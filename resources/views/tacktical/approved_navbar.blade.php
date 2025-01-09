<ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.head.approved.surveillance-pending') || Route::is('tacktical.inteligence.autorization.head.approved.surveillance-ongoing') || Route::is('tacktical.inteligence.autorization.head.rejected.surveillance') || Route::is('tacktical.inteligence.autorization.head.deferred.surveillance') || Route::is('tacktical.inteligence.autorization.head.complete.surveillance') ) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.head.approved.surveillance-pending')}}">Surveillance</a>
                                    </li>

                                    <li class="nav-item">
                                      <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.head.approved.information-gathering-pending')||Route::is('tacktical.inteligence.autorization.head.approved.information-gathering-ongoing')  || Route::is('tacktical.inteligence.autorization.head.rejected.information-gathering') || Route::is('tacktical.inteligence.autorization.head.deferred.information-gathering') || Route::is('tacktical.inteligence.autorization.head.comeplete.information-gathering')) active btn btn-info @endif"  href="{{route('tacktical.inteligence.autorization.head.approved.information-gathering-pending')}}"> Information Gathering</a>
                                    </li>
</ul>