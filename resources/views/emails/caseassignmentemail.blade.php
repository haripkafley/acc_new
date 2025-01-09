
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel ="stylesheet" href="https://fonts.googleapis.com/css2?family=Product+Sans&display=swap" >
    <style>
        .card {
    background-color: #F3F3F3;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    margin: 0 auto;
    border: 1px solid #000000;
    padding: 20px;
}

.card-header {
    padding: 10px;
    max-width: 700px;
    text-align: center;
    margin-left: auto;
    margin-right: auto;
}

.card-body {
    border-top: 1px solid #000000;
    padding: 10px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.p {
    font-family: 'Product Sans', Arial, sans-serif;
    color: #000000;
    font-size: 13px;
}
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <font color='#007BFF' size="5.5" face="Product Sans">{{ $cardValue }}</font>
    </div>
    <div class="card-body">
        <p class="p">{{ $first }}</p>
         <p class="p">{{ $second }}</p>
          <p class="p">&nbsp;<b>{{ $third }}</b></p>
           <p class="p">&nbsp;<b>{{ $fourth }}</b></p>
            <p class="p">{{ $fifth }}</p>
    <br>
        <div style="text-align: center;">
            <a href="{{ url('http://127.0.0.1:8000/') }}" class="btn btn-primary" style="border-radius: 5px; display: inline-block; padding: 10px 20px; text-decoration: none; background-color: #007bff; color: #ffffff;">Go to CIMS login page</a>
        </div>
    </div>
</div>
   
    
</body>
</html>