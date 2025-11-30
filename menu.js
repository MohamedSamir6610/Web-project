let cart = JSON.parse(localStorage.getItem("cart")) || [];

// زرار Add To Cart
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

    // نخزن بيانات المنتج للصفحة التانية
    localStorage.setItem("selectedItem", JSON.stringify(selectedItem));

    // نشوف هو موجود في الكارت ولا لأ
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

    // الرسالة النهائية بس الاسم والسعر
    alert(name + " - " + price + " EGP");

    // نقل لصفحة المنتج
    window.location.href = "item.html";
});
