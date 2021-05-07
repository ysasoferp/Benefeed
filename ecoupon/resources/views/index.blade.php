@extends('layouts.app')
@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
            
            
            ['Product Name', 'Quantity'],

                @php
                foreach($location as $loc) {
                    echo "['".$loc->name."', ".$loc->total_coupon."],";
                }
                @endphp
         
        ]);

        var options = {
          title: 'Total Coupon Scaned'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                   @if(isset($costumer)) 
                   
                   {{count($costumer)}}
                    
                    @endif
                </h3>

                <p>Total No of Customers</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{count($tcoupon)}}</h3>

                <p>Total Coupon {{date("F")}}</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          
         
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <!--<section class="col-lg-7 connectedSortable">-->
            <!-- Custom tabs (Charts with tabs)-->
          <!--  <div class="card">-->
          <!--    <div class="card-header">-->
          <!--      <h3 class="card-title">-->
          <!--        <i class="fas fa-chart-pie mr-1"></i>-->
          <!--        Sales-->
          <!--      </h3>-->
          <!--      <div class="card-tools">-->
          <!--        <ul class="nav nav-pills ml-auto">-->
          <!--          <li class="nav-item">-->
          <!--            <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>-->
          <!--          </li>-->
          <!--          <li class="nav-item">-->
          <!--            <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>-->
          <!--          </li>-->
          <!--        </ul>-->
          <!--      </div>-->
          <!--    </div><!-- /.card-header -->
          <!--    <div class="card-body">-->
          <!--      <div class="tab-content p-0">-->
                  <!-- Morris chart - Sales -->
          <!--        <div class="chart tab-pane active" id="revenue-chart"-->
          <!--             style="position: relative; height: 300px;">-->
          <!--            <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>-->
          <!--         </div>-->
          <!--        <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">-->
          <!--          <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>-->
          <!--        </div>-->
          <!--      </div>-->
          <!--    </div><!-- /.card-body -->
          <!--  </div>-->
            <!-- /.card -->          

           
          <!--</section>-->
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-12 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-map-marker-alt mr-1"></i>
                  Coupon Scaned Area
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                  <!--<button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                    <i class="far fa-calendar-alt"></i>
                  </button>-->
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <div class="card-body">
               
          <div id="piechart" class="col-lg-12" style="height:400px"></div>
                </div>
              <!-- /.card-body-->
            </div>
            <!-- /.card -->

          </section>
	<section class="col-lg-12">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
   
          <h3 class="card-title">RECENT CUSTOMER REGISTERED</h3>         
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      
                      <th style="width: 18%">
                          Name
                      </th>
                      <th style="width: 18%">
                          Date
                      </th>
                      <th style="width: 18%">
                          Phone No
                      </th>
					  <th style="width: 18%">
                         Location
                      </th>
                      
                      <th style="width: 28%" class="text-center">
						 Settings	
                      </th>
                  </tr>
              </thead>
              <tbody>
                  
                  @if(isset($costumer))
                  @foreach($costumer as $key => $costm)
                  @if($key < 11)
                  <tr>
                      <td>
                         {{ $costm->fname. " " . $costm->lname}}
						 <small>
                              {{$costm->email}}
                          </small>
                      </td>
                      <td>
                          <a>
                              {{ $costm->created_at}}
                          </a>
                          <br/>
                          <small>
                              Joined
                          </small>
                      </td>
                      <td>
                          <a>
                               {{ $costm->phone}}
                          </a>
                          <br/>
                          <small>
                              Phone No
                          </small>
                      </td>
                      <td class="project_progress">
                          <a>
                               {{ @$costm->location->name}}
                          </a>
                          <br/>
                          <small>
                              Location
                          </small>
                      </td>
                      
                  <td class="project-actions">
                          
                         <a class="btn btn-info btn-sm" href="javascript:;" onclick="confirmEdit('{{$costm->id}}')">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
										  <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$costm->id}}')">
                              <i class="fas fa-trash-alt">
                              </i>
                              Delete
                          </a>
        <form id="delete-user-{{$costm->id}}" action="{{ route('deleteCustom', $costm->id ) }}" method="POST" style="display: none;">
        @csrf
      </form>
                      </td>  
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






    </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
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


@section('script')

<script>
    
    function confirmDelete(id){
    let choice = confirm("Are You sure, You want to Delete this User ?")
    if(choice){
      document.getElementById('delete-user-'+id).submit();
    }
  }
  
  function confirmEdit(id){
   $.get("{{url('custom/edit/')}}/"+id, function(data, status){
       
    $('#idGet').val(data.id);
   $('#F_name').text(data.fname);
   $('#L_name').text(data.lname);
   $('#Email').text(data.email);
   $('#identityImage').attr("src", data.identity);
   $('#Phone_number').text(data.phone);
   $('#ModelEdit').click(); 

    
  });
  
  }
  
</script>

@endsection



