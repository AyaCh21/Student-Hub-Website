document.addEventListener('DOMContentLoaded', function() {
    const phaseHeaders = document.querySelectorAll('.phase-header');
    const footer = document.querySelector('footer');
    const phaseContainers = document.querySelectorAll('.phase-container');

    function adjustFooterPosition() {
        const bodyHeight = document.body.clientHeight;
        const windowHeight = window.innerHeight;
        const footerHeight = footer.offsetHeight;

        if (bodyHeight < windowHeight) {
            footer.style.position = 'fixed';
            footer.style.bottom = '0';
        } else {
            footer.style.position = 'static';
        }
    }

    function adjustLastPhaseMargin() {
        const lastPhaseContainer = phaseContainers[phaseContainers.length - 1];
        const expandedCourses = lastPhaseContainer.querySelectorAll('.course:not(.collapsed)');
        let totalExpandedHeight = 0;

        expandedCourses.forEach(course => {
            totalExpandedHeight += course.offsetHeight;
        });

        lastPhaseContainer.style.paddingBottom = `${totalExpandedHeight}px`;
    }

    phaseHeaders.forEach(header => {
        const toggle = header.querySelector('.phase-toggle');
        const courses = header.nextElementSibling;

        toggle.addEventListener('click', function() {
            const isCollapsed = courses.style.display === 'none';
            courses.style.display = isCollapsed ? 'block' : 'none';
            toggle.querySelector('i').classList.toggle('fa-plus');
            toggle.querySelector('i').classList.toggle('fa-minus');
            adjustFooterPosition();
            adjustLastPhaseMargin();
        });

        const courseToggles = courses.querySelectorAll('.course-toggle');

        courseToggles.forEach(courseToggle => {
            const options = courseToggle.nextElementSibling;

            courseToggle.addEventListener('click', function() {
                const isCollapsed = options.style.display === 'none';
                options.style.display = isCollapsed ? 'block' : 'none';
                courseToggle.querySelector('i').classList.toggle('fa-plus');
                courseToggle.querySelector('i').classList.toggle('fa-minus');
                adjustFooterPosition();
                adjustLastPhaseMargin();
            });
        });
    });

    adjustFooterPosition();
    adjustLastPhaseMargin();

    window.addEventListener('resize', function() {
        adjustFooterPosition();
        adjustLastPhaseMargin();
    });
});
