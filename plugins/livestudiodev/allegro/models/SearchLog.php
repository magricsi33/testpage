<?php namespace LivestudioDev\Allegro\Models;

use Model;

/**
 * Model
 */
class SearchLog extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_allegro_searches';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'product' => 'LivestudioDev\Lscart\Models\Product'
    ];
}
