@extends('layouts.admin')

@section('content')
<br>

<section class = "content">   
    <div class = "card" >
        <div class = "card-header"> <input type="hidden" id="maincaseno" name="maincaseno" value="{{ $caseno }}">
        <input type="hidden" id="maincasenoid" name="maincasenoid" value="{{ $casenoid }}">
            @foreach ($showcases as $cases)
                <div class="row" > 
	                <div class="col-md-3">
                        <div class="form-group">
                            <label>Case Number: </label> &nbsp; {{ $cases->case_no }}
                                    <input type="hidden" id="maincaseno" name="maincaseno" value="{{ $caseno }}"></br>
                            <label>Case Title: </label> &nbsp; {{ $cases->case_title }}
                                    <input type="hidden" readonly name="registration_date"  class="form-control" id="registration_date" value="{{ \Carbon\Carbon::parse($cases->case_reg_date)->format('d/m/Y')}}">
                                    <input type="hidden"  name="registration_date_ss"  class="form-control" id="registration_date_ss" value="{{ $cases->case_reg_date }}">
                                    <br>
                            <label>Case Creation Date: </label> &nbsp; {{ \Carbon\Carbon::parse($cases->case_reg_date)->format('d/m/Y')}}
                            <br>
                            <label>Complaint Details: </label> &nbsp; {{ $cases->allegation_details }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sector Type: </label> &nbsp; {{ $cases->sector_type }}
                                    <br>
                            <label>Sector Sub Type: </label> &nbsp; {{ $cases->sector_sub_type }}
                                    <br>
                            <label>Area: </label> &nbsp; {{ $cases->area }}
                            <br>
                            <label>Institution Type: </label> &nbsp; {{ $cases->institution_type }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Priority: </label> &nbsp; {{ $cases->priority }}
                                    <br>
                            <label>Probable Offence: </label> &nbsp;
                                <br>
                                @foreach ($offences as $offence)
                                    {{ $offence->offence_type }}
                                @endforeach
                                    
                            
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            
                            <label>Change Case Status: </label> &nbsp; 
                                <select name="casestatus" id="casestatus" onchange="changestatus('{{ $casenoid }}')">
                                    <option value="">Select Status</option>
                                        <option selected>{{ $cases->case_substatus }}</option>
                                        @foreach ($casesubstatus as $status)
                                            <option value="{{ $status->status_name }}">{{ $status->status_name }}</option>
                                        @endforeach    
                                </select>  
                                <br>
                                <input type="text" class="form-control" style="display:none" placeholder="Remarks" name="changestatusremarks" id="changestatusremarks">  
                                <button type="submit" id="changestatusbutton" name="changestatusbutton" style="display:none;float:right;" class="btn btn-light"  data-toggle="tooltip" data-placement="bottom" title="Save" ><i class="fa fa-save"></i></button>  
                            
                        </div>
                    </div>
                </div>
        @endforeach
        </div>
    </div>
    <!------------------------ end top part ---------------->

    

	<div class="card  card-tabs">
  		<h6 class="card-header">@include('investigator_tab')</h6>
  			<div class="card-body">
			  	<div class="row">
                    <div class="col-12 col-sm-12">
                        @include('oands_tab')                
					</div>
				</div>
  			</div>
	</div>
</section>
<script>
	function changestatus(casenoid)
        {
           
            $('#changestatusremarks').show();
            $('#changestatusbutton').show();
            var status = $('#casestatus').val();
            
                        $.ajax({
                            type:'POST',
                            enctype: 'multipart/form-data',
                            url:"{{ route('changestatusinvestigator',["+casenoid+","+status+"]) }}",
                            data: formdata,
                            success:function(data){
                                alert(data.success);
                            }
                            });
        }
</script>
@endsection