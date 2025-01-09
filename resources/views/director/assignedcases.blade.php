@extends('layouts.admin')

@section('content')
<br>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="tab-container">
                        <div class="card-header">
                            <div class="tab-header">
                                <div class="tab-item {{ Request::routeIs('directornonassigned') ? 'active' : '' }}">
                                    <a href="{{ route('directornonassigned') }}">Pending Assignment</a>
                                </div>
                                <div class="tab-item {{ Request::routeIs('directorassigned') ? 'active' : '' }}">
                                    <a href="{{ route('directorassigned') }}">Assigned</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- tab content -->
                                    <button type="button" id="addcasebtn" name="addcasebtn" class="btn btn-info btn-sm" style="float:right" onclick="addnewcasedirector()">
                                        <span><i class="fa fa-plus"></i></span>
                                        <span style="font:face:Product Sans">Add Case</span>
                                    </button>
                                    <br><br>
                                    <table id  = "casetableassigned" class="table t2" >
                                            <thead>
                                                <tr>
                                                    <th>Case No</th>
                                                    <th >Case Title</th>
                                                    <th>Status</th>
                                                    <th>Days in Queue</th>
                                                    <th>Running Days</th>
                                                    <th>Assigned To</th>
                                                    <th>Assigned On</th>                  
                                                    <th class="lastchild">Action</th>            
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if($allcases->count())
                                                @foreach ($allcases as $case)  
                                                @php
                                                $specialrecords = DB::table('tbl_user_role_mapping')
                                                    ->where('case_no_id', $case->id)
                                                    ->where('conflictstatus', '<>', 0)
                                                    ->whereIn('role', ['Team Leader', 'Team Member', 'Legal Representative','Chief'])
                                                    ->count();
                                                @endphp
                                                <tr>
                                                    <td>{{ $case->case_no }}</td>
                                                    <td class="narrow-td">
                                                        @if($case->assigned_status=="Assignment Order Printed")
                                                            <u><a class  = "link-info" href="{{ route('casesummary',$case->id) }}" data-toggle="tooltip" data-placement="bottom" title="Case Details"><font color="#007BFF">{{ $case->case_title }}</font></a></u>
                                                        @else
                                                        {{ $case->case_title }}
                                                        @endif                                                    
                                                    </td>
                                                    @if ($case->sub_status== "")
                                                    <td >Assigned to Chief</td> 
                                                     @elseif ($case->sub_status== "Active")
                                                        <td><b>{{ $case->status }}<font color="green"> [{{ $case->sub_status }}] </font></b></td> 
                                                    @else
                                                        <td><b>{{ $case->status }}<font color="red"> [{{ $case->sub_status }}] </font></b></td> 
                                                    @endif
                                                    <td>{{ date_diff(new \DateTime($case->creation_date), new \DateTime())->format("%d days"); }}</td>
                                                    <td></td>
                                                    <td>
                                                        @if($case->branch == "Select Branch")
                                                            Special Team
                                                        @else
                                                        {{ $case->branch }}
                                                        @endif
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($case->creation_date)->format('d/m/Y')}}</td> 
                                                    <td> 
                                                        @if($case->investigation_type == "Normal")
                                                            @if($case->assigned_status=="2" )
                                                            <button type="button" class="btn btn-info btn-xs" onclick="show_modal_chief_coi('{{ $case->id }}')" name="coi" data-toggle="tooltip" data-placement="bottom" title="View COI">Manage COI</button>
                                                            @endif
                                                            <button type="button" class="btn btn-success btn-xs" onclick="show_modal_reassign('{{ $case->id }}','{{ $case->branch }}')" name="Reassign" data-toggle="tooltip" data-placement="bottom" title="Reassign">Reassign</button> 
                                                        @endif
                                                        @if($case->investigation_type == "Special")
                                                            @if($case->assigned_status=="10" && $specialrecords >= 2)
                                                                <button type="button" class="btn btn-info btn-xs" onclick="show_modal_coi_together('{{ $case->id }}')" name="coi" data-toggle="tooltip" data-placement="bottom" title="View COI">Manage COI</button>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach  
                                            @else
                                                <tr>
                                                    <td colspan="8" style="text-align: center"> No record found </td>
                                                </tr>
                                            @endif           
                                            </tbody>
                                        </table>
                                <!-- end tab content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- add case modal -->

   <form class="submitaddcase" method = "POST" action="{{ route('registercase') }}" enctype="multipart/form-data" >
        @csrf
        <div class="modal fade" id="addcasedetailsdiv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog custom-dialog-size" role="document">
                <div class="modal-content custom-modal-content">
                    <div class="modal-header custom-modal-header"  style="height: 50px;">
                        <h6 class="modal-title" id="exampleModalLabel">
                            <ul class="nav " id="myTabs" role="tablist">
                                        <li class="tab">
                                            <a class="tab active" id="tab1-tab"  href="#tab1" role="tab" aria-controls="tab1" aria-selected="true" disabled>General</a>
                                        </li>
                                        <li class="tab">
                                            <a class="tab" id="tab2-tab"  href="#tab2" role="tab" aria-controls="tab2" aria-selected="false" disabled>Allegations</a>
                                        </li>
                                        <li class="tab">
                                            <a class="tab" id="tab3-tab"  href="#tab3" role="tab" aria-controls="tab3" aria-selected="false" disabled>Subject</a>
                                        </li>
                                            <li class="tab">
                                            <a class="tab" id="tab4-tab"  href="#tab4" role="tab" aria-controls="tab4" aria-selected="false" disabled>COI</a>
                                        </li>
                                        <li class="tab">
                                            <a class="tab" id="tab5-tab"  href="#tab5" role="tab" aria-controls="tab5" aria-selected="false" disabled>Assign</a>
                                        </li>
                                    </ul>
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body custom-modal-body">
                             
                                    <div class="tab-content" id="myTabContent">
                                        
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                            <!-- general -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                        <label style="font-family:Product Sans">Source&nbsp;<font color='red'>*</font></label>
                                                            <select class="form-control" onchange="displaycaseno()"  name="source_add" id="source_add" >
                                                                <option value="">Select Source</option>
                                                                    @foreach ($sources as $sourcetype)
                                                                        <option value="{{ $sourcetype->source_type }}">{{ $sourcetype->source_type }}</option>
                                                                    @endforeach    
                                                            </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-family:Product Sans">Case ID&nbsp;<font color='red'>*</font></label>
                                                        <input type="text" readonly name="case_no_add"  class="form-control " id="case_no_add" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="agency_name" style="display:none;">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-family:Product Sans">Agency Name &nbsp;<font color='red'>*</font></label>
                                                        <input type="text" name="agency_name_add"  class="form-control " id="agency_name_add"  >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                         <label style="font-family:Product Sans">Case No&nbsp;<font color='red'>*</font></label>
                                                           <input type="text" name="case_id_add"  class="form-control " id="case_id_add" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                       <label style="font-family:Product Sans">Case Title&nbsp;<font color='red'>*</font></label>
                                                        <input type="text" name="case_title_add"  class="form-control" id="case_title_add" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                       <label style="font-family:Product Sans">Case Creation Date&nbsp;<font color='red'>*</font></label>
                                                        <input type="date" name="case_reg_no_add"  class="form-control" id="case_reg_no_add" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-family:Product Sans">Sector Type&nbsp;<font color='red'>*</font></label>
                                                            <select class="form-control" name="sector_type_add" id="sector_type_add" >
                                                                <option value="">Select Type</option>
                                                                    @foreach ($sector as $sect)
                                                                        <option value="{{ $sect->sector_type }}">{{ $sect->sector_type }}</option>
                                                                    @endforeach    
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                         <label style="font-family:Product Sans">Sector&nbsp;<font color='red'>*</font></label>
                                                            <select class="form-control" name="sector_subtype_add" id="sector_subtype_add" >
                                                                <option value="">Select Type</option>
                                                                    @foreach ($subsector as $sectsub)
                                                                        <option value="{{ $sectsub->sector_name }}">{{ $sectsub->sector_name }}</option>
                                                                </option>
                                                                    @endforeach    
                                                            </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-family:Product Sans">Area&nbsp;<font color='red'>*</font></label>
                                                            <select class="form-control" name="area_add" id="area_add" >
                                                                <option value="">Select Type</option>
                                                                    @foreach ($area as $areas)
                                                                        <option value="{{ $areas->area_name }}">{{ $areas->area_name }}</option>
                                                                </option>
                                                                    @endforeach    
                                                            </select>
                                                    </div>
                                                </div> 
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-family:Product Sans">Institution Type&nbsp;<font color='red'>*</font></label>
                                                            <select class="form-control" name="institution_type_add" id="institution_type_add" >
                                                                <option value="">Select Type</option>
                                                                    @foreach ($institutiontype as $inst)
                                                                        <option value="{{ $inst->institution_type }}">{{ $inst->institution_type }}</option>
                                                                    @endforeach    
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        <!-- general -->
                                            <div style="text-align: center;">
                                                <a style="color: #5E6366;" onclick="nextone()"><i class="fa fa-arrow-circle-right" data-toggle="tooltip" data-placement="bottom" title="Next"></i> Next</a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade " id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                            <!-- allegation -->
                                            <div class="row">
                                                <div class = "col-md-12 ">
                                                    <div class  = "form-group">
                                                        <label style="font-family:Product Sans">Probable Offence&nbsp;<font color='red'>*</font></label>
                                                            <select class="offencetype" multiple="multiple"   name="offence_type_add[]" id="offence_type_add" >
                                                                <option value="">Select Offence Type</option>
                                                                    @foreach ($offencetypes as $offence)
                                                                        <option >{{ $offence->offence_type }}</option>
                                                                    @endforeach    
                                                            </select>
                                                    </div>
                                                </div>   
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for  = "exampleInputEmail1">Allegation Details<font color='red'>*</font></label>
                                                            <textarea id  = "allegation_details_add" placeholder="Allegation Details"  type="text" class="form-control" name="allegation_details_add"  required ></textarea>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label style="font-family:Product Sans">Allegation Document<font color='red'>*</font></label>
                                                            <table class="table table-bordered" id="allegationtable">
                                                                <thead>
                                                                    <th>Name</th>
                                                                    <th>Document</th>
                                                                </thead>
                                                                <tbody id="allegationdocbody">
                                                                    <tr>
                                                                        <td><input type="text" name="allegation_doc_name[]" id="allegation_doc_name" class='form-control'></td>
                                                                        <td><input type="file" class="form-control" id="allegation_doc" name="allegation_doc[]"   ></td>
                                                                        <td><i class="fa fa-plus" style="color:green" onclick="addallegationdocs()"></i></td>    
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div style="text-align: center;">
                                                <a style="color:#5E6366"  onclick="previousone()" >Previous &nbsp;<i class='fa fa-arrow-circle-left'  data-toggle="tooltip" data-placement="bottom" title="Previous"></i> &nbsp;</a>
                                                <a style="color: #5E6366;" onclick="nexttwo()"><i class="fa fa-arrow-circle-right" data-toggle="tooltip" data-placement="bottom" title="Next"></i> Next</a>
                                            </div>
                                            
                                        <!-- allegation -->
                                        </div>
                                        <div class="tab-pane fade " id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                            <!-- subject -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label style="font-family:Product Sans">Subject</label> <br>
                                                        <div class = "input-group">
                                                        <input type="text" class="form-control" name="cid" placeholder="Search CID/Permit/License No" id="cid"  ><button class ="search-btn" type="button" onclick="SearchEntity();">Search</button>  &nbsp; &nbsp; &nbsp; <i class="fa fa-user-plus" id="AddEntity" style="float:right;display:none"; color="blue" onclick="showaddperson()" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='blue';" data-toggle="tooltip" data-placement="bottom" title="Add Entity"></i><br>
                                                        </div>
                                                </div>   
                                            </div>
                                            <br>
                                            <div id= "show_accused_party" style="display:none">
                                                <div class= "row">
                                                    <div class  = "col-md-12">
                                                        <div class  = "form-group">
                                                            <table id="entitytable" class="table table-bordered">
                                                                <thead>
                                                                        <tr>
                                                                            <th>ID Photo</th>
                                                                            <th>Name</th>
                                                                            <th>Cid</th> 
                                                                            <th>DOB</th>
                                                                            <th>Nationality</th>
                                                                            <th>Gender</th>
                                                                            <th>Subject Category</th> 
                                                                            <th>Action</th>                                                 
                                                                        </tr>
                                                                </thead>
                                                                <tbody id="searchResults">
                                                                </tbody>
                                                            </table> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- subject -->
                                    
                                    <form id="SubmitForm" >
                                        @csrf 
                                        <div id="persondiv" style="display:none" class="floating-div">
                                            <span class="close-button" onclick="closediv()">X</span>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label style="font-family:Product Sans"> Subject with this ID is not found in the database. You are required to create new entity in the system first. </label><br> &nbsp;&nbsp;
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label style="font-family:Product Sans">Individual Type: </label><br> &nbsp;&nbsp;
                                                        <input type="radio" name="persons" id="persons"  value="Bhutanese" onclick="showbhutanesediv();"> Bhutanese &nbsp;
                                                        <input type="radio" name="persons" id="persons" value="NonBhutanese" onclick="shownonbhutanesediv()"> Non Bhutanese  
                                                    </label>
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
                                                                        <input type="text" class="form-control" name="bhutanesecid" placeholder="CID" id="bhutanesecid"  ><button class ="search-btn" type="button" onclick="checkcid();">Search</button> <br>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    
                                                    <div id="showcitizendetailsbhutanese" style="display:none">
                                                        <div class= "row"> 
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Name&nbsp;<font color='red'>*</font></label>
                                                                        <input readonly  name="bhutanesename" id="bhutanesename"  class="form-control" type="text" />
                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Gender&nbsp;<font color='red'>*</font></label>
                                                                        <input readonly name="bhutanesegender" id="bhutanesegender"  class="form-control" type="text" />
                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Date of Birth&nbsp;<font color='red'>*</font></label>
                                                                        <input value="xyz" readonly name="bhutanesedob" id="bhutanesedob"  class="form-control" type="text" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class= "row"> 
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Dzongkhag&nbsp;<font color='red'>*</font></label>
                                                                        <input value="xyz" readonly name="bhutanesedzongkhag" id="bhutanesedzongkhag"  class="form-control" type="text" />
                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Gewog&nbsp;<font color='red'>*</font></label>
                                                                        <input value="xyz" readonly name="bhutanesegewog" id="bhutanesegewog"  class="form-control" type="text" />
                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Village&nbsp;<font color='red'>*</font></label>
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
                                                                    <label style="font-family:Product Sans">Address&nbsp;<font color='red'>*</font></label>
                                                                        <input name="bhutaneseaddress" id="bhutaneseaddress"  class="form-control" type="text" placeholder="Current Address"/>
                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Phone/Mobile Number&nbsp;<font color='red'>*</font></label>
                                                                        <input name="bhutanesephone" id="bhutanesephone" class="form-control" type="number" placeholder="Mobile No" title="Please enter exactly 8 digits" oninput="javascript: if (this.value.length > 8) this.value = this.value.slice(0, 8);">

                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Email&nbsp;</label>(optional)
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
                                                                <label style="font-family:Product Sans">Work Permit&nbsp;<font color='red'>*</font></label>
                                                                    <input name="nonbhutanesepermit" id="nonbhutanesepermit" onchange="getDetailsByPermit()" class="form-control" type="text" placeholder="Search Permit"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div id="showcitizendetailsnonbhutanese" style="display:none">
                                                        <div class= "row"> 
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Name&nbsp;<font color='red'>*</font></label>
                                                                        <input value="xyz" readonly name="nonbhutanesename" id="nonbhutanesename"  class="form-control" type="text" placeholder="Search CID"/>
                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Gender&nbsp;<font color='red'>*</font></label>
                                                                        <input value="xyz" readonly name="nonbhutanesegender" id="nonbhutanesegender"  class="form-control" type="text" />
                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Date of Birth&nbsp;<font color='red'>*</font></label>
                                                                        <input value="xyz" readonly name="nonbhutanesedob" id="nonbhutanesedob"  class="form-control" type="text" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <h3>Permanent Address</h3>
                                                        <div class= "row">
                                                            <div class   = "col-md-12">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">&nbsp;</label>
                                                                    <textarea name="nonbhutanesepermanentaddress" id="nonbhutanesepermanentaddress"  class="form-control" rows="5"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h3>Contact Details</h3>
                                                        <br>
                                                        <div class= "row"> 
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Address&nbsp;<font color='red'>*</font></label>
                                                                        <input name="nonbhutaneseaddress" id="nonbhutaneseaddress"  class="form-control" type="text" placeholder="Address"/>
                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Phone/Mobile Number&nbsp;<font color='red'>*</font></label>
                                                                        <input name="nonbhutanesephone" id="nonbhutanesephone"  class="form-control" type="number" placeholder="Mobile No"/>
                                                                </div>
                                                            </div>
                                                            <div class   = "col-md-4">
                                                                <div class  = "form-group">
                                                                    <label style="font-family:Product Sans">Email&nbsp;</label>
                                                                        <input name="nonbhutaneseemail" id="nonbhutaneseemail"  class="form-control" type="text" placeholder="Email"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        </div>
                                                </div>
                                            <br>
                                            <button type="button" class="btn btn-outline-primary" onclick="addmainentity()" name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Save" style="float:right">Save</button> 
                                        </div>
                                        </form>
                                        <div style="text-align: center;">
                                                <a style="color:#5E6366"  onclick="previoustwo()" >Previous &nbsp;<i class='fa fa-arrow-circle-left'  data-toggle="tooltip" data-placement="bottom" title="Previous"></i> &nbsp;</a>
                                                <a style="color: #5E6366;" onclick="nextthree()"><i class="fa fa-arrow-circle-right" data-toggle="tooltip" data-placement="bottom" title="Next"></i> Next</a>
                                        </div>
                                        
                                        </div>
                                        <div class="tab-pane fade " id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                                            <!-- coi -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    <h4> <i class="fa fa-edit"></i>Conflict of Interest Declaration </h4>&nbsp;&nbsp;
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label style="font-family:Product Sans">Do you have conflict of interest with any of the alledged person/the case? &nbsp;&nbsp;
                                                            <input type="radio" name="persontype"  value="yes" onclick="showcoidiv();"> Yes &nbsp;
                                                        <input type="radio" name="persontype" value="no" onclick="dontshowcoidiv()"> No  </label>
                                                        <input type="hidden" name="yesno" id="yesno">
                                                    </div>
                                                </div>
                                                <br><br>
                                                
                                                <div class= "row" id="coidiv" style="display:none"> 
                                                    <div class   = "col-md-12">
                                                        <div class  = "form-group">
                                                            <label style="font-family:Product Sans">Nature of COI&nbsp;<font color='red'>*</font></label>
                                                                <textarea id="summernote" name="coidirector" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div> 
                                            <!-- coi -->
                                            <div style="text-align: center;">
                                                <a style="color:#5E6366"  onclick="previousthree()" >Previous &nbsp;<i class='fa fa-arrow-circle-left'  data-toggle="tooltip" data-placement="bottom" title="Previous"></i> &nbsp;</a>
                                                <a style="color: #5E6366;" onclick="nextfour()"><i class="fa fa-arrow-circle-right" data-toggle="tooltip" data-placement="bottom" title="Next"></i> Next</a>
                                            </div>
                                        
                                            
                                        </div>
                                        <div class="tab-pane fade " id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                                            <!-- assign -->
                                            <div class= "row"> 
                                                <div class   = "col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-family:Product Sans">Priority&nbsp;<font color='red'>*</font></label>
                                                        <select class="form-control"   name="priority_add" id="priority_add" >
                                                            <option>Select Priority</option>
                                                                @foreach ($priority as $priority)
                                                                    <option value   = "{{ $priority->priority_type }}">{{ $priority->priority_type }}</option>
                                                                    </option>
                                                                @endforeach    
                                                        </select>
                                                    </div>		                  			
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class   = "col-md-12">
                                                    <div class  = "form-group">
                                                        <label style="font-family:Product Sans">Remarks/Instructions&nbsp;<font color='red'>*</font></label>
                                                        <textarea placeholder="Remarks"  type="text" class="form-control" name="remarks_add" id="remarks_add" class=""   ></textarea>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="font-family:Product Sans">Investigation Type&nbsp;<font color='red'>*</font></label>
                                                            <select class="form-control"   name="investigation_type_add" id="investigation_type_add"  onchange="toggleinvestigationtype()">
                                                                <option value="">Select Investigation Type</option>
                                                                    @foreach ($investigationtype as $invtype)
                                                                        <option >{{ $invtype->name }}</option>
                                                                </option>
                                                                @endforeach    
                                                            </select> 
                                                    </div> 
                                                </div>
                                                <div class   = "col-md-6" id="showbranch" style="display:none">
                                                    <div class  = "form-group">
                                                        <label style="font-family:Product Sans">Assign to&nbsp;<font color='red'>*</font></label>
                                                            <select class    = "form-control" name="branch" id="branch" onchange="displaynames()">
                                                                <option>Select Branch</option>
                                                                    @foreach ($branches as $branch)
                                                                        <option value   = "{{ $branch->branch_name }}">{{ $branch->branch_name }}</option>
                                                                    @endforeach    
                                                            </select>
                                                            
                                                    </div>
                                                </div>    
                                            </div>
                                            <div id="showteamselection" style="display:none">
                                                <div class= "row">
                                                    <div class  = "col-md-10">
                                                        <div class  = "form-group">
                                                            <table class="table table-bordered" id="teamdetails">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Role</th>                                                 
                                                                    </tr>
                                                                </thead>   
                                                                <tbody >
                                                                    <tr >
                                                                        <td>
                                                                            <select class  = "form-control" name="teammemberassign[]" id="teammemberassign" onchange="showadhoc()">
                                                                                <option>Select Team Members</option>
                                                                                    @foreach ($usersspecial as $userusers)
                                                                                        <option value   = "{{ $userusers->email }}">{{ $userusers->name }}&nbsp; [ {{ $userusers->role }}, {{ $userusers->branch }}] </option>                                                                       </option>
                                                                                    @endforeach 
                                                                                <option>Adhoc</option>   
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select class  = "form-control" name="teamrolesassign[]" id="teamrolesassign" >
                                                                                <option>Select Role</option>
                                                                                <option value   = "Team Member">Team Member</option>
                                                                                <option value   = "Team Leader">Team Leader</option>
                                                                                <option value   = "Legal Representative">Legal Representative</option> 
                                                                                <option value   = "Chief">Supervisor<ption> 
                                                                            </select>
                                                                        </td>   
                                                                        <td>   
                                                                            <button type="button"  class="btn btn-warning" onclick="addmorenew()" name="add" data-toggle="tooltip" data-placement="bottom" title="Add More"><i class="fa fa-plus"></i></button>
                                                                            <button type="button"  class="btn btn-warning" onclick="removenew()" name="add" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="fa fa-minus"></i></button>
                                                                        </td>                                         
                                                                    </tr>
                                                                </tbody>
                                                            </table>    
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id= "showdivisionheaddetails" style="display:none">
                                                <div class= "row">
                                                    <div class  = "col-md-12">
                                                        <div class  = "form-group">
                                            
                                                            <table class="table table-bordered">
                                                                    <thead>
                                                                            <tr>
                                                                                <th>Name</th>
                                                                                <th>Designation</th>                                                 
                                                                            </tr>
                                                                    </thead>
                                                                        
                                                                    <tbody id="headdetails">
                                                                    
                                                                    </tbody>
                                                            </table> 
                                                        
                                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="text-align: center;">
                                                    <a style="color:#5E6366"  onclick="previousfour()" >Previous &nbsp;<i class='fa fa-arrow-circle-left'  data-toggle="tooltip" data-placement="bottom" title="Previous"></i> &nbsp;</a>
                                                </div>
                                                <br><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                
                                                                
                                                                <!-- <a style="display:none" href="" class="btn btn-info btn-xs" id="addcasespecial" >Print Assignment Order</a> -->
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                            <!-- assign -->
                                            
                                            <button style="float:right;" type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button> 
                                            <input type="submit" style="float:right;" class="btn btn-primary btn-sm" value="Create" id="addcase" onclick="checkfields()"> &nbsp;
                                        </div>
                                    </div>   
                                    
                    </div>
                    <div class="modal-footer custom-modal-footer">
                        
                                               
                    </div>
                </div>
            </div>
        </div>
