<?php namespace Livestudiodev\Bakonyiklima\Models;

use Model;

/**
 * Model
 */
class Offer extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_bakonyiklima_offers';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
