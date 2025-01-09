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
                             Diary Form
                            </div>
                            
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">

                            {{-- @include('tacktical.indi.navbar') --}}

                            <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.diary.page.head.details')) active btn btn-info @endif"  href="{{route('tacktical.diary.page.head.details',@$id)}}">Diary Head</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.diary.page.head.details.individuals.details')) active btn btn-info @endif"  href="{{route('tacktical.diary.page.head.details.individuals.details',@$id)}}">Diary Official</a>
                                    </li>
                                </ul>
                            
                            <table id  = "maintableDz" class="table" >
                                <thead>
                                    <tr>
                                        <th>Ir/Ti No</th>
                                        <th>Activity</th>
                                        <th>Event</th>
                                        <th>Date Of Event</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Created By</th>
                                        <th>Remarks</th>
                                        <th>Type</th>
                                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        @php
                                         $user_details = DB::table('users')->where('id',@$att->created_by)->first();
                                        @endphp
                                        @if(@$att->type_format=="diary")
                                        <td>@if(@$att->type_of_file=="information") {{@$att->ir_details->ir_no}} @else {{@$att->ti_details->si_ig_no}} @endif</td>
                                        <td>{{ $att->activity}}</td>
                                        <td>{{ $att->event }}</td>
                                        <td>{{ $att->date_of_event   }}</td>
                                        <td>{{ $att->start_time }}</td>
                                        <td>{{ $att->end_time }}</td>

                                        <td>{{ @$user_details->name }} (EID :{{ @$user_details->eid }})</td>
                                        <td>{{ $att->remarks }}</td>
                                        <td>Diary</td>
                                        @elseif(@$att->type_format=="intel_plan")
                                        <td>{{@$att->ir_details->ir_no}}</td>
                                        <td>{{ $att->task}}</td>
                                        <td>--</td>
                                        <td>{{ $att->start_date}}</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>{{ @$user_details->name }} (EID :{{ @$user_details->eid }})</td>
                                        <td>--</td>
                                        <td>Intel Plan</td>
                                        @else
                                        <td>{{@$att->ir_details->ir_no}}</td>
                                        <td>{{ $att->activity}}</td>
                                        <td>--</td>
                                        <td>{{ $att->start_date}}</td>
                                        <td>--</td>
                                        <td>--</td>
                                        <td>{{ @$user_details->name }} (EID :{{ @$user_details->eid }})</td>
                                        <td>--</td>
                                        <td>Idiary</td>

                                        @endif
                                        
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



</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#activity').val($(this).data('activity'));
            $('#event').val($(this).data('event'));
            $('#start_time').val($(this).data('start_time'));
            $('#end_time').val($(this).data('end_time'));
            $('#date_of_event').val($(this).data('date_of_event'));
            $('#remarks').val($(this).data('remarks'));
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
    <script type="text/javascript">
        $('.ir_ti_id').on('change',function(e){
            var type = $('.ir_ti_id option:selected').data('type');
            $('#type_of_file').val(type);
        })

        $(document).ready(function() {
            $('#maintableDz').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>

@endsection