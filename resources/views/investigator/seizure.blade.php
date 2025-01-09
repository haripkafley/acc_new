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
            @include('tabs/searchandseizure_tab')
                    @if(Auth::user()->role == "Investigator")
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="addnewseizure()">
                            <span><i class="fa fa-plus"></i></span>   
                            <span style="font:face:Product Sans">Add Seizure</span>
                        </button>
                    @endif
                        <br> 
                         <br> 
                        <table id = "seizuretable" class="table t2">
                            <thead>
                                <tr>
                                    <!-- <th scope="col">Photo</th> -->
                                    <th scope="col">Category</th>
                                    <th scope="col">Seizure Date</th>
                                    <th scope="col">Seizure Time</th>
                                    <th scope="col">Authorization Type</th>
                                    <th scope="col">Seizure Type</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @if($seizuredtls->count())
                                @foreach ($seizuredtls as $seizures)
                                    <tr> 
                                        <!-- <td></td> -->
                                        <td>{{ $seizures->item_type }}</td>
                                        <td>{{ \Carbon\Carbon::parse($seizures->seizure_date)->format('d/m/Y')}}</td>
                                        <td>{{ date('g:i A', strtotime($seizures->seizure_time)) }}</td>
                                        <td>{{ $seizures->authorization_type }}</td>
                                        <td>{{ $seizures->seizure_type }}</td>
                                        <td>{{ $seizures->status }}</td>
                                        <td>
                                            <i class  = "fa fa-eye"   onclick="viewseizuredtls('{{ $seizures->seizure_id }}')" data-toggle="tooltip" data-placement="bottom" title="View Seizure Details"></i>
                                            @if($seizures->status != "Sent to Forensics")
                                                <button class="btn btn-primary btn-sm" title="Freeze" onclick="sendToForensics({{ $seizures->id }})">Send to Forensics</button>
                                            @endif
                                        </td>
                                    </tr>
                                
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5" style="text-align: center"> No record found </td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>
            </div> 
	</div>
</div>

