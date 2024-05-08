document.addEventListener("DOMContentLoaded",
    function () {
    const nav_options = document.querySelectorAll('.nav-opt');

    nav_options.forEach(item => {
        item.addEventListener('click',
            function () {
            nav_options.forEach(nav_option => nav_option.classList.remove('active'));
            this.classList.add('active');
            })
    })
    })