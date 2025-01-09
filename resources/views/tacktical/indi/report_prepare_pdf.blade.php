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

    <table class="order-details">
        <tbody>
            <tr>
                <td>@if(@$data->type_ti=="IG") IG @else SI @endif No. :</td>
                <td>{{@$data->si_ig_no}}</td>
            </tr>
            <tr>
                <td>Date Of Request :</td>
                <td>{{@$data->request_date}}</td>
            </tr>
            <tr>
                <td>Date Of Completation :</td>
                <td>{{@$data->completation_date}}</td>
            </tr>
            
        </tbody>
    </table>






    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>Background : </b> {!!@$data->background!!}</p>
                
    </div>







    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>Findings : </b> {!!@$data->findings!!}</p>
                
    </div>

    @if(@$data->type_ti=="IG")
    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>Recommendations, if any: </b> {!!@$data->recomendation!!}</p>
                
    </div>

    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>Other Information, if any </b> {!!@$data->other_information!!}</p>
                
    </div>
    @endif
    <br>
    <div class="card" style="border: 2px solid black;
           box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            margin-bottom: 1rem;margin-top: 15px;padding: 10px;">
                <p><b>Attachments, if required </b> @if(@$data->attachment)
                        <a class="btn btn-xs btn-warning mt-3" href="{{URL::to('attachment/ti')}}/{{$data->attachment}}" target="_blank"><i class="fa fa-eye"></i>View Attachment
                        </a> @else No Attachemnt
                        @endif</p>
                
    </div>


        <table class="order-details">
        <tbody>
            <tr>
                <td>Submitted by</td>
                <td>{{@$data->submit_details->name}}</td>
            </tr>
            @if(@$data->review_by!="")
            <tr>
                <td>Review By :</td>
                <td>{{@$data->review_details->name}}</td>
            </tr>
            <tr>
                <td>Review Remarks :</td>
                <td>{{@$data->report_remarks}}</td>
            </tr>
            <tr>
                <td>Review Date :</td>
                <td>{{@$data->review_date}}</td>
            </tr>
            @endif
            
        </tbody>
    </table>



</body>
</html>
