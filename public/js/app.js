function caculateTotal() {
    //Lay tat ca cac hang trong bang ngoai tru tieu de
    var rows = document.querySelectorAll('#gradesTable tr');

    for (var i = 1; i < rows.length; i++) {
        var cc = parseFloat(rows[i].querySelector('td[name="cc"]').textContent);
        var bt = parseFloat(rows[i].querySelector('td[name="bt"]').textContent);
        var gki = parseFloat(rows[i].querySelector('td[name="gki"]').textContent);
        var cki = parseFloat(rows[i].querySelector('td[name="cki"]').textContent);
        var total = cc * 0.1 + bt * 0.2 + gki * 0.2 + cki * 0.5;
        //gan gia tri vua tinh vao cot tong ket
        rows[i].querySelector('.total').textContent = total.toFixed(2);
    }
}
window.onload = caculateTotal;


function showContestDetail(contestId) {
    event.preventDefault();
    const contestDetails = {
        'contest1': `
        <div class="row text-center">
    <h3>Lập trình cơ bản</h3>
    <p>Ngày bắt đầu: 30/11/2024</p>
    <p>Thời gian làm bài: 60 phút</p>
    <p>Nội dung kiểm tra: Kiểm tra kiến thức cơ bản về lập trình, cấu trúc điều khiển, vòng lặp, và hàm.</p>
    <p>Số câu hỏi: 30 câu trắc nghiệm.</p>
    <div class="d-flex justify-content-around">
            <button class="btn btn-success">Tham gia</button>
            <button class="btn btn-danger">Đóng</button>
        </div>
        </div>
`,
        'contest2': `
    <div class="row text-center">
    <h3>Lập trình hướng đối tượng</h3>
    <p>Ngày bắt đầu: 30/11/2024</p>
    <p>Thời gian làm bài: 60 phút</p>
    <p>Nội dung kiểm tra: Kiểm tra kiến thức về các nguyên lý lập trình hướng đối tượng, kế thừa, đa hình, và giao diện.</p>
    <p>Số câu hỏi: 25 câu trắc nghiệm.</p>
    <div class="d-flex justify-content-around">
            <button class="btn btn-success">Tham gia</button>
            <button class="btn btn-danger">Đóng</button>
        </div>
    </div>
`,
        'contest3': `
        <div class="row text-center">
    <h3>Thiết kế Web</h3>
    <p>Ngày bắt đầu: 30/11/2024</p>
    <p>Thời gian làm bài: 60 phút</p>
    <p>Nội dung kiểm tra: Kiểm tra kiến thức về HTML, CSS, và JavaScript trong phát triển ứng dụng web.</p>
    <p>Số câu hỏi: 20 câu trắc nghiệm.</p>
    <div class="d-flex justify-content-around">
            <button class="btn btn-success">Tham gia</button>
            <button class="btn btn-danger">Đóng</button>
        </div>
        </div>
`
    };
    document.getElementById('contestDetail').innerHTML = contestDetails[contestId];
}

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

        // Hiển thị toast
        toast.show();
    });
});