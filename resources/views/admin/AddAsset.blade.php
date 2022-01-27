@extends('admin.master')

@section('content')
<div class="content-wrapper">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Asset') }}
        </h2>
    </x-slot>
    @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif
    @if(Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error')}}</div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{route('AddAssetPost')}}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="grid grid-cols-2 gap-6">
                            <div class="grid grid-rows-2 gap-6">
                                <div>
                                    <x-label for="assetName" :value="__('Asset Name')" />
                                    <x-input id="assetName" class="block mt-1 w-full" type="text" name="assetName" autofocus />
                                    @if($errors->has('assetName'))
                                        <label class="text text-danger">{{$errors->first('assetName')}}</label>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    <x-label for="AssetType" :value="__('Asset Type')"/>
                                    <select name="AssetType" class="form-control custom-select">
                                        <option value="">Select Asset Type</option>
                                        @foreach($asset_type_data as $AssetType)
                                            <option value="{{$AssetType->id}}">{{$AssetType->asset_type_name}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('AssetType'))
                                        <label class="text text-danger">{{$errors->first('AssetType')}}</label>
                                    @endif 
                                </div>
                                <div>
                                    <x-label for="assetImg" :value="__('Asset Image')" />
                                    <input id="assetImg" class="block mt-1 w-full" type="file" name="assetImg"  autofocus />
                                    <!-- <x-input id="assetImgid" class="block mt-1 w-full" value="" type="hidden" name="assetImgid"  autofocus /> -->
                                    @if($errors->has('assetImg'))
                                        <label class="text text-danger">{{$errors->first('assetImg')}}</label>
                                    @endif 
                                </div>
                                <div class="form-group">
                                    <x-label for="AssetActive" :value="__('Asset Active or Inactive')"/>
                                    <select name="AssetActive" class="form-control custom-select">
                                        <option value="">Select Asset Active or Inactive</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @if($errors->has('AssetActive'))
                                        <label class="text text-danger">{{$errors->first('AssetActive')}}</label>
                                    @endif 
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <x-button class="ml-3">
                                {{ __('Add') }}
                            </x-button>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</div>

@stop