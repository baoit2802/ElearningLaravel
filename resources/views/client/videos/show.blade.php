<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->courseName }} - Video Playlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <br><a class="BtnBack" href="{{ url('/courses') }}">Trở về</a>
        <h1 class="mb-4 p-3 text-center">Video Playlist: {{ $course->courseName }}</h1>
        <div class="row">
            <div class="col-lg-8">
                <div class="video-container">
                    @if($videos->isNotEmpty())
                        <iframe id="main-video" width="100%" height="500" src="{{ $videos[0]->video_url }}?autoplay=1&mute=1"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                        <h2 class="title mt-3">{{ $videos[0]->title }}</h2>
                    @else
                        <p>Không có video nào trong khóa học này.</p>
                    @endif


                </div>
            </div>
            <div class="col-lg-4">
                <div class="playlist">
                    @foreach($videos as $video)
                        <a href="#" onclick="changeVideo(event, '{{ $video->video_url }}', '{{ $video->title }}')">
                            {{ $loop->iteration }}. {{ $video->title }}
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <script>
        function changeVideo(event, videoUrl, title) {
            event.preventDefault();
            const videoElement = document.getElementById('main-video');
            videoElement.src = videoUrl + '?autoplay=1&mute=1';
            document.querySelector('.title').textContent = title; // Cập nhật tiêu đề
        }


    </script>
</body>

</html>