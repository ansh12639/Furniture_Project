// image slider

let slideIndex = 0;
let slides = document.querySelectorAll(".slide");
let totalSlides = slides.length;

function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.remove("active");
    if (i === index) {
      slide.classList.add("active");
    }
  });
}

function changeSlide(n) {
  slideIndex = (slideIndex + n + totalSlides) % totalSlides;
  showSlide(slideIndex);
}

// Auto slide
setInterval(() => {
  changeSlide(1);
}, 5000); // 5 seconds

let bagItems;

onLoad();

function onLoad() {
  let bagItemStr = localStorage.getItem("bagItems");
  bagItems = bagItemStr ? JSON.parse(bagItemStr) : [];
  displayFeutureItems();
  cartCount();
}

function addToBag(feutureItemid) {
  bagItems.push(feutureItemid);
  localStorage.setItem("bagItems", JSON.stringify(bagItems));
  cartCount();
}

function cartCount() {
  let cartCountElement = document.querySelector(".cartcount");
  if (!cartCountElement) return;

  fetch('get_cart_count.php')
    .then(response => response.json())
    .then(data => {
      // If server returns a valid count (user is logged in), use it
      if (data && typeof data.count !== 'undefined') {
        cartCountElement.style.visibility = data.count > 0 ? "visible" : "hidden";
        cartCountElement.innerText = data.count;
      } else {
        // Fallback to local storage
        if (bagItems && bagItems.length > 0) {
          cartCountElement.style.visibility = "visible";
          cartCountElement.innerText = bagItems.length;
        } else {
          cartCountElement.style.visibility = "hidden";
        }
      }
    })
    .catch(error => {
      console.error('Error fetching cart count:', error);
      // Fallback on error
      if (bagItems && bagItems.length > 0) {
        cartCountElement.style.visibility = "visible";
        cartCountElement.innerText = bagItems.length;
      } else {
        cartCountElement.style.visibility = "hidden";
      }
    });
}


function displayFeutureItems() {
  let feutureItemsContainer = document.querySelector(
    "#feuture-items-container"
  );
  if (!feutureItemsContainer) {
    return;
  }
  let innerHtml = "";

  feutureItems.forEach((feutureItem) => {
    innerHtml += `<div class="feuture-product">
        <div class="fueture-image">
          <img src="${feutureItem.image}" alt="" />
        </div>
        <div class="feuture-product-title">
          <h2 class="brand-name">${feutureItem.product_brand}</h2>
          <h3 class="product-name">${feutureItem.product_name}</h3>
        </div>
        <div class="price">
          <span class="current-price">Rs ${feutureItem.current_price}</span>
          <span class="original-price">Rs ${feutureItem.original_price}</span>
          <span class="discount">${feutureItem.discount}% Off</span>
        </div>
        <button class="add-to-cart-btn" onclick="addToBag(${feutureItem.id})">add to cart</button>
      </div>`;
  });

  feutureItemsContainer.innerHTML = innerHtml;
}
