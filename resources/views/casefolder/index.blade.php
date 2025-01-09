@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Case List </div>
                        <div class = "card-body">
                            <div  class="table-responsive-lg">
                                <table id  = "maintable" class="table t2" >
                                    <thead>
                                        <tr>
                                            <th>Case ID.</th>
                                            <th>Case No.</th>
                                            <th>Case Title</th>
                                            <th>Case Status</th>
                                            <th>Running Days</th>
                                            <th>Date Opened</th>                            
                                            <th>Action</th>            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($showassignedcases->count())
                                            @foreach ($showassignedcases as $case)  
                                            
                                            <tr>
                                                <td>{{ $case->case_no }}</td>
                                                <td>{{ $case->case_id }}</td>
                                                <td>
                                                    @if($case->assigned_status=="Assignment Order Printed")
                                                        <u><a class  = "link-info" href="{{ route('casesummary',$case->id) }}" data-toggle="tooltip" data-placement="bottom" title="Case Details"><font color="#007BFF">{{ $case->case_title }}</font></a></u>
                                                    @else
                                                        {{ $case->case_title }}
                                                    @endif
                                                </td>
                                                <td>
                                                
                                                @if($case->sub_status =="Open")
                                                    <b>{{ $case->status }}<font color="green"> [{{ $case->sub_status }}] </font></b>
                                                @else
                                                    <b>{{ $case->status }}</b>
                                                @endif
                                                </td>
                                                
                                                <td></td>
                                                
                                                <td>{{ \Carbon\Carbon::parse($case->creation_date)->format('d/m/Y')}}</td> 
                                                <td>
                                                    @if($case->investigation_type== "Normal")
                                                        @if($case->role=="Chief")
                                                            @php
                                                                $records = DB::table('tbl_user_role_mapping')
                                                                ->where('case_no_id', $case->id)
                                                                ->where('conflictstatus', '<>', 0)
                                                                ->whereIn('role', ['Team Leader', 'Team Member', 'Legal Representative'])
                                                                ->count();
                                                            @endphp
                                                                @if($case->assigned_status==4)
                                                                    <button type="button" class="btn btn-info btn-xs" onclick="show_reassigncase_modal_chief('{{ $case->id }}')" name="coi" data-toggle="tooltip" data-placement="bottom" title="Reassign">Reassign</button>
                                                                
                                                                @elseif($case->assigned_status==1 && $case->conflictstatus==0)
                                                                    <button type="button" class="btn btn-info btn-xs" onclick="show_modal_coi('{{ $case->id }}')" name="coi" data-toggle="tooltip" data-placement="bottom" title="Declare COI">Declare COI</button>
                                                                @elseif($case->assigned_status==3 && $case->conflictstatus==1)
                                                                    <button type="button" class="btn btn-info btn-xs" onclick="show_assigncase_modal_chief('{{ $case->id }}')" name="coi" data-toggle="tooltip" data-placement="bottom" title="Assign">Assign</button>
                                                                @endif
                                                                @if( $records == 3 && $case->assigned_status==4)
                                                                    <button type="button" class="btn btn-info btn-xs" onclick="show_modal_coi_together('{{ $case->id }}','{{ $case->reassignmentstatus }}')" name="declare_coi_together" data-toggle="tooltip" data-placement="bottom" title="Manage COI">Manage COI</button>
                                                                @endif
                                                        @endif
                                                        @if($case->role=="Team Member" || $case->role=="Team Leader" || $case->role=="Legal Representative")
                                                                @if($case->assigned_status== 4 && $case->conflictstatus == 0 )
                                                                    <button type="button" class="btn btn-info btn-xs" onclick="show_modal_declare_coi('{{ $case->id }}')" name="declare_coi" data-toggle="tooltip" data-placement="bottom" title="Declare COI">Declare COI</button>
                                                                   
                                                                @endif
                                                        @endif
                                                @endif
                                                @if($case->investigation_type == "Special")
                                                            @if($case->role=="Chief")
                                                                @if($case->conflictstatus == 0 )
                                                                <button type="button" class="btn btn-info btn-xs" onclick="show_modal_coi_special('{{ $case->id }}')" name="coi" data-toggle="tooltip" data-placement="bottom" title="Manage COI">Manage COI</button>
                                                                @endif
                                                            @endif
                                                            @if($case->role=="Team Member" || $case->role=="Team Leader" || $case->role=="Legal Representative")
                                                                @if($case->conflictstatus == 0 )
                                                                    <button type="button" class="btn btn-info btn-xs" onclick="show_modal_declare_coi('{{ $case->id }}')" name="declare_coi" data-toggle="tooltip" data-placement="bottom" title="Declare COI">Declare COI</button>
                                                                @endif
                                                            @endif
                                                @endif
                                                </td>
                                            </tr>
                                            @endforeach  
                                            @else
                                                <tr>
                                                    <td colspan="8" style="text-align:center"> No record found </td>
                                                </tr>
                                            @endif           
                                        </tbody>
                                    </div>
                                </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Declare COI -->

	<form method = "POST" action="{{ route('declarecoichief') }}" enctype="multipart/form-data" >
										@csrf  

			<div class="modal fade" id="coichiefmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl modal-dialog-scrollable" >
					<div class="modal-content">
						<div class="modal-header alert-info" style="background-color: #B4B5BD" style="background-color: #B4B5BD"><h5 class="modal-title" id="exampleModalLabel">Declare COI</h5>
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span> </button>
						</div>
						<div class="modal-body">
						    <input id = "case_no_id_coi" class="form-control"  type="hidden" name="case_no_id_coi" placeholder="Case No"  >
                                <div id="casedetailsdiv" style="display:none;"></div>
	                            <hr>
							        <div id="coi_show" style="display:none;"></div>    
                                    <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label style="font-family:Product Sans">Do you have conflict of interest with any of the alledged person/the case? &nbsp;&nbsp;
                                                    <input type="radio" name="alfabet"  value="yes" onclick="showcoidiv();"> Yes &nbsp;
                                                <input type="radio" name="alfabet" value="no" onclick="dontshowcoidiv()"> No  </label>
                                                <input type="hidden" name="yesno" id="yesno">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class= "row" id="coidiv" style="display:none"> 
                                            <div class   = "col-md-12">
                                                <div class  = "form-group">
                                                    <label style="font-family:Product Sans" for   = "exampleInputEmail1">Nature of COI&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="coichief" id="coichief" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div> 
						</div>
					
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" onclick="return validateForm();">Declare COI</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											
						</div>
					</div>
				</div>
			</div>
	</form>

	<!-- END VIEW COI -->

    <!-- Declare COI SPECIAL -->

	<form method = "POST" action="{{ route('declarecoichief_special') }}" enctype="multipart/form-data" >
										@csrf  
			<div class="modal fade" id="coichiefmodal_special" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl modal-dialog-scrollable" >
					<div class="modal-content">
						<div class="modal-header alert-info" style="background-color: #B4B5BD"><h5 class="modal-title" id="exampleModalLabel">Manage COI</h5>
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span> </button>
						</div>
						<div class="modal-body">
						    <input id = "case_no_id_coi_special" class="form-control"  type="hidden" name="case_no_id_coi_special" placeholder="Case No"  >
                                <div id="casedetailsdiv_special" style="display:none;"></div>
	                            <hr>
							        <div id="coi_show" style="display:none;"></div>    
                                    <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label style="font-family:Product Sans">Do you have conflict of interest with any of the alledged person/the case? &nbsp;&nbsp;
                                                    <input type="radio" name="alfabet"  value="yes" onclick="showcoidivspecial();"> Yes &nbsp;
                                                <input type="radio" name="alfabet" value="no" onclick="dontshowcoidivspecial()"> No  </label>
                                                <input type="hidden" name="yesnospecial" id="yesnospecial">
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class= "row" id="coidivspecial" style="display:none"> 
                                            <div class   = "col-md-12">
                                                <div class  = "form-group">
                                                    <label style="font-family:Product Sans">Nature of COI&nbsp;<font color='red'>*</font></label>
                                                    <textarea name="coichiefspecial" id="coichiefspecial" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div> 
						</div>
					
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" >Declare COI</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											
						</div>
					</div>
				</div>
			</div>
	</form>

	<!-- END VIEW COI -->
    
