<ul class="tabs">
    <li class="tab">
			<a href="{{route('viewinvestigationplan', $casenoid)}}" class="tab {{ 'investigator/investigationplan/'.$casenoid == request()->path() ? 'active' : 'hov' }}" >General</a>
	</li>
	<li class="tab">
			<a href="{{route('viewhypo', $casenoid)}}" class="tab  {{ 'investigator/hypothesisandevidence/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}">Case Hypothesis</a>
	</li>
	<li class="tab">
			<a class="tab {{ 'investigator/actionplan/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}" href="{{route('viewactionplan', $casenoid)}}">Action Plan</a>
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
	
