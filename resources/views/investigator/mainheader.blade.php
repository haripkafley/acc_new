
<div class="carod">
    <div class="carod-header custom-header" onclick="toggleCard(this)" >
            <font color='white'  face="Product Sans"><i class="fa fa-briefcase"></i> </font> &nbsp;
            <font color='#fff' size="5" face="Product Sans">  {{ $caseid }}</font>
            @if(Auth::user()->role == "Director")
            <i style="float:right; padding-top:6px" class="fa fa-edit"  data-toggle="tooltip" data-placement="middle" title="Edit" onclick="showeditdirector(event)"></i>
            @endif
    </div>
    <div class="carod-content">
        @foreach ($casesdtls as $casedetails)
    <!-- carod content -->
        <input type="hidden" id="maincaseno" name="maincaseno" value="{{ $caseno }}">
        <input type="hidden" id="maincasenoid" name="maincasenoud" value="{{ $casedetails->id }}">
                <div class="row">
                    <div class="col-md-3">
                        <font color='grey' size="2" face="'Product Sans'">Case No:</font> <font color='black' size="2" face="'Product Sans'" style="margin-left:45px">{{ $casedetails->case_no }}</font><br>
                        <font color='grey' size="2" face="'Product Sans'">Case Title:</font> <font color='black' size="2" face="'Product Sans'" style="margin-left:41px">{{ $casedetails->case_title }}</font><br>
                        <font color='grey' size="2" face="'Product Sans'">Date Assigned:</font><font color='black' size="2" face="'Product Sans'" style="margin-left:15px">{{ \Carbon\Carbon::parse($casedetails->assignment_order_date)->format('d/m/Y')}}</font>
                    </div>
                    
                    <div class="col-md-3">
                        <font color='grey' size="2" face="'Product Sans'">Intake Source:</font><font color='black' size="2" face="'Product Sans'" style="margin-left:8px"> {{ $casedetails->source_type }}</font><br>
                        <font color='grey' size="2" face="'Product Sans'">Sector:</font> <font color='black' size="2" face="'Product Sans'" style="margin-left:46px">{{ $casedetails->sector }}</font><br>
                        <font color='grey' size="2" face="'Product Sans'">Sub Sector:</font><font color='black' size="2" face="'Product Sans'" style="margin-left:25px">{{ $casedetails->sector_type }}</font>

                    </div>
                    <div class="col-md-3">
                        <font color='grey' size="2" face="'Product Sans'">Team Leader:</font><font color='black' size="2" face="'Product Sans'" style="margin-left:20px">  <?php echo $key=DB::table('users')->where('email',$teamleader)->value('name') ?></font><br>
                        <font color='grey' size="2" face="'Product Sans'">Legal Rep:</font><font color='black' size="2" face="'Product Sans'" style="margin-left:40px"><?php echo $key=DB::table('users')->where('email',$legalrep)->value('name') ?></font><br>
                        <font color='grey' size="2" face="'Product Sans'">Team Members:</font><font color='black' size="2" face="'Product Sans'" style="margin-left:8px">
                                @foreach ($teammember as $key => $team)
                                    <?php $name = DB::table('users')->where('email', $team->assigned_to)->value('name'); ?>

                                    @if ($loop->last)
                                        {{ $name }}
                                    @else
                                        {{ $name }},
                                    @endif
                                @endforeach

                        </font><br>
                    </div>
                    <div class="col-md-3">
                        <font color='grey' size="2" face="'Product Sans'">Investigation Status:</font><font color='black' size="2" face="'Product Sans'" style="margin-left:25px">{{ $casedetails->status}}</font> &nbsp;
                            @if(Auth::user()->role == "Chief")
                                 <font color='black' size="3"><i class="fa fa-edit" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='black';"  data-toggle="tooltip" data-placement="bottom" title="Edit" onclick="showeditchief('{{ $casedetails->id }}','{{ $casedetails->status}}')"></i></font>
                            @endif<br>
                        <font color='grey' size="2" face="'Product Sans'">Sub Status:</font><font color='black' size="2" face="'Product Sans'" style="margin-left:78px">{{ $casedetails->sub_status}}</font>
                            @if(Auth::user()->role == "Investigator")
                                 <font color='black' size="3"><i class="fa fa-edit" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='black';"  data-toggle="tooltip" data-placement="bottom" title="Edit" onclick="showeditinv('{{ $casedetails->id }}','{{ $casedetails->sub_status}}')"></i></font>
                            @endif<br>
                        <font color='grey' size="2" face="'Product Sans'">Expected Closure Date:</font><font color='black' size="2" face="'Product Sans'" style="margin-left:8px">  {{ \Carbon\Carbon::parse($casedetails->assignment_order_date)->format('d/m/Y')}}</font><br>

                    </div>
                    
                    
                </div>
    <!-- carod content -->
    @endforeach
    </div>