<!-- ASSIGN CASE CHIEF-->
<form method = "POST" action="{{ route('assigncasechief') }}"  enctype="multipart/form-data" >
        @csrf    
      <div class="modal fade" id="showmodal_assigncase_chief" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info" style="background-color: #B4B5BD">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Case(Chief)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="casedetailsdivassignchief" style="display:none;"></div>
                            <input type="hidden" id="case_no_id_chief_assign" name="case_no_id_chief_assign">
                        <hr>
                            <div class   = "row">
                                <div class  = "col-md-6">
                                    <div class      = "form-group">
                                        <label style="font-family:Product Sans">Team Name&nbsp;(Optional)</label>
                                        <input id   = "teamname" placeholder="Team Name" type="text"  class="form-control" name="teamname"   autocomplete="teamname" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class  = "row">
                                <div class = "col-md-12">
                                    <div class = "form-group">
                                <label style="font-family:Product Sans">Team Members&nbsp;<font color='red'>*</font></label> &nbsp; &nbsp; 
                                        <button type="button" id="addcasebtn" name="addcasebtn" class="btn btn-info btn-xs" style="float:right" onclick="showteammemberadd()">
                                            <span style="font:face:Product Sans">Add Team Members</span>
                                            <span><i class="fa fa-plus"></i></span>
                                        </button>
                                    
                                        <table id="tblTeamMembers"class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Role</th>
                                                <th>Member</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="team">
                                            
                                        </tbody>
                                    </table>
                                    <br>
                                     
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="return validateFormChief();">Assign</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH ASSIGN CASE CHIEF -->
<!-- ASSIGN CASE CHIEF-->
<form method = "POST" action="{{ route('reassigncasechief') }}"  enctype="multipart/form-data" >
        @csrf    

      <div class="modal fade" id="showmodal_reassigncase_chief" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info" style="background-color: #B4B5BD">
                    <h5 class="modal-title" id="exampleModalLabel">ReAssign Case-Chief</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                            <div id="casedetailsdivreassignchief" style="display:none;"></div>
                                <input type="hidden" id="case_no_id_chief_reassign" name="case_no_id_chief_reassign">
                                    <hr>
                            
                              <div id="existingteammembersreassign" style="display:none;"></div>
                                <hr>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">ReAssign</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH ASSIGN CASE CHIEF -->
