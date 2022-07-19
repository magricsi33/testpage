<?php namespace LivestudioDev\Lscartborgun\Controllers;

use Backend\Classes\Controller;
use LivestudioDev\Lscartborgun\Classes\BorgunDriver;
use LivestudioDev\Lscart\Models\Order;

class BorgunTest extends Controller
{
    public function index()
    {
      
      $order = Order::first();
      $driver = new BorgunDriver();
      $formdata = $driver->getPayForm($order);
      
      // $contents = $response->getBody()->getContents();
      // dd($driver->getCheckHash());
      $this->vars["formdata"] = $formdata;
    }
}