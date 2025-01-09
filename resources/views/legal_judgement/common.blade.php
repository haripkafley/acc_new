        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('judgement.chief.list.judgement.details')) active btn btn-info @endif"  href="{{route('judgement.chief.list.judgement.details',['id'=>@$id])}}">Judgement Details</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('judgement.chief.list.judgement.details.review.page')) active btn btn-info @endif"  href="{{route('judgement.chief.list.judgement.details.review.page',['id'=>@$id])}}"> Review Details</a>
        </li>

        @if(@$data->review_judgement=="Convicted")
        <li class="nav-item">
          <a class="nav-link @if(Route::is('judgement.chief.list.judgement.details.convicted.page')) active btn btn-info @endif"  href="{{route('judgement.chief.list.judgement.details.convicted.page',['id'=>@$id])}}">Conviction Details</a>
        </li>
        @endif

        <li class="nav-item">
          <a class="nav-link @if(Route::is('judgement.chief.list.judgement.details.appraisal.page')) active btn btn-info @endif"  href="{{route('judgement.chief.list.judgement.details.appraisal.page',['id'=>@$id])}}"> Appraisal</a>
        </li>

        @if(@$decision_data->decision=="Appeal")
        <li class="nav-item">
          <a class="nav-link @if(Route::is('judgement.chief.list.judgement.details.appeal.page')) active btn btn-info @endif"  href="{{route('judgement.chief.list.judgement.details.appeal.page',['id'=>@$id])}}"> Appraisal Appeal</a>
        </li>
        @endif

</ul>