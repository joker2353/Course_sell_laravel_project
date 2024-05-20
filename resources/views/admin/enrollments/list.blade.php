@extends('layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Enrollments</h3>
                            </div>
                            
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                       
                                        <th scope="col">Course Title</th>
                                        <th scope="col">Learner</th>
                                        <th scope="col">Created By</th>
                                        
                                        <th scope="col">Enrolled Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($apps->isNotEmpty())
                                    @foreach($apps as $app)
                                    <tr>
                                        
                                        <td>
                                           <p> {{ $app->course->title }}</p>
                                           {{-- <p> Applicants: {{ $course->applications->count() }}</p> --}}
                                        </td>
                                        <td>{{ $app->user->name }}</td>
                                        
                                        <td>
                                            {{ $app->creator->name }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($app->applied_date)->format('d M, Y') }}</td>
                                        <td>
                                            <div class="action-dots float">
                                                <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    
                                                    
                                                    <li><a class="dropdown-item" href="#" onclick="deleteEnrollment({{ $app->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                    
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                
                            
                                </tbody>
                                
                            </table>
                        </div>
                        {{ $apps->links() }}
                    </div>
                 
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
    function deleteEnrollment(id){
        
        if(confirm("Are you sure you want to delete?")){
            $.ajax({
            url:'{{ route("admin.enrollments.destroy") }}',
            type:'post',
            data: {id:id},
            dataType:'json',
            
            success:function(response){
                window.location.href='{{ route("admin.enrollments") }}';
            }
            });
        }
    }
    </script>

@endsection