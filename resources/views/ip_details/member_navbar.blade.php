        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('member.get.information.report.assignment.details.project')) active btn btn-info @endif"  href="{{route('member.get.information.report.assignment.details.project',['id'=>@$id])}}">Intel Project Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('member.get.information.report.assignment.intel.plan') || Route::is('member.get.information.report.assignment.intel.plan.hypothesis')) active btn btn-info @endif"  href="{{route('member.get.information.report.assignment.intel.plan.hypothesis',['id'=>@$id])}}"> Intel Plan </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('member.get.information.report.assignment.sir.plan')) active btn btn-info @endif"  href="{{route('member.get.information.report.assignment.sir.plan',['id'=>@$id])}}">Source Information Report</a>
        </li>

        

        <li class="nav-item">
          <a class="nav-link @if(Route::is('member.get.information.report.assignment.intel.project.idiary.page')) active btn btn-info @endif"  href="{{route('member.get.information.report.assignment.intel.project.idiary.page',['id'=>@$id])}}">IDiary</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get.information.report.assignment.intel.event.plan')) active btn btn-info @endif"  href="{{route('manage.get.information.report.assignment.intel.event.plan',['id'=>@$id])}}"> Intel Event </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get.information.report.assignment.exhibit.plan')) active btn btn-info @endif"  href="{{route('manage.get.information.report.assignment.exhibit.plan',['id'=>@$id])}}"> Exhibit </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('member.get.information.report.assignment.entities.person.manage') || Route::is('member.get.information.report.assignment.entities.organization.manage') || Route::is('member.get.information.report.assignment.entities.asset.manage') ) active btn btn-info @endif"  href="{{route('member.get.information.report.assignment.entities.person.manage',['id'=>@$id])}}"> Entities </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get.information.report.assignment.tacktical.request')) active btn btn-info @endif"  href="{{route('manage.get.information.report.assignment.tacktical.request',['id'=>@$id])}}"> TI Request </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get.information.iprc.decision')) active btn btn-info @endif"  href="{{route('manage.get.information.iprc.decision',['id'=>@$id])}}"> IPRC </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('member.get.information.report.assignment.intel.project.comission.decision.page')) active btn btn-info @endif"  href="{{route('member.get.information.report.assignment.intel.project.comission.decision.page',['id'=>@$id])}}">Commission Meeting</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('member.get.information.report.assignment.intel.project.report.page')) active btn btn-info @endif"  href="{{route('member.get.information.report.assignment.intel.project.report.page',['id'=>@$id])}}"> Report</a>
        </li>

        <li class="nav-item">
          <a class="nav-link"  href="{{session('ip_back_url_indi')}}"> Back To Menu</a>
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

</ul>