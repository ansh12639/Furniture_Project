document.addEventListener("DOMContentLoaded", () => {
  const urlParams = new URLSearchParams(window.location.search);
  const productId = urlParams.get("id");

  console.log('Product ID:', productId);  // Check if the product ID is fetched correctly

  const cartContainer = document.querySelector(".cart-container");
  const subtotalEl = document.getElementById("subtotal");
  const productIdInput = document.getElementById("id");
  const quantityInput = document.getElementById("quantity");
  const totalInput = document.getElementById("total");

  if (!productId) {
    cartContainer.innerHTML = "<p>No product selected.</p>";
    return;
  }

  // Fetch product details when the page loads
  fetch(`DetailsPage.php?id=${productId}`)
    .then((res) => res.json())
    .then((item) => {
      let quantity = 1;
      const maxQuantity = parseInt(item.quantity);
      const price = parseFloat(item.price);
      let subtotal = price * quantity;

      const renderCartItem = () => {
        cartContainer.innerHTML = `
          <div class="product-item">
            <img src="${item.image_path}" alt="${item.name}" style="width: 150px; height: 150px; object-fit: cover;">
            <div class="product-info">
              <h3>${item.name}</h3>
              <p>Price: Rs ${price.toFixed(2)}</p>
              <div class="quantity-controls">
                <button class="decrease">-</button>
                <span class="qty-value">${quantity}</span>
                <button class="increase">+</button>
              </div>
              <p class="stock-warning" style="color: red; font-weight: bold;"></p>
              <p>Total: Rs <span class="subtotal-value">${subtotal.toFixed(2)}</span></p>
            </div>
          </div>
        `;

        const increaseBtn = cartContainer.querySelector(".increase");
        const decreaseBtn = cartContainer.querySelector(".decrease");
        const qtyDisplay = cartContainer.querySelector(".qty-value");
        const subtotalDisplay = cartContainer.querySelector(".subtotal-value");
        const stockWarning = cartContainer.querySelector(".stock-warning");

  const updateCart = () => {
    console.log('Updating cart with quantity:', quantity);  // Debugging: Check quantity being sent.

    fetch('cart_onclick.php', {
      method: 'POST',
      body: new URLSearchParams({
        action: 'update',
        product_id: productId,
        quantity: quantity
      })
    })
    .then((response) => response.json())
    .then((data) => {
      console.log('Response Data:', data);
      if (data.status === 'success') {
        updateDisplay();
      } else {
        stockWarning.textContent = data.message || 'An error occurred';
      }
    })
    .catch((err) => {
      console.error("Error updating cart:", err);
    });
  };

        const updateDisplay = () => {
          qtyDisplay.textContent = quantity;
          subtotal = quantity * price;
          subtotalDisplay.textContent = subtotal.toFixed(2);
          subtotalEl.textContent = `Rs ${subtotal.toFixed(2)}`;
          quantityInput.value = quantity;
          totalInput.value = subtotal.toFixed(2);
        };

  // Event listeners for quantity increase/decrease
  increaseBtn.addEventListener("click", () => {
    if (quantity < maxQuantity) {
      quantity++;
      stockWarning.textContent = "";
      updateCart();
    } else {
      stockWarning.textContent = "Insufficient stock!";
    }
  });

  decreaseBtn.addEventListener("click", () => {
    if (quantity > 1) {
      quantity--;
      stockWarning.textContent = "";
      updateCart();
    }
  });

  updateDisplay(); // Make sure it's updated on first render
      };

      renderCartItem();

      productIdInput.value = item.id;
      quantityInput.value = quantity;
      totalInput.value = subtotal.toFixed(2);
    })
    .catch((err) => {
      console.error("Error fetching product:", err);
      cartContainer.innerHTML = "<p>Failed to load product.</p>";
    });
});
