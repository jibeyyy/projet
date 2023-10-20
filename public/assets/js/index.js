/////////////////////////////////
////////////  menu Burger //////
////////////////////////////////
var sidenav = document.getElementById("mySidenav"); // recuperation des id html
var openBtn = document.getElementById("openBtn");
var closeBtn = document.getElementById("closeBtn");

openBtn.onclick = openNav; // implementation des fonction
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
    var selecteur = document.getElementById("selecteur");
    var selectedValue = selecteur.options[selecteur.selectedIndex].value;
    window.location.href = selectedValue;
}


////////////////////////////////////
//////////   PANIER   //////////////////
///////////////////////////////////
document.querySelector('.paner').addEventListener('submit', function(e) {
    e.preventDefault(); // Empêche le formulaire de se soumettre normalement

    // Récupère les valeurs du formulaire
    var selectedLivre = document.querySelector('#name').value;
    var selectedQuantity = document.querySelector('#quantity').value;
    var selectedPrice = document.querySelector('#price').value;

    // Met à jour les éléments dans le tableau
    document.querySelector('#name').textContent = selectedLivre;
    document.querySelector('#quantity').textContent = selectedQuantity;
    document.querySelector('#price').textContent = selectedPrice;
});
