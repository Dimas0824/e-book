function confirmDelete(id, title) {
    document.getElementById('bookTitle').textContent = title;
    document.getElementById('confirmDeleteBtn').onclick = function () {
        window.location.href = 'process/hapusBuku.php?id=' + id;
    };

    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}