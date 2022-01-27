<?php

namespace App\Http\Controllers;

use App\Models\AssetImage;
use App\Models\AssetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetTypeController extends Controller
{
    public function add(){
        return view('admin.AddAssetType');
    }
    public function AddAssetTypePost(Request $req){
        $req->validate([
            'assetTypeName'=>'required',
            'AssetTypeDesc'=>'required'
        ],
        [
            'assetTypeName.required'=>'Please enter Type of Asset',
            'AssetTypeDesc.required'=>'Please enter description of Asset type'
        ]
        );
        $insert=AssetType::create([
            'asset_type_name'=>$req->assetTypeName,
            'asset_type_desc'=>$req->AssetTypeDesc
        ]);
        if($insert){
            return back()->with('success','data added successfully');
        }
    }

    public function UpdateAssetType($id){
        $assetType = AssetType::where('id',$id)->get();
        return view('admin.UpdateAssetType',['asset_type_data'=>$assetType]);
    }
    public function UpdateAssetTypePost(Request $req){
        $req->validate([
            'assetTypeName'=>'required',
            'AssetTypeDesc'=>'required'
        ],
        [
            'assetTypeName.required'=>'Please enter Type of Asset',
            'AssetTypeDesc.required'=>'Please enter description of Asset type'
        ]
        );
        // dd($req->AssetTypeId);
        AssetType::where('id',$req->AssetTypeId)->update([
            'asset_type_name'=>$req->assetTypeName,
            'asset_type_desc'=>$req->AssetTypeDesc,
        ]);
        return back()->with('success','Asset type updated successfully');
    }

    public function deleteAssetType(Request $req){   
       
            $asset = AssetType::where('id', $req->Asset_type_id)->delete();
            if ($asset) {
                return response()->json(['msg'=>"Asset type removed"]);
            } else {
                return response()->json(['msg'=>"Asset could not be deleted"]);
            } 
        
    }

    public function ShowAssetType(){
        $data = AssetType::all();
        return view('admin.ShowAssetType',compact('data'));
    }
}
