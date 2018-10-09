<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
  protected $fillable = [
    'name', 'created_at', 'updated_at'
  ];

  protected $hidden = [
    'created_at', 'updated_at'
  ];
  public static function findOrCreate($name)
  {
    $brand = Brand::where('name', '=', $name)->first();
    if(!$brand)
    {
      $brand = new Brand();
      $brand->name = $name;
      $brand->save();
    }
    return $brand->id;
  }
}
