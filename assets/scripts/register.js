window.onload = () => {
    let passwordField = document.querySelector('#registration_form_password_first');

    let eye = document.createElement('i');
    eye.classList.add('far');
    eye.classList.add('fa-eye');
    eye.classList.add('show-passwords');

    if (passwordField) {
        passwordField.parentNode.appendChild(eye);
        const div = passwordField.parentNode;
        div.style.position = 'relative';
        eye.style.position = 'absolute';
        eye.style.right = '20px';
        eye.style.top = '59%';
        eye.style.fontSize = 'large';
    }


    if (eye) {
        eye.addEventListener('click', function () {
            let passwordField = document.querySelector('#registration_form_password_first');
            let confirmPasswordField = document.querySelector('#registration_form_password_second');

            const newType = passwordField.type === 'password' ? 'text' : 'password';

            passwordField.type = newType;
            confirmPasswordField.type = newType;
            eye.classList.toggle('fa-eye-slash');

        })
    }
}





