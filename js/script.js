
function filterImages(category) {
    const images = document.querySelectorAll('.image-container');

    images.forEach(image => {
        if (category === 'all' || image.getAttribute('data-category') === category) {
            image.style.display = 'block'; // نمایش عکس‌های مربوطه
        } else {
            image.style.display = 'none'; // مخفی کردن عکس‌های نامرتبط
        }
    });

    // تغییر استایل دکمه فعال
    const buttons = document.querySelectorAll('.filter-buttons button');
    buttons.forEach(button => {
        button.classList.remove('active');
        if (button.textContent.toLowerCase() === category || (category === 'all' && button.textContent.toLowerCase() === 'all')) {
            button.classList.add('active');
        }
    });
}

//مودال بزرگنمایی

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('modal').style.display = "none";
});

function openModal(filename) {
    const modal = document.getElementById('modal');
    const modalImg = document.getElementById('modalImg');
    modal.style.display = "block";
    modalImg.src = "uploads/" + filename;
}

function closeModal() {
    document.getElementById('modal').style.display = "none";
}



document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    if (passwordField.type === 'password') {
        passwordField.type = 'text'; // نمایش رمز عبور
        this.textContent = 'hide password'; // تغییر آیکون به چشم بسته
    } else {
        passwordField.type = 'password'; // مخفی کردن رمز عبور
        this.textContent = 'show password'; // تغییر آیکون به چشم باز
    }
});






