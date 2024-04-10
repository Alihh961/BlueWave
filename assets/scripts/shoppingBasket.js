import Swal from "sweetalert2";

let shoppingBasketContainer = document.querySelector('.shopping-basket-container');
const $ = require('jquery');


if (shoppingBasketContainer) {


    let basketItems = JSON.parse(localStorage.getItem('basket'));


    if (basketItems) {

        basketItems = JSON.parse(localStorage.getItem('basket')).items;

        basketItems.forEach(item => {

            let itemDiv = document.createElement('div');


            itemDiv.classList.add('shopping-basket-item');

            let itemNameSpan = document.createElement('span');
            let itemImageSpan = document.createElement('img');
            let itemQuantityInput = document.createElement('input');
            let itemTotalPriceSpan = document.createElement('span');
            let qtyAndPriceContainer = document.createElement('div');
            let removeButton = document.createElement('button');


            itemNameSpan.innerHTML = item.name;

            itemTotalPriceSpan.innerHTML = `${(item.price * item.quantity).toFixed(2)}$`;
            itemTotalPriceSpan.setAttribute('data-id', item.id);
            itemTotalPriceSpan.setAttribute('class', 'unit-price-total');


            itemImageSpan.src = `assets/images/accessories/${item.url}`;


            itemQuantityInput.value = item.quantity;
            itemQuantityInput.setAttribute('data-id', item.id);
            itemQuantityInput.setAttribute('data-price', +item.price);
            itemQuantityInput.setAttribute('value', item.quantity);
            itemQuantityInput.setAttribute('type', 'number');


            qtyAndPriceContainer.append(itemQuantityInput);
            qtyAndPriceContainer.append(itemTotalPriceSpan);

            removeButton.classList.add('btn-danger');
            removeButton.classList.add('btn');
            removeButton.innerHTML = "Remove"
            removeButton.setAttribute('data-id', item.id);
            removeButton.setAttribute('data-role', 'remove');


            itemDiv.append(itemImageSpan);
            itemDiv.append(itemNameSpan);
            itemDiv.append(qtyAndPriceContainer);
            itemDiv.append(removeButton);


            shoppingBasketContainer.append(itemDiv);

        })
        let checkoutDiv = document.createElement('div');
        checkoutDiv.classList.add('checkout-div');

        let totalPriceCheckout = document.createElement('h6');
        let totalPricesArray = document.querySelectorAll('.unit-price-total');
        let totalPricesNumber = 0;

        totalPricesArray.forEach(price => {
            totalPricesNumber += +price.innerHTML.slice(0, -1);
        })


        totalPriceCheckout.innerHTML = `The total price : ${totalPricesNumber}$`;


        let orderButton = document.createElement('a');
        orderButton.innerHTML = "Order now";
        orderButton.setAttribute('class', 'btn btn-success d-block');

        let emptyBasketButton = document.createElement('a');
        emptyBasketButton.innerHTML = 'Empty Carte';
        emptyBasketButton.setAttribute('class', 'btn btn-danger d-block');


        let buttonContainer = document.createElement('div');

        buttonContainer.append(emptyBasketButton);
        buttonContainer.append(orderButton);


        checkoutDiv.append(totalPriceCheckout);
        checkoutDiv.append(buttonContainer);

        emptyBasketButton.addEventListener('click', () => {
            console.log('removed');
            localStorage.removeItem('basket');
            location.reload();
        })

        shoppingBasketContainer.append(checkoutDiv);

        function getTotalPrice() {

            let pricesElement = document.querySelectorAll('.unit-price-total');

            let prices = 0;

            pricesElement.forEach(priceElement => {
                prices += +priceElement.innerHTML.slice(0, -1);


            });

            return prices;
        }


        function updateTotalPrice() {

            let totalPrice = getTotalPrice();

            let message = document.querySelector('.checkout-div h6');

            message.innerHTML = `The total price : ${totalPrice}$`;


        }

        let qtyInputs = shoppingBasketContainer.querySelectorAll('input');

        qtyInputs.forEach(input => {

            input.addEventListener('change', (event) => {
                let newValue = event.target.value;
                const id = event.target.getAttribute('data-id');
                let items = JSON.parse(localStorage.getItem('basket')).items;

                if (newValue <= 0) {
                    newValue = 1;
                    event.target.value = 1;
                }

                items.forEach(item => {
                    if (item.id == id) {
                        item.quantity = +newValue;
                    }
                });


                localStorage.setItem('basket', JSON.stringify({
                    items: items
                }));

                let totalPriceElement = document.querySelector(`span[data-id="${id}"]`);
                let unitPrice = event.target.getAttribute('data-price');
                totalPriceElement.innerHTML = (newValue * unitPrice).toFixed(2) + "$";
                updateTotalPrice();

            })
        });

        let removeButtons = shoppingBasketContainer.querySelectorAll(`button[data-role="remove"]`);

        removeButtons.forEach(button => {
            button.addEventListener('click', () => {
                let id = button.getAttribute('data-id');

                let items = JSON.parse(localStorage.getItem('basket')).items;


                items = items.filter(item => item.id != id);

                if (items.length > 0) {
                    localStorage.setItem('basket', JSON.stringify({
                        items:
                        items

                    }));
                } else {
                    localStorage.removeItem('basket');
                }

                document.location.reload();


            })
        });


        function orderNow() {

            let totalPrice = getTotalPrice();

            Swal.fire({
                title: `Do you want to order now and pay ${totalPrice}$ ?`,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Yes,Order now",
                denyButtonText: `Cancel`
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {


                    const items = JSON.parse(localStorage.getItem('basket')).items;

                    console.log(JSON.stringify(items));
                    $.ajax({
                        type: 'POST',
                        url: 'order-accessories',
                        data: JSON.stringify(items),
                        success: function (data) {
                            Swal.fire({
                                title: data.title,
                                text: data.message,
                                icon: "info"
                            }).then(() => {
                                localStorage.removeItem('basket');
                                    location.reload();

                                }
                            )
                        },
                        error: function (xhr) {

                            var error = xhr.responseJSON;
                           
                            Swal.fire({
                                title: error.title,
                                text: error.message,
                                icon: "error"
                            });
                        }

                    })
                }
            });
        }

        orderButton.addEventListener('click', () => {
            orderNow();
        });


    } else {

        let noItemsMessage = document.createElement('h3');
        noItemsMessage.innerHTML = 'No items added to the basket';

        shoppingBasketContainer.append(noItemsMessage);
    }


}
