
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
        <div class="card-body" style="font-family:Product Sans">
            <div class="tab-content" id="custom-tabs-four-tabContent">
                @include('tabs/evidence_tab')
                    @if(Auth::user()->role == "Investigator")
                        <button type="button" class="btn-primary" style="float:right; font-family:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" data-toggle="modal" data-target="#addevidencematrix">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font-family:Product Sans">Add Evidence Matrix</span>
                        </button>
                    @endif
                    <br>
                    <br>
                    <div id="accordion">
                        <!-- -->
                            @foreach($evidencematrix as $accused_id => $groupedRows)
                                <div class="card">
                                    <div class="card-header" id="heading-{{ $accused_id }}">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-{{ $accused_id }}" aria-expanded="true" aria-controls="collapse-{{ $accused_id }}">
                                            <h5><?php echo $key = DB::table('tbl_case_entities')->where('id', $accused_id)->value('name') ?></h5> 
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapse-{{ $accused_id }}" class="collapse" aria-labelledby="heading-{{ $accused_id }}" data-parent="#accordion">
                                        <div class="card-body"  >
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs tabs" id="myTabs">
                                                <li class="nav-item">
                                                    <a class="nav-link tab active" data-toggle="tab" href="#offenses-tab-{{ $accused_id }}">Summary</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link tab" data-toggle="tab" href="#descriptions-tab-{{ $accused_id }}">Details</a>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content" >
                                                <br>
                                                <div class="tab-pane fade show active" id="offenses-tab-{{ $accused_id }}">
                                                    <!-- Your content for Offenses tab -->
                                                    @php
                                                        $lastCountForOffenses = []; // Create an array to store the last count for each offense
                                                    @endphp
                                                    @foreach($groupedRows as $row)
                                                        @php
                                                            $offenseId = $row->offence_id;
                                                            $lastCountForOffenses[$offenseId] = $row->count; // Store the last count for this offense
                                                        @endphp
                                                    @endforeach
                                                    <!-- Display the last count for each offense with a serial number -->
                                                    @php $serialNumber = 1; @endphp
                                                    @foreach($lastCountForOffenses as $offenseId => $lastCount)
                                                        <p><b> {{ $serialNumber++ }}.</b> &nbsp;&nbsp;<b> <?php echo $key = DB::table('tbl_offences_lookup')->where('offence_id', $offenseId)->value('offence_type') ?></b> &nbsp;&nbsp;{ Count: {{ $lastCount }}}</p>
                                                    @endforeach
                                                                                                    
                                                    <!-- -->
                                                </div>
                                                <div class="tab-pane fade" id="descriptions-tab-{{ $accused_id }}">
                                                    <!-- Your content for Descriptions tab -->
                                                    @foreach($groupedRows as $row)
                                                        
                                                        <u><b>Offence Name: <?php echo $key = DB::table('tbl_offences_lookup')->where('offence_id', $row->offence_id)->value('offence_type') ?></b></u>&nbsp;&nbsp;<i style="float:right;color:grey" class="fa fa-edit" onclick="editelementsmatrixview('{{ $row->id }}')" data-toggle="tooltip" data-placement="bottom" title="Edit" > &nbsp;</i> <i class="fa fa-eye" onclick="showelementsmatrixview('{{ $row->id }}')" style="color:grey;float:right" data-toggle="tooltip" data-placement="bottom" title="View" > &nbsp;</i> &nbsp;
                                                            <br><br>
                                                            <p> <b>&nbsp;Count: </b>{{ $row->count }}&nbsp;&nbsp;  <br>
                                                            <b>&nbsp;Description: </b>{{ $row->description }}&nbsp;&nbsp; <br>
                                                            <b>&nbsp;Evidences: </b>
                                                                <?php
                                                                    // Assuming $row->id corresponds to another table's id
                                                                    $evidenceDetails = DB::table('tbl_case_evidence_matrix_two')
                                                                        ->where('table_two_id', $row->id)
                                                                        ->leftJoin('tbl_case_evidence_matrix_three', 'tbl_case_evidence_matrix_three.table_two_id', '=', 'tbl_case_evidence_matrix_two.id')
                                                                        ->pluck('tbl_case_evidence_matrix_three.evidence_id');
                                                                        
                                                                ?>
                                                                {{ $evidenceDetails->implode(',') }}
                                                            </p>
                                                        <hr>
                                                    @endforeach
                                                    

                                                    <!-- -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <br>
                                    @endforeach
                        <!-- -->
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- -->
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
                                <button class="forward-button" onclick="showtableformatrix()" style="float:right">
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
                                        <th>Evidences</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td class="narrow-td">
                                            @foreach($evidences as $evi)
                                                <label style="font-family:Product Sans; cursor: move;" draggable="true" ondragstart="drag(event)" id="{{ $evi->id }}"> {{ $evi->evidence_name }}</label><br>
                                            @endforeach
                                        </td>
                                        <td > 
                                            <!-- <div class="search-icon-container">
                                                <i class="fas fa-search"></i>
                                                <i class="fas fa-times cross-icon"></i>
                                            </div> --> 
                                        <span class="maincircle" name="maincircle" id="maincircle"> </span><i class="fas fa-search"></i>
                                        &nbsp; &nbsp;<label style="font-family:Product Sans" id="selectedValue" onclick="handleClick()"></label><input type="hidden" name="matrixid" id="matrixid">
                                        <input type="hidden" name="offenceid" id="offenceid">
                                        <br>
                                          <div id="elementsdiv" ></div>

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
  <!-- end -->
  <!--view modal -->
    <div class="modal fade" id="showelementsmatrix">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content" style="font-family:Product Sans">
                <div class="modal-header">
                    <h5 class="modal-title">View Elements</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="elementsdivmatrix"></div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<!-- end view modal -->
  <style>
    .custom-dialog-size 
    {
        max-width: 1200px; 
        margin-left : 50px;
    }

    .modal-header 
    {
        background: linear-gradient(to top, grey, #ffffff);
        color: #fff;
        font-family: Product Sans;
        border-radius: 5px 5px 0 0;
    }

    .forward-button 
    {
        padding: 5px 10px;
        background-color: #007bff; /* Blue color, you can change this */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 10px;
    }
    .substantiate-button 
    {
        padding: 5px 10px;
        background-color: green; 
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 10px;
        float:right;
    } 
    .remove-button 
    {
        background-color: red; 
        color: white;
        border: none;
        border-radius: 3px; 
        cursor: pointer;
        font-size: 8px;
        height:20px;
        width:20px;
    }


  
    .circle 
    {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: red;
        margin-right: 5px;
    }
    .p 
    {
        margin-top: -21px;
        margin-left: 20px;
        margin-bottom: 1rem;
    }
    .narrow-td 
    {
        width: 150px; /* Change this value to your desired width */
        border: 1px solid black; /* Just for demonstration */
        padding: 10px; /* Adding some padding for spacing */
        overflow: auto;
    }

    .maincircle 
    {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: red;
        margin-right: 5px;
    }

    .hidden-button {
        display: none;
    }

    .save-button 
    {
        padding: 5px 10px;
        background-color: blue; /* Blue color, you can change this */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 10px;
        float:right;
    } 
    .cancel-button 
    {
        padding: 5px 10px;
        background-color: grey; /* Blue color, you can change this */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 10px;
        float:right;
    } 

    .tabs {
    margin-left: -4px;
    }

    .tab {
        display: inline-block;
        padding: 3px;
        margin-right: 13px;
        color: #555;
        text-decoration: none;
        font-family: Product Sans;
        border-bottom: 2px solid transparent;
        transition: border-bottom-color 0.3s ease;
    }

    .tab.active {
        color: #000;
        border-bottom-color: blue !important;
    }

    .box {
            width: 950px;
            height: 150px;
            border: 1px solid #ccc;
            padding: 4px;
            margin: 4px;
        }
           
  </style>
  <script>
    function showtableformatrix()
    {
        document.getElementById("footersubmit").style.display = "block";
        var accuseddropdown = document.getElementById("searchsuspect");
        var selectedOptionAccused = accuseddropdown.options[accuseddropdown.selectedIndex];
        var selectedTextAccused = selectedOptionAccused.text;
        var accusedid = selectedOptionAccused.value;

         
        var dropdown       = document.getElementById("offence_types");
        var selectedOption = dropdown.options[dropdown.selectedIndex];
        var selectedText   = selectedOption.text;
        var selectedValue  = selectedText;
        var offenceid      = document.getElementById("offence_types").value;


        var maindescription     = document.getElementById("maindescription").value;
        var casenoid            = document.getElementById("evidencematrixcasenoidadd").value;
        
        var url = '{{ route("addmainevidencematrix", ['accusedid' => ':accusedid', 'offenceid' => ':offenceid','casenoid' => ':casenoid','maindescription' => ':maindescription']) }}';
            url = url.replace(':accusedid', accusedid);
            url = url.replace(':offenceid', offenceid);
            url = url.replace(':casenoid', casenoid);
            url = url.replace(':maindescription', maindescription);

        $.ajax({
            type: "get",
            url: url,
            data: {
                'accusedid'        :   accusedid,
                'offenceid'        :   offenceid,
                'casenoid'         :   casenoid,
                'maindescription'  :   maindescription,
            },
            success: function(responseText) {
                $('#showmatrixdiv').show(300); 
                $('#offenceid').val(dropdown.value);
                $('#selectedValue').text(selectedValue);
                $('#matrixid').val(responseText.evidencematrixid);
                
                },
                    error: function(xhr, textStatus, errorThrown) {
                    }
                });
        }

    function showelements()
        {
            document.getElementById('selectedValue').removeEventListener('click', showelements);
            
            var matrixid= $('#matrixid').val();
            
            var url = '{{ route("showelements", ":matrixid") }}';
            url = url.replace(':matrixid', matrixid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#matrixid').val()},
                success: function(responseText) {

                var elementsDiv = $('#elementsdiv'); // Select the div where you want to append elements
                let isSubstantiated = false;
                $.each(responseText.elements, function (index, element) {
                   var tableRow = $('<tr>');
                    var tdElement = $('<td>')
                        .attr('ondrop', `drop(event, ${element.id})`)
                        .attr('ondragover', 'allowDrop(event)')
                        .append(
                            $('<span>')
                                .attr('class', 'circle')
                                .attr('name', 'circle_' + element.id)
                                .attr('id', 'circle_' + element.id)
                        )
                        .append(
                            $('<label>')
                                .attr('class', 'p')
                                .attr('name', 'p_' + element.id)
                                .attr('id', 'p_' + element.id)
                                .text(element.element_name) 
                                )
                        .append(
                            $('<button>')
                                .attr('class', 'hidden-button')
                                .attr('name', 'subbtn_' + element.id)
                                .attr('id', 'subbtn_' + element.id)
                                .text("Substantiate") 
                                .click(function () {
                                    // Check the current text and call the corresponding function
                                    if ($(this).text().trim() === "Substantiate") {
                                        $(this).text("Unsubstantiate").css('background-color', 'orange');
                                        substantiate(element.id);
                                    } else {
                                        $(this).text("Substantiate").css('background-color', 'green');
                                        // Call a different function for unsubstantiated state
                                        unsubstantiate(element.id);
                                    }
                                })
                                )
                        
                    tableRow.append(tdElement);
                    elementsDiv.append(tableRow);
                    });

                }   
            });
        }
    
    let labelClicked = false;

    function handleClick() {
        if (!labelClicked) {
            showelements();
            labelClicked = true;
        } else {
            alert("Already clicked.");
        }
    }

    let draggedData = null;
    let draggedId = null;

    function allowDrop(event) 
    {
        event.preventDefault();
    }

    function drag(event) 
    {
        draggedData = event.target.innerText;
        draggedId = event.target.id;
    }

    function allowDrop(event) 
    {
        event.preventDefault();
    }

   function drop(event, elementId) {
    event.preventDefault();
    var droppable = event.target;
    var circle = droppable.querySelector('.hidden-button');

    // Create a container for label and remove button
    const container = document.createElement('div');
    container.style.display = 'flex'; 

    const lineBreakBefore = document.createElement('br');
    const label = document.createElement('label');
    label.style.fontFamily = 'Product Sans';
    label.setAttribute('name', "Evidencelabel_" + draggedId);
    label.setAttribute('id', "Evidencelabel_" + draggedId);
    label.textContent = draggedData;

    var substantiatebtn  = document.getElementById("subbtn_" + elementId);
    substantiatebtn.style.display = 'block';
    substantiatebtn.classList.add("substantiate-button");

    

    const textarea = document.createElement('textarea');
    textarea.style.display = 'block'; // Display the text area
    textarea.cols = 130;
    textarea.setAttribute('id', 'textarea_' + draggedId);

    const savebtn = document.createElement('button');
    savebtn.textContent = "Save";
    savebtn.setAttribute('name', "Savebtn_" + draggedId);
    savebtn.setAttribute('id', "Savebtn_" + draggedId);
    savebtn.classList.add("save-button");
    savebtn.onclick = function () {
        savetxtdtls(draggedId,elementId);
    };

    // Create the Cancel button
    const cancelbtn = document.createElement('button');
    cancelbtn.textContent = "Cancel";
    cancelbtn.setAttribute('name', "Cancelbtn_" + draggedId);
    cancelbtn.setAttribute('id', "Cancelbtn_" + draggedId);
    cancelbtn.classList.add("cancel-button");

    const removeButton = document.createElement('button');
    removeButton.textContent = '-';
    removeButton.setAttribute('name', "Removebtn_" + draggedId);
    removeButton.setAttribute('id', "Removebtn_" + draggedId);
    removeButton.className = 'remove-button';
    removeButton.onclick = function () {
        label.remove();
        removeButton.remove();
        container.remove();
        textarea.remove();
        savebtn.remove();
        cancelbtn.remove();
        const evidencelabels = document.querySelectorAll('.Evidencelabel_');
        if (evidencelabels.length === 0) {
            substantiatebtn.style.display = 'none';
        }
    };
    // Append label and remove button to the container
    container.appendChild(label);
    container.appendChild(removeButton);
    

    // Insert container and line break before the circle
    droppable.insertBefore(lineBreakBefore, circle.nextSibling);
    droppable.insertBefore(lineBreakBefore, lineBreakBefore.nextSibling);
    droppable.insertBefore(container, lineBreakBefore.nextSibling);
    droppable.insertBefore(lineBreakBefore, container.nextSibling);
    droppable.insertBefore(textarea, lineBreakBefore.nextSibling);
    droppable.insertBefore(lineBreakBefore, textarea.nextSibling);
    droppable.insertBefore(savebtn, lineBreakBefore.nextSibling);
    droppable.insertBefore(cancelbtn, savebtn.nextSibling);
}

