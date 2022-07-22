<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use LivestudioDev\Lscart\Models\Product;

class SimpleXMLExtended extends \SimpleXMLElement {
	public function addCData($cdata_text) {
	  $node = dom_import_simplexml($this);
	  $no   = $node->ownerDocument;
	  $node->appendChild($no->createCDATASection($cdata_text));
	}
}

Route::get('google/merchant_rss.xml', function() {
    $products = Product::isActive()->has('category')->get();
    $xml = new SimpleXMLExtended("<?xml version=\"1.0\"?><rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\"></rss>");
    $NS = array( 
      'g' => 'http://base.google.com/ns/1.0' 
    ); 
    $xml->registerXPathNamespace('g', $NS['g']);
    $channel = $xml->addChild('channel');
    $cTitleCDATA = $channel->addChild('title');
    $cTitleCDATA->addCData('Allegro');
    $channel->addChild('link','https://allegro.hu');
    $cDescCDATA = $channel->addChild('description');
    $cDescCDATA->addCData('');
  
    foreach($products as $key => $product) {
      $item = $channel->addChild('item');
      $item->addChild('xmlns:g:id',$product->id);
      $nameCDATA = $item->addChild('xmlns:g:title');
      $nameCDATA->addCData($product->name);
  
      $descCDATA = $item->addChild('xmlns:g:description');
      $descCDATA->addCData(preg_replace('/[\x00-\x1F\x7F]/', '', $product->description));
  
      $item->addChild('xmlns:g:link',URL::to('termek/'.$product->slug));
      if($product->image) {
        $item->addChild('xmlns:g:image_link',$product->image->getPath());
      }
      $item->addChild('xmlns:g:condition','new');
      $avaCDATA = $item->addChild('xmlns:g:availability');
      $avaCDATA->addCData("in stock");
    // deprecated in favor of always in stock
    //   if($product->totalStock > 0) { 
    //     $avaCDATA->addCData("in stock");
    //   } else {
    //     $avaCDATA->addCData("out of stock");
    //   }
      $item->addChild('xmlns:g:price',"0 HUF"); // Always free
    }
  
    $headers = ['Content-Type' => 'application/xml'];
    return response($xml->asXml(),200,$headers);
  });