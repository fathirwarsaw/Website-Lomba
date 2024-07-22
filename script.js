document.addEventListener('DOMContentLoaded', function() {
    const assignmentForm = document.getElementById('assignmentForm');
    const messageDiv = document.getElementById('messageDiv');

    assignmentForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(assignmentForm);

        fetch(assignmentForm.getAttribute('action'), {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            showMessage(data.message, data.success);
            if (data.success) {
                showSuccessNotification(); // Panggil fungsi notifikasi jika berhasil
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while submitting the assignment.', false);
        });
    });

    function showMessage(message, isSuccess) {
        messageDiv.innerHTML = `<p>${message}</p>`;
        if (isSuccess) {
            messageDiv.classList.remove('error');
            messageDiv.classList.add('success');
        } else {
            messageDiv.classList.remove('success');
            messageDiv.classList.add('error');
        }
        assignmentForm.reset();
    }

    function showSuccessNotification() {
        const notification = document.createElement('div');
        notification.className = 'success-notification';
        notification.textContent = 'Assignment submitted successfully!';
        document.body.appendChild(notification);

        setTimeout(function() {
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.remove();
            }, 1000);
        }, 3000); // Hapus notifikasi setelah 3 detik
    }
});
