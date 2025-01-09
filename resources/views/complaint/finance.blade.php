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
          <a class="nav-link active btn btn-info"  href="{{route('complaint.financial-implication-details.page',['id'=>@$id])}}">Financial Implication</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{route('complaint.social.implication',['id'=>@$id])}}">Social Implication</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('link.case.complaint',['id'=>@$id])}}">Link Case</a>
        </li>
      </ul>




          <form method="post" action="{{route('complaint.financial-implication-details.save.details')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="complaintID" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Financial Implication</label>
                           <input type="number" name="financial_implication_amount" value="{{@$data->financial_implication_amount}}" class="form-control">
                    </div>
                </div>

                 <div class="col-sm-6"><button type="submit" class="btn btn-info mt-4">Save</button></div>
            </div>
        </form>


            



            {{-- natural-resource --}}

            <div class="row">
                <div class="col-sm-12">
                    <h4>Natural Resource</h4>
                    
                    <div class="form-check form-check-inline">
                              
                         <input class="form-check-input natural_resource" type="radio" id="natural_resource" name="natural_resource" @if(@$finance_details->natural_resource=="Y") checked @endif  value="Y">
                              <label class="form-check-label" for="genderInput">Yes</label>
                              
                      </div>

                      <div class="form-check form-check-inline">
                              
                              <input class="form-check-input natural_resource" type="radio" id="natural_resource" name="natural_resource" @if(@$finance_details->natural_resource=="N") checked @elseif(@$finance_details=="") checked @endif value="N">
                              <label class="form-check-label" for="genderInput">No</label>
                              
                    </div>



                        <div class = "card-body natural_table" @if(@$finance_details->natural_resource=="Y") style="display:block" @else style="display:none" @endif>
                            <h5>
                              <small><a class="btn btn-warning" style="float:right" id="natural_resource_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        
                                        <th>Sector</th>
                                        <th>Resource</th>
                                        <th>Description</th>
                                        <th>Amount Involved</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$natural_resources->isNotEmpty())
                                    @foreach(@$natural_resources as $att)
                                    <tr>
                                        
                                        <td>{{ $att->sector }}</td>
                                        <td>{{ $att->resource }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td>
                                        
                                                 <a class="btn btn-xs btn-danger" href="" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                            </a>
                                                            

                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>

                        {{-- model --}}
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Natural Resource</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('natural.resource.add.complaint')}}">@csrf
                                <input type="hidden" name="complaintID" value="{{@$id}}">
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Sector</label>
                                  <select class="form-control" name="sector">
                                      <option value="">Select</option>
                                      <option value="Forest Sector">Forest Sector</option>
                                      <option value="Mining Sector">Mining Sector</option>
                                      <option value="Environment Sector">Environment Sector</option>
                                      <option value="Others">Others</option>
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Resource</label>
                                  <input type="text" class="form-control" id="resource" name="resource" aria-describedby="emailHelp" placeholder="Resource">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Description</label>
                                  <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp" placeholder="Description" style="height:250px;"></textarea>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Amount Involved</label>
                                  <input type="number" class="form-control" id="amount" name="amount" aria-describedby="emailHelp" placeholder="Amount Involved">
                                 </div>
                        
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>

                        {{-- end-model --}}

                </div>
            </div>


        {{-- new-policy --}}

        <div class="row">
                <div class="col-sm-12">
                    <h4>New Policy</h4>
                    
                    <div class="form-check form-check-inline">
                              
                         <input class="form-check-input new_policy" type="radio" name="new_policy"   @if(@$finance_details->policy=="Y") checked @endif  value="Y">
                              <label class="form-check-label" for="genderInput">Yes</label>
                              
                      </div>

                      <div class="form-check form-check-inline">
                              
                              <input class="form-check-input new_policy" type="radio" name="new_policy"   @if(@$finance_details->policy=="N") checked @elseif(@$finance_details=="") checked @endif value="N">
                              <label class="form-check-label" for="genderInput">No</label>
                              
                    </div>



                        <div class = "card-bodyc new_policy_table" @if(@$finance_details->policy=="Y") style="display:block" @else style="display:none" @endif>
                            <h5>
                              <small><a class="btn btn-warning" style="float:right" id="new_policy_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount Involved</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$policy->isNotEmpty())
                                    @foreach(@$policy as $att)
                                    <tr>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td>
                                        
                                                 <a class="btn btn-xs btn-danger" href="" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                </a>
                                                            

                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>

                        {{-- model --}}
            <div class="modal fade" id="exampleModaEdit2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">Add New Policy</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('new.policy.add.complaint')}}">@csrf
                                <input type="hidden" name="complaintID" value="{{@$id}}">
                                

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Description</label>
                                  <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp" placeholder="Description" style="height:250px;"></textarea>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Amount Involved</label>
                                  <input type="number" class="form-control" id="amount" name="amount" aria-describedby="emailHelp" placeholder="Amount Involved">
                                 </div>
                        
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>

                        {{-- end-model --}}

                </div>
            </div>




        {{-- political --}}


        <div class="row">
                <div class="col-sm-12">
                    <h4>Political</h4>
                    
                    <div class="form-check form-check-inline">
                              
                         <input class="form-check-input political" type="radio" name="Political"  @if(@$finance_details->political=="Y") checked @endif   value="Y">
                              <label class="form-check-label" for="genderInput">Yes</label>
                              
                      </div>

                      <div class="form-check form-check-inline">
                              
                              <input class="form-check-input political" type="radio" name="Political"    @if(@$finance_details->political=="N") checked @elseif(@$finance_details=="") checked @endif value="N">
                              <label class="form-check-label" for="genderInput">No</label>
                              
                    </div>



                        <div class = "card-body political_table"  @if(@$finance_details->political=="Y") style="display:block" @else style="display:none" @endif>
                            <h5>
                              <small><a class="btn btn-warning" style="float:right" id="new_political_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Reason</th>
                                        <th>Description</th>
                                        <th>Amount Involved</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$political->isNotEmpty())
                                    @foreach(@$political as $att)
                                    <tr>
                                        <td>{{ $att->reason }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td>
                                        
                                                 <a class="btn btn-xs btn-danger" href="" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                </a>
                                                            

                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>

                        {{-- model --}}
            <div class="modal fade" id="exampleModaEdit3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel3">Political</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('new.political.add.complaint')}}">@csrf
                                <input type="hidden" name="complaintID" value="{{@$id}}">
                                
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Reason</label>
                                  <textarea type="text" class="form-control" id="reason" name="reason" aria-describedby="emailHelp" placeholder="Reason" style="height:250px;"></textarea>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Description</label>
                                  <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp" placeholder="Description" style="height:250px;"></textarea>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Amount Involved</label>
                                  <input type="number" class="form-control" id="amount" name="amount" aria-describedby="emailHelp" placeholder="Amount Involved">
                                 </div>
                        
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>

                        {{-- end-model --}}

                </div>
            </div>



        {{-- personnel --}}
                <div class="row">
                <div class="col-sm-12">
                    <h4>Personnel</h4>
                    
                    <div class="form-check form-check-inline">
                              
                         <input class="form-check-input personnel" type="radio" name="personnel"  @if(@$finance_details->personnel=="Y") checked @endif  value="Y">
                              <label class="form-check-label" for="genderInput">Yes</label>
                              
                      </div>

                      <div class="form-check form-check-inline">
                              
                              <input class="form-check-input personnel" type="radio"  name="personnel" @if(@$finance_details->personnel=="N") checked @elseif(@$finance_details=="") checked @endif value="N">
                              <label class="form-check-label" for="genderInput">No</label>
                              
                    </div>



                        <div class = "card-body personnel_table" @if(@$finance_details->personnel=="Y") style="display:block" @else style="display:none" @endif>
                            <h5>
                              <small><a class="btn btn-warning" style="float:right" id="personnel_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Agency</th>
                                        <th>Activity</th>
                                        <th>Description</th>
                                        <th>Amount Involved</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$personnel->isNotEmpty())
                                    @foreach(@$personnel as $att)
                                    <tr>
                                        <td>{{ $att->agency }}</td>
                                        <td>{{ $att->activity }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td>
                                        
                                                 <a class="btn btn-xs btn-danger" href="" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                </a>
                                                            

                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>

                        {{-- model --}}
            <div class="modal fade" id="exampleModaEdit4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Personnel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('new.personnel.add.complaint')}}">@csrf
                                <input type="hidden" name="complaintID" value="{{@$id}}">
                                
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Agency</label>
                                  <input type="text" class="form-control" id="agency" name="agency" aria-describedby="emailHelp" placeholder="Agency" required>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Activity</label>
                                  <select class="form-control" required name="activity">
                                      <option value="">Select</option>
                                      <option value="Recruitment">Recruitment</option>
                                      <option value="Promotion">Promotion</option>
                                      <option value="Training">Training</option>
                                      <option value="Scholarship">Scholarship</option>
                                      <option value="Misuse of Personnel">Misuse of Personnel</option>
                                      <option value="Selection For Training">Selection For Training</option>
                                      <option value="Transfer">Transfer</option>
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Description</label>
                                  <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp" placeholder="Description" style="height:250px;"></textarea>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Amount Involved</label>
                                  <input type="number" class="form-control" id="amount" name="amount" aria-describedby="emailHelp" placeholder="Amount Involved">
                                 </div>
                        
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>

                        {{-- end-model --}}
              </div>
        </div>


{{-- procurement goods and services --}}

                <div class="row">
                <div class="col-sm-12">
                    <h4>Procurement goods and services</h4>
                    
                    <div class="form-check form-check-inline">
                              
                         <input class="form-check-input procurement_good" type="radio" name="procurement_good_name"  @if(@$finance_details->procurement_good=="Y") checked @endif    value="Y">
                              <label class="form-check-label" for="genderInput">Yes</label>
                              
                      </div>

                      <div class="form-check form-check-inline">
                              
                              <input class="form-check-input procurement_good" type="radio" name="procurement_good_name"  @if(@$finance_details->procurement_good=="N") checked @elseif(@$finance_details=="") checked @endif   value="N">
                              <label class="form-check-label" for="genderInput">No</label>
                              
                    </div>



                        <div class = "card-body procurement_good_table" @if(@$finance_details->procurement_good=="Y") style="display:block" @else style="display:none" @endif>
                            <h5>
                              <small><a class="btn btn-warning" style="float:right" id="goods_services_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Dzongkhag / Thromde</th>
                                        <th>Gewog</th>
                                        <th>Goods / Service Description</th>
                                        <th>Supplier</th>
                                        <th>Amount Involved</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$goods_services->isNotEmpty())
                                    @foreach(@$goods_services as $att)
                                    <tr>
                                        <td>{{ $att->dzongkhagrelation->dzoName }}</td>
                                        <td>{{ $att->gewogrelation->gewogName }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->supplier }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td>
                                        
                                                 <a class="btn btn-xs btn-danger" href="" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                </a>
                                                            

                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>

                        {{-- model --}}
            <div class="modal fade" id="exampleModaEdit5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel5">Procurement Goods And Services</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('new.personnel.goods-services.add.complaint')}}">@csrf
                                <input type="hidden" name="complaintID" value="{{@$id}}">
                                
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Dzongkhag</label>
                                  <select class="form-control dzongkhag_id" name="dzongkhag_id">
                                      <option value="">Select</option>
                                      @foreach(@$dzongkhag as $value)
                                      <option value="{{@$value->dzoID}}">{{@$value->dzoName}}</option>
                                      @endforeach
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Gewog</label>
                                  <select class="form-control gewog_id" required name="gewog_id" >
                                      <option value="">Select</option>
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Goods / Service Description</label>
                                  <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp" placeholder="Goods / Service Description" style="height:250px;"></textarea>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Supplier</label>
                                  <input type="text" class="form-control" id="supplier" name="supplier" aria-describedby="emailHelp" placeholder="Supplier">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Amount Involved</label>
                                  <input type="number" class="form-control" id="amount" name="amount" aria-describedby="emailHelp" placeholder="Amount Involved">
                                 </div>
                        
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>

                        {{-- end-model --}}
              </div>
        </div>




        {{-- procurement goods --}}
        <div class="row">
                <div class="col-sm-12">
                    <h4>Procurement goods and services</h4>
                    
                    <div class="form-check form-check-inline">
                              
                         <input class="form-check-input service" type="radio" name="service"  @if(@$finance_details->procurement_work=="Y") checked @endif  value="Y">
                              <label class="form-check-label" for="genderInput">Yes</label>
                              
                      </div>

                      <div class="form-check form-check-inline">
                              
                              <input class="form-check-input service" type="radio" name="service"  @if(@$finance_details->procurement_work=="N") checked @elseif(@$finance_details=="") checked @endif value="N">
                              <label class="form-check-label" for="genderInput">No</label>
                              
                    </div>



                        <div class = "card-body service_table" @if(@$finance_details->procurement_work=="Y") style="display:block" @else style="display:none" @endif>
                            <h5>
                              <small><a class="btn btn-warning" style="float:right" id="goods_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Dzongkhag / Thromde</th>
                                        <th>Gewog</th>
                                        <th>Goods / Service Description</th>
                                        <th>Contractor</th>
                                        <th>Amount Involved</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$goods->isNotEmpty())
                                    @foreach(@$goods as $att)
                                    <tr>
                                        <td>{{ $att->dzongkhagrelation->dzoName }}</td>
                                        <td>{{ $att->gewogrelation->gewogName }}</td>
                                        <td>{{ $att->description }}</td>
                                        <td>{{ $att->contractor }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td>
                                        
                                                 <a class="btn btn-xs btn-danger" href="" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                </a>
                                                            

                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>

                        {{-- model --}}
            <div class="modal fade" id="exampleModaEdit6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel6">Procurement Works</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('new.personnel.goods.add.complaint')}}">@csrf
                                <input type="hidden" name="complaintID" value="{{@$id}}">
                                
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Dzongkhag</label>
                                  <select class="form-control dzongkhag_id" name="dzongkhag_id">
                                      <option value="">Select</option>
                                      @foreach(@$dzongkhag as $value)
                                      <option value="{{@$value->dzoID}}">{{@$value->dzoName}}</option>
                                      @endforeach
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Gewog</label>
                                  <select class="form-control gewog_id" required name="gewog_id" >
                                      <option value="">Select</option>
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Work Description</label>
                                  <textarea type="text" class="form-control" id="description" name="description" aria-describedby="emailHelp" placeholder="Work Description" style="height:250px;"></textarea>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Contractor</label>
                                  <input type="text" class="form-control" id="contractor" name="contractor" aria-describedby="emailHelp" placeholder="Contractor">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Amount Involved</label>
                                  <input type="number" class="form-control" id="amount" name="amount" aria-describedby="emailHelp" placeholder="Amount Involved">
                                 </div>
                        
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>

                        {{-- end-model --}}
              </div>
        </div>
        


        {{-- land-details --}}
                <div class="row">
                <div class="col-sm-12">
                    <h4>Land Details</h4>
                    
                    <div class="form-check form-check-inline">
                              
                         <input class="form-check-input land" type="radio" name="land"  @if(@$finance_details->land=="Y") checked @endif  value="Y">
                              <label class="form-check-label" for="genderInput">Yes</label>
                              
                      </div>

                      <div class="form-check form-check-inline">
                              
                              <input class="form-check-input land" type="radio" name="land"  @if(@$finance_details->land=="N") checked @elseif(@$finance_details=="") checked @endif value="N">
                              <label class="form-check-label" for="genderInput">No</label>
                              
                    </div>



                        <div class = "card-body land_table" @if(@$finance_details->land=="Y") style="display:block" @else style="display:none" @endif>
                            <h5>
                              <small><a class="btn btn-warning" style="float:right" id="land_add">+Add Data</a></small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Dzongkhag / Thromde</th>
                                        <th>Gewog</th>
                                        <th>Area</th>
                                        <th>Thram No.</th>
                                        <th>Plot No.</th>
                                        <th>Amount Involved</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$land->isNotEmpty())
                                    @foreach(@$land as $att)
                                    <tr>
                                        <td>{{ $att->dzongkhagrelation->dzoName }}</td>
                                        <td>{{ $att->gewogrelation->gewogName }}</td>
                                        <td>{{ $att->area }}</td>
                                        <td>{{ $att->tham_no }}</td>
                                        <td>{{ $att->plot_no }}</td>
                                        <td>{{ $att->amount }}</td>
                                        <td>
                                        
                                                 <a class="btn btn-xs btn-danger" href="" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                
                                                </a>
                                                            

                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>

                        {{-- model --}}
            <div class="modal fade" id="exampleModaEdit7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel7"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel7">Land Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('new.personnel.land.add.complaint')}}">@csrf
                                <input type="hidden" name="complaintID" value="{{@$id}}">
                                
                                <div class="form-group">
                                  <label for="exampleInputEmail1">Dzongkhag</label>
                                  <select class="form-control dzongkhag_id" name="dzongkhag_id">
                                      <option value="">Select</option>
                                      @foreach(@$dzongkhag as $value)
                                      <option value="{{@$value->dzoID}}">{{@$value->dzoName}}</option>
                                      @endforeach
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Gewog</label>
                                  <select class="form-control gewog_id" required name="gewog_id" >
                                      <option value="">Select</option>
                                  </select>
                                 </div>

                                 

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Area</label>
                                  <input type="text" class="form-control" id="area" name="area" aria-describedby="emailHelp" placeholder="Area">
                                 </div>


                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Thram No.</label>
                                  <input type="text" class="form-control" id="tham_no" name="tham_no" aria-describedby="emailHelp" placeholder="Thram No.">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Plot No.</label>
                                  <input type="text" class="form-control" id="plot_no" name="plot_no" aria-describedby="emailHelp" placeholder="Plot No.">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Amount Involved</label>
                                  <input type="number" class="form-control" id="amount" name="amount" aria-describedby="emailHelp" placeholder="Amount Involved">
                                 </div>
                        
                                <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>

                        {{-- end-model --}}
              </div>
        </div>
        



    </div>
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript">
    $('#natural_resource_add').on('click',function(){
           $('#exampleModaEdit').modal('show');
        })
