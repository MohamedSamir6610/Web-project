let cart = JSON.parse(localStorage.getItem("cart")) || [];


$(document).on("click", ".add-to-cart", function () {

    let name = $(this).data("name");
    let price = Number($(this).data("price"));
    let desc = $(this).data("desc");
    let img = $(this).data("img");

    let selectedItem = {
        name: name,
        price: price,
        desc: desc,
        img: img
    };


    localStorage.setItem("selectedItem", JSON.stringify(selectedItem));


    let existing = cart.find(item => item.name === name);

    if (existing) {
        existing.qty += 1;
    } else {
        cart.push({
            name: name,
            price: price,
            qty: 0,
            desc: desc,
            img: img,
            note: ""
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));


    alert(name + " - " + price + " EGP");


    window.location.href = "item.html";
});
