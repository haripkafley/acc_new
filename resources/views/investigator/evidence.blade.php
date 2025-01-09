

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
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="addnewevidencetag()">
                            <span><i class="fa fa-plus"></i></span>    
                            <span style="font:face:Product Sans">Add Evidence</span>
                        </button>
                    @endif
                            <br>
                            <br>
                        <div id="showevidencetag">
                            <div id="enlargedImgModal" style="display: none;">
                                <span id="closeBtn" style="display: none; position: absolute; top: 10px; right: 10px; cursor: pointer;" onclick="closeBiggerImage()">&times;</span>
                                <img id="enlargedImg" src="" alt="Enlarged Image" style="max-width: 90%; max-height: 90%;">
                            </div>
                        <table class="table t2">
                            <tr>
                                <th>Exhibit</th>
                                <th>Exhibit Name</th>
                                <th>Exhibit No</th>
                                <th>Collected On</th>
                                <th>Collected By</th>
                                <th>Description</th>
                                <th>Elementize</th>
                                <th>Action</th>
                            </tr>
                            @if($evidences->count())
                            @foreach($evidences as $evidence)
                            <tr>
                                <td>
                                    @if(in_array($evidence->evidence_file_extension, ['jpg', 'jpeg', 'png', 'gif']))
                                        <i class="fas fa-camera evidence-icon" data-type="image" data-url="{{ asset('Evidences/' .$evidence->id.'/' .$evidence->evidence_file_name) }}"></i>
                                    @elseif (in_array($evidence->evidence_file_extension, ['docx', 'doc']))
                                        <i class="far fa-file-word evidence-icon" data-type="document" data-url="{{ asset('Evidences/' .$evidence->id.'/' .$evidence->evidence_file_name) }}"></i>
                                    @elseif (in_array($evidence->evidence_file_extension, ['pdf']))
                                        <i class="far fa-file-pdf evidence-icon" data-type="pdf" data-url="{{ asset('Evidences/' .$evidence->id.'/' .$evidence->evidence_file_name) }}"></i>
                                    @else
                                        <p>Unsupported file type: {{ $evidence->evidence_file_extension }}</p>
                                    @endif
                                </td>
                                <td>{{ $evidence->evidence_name	 }}</td>
                                <td>{{ $evidence->evidence_no }}</td>
                                <td>{{ \Carbon\Carbon::parse($evidence->collected_on)->format('d/m/Y')}}</td>
                                <td><?php echo $key=DB::table('users')->where('email', $evidence->collected_by)->value('name') ?></td>
                                <td>{{ $evidence->evidence_description }}</td>
                                <td>
                                    @if(DB::table('tbl_case_evidence_matrix_three')->where('evidence_id', $evidence->id)->exists())
                                        Yes
                                    @else
                                    No
                                    @endif
                                </td>
                                <td>
                                    
                                    <i class="fa fa-eye" onclick="showviewevidence('{{ $evidence->id }}')" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="View" ></i>&nbsp; &nbsp;
                                    <i class="fa fa-edit grey-trash-icon" onclick="showeditevidence('{{ $evidence->id }}')" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Edit" ></i>&nbsp; &nbsp;
                                    <a style="color:red" href="{{ route('deleteevidence', ['id' => $evidence->id]) }}" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Are you sure you want to delete this record?') || event.preventDefault();"><i class="fa fa-trash"></i></a> &nbsp;
                                    <!-- <i class="fa fa-print" onclick="showprintevidence('{{ $evidence->id }}')" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Print" ></i>&nbsp; &nbsp;
                                    <i class="fa fa-download" onclick="showdownloadevidence('{{ $evidence->id }}')" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="bottom" title="Download" ></i>&nbsp; &nbsp; -->
                                </td>
                            </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="8"> No record found </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
<!-- display -->
<div id="contentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contentModalLabel">File Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="contentContainer">
                <!-- Content will be displayed here -->
            </div>
        </div>
    </div>
</div>
<!-- -->
<!--add modal -->
<form method = "POST" action="{{ route('addevidences') }}"  enctype="multipart/form-data" >
      @csrf
