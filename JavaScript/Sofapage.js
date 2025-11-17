 // Sofa Items page section
 
 let bagItems = [];
 onLoad()

 function onLoad(){
  let bagItemsStr = localStorage.getItem('bagItems');
  bagItems = bagItemsStr ? JSON.parse(bagItemsStr) : [];
  displaySofaItems()
  displayBagIcon()
 }



 function addToBag(sofaItemid){
  bagItems.push(sofaItemid)
  localStorage.setItem('bagItems', JSON.stringify(bagItems));
  displayBagIcon()
 }

 function displayBagIcon(){
  let bagItemsCountElement = document.querySelector('.bag-item-count');
  if(bagItems.length > 0){
    bagItemsCountElement.style.visibility = 'visible';
    bagItemsCountElement.innerText = bagItems.length;
  }else{
    bagItemsCountElement.style.visibility = 'hidden';
  }
 }

 function displaySofaItems(){
  let itemsContainerElement = document.querySelector('.sofa-items-container');
  if(!itemsContainerElement){
    return
  }
  let innerHtml = ''; 
  sofaItems.forEach( (sofaItem) => {
   innerHtml += `<div class="sofa-item-container">
         <img class="sofa-item-img" src="${sofaItem.item_image}" alt="item image" />
         <div class="company-name">${sofaItem.company_name}</div>
         <div class="item-name">${sofaItem.item_name}</div>
         <div class="price">
           <span class="current-price">Rs${sofaItem.current_price}</span>
           <span class="original-price">Rs${sofaItem.original_price}</span>
           <span class="discount">(${sofaItem.discount_price} OFF)</span>
         </div>
         <button class="add-to-bag-btn" onclick="addToBag(${sofaItem.id})">Add To Cart</button>
       </div>
       `
  } )
  
  
  
  itemsContainerElement.innerHTML = innerHtml;
 }

