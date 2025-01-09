@extends('layouts.admin')

@section('content')
<br>
@include('investigator/mainheader')
    <!------------------------ end top part ---------------->  
<div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                @include('tabs/interviewplan_tab')
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <br>
                    @if(Auth::user()->role == "Investigator")
                    <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="showvideocall()">
                                <span><i class="fa fa-video"></i></span>    
                                <span style="font:face:Product Sans">Video Call</span>
                    </button>
                    
                    <button type="button" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;box-shadow: none;" style="float:right" onclick="addnewinterviewplan()">
                                <span><i class="fa fa-plus"></i></span>    
                                <span style="font:face:Product Sans">Add Interview Plan</span>
                    </button>
                    
                        @endif

                        <br> 
                            <div id="interviewplanindex">
                                <br>
                                <table id= "example4" class="table t2">
                                    <thead >
                                        <tr>
                                            <th>Scheduled Date</th>
                                            <th>Interviewee</th>
                                            <th>Defences</th>
                                            <th>Facts Already Established</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($interviewplans as $plans)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($plans->interview_date)->format('d/m/Y')}}</td>
                                                <td><?php echo $key=DB::table('tbl_case_interviewees')->where('identification_no',$plans->accused)->value('name'); ?></td>
                                                <td>{{ $plans->defences }}</td>
                                                <td>{{ $plans->facts_established }}</td>
                                                <td>{{ $plans->location }}</td>
                                                <td> 
                                                    @if ($plans->status == 1)
                                                        @if(Auth::user()->role == "Chief")
                                                        <label class="text-success">Submitted for Review</label>
                                                        @else
                                                        <label class="text-success">Sent for Review</label>
                                                        @endif
                                                        @elseif($plans->status == 2)
                                                        <label class="text-success">Reviewed</label>
                                                        @elseif($plans->status == 3)
                                                        <label class="text-success">Summon Order Printed</label>
                                                        @elseif($plans->status == 4)
                                                        <label class="text-success">Report Printed</label>
                                                        @endif
                                                </td>
                                                <td>
                                                    <i onclick="showinterviewplandetails('{{ $plans->id }}')" style="color:grey"  data-toggle="tooltip" data-placement="bottom" title="View"  class="fa fa-eye" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='grey';" ></i> &nbsp; 
                                                    @if(Auth::user()->role == "Investigator")
                                                    <a  href="{{ route('deleteintplan', $plans->id) }}" style="color:red" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='red';" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash"></i></a>&nbsp; 
                                                        @if($plans->status == 2)
                                                             <button  class="btn btn-success btn-sm" title="Generate Summon Order" onclick="showsummonorder('{{ $plans->id }}')">Generate</button>
                                                        @elseif($plans->status == 3)
                                                             <button  class="btn btn-success btn-sm" title="Report" onclick="showinterviewreport('{{ $plans->id }}')">Report</button>
                                                        @endif
                                                    @endif
                                                    @if(Auth::user()->role == "Chief")
                                                        @if($plans->status == 1)
                                                            <button class  = "btn btn-outline-primary btn-sm"  type="button" onclick="showinterviewdtlsreview('{{ $plans->id }}')" data-toggle="tooltip" data-placement="bottom" title="Review">Review</button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    <!--add modal -->
<form method = "POST" action="{{ route('add_interview_plan') }}"  enctype="multipart/form-data" >
      @csrf    
