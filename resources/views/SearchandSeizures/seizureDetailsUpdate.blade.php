@foreach($seizuredtls as $data)
<div class="row">
    <div class="col-md-3">
        <label style="font-family:Product Sans">Seziure Date:&nbsp;</label>
        <br>
            {{ \Carbon\Carbon::parse($data->seizure_date)->format('d/m/Y') }}
    </div>
    <div class="col-md-3">
        <label style="font-family:Product Sans">Seziure Time:&nbsp;</label>
        <br>
            {{ $data->seizure_time }}
    </div>
    <div class="col-md-3">
        <label style="font-family:Product Sans">Seized From (CID):&nbsp;</label>
        <br>
            {{ $data->seized_from_cid }}
    </div> 
    <div class="col-md-3">
        <label style="font-family:Product Sans">Seized From (Name):&nbsp;</label>
        <br>
            {{ $data->seized_from_name }}
    </div>
</div>
@endforeach
<hr>
    <div class="row">
        <div class="col-md-6">
            <label class="text-info"><b>Officer Conducting Seize</b>&nbsp;</label>
                <ol>
                    @foreach ($officers as $off)
                        <li> 
                            <?php echo $key=DB::table('users')->where('email',$off->officer_email)->value('name'); ?> <br>
                        </li>
                    @endforeach
                </ol> 
        </div>
    
        <div class="col-md-6">
            <label class="text-info"><b>Witness</b>&nbsp;</label>
                <ol>
                    @foreach ($witnesses as $wit)
                        <li> 
                            {{ $wit->witness_name}} [CID : {{ $wit->witness_cid }} ]
                        </li>
                    @endforeach
                </ol> 
        </div>
    </div>
    <hr>
    
    <label class="text-info"><b>Seized Items</b>&nbsp;</label>
        <table class="table t2" id="digitalitemstable">
            <thead>
                <!-- <th></th> -->
                <th>Category</th>
                <th>Name</th>
                <th>Manufacturer</th>
                <th>Model</th>
                <th>Serial No</th>
                <th>Condition</th>
                <th>Status</th>
            </thead>
             @if($seizeditemsdigital->count())
            @foreach($seizeditemsdigital as $items)
            <tbody>
                <!-- <td><input type="checkbox" name="selected[]" value="{{ $items->id }}"><input type="hidden" id="casenoidseizure" name="casenoidseizure" value="{{ $items->id }}"></td> -->
                <td>{{ $items->item_type}}</td>
                <td>{{ $items->item_name}}</td>
                <td>{{ $items->manufacturer}}</td>
                <td>{{ $items->model}}</td>
                <td>{{ $items->serial_no}}</td>
                <td>{{ $items->condition}}</td>
                <td>{{ $items->status}}</td>
                <td > 
                    @if($items->status == "Seized")
                        <i class="fa fa-edit" onclick="openstatus('{{ $items->id}}')" style="color:green;" onmouseover="this.style.color='#333333';" onmouseout="this.style.color='green';" data-toggle="tooltip" data-placement="bottom" title="Send to Forensics"></i>
                    @endif
                </td>
            </tbody>
            @endforeach
            @else
            <tr>
                <td colspan="7"> No record found </td>
            </tr>
            @endif
            
        </table>
        <br>
        <table class="table t2" id="emailTable">
            <thead>
                <th>Category</th>
                <th>Email Id</th>
                <th>Password</th>
                <th>Old Password</th>
                <th>Inbox</th>
                <th>Sent</th>
                <th>Draft</th>
                <th>Spam</th>
            </thead>
             @if($seizeditemspassport->count())
            @foreach($seizeditemsemail as $emailitems)
            <tbody>
                <td>{{ $emailitems->item_type}}</td>
                <td>{{ $emailitems->email_address}}</td>
                <td>{{ $emailitems->password}}</td>
                <td>{{ $emailitems->oldpassword}}</td>
                <td>{{ $emailitems->inbox}}</td>
                <td>{{ $emailitems->sent}}</td>
                <td>{{ $emailitems->draft}}</td>
                <td>{{ $emailitems->spam}}</td>
            </tbody>
            @endforeach
            @else
            <tr>
                <td colspan="8"> No record found </td>
            </tr>
            @endif
        </table>
            <br>
        
        <table class="table t2" id="socialmediaTable">
            <thead>
                <th>Category</th>
                <th>Platform</th>
                <th>Password</th>
                <th>Old Password</th>
            </thead>
             @if($seizeditemspassport->count())
            @foreach($seizeditemssocial as $socialitems)
            <tbody>
                <td>{{ $socialitems->item_type}}</td>
                <td>{{ $socialitems->platform}}</td>
                <td>{{ $socialitems->password}}</td>
                <td>{{ $socialitems->oldpassword}}</td>
            </tbody>
            @endforeach
            @else
            <tr>
                <td colspan="4"> No record found </td>
            </tr>
            @endif
        </table>
        <br>
       
        <table class="table t2" id="passportTable">
            <thead>
                <th>Category</th>
                <th>Name</th>
                <th>Passport No</th>
                <th>Issue Date</th>
                <th>Expiry Date</th>
            </thead>
             @if($seizeditemspassport->count())
             @foreach($seizeditemspassport as $passportitems)
            <tbody>
                
                <td>{{ $passportitems->item_type}}</td>
                <td>{{ $passportitems->passportname}}</td>
                <td>{{ $passportitems->passportno}}</td>
                <td>{{ $passportitems->passportissuedate}}</td>
                <td>{{ $passportitems->passportexpirydate}}</td>
                
            </tbody>
             @endforeach
             @else
            <tr>
                <td colspan="5"> No record found </td>
            </tr>
            @endif
        </table>
        
        <br>
        
        <table class="table t2" id="passportTable">
            <thead>
                <th>Category</th>
                <th>Amount</th>
            </thead>
            @if($seizeditemscurrency->count())
             @foreach($seizeditemscurrency as $currencyitems)
            <tbody>
                <td>{{ $currencyitems->item_type}}</td>
                <td>{{ $currencyitems->currencyamt}}</td>
            </tbody>
            @endforeach
            @else
            <tr>
                <td colspan="2"> No record found </td>
            </tr>
            @endif
            
        </table>
        <br><br>
        

<form id="addForm" >
    @csrf 
    <div class="modal fade" id="changestatusmodal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Status</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type ="hidden" name="idseizure" id="idseizure">
                                <label style="font-family:Product Sans">Search Type Requested&nbsp;<font color='red'>*</font></label>
                                    <select class="form-control" name="typeofsearch">
                                        <option selected>Select an Option</option>
                                        <option value="Send to SPMD">Send to SPMD</option>
                                        <option value="Send to Forensics">Send to Forensics</option>
                                    </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onclick="updateseizurestatus()">Update</button>
                </div>
            </div>
        </div>
    </div>
    </form>

<style>
    
.t2{
    outline: 2px dotted #ccc;
    font-family:Product Sans;
}
</style>
<script>

    function openstatus(id)
    {
        $('#changestatusmodal').modal('show');  
        $('#idseizure').val(id);
        
    }

    function updateseizurestatus()
    {
        $.ajax({
                url: '{{ route('updateseizurestatus') }}',
                type: 'POST',
                dataType: 'json',
                data: $('#addForm').serialize(),
                success: function(data) {
                    $('#changestatusmodal').modal('hide');
                    $('#seizureTable').DataTable().ajax.reload();
                   
                },
                error: function(xhr, status, error) {
                    // Your code here to handle error response
                }
            });
    }
   
</script>