function callAjax(url, data, callback, method = "POST") {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const responseText = xhr.responseText;
                callback(responseText);
            } else {
                alert(xhr.status);
            }
        }
    };
    xhr.send(data);
}

function razorPay(url, data) {
    callAjax(url, data, function (response) {
        const jsonData = JSON.parse(response);
        var options = {
            key: jsonData.key,
            amount: jsonData.amount * 100,
            currency: "INR",
            name: "Ayaac",
            description: "Test Transaction",
            order_id: jsonData.order_id,
            notes: jsonData.notes,
            handler: function (response) {
                callAjax(jsonData.callback_url + '?razorpay_payment_id=' + response.razorpay_payment_id, sendObj({ '_token': jsonData.token, 'razorpay_payment_id': response.razorpay_payment_id }), function (e) {
                    const pData = JSON.parse(e);
                    if (pData.status == false) {
                        toastr.options = {
                            progressBar: true,
                            closeButton: true,
                            toastClass: "toast-error",
                        };
                        toastr.success(pData.msg, {
                            timeout: 12000,
                        });
                    } else if (pData.status == true) {
                        setCookie("successCookie", pData.msg, 1);
                        if (pData.redirect) {
                            window.location.href = pData.redirect;
                        } else {
                            window.location.reload();
                        }
                    }
                }, 'GET');
            },
            prefill: {
                name: jsonData.name,
                email: jsonData.email,
                contact: jsonData.mobile
            },
            theme: {
                color: "#3399cc"
            }
        };

        var rzp = new Razorpay(options);
        rzp.open();
    });
}

function copyText(textToCopy) {
    navigator.clipboard.writeText(textToCopy).then(function () {
        alert('Text copied to clipboard successfully!');
    }).catch(function (error) {
        console.error('Error copying text: ', error);
    });
}

// function showEl(){
//     alert('yes');
// }

// function isValidURL(href) {
//     try {
//         const url = new URL(href);
//         if (url.protocol !== "http:" && url.protocol !== "https:") {
//             return false;
//         }
//         return true;
//     } catch (e) {
//         return false;
//     }
// }

// document.addEventListener("DOMContentLoaded", function () {
//     const menuLinks = document.querySelectorAll("#menu a");

//     menuLinks.forEach(function (link) {
//         link.addEventListener("click", function (event) {
//             event.preventDefault();

//             if (isValidURL(link.href)) {

//                 const stringValue = link.href.includes('?') ? '&' : '?';

//                 callAjax(link.href + stringValue + "side_menu=true", null, function (e) {
//                     history.pushState({ path: link.href }, 'demo title', link.href);
//                     const jsonData = JSON.parse(e);
//                     document.getElementById('parent').innerHTML = jsonData.content;
//                 }, 'GET');
//             }
//         });
//     });
// });

// window.addEventListener('popstate', (event) => {
//     console.log('popstate event triggered:', event);
// });

// let isPopStateHandling = true; // To prevent double execution
// let initialLoad = true;

// window.addEventListener('popstate', (event) => {
//     if (isPopStateHandling) return; // Avoid re-triggering

//     if (initialLoad) {
//         initialLoad = false;
//         return; // Skip handling on initial load
//     }

//     isPopStateHandling = false;
//     console.log('aaaa');

//     const state = event.state;
//     if (state && state.path) {

//         const stringValue = state.path.includes('?') ? '&' : '?';
//         const ajaxURL = state.path + stringValue + "side_menu=true";

//         // Perform the AJAX request
//         callAjax(ajaxURL, null, function (e) {
//             const jsonData = JSON.parse(e);
//             document.getElementById('parent').innerHTML = jsonData.content;

//             // Reset the flag after successful execution
//             isPopStateHandling = false;
//         }, 'GET');
//     } else {
//         isPopStateHandling = false; // Reset if no state or path
//     }
// });

function ajaxSend(url, data, responseId = "") {
    callAjax(url, data, function (responseText) {
        if (responseId) {
            const resId = document.querySelector(responseId);
            if (resId) {
                resId.innerHTML = responseText;
            }
        }
    });
}

function print_response(url, data, responseId, method = "POST") {
    callAjax(
        url,
        data,
        function (responseText) {
            document.querySelector(responseId).innerHTML = responseText;
        },
        method
    );
}

function ajaxModal(url, data, modalType = "", method = "POST") {
    var original_content = event.currentTarget;
    var oldHtml = original_content.innerHTML;
    original_content.innerHTML =
        '<div class="spinner-border spinner-border-sm" role="status"></div>';
    original_content.classList.add("disabled", "true");
    callAjax(
        url,
        data,
        function (responseText) {
            $("#basicModal").modal("show");
            if (modalType) {
                document
                    .getElementById("ajaxModalClass")
                    .classList.add(modalType);
            }
            original_content.classList.remove("disabled");
            original_content.innerHTML = oldHtml;

            var parser = new DOMParser();
            var doc = parser.parseFromString(responseText, "text/html");
            var resTitle = doc.getElementById("title");

            if (resTitle) {
                document.getElementById('modal_title').innerHTML = resTitle.innerHTML;
                resTitle.remove();
            }

            document.getElementById("ajax_response").innerHTML = doc.body.innerHTML;
        },
        method
    );
}

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        while (cookie.charAt(0) == " ") {
            cookie = cookie.substring(1, cookie.length);
        }
        if (cookie.indexOf(nameEQ) == 0) {
            return cookie.substring(nameEQ.length, cookie.length);
        }
    }
    return null;
}

