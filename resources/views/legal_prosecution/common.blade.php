        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('prosecution.legal.chief.list.view.details')) active btn btn-info @endif"  href="{{route('prosecution.legal.chief.list.view.details',['id'=>@$id])}}">Prosecution Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('prosecution.legal.chief.list.view.drop.view.details')) active btn btn-info @endif"  href="{{route('prosecution.legal.chief.list.view.drop.view.details',['id'=>@$id])}}"> Returned / Dropped / Withdrawn </a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('prosecution.legal.chief.list.view.review.oag.view.details')) active btn btn-info @endif"  href="{{route('prosecution.legal.chief.list.view.review.oag.view.details',['id'=>@$id])}}">Review</a>
        </li>

        


        



        
      </ul>