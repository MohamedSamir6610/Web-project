let cart = JSON.parse(localStorage.getItem("cart")) || [];

function renderCart() {
    $("#cart-items").empty();
    let total = 20; // delivery

    cart.forEach(item => {
        total += item.price * item.qty;
        $("#cart-items").append(`
            <div class="cart-block">
                <h4>${item.name} × ${item.qty}</h4>
                <p>Note: ${item.note || "No note"}</p>
                <p>${item.price * item.qty} EGP</p>
            </div><hr>
        `);
    });

    $("#total").text(total);
}

renderCart();

$("#checkout").on("click", function() {
    if($("#address").val() === "") { alert("Please enter your address"); return; }
    alert("Order placed successfully!");
    localStorage.removeItem("cart");
    window.location.href = "menu.html";
});
