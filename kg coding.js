const CONVENIENCE_FEES = 99;
let bagItemObjects;
onLoad();

function onLoad() {
  loadBagItemObjects();
  displayBagItems();
  displayBagSummary();
}

function displayBagSummary() {
  let bagSummaryElement = document.querySelector(".right");
  let totalItem = bagItemObjects.length;
  let totalMRP = 0;
  let totalDiscount = 0;

  bagItemObjects.forEach((bagItem) => {
    totalMRP += bagItem.original_price;
    totalDiscount += bagItem.original_price - bagItem.current_price;
  });

  let finalPayment = totalMRP - totalDiscount + CONVENIENCE_FEES;

  bagSummaryElement.innerHTML = `<input type="text" placeholder="Promo Code" />
            <button class="apply-btn">Apply</button>

            <div class="summary">
              <p>PRICE DETAILS (${totalItem} items)</p>
              <p>Subtotal <b>${totalMRP}</b></p>
              <p>Discount on MRP <b>${totalDiscount}</b></p>
              <p><strong>Convenience Fee</strong> <b>Rs 99</b></p>
              <p><strong>Total payment</strong> <b>Rs ${finalPayment}</b></p>
              <p style="font-size: 14px; color: gray">
                or 4 interest-free payments of $1 00.00 with
                <strong>Afterpay</strong>
              </p>
            </div>

            <div class="gift-message">
              <input type="checkbox" id="gift" />
              <label for="gift">Add a gift message</label>
            </div>

            <div class="checkout-options">
              <button class="paypal">PayPal Checkout</button>
              <button class="afterpay">Checkout with Afterpay</button>
              <button class="checkout">Checkout</button>
            </div>`;
}

function loadBagItemObjects() {
  console.log(bagItems);
  bagItemObjects = bagItems.map((feutureItemId) => {
    for (let i = 0; i < feutureItems.length; i++) {
      if (feutureItemId == feutureItems[i].id) {
        return feutureItems[i];
      }
    }
  });
  console.log(bagItemObjects);
}

function displayBagItems() {
  let containerElement = document.querySelector(".left-product");
  let innerHTML = "";
  bagItemObjects.forEach((bagItem) => {
    innerHTML += generateItemHTML(bagItem);
  });
  containerElement.innerHTML = innerHTML;
}

function removeFromBag(itemId) {
  bagItems = bagItems.filter((bagItemId) => bagItemId != itemId);
  localStorage.setItem("bagItems", JSON.stringify(bagItems));
  loadBagItemObjects();
  cartCount();
  displayBagItems();
  displayBagSummary();
}

function generateItemHTML(feutureItem) {
  return `<div class="product">
              <img src="../${feutureItem.image}" alt="Product" />
              <div class="product-details">
                <h2>${feutureItem.product_brand}</h2>
                <p>${feutureItem.product_name}</p>
                <p>In Stock</p>
                <a href="#">Edit</a>
                <div class="price-section">
                  <span class="old-price">Rs ${feutureItem.original_price}</span>
                  <span class="new-price">Rs ${feutureItem.current_price}</span>
                </div>
                <div class="qty">
                  Qty: <input type="number" value="1" min="1" />
                </div>
              </div>
              <span class="remove-btn" onclick="removeFromBag(${feutureItem.id})">X</span>
            </div>`;
}
