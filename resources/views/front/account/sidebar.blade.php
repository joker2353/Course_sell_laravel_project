<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">
         @if(Auth::user()->image!='')
         <img src="{{ asset('profile_pic/thumb/'.Auth::user()->image) }}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
         @else
         <img src="{{ asset('assets/images/avatar7.png') }}" alt="avatar"  class="rounded-circle img-fluid" style="width: 150px;">
         @endif

        
        <h5 class="mt-3 pb-0">{{ Auth::user()->name }}</h5>
        <p class="text-muted mb-1 fs-6">{{ Auth::user()->designation }}</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
        </div>
    </div>
</div>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('account.profile') }}">Account Settings</a>
            </li>
            @if(Auth::user()->changeRole==0 && Auth::user()->role!='admin' )
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.pubreq') }}">Request for pulisher</a>
            </li>
            @endif
             
            @if(Auth::user()->role=='publisher')
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.createCourse') }}">Create a Courses</a>
            </li>
            @endif
            
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.myCourses') }}">My Course</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.enrollment') }}">Enrolled Courses</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.savedCourse') }}">Course Wishlist</a>
            </li>  
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.logout') }}">Log Out</a>
            </li>                                                         
        </ul>
    </div>
</div>