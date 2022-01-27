@extends('admin.master')
@section('content')
<div class="content-wrapper">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assets') }}
        </h2>
    </x-slot> 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Asset Name</th>
                            <th>Asset Images</th>
                            <th width="300px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        @if(!empty($data))
                            @foreach($data as $value)
                                <tr>
                                    <td>{{ $value->Asset->asset_name }}</td>
                                    <td>
                                        <img src="{{asset('/uploads/'.$value->images)}}" width="100" height="100"><br>
                                        <button  class="btn btn-danger delAssetImages" id="{{$value->id}}">Delete</button>
                                    </td>
                                    <td>
                                       
                                        <button class="btn btn-warning updateAssets" id="{{$value->id}}">Update</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">There are no data.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $(".delAssetImages").click(function(){
            let Asset_id = $(this).attr("id");
            alert(Asset_id);
            if(confirm('Assets and all related Images will be deleted. Are you sure?')){
                $.ajax({
                    url:"{{url('deleteAsset')}}",
                    method: 'delete',
                    data: {_token:'{{csrf_token()}}' , Asset_id:Asset_id},
                    success:function(response){
                        alert(response.msg); 
                        window.location.reload();
                    }
                })
            }
           
        });
    });
</script>
@stop




