<?php

namespace Fabrica\Http\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

//use Fabrica\Events\ModuleEvent;
use Fabrica\Events\IssueEvent;
use Fabrica\Http\Requests;
use Fabrica\Http\Api\Controller;

use DB;
use Sentinel;
use Fabrica\Project\Provider;
use Fabrica\Project\Eloquent\Module;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('privilege:manage_project', [ 'except' => [ 'index' ] ]);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($project_key)
    {
        $modules = Module::whereRaw([ 'project_key' => $project_key ])->orderBy('sn', 'asc')->get();
        foreach ($modules as $module)
        {
            $module->is_used = $this->isFieldUsedByIssue($project_key, 'module', $module->toArray()); 
        }
        $users = Provider::getUserList($project_key);
        return response()->json([ 'ecode' => 0, 'data' => $modules, 'options' => [ 'users' => $users ] ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_key)
    {
        $name = $request->input('name');
        if (!$name) {
            throw new \UnexpectedValueException('the name can not be empty.', -11400);
        }

        if (Module::whereRaw([ 'name' => $name ])->exists()) {
            throw new \UnexpectedValueException('module name cannot be repeated', -11401);
        }

        $principal = [];
        $principal_id = $request->input('principal');
        if (isset($principal_id)) {
            $user_info = Sentinel::findById($principal_id);
            $principal = [ 'id' => $principal_id, 'name' => $user_info->first_name ];
        }

        $creator = [ 'id' => $this->user->id, 'name' => $this->user->first_name, 'email' => $this->user->email ];
        $module = Module::create(
            [ 
            'project_key' => $project_key, 
            'principal' => $principal, 
            'sn' => time(), 
            'creator' => $creator ] + $request->all()
        );

        // trigger event of version added
        //Event::fire(new ModuleEvent($project_key, $creator, [ 'event_key' => 'create_module', 'data' => $module->name ]));

        return response()->json([ 'ecode' => 0, 'data' => $module ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($project_key, $id)
    {
        $module = Module::find($id);
        $module->is_used = $this->isFieldUsedByIssue($project_key, 'module', $module->toArray());

        return response()->json(['ecode' => 0, 'data' => $module]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_key, $id)
    {
        $module = Module::find($id);
        if (!$module || $module->project_key != $project_key) {
            throw new \UnexpectedValueException('the module does not exist or is not in the project.', -11402);
        }

        $name = $request->input('name');
        if (isset($name)) {
            if (!$name) {
                throw new \UnexpectedValueException('the name can not be empty.', -11400);
            }
            if ($module->name !== $name && Module::whereRaw([ 'name' => $name ])->exists()) {
                throw new \UnexpectedValueException('module name cannot be repeated', -11401);
            }
        }

        $principal_id = $request->input('principal');
        if (isset($principal_id)) {
            if ($principal_id) {
                $user_info = Sentinel::findById($principal_id);
                $principal = [ 'id' => $principal_id, 'name' => $user_info->first_name ];
            }
            else
            {
                $principal = [];
            }
        }
        else
        {
            $principal = isset($module['principal']) ? $module['principal'] : [];
        }

        $module->fill([ 'principal' => $principal ] + array_except($request->all(), [ 'creator', 'project_key' ]))->save();

        // trigger event of module edited
        //$cur_user = [ 'id' => $this->user->id, 'name' => $this->user->first_name, 'email' => $this->user->email ];
        //Event::fire(new ModuleEvent($project_key, $cur_user, [ 'event_key' => 'edit_module', 'data' => $request->all() ]));

        return response()->json([ 'ecode' => 0, 'data' => Module::find($id) ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $project_key, $id)
    {
        $module = Module::find($id);
        if (!$module || $project_key != $module->project_key) {
            throw new \UnexpectedValueException('the module does not exist or is not in the project.', -11402);
        }

        $operate_flg = $request->input('operate_flg');
        if (!isset($operate_flg) || $operate_flg === '0') {
            $is_used = $this->isFieldUsedByIssue($project_key, 'module', $module->toArray());
            if ($is_used) {
                throw new \UnexpectedValueException('the module has been used by some issues.', -11403);
            }
        }
        else if ($operate_flg === '1') {
            $swap_module = $request->input('swap_module');
            if (!isset($swap_module) || !$swap_module) {
                throw new \UnexpectedValueException('the swap module cannot be empty.', -11405);
            }

            $smodule = Module::find($swap_module);
            if (!$smodule || $project_key != $smodule->project_key) {
                throw new \UnexpectedValueException('the swap module does not exist or is not in the project.', -11406);
            }

            $this->updIssueModule($project_key, $id, $swap_module);
        }
        else if ($operate_flg === '2') {
            $this->updIssueModule($project_key, $id, '');
        }
        else
        {
            throw new \UnexpectedValueException('the operation has error.', -11404);
        }

        Module::destroy($id);

        // trigger event of module deleted 
        //$cur_user = [ 'id' => $this->user->id, 'name' => $this->user->first_name, 'email' => $this->user->email ];
        //Event::fire(new ModuleEvent($project_key, $cur_user, [ 'event_key' => 'del_module', 'data' => $module->name ]));

        if ($operate_flg === '1') {
            return $this->show($project_key, $request->input('swap_module'));
        }
        else
        {
            return response()->json(['ecode' => 0, 'data' => [ 'id' => $id ]]);
        }
    }

    /**
     * update the issues module
     *
     * @param array  $issues
     * @param string $source
     * @param string $dest
     *
     * @return void
     */
    public function updIssueModule($project_key, $source, $dest): void
    {
        $issues = DB::collection('issue_' . $project_key)
            ->where('module', $source)
            ->where('del_flg', '<>', 1)
            ->get();

        foreach ($issues as $issue)
        {
            $updValues = [];

            if (is_string($issue['module'])) {
                if ($issue['module'] === $source) {
                    $updValues['module'] = $dest;
                }
            } 
            else if (is_array($issue['module'])) {
                $updValues['module'] = array_values(array_filter(array_unique(str_replace($source, $dest, $issue['module']))));
            }

            if ($updValues) {
                $updValues['modifier'] = [ 'id' => $this->user->id, 'name' => $this->user->first_name, 'email' => $this->user->email ];
                $updValues['updated_at'] = time();

                $issue_id = $issue['_id']->__toString();

                DB::collection('issue_' . $project_key)->where('_id', $issue_id)->update($updValues);
                // add to histroy table
                $snap_id = Provider::snap2His($project_key, $issue_id, [], [ 'module' ]);
                // trigger event of issue edited
                Event::fire(new IssueEvent($project_key, $issue_id, $updValues['modifier'], [ 'event_key' => 'edit_issue', 'snap_id' => $snap_id ]));
            }
        }
    }

    /**
     * update sort etc..
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function handle(Request $request, $project_key)
    {
        // set module sort.
        $sequence_modules = $request->input('sequence') ?: [];
        if ($sequence_modules) {
            $i = 1;
            foreach ($sequence_modules as $module_id)
            {
                $module = Module::find($module_id);
                if (!$module || $module->project_key != $project_key) {
                    continue;
                }
                $module->sn = $i++;
                $module->save();
            }
        }

        return response()->json(['ecode' => 0, 'data' => [ 'sequence' => $sequence_modules ] ]);
    }
}
