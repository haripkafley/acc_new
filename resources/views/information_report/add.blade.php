@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.form.add.ir')) active btn btn-info @endif"  href="{{route('manage.information.report.form.add.ir')}}">IR Details</a>
        </li>

        {{-- <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)" disabled>IR Suspect</a>
        </li>

        <li class="nav-item">
          @if (session('ir_report_type')=="reporting_officer")
          <a class="nav-link @if(Route::is('manage.information.report.form.reporting.official')) active btn btn-info @endif"  href="{{route('manage.information.report.form.reporting.official')}}">Back</a>
          @else
          <a class="nav-link @if(Route::is('manage.information.report.form')) active btn btn-info @endif"  href="{{route('manage.information.report.form')}}">Back</a>
          @endif
        </li> --}}

        </ul>




          <form method="post" action="{{route('manage.information.report.form.insert.ir')}}" enctype="multipart/form-data">
            @csrf
                <div class="row">

                <div class="col-md-3">
                <div class="form-group">
                    <label>Reported By</label>
                    <select class="select2-multiple form-control"  name="members[]" multiple="multiple"
                    id="select2Multiple">
                    @foreach(@$user as $val)
                    <option value="{{@$val->id}}">{{@$val->name}} @if(@$val->unit!="")(Unit- {{@$val->unit}}) @endif</option>
                    @endforeach              
                  </select>
                </div>
               </div>

               <div class="col-md-3">
                <div class="form-group">
                    <label>IR Received Date</label>
                    <input type="date" name="received_date" required class="form-control">
                </div>
               </div>


               <div class="col-md-3">
               <div class="form-group">
                                    <label for="exampleInputEmail1">Source Type</label>
                                    <select class="form-control source_type" name="source_type">
                                        <option value="">Select</option>
                                        <option value="OSINT">OSINT</option>
                                        <option value="SOCINT">SOCINT</option>
                                        <option value="Humint">Humint</option>
                                        <option value="DS">Data Source</option>
                                    </select>
                                    
                 </div>
             </div>



               <div class="col-md-3">
                <div class="form-group">
                    <label>Source</label>
                    <select class="form-control" required name="source" id="source">
                        <option value="">Select</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
               </div>

               <div class="col-md-3 other_div" style="display:none">
                <div class="form-group">
                    <label>Other Source Name</label>
                    <input type="text" name="source_other"  class="form-control">
                </div>
               </div>

               <div class="col-md-12">
                <div class="form-group">
                    <label>IR Title</label>
                    <input type="text" name="title" required class="form-control">
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Occurance From</label>
                    <input type="date" name="occurance_from" required class="form-control">
                </div>
               </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label>Occurance Till</label>
                    <input type="date" name="occurance_till" required class="form-control">
                </div>
               </div>

               <div class="col-sm-4">
                    <div class="form-group">
                        <label>Dzongkhag<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="dzongkhag" id="dzongkhag">
                                <option value="">Select</option>
                                @foreach(@$dzongkhag as $value)
                                <option value="{{$value->dzoID}}">{{@$value->dzoName}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Gewog<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="gewog" id="gewog">
                                <option value="">Select Gewog</option>
                            </select>
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Village<span style="font-weight: bold; color: red;"></span></label>
                            <select class="form-control" name="village" id="village">
                                <option value="">Select Village</option>
                            </select>
                    </div>
                </div>



               

               <div class="col-md-12">
                <div class="form-group">
                    <label>IR Details</label>
                    <textarea type="text" name="description" required class="form-control"></textarea>
                </div>
               </div>

               

               <div class="col-md-4">
                <div class="form-group">
                    <label>Agency</label>
                    <select class="form-control" required name="agency">
                        <option value="">Select</option>
                        @foreach(@$agency as $value)
                        <option value="{{@$value->agencyID}}">{{@$value->agencyName}}</option>
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
                        <option value="{{@$value->offence_id}}">{{@$value->offence_type}}</option>
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
                        <option value="{{@$value->id}}">{{@$value->area_name}}</option>
                        @endforeach
                    </select>
                </div>
               </div>


               <div class="col-md-6">
                <div class="form-group">
                    <label>Attachment</label>
                    <input type="file" name="attachment"  class="form-control">
                </div>
               </div>



            </div>
                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            
        </form>
        <div class="row"><div class="col-md-12 text-center mt-5"><span class="btn btn-success">Please add ir first then you can add suspect/withness.</span></div></div>
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