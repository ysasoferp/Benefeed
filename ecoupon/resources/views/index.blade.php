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
                foreach($couponsCountByLocation as $loc) {
                    echo "['".$loc->name."', ".$loc->coupon_total_count."],";
                }
                @endphp

        ]);

        var options = {
          title: 'Total Coupon Scaned',
            titleTextStyle: {
              color: 'blue',
                fontWeight: 'bold',
                fontSize:21
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);

          var withDrawalData = google.visualization.arrayToDataTable([


              ['Withdrawal Status', 'Quantity'],

              @php
                  foreach($withdrawalList as $w) {
                      echo "['".$w[0]."', ".$w[1]."],";
                  }
              @endphp
          ]);

          var WithdrawalStatusChartOptions = {
              title: 'Withdrawal Status',
              legend:'bottom',
              titleTextStyle: {
                  color: 'blue',
                  fontWeight: 'bold',
                  fontSize:21
              }
          };

          var WithdrawalStatusChart = new google.visualization.PieChart(document.getElementById('widrawal_status_chart'));

          WithdrawalStatusChart.draw(withDrawalData, WithdrawalStatusChartOptions);



          var data = google.visualization.arrayToDataTable([
              ['Store', 'Coupon Scanned', { role: 'style' }],
                  @php
                      foreach($top5ScannedStore as $store) {
                          echo "['".addslashes($store->name)."', ".$store->coupon_total_count.",'blue'],";
                      }
                  @endphp
          ]);
          var options = {
              title: 'Top 5 Stores Coupon Scanned',
              titleTextStyle: {
                  fontWeight: 'bold',
                  fontSize:21
              }
          };


          var barChart = new google.visualization.BarChart(document.getElementById('barchart'));

          barChart.draw(data, options);
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
          <div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                   @if(isset($totalCustomers))
                        {{$totalCustomers}}
                    @endif
                </h3>

                <p>Total No of Customers</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>

            </div>
          </div>
            <div class="col-lg-3 col-3">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>
                            @if(isset($totalNewCustomers))

                                {{$totalNewCustomers}}

                            @endif
                        </h3>

                        <p>Total No of New Customers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person" onClick="window.location='{{ url('customers?status=0') }}'"></i>
                    </div>

                </div>
            </div>
          <!-- ./col -->
          <div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="total-coupon">{{$tcoupon}}</h3>

                <p>Total Coupon <span id="total-coupon-range">{{date("F")}}</span></p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>

            </div>
          </div>
            <div class="col-lg-3 col-3">
                <!-- small box -->
                <div class="small-box" style="background-color: #ffc000;color: #fff">
                    <div class="inner">
                        <h3>P<span id="total-coupon-value">{{$tcouponAmount}}</span></h3>

                        <p>Total Coupon Value(<span id="total-coupon-value-range">{{date("F")}}</span>)</p>
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

            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-12 connectedSortable">

                <div class="row">
                    <div class="col-lg-6">
                        <div id="widrawal_status_chart" style="height:400px"></div>
                    </div>
                    <div class="col-lg-6" style="background-color: #fff">
                        <div style="position: absolute;z-index: 1000;left: 25px;top: 100px;">
                            <button class="total-scanned-range btn btn-sm btn-warning" style="display: none;"
                                    data-time_span="thisMonth">This Month
                            </button>
                            <button class="total-scanned-range btn btn-sm btn-warning" data-time_span="previousMonth">
                                Previous Month
                            </button>
                            <button class="total-scanned-range btn btn-sm btn-warning" data-time_span="last6Months">Last
                                6 Months
                            </button>
                            <button class="total-scanned-range btn btn-sm btn-warning" data-time_span="thisYear">This
                                Year
                            </button>
                        </div>
                        <div id="piechart" style="height:400px;margin-left: 50px"></div>
                    </div>
                </div>

            </section>
            <section class="col-lg-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div id="barchart" style="height:400px"></div>
                    </div>
                    <div class="col-sm-6" style="background-color: #fff">
                        <div style=" display: flex;
                justify-content: center;
                align-items: center;">
                            <div
                                style="background-color: #316395;color: #fff;height: 100px;margin-top: 55px;text-align: center;width:400px">
                                <div style="font-size: 50px;font-weight: bold;">
                                    P {{ number_format($tValueNotScanned)}}</div>
                                <div style="font-size: 14px">Total Coupon Value not yet scanned</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


          <!-- right col -->
        </div>
          <div class="row mt-3">
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

                              @if(isset($recentCustomer))
                                  @foreach($recentCustomer as $key => $costm)
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

                                                  <a class="btn btn-info btn-sm" href="javascript:;"
                                                     onclick="confirmEdit('{{$costm->id}}')">
                                                      <i class="fas fa-pencil-alt">
                                                      </i>
                                                      Edit
                                                  </a>
                                                  <a class="btn btn-danger btn-sm" href="javascript:;"
                                                     onclick="confirmDelete('{{$costm->id}}')">
                                                      <i class="fas fa-trash-alt">
                                                      </i>
                                                      Delete
                                                  </a>
                                                  <form id="delete-user-{{$costm->id}}"
                                                        action="{{ route('deleteCustom', $costm->id ) }}" method="POST"
                                                        style="display: none;">
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

              </section>
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

<!-- ./wrapper -->
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

@endsection


@section('script')

    <script>

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
    </script>

@endsection

@push('css')
    <style type="text/css">
        .total-scanned-range {
            display:block;
            background-color: #f2884a;
            margin-bottom:10px;
            color:#fff;
        }
    </style>
@endpush

@push('js')
    <script>
        $(function () {
            $('.total-scanned-range').click(function (e) {
                var $this = $(this), time_span = $this.data('time_span')
                $.get('/coupon-scanned-chart-data?time_span=' + time_span, function (response) {
                    if(response.success) {
                        $('#total-coupon').html(response.tcoupon)
                        $('#total-coupon-value').html(response.tcouponAmount)
                        $('#total-coupon-range').html(response.range)
                        $('#total-coupon-value-range').html(response.range)


                        var data = google.visualization.arrayToDataTable(response.graphData);

                        var options = {
                            title: 'Total Coupon Scaned',
                            titleTextStyle: {
                                color: 'blue',
                                fontWeight: 'bold',
                                fontSize:21
                            }
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                        chart.draw(data, options);
                    }
                })
            })
        })
    </script>
@endpush



