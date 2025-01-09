

	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="{{route('viewarrest', $casenoid)}}" class="nav-link {{ 'investigator/arrest/'.$casenoid == request()->path() ? 'active' : 'hov' }}" >Arrest and Detention</a>
		</li>
		<li class="nav-item">
			<a href="{{route('viewsearch', $casenoid)}}" class="nav-link  {{ 'investigator/searchandseizure/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}">Search and Seizure</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{ 'investigator/freeze/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}" href="{{route('viewfreeze', $casenoid)}}">Freeze and Unfreeze</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{'investigator/suspension/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}" href="{{route('viewsuspension', $casenoid)}}">Suspension</a>
		</li>
	</ul>
