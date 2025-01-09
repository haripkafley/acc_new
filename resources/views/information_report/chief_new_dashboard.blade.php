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
                    <div class="card-header" style="font-family:Product Sans"> Chief Dashboard </div>
                        <div class = "card-body">
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12"><h2>Information </h2></div>
                                        <div class="col-md-2 mt-2" >    
                                            <div class="card_design">
                                                <h3>New IR</h3>
                                                <p>{{@$pending_ir}}</p>
                                            </div>
                                            </div>

                                            <div class="col-md-2 mt-2" >    
                                            <div class="card_design">
                                                <h3>Drop</h3>
                                                <p>{{@$drop_ir}}</p>
                                            </div>
                                            </div>

                                            <div class="col-md-2 mt-2" >    
                                            <div class="card_design">
                                                <h3>Share</h3>
                                                <p>{{@$share_ir}}</p>
                                            </div>
                                            </div>

                                            <div class="col-md-2 mt-2" >    
                                            <div class="card_design">
                                                <h3>Deffer</h3>
                                                <p>{{@$deffer_ir}}</p>
                                            </div>
                                            </div>

                                            <div class="col-md-2 mt-2" >    
                                            <div class="card_design">
                                                <h3>Upgrade</h3>
                                                <p>{{@$upgrade_ir}}</p>
                                            </div>
                                            </div>

                                        

                                        
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-md-12"><h2>Intel Project </h2></div>
                                        <div class="col-md-6 mt-2" >    
                                            <div class="card_design">
                                                <h3>Ongoing</h3>
                                                <p>{{@$intel_project_ongoing}}</p>
                                            </div>
                                            </div>

                                            <div class="col-md-6 mt-2" >    
                                            <div class="card_design">
                                                <h3>Completed</h3>
                                                <p>{{@$intel_project_complete}}</p>
                                            </div>
                                            </div>

                                            
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-md-12"><h2>Tacktical</h2></div>
                                        <div class="col-md-6 mt-2" >    
                                            <div class="card_design">
                                                <h3>Ongoing</h3>
                                                <p>{{@$ti_ongoing}}</p>
                                            </div>
                                            </div>

                                            <div class="col-md-6 mt-2" >    
                                            <div class="card_design">
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