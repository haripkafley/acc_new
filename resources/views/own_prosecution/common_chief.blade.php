        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.own.prosecution.chief.chamber.view')) active btn btn-info @endif"  href="{{route('manage.own.prosecution.chief.chamber.view',['id'=>@$data->id])}}">Chamber Hearing</a>
        </li>

        @if(@$data->own_status=="Admitted")
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.own.prosecution.chief.admitted.view')) active btn btn-info @endif"  href="{{route('manage.own.prosecution.chief.admitted.view',['id'=>@$data->id])}}"> Admitted </a>
        </li>
        @endif

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.own.prosecution.chief.prosecution.status.view')) active btn btn-info @endif"  href="{{route('manage.own.prosecution.chief.prosecution.status.view',['id'=>@$data->id])}}">Status Of Prosecution</a>
        </li>

</ul>