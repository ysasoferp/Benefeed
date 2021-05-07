@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pages</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pages</li>
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
                <h3 class="card-title">Pages</h3>


                @if(session()->has('msg'))
          <span class="alert alert-success ml-4">{{session()->get('msg')}}</span>
          @endif

              </div>
              <!-- /.card-header -->
              <!-- form start -->





              <form action="{{route('Storepages')}}" method="post">
                  @csrf
                <div class="card-body">


                  <div class="row">
					<div class="col-sm-6">
                      <!-- select -->
                      <form>
						<div class="form-group">
                        <label>About Us Page</label>
                        <textarea class="form-control" rows="3" name="about" placeholder="">{{ @$pages->about}}</textarea>
                     </div>

						<div class="form-group">
                        <label>Privacy Policy Page</label>
                        <textarea class="form-control" rows="3" name="privacy" placeholder="">{{ @$pages->privacy}}</textarea>
                      	</div>

                      	<div class="form-group">
                        <label>Footer Page</label>
                        <textarea class="form-control" rows="3" name="footer" placeholder="">{{ @$pages->footer}}</textarea>
                      	</div>



                        	<div class="form-group">
                        <label>FAQ Page</label>
                        <textarea class="form-control" rows="3" name="faq" placeholder="">{{ @$pages->faq}}</textarea>
                      	</div>

						<div class="form-group">
                        <h3 class="m-2">Contact Us Page</h3>
                        <lable for="email">Email:</lable>
                        <input class="form-control mb-3" rows="3" name="email" placeholder="Enter Contact Email"  value="{{ @$pages->email}}" />

                        <lable for="phone">Phone Number:</lable>
                        <input class="form-control" rows="3" name="phone" placeholder=" Enter Contact Phone"  value="{{ @$pages->phone}}" />
                        </div>



                    </div>
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




  setTimeout(function(){

       $('.alert').fadeOut('slow');

   }, 3000);


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
