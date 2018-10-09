<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class View extends Model
{
  protected $fillable = [
      'id', 'viewable_type', 'viewable_id', 'visitor', 'viewed_at'
  ];
  protected $guarded = [];

  public $timestamps = false;

  public static function unique($id)
  {
    return View::where('viewable_id', '=', $id)->get()->unique( ['visitor', true])->count();
  }
  public static function total($id)
  {
    return View::where('viewable_id', '=', $id)->get()->count();
  }

  
}
