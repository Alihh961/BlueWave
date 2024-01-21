let pageTitle = document.querySelector('title');

if(pageTitle == 'Home'){

//     let max;
//     const itemsSection = document.querySelector('.products');
//     const showButton = document.querySelector('.show-more');
//
//
// // get the max numbers if categories
//     function getMax(){
//         fetch('/max-vision-items').then(response => response.json())
//             .then(data=>
//                 {
//                     max= data.max;
//                     if(itemsSection.children.length > max){
//                         document.querySelector('.show-more').style.display='none';
//
//                     }
//                 }
//             )
//     }
//
//     getMax();
//
// // add more products when the button is clicked
//     showButton.addEventListener('click', () => {
//
//         if (itemsSection.children.length < max) {
//
//             fetch('/load-more?offset=' + itemsSection.children.length)
//                 .then(response => response.json())
//                 .then(data => {
//                     items = data.items;
//
//                     items.forEach(function (item) {
//
//                         var newProductContainer = document.createElement('a');
//                         newProductContainer.classList.add('product-container');
//                         newProductContainer.setAttribute('href' ,`view-product?c=${item.id}`);
//
//                         var newItem = document.createElement('div');
//                         newItem.classList.add('product');
//
//                         var newImage = document.createElement('img');
//                         newImage.src = 'https://127.0.0.1:8000/assets/images/test-6d05b5f43bd4fba9b630eb472bc1d5bc.png';
//                         var newH6 = document.createElement('h6');
//
//                         newH6.innerHTML = item.name;
//
//                         newItem.append(newImage);
//                         newItem.append(newH6);
//
//                         newProductContainer.append(newItem);
//
//                         itemsSection.append(newProductContainer);
//                     });
//
//
//
//                 });
//         }else{
//             document.querySelector('.show-more').style.display='none';
//         }
//
//     });
}

