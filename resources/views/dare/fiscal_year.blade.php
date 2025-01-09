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
                              Fiscal Year
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                             
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    Add
                                </button>
                                
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->year  }}</td>
                                        <td>{{ $att->start_date }}</td>
                                        <td>{{ $att->end_date }}</td>
                                        <td>
                                                        
                                                             
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button "
                                                                data-year='{{ @$att->year }}' data-start_date="{{$att->start_date}}" data-end_date="{{$att->end_date}}" data-id="{{$att->complaintmodeID}}"  data-toggle="modal"
                                                                >
                                                                Edit
                                                            </a>
                                                            

                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('manage.fiscal.year.delete',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
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
          <h5 class="modal-title" id="exampleModalLabel">Add Fiscal Year</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('manage.fiscal.year.insert')}}">@csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Year</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="year" aria-describedby="emailHelp" placeholder="Enter Year">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Start Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="start_date" aria-describedby="emailHelp" >
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">End Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="end_date" aria-describedby="emailHelp" >
                 </div>

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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Complaint Mode</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('manage.fiscal.year.update')}}">@csrf
                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Year</label>
                                  <input type="text" class="form-control" id="year" readonly name="year" aria-describedby="emailHelp" placeholder="Enter Year">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Start Date</label>
                                  <input type="date" class="form-control" id="start_date" name="start_date" aria-describedby="emailHelp" >
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">End Date</label>
                                  <input type="date" class="form-control" id="end_date" name="end_date" aria-describedby="emailHelp" >
                                 </div>
                        
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
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#modeName').val($(this).data('name'));
            $('#id').val($(this).data('id'));
            $('#start_date').val($(this).data('start_date'));
            $('#end_date').val($(this).data('end_date'));
            $('#year').val($(this).data('year'));
            $('#exampleModaEdit').modal('show');
        })
</script>


@endsection