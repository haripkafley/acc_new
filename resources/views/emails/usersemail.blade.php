<!DOCTYPE html>
<html>
<head>
    <title>User Registration Successful</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $body }}</p>
   
     
<p><a href="{{ url('http://127.0.0.1:8000/createpassword?email=' . $email) }}" class="btn btn-warning">Click Here</a>


    <p>Thanks, CIMS</p>
</body>
</html> 