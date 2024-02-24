import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss'

Swal.fire({
    title: "Do you want to save the changes?",
    showDenyButton: true,
    showCancelButton: false,
    confirmButtonText: "Yes,Order now",
    denyButtonText: `Cancel`
}).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
        Swal.fire("Saved!", "", "success");
    }
});


const $ = require('jquery');


import './scripts/home-page.js'
import './scripts/checkout.js'
import './scripts/header-dropmenu.js'
import './scripts/register.js'
import './scripts/shoppingBasket.js'

import './scripts/addToShoppingBasket.js'
import Swal from "sweetalert2";



console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉')
