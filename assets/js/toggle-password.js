function initializeToggleButtons() {
    const toggleButtons = document.querySelectorAll('.toggle-password-btn');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const eyeIcon = this.querySelector('.fa-eye');
            const eyeSlashIcon = this.querySelector('.fa-eye-slash');

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.style.display = 'none';
                eyeSlashIcon.style.display = 'inline-block';
            } else {
                input.type = 'password';
                eyeSlashIcon.style.display = 'none';
                eyeIcon.style.display = 'inline-block';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', initializeToggleButtons);
