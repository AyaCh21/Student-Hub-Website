
document.addEventListener('DOMContentLoaded', function() {
    const ratingForm = document.getElementById('rating-form');

    ratingForm.addEventListener('submit', function(event) {
        const ratingValue = parseInt(document.getElementById('rating_exam_rateValue').value);
        if (isNaN(ratingValue) || ratingValue < 0 || ratingValue > 10) {
            alert('Please enter a rating value between 0 and 10.');
            event.preventDefault(); // Prevent form submission
        }
    });
});
