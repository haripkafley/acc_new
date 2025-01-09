        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> Person Involved List </div>

                        <div class = "card-body">
                            <h5>
                              <small>List of accused, witness(es) and complainant</small>
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>CID</th>
                                        <th>Other ID</th>
                                        <th>Category</th>
                                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$person->isNotEmpty())
                                    @foreach(@$person as $att)
                                    <tr>
                                        <td>{{ @$att->personID }}</td>
                                        <td>{{ @$att->fname }} {{ @$att->mname }} {{ @$att->lname }}</td>
                                        <td>{{ @$att->cid }}</td>
                                        <td>{{ @$att->otherIdentificationNo }}</td>
                                        <td>{{ @$att->categoryName }}</td>
                                       
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Person Involved Againt This Complaint</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>