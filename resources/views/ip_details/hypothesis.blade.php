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
                              Hypothesis
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Hypothesis
                                </button>
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.member_navbar')
                            <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('member.get.information.report.assignment.intel.plan.hypothesis')) active btn btn-success @endif"  href="{{route('member.get.information.report.assignment.intel.plan.hypothesis',['id'=>@$id])}}"> Hypothesis</a>
                                </li>

                                
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('member.get.information.report.assignment.intel.plan')) active btn btn-success @endif"  href="{{route('member.get.information.report.assignment.intel.plan',['id'=>@$id])}}">Task Details</a>
                                </li>

                                
                            </ul>
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Hypothesis</th>
                                        <th>Description</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$plan->isNotEmpty())
                                    @foreach(@$plan as $att)
                                    <tr>
                                        <td>{{ $att->name}}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>
                                                        
                                                            
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-hypo_sl_number="{{$att->hypo_sl_number}}"
                                                                data-id="{{$att->id}}"
                                                                data-name="{{$att->name}}"
                                                                data-description="{{$att->description}}"
                                                                data-toggle="modal"
                                                                >
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            
                                                            
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('member.get.information.report.assignment.intel.plan.hypothesis.delete.data',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
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
          <h5 class="modal-title" id="exampleModalLabel">Add Hypothesis</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('member.get.information.report.assignment.intel.plan.hypothesis.insert.data')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ip_id" value="{{@$id}}">

                <div class="form-group">
                  <label for="exampleInputEmail1">Hypothesis</label>
                  <input type="text" class="form-control" name="name" readonly value="Hypothesis {{@$hypo_number}}">
                 </div>


                {{-- <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Name">
                 </div> --}}


                 <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="description" aria-describedby="emailHelp"></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Idiary</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('member.get.information.report.assignment.intel.plan.hypothesis.update.data')}}">@csrf
                                
                             <div class="form-group">
                                  <label for="exampleInputEmail1">Hypothesis</label>
                                  <input type="text" class="form-control" id="hypo_sl_number" name="name" value="{{@$hypo_sl_number}}" readonly>
                              </div>

                               {{-- <div class="form-group">
                              <label for="exampleInputEmail1">Name</label>
                              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Name">
                             </div> --}}


                             <div class="form-group">
                              <label for="exampleInputEmail1">Description</label>
                              <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp"></textarea>
                             </div>

                             
                                 
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
            $('#name').val($(this).data('name'));
            $('#description').val($(this).data('description'));
            $('#id').val($(this).data('id'));
            $('#hypo_sl_number').val($(this).data('hypo_sl_number'));
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


@endsection