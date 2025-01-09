@extends('layouts.admin')

@section('content')
<br>

@include('investigator/mainheader')
    <!------------------------ end top part ---------------->

    <div class="col-sm-13" style="margin-top:-9px;">
        <div class="card card-primary card-outline card-outline-tabs" style="height:350px">
            <div class="card-header p-0 border-bottom-0">
                @include('tabs/investigator_tab')
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
				    @if( $casesummary  == "")	
                        @if(Auth::user()->role == "Investigator") 
                        <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="addcasesummary()">
                            <span style="font:face:Product Sans">Add Case Summary</span>
                            <span><i class="fa fa-plus"></i></span>
                        </button>
                        @endif

					@else
                        <br>
                        <div id="casesummaryshow" >
                            <label style="font-family:Product Sans">Case Summary:</label>
                            <br>
                            {{ $casesummary }} 
                            <br>
                            @if(Auth::user()->role == "Investigator")
                            <button type="button" class="btn-primary" style="float:right; font:face:Product Sans;border-radius: 5px; display: inline-block; padding: 4px 4px; text-decoration: none; background-color: #007bff; color: #ffffff;" onclick="showeditsummarydetails('{{ $casenoid }}')">
                                    <span style="font:face:Product Sans">Edit</span>
                                    <span><i class="fa fa-pencil"></i></span>
                                </button>
                           @endif
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
        
<!--add modal -->
<form method = "POST" action="{{ route('addcasesummary') }}"  enctype="multipart/form-data" >
      @csrf    
<div class="modal fade" id="addcasesummarymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Add Case Summary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <input type="hidden" name="casesummarycasenoidadd" id="casesummarycasenoidadd" value="{{ $casenoid }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="casetitle">Case Summary:<font color='red'>*</font></label>
                                        <textarea name="casesummarydtls" id="casesummarydtls" class="form-control" required=""></textarea>
                                </div>
                            </div>
                        </div>  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end add modal -->
<!--add modal -->
<form method = "POST" action="{{ route('updatecasesummary') }}"  enctype="multipart/form-data" >
      @csrf    
<div class="modal fade" id="editcasesummarymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" >
            <div class="modal-content" style="font-family:Product Sans">                                                                                                                                                                                         <div class="modal-header alert-info">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Case Summary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <input type="hidden" name="casesummarycasenoidedit" id="casesummarycasenoidedit" value="{{ $casenoid }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="casetitle">Case Summary:<font color='red'>*</font></label>
                                        <textarea name="casesummaryeditdtls" id="casesummaryeditdtls" class="form-control" required="">  {{ $casesummary }} </textarea>
                                </div>
                            </div>
                        </div>  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end add modal -->
</section>
<script>
	
    function addcasesummary()
        {
            $('#addcasesummarymodal').modal('show'); 
             $('#casesummaryshow').show(); 
        }
    
    function showeditsummarydetails()
        {
            $('#editcasesummarymodal').modal('show'); 
        }

</script>
<style>
     .modal-header {
    background: linear-gradient(to top, #BFABA2, #ffffff);
    color: #000;
    font-family: Product Sans;
    border-radius: 5px 5px 0 0;
     }
</style>
@endsection