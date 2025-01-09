        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.assign.judgement.legal.appraisal.page')) active btn btn-info @endif"  href="{{route('get.assign.judgement.legal.appraisal.page',['id'=>@$id])}}">Appraisal Details</a>
        </li>

        @if(@$decision_data->decision=="Appeal")
        <li class="nav-item">
          <a class="nav-link @if(Route::is('get.assign.judgement.legal.appraisal.appeal.page')) active btn btn-info @endif"  href="{{route('get.assign.judgement.legal.appraisal.appeal.page',['id'=>@$id])}}"> Appeal Details</a>
        </li>
        @endif

</ul>