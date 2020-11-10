window.isMobile = /iphone|ipod|ipad|android|blackberry|opera mini|opera mobi|skyfire|maemo|windows phone|palm|iemobile|symbian|symbianos|fennec/i.test(navigator.userAgent.toLowerCase());

const mainContainerEl = document.querySelector(".types");
const basketEl = document.querySelector(".basket-inner");

let itemsInBasket = {};


wasteTypes.forEach(element => {
    const newEl = document.createElement("div");
    newEl.classList.add("type");

    newEl.innerHTML = `

        <span class="name">
           <b> ${element.name} </b>
        </span>
        <br>
        <span class="buttons">
            <button class="btn btn-outline-success add hidden"><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
            <button class="btn btn-outline-danger remove hidden"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </span>

    `;

    newEl.querySelector(".add").addEventListener('click', () => {
        if (!itemsInBasket[element.name]) itemsInBasket[element.name] = 1;
        else itemsInBasket[element.name]++;
        addBasket(element);
    });
    newEl.querySelector(".remove").addEventListener('click', () => {

        removeBasket(element)
    });

    if (!window.isMobile) {
        newEl.addEventListener("mouseenter", () => {
            newEl.classList.toggle("hover", true);
            newEl.querySelector(".buttons").style.display = "unset";
        });

        newEl.addEventListener("mouseleave", () => {
            newEl.classList.toggle("hover", false);
            newEl.querySelector(".buttons").style.display = "none";
        });
    }



    mainContainerEl.appendChild(newEl);

});

document.querySelector(".submit-button").addEventListener("click", () => {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            document.querySelector(".notification").innerHTML +=
                `
            <div class='border alert alert-info alert-dismissable fade show'>${this.responseText}<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button></div>
            `;
        }
    };
    xhttp.open("POST", "responseTest.php?d=" + JSON.stringify(itemsInBasket), true);
    xhttp.send();

    itemsInBasket = {};
    document.querySelector(".basket").style.display = "none";
    document.querySelector(".basket-inner").innerHTML = "";
});

function addBasket(element) {
    if (itemsInBasket[element.name] == 1) {
        const basketItemEl = document.createElement("div");
        basketItemEl.classList.add("basket-item");
        basketItemEl.id = element.name;

        basketItemEl.innerHTML =
            `
            <span class="item-name"><b>${element.name}</b></span>
            <div>
                <span class="amount">Ilość: ${itemsInBasket[element.name]}</span>
                <button class="btn btn-outline-danger remove hidden"><i class="fa fa-trash" aria-hidden="true"></i></button>
            </div>
            `;

        basketItemEl.querySelector("button.remove").addEventListener("click", () => removeBasket(element));

        basketEl.appendChild(basketItemEl);
    }
    else if (itemsInBasket[element.name]) {
        document.querySelector("#" + element.name + " .amount").innerHTML = "Ilość: " + itemsInBasket[element.name];
    }
    console.log(itemsInBasket);
    if (!(Object.keys(itemsInBasket).length === 0 && itemsInBasket.constructor === Object)) {
        document.querySelector(".basket").style.display = "block";
    }
    else {
        document.querySelector(".basket").style.display = "none";
    }
}

function removeBasket(element) {
    if (itemsInBasket[element.name]) {
        itemsInBasket[element.name]--;
        document.querySelector("#" + element.name + " .amount").innerHTML = "Ilość: " + itemsInBasket[element.name];
    }
    if (itemsInBasket[element.name] == 0) {
        delete itemsInBasket[element.name];
        document.querySelector("#" + element.name)?.remove();
    }
    if (!(Object.keys(itemsInBasket).length === 0 && itemsInBasket.constructor === Object)) {
        document.querySelector(".basket").style.display = "block";
    }
    else {
        document.querySelector(".basket").style.display = "none";
    }
    console.log(itemsInBasket);
}