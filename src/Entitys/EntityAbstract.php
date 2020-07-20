<?php
namespace Fabrica\Entitys;

use Support\Contracts\Support\Arrayable;
use Support\Contracts\Support\ArrayableTrait;
use Muleta\Traits\Debugger\HasErrors;
use Muleta\Traits\Coder\GetSetTrait;
use Support\Contracts\Output\OutputableTrait;
use Illuminate\Database\Eloquent\Collection;
use Support\Repositories\EntityRepository;

abstract class EntityAbstract implements Arrayable
{
    use ArrayableTrait;

    public $code;
    
    public function __construct($code = '')
    {
        $this->code = $code;
    }
    
    public static function make($code = '')
    {
        return new static(
            $code
        );
    }
    
}