<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seed extends Model
{
  protected $fillable = [
    'price', 'title', 'aff_code', 'campaign', 'product_id', 'category', 'subcategory', 'meta_keywords', 'meta_title', 'meta_description', 'images', 'old_price', 'featured', 'brand', 'url', 'description', 'popular', 'status'
  ];

  public $timestamps = false;

  public static function createOrUpdate($feed)
  {
    $seed = Seed::where('product_id', '=', $feed['product_id'])->first();
    if($seed)
    $seed->update($feed);
    else
    $seed = Seed::create($feed);

    return $seed;

  }
}
