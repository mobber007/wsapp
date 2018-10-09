<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Seed;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Image;
use App\Scrappers\Zoom;
use GuzzleHttp\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSeedProduct implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $seed;
  public $tries = 1;

  public function __construct($seed){
    $this->seed = $seed;
  }

  public function handle(){
    $product = Product::external($this->seed->product_id);
    if($product){
      $this->updateProduct($product);
    }
    else {
      $this->createProduct();
    }

  }
  protected function initiazeCrawl($url){
    $guzzle_options = [
      'allow_redirects' => [
        'max'             => 1,        // allow at most 1 redirects.
        'strict'          => true,      // use "strict" RFC compliant redirects.
        'referer'         => true,      // add a Referer header
        'protocols'       => ['https', 'http'],
        'track_redirects' => true
      ],
      'timeout' => 30,
      'verify' => true,
      'synchronous' => true];
      $guzzle_client = new Client($guzzle_options);
      $client = new Zoom();
      $client->setClient($guzzle_client);
      $res = $client->request('GET',$url);
      return $res;
    }
    protected function scrape_bmall($url){
      $res = $this->initiazeCrawl((string)$url);
      try {
        $description = $res->filterXPath('//div[contains(@id, "div_product_short_description")]')->text();
      } catch (\Exception $e) {
        $description = NULL;
      }
      try {
        $title = $res->filterXPath('//div[contains(@id, "breadcrumbs")]/ul/li/a')->last()->text();
      } catch (\Exception $e) {
        $title = NULL;
      }

      $title = $res->filterXPath('//div[contains(@id, "breadcrumbs")]/ul/li/a')->last()->text();
      $images = $res->filterXPath('//ul[contains(@id, "gallery")]/li/img')->evaluate('substring-after(@data-cloudzoom, "zoomImage:")');
      foreach ($images as $index => $image) {
        $images[$index] = str_replace("'", '', $image);
      }
      return [
        'images' => $images,
        'title' => $title,
        'description' => $description
      ];
    }
    protected function scrape_kurtmann($url){
      $res = $this->initiazeCrawl((string)$url);
      $description = $res->filter('div > div.meniu4')->text();
      $images = array_unique($res->filterXPath('//a[contains(@rel, "zoom")]')->evaluate('substring-after(@href, "")'));

      return [
        'images' => $images,
        'description' => $description
      ];
    }
    protected function scrape_dyfashion($url){
      $res = $this->initiazeCrawl((string)$url);
      $images = $res->filterXPath('//a[contains(@class, "elevatezoom")]')->evaluate('substring-after(@data-zoom-image, "")');
      return [
        'images' => $images,
      ];
    }
    protected function scrape_ppt($url){
      $res = $this->initiazeCrawl((string)$url);
      $description = $res->filterXPath('//table[contains(@id, "product-attribute-specs-table")]')->text();
      $images = explode(',',explode('"data":',array_reverse(array_filter(array_unique($res->filterXPath('//script[contains(@type, "text/x-magento-init")]')->each(function ($node, $i) {
        if(strpos($node->text(), 'data-gallery-role=gallery-placeholder') && strpos($node->text(), 'mage/gallery/gallery'))
        return $node->text();
      }))))[0])[1]);
      $new_images = [];
      foreach ($images as $index => $image) {
        if(strpos($image, 'img'))
        {
          $new_image = 'https://ppt-prod-static-ro.azureedge.net/media/catalog/product/l/a/'.explode('\/l\/a\/',str_replace('"', '', explode('"img":"', $image)[1]))[1];
          array_push($new_images, $new_image);
        }

      }
      return [
        'images' => $new_images,
        'description' => (string)$description
      ];
    }
    protected function split_images($images){
      $new_images = explode(',', str_replace(' ', '', $images));
      return [
        'images' => $new_images,
      ];
    }

    public function updateProduct($product)
    {
      $product->price = intval($this->seed->price);
      $product->old_price = intval($this->seed->old_price);
      $product->status = intval($this->seed->product_active);
      $product->save();
    }
    public function createProduct()
    {
      $product = new Product();

      $product->price = intval($this->seed->price);
      $product->old_price = intval($this->seed->old_price);
      $product->status = intval($this->seed->product_active);
      $product->title = (string)$this->seed->title;
      $product->event_url = (string)$this->seed->aff_code;
      $product->url = (string)$this->seed->url;
      $product->keywords = (string)mb_strtolower($this->seed->category.','.$this->seed->subcategory);
      $product->subcategory = ucwords(mb_strtolower($this->seed->subcategory));
      $product->external_id = (string)$this->seed->product_id;
      $product->category_id = Category::findOrCreate(ucwords(mb_strtolower($this->seed->category)));
      $product->brand_id = Brand::findOrCreate(ucwords(mb_strtolower($this->seed->brand)));
      $product_images = $this->split_images($this->seed->image_urls)['images'];
      $product->description =  (string)$this->seed->description;
      $product->affiliate = (string)mb_strtolower($this->seed->campaign_name);
      if(strpos($product->url, 'b-mall.ro') !== FALSE){
        $res = $this->initiazeCrawl($product->url);
        try {
          $description = $res->filterXPath('//div[contains(@id, "div_product_short_description")]')->text();
        } catch (\Exception $e) {
          $description =  (string)$this->seed->description;
        }
        try {
          $title = $res->filterXPath('//div[contains(@id, "breadcrumbs")]/ul/li/a')->last()->text();
        } catch (\Exception $e) {
        $title = (string)$this->seed->title;
        }
        $images = $res->filterXPath('//ul[contains(@id, "gallery")]/li/img')->evaluate('substring-after(@data-cloudzoom, "zoomImage:")');
        foreach ($images as $index => $image) {
          $images[$index] = str_replace("'", '', $image);
        }
        //$bmall = $this->scrape_bmall($product->url);
        $product_images = $images;
        $product->description =  $description;
        $product->title =  (string)$title;
      }
      if(strpos($product->url, 'ppt.ro') !== FALSE){
        $ppt = $this->scrape_ppt($product->url);
        $product_images = $ppt['images'];
        $product->description =  $ppt['description'];
      }
      if(strpos($product->url, 'kurtmann.ro') !== FALSE){
        $kurtmann = $this->scrape_kurtmann($product->url);
        $product_images = $kurtmann['images'];
        $product->description =  $kurtmann['description'];
      }
      if(strpos($product->url, 'dyfashion.ro') !== FALSE){
        $dyfashion = $this->scrape_dyfashion($product->url);
        $product_images = $dyfashion['images'];
      }

      try {
        $product->thumbnail = (string)$product_images[0];
      } catch (\Exception $e) {
        $product->thumbnail = (string)$product_images;
      }

      $product->save();
      foreach ($product_images as $key => $product_image) {
        $image = new Image();
        $image->url = $product_image;
        $image->product_id = $product->external_id;
        $image->save();
      }

    }
  }
