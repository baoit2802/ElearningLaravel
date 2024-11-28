<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->courseName }} - Video Playlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a class="btn btn-secondary mb-3" href="{{ route('courses.my_courses') }}">Trở về</a>
            <h1 class="text-center flex-grow-1">Video Playlist: {{ $course->courseName }}</h1>
            <div class="toast-container position-fixed p-3" style="z-index: 1055; top: 20px; right: 20px">
                @if (session('success'))
                    <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>


        <div class="row">
            <!-- Video Player -->
            <div class="col-lg-8">
                <div class="video-container">
                    @if ($videos->isNotEmpty())
                        <iframe id="main-video" width="100%" height="400"
                            src="{{ $videos[0]->video_url }}?autoplay=1&mute=1" title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                        <h3 id="video-title" class="mt-3">{{ $videos[0]->title }}</h3>
                    @else
                        <p>Không có video nào trong khóa học này.</p>
                    @endif
                </div>

                <!-- Review Section -->
                @if ($videos->isNotEmpty())
                    <div id="review-section" class="mt-4">
                        @auth
                            <div class="rating w-75">
                                <h4>Đánh giá của học viên</h4>
                                <form action="{{ route('reviews.store', $videos[0]->id) }}" method="POST">
                                    @csrf
                                    <div class="star-rating">
                                        <input type="radio" id="star5" name="rating" value="5">
                                        <label for="star5">★</label>

                                        <input type="radio" id="star4" name="rating" value="4">
                                        <label for="star4">★</label>

                                        <input type="radio" id="star3" name="rating" value="3">
                                        <label for="star3">★</label>

                                        <input type="radio" id="star2" name="rating" value="2">
                                        <label for="star2">★</label>

                                        <input type="radio" id="star1" name="rating" value="1">
                                        <label for="star1">★</label>
                                    </div>
                                    <textarea name="comment" class="form-control mt-3" placeholder="Nhận xét của bạn"
                                        style="height: 100px; width:300px; font-size: 1.1rem; padding: 15px;"></textarea>
                                    <button type="submit" class="btn btn-primary mt-3">Gửi đánh giá</button>
                                </form>
                            </div>



                        @else
                            <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để đánh giá.</p>
                        @endauth

                        <div class="reviews mt-4">
                            <h5>Đánh giá từ học viên:</h5>
                            @forelse ($videos[0]->reviews as $review)
                                <div class="review border p-3 mb-2">
                                    <div>
                                        <strong>{{ $review->user->name }}</strong>:
                                        <span class="text-warning">
                                            @for ($i = 0; $i < $review->rating; $i++) ★ @endfor
                                            @for ($i = $review->rating; $i < 5; $i++) ☆ @endfor
                                        </span>
                                    </div>
                                    <p>{{ $review->comment }}</p>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            @empty
                                <p>Chưa có đánh giá nào.</p>
                            @endforelse
                        </div>

                    </div>
                @endif
            </div>

            <!-- Playlist -->
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('public/js/app.js') }}"></script>
</body>

</html>