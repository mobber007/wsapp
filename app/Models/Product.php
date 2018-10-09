<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\View;
use App\Models\Category;
use App\Models\Brand;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use App\Jobs\ProcessProductView;

class Product extends Model implements  LikeableContract
{
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */

  use HasSlug, Likeable, SearchableTrait;

  protected $fillable = [
    'price', 'title', 'event_url', 'affiliate', 'external_id', 'category_id', 'subcategory', 'keywords', 'thumbnail', 'old_price', 'slug', 'type', 'brand_id', 'url', 'description', 'status'
  ];

  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */


  protected $hidden = [
    'created_at', 'updated_at', 'status', 'url', 'category_id', 'brand_id'
  ];

  /**
  * The accessors to append to the model's array form.
  *
  * @var array
  */
  protected $appends = [
    'favorited', 'discounted', 'unique_views', 'total_views', 'affiliate_logo', 'category', 'brand'
  ];

  protected $searchable = [
    'columns' => [
      'title' => 10,
      'description' => 10,
      'subcategory' => 7,
      'keywords' => 5,
      'affiliate' => 2
    ]
  ];

  public function images()
  {
    return $this->hasMany('App\Models\Image','product_id', 'external_id');
  }

  public function category()
  {
    return $this->belongsTo('App\Models\Category','category_id');
  }

public static function searchProducts($request)
{
  $products = Product::active();
  $request->validated();
  if($request->search)
  $products = $products->search($request->search);
  if($request->category)
  $products = $products->where('category_id','=',$request->category);
  if($request->brand)
  $products = $products->where('brand_id','=',$request->brand);
  if($request->affiliate)
  $products = $products->where('affiliate','=',$request->affiliate);
  if($request->filter == 'ppr')
  $product = $products->whereRaw('(old_price - price)/old_price *100 > 2');
  if($request->filter == 'pcr')
  $products = $products->orderBy('price', 'asc');
  if($request->filter == 'pdc')
  $products = $products->orderBy('price', 'desc');
  if($request->filter == 'ioa')
  $products = $products->orderBy('created_at','desc');
  return $products;
}

  public static function similar($product)
  {
    //$similars = Product::where('category_id', '=', $product->category_id)->where('subcategory', 'LIKE', '%'.$product->subcategory.'%')->whereNotIn('id',[$product->id])->take(100)->get();
    $similars = Product::search($product->title)->whereNotIn('id',[$product->id])->take(100)->get();
    if(count($similars))
    {
      if(count($similars) > 11)
      return $similars->random(12);
      if(count($similars) < 12)
      return $similars->random(count($similars));
    }
    else {
      return Product::search($product->subcategory)->whereNotIn('id',[$product->id])->take(12)->get();
    }
  }

  public static function active()
  {
    return Product::where('status', '>', 0)->where('price', '>', 0);
  }
  public function getSlugOptions() : SlugOptions
  {
    return SlugOptions::create()
    ->generateSlugsFrom(['title'])
    ->usingSeparator('-')
    ->saveSlugsTo('slug');
  }
  public function getFavoritedAttribute()
  {
    return $this->liked;
  }

  public function getCategoryAttribute(){
    return Category::find($this->category_id)->name;
}
public function getBrandAttribute(){
  return Brand::find($this->brand_id)->name;
}
  public function getUniqueViewsAttribute()
  {
    return View::unique($this->id);
  }
  public function getTotalViewsAttribute()
  {
    return View::total($this->id);
  }

  public function getDiscountedAttribute()
  {
    try
    {
      if(ceil((($this->old_price - $this->price)/$this->old_price * 100)) < 2)
      return 0;
      else
      return ceil((($this->old_price - $this->price)/$this->old_price * 100));
    }
    catch (\Exception $exception)
    {
      return 0;
    }
  }
  public function getAffiliateLogoAttribute()
  {
    $affliate_url = str_replace(' ', '',env('APP_URL').'/storage/affiliate/'.str_replace_last('.', '-', $this->affiliate).'.png');

    return $affliate_url;
  }

  public static function sortByViews(string $direction = 'desc')
  {
    return Product::where('type', '<>', 'featured')->leftJoin('views', "views.viewable_id", '=', "products.id")
    ->selectRaw("products.*, count(`views`.`id`) as numOfViews")
    ->groupBy("products.id")
    ->orderBy('numOfViews', $direction);
  }
  public static function sortByUniqueViews(string $direction = 'desc')
  {
    return Product::where('type', '<>', 'featured')->leftJoin('views', 'views.viewable_id', '=', 'products.id')
    ->selectRaw("products.*, count(distinct visitor) as numOfUniqueViews")
    ->groupBy("products.id")
    ->orderBy('numOfUniqueViews', $direction);
  }

  public static function external($product_id)
  {
    try {
      return Product::where('external_id', '=', $product_id)->first();
    } catch (\Exception $e) {
      return null;
    }
  }

  public function addView()
  {
    $view =  View::create([
      'viewable_id' => $this->getKey(),
      'viewable_type' => $this->getMorphClass(),
      'visitor' => Request::ip(),
      'viewed_at' => now()
    ]);
    return $view;
  }
}
