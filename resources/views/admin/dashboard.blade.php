@extends('admin.master')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            

            <!-- PIE CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col (RIGHT) -->


           <!-- BAR CHART -->
           <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

<!-- ChartJS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- AdminLTE App -->

<script>
  $(function () {
    <?php
        $asset_names = array(); //all asset names which are active
        $asset_names2 = array(); //all asset names which are inactive
        $count = 0;
        $count2 = 0;
        foreach($assets_with_assetType as $assets){
          if($assets->is_active == 1){
            array_push($asset_names,$assets->asset_name);
            $count++;
          }
          else{
            array_push($asset_names2,$assets->asset_name);
            $count2++;
          }
          
        }
    ?>
    // asset count wrt names active ones
    let asset_names_withCount = {};
    <?php 
      $i=0; 
      $cnt2=0;
      while($i!=$count){
      ?>
      asset_names_withCount['<?php echo $asset_names[$i]?>'] = asset_names_withCount['<?php echo $asset_names[$i]?>'] ? asset_names_withCount['<?php echo $asset_names[$i]?>'] + 1 : 1;
     
      <?php 
        $i++;
      }
      ?>  
      // for(var key in asset_names_withCount) {
      //   alert(key + " : " + asset_names_withCount[key]);
      // }
      //active count
  
    // asset count wrt names inactive ones
    let asset_names_withCount2 = {};
    <?php 
      $i=0; 
     
      while($i!=$count2){
      ?>
      asset_names_withCount2['<?php echo $asset_names2[$i]?>'] = asset_names_withCount2['<?php echo $asset_names2[$i]?>'] ? asset_names_withCount2['<?php echo $asset_names2[$i]?>'] + 1 : 1;
      <?php 
        $i++;
      }
      ?>  
      // for(var key in asset_names_withCount2) {
      //   alert(key + " : " + asset_names_withCount2[key]);
      // }
      //inactive count
   



      <?php
            $count = 0;
            $assetType = array();
             foreach($assets_with_assetType as $assets){
               array_push($assetType,$assets->AssetType->asset_type_name);
               $count++;
            }
      ?>
      asset_types = {}
      <?php 
      $i=0; 
     
      while($i!=$count){
      ?>
      asset_types['<?php echo $assetType[$i]?>'] = asset_types['<?php echo $assetType[$i]?>'] ? asset_types['<?php echo $assetType[$i]?>'] + 1 : 1;
      <?php 
        $i++;
      }
      ?>  
      // for(var key in asset_types) {
      //   alert(key + " : " + asset_types[key]);
      // }



    //==============================================================================================================================
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var donutData        = {
      labels: Object.keys(asset_types),
      datasets: [
        {
          data: Object.values(asset_types),
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    //==============================================================================================================================

    //-------------
    //- BAR CHART -
    //-------------
     // Bar chart 
     const bar = document.getElementById('barChart').getContext('2d');
    let bar_data = JSON.parse('{!! json_encode([$asset_active, $asset_inactive]) !!}');
    const barChart = new Chart(bar, {
        type: 'bar',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: bar_data,
                backgroundColor: [
                    'rgba(0, 123, 255, 1)',
                    'rgba(220, 53, 69, 1)',
                ],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend:{
                display: false
            }
        }
    });

   
  })
  </script>
@stop