</form>
<!-- end add case -->

<!-- VIEW COI CHIEF-->

<form method = "POST" action="{{route('proceed_chief')}}"   enctype="multipart/form-data" >
    @csrf  

        <div class="modal fade" id="showmodal_coi_chief" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" >
                <div class="modal-content">
                    <div class="modal-header alert-info" style="background-color: #B4B5BD">
                        <h5 class="modal-title" id="exampleModalLabel">Manage COI</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="casedetailsall" style="display:none;"></div>
                                <input id = "case_no_id_coi_chief" class="form-control"  type="hidden" name="case_no_id_coi_chief" placeholder="Case No"  >
                        <hr>
                        <div id="coi_show_chief" style="display:none;"></div>
                       <hr>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="reassignbtn" >ReAssign</button> 
                        <button type="submit" class="btn btn-primary" >Proceed</button>
                                               
                    </div>
                </div>
            </div>
        </div>
</form>

<!-- END VIEW COI -->

<!-- show entity details modal -->
<div class="modal fade" id="show_entitydtls_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Entity Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value=""  name="entityidaddcase" id="entityidaddcase">
                        <div id="entitydetailsshowaddcase" style="display:none;"></div>
                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end -->
<!-- Reassign -->

<form method = "POST" action="{{ route('reassigncase') }}"  >
        @csrf     

      <div class="modal fade" id="modal_reassign_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info" style="background-color: #B4B5BD">
                    <h5 class="modal-title" id="exampleModalLabel">Reassign Case</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        
                        <input type="hidden" name="casenoid_reassign" id="casenoid_reassign">
                        <div id="allegationandaccusedreassigncase" style="display:none;"></div>
                        <hr>
                        <div id="reassigndiv" style="display:none;">  </div>

                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-xs" onclick="return validateForm();">ReAssign</button>

                </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH REASSIGN -->
    <!-- VIEW COI TOGETHER-->

	<form method = "POST" action="{{ route('printassignmentorder') }}" enctype="multipart/form-data" >
			@csrf  

			<div class="modal fade" id="coitogethermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl modal-dialog-scrollable" >
					<div class="modal-content">
						<div class="modal-header alert-info" style="background-color: #B4B5BD"><h5 class="modal-title" id="exampleModalLabel">Manage COI</h5>
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span> </button>
						</div>
						<div class="modal-body">
						    <input id = "case_no_id_coi_together" class="form-control"  type="hidden" name="case_no_id_coi_together"   >
                            <input id = "reassignmentstatus" class="form-control"  type="hidden" name="reassignmentstatus"  value="">
                                <div id="casedetailsdivtogether" style="display:none;"></div>
	                            <hr>
							        <div id="coi_show_together" style="display:none;"></div>    
                                    <hr>
                                       
						</div>
					
						<div class="modal-footer">
                                <button type="submit"  class="btn btn-primary" >PRINT ASSIGNMENT ORDER</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											
						</div>
					</div>
				</div>
			</div>
	</form>

