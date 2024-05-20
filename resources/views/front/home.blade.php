@extends('layouts.app')

@section('main')
<section class="section-0 lazy d-flex bg-image-style dark align-items-center "   class="" data-bg="assets/images/web_banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <h1>Find your desired Course</h1>
                <p>Hundreds of Course available.</p>
                <div class="banner-btn mt-5"><a href="#" class="btn btn-primary mb-4 mb-sm-0">Explore Now</a></div>
            </div>
        </div>
    </div>
</section>

<section class="section-1 py-5 "> 
    <div class="container">
        <div class="card border-0 shadow p-5">
            <form action="{{ route('jobs') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keywords">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="location" id="location" placeholder="Location">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <select name="category" id="category" class="form-control">
                        <option value="">Select a Category</option>
                        @if($newcategories->isNotEmpty())
                        @foreach($newcategories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                        @endif
                        
                        
                    </select>
                </div>
                
                <div class=" col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                    <div class="d-grid gap-2">
                        {{-- <a href="jobs.html" class="btn btn-primary btn-block">Search</a> --}}
                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                    </div>
                    
                </div>
            </div>  
        </form>          
        </div>
    </div>
</section>

<section class="section-2 bg-2 py-5">
    <div class="container">
        <h2>Popular Categories</h2>
        <div class="row pt-5">

           @if($categories->isNotEmpty())

           @foreach($categories as $category)

           <div class="col-lg-4 col-xl-3 col-md-6">
            <div class="single_catagory">
                <a href="{{ route('jobs').'?category='.$category->id }}"><h4 class="pb-2">{{ $category->name }}</h4></a>
                <p class="mb-0"> <span>0</span> Available position</p>
            </div>
           </div>

            @endforeach

           @endif 
        </div>
    </div>
</section>

<section class="section-3  py-5">
    <div class="container">
        <h2>Featured Courses</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                       @if($featuredCourses->isNotEmpty())
                       @foreach($featuredCourses as $fcourse)

                       
                       <div class="col-md-4">
                        <div class="card border-0 p-3 shadow mb-4">
                            <div class="card-body">
                                <h3 class="border-0 fs-5 pb-2 mb-0">{{ $fcourse->title }}</h3>
                                <p>{{ Str::words($fcourse->description,2) }}</p>
                                <div class="bg-light p-3 border">
                                    <p class="mb-0">
                                        {{-- <span class="fw-bolder"><i class="fa fa-map-marker"></i></span> --}}
                                        <span class="ps-1">Author: {{ $fcourse->author }}</span>
                                    </p>
                                    <p class="mb-0">
                                        {{-- <span class="fw-bolder"><i class="fa fa-clock-o"></i></span> --}}
                                        <span class="ps-1">Duration: {{ $fcourse->duration }}</span>
                                    </p>

                                    @if(!is_null($fcourse->price))
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                        <span class="ps-1">Price: {{ $fcourse->price }}</span>
                                    </p>
                                    @endif

                                   
                                </div>

                                <div class="d-grid mt-3">
                                    <a href="{{ route('jobDetail',$fcourse->id) }}" class="btn btn-primary btn-lg">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                       @endforeach
                       @endif                                               
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-3 bg-2 py-5">
    <div class="container">
        <h2>Latest Courses</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                       @if($latestCourses->isNotEmpty())
                       @foreach($latestCourses as $latestcor)
                       <div class="col-md-4">
                        <div class="card border-0 p-3 shadow mb-4">
                            <div class="card-body">
                                <h3 class="border-0 fs-5 pb-2 mb-0">{{ $latestcor->title }}</h3>
                                <p>{{ Str::words($latestcor->description,2) }}</p>
                                <div class="bg-light p-3 border">
                                    <p class="mb-0">
                                        {{-- <span class="fw-bolder"><i class="fa fa-map-marker"></i></span> --}}
                                        <span class="ps-1">Author: {{ $latestcor->author }}</span>
                                    </p>
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                        <span class="ps-1">Duration: {{ $latestcor->duration}}</span>
                                    </p>
                                    @if(!is_null($latestcor->price))
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                        <span class="ps-1">{{ $latestcor->price }}</span>
                                    </p>
                                    @endif
                                </div>

                                <div class="d-grid mt-3">
                                    <a href="{{ route('jobDetail',$latestcor->id) }}" class="btn btn-primary btn-lg">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                      @endforeach
                       @endif
                       
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  
@endsection