        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.custody.details')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.custody.details',['id'=>@$id])}}">Storage - Properties</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.custody.details.cash.storage')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.custody.details.cash.storage',['id'=>@$id])}}">Storage - Cash </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.custody.details.maintenance-log')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.custody.details.maintenance-log',['id'=>@$id])}}">Maintenance Log</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.custody.details.chain')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.custody.details.chain',['id'=>@$id])}}">Chain of Custody</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.custody.details.valuation')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.custody.details.valuation',['id'=>@$id])}}">Valuation </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.custody.details.lease.hiring')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.custody.details.lease.hiring',['id'=>@$id])}}">Lease & Hiring </a>
        </li>
</ul>