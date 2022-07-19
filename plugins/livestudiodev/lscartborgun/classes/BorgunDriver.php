<?php namespace LivestudioDev\Lscartborgun\Classes;

use GuzzleHttp\Client;
use LivestudioDev\Lscart\Models\Order;
use LivestudioDev\Lscartborgun\Models\Settings;

class BorgunDriver {
	public $url;
	public $self_url;
	private $settings;
	
	public function __construct() {
		$b_settings = Settings::instance();
		$live = $b_settings->environment && $b_settings->environment == 1 ? true : false;
		$this->self_url = \Url::to('/');

		if($live){
			$this->url = "https://securepay.borgun.is/securepay/default.aspx";
			$this->settings = [
				'merchantId' => $b_settings->merchantId,
				'gatewayId' => $b_settings->gatewayId,
				'secret' => $b_settings->secret
			];
		}else {
			$this->url = "https://test.borgun.is/SecurePay/default.aspx";
			$this->settings = [
				'merchantId' => 9275444,
				'gatewayId' => 16,
				'secret' => 99887766
			];
		}
	}

	public static function getGates()
	{
		return ["Borgun" => "Borgun"];
	}

	public function getCheckHash($data)
	{
		$data = [
			$this->settings["merchantId"],
			$this->self_url."/borgunsuccess",
			$this->self_url."/borgunsuccess",
			$data["orderid"],//"ORDER1230001",
			$data["amount"],//"800",
			$data["currency"]//"HUF"
		];

		return $this->generateHMAC($data);
	}

	public function validateOrder($borgundata)
	{
		$order = Order::where('order_number',$borgundata["orderid"])->first();

		$data = [];
		$data["orderid"] = $order->order_number;
		$data["amount"] = $order->history["absolutePriceBrutto"];
		$data["currency"] = "HUF";
		$hash = $this->getOrderHash($data);

		if($hash == $borgundata["orderhash"]){
			return true;
		}else {
			return false;
		}
	}

	public function getOrderHash($data)
	{
		$data = [
			$data["orderid"],//"ORDER1230001",
			$data["amount"],//"800",
			$data["currency"]//"HUF"
		];

		return $this->generateHMAC($data);
	}

	public function generateHMAC($data)
	{
		$msg = utf8_encode(implode('|',$data));
		
		return hash_hmac('sha256', $msg, $this->settings["secret"]);
	}

	public function getPayForm($order)
	{
		$fields = [
			'merchantid' => $this->settings['merchantId'],
			'paymentgatewayid' => $this->settings['gatewayId'],					
			'language' => 'HU',			
			'returnurlsuccess' => $this->self_url.'/borgunsuccess',
			'returnurlcancel' => $this->self_url.'/borguncancel',
			'returnurlerror' => $this->self_url.'/borgunerror',
			'pagetype' => 0,
			'skipreceiptpage' => 0
		];

		$fields['orderid'] = $order->order_number;
		$fields['currency'] = "HUF";
		$fields['amount'] = $order->getAbsolutePrice();
		$fields['buyername'] = $order->name;
		$fields['buyeremail'] = $order->email;
		
		$data = [];
		$data["currency"] = "HUF";
		$data["amount"] = $order->getAbsolutePrice();
		$data["orderid"] = $order->order_number;

		$fields["checkhash"] = $this->getCheckHash($data);

		$coupon = $order->coupon;
		$user = \Auth::user();
		if($user){
			$discounts = $user->discounts;
		}else {
			$discounts = null;
		}


		$lastkey = 0;
		foreach ($order->items as $key => $item) {
			$u_price = $item->product->getItemPrice($item->variant_id, null, true, $coupon, $discounts);

			$fields["itemdescription_".$key] = $item->product->name;
			$fields["itemcount_".$key] = $item->quantity;
			$fields["itemunitamount_".$key] = $u_price;
			$fields["itemamount_".$key] = ($item->quantity * $u_price);
			$lastkey = $key;
		}

		$lastkey++;
		if($order->getShippingCost() > 0){
			$fields["itemdescription_".$lastkey] = "Szálítási költség";
			$fields["itemcount_".$lastkey] = 1;
			$fields["itemunitamount_".$lastkey] = $order->getShippingCost();
			$fields["itemamount_".$lastkey] = $order->getShippingCost();
		}

		// $fields = [
		// 	'merchantid' => $this->settings['merchantId'],
		// 	'paymentgatewayid' => $this->settings['gatewayId'],
		// 	'checkhash' => $this->getCheckHash(), // 'e9767a8af654d779062d23c921c90e363c9f70b566d905f7aff32f43ef014eda',
		// 	'orderid' => 'ORDER1230001',
		// 	'currency' => 'ISK',
		// 	'language' => 'HU',
		// 	'retunurlsuccess' => 'http://somedomain.is/ReturnPageSuccess?order_id=ORDER1230001',
		// 	'returnurlerror' => 'http://lsdemo.hu/exampleshop/borgunerror',
		// 	'itemdescription_0' => 'Termek leiras',
		// 	'itemcount_0' => 1,
		// 	'itemunitamount_0' => 100.00,
		// 	'itemamount_0' => 100.00
		// ];

		return $fields;
	}
}