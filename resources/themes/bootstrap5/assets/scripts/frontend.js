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

        var input = wrapper.querySelector('input[name="password"]');
        if (!input) {
            return;
        }

        var showLabel = button.querySelector('.show-label');
        var hideLabel = button.querySelector('.hide-label');
        var showLabelText = showLabel ? showLabel.textContent.trim() : (button.getAttribute('aria-label') || '');
        var hideLabelText = hideLabel ? hideLabel.textContent.trim() : showLabelText;

        button.addEventListener('click', function () {
            var showPassword = input.type === 'password';
            input.type = showPassword ? 'text' : 'password';
            button.setAttribute('aria-pressed', showPassword ? 'true' : 'false');
            button.setAttribute('aria-label', showPassword ? hideLabelText : showLabelText);

            if (showLabel && hideLabel) {
                showLabel.classList.toggle('d-none', showPassword);
                hideLabel.classList.toggle('d-none', !showPassword);
            }
        });
    });
});
