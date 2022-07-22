<?php namespace LivestudioDev\Allegro\Models;

use Model;

/**
 * Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_allegro_tags';

    public $belongsToMany = [
        'tags' => ['LivestudioDev\Lscart\Models\Product','table' => 'livestudiodev_allegro_tags_to_products','key' => 'tag_id','otherKey' => 'product_id']
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