<div class="modal fade" id="addevidence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add Exhibit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-family:Product Sans">
                   <div class="row"> 
                        <input type="hidden" name="evicasenoidadd" id="evicasenoidadd" value="{{ $casenoid }}" >
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Evidence Category&nbsp;<font color='red'>*</font></label>
                                <select class="form-control" name="evidencecat" id="evidencecat" onchange="updateExhibitNo()" required>
                                    <option selected="selected" value="">--select one--</option>
                                    @foreach ($evidencecategory as $cat)
                                    <option value="{{ $cat->name }}" >{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Exhibit Number&nbsp;<font color='red'>*</font></label>
                                <input type="text" name="evidenceno" class="form-control" id="evidenceno" readonly >
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Exhibit Name&nbsp;<font color='red'>*</font></label>
                                    <input type="text" name="evidname"  class="form-control" id="evidname" required>   
                            </div>
                        </div>
                        <div class="col-sm-6">
                               <div class="form-group">
                                    <label>Collected On&nbsp;<font color='red'>*</font></label>
                                    <input type="date" name="collected_on"  class="form-control" id="collected_on" required>
                                </div> 
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-sm-6">
                                <div class="form-group">
                                <label>Collected Method&nbsp;<font color='red'>*</font></label>
                                    <select class="form-control"   name="evidfrom" id="evidfrom" required>
                                        <option value="">Select</option>
                                            @foreach ($collectionmethods as $method)
                                                <option >{{ $method->method }}</option>
                                            @endforeach    
                                    </select>   
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label>Collected By&nbsp;<font color='red'>*</font></label>
                                <select class="form-control"   name="evidcollectedby" id="evidcollectedby" required>
                                    <option value="">Select</option>
                                        @foreach ($officers as $off)
                                            <option value="{{ $off->email }}">{{ $off->name }}</option>
                                        @endforeach    
                                </select>   
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                    <label>Description&nbsp;<font color='red'>*</font></label>
                                    <textarea name="evidescription"  class="form-control" id="evidescription" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Upload Exhibit&nbsp;<font color='red'>*</font></label>(accepted format:pdf,doc,docx,jpg,png,jpeg,gif)
                                <input type="file" name="eviexhibit"   class="form-control" id="eviexhibit" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="return validateForm()">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end add modal -->

<!-- edit modal -->
  <form method="POST" action="{{ route('updateevid') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="editevidencemodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Exhibit</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="evidenceid" id="evidenceid">
                    <div id="editevidenceshow" style="display:none"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- end edit modal -->
<!-- view modal -->
<form method="POST" action="{{ route('updateevid') }}" enctype="multipart/form-data">
                            @csrf
    <div class="modal fade" id="viewevidencemodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Exhibit</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="evidenceidview" id="evidenceidview">
                    <div id="viewevidenceshow" style="display:none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- end edit modal -->
<script>
    
	function addnewevidencetag()
        {
            $('#addevidence').modal('show');  
        }
    
    function showeditevidence(id)
        {
            $('#editevidencemodal').modal('show'); 
            $('#evidenceid').val(id);

            var url = '{{ route("editevid", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#evidenceid').val()},
                success: function(responseText) {
                    
                    $("#editevidenceshow").html(responseText);
                    $('#editevidenceshow').show();   
                }
            });
        }

        function showviewevidence(id)
        {
            $('#viewevidencemodal').modal('show'); 
            $('#evidenceidview').val(id);

            var url = '{{ route("viewevid", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#evidenceidview').val()},
                success: function(responseText) {
                    
                    $("#viewevidenceshow").html(responseText);
                    $('#viewevidenceshow').show();   
                }
            });
        }
    
       function updateExhibitNo() {
        var evidenceCat = $('#evidencecat option:selected');
        var categoryname = evidenceCat.text();
        var casenoid = {{ $casenoid}};
        
        var url = '{{ route("getLastExhibitNumber", ['categoryname' => ':categoryname', 'casenoid' => ':casenoid']) }}';
                url = url.replace(':categoryname', categoryname);
                url = url.replace(':casenoid', casenoid);
                    $.ajax({
                        type:"GET",
                        url: url,
                        data: {
                            'categoryname':   categoryname,
                            'categoryname':   categoryname,   
                        },
                        success: function(data) {
                        console.log(data);
                        $('#evidenceno').val(data);
                    },
                    error:function(e){
                        console.log(e,'error');
                    }
                });
            }

    document.querySelectorAll('.evidence-icon').forEach(icon => {
        icon.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const url = this.getAttribute('data-url');
            const contentContainer = document.getElementById('contentContainer');
            
            // Clear any previous content
            contentContainer.innerHTML = '';

           if (type === 'image') {
    // Display an image
    const img = document.createElement('img');
    img.src = url;
    img.style.maxWidth = '100%';
    img.style.height = 'auto';

    // Create a div container to hold the image
    const imgContainer = document.createElement('div');
    imgContainer.appendChild(img);

    // Create a print icon element
const printIcon = document.createElement('i');
printIcon.className = 'fas fa-print'; // Assuming you're using Font Awesome
printIcon.style.cursor = 'pointer'; // Make the icon look clickable

// Append the print icon to the document body or any other desired container
document.body.appendChild(printIcon); // You can replace `document.body` with your desired container

// Add a click event listener to the icon
printIcon.addEventListener('click', () => {
    // Open a print dialog for the content you want to print
    const printWindow = window.open('', '', 'width=600,height=600');
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print</title></head><body>');
    printWindow.document.write('<img src="' + url + '" style="max-width:100%;height:auto;" />');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
    printWindow.close();
});


    // Create a "Download" button
    // Create a download anchor element
const downloadButton = document.createElement('a');
downloadButton.href = url;
downloadButton.download = 'image.jpg';
downloadButton.style.color ="black";

// Create a download icon element
const downloadIcon = document.createElement('i');
downloadIcon.className = 'fas fa-download'; // Assuming you're using Font Awesome

// Append the download icon to the anchor element
downloadButton.appendChild(downloadIcon);

// Append the anchor element to the document body or any other desired container


    // Append the image, print button, and download button to the content container
    contentContainer.appendChild(imgContainer);
    contentContainer.appendChild(printIcon);
    contentContainer.appendChild(downloadButton);
} else {
    // Display documents and PDFs using an iframe
    const iframe = document.createElement('iframe');
    iframe.src = url;
    iframe.style.width = '100%';
    iframe.style.height = '500px'; // Adjust the height as needed

    // Append the iframe to the content container
    contentContainer.appendChild(iframe);
}


            // Show the modal
            $('#contentModal').modal('show');
        });
    });

