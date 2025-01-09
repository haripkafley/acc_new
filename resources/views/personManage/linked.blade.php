@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
            <li>
           <a class="nav-link " href="{{route('manage.person.edit.view',@$id)}}">General Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active btn btn-info"  href="{{route('manage.person.linked.view',@$id)}}" >Linked Complaint</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('manage.person.image.upload',@$id)}}" >Image Upload</a>
        </li>
      </ul>


        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Linked Person </div>

                        <div class = "card-body">
                         
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>#</th>
                                        <th>Complaint Registration No</th>
                                        <th>Person Category</th>
                                        
                                        <th>Action</th>          
                                    </tr>
                                </thead>
                                <tbody>

                                    
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->linkComplaintPersonCatID }}</td>
                                        <td>{{ $att->complaint_details->complaintRegNo}}</td>
                                        <td>{{ $att->linkcomplaint_person_categoryName->categoryName}}</td>
                                        <td><a href="{{route('manage.person.linked.view.delete',['id'=>$att->linkComplaintPersonCatID])}}" class="btn btn-danger" >Delete</a></td>
                                       
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No  Complaint Found</td></tr>
                                    @endif
                                   



                                   
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <form method="post" action="{{route('manage.person.linked.view.person.insert')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="personID" value="{{@$id}}">
            <div class="row">
                

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Complaint Registration No<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control" name="complaintID" placeholder="Enter Registration No" type="text" id="search_case" required>
                    </div>

                    <div class="form-group">
                        <label>Select Category<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="personCategory">
                                <option value="">Select</option>
                                @foreach(@$category as $value)
                                <option value="{{@$value->personCategoryID}}">{{@$value->categoryName}}</option>
                                @endforeach
                            </select>
                    </div>



                    <div id="case_list">
                     </div>
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Link Person</button></div>
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