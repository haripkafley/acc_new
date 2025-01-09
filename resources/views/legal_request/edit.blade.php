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
                                    Edit Legal Request
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{ route('legal.service.request.page.update.request') }}">@csrf
                                
                                
                                <input type="hidden" name="id" value="{{@$data->id}}">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Service Requested</label>
                                    <select name="service_request" id="service_request" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Legal Review" @if(@$data->service_request=="Legal Review") selected  @endif>Legal Review</option>
                                        <option value="Civil Litigation" @if(@$data->service_request=="Civil Litigation") selected  @endif>Civil Litigation</option>
                                        <option value="Drafting" @if(@$data->service_request=="Drafting") selected  @endif>Drafting</option>
                                        <option value="Others" @if(@$data->service_request=="Others") selected  @endif>Others</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brief Description of Service Requested</label>
                                    <textarea class="form-control" name="description">{{@$data->description}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="date" name="date" value="{{@$data->date}}" class="form-control" required  id="date">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Duration From</label>
                                    <input type="date" name="from_duration" value="{{@$data->from_duration}}" class="form-control" required  id="from_duration">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Duration To</label>
                                    <input type="date" name="to_duration" class="form-control" value="{{@$data->to_duration}}" required  id="to_duration">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Purpose</label>
                                    <textarea class="form-control" name="purpose">{{@$data->purpose}}</textarea>
                                </div>
                               

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Attachment</label>
                                    <input type="file" name="attachment" class="form-control" id="attachment">
                                </div>

                                @if(@$data->attachment)
                                    <div class="form-group">
                                        <a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/legal_request')}}/{{$data->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                Attachment
                                        </a>
                                    </div>
                                @endif
                                
                                

                                

                                

                                

                               
                                @if(@$activities=="")
                                <button type="submit" class="btn btn-primary">Submit</button>
                                @else
                                <button  disabled class="btn btn-danger">You can not update this service</button>
                                @endif
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
