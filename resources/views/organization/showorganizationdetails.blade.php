@foreach($orgdetailsshow as $org)
@if($org->organization_type == "Business")
<div class= "row"> 
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Business Name&nbsp;</label>
            <br>
                {{ $org->organization_name}}
                
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Location&nbsp;</label>
            <br>
                {{ $org->business_location }}
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Owners&nbsp;</label>
                <br>
                {{ $org->business_owner }}
        </div>
    </div>
</div>
<div class= "row"> 
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">License Issue Date&nbsp;</label>
                <br>
                {{ $org->business_license_issue_date }}
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">License Expiry Date&nbsp;</label>
                <br>
                {{ $org->business_license_expiry_date }}
        </div>
    </div>
</div>
<div class= "row">
    <div class   = "col-md-12">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Activity&nbsp;</label>
                <br>
                {{ $org->business_activity }}
        </div>
    </div>
</div>
<h4>Contact Details</h4>
<br>
<div class= "row"> 
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Contact Person&nbsp;</label>
                <br>
                {{ $org->contact_person }}
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;</label>
                <br>
                {{ $org->phone_no }}
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Email&nbsp;</label>
                <br>
                <br>
                @if($org->email =="")
                No Email Available
                @else
                {{ $org->email }}
                @endif
        </div>
    </div>
</div>
@endif
@if($org->organization_type == "Government")
<div class= "row"> 
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Parent Agency&nbsp;</label>
                <br>
                 <?php echo $key=DB::table('tbl_parentagencies_lookup')->where('parent_agency_id',$org->parent_agency)->value('parent_agency') ?> 
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Agency Name&nbsp;</label>
              <br>
              <?php echo $key=DB::table('tbl_agencynames_lookup')->where('agency_name_id',$org->organization_name)->value('agency_name') ?>  
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Location&nbsp;</label>
                <br>
                {{ $org->business_location }}
        </div>
    </div>
</div>

<h4>Contact Details</h4>
<br>
<div class= "row"> 
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Contact Person&nbsp;</label>
                <br>
                {{ $org->contact_person }}
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;</label>
                <br>
                {{ $org->phone_no }}
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Email&nbsp;</label>
                <br>
                @if($org->email =="")
                No Email Available
                @else
                {{ $org->email }}
                @endif
        </div>
    </div>
</div>
@endif
@if($org->organization_type == "Corporation")
<div class= "row"> 
    <div class   = "col-md-6">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Agency Name&nbsp;</label>
                <br>
                <?php echo $key=DB::table('tbl_agencynames_lookup')->where('agency_name_id',$org->organization_name)->value('agency_name') ?> 
        </div>
    </div>
    <div class   = "col-md-6">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Location&nbsp;</label>
                <br>
                {{ $org->business_location }}
        </div>
    </div>
</div>
<h4>Contact Details</h4>
<br>
<div class= "row"> 
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Contact Person&nbsp;</label>
                <br>
                {{ $org->contact_person }}
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Phone/Mobile Number&nbsp;</label>
                <br>
                {{ $org->phone_no }}
        </div>
    </div>
    <div class   = "col-md-4">
        <div class  = "form-group">
            <label for   = "exampleInputEmail1">Email&nbsp;</label>
                <br>
                @if($org->email =="")
                No Email Available
                @else
                {{ $org->email }}
                @endif

        </div>
    </div>
</div>
@endif
@endforeach