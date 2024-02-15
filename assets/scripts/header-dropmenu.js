//change the opacity and visibility of dropdown list
let dropContainer = document.querySelector('.drop');
let dropList = document.querySelector('#dropList');
let toggle = document.querySelector('#toggle');
let arrow = document.querySelector('.arrow');


if(dropContainer){

    dropContainer.addEventListener('click', function () {
        if (window.getComputedStyle(dropList).opacity == 0) {
            dropList.style.visibility = 'visible';
            dropList.style.opacity = 1;
            arrow.style.transform = 'rotateZ(-90deg) rotateY(180deg)';
            arrow.style.marginBottom = 0;

        } else {
            dropList.style.visibility = 'hidden';
            dropList.style.opacity = 0;
            arrow.style.transform = 'rotateZ(90deg) rotateY(180deg) '
            arrow.style.marginBottom = "6px";

        }

    });
}


// close the dropDown list when the user click outside the menu
document.addEventListener('click', function(event) {
    if (event.target !== toggle) {
        if(dropList){
            var dropListComputedStyle = window.getComputedStyle(dropList);
            if (dropListComputedStyle.getPropertyValue('opacity') !== '0') {
                dropList.style.visibility = 'hidden';
                dropList.style.opacity = '0';
                arrow.style.transform = 'rotateZ(90deg) rotateY(180deg)';
                arrow.style.marginBottom = '0';
            }
        }

    }
});

const menuBtn = document.querySelector('.menu-btn');

menuBtn.addEventListener('click', () => {

    document.querySelector('.nav-header').classList.toggle('openedMenu');

    menuBtn.classList.toggle('open');

})

