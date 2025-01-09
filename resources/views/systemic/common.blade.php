        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('systemic.recommendations.follow.view')) active btn btn-info @endif"  href="{{route('systemic.recommendations.follow.view',['id'=>@$case_id])}}">Review by Agency</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('systemic.recommendations.follow.action.taken.agency')) active btn btn-info @endif"  href="{{route('systemic.recommendations.follow.action.taken.agency',['id'=>@$case_id])}}">Action Taken by Agency </a>
        </li>

        

        <li class="nav-item">
          <a class="nav-link @if(Route::is('systemic.recommendations.follow.further.action')) active btn btn-info @endif"  href="{{route('systemic.recommendations.follow.further.action',['id'=>@$case_id])}}">Further Action </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('systemic.recommendations.follow.close.model')) active btn btn-info @endif"  href="{{route('systemic.recommendations.follow.close.model',['id'=>@$case_id])}}">Close </a>
        </li>
</ul>