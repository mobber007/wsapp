<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Image;
use App\Scrappers\Zoom;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;

class CheckImagesLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check_images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
     protected function check_link($url){
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

         try {
           $client = new Client($guzzle_options);
           $res = $client->request('GET',$url);
           $status = $res->getStatusCode();
         } catch (\Exception $e) {
           $status = $e->getCode();
         }
         return $status;
       }

    public function handle()
    {
        $images = Image::all();
        $total = count($images);
        foreach ($images as $index => $image) {
          $this->info($total - $index);
          $status_code =  $this->check_link($image->url);
          $this->info($image->url.' => '.$status_code);
          if($status_code != 200)
          {
              $image->delete();
          }

        }
    }
}
