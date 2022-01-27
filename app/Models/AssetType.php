<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    use HasFactory;
    protected $fillable = ['asset_type_name', 'id','asset_type_desc'];
    protected $table = "asset_types";
    public function Asset(){
        return $this->hasMany(Asset::class,'type_id','id');
    }
    
}