<!-- add seizure modal -->
 <form action="{{ route('seizureAdd') }}" method="POST">
                @csrf
    <div class="modal fade" id="addnewseizuremodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Seizure</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="casenoidseizureadd" name="casenoidseizureadd" value="{{ $casenoid }}">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Seizure Type: </label><br> &nbsp;&nbsp;
                                    <input type="radio" name="seizuretype"  value="Without Search" onclick="showwithoutsearhdiv();" required> Without Search &nbsp;
                                    <input type="radio" name="seizuretype" value="With Search" onclick="showwithsearchdiv()" required> With Search  </label>
                            </div>
                        </div>
                            <br>
                            <div id="withsearchdiv" style="display:none">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            
                                            <label style="font-family:Product Sans">Search ID&nbsp;<font color='red'>*</font></label>
                                                <div class = "input-group">
                                                        <select class="form-control" name="searchid" id="searchid" >
                                                    <option selected>Select an Option</option>
                                                    @foreach($searchdtls as $dtls)
                                                        <option value="{{ $dtls->search_id}}">{{ $dtls->search_id}} </option>
                                                    @endforeach
                                                </select><button class ="search-btn" type="button" onclick="showsearchdtls()">Search</button><br>
                                                </div>
                                                                                      
                                        </div>                                
                                    </div>
                                </div>
                                <div id="showsearchdtlsdiv"  style="display:none">
                                <div class="row">
                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Accused:&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                     <input type="text" class="form-control" readonly name="searchaccusedname" id="searchaccusedname">
                                </div>

                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Probable Cause:&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" readonly name="searchppcause" id="searchppcause">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Ownership Type:&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                     <input type="text" class="form-control" readonly name="searchownershiptype" id="searchownershiptype">
                                </div>

                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Target Location:&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" readonly name="searchtargetlocation" id="searchtargetlocation">
                                </div>
                            </div>
                                   
                                </div>
                            <hr>
                            
                            </div>
                        <div id ="withoutsearchdiv" style="display:none">
                            <div class="row">
                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Seziure Date:&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="date" class="form-control" name="seziureDate" >
                                </div>

                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Seziure Time:&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="time" class="form-control" name="seziureTime"  >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Seized From (CID):&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" value="" name="seizedCid" >
                                </div> 
                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Seized From (Name):&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" class="form-control" value="" name="seizedName" >
                                </div>
                            </div>
                            <hr>
                        </div>
                        
                        <div id="seizuredtlsdiv" style="display:none">
                        
                            <div class="row">
                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Seziure Date:&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="date" class="form-control" name="seziureDatesearch" >
                                </div>

                                <div class="col-md-2">
                                    <label style="font-family:Product Sans">Seziure Time:&nbsp;<font color='red'>*</font></label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="time" class="form-control" name="seziureTimesearch"  >
                                </div>
                            </div>
                            <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="text-info"><b>Officer Conducting Seize</b>&nbsp;</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                            <label style="font-family:Product Sans">Name:&nbsp;<font color='red'>*</font></label>
                            </div>
                            <div class="col-md-4 form-group">
                                <select class="officers" multiple="multiple"   name="officers[]" id="officers" >
                                    <option value="">Select</option>
                                        @foreach ($officers as $int)
                                            <option value="{{ $int->email }}">{{ $int->name }}</option>
                                        @endforeach    
                                </select>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                            <label style="font-family:Product Sans">Authorization Type:&nbsp;<font color='red'>*</font></label>
                            </div>
                            <div class="col-md-4 form-group">
                                <select class="form-control" name="authorizationtype" id="authorizationtype" >
                                    <option value="">Select</option>
                                    <option value="With Consent">With Consent</option>
                                    <option value="With Warrant">With Warrant</option>    
                                </select>
                            </div>
                        </div>
                         
                        <hr>
                        <div class="col-md-2">
                            <label class="text-info"><b>Witness:</b>&nbsp;<font color='red'>*</font></label>
                        </div>
                            <table class="table table-bordered" id="tasktable">
                                <thead>
                                    <th>Name</th>
                                    <th>CID</th>
                                    
                                </thead>
                                <tbody id="actionplanbody">
                                    <tr>
                                        <td><input type="text" name="witnessname[]" id="witnessname[]" class='form-control'></td>
                                        <td><input type="text" name="witnesscid[]" id="witnesscid[]" class='form-control'></td>
                                        
                                        <td><i class="fa fa-plus" style="color:green" onclick="addtask()"></i></td>    
                                    </tr>
                                </tbody>
                            </table>
                        <h2 class = "card-title text-info"><b>Seizure Details:</b>&nbsp;<font color='red'>*</font></h2>
                            <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-family:Product Sans"><b>Item Type:</b></label>
                                    &nbsp;
                                            @foreach ($typeseizures as $radioButton)
                                                <input type="radio" name="radioButton" id="typeofseizure" value="{{ $radioButton->seizure_type }}" onclick="searchTarget()">
                                                {{ $radioButton->seizure_type }} &nbsp;
                                            @endforeach
                                </div>
                            </div>
                            <br>
                            </div>
                            <div id="emaildiv" style="display:none">
                                <table class="table table-bordered" id="emailTable">
                                                <thead>
                                                    <th>Category</th>
                                                    <th>Email Id</th>
                                                    <th>Password</th>
                                                    <th>Old Password</th>
                                                    <th>Inbox</th>
                                                    <th>Sent</th>
                                                    <th>Draft</th>
                                                    <th>Spam</th>
                                                    
                                                </thead>
                                                <tbody>
                                                </tbody>
                                    </table>
                                </div>
                                <br>
                            <div id="digitalitemdiv" style="display:none">
                                    <table class="table table-bordered" id="digitalitemTable">
                                                <thead>
                                                    <th>Category</th>
                                                    <th>Name</th>
                                                    <th>Manufacturer</th>
                                                    <th>Model</th>
                                                    <th>Serial No</th>
                                                    <th>Condition</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                    </table>
                                </div>
                                <br>
                                <div id="socialmediadiv" style="display:none">
                                <table class="table table-bordered" id="socialmediaTable">
                                                <thead>
                                                    <th>Category</th>
                                                    <th>Platform</th>
                                                    <th>Password</th>
                                                    <th>Old Password</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                    </table>
                                </div>
                                <br>
                                <div id="passportdiv" style="display:none">
                                <table class="table table-bordered" id="passportTable">
                                                <thead>
                                                    <th>Category</th>
                                                    <th>Name</th>
                                                    <th>Passport No</th>
                                                    <th>Issue Date</th>
                                                    <th>Expiry Date</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                    </table>
                                </div>
                                <br>
                                <div id="currencydiv" style="display:none">
                                <table class="table table-bordered" id="currencyTable">
                                                <thead>
                                                    <th>Category</th>
                                                    <th>Amount</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                    </table>
                                </div>
                                <br>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary"  name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Save" >Save</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- show entity details modal -->