<style>
    
  .floating-div {
    position: fixed;
    top: 40%;
    left: 45%;
    transform: translate(-50%, -50%);
    width: 900px;
    max-height: 70%; /* Adjust to fit the content and maintain scrollability */
    background-color: #f0f0f0;
    padding: 10px;
    border: 2px solid #ccc;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 2;
    overflow: auto;
  }


.close-button {
    cursor: pointer;
    position: absolute;
    top: 5px;
    right: 5px;
  }

.tab-header {
    display: flex;
    justify-content: left;
    align-items: left;
    font-family : Product Sans;
    
}

.tab-item {
    margin-right: 10px;
    
}

.tab-item a {
    text-decoration: none;
    color: #333;
    padding: 10px;
}

.tab-item.active a {
    color: #000;
    border-bottom: 5px solid blue;
}

.tab-content {
    padding: 10px;
    background-color: #fff;
}
.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
    
}

.t2 tbody th
{
    vertical-align: middle;
}
.t2 tbody th,
.t2 tbody td {
  padding: 0.35rem; /* Adjust the padding as needed */
  font-size: 0.9rem; /* Adjust the font size as needed */
  vertical-align: middle;
  /* text-align: center; */
}

.lastchild {
    width: 150px; /* Adjust the font size as needed */
    vertical-align: middle;
  }

