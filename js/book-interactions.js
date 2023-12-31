console.log("hello")

document.addEventListener('DOMContentLoaded', function() {
    const sortOption = document.getElementById('sortOption');
    const filterInput = document.getElementById('filterInput');
    const bookTable = document.querySelector('table');

    sortOption.addEventListener('change', function() {
        sortBooks(bookTable, sortOption.value);
    });

    filterInput.addEventListener('keyup', function() {
        filterBooks(bookTable, filterInput.value);
    });

    function sortBooks(table, sortBy) {
        console.log("Sorting by: " + sortBy); // Debugging line
        let rows = Array.from(table.querySelectorAll('tr:nth-child(n+2)')); // Select all rows except the header
        rows.sort(function(a, b) {
            let valA = a.querySelector(`td[data-label="${sortBy}"]`).textContent.trim();
            let valB = b.querySelector(`td[data-label="${sortBy}"]`).textContent.trim();

            // Modify this part if your sorting criteria are numeric or date
            return valA.localeCompare(valB);
        });

        // Re-add the sorted rows to the table
        rows.forEach(row => table.appendChild(row));
    }

    function filterBooks(table, searchText) {
        console.log("Filtering with text: " + searchText); // Debugging line
        let rows = table.querySelectorAll('tr:nth-child(n+2)'); // Select all rows except the header

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText.toLowerCase()) ? '' : 'none';
        });
    }
});
