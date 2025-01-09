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




    {{-- table-showing --}}
    <div class="col-sm-12">

                           <div class="card-body">
                            <small>List of Properties to be Disposed</small>
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Seized From (CID)</th>
                                        <th>Seized From (Name)</th>
                                        <th>Location of Seizure</th>
                                        <th>Date and Time of Seizure</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                        
                                            <tr>
                                                <td>No data found</td>
                                            </tr>


                                       
                                    

                                </tbody>
                            </table>
                        </div>



    </div>



        <div class="col-sm-12">

                           <div class="card-body">
                            <small>List of Properties to be Handed Over</small>
                            <table id="maintableGewog" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Item</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Seized From (CID)</th>
                                        <th>Seized From (Name)</th>
                                        <th>Location of Seizure</th>
                                        <th>Date and Time of Seizure</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                        
                                            <tr>
                                                <td>No data found</td>
                                            </tr>


                                       
                                    

                                </tbody>
                            </table>
                        </div>



    </div>


    



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