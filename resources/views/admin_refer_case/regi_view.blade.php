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
                                        
                                        <td>
                                            @php
                                            $probable_charge = DB::table('admin_refer_case_sanction')->where('user_id',$att->id)->where('case_id',@$case_id)->get();
                                            @endphp

                                            @foreach(@$probable_charge as $value)
                                            <p style="font-weight: bold;">{{substr(@$value->sanction,0,10)}}.. <a href="javascript:void(0)" class="btn btn-danger edit_button" data-sanction="{{@$value->sanction}}"> <i class="fa fa-eye"></i> </a></p>
                                            @endforeach
                                           

                                        <td>
                                            

                                            @php
                                            $fines = \App\Models\AdminReferCaseFines::where('user_id',$att->id)->where('case_id',@$case_id)->get();
                                            @endphp

                                            @foreach(@$fines as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->fines,0,10)}}.. <a href="javascript:void(0)" class="btn btn-danger restitution_button" data-fines="{{@$value->fines}}"> <i class="fa fa-eye"></i> </a></p>
                                            @endforeach
                                            



                                        </td>

                                        <td>


                                            @php
                                            $confiscation_prayed = \App\Models\AdminReferCaseAgencyRefer::where('user_id',$att->id)->where('case_id',@$case_id)->get();
                                            @endphp

                                            @foreach(@$confiscation_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->organization ,0,10)}}.. <a href="javascript:void(0)" class="btn btn-danger confiscation_button" data-organization="{{@$value->organization}}" data-department="{{@$value->department}}" data-division="{{@$value->division}}" data-remarks="{{@$value->remarks}}"> <i class="fa fa-eye"></i> </a></p>
                                            @endforeach
                                            

                                         </td>

                                        
                                        
                                        <td>
                                            @php
                                            $other_prayed = \App\Models\AdminReferCaseReferLetter::where('user_id',$att->id)->where('case_id',@$case_id)->get();
                                            @endphp

                                            @foreach(@$other_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->description  ,0,10)}}.. <a href="javascript:void(0)" class="btn btn-danger other_button" data-other="{{@$value->description}}"> <i class="fa fa-eye"></i> </a></p>
                                            @endforeach
                                            
                                        </td>

                                        @php
                                          $status = \App\Models\AdminReferCaseStatus::where('user_id',$att->id)->where('case_id',@$case_id)->first();
                                        @endphp
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-warning status_button" data-status="{{@$status->status}}" data-user="{{@$att->id}}" data-remark="{{@$status->remarks}}">View Status</a>

                                            <a href="{{route('case.administrative.referrals.page.register.details',['case_id'=>@$case_id,'user_id'=>$att->id])}}" target="_blank" class="btn btn-success mt-2">View</a>
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
          <h5 class="modal-title" id="exampleModalLabel"> Administrative Sanction</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Administrative Sanction</label>
                  <textarea type="text" class="form-control" disabled id="sanction_id" name="sanction" aria-describedby="emailHelp" required placeholder="Administrative Sanction"></textarea>
                 </div>

                 
        
                
              
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
            

                

                <div class="form-group">
                  <label for="exampleInputEmail1">Fines and Penalties</label>
                  <textarea type="text" class="form-control" disabled id="fines_id" name="fines" aria-describedby="emailHelp" required placeholder="Fines and Penalties" style="height:150px"></textarea>
                 </div>

                 
        
                
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
                  <textarea type="text" class="form-control" id="organization_id" disabled name="organization" aria-describedby="emailHelp" required placeholder="Ministry / Organization"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Department / Division</label>
                  <textarea type="text" class="form-control" id="department_id" disabled name="department" aria-describedby="emailHelp" required placeholder="Department / Division"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Division</label>
                  <textarea type="text" class="form-control" id="division_id" disabled name="division" aria-describedby="emailHelp" required placeholder="Division"></textarea>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Remarks</label>
                  <textarea type="text" class="form-control" id="remarks_id" disabled name="remarks" aria-describedby="emailHelp" required placeholder="Remarks"></textarea>
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
            

                

                <div class="form-group">
                  <label for="exampleInputEmail1">Reference Letter</label>
                  <textarea type="text" class="form-control" id="reference_id" name="description" aria-describedby="emailHelp" required placeholder="Reference Letter"></textarea>
                 </div>

                 
        
              
              
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
                    <label>Remarks : <p id="status_remarks"></p></label>
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
            $('#sanction_id').val($(this).data('sanction'));
            $('#exampleModaEdit').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.restitution_button').on('click',function(){
            $('#fines_id').val($(this).data('fines'));
            $('#exampleModaRestitution').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.confiscation_button').on('click',function(){
            $('#organization_id').val($(this).data('organization'));
            $('#department_id').val($(this).data('department'));
            $('#division_id').val($(this).data('division'));
            $('#remarks_id').val($(this).data('remarks'));
            $('#exampleModaconfiscation').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.other_button').on('click',function(){
            $('#reference_id').val($(this).data('other'));
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

            $('#status_remarks').html($(this).data('remark'));
            

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