</script>

<script type="text/javascript">
    $('#new_policy_add').on('click',function(){
           $('#exampleModaEdit2').modal('show');
        })
</script>

<script type="text/javascript">
    $('#new_political_add').on('click',function(){
           $('#exampleModaEdit3').modal('show');
        })
</script>

<script type="text/javascript">
    $('#personnel_add').on('click',function(){
           $('#exampleModaEdit4').modal('show');
        })

    $('#goods_add').on('click',function(){
           $('#exampleModaEdit6').modal('show');
        })

    $('#land_add').on('click',function(){
           $('#exampleModaEdit7').modal('show');
        })
</script>


<script type="text/javascript">
    $('#goods_services_add').on('click',function(){
           $('#exampleModaEdit5').modal('show');
        });


            $('.dzongkhag_id').on('change', function() {
            console.log(333333);
            let selectId = $(this).val();
            console.log(selectId);
            var url = '{{ route('gewog.list.dz', ':id') }}';
            url = url.replace(':id', selectId);
            $('.gewog_id').empty();
            
            $.getJSON(url, function(data) {
                $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('.gewog_id').append('<option value="' + value.gewogID + '">' + value.gewogName +
                        '</option>');
                });
            });

        });
</script>


{{-- natural_resource --}}
<script type="text/javascript">
    $('.natural_resource').on('change',function(){
        var getvalue = $(this).val();
        var complaintId = '{{@$id}}';
        $.ajax({
        url:'{{route('status.update.natural.resource')}}',
        type:'GET',
        data:{getvalue:getvalue,complaintId:complaintId},
        success:function(data){
          console.log(data);
          if(getvalue=="Y")
          {
            $('.natural_table').css('display','block');
          }else{
            $('.natural_table').css('display','none');
          }
          
        }
      });

    });
