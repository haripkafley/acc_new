@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        




          <form method="post" action="{{route('tacktical.inteligence.autorization.form.update.recommendation.decision-make')}}" enctype="multipart/form-data">
            @csrf
                <div class="row">

                
                <input type="hidden" name="id" value="{{@$data->id}}">

                <div class="col-md-6">
                <div class="form-group">
                    <label>Recommended By</label>
                    <select class="form-control" required name="recommend_by">
                        <option value="">Select</option>
                        @foreach(@$user as $value)
                        <option value="{{@$value->id}}" @if(@$data->recommend_by==@$value->id) selected @endif>{{@$value->name}}</option>
                        @endforeach
                    </select>
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>Recommended Date</label>
                    <input type="date" name="recommend_date" value="{{@$data->recommend_date}}" required class="form-control">
                </div>
               </div>

               

               <div class="col-md-12">
                <div class="form-group">
                    <label>Remarks</label>
                    <textarea type="text" name="recommend_remarks" required class="form-control">{{@$data->recommend_remarks}}</textarea>
                </div>
               </div>

               
               



            </div>
                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            
        </form>
    </div>
</section>

<script
type="text/javascript"
charset="utf8"
src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"
></script>



@endsection