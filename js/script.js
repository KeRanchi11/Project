
function filterImages(category) {
    const images = document.querySelectorAll('.image');
    images.forEach(image => {
        if (category === 'all' || image.getAttribute('data-category') === category) {
            image.style.display = 'flex'; // نمایش عکس
        } else {
            image.style.display = 'none'; // مخفی کردن عکس
        }
    });

    // اضافه کردن کلاس active به دکمه انتخاب شده
    document.querySelectorAll('.filter-buttons button').forEach(button => {
        button.classList.remove('active');
        if (button.textContent.toLowerCase() === category || (category === 'all' && button.textContent === 'All')) {
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




window.onload = function() {
    console.log("JavaScript Loaded!"); // تست اجرا شدن جاوا اسکریپت

    // چک کردن آیا فوتر از قبل وجود دارد یا نه
    if (!document.querySelector("footer")) {
        const footer = document.createElement("footer");
        footer.innerHTML = `
            <div class="footer-content">
                <p>&copy; 2025 Maleki SignMaker. All rights reserved.</p>
                <p>Designed by <a href="https://yourwebsite.com" target="_blank">Your Name</a></p>
            </div>
        `;
        document.body.appendChild(footer);
    }
};