<div class="modal fade" id="addinterviewplan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add Interview Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Interviewee <font color='red'>*</font></label>&nbsp; &nbsp; &nbsp; <i class="fa fa-user-plus" id="AddEntity" color="blue" onclick="showaddperson()" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='blue';" data-toggle="tooltip" data-placement="bottom" title="Add Interviewee"></i>
                                    <select class="form-control" name="interviewaccused" id="interviewaccused" required>
                                        <option value="">Select Interviewee</option>
                                            @foreach ($accused as $ent)
                                                <option value="{{ $ent->identification_no }}">{{ $ent->name }}[CID: {{ $ent->identification_no }}]</option>
                                            @endforeach    
                                    </select> 
                                    <input type="hidden" name="interviewplancasenoidadd" class="form-control" value="{{ $casenoid }}" />                                 
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date of Interview&nbsp;<font color='red'>*</font></label>
                                     <input type="date" id="interviewdate" name="interviewdate" class="form-control" required>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Interviewer <font color='red'>*</font></label>
                                    <select class="form-control" multiple="multiple"   name="interviewers[]" id="interviewers" required>
                                        <option value="">Select Interviewers</option>
                                            @foreach ($interviewers as $int)
                                                <option value="{{ $int->email }}">{{ $int->name }}</option>
                                            @endforeach    
                                    </select>                               
                            </div>
                        </div>                                                
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Location&nbsp;<font color='red'>*</font></label>
                                     <input type="text" id="interviewlocation" name="interviewlocation" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                               <label>Defences&nbsp;<font color='red'>*</font></label>
                                    <textarea class="form-control" name="interviewdefences" id="interviewdefences" rows="3" required></textarea>                                                       
                            </div>
                        </div>                                                
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Facts Already Established&nbsp;<font color='red'>*</font></label>
                                     <textarea class="form-control" name="facts_altready_established_add" id="facts_altready_established_add" rows="3" required></textarea>
                            </div>
                        </div>
                    </div> 
                        <table class="table table-bordered" id="addevidencetable">
                        <thead>
                        <th>Points to Prove</th>
                        <th>Facts to Determine</th>
                        </thead>
                        <tbody id="tablebody">
                            <tr class="row-template">
                                <td>
                                <input class="form-control" type="text" name="interview_points" />
                                </td>
                                <td>
                                <table class="table no-border">
                                    <tbody class="fact-rows">
                                    <tr class="fact-row">
                                        <td>
                                        <input type="text" name="interviewplan_facts[]" class="form-control" />
                                        </td>
                                        <td>
                                        <i class="fa fa-plus" style="color:green" onclick="addFactRow(this)"></i>
                                        <i class="fa fa-minus" style="color:red" onclick="removeFactRow(this)"></i>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table> 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end add modal -->

<!-- edit modal -->
  <form  method = "POST" action="{{ route('updateinterviewplan') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="displayinterviewplanmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Interview Plan Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="interviewplanid" id="interviewplanid">
                    <div id="displayinterviewplandetails" style="display:none">
                            
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Status&nbsp;</label><br>
                                    <select id="status" name="status" class="form-control">
                                        <option>Please choose one</option>
                                        <option value="Reviewed">Reviewed</option>
                                    </select>
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Remarks&nbsp;</label><br>
                                    <textarea id="remarks" name="remarks" class="form-control"></textarea>
                            </div>
                        </div> 
                    </div>
                            
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Update" >Update</button> 
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end edit modal -->

<!-- edit modal -->
  <form  method = "POST" action="{{ route('printsummonorder') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="displaysummonordermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Summon Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="interviewplanidforsummonorder" id="interviewplanidforsummonorder">
                    <div id="displayinterviewplandetailsforsummonorder" style="display:none"></div>

                    <hr style="height: 1px;  background: teal; margin: 10px 0;   box-shadow: 0px 0px 4px 2px rgba(204,204,204,1);">        
                    <div id="displaysummonorder" style="display:none"></div>
                       
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Update" >Print Summon Order</button> 
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end edit modal -->


<!-- edit modal -->
  <form  method = "POST" action="{{ route('displayinterviewreport') }}" enctype="multipart/form-data">
    @csrf 
