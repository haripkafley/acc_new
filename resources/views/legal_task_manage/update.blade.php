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
                                    Update Task Status
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" action="{{ route('manage.task.management.legal.get.case.update.task.post') }}">@csrf
                                
                                
                                

                                <input type="hidden" name="id" value="{{@$data->id}}">

                                 

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Type Of Task : <span style="font-weight:normal;">{{ $data->task_type->task_name }}</span></label>
                                    
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Task : <span style="font-weight:normal;">{{ $data->task_name->invTaskName }}</span></label>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Task Description : <p style="font-weight:normal;">{{ $data->task_description}}</p></label>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Assignment Date : <span style="font-weight:normal;">{{ $data->date_assignment }}</span></label>
                                </div>

                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">Select</option>
                                        <option value="Ongoing" @if(@$data->status=="Ongoing") selected @endif>Ongoing</option>
                                        <option value="Deffered" @if(@$data->status=="Deffered") selected @endif>Deffered</option>
                                        <option value="Completed" @if(@$data->status=="Completed") selected @endif>Completed</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea class="form-control" name="remarks"> {{@$data->remarks}} </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status Date</label>
                                    <input type="date" name="status_update_date" value="{{@$data->status_update_date}}" class="form-control" required  id="status_update_date">
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
