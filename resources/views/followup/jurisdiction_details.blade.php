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

        @include('followup.common')



        
            <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                  </div>
            </div>




    {{-- table-showing --}}
    <div class="col-sm-12">

                           <div class="card-body">
                            
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>Date Of Registration</th>
                                        <th>Jurisdiction</th>
                                        <th>Charges</th>
                                        <th>Restitution Prayed</th>
                                        <th>Confiscation Recovery prayed</th>
                                        <th>Other Prayers</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data)
                                        {{-- {{$data}} --}}
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->date_registration }}</td>
                                                <td>{{ $att->jurisdiction }}</td>
                                                <td>
                                                @php
                                                $probable_charge = DB::table('follow_charges')->where('follow_jurisdiction_id',$att->id)->where('status','!=','D')->get();
                                                @endphp

                                                @foreach(@$probable_charge as $value)
                                                <p style="font-weight: bold;">{{@$value->probable_charge}} @if(@$close_details->date_of_closing=="") <a href="{{route('get.official.cases.followup.jurisdiction.delete.charges',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif </p>
                                                @endforeach
                                                @if(@$close_details->date_of_closing=="")
                                                <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success edit_button">+add new</a></p>
                                                @endif

                                            </td>



                                            <td>
                                            

                                            @php
                                            $restitution_prayed = \App\Models\FollowRestitutionPrayed::where('follow_jurisdiction_id',$att->id)->with('probable_charge_details')->get();
                                            @endphp

                                            @foreach(@$restitution_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->restitution_prayed,0,50)}}.. @if(@$close_details->date_of_closing=="") <a href="{{route('get.official.cases.followup.jurisdiction.delete.restitution',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach
                                            @if(@$close_details->date_of_closing=="")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success restitution_button">+add new</a></p>
                                            @endif


                                        </td>


                                        <td>
                                            

                                            @php
                                            $confiscation_prayed = \App\Models\FollowConfiscation::where('follow_jurisdiction_id',$att->id)->with('probable_charge_details')->get();
                                            @endphp

                                            @foreach(@$confiscation_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->confiscation_prayed ,0,50)}}.. @if(@$close_details->date_of_closing=="")<a href="{{route('get.official.cases.followup.jurisdiction.delete.confiscation',@$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach
                                            @if(@$close_details->date_of_closing=="")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success confiscation_button">+add new</a></p>
                                            @endif


                                        </td>


                                        <td>
                                            

                                            @php
                                            $other_prayed = \App\Models\FollowOtherPrayed::where('follow_jurisdiction_id',$att->id)->with('probable_charge_details')->get();
                                            @endphp

                                            @foreach(@$other_prayed as $value)
                                            <p style="font-weight: bold;">{{-- {{@$value->probable_charge_details->probable_charge}} --}} {{substr(@$value->other_prayers ,0,50)}}.. @if(@$close_details->date_of_closing=="") <a href="{{route('get.official.cases.followup.jurisdiction.delete.other',$value->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this ?')"> X </a> @endif</p>
                                            @endforeach
                                            @if(@$close_details->date_of_closing=="")
                                            <p><a href="javascript:void(0)"  data-user="{{@$att->id}}" class="btn btn-success other_button">+add new</a></p>
                                            @endif


                                        </td>

                                        <td><a href="{{route('get.official.cases.followup.jurisdiction.details.view.more',@$att->id)}}" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i></a></td>
                                                
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
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
          <h5 class="modal-title" id="exampleModalLabel">New Probable Charge</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('get.official.cases.followup.jurisdiction.insert.charges')}}">@csrf
                <input type="hidden" name="user_id" id="user_id_value">
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
            <form method="post" action="{{route('get.official.cases.followup.jurisdiction.insert.restitution')}}">@csrf
                <input type="hidden" name="user_id_restitution_value" id="user_id_restitution_value">
                

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
            <form method="post" action="{{route('get.official.cases.followup.jurisdiction.insert.confiscation')}}">@csrf
                <input type="hidden" name="user_id_confiscation_value" id="user_id_confiscation_value">
                

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
            <form method="post" action="{{route('get.official.cases.followup.jurisdiction.insert.other')}}">@csrf
                <input type="hidden" name="user_id_other_value" id="user_id_other_value">
                

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
@endsection