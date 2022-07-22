<?php namespace LivestudioDev\Lscart\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use LivestudioDev\Lscart\Classes\ShipExportDriver;
use LivestudioDev\Lscart\Models\Order;
use LivestudioDev\Lscart\Models\Product;
use Illuminate\Support\Facades\Input;
use LivestudioDev\Lscart\Models\Cart;
use LivestudioDev\Lscart\Models\CartItem;
use Renatio\DynamicPDF\Classes\PDF;

class Orders extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        $this->addCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css','5.14.0');
        $this->addCss('/plugins/livestudiodev/lscart/assets/css/orderItems.css','1.0.0');
        $this->addCss('/plugins/livestudiodev/lscart/assets/css/orderList.css','1.0.0');

        parent::__construct();
        BackendMenu::setContext('LivestudioDev.Lscart', 'main-menu-item2');
    }

    public function pdf($id)
    {
        $data["order"] = Order::where('id',$id)->first()->toArray();
        return PDF::loadTemplate('livestudiodev.allegro::pdf.order', $data)->download($data["order"]["order_number"].'_'.$data["order"]["name"].'.pdf');
    }

    public function onShippingExport()
    {
        $this->vars["checked"] = \Input::get('checked');        

        return $this->makePartial('popup');
    }

    public function onMultiAction()
    {
        $this->vars["checked"] = \Input::get('checked');        

        return $this->makePartial('action_popup');
    }



    public function onDoMultiAction()
    {
        $status = \Input::get('radio');
        $ids = \Input::get('ids');

        foreach ($ids as $orderid) {
            $order = Order::find($orderid);
            $order->status = $status;
            $order->save();
        }
        \Flash::success('Sikeresen módosítottuk a státuszokat.');
        return \Redirect::refresh();
    }

    public function onExportShipping()
    {
        $scheme = \Input::get('radio');
        $ids = \Input::get('ids');

        return \Redirect::to(\Backend::url('livestudiodev/lscart/orders/oxport'))->with(['scheme' => $scheme, 'ids' => $ids]);
    }

    public function oxport()
    {
        $scheme = \Session::get('scheme');
        $ids = \Session::get('ids');

        $driver = new ShipExportDriver();
        $response = $driver->downloadOrderExport($scheme,$ids);
        return $response;
    }

    public function listInjectRowClass($record, $definition = null)
    {
        if ($record->status == 3) {
            return 'strike';
        }

        if ($record->status == 2) {
            return "bg-success";
        }

        if ($record->status == 0) {
            return 'disabled';
        }
    }
}
