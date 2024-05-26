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

// Reply button functionality
document.querySelectorAll('.reply-button').forEach(button => {
    button.addEventListener('click', function() {
        const commentId = this.getAttribute('data-comment-id');
        const commentWrapper = this.closest('.comment-wrapper');

        // Remove any existing reply form in this comment wrapper
        const existingForm = commentWrapper.querySelector('.reply-form');
        if (existingForm) {
            existingForm.remove();
        }

        // Clone the hidden reply form template
        const replyFormTemplate = document.getElementById('reply-form-template');
        const replyForm = replyFormTemplate.cloneNode(true);
        replyForm.style.display = 'block';
        replyForm.classList.add('reply-form');
        replyForm.querySelector('.parent_id').value = commentId;

        // Append the reply form to the current comment wrapper
        commentWrapper.appendChild(replyForm);
        replyForm.scrollIntoView({ behavior: 'smooth' });

        // Add event listener to the newly added reply form's submit button
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
            form.closest('.reply-form').remove(); // Remove the form after successful submission
        }
    }).catch(error => {
        console.error('Error submitting reply form:', error);
    });
}