<?php namespace LivestudioDev\Allegro\Models;

use Model;

/**
 * Model
 */
class Question extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_allegro_questions';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasOne = [
        'product' => ['LivestudioDev\Lscart\Models\Product', 'otherKey' => 'product_id', 'key' => 'id']
    ];
}
