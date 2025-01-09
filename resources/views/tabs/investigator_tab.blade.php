<link rel ="stylesheet" href="https://fonts.googleapis.com/css2?family=Product+Sans&display=swap" >

	<ul class="nav nav-tabs" style="font-family:Product Sans;font-size:13px; background-color: #5E6366">
		<li class="nav-item">
			<a href="{{route('casesummary', $casenoid)}}" class="nav-link {{ 'investigator/casesummary/'.$casenoid == request()->path() ? 'active' : 'hov' }}" >Allegation Details</a>
		</li>
		<li class="nav-item">
			<a href="{{route('viewinvestigationplan', $casenoid)}}" class="nav-link  {{ 'investigator/investigationplan/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}">Investigation Plan</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{'investigator/person/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}" href="{{ route('viewperson', $casenoid)}}">Entities</a>
		</li>
		<li class="nav-item">
			<a href="{{route('viewinterviewplan', $casenoid)}}" class="nav-link  {{ 'investigator/interviewplan/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}">Interview</a>
		</li>
		
		<li class="nav-item">
			<a class="nav-link {{'investigator/idiary/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}" href="{{route('viewidiary', $casenoid)}}">iDiary</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{'investigator/caseevent/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}" href="{{route('viewcaseevent', $casenoid)}}">Case Event</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{'investigator/arrest/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}" href="{{route('viewarrest', $casenoid)}}">Arrest & Detention</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{'investigator/search/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}" href="{{route('viewsearch', $casenoid)}}">Search & Seizure</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{'investigator/evidence/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}" href="{{route('viewevidence', $casenoid)}}">Exhibits</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{'investigator/files/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}" href="{{route('viewfiles', $casenoid)}}">Files</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{'investigator/reports/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}" href="{{route('viewreports', $casenoid)}}">Reports</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{'investigator/linkanalysis/'.$casenoid == request()->path() ? 'disabled active' : 'hov' }}" href="{{route('viewlinkanalysis', $casenoid)}}">Link Analysis</a>
		</li>
	</ul>
