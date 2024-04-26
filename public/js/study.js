document.addEventListener('DOMContentLoaded', function() {
    const phaseToggles = document.querySelectorAll('.phase-toggle');

    phaseToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const courses = this.nextElementSibling;
            courses.style.display = courses.style.display === 'none' ? 'block' : 'none';
        });
    });
});
