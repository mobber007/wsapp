<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
  protected $fillable = [
      'name', 'created_at', 'updated_at'
  ];

  public $timestamps = false;

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'created_at', 'updated_at'
  ];
}