function savetxtdtls(draggedId,elementId)
    {
        var textarea            = document.getElementById("textarea_" + draggedId);
        var evidencelabel       = document.getElementById("Evidencelabel_" + draggedId);
        var savebtn             = document.getElementById("Savebtn_" + draggedId);
        var cancelbtn           = document.getElementById("Cancelbtn_" + draggedId);
        var textareaValue       = textarea.value;
        
        var url = '{{ route("updateevidencematrix", ['draggedId' => ':draggedId', 'textareaValue' => ':textareaValue', 'elementId' => ':elementId']) }}';
                url = url.replace(':draggedId', draggedId);
                url = url.replace(':textareaValue', textareaValue);
                url = url.replace(':elementId',elementId);


            $.ajax({
                type: "get",
                url: url,
                data: {
                    'draggedId':     draggedId,
                    'textareaValue':  textareaValue,
                    'elementId':     elementId
                },
                success: function(responseText) {
                    textarea.style.display = 'none';
                    cancelbtn.className = 'hidden-button';
                    savebtn.className = 'hidden-button';
                    evidencelabel.onclick = function () {
                        showsavedtext(responseText.matrixevidenceid);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle the error response
                }
            });
    }

    var isTextareaVisible = false;

    function showsavedtext(id)
    {

        var url = '{{ route("showtextdetails", ['id' => ':id']) }}';
        url = url.replace(':id', id);

    $.ajax({
        type: "get",
        url: url,
        data: {
            'id': id,
        },

        success: function (responseText) {

            var newTxtId = responseText.id;

            var droppedLabel = document.getElementById('Evidencelabel_' + draggedId);
            var removebtn    = document.getElementById('Removebtn_' + draggedId);

            if (droppedLabel) {
                var textareadtls = document.getElementById('textarea_' + newTxtId);

                if (!textareadtls) {
                    textareadtls = document.createElement('textarea');
                    linebr = document.createElement('br');
                    textareadtls.setAttribute('id', 'textarea_' + newTxtId);
                    textareadtls.setAttribute('name', 'textarea_' + newTxtId);
                    textareadtls.rows = 4;
                    textareadtls.cols = 100;
                    textareadtls.value = responseText.textareaValue;

                    var lineBreakn = document.createElement('br');
                    droppedLabel.parentNode.insertBefore(lineBreakn, removebtn.nextSibling);
                    droppedLabel.parentNode.insertBefore(textareadtls, lineBreakn.nextSibling);

                    isTextareaVisible = true; 
                } 
                else {
                    textareadtls.style.display = isTextareaVisible ? 'none' : 'block';
                    isTextareaVisible = !isTextareaVisible; 
                }
            }

        },
        error: function (xhr, textStatus, errorThrown) {
            console.error('Error:', errorThrown);
        }
    });
                
    }

    function substantiate(elementid)
    {
    var url = '/substantiateelement/' + elementid;

    $.ajax({
        type: "GET",
        url: url,
        data: { search: elementid },
        // Rest of the AJAX parameters and callbacks

            success: function(result) {
                var circle = document.getElementById("circle_" + elementid);
                circle.style.backgroundColor = 'green';
                var label = document.getElementById("p_" + elementid);
                label.style.backgroundColor = '#e0e0e0';
                // '#D3D3D3';

            }
        });

    var urlnew = '/findvalues/' + elementid;

    $.ajax({
        type: "GET",
        url: urlnew,
        data: { search: elementid },
        // Rest of the AJAX parameters and callbacks

            success: function(response) {
                
                 console.log('Success:', response.substantiatevalue);
                 var circle = document.getElementById("maincircle");
                 if(response.substantiatevalue == "Yes")
                 {
                     
                    circle.style.backgroundColor = 'green';
                 }
                 else
                 {
                    circle.style.backgroundColor = 'orange';
                 }
            }
        });
        
    }

     function unsubstantiate(elementid)
    {
    var casenoid = document.getElementById("evidencematrixcasenoidadd").value;

    var url = '/unsubstantiateelement/' + elementid ;

    $.ajax({
        type: "GET",
        url: url,
        data: { search: elementid },
        // Rest of the AJAX parameters and callbacks

            success: function(result) {
                var circle = document.getElementById("circle_" + elementid);
                circle.style.backgroundColor = 'orange';
                var label = document.getElementById("p_" + elementid);
                label.style.color = 'black';
            },
            error: function() {
                alert('An error occurred while fetching data.');
            }
        });
        
    }

     function savematrix()
    {
        var matrixid  = document.getElementById("matrixid").value;
        
        
        var url = '{{ route("addevidencematrix", ['matrixid' => ':matrixid']) }}';
            url = url.replace(':matrixid', matrixid);
           

        $.ajax({
            type: "get",
            url: url,
            data: {
                'matrixid':   matrixid,
                
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

    function showelementsmatrixview(id)
    {
        $('#showelementsmatrix').modal('show'); 
            var url = '{{ route("showelementsfrommatrix", ['id' => ':id']) }}';
                url = url.replace(':id', id);
            
            $.ajax({
                type: "get",
                url: url,
                data: {
                    'id':   id,
                },
                success: function(responseText)
                {
                    $("#elementsdivmatrix").html(responseText);
                    $("#elementsdivmatrix").show();
                }
            });
    }
  </script>
@endsection

    <!----------------------------------------------->