window.addEventListener("load", hndLoad);

let contactInput;
let submitButton;

function hndLoad() {
    submitButton = document.querySelector("#submitButton");
    contactInput = document.querySelector("#contact");
    contactInput.addEventListener("change", hndChange);
}

function hndChange() {
    if (contactInput.value) {
        submitButton.disabled = false;
    }
    else {
        submitButton.disabled = true;
    }
}

