@extends('layouts.app')
@section('main')
<section class="section-4 bg-2">    
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-8">
                @include('front.message')
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{ $course->title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i>Author: {{ $course->author }}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i>Duration: {{ $course->duration }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now">
                                    <a class="heart_mark" href="javascript:void(0)" onclick="saveJob({{ $course->id }})"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Course description</h4>
                            <p>{!! nl2br($course->description) !!} </p>
                        </div>
                        <div class="single_wrap">
                            <h4>Prerequisite</h4>
                           
                                {!! nl2br($course->prerequisite) !!}
                            
                        </div>
                        {{-- <div class="single_wrap">
                            <h4>Qualifications</h4>
                            
                                {!! nl2br($job-> qualifications) !!}
                            
                        </div> --}}
                        <div class="single_wrap">
                            <h4>Benefits</h4>
                            <p>{!! nl2br($course->benefits) !!}</p>
                        </div>
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                            {{-- <a href="#" class="btn btn-secondary">Save</a> --}}

                            @if(Auth::check())
                            <a href="#" onclick="saveCourse({{ $course->id }})" class="btn btn-primary">Save</a>
                            @else
                            <a href="javascript:void(0)" class="btn btn-primary disabled">Login to Save</a>
                            @endif

                            @if(Auth::check())
                            <a href="#" onclick="applyCourse({{ $course->id }})" class="btn btn-primary">Apply</a>
                            @else
                            <a href="javascript:void(0)" class="btn btn-primary disabled">Login to Apply</a>
                            @endif
                            
                            
                            
                        </div>
                    </div>
                </div>
                
                @if(Auth::user())
                @if(Auth::user()->id==$course->user_id)

                <div class="card shadow border-0 mt-4">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                        <h4>Enrollment</h4>
                                </div>
                            </div>
                            <div class="jobs_right">
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                       <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Enrolled date</th>
                        </tr>

                           @if($apps->isNotEmpty())
                           @foreach($apps as $app)

                           <tr>
                            <td>{{ $app->user->name }}</td>
                            <td>{{ $app->user->email }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($app->applied_date)->format('d M, Y') }}
                            </td>
                        </tr>

                           @endforeach
                           @endif

                        
                       </table>
                    </div>
                </div>
            @endif
            @endif
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Course Summery</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>{{ \Carbon\Carbon::parse($course->created_at)->format('d M, Y') }}</span></li>
                                <li>Seat: <span>{{ $course->seat }}</span></li>
                                <li>Price: <span>{{ $course->price }}</span></li>
                                <li>Duration: <span>{{ $course->duration }}</span></li>
                                <li>Author: <span> {{ $course->author }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
function applyCourse(id){
    if(confirm("Are you sure you want to buy this course?")){
        $.ajax({
        url:'{{ route("apply") }}',
        type:'post',
        dataType:'json',
        data:{id:id},
        success:function(response){
           window.location.href="{{ url()->current() }}";
        }
        });
    }
}

function saveCourse(id){
    if(confirm("Are you sure you want to  this course?")){
        $.ajax({
        url:'{{ route("saveCourse") }}',
        type:'post',
        dataType:'json',
        data:{id:id},
        success:function(response){
           window.location.href="{{ url()->current() }}";
        }
        });
    }
    }



</script>
@endsection