<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Goutte\Client;
use App\Models\Generic;
use Exception;
class ScrapEveryMin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrap:everymin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will scrap data every min';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $product = Product::where('scrapped',0)->first();  
        $client = new Client();
           try{
               $crawler = $client->request('GET', $product->scrapper_url);
               $category = $crawler->filter('.page-heading-1-l.brand small')->text();
               $product->category_id = $this->getCategoryId($category);
               $product->scrapped_data =  $crawler->filter('.section > .container > .row > .col-xs-12.col-sm-6.col-md-6.col-lg-6 > .row')->html();
               $product->scrapped=1;
               $product->save();
              
           }catch(Exception $e){
               $product->error = $e->getMessage();
               $product->scrapped=2;
               $product->save();
           }
    }
    public function getCategoryId($name)
    {
        $category = Category::firstOrCreate([
            'name' => $name,
        ]);

        return $category->id;
    }
}
