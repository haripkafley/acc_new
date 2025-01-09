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
                                    Add Legal Request
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{ route('legal.service.request.page.insert.request') }}">@csrf
                                
                                
                                

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Service Requested</label>
                                    <select name="service_request" id="service_request" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Legal Review">Legal Review</option>
                                        <option value="Civil Litigation">Civil Litigation</option>
                                        <option value="Drafting">Drafting</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brief Description of Service Requested</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Date</label>
                                    <input type="date" name="date" class="form-control" required  id="date">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Duration From</label>
                                    <input type="date" name="from_duration" class="form-control" required  id="from_duration">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Duration To</label>
                                    <input type="date" name="to_duration" class="form-control" required  id="to_duration">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Purpose</label>
                                    <textarea class="form-control" name="purpose"></textarea>
                                </div>
                               

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Attachment</label>
                                    <input type="file" name="attachment" class="form-control" id="attachment">
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
