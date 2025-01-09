@extends('layouts.admin')

@section('content')

    <br>
    <section class="content">
        <div id="casedetailscard" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header" style="font-family:Product Sans">
                            {{-- Dzonkhag List --}}
                            <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Add Task
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" action="{{ route('manage.task.management.legal.chief.insert.task') }}">@csrf
                                
                                
                                

                                <div class="form-group">
                                    <label for="exampleInputEmail1">User</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach(@$users as $value)
                                        <option value="{{@$value->id}}" data-embellishmentid="{{@$value->cid}}" data-eid="{{@$value->id}}">{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" class="form-control" required  id="cid">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input type="text" name="eid" class="form-control" required  id="eid">
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Case</label>
                                    <select class="form-control" name="case_id">
                                        <option value="">Select</option>
                                        <option value="1">Case1</option>
                                        <option value="2">Case2</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Type Of Task</label>
                                    <select name="type_of_task" class="form-control">
                                        <option value="">Select</option>
                                        @foreach(@$task_type as $value)
                                        <option value="{{@$value->id}}">{{@$value->task_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Task</label>
                                    <select name="task" class="form-control">
                                        <option value="">Select</option>
                                        @foreach(@$tasks as $value)
                                        <option value="{{@$value->invtaskID}}">{{@$value->invTaskName}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Task Description</label>
                                    <textarea class="form-control" name="task_description"></textarea>
                                </div>
                                

                                

                                

                                

                               

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
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
