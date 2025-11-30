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
            qty: 1,
            desc: desc,
            img: img,
            note: ""
        });
    }

    localStorage.setItem("cart", JSON.stringify(cart));

    alert(name + " added to cart!");

    // نقل لصفحة المنتج
    window.location.href = "item.html";
});


// الضغط على الصورة أو العنوان يفتح صفحة المنتج
$(document).on("click", ".item img, .item h3", function () {
    
    let parent = $(this).closest(".item");

    let selectedItem = {
        name: parent.data("name"),
        price: parent.data("price"),
        desc: parent.data("desc"),
        img: parent.data("img")
    };

    localStorage.setItem("selectedItem", JSON.stringify(selectedItem));
    window.location.href = "item.html";
});