<!-- DECLArE COI -->
<form method = "POST" action="{{ route('declarecoi_investigator') }}"  enctype="multipart/form-data" >
        @csrf    

    <div class="modal fade" id="modal_show_declare_coi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info" style="background-color: #B4B5BD"> <h5 class="modal-title" >MANAGE COI</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="casedetailsdivinv" style="display:none;"></div>
                    <input id = "case_no_id_coi_inv" class="form-control"  type="hidden" name="case_no_id_coi_inv"  >
                       <hr>
						<div id="coi_show_inv" style="display:none;"></div>          
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <label style="font-family:Product Sans">Do you have conflict of interest with the case? &nbsp;&nbsp;
                                    <input type="radio" name="alfabet"  value="yes" onclick="showcoidivinv();"> Yes &nbsp;
                                <input type="radio" name="alfabet" value="no" onclick="dontshowcoidivinv()"> No  </label>
                                <input type="hidden" name="yesnoinv" id="yesnoinv">
                            </div>
                        </div>
                    <br>
                    <br>
                    <div class= "row" id="coidivinv" style="display:none"> 
                        <div class   = "col-md-12">
                            <div class  = "form-group">
                                <label style="font-family:Product Sans">Nature of COI&nbsp;<font color='red'>*</font></label>
                                <textarea name="coiinv" id="coiinv" class="form-control"></textarea>
                            </div>
                        </div>
                    </div> 
                    <hr>
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="return validateFormInv();">Declare</button>                    
                </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH Declare COI -->
