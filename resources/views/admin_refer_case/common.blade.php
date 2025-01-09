        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('administrative-referrals.chief-view-cases.followup.view')) active btn btn-info @endif"  href="{{route('administrative-referrals.chief-view-cases.followup.view',['id'=>@$case_id])}}">Review by Agency</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('administrative-referrals.chief-view-cases.followup.action.taken.by.agency')) active btn btn-info @endif"  href="{{route('administrative-referrals.chief-view-cases.followup.action.taken.by.agency',['id'=>@$case_id])}}">Action Taken by Agency </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('administrative-referrals.chief-view-cases.followup.own.action')) active btn btn-info @endif"  href="{{route('administrative-referrals.chief-view-cases.followup.own.action',['id'=>@$case_id])}}">Own Action</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('administrative-referrals.chief-view-cases.followup.futher.action')) active btn btn-info @endif"  href="{{route('administrative-referrals.chief-view-cases.followup.futher.action',['id'=>@$case_id])}}">Further Action </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('administrative-referrals.chief-view-cases.followup.closed')) active btn btn-info @endif"  href="{{route('administrative-referrals.chief-view-cases.followup.closed',['id'=>@$case_id])}}">Close </a>
        </li>
</ul>