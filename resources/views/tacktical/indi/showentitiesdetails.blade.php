@foreach ($entitydetailsshow as $showentitydtls)
<link rel ="stylesheet" href="https://fonts.googleapis.com/css2?family=Product+Sans&display=swap" >    
 @php
          $id = Auth::user()->id;
          $adminData = App\Models\User::find($id);
      @endphp
<table class="table t2" style="font:Product Sans">
        <thead >
            <tr>
                <th>BioData</th>
                <th>Photo</th>
                <th>Background</th>
            </tr>
        </thead>
        <tbody>
            <tr>   
                <td>
                    <label class="label">Name:</label> {{ $showentitydtls->name }}<br>
                    <label class="label">CID:</label> {{ $showentitydtls->identification_no }}<br>
                    <label class="label">Date of Birth:</label>{{ \Carbon\Carbon::parse($showentitydtls->dateofbirth)->format('d/m/Y')}} <br>
                    <label class="label">Gender:</label> {{ $showentitydtls->gender }}<br>
                    @if($showentitydtls->type == "Bhutanese")
                    <label class="label">Dzongkhag:</label> {{ $showentitydtls->dzongkhag }}<br>
                    <label class="label">Village:</label> {{ $showentitydtls->village }}<br>
                    <label class="label">Gewog:</label> {{ $showentitydtls->gewog }}<br>
                    @endif
                    @if($showentitydtls->type == "Non Bhutanese")
                    <label class="label">Permanent Address:</label> {{ $showentitydtls->permanentaddress }}<br>
                    @endif
                    @if($showentitydtls->contactno == "")
                    <label class="label">Contact no:</label> Not Available
                    @else
                    <label class="label">Contact No:</label> {{ $showentitydtls->contactno }}
                    @endif <br>
                    @if($showentitydtls->email == "")
                    <label class="label">Email:</label> No email available
                    @else
                    <label class="label">Email:</label> {{ $showentitydtls->email }}
                    @endif <br>
                    <label class="label">Nationality:</label> {{ $showentitydtls->type }}<br>
                    <label class="label">Address:</label> 
                    @if($showentitydtls->address == "")
                    Not Available
                    @else
                    {{ $showentitydtls->address }}
                    @endif
                    
                </td>
                <td>
                     @if($showentitydtls->photo_name == "")
                        <img src="{{ asset('acc_images/person.png') }}" style="height:55px;width:55px;" alt="User Image">
                        @else

                        <img src="{{ asset('Entity/' .$showentitydtls->id.'/' .$showentitydtls->photo_name) }}"  class="rounded-circle header-profile-user" alt="User Image" style="height:35px;width:35px;"></td>
                        @endif
                </td>
                <td>
                    @foreach($othercasesdtls as $dtls)
                    <?php echo $key=DB::table('tbl_registered_cases')->where('id',$dtls->case_no_id)->value('case_no'); ?>
                    <br>
                    @endforeach
                    
                </td>
            </tbody>
    </table>
     <style>
    .t2{
    outline: 1px solid #ccc;
    font-family:Product Sans;
    
}

.t2 tbody th
{
    vertical-align: middle;
}
.t2 tbody th,
.t2 tbody td {
  padding: 0.35rem; /* Adjust the padding as needed */
  font-size: 0.9rem; /* Adjust the font size as needed */
  vertical-align: middle;
  /* text-align: center; */
}
.label {
        display: inline-block;
        width: 120px;
    }
</style>
@endforeach
    