let addToShoppingBasketButton = document.querySelectorAll('.add-to-shopping-basket');
const $ = require('jquery');
import Swal from "sweetalert2";





if (addToShoppingBasketButton) {



    addToShoppingBasketButton.forEach((button) => {
        button.addEventListener('click', () => {

            const id = button.getAttribute('data-id');

            $.ajax({
                url: `accessories/${id}`,
                type: 'GET',
                success: function (data) {


                    try{
                        let basketItemsString = localStorage.getItem('basket');
                        let basketItems = JSON.parse(basketItemsString);



                        if (!basketItems) {
                            data.quantity = 1;

                            basketItems = {
                                items: [data]
                            };

                        } else {

                            // get basket items name to check if the data item exists already
                            let basketItemsId = [];
                            basketItems.items.forEach(item=>{

                                basketItemsId.push(item.id);

                            });


                            if(basketItemsId.includes(data.id)){

                                basketItems.items.forEach(item=>{
                                    if(item.id == data.id){
                                        item.quantity += 1;
                                    }
                                } )

                            }else{

                                data.quantity = 1;
                                basketItems.items.push(data);

                            }

                        }



                        let updatedBasketString = JSON.stringify(basketItems);


                        localStorage.setItem('basket', updatedBasketString);


                        Swal.fire({
                            title: 'Added',
                            text: 'You can modify the quantity in the basket',
                            showDenyButton: true,
                            showCancelButton: false,
                            confirmButtonText: "Go to basket",
                            denyButtonText: `Continue`,
                            icon: "success"

                        }).then((result) => {
                            if(result.isConfirmed){
                                window.location.href ='shopping-basket';
                            }
                        });


                    }
                    catch (e) {
                        console.log(e);
                    }


                }
            });


        })
    })
}
