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
                              Commission Directives
                            </div>
                            
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.indi.navbar')
                            <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.commission.directives.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.commission.directives.page',['id'=>@$id])}}"> Commission Directives</a>
                                </li>

                                
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.commission.directives.page.activity')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.commission.directives.page.activity',['id'=>@$id])}}">Commission Directive Activities</a>
                                </li>

                                
                            </ul>
                            @if(@$check->report_status!="A")
                            <form action="{{route('tacktical.inteligence.autorization.individual.commission.directives.page.update')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{@$id}}">
                                <div class="col-md-12">
                                    <label>Commission Directives</label>
                                    <textarea class="form-control" name="description" required></textarea>
                                </div>
                                <div class="col-md-12 mt-3"><button type="submit" class="btn btn-primary">Save</button></div>
                            </form>
                            @endif

                            <div class = "card-body">
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Commission Directives</th>
                                        @if(@$check->report_status!="A")
                                        <th>Action</th>       
                                        @endif     
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$data->isNotEmpty())
                                    @foreach(@$data as $att)
                                    <tr>
                                        <td>{{ $att->description}}</td>
                                        @if(@$check->report_status!="A")
                                       <td>
                                               <a class="btn btn-xs btn-danger" href="{{route('tacktical.inteligence.autorization.individual.commission.directives.page.delete',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                                </a>
                                                            
                                                            
                                        </td>
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
            $('#name').val($(this).data('name'));
            $('#code').val($(this).data('code'));
            $('#created_on').val($(this).data('created_on'));
            $('#created_method').val($(this).data('created_method')).change();
            let string = $(this).data('collected_by');
            if (/,/.test(string)) {
                 let arr = string.split(',');
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }else{
                let arr = [string];
                 $("#leaderMultiSelctdropdown").val(arr);
                $("#leaderMultiSelctdropdown").val(arr);
                $('#leaderMultiSelctdropdown').val(arr).change();
            }
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