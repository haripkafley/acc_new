@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
         <li class="nav-item">
          <a class="nav-link" href="{{route('complaint.registration.edit.view',['id'=>@$id])}}">Complaint Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{route('allegation.offence.management',['id'=>@$id])}}">Allegations/Offences</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('attachment.view.complaint',['id'=>@$id])}}">Attachment Details</a>
        </li>


        <li class="nav-item">
          <a class="nav-link " href="{{route('person.involved.complaint',['id'=>@$id])}}" >Person Involved</a>
        </li>

        
        
        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.financial-implication-details.page',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.social.implication',['id'=>@$id])}}">Social Implication</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('link.case.complaint',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>


        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Linked Case List </div>

                        <div class = "card-body">
                         
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Date</th>
                                        <th>Complaint Reg. No.</th>
                                        <th>Complaint Title</th>
                                        <th>Mode</th>
                                        <th>Type</th>
                                        <th>Link Status</th>  
                                        <th>Action</th>          
                                    </tr>
                                </thead>
                                <tbody>

                                    @if(@$person_previous_case->isNotEmpty())
                                    @foreach(@$person_previous_case as $value)
                                    @if(!in_array($value->complaintID,@$case_already_register))
                                    <tr>
                                    <td>{{@$value->updated_at}}</td>
                                    <td>{{@$value->complaintRegNo}}</td>
                                    <td>{{@$value->complaintTitle}}</td>
                                    <td>{{@$value->complaintmoderelation->modeName}}</td>
                                    <td>{{@$value->complaintTyperelation->complainttypeName}}</td>
                                    <td>Not Linked</td>
                                    <td>
                                        <a class="btn btn-xs btn-info" href="{{route('link.case.complaint.person.case',['complaint_id'=>@$id,'id'=>@$value->complaintID])}}" onclick="return confirm('Are you sure , you want to link this case ? ')"> <i class="fa fa-link"></i>Link </a>

                                    </td>
                                     </tr>
                                     @endif
                                    @endforeach
                                    @endif



                                    
                                    @foreach(@$person_involved as $value)
                                    <tr>
                                    {{-- <td>{{@$value->repeatedID}}</td> --}}
                                    <td>{{@$value->repeatedComplaint_registrationRelation->updated_at}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintRegNo}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintTitle}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintmoderelation->modeName}}</td>
                                    <td>{{@$value->repeatedComplaint_registrationRelation->complaintTyperelation->complainttypeName}}</td>
                                    <td> Linked</td>
                                    <td>
                                        <a class="btn btn-xs btn-danger" href="{{route('link.case.complaint.delete',['id'=>@$value->repeatedID ])}}" onclick="return confirm('Are you sure , you want to delete this case ? ')"> <i class="fa fa-trash"></i> </a>

                                    </td>
                                </tr>
                                    @endforeach
                                    
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <form method="post" action="{{route('link.case.complaint.register')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="complaintID" value="{{@$id}}">
            <div class="row">
                

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Complaint Registration No<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" name="complaintRegNo_LinkComplaint" placeholder="Enter Registration No" type="text" id="search_case" required>
                    </div>
                    <div id="case_list">
                     </div>
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Link Complaint</button></div>
            </div>
        </form>
    </div>
</section>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

 $('#search_case').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('search.autocomplete.cases') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#case_list').fadeIn();  
                    $('#case_list').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#search_case').val($(this).text());  
        $('#case_list').fadeOut();  
    });  

});
</script>


@endsection