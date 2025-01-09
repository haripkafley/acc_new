@extends('layouts.admin')

@section('content')
<link
rel="stylesheet"
type="text/css"
href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"
/>

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card-body">
                    <a href="{{route('sensitization.action.taken.report',@$data->action_id)}}" class="btn btn-primary" style="float: right;">
                        Back
                    </a>
                </div>
                        <form action="{{route('sensitization.action.taken.report.action.for.yes.redirect')}}" method="POST" id="action_form">
                        @csrf
                        <input type="hidden" name="redirect" value="N">
                        <input type="hidden" name="id" value="{{@$id}}">
                        <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Action Taken? <span style="font-weight: bold; color: red;">*</span></label>
                                    <br>
                                        <div class="form-check form-check-inline">
                                          
                                          <input class="form-check-input action_taken" type="radio" id="action_taken" name="action_taken" checked value="Y">
                                          <label class="form-check-label" for="genderInput">Yes</label>
                                          
                                        </div>

                                        <div class="form-check form-check-inline">
                                          
                                          <input class="form-check-input action_taken" type="radio" id="action_taken"  name="action_taken" value="N">
                                          <label class="form-check-label" for="genderInput">No</label>
                                          
                                        </div>
                                </div>
                        </div>
                    </form>
                
                
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Action Taken Report </div>
                        
                    <div id="casedetailscard" class="container-fluid">
                        <form method="post" action="{{route('sensitization.action.taken.report.edit.view.yes.action.update')}}" enctype="multipart/form-data">
                        
                        @csrf
                        <input type="hidden" name="action_id" value="{{@$id}}">
                        <div class="row">






                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Letter No<span style="font-weight: bold; color: red;">*</span></label>
                                        <input class="form-control"  type="text" value="{{@$data->letter_no}}" name="letter_no" required>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Letter Date<span style="font-weight: bold; color: red;">*</span></label>
                                        <input class="form-control"  type="date" value="{{@$data->letter_date}}" name="letter_date" required>
                                </div>
                            </div>


                            

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Attachment<span style="font-weight: bold; color: red;">*</span></label>
                                        <input class="form-control"  type="file" name="attach_letter" >
                                </div>
                            </div>

                            @if(@$data->attach_letter!="")
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <a class="btn btn-xs btn-info" href="{{URL::to('attachment/action')}}/{{@$data->attach_letter}}" target="_blank"><i class="fa fa-eye"></i>View  </a>
                                </div>
                            </div>
                            @endif


                      


                           


                           


                           

                            

                            <div class="col-sm-12"></div>
                            <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
                        </div>
                    </form>
                </div>




                         
                        <div class = "card-body">
                            <a href="{{route('sensitization.action.taken.report.crud.add.view',@$id)}}" class="btn btn-primary" style="float: right;margin-bottom: 10px;">
                                    + Add Action
                                </a>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Entity Type</th>
                                        <th>Name</th>
                                        <th>Action Taken</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                       @if(@$persons->isNotEmpty())
                                       @foreach(@$persons as $value)
                                       <tr>
                                           <td>{{@$value->type}}</td>
                                           <td>{{@$value->name}}</td>
                                           <td>{{@$value->action_taken}}</td>
                                           <td>
                                               <a href="{{route('sensitization.action.taken.report.crud.edit.view',@$value->id)}}" class="bnt btn-info">Edit/View</a>
                                               <a href="{{route('sensitization.action.taken.report.crud.delete.view',@$value->id)}}" class="bnt btn-danger">Delete</a>
                                           </td>
                                           
                                        </tr>
                                       @endforeach
                                       @endif            
                                </tbody>
                            </table>
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


<script type="text/javascript">
    $('.action_taken').on('change',function(){
        var action = $(this).val();
        if(action=="N")
        {
            $('#action_form').submit();
        }
    });
</script>

@endsection