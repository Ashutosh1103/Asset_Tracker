@extends('admin.master')
@section('content')

  <!-- Google Font: Source Sans Pro -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
<style>
    #imgasset{
        display: inline;
    }
</style>


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
                <table id="example2" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Asset Code</th>
                            <th>Asset Name</th>
                            <th>Asset Type</th>
                            <th>Asset Image</th>
                            <th>Asset Active or Inactive</th>
                            <th width="300px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                   
                        @if(!empty($data) && $data->count())
                            @foreach($data as $value)
                                <tr>
                                    <td>{{ $value->asset_code }}</td>
                                    <td>{{ $value->asset_name }}</td>
                                    <td>{{ $value->AssetType->asset_type_name }}</td>
                                    <td style="width:26%">
                                        
                                        @foreach($images as $image)
                                            @if($value->id == $image->asset_id)
                                                <button  class="btn btn-danger delAssetImages" id="{{$image->id}}">Delete</button>
                                                <img id='imgasset' src="{{asset('/uploads/'.$image->images)}}" width="100" height="100">
                                            @endif
                                        @endforeach
                                    </td>
                                    @if($value->is_active==1)
                                        <td>Active</td>
                                    @else
                                        <td>InActive</td>
                                    @endif
                                    
                                    <td>
                                        <button  class="btn btn-danger delAssets" id="{{$value->id}}">Delete</button>
                                        <a class="btn btn-warning" href="{{route('UpdateAsset',['id'=>$value->id])}}">Update</a>
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
        $(".delAssets").click(function(){
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
        $(".delAssetImages").click(function(){
            let image_id = $(this).attr("id");
            alert(image_id);
            if(confirm('This Image will be deleted. Are you sure?')){
                $.ajax({
                    url:"{{url('deleteAssetImage')}}",
                    method: 'delete',
                    data: {_token:'{{csrf_token()}}' , image_id:image_id},
                    success:function(response){
                        alert(response.msg); 
                        window.location.reload();
                    }
                })
            }
           
        });
    });
</script>


<!-- jQuery -->
<script src="{{asset('/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<!-- Page specific script -->
<script>
  $(function () {
    $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["csv"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
  
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


@stop




