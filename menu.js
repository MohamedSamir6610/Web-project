let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Add to Cart + redirect
$(document).on("click", ".add-to-cart", function () {
    const name = $(this).data("name");
    const price = Number($(this).data("price"));

    const existing = cart.find(i => i.name === name);

    if(existing) existing.qty++;
    else cart.push({ name, price, qty: 1, note: "" });

    localStorage.setItem("cart", JSON.stringify(cart));

    alert(`${name} added to cart!`);

    // تأخير صغير بعد alert عشان النقل يشتغل
    setTimeout(() => {
        window.location.href = "item.html"; // حط اسم الصفحة اللي عايز تروح لها
    }, 100);
});


function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

renderCart();

$("#cart-footer").append(`
    <button class="checkout-btn">Checkout</button>
`);

// Checkout Button Event
$(document).on("click", ".checkout-btn", function () {
    if(cart.length === 0) {
        alert("Your cart is empty! Add some items first.");
    } 
    else {
        //window.location.href = "cart web project.html"; // open checkout page
    }
});

// Click on item image or title → go to item page
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