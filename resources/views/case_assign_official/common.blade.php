        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('assign.official.case.view-details.followup')) active btn btn-info @endif"  href="{{route('assign.official.case.view-details.followup',['id'=>@$id])}}">Prosecutor Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('assign.official.case.view-details.followup.case-return-dropped-withdrawn')) active btn btn-info @endif"  href="{{route('assign.official.case.view-details.followup.case-return-dropped-withdrawn',['id'=>@$id])}}">Case Returned / Dropped / Withdrawn </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('assign.official.case.view-details.followup.case-juridiction')) active btn btn-info @endif"  href="{{route('assign.official.case.view-details.followup.case-juridiction',['id'=>@$id])}}">Case Jurisdiction </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('assign.official.case.view-details.followup.case-jurisdiction-details')) active btn btn-info @endif"  href="{{route('assign.official.case.view-details.followup.case-jurisdiction-details',['id'=>@$id])}}">Under Trial </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('assign.official.case.view-details.followup.under.under.trial')) active btn btn-info @endif"  href="{{route('assign.official.case.view-details.followup.under.under.trial',['id'=>@$id])}}">Under Under Trial </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('assign.official.case.view-details.followup.closure')) active btn btn-info @endif"  href="{{route('assign.official.case.view-details.followup.closure',['id'=>@$id])}}">Closure </a>
        </li>


        



        
      </ul>