<ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">

                                    @php
                                      $check = DB::table('tactical_inteligence')->where('id',$id)->first();
                                    @endphp
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head-details')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head-details',@$id)}}">Information Details</a>
                                    </li>


                                    @if($check->type_ti=="S")
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.si-plan.information.individual.page')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.si-plan.information.individual.page',@$id)}}"> SI Plan </a>
                                    </li>
                                    @else

                                     <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.commission.directives.individual.page')|| Route::is('tacktical.inteligence.autorization.tacktical.details.head.commission.directives.individual.page.activity')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.commission.directives.individual.page',@$id)}}"> IG Plan </a>
                                    </li>

                                    @endif


                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.source.information.own.page')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.source.information.own.page',@$id)}}"> Source Information Report (Head)</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.source.information.individual.page')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.source.information.individual.page',@$id)}}"> Source Information Report (Individual)</a>
                                    </li>


                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.log.sheet.individual.page')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.log.sheet.individual.page',@$id)}}"> Log Sheet</a>
                                    </li>


                                    {{-- @if($check->type_ti=="IG")

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.commission.directives.individual.page')|| Route::is('tacktical.inteligence.autorization.tacktical.details.head.commission.directives.individual.page.activity')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.commission.directives.individual.page',@$id)}}">Commission Directives</a>
                                    </li>

                                    @endif --}}

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.exhibit.individual.page')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.exhibit.individual.page',@$id)}}"> Exhibit</a>
                                    </li>

                                     <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page') || Route::is('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page.organisation') ) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.entity.individual.page',@$id)}}"> Entities</a>
                                    </li>

                                    {{-- <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.diary.information.own.page')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.diary.information.own.page',@$id)}}"> Diary (Head)</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.diary.information.individual.page')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.diary.information.individual.page',@$id)}}"> Diary (Individual)</a>
                                    </li> --}}

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.tacktical.details.head.report.information.individual.page')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.tacktical.details.head.report.information.individual.page',@$id)}}"> Report</a>
                                    </li>

    </ul>



 @php
   $tacktical_details = \App\Models\Ti\TackticalInteligence::where('id',$id)->first();
   $from = Carbon\Carbon::parse(@$tacktical_details->request_date);
   $to = Carbon\Carbon::now();
   $days =  $from->diffInDays($to);
   $assign_date = DB::table('tactical_inteligence_team_member')->where('tacktical_id',@$tacktical_details->id)->orderBy('id','asc')->first();
   if(@$assign_date=="")
   {
    $days_work = 0;
   }else{
    $days_work =  @$to->diffInWeekdays(@$assign_date->created_at);
   }
   

   $teamleader = \App\Models\Ti\TackticalMember::where('tacktical_id',@$tacktical_details->id)->where('role','TL')->where('coi_status','N')->get();
    $members = \App\Models\Ti\TackticalMember::where('tacktical_id',@$tacktical_details->id)->where('role','M')->where('coi_status','N')->get();
    $legal = \App\Models\Ti\TackticalMember::where('tacktical_id',@$tacktical_details->id)->where('role','LR')->where('coi_status','N')->get();
@endphp
   


  <ul class="nav nav-pills mb-3 shadow-sm">
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">Suspect Details : {{@$tacktical_details->suspect_details}}</li> 
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| SL NO : {{@$tacktical_details->sl_no}}</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| TI No : {{@$tacktical_details->si_ig_no}}</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| Running Days : {{@$days}}</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| Working Days : {{@$days_work}}</li> 
  @if(@$assign_date!="")
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| Assigned Date : {{date('d-m-Y', strtotime($assign_date->created_at));}}</li>
  @endif
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;">| Team Leader : @foreach(@$teamleader as $val) {{@$val->user_details->name}} , @endforeach</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;"> | Members : @foreach(@$members as $val) {{@$val->user_details->name}} , @endforeach</li> 
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;"> | Legal Representative : @foreach(@$legal as $val) {{@$val->user_details->name}} , @endforeach</li>
  <li class="nav-item" style="margin-left: 15px;font-weight: bolder;"> | <a href="{{route('tacktical.inteligence.autorization.form.assigning.team.members',@$tacktical_details->id)}}" class="btn btn-success btn-xs">+ Add Member</a></li>
</ul>