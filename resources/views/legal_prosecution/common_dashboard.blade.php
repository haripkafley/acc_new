        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('prosecution.legal.list.my-dashboard.view.prosecution.details')) active btn btn-info @endif"  href="{{route('prosecution.legal.list.my-dashboard.view.prosecution.details',['id'=>@$id])}}">Prosecution Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('prosecution.legal.list.my-dashboard.view.case-return-dropped-withdrawn')) active btn btn-info @endif"  href="{{route('prosecution.legal.list.my-dashboard.view.case-return-dropped-withdrawn',['id'=>@$id])}}"> Returned / Dropped / Withdrawn </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('prosecution.legal.list.my-dashboard.view.review-case-lgeal')) active btn btn-info @endif"  href="{{route('prosecution.legal.list.my-dashboard.view.review-case-lgeal',['id'=>@$id])}}">Review</a>
        </li>

</ul>