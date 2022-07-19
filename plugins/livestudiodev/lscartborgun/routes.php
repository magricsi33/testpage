<?php

use LivestudioDev\Lscartborgun\Classes\BorgunDriver;
use LivestudioDev\Lscart\Models\Order;

Route::post('borgunerror', function() {
	dd(\Input::all());
});

Route::post('borgunsuccess', function() {
	
	if(\Input::all() == null) return \Redirect::to('/');

	$driver = new BorgunDriver();
	$valid = $driver->validateOrder(\Input::all());
	$order = Order::where('order_number',\Input::get('orderid'))->first();

	$order_number = $order->order_number;

	$url = \Url::to('/');
	if($valid){
		$order->status = 5;
		$order->save();
	}else {
		dd(\Input::all());
	}

	return \Redirect::to("{$url}/koszonjuk/{$order->id}");

	dd(\Input::all());
	// "status" => "OK"
	// "orderid" => "00000003"
	// "authorizationcode" => "123456"
	// "creditcardnumber" => "474152******0003"
	// "amount" => "766372.5"
	// "currency" => "HUF"
	// "orderhash" => "acc84fd9a3b4110fdaaa8f279b892fd508d2e9f1a9d78c848337c0d0052ea3d1"
	// "merchantid" => "9275444"
	// "buyername" => "Kováts Attila"
	// "buyeremail" => "lorexzer0@gmail.com"
	// "step" => "Confirmation"
});

Route::post('borguncancel', function() {
	$order = Order::where('order_number',\Input::get('orderid'))->first();
	$order->status = 3;
	$order->save();

	$url = \Url::to('/');
	return \Redirect::to("{$url}/koszonjuk/{$order->id}");
});

?>