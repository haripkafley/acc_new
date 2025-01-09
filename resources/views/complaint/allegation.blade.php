@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" href="{{route('complaint.registration.edit.view',['id'=>@$id])}}">Complaint Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active btn btn-info"  href="{{route('allegation.offence.management',['id'=>@$id])}}">Allegations/Offences</a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link"  href="{{route('attachment.view.complaint',['id'=>@$id])}}">Attachment Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('person.involved.complaint',['id'=>@$id])}}" >Person Involved</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.financial-implication-details.page',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.social.implication',['id'=>@$id])}}">Social Implication</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('link.case.complaint',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>



        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Allegation List </div>
                    

                        <div class = "card-body">
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Allegation
                                </button>
                               
                            </div>
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Allegation</th>
                                        <th>Allegation Details</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$allegation->isNotEmpty())
                                    @foreach(@$allegation as $att)
                                    <tr>
                                        <td>{{ $att->allegation_name }}</td>
                                        <td>{{ $att->allegation_description }}</td>
                                        <td>
                                                        <a class="btn btn-xs btn-info edit_button"
                                                            data-id="{{$att->id}}"
                                                            data-allegation_name="{{$att->allegation_name}}"
                                                            data-allegation_description="{{$att->allegation_description}}"   
                                                        >
                                                                <i class="fa fa-edit"></i>
                                                                
                                                            </a>
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('allegation.offence.management.delete.allegation',['id'=>@$att->id])}}" onclick="return confirm('Are you sure , you want to delete this attachment ? ')"><i class="fa fa-trash"></i>
                                                                
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



        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Offence List </div>
                    

                        <div class = "card-body">
                            
                            
                            <div class="col-sm-12">
                    
                        <form method="post" action="{{route('complaint.evaluate.list.view.details.add.offence.post')}}">
                            @csrf
                            <input type="hidden" name="complaint_id" value="{{@$id}}">
                            <div class="row">
                            <div class="col-md-9 mb-2">
                            <div class="form-group">
                                <label>Offence</label>
                                <select class="form-control" name="offence">
                                    <option value="">Select</option>
                                    @foreach(@$offence_list as $val)
                                    <option value="{{@$val->offence_id}}">{{@$val->offence_type}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mt-4"><button class="btn btn-primary">Save</button></div>
                        </div>
                        </form>
                    
                    <table  class="table">
                        <thead>
                            <th>S.no</th>
                            <th>Offence</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @php $count = 1 @endphp
                            @foreach(@$evalution_offence_list as $value)
                            <tr>
                                <th>{{@$count++}}</th>
                                <td>{{@$value->offence_name->offence_type}}</td> 
                                <td><a href="{{route('complaint.evaluate.list.view.details.delete.offence',@$value->id)}}" class="btn btn-xs btn-danger" onclick="return confirm('Are sure want to delete this?')"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    
                </div>
                        </div>
                </div>
            </div>
        </div>




<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Allegation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('allegation.offence.management.insert.allegation')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="complaint_id" value="{{@$id}}">

                <div class="form-group">
                  <label for="exampleInputEmail1">Allegation Name</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="allegation_name" aria-describedby="emailHelp" placeholder="Allegation Name" required>
                 </div>


                <div class="form-group">
                  <label for="exampleInputEmail1">Allegation Description</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1" name="allegation_description" aria-describedby="emailHelp" placeholder="Allegation Description" required></textarea>
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

  {{-- edit --}}
              <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Exhibit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('allegation.offence.management.update.allegation')}}">@csrf
                                
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Allegation Name</label>
                                  <input type="text" class="form-control" id="allegation_name" name="allegation_name" aria-describedby="emailHelp" placeholder="Allegation Name" required>
                                 </div>


                                <div class="form-group">
                                  <label for="exampleInputEmail1">Allegation Description</label>
                                  <textarea type="text" class="form-control" id="allegation_description" name="allegation_description" aria-describedby="emailHelp" placeholder="Allegation Description" required></textarea>
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
            $('#allegation_name').val($(this).data('allegation_name'));
            $('#allegation_description').val($(this).data('allegation_description'));
            $('#id').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
</script>

@endsection