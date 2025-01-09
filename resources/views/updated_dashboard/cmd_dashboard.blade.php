@extends('layouts.admin')

@section('content')

    <br>
    <section class="content">
        <div id="casedetailscard" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        
                        <div class="card-body">
                        Welcome {{auth()->user()->name}}
                       </div>

                       <div class="row" style="padding: 25px;">

                        <div class="col-md-6">
                            <h2>Case Dashboard</h2>
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Information</label>
                                        <select class="form-control">
                                            <option>Select</option>
                                            <option>All</option>
                                            <option>No Of Cases Assgined</option>
                                            <option>No Of Cases Investigated</option>
                                        </select>
                                    </div>
                                

                                
                                    <div class="col-md-6">
                                        <label>View</label>
                                        <select class="form-control">
                                            <option>Year Wise</option>
                                            <option>Monthly Wise</option>
                                         </select>
                                    </div>
                                

                                
                                    <div class="col-md-6">
                                        <label>Year</label>
                                        <select class="form-control">
                                            <option>2022</option>
                                            <option>2023</option>
                                            <option>2024</option>
                                         </select>
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col-md-12">
                                    <table id  = "maintable" class="table table-striped " >
                                    <thead class="thead-dark">
                                        <th>Year</th>
                                        <th>No. of Cases</th>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>2024</td>
                                            <td>3</td>
                                         </tr>
                                    </tbody>
                                    
                                </table>
                                </div>
                            </div>

                            <div class="row" style="margin-top:25px">
                                <div class="col-md-6">
                                    <div id="barchart_material" style="width: 900px; height: 500px;"></div>
                                </div>
                            </div>

                        </div>
                    </div>
            </div>


           




        </div>
    </section>


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
  
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
         ['No Of Cases', 'No Of Cases', { role: 'style' }],
         ['2022',2, '#b87333'],            // RGB value
         ['2023', 1, 'silver'],            // English color name
         ['2024', 1, 'gold'],
      ]);
   
        
  
        var chart = new google.charts.Bar(document.getElementById('barchart_material'));
  
        chart.draw(data, google.charts.Bar);
      }
    </script>    



@endsection
