@foreach ($entitydetailsshow as $showentitydtls)

    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Name&nbsp;</label>
                <input type="text" name="personname"  class="form-control" id="personname" value="{{ $showentitydtls->name }}"  required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
            <label>Identification No&nbsp;</label>
                <input type="text" name="identificationno"  class="form-control" id="identificationno" value="{{ $showentitydtls->identification_no }}"  required>   
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Nationality&nbsp;</label>
                <input type="text" name="nationality"  class="form-control" id="nationality" value="{{ $showentitydtls->type }}"  required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Date of Birth&nbsp;</label>
                   
                <input type="date" name="dateofbirth" class="form-control" id="dateofbirth" value="{{ $showentitydtls->dateofbirth }}" required>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Gender&nbsp;</label>
                    <select name="gender" class="form-control"  required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ $showentitydtls->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $showentitydtls->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>

            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
            <label>Phone No&nbsp;</label>
                <input type="text" name="phoneno"  class="form-control" id="phoneno" value="{{ $showentitydtls->contactno }}" type="number" placeholder="Mobile No" title="Please enter exactly 8 digits" oninput="javascript: if (this.value.length > 8) this.value = this.value.slice(0, 8);"  required>   
            </div>
        </div>
    </div>
    @if($showentitydtls->type == "Bhutanese")
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Dzongkhag&nbsp;</label>
                <input type="text" name="dzongkhag"  class="form-control" id="dzongkhag" value="{{ $showentitydtls->dzongkhag }}" >
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Village&nbsp;</label>
                <input type="text" name="village"  class="form-control" id="village" value="{{ $showentitydtls->village }}" >
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Gewog&nbsp;</label>
                <input type="text" name="gewog"  class="form-control" id="gewog" value="{{ $showentitydtls->gewog }}" >
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Email&nbsp;</label>
                <input type="text" name="email"  class="form-control" id="email" value="{{ $showentitydtls->email }}" >
            </div>
        </div>
    </div>
    @endif
    @if($showentitydtls->type == "Non Bhutanese")
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Permanent Address&nbsp;</label>
                <input type="text" name="paddress"  class="form-control" id="paddress" value="{{ $showentitydtls->permanentaddress }}" >
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Email&nbsp;</label>
                <input type="text" name="email"  class="form-control" id="email" >
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Photo&nbsp;&nbsp;&nbsp;</label>
                <img src="{{ asset('Entity/' .$showentitydtls->id.'/' .$showentitydtls->photo_name) }}"   alt="User Image" style="height:45px;width:45px;" onclick="showBiggerImage('{{ asset('Entity/' .$showentitydtls->id.'/' .$showentitydtls->photo_name) }}')">
                
            </div>
        
            <div class="form-group">
                <label for   = "exampleInputEmail1">Change Photo&nbsp;(accepted format: jpg,jpeg,png,gif)</label>
                    <input  name="bhutanesephoto" id="bhutanesephoto"  class="form-control" type="file" >
                <div id="enlargedImgModal" style="display: none;">
                    <span id="closeBtn" style="display: none; position: absolute; top: 10px; right: 10px; cursor: pointer;" onclick="closeBiggerImage()">&times;</span>
                    <img id="enlargedImg" src="" alt="Enlarged Image" style="max-width: 90%; max-height: 90%;">
                </div>
            </div>
        </div>
    </div>
@endforeach
<script>
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
</style>


    