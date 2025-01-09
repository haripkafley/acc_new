@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">



<a href="{{route('action.taken.report.edit.view.yes.action',@$id)}}" class="btn btn-primary" style="float: right;">
                        Back
                    </a>

       {{--  <div class="card-body">
                    
                </div> --}}


        <form method="post" action="{{route('action.taken.report.crud.insert')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="atr_id" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Type <span style="font-weight: bold; color: red;">*</span></label>
                                    <br>
                                        <div class="form-check form-check-inline">
                                          
                                          <input class="form-check-input action_taken" type="radio" id="action_taken" name="action_taken" checked value="Individual">
                                          <label class="form-check-label" for="genderInput">Individual</label>
                                          
                                        </div>

                                        <div class="form-check form-check-inline">
                                          
                                          <input class="form-check-input action_taken" type="radio" id="action_taken"  name="action_taken" value="Organization">
                                          <label class="form-check-label" for="genderInput">Organization</label>
                                          
                                        </div>
                                </div>
                        </div>




                <div class="individual_div">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Nationality<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control nationality" name="nationality">
                                @foreach(@$country as $value)
                                 <option value="{{@$value->country_name}}" @if(@$value->country_name=="Bhutan") selected @endif>{{@$value->country_name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>



               

                {{-- bhutan-div///////////////////////////////////////////////////// --}}
                

                <div class="bhutan_div" style="width:100%">
                

                <div class="row">    
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>CID<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="text" id="cid" name="cid_no">
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group" style="margin-top:30px;">
                        <a href="javascript:void(0)" class="btn btn-danger" id="search_button">Search</a>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Name</label>
                            <input class="form-control"  type="text" id="bhutan_name" name="bhutan_name" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Dzongkhag</label>
                            <input class="form-control"  type="text" id="bhutan_dzonkhag" name="bhutan_dzonkhag" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Gewog</label>
                            <input class="form-control"  type="text" id="bhutan_gewog" name="bhutan_gewog" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Village</label>
                            <input class="form-control"  type="text" id="bhutan_village" name="bhutan_village" readonly>
                    </div>
                </div>

            </div>
         </div>

           

            {{-- othernation-div///////////////////////////////////////////////////// --}}
            <div class="othernation_div" style="width:100%;display:none">

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Document No</label>
                            <input class="form-control"  type="text"  name="document_no">
                    </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                            <input class="form-control"  type="text"  name="othernation_name">
                    </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Permanent Address</label>
                            <textarea class="form-control" name="parmanent_address"></textarea>
                    </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Address In Bhutan</label>
                            <textarea class="form-control" name="bhutan_address"></textarea>
                    </div>
                    </div>

            </div>
            {{-- end-othernation-div --}}

        </div>

        {{-- end-of-individual-div --}}


        <div class="organization_div" style="width:100%;display: none;">

            <div class="col-sm-12">
                    <div class="form-group">
                        <label>Organization Type</label>
                         <select class="form-control organization_type" name="organization_type">
                             <option value="Contractor">Contractor</option>
                             <option value="Other Businessess">Other Businessess</option>
                             <option value="Others">Others</option>
                         </select>
                   </div>
           </div>





           <div class="contractor_div">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>CDB Registraiton No</label>
                            <input type="text" name="reg_no" class="form-control">
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                            <input type="text" name="contractor_name" class="form-control">
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Office Address</label>
                            <input type="text" name="office_address" class="form-control">
                    </div>
                </div>

                
           </div>


           <div class="otherbusiness_div" style="display:none">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>License No</label>
                            <input type="text" name="reg_no_other_business" class="form-control">
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                            <input type="text" name="otherbusiness_name" class="form-control">
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Business  Location</label>
                            <input type="text" name="business_location" class="form-control">
                    </div>
                </div>

                
           </div>

           <div class="others_div" style="display:none">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                            <input type="text" name="other_name" class="form-control">
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Office Address</label>
                            <input type="text" name="other_office_address" class="form-control">
                    </div>
                </div>
           </div>




        </div>

                <div class="clearfix"> </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Action Taken <span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="action_taken_status" required>
                                <option>Select</option>
                                @foreach(@$actions as $value)
                                <option value="{{@$value->name}}">{{@$value->name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Action Taken Details<span style="font-weight: bold; color: red;"></span></label>
                            <textarea class="form-control"  type="text" name="action_details"> </textarea>
                    </div>
                </div>





               


                

                

                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            </div>
        </form>
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>

        <script type="text/javascript">
        $('#search_button').on('click',function(e){
            if($('#cid').val()==""){
                alert('Please enter cid');
                return false;
            }else{
                var cid = $('#cid').val();
                $.ajax({
                url:'{{route('person.details.from.person-table')}}',
                type:'GET',
                data:{cid:cid},
                success:function(data){
                  console.log(data);
                  if(data.success==false){
                    alert('User not found . Please try another one');
                    return false;
                  }
                  $('#bhutan_dzonkhag').val(data.dzongkhag);
                  $('#bhutan_gewog').val(data.gewog);
                  $('#bhutan_village').val(data.village);
                  $('#bhutan_name').val(data.name);
                }
              })
            }

        });
    </script>


    <script type="text/javascript">
        $('.nationality').on('change',function(){
            var nation = $(this).val();
            if(nation=="Bhutan")
            {
                $('.bhutan_div').show();
                $('.othernation_div').hide();
            }else{
                $('.bhutan_div').hide();
                $('.othernation_div').show();
            }
        });
    </script>


        <script type="text/javascript">
        $('.action_taken').on('change',function(){
            var action_taken = $(this).val();
            if(action_taken=="Individual")
            {
                $('.individual_div').show();
                $('.organization_div').hide();
            }else{
                $('.individual_div').hide();
                $('.organization_div').show();
            }
        });
    </script>


        <script type="text/javascript">
               $('.organization_type').on('change',function(){
                    var organisation = $(this).val();
                    if(organisation=="Contractor")
                    {
                        $('.contractor_div').show();
                        $('.otherbusiness_div').hide();
                        $('.others_div').hide();
                    }
                    else if(organisation=="Other Businessess")
                    {
                        $('.contractor_div').hide();
                        $('.otherbusiness_div').show();
                        $('.others_div').hide();
                    }
                    else if(organisation=="Others")
                    {
                        $('.contractor_div').hide();
                        $('.otherbusiness_div').hide();
                        $('.others_div').show();
                    }
               });
           </script>

@endsection