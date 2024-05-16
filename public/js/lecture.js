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

