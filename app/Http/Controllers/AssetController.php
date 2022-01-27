<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetImage;
use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetController extends Controller
{


    public function AddAsset(){
        $asset_type_data = AssetType::all();
        return view('admin.AddAsset',['asset_type_data'=>$asset_type_data]);
    }
    public function AddAssetPost(Request $req){
        $req->validate([
            'assetName'=>'required',
            'AssetType'=>'required',
            'AssetActive'=>'required',
        ],
        [
            'assetName.required'=>'Please enter name of Asset',
            'AssetType.required'=>'Please enter type of Asset',
            'AssetActive.required'=>'Please enter if Asset is active',  
        ]
        );
        $uuid = substr(md5(uniqid(time())),16);
        if(!$req->has('assetImg')){ //if image not inserted by user
                Asset::insert([
                    'type_id'=>$req->AssetType,
                    'asset_name'=>$req->assetName,
                    'asset_code'=>$uuid,
                    'is_active'=>$req->AssetActive,
                ]);
                // $asset = Asset::where('type_id',$req->AssetType)->first();
                // $req->session()->put('Assetid',$asset->id);
                return back()->with('success','Data inserted');
                
            }
        else{
                $image = $req->file('assetImg');
                $dest = public_path('/uploads');
                $filename = "Image-".rand()."-".time().".".$image->extension();
                if($image->move($dest,$filename)){
                    $asset_inserted=Asset::create([
                        'type_id'=>$req->AssetType,
                        'asset_name'=>$req->assetName,
                        'asset_code'=>$uuid,
                        'is_active'=>$req->AssetActive,
                    ]);
                  
                    // $asset = Asset::where('type_id',$req->AssetType)->first();
                    // $req->session()->put('Assetid',$asset_inserted->id);
                    if($asset_inserted){
                         AssetImage::insert([
                        'images'=>$filename,
                        'asset_id'=>$asset_inserted->id
                     ]);
                     return back()->with('success','Asset with Image inserted Successfully');
                    }
                 }  
                 else{
                    return back()->with('error','Some error occured in image uploading. Please try again');
                 }
            }
    }
    
    public function UpdateAsset($id){
        $asset_type_data = AssetType::all();
        $asset = Asset::with('AssetType')->where('id',$id)->first();
        $image = AssetImage::with('Asset')->where('asset_id',$id)->get();
        return view('admin.UpdateAsset',['asset_data'=>$asset,'asset_type_data'=>$asset_type_data,'image'=>$image]);
    }

    public function UpdateAssetPost(Request $req){
        // dd($asset[0]->asset_name);
        $req->validate([
            'assetName'=>'required', 
        ],
        [
            'assetName.required'=>'Please enter name of Asset', 
        ]
        );
        // dd($req->AssetActive);
        if(!empty($req->AssetType)){
            if(!empty($req->AssetActive)){
                Asset::where('id',$req->assetid)->update([
                    'type_id'=>$req->AssetType,
                    'asset_name'=>$req->assetName,
                    'is_active'=>$req->AssetActive,
                ]);
                return back()->with('success','Asset updated Successfully');
            }
            else{
                Asset::where('id',$req->assetid)->update([
                    'type_id'=>$req->AssetType,
                    'asset_name'=>$req->assetName,  
                    'is_active'=>$req->AssetActive,
                ]);
                return back()->with('success','Asset updated Successfully');
            }
        }
        else{
            if($req->has('AssetActive')){
                Asset::where('id',$req->assetid)->update([
                    'asset_name'=>$req->assetName,
                    'is_active'=>$req->AssetActive,
                ]);
                // dd($req->AssetActive);
                return back()->with('success','Asset updated Successfully');
            }
            else{
                Asset::where('id',$req->assetid)->update([
                    'asset_name'=>$req->assetName,
                    'is_active'=>$req->AssetActive,
                ]);
                return back()->with('success','Asset updated Successfully');
            }
        }
        //add image
        if($req->has('assetImg')){
            $image = $req->file('assetImg');
            $dest = public_path('/uploads');
            $filename = "Image-".rand()."-".time().".".$image->extension();
            if($image->move($dest,$filename)){
                AssetImage::insert([
                    'images'=>$filename,
                    'asset_id'=>$req->assetid
                    ]);
                    return back()->with('success','Asset with Image updated Successfully');
                
                }  
                else{
                return back()->with('error','Some error occured in image uploading. Please try again');
                }
        }
        
    }
    public function deleteAsset(Request $req){
        $image = AssetImage::where('asset_id', $req->Asset_id)->get();       
        if ($image) {
            foreach ($image as $product) {
                unlink(public_path('uploads/') . $product->images);
            }
        }
        $asset = Asset::where('id', $req->Asset_id)->delete();
        if ($asset) {
            return response()->json(['msg'=>"Asset removed"]);
        } else {
            return response()->json(['msg'=>"Asset could not be deleted"]);
        } 
    }

    public function ShowAsset(Request $req){
        $data = Asset::with('AssetType')->get();
        $images = AssetImage::with('Asset')->get();
        // dd($req->session()->get('Assetid'));
        // $image = AssetImage::where('asset_id',$req->session()->get('Assetid'))->get();
        return view('admin.ShowAssets',['data'=>$data,'images'=>$images]);
    }

    public function ShowAssetImages($id){
        // $assetId = $req->session()->get('Assetid');
        $image = AssetImage::with('Asset')->where('asset_id',$id)->get();
        return view('admin.ShowAssetImages',['data'=>$image]);
    }

    public function deleteAssetImage(Request $req){
        $image = AssetImage::where('asset_id', $req->image_id)->get();       
        if ($image) {
            foreach ($image as $product) {
                unlink(public_path('uploads/') . $product->images);
            }
        }
        $assetimage = AssetImage::where('id', $req->image_id)->delete();
        if ($assetimage) {
            return response()->json(['msg'=>"Asset image removed"]);
        } else {
            return response()->json(['msg'=>"Asset image could not be deleted"]);
        } 
    }
}
