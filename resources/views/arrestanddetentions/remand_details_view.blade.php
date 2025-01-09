  <h5><label style="font-family:Product Sans">Previous Remands</label></h5>
  
  @if($remands->count())
  <div class="row">
                      
          <div class="col-sm-12">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Remanded Until</th>
                <th>Court</th>
                <th>Documents</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($remands as $data)
            @if($data->remand_status == "Under Custody")
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->remanded_until)->format('d/m/Y')}}</td>
                <td>{{ $data->court }}</td>
                <td></td>
            </tr>
            @endif
     @endforeach
     @else
    <tr>
        <td colspan="8"> No record found </td>
    </tr>


@endif
        </tbody>
    </table>
    
</div></div>
     
<hr>
    
   
    

   
                
                