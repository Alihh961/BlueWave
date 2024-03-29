let addToShoppingBasketButton = document.querySelectorAll('.add-to-shopping-basket');
const $ = require('jquery')


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
                                console.log('includes');

                            }else{
                                console.log(' no includes');

                                data.quantity = 1;
                                basketItems.items.push(data);

                            }

                        }



                        let updatedBasketString = JSON.stringify(basketItems);


                        localStorage.setItem('basket', updatedBasketString);

                        var div = document.createElement('div');


                        div.style.width = '100%';
                        div.style.minHeight = '100vh';
                        div.style.position = 'absolute';
                        div.style.zIndex = '999';
                        div.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
                        div.style.top = '0';
                        div.style.left = '0';

                        var message = document.createElement('div');

                        message.style.width = "320px";
                        message.style.height = '300px';
                        message.style.position = 'absolute';
                        message.style.top = '50%';
                        message.style.left = '50%';
                        message.style.transform = 'translate(-50%, -50%)';
                        message.style.backgroundColor = 'red';

                        document.body.style.overflow = 'hidden';

                        div.append(message);


                        document.body.append(div);
                    }
                    catch (e) {
                        console.log(e);
                    }


                }
            });


        })
    })
}
