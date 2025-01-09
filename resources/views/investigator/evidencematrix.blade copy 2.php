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
                                                            $lastCountForOffenses[$offenseId] = $row->counting; // Store the last count for this offense
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
                                                    @php
                                                        $uniqueOffenceIds = [];
                                                        $serialNumberA = 1; // Initialize the serial number outside the loop
                                                    @endphp
                                                    @foreach($groupedRows as $row)
                                                        @if(!in_array($row->offence_id, $uniqueOffenceIds))
                                                            <p><b>{{ $serialNumberA }}.&nbsp;&nbsp; <?php echo $key = DB::table('tbl_offences_lookup')->where('offence_id', $row->offence_id)->value('offence_type') ?></b></p>
                                                            
                                                            @php
                                                                $uniqueOffenceIds[] = $row->offence_id;
                                                                $serialNumberA++; // Increment the serial number for the next group
                                                                
                                                            @endphp
                                                            
                                                        @endif
                                                        
                                                        <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Count: {{ $row->counting }} &nbsp;&nbsp; <i class="fa fa-eye" onclick="showelementsmatrixview('{{ $row->id }}')" style="color:grey" data-toggle="tooltip" data-placement="bottom" title="View" ></i> &nbsp;<i class="fa fa-edit" onclick="editelementsmatrixview('{{ $row->id }}')" style="color:grey" data-toggle="tooltip" data-placement="bottom" title="Edit" ></i></p>
                                                        
                                                    @endforeach
                                                    

                                                    <!-- -->
                                                </div>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
                                        &nbsp; &nbsp;<label style="font-family:Product Sans" id="selectedValue" onclick="showelements()"></label><input type="hidden" name="matrixid" id="matrixid">
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
<!--edit modal -->
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

<!-- end edit modal -->

