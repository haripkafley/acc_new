
	<ul class="tabs" >
		<li class="tab">
			<a href="{{route('viewarrest', $casenoid)}}" class="tab {{ 'investigator/arrest/'.$casenoid == request()->path() ? 'active' : 'hov' }}" >Arrest </a>
		</li>
		<li class="tab">
			<a href="{{route('viewdetention', $casenoid)}}" class="tab  {{ 'investigator/detention/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}">Detention</a>
		</li>
		<!-- <li class="tab">
			<a class="tab {{ 'investigator/freeze/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}" href="{{route('viewfreeze', $casenoid)}}">Freeze and Unfreeze</a>
		</li>
		<li class="tab">
			<a class="tab {{'investigator/suspension/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}" href="{{route('viewsuspension', $casenoid)}}">Suspension</a>
		</li> -->
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
