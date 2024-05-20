@extends('layouts.app')

@section('main')
<section class="section-3 py-5 bg-2 ">
    <div class="container">     
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Courses</h2>  
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                        <option value="">Latest</option>
                        <option value="">Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="" name="searchForm" id="searchForm">
                <div class="card border-0 shadow p-4">
                    <div class="mb-4">
                        <h2>Keywords</h2>
                        <input value="{{ Request::get('keyword') }}" type="text" name="keyword" id="keyword" placeholder="Keywords" class="form-control">
                    </div>

                    

                    <div class="mb-4">
                        <h2>Category</h2>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @if($categories->isNotEmpty())
                            @foreach($categories as $cat)
                            <option {{ (Request::get('cat')==$cat->id) ? 'selected': '' }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                            @endif
                            
                            
                        </select>
                    </div>                   

                   

                    <button type="submit" class="btn btn-primary">search</button>    
                </div>
            </form>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">                    
                    <div class="job_lists">
                    <div class="row">


                        @if($courses->isNotEmpty())
                        @foreach($courses as $course)
                        

                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="border-0 fs-5 pb-2 mb-0">{{ $course->title }}</h3>
                                    <p>{{ Str::words($course->description,2) }}</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            {{-- <span class="fw-bolder"><i class="fa fa-map-marker"></i></span> --}}
                                            <span class="ps-1">Author: {{ $course->author }}</span>
                                        </p>
                                        <p class="mb-0">
                                            {{-- <span class="fw-bolder"><i class="fa fa-clock-o"></i></span> --}}
                                            <span class="ps-1">Duration: {{ $course->duration }}</span>
                                        </p>
                                         
                                         @if(!is_null($course->price))
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{ $course->price }}</span>
                                        </p>
                                        @endif
                                    </div>

                                    <div class="d-grid mt-3">
                                        {{-- <a href="{{ route('jobDetail',$job->id) }}" class="btn btn-primary btn-lg">Details</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        @endforeach

                         @else
                         <div class="col-mod-4">Courses not found</div>

                        @endif
                    
                    </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $("#searchForm").submit(function(e)){
        e.preventDefault();
        var url='{{ route("jobs") }}?';
        var keyword=$("#keyword").val();
        var category=$("#category").val();
        if(keyword!=""){
            url += '&keyword='+keyword;
        }
        if(category!=""){
            url += '&keyword='+category;
        }
        window.location.href=url;
    }
</script>
@endsection