document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('rating_form');
    const input = document.querySelector('#rate_range');
    const value = document.querySelector('#value');

    value.textContent = input.value;

    input.addEventListener("input", (event) => {
        value.textContent = event.target.value;
        console.log(value, "is the value");
    });

    // PART FOR THE DATABASE
    form.addEventListener('submit', (event) => {

    })
});
