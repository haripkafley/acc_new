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
       
      </ul>



        
            <div class="row">
              


                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                  </div>
            </div>


            

             

                
         <div class="col-sm-12">  
            
            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        
                                        <th>Name of Accused</th>
                                        <th>Identification No</th>
                                        <th>Administrative Sanction</th>
                                        <th>Fines and Penalties</th>
                                        <th>Agency  Referred</th>
                                        <th>Reference Letter</th>
                                        <th>Status</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr>
                                       
                                        <td>{{ @$att->name}}</td>
                                        <td>{{ $att->identification_no}}</td>
                                         @php
                                          $status = \App\Models\AdminReferCaseStatus::where('user_id',$att->id)->where('case_id',@$case_id)->first();
                                         @endphp
                                        <td>
                                            @php
                                            $probable_charge = DB::table('admin_refer_case_sanction')->where('user_id',$att->id)->where('case_id',@$case_id)->get();
                                            @endphp

                                            @foreach(@$probable_charge as $value)
                                            <p style="font-weight: bold;">{{substr(@$value->sanction,0,50)}}.. @if(@$status->status!="Closed")<a href="{{route('case.administrative.referrals.page.case.administrative-sanction.delete',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach

                                            @if(@$status->status!="Closed")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success edit_button">+add new</a></p>
                                            @endif

                                        <td>
                                            

                                            @php
                                            $fines = \App\Models\AdminReferCaseFines::where('user_id',$att->id)->where('case_id',@$case_id)->get();
                                            @endphp

                                            @foreach(@$fines as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->fines,0,50)}}.. @if(@$status->status!="Closed") <a href="{{route('case.administrative.referrals.page.case.fines-penalty.delete',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach
                                            @if(@$status->status!="Closed")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success restitution_button">+add new</a></p>
                                            @endif



                                        </td>

                                        <td>


                                            @php
                                            $confiscation_prayed = \App\Models\AdminReferCaseAgencyRefer::where('user_id',$att->id)->where('case_id',@$case_id)->get();
                                            @endphp

                                            @foreach(@$confiscation_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->organization ,0,50)}}.. @if(@$status->status!="Closed") <a href="{{route('case.administrative.referrals.page.case.agency-refer.delete',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach
                                            @if(@$status->status!="Closed")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success confiscation_button">+add new</a></p>
                                            @endif

                                         </td>

                                        
                                        
                                        <td>
                                            @php
                                            $other_prayed = \App\Models\AdminReferCaseReferLetter::where('user_id',$att->id)->where('case_id',@$case_id)->get();
                                            @endphp

                                            @foreach(@$other_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->description  ,0,50)}}.. @if(@$status->status!="Closed") <a href="{{route('case.administrative.referrals.page.case.reference-letter.delete',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach
                                            @if(@$status->status!="Closed")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success other_button">+add new</a></p>
                                            @endif
                                        </td>

                                       
                                        <td>
                                            <p>{{@$status->status}}</p>
                                            <a href="javascript:void(0)" class="btn btn-warning status_button" data-status="{{@$status->status}}" data-user="{{@$att->id}}" data-remark="{{@$status->remarks}}">Update Status</a>

                                            <a href="{{route('case.administrative.referrals.page.register.details',['case_id'=>@$case_id,'user_id'=>$att->id])}}" target="_blank" class="btn btn-success mt-2"><i class="fa fa-eye"></i></a>
                                        </td>
                                        
                                    </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>

         </div>









                






               
    </div>


    <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Administrative Sanction</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('case.administrative.referrals.page.case.administrative-sanction.insert')}}">@csrf
                <input type="hidden" name="user_id" id="user_id_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">
                <div class="form-group">
                  <label for="exampleInputEmail1">Administrative Sanction</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="sanction" aria-describedby="emailHelp" required placeholder="Administrative Sanction"></textarea>
                 </div>

                 
        
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
</div>



{{-- restitution-prayed --}}
    <div class="modal fade" id="exampleModaRestitution" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Fines and Penalties</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('case.administrative.referrals.page.case.fines-penalty.insert')}}">@csrf
                <input type="hidden" name="user_id_restitution_value" id="user_id_restitution_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">

                

                <div class="form-group">
                  <label for="exampleInputEmail1">Fines and Penalties</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="fines" aria-describedby="emailHelp" required placeholder="Fines and Penalties"></textarea>
                 </div>

                 
        
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
</div>

{{-- confiscation --}}

    <div class="modal fade" id="exampleModaconfiscation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agency Referred</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('case.administrative.referrals.page.case.agency-refer.insert')}}">@csrf
                <input type="hidden" name="user_id_confiscation_value" id="user_id_confiscation_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">

                

                <div class="form-group">
                  <label for="exampleInputEmail1">Ministry / Organization</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="organization" aria-describedby="emailHelp" required placeholder="Ministry / Organization"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Department / Division</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="department" aria-describedby="emailHelp" required placeholder="Department / Division"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Division</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="division" aria-describedby="emailHelp" required placeholder="Division"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Remarks</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="remarks" aria-describedby="emailHelp" required placeholder="Remarks"></textarea>
                 </div>

                 
        
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
</div>


{{-- other-prayed --}}
    <div class="modal fade" id="exampleModaother" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Reference Letter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('case.administrative.referrals.page.case.reference-letter.insert')}}">@csrf
                <input type="hidden" name="user_id_other_value" id="user_id_other_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">

                

                <div class="form-group">
                  <label for="exampleInputEmail1">Reference Letter</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="description" aria-describedby="emailHelp" required placeholder="Reference Letter"></textarea>
                 </div>

                 
        
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
</div>

{{-- status-update --}}
    <div class="modal fade" id="exampleModalStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Status Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('case.administrative.referrals.page.case.update.status')}}">@csrf
                <input type="hidden" name="user_id_status_value" id="user_id_status_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">

                <div class="form-group">
                    <label>Current Status : <p id="status_current"></p></label>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Status</label>
                  <select name="status" class="form-control" id="status_status" required>
                      <option value="">Select</option>
                      <option value="Under Agency Review">Under Agency Review</option>
                      <option value="Action Taken">Action Taken</option>
                      <option value="Further Action">Further Action</option>
                      <option value="Closed">Closed</option>
                  </select>
                 </div>


                 <div class="form-group">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" id="status_remarks"></textarea>
                 </div>
                 
        
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
</div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   

    <script type="text/javascript">
        $('input[type=radio][name=evaluation]').on('change', function() {
          var evaluation =  $(this).val();
           if(evaluation=="Y")
           {
             $('.describe').show();
           }else{
            $('.describe').hide();
           } 
        });
    </script>

    <script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#user_id_value').val($(this).data('user'));
            $('#exampleModaEdit').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.restitution_button').on('click',function(){
            $('#user_id_restitution_value').val($(this).data('user'));
            $('#exampleModaRestitution').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.confiscation_button').on('click',function(){
            $('#user_id_confiscation_value').val($(this).data('user'));
            $('#exampleModaconfiscation').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.other_button').on('click',function(){
            $('#user_id_other_value').val($(this).data('user'));
            $('#exampleModaother').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.status_button').on('click',function(){
            if($(this).data('status')!=""){
                $('#status_current').html($(this).data('status'));
            }else{
                $('#status_current').html('Status not updated');
            }

            $('#status_remarks').val($(this).data('remark'));
            $('#user_id_status_value').val($(this).data('user'));

            $('#exampleModalStatus').modal('show');
        })
</script>


    <script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});


</script>


@endsection