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
/////// carousel   ////////////////
///////////////////////////////////







////////////////////////////////////
////////// PANIER //////////////////
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
