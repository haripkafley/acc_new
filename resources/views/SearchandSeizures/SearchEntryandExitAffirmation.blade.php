@extends('layouts.admin')

@section('content')
<style>
    .coi_show {
        display: none;
    }

    .coi_hide {
        display: none;
    }
</style>

<br>

<section id="table1s" class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title text-info"><b>Search Entry and Exit Affirmation</b></h2>
                        <div class="d-flex justify-content-end">
                            
                        </div>
                        {{-- <div class="d-flex justify-content-end">
                <button type="button" class="btn-close" aria-label="Close" onclick="return hideDetails3();"><b>X</b></button>
              </div> --}}
                    </div>
                    <!-- content -->
                    <div class="card-body">
                        
                        <form>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Place of Search:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" id="first-name" class="form-control" name="case_no"
                                        placeholder="Please Enter Case Number">
                                </div>

                                <div class="col-md-2">
                                    <label>Date:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="date" id="first-name" class="form-control" name="Suspect"
                                        placeholder="Please Enter Suspect">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>Time of Entry:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="time" id="first-name" class="form-control" name="case_no"
                                        placeholder="Please Enter Case Number">
                                </div>

                                <div class="col-md-2">
                                    <label>Time of Exit:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="time" id="first-name" class="form-control" name="Suspect"
                                        placeholder="Please Enter Suspect">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label><b>Search Entry and Exit Affirmation given by:</b></label>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>CID:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" id="first-name" class="form-control" name="case_no"
                                        placeholder="Please Enter Case Number">
                                </div>

                                <div class="col-md-2">
                                    <label>Name:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" id="first-name" class="form-control" name="Suspect"
                                        placeholder="Please Enter Suspect">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label><b>Witness:</b></label>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>CID:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" id="first-name" class="form-control" name="case_no"
                                        placeholder="Please Enter Case Number">
                                </div>

                                <div class="col-md-2">
                                    <label>Name:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" id="first-name" class="form-control" name="Suspect"
                                        placeholder="Please Enter Suspect">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>CID:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" id="first-name" class="form-control" name="case_no"
                                        placeholder="Please Enter Case Number">
                                </div>

                                <div class="col-md-2">
                                    <label>Name:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="text" id="first-name" class="form-control" name="Suspect"
                                        placeholder="Please Enter Suspect">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>Attach Document:</label>
                                </div>
                                <div class="col-md-4 form-group">
                                    <input type="file" id="first-name" class="form-control" name="case_no">
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <button type="submit" class="btn btn-info">Submit</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>

                        </form>

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