.tab {
		display: inline-block;
		padding: 3px;
        font-size: 20px;
		margin-right: 3px;
		color: #555;
		text-decoration: none;
		font-family: Product Sans;
		border-bottom: 2px solid transparent;
		transition: border-bottom-color 0.3s ease;
		}

	.tab.active {
  		color: #000;
  		border-bottom-color: blue;
	}

    .tab.completed {
  		color: green;
  		color: blue;
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

#addcasedetailsdiv .modal-dialog.custom-dialog-size {
    height: 90vh;
   max-width: 90%; 
    margin: auto; /* Center the modal both horizontally and vertically */
    margin-top: 50px; /* Adjust the top margin as needed */
    margin-bottom: 50px; /* Adjust the bottom margin as needed */
}

#addcasedetailsdiv .custom-modal-content {
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden; /* Hide any content overflow */
}

#addcasedetailsdiv .custom-modal-body {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 15px;
    width: 100%; /* Ensure the content doesn't exceed the modal's width */
}

#addcasedetailsdiv .custom-modal-footer {
    flex: 0 0 auto;
    background-color: #f7f7f7;
    padding: 10px 15px;
    border-top: 1px solid #d1d1d1;
    width: 100%; /* Ensure the footer spans the full width */
}

.narrow-td 
    {
        width: 200px; /* Change this value to your desired width */
       
    }

