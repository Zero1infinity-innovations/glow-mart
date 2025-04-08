document.addEventListener("DOMContentLoaded", function () {
    const resendBtn = document.getElementById("resend-btn");
    const countdownElement = document.getElementById("countdown");
    let countdown = 62;

    resendBtn.disabled = true;

    const timer = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;

        if (countdown <= 0) {
            clearInterval(timer);
            resendBtn.disabled = false;
            countdownElement.textContent = "0";
        }
    }, 1000);

    resendBtn.addEventListener("click", () => {
        // alert("OTP Resent!");
        countdown = 62;
        countdownElement.textContent = countdown;
        resendBtn.disabled = true;

        const newTimer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(newTimer);
                resendBtn.disabled = false;
                countdownElement.textContent = "0";
            }
        }, 1000);
    });
});
