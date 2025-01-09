@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> 
                        {{-- Embassy List --}}
                        <div class="row" style="font-family:Product Sans">
                            <div class="col-sm">
                                List Of Assigned Cases
                            </div>
                           </div>
                    </div>

                    


                        <div class = "card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <form method="post" id="form_submit" action="{{route('action.review.assign.committee.list.update.availability')}}">
                                @csrf  
                                <input type="hidden"  class="id_value" name="id_value">
                                        <input type="hidden" name="optradio_value" class="optradio_value" >  
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        
                                        <th>ACC Letter No</th>
                                        <th>ACC Letter Date</th>
                                        <th>ATR Letter No</th>
                                        <th>ATR Letter Date</th> 
                                        {{-- <th>CEC Date</th> 
                                        <th>CEC Time</th> 
                                        <th>Venue</th> 
                                        <th>Availability</th> --}}
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr>
                                        <td>{{ $att->complaint_details->action_details->letter_no}}</td>
                                        <td>{{ $att->complaint_details->action_details->letter_date}}</td>
                                        <td>{{ $att->complaint_details->letter_no}}</td>
                                        <td>{{ $att->complaint_details->letter_date}}</td>
                                        {{-- <td>{{ $att->complaint_details->com_date}}</td>
                                        <td>{{ $att->complaint_details->com_time}}</td>
                                        <td>{{ $att->complaint_details->com_venue}}</td>
                                        
                                        <td>
                                                <label class="radio-inline">
                                                  <input type="radio" name="addmore[{{$key}}][optradio]" class="radio_option" id="{{$key}}" value="Y" data-id="{{@$att->id}}" @if($att->availability=="Y") checked @endif>Yes
                                                </label>
                                                <label class="radio-inline">
                                                  <input type="radio" name="addmore[{{$key}}][optradio]" class="radio_option" id="{{$key}}" value="N" data-id="{{@$att->id}}" @if($att->availability=="N") checked @endif>No
                                                </label>
                                                
                                        </td> --}}
                                        <td>
                                            {{-- @if($att->availability=="Y") --}}
                                                @if($att->coi_status=="AA")
                                                <a href="{{route('action.review.assign.committee.list.coi.details',['id'=>$att->id,'type'=>'com'])}}" class="btn btn-warning">COI</a>
                                                @else
                                                <a href="{{route('action.review.assign.committee.list.case.details',['id'=>$att->id,'type'=>'com'])}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                @endif

                                            {{-- @endif --}}

                                        </td>
                                    </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>
                            </form>        
                        </div>
                </div>
            </div>
        </div>


        
    </div>
</section>



<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" charset="utf8"
    src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});

$(".radio_option:radio").on('change',function(){
    
    $('.id_value').val($(this).data('id'));
    $('.optradio_value').val($(this).val());
    
    $('#form_submit').submit();
});
</script>


@endsection