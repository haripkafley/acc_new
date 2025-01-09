@extends('layouts.admin')

@section('content')
<section class="content">
        <div id="casedetailscard" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header" style="font-family:Product Sans">
                            {{-- Dzonkhag List --}}
                            <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Edit Task
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    <a href="{{route('manage.task-manage-case')}}" style="float:right;" class="btn btn-primary">Back</a>
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" action="{{ route('manage.task-manage-case.update.task') }}">@csrf
                                
                                
                                
                                <input type="hidden" name="id" value="{{@$data->id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">User</label>
                                    <select name="user_id" disabled id="user_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach(@$users as $value)
                                        <option value="{{@$value->id}}" @if(@$data->user_id==@$value->id) selected @endif disabled data-cid="{{@$value->cid}}"  data-eid="{{@$value->id}}">{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" class="form-control" value="{{@$data->user_details->cid}}" readonly  id="cid">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input type="text" name="eid" class="form-control" value="{{@$data->user_details->eid}}" readonly  id="eid">
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Case</label>
                                    <select class="form-control" @if(@$data->status!="AA") disabled @endif name="case_id">
                                        <option value="">Select</option>
                                        <option value="1" @if(@$data->case_id=="1") selected @endif>Case1</option>
                                        <option value="2" @if(@$data->case_id=="2") selected @endif>Case2</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Type Of Task</label>
                                    <select name="type_of_task" @if(@$data->status!="AA") disabled @endif class="form-control">
                                        <option value="">Select</option>
                                        @foreach(@$task_type as $value)
                                        <option value="{{@$value->id}}" @if(@$data->type_of_task==@$value->id) selected @endif>{{@$value->task_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Task</label>
                                    <select name="task" @if(@$data->status!="AA") disabled @endif class="form-control">
                                        <option value="">Select</option>
                                        @foreach(@$tasks as $value)
                                        <option value="{{@$value->invtaskID}}" @if(@$data->task==@$value->invtaskID) selected @endif>{{@$value->invTaskName}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Task Description</label>
                                    <textarea class="form-control" @if(@$data->status!="AA") disabled @endif name="task_description">{{@$data->task_description}}</textarea>
                                </div>
                                

                                

                                

                                

                               
                                @if(@$data->status=="AA")  
                                <button type="submit" class="btn btn-primary">Submit</button>
                                @endif
                            </form>
                        </div>

                        @if(@$data->status!="AA")
                
                        <div class="card-body">
                            <p><b>Status : </b> {{@$data->status}}</p>
                            <p><b>Remarks : </b> {{@$data->remarks}}</p>
                            <p><b>Status Update Date : </b> {{@$data->status_update_date}}</p>

                        </div>

                        @endif
                    </div>
                </div>
            </div>





          


        </div>
    </section>


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#user_id').on('change',function(e){
      
      e.preventDefault();
      var id = $(this).val();
      
      $.ajax({
        url:'{{route('manage.task-manage-case.fetch.user')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#cid').val(data.users.cid);
          $('#eid').val(data.users.eid);
          
        }
      })
    
   })
  })
</script>





@endsection
