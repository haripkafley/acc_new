@foreach ($casedetails as $cases)
    <div class="row" > 
        <div class="col-md-4">
            <div class="form-group">
                <label style="font-family:Product Sans">Case Id: </label>&nbsp; {{ $cases->case_no }} 
                    <br>
                    <label style="font-family:Product Sans">Case No: </label> &nbsp; {{ $cases->case_id }}
                    <br>
                    <label style="font-family:Product Sans">Case Title: </label> &nbsp;  {{ $cases->case_title }}
                <br>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label style="font-family:Product Sans">Intake Type: </label> &nbsp; {{ $cases->source_type }}
                <br>
                <label style="font-family:Product Sans">Sub Type: </label> &nbsp; {{ $cases->sector_type }}
                <br>
                <label style="font-family:Product Sans">Date Assigned: </label> &nbsp; {{ \Carbon\Carbon::parse($cases->creation_date)->format('d/m/Y')}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label style="font-family:Product Sans">Sector: </label> &nbsp; {{ $cases->sector }}
                <br>
                <label style="font-family:Product Sans">Area: </label> &nbsp; {{ $cases->area }}
                <br>
                <label style="font-family:Product Sans">Institution Type: </label> &nbsp; {{ $cases->institution_type }} 
            </div>
        </div>
    </div>
    <hr>
    <div class="row" > 
        <div class="col-md-12">
            <div class="form-group">
                <label style="font-family:Product Sans">Allegation Summary: </label> &nbsp;<br>
                {{ $cases->allegation_details }}
            </div>
        </div>
    </div>
    <div class="row" > 
        <div class="col-md-12">
            <div class="form-group">
                <label style="font-family:Product Sans">Allegation Documents: </label> &nbsp;<br> 
                <table class="table t2" id="allegationtable">
                    <thead>
                        <th>Name</th>
                        <th>Document</th>
                    </thead>
                    <tbody>
                        @foreach ($allegationdocuments as $docs)
                            <tr>   
                                <td>{{ $docs->doc_name }}</td>
                                <td>
                                    <a target="_blank" href="{{ asset('Case Folder/' .$docs->case_no_id.'/' .$docs->file_name) }}" ><img src="{{ asset('acc_images/pdf.jpg') }}" width="30px" height="30px" /></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
            <div class = "col-md-6">
                <div class = "form-group">
                    <label style="font-family:Product Sans">Probable Offences</label>
                        <ol>
                            @foreach ($offencedetails as $off)
                                <li> 
                                    {{ $off->offence_type }}<br>
                                </li>
                            @endforeach
                        </ol>                     
                </div>
            </div>
            @if(Auth::user()->role == "Chief")
            <div class = "col-md-6">
                <div class = "form-group">
                    <label style="font-family:Product Sans">Remarks</label><br>
                            {{ $cases->instructions }}                
                </div>
            </div>
            @endif
    </div>
    <hr>
    <div class="row">
            <div class = "col-md-12">
                <div class = "form-group">
                    <label style="font-family:Product Sans">Alledged Party</label>
                        <table id="addmoretable" class="table t2">
                            <thead>
                                <tr>
                                    <th>ID Photo</th>
                                    <th>Name</th>
                                    <th>CID</th>
                                    <th>DOB</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="entity">
                                @foreach ($accuseddetails as $entityshow)
                                    <tr>   
                                        <td><img src="{{ asset('acc_images/person.png') }}" width="30px" height="30px" /></img></td>
                                        <td>{{ $entityshow->name }}</td>
                                        <td>{{ $entityshow->identification_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($entityshow->dateofbirth)->format('d/m/Y')}}</td>
                                        <td><i class="fa fa-eye" onclick="viewentitydetailscoi('{{ $entityshow->id }}')"  id="viewdetails" name="viewdetails" data-toggle="tooltip" data-placement="bottom" title="View Details"></i></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> 
                        
                </div>
            </div>
    </div>
@endforeach
<!-- show entity details modal -->
<div class="modal fade" id="show_entity_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" >
        <div class="modal-content">
            <div class="modal-header alert-info" style="background-color: #B4B5BD">
                <h5 class="modal-title" id="exampleModalLabel">Entity Details</h5>
                <button type="button" class="close" onclick="closeentitymodal()" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="card-content">
                        <div id="entitydetailsshow"></div>
                    </div>
            </div>
            <div class="modal-footer">
                
                                        
            </div>
        </div>
    </div>
</div>
<!-- end entity details modal -->
<script>
    function viewentitydetailscoi(id){
    
        $('#entityidcoi').val(id);
        $('#show_entity_details').modal('show');
    

   var url = '{{ route("searchentitydetails", ":id") }}';
            url = url.replace(':id', id);
               
            $.ajax({
                
                type:"GET",
                url: url,
                data: {search: $('#entityidcoi').val()},
                success: function(result) {
                    
                    $("#entitydetailsshow").html(result);
                    $("#entitydetailsshow").show();
                    
                }
            });

}
function closeentitymodal()
        {
            $('#show_entity_details').modal('hide');
        }
</script>
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



</style>