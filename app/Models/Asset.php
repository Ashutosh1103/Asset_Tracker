<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AssetType;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_name',
        'type_id',
        'asset_code',
        'is_active'
    ];
    protected $table = "assets";
    public function AssetType(){
        return $this->belongsTo(AssetType::class,'type_id','id');
    }
    public function AssetImage(){
        return $this->hasMany(AssetImage::class,'asset_id','id');
    }
}
