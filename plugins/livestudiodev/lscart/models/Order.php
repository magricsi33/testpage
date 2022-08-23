<?php namespace LivestudioDev\Lscart\Models;

use Model;
use LivestudioDev\Lscart\Models\Settings;
use LivestudioDev\Lscart\Models\OrderItem;
use LivestudioDev\Lscart\Models\Product;
use Event;
use DB;
use stdClass;

/**
 * Model
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscart_orders';
    public $jsonable = ['address','billing_address','infos','history'];

    public $implement = [
        'LivestudioDev.Lscart.Behaviors.Priceable'
    ];

    public $hasOne = [
        'cart' => 'LivestudioDev\Lscart\Models\Cart'
    ];

    public $hasMany = [
        'items' =>  'LivestudioDev\Lscart\Models\OrderItem'
    ];

    public $belongsTo = [
        'coupon' => 'LivestudioDev\Lscart\Models\Coupon',
        'shipping' => 'LivestudioDev\Lscart\Models\ShippingMethod',
        'payment' => 'LivestudioDev\Lscart\Models\PaymentMethod',
        'currency' => 'LivestudioDev\Lscart\Models\Currency'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($order) {
            $order->items()->delete();
        });
    }

    public function afterUpdate()
    {
        // if($this->status == 1)
        // {
        //     $response = $driver->makeInvoiceFromOrder($this);
        //     if($response instanceof Exception){
        //         \Log::error($response);
        //         \Flash::success('A rendelés(ek) feldolgozása hibába ütközött.');
        //     }

        //     \Flash::success('A rendelés(ek) sikeresen feldolgozásra került(ek).');
        // }

        Event::fire('lscart.order.afterupdate', $this->id);
    }

    public function getAbsolutePriceAttribute()
    {
        return number_format($this->getAbsolutePrice())." ".Settings::instance()->currency->code;
    }

    public function getOrderStatusAttribute()
    {
        $st = $this->status;
        switch ($st) {
            case 0:
                return "Beérkezett";
            case 1:
                return "Feldolgozott";
            case 2:
                return "Kész";
            case 3:
                return "Elutasítva";
            case 4:
                return "Folyamatban";
            case 5:
                return "Beérkezett és fizetve";
            case 6:
                return "Véleményezés";
        }
    }

    public function getNameOptions($scopes = null)
    {
        $names = Order::all()->lists('name','name');

        return $names;
    }

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
