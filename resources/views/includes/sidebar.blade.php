<ul class="list-group">
    <li class="list-group-item">
    	<a href="{{ route('subList', array('lng' => 'eng')) }}">
    		<i class="glyphicon glyphicon-chevron-right"></i>
    		<span>All Subject List (English)</span>
    	</a>
    </li>
    <li class="list-group-item">
    	<a href="{{ route('subList', array('lng' => 'mth')) }}">
    		<i class="glyphicon glyphicon-chevron-right"></i>
    		<span>All Subject List (Bengali)</span>
    	</a>
    </li>
    <li class="list-group-item">
    	<a href="{{ route('exmHis') }}">
    		<i class="glyphicon glyphicon-chevron-right"></i>
    		<span>My Exam History</span>
    	</a>
    </li>
    <!--li class="list-group-item">
    	<a href="{{ route('scrCrds') }}">
    		<i class="glyphicon glyphicon-chevron-right"></i>
    		<span>My Score Cards</span>
    	</a>
    </li-->
    <li class="list-group-item">
    	<a href="{{ route('guestProfile') }}">
    	<i class="glyphicon glyphicon-chevron-right"></i>
    	<span>My Profile</span>
    	</a>
    </li>
    <li class="list-group-item">
    	<a href="{{ route('guestProfileCngPwd') }}">
    		<i class="glyphicon glyphicon-chevron-right"></i>
    		<span>Change Password</span>
    	</a>
    </li>
</ul>