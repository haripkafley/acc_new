@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> 
                        {{-- Embassy List --}}
                        <div class="row" style="font-family:Product Sans">
                            <div class="col-sm">
                              Source Form
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Source
                                </button>
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.indi.navbar')
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Source Type</th>
                                        <th>Source</th>
                                        <th>Agency</th>
                                        <th>Registration Date Of Source</th>
                                        <th>Information Received For</th>
                                        <th>TI No</th>
                                        <th>Status</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ @$att->source_type}}</td>
                                        <td>{{ @$att->source_name->name}}</td>
                                        <td>{{ @$att->source_name->agency_name->agencyName }}</td>
                                        <td>{{ @$att->date }}</td>
                                        <td>{{ @$att->tacktical_details->request_type_details->name }}</td>
                                        <td>{{ @$att->tacktical_details->si_ig_no }}</td>
                                        <td>{{@$att->status}}</td>
                                        
                                        
                                        
                                        <td>
                                                        
                                                            
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{@$att->id}}"
                                                                data-source_code="{{@$att->source_code}}"
                                                                data-source_type="{{@$att->source_type}}"
                                                                data-agency="{{@$att->source_name->agency_name->agencyName}}"
                                                                data-toggle="modal"
                                                                >
                                                                Edit / View More
                                                            </a>
                                                            
                                                            
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('tacktical.inteligence.autorization.individual.source.information.page.delete.data',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                                            </a>
                                                            
                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Source Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('tacktical.inteligence.autorization.individual.source.information.page.insert.data')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ti_id" value="{{@$id}}">
                
                {{-- <div class="form-group">
                  <label for="exampleInputEmail1">Source</label>
                  <select class="form-control source_dropdown" name="source_code" required>
                      <option value="">Select</option>
                      @foreach(@$source as $val)
                      <option value="{{@$val->id}}" data-agency="{{@$val->agency_name->agencyName}}">{{@$val->name}}</option>
                      @endforeach
                  </select>
                 </div> --}}


                 <div class="form-group">
                                        <label for="exampleInputEmail1">Source Type</label>
                                        <select class="form-control source_type" name="source_type">
                                            <option value="">Select</option>
                                            <option value="OSINT">OSINT</option>
                                            <option value="SOCINT">SOCINT</option>
                                            <option value="Humint">Humint</option>
                                            <option value="DS">Data Source</option>
                                        </select>
                                        
                     </div>
                 



               
                <div class="form-group">
                    <label>Source</label>
                    <select class="form-control" required name="source_code" id="source">
                        <option value="">Select</option>
                    </select>
                </div>


                 {{-- <div class="form-group">
                  <label for="exampleInputEmail1">Agency</label>
                  <input type="text" name="agency" class="agency_name form-control" readonly>
                 </div> --}}

                 <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>


<!--Edit Modal -->
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Source Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('tacktical.inteligence.autorization.individual.source.information.page.update.data')}}">@csrf
                                
                             {{-- <div class="form-group">
                              <label for="exampleInputEmail1">Source</label>
                              <select class="form-control source_dropdown" name="source_code" id="source_code" required>
                                  <option value="">Select</option>
                                  @foreach(@$source as $val)
                                  <option value="{{@$val->id}}" data-agency="{{@$val->agency_name->agencyName}}">{{@$val->name}}</option>
                                  @endforeach
                              </select>
                             </div> --}}

                             <div class="form-group">
                                        <label for="exampleInputEmail1">Source Type</label>
                                        <select class="form-control source_type" id="source_type_edit" name="source_type">
                                            <option value="">Select</option>
                                            <option value="OSINT">OSINT</option>
                                            <option value="SOCINT">SOCINT</option>
                                            <option value="Humint">Humint</option>
                                            <option value="DS">Data Source</option>
                                        </select>
                                        
                            </div>
                 



               
                                <div class="form-group">
                                      <label for="exampleInputEmail1">Source</label>
                                      <select class="form-control" name="source_code" id="source_edit" required>
                                          <option value="">Select</option>
                                          @foreach(@$source as $val)
                                          <option value="{{@$val->id}}">{{@$val->name}}</option>
                                          @endforeach
                                      </select>
                                </div>


                             {{-- <div class="form-group">
                              <label for="exampleInputEmail1">Agency</label>
                              <input type="text" name="agency" id="agency" class="agency_name form-control" readonly>
                             </div> --}}

                             

                            

                            
                                 
                             <input type="hidden" name="id" id="id">
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>

    </div>
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('.edit_button').on('click',function(){
           $('#source_edit').val($(this).data('source_code')).change();
            $('#agency').val($(this).data('agency'));
            $('#id').val($(this).data('id'));
            $('#source_type_edit').val($(this).data('source_type'));
            $('#exampleModaEdit').modal('show');
        })
</script>

     <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>

    <script type="text/javascript">
        $('.source_dropdown').on('change',function(e){
            var agency = $(this).find(':selected').data('agency');
            $('.agency_name').val(agency);
        });
    </script>

        <script type="text/javascript">
    $('.source_type').on('change',function(e){
        var source = $(this).val();
        var url = '{{ route('get.source.from.source.type', ':id') }}';
        url = url.replace(':id', source);
        $('#source').empty();
            
        $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('#source').append('<option value="' + value.id + '">' + value.name +
                        '</option>');

                });
                
            });
    });
</script>


        <script type="text/javascript">
    $('#source_type_edit').on('change',function(e){
        var source = $(this).val();
        var url = '{{ route('get.source.from.source.type', ':id') }}';
        url = url.replace(':id', source);
        $('#source_edit').empty();
            
        $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('#source_edit').append('<option value="' + value.id + '">' + value.name +
                        '</option>');

                });
                
            });
    });
</script>


@endsection