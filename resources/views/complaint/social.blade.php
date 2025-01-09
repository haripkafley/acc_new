@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" href="{{route('complaint.registration.edit.view',['id'=>@$id])}}">Complaint Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('allegation.offence.management',['id'=>@$id])}}">Allegations/Offences</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="{{route('attachment.view.complaint',['id'=>@$id])}}">Attachment Details</a>
        </li>
        

        


        <li class="nav-item">
          <a class="nav-link" href="{{route('person.involved.complaint',['id'=>@$id])}}" >Person Involved</a>
        </li>


        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.financial-implication-details.page',['id'=>@$id])}}">Financial Implication</a>
        </li>


        <li class="nav-item">
          <a class="nav-link active btn btn-info"  href="{{route('complaint.social.implication',['id'=>@$id])}}">Social Implication</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('link.case.complaint',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>




          <form method="post" action="{{route('complaint.social.implication.save')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="complaintID" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Implication<span style="font-weight: bold; color: red;">*</span></label>
                            <select class="form-control" name="implication" required>
                              <option value="">Select</option>
                              <option value="Individual" @if(@$data->implication=="Individual") selected @endif>Individual</option>
                              <option value="Local" @if(@$data->implication=="Local") selected @endif>Local</option>
                              <option value="Regional" @if(@$data->implication=="Regional") selected @endif>Regional</option>
                              <option value="National" @if(@$data->implication=="National") selected @endif>National</option>
                            </select>
                    </div>
                </div>

                <div class="clearfix"> </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Implication Details<span style="font-weight: bold; color: red;"></span></label>
                            <textarea class="form-control"  type="text" name="implication_details"> {{@$data->implication_details}} </textarea>
                    </div>
                </div>

                
                
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Save</button></div>
            </div>
        </form>
    </div>
</section>




@endsection