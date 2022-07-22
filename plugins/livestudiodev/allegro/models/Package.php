<?php namespace LivestudioDev\Allegro\Models;

use Model;

/**
 * Model
 */
class Package extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_allegro_packages';

    public $jsonable = ['tables'];

    public $slugs = ['slug' => 'name'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasOne = [
        'product' => 'LivestudioDev\Lscart\Models\Product'
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];
}