</style>
<script>
    // $("#myTabs").prop('disabled', true);

    function validateForm() {
    const newBranchSelect = document.getElementById('new_branch');
    const reason = document.getElementById('reason_reassign');
    
    if (newBranchSelect.value === "") {
        alert("Please select a new branch.");
        return false; // Prevent form submission
    }
    
    if (reason.value === "") {
        alert("Please provide a reason for the reassignment.");
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}

    
    function closediv() 
    {
        document.getElementById("persondiv").style.display = "none";
    }

    function addnewcasedirector()
        {
            $('#addcasedetailsdiv').modal('show');
        }
    
    function nextone()
    {
        var activeTab = $(".tab.active");
        var source          =   document.getElementById("source_add").value;
        var caseno          =   document.getElementById("case_id_add").value;
        var sectortype      =   document.getElementById("sector_type_add").value;
        var sectorsubtype   =   document.getElementById("sector_subtype_add").value;
        var casetitle       =   document.getElementById("case_title_add").value;
        var area            =   document.getElementById("area_add").value;
        var date            =   document.getElementById("case_reg_no_add").value;
        var institution     =   document.getElementById("institution_type_add").value;

        var nextTab = activeTab.parent().next().find("a.tab");

        if (source === "") {
        alert("Please fill in source");
        event.preventDefault(); // Prevent form submission
        }
         else if(caseno === ""){
          alert("Please fill in case no");
        event.preventDefault(); // Prevent form submission
        }
         else if(casetitle === ""){
          alert("Please fill in Case title");
        event.preventDefault(); // Prevent form submission
        }
         else if(date === ""){
          alert("Please fill in case creation date");
        event.preventDefault(); // Prevent form submission
        }
         else if(sectortype === ""){
          alert("Please fill in sector");
        event.preventDefault(); // Prevent form submission
        }
         else if(sectorsubtype === ""){
          alert("Please fill in sector type");
        event.preventDefault(); // Prevent form submission
        }
        else if(area === ""){
          alert("Please fill in area");
        event.preventDefault(); // Prevent form submission
        }
         else if(institution === ""){
          alert("Please fill in institution type");
        event.preventDefault(); // Prevent form submission
        }
           else {
        if (nextTab.length) {
            activeTab.removeClass("active");
            activeTab.addClass("completed");
            nextTab.addClass("active");
            $(activeTab.attr("href")).removeClass("show active");
            
            $(nextTab.attr("href")).tab("show");
            var activeTabElement = document.querySelector(prevTab.attr("href"));
            activeTabElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
    }
    function nexttwo()
    {
        var activeTab = $(".tab.active");
        console.log(activeTab);

        var nextTab = activeTab.parent().next().find("a.tab");
        console.log(nextTab);

        var offences        =   document.getElementById("offence_type_add").value;
        var allegation      =   document.getElementById("allegation_details_add").value;
        var allegationdoc   =   document.getElementById("allegation_doc").value;

        if (offences === "") {
        alert("Please fill in offence");
        event.preventDefault(); // Prevent form submission
        }
         else if(allegation === ""){
          alert("Please fill in allegation");
        event.preventDefault(); // Prevent form submission
        }
         else if(allegationdoc === ""){
          alert("Please fill in atleast one allegation document");
        event.preventDefault(); // Prevent form submission
        }
        else{
        if (nextTab.length) {
            activeTab.removeClass("active");
            activeTab.addClass("completed");
            nextTab.addClass("active");
            $(activeTab.attr("href")).removeClass("show active");
            $(nextTab.attr("href")).tab("show");
        }
        }
    }
    function nextthree()
    {
        var activeTab = $(".tab.active");
        console.log(activeTab);

        var nextTab = activeTab.parent().next().find("a.tab");
        console.log(nextTab);

        var subject   =   document.getElementById("entitytable");

        if (subject.querySelectorAll('tr').length === 0) {
            alert("Please fill in subject");
            event.preventDefault(); // Prevent form submission
        } else {

        if (nextTab.length) {
            activeTab.removeClass("active");
            activeTab.addClass("completed");
            nextTab.addClass("active");
            $(activeTab.attr("href")).removeClass("show active");
            $(nextTab.attr("href")).tab("show");
        }
    }
    }
    function nextfour()
    {
        var activeTab = $(".tab.active");
        console.log(activeTab);

        var nextTab = activeTab.parent().next().find("a.tab");
        console.log(nextTab);

        var coi   =   document.getElementById("yesno").value;

        if (coi === "") {
        alert("Please select one");
        event.preventDefault(); // Prevent form submission
        }
        else{
        if (nextTab.length) {
            activeTab.removeClass("active");
            activeTab.addClass("completed");
            nextTab.addClass("active");
            $(activeTab.attr("href")).removeClass("show active");
            $(nextTab.attr("href")).tab("show");
        }
        }
    }

    function previousone()
    {
        var activeTab = $(".tab.active");
        var prevTab = activeTab.parent().prev().find("a.tab");

        var source          =   document.getElementById("source_add").value;
        var sectortype      =   document.getElementById("sector_type_add").value;
        var sectorsubtype   =   document.getElementById("sector_subtype_add").value;
        var casetitle       =   document.getElementById("case_title_add").value;
        var area            =   document.getElementById("area_add").value;
        var date            =   document.getElementById("case_reg_no_add").value;
        var institution     =   document.getElementById("institution_type_add").value;
        
        if (prevTab.length) {
        activeTab.removeClass("active");
        prevTab.addClass("active");
        $(activeTab.attr("href")).removeClass("show active");
        $(prevTab.attr("href")).tab("show");
        }
    }

    function previoustwo()
    {
        var activeTab = $(".tab.active");
        var prevTab = activeTab.parent().prev().find("a.tab");

        if (prevTab.length) {
        activeTab.removeClass("active");
        prevTab.addClass("active");
        $(activeTab.attr("href")).removeClass("show active");
        $(prevTab.attr("href")).tab("show");
        }
    }

    function previousthree()
    {
        var activeTab = $(".tab.active");
        var prevTab = activeTab.parent().prev().find("a.tab");

        if (prevTab.length) {
        activeTab.removeClass("active");
        prevTab.addClass("active");
        $(activeTab.attr("href")).removeClass("show active");
        $(prevTab.attr("href")).tab("show");
        }
    }
    function previousfour()
    {
        var activeTab = $(".tab.active");
        var prevTab = activeTab.parent().prev().find("a.tab");

        

        if (prevTab.length) {
        activeTab.removeClass("active");
        
        prevTab.addClass("active");
        $(activeTab.attr("href")).removeClass("show active");
        $(prevTab.attr("href")).tab("show");
        }
    }

    function displaycaseno()
        {
            var sourceName = $('#source_add').val(); 

            if(sourceName == "Reactive (Agency Referral)")
            {
                $('#agency_name').show(); 
            }
            else
            {
                $('#agency_name').hide(); 
            }
            var url = '{{ route("generateCaseno", ":sourceName") }}';
                url = url.replace(':sourceName', sourceName);
                    $.ajax({
                        type:"GET",
                        url: url,
                        data: {search: $('#sourceName').val()},
                        success: function(data) {
                        $('#case_no_add').val(data);
                    },
                    error:function(e){
                        console.log(e,'error');
                    }
                });
        }

            function SearchEntity()
            {
               var cid = $("#cid").val();
               if(cid == "")
               {
                alert("Please enter CID to search");
               }
               else{
            
            
                var url = '{{ route("searchentity", ":cid") }}';
                        url = url.replace(':cid', cid);
                        
                        $.ajax({
                            
                            type:"GET",
                            url: url,
                            data: {search: $('#cid').val()},
                            success: function(result) {
                            if (result.data !== null && result.data.length > 0)
                                {
                                    var id = result.data[0].id;
                                    var existingRecord = $('#searchResults tr[data-id="' + id + '"]');
                                    if (existingRecord.length === 0) 
                                        {
                                            var dateOfBirth = new Date(result.data[0].dateofbirth);
                                            var day = dateOfBirth.getDate();
                                            var month = dateOfBirth.getMonth() + 1; 
                                            var year = dateOfBirth.getFullYear();

                                            day = (day < 10 ? '0' : '') + day;
                                            month = (month < 10 ? '0' : '') + month;

                                            var formattedDateOfBirth = day + '/' + month + '/' + year;

                                            html  = '<tr>';
                                            html += '<td>No Photo</td>';
                                            html += '<td><input type="hidden" id="entityname[]" name="entityname[]" value="'+result.data[0].name+'">'+result.data[0].name+'</td>';
                                            html += '<td><input type="hidden" id="entitycid[]" name=entitycid[]" value="'+result.data[0].identification_no+'">'+result.data[0].identification_no+'</td>';
                                            html += '<td><input type="hidden" id="entitydob[]" name="entitydob[]" value="'+ formattedDateOfBirth +'">'+ formattedDateOfBirth +'</td>';
                                            html += '<td><input type="hidden" id="entitynationality[]" name=entitynationality[]" value="'+result.data[0].type+'">'+result.data[0].type+'</td>';
                                            html += '<td><input type="hidden" id="entitygender[]" name=entitygender[]" value="'+result.data[0].gender+'">'+result.data[0].gender+'</td>';
                                            html += '<td><select name="partytype[]" id="partytype[]" class="form-control"><option selected value="Witness">Witness</option><option value="Accused">Accused</option><option value="Victim">Victim</option><option value="Complainant">Complainant</option><select></td>';
                                            html += '<td><i class="fa fa-eye" onclick="viewentitydetailsaddcase('+result.data[0].id+')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details">&nbsp;</i> &nbsp;<i class="fa fa-trash" onclick="removefromtable('+result.data[0].id+')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="Remove"></i></td>';       
                                            $('#show_accused_party').show(500);
                                            $('#searchResults').append(html);
                                            $('#cid').val('');
                                        } 
                                        else 
                                        {
                                            alert('Record with the same ID already exists');
                                        }
                                }
                                else
                                {
                                    document.getElementById("persondiv").style.display = "block";
                                }
                            },
                            error: function() {
                                alert('An error occurred while fetching data.');
                            }
                        });
                    }
            }
        
    function showcoidiv()
            {
                var result = warn(); 
            }

        function warn() {
            
                if (confirm('Are you sure you want to declare COI ?')) 
                {
                    $('#coidiv').show(); 
                    $('#yesno').val("Yes");
                }
                else
                {
                    $('#coidiv').hide(); 
                    $('#yesno').val("No");
                }
            }

        function dontshowcoidiv()
            {
                $('#coidiv').hide(); 
                $('#yesno').val("No");
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
    
    function checkcid() {
            var cid = document.getElementById('bhutanesecid').value;
            var url = '{{ route("checkCIDcreatecase", [":cid"]) }}';
            url = url.replace(':cid', cid);

            $.ajax({
                type: "GET",
                url: url,
                success: function(result) {
                if (result.data.length > 0) {
                    alert("Already exists");
                    cid == "";
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
                $('#token').val(data);
            },
            error: function() { 
                console.log('error');
            }
        });

        getDetailsByCID();
       }

    function getDetailsByCID(){
         var cid = $('#bhutanesecid').val();
         var token = $('#token').val();
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

             var dobString = response.citizenDetailsResponse.citizenDetail[0].dob;
            var parts = dobString.split('/');

            if (parts.length === 3) {
            var year = parts[2];
            var month = String(parts[1]).padStart(2, '0'); 
            var day = String(parts[0]).padStart(2, '0'); 

            var sqlFormattedDate = year + '-' + month + '-' + day;

            }
            if(response.citizenDetailsResponse.citizenDetail.length >= 0){
                
                
                $("#bhutanesename").val(response.citizenDetailsResponse.citizenDetail[0].firstName +' '+ middlename +' '+ response.citizenDetailsResponse.citizenDetail[0].lastName); 
                $("#bhutanesedzongkhag").val(response.citizenDetailsResponse.citizenDetail[0].dzongkhagName); 
                $("#bhutanesevillage").val(response.citizenDetailsResponse.citizenDetail[0].gewogName); 
                $("#bhutanesegewog").val(response.citizenDetailsResponse.citizenDetail[0].villageName);
                $("#bhutanesedob").val(sqlFormattedDate); 
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

        function enablesavebutton()
        {
            var saveButton = document.getElementById("addButton");
            saveButton.disabled = false;
        }
       
        function addmainentity() {
            var selectedOption = $("input[name='persons']:checked").val();

                if (selectedOption === "Bhutanese") {
                    var bhutaneseaddress = $("#bhutaneseaddress").val();
                    var bhutanesephone = $("#bhutanesephone").val();

                    if (bhutaneseaddress === "") {
                        alert("Please fill up address.");
                        return false;
                    }
                    if (bhutanesephone === "") {
                        alert("Please fill up phone no.");
                        return false;
                    }

                    var bhutanesename      = $('#bhutanesename').val();
                    var bhutanesegender    = $('#bhutanesegender').val();
                    var bhutanesedob       = $('#bhutanesedob').val();
                    var bhutanesedzongkhag = $('#bhutanesedzongkhag').val();
                    var bhutanesegewog     = $('#bhutanesegewog').val();
                    var bhutanesevillage   = $('#bhutanesevillage').val();
                    var bhutaneseaddress   = $('#bhutaneseaddress').val();
                    var bhutanesephoneno   = $('#bhutanesephoneno').val();
                    var bhutaneseemail     = $('#bhutaneseemail').val();
                    var persontype         = selectedOption;
                    var bhutanesecid       = $('#bhutanesecid').val();
                    
                    $.ajax({
                    url: "/savemainentity",
                    type:"POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        bhutanesename:bhutanesename,
                        bhutanesegender:bhutanesegender,
                        bhutanesedob:bhutanesedob,
                        bhutanesedzongkhag:bhutanesedzongkhag,
                        bhutanesegewog:bhutanesegewog,
                        bhutanesevillage:bhutanesevillage,
                        bhutaneseaddress:bhutaneseaddress,
                        bhutanesephoneno:bhutanesephoneno,
                        bhutaneseemail:bhutaneseemail,
                        persontype: persontype,
                        bhutanesecid:bhutanesecid
                        
                    },
                    success:function(result){
                        html = '<tr>';
                        html += '<td>No Photo</td>';
                        html += '<td><input type="hidden" id="entityname[]" name="entityname[]" value="'+result.data.name+'">'+result.data.name+'</td>';
                        html += '<td><input type="hidden" id="entitycid[]" name=entitycid[]" value="'+result.data.identification_no+'">'+result.data.identification_no+'</td>';
                        html += '<td><input type="hidden" id="entitycid[]" name=entitycid[]" value="'+result.data.dateofbirth+'">'+result.data.dateofbirth+'</td>';
                        html += '<td><input type="hidden" id="entitynationality[]" name=entitynationality[]" value="'+result.data.type+'">'+result.data.type+'</td>';
                        html += '<td><input type="hidden" id="entitygender[]" name=entitygender[]" value="'+result.data.gender+'">'+result.data.gender+'</td>';
                        html += '<td><select name="partytype[]" id="partytype[]" class="form-control"><option value="Witness">Witness</option><option value="Accused">Accused</option><option value="Victim">Victim</option><option value="Complainant">Complainant</option><select></td>';
                        html += '<td><i class="fa fa-eye" onclick="viewentitydetailsaddcase('+result.data.id+')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details">&nbsp;</i> &nbsp;<i class="fa fa-trash" onclick="viewentitydetailsaddcase('+result.data.id+')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="Remove"></i></td>';       
                        $('#show_accused_party').show(500);
                        $('#searchResults').append(html);
                        document.getElementById("persondiv").style.display = "none";
                        Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Status updated successfully',
                                    showConfirmButton: false,
                                    timer: 1500 })
                        },
                        error: function(result) {
                            alert("error");
                        },
                        });
                

                    } else if (selectedOption === "NonBhutanese") {
                        var nonbhutanesepermanentaddress = $("#nonbhutanesepermanentaddress").val();
                        var nonbhutanesephone = $("#nonbhutanesephone").val();

                        if (nonbhutanesepermanentaddress === "") {
                            alert("Please fill up permanent address");
                            return false;
                        }
                        if (nonbhutanesephone === "") {
                            alert("Please fill up phone no.");
                            return false;
                        }
                    } else {
                        alert("Please select an individual type.");
                        return false;
                    }

       }
        function toggleinvestigationtype()
            {
                $option = $('#investigation_type_add').val(); 
                
                if($option == "Normal")
                {
                $('#showbranch').show();
                $('#showteamselection').hide();
                
                }

                if($option == "Special")
                {
                $('#showteamselection').show();
                $('#showdivisionheaddetails').hide();
                $('#showbranch').hide();
                
                }
            }

        function displaynames()
            {
                var branch = $('#branch').val(); 

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('showdivisionheads')}}",
                    type: "GET",
                    data:{
                        'branch' : branch 
                        },
                    success:function(result){
                            html = '<tr>';
                            html += '<td>'+result.name+'</td>';
                            html += '<td>'+result.position+'</td>';
                            $('#showdivisionheaddetails').show(100);
                            $('#showteamselection').hide();
                            $('#headdetails').append(html);
                    },
                    error:function(e){
                        console.log(e,'error');
                    }
                });
            }

