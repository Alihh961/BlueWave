console.log('EA JS file works');

// const contentWrapper = document.querySelector('.content-wrapper');
//
// if(contentWrapper){
//     contentWrapper.classList.add('d-block');
//     contentWrapper.classList.add('specific-user-content-wrapper');
//
// }

const formSpecificUser = document.querySelector('.form-specific-user');

if(formSpecificUser){

    const contentWrapperDiv = formSpecificUser.parentElement;
    contentWrapperDiv.classList.add('d-block');
    contentWrapperDiv.classList.add('specific-user-content-wrapper');

    let mainSection = contentWrapperDiv.parentElement;

    mainSection.style.background = 'linear-gradient(#141e30, #243b55)';
    mainSection.querySelector('.resizer-handler').style.display = 'none';
}


