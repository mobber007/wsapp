<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'created_at', 'updated_at', 'parent_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'slug'
    ];
   /* protected $appends = [
        'children'
    ];

    public function getChildrenAttribute()
    {
        return Category::where('parent_id', '=', $this->id)->get();
    }*/
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */

     public static function findOrCreate($name)
     {
       $category = Category::where('name', '=', $name)->first();
       if(!$category)
       {
         $category = new Category();
         $category->name = (string)$name;
         $category->parent_id = 0;
         $category->save();
       }
       return $category->id;
     }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name'])
            ->usingSeparator('-')
            ->saveSlugsTo('slug');
    }
}
