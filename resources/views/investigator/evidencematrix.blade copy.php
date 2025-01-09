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
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    @include('tabs/evidence_tab')
                     @if(Auth::user()->role == "Investigator")
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" data-toggle="modal" data-target="#addevidencematrix">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font:face:Product Sans">Add Evidence Matrix</span>
                        </button>
                            @endif
                            <br>
                            <br>
                    <div id="showevidencetag">
                        <!-- matrix -->
                            @foreach ($uniqueAccused as $row)
                                <div class="accordion">
                                    <div class="accordion-section">
                                        <span onclick="showmatrix('{{ $row->accused_name }}','{{ $row->case_no_id }}')">
                                            <?php $accusedName = DB::table('tbl_case_entities')->where('id', $row->accused_name)->value('name') ?>
                                            {{ $accusedName }}
                                        </span>
                                    </div>
                                    <div class="accordion-content">
                                        {{-- Dynamic content for each accordion section --}}
                                        <div class="matrixdetails" style="display: none;" data-accused="{{ $row->accused_name }}" data-casenoid="{{ $row->case_no_id }}"></div>
                                    </div>
                                </div>
                            @endforeach

                        <!-- end -->
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!----------------------------------------------->
    <div class="container mt-5">
    

    <!-- The Modal -->
    <div class="modal fade" id="addevidencematrix" tabindex="-1" role="dialog" aria-labelledby="addevidencematrixLabel" aria-hidden="true">
      <div class="modal-dialog custom-dialog-size" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addevidencematrixLabel">Evidence Matrix</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Modal content goes here -->
           <input type="hidden" name="evidencematrixcasenoidadd" id="evidencematrixcasenoidadd" value="{{ $casenoid }}">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <font face="Product Sans" color="Grey">Accused&nbsp;<font color='red'>*</font></font>
                                    <select class="form-control"   name="searchsuspect" id="searchsuspect" >
                                        <option selected>Select an Option</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id}}">{{ $subject->name}} [{{ $subject->identification_no}}]</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <font face="Product Sans" color="Grey">Probable Offence:<font color='red'>*</font></font>
                                <select class="form-control" name="offence_types" id="offence_types" required >
                                    <option value="Select Offence Type">Select Offence Type</option>
                                    @foreach ($offencetypes as $offence)
                                    <option value="{{ $offence->offence_id }}">{{ $offence->offence_type }}</option>
                                    @endforeach
                                </select>                              
                            </div>                                
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <font face="Product Sans" color="Grey">Description&nbsp;<font color='red'>*</font></font>
                                    <textarea id="maindescription" name="maindescription" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button class="forward-button" onclick="showdiv()" style="float:right">
                                    <i class="fas fa-arrow-circle-right icon"></i>Go Forward
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div id="showmatrixdiv" style="display:none">
                        <div class="card">
                            <div class="card-content">
                                <!-- content -->
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="narrow-td">
                                            @foreach ($evidences as $evi)
                                                <label style="font-family:Product Sans; cursor: move;" draggable="true" ondragstart="drag(event)" id="{{ $evi->id }}"> {{ $evi->evidence_name }}</label><br>
                                            @endforeach
                                        </td>
                                        <td > 
                                            <!-- <div class="search-icon-container">
                                                <i class="fas fa-search"></i>
                                                <i class="fas fa-times cross-icon"></i>
                                            </div> -->
                                        <span class="maincircle" name="maincircle" id="maincircle"> </span><i class="fas fa-search"></i>
                                        &nbsp; &nbsp;<label style="font-family:Product Sans" id="selectedValue" onclick="showelements()"></label>
                                        <input type="hidden" name="offenceid" id="offenceid">
                                        <br>
                                        <div id="elementsdiv" style="display:none"></div>
                                        </td>
                                    </tr>
                                </table>
                                <!-- content -->
                            </div>
                        </div>
                    </div>
                    <!-- matrix -->
          </div>
          <div class="modal-footer">
            <button type="button" id="footersubmit" style="display:none" class="btn btn-primary" onclick="savematrix()">Save Changes</button>
          </div>
        </div>
      </div>
    </div>

  </div>
<!-- edit modal -->
    <!-- <div class="modal fade" id="addevidencematrix">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Evidence Matrix</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div> -->

<!-- end edit modal -->
<!-- edit modal -->
    <div class="modal fade" id="showmatrixdetails">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Matrix Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<!-- end edit modal -->
