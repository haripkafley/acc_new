<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Receipt of Document</h2>
             
      <div class="col-sm-12">

                        <div class = "card-body">
                            
                            <table id = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Receipt Date</th>
                                        <th>Receipt Time</th>
                                        <th>Particular</th>
                                        <th>File No</th>
                                        <th>No Of Pages</th>
                                        <th>Validity Of Document</th>
                                        <th>Received From</th>
                                        <th>Received By</th>
                                        <th>Status</th>
                                                  
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    <tr>
                                        
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->time }}</td>
                                        <td>@if(@$data->particular=="F") File @else Travel Document @endif</td>
                                        <td>{{ $data->document_no }}</td>
                                        <td>{{ $data->no_pages }}</td>
                                        <td>{{ $data->validity_of_document }}</td>
                                        <td>{{ $data->received_from }}</td>
                                        <td>{{ $data->received_by }}</td>
                                        <td>
                                           {{ $data->status }}

                                        </td>
                                        
                                    </tr>
                                    
                                                  
                               </tbody>
                            </table>
                        </div>

 </div>
</div>

</body>
</html>
