<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Product;
use App\Models\View;

class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'role:guru']);
  }

  public function index()
  {
    $widgets = array([
      'name' => 'users',
      'icon' => 'group',
      'total' => $this->users()
    ],
    [
      'name' => 'products',
      'icon' => 'store',
      'total' => $this->products()
    ],
    [
      'name' => 'views',
      'icon' => 'remove_red_eye',
      'total' => $this->views()
    ]);
    return response()->json($widgets);
  }
  protected function users()
  {
    return User::paginate(12)->total();
  }
  protected function products()
  {
    return Product::paginate(12)->total();
  }
  protected function views()
  {
    return View::select('viewable_id')->groupBy('viewable_id')->paginate(12)->total();
  }
}
