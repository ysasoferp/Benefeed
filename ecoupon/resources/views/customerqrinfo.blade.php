@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customer Unique ID</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer Unique ID</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
	<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Customer Unique ID</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  
                 
                  <div class="row">
			  
                     <div class="col-sm-6">
                      <!-- Export Withdraw Data -->
                      <button class="btn btn-primary" id="exportData" >Export List</button>
                    </div>
                 
                  </div>
                 
                </div>
                <!-- /.card-body -->
               
              </form>
            </div>
            <!-- /.card -->

            <!-- Form Element sizes -->
 
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- Main content -->
     <section class="content">
		<div class="container-fluid">
			<div class="row">
        
			<div class="col-md-12">
          
          <!-- /.card -->
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Customer QR Data</h3>

              
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                 
                  <tr>
                    <th>Unique ID</th>                    
					<th>Email ID</th>
					<th>Customer Name</th>
                    
                  </tr>
                </thead>
                <tbody>
                    
                    @if(isset($transaction))

@foreach($transaction as $trans)
@if(isset($trans->customer))
                  <tr>
                    <td><a  href="javascript:;" onclick="Withdraw('{{$trans->id}}')" >{{$trans->txn_no}}</a></td>
					<td>{{$trans->amount}}</td>
					@if($trans->txn_type == 1)
                    <td>In Progress</td>
                     @endif
                    @if($trans->txn_type == 5)
                    <td>Into Payment Partner</td>
                     @endif
                    @if($trans->txn_type == 4)
                    <td>Withdrawn</td>
                    @endif
                     @if($trans->txn_type == 7)
                    <td>GCASH Payment</td>
                    @endif
                     @if($trans->txn_type == 8)
                    <td>Direct Bank Deposit</td>
                    @endif
					<td>{{$trans->note}}</td>
					<td>{{$trans->customer->fname}}</td>                    
				  </tr>
@endif
@endforeach
@endif
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
         
        </div>
      </div>
      </div>
    </section>
    <!-- /.content -->
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
@endsection

@section('script')
<script>

function Withdraw(id){
    
   
     document.getElementById('user_idGet').value = id;
    document.getElementById('openWithdraw').click();
   
  }    
  
  
  $('#withDraw_status').change(function(){
      
      var area=$('#withDraw_status :selected').val();
       if(area != ""){
         window.open("{{url('withdrawl?filter=')}}"+area, "_self");
     }else{
         
          window.open("{{url('withdrawl')}}", "_self");
     }
      
      
  });
  
  
  $('.datesubmit').click(function(e){
      
      e.preventDefault();
      var from = $('.from').val();
      var to = $('.to').val();
      
      if(from !="" || to !=""){
      
      window.open("{{url('withdrawl?from=')}}"+from+"&to="+to, "_self");
      }else{
          window.open("{{url('withdrawl')}}", "_self"); 
      }
  })
  
  
   
  $('#exportData').click(function(e){
      
      e.preventDefault();
      
     
      
         var from = $('.from').val();
      var to = $('.to').val();
      var area=$('#withDraw_status :selected').val();
  
     
         window.open("{{url('ExportWithdrawlData?filter=')}}"+area+"&from="+from+"&to="+to, "_self");
     
      
      
  });
  
    
</script>
@endsection
