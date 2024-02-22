import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss'

const $ = require('jquery')

$.ajax({
    url : `accessories/1`,
    type : 'GET',
    success : function(data){
        console.log(data);
    }
})

import './scripts/home-page.js'
import './scripts/checkout.js'
import './scripts/header-dropmenu.js'
import './scripts/register.js'
import './scripts/shoppingBasket.js'

import './scripts/addToShoppingBasket.js'



console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉')
