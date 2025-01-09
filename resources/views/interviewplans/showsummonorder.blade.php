<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>Report To<span style="font-weight: bold; color: red;">*</span></label>
                <select class="form-control" name="add_report_to" required>
                    <option value="">Select One</option>
                    @foreach ($interviewers as $intpersons)
                    <option value="{{ $intpersons->email }}">{{ $intpersons->name }}</option>
                    @endforeach
                </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Date<span style="font-weight: bold; color: red;">*</span></label>
                <input class="form-control" name="summondate" type="date" required>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Time<span style="font-weight: bold; color: red;">*</span></label>
                <input class="form-control" name="summontime" type="time" required>
        </div>
    </div>

    <div class="col-sm-10">
        <div class="form-group">
            <label>Venue<span style="font-weight: bold; color: red;">*</span></label>
                <textarea class="form-control" name="summonvenue" required></textarea>
        </div>
    </div>
   <div class="col-sm-12">
        <h6><b>Documents to be produced</b></h6>
            <table id= "example3" class="table table-bordered ">
                <thead >
                    <tr>
                        <th scope="col">Description of Document/Article</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">Action</th>
                        
                    </tr>
                </thead>
                <tbody id="documentstable">
                    <td><input type="text" name="description[]" class="form-control" required></td>
                    <td><input type="number" name="quantity[]" class="form-control" required></td>
                    <td><input type="text" name="remarks[]" class="form-control" required></td>
                    <td><button type="button" onclick="addRow()">Add More</button></td>
                </tbody>
            </table>
    </div>
</div>
<script>
    function addRow() {
        var tableBody = document.getElementById('documentstable');
        var newRow = tableBody.insertRow();
        
        // Create cells for each column
        var cell1 = newRow.insertCell();
        var cell2 = newRow.insertCell();
        var cell3 = newRow.insertCell();
        var cell4 = newRow.insertCell();
        
        // Set the content of the cells
        cell1.innerHTML = '<input type="text" name="description[]" class="form-control">';
        cell2.innerHTML = '<input type="number" name="quantity[]" class="form-control">';
        cell3.innerHTML = '<input type="text" name="remarks[]" class="form-control">';
        cell4.innerHTML = '<button type="button" onclick="removeRow(this)">Remove</button>';
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
