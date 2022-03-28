window.addEventListener("load", hndLoad);

let contactInput;
let submitButton;
let form;

function hndLoad() {
    submitButton = document.querySelector("#submitButton");
    contactInput = document.querySelector("#contact");
    contactInput.addEventListener("change", hndChange);
    form = document.querySelector("#commissionForm");
    form.addEventListener("change", hndFormChange);
}

function hndChange() {
    if (contactInput.value) {
        submitButton.disabled = false;
    }
    else {
        submitButton.disabled = true;
    }
}

function hndFormChange(_event) {
    let priceHTML = document.querySelector("#estimatedTotal")
    priceHTML.innerHTML = "";
    let priceTotal = 0;
    let formData = new FormData(document.forms[0]);
    let counter = 0;
    for (let entry of formData) {
        console.log(entry);
        let item = document.querySelector("[value='" + entry[1] + "']");
        let price = Number(item.getAttribute("price"));
        if (counter == 0) {
            priceTotal += price;
        }
        else {
            priceTotal *= price;
        }
        counter++;
    }
    priceHTML.innerHTML = Math.round((priceTotal + Number.EPSILON) * 100) / 100;

    console.log(formData[1])
    if (formData[1][1] == "sketch") {
        console.log("sketch")
    }
}