<div class="modal fade" id="displayinterviewreportmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="interviewplanidforinterviewreport" id="interviewplanidforinterviewreport">
                    <div id="displayinterviewplandetailsinterviewreport" style="display:none"></div>
                    <hr style="height: 1px;  background: teal; margin: 10px 0;   box-shadow: 0px 0px 4px 2px rgba(204,204,204,1);">        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Type of Interview&nbsp;<font color='red'>*</font> </label><br>
                                        <select  name="interviewtype" id="interviewtype" class="form-control" required>
                                            <option value="">Select Type</option>
                                                @foreach ($interviewtypes as $types)
                                                    <option value="{{ $types->interview_type }}">{{ $types->interview_type }}</option>
                                                @endforeach    
                                        </select> 
                                </div>                          
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date &nbsp;<font color='red'>*</font></label><br>
                                      <input class="form-control" type="date" name="interviewdate" required>                              
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Time &nbsp;<font color='red'>*</font></label><br>
                                      <input class="form-control" type="time" name="interviewstarttime" required>                              
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Time &nbsp;<font color='red'>*</font></label><br>
                                      <input type="time" class="form-control"  name="interviewendtime" required> 
                                </div>                          
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Location &nbsp;<font color='red'>*</font></label><br>
                                      <input type="actuallocation" class="form-control"  name="actuallocation" required>                              
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Interview Summary&nbsp;<font color='red'>*</font>&nbsp;</label><br>
                                       <textarea class="form-control" name="interviewsummary" id="interviewsummary" cols="5" required></textarea> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Observation Summary&nbsp;&nbsp;<font color='red'>*</font></label><br>
                                       <textarea class="form-control" name="interviewobservationsummary" id="interviewobservationsummary" cols="5" required></textarea> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Interview Recorded&nbsp;&nbsp;&nbsp;<font color='red'>*</font></label>
                                       <input type="radio" name="interviewrecord"  value="yes" onclick="showrecordeddiv();" required> Yes &nbsp;
                                       <input type="radio" name="interviewrecord" value="no" onclick="shownotrecordeddiv();" required> No  </label>
                                    </label> 
                                </div>
                            </div>
                        </div>
                        <div id="showrecordeddiv" style="display:none">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Interview Recording URL&nbsp;</label>
                                        <input name="recordurl" class="form-control" type="text"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Written Statement&nbsp;&nbsp;&nbsp;&nbsp;<font color='red'>*</font></label>
                                       <input type="radio" name="writtenstatement"  value="yes" onclick="showstatementdiv();" required> Yes &nbsp;
                                       <input type="radio" name="writtenstatement" value="no" onclick="shownostatementdiv();" required> No  </label>
                                    </label> 
                                </div>
                            </div>
                        </div>
                        <div id="showstatementdiv" style="display:none">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Statement Written By&nbsp;</label>
                                        <input name="writtenby" class="form-control" type="text"> 
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Statement Read By&nbsp;</label>
                                        <input name="readby" class="form-control" type="text"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Attach Statement&nbsp;</label>
                                        <input name="statement" class="form-control" type="file"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Update" >Print Interview Report</button> 
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end edit modal -->
<form id="addForminterview" >
    @csrf 
