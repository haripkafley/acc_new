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
                              Hypothesis
                            </div>
                            
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('ip_details.head_navbar')
                            <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">


                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.hypothesis')) active btn btn-success @endif"  href="{{route('manage.ip.lists.head.chief.details.hypothesis',['id'=>@$id])}}"> Hypothesis</a>
                                </li>
        
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.plan.intel')) active btn btn-success @endif"  href="{{route('manage.ip.lists.head.chief.details.plan.intel',['id'=>@$id])}}">Task Details</a>
                                </li>

                                
                            </ul>
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Hypothesis</th>
                                        <th>Description</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$plan->isNotEmpty())
                                    @foreach(@$plan as $att)
                                    <tr>
                                        <td>{{ $att->name}}</td>
                                        <td>{{ $att->description }}</td>
                                        
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


        <!-- Modal -->

</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#name').val($(this).data('name'));
            $('#description').val($(this).data('description'));
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