<!-- add team members -->
<div class="modal fade" id="show_teammembers_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info" style="background-color: #B4B5BD"> <h5 class="modal-title" >ADD TEAM MEMBERS</h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <div class="">
                        <br>
                        <div class   = "row">
                            <div class  = "col-md-6">
                                <div class      = "form-group">
                                    <label>Role<font color="red">*</font></label>
                                        <select class="form-control" id="teamroles" >
                                            <option value="">Please Select One</option> 
                                            <option value   = "Team Member">Team Member</option>
                                            <option value   = "Team Leader">Team Leader</option> 
                                            <option value   = "Legal Representative">Legal Representive</option>
                                        </select>   
                                </div>
                            </div >
                            <div class  = "col-md-6">
                                <div class      = "form-group">
                                    <label>Members<font color="red">*</font></label>
                                        <select class="form-control" id="teammembers" >
                                            <option value="">Please Select One</option>
                                            @foreach ($users as $user)
                                            <option value = "{{ $user->email }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    
                                </div>
                            </div>
                        </div>
                    </div>       
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="addteam()">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!--add team members -->
<!-- VIEW COI TOGETHER-->

	<form method = "POST" action="{{ route('printassignmentorder') }}" enctype="multipart/form-data" >
			@csrf  

			<div class="modal fade" id="coitogethermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl modal-dialog-scrollable" >
					<div class="modal-content">
						<div class="modal-header alert-info" style="background-color: #B4B5BD" style="background-color: #B4B5BD"><h5 class="modal-title" id="exampleModalLabel">Manage COI</h5>
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
                                        @php
                                    $records = 0;
                            foreach ($showassignedcases as $case) {
    $records += DB::table('tbl_user_role_mapping')
        ->where('case_no_id', $case->id)
        ->where('conflictstatus', '<>', 0)
        ->whereIn('role', ['Team Leader', 'Team Member', 'Legal Representative'])
        ->count();
}
@endphp
                        <div class="modal-footer">
                            @if ($records >= 3)
                                <button type="submit" class="btn btn-primary">PRINT ASSIGNMENT ORDER</button>
                            @endif
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    

                        
					</div>
				</div>
			</div>
	</form>

	<!-- END VIEW COI TOGETHER-->
