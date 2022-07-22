<?php

namespace LivestudioDev\Lscart\Components;

use LivestudioDev\Lscart\Models\Cart as CartModel;
use LivestudioDev\Lscart\Models\Product;
use LivestudioDev\Lscart\Models\Category;
use LivestudioDev\Lscart\Models\ShipDetail;
use LivestudioDev\Lscart\Models\CartItem;
use LivestudioDev\Lscart\Models\Coupon;
use LivestudioDev\Lscart\Models\Currency;
use LivestudioDev\Lscart\Models\ProductVariant;
use LivestudioDev\Lscart\Models\ShippingMethod;
use LivestudioDev\Lscart\Models\Settings;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Cms\Classes\ComponentBase;
use Exception;
use Event;

class Cart extends ComponentBase
{

	public $cart;

    // INIT FUNCTIONS

	public function componentDetails()
	{
		return [
			'name'			=> 'Kosár',
			'description'	=>	'Kosár leírás'
		];
	}

	public function defineProperties()
	{
		return [];
	}

	public function init()
	{
		$this->cart = CartModel::fromSession();
	}

    // GLOBAL VARIABLES
	
	/**
	 * Returns the available currencies
	 *
	 * @return Collection
	 */
	public function currencies()
	{
		return Currency::all();
	}

	/**
	 * Returns the available shipping methods
	 *
	 * @return Collection
	 */
	public function shippingMethods()
	{
		return ShippingMethod::where('active',1)->get();
	}
	
	/**
	 * Returns the available payment methods
	 *
	 * @return Collection
	 */
	public function paymentMethods()
	{
		return PaymentMethod::all();
	}

	/**
	 * Returns the available payment methods
	 *
	 * @return int
	 */
	public function currencyId()
	{
		return $this->cart->currency ? $this->cart->currency->id : null;
	}
    
    /**
     * Returns the absolute brutto price with shipping and payment costs
     *
     * @return int
     */
    public function absolutePrice($currency = null)
    {
        return $this->cart->getAbsolutePrice($currency);
	}
		
	/**
	 * Returns the absolute netto price with shipping and payment costs
	 *
	 * @return int
	 */
	public function absoluteNetto($currency = null)
	{
		return $this->cart->getAbsoluteNetto($currency);
	}
	
	/**
	 * Returns only the vat price
	 *
	 * @return int
	 */
	public function vatPrice($currency = null)
	{
		return $this->cart->getVatPrice($currency = null);
	}
    
    /**
     * Returns the shipping cost of the selected shipping method
     *
     * @return int
     */
    public function shippingCost($netto = false, $currency = null)
    {
        return $this->cart->getShippingCost();
    }
    
    /**
     * Returns the payment cost of the selected payment method
     *
     * @return int
     */
    public function paymentCost($netto = false, $currency = null)
    {
        return $this->cart->getPaymentCost();
    }
    
    /**
     * Returns the total quantity of the cart items
     *
     * @return int
     */
    public function totalQuantity()
    {
        return $this->cart->getTotalQuantity();
    }
    
    /**
     * Returns the total brutto price without shipping and payment costs
     *
     * @return int
     */
    public function totalBrutto($coupon = true, $discount = true, $currency = null)
    {
        return $this->cart->getTotalPriceBrutto($coupon,$discount,$currency);
    }
    
    /**
     * Returns the total netto price without shipping and payment costs
     *
     * @return int
     */
    public function totalNetto($coupon = true, $discount = true, $currency = null)
    {
        return $this->cart->getTotalPrice($coupon,$discount,$currency);
    }

    // AJAX FUNCTIONS

    public function onSetCartShipping()
	{
		$this->cart->shipping_id = post('shipping_mode');
		$this->cart->save();

		return [
			'#checkout' => $this->renderPartial($this->alias . '::checkout', ['cart.cart' => $this->cart]),
			'#payments' => $this->renderPartial($this->alias . '::payments', ['cart.cart' => $this->cart]),
			'#shipping_methods' => $this->renderPartial($this->alias . '::shipping_methods', ['cart.cart' => $this->cart]),
		];
	}
	
	public function onSetCartCurrency()
	{
		$oldcurr = $this->cart->currency->id;
		$this->cart->currency_id = post('currency_id');
		$this->cart->save();

		Event::fire('livestudiodev.lscart.modified_currency', ['oldcurr' => $oldcurr, 'newcurr' => post('currency_id')]);

		// return $this->refreshCart();
		return \Redirect::refresh();
	}

	public function onSetCartPayment()
	{
		$this->cart->payment_id = post('payment_mode');
		$this->cart->save();

		return $this->refreshCart();
	}

	public function onRemoveUserShipDetail()
	{
		$user = \Auth::user();

		$sd = ShipDetail::find(post('id'));
		if($sd->active) {
			foreach($user->shipaddresses as $adr){
				$adr->active = 1;
				$adr->save();
				break;
			}
		}
		$sd->delete();

		$user->reloadRelations('shipaddresses');

		return [
			'#shippingAddresses' => $this->renderPartial('profile/shipping', ['user' => $user]),
		];
	}

