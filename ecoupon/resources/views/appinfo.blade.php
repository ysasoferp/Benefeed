@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Appinfo</li>
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
                <h3 class="card-title">AppInfo</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->





              <form action="{{route('appinfostore')}}" method="post">
                  @csrf
                <div class="card-body">


                  <div class="row">
					<div class="col-sm-6">
                      <!-- select -->
                      <form>
						<div class="form-group">
							<input type="text" name="app_v" class="form-control" id="range" placeholder="Enter App Version ">

							<p>Current App Version:  {{ @$appinfo->app_v}}</p>

						</div>

                    </div>
				  </div>
				  <div class="row">
					<div class="col-sm-6">
                      <!-- select -->

						<div class="form-group">
                        <label>App Link</label>
                        <input type="text" name="applink" class="form-control" id="range" placeholder="Enter App Udated Link ">

                      	<p>Current App Link:  {{ @$appinfo->updated_link}}</p>


                      </div>
                       </div>
                    </div>
                      	<div class="form-group">
                        <label>Heading</label>
                        <input type="text" name="heading" class="form-control" id="range" placeholder="Enter App Udated headnig ">

                      	<p>Current Heading:  {{ @$appinfo->heading}}</p>


                      </div>
                      	<div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" id="range" placeholder="Enter App Udated Link ">

                      	<p>Current Description:  {{ @$appinfo->description}}</p>


                      </div>
                      	<div class="form-group">
                        <label>App Success</label>
                        <input type="text" name="success" class="form-control" id="range" placeholder="Enter App Udated Link ">

                      	<p>Current Success:  {{ @$appinfo->success}}</p>


                      </div>
                      	<div class="form-group">
                        <label>App fail</label>
                        <input type="text" name="fail" class="form-control" id="range" placeholder="Enter App Udated Link ">

                      	<p>Current Fail notice:  {{ @$appinfo->fail}}</p>


                      </div>


					<button type="submit" class="btn btn-primary">Send</button>

                  </div>
                  </form>
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
<!-- jquery-validation -->
<script src="../../public/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../public/plugins/jquery-validation/additional-methods.min.js"></script>
<script>
$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      alert( "Form successful submitted!" );
    }
  });
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      username: {
        required: true,

      },
      firstname: {
        required: true,
      },
	  lastname: {
        required: true,
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      username: {
        required: "Please enter user name"

      },
	  firstname: {
        required: "Please enter first name"

      },
	  lastname: {
        required: "Please enter last name"

      }

    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
@endsection
