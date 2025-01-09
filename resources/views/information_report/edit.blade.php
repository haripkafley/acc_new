@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.form.edit.ir')) active btn btn-info @endif"  href="{{route('manage.information.report.form.edit.ir',@$id)}}">IR Details</a>
        </li>

        {{-- <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.suspects.add')) active btn btn-info @endif" href="{{route('manage.information.report.suspects.add',@$id)}}" disabled>IR Suspect</a>
        </li>

        <li class="nav-item">
          @if (session('ir_report_type')=="reporting_officer")
          <a class="nav-link @if(Route::is('manage.information.report.form.reporting.official')) active btn btn-info @endif"  href="{{route('manage.information.report.form.reporting.official')}}">Back</a>
          @else
          <a class="nav-link @if(Route::is('manage.information.report.form')) active btn btn-info @endif"  href="{{route('manage.information.report.form')}}">Back</a>
          @endif
        </li> --}}

        </ul>

            @if (session('ir_report_type')=="reporting_officer")
            <div class="row"><div class="col-md-12 text-right"><a class=" active btn btn-success text-left"  href="{{route('manage.information.report.form.reporting.official')}}"> Back</a></div></div>
            @else
            <div class="row"><div class="col-md-12 text-right"><a class=" active btn btn-success text-left"  href="{{route('manage.information.report.form')}}"> Back</a></div></div>
            @endif
          <form method="post" action="{{route('manage.information.report.form.update.ir')}}" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" value="{{@$id}}">
                <div class="row">
                <div class="col-md-3">
                <div class="form-group">
                    <label>Reported By</label>
                    <select class="select2-multiple form-control"  name="members[]" multiple="multiple"
                    id="select2Multiple">
                    @foreach(@$user as $val)
                    <option value="{{@$val->id}}" @if(in_array(@$val->id,$user_array)) selected @endif>{{@$val->name}} @if(@$val->unit!="")(Unit- {{@$val->unit}}) @endif</option>
                    @endforeach              
                  </select>
                </div>
               </div>

               <div class="col-md-3">
                <div class="form-group">
                    <label>IR Received Date</label>
                    <input type="date" name="received_date" value="{{@$data->received_date}}" required class="form-control">
                </div>
               </div>

               <div class="col-md-3">
               <div class="form-group">
                                    <label for="exampleInputEmail1">Source Type</label>
                                    <select class="form-control source_type" name="source_type">
                                        <option value="">Select</option>
                                        <option value="OSINT" @if(@$data->source_type=="OSINT") selected @endif>OSINT</option>
                                        <option value="SOCINT" @if(@$data->source_type=="SOCINT") selected @endif>SOCINT</option>
                                        <option value="Humint" @if(@$data->source_type=="Humint") selected @endif>Humint</option>
                                        <option value="DS" @if(@$data->source_type=="DS") selected @endif>Data Source</option>
                                    </select>
                                    
                 </div>
             </div>



               

               <div class="col-md-6">
                <div class="form-group">
                    <label>Source</label>
                    <select class="form-control" required name="source" id="source">
                        <option value="">Select</option>
                        @foreach(@$sources as $value)
                        <option value="{{@$value->id}}" @if(@$data->source==@$value->id) selected @endif>{{@$value->name}}</option>
                        @endforeach
                        <option value="Other" @if(@$data->source=="Other") selected @endif>Other</option>
                    </select>
                </div>
               </div>

               <div class="col-md-6 other_div" @if(@$data->source=="Other") style="display:block" @else style="display:none" @endif>
                <div class="form-group">
                    <label>Other Source Name</label>
                    <input type="text" name="source_other" value="{{@$data->source_other}}" class="form-control">
                </div>
               </div>




               <div class="col-md-12">
                <div class="form-group">
                    <label>IR Title</label>
                    <input type="text" name="title" required value="{{@$data->title}}" class="form-control">
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Occurance From</label>
                    <input type="date" name="occurance_from" value="{{@$data->occurance_from}}" required class="form-control">
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Occurance Till</label>
                    <input type="date" name="occurance_till" value="{{@$data->occurance_till}}" required class="form-control">
                </div>
               </div>


               <div class="col-sm-4">
                    <div class="form-group">
                        <label>Dzongkhag<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="dzongkhag" id="dzongkhag">
                                <option value="">Select</option>
                                @foreach(@$dzongkhag as $value)
                                <option value="{{$value->dzoID}}" @if(@$data->dzongkhag_id==$value->dzoID) selected @endif>{{@$value->dzoName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Gewog<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="gewog" id="gewog">
                                <option value="">Select Gewog</option>
                                @foreach(@$gewog as $value)
                                <option value="{{$value->gewogID}}" @if(@$data->gewog_id==$value->gewogID) selected @endif>{{@$value->gewogName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Village<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="village" id="village">
                                <option value="">Select Village</option>
                                @foreach(@$village as $value)
                                <option value="{{$value->villageID}}" @if(@$data->village==$value->villageID) selected @endif>{{@$value->villageName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>



               <div class="col-md-12">
                <div class="form-group">
                    <label>IR Details</label>
                    <textarea type="text" name="description" required class="form-control">{{@$data->description}}</textarea>
                </div>
               </div>



               <div class="col-md-4">
                <div class="form-group">
                    <label>Agency</label>
                    <select class="form-control" required name="agency">
                        <option value="">Select</option>
                        @foreach(@$agency as $value)
                        <option value="{{@$value->agencyID}}" @if(@$data->agency==@$value->agencyID) selected @endif>{{@$value->agencyName}}</option>
                        @endforeach
                    </select>
                </div>
               </div>


               <div class="col-md-4">
                <div class="form-group">
                    <label>Corruption Offences</label>
                    <select class="form-control" required name="corruption">
                        <option value="">Select</option>
                        @foreach(@$offence as $value)
                        <option value="{{@$value->offence_id}}" @if(@$data->corruption==@$value->offence_id) selected @endif>{{@$value->offence_type}}</option>
                        @endforeach
                    </select>
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>Area Of Corruption</label>
                    <select class="form-control" required name="area">
                        <option value="">Select</option>
                        @foreach(@$area as $value)
                        <option value="{{@$value->id}}" @if(@$data->area==@$value->id) selected @endif>{{@$value->area_name}}</option>
                        @endforeach
                    </select>
                </div>
               </div>


               <div class="col-md-6">
                <div class="form-group">
                    <label>Attachment</label>
                    <input type="file" name="attachment"  class="form-control">
                </div>
                 @if(@$data->attachment)
                    <a class="btn btn-xs btn-warning" href="{{URL::to('attachment/ir')}}/{{$data->attachment}}" target="_blank"><i class="fa fa-eye"></i>View Attachment
                    </a>
                 @endif
               </div>





            </div>
                
                
                <div class="col-sm-6 mt-2"><button type="submit" class="btn btn-info">Update Details</button></div>
           </form>

            <div class="row mt-5">
            <div class="col-md-12">
                
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Suspect/Witness List </div>

                        <div class = "card-body">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                        Add Suspect/Witness
                    </button>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Person Type</th>
                                        <th>Nationality</th>
                                        <th>Name Of Suspect</th>
                                        <th>CID / Identification No</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>Photo</th>
                                        <th>Address</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$suspects->isNotEmpty())
                                    @foreach(@$suspects as $att)
                                    <tr>
                                        <td>@if(@$att->person_type=='S') Suspect @else Witness @endif</td>
                                        <td>@if(@$att->nationality=="B")National @else Non-National @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>@if(@$att->nationality=="B") {{ @$att->cid }} @else {{ @$att->identity }} @endif</td>
                                        <td>{{ $att->country }}</td>
                                        <td>{{ $att->phone_number }}</td>
                                        <td>
                                            <img src="{{URL::to('attachment/ir')}}/{{$att->photo}}" style="width:80px;height: 80px;">
                                        </td>
                                        <td>{{ $att->address }}</td>
                                        <td>
                                                        
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('manage.information.report.suspects.delete.suspect',['id'=>@$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Suspect Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
        

        <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Suspect</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                            <form method="post" action="{{route('manage.information.report.suspects.insert.suspect')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="ir_id" value="{{@$id}}">
            <div class="row">

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Person Type<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="person_type" id="person_type">
                                <option value="">Select</option>
                                <option value="S">Suspect</option>
                                <option value="W">Witness</option>
                            </select>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>National Type<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="nationality" id="nationality">
                                <option value="">Select</option>
                                <option value="B">National</option>
                                <option value="N">Non-National</option>
                            </select>
                    </div>
                </div>

                <div class="col-sm-12 cid_div" style="display:none">
                    <div class="form-group">
                        <label>CID</label>
                            <input type="text" name="cid" class="form-control">
                    </div>
                </div>

                <div class="col-sm-12 identity_div" style="display:none">
                    <div class="form-group">
                        <label>Identification No</label>
                            <input type="text" name="identity" class="form-control">
                    </div>
                </div>

                <div class="clearfix"> </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="name" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>DOB<span style="font-weight: bold; color: red;"></span></label>
                            <input type="date" name="dob" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Phone Number<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="phone_number" class="form-control" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Address<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="address" class="form-control" required>
                    </div>
                </div>


                


                <div class="col-sm-12" id="country_div">
                    <div class="form-group">
                        <label>Country<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="country">
                                <option value="">Select</option>
                                @foreach(@$country as $value)
                                <option value="{{@$value->country_name}}">{{@$value->country_name}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Photo<span style="font-weight: bold; color: red;"></span></label>
                            <input type="file" name="photo" class="form-control" required>
                    </div>
                </div>


                


                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
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
</section>

<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $('#source').on('change',function(e){
        var source = $(this).val();
        if(source=="Other")
        {

            $('.other_div').show();
        }else{
            $('.other_div').hide();
        }    
    });
</script>

<script type="text/javascript">
    $('#nationality').on('change',function(e){
        var nationality = $(this).val();
        if(nationality=="B")
        {
            $('.cid_div').show();
            $('.identity_div').hide();
            $('#country_div').hide();
        }else{
            $('.cid_div').hide();
            $('.identity_div').show();
            $('#country_div').show();
        }    
    });
</script>


<script type="text/javascript">
    $('.source_type').on('change',function(e){
        var source = $(this).val();
        var url = '{{ route('get.source.from.source.type', ':id') }}';
        url = url.replace(':id', source);
        $('#source').empty();
            
        $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('#source').append('<option value="' + value.id + '">' + value.name +
                        '</option>');

                });
                $('#source').append('<option value="Other">Other</option>');
            });
    });
</script>

 <script type="text/javascript">
  $(document).ready(function(){
    $('#dzongkhag').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('get.gewog.onchange.dzongkhag')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#gewog').html(data.gewog);
          
        }
      })
    })
  })
</script>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#gewog').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('get.village.onchange.gewog')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#village').html(data.village);
          
        }
      })
    })
  })
</script>

     <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>

@endsection