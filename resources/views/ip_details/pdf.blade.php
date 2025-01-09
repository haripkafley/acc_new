<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title> Invoice #6</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px; width: 100%;">
                <p style="color:red"><b>INTELLIGENCE REPORT</b></p>
                <p><b>IP No : </b> {{@$data->ir_no}}</p>
                <p><b>IP Title : </b> {{@$data->title}}</p>
                <p><b>Report Date : </b> {{@$report->report_date}}</p>
                
    </div>
    <table class="order-details">
        <thead>
            
            
            
            


        
        <tbody>
            <tr>
                <td>IP No :</td>
                <td>{{@$data->ir_no}}</td>
            </tr>
            <tr>
                <td>IP Title :</td>
                <td>{{@$data->title}}</td>
            </tr>
            <tr>
                <td>Offences :</td>
                <td>{{@$data->offence_name->offence_type}}</td>
            </tr>
            <tr>
                <td>Period of Occurrence:</td>
                <td>{{@$data->occurance_from}} - {{@$data->occurance_to}}</td>
            </tr>
            <tr>
                <td>Place of Occurrence:</td>
                <td>{{@$data->dzongkhagrelation->dzoName}}  @if(@$data->gewog_id!=""), {{@$data->gewogrelation->gewogName}} @endif @if(@$data->village!=""), {{@$data->villagerelation->villageName}} @endif</td>
            </tr>

            <tr>
                <td>No. of Suspect:</td>
                <td>{{@$suspect_number}}</td>
            </tr>

            <tr>
                <td>No. of Witness:</td>
                <td>{{@$witness_number}}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    SECTION 02: Suspect
                </th>
            </tr>
            <tr class="bg-blue">
                {{-- <th>Person Type</th> --}}
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
                                        {{-- <td>@if(@$att->person_type=='S') Suspect @else Witness @endif</td> --}}
                                        <td>@if(@$att->nationality=="B")National @else Non-National @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->identity }}</td>
                                        <td>{{ $att->country }}</td>
                                        <td>{{ $att->phone_number }}</td>
                                        <td>{{ $att->dob }}</td>
                                        <td><p>{{ $att->address }}</p></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Suspect Found</td></tr>
                                    @endif
        </tbody>
    </table>


        <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    SECTION 03: Witness (Optional)
                </th>
            </tr>
            <tr class="bg-blue">
                {{-- <th>Person Type</th> --}}
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
                                        {{-- <td>@if(@$att->person_type=='S') Suspect @else Witness @endif</td> --}}
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

    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>SECTION 04: IP Findings: </b> {!!@$report->background!!}</p>
                
    </div>


    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    Hypothesis
                </th>
            </tr>
            <tr class="bg-blue">
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


        <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                    Hypothesis
                </th>
            </tr>
            <tr class="bg-blue">
               <th>Exhibit Code</th>
                                        <th>Exhibit Name</th>
                                        <th>Collected Date</th>
                                        {{-- <th>Collected Method</th> --}}
                                        <th>Collected By</th>
                                        <th>Attachment</th>   
                                        <th>Description</th>
                                        <th>Select</th>
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

    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>3. What we Know: </b> {!!@$report->what_we_know!!}</p>
                
    </div>

    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>4. What we don't Know (Intelligence Gap): </b> {!!@$report->what_dont_know!!}</p>
                
    </div>

    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>5. What we think: </b> {!!@$report->what_we_think!!}</p>
                
    </div>
    <br><br><br><br>
    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>6.Recommendation </b> {!!@$report->recommendation!!}</p>
                
    </div>

    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>Commission Directives : </b> 
                    @foreach(@$commission_directive as $value)
                        <p>{{@$value->remarks}}</p>
                        @endforeach
                </p>


                <p><b>Commission Acceptance Remarks : </b> 
                    @foreach(@$commission_directive as $value)
                        <p>{{@$value->head_remark}}</p>
                        @endforeach
                </p>
                
    </div>

</body>
</html>
