        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.disposal.auction.details')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.disposal.auction.details',['id'=>@$id])}}">Auction</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.disposal.return.details')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.disposal.return.details',['id'=>@$id])}}">Return / Handing Over of seized Item </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.disposal.escrow.accused.details')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.disposal.escrow.accused.details',['id'=>@$id])}}">ESCROW - Accused</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.get-assign-official-seized-properties.disposal.escrow.agency.details')) active btn btn-info @endif"  href="{{route('manage.get-assign-official-seized-properties.disposal.escrow.agency.details',['id'=>@$id])}}">ESCROW - Agency</a>
        </li>

        
</ul>