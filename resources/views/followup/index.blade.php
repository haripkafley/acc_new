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

       @include('followup.common')



        
            <div class="row">
              
                <div class="col-sm-12">
                    <div class="card">
                    <p><b>Case Name:</b> {{@$case_details->case_no}}</p>

                    <p><b>Case Title:</b> {{@$case_details->case_title}}</p>

                  </div>
            </div>


                {{-- table-showing --}}
    <div class="col-sm-12">

                           <div class="card-body">
                            @if(@$close_details->date_of_closing=="")
                            <small><a href="#add_form" class="btn btn-primary">+ Add Data</a></small>
                            @endif
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>Name of Prosecutor</th>
                                        <th>EID</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$oag)
                                        {{-- {{$data}} --}}
                                        @foreach (@$oag as $att)
                                            <tr>
                                                <td>{{ $att->name }}</td>
                                                <td>{{ $att->eid }}</td>
                                                <td>{{ $att->date }}</td>
                                                <td>
                                                    @if(@$close_details->date_of_closing=="")
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('get.official.cases.followup.prosecutor.details.delete.data', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
                                                    </a>
                                                    @endif
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

            @if(@$close_details->date_of_closing=="")
            <div class="col-md-12 " id="add_form">
            <div class="card-body">    
            <form method="post" action="{{route('get.official.cases.followup.prosecutor.details.insert.data')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="assign_official_id" value="{{@$id}}">
            <input type="hidden" name="case_id" value="{{@$case_id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name of Prosecutor<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="text" name="name" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>EID<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="text" name="eid" required>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Date<span style="font-weight: bold; color: red;">*</span></label>
                            <input class="form-control"  type="date" name="date" required>
                    </div>
                </div>

                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            </div>
        </form>
    </div>
</div>
@endif






</div>
</div>


            

             

                
         
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   

    <script type="text/javascript">
        $('input[type=radio][name=evaluation]').on('change', function() {
          var evaluation =  $(this).val();
           if(evaluation=="Y")
           {
             $('.describe').show();
           }else{
            $('.describe').hide();
           } 
        });
    </script>

    <script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#user_id_value').val($(this).data('user'));
            $('#exampleModaEdit').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.restitution_button').on('click',function(){
            $('#user_id_restitution_value').val($(this).data('user'));
            $('#exampleModaRestitution').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.confiscation_button').on('click',function(){
            $('#user_id_confiscation_value').val($(this).data('user'));
            $('#exampleModaconfiscation').modal('show');
        })
</script>

    <script type="text/javascript">
    $('.other_button').on('click',function(){
            $('#user_id_other_value').val($(this).data('user'));
            $('#exampleModaother').modal('show');
        })
</script>


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