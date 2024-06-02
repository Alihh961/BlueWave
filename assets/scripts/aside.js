const links = document.querySelectorAll([ 'a.home' , 'a.about-us']);
let pageTitle = document.querySelector('title').innerHTML;

if(pageTitle === 'Home'){
    links[0].style.backgroundColor = 'rgb(90 121 147)';
}else{
    links[0].style.backgroundColor = 'transparent';

}
