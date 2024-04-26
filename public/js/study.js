document.addEventListener('DOMContentLoaded', function() {
    const phaseHeaders = document.querySelectorAll('.phase-header');

    phaseHeaders.forEach(header => {
        const toggle = header.querySelector('.phase-toggle');
        const courses = header.nextElementSibling;

        toggle.addEventListener('click', function() {
            courses.style.display = courses.style.display === 'none' ? 'block' : 'none';
            toggle.querySelector('i').classList.toggle('fa-plus-circle');
            toggle.querySelector('i').classList.toggle('fa-minus-circle');
        });
    });

    const courseToggles = document.querySelectorAll('.course-toggle');

    courseToggles.forEach(toggle => {
        const options = toggle.nextElementSibling;

        toggle.addEventListener('click', function() {
            options.style.display = options.style.display === 'none' ? 'block' : 'none';
            toggle.querySelector('i').classList.toggle('fa-plus-circle');
            toggle.querySelector('i').classList.toggle('fa-minus-circle');
        });
    });
});