<div class="modal fade" id="addpersondiv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">  
                <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add Person</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><input type="hidden" name="personcasenoidadd" id="personcasenoidadd" value="{{ $casenoid }}">
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Individual Type: </label><br> &nbsp;&nbsp;
                                    <input type="radio" name="persontype"  value="Bhutanese" onclick="showbhutanesediv();"> Bhutanese &nbsp;
                                    <input type="radio" name="persontype" value="NonBhutanese" onclick="shownonbhutanesediv()"> Non Bhutanese  </label>
                            </div>
                        </div>
                            <br>
                        <div id="bhutanesediv" style="display:none"> 
                            <input type="hidden" name="token" id="token" value="d4f6b858-8c7e-3ec7-ab7a-8f6c610a48c4"><br>
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">CID&nbsp;<font color='red'>*</font></label>
                                                <div class = "input-group">
                                                    <input type="text" class="form-control" name="bhutanesecid" placeholder="CID" id="bhutanesecid"  ><button class ="search-btn" type="button" onclick="checkcid('{{ $casenoid }}');">Search</button> <br>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                
                                <div id="showcitizendetailsbhutanese" style="display:none">
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Name&nbsp;<font color='red'>*</font></label>
                                                    <input readonly  name="bhutanesename" id="bhutanesename"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gender&nbsp;<font color='red'>*</font></label>
                                                    <input readonly name="bhutanesegender" id="bhutanesegender"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Date of Birth&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="bhutanesedob" id="bhutanesedob"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Dzongkhag&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="bhutanesedzongkhag" id="bhutanesedzongkhag"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gewog&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="bhutanesegewog" id="bhutanesegewog"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Village&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="bhutanesevillage" id="bhutanesevillage"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Contact Details</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                    <input name="bhutaneseaddress" id="bhutaneseaddress"  class="form-control" type="text" placeholder="Current Address"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;<font color='red'>*</font></label>
                                                    <input name="bhutanesephone" id="bhutanesephone"  class="form-control" type="text" placeholder="Mobile No"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Email&nbsp;</label>(optional)
                                                    <input name="bhutaneseemail" id="bhutaneseemail"  class="form-control" type="text" placeholder="Email"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                </div>

                            </div>
                            <br>
                            <div  id="nonbhutanesediv" style="display:none"> 
                                <div class= "row"> 
                                    <div class   = "col-md-6">
                                        <div class  = "form-group">
                                            <label for   = "exampleInputEmail1">Work Permit&nbsp;<font color='red'>*</font></label>
                                                <div class = "input-group">
                                                    <input type="text" class="form-control" name="nonbhutanesepermit" placeholder="Work Permit Number" id="nonbhutanesepermit"  ><button class ="search-btn" type="button" onclick="getDetailsByPermit();">Search</button> <br>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div id="showcitizendetailsnonbhutanese" style="display:none">
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Name&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="nonbhutanesename" id="nonbhutanesename"  class="form-control" type="text" placeholder="Search CID"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Gender&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="nonbhutanesegender" id="nonbhutanesegender"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Date of Birth&nbsp;<font color='red'>*</font></label>
                                                    <input value="xyz" readonly name="nonbhutanesedob" id="nonbhutanesedob"  class="form-control" type="text" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h3>Permanent Address</h3>
                                    <div class= "row">
                                        <div class   = "col-md-12">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                <textarea name="nonbhutanesepermanentaddress" id="nonbhutanesepermanentaddress"  class="form-control" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h3>Contact Details</h3>
                                    <br>
                                    <div class= "row"> 
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Address&nbsp;<font color='red'>*</font></label>
                                                    <input name="nonbhutaneseaddress" id="nonbhutaneseaddress"  class="form-control" type="text" placeholder="Address"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;<font color='red'>*</font></label>
                                                    <input name="nonbhutanesephone" id="nonbhutanesephone"  class="form-control" type="text" placeholder="Mobile No"/>
                                            </div>
                                        </div>
                                        <div class   = "col-md-4">
                                            <div class  = "form-group">
                                                <label for   = "exampleInputEmail1">Email&nbsp;</label>
                                                    <input name="nonbhutaneseemail" id="nonbhutaneseemail"  class="form-control" type="text" placeholder="Email"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    </div>
                            </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="addmainentity()" name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Save" >Save</button> 
                </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH ADD Person -->
<!-- end edit modal -->
<form id="addForminterview" >
    @csrf 
<div class="modal fade" id="videocallmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">  
                <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Video Call</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                </div>
                
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH ADD Person -->
<!-- end edit modal -->
<form id="addForminterview" >
    @csrf 
<div class="modal fade" id="interviewviewdtlsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">  
                <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Interview Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="interviewidview" name="interviewidview">
                        <div id="showinterviewdetails" style="display:none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH ADD Person -->
