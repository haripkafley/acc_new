        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details',['id'=>@$id])}}">Intel Project Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.plan.intel') || Route::is('manage.ip.lists.head.chief.details.hypothesis')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.hypothesis',['id'=>@$id])}}"> Intel Plan</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.plan.sir')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.plan.sir',['id'=>@$id])}}">Source Information Report</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.idiary.intel')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.idiary.intel',['id'=>@$id])}}">IDiary</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.event.intel')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.event.intel',['id'=>@$id])}}">Intel Event</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.exhibit.intel')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.exhibit.intel',['id'=>@$id])}}"> Exhibit </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.entities.intel') || Route::is('manage.ip.lists.head.chief.details.entities.intel.organization') || Route::is('manage.ip.lists.head.chief.details.entities.intel.asset') ) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.entities.intel',['id'=>@$id])}}"> Entities </a>
        </li>


        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.tacktical.request')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.tacktical.request',['id'=>@$id])}}"> TI Request </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.iprc.decision.view')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.iprc.decision.view',['id'=>@$id])}}"> IPRC </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.commission.details')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.commission.details',['id'=>@$id])}}">Commission Meeting</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.ip.lists.head.chief.details.commission.details.project_report')) active btn btn-info @endif"  href="{{route('manage.ip.lists.head.chief.details.commission.details.project_report',['id'=>@$id])}}"> Report</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{session('ip_back_url')}}"> Back To Menu</a>
        </li>
</ul>

@php
$from = Carbon\Carbon::parse(@$data->received_date);
$to = Carbon\Carbon::now();
$days =  $from->diffInDays($to);


$from_start = DB::table('ir_form_team_member')->where('ir_id',@$data->id)->orderBy('id','asc')->first();
$from_work = Carbon\Carbon::parse($from_start->created_at);
$to_work = Carbon\Carbon::now();
$days_work =  $to_work->diffInWeekdays($from_work);
$teamleader = \App\Models\Dare\IrTeamMember::where('ir_id',@$data->id)->where('role','TL')->where('coi_status','N')->get();
$members = \App\Models\Dare\IrTeamMember::where('ir_id',@$data->id)->where('role','M')->where('coi_status','N')->get();
$legal = \App\Models\Dare\IrTeamMember::where('ir_id',@$data->id)->where('role','LR')->where('coi_status','N')->get();
// dd($teamleader);
@endphp

<ul class="nav nav-pills mb-3 shadow-sm">
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">IR No : {{@$data->ir_no}}</li> 
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| IP Title : {{@$data->title}}</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| Running Days : {{@$days}}</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| Working Days : {{@$days_work}}</li> 
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| Assigned Date : {{date('d-m-Y', strtotime($from_start->created_at));}}</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| Team Leader : @foreach(@$teamleader as $val) {{@$val->user_details->name}} , @endforeach</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;"> | Members : @foreach(@$members as $val) {{@$val->user_details->name}} , @endforeach</li> 
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;"> | Legal Representative : @foreach(@$legal as $val) {{@$val->user_details->name}} , @endforeach</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| <a href="{{route('information.report.form.team.member',@$data->id)}}" class="btn btn-success btn-xs">+Add Member</a></li>

</ul>