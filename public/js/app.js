function changeVideo(event, src, title) {
    event.preventDefault();
    const videoElement = document.getElementById('main-video');
    videoElement.src = src;
    videoElement.play();
    document.querySelector('.title').innerText = title;
}

document.addEventListener('DOMContentLoaded', function() {
    const toastElements = document.querySelectorAll('.toast');

    toastElements.forEach(function(toastElement) {
        // Hiển thị toast với hiệu ứng từ phải qua trái
        toastElement.classList.add('slide-in');

        // Tạo một Toast Bootstrap
        const toast = new bootstrap.Toast(toastElement, {
            animation: false, // Tắt animation mặc định của Bootstrap
            autohide: true,
            delay: 3000, // 3 giây
        });

        // Lắng nghe sự kiện đóng của Bootstrap Toast
        toastElement.addEventListener('hide.bs.toast', function() {
            toastElement.classList.remove('slide-in');
            toastElement.classList.add('slide-out');

            // Xóa toast khỏi DOM sau khi kết thúc animation "đóng"
            toastElement.addEventListener('animationend', function() {
                toastElement.remove();
            });
        });

        toast.show();
    });
});