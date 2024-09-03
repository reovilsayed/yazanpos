<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Generic;
use App\Models\Product;
use App\Models\Supplier;
use Exception;
use Goutte\Client;

class ScrapController extends Controller
{

    public function scrap()
    {
      
        if(request('url')){
            $client = new Client();
    
            // Example URL
            $url = request('url');  // Update the URL
        
            // Send a GET request to the URL
            $crawler = $client->request('GET', $url);
        
            $description = $crawler->filter('.generic-data-container.en')->html();
            $title = $crawler->filter('.page-heading-1-l')->text();
            $generic_id = $this->getGenericId( $title);
    
            $generic = Generic::find($generic_id);
    
            $generic->description = $description;
            $generic->save();
            $crawler->filter('.available-brands .brand-item')->each(function ($productItem) use($generic_id) {
                 $productName = $productItem->filter('.data-row-top')->text() ;
                 $strength = $productItem->filter('.data-row-strength')->text();
                 $company = $productItem->filter('.data-row-company')->text();
                 $productUrl = $productItem->filter('a')->attr('href');
                $unitPrice = $productItem->filter('.unit-price .package-pricing')->text();
                preg_match('/[0-9.]+/', $unitPrice, $matches);
                 $priceWithoutSymbol = isset($matches[0]) ? $matches[0] : null ;
       
                preg_match('/\d+/', $strength, $iuMatches);
    
                
                $product = new Product();
                $product->name = $productName;
                $product->strength = $strength;
                $product->generic_id = $generic_id;
                $product->supplier_id = $this->getSupplierId($company);
                $product->price = $priceWithoutSymbol;
                $product->trade_price = $priceWithoutSymbol * .88;
                $product->scrapper_url = $productUrl;
                $product->save();
            });
        }
        return view('scrap');

    }
    

    public function product()
    {
        $products = Product::latest()->limit(1000)->where('scrapped',0)->get();
        return view('product', compact('products'));
    }



    public function getSupplierId($name)
    {
        $supplier = Supplier::firstOrCreate([
            'name' => $name,
        ]);

        return $supplier->id;
    }
    public function getGenericId($name)
    {
        $generic = Generic::firstOrCreate([
            'name' => $name,
        ]);

        return $generic->id;
    }
    public function getCategoryId($name)
    {
        $category = Category::firstOrCreate([
            'name' => $name,
        ]);

        return $category->id;
    }
    public function progress()
    {
       $product_done = Product::where('scrapped',1)->count();
       $product_error = Product::where('scrapped',2)->count();
       $product_pending = Product::where('scrapped',0)->count();

       return [
          'done'=>$product_done,
          'error'=>$product_error,
          'pending'=>$product_pending,
       ];
    }
}