@extends('layouts.admin')

@section('content')

<br>


<section class            = "content">
      <div class          = "container-fluid">
        <div class        = "row">
          <div class      = "col-12">
            <div class    = "card">
              <div class  = "card-header">
                <h3 class = "card-title">Evidences</h3>
                <button type="button" style="float:right" class="btn btn-primary" onclick="addnewevidence()" name="add" data-toggle="tooltip" data-placement="bottom" title="Add New Evidence"><i class="fa fa-plus"></i></button>
              </div>
              <!-- /.card-header -->
              <div class  = "card-body">
                
              <table id = "example1" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                        <th>Sl No</th>
                        <th>Evidence Type</th>
                        <th>Evidence Name</th>
                        <th>Evidence Description</th>
                        <th>Evidence Collected On</th> 
                        <th>Evidence Collected By</th> 
                        <th>Action</th>                    
                        
                  </tr>
                  </thead>
                  <tbody>
                
            </tbody>
         </table>

                
<!-- Modal -->

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      <!-- ADD CASE -->
<form method = "POST" action="{{ route('addevidences') }}" enctype="multipart/form-data" >
    @csrf      

    <div class="modal fade" id="modal_addevidence_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" >
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <h5 class="modal-title" >Add New Evidence</h5>
                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Case No&nbsp;<font color='red'>*</font></label>
                                        <select class  = "form-control" name="caseno" id="caseno" >
                                            <option>Select Case No</option>
                                                @foreach ($cases as $case)
                                                    <option value   = "{{ $case->case_no  }}">{{ $case->case_no }}</option>
                                                    
                                                @endforeach    
                                        </select>
                                        
                                    </div>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Evidence Category&nbsp;<font color='red'>*</font></label>
                                       
                                        <select class  = "form-control" name="evidencecat" id="evidencecat" >
                                                    <option>Select Category</option>
                                                    <option value   = "Statement">Statement</option>
                                                    <option value   = "Agreement">Agreement</option>
                                                    <option value   = "Emails">Emails</option>
                                                    <option value   = "Document">Document</option>
                                                    <option value   = "Audio Visual">Audio Visual</option>
                                                    <option value   = "Properties">Properties</option>
                                                    <option value   = "Expert Opinion">Expert Opinion</option>
                                                   
                                        </select>
                                    </div>
                                </div>

                            </div>  
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Evidence Name&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="evidencename"  class="form-control" id="evidencename">
                                        
                                    </div>
                                    
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Evidence No&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="evidenceno"  class="form-control" id="evidenceno">
                                        
                                    </div>
                                </div>
                                
                                    
                        </div>  
                        <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Collected On&nbsp;<font color='red'>*</font></label>
                                        <input type="date" name="collectedon"  class="form-control" id="collectedon">
                                        
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Collected By&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="collectedby"  class="form-control" id="collectedby">
                                        
                                    </div>
                                </div>

                            </div>  
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Offence&nbsp;<font color='red'>*</font></label>
                                        
                                        <select class  = "form-control" name="evioffence" id="evioffence" >
                                                    <option>Select Category</option>
                                                    <option value   = "Offence 1">Offence 1</option>
                                                    <option value   = "Offence 2">Offence 2</option>
                                                    <option value   = "Offence 3">Offence 3</option>
                                                   
                                                   
                                        </select>
                                    </div>
                                </div>
                            </div>     
                            <div class="row">
                               
                            <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Evidence Description&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="evidescription"  class="form-control" id="evidescription">
                                        
                                    </div>
                                    
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Allegation&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="eviallegation"  class="form-control" id="eviallegation">
                                        
                                    </div>
                                </div>
  
                            </div>  
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Importance&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="eviimportance"  class="form-control" id="eviimportance">
                                        
                                    </div>
                                    
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Source&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="evisource"  class="form-control" id="evisource">
                                        
                                    </div>
                                </div>
                                    
                            </div>  
                                    
                         
                                
                                
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Event&nbsp;<font color='red'>*</font></label>
                                        <input type="text" name="evievent"  class="form-control" id="evievent">
                                        
                                    </div>
                                    
                                </div>
                                
                                    
                            </div>  
                                    
                                                   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</form>

<!-- FINISH ADD CASE -->
    </section>
    <script>
      function addnewevidence()
        {
           
            $('#modal_addevidence_show').modal('show');
        }
    </script>
@endsection
