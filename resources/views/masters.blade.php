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
                                    Masters Landing Page
                                </div>
                                
                            </div>

                        </div>




                        <div class="card-body">
                            <h4>Agency Master Records</h4>
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('embassy.index')}}" class="btn btn-primary">Embassy</a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('emp-category.index')}}" class="btn btn-warning">Employee Category</a>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('agency.index')}}" class="btn btn-success">Agency</a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('dzonkhag.index')}}" class="btn btn-danger">Dzongkhag </a>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('gewog.index')}}" class="btn btn-info">Gewog </a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('village.index')}}" class="btn btn-warning">Village </a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('constituency.index')}}" class="btn btn-primary">Constituency </a>
                                    </div>
                                </div>

                            </div>


                        </div>



                        <div class="card-body">
                            <h4>Complaint Master Records</h4>
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('complaint-mode-master')}}" class="btn btn-primary">Complaint Mode</a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('complaint-type-master')}}" class="btn btn-warning">Complaint Type</a>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('source-complaint-master')}}" class="btn btn-success">Source of Complaints</a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('person-category-master')}}" class="btn btn-danger">Person Category </a>
                                    </div>
                                </div>


                                

                            </div>


                        </div>


                   <div class="card-body">
                            <h4>Evaluation Masters</h4>
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('corruption-type.index')}}" class="btn btn-primary">Type of Corruption</a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('corruption-area.index')}}" class="btn btn-warning">Area of Corruption</a>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('complain-evaluation-decision.index')}}" class="btn btn-success">Complaints Evaluation Decisions</a>
                                    </div>
                                </div>

                                


                                

                            </div>
                           
                           
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('manage.pursuability-value-category')}}" class="btn btn-danger">Pursuability Value Category</a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('manage.pursuability-value-sub-category')}}" class="btn btn-info">Pursuability Value Subcategory</a>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('manage.pursuability-value-feilds')}}" class="btn btn-warning">Pursuability Value Fields</a>
                                    </div>
                                </div>

                                


                                

                            </div>

                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('pl-value-range.index')}}" class="btn btn-primary">Pursuability Values Range</a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('pl-value-scope.index')}}" class="btn btn-warning">Interpretation of P-Value Score</a>
                                    </div>
                                </div>


                            </div>


                        </div>


                        <div class="card-body">
                            <h4>Followup Master Records</h4>
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('followup-status-master')}}" class="btn btn-primary">Followup Status</a>
                                    </div>
                                </div>

                              </div>
                         </div>


                         <div class="card-body">
                            <h4>Users Master Records</h4>
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('manage.department')}}" class="btn btn-primary">Department</a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('manage.regional-office')}}" class="btn btn-danger">Regional Office</a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <a href="{{route('manage.division')}}" class="btn btn-warning">Division</a>
                                    </div>
                                </div>

                              </div>
                         </div>
                            

        </div>
    </div>
</div>
</div>

</section>


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <script>
        // $(function() {
        //     $("#maintableDz").dataTable();
        // });

        $(document).ready(function() {
            $('#maintableDz').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });

// ;

        $('.edit_button').on('click',function(){
            $('#pValueName_edit').val($(this).data('name'));
            $('#CategoryId').val($(this).data('id'));
            $('#remakrs_name_edit').val($(this).data('remark'));
            $('#exampleModaEdit').modal('show');
        })
        
    </script>




@endsection
