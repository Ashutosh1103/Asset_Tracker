@extends('admin.master')

@section('content')
<div class="content-wrapper">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Asset Type') }}
        </h2>
    </x-slot>
    @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{route('AddAssetTypePost')}}">
                        @method('POST')
                        @csrf
                        <div class="grid grid-cols-2 gap-6">
                            <div class="grid grid-rows-2 gap-6">
                                <div>
                                    <x-label for="assetTypeName" :value="__('Asset Type Name')" />
                                    <x-input id="assetTypeName" class="block mt-1 w-full" type="text" name="assetTypeName" autofocus />
                                    @if($errors->has('assetTypeName'))
                                        <label class="text text-danger">{{$errors->first('assetTypeName')}}</label>
                                    @endif  
                                </div>
                                <div class="form-group">
                                    <x-label for="AssetTypeDesc" :value="__('Description')"/>
                                    <x-input id="AssetTypeDesc" class="block mt-1 w-full" type="text" name="AssetTypeDesc" autofocus />
                                    @if($errors->has('AssetTypeDesc'))
                                        <label class="text text-danger">{{$errors->first('AssetTypeDesc')}}</label>
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