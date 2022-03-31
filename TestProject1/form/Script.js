window.addEventListener("load", hndLoad);

let contactInput;
let descriptionInput;
let agreeCheckbox;
let form;
let modalButton;
let modalBody;
let formData;

function hndLoad() {
    contactInput = document.querySelector("#contact");
    descriptionInput = document.querySelector("#description");
    agreeCheckbox = document.querySelector("#termsCheck");
    modalButton = document.querySelector("#modalButton");
    modalButton.addEventListener("click", hndModalOpen);
    modalBody = document.querySelector(".modal-body")
    form = document.querySelector("#commissionForm");
    form.addEventListener("change", hndFormChange);
    hndFormChange();
}

function hndModalOpen() {
    modalBody.innerHTML = "";
    let p1 = document.createElement("p");
    p1.innerHTML = "<b>Review your commission before you submit it!</b>"
    let p2 = document.createElement("p");
    p2.innerHTML = `<b>Type:</b> ${formData.get("type")}<br><b>Render style:</b> ${formData.get("render")}<br><b>Artstyle:</b> ${formData.get("style")}<br><b>Lineart Style:</b> ${formData.get("lineart")}<br><b>Size:</b> ${formData.get("size")}<br><b>Description:</b> ${formData.get("description")}<br><b>Contact:</b> ${formData.get("contactMedia")}: ${formData.get("contact")}`;
    modalBody.appendChild(p1);
    modalBody.appendChild(p2);    
}

function hndFormChange(_event) {
    let priceHTML = document.querySelector("#estimatedTotal")
    priceHTML.innerHTML = "";
    let priceTotal = 0;
    formData = new FormData(document.forms[0]);
    let counter = 0;
    let sketch = false;
    for (let entry of formData) {
        let selector = document.querySelector("#lineart");
        if (entry[1] == "sketch") {
            sketch = true;
        }
        else if (sketch == false) {
            selector.setAttribute("readonly", false);
        }
        if (entry[0] == "lineart" && sketch == true) {
            entry[1] = "none - sketch";
            selector.setAttribute("readonly", true);
            selector.selectedIndex = 0;
            selector.value = "none - sketch";
        }
        let item = document.querySelector("[value='" + entry[1] + "']");
        let price = Number(item.getAttribute("price"));
        if (counter == 0) {
            priceTotal += price;
        }
        else {
            priceTotal *= price;
        }

        counter++;
        if (counter >= 5) {
            break;
        }
    }
    priceHTML.innerHTML = Math.round((priceTotal + Number.EPSILON) * 100) / 100;

    if (contactInput.value && descriptionInput.value && agreeCheckbox.checked) {
        modalButton.disabled = false;
    }
    else {
        modalButton.disabled = true;
    }
}

