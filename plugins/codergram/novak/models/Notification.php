<?php namespace Codergram\Novak\Models;

use Model;

/**
 * Model
 */
class Notification extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'codergram_novak_notifications';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        "owner" => ["Rainlab\User\Models\User", "key" => "user_id", "otherKey" => "id"],
    ];
}
