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
                                    Disposal Details
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    <a href="{{route('manage.seized.document.get.official.disposal.documentation.page',@$id)}}" class="btn btn-primary" style="float:right;">Back</a>
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" action="{{ route('manage.seized.document.get.official.disposal.add.insert.details') }}">@csrf
                                
                                <input type="hidden" name="id" value="{{@$id}}">
                                <input type="hidden" name="case_id" value="{{@$data->case_id}}">
                                

                    

                        <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Particular</th>
                                        <th>File / Document No.</th>
                                        <th>No of Pages</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$receipt->isNotEmpty())
                                    @foreach(@$receipt as $att)
                                    <tr>
                                        
                                        
                                        <td>@if(@$att->particular=="D") Travel Document @else File @endif</td>
                                        <td>{{ $att->document_no }}</td>
                                        <td>{{ $att->no_pages }}</td>
                                        
                                        <td>
                                                <div class="form-group">
                                                <input type="checkbox"  name="files[]" value="{{@$att->id}}" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>




                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Disposal Date</label>
                                    <input type="date" name="disposal_date"  class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Disposal Date</label>
                                    <input type="time" name="disposal_time"  class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Method</label>
                                    <input type="text" name="method"  class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Disposed By</label>
                                    <input type="text" name="disposed_by"  class="form-control" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Place Of Disposal</label>
                                    <input type="text" name="place_of_disposal"  class="form-control" >
                                </div>

                                 

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Remarks</label>
                                    <textarea class="form-control" name="remarks"></textarea>
                                </div>
                                

                                

                                

                                

                               

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>





          


        </div>
    </section>


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>






@endsection
