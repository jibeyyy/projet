/////////////////////////////////
////////////  menu Burger //////
////////////////////////////////
let sidenav = document.getElementById("mySidenav"); // recuperation des id html
let openBtn = document.getElementById("openBtn");
let closeBtn = document.getElementById("closeBtn");

openBtn.onclick = openNav; // implementation des fonctions au variable
closeBtn.onclick = closeNav;


function openNav() {
    sidenav.classList.add("active"); //fonction add pour ouvrir 
}

function closeNav() {
    sidenav.classList.remove("active"); // fonction remove pour suprimer la div via l'id html
}

///////////////////////////////////
///////   carousel   ////////////////
///////////////////////////////////
function previous() {
    const widthSlider = document.querySelector('.carousel').offsetWidth; // recuperation de la largeur du conteneur
    document.querySelector('.sliderContent').scrollLeft -= widthSlider; // cela scroll directement à l'extremité gauche
}

function next() {
    const widthSlider = document.querySelector('.carousel').offsetWidth;
    document.querySelector('.sliderContent').scrollLeft += widthSlider;
}


/////////////////////////////////////////
///////////  selecteur d'onglet  ///////////
//////////////////////////////////////////

function nextPage() {
    let selecteur = document.getElementById("selecteur"); // recuperation de l'id html
    let selectedValue = selecteur.options[selecteur.selectedIndex].value; //on implemente les options des balise html à la variable selecteur et renvoie l'index de l'option actuellement
    window.location.href = selectedValue; // redirige l'utilisateur vers une nouvelle page en utilisant la valeur stockée dans la variable selectedValue comme URL de destination.
}


