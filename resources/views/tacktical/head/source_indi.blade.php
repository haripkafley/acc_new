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
                              Source Form Individual
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.head.navbar')
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>SIR NO</th>
                                        <th>Source Code</th>
                                        <th>SIR Received Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Details</th>
                                        <th>Officers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->sir_no}}</td>
                                        <td>{{ @$att->source_name->name }} (Type - {{@$att->source_type}} )</td>
                                        <td>{{ $att->received_date   }}</td>
                                        <td>{{ $att->start_time }}</td>
                                        <td>{{ $att->end_time }}</td>
                                        <td>{{ $att->details }}</td>
                                        <td>
                                            @php
                                                $explode = explode(',',$att->officers);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

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



    </div>
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#source_code').val($(this).data('source_code'));
            $('#agency').val($(this).data('agency')).change();;
            $('#information_recived_for').val($(this).data('information_recived_for'));
            $('#status').val($(this).data('status')).change();;
            $('#id').val($(this).data('id'));
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