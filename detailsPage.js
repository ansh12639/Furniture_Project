document.addEventListener("DOMContentLoaded", () => {
  updateCartCount();
});

const urlParams = new URLSearchParams(window.location.search);
const productId = urlParams.get("id");

const loadingEl = document.getElementById("loading");
const errorEl = document.getElementById("error-message");
const container = document.getElementById("product-container");

function showLoading() {
  loadingEl.style.display = "block";
  errorEl.style.display = "none";
  container.style.display = "none";
}

function showError(message) {
  loadingEl.style.display = "none";
  errorEl.style.display = "block";
  errorEl.textContent = message;
  container.style.display = "none";
}

function showProduct(data) {
  loadingEl.style.display = "none";
  errorEl.style.display = "none";
  container.style.display = "flex";

  container.innerHTML = `
    <img src="${data.image_path}" alt="${data.name}">
    <div class="info">
        <h3>${data.name}</h3>
        <p><small>${data.info}</small></p>
        <p><strong>Description:</strong> ${data.description}</p>
        <p><strong>Price:</strong> Rs${data.price}</p>
        <br>
        <button id="add-to-cart" class="add-to-cart-button" data-id="${data.id}">Add to Cart</button>
    </div>
  `;

  const addToCartButton = document.getElementById("add-to-cart");
  addToCartButton.addEventListener("click", () => {
    const productId = addToCartButton.getAttribute("data-id");
    const quantity = 1;

    // Check if the user is logged in
    fetch('check_login.php')  // Check login status
      .then((response) => response.json())
      .then((result) => {
        if (result.loggedIn) {
          // User is logged in, proceed with adding the product to the cart
          fetch("addToCart.php", {
              method: "POST",
              headers: {
                  "Content-Type": "application/json",
              },
              body: JSON.stringify({ id: productId, quantity: quantity })


          })
          .then((response) => response.json())
          .then((result) => {
              if (result.success) {
                  updateCartCount();
                  // Redirect to the cart page after a short delay
                  setTimeout(() => {
                      window.location.href = `cart_onclick.php?id=${productId}`;
                  }, 500);
              } else {
                  showToast("Failed to add product to cart.");
              }
          })
          .catch((error) => {
              console.error("Error adding to cart:", error);
              showToast("Error adding to cart.");
          });
        } else {
          // If the user is not logged in, redirect to login page
          window.location.href = "login.html";
        }
      })
      .catch((error) => {
        console.error('Error checking login status:', error);
        showToast("Error checking login status.");
      });
  });
}

function showToast(message) {
  let toast = document.createElement("div");
  toast.textContent = message;
  toast.style.position = "fixed";
  toast.style.bottom = "20px";
  toast.style.left = "50%";
  toast.style.transform = "translateX(-50%)";
  toast.style.backgroundColor = "#bb1e1e";
  toast.style.color = "white";
  toast.style.padding = "10px 20px";
  toast.style.borderRadius = "8px";
  toast.style.boxShadow = "0 2px 10px rgba(0,0,0,0.2)";
  toast.style.zIndex = "1000";
  toast.style.opacity = "0";
  toast.style.transition = "opacity 0.5s ease";

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = "1";
  }, 100);

  setTimeout(() => {
    toast.style.opacity = "0";
    setTimeout(() => {
      document.body.removeChild(toast);
    }, 500);
  }, 3000);
}

if (productId) {
  showLoading();
  fetch(`detailsPage.php?id=${productId}`)
    .then((response) => response.json())
    .then((data) => {
      if (!data.error) {
        showProduct(data);
      } else {
        showError("Product not found.");
      }
    })
    .catch(() => {
      showError("Failed to load product details.");
    });
} else {
  showError("Product ID is missing.");
}

function updateCartCount() {
  fetch('get_cart_count.php')
    .then(response => response.json())
    .then(data => {
      const cartCountElement = document.querySelector('.cartcount');
      if (cartCountElement) {
        cartCountElement.textContent = data.count;
      }
    })
    .catch(error => {
      console.error('Error fetching cart count:', error);
    });
}
