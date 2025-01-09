


@foreach ($elements as $eleitem)
<tr>
    <td ondrop="drop(event)" ondragover="allowDrop(event)">
    
        <span class="circle" name="circle_{{ $eleitem->id }}" id="circle_{{ $eleitem->id }}"></span><p class="p" id="p_{{ $eleitem->id }}" name="p_{{ $eleitem->id }}" onclick="labelclick('{{ $eleitem->id }}')"><?php echo $key=DB::table('tbl_elements_lookup')->where('id', $eleitem->element_id)->value('element_name') ?></p>
        <div class="textarea-container" name="textarea-container_{{ $eleitem->id }}" id="textarea-container_{{ $eleitem->id }}" data-id="{{ $eleitem->id }}">
            <br>
            
            Relevant Evidence:<br>
            <textarea cols="130" name="txtarea_{{ $eleitem->id }}" id="txtarea_{{ $eleitem->id }}"></textarea><br>
            <button class="btn-primary" style="margin-left:600px" name="btn_{{ $eleitem->id }}" id="btn_{{ $eleitem->id }}" onclick="update('{{ $eleitem->id }}')">Update</button>
            <button name="cancelbtn_{{ $eleitem->id }}" id="cancelbtn_{{ $eleitem->id }}" onclick="cancel('{{ $eleitem->id }}')">Cancel</button>
            <input name="evidenceid_{{ $eleitem->id }}" id="evidenceid_{{ $eleitem->id }}" type="hidden">
        </div>
        <div class="textarea-container-substantiate" id="textarea-container-substantiate_{{ $eleitem->id }}">
            <input type="hidden" id="required_{{ $eleitem->id }}" value="{{ $eleitem->required }}">
            <textarea cols="130" readonly name="txtareasubstantiate_{{ $eleitem->id }}" id="txtareasubstantiate_{{ $eleitem->id }}" onclick="showsubstantiate('{{ $eleitem->id }}')"></textarea><br>
            <button style="display:none" name="btn-substantiate_{{ $eleitem->id }}" id="btn-substantiate_{{ $eleitem->id }}" onclick="substantiate('{{ $eleitem->id }}')">Substantiate</button>
        </div>
    </td>
</tr>
@endforeach



<script>
  function allowDrop(event) {
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();
        var droppable = event.target;
        var circle = droppable.querySelector('.p');
        var textareaContainer = droppable.closest('.textarea-container'); 

        droppable.insertBefore(document.createTextNode(draggedData + ' '), circle.nextSibling);
        var textareaContainer = event.target.querySelector('.textarea-container');
         var draggeddatatest = event.target.querySelector('.label');
        textareaContainer.style.display = 'block';

        var dataId = textareaContainer.getAttribute('data-id');
        var evidenceInput = document.getElementById("evidenceid_" + dataId);
            if (evidenceInput) {
                evidenceInput.value = draggedId;
            }
}

function showTextarea(event) {
    // Hide the textarea-container when the circle is clicked
    var textareaContainer = event.target.parentNode.querySelector('.textarea-container');
    textareaContainer.style.display = 'block';
}

function update(textareaId) {
    var textarea            = document.getElementById("txtarea_" + textareaId);
    var circle              = document.getElementById("circle_" + textareaId);
    var textareaContainer   = document.getElementById("textarea-container_" + textareaId);
    var textareaValue       = textarea.value;
    var accusedname         = document.getElementById("searchsuspect").value;
    var offencename         = document.getElementById("offence_types").value;
    var casenoid            = document.getElementById("evidencematrixcasenoidadd").value;
    var evidence            = document.getElementById("evidenceid_" + textareaId);
    var evidenceid          = evidence.value;

    if(textareaValue == "")
    {
        alert("Please enter the text");
    }
    else{
            var url = '{{ route("updateevidencematrix", ['textareaId' => ':textareaId', 'textareaValue' => ':textareaValue','accusedname' => ':accusedname', 'offencename' => ':offencename', 'casenoid' => ':casenoid', 'evidenceid' => ':evidenceid']) }}';
            url = url.replace(':textareaId', textareaId);
            url = url.replace(':textareaValue', textareaValue);
            url = url.replace(':accusedname', accusedname);
            url = url.replace(':offencename', offencename);
            url = url.replace(':casenoid', casenoid);
            url = url.replace(':evidenceid', evidenceid);


        $.ajax({
            type: "get",
            url: url,
            data: {
                'textareaId':    textareaId,
                'textareaValue': textareaValue,
                'accusedname':   accusedname,
                'offencename':   offencename,
                'casenoid':      casenoid,
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
            }
        }

    function cancel(textareaId) {
        var circle = document.getElementById("circle_" + textareaId);
        var textareaContainer = document.getElementById("textarea-container_" + textareaId);
        
        textareaContainer.style.display = 'none';
        circle.style.backgroundColor = 'red';

    }

function labelclick(elementid) {
    var circle = document.getElementById("circle_" + elementid);
    var textarea = document.getElementById("txtarea_" + elementid);
    var textareaId = "txtarea_" + elementid;
                $('#' + textareaId).show(500);

    var url = '/showelementforsubstantiate/' + elementid;

    $.ajax({
        type: "GET",
        url: url,
        data: { search: elementid },
        success: function(result) {
            if (result.data.length > 0) {
                var textareaId = "txtareasubstantiate_" + elementid;
                var textareaContainer = document.getElementById("textarea-container-substantiate_" + elementid);
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

function showsubstantiate(elementid)
{
    var btnsub = document.getElementById("btn-substantiate_" + elementid);
    btnsub.style.display = 'block';

}

function substantiate(elementid)
{
    var casenoid = document.getElementById("evidencematrixcasenoidadd").value;

    var url = '/substantiateelement/' + elementid + '/'+ casenoid;

    $.ajax({
        type: "GET",
        url: url,
        data: { search: elementid, search: casenoid },
        // Rest of the AJAX parameters and callbacks

            success: function(result) {
                var circle = document.getElementById("circle_" + elementid);
                circle.style.backgroundColor = 'green';
                var requiredElement = document.getElementById("required_" + elementid);

                if (requiredElement) {
                var requiredValue = requiredElement.value;

                for (var i = 0; i < requiredValue.length; i++) {
                    if (requiredValue.charAt(i) === "N" || requiredValue.charAt(i) === "o") {
                        var circle = document.getElementById("maincircle");
                                circle.style.backgroundColor = 'green';
                    break; // Exit the loop as soon as we find "No"
                    }
                    
                }

                if (i === requiredValue.length) {
                    console.log("The value does not contain 'No'");
                }
                } else {
                console.log("Element with ID 'required_" + elementid + "' not found");
                }

                var textareaContainer = document.getElementById("textarea-container-substantiate_" + elementid);
                textareaContainer.style.display = 'none';
            },
            error: function() {
                alert('An error occurred while fetching data.');
            }
        });
        
    }


</script>
<style>
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
</style>

    
  





