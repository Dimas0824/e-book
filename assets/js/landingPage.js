
// Search functionality
document.getElementById('searchInput').addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#bookTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Filter functionality
function filterBooks(type) {
    const rows = document.querySelectorAll('.book-row');
    const buttons = document.querySelectorAll('[onclick^="filterBooks"]');

    // Update button states
    buttons.forEach(btn => {
        btn.classList.remove('btn-primary', 'btn-outline-primary', 'btn-success', 'btn-outline-success', 'btn-warning', 'btn-outline-warning');

        // Determine button type from onclick attribute
        const btnType = btn.onclick.toString().includes('all') ? 'all' :
            btn.onclick.toString().includes('available') ? 'available' : 'unavailable';

        if (btnType === type) {
            // Active button
            if (type === 'all') btn.classList.add('btn-primary');
            else if (type === 'available') btn.classList.add('btn-success');
            else btn.classList.add('btn-warning');
        } else {
            // Inactive button
            if (btnType === 'all') btn.classList.add('btn-outline-primary');
            else if (btnType === 'available') btn.classList.add('btn-outline-success');
            else btn.classList.add('btn-outline-warning');
        }
    });

    // Filter rows
    rows.forEach(row => {
        const stock = parseInt(row.getAttribute('data-stock'));
        let show = false;

        switch (type) {
            case 'all':
                show = true;
                break;
            case 'available':
                show = stock > 0;
                break;
            case 'unavailable':
                show = stock === 0;
                break;
        }

        row.style.display = show ? '' : 'none';
    });
}

// Initialize filter
filterBooks('all');