<div class="modal fade" id="digitalitemmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Add Digital Items </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><input type="hidden" name="seizureidupdatedetails" id="seizureidupdatedetails" ">
                <div class="modal-body">
                    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Item&nbsp;<font color='red'>*</font></label>
                                    <input name="digitalitem" id="digitalitem"  class="form-control" type="text" placeholder="Item"/>
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Manufacturer&nbsp;<font color='red'>*</font></label>
                                    <input name="manufacturer" id="manufacturer"  class="form-control" type="text" placeholder="Manufacturer"/>
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Model&nbsp;<font color='red'>*</font></label>
                                    <input name="model" id="model"  class="form-control" type="text" placeholder="model"/>
                            </div>
                        </div>
                    </div>
                    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Serial No&nbsp;<font color='red'>*</font></label>
                                    <input name="serialno" id="serialno"  class="form-control" type="text" placeholder="serial no"/>
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Condition&nbsp;<font color='red'>*</font></label>
                                    <input name="condition" id="condition"  class="form-control" type="text" placeholder="condition"/>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="adddigitalitems()" name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Save" >Save</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- end -->

   
<div class="modal fade" id="emailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Add Email </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><input type="hidden" name="seizureidupdatedetails" id="seizureidupdatedetails" >
                <div class="modal-body">
                    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Email&nbsp;<font color='red'>*</font></label>
                                    <input name="emailid" id="emailid"  class="form-control" type="text" placeholder="Email" required/>
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Password&nbsp;<font color='red'>*</font></label>
                                    <input name="password" id="password"  class="form-control" type="text" placeholder="Password" required/>
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Old Password&nbsp;<font color='red'>*</font></label>
                                    <input name="oldpassword" id="oldpassword"  class="form-control" type="text" placeholder="Old Password" required/>
                            </div>
                        </div>
                    </div>
                    <h5>No. of mails (standard folders)</h5>
                    <div class= "row"> 
                        <div class   = "col-md-3">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Inbox&nbsp;<font color='red'>*</font></label>
                                    <input name="inbox" id="inbox"  class="form-control" type="text" placeholder="inbox" required/>
                            </div>
                        </div>
                        <div class   = "col-md-3">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Sent&nbsp;<font color='red'>*</font></label>
                                    <input name="sent" id="sent"  class="form-control" type="text" placeholder="sent" required/>
                            </div>
                        </div>
                        <div class   = "col-md-3">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Draft&nbsp;<font color='red'>*</font></label>
                                    <input name="draft" id="draft"  class="form-control" type="text" placeholder="Draft" required/>
                            </div>
                        </div>
                        <div class   = "col-md-3">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Spam&nbsp;<font color='red'>*</font></label>
                                    <input name="spam" id="spam"  class="form-control" type="text" placeholder="Spam" required/>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="addemail()" name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Save" >Save</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="socialmediamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Add Social Media </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button><input type="hidden" name="seizureidupdatedetails" id="seizureidupdatedetails" >
                </div>
                <div class="modal-body">
                    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Platform&nbsp;<font color='red'>*</font></label>
                                    <input name="platform" id="platform"  class="form-control" type="text" placeholder="platform"/>
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Password&nbsp;<font color='red'>*</font></label>
                                    <input name="socialpassword" id="socialpassword"  class="form-control" type="text" placeholder="Password"/>
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Old Password&nbsp;<font color='red'>*</font></label>
                                    <input name="socialoldpassword" id="socialoldpassword"  class="form-control" type="text" placeholder="Old Password"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="addsocialmedia()" name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Save" >Save</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="passportmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Add Passport </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button><input type="hidden" name="seizureidupdatedetails" id="seizureidupdatedetails" >
                </div>
                <div class="modal-body">
                    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Passport No&nbsp;<font color='red'>*</font></label>
                                    <input name="passportno" id="passportno"  class="form-control" type="text" placeholder="Passport No"/>
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Name&nbsp;<font color='red'>*</font></label>
                                    <input name="passportname" id="passportname"  class="form-control" type="text" placeholder="Name"/>
                            </div>
                        </div>
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Issue Date&nbsp;<font color='red'>*</font></label>
                                    <input name="passportissuedate" id="passportissuedate"  class="form-control" type="date" placeholder="Issue Date"/>
                            </div>
                        </div>
                    </div>
                    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Expiry Date&nbsp;<font color='red'>*</font></label>
                                    <input name="passportexpirydate" id="passportexpirydate"  class="form-control" type="date" placeholder="Expiry Date"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="addpassport()" name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Save" >Save</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="currencymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-secondary">
                    <h5 class="modal-title" >Add Currency</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button><input type="hidden" name="seizureidupdatedetails" id="seizureidupdatedetails" >
                </div>
                <div class="modal-body">
                    <div class= "row"> 
                        <div class   = "col-md-4">
                            <div class  = "form-group">
                                <label for   = "exampleInputEmail1">Amount&nbsp;<font color='red'>*</font></label>
                                    <input name="currencyamt" id="currencyamt"  class="form-control" type="text" placeholder="Amount"/>
                            </div>
                        </div>
                        
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="addcurrency()" name="addButton" id="addButton" data-toggle="tooltip" data-placement="bottom" title="Save" >Save</button> 
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- end -->

    <div class="modal fade" id="showseizuredetailsmodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seizure Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                     <div id="displayseizuredtls" style="display:none">
                                <input type="hidden" name="displayseizuredetailsid" id="displayseizuredetailsid">
                        </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="showseizuredetailsupdatemodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seizure Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                     <div id="displayseizuredtlsupdate" style="display:none">
                            <input type="hidden" name="displayseizuredetailsupdateid" id="displayseizuredetailsupdateid">
                        </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- seizure details -->
    <div class="modal fade" id="showseizuredetailsmodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seizure Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                     <div id="displayseizuredtls" style="display:none">
                                <input type="hidden" name="displayseizuredtlsid" id="displayseizuredtlsid">
                        </div>
                </div>
                
                <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- seizure details -->
 <script>
	
    function addnewseizure()
        {
            $('#addnewseizuremodal').modal('show'); 
        }
    function addtask() 
        {
            html = '<tr>';
            html += '<td><input type="text" name="witnessname[]" id="witnessname[]" class="form-control"></td><td><input type="text" name="witnesscid[]" id="witnesscid[]" class="form-control"></td><td><i class="fa fa-minus" style="color:red" onclick="removetask()"></i></td>'
            html += '</tr>'
            $('#actionplanbody').append(html);
        }
    
    function removetask() 
        {
            var $tableBody = $('#tasktable').find("tbody"),
            $trLast = $tableBody.find("tr:last"),
            $trNew = $trLast.remove();
        }
    
    function searchTarget() 
    {
        var x = $('input[name="radioButton"]:checked').val();

        if(x == 'Digital Items'){
                $('#digitalitemmodal').modal('show');
                $('#emailmodal').modal('hide');
                $('#socialmediamodal').modal('hide');
                $('#passportmodal').modal('hide');  
                $('#currencymodal').modal('hide');
        }
        else if(x == 'Emails'){
                $('#digitalitemmodal').modal('hide');
                $('#emailmodal').modal('show');
                $('#socialmediamodal').modal('hide');
                $('#passportmodal').modal('hide');  
                $('#currencymodal').modal('hide');
        }
        else if(x == 'Social Media'){
                $('#digitalitemmodal').modal('hide');
                $('#emailmodal').modal('hide');
                $('#socialmediamodal').modal('show');
                $('#passportmodal').modal('hide');  
                $('#currencymodal').modal('hide');
        }
        else if(x == 'Passport'){
                $('#digitalitemmodal').modal('hide');
                $('#emailmodal').modal('hide');
                $('#socialmediamodal').modal('hide');
                $('#passportmodal').modal('show');  
                $('#currencymodal').modal('hide');
            
        }
        else {
                $('#digitalitemmodal').modal('hide');
                $('#emailmodal').modal('hide');
                $('#socialmediamodal').modal('hide');
                $('#passportmodal').modal('hide');  
                $('#currencymodal').modal('show');
            
        }
    }

    function addemail() {
            var category = "Email";
            var email = $('#emailid').val();
            var pwd = $('#password').val();
            var oldpwd = $('#oldpassword').val();
            var inbox = $('#inbox').val();
            var sent = $('#sent').val();
            var draft = $('#draft').val();
            var spam = $('#spam').val();
            var newRow = '<tr><td><input type="hidden" id="emailcategory[]" name="emailcategory[]" value="'+category+'">' + category + '</td><td><input type="hidden" id="emailid[]" name="emailid[]" value="'+email+'">' + email + '</td><td><input type="hidden" id="password[]" name="password[]" value="'+pwd+'">' + pwd + '</td><td><input type="hidden" id="oldpwd[]" name=oldpwd[]" value="'+category+'">' + oldpwd + '</td><td><input type="hidden" id="inbox[]" name="inbox[]" value="'+inbox+'">' + inbox + '</td><td><input type="hidden" id="sent[]" name="sent[]" value="'+sent+'">' + sent + '</td><td><input type="hidden" id="draft[]" name="draft[]" value="'+draft+'">' + draft + '</td><td><input type="hidden" id="spam[]" name="spam[]" value="'+spam+'">' + spam + '</td></tr>';
                $('#emailTable tbody').append(newRow);
                $('#emailmodal input').val('');
                 $('#emailmodal').modal('hide');
                 //$('#emaildiv').show();
      }
      function adddigitalitems() {
            var category = "Digital Items";
            var itemname = $('#digitalitem').val();
            var manufacturer = $('#manufacturer').val();
            var model = $('#model').val();
            var serialno = $('#serialno').val();
            var condition = $('#condition').val();
            var newRow = '<tr><td><input type="hidden" id="digitalcategory[]" name="digitalcategory[]" value="'+category+'">' + category + '</td><td><input type="hidden" id="digitalname[]" name="digitalname[]" value="'+itemname+'">'+ itemname + '</td><td><input type="hidden" id="manufacturer[]" name="manufacturer[]" value="'+manufacturer+'">' + manufacturer + '</td><td><input type="hidden" id="model[]" name="model[]" value="'+model+'">' + model + '</td><td><input type="hidden" id="serialno[]" name="serialno[]" value="'+serialno+'">' + serialno + '</td><td><input type="hidden" id="condition[]" name="condition[]" value="'+condition+'">' + condition + '</td></tr>';
                $('#digitalitemTable tbody').append(newRow);
                $('#digitalitemmodal input').val('');
                 $('#digitalitemmodal').modal('hide');
                // $('#digitalitemdiv').show();
      }

      function addsocialmedia() {
            var category = "Social Media";
            var platform = $('#platform').val();
            var socialpassword = $('#socialpassword').val();
            var socialoldpassword = $('#socialoldpassword').val();
            
            var newRow = '<tr><td><input type="hidden" id="socialmediacategory[]" name="socialmediacategory[]" value="'+category+'">' + category + '</td><td><input type="hidden" id="platform[]" name="platform[]" value="'+platform+'">' + platform + '</td><td><input type="hidden" id="socialpassword[]" name="socialpassword[]" value="'+socialpassword+'">' + socialpassword + '</td><td><input type="hidden" id="socialoldpassword[]" name="socialoldpassword[]" value="'+socialoldpassword+'">' + socialoldpassword + '</td></tr>';
                $('#socialmediaTable tbody').append(newRow);
                $('#socialmediamodal input').val('');
                 $('#socialmediamodal').modal('hide');
                 //$('#socialmediadiv').show();
      }

      function addpassport() {
            var category = "Passport";
            var passportno = $('#passportno').val();
            var passportname = $('#passportname').val();
            var passportissuedate = $('#passportissuedate').val();
            var passportexpirydate = $('#passportexpirydate').val();
            
            var newRow = '<tr><td><input type="hidden" id="passportcategory[]" name="passportcategory[]" value="'+category+'">' + category + '</td><td><input type="hidden" id="passportno[]" name="passportno[]" value="'+passportno+'">' + passportno + '</td><td><input type="hidden" id="passportname[]" name="passportname[]" value="'+passportname+'">' + passportname + '</td><td><input type="hidden" id="passportissuedate[]" name="passportissuedate[]" value="'+passportissuedate+'">' + passportissuedate + '</td><td><input type="hidden" id="passportexpirydate[]" name="passportexpirydate[]" value="'+passportexpirydate+'">' + passportexpirydate + '</td></tr>';
                $('#passportTable tbody').append(newRow);
                $('#passportmodal input').val('');
                 $('#passportmodal').modal('hide');
                 //$('#passportdiv').show();
      }

      function addcurrency() {
            var category = "Currency";
            var currencyamt = $('#currencyamt').val();
            
            var newRow = '<tr><td><input type="hidden" id="currencycategory[]" name="currencycategory[]" value="'+category+'">' + category + '</td><td><input type="hidden" id="currencyamt[]" name="currencyamt[]" value="'+currencyamt+'">' + currencyamt + '</td></tr>';
                $('#currencyTable tbody').append(newRow);
                $('#currencymodal input').val('');
                 $('#currencymodal').modal('hide');
                 //$('#currencydiv').show();
      }

      function viewseizuredtls(seizure_id)
        {
            $('#displayseizuredetailsid').val(seizure_id);
             $('#showseizuredetailsmodal').modal('show'); 

            var url = '{{ route("viewseizuredetails", ":seizure_id") }}';
                    url = url.replace(':seizure_id', seizure_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#displayseizuredetailsid').val()},
                        success: function(responseText) {
                            
                            $("#displayseizuredtls").html(responseText);
                            $("#displayseizuredtls").show();
                            
                        }
                    });
        }
    function showseizuredtlsupdate(seizure_id)
        {
            $('#displayseizuredetailsupdateid').val(seizure_id);
             $('#showseizuredetailsupdatemodal').modal('show'); 

            var url = '{{ route("viewseizuredetailsupdate", ":seizure_id") }}';
                    url = url.replace(':seizure_id', seizure_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#displayseizuredetailsupdateid').val()},
                        success: function(responseText) {
                            
                            $("#displayseizuredtlsupdate").html(responseText);
                            $("#displayseizuredtlsupdate").show();
                            
                        }
                    });
                    
        }

        function showwithoutsearhdiv() 
        {
            $('#withoutsearchdiv').show(1000); 
            $('#seizuredtlsdiv').show(1000);
            $('#withsearchdiv').hide();                       
        }

    function showwithsearchdiv()
        {
            $('#withoutsearchdiv').hide();
            $('#seizuredtlsdiv').show(1000); 
           
            $('#withsearchdiv').show();  
        }
    
    function showsearchdtls()
    {
        var dropdown = document.getElementById('searchid');
         var selectedValue = dropdown.value;

         var url = '{{ route("getsearchdtls", ":selectedValue") }}';
                        url = url.replace(':selectedValue', selectedValue);
                        
                        $.ajax({
                            
                            type:"GET",
                            url: url,
                            data: {search: $('#selectedValue').val()},
                            success: function(result) {
                                console.log(result);
                                console.log(result.data[0].suspect);
                                    $('#showsearchdtlsdiv').show(500);
                                    $('#searchaccusedname').val(result.data[0].name);
                                    $('#searchppcause').val(result.data[0].cause_name);
                                    $('#searchownershiptype').val(result.data[0].ownership_type);
                                    $('#searchtargetlocation').val(result.data[0].searchtarget);
                                    $('#seizuredtlsdiv').show(1000);
                                
                            },
                            error: function() {
                                alert('An error occurred while fetching data.');
                            }
                        });
        }

        function showseizuredetails(id)
        {
            $('#displayseizuredtlsid').val(search_id);
             $('#showseizuredetailsmodal').modal('show'); 

            var url = '{{ route("viewsearchdetails", ":search_id") }}';
                    url = url.replace(':search_id', search_id);
                    
                    $.ajax({
                        
                        type:"GET",
                        url: url,
                        data: {search: $('#displayseizuredtlsid').val()},
                        success: function(responseText) {
                            
                            $("#displayseizuredtls").html(responseText);
                            $("#displayseizuredtls").show();
                            
                        }
                    });
        }

        function sendToForensics(seizureId) {
        // Use JavaScript to redirect the user to the specified route
       window.location.href = "{{ route('updateseizurestatus', ['seizure_id' => ':seizure_id']) }}".replace(':seizure_id', seizureId);
    }
        
</script>

<style>
    .modal-header {
    background: linear-gradient(to top, grey, #ffffff);
    color: #fff;
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