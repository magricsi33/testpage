<?php namespace LivestudioDev\Allegro\Models;

use Model;

/**
 * Model
 */
class UsageType extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $slugs = [
        'slug' => 'name'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_allegro_usage_types';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