<!-- edit modal -->
    <div class="modal fade" id="showmatrixdetailsforedit">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Matrix</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table-bordered">
                        <tr>
                            <td class="narrow-td">
                                @foreach ($evidences as $evi)
                                    <label style="font-family:Product Sans; cursor: move;" draggable="true" ondragstart="dragEdit(event)" id="{{ $evi->id }}"> {{ $evi->evidence_name }}</label><br>
                                @endforeach
                            </td>
                            <td> 
                                <span class="maincircle" name="maincircleedit" id="maincircleedit"> </span><i class="fas fa-search"></i>
                                        &nbsp; &nbsp;<label style="font-family:Product Sans" name="selectedValueEdit" id="selectedValueEdit" ></label>
                                <div id="resultDiv"></div>
                            </td>
                        </tr>
                    </table>
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
        var accusedid = selectedOptionAccused.value;

         
        var dropdown = document.getElementById("offence_types");
        var selectedOption = dropdown.options[dropdown.selectedIndex];
        var selectedText = selectedOption.text;
        var selectedValue = selectedText;
        var offenceid = document.getElementById("offence_types").value;


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
    //}
    function showelements()
        {
            document.getElementById('selectedValue').removeEventListener('click', showelements);
            
            var matrixid= $('#matrixid').val();
            alert(matrixid);
            
            var url = '{{ route("showelements", ":matrixid") }}';
            url = url.replace(':matrixid', matrixid);

            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#matrixid').val()},
                success: function(responseText) {

                var elementsDiv = $('#elementsdiv'); // Select the div where you want to append elements

                $.each(responseText.elements, function (index, element) {
                   var tableRow = $('<tr>');
                    var tdElement = $('<td>')
                        .attr('ondrop', 'drop(event)')
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
                                .click(function () {
                                    labelclick(element.id);
                                })
                                )// Append element_name after the span
                        .append(
                            $('<button>')
                            .addClass('forward-button')
                            .addClass(' hidden-button')
                            .attr('name', 'btn-substantiate_' + element.id)
                            .attr('id', 'btn-substantiate_' + element.id)
                            .text('Substantiate')
                            .click(function () {
                                substantiate(element.id);
                            })
                                )
                        .append(
                            $('<button>')
                            .addClass('forward-button')
                            .addClass('hidden-button')
                            .attr('name', 'btn-unsubstantiate_' + element.id)
                            .attr('id', 'btn-unsubstantiate_' + element.id)
                            .text('Unsubstantiate')
                            .click(function () {
                                unsubstantiate(element.id);
                            })
                                )
                        .append(
                            $('<div>')
                                .attr('class', 'textarea-container')
                                .attr('name', 'textarea-container_' + element.id)
                                .attr('id', 'textarea-container_' + element.id)
                        )
                        .append(
                            $('<div>')
                                .attr('class', 'textarea-container-substantiate')
                                .attr('name', 'textarea-container-substantiate_' + element.id)
                                .attr('id', 'textarea-container-substantiate_' + element.id)
                                .attr('type', 'hidden')
                        );

                    tableRow.append(tdElement);
                    elementsDiv.append(tableRow);
                        // Assuming you have a variable `element` containing the ID
                         var labelclone = $('<label>')
                            .attr('name', 'labelclone_' + element.id)
                            .attr('id', 'labelclone_' + element.id);
                        var textareaContainer = $('#textarea-container_' + element.id);
                            textareaContainer.attr('data-id', element.id);
                        // Create the relevant elements
                        var relevantEvidenceText = $('<br>Relevant Evidence:<br>');
                        var textareaElement = $('<textarea>')
                            .attr('cols', '130')
                            .attr('name', 'txtarea_' + element.id)
                            .attr('id', 'txtarea_' + element.id);
                        var updateButton = $('<button>')
                            .addClass('btn-primary')
                            .attr('style', 'margin-left:600px')
                            .attr('name', 'btn_' + element.id)
                            .attr('id', 'btn_' + element.id)
                            .text('Update')
                            .click(function () {
                                update(element.id);
                            });
                        var cancelButton = $('<button>')
                            .attr('name', 'cancelbtn_' + element.id)
                            .attr('id', 'cancelbtn_' + element.id)
                            .text('Cancel')
                            .click(function () {
                                cancel(element.id);
                            });
                        var hiddenInput = $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'evidenceid_' + element.id)
                            .attr('id', 'evidenceid_' + element.id);

                        // Append these elements to the textareaContainer
                        textareaContainer.append(labelclone);
                        textareaContainer.append(relevantEvidenceText);
                        textareaContainer.append(textareaElement);
                        textareaContainer.append(updateButton);
                        textareaContainer.append(cancelButton);
                        textareaContainer.append(hiddenInput);

                        var textareaContainerSubstantiate = $('#textarea-container-substantiate_' + element.id);
                        
                        var textareaSubstantiate = $('<textarea>')
                            .attr('cols', '130')
                            .attr('name', 'txtareasubstantiate_' + element.id)
                            .attr('id', 'txtareasubstantiate_' + element.id);
                        textareaContainerSubstantiate.append(textareaSubstantiate);

                    });

                    // Append the table row to the elementsDiv
                    
                        }   
                    });
                }
    /////////////////////////////////////////////////////////////////////////////////////////

    function editelementsmatrixview(matrixidedit) {
       
        var url = '{{ route("showelementsforeditfrommatrix", ":matrixidedit") }}';
        url = url.replace(':matrixidedit', matrixidedit);

        $.ajax({
            type: "GET",
            url: url,
            data: {
                'matrixidedit': matrixidedit
            },
            success: function (response) {
                $('#resultDiv').empty();

            $.each(response.data, function (index, element) {
                $('#selectedValueEdit').text(element.offence_type);

                var tableRow = $('<tr>');
                var tdElement = $('<td>')
                    .attr('ondrop', 'dropEdit(event)')
                    .attr('ondragover', 'allowDropEdit(event)')
                    
                    .append(
                        $('<span>')
                            .attr('class', 'circle')
                            .attr('name', 'circleedit_' + element.id)
                            .attr('id', 'circleedit_' + element.id)
                            .css('background-color', function() {
                                if (element.substantiate === 'Substantiated' && element.evidence_id !== null) {
                                    return 'green';
                                } else if (element.substantiate === null && element.evidence_id !== null) {
                                    return 'orange';
                                }
                                return '';
                            })
                    )
                    .append(
                        $('<label>')
                            .attr('class', 'pedit')
                            .attr('name', 'labeledit_' + element.id)
                            .attr('id', 'labeledit_' + element.id)
                            .text(element.element_name)
                            .click(function () {
                                labelclickedit(element.id);
                            })
                    )
                    .append(
                        $('<br>')
                    )
                    
                    .append(
                        
                        $('<span>')
                            .attr('class', 'pedit')
                            .attr('name', 'spanedit_' + element.id)
                            .attr('id', 'spanedit_' + element.id)
                            .text(element.evidence_name !== null ? 'Evidence : ' + element.evidence_name : '')
                            
                    )
                    .append(
                        $('<br>')
                    )

                    .append(
                            $('<textarea>')
                                .attr('class', 'hidden-textarea')
                                .attr('cols', '130')
                                .attr('name', 'textdetailsedit_' + element.id)
                                .attr('id', 'textdetailsedit_' + element.id)
                                .text(element.textdetails)
                        )
                        .append(
                            $('<br>')
                        )
                        .append(
                            $('<button>')
                                .attr('class', 'hidden-button-edit')
                                .attr('name', 'btnsubstantiateedit_' + element.id)
                                .attr('id', 'btnsubstantiateedit_' + element.id)
                                .text('Update and Substantiate')
                                .click(function () {
                                    substantiateedit(element.id);
                                })
                        );
                    
                    
                    tableRow.append(tdElement);
                    $('#resultDiv').append(tableRow);
            
                    


                    // Append the table row to the elementsDiv
                    
                });    

            $('#showmatrixdetailsforedit').modal('show');
        },
        error: function (error) {
            // Handle errors if needed
        }
    });
}

