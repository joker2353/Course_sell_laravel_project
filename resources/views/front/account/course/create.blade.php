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
                <form action="" method="post" id="createCourseForm" name="createCourseForm">
                <div class="card border-0 shadow mb-4 ">
                    <div class="card-body card-form p-4">
                        <h3 class="fs-4 mb-1">Course Details</h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Title<span class="req">*</span></label>
                                <input type="text" placeholder="Course Title" id="title" name="title" class="form-control">
                                <p></p>
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Category<span class="req">*</span></label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                    @endif
                                    
                                </select>
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Author<span class="req">*</span></label>
                                <input type="text" placeholder="Author name" id="author" name="author" class="form-control">
                                <p></p>
                               
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Seats<span class="req">*</span></label>
                                <input type="number" min="1" placeholder="Seat" id="seat" name="seat" class="form-control">
                                 <p></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Course Price</label>
                                <input type="text" placeholder="Price" id="price" name="price" class="form-control">
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Duration<span class="req">*</span></label>
                                <input type="text" placeholder="Duration" id="duration" name="duration" class="form-control">
                              <p></p>
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label for="" class="mb-2">Description<span class="req">*</span></label>
                            <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description"></textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Benefits</label>
                            <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Prerequisite</label>
                            <textarea class="form-control" name="prerequisite" id="prerequisite" cols="5" rows="5" placeholder="Prerequisite"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Link</label>
                            <textarea class="form-control" name="link" id="link" cols="5" rows="5" placeholder="Link"></textarea>
                        </div>


                        <div class="mb-4">
                            <label for="" class="mb-2">Experience<span class="req">*</span></label>
                            <select name="experience" id="experience" class="form-control">
                                <option value="1">2 years</option>
                                <option value="2">3 years</option>
                                <option value="3">4 years</option>
                                <option value="4">5 years</option>
                                <option value="5">6 years</option>
                                <option value="6">7 years</option>
                                <option value="7">8 years</option>
                                <option value="8">9 years</option>
                                <option value="9">10 years</option>
                                <option value="10">10+ years</option>
                            </select>
                            <p></p>
                        </div>
                        
                        

                        <div class="mb-4">
                            <label for="" class="mb-2">Keywords</label>
                            <input type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                        </div>

                    </div> 
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-primary">Create Course</button>
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
$("#createCourseForm").submit(function(e){
    e.preventDefault();
    $("button[type='submit']").prop('disabled',true);
    $.ajax({
        url:'{{ route("account.saveCourse") }}',
        type:'post',
        dataType:'json',
        data: $("#createCourseForm").serializeArray(),
        success:function(response){
            if(response.status==true){
                $("button[type='submit']").prop('disabled',false);
                $("#title").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#category").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#author").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#seat").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#price").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    $("#description").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')

                    

              window.price.href="{{ route('account.createCourse') }}";
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
                if(errors.author){
                    $("#author").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.author)
                }else{
                    $("#author").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
                if(errors.seat){
                    $("#seat").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.seat)
                }else{
                    $("#seat").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }
                if(errors.price){
                    $("#price").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.price)
                }else{
                    $("#price").removeClass('is-invalid')
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
               
            }
        }
    });
});
     
</script>
@endsection