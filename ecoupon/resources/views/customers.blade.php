@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customers</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customers</li>
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
                <h3 class="card-title">Customers</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="withdrawlFilter">
                                <form class="form-inline">
                                <!-- select -->
                                    <label for="filter_area">Filter by: Area</label>
                                    <select class="form-control mr-2" id="filter_area" style="width:250px;">
                                        <option value="">Select Area</option>
                                        @php

                                            $filter = "";
                                            if(isset($_REQUEST['filter'])){
                                            $filter = $_REQUEST['filter'];
                                            }

                                        @endphp

                                        @if(isset($location))

                                            @foreach($location as $loc )
                                                @if($filter == $loc->id)
                                                    <option value="{{$loc->id}}" selected>{{$loc->name}}</option>
                                                @else
                                                    <option value="{{$loc->id}}">{{$loc->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>

                                    <label for="status">Status</label>
                                    <select name="status" class="form-control mr-3" id="status"  style="width:250px;">
                                        <option value="" {{ $status =="" ?"selected" : "" }}>All</option>
                                        <option value="1" {{ $status ==1 ?"selected" : "" }}>Approved</option>
                                        <option value="3" {{ $status ==3 ?"selected" : "" }}>Disapproved</option>
                                        <option value="4" {{ $status ==4 ?"selected" : "" }}>Lock Profile</option>
                                        <option value="5" {{ $status ==5 ?"selected" : "" }}>Unlock Profile</option>
                                    </select>
                                <button class="btn btn-primary" id="exportData">Export</button>
                                </form>
                </div>
                        </div>
                <!-- /.card-body -->
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
              <h3 class="card-title">Cusomers List</h3>

                       @if(session()->has('msgError'))
          <span class="alert alert-danger ml-4">{{session('msgError')}}</span>
          @endif
                @if(session()->has('msg'))
          <span class="alert alert-success ml-4">{{session('msg')}}</span>
          @endif
            </div>
            <div class="card-body p-0">
              <table class="table">
                <thead>
                  <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Store Name</th>
                  	<th>Area</th>
					<th>Contact No</th>
					<th>Wallet</th>
					<th>Status</th>
					<th>Action</th>

                  </tr>
                </thead>
                <tbody>

@if(isset($customers))
@foreach($customers as $custm)
                  <tr>
                    <td>{{@$custm->email}}</td>
                    <td>{{@$custm->fname. " " . $custm->lname}}</td>
                    <td>{{@$custm->store->name}}</td>
					<td>{{@$custm->location->name}}</td>
					<td>{{@$custm->phone}}</td>
					<td>{{@$custm->wallet}}</td>
					@if($custm->status ==1)
					<td class="text-success">Approved</td>
					@elseif($custm->status ==0)
					<td class="text-secondary">New Customer</td>
					@else
				    <td class="text-danger">Disapproved</td>
					@endif
					<td class="project-actions">

                         <a class="btn btn-info btn-sm" href="javascript:;" onclick="confirmEdit('{{$custm->id}}')">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
										  <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$custm->id}}')">
                              <i class="fas fa-trash-alt">
                              </i>
                              Delete
                          </a>
        <form id="delete-user-{{$custm->id}}" action="{{ route('deleteCustom', $custm->id ) }}" method="POST" style="display: none;">
        @csrf
      </form>
                      </td>
				  </tr>

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
	  <div class="row">

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="card-tools">
                  <ul class="pagination pagination-sm float-left">
                  {{$customers->appends(Request::only(['filter','status']))->links()}}
                  </ul>
                </div>
              </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->


<!-- Button trigger modal -->
<a class="btn btn-primary d-none" id="ModelEdit" data-toggle="modal" data-target="#CustomerModel" ></a>


<!-- Modal -->
<div class="modal fade" id="CustomerModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Customer </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('activateCustom')}}" method="post">
          @csrf
      <div class="modal-body editcustModel">

      <img src=""  id="identityImage" class="img-thumbnail p-3"  style="max-height:200px"/>
      <div><h4> First Name: </h4><span id="F_name" ></span></div>
      <div><h4> Last Name: </h4><span id="L_name" ></span></div>
      <div><h4> Email: </h4><span id="Email" ></span></div>
      <div><h4> Phone Number: </h4><span id="Phone_number" ></span></div>


     <div><label class="statuslabel">Status</label>

     <select name="status">
         <option value="1" >Approved</option>
         <option value="3">Disapproved</option>
         <option value="4" >Lock Profile</option>
         <option value="5" >Unlock Profile</option>
     </select></div>


      <div><label class="statuslabel">Store Name</label>

     <select name="storeName" id="storeName">
         @if(isset($stores))
         @foreach($stores as $store )

         <option value="{{$store->id}}" >{{$store->name}}</option>
        @endforeach
        @endif
     </select></div>


     <input type="hidden" id="idGet" name="id" />


      </div>
      <div class="modal-footer">
        <a class="btn btn-secondary" data-dismiss="modal">Close</a>
        <input type="submit" class="btn btn-primary" value="Save changes">

      </div>
      </form>
    </div>

  </div>
</div>








          </div>
          <!-- /.col -->
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
        setTimeout(function () {

            $('.alert').fadeOut('slow');

        }, 3000);


        function confirmDelete(id) {
            let choice = confirm("Are You sure, You want to Delete this User ?")
            if (choice) {
                document.getElementById('delete-user-' + id).submit();
            }
        }

        function confirmEdit(id) {
            $.get("{{url('custom/edit/')}}/" + id, function (data, status) {

                $('#idGet').val(data.id);
                $('#F_name').text(data.fname);
                $('#L_name').text(data.lname);
                $('#Email').text(data.email);
                $('#identityImage').attr("src", data.identity);
                $('#Phone_number').text(data.phone);
                $('#ModelEdit').click();


            });

        }


        $('#filter_area,#status').change(function () {

            var area = $('#filter_area :selected').val();
            var status = $('#status :selected').val();
            if (area != "" || status != "") {
                window.open("{{url('customers?filter=')}}" + area +"&status="+status, "_self");
            } else {

                window.open("{{url('customers')}}", "_self");
            }
        });


        $('#exportData').click(function (e) {

            e.preventDefault();
            var area = $('#filter_area :selected').val();
            var status = $('#status :selected').val();
            window.open(`{{url('ExportQR')}}?filter=${area}&status=${status}`);

        });


    </script>

@endsection

