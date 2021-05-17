@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Coupons List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Coupons List</li>
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
                <h3 class="card-title">Coupons List</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">


                  <div class="row">
                    <div class="col-sm-6">
                      <!-- select -->
                      <div class="form-group">
                        <label>Filter by Status</label>
                        <select class="form-control filter" id="filter_coupon"  required>
                              @php

                        $filter = "";
                        $request_area="";
                        $request_store="" ;
                        if(isset($_REQUEST['status'])){
                        $filter = $_REQUEST['status'];
                        }

                        if(isset($_REQUEST['area'])){
                        $request_area = $_REQUEST['area'];
                        }
                        if(isset($_REQUEST['store'])){
                        $request_store = $_REQUEST['store'];
                        }
                        @endphp
                          <option value="" >Select Coupon Status</option>
                           @if( strtolower($filter) == "all")
                          <option value="all"  selected>All Coupon</option>
                          @else
                          <option value="all" >All Coupon</option>
                          @endif
                          @if( strtolower($filter) == "valid")
                          <option value="Valid"  selected>Valid Coupon</option>
                          @else
                          <option value="Valid" >Valid Coupon</option>
                          @endif
                          @if( strtolower($filter) == "scanned")
                          <option value="Scanned" selected>Scanned Coupon</option>
                          @else
                          <option value="Scanned"  >Scanned Coupon</option>
                          @endif
                        </select>
                      </div>
                        <div class="form-group">
                        <label>Filter by StoreName</label>
                        <select class="form-control filter" id="filter_coupon_store">
                         <option value="" >Select Store Name</option>
                        @if(isset($storeName))
                        @foreach($storeName as $store)
                        @if($request_store == $store->id)
                         <option value="{{$store->id}}" selected >{{$store->name}}</option>
                        @else
                         <option value="{{$store->id}}" >{{$store->name}}</option>
                        @endif
                        @endforeach
                        @endif
                        </select>
                      </div>
                       <div class="form-group">
                        <label>Filter by Area</label>
                        <select class="form-control filter" id="filter_coupon_area">
                         <option value="" >Select Area</option>
                         @if(isset($areas))
                         @foreach($areas as $area)
                         @if($request_area == $area->id)
                         <option value="{{$area->id}}" selected >{{$area->name}}</option>
                         @else
                          <option value="{{$area->id}}" >{{$area->name}}</option>
                         @endif
                         @endforeach
                         @endif
                        </select>
                      </div>
                        <div class="form-group">
                            <label>Filter by Scanned Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">From</span>
                                </div>
                                <input type="text" name="scannedFrom" class="form-control filter" id="scanned-from" value="{{ Request::get('scannedFrom') }}"  required />
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">To</span>
                                </div>
                                <input type="text" name="scannedTo" class="form-control filter" id="scanned-to" value="{{ Request::get('scannedTo') }}"  required/>
                            </div>


                        </div>
                    </div>
					<div class="col-sm-6">
                      <!-- Export Withdraw Data -->
                      <button class="btn btn-primary" style="margin-top:32px;" id="exportData" >Export</button>
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
                        <th>Name</th>
                          <th>Store Name</th>
                    <th>Status</th>
					<th>Scan Date</th>
					<th>Area</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
               @if(isset($coupon))
                   @foreach($coupon as $ecoupon)
                       <tr>
                           <td>{{$ecoupon->coupon_code}}</td>
                           <td>{{$ecoupon->amount}}</td>
                           <td>{{@$ecoupon->customer->fname}} {{@$ecoupon->customer->lname}}</td>
                           <td>{{@$ecoupon->customer->store->name}}</td>
                           <td>{{$ecoupon->status}}</td>
                           <td>{{$ecoupon->redeem}}</td>
                           <td>{{@$ecoupon->customer->location->name}}</td>
                           <td>

                               @if( strtolower($ecoupon->status) == "scanned")
                                   <a class="btn btn-danger btn-sm" href="javascript:void(0);" style="cursor:context-menu;"  >
                                       <i class="fas fa-trash-alt">
                                       </i>
                                       Delete
                                   </a>
                               @else
                                   <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$ecoupon->id}}')">
                                       <i class="fas fa-trash-alt">
                                       </i>
                                       Delete
                                   </a>

                               @endif

                               <form id="delete-user-{{$ecoupon->id}}" action="{{ route('deleteCoupon', $ecoupon->id ) }}" method="POST" style="display: none;">
                                   @csrf
                               </form></td>
                       </tr>
                   @endforeach
			@endif
                </tbody>
              </table>
                @if($coupon->count() > 0)
                    {{   $coupon->appends(Request::only(['status','store','area']))->links()}}
                @endif
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
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@endsection



@push('css')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" />
@endpush

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

  $('.filter').change(function(){

      var filters = {
          status: $('#filter_coupon :selected').val(),
          area: $('#filter_coupon_area :selected').val(),
          store: $('#filter_coupon_store :selected').val(),
          scannedFrom: $('#scanned-from').val(),
          scannedTo: $('#scanned-to').val()
      }

      var filterArray =[],urlParams = "";

      Object.keys(filters).forEach(function(key) {
          console.log(key, filters[key]);
          filterArray.push(key +'=' + filters[key]);
      });

      urlParams = filterArray.join('&');

      window.open("{{url('coupon/couponlist?')}}" + urlParams , "_self");

  });


  $('#exportData').click(function(e){

      e.preventDefault();

      var filters = {
          status: $('#filter_coupon :selected').val(),
          area: $('#filter_coupon_area :selected').val(),
          store: $('#filter_coupon_store :selected').val(),
          scannedFrom: $('#scanned-from').val(),
          scannedTo: $('#scanned-to').val()
      }

      var filterArray =[],urlParams = "";

      Object.keys(filters).forEach(function(key) {
          console.log(key, filters[key]);
          filterArray.push(key +'=' + filters[key]);
      });

      urlParams = filterArray.join('&');




         window.open("{{url('ExportCoupon?filter=')}}"+urlParams, "_self");



  });

  $(function () {
      $('#scanned-from, #scanned-to').datepicker({
          dateFormat: 'yy-mm-dd',
      })
  })

</script>

@endsection