function deleteCookie(name) {
    document.cookie =
        name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function ajaxFormSubmit(event) {
    event.preventDefault();

    var original_content = event.submitter;
    var oldHtml = original_content.innerHTML;

    original_content.innerHTML =
        '<div class="spinner-border spinner-border-sm" role="status"></div>';
    original_content.classList.add("disabled", "true");

    callAjax(
        event.target.action,
        new FormData(event.target),
        function (response) {
            try {
                var data = JSON.parse(response);

                if (typeof data === "object" && data !== null) {
                    if (data.status == false) {
                        toastr.options = {
                            progressBar: true,
                            closeButton: true,
                            toastClass: "toast-error",
                        };
                        toastr.success(data.msg, {
                            timeout: 12000,
                        });
                    } else if (data.status == true) {
                        setCookie("successCookie", data.msg, 1);
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.reload();
                        }
                    }

                    original_content.classList.remove("disabled");
                    original_content.innerHTML = oldHtml;
                } else {
                    alert('Invalid JSON responses');
                    original_content.classList.remove("disabled");
                    original_content.innerHTML = oldHtml;
                }
            } catch (error) {
                console.error(error);
                original_content.classList.remove("disabled");
                original_content.innerHTML = oldHtml;
            }
        }
    );
}

function sendObj(obj) {
    var formData = new FormData();

    function appendFormData(data, parentKey = '') {
        if (typeof data === 'object' && data !== null && !(data instanceof File)) {
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    const fullKey = parentKey ? `${parentKey}[${key}]` : key;
                    appendFormData(data[key], fullKey);
                }
            }
        } else {
            formData.append(parentKey, data);
        }
    }

    appendFormData(obj);
    return formData;
}

function getValueToForm(inputName) {
    const inputValue = document.querySelector(
        `input[name='${inputName}']`
    ).value;
    return inputValue;
}

function formToObj(formId, reset = false) {
    const formElement = document.getElementById(formId);
    const formData = new FormData(formElement);
    if (reset === true) {
        formElement.reset();
    }
    return formData;
}

function sendData(thisValue) {
    const name = thisValue.name;
    const value = thisValue.value;
    const formData = new FormData();
    formData.append(name, value);
    return formData;
}

// image validation
function imageValidate(element, maxWidth, maxHeight, sizeKb) {
    const file = element.files[0];
    const maxSizeInKbytes = sizeKb * 1024; // Maximum file size allowed (5MB)
    const allowedTypes = ["image/jpeg", "image/png", "image/jpg"]; // Allowed image types
    const fileType = file.type;
    if (!allowedTypes.includes(fileType)) {
        var nextSibling = element.nextElementSibling;
        nextSibling.textContent =
            "Allowed types are: " + allowedTypes.join(", ");
        element.value = "";
        return;
    }

    if (file.size > maxSizeInKbytes) {
        var nextSibling = element.nextElementSibling;
        nextSibling.textContent =
            "Image size exceeds the maximum limit of " +
            maxSizeInKbytes / 1024 +
            " Kbytes.";
        element.value = "";
        return;
    }

    const reader = new FileReader();
    reader.onload = function (event) {
        const img = new Image();
        img.onload = function () {
            const width = this.width;
            const height = this.height;
            if (width <= maxWidth && height <= maxHeight) {
                var nextSibling = element.nextElementSibling;
                nextSibling.textContent = "";
                return;
            } else {
                var nextSibling = element.nextElementSibling;
                nextSibling.textContent = `Image dimensions should not exceed ${maxWidth}x${maxHeight} pixels.`;
                element.value = "";
                return;
            }
        };
        img.src = event.target.result;
    };
    if (file) {
        reader.readAsDataURL(file);
    }
}

function validateSquareImage(element, sizeKb) {
    const file = element.files[0];
    const maxSizeInKbytes = sizeKb * 1024; // Maximum file size allowed (5MB)
    const allowedTypes = ["image/jpeg", "image/png", "image/jpg"]; // Allowed image types
    const fileType = file.type;
    if (!allowedTypes.includes(fileType)) {
        var nextSibling = element.nextElementSibling;
        nextSibling.textContent =
            "Allowed types are: " + allowedTypes.join(", ");
        element.value = "";
        return;
    }

    if (file.size > maxSizeInKbytes) {
        var nextSibling = element.nextElementSibling;
        nextSibling.textContent =
            "Image size exceeds the maximum limit of " +
            maxSizeInKbytes / 1024 +
            " Kbytes.";
        element.value = "";
        return;
    }

    const reader = new FileReader();
    reader.onload = function (event) {
        const img = new Image();
        img.onload = function () {
            const width = this.width;
            const height = this.height;
            if (width === height) {
                var nextSibling = element.nextElementSibling;
                nextSibling.textContent = "";
                return;
            } else {
                var nextSibling = element.nextElementSibling;
                nextSibling.textContent = `Image dimensions must be square not ${width}x${height} pixels.`;
                element.value = "";
                return;
            }
        };
        img.src = event.target.result;
    };
    if (file) {
        reader.readAsDataURL(file);
    }
}


