        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('systemic.view.chief.follow.view')) active btn btn-info @endif"  href="{{route('systemic.view.chief.follow.view',['id'=>@$case_id])}}">Review by Agency</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('systemic.view.chief.follow.view.action.taken.agency')) active btn btn-info @endif"  href="{{route('systemic.view.chief.follow.view.action.taken.agency',['id'=>@$case_id])}}">Action Taken by Agency </a>
        </li>

        

        <li class="nav-item">
          <a class="nav-link @if(Route::is('systemic.view.chief.follow.view.futher.action')) active btn btn-info @endif"  href="{{route('systemic.view.chief.follow.view.futher.action',['id'=>@$case_id])}}">Further Action </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('systemic.view.chief.follow.view.close.action')) active btn btn-info @endif"  href="{{route('systemic.view.chief.follow.view.close.action',['id'=>@$case_id])}}">Close </a>
        </li>
</ul>