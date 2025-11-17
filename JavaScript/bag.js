let bagItemsObjects;

onLoad();

function onLoad(){
  loadBagItemObjects();
  displayBagItems();
  generateItemHtml();
}





function loadBagItemObjects(){
  bagItemsObjects = bagItems.map( sofaItemid => {
    for(let i = 0; i <sofaItems.length; i++){
      if(sofaItemid == sofaItems[i].id){
        return sofaItems[i];
      }
    }
  })
}
function displayBagItems(){
  let bagContainerElement = document.querySelector('.product-section');
  let innerHTML = '';
  bagItemsObjects.forEach(bagItem => {
    innerHTML += generateItemHtml(bagItem)
  });
  bagContainerElement.innerHTML = innerHTML;
}

function removeFromBag(sofaItemid){
  bagItems = bagItems.filter(bagItemid => bagItemid != sofaItemid);
  localStorage.setItem('bagItems', JSON.stringify(bagItems));
  loadBagItemObjects();
  displayBagIcon();
  displayBagItems();
  displayBagSummary()
}



function generateItemHtml(sofaItem){
  return `
        <div class="product-details">
        <img src="${sofaItem.item_image}"/>
        <div class="title">
          <h3>${sofaItem.company_name}</h3>
          <p>${sofaItem.item_name}</p>
          <p><strong>Rs${sofaItem.current_price}</strong> <del>Rs${sofaItem.original_price}</del>${sofaItem.discount_price} (0% OFF)</p>
          <p><strong></strong> ${sofaItem.return_days}</p>
          <p><span>${sofaItem.delivery}</span></p>
        </div>
         <div class="remove-from-cart" onclick="removeFromBag(${sofaItem.id})">X</div>
         </div>
  `
}

