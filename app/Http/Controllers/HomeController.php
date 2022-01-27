<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Assettype;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $assets_with_assetType = Asset::with('AssetType')->get();
        $asset_active = Asset::where('is_active', 1)->count();
        $asset_inactive = Asset::where('is_active', 0)->count();
        session()->put('sid','admin@gmail.com');
        return view('admin.dashboard',['assets_with_assetType'=>$assets_with_assetType, 'asset_active' => $asset_active, 'asset_inactive' => $asset_inactive]);
    }
}