	public function onSetUserShipDetailActive()
	{
		$user = \Auth::user();

		if(post('active_address')){
			foreach($user->shipaddresses as $adr){
				if($adr->id == post('active_address')){
					$adr->active = 1;
				}else {
					$adr->active = 0;
				}
				$adr->save();
			}
		}

		return [
			'#addressData' => $this->renderPartial('profile/address', ['user' => $user]),
		];
	}

	public function onUserShipDetailMakeActive()
	{
		$user = \Auth::user();

		if(post('id')){
			foreach($user->shipaddresses as $adr){
				if($adr->id == post('id')){
					$adr->active = $adr->active == 1 ? 0 : 1;
				}else {
					$adr->active = 0;
				}
				$adr->save();
			}
		}else {
			$shipdetail->active = 0;
		}

		return [
			'#shippingAddresses' => $this->renderPartial('profile/shipping', ['user' => $user]),
		];
	}

	public function onAddUserShipDetail()
	{
		$user = \Auth::user();

		$address = [];
		$address["postcode"] = post('postcode');
		$address["address_name"] = post('address_name');
		$address["address_type"] = post('address_type');
		$address["city"] = post('city');
		$address["flat_number"] = post('flat_number');
		$address["floor"] = post('floor');
		$address["door_num"] = post('door_num');
		$address["phone"] = post('phone');

		$shipdetail = new ShipDetail();
		$shipdetail->address = $address;
		$shipdetail->name = post('name');
		$shipdetail->person_name = post('person_name');
		$shipdetail->user_id = $user->id;

		if(post('active')){
			$shipdetail->active = post('active');
			foreach($user->shipaddresses as $adr){
				$adr->active = 0;
				$adr->save();
			}
		}else {
			$shipdetail->active = 0;
		}

		$shipdetail->save();

		$user->reloadRelations('shipaddresses');

		return [
			'#shippingAddresses' => $this->renderPartial('profile/shipping', ['user' => $user]),
		];
	}

	public function onCheckout()
	{
		$order = $this->cart->convertToOrder();
		$user = \Auth::user();

		$b_address = [];
		$b_address["postcode"] = post('bill_postcode');
		$b_address["address_name"] = post('bill_address_name');
		$b_address["address_type"] = post('bill_address_type');
		$b_address["city"] = post('bill_city');
		$b_address["flat_number"] = post('bill_flat_number');
		$b_address["floor"] = post('bill_floor');
		$b_address["door_num"] = post('bill_door_num');
		$b_address["phone"] = post('phone');
		$b_address["tax_number"] = post('tax_number');

		$address = [];

		if (post('ship_bill_equal') == 1) {
			$address = $b_address;
		} else {
			$address["postcode"] = post('postcode');
			$address["address_name"] = post('address_name');
			$address["address_type"] = post('address_type');
			$address["city"] = post('city');
			$address["flat_number"] = post('flat_number');
			$address["floor"] = post('floor');
			$address["door_num"] = post('door_num');
			$address["phone"] = post('phone');
			$address["name"] = post('ship_name');
		}
		

		$order->address = $address;
		$order->billing_address = $b_address;
		$order->email = post('email');
		$order->name = post('bill_name');

		$infos = [];
		$infos["shipping_mode"] = post('shipping_mode');
		$infos["payment_mode"] = post('payment_mode');
		if (post('note')) {
			$infos["note"] = "A rendelést erre a napra szeretném kérni: " .post('note');
		} else {
			$infos["note"] = post('note');
		}
		

		$history = [];
		if ($order->coupon) {
			$save_coupon = $order->coupon->toArray();
			$history["coupon"] = $save_coupon;
		}

		if($user) {
			$history["discounts"] = $user->discounts->toArray();
		}

		$history["shippingCostBrutto"] = $order->getOnlyShippingCost();
		// $history["shippingCostNetto"] = $order->getOrderShippingCost(true);
		$history["paymentCostBrutto"] = $order->getOnlyPaymentCost();
		// $history["paymentCostNetto"] = $order->getOrderPaymentCost(true);

		$history["totalPriceBrutto"] = $order->getTotalPriceBrutto();
		$history["totalPrice"] = $order->getTotalPrice();
		$history["absolutePriceBrutto"] = $order->getAbsolutePrice();
		$history["absolutePrice"] = $order->getAbsoluteNetto();
		$history["shippingMode"] = $order->shipping->name;
		$history["paymentMode"] = $order->payment->name;

		$order->history = $history;

		$order->infos = $infos;
		if($user){
			$order->user_id = $user->id;
		}

		if ($order->save()) {
			$email = post('email');

			$vars = [
				"name" => $order->name,
				"order" => $order
			];

			\Flash::success("Rendelését megkaptuk, köszönjük!");
		} else {
			\Flash::error("A rendelés leadása közben hibába ütköztünk!");
		}

		return $order;
	}

