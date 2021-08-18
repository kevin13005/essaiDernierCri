Dernier cri : Explication démarche projet

1ere étape : installation de Bedrock en local dans le repertoire www de WampServer, j'utilise la version PHP 7.3.12

2eme étape : Initialisation et création du repo GitHub, j'utilise la branch master

3eme étape :Choix du theme Twenty twenty one qui convient au cahier des charges, c'est à dire, une page d'accueil affichant les articles (arborescence du theme correspondant parfaitement, ici index.php est utilisé pour afficher tous les articles car front-page.php ou home.php ne sont pas présent dans l'arborescence).De plus, en back office, dans reglages, j'ai fixé "les derniers articles à afficher'. Une page détail des articles, ici single.php convient pour ceci.
Donc création d'un theme enfant de twenty twenty one pour que ce soit lisible plus facilement
pour vous, que ce soit dans functions.php ou index.php par exemple.

4eme etape : Choix de "pokemon API" comme article à afficher sur le blog. J'utiliserai les methode HTTP REQUEST disponible dans Wordpress. Le code documenté et implémenté est disponible dans index.php Les articles sont importés, s'affiche dans index.php et s'ajoute automatiquement dans l'interface et en base de données avec mon code.

5eme étape : création d'un custom post type avec la fonction dédié à la fin du fichier functions.php , je l'ajoute avec un hook à l'interface.

6eme etape : Modification des droits utilisateurs, l'administrator a plus de droits pour creer des custom post type, sans ceci il ne peut pas en créer. Dans functions.php, la foinction modification_droits() se charge de réaliser ceci.

7eme etape : ajouter wp-CLI sur mon ordinateur et sur wordpress, j' essai ensuite de generer des news automatiquement avec WP GENERATE POST, Mais wp-cli me dit que le custom post type n'est pas enregistré. Apres beaucoup de tentatives et recherche , je n'ai pas pu trouver pourquoi wp-cli ne reconnait pas l'existence du custom post type 'news' qui est présent dans l'interface d'administratino wordpress pourtant. Donc création avec l'interface directement de 20 news.

8eme etape : Le custom post type 'News' est accessible via REST API à la route localhost:8001/wp-json/wp/v2/news/, en ajoutant un parametre dans la fonction register post type() dans functions.php


Acceder au projet :

Avoir localhost installé
cloner le projet dans github
lancer localhost sur localhost:8001 donc port 8001 
faire commande dans le terminal : php -S localhost:8001 -t web
aller sur localhost:8001/wp pour acceder à l'administration wordpress
identifiant : derniercri
mot de passe : derniercri