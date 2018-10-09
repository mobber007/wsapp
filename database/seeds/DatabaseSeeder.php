<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Seed;
use App\Models\Affiliate;
use App\Jobs\ProcessSeedProduct;
use App\Models\Image;
use App\Scrappers\Zoom;
use App\Scrappers\Crawler;
use GuzzleHttp\Client as Client;

class DatabaseSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    //$this->fix_kurtmman();
  

  }




  protected function fix_kurtmman()
  {
    $products = Product::where('affiliate', '=', 'kurtmann.ro')->get();
    $total = count($products);
    foreach ($products as $index => $product) {
      $images = Image::where('product_id', '=', $product->external_id)->get();
      if(count($images))
      {
        foreach ($images as $value) {
          $new_value = mb_strtolower(str_replace('kurtmann.ro', 'www.kurtmann.ro', $value->url));
          $status_code = $this->check_link($new_value);
          if($status_code == 200)
          {
            $value->url = $new_value;
            $value->save();
            $this->command->info('Updated image');
          }
        }
      }
      else {
        $res = $this->initiazeCrawl($product->url);
        $images = array_unique($res->filterXPath('//a[contains(@rel, "zoom")]')->evaluate('substring-after(@href, "")'));
        foreach ($images as $value) {
          $new_value = mb_strtolower(str_replace('kurtmann.ro', 'www.kurtmann.ro', $value));
          $status_code = $this->check_link($new_value);
          if($status_code == 200)
          {

            $image = new Image();
            $image->url = $new_value;
            $image->product_id = $product->external_id;
            $image->save();
            $this->command->info('Created new image');
          }
        }
      $this->command->info($total - $index.' => '.count($images));
      }

    }


  }
  protected function check_link($url){
    $guzzle_options = [
      'allow_redirects' => [
        'max'             => 0,        // allow at most 1 redirects.
        'strict'          => true,      // use "strict" RFC compliant redirects.
        'referer'         => true,      // add a Referer header
        'protocols'       => ['https', 'http'],
        'track_redirects' => true
      ],
      'timeout' => 30,
      'verify' => true,
      'synchronous' => true];

      try {
        $client = new Client($guzzle_options);
        $res = $client->request('GET',$url);
        $status = $res->getStatusCode();
      } catch (\Exception $e) {
        $status = $e->getCode();
      }
      return $status;
    }

  protected function createMyCsv()
  {
    $path = public_path().'/csv/feed.csv';
    $this->command->info('Fetching updated feeds');
    file_put_contents($path, file_get_contents(env('2PERFORMANT_FEED')));
    $this->command->info('Updated feeds fetched');
    $reader = Reader::createFromStream(fopen($path, 'r'));
    $reader->setDelimiter(',');
    $reader->setHeaderOffset(0);
    $this->command->info('Parsing records to array');
    $datas = $reader->getRecords();
    $this->command->info('Records parsed');
    return [ 'feeds' => $datas, 'total' => count($reader)];
  }

