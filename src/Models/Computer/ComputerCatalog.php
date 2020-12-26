<?php
/**
 * Armazena a Localização e Hierarquia de Pastas e Arquivos
 */

namespace Fabrica\Models\Computer;

use Fabrica\Tools\Ssh;
use Pedreiro\Models\Base;

class ComputerCatalog extends Base
{
    public static $apresentationName = 'Servidores';

    protected $organizationPerspective = true;

    protected $table = 'computer_catalogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'location',
        'computer_id',
    ];


    protected $mappingProperties = array(

        'customer_id' => [
            'type' => 'integer',
            "analyzer" => "standard",
        ],
    );

    
    public $formFields = [
        [
            'name' => 'name',
            'label' => 'name',
            'type' => 'text'
        ],
        [
            'name' => 'url',
            'label' => 'url',
            'type' => 'text'
        ],
        [
            'name' => 'ip',
            'label' => 'url',
            'type' => 'text'
        ],
        [
            'name' => 'instance',
            'label' => 'url',
            'type' => 'text'
        ],
        [
            'name' => 'status',
            'label' => 'Status',
            'type' => 'checkbox'
        ],
        // [
        //     'name' => 'status',
        //     'label' => 'Enter your content here',
        //     'type' => 'textarea'
        // ],
        // ['name' => 'publish_on', 'label' => 'Publish Date', 'type' => 'date'],
        // ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'relationship' => 'category'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'name',
        'url',
        'ip',
        'instance',
        'user',
        'status'
    ];

    public $validationRules = [
        'name'       => 'required|max:255',
        'url'        => 'required|max:100',
        'status'        => 'boolean',
        // 'publish_on'  => 'date',
        // 'published'   => 'boolean',
        // 'category_id' => 'required|int',
    ];

    public $validationMessages = [
        'name.required' => "Nome é obrigatório."
    ];

    public $validationAttributes = [
        'name' => 'Name'
    ];
    
    public function getName()
    {
        return $this->instance;
    }

    public function getApresentationName()
    {
        if (!$name = $this->getName()) {
            return 'Vazio';
        }
        return $name;
    }

    public function connect()
    {
        return new Ssh($this);
    }


    public function user()
    {
        return $this->belongsTo(\Illuminate\Support\Facades\Config::get('sitec.core.models.user', \App\Models\User::class), 'user_id', 'id');
    }
}