<script>
    
    function show_modal_coi(casenoid)
        {
            $('#case_no_id_coi').val(casenoid);
            $('#coichiefmodal').modal('show');
            
            var url = '{{ route("showcasedetailsforcoi", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_coi').val()},
                success: function(responseText) {
                    
                    $("#casedetailsdiv").html(responseText);
                    $("#casedetailsdiv").show();
                    
                }
            });

             var url = '{{ route("viewcoi", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_coi').val()},
                success: function(responseText) {
                    
                    $("#coi_show").html(responseText);
                    $("#coi_show").show();
                    
                }
            });
        }

        function show_modal_coi_special(casenoid)
        {
            $('#case_no_id_coi_special').val(casenoid);
            $('#coichiefmodal_special').modal('show');
            
            var url = '{{ route("showcasedetailsforcoi", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_coi_special').val()},
                success: function(responseText) {
                    
                    $("#casedetailsdiv_special").html(responseText);
                    $("#casedetailsdiv_special").show();
                    
                }
            });

             var url = '{{ route("viewcoi", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_coi_special').val()},
                success: function(responseText) {
                    
                    $("#coi_show_special").html(responseText);
                    $("#coi_show_special").show();
                    
                }
            });
        }


        function showcoidiv()
        {
            $('#coidiv').show(); 
            $('#yesno').val("Yes");
        }

        function dontshowcoidiv()
        {
            $('#coidiv').hide(); 
            $('#yesno').val("No");
        }

        function showcoidivspecial()
        {
            $('#coidivspecial').show(); 
            $('#yesnospecial').val("Yes");
        }

        function dontshowcoidivspecial()
        {
            $('#coidivspecial').hide(); 
            $('#yesnospecial').val("No");
        }

        function showcoidivinv()
        {
            $('#coidivinv').show(); 
            $('#yesnoinv').val("Yes");
        }

        function dontshowcoidivinv()
        {
            $('#coidivinv').hide(); 
            $('#yesnoinv').val("No");
        }

        function show_assigncase_modal_chief(casenoid)
        {
           
        $('#case_no_id_chief_assign').val(casenoid);
        
        $('#showmodal_assigncase_chief').modal('show');

        var url = '{{ route("showcasedetailsforcoi", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_chief_assign').val()},
                success: function(responseText) {
                    
                    $("#casedetailsdivassignchief").html(responseText);
                    $("#casedetailsdivassignchief").show();
                    
                }
            });

        }

        function show_reassigncase_modal_chief(casenoid)
        {
           
        $('#case_no_id_chief_reassign').val(casenoid);
        
        $('#showmodal_reassigncase_chief').modal('show');

        var url = '{{ route("showcasedetailsforcoi", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_chief_reassign').val()},
                success: function(responseText) {
                    
                    $("#casedetailsdivreassignchief").html(responseText);
                    $("#casedetailsdivreassignchief").show();
                    
                }
            });

            var url = '{{ route("showteamdetailsforreassign", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_chief_reassign').val()},
                success: function(responseText) {
                    
                    $("#existingteammembersreassign").html(responseText);
                    $("#existingteammembersreassign").show();
                    
                }
            });

        }
        
        function addteam() {
            var teamRole = $('#teamroles').val();
            var teamMember = $('#teammembers').val();
            var teamMembertext = $('#teammembers option:selected').text();
    
            if (teamRole && teamMember) {
                var newRow = '<tr><td><input type="hidden" name="teamroles[]" value="'+ teamRole + '">' + teamRole + '</td><td><input type="hidden" name="teammembers[]" value="'+ teamMember + '">' + teamMembertext + '</td><td><i class="fa fa-minus"  onclick="removeTeamMember(this)"></i></td></tr>';
                var newRow =
                    $('#team').append(newRow);
                    $('#teamroles').val('');
                    $('#teammembers').val('');
                    $('#show_teammembers_details').hide();
                }  
            }

        function removeTeamMember(button) {
            $(button).closest('tr').remove();
            }

    function show_modal_declare_coi(casenoid)
    {
            
            $('#case_no_id_coi_inv').val(casenoid);
            $('#modal_show_declare_coi').modal('show');
            
            var url = '{{ route("showcasedetailsforcoi", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_coi_inv').val()},
                success: function(responseText) {
                    
                    $("#casedetailsdivinv").html(responseText);
                    $("#casedetailsdivinv").show();
                    
                }
            });

            var url = '{{ route("viewcoiinv", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#case_no_id_coi_inv').val()},
                success: function(responseText) {
                    
                    $("#coi_show_inv").html(responseText);
                    $("#coi_show_inv").show();
                    
                }
            });
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

             var url = '{{ route("viewcoitogether", ":casenoid") }}';
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

        function showteammemberadd()
        {
           
            $('#show_teammembers_details').modal('show');
        }

        function validateForm() {
            const yesnovalue = document.getElementById('yesno');
            
            if (yesnovalue.value === "") {
                alert("Please select Yes/No.");
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }

        function validateFormInv()
        {
            const yesnovalueinv = document.getElementById('yesnoinv');
            
            if (yesnovalueinv.value === "") {
                alert("Please select Yes/No.");
                return false; // Prevent form submission
            }

            return true; 
        }
        function validateFormChief() {
            var table = document.getElementById("tblTeamMembers");

            if (table.rows.length === 0) {
                alert("Please add team members to the table.");
                return false;
            }

            console.log("validateFormChief function called."); // Add this line
            return true; // Allow form submission
        }

</script>
<style>
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

.smaller-button {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }
</style>
@endsection