protected function fix_bmall_seeds()
{
  $seeds = Seed::where('campaign_name', '=', 'b-mall.ro')->get();
  $count = count($seeds);
  foreach ($seeds as $index => $seed) {
    $this->command->info($count - $index);
    try {
      $bmall = $this->scrape_bmall($seed->url);
      $seed->title = $bmall['title'];
      $seed->description = $bmall['description'];
      $seed->image_urls = serialize($bmall['images']);
      $seed->save();
    } catch (\Exception $e) {

    }

  }
}
protected function fix_simple_seeds()
{
  $seeds = Seed::whereIn('campaign_name', ['starshiners.ro', 'depurtat.ro', 'missgrey.ro'])->get();
  $count = count($seeds);
  foreach ($seeds as $index => $seed) {
    $this->command->info($count - $index);
    try {
      $splits = $this->split_images($seed->image_urls);
      $this->command->info($seed->title.' => '.count($splits['images']));
      $seed->image_urls = serialize($splits['images']);
      $seed->save();
    } catch (\Exception $e) {

    }

  }
}
protected function fix_brand_seeds()
{
  $seeds = Seed::where('brand', '=','')->get();
  $count = count($seeds);
  foreach ($seeds as $index => $seed) {
    $this->command->info($count - $index);
    try {
      $seed->brand = ucwords(explode('.', $seed->campaign_name)[0]);
      $seed->save();
    } catch (\Exception $e) {

    }

  }
}
protected function fix_description_seeds()
{
  $seeds = Seed::where('description', '=','')->get();
  $count = count($seeds);
  foreach ($seeds as $index => $seed) {
    $this->command->info($count - $index);
    try {
      $seed->description = $seed->title.' '.$seed->product_id.' vandut de '.$seed->campaign_name;
      $seed->save();
    } catch (\Exception $e) {

    }

  }
}

  protected function initiazeCrawl($url)
  {
    $guzzle_options = [
      'allow_redirects' => [
        'max'             => 1,        // allow at most 10 redirects.
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
      $res = $this->initiazeCrawl($url);
      $images = $res->filterXPath('//ul[contains(@id, "gallery")]/li/img')->evaluate('substring-after(@data-cloudzoom, "zoomImage:")');
      try {
        $description = $res->filterXPath('//div[contains(@id, "div_product_short_description")]')->text();
      } catch (\Exception $e) {
        $description =  NULL;
      }
      try {
        $title = $res->filterXPath('//div[contains(@id, "breadcrumbs")]/ul/li/a')->last()->text();
      } catch (\Exception $e) {
      $title = NULL;
      }
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
      try {
        $description = $res->filter('div > div.meniu4')->text();
      } catch (\Exception $e) {
        $description = NULL;
      }


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
    protected function split_images($images){
      $new_images = explode(',', str_replace(' ', '', $images));
      return [
        'images' => $new_images,
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

    protected function make_seeds()
    {
      $csv = $this->createMyCsv();
      $feeds = iterator_to_array($csv['feeds'], true);
      $products = [];
        $this->command->info('Counting updatable products');
      foreach ($feeds as $index => $feed){
        if($feed['product_active'] == 0)
        {
            array_push($products, $feed);

        }

        else {
          if(!Seed::where('product_id','=', $feed['product_id'])->first()){
            array_push($products, $feed);
          }
        }

      }

      $total = count($products);
      $this->command->info('counted '.$total.' updatable products');
      foreach ($products as $index => $product) {
        $this->command->info($total - $index);
        try {
          $seed = Seed::createOrUpdate($product);
          ProcessSeedProduct::dispatch($seed);

        } catch (\Exception $e) {
          $this->command->info($e->getMessage());
        }
      }
      /*$index = $total;
      while ($index <= $total) {
        $this->command->info($index);
        $index -= 1;
        $feed = $products[$index];
        try {
          $seed = Seed::createOrUpdate($feed);
          ProcessSeedProduct::dispatch($seed);

        } catch (\Exception $e) {
          $this->command->info($e->getMessage());
        }

      }*/
    }
    protected function start_seeder()
    {
      $csv = $this->createMyCsv();
      $feeds = $csv['feeds'];
      $total = $csv['total'];
      foreach ($feeds as $index => $feed) {
        $this->command->info($total - $index);
        if($feed['product_id']){
          $product = Product::external($feed['product_id']);
          $affiliate = (string)mb_strtolower($feed['campaign_name']);
          if($product){
            try {
              $product->price = intval($feed['price']);
              $product->old_price = intval($feed['old_price']);
              $product->status = intval($feed['product_active']);
              $product->save();
              $this->command->info('Updated product => '.$product->external_id);
            } catch (\Exception $e) {
              $this->command->info($e->getMessage());
            }
          }


          else {
            $product = new Product();
            try {
              $product->price = intval($feed['price']);
              $product->old_price = intval($feed['old_price']);
              $product->status = intval($feed['product_active']);
              $product->featured = 0;
              $product->popular = 0;
              $product->title = $feed['title'];
              $product->event_url = $feed['aff_code'];
              $product->url = $feed['url'];
              $product->meta_title = $feed['title'];
              $product->meta_keywords = mb_strtolower($feed['category'].','.$feed['subcategory']);
              $product->subcategory = mb_strtolower($feed['subcategory']);
              $product->meta_description = $feed['description'];
              $product->external_id = $feed['product_id'];
              $product->category_id = Category::findOrCreate($feed['category']);
              $product->brand_id = Brand::findOrCreate($feed['brand']);
              switch ($affiliate) {
                case 'depurtat.ro':
                $product_images = $this->split_images($feed['images'])['images'];
                $product->thumbnail = $product_images[0];

                break;
                case 'missgrey.ro':
                $product_images = $this->split_images($feed['images'])['images'];
                $product->thumbnail = $product_images[0];

                break;
                case 'starshiners.ro':
                $product_images = $this->split_images($feed['images'])['images'];
                $product->thumbnail = $product_images[0];

                break;
                case 'ppt.ro':
                $ppt = $this->scrape_ppt($product->url);
                $product_images = $ppt['images'];
                $product->thumbnail = $product_images[0];
                $product->description =  $ppt['description'];

                break;
                case 'dyfashion.ro':
                $dyfashion = $this->scrape_dyfashion($product->url);
                $product_images = $dyfashion['images'];
                $product->thumbnail = $product_images[0];

                break;
                case 'kurtmann.ro':
                $kurtmann = $this->scrape_kurtmann($product->url);
                $product_images = $kurtmann['images'];
                $product->thumbnail = $product_images[0];
                $product->description =  $kurtmann['description'];

                break;
                default:
                $bmall = $this->scrape_bmall($product->url);
                $product_images = $bmall['images'];
                $product->thumbnail = $product_images[0];
                $product->description =  $bmall['description'];
                $product->title =  $bmall['title'];

                break;
              }
              $product->affiliate = $affiliate;
              $product->save();
              foreach ($product_images as $key => $product_image) {
                $image = new Image();
                $image->url = $product_image;
                $image->product_id = $product->id;
                $image->save();
              }
              $this->command->info('Created product => '.$product->external_id);

            } catch (\Exception $e) {
              $this->command->info($e->getMessage());
            }
          }}
        }
      }
    }