	public function onAddCartItem()
	{
		$extras = [];
        $settings = Settings::instance();
		$variantid = post('variant_id');

		$item = new CartItem();
		$item->product = Product::find(post('product_id'));
		$item->quantity = post('quantity');

		$variant = ProductVariant::find(post('variant_id'));

		if($this->cart->hasProduct($item)){
			$gtItem = $this->cart->getItemByProduct(post('product_id'));
		}

		if(isset($gtItem)){
			$modifier = $gtItem->quantity;
			if($gtItem->variant){
				$variant->stock -= $modifier;
			}else {
				$item->product->stock -= $modifier;
			}
		}

		if(!$item->product->variantonly){
			if($variant && $variant->stock <= $item->quantity && $settings->useStock == true) {
				\Flash::warning("Ebből a termékből már csak " . $variant->stock . " db van");
				return $this->refreshCart();
			}

		}else {
			if($variant && $variant->stock <= $item->quantity && $settings->useStock == true) {
				\Flash::warning("Ebből a termékből már csak " . $variant->stock . " db van");
				return $this->refreshCart();
			}else if($item->product->stock <= $item->quantity && $settings->useStock == true) {
				\Flash::warning("Ebből a termékből már csak " . $item->product->stock . " db van");
				return $this->refreshCart();
			}
		}

		if($variantid){
			$item->variant = ProductVariant::find(post('variant_id'));
		}
		$item->cart_id = $this->cart->id;
		
		if ($this->cart->hasProduct($item)) {
			$this->cart->addQuantity($item);
		} else {
			$this->cart->add($item);
		}
		
		\Flash::success("Termék sikeresen kosárba téve.");

		return $this->refreshCart();
	}

	public function onModifyItemVariant()
	{
		$id = post('id');
		$variantid = post('variant_id');
		$item = CartItem::find($id);
		if($this->cart->hasItem($item)){
			$this->cart->modifyItemVariant($item,$variantid);
		}

		return $this->refreshCart();
	}

	public function onModifyItemQuantity()
	{
		$id = post('id');
		$action = post('action');
		$quantity = post('quantity');
		$item = CartItem::find($id);

		if ($this->cart->hasItem($item)) {
			if ($action == 'add') {
				$this->cart->addItemQuantity($item);
			} else if ($action == 'remove') {
				$this->cart->removeItemQuantity($item);
			} else {
				$this->cart->modifyItemQuantity($item,$quantity);
			}
		}

		return $this->refreshCart();
	}

	public function onRemoveCartItem()
	{
		$id = post('id');
		$item = CartItem::find($id);

		if ($this->cart->hasItem($item)) {
			$this->cart->remove($item);
		} else {
			return;
		}

		return $this->refreshCart();
	}

	public function onCartClear()
	{
		try {
			$this->cart->clear();
		} catch (Exception $e) {
			dd($e . " HIBA ");
		}

		return $this->refreshCart();
	}

	public function onAddCoupon()
	{
		$code = post('code');

		if($code == "") {
			return [
				"error" => "Hibás kupon!"
			];
		}

		$user = \Auth::user();
		$coupon = Coupon::where('code',$code)->first();
		if($coupon){
			if($this->cart->canApplyCoupon($coupon,$user)){
				$this->cart->addCoupon($coupon);
			}else {
				return [
					"error" => "Nem jogosult a használatra!"
				];
			}
		}else {
			return
			[
				"error" => "Hibás kupon!"
			];
		}

		return $this->refreshCart();
	}

	public function onRemoveCoupon()
	{
		if($this->cart->coupon){
			$this->cart->removeCoupon($this->cart->coupon);
		}

		return $this->refreshCart();
    }

    // UTILITY FUNCTIONS

	protected function refreshCart(): array
	{
		$user = \Auth::user();
		$this->cart->load('coupon');

		return [
			'#counter' => $this->renderPartial($this->alias . '::counter', ['cart.cart' => $this->cart]),
			'#cartCounter2' => $this->renderPartial($this->alias . '::counter', ['cart.cart' => $this->cart]),
			'#cart' => $this->renderPartial($this->alias . '::default', ['cart.cart' => $this->cart]),
			'#cartitems' => $this->renderPartial($this->alias . '::cartitems', ['cart.cart' => $this->cart, 'user' => $user]),
			'#checkout' => $this->renderPartial($this->alias . '::checkout', ['cart.cart' => $this->cart]),
			'#coupon' => $this->renderPartial($this->alias . '::coupon', ['cart.cart' => $this->cart]),
			'#payments' => $this->renderPartial($this->alias . '::payments', ['cart.cart' => $this->cart]),
			'#preview' => $this->renderPartial($this->alias . '::preview', ['cart.cart' => $this->cart]),
		];
	}
}
