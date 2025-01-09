

	<ul class="tabs"  >
		<li class="tab">
			<a href="{{	route('viewinterviewplan', $casenoid)}}" class="tab {{ 'investigator/interviewplan/'.$casenoid == request()->path() ? 'active' : 'hov' }}" >Plan</a>
		</li>
		<li class="tab">
			<a href="{{	route('viewsummonorder', $casenoid)}}" class="tab  {{ 'investigator/summonorder/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}">Summon Order</a>
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
