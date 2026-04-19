document.addEventListener('DOMContentLoaded', function () {
    var toggleButtons = document.querySelectorAll('[data-password-toggle="true"]');
    if (!toggleButtons.length) {
        return;
    }

    toggleButtons.forEach(function (button) {
        var wrapper = button.closest('.login-password-field');
        if (!wrapper) {
            return;
        }

        var input = wrapper.querySelector('input[type="password"], input[type="text"]');
        if (!input) {
            return;
        }

        var showLabel = button.querySelector('.show-label');
        var hideLabel = button.querySelector('.hide-label');

        button.addEventListener('click', function () {
            var showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';
            button.setAttribute('aria-pressed', showPassword ? 'true' : 'false');
            button.setAttribute('aria-label', showPassword ? 'Hide password' : 'Show password');

            if (showLabel && hideLabel) {
                showLabel.classList.toggle('d-none', showPassword);
                hideLabel.classList.toggle('d-none', !showPassword);
            }
        });
    });
});
