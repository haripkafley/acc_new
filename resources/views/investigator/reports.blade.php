@extends('layouts.admin')

@section('content')
<br>

<section class = "content">   
    @include('investigator/mainheader')
    <!------------------------ end top part ---------------->  
<div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    @if(Auth::user()->role == "Investigator")
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="addreport()">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font:face:Product Sans">Add Report</span>
                        </button>
                    @endif
                    <br>
                    <br>
                        <table class="table t2">
                            <tr>
                                <th>Report Type</th>
                                <th>Report Title</th>
                                <th>Creation Date</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @if($reports->count())
                            @foreach($reports as $report)
                            <tr>
                                <td><?php echo $key=DB::table('tbl_report_category_lookup')->where('id',$report->report_type_id)->value('report_name'); ?></td>
                                <td>{{ $report->report_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y')}}</td>
                                <td><?php echo $key=DB::table('users')->where('email',$report->created_by)->value('name'); ?></td>
                                <td></td>
                                <td><a style="color:grey" href="{{ route('generatereportword',$report->id) }}" data-toggle="tooltip" data-placement="bottom" title="Download as Word" ><i class="far fa-file-word evidence-icon"></i></a> &nbsp;
                                <!-- <a style="color:grey" href="{{ route('generatereportpdf',$report->id) }}" data-toggle="tooltip" data-placement="bottom" title="Download as PDF" ><i class="far fa-file-pdf evidence-icon"></i></a> &nbsp; -->
                            </td>
                            </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td style="text-align:center" style colspan="5"> No record found </td>
                                </tr>
                            @endif
                        </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</section>
<!--add modal -->
  <form  method = "POST" action="{{ route('savereport') }}"  enctype="multipart/form-data">
    @csrf
<div class="modal fade" id="addreportmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-family:Product Sans">
                   <div class="row"> 
                        <input type="hidden" name="reportcasenoid" id="reportcasenoid" value="{{ $casenoid }}" >
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Report Title&nbsp;<font color='red'>*</font></label>
                                <input type="text" name="reporttitle" name="reporttitle" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Report Category&nbsp;<font color='red'>*</font></label>
                                <select class="form-control" name="reporttype" id="reporttype" onchange="showreportdivs()" required>
                                    <option selected="selected" value="">--select one--</option>
                                    @foreach ($reportcategory as $cat)
                                    <option value="{{ $cat->id }}" >{{ $cat->report_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div id="div_1" class="hidden">
                                    <!-- -->
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav navi-tabs card-header-tabs" id="myTab" role="tablist">
                                                <li class="navi-item">
                                                    <a class="navi-link active" id="tab5-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="true">Case Summary</a>
                                                </li>
                                                <li class="navi-item">
                                                    <a class="navi-link " id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Alleged Person</a>
                                                </li>
                                                <li class="navi-item">
                                                    <a class="navi-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Witnesses</a>
                                                </li>
                                                <!-- <li class="navi-item">
                                                    <a class="navi-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false"> Offences</a>
                                                </li>
                                                <li class="navi-item">
                                                    <a class="navi-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Evidences</a>
                                                </li> -->
                                            </ul>
                                        </div>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Case Summary&nbsp;<font color='red'>*</font></label>
                                                            <textarea name="casesummaryreport"  class="form-control" id="casesummaryreport" onchange="showfooter()"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="text-align: center;">
                                                    <a style="color: #5E6366; cursor: pointer" onclick="nextone()"><i class="fa fa-arrow-circle-right" data-toggle="tooltip" data-placement="bottom" title="Next"></i> Next</a>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show " id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                                <!-- Content for Tab 1 -->
                                            <p>List of Accused:</p>
                                                @foreach($accused as $subject)
                                                    <label for="accused_{{ $subject['id'] }}">
                                                        <input type="checkbox" name="accused[]" id="accused_{{ $subject['id'] }}" value="{{ $subject['id'] }}">
                                                        {{ $subject['name'] }}
                                                    </label>
                                                    <br>
                                                @endforeach
                                                <div style="text-align: center;">
                                                    <a style="color: #5E6366; cursor: pointer" onclick="nextone()"><i class="fa fa-arrow-circle-right" data-toggle="tooltip" data-placement="bottom" title="Next"></i> Next</a>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                                <!-- Content for Tab 2 -->
                                                <p>List of Witnesses:</p>
                                                @foreach($witness as $wit)
                                                    <label for="witness_{{ $subject['id'] }}">
                                                        <input type="checkbox" name="witness[]" id="witness_{{ $wit['id'] }}" value="{{ $wit['id'] }}">
                                                        {{ $wit['name'] }}
                                                    </label>
                                                    <br>
                                                @endforeach
                                                <div style="text-align: center;">
                                                    <a style="color: #5E6366; cursor: pointer" onclick="nextone()"><i class="fa fa-arrow-circle-right" data-toggle="tooltip" data-placement="bottom" title="Next"></i> Next</a>
                                                </div>        </div>
                                            <!-- <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                                
                                            </div>
                                            <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                                                <p>This is the content of Tab 4</p>
                                                <div style="text-align: right;">
                                                    <button type="submit" class="btn btn-primary btn-sm" title="Generate Report">Save</button>
                                                </div>
                                                <br>
                                            </div> -->
                                            <!-- Add more tab panes as needed -->
                                        </div>
                                    </div>

                                    <!-- -->
                                </div>
                                <div id="div_2" class="hidden">
                                    Non Prosecution
                                </div>
                                <div id="div_3" class="hidden">
                                    Rapid Response
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                     <button type="submit" id="footersubmit" style="display:none" class="btn btn-primary btn-sm" title="Generate Report">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end add modal -->
<script>

    function addreport()
    {
        $('#addreportmodal').modal('show'); 
    }

    function showreportdivs() 
    {
       var selectElement = document.getElementById("reporttype");
       var selectedOption = selectElement.options[selectElement.selectedIndex];
       var selectedText = selectedOption.text;
        
        if (selectedText === "Investigation Report (Prosecution)") 
        {
            $("#div_1").show();
            $("#div_2").hide();
            $("#div_3").hide();
        }
        if (selectedText === "Investigation Report (Non-Prosecution)") 
        {
            $("#div_1").hide();
            $("#div_2").show();
            $("#div_3").hide();
        }
        if (selectedText === "Rapid Response Report") 
        {
            $("#div_1").hide();
            $("#div_2").hide();
            $("#div_3").show();
        }
        
    }
    function nextone() {
    var activeTab = document.querySelector(".navi-link.active");
    var nextTab = activeTab.parentElement.nextElementSibling.querySelector(".navi-link");

    if (nextTab) {
        activeTab.classList.remove("active");

        var tabId = activeTab.getAttribute("href").substring(1);
        document.getElementById(tabId).classList.remove("show", "active");

        nextTab.classList.add("active");

        var nextTabId = nextTab.getAttribute("href").substring(1);
        document.getElementById(nextTabId).classList.add("show", "active");
    }
}

    function showreportdetails(casenoid) 
    {
        var url = '/generatereport/' + casenoid; 
        window.open(url, '_blank');
    }

    function showfooter()
    {
        if(document.getElementById("casesummaryreport").text != "")
        {
        document.getElementById("footersubmit").style.display = "block";
        }
        else
        {
            alert("Please fill up case summary for report generation");
        }
    }

</script>
<style>
    .hidden 
        {
            display: none;
        }
    
    .navi-tabs 
        {
            list-style: none;
            padding: 0;
            margin: 0;
        }
    
    .navi-link {
        padding: 5px 5px; /* Add padding to create space between tabs */
        margin-right: 10px;
        border: 1px solid gray;
        border-radius:15%;
        background-color: #f8f9fa;
        color: #333;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
        font-size: 14px; 
    }

    .navi-link.active {
        background-color: #007bff;
        color: #fff;
    }

    .navi-link:hover {
        background-color: #007bff; /* Change background color on hover */
        color: #fff; /* Change text color on hover */
    }

    .navi-item {
        display: inline-block; /* Display tabs in a horizontal row */
    }

    .t2
        {
            outline: 1px solid #ccc;
            font-family:Product Sans;
        }

</style>
@endsection