</script>


<script type="text/javascript">
    $('.new_policy').on('change',function(){
        var getvalue = $(this).val();
        var complaintId = '{{@$id}}';
        $.ajax({
        url:'{{route('status.update.new-policy.resource')}}',
        type:'GET',
        data:{getvalue:getvalue,complaintId:complaintId},
        success:function(data){
          console.log(data);
          if(getvalue=="Y")
          {
            $('.new_policy_table').css('display','block');
          }else{
            $('.new_policy_table').css('display','none');
          }
          
        }
      });

    });
</script>


<script type="text/javascript">
    $('.political').on('change',function(){
        var getvalue = $(this).val();
        var complaintId = '{{@$id}}';
        $.ajax({
        url:'{{route('status.update.political.resource')}}',
        type:'GET',
        data:{getvalue:getvalue,complaintId:complaintId},
        success:function(data){
          console.log(data);
          if(getvalue=="Y")
          {
            $('.political_table').css('display','block');
          }else{
            $('.political_table').css('display','none');
          }
          
        }
      });

    });
</script>

<script type="text/javascript">
    $('.personnel').on('change',function(){
        var getvalue = $(this).val();
        var complaintId = '{{@$id}}';
        $.ajax({
        url:'{{route('status.update.personnel.resource')}}',
        type:'GET',
        data:{getvalue:getvalue,complaintId:complaintId},
        success:function(data){
          console.log(data);
          if(getvalue=="Y")
          {
            $('.personnel_table').css('display','block');
          }else{
            $('.personnel_table').css('display','none');
          }
          
        }
      });

    });
