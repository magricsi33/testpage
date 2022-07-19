<?php namespace LivestudioDev\Lscart\Models;

use Model;

/**
 * Model
 */
class PaymentMethod extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $belongsTo = [
        'vatkey' => 'LivestudioDev\Lscart\Models\VatKey'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_payment_methods';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getPaymentGateOptions()
    {
        $modes = [];

        if(class_exists("LivestudioDev\Lscartborgun\Classes\BorgunDriver")){
            $modes = array_merge($modes,\LivestudioDev\Lscartborgun\Classes\BorgunDriver::getGates());
        }

        if(class_exists("LivestudioDev\Lscartbarion\Classes\BarionDriver")){
            $modes = array_merge($modes,\LivestudioDev\Lscartbarion\Classes\BarionDriver::getGates());
        }

        return $modes;
    }
}
