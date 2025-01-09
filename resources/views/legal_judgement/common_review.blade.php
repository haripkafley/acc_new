        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.assign.judgement.legal.review.legal.page')) active btn btn-info @endif"  href="{{route('get.assign.judgement.legal.review.legal.page',['id'=>@$id])}}">Review Details</a>
        </li>

        @if(@$decision_data->review_judgement=="Convicted")
        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.assign.judgement.legal.review.legal.convicted.page')) active btn btn-info @endif"  href="{{route('get.assign.judgement.legal.review.legal.convicted.page',['id'=>@$id])}}"> Convicted Details</a>
        </li>
        @endif

</ul>