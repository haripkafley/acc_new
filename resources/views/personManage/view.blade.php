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

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active btn btn-info" href="{{route('manage.person.view.details',['id'=>@$id])}}">Person Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link "  href="{{route('manage.person.view.details.complaint',['id'=>@$id])}}">Complaint Details</a>
        </li>
        
      </ul>



        
            <div class="row">
              


                <div class="col-sm-12">
                    <div class="card">
                    @if(isset($data->userPic)) 
                        <img src="{{URL::to('storage/app/public/person')}}/{{@$data->userPic}}" class="user-image" alt="" style="height:100px;width:100px;margin-left: auto;">
                    @endif  

                    <p><b>Name:</b> {{@$data->fname}} {{@$data->mname}} {{@$data->lname}}</p>

                    @if(@$data->cid!="")
                    <p><b>CID:</b> {{@$data->cid}}</p>
                    @else
                    <p><b>OtherIdentification Id:</b> {{@$data->otherIdentificationNo}}</p>
                    @endif

                    <p><b>Gender:</b> @if(@$data->gender!=""){{@$data->genderRelation->name}} @else -- @endif</p>

                    <p><b>Employee Id:</b> @if(@$data->employID!=""){{@$data->employID}} @else -- @endif </p>

                    <p><b>Nationality:</b> @if(@$data->nationality!=""){{@$data->nationality}} @else -- @endif</p>

                    <p><b>Religion:</b> @if(@$data->religion!=""){{@$data->religion}} @else -- @endif</p>


                    <p><b>Birth Place:</b> @if(@$data->birthPlace!=""){{@$data->birthPlace}} @else -- @endif</p>

                    <p><b>Date Of Birth:</b> @if(@$data->dob!=""){{@$data->dob}} @else -- @endif</p>

                    <p><b>Height:</b> @if(@$data->height!=""){{@$data->height}} @else -- @endif</p>

                    <p><b>Weight:</b> @if(@$data->weight!=""){{@$data->weight}} @else -- @endif</p>

                    <p><b>Blood Group:</b> @if(@$data->blood_group!=""){{@$data->blood_group}} @else -- @endif</p>

                    @if(@$data->cid!="")

                    <p><b>Dzongkhag:</b> @if(@$data->permAddDzongkhag!=""){{@$data->dzongkhagrelation->dzoName}} @else -- @endif</p>

                    <p><b>Gewog:</b> @if(@$data->permAddGewog!=""){{@$data->gewogrelation->gewogName}} @else -- @endif</p>

                    <p><b>Village:</b> @if(@$data->permAddVillage!=""){{@$data->villagerelation->villageName}} @else -- @endif</p>

                    <p><b>Thram No:</b> @if(@$data->permAddThram_no!=""){{@$data->permAddThram_no}} @else -- @endif</p>

                    <p><b>House No:</b> @if(@$data->permAddHouse_no!=""){{@$data->permAddHouse_no}} @else -- @endif</p>

                    


                    @endif

                    <p><b>Remarks:</b> @if(@$data->remarks!=""){{@$data->remarks}} @else -- @endif</p>
         
    </div>









                






               
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   
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
        $('#assign_to').on('change',function(){
            var id = $('#assign_to').val();

            if(id=="H"){
                $('#assignUsers_div').css('display','block');
                $('#regional_office_div').css('display','none');
            }else{
                $('#assignUsers_div').css('display','none');
                $('#regional_office_div').css('display','block');
            }
        });
    </script>



@endsection