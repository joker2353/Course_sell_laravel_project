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
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Jobs Applied</h3>
                            </div>
                           
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Applied date</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($jobapps->isNotEmpty())
                                        @foreach($jobapps as $jobapp)
                                        <tr class="active">
                                            <td>
                                                <div class="job-name fw-500">{{ $jobapp->job->title }}</div>
                                                <div class="info1">{{ $jobapp->job->jobType->name }} . {{ $jobapp->job->location }}</div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($jobapp->created_at)->format('d M, Y') }}</td>
                                            <td>{{ $jobapp->job->applications->count() }} Applications</td>
                                            <td>
                                                @if($jobapp->job->status==1)
                                                <div class="job-status text-capitalize">active</div>
                                                @else
                                                <div class="job-status text-capitalize">block</div>
                                                @endif

                                                
                                            </td>
                                            <td>
                                                <div class="action-dots float-end">
                                                    <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route("jobDetail",$jobapp->job_id) }}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                                                                                                                                                                    
                                                        <li><a class="dropdown-item" href="#" onclick="removeJob({{ $jobapp->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach 
                                    @endif
                                    
                                   
                                    
                                   
                                </tbody>
                                
                            </table>
                        </div>
                        {{ $jobapps->links() }}
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
function removeJob(id){
    if(confirm("Are you sure you want to remove?")){
        $.ajax({
        url:'{{ route("account.removeapp") }}',
        type:'post',
        data: {id:id},
        dataType:'json',
        
        success:function(response){
            window.location.href='{{ route("account.applications") }}'
        }
        });
    }
}
</script>
@endsection