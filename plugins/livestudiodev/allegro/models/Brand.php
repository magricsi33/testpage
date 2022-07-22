<?php namespace LivestudioDev\Allegro\Models;

use Model;

/**
 * Model
 */
class Brand extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_allegro_brands';

    protected $slugs = [
        'slug' => 'name'
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];

    public $hasMany = [
        'products' => ['LivestudioDev\Lscart\Models\Product', 'key' => 'brand_id']
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
