//change the opacity and visibility of dropdown list
let dropContainer = document.querySelector('.drop');
let dropList = document.querySelector('#dropList');
let toggle = document.querySelector('#toggle');
let arrow = dropContainer.querySelector('.arrow');



dropContainer.addEventListener('click', function () {
    if (window.getComputedStyle(dropList).opacity == 0) {
        dropList.style.visibility = 'visible';
        dropList.style.opacity = 1;
        arrow.style.transform='rotateZ(-90deg) rotateY(180deg)';
        arrow.style.marginBottom=0;

    } else {
        dropList.style.visibility = 'hidden';
        dropList.style.opacity = 0;
        arrow.style.transform='rotateZ(90deg) rotateY(180deg) '
        arrow.style.marginBottom="6px";

    }

});






// close the dropDown list when the user click outside the menu
document.addEventListener('click', function (event) {
    if (event.target != toggle) {

        if (window.getComputedStyle(dropList).opacity != 0) {


            dropList.style.visibility = 'hidden';
            dropList.style.opacity = 0;
            arrow.style.transform='rotateZ(90deg) rotateY(180deg)';
            arrow.style.marginBottom=0;


        }
    }
})



