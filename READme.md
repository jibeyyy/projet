                                 DjueKoffi

Site web e-commerce visant à promouvoir les différents livres écrits par Djue Koffy Mathieu.

------------------------Installation des composants: ----------------------------------

---Composer---
Le projet utilise Composer pour gérer les dépendances PHP. Une fois Composer installé, 
exécutez la commande 
suivante à la racine de votre projet :

             "composer install"
             
---Sass---
Le projet utilise Sass pour la gestion des styles. Une fois Sass installé, exécutez la 
commande suivante dans le dossier CSS pour compiler les fichiers Sass en CSS :

 Dans l'IDE Cloud9, dans le terminal :
 
              allez à la racine du dossier en utilisant les lignes de commande et taper :
            "watch sass style.scss style.css"
                  
Vous pouvez trouver le code source à cette adresse : https://github.com/jibeyyy/projet

---------------------LICENSE: ----------------------------------------------
Ce projet n'est pas sous licence, ce qui signifie que les droits d'auteur standard s'appliquent automatiquement. Sans licence, d'autres ne peuvent pas légalement copier, distribuer ou modifier mon travail sans mon autorisation.


-------------------STRUCTURE DU PROJECT: -----------------------------------
-Vous trouverez un dossier principal "DjueKoffi" qui regroupe un dossier "app"
(caché aux utilisateurs)= composé de la structure MVC (dossier Controllers, dossier Models, 
dossier Views), un dossier "Utils" (pour gérer la base de données), un fichier "config.ini" 
pour configurer les identifiants de connexion dans le dossier "Utils". Dans le dossier "Views", 
vous retrouverez un dossier "admin" (pour gérer les pages HTML du côté administrateur)
et le dossier "front"
(pour gérer les pages HTML du côté utilisateur).

-Un autre dossier est le dossier "Public"= il regroupe les images, le style CSS, les scripts JavaScript, la police de texte et la page 
principale "index.php".

-Un dossier "vendor"= À l'intérieur de 'vendor', il y a un fichier particulièrement important appelé 'autoload.php'.
C'est comme le chef d'orchestre de notre application. Il s'assure que toutes les classes et
les fichiers nécessaires sont automatiquement chargés et prêts à être utilisés.

-------------------CONTACT : -----------------------------------------------
Pour plus d'informations concernant ce projet, vous pouvez me joindre à cette adresse :
afonsojeanbaptiste@gmail.com.

-------------------REMERCIMENTS:--------------------------------------------

Je remercie 3W Academy pour m'avoir donné l'opportunité d'apprendre à créer un site/application web. Cela me sera très utile pour mes futurs projets.