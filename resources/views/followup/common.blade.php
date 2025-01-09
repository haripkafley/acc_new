        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.official.cases.followup.prosecutor.details')) active btn btn-info @endif"  href="{{route('get.official.cases.followup.prosecutor.details',['id'=>@$id])}}">Prosecutor Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.official.cases.followup.case-return-dropped-withdrawn')) active btn btn-info @endif"  href="{{route('get.official.cases.followup.case-return-dropped-withdrawn',['id'=>@$id])}}">Case Returned / Dropped / Withdrawn </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.official.cases.followup.jurisdiction')) active btn btn-info @endif"  href="{{route('get.official.cases.followup.jurisdiction',['id'=>@$id])}}">Case Jurisdiction </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.official.cases.followup.jurisdiction.details')) active btn btn-info @endif"  href="{{route('get.official.cases.followup.jurisdiction.details',['id'=>@$id])}}">Under Trial </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.official.cases.followup.jurisdiction.details.under.under.appeal')) active btn btn-info @endif"  href="{{route('get.official.cases.followup.jurisdiction.details.under.under.appeal',['id'=>@$id])}}">Under Under Trial </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.official.cases.followup.closure')) active btn btn-info @endif"  href="{{route('get.official.cases.followup.closure',['id'=>@$id])}}">Closure </a>
        </li>


        



        
      </ul>