<?php namespace LivestudioDev\Lscart\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use LivestudioDev\Lscart\Classes\ShipExportDriver;
use LivestudioDev\Lscart\Models\Order;
use LivestudioDev\Lscart\Models\OrderItem;
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
        $orders = Order::where('id',$id)->first();
        $totalPrice = 0;
        //dd($orders->items);

        foreach ($orders->items as $item) {
            if ($item->variant) {
                $totalPrice += ($item->product->price + $item->variant->pricediff) * $item->quantity;
            } else {
                $totalPrice += $item->product->price * $item->quantity;
            }
            

        }
        //dd($orders);
        $data = [
            'order' => $orders,
            'totalPrice' => $totalPrice,
        ];

        return PDF::loadTemplate('livestudiodev.allegro::pdf.order', $data)->download($data["order"]["order_number"].'_'.$data["order"]["name"].'.pdf');
    }

    public function onAddNewOrderItemPopup()
    {
        $this->vars["products"] = Product::where('status','<>',0)->get();
        $this->vars["orderid"] = \Input::get('orderid');
        return $this->makePartial('addneworderitem_popup');
    }

    public function onEditOrderItemPopup()
    {
        $this->vars["orderid"] = \Input::get('orderid');
        $this->vars["itemid"] = \Input::get('itemid');
        $this->vars["item"] = OrderItem::find(\Input::get('itemid'));
        return $this->makePartial('editorderitem_popup');
    }

    public function onRefreshVariants()
    {
        $vars = Product::where('id',\Input::get('product_id'))->first()->variants;

        if(count($vars) > 0){
            $this->vars["variants"] = $vars;
            return [
                '#newItemModalVariants' => $this->makePartial('addproductvariants')
            ];
        }
    }
    public function onOrderAlertsPopup()
    {
        $oid = \Input::get('orderid');
        $order = Order::find($oid);

        $this->vars["orderid"] = $oid;
        $this->vars["alerts"] = $order->alerts;
        $this->vars['cst'] = $order->customer;

        return $this->makePartial('order_alerts');
    }

    public function onAddNewOrderItem()
    {
        $orderid = Input::get('orderid');
        $productid = Input::get('product_id');
        $variantid = Input::get('variant_id');
        $quantity = Input::get('quantity');

        $order = Order::find($orderid);
        $product = Product::find($productid);

        $i_history = [];

        $oitem = $order->items()->where('product_id',$productid)->where('variant_id',$variantid)->first();
        if(!$oitem){
            $oitem = new OrderItem();
            $oitem->history = $i_history; // TBD
            $oitem->extras = null;
            $oitem->variant_id = $variantid;
            $oitem->product = $product;
            $oitem->order_id = $orderid;
            $oitem->quantity = $quantity;
        }else {
            $oitem->quantity += $quantity;
        }
        $oitem->save();
        $order->items()->add($oitem);
        $order->reloadRelations('items');

        $this->vars['formModel'] = $order;
        $this->vars['formContext'] = 'update';

        return [
            '#orderItemTab' => $this->makePartial('orderitems'),
            '#orderTotalTab' => $this->makePartial('ordertotal')
        ];
    }

    public function onEditOrderItem()
    {
        $itemid = Input::get('itemid');
        $orderid = Input::get('orderid');

        $quantity = Input::get('quantity');

        $order = Order::find($orderid);
        $oitem = $order->items()->find($itemid);
        $oitem->quantity = $quantity;
        $oitem->save();

        $order->reloadRelations('items');

        $this->vars['formModel'] = $order;
        $this->vars['formContext'] = 'update';

        return [
            '#orderItemTab' => $this->makePartial('orderitems'),
            '#orderTotalTab' => $this->makePartial('ordertotal')
        ];
    }

    public function onRemoveOrderItem()
    {
        $itemid = Input::get('itemid');
        $orderid = Input::get('orderid');


        $order = Order::find($orderid);
        $oitem = $order->items()->find($itemid);
        $oitem->delete();
        $order->reloadRelations('items');

        $this->vars['formModel'] = $order;
        $this->vars['formContext'] = 'update';

        return [
            '#orderItemTab' => $this->makePartial('orderitems'),
            '#orderTotalTab' => $this->makePartial('ordertotal')
        ];
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

    public function onSummaryPdf()
    {
        $checked = \Input::get('checked');

        return \Redirect::to(\Backend::url('livestudiodev/lscart/orders/multipdf'))->with(['checked' => $checked]);
    }

    public function multipdf()
    {
        $checked = \Session::get('checked', []);
        if(count($checked) < 1) {
            \Flash::error('Nincs kiválasztva egyetlen rendelés sem.');
            return \Redirect::to(\Backend::url('livestudiodev/lscart/orders'));
        }

        $orders = Order::whereIn('id',$checked)->get();
        $products = [];
        $totalPrice = 0;

        foreach ($orders as $order) {
            foreach ($order->items as $item) {

                if(isset($products[$item->product_id.'_'.$item->variant_id])) {
                    $products[$item->product_id.'_'.$item->variant_id]["totalQuantity"] += $item->quantity;
                } else {
                    if ($item->variant_id) {
                        $products[$item->product_id.'_'.$item->variant_id] = [
                            'item' => $item,
                            'product' => $item->product,
                            'variant' => $item->variant,
                            'totalQuantity' => $item->quantity
                        ];
                    } else {
                        $products[$item->product_id.'_0'] = [
                            'item' => $item,
                            'product' => $item->product,
                            'variant' => $item->variant,
                            'totalQuantity' => $item->quantity
                        ];
                    }

                }

                if ($item->variant) {
                    $totalPrice += ($item->product->price + $item->variant->pricediff) * $item->quantity;
                } else {
                    $totalPrice += $item->product->price * $item->quantity;
                }

                //dd($item->product->price);
            }
        }

        $data = [
            'orders' => $orders,
            'products' => $products,
            'totalPrice' => $totalPrice,
        ];
        return PDF::loadTemplate('livestudiodev.allegro::order_multi', $data)->download('Osszegzett_fuvarlevel.pdf');
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