<script>
	
    function addnewinterviewplan()
        {
            $('#addinterviewplan').modal('show');  
        }
    
    function showvideocall()
    {
        $('#videocallmodal').modal('show'); 
    }

    function showeditinterviewplan(id)
        {
            $('#interviewplanindex').hide();   
            $('#addinterviewdiv').hide();  
            $('#editinterviewdiv').show(); 
            $('#addinterviewplanbutton').hide();
            $('#closeinterviewplanbutt').show(); 
        }
    function closeinterviewplanadd()
        {
            $('#interviewplanindex').show();   
            $('#addinterviewdiv').hide();  
            $('#editinterviewdiv').hide(); 
            $('#addinterviewplanbutton').show(); 
            $('#closeinterviewplanbutt').hide();
        }
    
    function closeeditinterviewplan()
    {
            $('#interviewplanindex').show();   
            $('#addinterviewdiv').hide();  
            $('#editinterviewdiv').hide(); 
            $('#addinterviewplanbutton').show(); 
            $('#closeinterviewplanbutt').hide();
    }
    function test() {
        
        var html = "<tr><td><input type='text' class='form-control' name='case_evidence[]'></td><td><i class='fa fa-minus' style='color:red' onclick='remove()'></i></td></tr>";
        $('#tablebody').append(html);
    }
    
    function remove() {
        var $tableBody = $('#addevidencetable').find("tbody"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trLast.remove();
    }

    function showinterviewdtlsreview(interviewplanid)
    {
        $('#interviewplanid').val(interviewplanid);
            $('#displayinterviewplanmodal').modal('show');

            var url = '{{ route("displayinterviewplandetails", ":interviewplanid") }}';
                    url = url.replace(':interviewplanid', interviewplanid);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#interviewplanid').val()},
                        success: function(responseText) {
                            
                            $("#displayinterviewplandetails").html(responseText);
                            $("#displayinterviewplandetails").show();
                           
                        }
                    });
    }

    function showsummonorder(interviewplanid)
    {
        $('#interviewplanidforsummonorder').val(interviewplanid);
            $('#displaysummonordermodal').modal('show');

            var url = '{{ route("displayinterviewplandetails", ":interviewplanid") }}';
                    url = url.replace(':interviewplanid', interviewplanid);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#interviewplanidforsummonorder').val()},
                        success: function(responseText) {
                            
                            $("#displayinterviewplandetailsforsummonorder").html(responseText);
                            $("#displayinterviewplandetailsforsummonorder").show();
                           
                        }
                    });

            var url = '{{ route("displaysummonorder", ":interviewplanid") }}';
                    url = url.replace(':interviewplanid', interviewplanid);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#interviewplanidforsummonorder').val()},
                        success: function(responseText) {
                            
                            $("#displaysummonorder").html(responseText);
                            $("#displaysummonorder").show();
                           
                        }
                    });
    }

    function showinterviewreport(interviewplanid)
    {
        $('#interviewplanidforinterviewreport').val(interviewplanid);
            $('#displayinterviewreportmodal').modal('show');

            var url = '{{ route("displayinterviewplandetails", ":interviewplanid") }}';
                    url = url.replace(':interviewplanid', interviewplanid);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#interviewplanidforinterviewreport').val()},
                        success: function(responseText) {
                            
                            $("#displayinterviewplandetailsinterviewreport").html(responseText);
                            $("#displayinterviewplandetailsinterviewreport").show();
                           
                        }
                    });
    }

    function addmainentity() {
            $.ajax({
                url: '{{ route('saveforinterviewentity') }}',
                type: 'POST',
                dataType: 'json',
                data: $('#addForminterview').serialize(),
                success: function(response) {
                    $('#addpersondiv').modal('hide');

                    // Get the dropdown element
                    var dropdown = $('#interviewaccused');

                    // Create a new option element
                    var option = $('<option></option>');

                    // Set the value and text of the option based on the response data
                    option.val(response.data.identification_no);
                    option.text(response.data.name + '[CID: ' + response.data.identification_no + ']');

                    // Append the option to the dropdown
                    dropdown.append(option);

                },
                error: function(xhr, status, error) {
                    // Your code here to handle error response
                }
            });
       }

     function showaddperson()
        {
            $('#addpersondiv').modal('show'); 
        }  

