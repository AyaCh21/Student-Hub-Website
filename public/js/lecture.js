document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('pdfSearch');
    const pdfList = document.getElementById('pdfList');
    const pdfs = JSON.parse(document.getElementById('pdf-data').textContent);

    function filterPDFs() {
        const searchTerm = searchInput.value.toLowerCase();
        pdfList.innerHTML = '';

        pdfs.filter(pdf => pdf.name.toLowerCase().includes(searchTerm)).forEach(pdf => {
            const pdfElement = document.createElement('li');
            pdfElement.textContent = pdf.name;
            pdfList.appendChild(pdfElement);
        });
    }

    searchInput.addEventListener('keyup', filterPDFs);
    filterPDFs();
});


document.getElementById('comment-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then(response => {
        if (response.ok) {
            form.reset();
            document.getElementById('parent_id').value = '';
        }
    }).catch(error => {
        console.error('Error submitting form:', error);
    });
});

/*
document.addEventListener("DOMContentLoaded", function() { // Ensure the code runs after the DOM is fully loaded

    // Reply Button Functionality
    document.querySelectorAll('.reply-button').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.getAttribute('data-comment-id');
            const commentWrapper = this.closest('.comment-wrapper');

            // Remove any existing reply form in this comment wrapper
            const existingForm = commentWrapper.querySelector('.reply-form');
            if (existingForm) {
                existingForm.remove(); // Ensure only one reply form is open at a time
            }

            // Clone the hidden reply form template
            const replyFormTemplate = document.getElementById('reply-form-template');
            const replyForm = replyFormTemplate.cloneNode(true); // Clone the template
            replyForm.id = ''; // Clear the ID to avoid duplicates
            replyForm.style.display = 'block'; // Make the form visible
            replyForm.classList.add('reply-form');
            replyForm.querySelector('.parent_id').value = commentId; // Set the parent_id for the reply

            // Append the reply form to the current comment wrapper
            commentWrapper.appendChild(replyForm);
            replyForm.scrollIntoView({ behavior: 'smooth' }); // Scroll to the form smoothly

            // Add event listener to the newly added reply form's submit button
            replyForm.querySelector('form').addEventListener('submit', handleReplyFormSubmit);
        });
    });

    function handleReplyFormSubmit(event) { // Function to handle reply form submission
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, { // Use fetch to submit the form
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Indicate an AJAX request
            }
        }).then(response => {
            if (response.ok) {
                form.reset(); // Reset the form after successful submission
                form.closest('.reply-form').remove(); // Remove the form after successful submission
            }
        }).catch(error => {
            console.error('Error submitting reply form:', error); // Handle any errors
        });
    }
});
*/

document.addEventListener("DOMContentLoaded", function() {
    // Add event listeners to all reply buttons
    document.querySelectorAll('.reply-button').forEach(button => {
        button.addEventListener('click', event => {
            const commentId = event.target.getAttribute('data-comment-id');
            const replyForm = document.getElementById(`reply-form-${commentId}`);

            // Toggle visibility of the reply form
            if (replyForm.style.display === 'none' || replyForm.style.display === '') {
                replyForm.style.display = 'block';
            } else {
                replyForm.style.display = 'none';
            }

            // Set the parent_id hidden field value
            const parentIdField = replyForm.querySelector('input[name="reply_form[parent_id]"]');
            if (parentIdField) {
                parentIdField.value = commentId;
            }

            // Add event listener for the reply form submission
            replyForm.querySelector('form').addEventListener('submit', handleReplyFormSubmit);
        });
    });

    function handleReplyFormSubmit(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(response => {
            if (response.ok) {
                form.reset();
                form.closest('.reply-form').style.display = 'none'; // Hide the form after successful submission
            } else {
                console.error('Failed to submit reply form.');
            }
        }).catch(error => {
            console.error('Error submitting reply form:', error);
        });
    }
});
