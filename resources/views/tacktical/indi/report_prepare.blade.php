@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

                @php

                   $tacktical_details = \App\Models\Ti\TackticalInteligence::where('id',$id)->first();
                   // dd(@$tacktical_details->id);
                   $from = Carbon\Carbon::parse(@$tacktical_details->request_date);
                   $to = Carbon\Carbon::now();
                   $days =  $from->diffInDays($to);
                   $assign_date = DB::table('tactical_inteligence_team_member')->where('tacktical_id',@$tacktical_details->id)->orderBy('id','asc')->first();
                   if(@$assign_date=="")
                   {
                    $days_work = 0;
                   }else{
                    $days_work =  @$to->diffInWeekdays(@$assign_date->created_at);
                   }
                @endphp
        

            <div class="row">

            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">

                    <div class="card-header" style="font-family:Product Sans"> Prepare Report </div>
                    
                    <div class="card-body">
                        <p><b>TI No : </b> {{@$data->si_ig_no}}</p>
                        <p><b>Running Days : </b> {{@$days}} days</p>
                        <p><b>Working Days : </b> {{@$days_work}} days</p>
                        <p><b>Relation To:</b> {{ @$data->relation_to }}</p>
                        <p><b>Offence :</b> {{ @$data->offence_details->offence_type }}</p>
                        <p><b>Request Type:  </b> {{ @$data->request_date }}</p>
                        <p><b>Occurance Duration :  </b> {{ @$data->start_date }}  - {{ @$data->end_date }}</p>
                        <p><b>Request Date :  </b> {{ @$data->request_date }}</p>
                    </div>

                </div>
            </div>

            

                <div class="col-md-12">
                <form action="{{route('tacktical.inteligence.autorization.individual.ti-report.information.page.update.report')}}" method="POST" style="width: 100%;" enctype="multipart/form-data">
                    @csrf
                   
                    <input type="hidden" name="id" value="{{@$id}}">

                    <div class="form-group mt-5">
                        <label for="title">Background</label>
                        <textarea type="text" class="text_complaint"   class="form-control"  placeholder="Enter background"  name="background" style="height:350px">{!!@$data->background!!}</textarea>
                    </div>





                

                <div class="form-group mt-5">
                        <label for="title">Findings</label>
                        <textarea type="text" class="text_complaint"   class="form-control"  placeholder="Enter what we know"  name="findings" style="height:350px">{!!@$data->findings!!}</textarea>
                </div>

                <div class="form-group mt-5">
                        <label for="title">Recommendations, if any</label>
                        <textarea type="text" class="text_complaint"   class="form-control"  placeholder="Enter what recommendation"  name="recomendation" style="height:350px">{{@$data->recomendation}}</textarea>
                </div>

                <div class="form-group mt-5">
                        <label for="title">Other Information, if any</label>
                        <textarea type="text" class="text_complaint"   class="form-control"  placeholder="Enter other information"  name="other_information" style="height:350px">{{@$data->other_information}}</textarea>
                </div>

                <div class="form-group mt-5">
                        <label for="title">Attachments, if required</label>
                        <input type="file" name="attachment" class="form-control">
                        @if(@$data->attachment)
                        <a class="btn btn-xs btn-warning mt-3" href="{{URL::to('attachment/ti')}}/{{$data->attachment}}" target="_blank"><i class="fa fa-eye"></i>View Attachment
                        </a>
                        @endif
                </div>


                <div class="form-group ">
                        <label for="title">Completation Date</label>
                        <input type="date" value="{{@$data->completation_date}}" name="completation_date" class="form-control">
                </div>

                    <div class="col-sm-12"><button class="btn btn-primary">Submit Report</button></div>
                </form>
            </div>
        </div>


        
    </div>
</section>

<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.2.1/tinymce.min.js"></script>

    <script>
       tinymce.init({
         selector: 'textarea.text_complaint', // Replace this CSS selector to match the placeholder element for TinyMCE
         license_key: 'gpl',
         plugins: 'code table lists',
         toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
       });

       
     </script>

@endsection