<ul class="tabs">
	<li class="tab">
		<a  href="{{route('viewgeneral')}}" class="tab {{ 'director/general' == request()->path() ? 'active' : 'hov' }}">General</a>
	</li>
	<li class="tab">
		<a href="{{route('viewallegation')}}" class="tab  {{ 'director/allegation' == request()->path() ? ' active' : 'hov' }}">Allegations</a>
	</li>
	<li class="tab">
		<a href="{{route('viewsubject')}}" class="tab  {{ 'director/subject' == request()->path() ? 'disabled active' : 'hov' }}">Subject</a>
	</li>
	<li class="tab">
		<a href="{{route('viewcoiaddcase')}}" class="tab  {{ 'director/coi' == request()->path() ? 'disabled active' : 'hov' }}">COI</a>
	</li>
	<li class="tab">
		<a href="{{route('viewassign')}}" class="tab  {{ 'director/assign' == request()->path() ? 'disabled active' : 'hov' }}">Assign</a>
	</li>
</ul>

<style>
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