////////////////////////////////////////////////////////////////////////////////////////
    let draggedData = null;
    let draggedId = null;

    function allowDrop(event) {
            event.preventDefault();
        }

    function drag(event) {
            draggedData = event.target.innerText;
            draggedId = event.target.id;
            
        }
    function allowDrop(event) {
        event.preventDefault();
    }

    function drop(event) {
        event.preventDefault();
        var droppable = event.target;
        var circle = droppable.querySelector('.p');
        var textareaContainer = droppable.closest('.textarea-container'); 

        const label = document.createElement('label');
        label.setAttribute('name',  "Evidencelabel_" + draggedId);
        const lineBreak = document.createElement('br');
        var textareaContainer = event.target.querySelector('.textarea-container');

        const removeButton = document.createElement('button');
        removeButton.textContent = ''; // Empty text content
        removeButton.className = 'remove-button';
        removeButton.onclick = function () {
            label.remove();
            textareaContainer.style.display = 'none';
        };

        label.appendChild(document.createTextNode(draggedData + ' '));

        label.appendChild(removeButton);
        label.appendChild(lineBreak);
        droppable.insertBefore(label, circle.nextSibling);

        textareaContainer.style.display = 'block';

        var dataId = textareaContainer.getAttribute('data-id');
        var evidenceInput = document.getElementById("evidenceid_" + dataId);
        if (evidenceInput) {
            evidenceInput.value = draggedId;
        }
    }


    function update(textareaId) {
        var textarea            = document.getElementById("txtarea_" + textareaId);
        var circle              = document.getElementById("circle_" + textareaId);
        var textareaContainer   = document.getElementById("textarea-container_" + textareaId);
        var textareaValue       = textarea.value;
        var evidence            = document.getElementById("evidenceid_" + textareaId);
        var evidenceid          = evidence.value;
        var substantiatebtn     = document.getElementById("btn-substantiate_" + textareaId);
        var textContainersub    = document.getElementById("textarea-container-substantiate_" + textareaId);
        var textareaIdsub       = "txtareasubstantiate_" + textareaId;

        if(textareaValue == "")
        {
            alert("Please enter the text");
        }
        else{
                var url = '{{ route("updateevidencematrix", ['textareaId' => ':textareaId', 'textareaValue' => ':textareaValue', 'evidenceid' => ':evidenceid']) }}';
                url = url.replace(':textareaId', textareaId);
                url = url.replace(':textareaValue', textareaValue);
                url = url.replace(':evidenceid', evidenceid);


            $.ajax({
                type: "get",
                url: url,
                data: {
                    'textareaId':    textareaId,
                    'textareaValue': textareaValue,
                    'evidenceid':    evidenceid,
                },
                success: function(responseText) {
                    // Handle the success response
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle the error response
                }
            });
                textareaContainer.style.display = 'none';
                    circle.style.backgroundColor = 'orange';
                
                    var url = '/showelementforsubstantiate/' + textareaId;
                $.ajax({
                    type: "GET",
                    url: url,
                    data: { search: textareaId },
                    success: function(result) {
                        if (result.data.length > 0) {
                            textContainersub.style.display = 'block';
                            
                            substantiatebtn.style.display = 'block';
                            $('#' + textareaIdsub).show(500);
                            $('#' + textareaIdsub).val(result.data[0].textdetails);
                        }
                    }
                    });
                    
                }
            }

        // Define a flag variable
    var isLabelClickEnabled = true;

    // Function to toggle labelclick
    function toggleLabelClick() {
        isLabelClickEnabled = !isLabelClickEnabled;
    }

    // Modify labelclick to check the flag before executing
    function labelclick(elementid) {
        // Check the flag
        if (isLabelClickEnabled) {
            var textareaId = "txtareasubstantiate_" + elementid;
            var textareaContainer = document.getElementById("textarea-container-substantiate_" + elementid);

            if (textareaContainer.style.display === 'block') {
                // If the textarea container is currently visible, hide it
                textareaContainer.style.display = 'none';
                substantiatebtn.style.display = 'none';
            } else {
                // If the textarea container is currently hidden, show it and load data
                var url = '/showelementforsubstantiate/' + elementid;

                $.ajax({
                    type: "GET",
                    url: url,
                    data: { search: elementid },
                    success: function(result) {
                        if (result.data.length > 0) {
                            textareaContainer.style.display = 'block';
                            
                            $('#' + textareaId).show(500);
                            $('#' + textareaId).val(result.data[0].textdetails);
                        }
                    },
                    error: function() {
                        alert('An error occurred while fetching data.');
                    }
                });
            }
        }
    }

    var isLabelClickEditEnabled = true;

    // Function to toggle labelclick
    function toggleLabelClickEdit() {
        isLabelClickEditEnabled = !isLabelClickEditEnabled;
    }

    // Modify labelclick to check the flag before executing
   function labelclickedit(elementid) {
    // Check the flag
    if (isLabelClickEditEnabled) {
        var textareaId = "textdetailsedit_" + elementid;
        var buttonsubstantiateId = "btnsubstantiateedit_" + elementid;
        var textarea = document.getElementById(textareaId);
        var buttonsubstantiate = document.getElementById(buttonsubstantiateId);

        if (textarea.style.display === 'block' || textarea.style.display === '') {
            // If the textarea container is currently visible or has no display property set, hide it
            textarea.style.display = 'none';
            buttonsubstantiate.style.display = 'none';
        } else {
            textarea.style.display = 'block'; // Show the textarea container
            buttonsubstantiate.style.display = 'block';
            $(buttonsubstantiate).addClass('forward-button-edit');
        }
    }
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
                var substantiatebtn = document.getElementById("btn-substantiate_" + elementid);
                substantiatebtn.style.display = 'none';
                var unsubstantiatebtn = document.getElementById("btn-unsubstantiate_" + elementid);
                unsubstantiatebtn.style.display = 'block';
                var label = document.getElementById("p_" + elementid);
                label.style.color = '#5A5A5A';

                var textareaContainer = document.getElementById("textarea-container-substantiate_" + elementid);
                textareaContainer.style.display = 'none';
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
    function substantiateedit(elementid)
    {

         var textarea   = document.getElementById("textdetailsedit_" + elementid);
         var textareaValue       = textarea.value;
         var evidence = document.getElementById("spanedit_" + elementid);
         var evidenceText = evidence.textContent; // Use textContent


        if(textareaValue == "")
        {
            alert("Please enter the text");
        }
        else if(evidenceText == "")
        {
            alert("Please select Evidence");
        }
        else{
                var url = '{{ route("editevidencematrix", ['elementid' => ':elementid', 'textareaValue' => ':textareaValue']) }}';
                url = url.replace(':elementid', elementid);
                url = url.replace(':textareaValue', textareaValue);


            $.ajax({
                type: "get",
                url: url,
                data: {
                    'elementid':    elementid,
                    'textareaValue': textareaValue
                    
                },
                success: function(responseText) {
                    textarea.style.display = 'none';
                    var circle = document.getElementById("circleedit_" + elementid);
                    circle.style.backgroundColor = 'green';
                    var substantiatebtn = document.getElementById("btnsubstantiateedit_" + elementid);
                    substantiatebtn.style.display = 'none';
                
                },
                
            });
               var urlnew = '/findvalues/' + elementid;

                $.ajax({
                    type: "GET",
                    url: urlnew,
                    data: { search: elementid },
                    // Rest of the AJAX parameters and callbacks

                        success: function(response) {
                            
                            console.log('Success:', response.substantiatevalue);
                            var maincircle = document.getElementById("maincircleedit");
                            if(response.substantiatevalue == "Yes")
                            {
                                
                                maincircle.style.backgroundColor = 'green';
                            }
                            else
                            {
                                maincircle.style.backgroundColor = 'orange';
                            }
                        }
                    });
                   
                }
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
                var substantiatebtn = document.getElementById("btn-substantiate_" + elementid);
                substantiatebtn.style.display = 'block';
                var unsubstantiatebtn = document.getElementById("btn-unsubstantiate_" + elementid);
                unsubstantiatebtn.style.display = 'none';
                var label = document.getElementById("p_" + elementid);
                label.style.color = 'black';
                var textareaContainer = document.getElementById("textarea-container-substantiate_" + elementid);
                textareaContainer.style.display = 'block';
            },
            error: function() {
                alert('An error occurred while fetching data.');
            }
        });
        
    }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    let draggedDataEdit = null;
    let draggedIdEdit = null;

    function allowDropEdit(event) {
            event.preventDefault();
        }

    function dragEdit(event) {
            draggedDataEdit = event.target.innerText;
            draggedIdEdit = event.target.id;
            
        }
    function allowDropEdit(event) {
        event.preventDefault();
    }

    function dropEdit(event) {
        
        event.preventDefault();
        var droppable = event.target;
        const label = document.createElement('label');
        var textareaContainer = event.target.querySelector('.hidden-textarea');
        textareaContainer.style.display = 'block';
        var btnsub = event.target.querySelector('.hidden-button-edit');
        btnsub.style.display = 'block';
        label.innerText = draggedDataEdit;
        label.id = draggedIdEdit;
        droppable.appendChild(label);

        
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

<style>
   
/* Define a CSS class to make the <td> elements wider */
    .wider-td {
        width: 200px; /* Adjust the width as needed */
    }

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
    
    .forward-button-edit {
            padding: 5px 10px;
            background-color: #007bff; /* Blue color, you can change this */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 10px;
            float: right;
        }

        /* Style for the icon */
    .icon {
            margin-right: 5px; /* Spacing between the icon and text */
        }

    .droppable {
        position: relative;
        display: inline-block;
        padding: 5px;
    }

    .circle {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: red;
        margin-right: 5px;
    }


    .textarea-container {
        display: none;
        margin-top: -5px;
        
    }
    .textarea-container-substantiate {
        display: none;
        margin-top: 10px;
    }
    .p {
    margin-top: -21px;
    margin-left: 20px;
    margin-bottom: 1rem;
    }
     
    .custom-button {
        background-color: blue; /* Background color */
        border: none; /* Remove border */
        color: white; /* Text color */
        margin-left : 699px;
        text-align: center; /* Center the text horizontally */
        text-decoration: none; /* Remove underline */
        display: inline-block; /* Make it behave like a block element */
        font-size: 19px; /* Font size */
        border-radius: 2px; /* Rounded corners */
        cursor: pointer; /* Show a pointer cursor on hover */
        height : 20px;
        }
    
    /* Define a CSS class to hide the button */
    .hidden-button {
        display: none;
    }
    .hidden-textarea {
        display: none;
    }
    .hidden-button-edit{
        display: none;
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

    /* Style for the Remove button */
.remove-button {
    background-color: red;
    color: white;
    border: none;
    padding: 5px;
    cursor: pointer;
    position: relative;
}

/* Style for the X symbol inside the Remove button */
.remove-button::before {
    content: '×'; /* Unicode character for the X symbol */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.2em; /* Adjust the font size to make the X smaller or larger */
}

/* Add more styles for hover or active states if desired */


</style>
@endsection