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
                                   New Systemic Recommendation
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data" action="{{ route('systemic.recommendations.registration.add.view.insert.data') }}">@csrf
                                
                                <input type="hidden" name="id" value="{{@$id}}">
                                                                

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Agency Type</label>
                                    <select class="form-control" name="agency_type" required>
                                        <option value="">Select</option>
                                        <option value="Government Agency">Government Agency</option>
                                        <option value="Constitutional Bodies">Constitutional Bodies</option>
                                        <option value="Autonomous Bodies">Autonomous Bodies</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Agency Name</label>
                                    <input type="text" name="agency_name" class="form-control" required >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Reference Letter</label>
                                    <input type="file" name="letter" class="form-control" required  >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Letter Date</label>
                                    <input type="date" name="letter_date" class="form-control" required  >
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
