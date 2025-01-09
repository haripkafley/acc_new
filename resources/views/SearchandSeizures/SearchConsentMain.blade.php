@extends('layouts.admin')

@section('content')
<style>
  .coi_show {
    display : none;
  }

  .coi_hide {
    display : none;
  }
</style>
<br>


<!-- MAIN TBALE seizuregenerals -->
<section id="tables" class = "content">
  <div class = "container-fluid">
    <div class = "row">
      <div class = "col-12">
        {{-- @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif --}}
        <div class = "card">
          <div class = "card-header">
            <h2 class = "card-title text-info"><b>Search Consent Table</b></h2>
          </div>

          <div class = "card-body">
            <div class="d-flex justify-content-start">
            </div>

            <br>
            <table id ="example3" class="table table-bordered table-hover ">
              <thead class="bg-info text-center">
                <tr>
                  <th>Sl No</th>
                  <th>Case Number</th>
                  <th>Consent Provided On</th>
                  <th>Consent Name</th>
                  <th>Witness Name</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @foreach ( $SearchConsentMain as $data )
                <tr>
                  
                    <td>{{ ++$i }}</td>
                    <td>{{ $data->case_no }}</td>
                    <td>{{ $data->consent_provided_on }}</td>
                    <td>{{ $data->consent_name }}</td>
                    <td>{{ $data->witness_name }}</td>
                    <td class="text-center">
                        <a href="{{ route('Search_ConsentView',$data->id) }}" class="btn btn-info btn-sm">Preview</a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
             
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<script>
$(document).ready(function () {
        $("#open").click(function () {
            $(".coi_show").animate({
                height: "toggle"
            }, 500);
            $(".coi_hide").hide();
        });
        $("#close").click(function () {
            $(".coi_show").hide();

        });
});

</script>

@endsection
