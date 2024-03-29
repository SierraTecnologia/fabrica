<?php
namespace Fabrica\Acl;

use Fabrica\Acl\Eloquent\Role;
use Fabrica\Acl\Eloquent\RolePermissions;
use Fabrica\Acl\Eloquent\Roleactor;
use Fabrica\Acl\Eloquent\Group;
use Fabrica\Acl\Permissions;

class Acl
{

    /**
     * get role list in the project.
     *
     * @var    string $project_key
     * @return collection
     */
    public static function getRoles($project_key)
    {
        return Roleactor::where('project_key', $project_key)->orwhere('project_key', '$_sys_$')->get();
    }

    /**
     * get role list in the project by userid.
     *
     * @var string $project_key
     * @var string $user_id
     *
     * @return array
     *
     * @psalm-return list<mixed>
     */
    public static function getRolesByUid($project_key, $user_id): array
    {
        $role_ids = [];

        $groups = self::getBoundGroups($user_id);
        foreach ($groups as $group)
        {
            $role_actors = Roleactor::whereRaw([ 'group_ids' => $group['id'], 'project_key' => $project_key ])
                ->get([ 'role_id' ])
                ->toArray();
            foreach($role_actors as $actor)
            {
                $role_ids[] =  $actor['role_id'];
            }
        }

        $role_actors = Roleactor::whereRaw([ 'user_ids' => $user_id, 'project_key' => $project_key ])
            ->get(['role_id'])
            ->toArray();
        foreach($role_actors as $actor)
        {
            $role_ids[] =  $actor['role_id'];
        }

        return array_values(array_unique($role_ids));
    }

    /**
     * get user list who has the permission allow in the project.
     *
     * @var string permission
     * @var string project_key
     *
     * @return array
     *
     * @param string $permission
     */
    public static function getUserIdsByPermission(string $permission, string $project_key)
    {
        $role_ids = [];
        $rps = RolePermissions::whereRaw([ 'permissions' => $permission, 'project_key' => $project_key ])->get();
        foreach ($rps as $rp)
        {
            $role_ids[] = $rp->role_id;
        }

        $local_role_ids = [];
        $local_rps = RolePermissions::whereRaw([ 'project_key' => $project_key ])->get();
        foreach ($local_rps as $rp)
        {
            $local_role_ids[] = $rp->role_id;
        }

        $rps = RolePermissions::whereRaw([ 'permissions' => $permission, 'project_key' => '$_sys_$', 'role_id' => [ '$nin' => $local_role_ids ] ])->get();
        foreach ($rps as $rp)
        {
            $role_ids[] = $rp->role_id;
        }

        $user_ids = [];
        $group_ids = [];
        $role_actors = Roleactor::whereRaw([ 'project_key' => $project_key, 'role_id' => [ '$in' => $role_ids ] ])->get();
        foreach ($role_actors as $actor)
        {
            if (isset($actor->user_ids) && $actor->user_ids) {
                $user_ids = array_merge($user_ids, $actor->user_ids);
            }
            if (isset($actor->group_ids) && $actor->group_ids) {
                $group_ids = array_merge($group_ids, $actor->group_ids);
            }
        }

        foreach ($group_ids as $group_id)
        {
            $group = Group::find($group_id);
            if ($group && isset($group->users) && $group->users) {
                $user_ids = array_merge($user_ids, $group->users);
            }
        }

        return array_values(array_unique($user_ids));
    }

    /**
     * check if user has permission allow.
     *
     * @var    string $user_id
     * @var    string $permission
     * @var    string $project_key
     * @return boolean
     */
    public static function isAllowed($user_id, $permission, $project_key)
    {
        $permissions = self::getPermissions($user_id, $project_key);
        if ($permission == 'view_project') {
            return !!$permissions;
        }
        else
        {
            return in_array($permission, $permissions);
        }
    }

    /**
     * get groups user is bound 
     *
     * @var    string $user_id
     * @return array 
     */
    public static function getBoundGroups($user_id)
    {
        $groups = [];
        $group_list = Group::where([ 'users' => $user_id ])->get(); 
        foreach ($group_list as $group) {
            $groups[] = [ 'id' => $group->id, 'name' => $group->name ];
        }
        return $groups;
    }

    /**
     * get user's all permissions in the project.
     *
     * @var    string $user_id
     * @var    string $project_key
     * @return array
     */
    public static function getPermissions($user_id, $project_key)
    {
        $role_ids = [];
        $role_actors = Roleactor::whereRaw([ 'user_ids' => $user_id, 'project_key' => $project_key ])
            ->get([ 'role_id' ])
            ->toArray();
        foreach($role_actors as $actor)
        {
            $role_ids[] =  $actor['role_id'];
        }

        $groups = self::getBoundGroups($user_id);
        foreach ($groups as $group) 
        {
            $role_actors = Roleactor::whereRaw([ 'group_ids' => $group['id'], 'project_key' => $project_key ])
                ->get([ 'role_id' ])
                ->toArray();
            foreach($role_actors as $actor)
            {
                $role_ids[] =  $actor['role_id'];
            }
        }

        $all_permissions = [];

        foreach ($role_ids as $role_id)
        {
            $rp = RolePermissions::where('project_key', $project_key)
                ->where('role_id', $role_id)
                ->first();

            if (!$rp) {
                $rp = RolePermissions::where('project_key', '$_sys_$')
                    ->where('role_id', $role_id)
                    ->first();
            }

            if ($rp) {
                $all_permissions = array_merge($all_permissions, $rp->permissions ?: []);
            }
        }
        return array_values(array_unique($all_permissions));
    }

    /**
     * get permission list.
     *
     * @return array
     *
     * @psalm-return array{0: mixed, 1: mixed, 2: mixed, 3: mixed, 4: mixed, 5: mixed, 6: mixed, 7: mixed, 8: mixed, 9: mixed, 10: mixed, 11: mixed, 12: mixed, 13: mixed, 14: mixed, 15: mixed, 16: mixed, 17: mixed, 18: mixed, 19: mixed, 20: mixed, 21: mixed, 22: mixed, 23: mixed, 24: mixed, 25: mixed, 26: mixed, 27: mixed}
     */
    public static function getAllPermissions(): array
    {
        return Permissions::all();
    }
}
