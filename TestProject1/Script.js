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
    hndFormChange();
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
    let sketch = false;
    for (let entry of formData) {
        let selector = document.querySelector("#lineart");
        if (entry[1] == "sketch") {
            sketch = true;
        }
        else if (sketch == false) {
            selector.disabled = false
            // selector.firstChild.setAttribute("disabled", true);
        }
        if (entry[0] == "lineart" && sketch == true) {
            entry[1] = "none_sketch";
            selector.disabled = true;
            selector.selectedIndex = 0;
            selector.value = "none_sketch";
        }
        let item = document.querySelector("[value='" + entry[1] + "']");
        let price = Number(item.getAttribute("price"));
        console.log(item, price);
        if (counter == 0) {
            priceTotal += price;
        }
        else {
            priceTotal *= price;
        }

        counter++;
    }
    priceHTML.innerHTML = Math.round((priceTotal + Number.EPSILON) * 100) / 100;
}

