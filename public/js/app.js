function changeVideo(event, videoUrl, title, videoId) {
    event.preventDefault();
    document.getElementById('main-video').src = videoUrl + '?autoplay=1&mute=1';
    document.getElementById('video-title').textContent = title;

    // Cập nhật hành động của form cho video mới
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.action = `/videos/${videoId}/reviews`;
    }

    // Fetch and update reviews for the selected video
    fetch(`/videos/${videoId}/reviews`)
        .then(response => response.json())
        .then(data => {
            const reviewSection = document.getElementById('reviews');
            reviewSection.innerHTML = '';
            if (data.length === 0) {
                reviewSection.innerHTML = '<p>Chưa có đánh giá nào.</p>';
            } else {
                data.forEach(review => {
                    reviewSection.innerHTML += `
                        <div class="border p-3 mb-2">
                            <strong>${review.user.name}</strong>:
                            <span class="text-warning">
                                ${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}
                            </span>
                            <p>${review.comment}</p>
                            <small class="text-muted">${new Date(review.created_at).toLocaleString()}</small>
                        </div>`;
                });
            }
        });
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

document.addEventListener('DOMContentLoaded', function() {
    fetch('/notifications')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const dropdownMenu = document.querySelector('#notificationDropdown .dropdown-menu');
            dropdownMenu.innerHTML = ''; // Xóa thông báo cũ

            if (data.length === 0) {
                dropdownMenu.innerHTML = '<p class="text-center p-2">Không có thông báo nào.</p>';
            } else {
                data.forEach(notification => {
                    const card = `
                        <div class="card-notification w-100">
                            <div class="container-notification">
                                <div class="left">
                                    <div class="status-ind ${notification.is_read ? '' : 'bg-danger'}"></div>
                                </div>
                                <div class="right">
                                    <div class="text-wrap">
                                        <p class="text-content">
                                            ${notification.title}
                                        </p>
                                        <p class="time">${new Date(notification.created_at).toLocaleString()}</p>
                                    </div>
                                    <div class="button-wrap">
                                        <button class="primary-cta" onclick="viewNotification(${notification.id})">Xem</button>
                                        <button class="secondary-cta" onclick="markAsRead(${notification.id})">Đánh dấu đã đọc</button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    dropdownMenu.innerHTML += card;
                });
            }
        })
        .catch(error => {
            console.error('Lỗi khi tải thông báo:', error);
            const dropdownMenu = document.querySelector('#notificationDropdown .dropdown-menu');
            dropdownMenu.innerHTML = '<p class="text-center text-danger p-2">Không thể tải thông báo. Vui lòng thử lại sau.</p>';
        });
});


// Hàm đánh dấu thông báo đã đọc
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Thông báo đã được đánh dấu đã đọc.');
                // Reload notifications
                location.reload();
            }
        })
        .catch(error => console.error('Lỗi khi đánh dấu đã đọc:', error));
}