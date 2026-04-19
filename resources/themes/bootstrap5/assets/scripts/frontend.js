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

        var input = wrapper.querySelector('input[name="password"][type="password"], input[name="password"][type="text"]');
        if (!input) {
            return;
        }

        var showLabel = button.querySelector('.show-label');
        var hideLabel = button.querySelector('.hide-label');
        var showLabelText = showLabel ? showLabel.textContent.trim() : 'Show';
        var hideLabelText = hideLabel ? hideLabel.textContent.trim() : 'Hide';
        var passwordLabelText = input.getAttribute('aria-label') || 'password';

        button.addEventListener('click', function () {
            var showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';
            button.setAttribute('aria-pressed', showPassword ? 'true' : 'false');
            button.setAttribute('aria-label', (showPassword ? hideLabelText : showLabelText) + ' ' + passwordLabelText);

            if (showLabel && hideLabel) {
                showLabel.classList.toggle('d-none', showPassword);
                hideLabel.classList.toggle('d-none', !showPassword);
            }
        });
    });
});
