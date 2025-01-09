@extends('layouts.admin')

@section('content')
    <style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
        .tox .tox-notification--warn, .tox .tox-notification--warning {
            display: none;
        }
            
        .card{
            padding: 25px;
        }

            </style>
<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="#">Assign Member</a>

        </li>

        <li class="nav-item">
          <a class="nav-link btn " href="{{route('administrative.inquiry.plan.chief.list')}}">Back To Menu</a>
         
        </li>
        
        
 
        
      </ul>



        
            <div class="row">
              


                <div class="col-sm-12">
                    <div class="card">
                    <p><b>Complaint No:</b> {{@$complaint->eve_offence_details->complaint_details->complaintRegNo}}</p>

                    <p><b>Complaint TItle:</b> {{@$complaint->eve_offence_details->complaint_details->complaintTitle}}</p>

                    <p><b>Date Time:</b> {{@$complaint->eve_offence_details->complaint_details->complaintDateTime}}</p>

                    <p><b>Offence Name :</b> {{@$complaint->eve_offence_details->allegation_name}}</p>
                    <p><b>Offence Description :</b> {{@$complaint->eve_offence_details->allegation_description}}</p>


                   

                    
               </div>
                   
            </div>


</div>


            <div class="row">

            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">

                    <div class="card-header" style="font-family:Product Sans"> Team Members </div>

                       
                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>Role</th>
                                        <th>COI Status</th>
                                        <th>COI Description</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$team->isNotEmpty())
                                    @foreach(@$team as $att)
                                    <tr>
                                        
                                        <td>{{ $att->user_details->name }}</td>
                                        <td>{{ $att->user_details->eid }} @if(@$att->user_details->unit!="") (Unit : {{$att->user_details->unit}}) @endif</td>
                                        <td>@if(@$att->role=="TL") Team Lead @elseif(@$att->role=="M") Member @else Legal Representative @endif</td>
                                        <td>@if(@$att->coi_status=="Y") Yes @elseif(@$att->coi_status=="N") No @else Awating Approval @endif</td>
                                        <td>{{ @$att->describe_coi }}</td>
                                        <td>
                                              @if(@$att->coi_status=="Y" || @$att->coi_status=="AA")
                                              <a class="btn btn-xs btn-danger" href="{{route('administrative.inquiry.plan.chief.add.officials.page.delete.data',['id'=>@$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                               </a>
                                               @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Member Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <form method="post" action="{{route('administrative.inquiry.plan.chief.add.officials.page.insert.data')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="appraise_id" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Users<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="user_id" id="user_id">
                                <option value="">Select</option>
                                @foreach(@$users as $value)
                                <option value="{{@$value->id}}" data-cid="{{@$value->eid}}">{{@$value->name}} @if(@$value->unit!="")(Unit- {{@$value->unit}}) @endif</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="clearfix"> </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>EID</label>
                            <input type="text" name="cid" id="cid" class="form-control">
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Role <span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="role" required id="role">
                                <option value="">Select</option>
                                <option value="TL">Team Lead</option>
                                <option value="M">Member</option>
                                <option value="LR">Legal Representative</option>
                            </select>
                    </div>
                </div>

                


                


                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            </div>
        </form>

</section>


<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>

<script type="text/javascript">
    $('#user_id').on('change',function(e){
        var user_id = $(this).find(':selected').attr('data-cid');
        $('#cid').val(user_id);
     });
</script>

@endsection