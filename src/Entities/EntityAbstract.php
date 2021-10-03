<?php
namespace Fabrica\Entities;

use Muleta\Contracts\Support\Arrayable;
use Muleta\Contracts\Support\ArrayableTrait;
use Muleta\Traits\Debugger\HasErrors;
use Muleta\Traits\Coder\GetSetTrait;
use Muleta\Contracts\Output\OutputableTrait;
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
    
    /**
     * @return static
     */
    public static function make($code = ''): self
    {
        return new static(
            $code
        );
    }
    
}