</div>
<!--edit modal -->
 <form method="POST" action="{{ route('updatecasedetails') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="caseeditmodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content" style="font-family:Product Sans">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="casenoidedit" id="casenoidedit">
                    <div id="caseeditdiv"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- end edit modal -->
<link rel ="stylesheet" href="https://fonts.googleapis.com/css2?family=Product+Sans&display=swap" >
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
        // Function to toggle the carod state
        function toggleCard(header) {
            const content = header.nextElementSibling;
            if (content.style.display === 'none' || content.style.display === '') {
                content.style.display = 'block';
            } else {
                content.style.display = 'none';
            }

            // Store the state in localStorage
            localStorage.setItem('cardState', content.style.display);
        }

        // Check and apply the carod state on page load
        document.addEventListener('DOMContentLoaded', function () {
            const storedState = localStorage.getItem('cardState');
            const cards = document.querySelectorAll('.carod-content');
            
            // Apply the stored state to all carod contents
            cards.forEach(function (content) {
                if (storedState === 'block') {
                    content.style.display = 'block';
                } else {
                    content.style.display = 'none';
                }
            });
        });
    function changestatusinv(id)
    {
        $('#statusinvmodal').modal('show');
    }
     function changestatuschief()
    {
        $('#statuschiefmodal').modal('show');
    }
    
    function showeditinv(caseid,status)
    {
        var confirmation = confirm("Are you sure you want to change the status?");
            if (!confirmation) 
                {
                    event.preventDefault(); // Prevent form submission
                }
                else
                {
                    updateDatabase(caseid,status);
                }
    }
    function updateDatabase(caseid,status) 
    {
        if(status == "Active")
        {
        var newData = "Inactive";
        }
        if(status == "Inactive")
        {
        var newData = "Active";
        }

   
       $.ajax({
                url: "{{ route('updateinvstatus', ['caseid' => ':caseid']) }}".replace(':caseid', caseid),
                type: 'get',
                data: { newData: newData },
                success: function (response) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Status updated successfully',
                    showConfirmButton: false,
                    timer: 1500 // Display for 1.5 seconds
                }).then(function () {
                    window.location.reload(); // Reload the page after the alert is closed
                });
                },
                error: function (error) {
                    console.log("here" + error);
                    alert('Error updating data');
                }
            });
    }

   function showeditchief(caseid,status)
    {
        var confirmation = confirm("Are you sure you want to change the status?");
            if (!confirmation) 
                {
                    event.preventDefault(); // Prevent form submission
                }
                else
                {
                    updateDatabasechief(caseid,status);
                }
    }
    function updateDatabasechief(caseid,status) 
    {
        if(status == "Open")
        {
        var newData = "Close";
        }
        if(status == "Close")
        {
        var newData = "Open";
        }

   
       $.ajax({
                url: "{{ route('updatechiefstatus', ['caseid' => ':caseid']) }}".replace(':caseid', caseid),
                type: 'get',
                data: { newData: newData },
                success: function (response) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Status updated successfully',
                    showConfirmButton: false,
                    timer: 1500 // Display for 1.5 seconds
                }).then(function () {
                    window.location.reload(); // Reload the page after the alert is closed
                });
                },
                error: function (error) {
                    console.log("here" + error);
                    alert('Error updating data');
                }
            });
    }

    function showeditdirector(event) {
        event.stopPropagation(); // Stop the event from propagating up to the parent div
        var casenoid = ($('#maincasenoid').val());
        $('#casenoidedit').val(casenoid);
        $('#caseeditmodal').modal('show');
        
        var url = '{{ route("editcasedetails", ":casenoid") }}';
            url = url.replace(':casenoid', casenoid);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {casenoid: casenoid},
                success: function(responseText) {
                    
                    $("#caseeditdiv").html(responseText);
                    $('#caseeditdiv').show();   
                }
            });
        
        }

    </script>
    <style>
        /* Styles for the carod container */
        .carod {
            width: 1205px;
            border: 1px solid #ccc;
            background-color: #fff;
            margin-top: -22px;
            margin-bottom: 20px;
            border-radius: 2px;
            radius: 1px;
        }

        /* Styles for the carod header */
        .carod-header {
            background-color: #1F81C4;
            padding: 10px;
            cursor: pointer;
            border-radius: 2px;
        }

        /* Styles for the carod content (initially hidden) */
        .carod-content {
            padding: 10px;
            display: none;
        }
        .custom-header {
            height: 43px;
            padding: 5px;
        }

        .modal-header {
    background: linear-gradient(to top, grey, #ffffff);
    color: #fff;
    font-family: Product Sans;
    border-radius: 5px 5px 0 0;
}
        
    </style>