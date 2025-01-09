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
                                        <th>Case/Accused</th>
                                        <th>CID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Attachment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$lists)
                                        {{-- {{$data}} --}}
                                        @foreach (@$lists as $att)
                                            <tr>
                                                <td>{{ $att->case_or_accused}}</td>
                                                <td>{{ $att->cid }}</td>
                                                <td>{{ $att->accused_name }}</td>
                                                <td>{{ $att->type }}</td>
                                                <td>{{ $att->date }}</td>
                                                <td><a class="btn btn-xs btn-info"
                                                               href="{{URL::to('attachment/case_followup')}}/{{$att->attachment}}" target="_blank">
                                                                <i class="fa fa-eye"></i>
                                                                Attachment
                                                            </a></td>
                                                <td>
                                                    @if(@$close_details->date_of_closing=="")
                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('get.official.cases.followup.case-return-dropped-withdrawn.delete.data', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        Delete
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

            
            <div class="col-md-12" id="add_form">
                <div class="card-body">
                    <form method="post" action="{{route('get.official.cases.followup.case-return-dropped-withdrawn.insert.data')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="assign_official_id" value="{{@$id}}">
            <input type="hidden" name="case_id" value="{{@$case_id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Select Type<span style="font-weight: bold; color: red;">*</span></label>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="case_or_accused" id="inlineCheckbox1"  value="Case" checked>
                              <label class="form-check-label" for="inlineCheckbox1">Case</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" id="inlineCheckbox2" name="case_or_accused" value="Accused">
                              <label class="form-check-label" for="inlineCheckbox2">Accused</label>
                            </div>
                    </div>
                </div>

                <div class="accused_div" style="width:100%;display:none">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>User</label>
                        <select class="form-control" name="accused_name" id="accused_name">
                            <option value="">Select</option>
                            @foreach(@$people_accused as $value)
                            <option value="{{@$value->name}}" data-cid="{{@$value->identification_no}}" data-id="{{@$value->id}}">{{@$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" name="accused_id" id="accused_id">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="cid" id="cid" readonly  class="form-control">
                    </div>
                </div>

            </div>


            <div class="col-sm-12">
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type" required>
                            <option value="">Select</option>
                            <option value="Returned">Returned</option>
                            <option value="Dropped">Dropped</option>
                            <option value="Withdrawn">Withdrawn</option>
                        </select>
                    </div>
            </div>

            <div class="col-sm-12">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date"  class="form-control">
                    </div>
                </div>

            <div class="col-sm-12">
                    <div class="form-group">
                        <label>Reason</label>
                        <textarea type="text" name="reason"  class="form-control"></textarea>
                    </div>
            </div>

            <div class="col-sm-12">
                    <div class="form-group">
                        <label>Attachment</label>
                        <input type="file" name="file"  class="form-control">
                    </div>
            </div>


            <div class="col-sm-12">
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </div>
    </form>
</div>
    </div>







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

<script type="text/javascript">
    $('input[type=radio][name=case_or_accused]').change(function() {
       if (this.value == 'Case') {
        $('.accused_div').hide();
       }else{
        $('.accused_div').show();
       }
   });
</script>

<script type="text/javascript">
    $('#accused_name').on('change',function(){
        console.log($(this).find(':selected').attr('data-cid'));
        $('#accused_id').val($(this).find(':selected').attr('data-id'));
        $('#cid').val($(this).find(':selected').attr('data-cid'));
    });
</script>
@endsection