@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        




          <form method="post" action="{{route('tacktical.inteligence.autorization.form.commission-decision.make.update')}}" enctype="multipart/form-data">
            @csrf
                <div class="row">

                
                <input type="hidden" name="id" value="{{@$data->id}}">

                <div class="col-md-6">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" required name="com_decision">
                        <option value="">Select</option>
                        <option value="AP" @if(@$data->com_decision=="AP") selected @endif>Approved</option>
                        <option value="DF" @if(@$data->com_decision=="DF") selected @endif>Deferred</option>
                        <option value="RJ" @if(@$data->com_decision=="RJ") selected @endif>Rejected</option>
                    </select>
                </div>
               </div>

               <div class="col-md-4">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="com_date" value="{{@$data->com_date}}" required class="form-control">
                </div>
               </div>

               

               <div class="col-md-12">
                <div class="form-group">
                    <label>Remarks</label>
                    <textarea type="text" name="com_remarks" required class="form-control">{{@$data->com_remarks}}</textarea>
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