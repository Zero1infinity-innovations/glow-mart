(function () {
    'use strict'

    // document.getElementById('tab-1').style.display = 'none';
    // document.getElementById('tab-4').style.display = 'block';
    

    document.querySelectorAll('#button1, #button2, #button3, #button4, #button4').forEach(button => {
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
                    const showTabs = document.getElementById('tab-' + data.showStep);
                    const hideTabs = document.getElementById('tab-' + data.hideStep);

                    const currentStep = document.querySelectorAll('input[name^="step"]');

                    currentStep[data.hideStep - 1].value = '0';
                    currentStep[data.showStep - 1].value = '1';

                    showTabs.style.display = "block";
                    hideTabs.style.display = 'none';
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