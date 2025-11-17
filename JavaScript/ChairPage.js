// chair display section 
displayChairItems();

function displayChairItems(){
  let itemsContainerElement = document.querySelector('.chair-items-container');
 let innerHtml = '';



 chairItems.forEach( (chairItem) => {
  innerHtml += `<div class="chair-item-container">
        <img class="chair-item-img" src="${chairItem.item_image}" alt="item image" />
        <div class="company-name">${chairItem.company_name}</div>
        <div class="item-name">${chairItem.item_name}</div>
        <div class="price">
          <span class="current-price">Rs${chairItem.current_price}</span>
          <span class="original-price">Rs${chairItem.original_price}</span>
          <span class="discount">(${chairItem.discount_price} OFF)</span>
        </div>
        <button class="add-to-bag-btn" onclick="addToBag(${chairItem.id})">Add To Cart</button>
      </div>`
 } )


 itemsContainerElement.innerHTML = innerHtml;
}