function showbhutanesediv() 
        {
            $('#bhutanesediv').show(1000); 
            $('#nonbhutanesediv').hide();                       
        }

    function shownonbhutanesediv()
        {
            $('#bhutanesediv').hide()
            $('#nonbhutanesediv').show(1000);
        }

        function checkcid(casenoid) {
            var cid = document.getElementById('bhutanesecid').value;
            var url = '{{ route("checkCID", [":cid", ":casenoid"]) }}';
            url = url.replace(':cid', cid);
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                type: "GET",
                url: url,
                success: function(result) {
                if (result.data.length > 0) {
                    alert("Already exists");
                } else {
                    gettoken();
                }
                },
                error: function() {
                alert('An error occurred while fetching data.');
                }
            });
            }

       function gettoken()
       {
         var url = "{{ route('gettoken')}}";
            $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: url,
            success: function (data) {
                console.log(data);
                $('#token').val(data);
            },
            error: function() { 
                console.log('error');
            }
        });

        getDetailsByCID();
       }

    function getDetailsByCID(){
        // console.log(_token);
         var cid = $('#bhutanesecid').val();
         var token = $('#token').val();
        // console.log(cid);
        $('#showcitizendetailsbhutanese').show(700);
        var settings = {
            "url": "https://apim.staging.api.gov.bt/dcrc_citizen_details_api/1.0.0/citizendetails/"+cid,
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Authorization": "Bearer " + token,
                // "Cookie": "route=1658042636.829.53.968004"
            },
        };

        $.ajax(settings).done(function (response) {
            console.log(response.citizenDetailsResponse);
            var data = response.citizenDetailsResponse.citizenDetail[0];
            var middlename;
          if(response.citizenDetailsResponse.citizenDetail[0].middleName == null){
                middlename = '';
            } else {
                middlename = response.citizenDetailsResponse.citizenDetail[0].middleName;
            }
            if(response.citizenDetailsResponse.citizenDetail[0].gender == 'F'){
                gender = 'Female';
            } else {
                 gender = 'Male';
            }
            if(response.citizenDetailsResponse.citizenDetail.length >= 0){
                
                
                $("#bhutanesename").val(response.citizenDetailsResponse.citizenDetail[0].firstName +' '+ middlename +' '+ response.citizenDetailsResponse.citizenDetail[0].lastName); 
                $("#bhutanesedzongkhag").val(response.citizenDetailsResponse.citizenDetail[0].dzongkhagName); 
                $("#bhutanesevillage").val(response.citizenDetailsResponse.citizenDetail[0].gewogName); 
                $("#bhutanesegewog").val(response.citizenDetailsResponse.citizenDetail[0].villageName);
                $("#bhutanesedob").val(response.citizenDetailsResponse.citizenDetail[0].dob); 
                $("#bhutanesegender").val(gender);  
                 

            } else {
                alert('No details found');
            }
        });
        }

        function getDetailsByPermit()
        {
            $('#showcitizendetailsnonbhutanese').show(700);
        }
       
        function showrecordeddiv()
        {
            $('#showrecordeddiv').show();
        }
        function shownotrecordeddiv()
        {
            $('#showrecordeddiv').hide();
        }

        function showstatementdiv()
        {
            $('#showstatementdiv').show();
        }
        function shownostatementdiv()
        {
            $('#showstatementdiv').hide();
        }
        function showzoommeet()
        {
             window.open("https://meet.google.com/", "_blank");
        }

        function showgooglemeet()
        {
             window.open("https://zoom.us/", "_blank");
        }

		function addFactRow(element) {
		  var factRow = element.closest('.fact-row');
		  var newRow = factRow.cloneNode(true);
		  factRow.parentNode.appendChild(newRow);
		}

		function removeFactRow(element) {
		  var factRow = element.closest('.fact-row');
		  factRow.remove();
		}        

        function showinterviewplandetails(id)
        {
           $('#interviewviewdtlsmodal').modal('show');
           $('#interviewidview').val(id);

            var url = '{{ route("showinterviewdetails", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#interviewidview').val()},
                success: function(responseText) {
                    
                    $("#showinterviewdetails").html(responseText);
                    $('#showinterviewdetails').show();   
                }
            });

        }
</script>
<style>
    .modal-header {
    background: linear-gradient(to top, #BFABA2, #ffffff);
    color: #000;
    font-family: Product Sans;
    border-radius: 5px 5px 0 0;
    }
    
.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}

.search-btn {
        background-color: #337ab7;
        color: #fff;
        border: none;
        padding: 8px 16px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s;
}

.search-btn:hover {
  background-color: #286090;
}

.search-btn:focus {
  outline: none;
}
</style>
@endsection