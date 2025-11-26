let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Add item
$(document).on("click", ".add-to-cart", function () {
  const name = $(this).data("name");
  const price = Number($(this).data("price"));

  const existing = cart.find(i => i.name === name);

  existing ? existing.qty++ : cart.push({ name, price, qty: 1 });

  saveCart();
  renderCart();
});

// Render cart
function renderCart() {
  $("#cart").empty();
  let total = 0;

  cart.forEach((item, index) => {
    total += item.price * item.qty;

    $("#cart").append(`
      <div class="cart-item">
        ${item.name} — ${item.price} EGP × ${item.qty}
        <div>
          <button class="increase" data-index="${index}">+</button>
          <button class="decrease" data-index="${index}">-</button>
          <button class="remove" data-index="${index}">Remove</button>
        </div>
      </div>
    `);
  });

  $("#total").text(total);
}

// Increase quantity
$(document).on("click", ".increase", function () {
  cart[$(this).data("index")].qty++;
  saveCart();
  renderCart();
});

// Decrease quantity
$(document).on("click", ".decrease", function () {
  const i = $(this).data("index");
  cart[i].qty--;
  if (cart[i].qty <= 0) cart.splice(i, 1);
  saveCart();
  renderCart();
});

// Remove item
$(document).on("click", ".remove", function () {
  cart.splice($(this).data("index"), 1);
  saveCart();
  renderCart();
});

// Save to LocalStorage
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
    } else {
        window.location.href = "cart web project.html"; // open checkout page
    }
});