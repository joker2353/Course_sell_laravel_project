@extends('layouts.app')



@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <form action="" method="post" id="editCourseForm" name="editCourseForm">
                <div class="card border-0 shadow mb-4 ">
                    <div class="card-body card-form p-4">
                        <h3 class="fs-4 mb-1">Edit Course Details</h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Title<span class="req">*</span></label>
                                <input value="{{ $course->title }} " type="text" placeholder="Job Title" id="title" name="title" class="form-control">
                                <p></p>
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Category<span class="req">*</span></label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                    <option   {{ ($course->category_id==$category->id) ? 'selected' :'' }} value={{ $category->id }}  >
                                         {{$category->name}}</option>
                                    @endforeach
                                    @endif
                                    
                                </select>
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Author<span class="req">*</span></label>
                                <input value="{{ $course->author }}" type="text" placeholder="Author name" id="author" name="author" class="form-control">
                                <p></p>
                               
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Seats<span class="req">*</span></label>
                                <input value="{{ $course->seat }}" type="number" min="1" placeholder="Seat" id="seat" name="seat" class="form-control">
                                 <p></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Course Price</label>
                                <input value="{{ $course->price }}" type="text" placeholder="Price" id="price" name="price" class="form-control">
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Duration<span class="req">*</span></label>
                                <input value="{{ $course->duration}}" type="text" placeholder="Duration" id="duration" name="duration" class="form-control">
                              <p></p>
                            </div>
                        </div>   

                        <div class="row">
                            <div class="mb-4 col-md-6">
                        <div class="form-check">
                            <input {{ ($course->isFeatured==0)? 'checked': '' }} class="form-check-input" type="checkbox" value="0" id="isFeatured" name="isFeatured">
                            <label class="form-check-label" for="isFeatured">
                             Featured
                            </label>
                          </div>
                            </div>
                            <div class="mb-4 col-md-6">
                                <div class="form-check-inline">
                                    <input {{ ($course->status==1)? 'checked': '' }} class="form-check-input" type="radio" value="1" id="status-active" name="status">
                                    <label class="form-check-label" for="status">
                                    Active
                                    </label>
                                  </div>
                                  <div class="form-check-inline">
                                    <input {{ ($course->status==0)? 'checked': '' }} class="form-check-input" type="radio" value="0" id="status-block" name="status">
                                    <label class="form-check-label" for="status">
                                    Block
                                    </label>
                                  </div>
                                    </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="" class="mb-2">Description<span class="req">*</span></label>
                            <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $course->description}}</textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Benefits</label>
                            <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $course->benefits}}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Prerequisite</label>
                            <textarea class="form-control" name="prerequisite" id="prerequisite" cols="5" rows="5" placeholder="Prerequisite">{{ $course->prerequisite}}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Link</label>
                            <textarea class="form-control" name="link" id="link" cols="5" rows="5" placeholder="Link">{{ $course->link}}</textarea>
                        </div>


                        <div class="mb-4">
                            <label for="" class="mb-2">Experience<span class="req">*</span></label>
                            <select name="experience" id="experience" class="form-control">
                                <option value="2" {{ ($course->experience==2) ? 'selected':'' }}>2 years</option>
                                <option value="3"{{ ($course->experience==3) ? 'selected':'' }}>3 years</option>
                                <option value="4"{{ ($course->experience==4) ? 'selected':'' }}>4 years</option>
                                <option value="5"{{ ($course->experience==5) ? 'selected':'' }}>5 years</option>
                                <option value="6"{{ ($course->experience==6) ? 'selected':'' }}>6 years</option>
                                <option value="7"{{ ($course->experience==7) ? 'selected':'' }}>7 years</option>
                                <option value="8"{{ ($course->experience==8) ? 'selected':'' }}>8 years</option>
                                <option value="9"{{ ($course->experience==9) ? 'selected':'' }}>9 years</option>
                                <option value="10"{{ ($course->experience==10) ? 'selected':'' }}>10 years</option>
                            </select>
                            <p></p>
                        </div>
                        
                        

                        <div class="mb-4">
                            <label for="" class="mb-2">Keywords</label>
                            <input value="{{ $course->keywords }}" type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                        </div>
                    </div> 
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-primary">Update Course</button>
                    </div>

                
                   
                </div> 
            </form>            
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
$("#editCourseForm").submit(function(e){
    e.preventDefault();
    $("button[type='submit']").prop('disabled',true);
    $.ajax({
        url:'{{ route("admin.courses.update", $course->id) }}',
        type:'PUT',
        dataType:'json',
        data: $("#editCourseForm").serializeArray(),
        success:function(response){
            $("button[type='submit']").prop('disabled',false);
            if(response.status==true){
                $("#title").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#category").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#jobType").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#vacancy").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#location").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#description").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#company_name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

              window.location.href="{{ route('admin.courses') }}";
            }else{
                var errors=response.errors;
       
                if(errors.title){
                    $("#title").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.title)
                }else{
                    $("#title").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
                if(errors.category){
                    $("#category").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.category)
                }else{
                    $("#category").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
                if(errors.jobType){
                    $("#jobType").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.jobType)
                }else{
                    $("#jobType").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
                if(errors.vacancy){
                    $("#vacancy").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.vacancy)
                }else{
                    $("#vacancy").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
                if(errors.location){
                    $("#location").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.location)
                }else{
                    $("#location").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
                if(errors.description){
                    $("#description").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.description)
                }else{
                    $("#description").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
                if(errors.company_name){
                    $("#company_name").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.company_name)
                }else{
                    $("#company_name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
            }
        }
    });
});
     
</script>
@endsection