<link rel ="stylesheet" href="https://fonts.googleapis.com/css2?family=Product+Sans&display=swap" >
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addnewevidencetag()
    {
        $('#addevidencematrix').modal('show');  
    }

    function showdiv()
    {
        document.getElementById("footersubmit").style.display = "block";
        var accuseddropdown = document.getElementById("searchsuspect");
        var selectedOptionAccused = accuseddropdown.options[accuseddropdown.selectedIndex];
        var selectedTextAccused = selectedOptionAccused.text;

         
        var dropdown = document.getElementById("offence_types");
        var selectedOption = dropdown.options[dropdown.selectedIndex];
        var selectedText = selectedOption.text;
        var selectedValue = selectedText;

        // if(selectedTextAccused == "Select an Option")
        // {
        //      Swal.fire({
        //             icon: 'error',
        //             title: 'error',
        //             text: 'Please select Accused',
        //             showConfirmButton: false,
        //             timer: 1500 
        //      });
             
        //     selectedText == "Select Offence Type";
            
        // }
        // else
        // {

        $('#showmatrixdiv').show(300); 
        $('#offenceid').val(dropdown.value);
        $('#selectedValue').text(selectedValue);
       
        }
    //}

    function showelements()
        {
            var offenceid= $('#offenceid').val();
            
            var url = '{{ route("showelements", ":offenceid") }}';
            url = url.replace(':offenceid', offenceid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#offenceid').val()},
                success: function(responseText) {
                    
                    $("#elementsdiv").html(responseText);
                    $("#elementsdiv").show();
                    
                }
            });
        }

  let draggedData = null;
  let draggedId = null;

    function allowDrop(event) {
        event.preventDefault();
    }

    function drag(event) {
        draggedData = event.target.innerText;
        draggedId = event.target.id;
        
    }

    function showmatrix(id, casenoid) {
    var matrixContainer = $(`.matrixdetails[data-accused="${id}"][data-casenoid="${casenoid}"]`);

    var url = '{{ route("showelementmatrix", ['id' => ':id', 'casenoid' => ':casenoid' ]) }}';
    url = url.replace(':id', id);
    url = url.replace(':casenoid', casenoid);

    $.ajax({
        type: "GET",
        url: url,
        data: {
            'id': id,
            'casenoid': casenoid
        },
        success: function(responseText) {
            matrixContainer.html(responseText); // Update the specific matrixContainer
            matrixContainer.show(); // Show the specific matrixContainer
        }
    });
}


    function savematrix()
    {
        var accusedname         = document.getElementById("searchsuspect").value;
        var offencename         = document.getElementById("offence_types").value;
        var casenoid            = document.getElementById("evidencematrixcasenoidadd").value;
        
        var url = '{{ route("addevidencematrix", ['accusedname' => ':accusedname', 'offencename' => ':offencename','casenoid' => ':casenoid']) }}';
            url = url.replace(':accusedname', accusedname);
            url = url.replace(':offencename', offencename);
            url = url.replace(':casenoid', casenoid);

        $.ajax({
            type: "get",
            url: url,
            data: {
                'accusedname':   accusedname,
                'offencename':   offencename,
                'casenoid':      casenoid,
            },
            success: function(responseText) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Matrix saved',
                    showConfirmButton: false,
                    timer: 1500 // Display for 1.5 seconds
                }).then(function () {
                    window.location.reload(); // Reload the page after the alert is closed
                });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                    }
                });
             $('#addevidencematrix').modal('hide'); 
    }

        // Get all elements with the class 'accordion-section'
const accordionSections = document.querySelectorAll('.accordion-section');

// Loop through each accordion section and add a click event listener
accordionSections.forEach(accordionSection => {
    accordionSection.addEventListener('click', () => {
        const content = accordionSection.nextElementSibling;

        // Toggle the display of the content for the clicked section
        content.style.display = content.style.display === 'block' ? 'none' : 'block';

        // Close other open accordion sections
        accordionSections.forEach(otherSection => {
            if (otherSection !== accordionSection) {
                const otherContent = otherSection.nextElementSibling;
                otherContent.style.display = 'none';
            }
        });
    });
});

</script>

<style>
   

    .modal-header 
    {
        background: linear-gradient(to top, grey, #ffffff);
        color: #fff;
        font-family: Product Sans;
        border-radius: 5px 5px 0 0;
    }

    .t2
    {
        outline: 1px solid #ccc;
        font-family:Product Sans;
    }

    .custom-dialog-size 
    {
        max-width: 1200px; 
        margin-left : 50px;
    }

    .search-icon-container 
    {
        position: relative;
        font-size: 1.2em; /* Adjust the size as needed */
    }

    .cross-icon 
    {
        position: absolute;
        top: -20%;
        left: 0;
        font-size: 1em; 
        transform: translate(0, 50%);
        color: red; /* Adjust the color as needed */
        }

    .narrow-td 
    {
        width: 150px; /* Change this value to your desired width */
        border: 1px solid black; /* Just for demonstration */
        padding: 10px; /* Adding some padding for spacing */
        overflow: auto;
    }

    .maincircle {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: red;
        margin-right: 5px;
    }

.accordion {
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
            width: 1100px;
        }

        .accordion-section {
            border: 1px solid #ddd;
            margin-bottom: 5px;
            cursor: pointer;
            padding: 10px;
        }

        .accordion-section:hover {
            background-color: #f0f0f0;
        }

        .accordion-content {
            display: none;
            padding: 10px;
        }
        .forward-button {
            padding: 5px 10px;
            background-color: #007bff; /* Blue color, you can change this */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 10px;
        }

        /* Style for the icon */
        .icon {
            margin-right: 5px; /* Spacing between the icon and text */
        }
</style>
@endsection