function showBiggerImage(imageSrc) {
  // Get the modal and the image elements
  var modal = document.getElementById('enlargedImgModal');
  var img = document.getElementById('enlargedImg');
  var closeBtn = document.getElementById('closeBtn');

  // Set the image source to the clicked image source
  img.src = imageSrc;

  // Show the modal and close button
  modal.style.display = 'block';
  closeBtn.style.display = 'block';
}

// Function to close the modal when the user clicks the close button
function closeBiggerImage() {
  var modal = document.getElementById('enlargedImgModal');
  var closeBtn = document.getElementById('closeBtn');

  // Hide the modal and close button
  modal.style.display = 'none';
  closeBtn.style.display = 'none';
}

// Function to close the modal when the user clicks outside the image or close button
window.onclick = function(event) {
  var modal = document.getElementById('enlargedImgModal');
  if (event.target === modal) {
    closeBiggerImage();
  }
};

function validateForm() {
    
    const fileInput = document.getElementById('eviexhibit');
    const allowedFormats = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpeg', 'image/gif'];

    if (fileInput.files.length > 0) {
        const fileType = fileInput.files[0].type;

        if (!allowedFormats.includes(fileType)) {
            alert('Please upload a valid file format (pdf, doc, docx, jpg, jpeg, png, gif).');
            event.preventDefault(); // Prevent form submission
        }
    }

    return true;
}
</script>

<style>

    /* Style for the modal container */
#enlargedImgModal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black background */
  z-index: 9999; /* Make the modal appear on top of other content */
  overflow: auto;
}

/* Style for the enlarged image */
#enlargedImg {
  display: block;
  max-width: 90%;
  max-height: 90%;
  margin: 50px auto; /* Center the image vertically and horizontally */
}

/* Style for the close button */
#closeBtn {
  display: none;
  position: absolute;
  top: 10px;
  right: 10px;
  color: #fff;
  font-size: 30px;
  cursor: pointer;
}

/* Style for the close button on hover */
#closeBtn:hover {
  color: #ff0000; /* Change the color to red on hover */
}

.modal-header {
    background: linear-gradient(to top, grey, #ffffff);
    color: #fff;
    font-family: Product Sans;
    border-radius: 5px 5px 0 0;
}

.t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
}
.evidence-link {
  padding: 5px 10px;
  background-color: #fff;
  color: #000;
  text-decoration: none;
  border-radius: 5px;
}

.evidence-link i {
  margin-right: 5px; /* Add some space between the icon and the text */
  font-size: 20px;
}

.round-image {
  border-radius: 20%; /* Set the border radius to 50% to make it circular */
  height: 130px; /* Set the desired height */
  width: 130px; /* Set the desired width */
}

.red-trash-icon {
    color: red;
}

.grey-trash-icon {
    color: grey;
}

</style>

@endsection