function show_hide_password(containerId) {
    var passwordInput = document.querySelector("#" + containerId + " input");
    var icon = document.querySelector("#" + containerId + " i");

    if (passwordInput.type === "text") {
        passwordInput.type = "password";
        icon.classList.remove("bx-show");
        icon.classList.add("bx-hide");
    } else if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("bx-hide");
        icon.classList.add("bx-show");
    }
}

function emailChangeListner(initialValue) {
    const input = event.target;

    const send_otp_btn = document.getElementById("send_otp_btn");
    const submit_btn = document.getElementById("submit_btn");

    if (input.value === initialValue) {
        send_otp_btn.classList.add("d-none");
        submit_btn.classList.remove("d-none");
    } else {
        submit_btn.classList.add("d-none");
        send_otp_btn.classList.remove("d-none");
    }
}

var timerInterval;
const timerTime = 60;

function send_otp() {
    document.getElementById("otp").setAttribute("required", "true");
    document.getElementById("send_otp_btn").classList.add("d-none");
    document.getElementById("submit_btn").classList.remove("d-none");
    document.getElementById("timer").classList.remove("d-none");
    document
        .getElementById("email_id_validate")
        .setAttribute("readonly", "readonly");
    document.getElementById("otp_admin").classList.remove("d-none");
    startTimer(timerTime, document.getElementById("timer"));
    document.getElementById("timer").textContent =
        "Time remaining: " + timerTime + " seconds";
}

function startTimer(duration, display) {
    var timer = duration;
    timerInterval = setInterval(function () {
        display.textContent = "Time remaining: " + timer + " seconds";

        if (--timer < 0) {
            clearInterval(timerInterval);
            document.getElementById("submit_btn").classList.add("d-none");
            document.getElementById("otp_admin").classList.add("d-none");
            document.getElementById("send_otp_btn").classList.remove("d-none");
            document
                .getElementById("email_id_validate")
                .removeAttribute("readonly");
            display.classList.add("d-none");
        }
    }, 1000);
}

function resendOTP() {
    clearInterval(timerInterval);
    document.getElementById("send_otp_btn").classList.add("d-none");
    startTimer(timerTime, document.getElementById("timer"));
}

function applyDynamicActions(condition, elementIds, actionsList) {
    if (!Array.isArray(elementIds) || !Array.isArray(actionsList)) return;

    elementIds.forEach((elementId, index) => {
        let element = document.getElementById(elementId);
        if (!element) return;

        let actions = actionsList[index] || '';

        actions.split(',').forEach(action => {
            let [property, value] = action.split(':');

            // Trim whitespace
            property = property.trim();
            value = value.trim();

            switch (property) {
                case 'display':
                    element.style.display = condition ? value : ''; // Hide/Show
                    break;
                case 'disable':
                    element.disabled = condition ? value === 'true' : false; // Enable/Disable
                    break;
                case 'readonly':
                    element.readOnly = condition ? value === 'true' : false; // ReadOnly/Editable
                    break;
                case 'background':
                    element.style.backgroundColor = condition ? value : ''; // Change Background Color
                    break;
                case 'class':
                    if (condition) {
                        element.classList.add(value); // Add Class
                    } else {
                        element.classList.remove(value); // Remove Class
                    }
                    break;
                default:
                    if (condition) {
                        element.setAttribute(property, value);
                    } else {
                        element.removeAttribute(property);
                    }
                    break;
            }
        });
    });
}
