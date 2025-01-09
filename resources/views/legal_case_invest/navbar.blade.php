        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.seizures.premises')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.seizures.premises',['id'=>@$id])}}">Search and Seizures of Premises</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.seizures.monitary.instruments')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.seizures.monitary.instruments',['id'=>@$id])}}"> Search and Seizures of Monetary Instruments</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.seizures.immovable.properties')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.seizures.immovable.properties',['id'=>@$id])}}">Freezing of Immovable Properties</a>
        </li>
        

        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.seizures.movable.properties')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.seizures.movable.properties',['id'=>@$id])}}"> Seizure of Movable Properties</a>
        </li>

        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.seizures.travel.document')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.seizures.travel.document',['id'=>@$id])}}"> Impounding of travel Documents</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.seizures.arrest.case')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.seizures.arrest.case',['id'=>@$id])}}"> Arrests</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.remand.release')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.remand.release',['id'=>@$id])}}"> Remand and Release</a>
        </li>

         <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.bail.and.bound')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.bail.and.bound',['id'=>@$id])}}"> Bail and Bond</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.suspension.public.servents')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.suspension.public.servents',['id'=>@$id])}}"> Suspension of Public Servants</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.suspension.suspension.license')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.suspension.suspension.license',['id'=>@$id])}}">Suspension / Prohibition of Business License</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.immunity.case')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.immunity.case',['id'=>@$id])}}">Immunity</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('legal.case.investigation.seracg.plea.bargain')) active btn btn-info @endif"  href="{{route('legal.case.investigation.seracg.plea.bargain',['id'=>@$id])}}">Plea Bargain</a>
        </li>
       

</ul>