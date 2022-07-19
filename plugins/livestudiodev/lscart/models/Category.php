<?php namespace LivestudioDev\Lscart\Models;

use Model;
use LivestudioDev\Lscart\Models\Product;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;
    use \October\Rain\Database\Traits\Sluggable;

    protected $slugs = ['slug' => 'name'];
    CONST PARENT_ID = 'parent_id';
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_categories';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasMany = [
        'products'  =>  [Product::class, 'key' => 'category_id', 'otherKey' => 'id', 'scope' => 'isActive']
    ];

    public $attachOne = [
        'image' => 'System\Models\File'
    ];
}
