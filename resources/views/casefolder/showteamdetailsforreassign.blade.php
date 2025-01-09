<section class="content">
<div class= "row">
        <div class  = "col-md-10">
                    <div class  = "form-group">
                         <label style="font-family:Product Sans">Existing Team Members</label>
                                    <table id="addmoretable" class="table table-bordered table-hover">
                                            <thead>
                                                    <tr>
                                                       
                                                        <th>Team Member</th>
                                                        <th>Role</th>
                                                       
                                                    </tr>
                                            </thead>
                                                
                                            <tbody>
                                            @foreach ($teamdetails as $users)
                                                    <tr >
                                                        <td>   <?php echo $key=DB::table('users')->where('email',$users->assigned_to)->value('name'); ?> </td>
                                                        <td>    {{ $users->role }}             </td>
                                                        <!-- <td><button type="button" name="rem" id="rem" onclick="removeuser('{{ $users->mapping_id }}')">Remove</button></td> -->
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                    </table>
                                       
                    </div>
        </div>
</div>

<div class  = "row">
        <div class  = "col-md-10">
                <div class = "form-group">
                        <label style="font-family:Product Sans">Add New Team Members&nbsp;<font color='red'>*</font></label>
                                <table id="addtable" class="table table-bordered table-hover">
                                        <thead>
                                                <tr>
                                                        <th>Team Member</th>
                                                        <th>Role</th>
                                                        <th></th>
                                                </tr>
                                        </thead>
                                                
                                        <tbody>
                                                <tr >
                                                        <td>
                                                        <select class  = "form-control" name="teammemberreassign[]" id="teammemberreassign[]" >
                                                                <option>Select Team Members</option>
                                                                    @foreach ($userdtls as $userusers)
                                                                <option value   = "{{ $userusers->email }}">{{ $userusers->name }}</option>                                                                       </option>
                                                                    @endforeach    
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class  = "form-control" name="teamrolesreassign[]" id="teamrolesreassign[]" >
                                                                <option>Select Role</option>
                                                                <option value   = "Team Member">Team Member</option>
                                                                <option value   = "Team Leader">Team Leader</option>
                                                                <option value   = "Legal Representive">Legal Representive</option> 
                                                            </select>
                                                        </td>
                                                        <td>   
                                                                <button type="button"  class="btn btn-warning" onclick="addmorenew()" name="add" data-toggle="tooltip" data-placement="bottom" title="Add More"><i class="fa fa-plus"></i></button>
                                                         <button type="button"  class="btn btn-warning" onclick="removenew()" name="add" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="fa fa-minus"></i></button>
</td>
                                                </tr>
                                        </tbody>
                                </table>
                                       
                </div>
        </div>
</div>


</section>

<script>
function addmorenew()
{
   
    var $tableBody = $('#addtable').find("tbody"),
    $trLast = $tableBody.find("tr:last"),
    $trNew = $trLast.clone();
    $trLast.after($trNew);

}   
function removenew()
{
    
    var $tableBody = $('#addtable').find("tbody"),
    $trLast = $tableBody.find("tr:last"),
    $trNew = $trLast.remove();
    
}
</script>