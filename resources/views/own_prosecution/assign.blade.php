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
                                   Assign Official 
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{ route('manage.own.prosecution.chief.assign.official.insert.user') }}">@csrf
                                
                                
                                
                                <input type="hidden" name="id" value="{{@$data->id}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">User</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach(@$users as $value)
                                        <option value="{{@$value->id}}" data-embellishmentid="{{@$value->cid}}" data-eid="{{@$value->id}}" @if(@$data->assign_id_own==@$value->id) selected @endif>{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">CID</label>
                                    <input type="text" name="cid" class="form-control" value="{{@$data->user_details->cid}}" required  id="cid">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">EID</label>
                                    <input type="text" name="eid" class="form-control" value="{{@$data->user_details->eid}}" required  id="eid">
                                </div>

                                

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Instruction</label>
                                    <textarea class="form-control" name="instruction">{{@$data->instruction}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Power of attorney</label>
                                    <input type="file" class="form-control" name="power_of_attorney">
                                </div>

                                @if(@$data->power_of_attorney!="")
                                <div class="form-group">
                                    <a class="btn btn-xs btn-info"
                                    href="{{URL::to('attachment/legal')}}/{{$data->power_of_attorney}}" target="_blank"><i class="fa fa-eye"></i> View attachment</a>
                                    </div>
                                @endif
                                

                                

                                

                                

                               

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
