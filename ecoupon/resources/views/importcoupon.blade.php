@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Coupon</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Coupon</li>
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
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Import Coupons</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('importCouponStore')}}" method="post" enctype="multipart/form-data">
                  @csrf
                <div class="card-body">
                   <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    
					<div class="input-group">
							<div class="custom-file">
							<input type="file" class="form-control mb-2"  name="upload_file">
					
						</div>
					</div>
                  </div>
                 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
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
              <h3 class="card-title">All Coupons</h3>
   @if(session()->has('msgError'))
          <span class="alert alert-danger ml-4">{{session('msgError')}}</span>
          @endif
                @if(session()->has('msg'))
          <span class="alert alert-success ml-4">{{session('msg')}}</span>
          @endif
                              </a>
       
              
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th>Coupon Serial Number</th>
                    <th>Amount</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

@if(isset($coupon))
@foreach($coupon as $ecoupon)

                  <tr>
                    <td>{{$ecoupon->coupon_code}}</td>
                    <td>{{$ecoupon->amount}}</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="javascript:;" onclick="confirmDelete('{{$ecoupon->id}}')" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        
                        <form id="delete-user-{{$ecoupon->id}}" action="{{ route('deleteCoupon', $ecoupon->id ) }}" method="POST" style="display: none;">
        @csrf
      </form>  
                      </div>
                    </td>
				  </tr>
				  
@endforeach
@else
   <tr colspen>
        
        <td colspan="2"> Record not Found!  </td>
             
   </tr>
@endif


				</tbody>
              </table>
              {{$coupon->links()}}
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
<script type="text/javascript">
  setTimeout(function(){ 
       
       $('.alert').fadeOut('slow');
       
   }, 3000); 
     
    
    
    
    


function confirmDelete(id){
    let choice = confirm("Are You sure, You want to Delete this User ?")
    if(choice){
      document.getElementById('delete-user-'+id).submit();
    }
  }
  
  
</script>

@endsection





