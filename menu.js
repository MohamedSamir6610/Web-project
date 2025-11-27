let cart = JSON.parse(localStorage.getItem("cart")) || [];


$(document).on("click", ".add-to-cart", function () {
    const name = $(this).data("name");
    const price = Number($(this).data("price"));

    const existing = cart.find(i => i.name === name);
    if(existing) existing.qty++;
    else cart.push({ name, price, qty: 1, note: "" });

    localStorage.setItem("cart", JSON.stringify(cart));
    alert(`${name} added to cart!`);
});


$(document).on("click", ".item img, .item h3", function () {
    const parent = $(this).closest(".item");
    const selectedItem = {
        img: parent.data("img"),
        name: parent.data("name"),
        desc: parent.data("desc"),
        price: parent.data("price")
    };
    localStorage.setItem("selectedItem", JSON.stringify(selectedItem));
    window.location.href = "item.html";
});
