<?php

namespace Fabrica\System\Eloquent;

use Jenssegers\Mongodb\Eloquent\Model;

class CalendarSingular extends Model
{
    //
    protected $table = 'calendar_singular';

    protected $fillable = array(
        'date',
        'year',
        'type'
    );
}
