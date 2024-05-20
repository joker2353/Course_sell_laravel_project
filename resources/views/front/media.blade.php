<html>
    <body>

        @if($capp->user_id==Auth::user()->id)
        <div class="mb-4">
        <iframe width="560" height="315" 
        src="{{ $course->link }}" 
        title="YouTube video player" 
        frameborder="0" allow="accelerometer; autoplay; 
        clipboard-write; encrypted-media; 
        gyroscope; picture-in-picture; 
        web-share" 
        referrerpolicy="strict-origin-when-cross-origin" 
        allowfullscreen></iframe>
        </div>
        @else
        <h1>You are not authorised to watch this video</h1>
        @endif
    </body>
</html>