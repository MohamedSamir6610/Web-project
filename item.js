let item = JSON.parse(localStorage.getItem("selectedItem"));
let qty = 1;

$("#item-img").attr("src", item.img);
$("#item-name").text(item.name);
$("#item-desc").text(item.desc);
$("#item-price").text(item.price + " EGP");

$("#plus").on("click", function() { qty++; $("#qty").text(qty); });
$("#minus").on("click", function() { if(qty>1) qty--; $("#qty").text(qty); });

$("#addCart").on("click", function() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const existing = cart.find(i => i.name === item.name);
    if(existing) existing.qty += qty;
    else cart.push({
        name: item.name,
        price: item.price,
        qty: qty,
        note: $("#note").val()
    });

    localStorage.setItem("cart", JSON.stringify(cart));
    alert("Added to cart!");
    window.location.href = "cart.html";
});
