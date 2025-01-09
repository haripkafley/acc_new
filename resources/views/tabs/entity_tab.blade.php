

	<ul class="tabs" >
		<li class="tab">
			<a href="{{	route('viewperson', $casenoid)}}" class="tab {{ 'investigator/person/'.$casenoid == request()->path() ? 'active' : 'hov' }}" >Person</a>
		</li>
		<li class="tab">
			<a href="{{	route('vieworganization', $casenoid)}}" class="tab  {{ 'investigator/organization/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}">Organization</a>
		</li>
		<li class="tab">
			<a class="tab {{ 'investigator/asset/'.$casenoid == request()->path() ? 'active disabled' : 'hov' }}" href="{{ route('viewasset', $casenoid)}}">Asset</a>
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
