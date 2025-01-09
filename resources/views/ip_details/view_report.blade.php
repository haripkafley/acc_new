@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">


        

            <div class="row">
                <style type="text/css">

                </style>

                <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs" style="border:2px solid black;height: 100vh; text-align:center;justify-content: center;">
                    <h2 class="text-center center" style="color:red;font-weight: bolder;">INTELLIGENCE REPORT</h2>
                    <p class="text-center center"><b>IP No : </b> {{@$data->ir_no}}</p>
                    <p class="text-center center"><b>IP Title : </b> {{@$data->title}}</p>
                    <p class="text-center center"><b>Report Date : </b> {{@$report->report_date}}</p>
                </div>
               </div>

            <div class="col-md-12" >
                <div class="card card-primary card-outline card-outline-tabs">

                    <div class="card-header" style="font-family:Product Sans"> Prepare Report </div>
                    
                    <div class="card-body">
                        <p><b>IP No : </b> {{@$data->ir_no}}</p>
                        <p><b>IP Title : </b> {{@$data->title}}</p>
                        <p><b>Offences : </b> {{@$data->offence_name->offence_type}}</p>
                        <p><b>Period of Occurrence:</b> {{@$data->occurance_from}} - {{@$data->occurance_to}}</p>
                        <p><b>Place of Occurrence:  </b> {{@$data->dzongkhagrelation->dzoName}}  @if(@$data->gewog_id!=""), {{@$data->gewogrelation->gewogName}} @endif @if(@$data->village!=""), {{@$data->villagerelation->villageName}} @endif</p>
                        <p><b>No. of Suspect: </b> {{@$suspect_number}}</p>
                        <p><b>No. of Witness: </b> {{@$witness_number}}</p>
                    </div>

                </div>
            </div>

            <div class="col-sm-12">
                    <div class="card">
                         <h5>SECTION 02: Suspect</h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Person Type</th>
                                        <th>Nationality</th>
                                        <th>Name Of Suspect</th>
                                        <th>CID</th>
                                        <th>Identification No</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>DOB</th>
                                        <th>Address</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$suspects->isNotEmpty())
                                    @foreach(@$suspects as $att)
                                    <tr>
                                        <td>@if(@$att->person_type=='S') Suspect @else Witness @endif</td>
                                        <td>@if(@$att->nationality=="B")National @else Non-National @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->identity }}</td>
                                        <td>{{ $att->country }}</td>
                                        <td>{{ $att->phone_number }}</td>
                                        <td>{{ $att->dob }}</td>
                                        <td>{{ $att->address }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Suspect Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>


                <div class="col-sm-12">
                    <div class="card">
                         <h5>SECTION 03: Witness (Optional)</h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Person Type</th>
                                        <th>Nationality</th>
                                        <th>Name Of Suspect</th>
                                        <th>CID</th>
                                        <th>Identification No</th>
                                        <th>Country</th>
                                        <th>Phone</th>
                                        <th>DOB</th>
                                        <th>Address</th>
                                     </tr>
                                </thead>
                                <tbody>
                                    @if(@$witness->isNotEmpty())
                                    @foreach(@$witness as $att)
                                    <tr>
                                        <td>@if(@$att->person_type=='S') Suspect @else Witness @endif</td>
                                        <td>@if(@$att->nationality=="B")National @else Non-National @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->identity }}</td>
                                        <td>{{ $att->country }}</td>
                                        <td>{{ $att->phone_number }}</td>
                                        <td>{{ $att->dob }}</td>
                                        <td>{{ $att->address }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Suspect Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>


                <form action="{{route('member.get.information.report.assignment.intel.project.report.page.prepare.report.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12"><h5>SECTION 04: IP Findings:</h5></div>
                    <input type="hidden" name="id" value="{{@$id}}">

                    <div class="form-group mt-5 card-body card">
                        <label for="title">1.Background:</label>
                        <p>{!!@$report->background!!}</p>
                    </div>





                <div class="col-sm-12">
                    <div class="card">
                         <h5>Hypothesis</h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Hypothesis</th>
                                        <th>Description</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$hypo->isNotEmpty())
                                    @foreach(@$hypo as $att)
                                    <tr>
                                        <td>{{ $att->name}}</td>
                                        <td>{{ $att->description }}</td>
                                        
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>


                <div class="col-md-12">
                    <div class="card">
                         <h5>Exhibit</h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Exhibit Code</th>
                                        <th>Exhibit Name</th>
                                        <th>Collected Date</th>
                                        <th>Collected By</th>
                                        <th>Attachment</th>   
                                        <th>Description</th>
                                        <th>Note</th>           
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$exhibit->isNotEmpty())
                                    @foreach(@$exhibit as $key=> $att)
                                    <tr>
                                        <td>{{ $att->code}}</td>
                                        <td>{{ $att->name}}</td>
                                        <td>{{ $att->created_on }}</td>
                                        {{-- <td>{{ $att->created_method   }}</td> --}}
                                        <td>
                                            @php
                                                $explode = explode(',',$att->collected_by);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        <td>
                                            @if(@$att->attachment!="")
                                            <a class="btn btn-xs btn-info" href="{{URL::to('attachment/ir')}}/{{$att->attachment}}" target="_blank"><i class="fa fa-eye"></i>View
                                            </a>
                                            @endif
                                        </td>
                                        <td>{{ $att->description}}</td>
                                        <td>{{@$att->exhibit_report->text}}</td>
                                    </tr>
                                    @endforeach
                                    
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                </div>
            </div>

                <div class="form-group mt-5 card-body card">
                        <label for="title">3. What we Know:</label>
                        <p>{!!@$report->what_we_know!!}</p>
                        
                </div>

                <div class="form-group mt-5 card-body card">
                        <label for="title">4. What we don't Know (Intelligence Gap):</label>
                        <p>{!!@$report->what_dont_know!!}</p>
                        
                </div>

                <div class="form-group mt-5 card-body card">
                        <label for="title">5. What we think:</label>
                        <p>{!!@$report->what_we_think!!}</p>
                        
                </div>

                <div class="form-group mt-5 card-body card">
                        <label for="title">6.Recommendation</label>
                        <p>{!!@$report->recommendation!!}</p>
                </div>

                <div class="col-sm-12">
                    <div class="card-body">
                    <h5>Commission Directives :</h5>
                        @foreach(@$commission_directive as $value)
                        <p>{{@$value->remarks}}</p>
                        @endforeach
                    </div>

                    <div class="card-body">
                    <h5>Commission Acceptance Remarks :</h5>
                        @foreach(@$commission_directive as $value)
                        <p>{{@$value->head_remark}}</p>
                        @endforeach
                    </div>
                </div>

                
                </form>
        </div>


        
    </div>
</section>

<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>

<script type="text/javascript">
    $('#user_id').on('change',function(e){
        var user_id = $(this).find(':selected').attr('data-cid');
        $('#cid').val(user_id);
     });
</script>

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