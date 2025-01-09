@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">





        

        <a href="{{route('action.taken.report.edit.view.yes.action',@$atr_id)}}" class="btn btn-primary" style="float: right;margin-bottom: 10px;">
                                    Back
                                </a>
        <form method="post" action="{{route('action.taken.report.crud.update')}}" enctype="multipart/form-data">
            @csrf
            


            <input type="hidden" name="id" value="{{@$data->id}}">
            <div class="row">
                <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Type <span style="font-weight: bold; color: red;">*</span></label>
                                    <br>
                                        <div class="form-check form-check-inline">
                                          
                                          <input class="form-check-input action_taken" type="radio" id="action_taken" name="action_taken" @if(@$data->type=="Individual") checked @endif value="Individual">
                                          <label class="form-check-label" for="genderInput">Individual</label>
                                          
                                        </div>

                                        <div class="form-check form-check-inline">
                                          
                                          <input class="form-check-input action_taken" type="radio" id="action_taken"  name="action_taken"  @if(@$data->type=="Organization") checked @endif value="Organization">
                                          <label class="form-check-label" for="genderInput">Organization</label>
                                          
                                        </div>
                                </div>
                        </div>




                <div class="individual_div" @if(@$data->type=="Individual") style="display:block" @else style="display:none" @endif>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Nationality<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control nationality" name="nationality">
                                @foreach(@$country as $value)
                                 <option value="{{@$value->country_name}}" @if(@$value->country_name==@$data->nationality) selected @endif>{{@$value->country_name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>



               

                {{-- bhutan-div///////////////////////////////////////////////////// --}}
                

                <div class="bhutan_div" @if(@$data->nationality=="Bhutan") style="width:100%;display:block" @else style="width:100%;display:none"  @endif>
                

                <div class="row">    
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>CID<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="text" id="cid" value="{{@$data->cid_no}}" name="cid_no">
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
                            <input class="form-control"  type="text" value="{{@$data->name}}" id="bhutan_name" name="bhutan_name" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Dzongkhag</label>
                            <input class="form-control"  type="text" id="bhutan_dzonkhag" value="{{@$data->person_details->dzongkhagrelation->dzoName}}" name="bhutan_dzonkhag" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Gewog</label>
                            <input class="form-control"  type="text" value="{{@$data->person_details->gewogrelation->gewogName}}" id="bhutan_gewog" name="bhutan_gewog" readonly>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Village</label>
                            <input class="form-control" value="{{@$data->person_details->villagerelation->villageName}}"  type="text" id="bhutan_village" name="bhutan_village" readonly>
                    </div>
                </div>

            </div>
         </div>

           

            {{-- othernation-div///////////////////////////////////////////////////// --}}
            <div class="othernation_div" @if(@$data->nationality!="Bhutan") style="width:100%;display:block" @else style="width:100%;display:none"  @endif>

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Document No</label>
                            <input class="form-control"  type="text" value="{{@$data->document_no}}" name="document_no">
                    </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                            <input class="form-control"  type="text" value="{{@$data->name}}" name="othernation_name">
                    </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Permanent Address</label>
                            <textarea class="form-control" name="parmanent_address">{{@$data->parmanent_address}}</textarea>
                    </div>
                    </div>

                    <div class="col-sm-12">
                    <div class="form-group">
                        <label>Address In Bhutan</label>
                            <textarea class="form-control" name="bhutan_address">{{@$data->bhutan_address}}</textarea>
                    </div>
                    </div>

            </div>
            {{-- end-othernation-div --}}

        </div>

        {{-- end-of-individual-div --}}


        <div class="organization_div" @if(@$data->type=="Organization") style="display:block;width: 100%;" @else style="display:none;width: 100%;" @endif>

            <div class="col-sm-12">
                    <div class="form-group">
                        <label>Organization Type</label>
                         <select class="form-control organization_type" name="organization_type">
                             <option value="Contractor" @if(@$data->organization_type=="Contractor") selected @endif>Contractor</option>
                             <option value="Other Businessess" @if(@$data->organization_type=="Other Businessess") selected @endif>Other Businessess</option>
                             <option value="Others" @if(@$data->organization_type=="Others") selected @endif>Others</option>
                         </select>
                   </div>
           </div>





           <div class="contractor_div" @if(@$data->organization_type=="Contractor") style="display:block" @else style="display:none" @endif>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>CDB Registraiton No</label>
                            <input type="text" name="reg_no" value="{{@$data->reg_no}}" class="form-control">
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                            <input type="text" name="contractor_name" value="{{@$data->name}}" class="form-control">
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Office Address</label>
                            <input type="text" name="office_address" value="{{@$data->office_address}}" class="form-control">
                    </div>
                </div>

                
           </div>


           <div class="otherbusiness_div" @if(@$data->organization_type=="Other Businessess") style="display:block" @else style="display:none" @endif>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>License No</label>
                            <input type="text" name="reg_no_other_business" value="{{@$data->reg_no}}" class="form-control">
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                            <input type="text" name="otherbusiness_name" value="{{@$data->name}}" class="form-control">
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Business  Location</label>
                            <input type="text" name="business_location" value="{{@$data->business_location}}" class="form-control">
                    </div>
                </div>

                
           </div>

           <div class="others_div" @if(@$data->organization_type=="Others") style="display:block" @else style="display:none" @endif>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                            <input type="text" name="other_name" value="{{@$data->name}}" class="form-control">
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Office Address</label>
                            <input type="text" name="other_office_address" value="{{@$data->office_address}}" class="form-control">
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
                                <option value="{{@$value->name}}" @if(@$data->action_taken==@$value->name) selected @endif>{{@$value->name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Action Taken Details<span style="font-weight: bold; color: red;"></span></label>
                            <textarea class="form-control"  type="text" name="action_details"> {{@$data->action_details}} </textarea>
                    </div>
                </div>





               


                

                

                <div class="col-sm-12"></div>
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Update</button></div>
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