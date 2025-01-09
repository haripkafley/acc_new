@extends('layouts.admin')

@section('content')
<link
rel="stylesheet"
type="text/css"
href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"
/>
<style type="text/css">
    .card_design{
        padding: 25px;
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        background-color: lightblue;
    }
</style>

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> My Dashboard </div>
                        <div class = "card-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12"><h2>Information Protocol</h2></div>
                                        <div class="col-md-6 mt-2" >    
                                            <div class="card_design">
                                                <h3>Ongoing</h3>
                                                <p>{{@$ip_ongoing}}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">    
                                            <div class="card_design mt-2">
                                                <h3>Completed</h3>
                                                <p>{{@$ip_completed}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>       

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12"><h2>Tactical Intelligence</h2></div>
                                        <div class="col-md-6 mt-2" >    
                                            <div class="card_design">
                                                <h3>Ongoing</h3>
                                                <p>{{@$ti_ongoing}}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">    
                                            <div class="card_design mt-2">
                                                <h3>Completed</h3>
                                                <p>{{@$ti_completed}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                 
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>



<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>
<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
$(function() {
$("#maintable").dataTable();
});
</script>
@endsection