@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Withdrawal Request</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Withdrawal Request</li>
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
                <h3 class="card-title">Withdrawal Request</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  
                 <div class="row">
					<div class="col-sm-3">
                      <div class="form-group">
					    <label>From</label>
						<div class="input-group date" id="reservationdate" data-target-input="nearest">
							<input type="text" class="form-control datetimepicker-input from" data-target="#reservationdate">
							<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
                       
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <!-- select -->
                      <div class="form-group">
					    <label>To</label>
						<div class="input-group date" id="reservationdate2" data-target-input="nearest">
							<input type="text" class="form-control datetimepicker-input to" data-target="#reservationdate2">
							<div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
								<div class="input-group-text"><i class="fa fa-calendar"></i></div>
							</div>
						</div>
                       
                      </div>
                    </div>
					<div class="col-sm-3">
                      <div class="form-group">
						<label></label>
                        <div class="input-group input-group-md">
							<button type="submit" class="datesubmit btn btn-primary">Submit</button>
						</div>
                      </div>
                    </div>
					<div class="col-sm-3">
                      
                    </div>
                    
                  </div>
                  
                   <div class="row">
					<div class="col-sm-3">
                      <div class="form-group">
					    <label>Fisrt Name</label>
						<div class="input-group date">
							<input type="text" class="form-control fname">
						
						</div>
                       
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <!-- select -->
                      <div class="form-group">
					    <label>Last Name</label>
						<div class="input-group date" >
							<input type="text" class="form-control lname" >
						
						
						</div>
                       
                      </div>
                    </div>
					<div class="col-sm-3">
                      <div class="form-group">
						<label></label>
                        <div class="input-group input-group-md">
							<button type="submit" class="namesubmit btn btn-primary">Submit</button>
						</div>
                      </div>
                    </div>
					<div class="col-sm-3">
                      
                    </div>
                    
                  </div>
                  <div class="row">
					<!--<div class="col-sm-6">-->
     <!--                 <div class="form-group">-->
						
     <!--                   <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>-->
     <!--                 </div>-->
     <!--               </div>-->
                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group withdrawlFilter">
                        <label>Filter by Status</label>
                        <select class="form-control" id="withDraw_status">
                            
                          @php
                        
                        $filter = "";
                        if(isset($_REQUEST['filter'])){
                        $filter = $_REQUEST['filter'];
                        }
                        
                        @endphp
                        
                        <option value="">Select Withdraw Status</option>
                        @if($filter == 1)
                        <option value="1" selected>In Progress</option>
                        @else
                        <option value="1">In Progress</option>
                        @endif
                         @if($filter == 5)
                        <option value="5" selected>Into Payment Partner</option>
                          @else
                          <option value="5">Into Payment Partner</option>
                          @endif
                          @if($filter == 4)
                        <option value="4" selected>Withdrawn</option>
                        @else
                         <option value="4">Withdrawn</option>
                        @endif
                        @if($filter == 7)
                        <option value="7" selected>GCASH Payment</option>
                        @else
                         <option value="7">GCASH Payment</option>
                        @endif
                        @if($filter == 8)
                        <option value="8" selected>Direct Bank Deposit</option>
                        @else
                         <option value="8">Direct Bank Deposit</option>
                        @endif
                        </select>
                      </div>
                    </div>
                    
                    
                     <div class="col-sm-6">
                      <!-- Export Withdraw Data -->
                      <button class="btn btn-primary" id="exportData" >Export</button>
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
              <h3 class="card-title">Withdrawal</h3>

              
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                 
                  <tr>
                    <th>Request No.</th>
                    <th>Requested Date</th>
                    <th>Amount</th>
					<th>Status</th>
					<th>Note</th>
					<th>Customer Name</th>
                    
                  </tr>
                </thead>
                <tbody>
                    
                    @if(isset($transaction))

@foreach($transaction as $trans)
@if(isset($trans->customer))
                  <tr>
                    <td><a  href="javascript:;" onclick="Withdraw('{{$trans->id}}')" >{{$trans->txn_no}}</a></td>
                    <td>{{$trans->created_at}}</td>
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
					<td>{{$trans->customer->fname. " " .$trans->customer->lname}}</td>                    
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
          
          
         
     	<div class="modal fade" id="modal-default-Withdraw">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Withdraw History</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="quickForm" action="{{route('editWithdraw')}}" enctype="multipart/form-data" method="post">
                  @csrf
                  
                  <input type="hidden" name="id" id="user_idGet" />
                  
                	<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<div class="form-group">							
								<select name="status" class="form-control">
									<option value="5" >Into Payment Partner</option>
									<option value="4" >Withdrawn</option>
									<option value="7" >GCASH Payment</option>
									<option value="8" >Direct Bank Deposit</option>
								</select>
													  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_role}}</strong>
         </span>
							</div>
						</div>
					</div>
				
				</div>
               
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<input type="text" name="note" value="{{old('note')}}" class="form-control" id="Note" placeholder="Enter Note">
							  <span class="text-danger" role="alert" style="font-size:11px">
          <strong>{{ @$error_note}}</strong>
         </span>
						</div>
					</div>
				
				</div>	
				
			
                <!-- /.card-body -->
                <div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" id="edsubmitBTN" class="btn btn-primary">Submit</button>
					<input type="hidden" value="{{@$errors}}" id="geterrors" />
				</div>
              </form>
            </div>
            
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div> 
      
      
        	<button type="button" class="btn btn-primary d-none" id="openWithdraw" data-toggle="modal" data-target="#modal-default-Withdraw">
							
						     	</button>  
          
          
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
  
  
  
  $('.namesubmit').click(function(e){
      
      e.preventDefault();
      var fname = $('.fname').val();
      var lname = $('.lname').val();
      
      if(fname !="" || lname !=""){
      
      window.open("{{url('withdrawl?fname=')}}"+fname+"&lname="+lname, "_self");
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
