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
                                        <th>Probable Charge</th>
                                        <th>Restitution Prayed</th>
                                        <th>Confiscation / Recovery prayed</th>
                                        <th>Other Prayers</th>
                                        <th>Status</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr>
                                        @php
                                            $status = \App\Models\CaseAssignStatus::where('user_id',$att->id)->where('case_id',@$case_id)->first();  
                                        @endphp
                                       
                                        <td>{{ @$att->name}}</td>
                                        <td>{{ $att->identification_no}}</td>
                                        <td>
                                            @php
                                            $probable_charge = DB::table('case_probable_charge')->where('user_id',$att->id)->where('case_id',@$case_id)->where('status','!=','D')->get();
                                            @endphp

                                            @foreach(@$probable_charge as $value)
                                            <p style="font-weight: bold;">{{@$value->probable_charge}} @if(@$status->status!="Closed") <a href="{{route('get.cases.official.prosecution.referrals.add.probable.charge.delete',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach


                                            @if(@$status->status!="Closed")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success edit_button">+add new</a></p>
                                            @endif

                                        </td>


                                        <td>
                                            

                                            @php
                                            $restitution_prayed = \App\Models\RestitutionPrayed::where('user_id',$att->id)->where('case_id',@$case_id)->with('probable_charge_details')->get();
                                            @endphp

                                            @foreach(@$restitution_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->restitution_prayed,0,50)}}.. @if(@$status->status!="Closed")<a href="{{route('get.cases.official.prosecution.referrals.add.restitution.prayed.delete',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach
                                            @if(@$status->status!="Closed")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success restitution_button">+add new</a></p>
                                            @endif



                                        </td>


                                        <td>
                                            

                                            @php
                                            $confiscation_prayed = \App\Models\ConfiscationPrayed::where('user_id',$att->id)->where('case_id',@$case_id)->with('probable_charge_details')->get();
                                            @endphp

                                            @foreach(@$confiscation_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->confiscation_prayed ,0,50)}}.. @if(@$status->status!="Closed")<a href="{{route('get.cases.official.prosecution.referrals.add.confiscation-recovery-prayed.delete',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach
                                            @if(@$status->status!="Closed")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success confiscation_button">+add new</a></p>
                                            @endif



                                        </td>


                                        <td>
                                            

                                            @php
                                            $other_prayed = \App\Models\OtherPrayers::where('user_id',$att->id)->where('case_id',@$case_id)->with('probable_charge_details')->get();
                                            @endphp

                                            @foreach(@$other_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->other_prayers ,0,50)}}.. @if(@$status->status!="Closed")<a href="{{route('get.cases.official.prosecution.referrals.add.other-prayed.delete',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach
                                            @if(@$status->status!="Closed")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success other_button">+add new</a></p>
                                            @endif



                                        </td>
                                        
                                        <td>
                                            
                                            <p>{{@@$status->status}}</p>
                                            <a href="javascript:void(0)" data-id="{{@$att->id}}"  data-status="{{@@$status->status}}" data-status_remark="{{@$status->remarks}}" class="btn btn-warning status_button">Update Status</a>

                                            <a href="{{route('get.cases.official.prosecution.referrals.registration.view.details',['case_id'=>@$case_id,'user_id'=>$att->id])}}" class="btn btn-success  mt-2" target="_blank">View All</a>
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
          <h5 class="modal-title" id="exampleModalLabel">New Probable Charge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('get.cases.official.prosecution.referrals.add.probable.charge')}}">@csrf
                <input type="hidden" name="user_id" id="user_id_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="case_id">
                <div class="form-group">
                  <label for="exampleInputEmail1">Probable Charge</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="probable_charge" aria-describedby="emailHelp" required placeholder="Probable Charge">
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
          <h5 class="modal-title" id="exampleModalLabel">New Restitution Prayed</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('get.cases.official.prosecution.referrals.add.restitution.prayed')}}">@csrf
                <input type="hidden" name="user_id_restitution_value" id="user_id_restitution_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">

                <div class="form-group">
                  <label for="exampleInputEmail1">Probable Charge</label>
                  <select class="form-control" required name="probable_charge_id">
                      <option value="">Select</option>  
                      @foreach(@$probable_charges as $value)
                      <option value="{{@$value->id}}">{{@$value->probable_charge}}</option>
                      @endforeach
                  </select>
                 </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Restitution Prayed</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="restitution_prayed" aria-describedby="emailHelp" required placeholder="Restitution Prayed"></textarea>
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
          <h5 class="modal-title" id="exampleModalLabel">New Confiscation / Recovery Prayed</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('get.cases.official.prosecution.referrals.add.confiscation-recovery-prayed')}}">@csrf
                <input type="hidden" name="user_id_confiscation_value" id="user_id_confiscation_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">

                <div class="form-group">
                  <label for="exampleInputEmail1">Probable Charge</label>
                  <select class="form-control" required name="probable_charge_id">
                      <option value="">Select</option>  
                      @foreach(@$probable_charges as $value)
                      <option value="{{@$value->id}}">{{@$value->probable_charge}}</option>
                      @endforeach
                  </select>
                 </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Confiscation/Recovery  Prayed</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="confiscation_prayed" aria-describedby="emailHelp" required placeholder="Confiscation/Recovery  Prayed"></textarea>
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
                            <form method="post" enctype="multipart/form-data" action="{{route('get.cases.official.prosecution.referrals.registration.update.status')}}">@csrf
                        <input type="hidden" name="id" id="id_appraise">
                        
                         <input type="hidden" name="case_id" value="{{@$case_id}}">
                         <div class="form-group">
                          <label for="exampleInputEmail1">Status</label>
                          <select class="form-control" required name="status" id="status_edit">
                              <option value="">Select</option>
                              <option value="Closed">Closed</option>
                              <option value="Further Action">Further Action</option>
                              <option value="Own Action">Own Action</option>
                          </select>
                         </div>

                         
                        <div class="form-group">
                          <label for="exampleInputEmail1">Remarks</label>
                          <textarea class="form-control" name="status_remark" id="status_remark"></textarea>
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
            <form method="post" action="{{route('get.cases.official.prosecution.referrals.add.other-prayed')}}">@csrf
                <input type="hidden" name="user_id_other_value" id="user_id_other_value">
                <input type="hidden" value="{{@$case_id}}" name="case_id" id="user_id_value">

                <div class="form-group">
                  <label for="exampleInputEmail1">Probable Charge</label>
                  <select class="form-control" required name="probable_charge_id">
                      <option value="">Select</option>  
                      @foreach(@$probable_charges as $value)
                      <option value="{{@$value->id}}">{{@$value->probable_charge}}</option>
                      @endforeach
                  </select>
                 </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Other Prayers</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="other_prayers" aria-describedby="emailHelp" required placeholder="Other Prayers"></textarea>
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
            $('#id_appraise').val($(this).data('id'));
            $('#status_edit').val($(this).data('status')).change();
            $('#status_remark').val($(this).data('status_remark'));
            $('#status_model').modal('show');
        })
</script>

@endsection