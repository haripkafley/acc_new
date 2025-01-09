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
                              SI Plan
                            </div>
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                
                               
                            </div>
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                             @include('tacktical.head.navbar')

                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Collected From</th>
                                        <th>Type Of Source</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Collection Officer</th>
                                        <th>Status</th>
                                               
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$sir->isNotEmpty())
                                    @foreach(@$sir as $att)
                                    <tr>
                                        <td>{{ @$att->task}}</td>
                                        <td>{{ @$att->collected_from }}</td>
                                        <td>{{ @$att->source_name->name }}</td>
                                        <td>{{ @$att->start_date }}</td>
                                        <td>{{ @$att->end_date }}</td>
                                        <td>
                                            @php
                                                $explode = explode(',',$att->officer_assign_id);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        <td>{{ $att->status_details->name }}</td>
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
            $('#task').val($(this).data('task'));
            $('#start_date').val($(this).data('start_date'));
            $('#end_date').val($(this).data('end_date'));
            $('#collected_from').val($(this).data('collected_from'));
            $('#source').val($(this).data('source')).change();
            let string = $(this).data('officer_assign_id');
            if (/,/.test(string)) {
                 let arr = string.split(',');
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }else{
                let arr = [string];
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }
           
            $('#id').val($(this).data('id'));
            $('#status').val($(this).data('status')).change();
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