const burgerMenu = document.querySelector('.burger-icon');
const asideContainer = document.querySelector('.aside');


if(burgerMenu){
    burgerMenu.addEventListener('click' , function(){
        document.body.classList.toggle('smaller');
        asideContainer.classList.toggle('aside-opened');
    })
}
