document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".best-selling-slider");
    const prevBtn = document.getElementById("best-selling-prevBtn");
    const nextBtn = document.getElementById("best-selling-nextBtn");
    let slideWidth = document.querySelector(".best-selling-product").offsetWidth + 15;
    let autoScroll;

    function cloneSlides() {
        document.querySelectorAll(".best-selling-product").forEach(product => {
            slider.appendChild(product.cloneNode(true));
        });
    }

    cloneSlides();

    function scrollNext() {
        slider.style.transition = "transform 0.4s ease-in-out";
        slider.style.transform = `translateX(-${slideWidth}px)`;
        setTimeout(() => {
            slider.appendChild(slider.firstElementChild);
            slider.style.transition = "none";
            slider.style.transform = "translateX(0)";
        }, 400);
    }

    function scrollPrev() {
        slider.prepend(slider.lastElementChild);
        slider.style.transition = "none";
        slider.style.transform = `translateX(-${slideWidth}px)`;
        setTimeout(() => {
            slider.style.transition = "transform 0.4s ease-in-out";
            slider.style.transform = "translateX(0)";
        }, 10);
    }

    nextBtn.addEventListener("click", () => {
        clearInterval(autoScroll);
        scrollNext();
        autoScroll = setInterval(scrollNext, 3000);
    });

    prevBtn.addEventListener("click", () => {
        clearInterval(autoScroll);
        scrollPrev();
        autoScroll = setInterval(scrollNext, 3000);
    });

    autoScroll = setInterval(scrollNext, 3000);

    // ================================
    // Add to Cart Functionality 
    // ================================
    function addToCart(name, price, quantity) {
        if (quantity <= 0) {
            alert("Please enter a valid quantity");
            return;
        }

        let formData = new URLSearchParams();
        formData.append("name", name);
        formData.append("price", price);
        formData.append("quantity", quantity);

        fetch("add_to_cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: formData.toString()
        })
        .then(response => response.json()) // Expect JSON
        .then(data => {
            if (data.success) {
                alert(data.success);
            } else {
                alert("Error: " + data.error);
            }
        })
        .catch(error => {
            console.error("Fetch Error:", error);
            alert("Failed to add item to cart.");
        });
    }

    // Attach event listeners to all "Add to Cart" buttons
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function () {
            let productDiv = this.closest(".best-selling-product");
            let name = productDiv.querySelector("h3").innerText;
            let priceText = productDiv.querySelector("p").innerText;
            let price = priceText.match(/\d+/)[0]; // Extract price from text
            addToCart(name, price, 1); // Default quantity is 1
        });
    });
});
