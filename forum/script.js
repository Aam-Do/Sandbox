window.addEventListener("load", hndLoad);

let postButton;
let nameInput;
let headingInput;
let contentInput;

function hndLoad() {
    postButton = document.querySelector("#submit");
    nameInput = document.querySelector("#name");
    headingInput = document.querySelector("#heading");
    contentInput = document.querySelector("#content");

    let postForm = document.querySelector("#postForm");
    postForm.addEventListener("change", hndPostFormChange);
}

function hndPostFormChange() {
    if (nameInput.value && headingInput.value && contentInput.value) {
        postButton.disabled = false;
    }
    else {
        postButton.disabled = true;
    }
}