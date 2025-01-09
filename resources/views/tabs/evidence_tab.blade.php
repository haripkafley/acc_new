
	<ul class="tabs" >
		<li class="tab">
			<a href="{{route('viewevidence', $casenoid)}}" class="tab {{ 'investigator/evidence/'.$casenoid  == request()->path() ? 'active' : 'hov' }}" >Exhibit Register</a>
		</li>
		<li class="tab">
			<a href="{{route('viewevidencematrix', $casenoid)}}" class="tab  {{ 'investigator/evidencematrix/'.$casenoid  == request()->path() ? 'active disabled' : 'hov' }}">Evidence Matrix</a>
		</li>
		<li class="tab">
			<a href="{{route('viewevidencesummary', $casenoid)}}" class="tab  {{ 'investigator/evidencesummary/'.$casenoid  == request()->path() ? 'active disabled' : 'hov' }}">Charge Summary</a>
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

	