</script>


<script type="text/javascript">
    $('.procurement_good').on('change',function(){
        var getvalue = $(this).val();
        var complaintId = '{{@$id}}';
        $.ajax({
        url:'{{route('status.update.procurementgood.resource')}}',
        type:'GET',
        data:{getvalue:getvalue,complaintId:complaintId},
        success:function(data){
          console.log(data);
          if(getvalue=="Y")
          {
            $('.procurement_good_table').css('display','block');
          }else{
            $('.procurement_good_table').css('display','none');
          }
          
        }
      });

    });
</script>


<script type="text/javascript">
    $('.service').on('change',function(){
        var getvalue = $(this).val();
        var complaintId = '{{@$id}}';
        $.ajax({
        url:'{{route('status.update.service.resource')}}',
        type:'GET',
        data:{getvalue:getvalue,complaintId:complaintId},
        success:function(data){
          console.log(data);
          if(getvalue=="Y")
          {
            $('.service_table').css('display','block');
          }else{
            $('.service_table').css('display','none');
          }
          
        }
      });

    });
</script>


<script type="text/javascript">
    $('.land').on('change',function(){
        var getvalue = $(this).val();
        var complaintId = '{{@$id}}';
        $.ajax({
        url:'{{route('status.update.land.resource')}}',
        type:'GET',
        data:{getvalue:getvalue,complaintId:complaintId},
        success:function(data){
          console.log(data);
          if(getvalue=="Y")
          {
            $('.land_table').css('display','block');
          }else{
            $('.land_table').css('display','none');
          }
          
        }
      });

    });
</script>
@endsection