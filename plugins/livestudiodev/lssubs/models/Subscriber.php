<?php namespace LivestudioDev\LSSubs\Models;

use Model;

/**
 * Model
 */
class Subscriber extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lssubs_subscribers';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsToMany = [
        'themes' => [
            'LivestudioDev\LSSubs\Models\Theme',
            'table' => 'livestudiodev_lssubs_subscribers_themes',
            'key' => 'subscriber_id',
            'otherKey' => 'theme_id'
        ]
    ];
}
