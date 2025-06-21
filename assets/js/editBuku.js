document.addEventListener('DOMContentLoaded', function () {
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();

    // Auto redirect after 3 seconds
    setTimeout(function () {
        window.location.href = '../index.php';
    }, 3000);
});