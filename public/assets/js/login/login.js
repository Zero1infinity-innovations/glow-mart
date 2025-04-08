(function () {
    'use strict'

    const tabOne = document.getElementById('tab-1');
    const tabTwo = document.getElementById('tab-2');

    tabTwo.style.display = 'none';

    document.querySelectorAll('#sendOtp, #verifyOtp').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const form = e.target.closest('form');

            const originalContent = e.target;
            const oldHtml = originalContent.innerHTML;

            originalContent.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div>';
            originalContent.classList.add('disabled', 'true');

            const formValues = new FormData(form);
            const endpoint = form.getAttribute('action');
            const payload = {};

            formValues.forEach((value, key) => {
                payload[key] = value;
            });

            callAjax(endpoint, sendObj(payload), function (response) {

                originalContent.innerHTML = oldHtml;
                originalContent.classList.remove('disabled');

                var data = JSON.parse(response);

                if (data.redirect !== undefined) {
                    window.location.href = data.redirect;
                    return;
                }

                if (data.status) {
                    tabOne.style.display = 'none';
                    tabTwo.style.display = 'block';
                    // console.log();
                } else {
                    toastr.options = {
                        progressBar: true,
                        closeButton: true,
                        toastClass: "toast-error",
                    };
                    toastr.success(data.msg, {
                        timeout: 12000,
                    });
                }
            });
        });
    });
})();