<br>

<link rel ="stylesheet" href="https://fonts.googleapis.com/css2?family=Product+Sans&display=swap" >
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<section class="content">
    
    @foreach ($casesdtls as $casedetails)
    
    <div id="accordion" style="margin-top:-40px;">
        <div class="card">
            <input type="hidden" id="textboxvalue" value="0">
            <div class="card-header custom-header" style="background-color: #1F81C4;" id="headingOne">
                <h5 class="mb-0">
                    &nbsp; &nbsp; 
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <font color='white' size="4" face="Product Sans"><i class="fa fa-briefcase"></i> </font> &nbsp;
                            <font color='#fff' size="5.5" face="Product Sans">  {{ $caseid }} </font>
                    </button>
                    
                   
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;
                     &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; 

                    <font color='white' size="2" face="'Product Sans'">Run Days: </font>
                    <font color='black' size="2" face="'Product Sans'"> {{ date_diff(new \DateTime($casedetails->assignment_order_date), new \DateTime())->format("%d"); }}</font>
                    &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 
                    <font color='white' size="2" face="'Product Sans'">Work Days: </font>
                    <font color='red' size="2" face="'Product Sans'"> {{ date_diff(new \DateTime($casedetails->assignment_order_date), new \DateTime())->format("%d"); }}</font>
                    <button class="btn" style="float:right" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne">
                            <i class="fa fa-angle-up" id="showarrowupbutton" onclick="showarrowdown()"></i>
                            <i style="display:none" id="showarrowdownbutton" class="fa fa-angle-down" onclick="showarrowup()"></i>
                    </button>
                </h5>
            </div>

               
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <!-- Content Start-->
                <input type="hidden" id="maincaseno" name="maincaseno" value="{{ $caseno }}">
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
                                @foreach($teammember as $team)    
                                <?php echo $key=DB::table('users')->where('email',$team->assigned_to)->value('name') ?> ,
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
                <!-- Content End-->
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
   
.custom-header {
  height: 43px;
  padding: 5px;
}

.custom-header h5 {
  margin-bottom: 0;
}

.custom-header button {
  font-size: 0.8rem;
  padding: 0;
  
}

.content {
  margin-top: -1px;
}
</style>
<script>

    function showarrowdown()
    {
        $('#showarrowupbutton').hide();
        $('#showarrowdownbutton').show();
    }
     function showarrowup()
    {
        $('#showarrowupbutton').show();
        $('#showarrowdownbutton').hide();
    }

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

   
    // Add an event listener to the button for collapse/expand
    document.querySelector('.btn-link').addEventListener('click', function () {
        // Get the collapse state
        const isCollapsed = document.querySelector('#collapseOne').classList.contains('show');

        // Update the textboxvalue value based on the collapse state
        document.querySelector('#textboxvalue').value = isCollapsed ? '1' : '0';
    });
    
    window.onload = function() {
        var textbox = document.getElementById('textboxvalue').value;
        const accordionItem = document.getElementById('collapseOne');

        if (textbox === '1') {
            // If textbox value is '1', collapse the accordion item
            $(document).ready(function(){
                $('#collapseOne').removeClass('show');
            });
        }
    };

    


</script>