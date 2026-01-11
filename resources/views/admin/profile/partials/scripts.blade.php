<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
$(document).ready(function() {
    // Password toggle functionality
    $('.toggle-password').click(function() {
        const target = $(this).data('target');
        const input = $('#' + target);
        const icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Show/hide 2FA instructions
    $('input[name="twoFactorMethod"]').change(function() {
        const method = $(this).val();
        $('#appInstructions, #smsInstructions').addClass('d-none');
        $(`#${method}Instructions`).removeClass('d-none');
    });

    // Initialize 2FA method display
    const initialMethod = $('input[name="twoFactorMethod"]:checked').val();
    $(`#${initialMethod}Instructions`).removeClass('d-none');

    // Password strength indicator
    $('#password').on('input', function() {
        updatePasswordStrength($(this).val());
    });

    // Password requirements toggle
    $('#showPasswordRequirements').change(function() {
        $('.password-requirements').toggleClass('d-none', !$(this).is(':checked'));
    });

    // Phone number formatting
    $('#phone').on('input', function(e) {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 0) {
            value = '+' + value;
        }
        $(this).val(value);
    });

    // Form validation
    $('.needs-validation').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });
});

// ... all other functions from the previous implementation ...
</script>
