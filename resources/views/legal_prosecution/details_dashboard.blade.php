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

        @include('legal_prosecution.common_dashboard')



        
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
                                        <th>Formal Charge</th>
                                        <th>Probable Charge</th>
                                        <th>Restitution Prayed</th>
                                        <th>Confiscation Recovery prayed</th>
                                        <th>Other Prayers</th>
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
                                            $formal_charge = DB::table('legal_formal_charge')->where('user_id',$att->id)->where('case_id',@$case_id)->where('status','!=','D')->get();
                                            @endphp

                                            @foreach(@$formal_charge as $value)
                                            <p style="font-weight: bold;">{{@$value->formal_charge}} <a href="javascript:void(0)" class="btn btn-dange formal_button_view" data-formal_charge="{{@$value->formal_charge}}"> <i class="fa fa-eye"></i> </a></p>
                                            @endforeach

                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success probable_add_button">+add new</a></p>
                                            

                                        </td>


                                        <td>
                                            @php
                                            $probable_charge = DB::table('case_probable_charge')->where('user_id',$att->id)->where('case_id',@$case_id)->where('status','!=','D')->get();
                                            @endphp

                                            @foreach(@$probable_charge as $value)
                                            <p style="font-weight: bold;">{{@$value->probable_charge}} <a href="javascript:void(0)" class="btn btn-dange edit_button" data-probable_charge="{{@$value->probable_charge}}"> <i class="fa fa-eye"></i> </a></p>
                                            @endforeach
                                            

                                        </td>


                                        <td>
                                            

                                            @php
                                            $restitution_prayed = \App\Models\RestitutionPrayed::where('case_id',@$case_id)->with('probable_charge_details')->where('user_id',$att->id)->get();
                                            @endphp

                                            @foreach(@$restitution_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->restitution_prayed,0,10)}}.. <a href="javascript:void(0)" class="btn btn-dange restitution_button" data-probable_charge="{{@$value->probable_charge_details->probable_charge}}" data-restitution="{{@$value->restitution_prayed}}"> <i class="fa fa-eye"></i> </a></p>
                                            @endforeach
                                            



                                        </td>


                                        <td>
                                            

                                            @php
                                            $confiscation_prayed = \App\Models\ConfiscationPrayed::where('case_id',@$case_id)->with('probable_charge_details')->where('user_id',$att->id)->get();
                                            @endphp

                                            @foreach(@$confiscation_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->confiscation_prayed ,0,10)}}.. <a href="javascript:void(0)" class="btn btn-dange confiscation_button" data-probable_charge="{{@$value->probable_charge_details->probable_charge}}" data-confiscation_prayed="{{@$value->confiscation_prayed}}"> <i class="fa fa-eye"></i> </a></p>
                                            @endforeach
                                            



                                        </td>


                                        <td>
                                            

                                            @php
                                            $other_prayed = \App\Models\OtherPrayers::where('case_id',@$case_id)->with('probable_charge_details')->where('user_id',$att->id)->get();
                                            @endphp

                                            @foreach(@$other_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->other_prayers ,0,10)}}.. <a href="javascript:void(0)" class="btn btn-dange other_button" data-probable_charge="{{@$value->probable_charge_details->probable_charge}}" data-other_prayers="{{@$value->other_prayers}}"> <i class="fa fa-eye"></i> </a></p>
                                            @endforeach
                                            {{-- <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success other_button">+add new</a></p> --}}



                                        </td>
                                        @php
                                            $status = \App\Models\Legal\ProsecutionStatus::where('case_id',@$case_id)->where('type','R')->where('user_id',$att->id)->first();  
                                        @endphp
                                        
                                        <td>
                                            <p>{{@$status->status}}</p>
                                            <a href="javascript:void(0)" data-user_id_status="{{@$att->id}}" data-id="{{@$status->id}}" data-agency="{{@$status->agency_name}}" data-date="{{@$status->date}}" data-attachment="{{URL::to('attachment/legal_prosecution')}}/{{@$status->attachment}}" data-attach="{{@$status->attachment}}" data-status="{{@$status->status}}" data-status_remark="{{@$status->remarks}}" class="btn btn-warning status_button">Update Status</a>
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


        <div class="modal fade" id="formal_charge_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Formal Charge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('prosecution.legal.list.my-dashboard.formal.charge.insert')}}">@csrf
                <input type="hidden" name="user_id" id="user_id_formal">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="case_id">
                <div class="form-group">
                  <label for="exampleInputEmail1">Formal Charge</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="formal_charge" aria-describedby="emailHelp" required placeholder="Formal Charge">
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


<div class="modal fade" id="formal_charge_modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Formal Charge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('prosecution.legal.list.my-dashboard.formal.charge.insert')}}">@csrf
                <input type="hidden" name="user_id" id="user_id_formal">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="case_id">
                <div class="form-group">
                  <label for="exampleInputEmail1">Formal Charge</label>
                  <input type="text" class="form-control" id="formal_charge" disabled name="formal_charge" aria-describedby="emailHelp" required placeholder="Formal Charge">
                 </div>
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


    <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Probable Charge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
                <input type="hidden" name="user_id" id="user_id_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">
                <div class="form-group">
                  <label for="exampleInputEmail1">Probable Charge</label>
                  <input type="text" class="form-control"  id="probable_charge_main_id" name="probable_charge" aria-describedby="emailHelp" disabled required placeholder="Probable Charge">
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
          <h5 class="modal-title" id="exampleModalLabel"> Restitution Prayed</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
                <input type="hidden" name="user_id_restitution_value" id="user_id_restitution_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">

                <div class="form-group">
                  <label for="exampleInputEmail1">Probable Charge</label>
                  <input type="text" class="form-control"  id="probable_charge_restitution" name="probable_charge" aria-describedby="emailHelp" disabled required placeholder="Probable Charge">
                 </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Restitution Prayed</label>
                  <textarea type="text" class="form-control" style="height:150px;" id="restitution_prayed_id" name="restitution_prayed" aria-describedby="emailHelp" disabled required placeholder="Restitution Prayed"></textarea>
                 </div>

                 
        
                <button type="submit" class="btn btn-primary">Submit</button>
             
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
          <h5 class="modal-title" id="exampleModalLabel"> Confiscation / Recovery Prayed</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
                

                <div class="form-group">
                  <label for="exampleInputEmail1">Probable Charge</label>
                  <input type="text" class="form-control"  id="probable_charge_confiscation" name="probable_charge" aria-describedby="emailHelp" disabled required placeholder="Probable Charge">
                 </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Confiscation/Recovery  Prayed</label>
                  <textarea type="text" class="form-control" style="height:150px;"  id="confiscation_prayed_id" name="confiscation_prayed" disabled aria-describedby="emailHelp" required placeholder="Confiscation/Recovery  Prayed"></textarea>
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

{{-- status --}}
            <div class="modal fade" id="status_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('prosecution.legal.list.my-dashboard.view.prosecution.details.update.status')}}">@csrf
                        <input type="hidden" name="id" id="id_status">
                         <input type="hidden" name="user_id_status" id="user_id_status">
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Prosecuting Agency</label>
                          <select class="form-control" name="agency_name" id="agency_name">
                              <option value="">Select</option>
                              <option value="OAG">OAG</option>
                              <option value="ACC">ACC</option>
                              <option value="Others">Others</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Prosecuting Agency</label>
                          <select class="form-control" name="status" id="status">
                              <option value="">Select</option>
                              <option value="Status1">Status1</option>
                              <option value="Status2">Status2</option>
                          </select>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Date</label>
                          <input type="date" class="form-control"  name="date" id="date">
                         </div>

                         
                        <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="remarks" id="remarks"></textarea>
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Attachment</label>
                          <input type="file" class="form-control"  name="attachment" id="attachment">
                         </div>

                         <div class="form-group attachment_view" style="display:none">
                          <a href="" class="btn btn-primary" id="attachment_view" target="_blank">View Attachment</a>
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


{{-- other-prayed --}}
    <div class="modal fade" id="exampleModaother" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Other Prayed</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
               

                <div class="form-group">
                  <label for="exampleInputEmail1">Probable Charge</label>
                  <input type="text" class="form-control"  id="probable_charge_other" name="probable_charge" aria-describedby="emailHelp" disabled required placeholder="Probable Charge">
                 </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Other Prayers</label>
                  <textarea type="text" class="form-control" style="height:150px;" id="other_prayers_id" name="other_prayers" aria-describedby="emailHelp" disabled required placeholder="Other Prayers"></textarea>
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
            $('#probable_charge_main_id').val($(this).data('probable_charge'));
            $('#exampleModaEdit').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.restitution_button').on('click',function(){
            $('#probable_charge_restitution').val($(this).data('probable_charge'));
            $('#restitution_prayed_id').val($(this).data('restitution'));
            $('#exampleModaRestitution').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.confiscation_button').on('click',function(){
            $('#probable_charge_confiscation').val($(this).data('probable_charge')); 
            $('#confiscation_prayed_id').val($(this).data('confiscation_prayed')); 
            $('#exampleModaconfiscation').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.other_button').on('click',function(){
            $('#probable_charge_other').val($(this).data('probable_charge'));
            $('#other_prayers_id').val($(this).data('other_prayers'));
            $('#exampleModaother').modal('show');
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


<script type="text/javascript">
    $('.status_button').on('click',function(){
            $('#id_status').val($(this).data('id'));
            $('#agency_name').val($(this).data('agency')).change();
            $('#status').val($(this).data('status')).change();
            $('#date').val($(this).data('date'));
            $('#user_id_status').val($(this).data('user_id_status'));

            $('#remarks').val($(this).data('status_remark'));

            if($(this).data('attach')!="")
            {
                // alert($(this).data('attachment'));
                $('.attachment_view').show();
                $('#attachment_view').attr('href',$(this).data('attachment')); 
            }
            $('#status_model').modal('show');
        })
</script>


    <script type="text/javascript">
    $('.probable_add_button').on('click',function(){
            $('#user_id_formal').val($(this).data('user'));
            $('#formal_charge_modal').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.formal_button_view').on('click',function(){
            $('#formal_charge').val($(this).data('formal_charge'));
            $('#formal_charge_modal_edit').modal('show');
        })
</script>
@endsection