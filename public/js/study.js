document.addEventListener('DOMContentLoaded', function() {
    const phaseHeaders = document.querySelectorAll('.phase-header');
    const footer = document.querySelector('footer');
    const phaseContainers = document.querySelectorAll('.phase-container');

    function adjustLastPhaseMargin() {
        const lastPhaseContainer = phaseContainers[phaseContainers.length - 1];
        const expandedCourses = lastPhaseContainer.querySelectorAll('.course:not(.collapsed)');
        let totalExpandedHeight = 0;

        expandedCourses.forEach(course => {
            totalExpandedHeight += course.offsetHeight;
        });

        lastPhaseContainer.style.paddingBottom = `${totalExpandedHeight}px`;
    }

    function togglePhase(phase) {
        const courses = phase.nextElementSibling;
        const isCollapsed = window.getComputedStyle(courses).display === 'none';

        courses.style.display = isCollapsed ? 'block' : 'none';
        phase.dataset.expanded = isCollapsed ? 'true' : 'false';

        const toggleIcon = phase.querySelector('.phase-toggle svg path');
       // toggleIcon.setAttribute('d', isCollapsed ? 'M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z' : 'M296-345-56-56 240-240 240 240-56 56-184-184-184 184Z');
        toggleIcon.setAttribute('d', isCollapsed ? 'M296-345-56-56 240-240 240 240-56 56-184-184-184 184Z' : 'M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z');

        adjustLastPhaseMargin();
    }

    function toggleCourse(course) {
        const options = course.nextElementSibling;
        const isCollapsed = window.getComputedStyle(options).display === 'none';

        options.style.display = isCollapsed ? 'block' : 'none';
        course.dataset.expanded = isCollapsed ? 'true' : 'false';

        const toggleIcon = course.querySelector('.course-toggle svg path');
       // toggleIcon.setAttribute('d', isCollapsed ? 'M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z' : 'M296-345-56-56 240-240 240 240-56 56-184-184-184 184Z');
        toggleIcon.setAttribute('d', isCollapsed ? 'M296-345-56-56 240-240 240 240-56 56-184-184-184 184Z' : 'M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z');

        adjustLastPhaseMargin();
    }


    phaseHeaders.forEach(header => {
        header.addEventListener('click', function() {
            togglePhase(header);
        });

        const courseToggles = header.nextElementSibling.querySelectorAll('.course-toggle');
        courseToggles.forEach(courseToggle => {
            courseToggle.addEventListener('click', function() {
                toggleCourse(courseToggle);
            });
        });
    });

    adjustLastPhaseMargin();

    window.addEventListener('resize', function() {
        adjustLastPhaseMargin();
    });
});
