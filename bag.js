let bagItemObejcts;
onLoad();

function onLoad() {
  loadBagItems();
  displayBagItems();
  displayBagSummary();
}

// function loadBagItems() {
//   console.log(bagItems);
//   bagItemObejcts = bagItems.map((feutureItemid) => {
//     for (let i = 0; i < feutureItems.length; i++) {
//       if (feutureItemid == feutureItems[i].id) {
//         return feutureItems[i];
//       }
//     }
//   });
//   console.log(bagItemObejcts);
// }

function displayBagSummary() {
  let bagSummaryRightElement = document.querySelector(".right");
  let totalItem = bagItemObejcts.length;
  let totalDiscount = 0;
  let totalMRP = 0;
  let finalPayment = 0;
  bagSummaryRightElement.innerHTML = `<input type="text" placeholder="Promo Code" />
            <button class="apply-btn">Apply</button>

            <div class="summary">
              <p>PRICE DETAILS (${totalItem} items)</p>
              <p>Subtotal <b>${totalMRP}</b></p>
              <p>Discount on MRP <b>${totalDiscount}</b></p>
              <p><strong>Convenience Fee</strong> <b>Rs 99</b></p>
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

function loadBagItems() {
  console.log(bagItems);
  bagItemObejcts = bagItems
    .map((feutureItemid) =>
      feutureItems.find((item) => item.id == feutureItemid)
    )
    .filter((item) => item !== undefined);
  console.log(bagItemObejcts);
}

function loadBagItemObjects() {
  console.log(bagItems);
  bagItemObejcts = bagItems.map((feutureItemsid) => {
    for (let i = 0; i < feutureItems.length; i++) {
      if (feutureItemsid == feutureItems[i].id) {
        return feutureItems[i];
      }
    }
  });
  console.log(bagItemObjects);
}

console.log("bagItems array: ", bagItems, bagItemObejcts);

function displayBagItems() {
  let leftContainerSummaryElement = document.querySelector(".left-product");
  let innerHTML = "";
  bagItemObejcts.forEach((bagItem) => {
    innerHTML += generateItemsHtml(bagItem);
  });
  leftContainerSummaryElement.innerHTML = innerHTML;
}

// id: "1",
//     image: "./Images/sofa image/Sofa (13).webp",
//     product_brand: "unknoen name",
//     product_name: "unknoen name",
//     current_price: 1499,
//     original_price: 2999,
//     discount: 50,
//     delivery_date: 10,feutureItem

function removeFromBag(itemId) {
  bagItems = bagItems.filter((bagItemId) => bagItemId != itemId);
  localStorage.setItem("bagItems", JSON.stringify(bagItems));
  // loadBagItemObjects();
  loadBagItems();
  displayBagItems();
}

function generateItemsHtml(feutureItem) {
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
