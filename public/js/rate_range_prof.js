document.addEventListener("DOMContentLoaded", function() {
    const input = document.querySelector('.rate_range');
    const value = document.querySelector('#rate_value');
    const slider = document.getElementById('rate_range');
    console.log(slider, "is the slider element");

    value.textContent = input.value;

    input.addEventListener("input", (event) => {
        value.textContent = event.target.value;
        console.log(value, "is the value");
    });
});
