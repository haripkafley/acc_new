        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('own.prosecution.get.assign.official.case.status.update-view-page')) active btn btn-info @endif"  href="{{route('own.prosecution.get.assign.official.case.status.update-view-page',['id'=>@$data->id])}}">Chamber Hearing</a>
        </li>

        @if(@$data->own_status=="Admitted")
        <li class="nav-item">
          <a class="nav-link @if(Route::is('own.prosecution.get.assign.official.case.admitted.details')) active btn btn-info @endif"  href="{{route('own.prosecution.get.assign.official.case.admitted.details',['id'=>@$data->id])}}"> Admitted </a>
        </li>
        @endif

        <li class="nav-item">
          <a class="nav-link @if(Route::is('own.prosecution.get.assign.official.case.prosecution.status.page')) active btn btn-info @endif"  href="{{route('own.prosecution.get.assign.official.case.prosecution.status.page',['id'=>@$data->id])}}">Status Of Prosecution</a>
        </li>

</ul>