<ul class="tabs">
    <li class="tab">
			<a href="{{route('viewsearch', $casenoid)}}" class="tab {{ 'investigator/search/'.$casenoid == request()->path() ? 'active' : 'hov' }}" >Search</a>
	</li>
	<li class="tab">
			<a href="{{route('viewseizure', $casenoid)}}" class="tab  {{ 'investigator/seizure/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}">Seizure</a>
	</li>
	<li class="tab">
			<a class="tab {{ 'investigator/freeze/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}" href="{{route('viewfreeze', $casenoid)}}">Freeze</a>
	</li>
	<li class="tab">
			<a class="tab {{ 'investigator/suspension/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}" href="{{route('viewsuspension', $casenoid)}}">Suspension</a>
	</li>
</ul>

<style>
	.tabs 
	{
		margin-left: -43px;
	}
    .tab {
		display: inline-block;
		padding: 3px;
		margin-right: 3px;
		color: #555;
		text-decoration: none;
		font-family: Product Sans;
		border-bottom: 2px solid transparent;
		transition: border-bottom-color 0.3s ease;
		}

	.tab.active {
  		color: #000;
  		border-bottom-color: blue;
	}
</style>

	