function show_modal_chief_coi(casenoid)
{
    $('#case_no_id_coi_chief').val(casenoid);
    $('#showmodal_coi_chief').modal('show');
    var button = $('#reassignbtn');
    button.on('click', function() {
    show_modal_reassign(casenoid);
  });

     var url = '{{ route("showcasedetailsforcoi", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_coi_chief').val()},
                success: function(responseText) {
                    
                    $("#casedetailsall").html(responseText);
                    $("#casedetailsall").show();
                    
                }
            });

            var url = '{{ route("viewcoi_chief", ":casenoid") }}';
                    url = url.replace(':casenoid', casenoid);

                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#case_no_id_coi_chief').val()},
                        success: function(responseText) {
                            
                            $("#coi_show_chief").html(responseText);
                            $("#coi_show_chief").show();
                            
                        }
                    });
}

function viewentitydetailsaddcase(id){
    
        $('#entityidaddcase').val(id);
        $('#show_entitydtls_details').modal('show');
    

   var url = '{{ route("showentitydetails", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#entityidaddcase').val()},
                success: function(result) {
                    
                    $("#entitydetailsshowaddcase").html(result);
                    $("#entitydetailsshowaddcase").show();
                    
                }
            });

}

function show_modal_reassign(casenoid,branch)
                {
                
                $('#casenoid_reassign').val(casenoid);
            
                $('#modal_reassign_show').modal('show');

                var url = '{{ route("showcasedetailsforcoi", ":casenoid") }}';
                    url = url.replace(':casenoid', casenoid);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#casenoid_reassign').val()},
                        success: function(responseText) {
                            
                            $("#allegationandaccusedreassigncase").html(responseText);
                            $("#allegationandaccusedreassigncase").show();
                            
                        }
                    });

                    var url = '{{ route("showcasedetailsforreassigncasedirector", ":casenoid") }}';
                    url = url.replace(':casenoid', casenoid);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#casenoid_reassign').val()},
                        success: function(responseText) {
                            
                            $("#reassigndiv").html(responseText);
                            $("#reassigndiv").show();
                            
                        }
                    });

                }

                function addmorenew()
            {
                var $tableBody = $('#teamdetails').find("tbody"),
                $trLast = $tableBody.find("tr:last"),
                $trNew = $trLast.clone();
                $trLast.after($trNew);
            }   
        
        function removenew()
            {
                var $tableBody = $('#teamdetails').find("tbody"),
                $trLast = $tableBody.find("tr:last"),
                $trNew = $trLast.remove();
            }

            function show_modal_coi_together(casenoid,reassignmentstatus)
        {
            $('#case_no_id_coi_together').val(casenoid);
            $('#reassignmentstatus').val(reassignmentstatus);
            $('#coitogethermodal').modal('show');
            
            var url = '{{ route("showcasedetailsforcoi", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_coi_together').val()},
                success: function(responseText) {
                    
                    $("#casedetailsdivtogether").html(responseText);
                    $("#casedetailsdivtogether").show();
                    
                }
            });

             var url = '{{ route("viewcoitogether_special", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_coi_together').val()},
                success: function(responseText) {
                    
                    $("#coi_show_together").html(responseText);
                    $("#coi_show_together").show();
                    
                }
            });
        }
        
		function addallegationdocs() {
        
        html = '<tr>';
        html += '<td><input class="form-control" type="text" name="allegation_doc_name[]" id="allegation_doc_name[]" class="form-control"></td><td><input type="file" class="form-control file-input" name="allegation_doc[]" id="allegation_doc"></td><td><i class="fa fa-minus" style="color:red" onclick="removeallegationdoc()"></i></td>'
        html += '</tr>'

        $('#allegationdocbody').append(html);
    }
    
    function removeallegationdoc() 
    {
        var $tableBody = $('#allegationtable').find("tbody"),
        $trLast = $tableBody.find("tr:last"),
        $trNew = $trLast.remove();
    }

    function checkfields()
        {
            var priority        =   document.getElementById("priority_add").value;
            var invtype         =   document.getElementById("investigation_type_add").value;
            var remarks         =   document.getElementById("remarks_add").value;

            if ( priority === "")
            {
                alert("Please fill priority.");
                event.preventDefault();
            } 
            else if( invtype === "")
            {
                alert("Please fill investigation type.");
                event.preventDefault();
            }
            else if(remarks === "") {
                alert("Please fill in remarks.");
                event.preventDefault(); // Prevent form submission
            } else {
                var confirmation = confirm("Are you sure you want to submit this form?");
                if (!confirmation) {
                event.preventDefault(); // Prevent form submission
                }
            }
        }
</script>
@endsection