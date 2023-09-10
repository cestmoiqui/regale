document.addEventListener('DOMContentLoaded', () => {
    toggleButtons();
}); // Calls the function when the document is completely downloaded

document.addEventListener('DOMContentLoaded', () => {
    const toggleButtons = document.querySelectorAll('.toggle-password-btn');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            var input = this.parentNode.previousElementSibling;
            var icon = this.firstChild;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fas', 'fa-eye');
                icon.classList.add('fas', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fas', 'fa-eye-slash');
                icon.classList.add('fas', 'fa-eye');
            }
        });
    });
});
;
