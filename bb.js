document.addEventListener("DOMContentLoaded", function () {
    const readBtn = document.getElementById("readBtn");
    const moreText = document.getElementById("moreText");

    readBtn.addEventListener("click", function () {
        if (moreText.classList.contains("hidden")) {
            moreText.classList.remove("hidden");
            readBtn.textContent = "Read Less";
        } else {
            moreText.classList.add("hidden");
            readBtn.textContent = "Read More";
        }
    });
});