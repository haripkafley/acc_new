@extends('layouts.admin')

@section('content')

    <br>
    <section class="content">
        <div id="casedetailscard" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header" style="font-family:Product Sans">
                            {{-- Dzonkhag List --}}
                            <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                   Edit Systemic Recommendation
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" action="{{ route('systemic.recommendations.registration.add.view.update.data') }}" enctype="multipart/form-data">@csrf
                                
                                <input type="hidden" name="id" value="{{@$id}}">
                                                                

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Agency Type</label>
                                    <select class="form-control" name="agency_type" required>
                                        <option value="">Select</option>
                                        <option value="Government Agency" @if(@$data->agency_type=="Government Agency") selected @endif>Government Agency</option>
                                        <option value="Constitutional Bodies" @if(@$data->agency_type=="Constitutional Bodies") selected @endif>Constitutional Bodies</option>
                                        <option value="Autonomous Bodies" @if(@$data->agency_type=="Autonomous Bodies") selected @endif>Autonomous Bodies</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Agency Name</label>
                                    <input type="text" name="agency_name" value="{{@$data->agency_name}}" class="form-control" required >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Reference Letter</label>
                                    <input type="file" name="letter" class="form-control">
                                </div>

                                <div class="form-group">
                                    <a class="btn btn-xs btn-info"
                                    href="{{URL::to('attachment/case_followup')}}/{{$data->letter}}" target="_blank">
                                     <i class="fa fa-eye"></i>View </a>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Letter Date</label>
                                    <input type="date" name="letter_date" class="form-control" value="{{@$data->letter_date}}" required  >
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>

                        <div class="card-body">
                            <div class="col-sm">
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2" style="float: right;">
                                    + Add Recommendation
                                </button>
                            </div>
                            <table id="maintableEvalDec" class="table">
                                <thead>
                                    <tr>
                                        <th>Systemic Recommendation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$recommendations)
                                        {{-- {{$recommendations}} --}}
                                        @foreach (@$recommendations as $att)
                                            <tr>
                                                <td>{{ $att->recommendation }}</td>
                                                
                                                <td>
                                                    <a class="btn btn-xs btn-info edit_button"
                                                        href="javascript:void(0)" data-recommendation="{{$att->recommendation}}" data-id="{{$att->id}}"><i class="fa fa-edit"></i> + <i class="fa fa-eye"></i>
                                                       
                                                    </a>


                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('systemic.recommendations.registration.add.view.delete.recommendation', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div> 

                        <div class="col-sm">
                                 <a href="{{route('systemic.recommendations.registration.view',@$data->case_id)}}" class="btn btn-success mt-5">
                                    Complete Registration
                                </a>
                            </div>

                    </div>
                </div>
            </div>




            <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">New Recommendation</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('systemic.recommendations.registration.add.view.insert.recommendation')}}">@csrf
                        <input type="hidden" name="register_id" value="{{@$id}}">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Recommendation</label>
                          <textarea class="form-control" required name="recommendation"></textarea>
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


            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Recommendation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('systemic.recommendations.registration.add.view.update.recommendation')}}">@csrf
                                <input type="hidden" name="id" id="id">
                                

                                <div class="form-group">
                                  <label for="exampleInputEmail1">Recommendation</label>
                                  <textarea class="form-control" required name="recommendation" id="recommendation"></textarea>
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
            $('#recommendation').val($(this).data('recommendation'));
            $('#id').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
</script>





@endsection
