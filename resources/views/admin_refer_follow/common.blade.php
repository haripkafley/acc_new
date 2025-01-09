        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('case.administrative.referrals.followup.list')) active btn btn-info @endif"  href="{{route('case.administrative.referrals.followup.list',['id'=>@$case_id])}}">Review by Agency</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('case.administrative.referrals.followup.action.taken.by.agency')) active btn btn-info @endif"  href="{{route('case.administrative.referrals.followup.action.taken.by.agency',['id'=>@$case_id])}}">Action Taken by Agency </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('case.administrative.referrals.followup.own-action-taken')) active btn btn-info @endif"  href="{{route('case.administrative.referrals.followup.own-action-taken',['id'=>@$case_id])}}">Own Action</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('case.administrative.referrals.followup.further-action-taken')) active btn btn-info @endif"  href="{{route('case.administrative.referrals.followup.further-action-taken',['id'=>@$case_id])}}">Further Action </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('case.administrative.referrals.followup.close-action')) active btn btn-info @endif"  href="{{route('case.administrative.referrals.followup.close-action',['id'=>@$case_id])}}">Close </a>
        </li>
</ul>