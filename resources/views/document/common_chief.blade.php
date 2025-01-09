        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.seized.document.chief.document.custody.view')) active btn btn-info @endif"  href="{{route('manage.seized.document.chief.document.custody.view',['id'=>@$case_id])}}">Storage</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.seized.document.chief.document.chain.custody.view')) active btn btn-info @endif"  href="{{route('manage.seized.document.chief.document.chain.custody.view',['id'=>@$case_id])}}">Chain of Custody</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.seized.document.chief.document.archiving.view')) active btn btn-info @endif"  href="{{route('manage.seized.document.chief.document.archiving.view',['id'=>@$case_id])}}">Archiving</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.seized.document.chief.document.renewal.view')) active btn btn-info @endif"  href="{{route('manage.seized.document.chief.document.renewal.view',['id'=>@$case_id])}}">Renewal of Documents</a>
        </li>

        
</ul>