@foreach($suspensiondtls as $dtls)
@if($dtls->suspension_type == "Public")
<div class= "row"> 
    <div class   = "col-md-3">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">CID&nbsp;</label><br>
                {{ $dtls->identification_no}}
        </div>
    </div>
    <div class   = "col-md-3">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Name&nbsp;</label>
            <br>
            {{ $dtls->name}}
        </div>
    </div>
    <div class   = "col-md-3">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Employee No&nbsp;</label>
                <br>
            {{ $dtls->employeeno}}
        </div>
    </div>

        <div class   = "col-md-3">
            <div class  = "form-group">
                <label for   = "exampleInputEmail1">Date of Appointment&nbsp;</label>
                    <br>
            {{ \Carbon\Carbon::parse($dtls->dateofappointment)->format('d/m/Y')}}
            </div>
        </div>
    </div>
        
    <div class= "row"> 
        <div class   = "col-md-3">
            <div class  = "form-group">
                <label for   = "exampleInputEmail1">Suspended On&nbsp;</label>
                <br>
                    {{ \Carbon\Carbon::parse($dtls->suspended_on)->format('d/m/Y')}}
            </div>
        </div>
        <div class   = "col-md-3">
            <div class  = "form-group">
                <label for   = "exampleInputEmail1">Reason for Suspension&nbsp;</label>
                <br>
                    {{ $dtls->suspension_reason}}
            </div>
        </div>
        
    </div>
    
    
</div>

@endif
@if($dtls->suspension_type == "Business")
<br>
<div class= "row"> 
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">License No&nbsp;</label>
            <br>
            {{ $dtls->identification_no }}
        </div>
    </div>
    <div class   = "col-md-4">
            <div class  = "form-group">
                <label for   = "exampleInputEmail1">Business Name&nbsp;</label><br>
                {{ $dtls->name }}
            </div>
        </div>
        <div class   = "col-md-4">
            <div class  = "form-group">
                <label for   = "exampleInputEmail1">Location&nbsp;</label><br>
                {{ $dtls->business_location }}
            </div>
        </div>
</div>
    <div class= "row"> 
        <div class   = "col-md-4">
            <div class  = "form-group">
                <label for   = "exampleInputEmail1">Owners&nbsp;</label><br>
                {{ $dtls->business_owner }}
            </div>
        </div>
    
        <div class   = "col-md-4">
            <div class  = "form-group">
                <label for   = "exampleInputEmail1">License Issue Date&nbsp;</label><br>
                    {{ $dtls->business_license_issue_date }}
            </div>
        </div>
        <div class   = "col-md-4">
            <div class  = "form-group">
                <label for   = "exampleInputEmail1">License Expiry Date&nbsp;</label><br>
                    {{ $dtls->business_license_expiry_date }}
            </div>
        </div>
    </div>
    <div class= "row">
        <div class   = "col-md-12">
            <div class  = "form-group">
                <label for   = "exampleInputEmail1">Activity&nbsp;</label><br>
                {{ $dtls->business_activity }}
            </div>
        </div>
    </div>
    
    @endif
    @endforeach