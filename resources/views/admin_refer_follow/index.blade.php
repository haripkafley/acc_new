@extends('layouts.admin')

@section('content')
    <style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
        .tox .tox-notification--warn, .tox .tox-notification--warning {
            display: none;
        }
            
        .card{
            padding: 25px;
        }

            </style>
<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        



        
            <div class="row">
              
                <div class="col-sm-6">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                  </div>
            </div>
            <div class="col-md-12"> @include('admin_refer_follow.common')</div>
                <small><a href="#add_button" class="btn btn-primary">+ Add Data</a></small>
                <div class="col-sm-12">

                           <div class="card-body">
                            
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>Due Date</th>
                                        <th>Date of Follow Up</th>
                                        <th>Follow Up Letter</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data)
                                        {{-- {{$data}} --}}
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->due_date }}</td>
                                                <td>{{ $att->date_of_follow }}</td>
                                                <td><a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/case_followup')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                View
                                                            </a></td>
                                                <td>{{ $att->remarks }}</td>
                                                <td>
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('case.administrative.referrals.followup.list.delete.review', ['id' => @$att->id]) }}"
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



    </div>

            <div class="col-md-12" id="add_button">
            <form method="post" action="{{route('case.administrative.referrals.followup.insert.review')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="assign_official_id" value="{{@$id}}">
            <input type="hidden" name="case_id" value="{{@$case_id}}">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Due Date<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="date" name="due_date" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date of Follow Up<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="date" name="date_of_follow" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Follow Up Letter<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="file" name="attachment" >
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Remarks<span style="font-weight: bold; color: red;">*</span></label>
                           <textarea class="form-control" name="remarks" required></textarea>
                    </div>
                </div>

                

                

                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info mt-4">Save</button></div>
            </div>
        </form>
    </div>

    {{-- table-showing --}}






</div>
</div>


            

             

                
         
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   



    <script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});


</script>


@endsection