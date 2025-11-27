let cart = JSON.parse(localStorage.getItem("cart")) || [];


$(document).on("click", ".add-to-cart", function () {
    const name = $(this).data("name");
    const price = Number($(this).data("price"));

   
    const existing = cart.find(i => i.name === name);
    existing ? existing.qty++ : cart.push({ name, price, qty: 1 });

    saveCart();
});

function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

renderCart();
$("#cart-footer").append(`
    <button class="checkout-btn">Checkout</button>
`);

 // Load existing cart on page load
$("#checkout-button").on("click", function() {
    if(cart.length === 0) {
        alert("Your cart is empty! Add some items first.");
    } //else {
        //window.location.href = "cart web project.html"; // open checkout page
    //}
});
