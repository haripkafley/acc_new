        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
        
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.form')) active btn btn-info @endif"  href="{{route('manage.information.report.form')}}">Pending IR</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.form.upgrade.assignment')) active btn btn-info @endif"  href="{{route('manage.information.report.form.upgrade.assignment')}}"> Intel Project</a>
        </li>

       
        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.form.deffer.assignment')) active btn btn-info @endif"  href="{{route('manage.information.report.form.deffer.assignment')}}">Deffered</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.form.drop.assignment')) active btn btn-info @endif"  href="{{route('manage.information.report.form.drop.assignment')}}">Dropped</a>
        </li>

        <li class="nav-item">
          <a class="nav-link @if(Route::is('manage.information.report.form.share.assignment')) active btn btn-info @endif"  href="{{route('manage.information.report.form.share.assignment')}}">Shared</a>
        </li>
       

        

</ul>