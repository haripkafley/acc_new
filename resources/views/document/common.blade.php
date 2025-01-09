        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.seized.document.get.official.case.storage')) active btn btn-info @endif"  href="{{route('manage.seized.document.get.official.case.storage',['id'=>@$data->id])}}">Storage</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.seized.document.get.official.case.chain-of-custody')) active btn btn-info @endif"  href="{{route('manage.seized.document.get.official.case.chain-of-custody',['id'=>@$data->id])}}">Chain of Custody</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.seized.document.get.official.archiving')) active btn btn-info @endif"  href="{{route('manage.seized.document.get.official.archiving',['id'=>@$data->id])}}">Archiving</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.seized.document.get.official.case.renewal')) active btn btn-info @endif"  href="{{route('manage.seized.document.get.official.case.renewal',['id'=>@$data->id])}}">Renewal of Documents</a>
        </li>

        
</ul>