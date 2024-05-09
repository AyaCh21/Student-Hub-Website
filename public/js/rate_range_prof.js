document.addEventListener("DOMContentLoaded", function() {
    const value = document.querySelector('#value');
    const input = document.querySelector('#rate_range');

    value.textContent = input.value;

    input.addEventListener("input", (event) => {
        value.textContent = event.target.value;
    });
});
