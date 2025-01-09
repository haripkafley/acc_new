@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">


        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.form.edit.ir')) active btn btn-info @endif"  href="{{route('manage.information.report.form.edit.ir',@$id)}}">IR Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.suspects.add')) active btn btn-info @endif" href="{{route('manage.information.report.suspects.add',@$id)}}" disabled>IR Suspect</a>
        </li>

        <li class="nav-item">
          @if (session('ir_report_type')=="reporting_officer")
          <a class="nav-link @if(Route::is('manage.information.report.form.reporting.official')) active btn btn-info @endif"  href="{{route('manage.information.report.form.reporting.official')}}">Back</a>
          @else
          <a class="nav-link @if(Route::is('manage.information.report.form')) active btn btn-info @endif"  href="{{route('manage.information.report.form')}}">Back</a>
          @endif
        </li>

        </ul>

            <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Suspect List </div>

                        <div class = "card-body">
                            
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Nationality</th>
                                        <th>Name Of Suspect</th>
                                        <th>CID</th>
                                        <th>Identification No</th>
                                        <th>Country</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$suspects->isNotEmpty())
                                    @foreach(@$suspects as $att)
                                    <tr>
                                        <td>@if(@$att->nationality=="B")National @else Non-National @endif</td>
                                        <td>{{ $att->name }}</td>
                                        <td>{{ $att->cid }}</td>
                                        <td>{{ $att->identity }}</td>
                                        <td>{{ $att->country }}</td>
                                        <td>
                                                        
                                                            
                                                            <a class="btn btn-xs btn-danger" href="{{route('manage.information.report.suspects.delete.suspect',['id'=>@$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Suspect Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <form method="post" action="{{route('manage.information.report.suspects.insert.suspect')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="ir_id" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>National Type<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="nationality" id="nationality">
                                <option value="">Select</option>
                                <option value="B">National</option>
                                <option value="N">Non-National</option>
                            </select>
                    </div>
                </div>

                <div class="clearfix"> </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Name Of Suspect<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="name" class="form-control" required>
                    </div>
                </div>


                <div class="col-sm-12 cid_div" style="display:none">
                    <div class="form-group">
                        <label>CID</label>
                            <input type="text" name="cid" class="form-control">
                    </div>
                </div>

                <div class="col-sm-12 identity_div" style="display:none">
                    <div class="form-group">
                        <label>Identification No</label>
                            <input type="text" name="identity" class="form-control">
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Country<span style="font-weight: bold; color: red;"></span></label>
                            <input type="text" name="country" class="form-control" required>
                    </div>
                </div>


                


                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            </div>
        </form>
    </div>
</section>

<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>

<script type="text/javascript">
    $('#nationality').on('change',function(e){
        var nationality = $(this).val();
        if(nationality=="B")
        {
            $('.cid_div').show();
            $('.identity_div').hide();
        }else{
            $('.cid_div').hide();
            $('.identity_div').show();
        }    
    });
</script>


@endsection