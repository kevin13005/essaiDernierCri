<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

 //affiche tous les articles sur une page, page d'accueil ici
get_header(); ?>

<?php if ( is_home() && ! is_front_page() && ! empty( single_post_title( '', false ) ) ) : ?>
	<header class="page-header alignwide">
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->
<?php endif; ?>

<?php
//creation d'article en base de données qui proviennent de l'api pokemon

global $wpdb;	
//requete en base pour recuperer le titre des posts existants		
$TitresDesPosts = $wpdb->get_results("SELECT post_title FROM wp_posts",ARRAY_A);

//creation d'un tableau vide, pour contenir les post_title
$tableauTitrePost = array();

//on insere chaque valeur recoltés en base dans un nouveau tableau ou il y a seulement 
//les post_title
foreach($TitresDesPosts as $titrePost){
	$tableauTitrePost[]= $titrePost["post_title"];
}

//appel API avec methode get, on recupere donnees
$pokemon = wp_remote_get('https://pokeapi.co/api/v2/pokemon/');

$http_code = wp_remote_retrieve_response_code( $pokemon );

//verifier si l'API envoie les donnees et pas de probleme de requete
if($http_code ='200'){
	//on recupere le corps des infos de l'API
	$response = wp_remote_retrieve_body( $pokemon );
	//on met au format json
	$remote_posts = json_decode($response, true);
	
	//parcourir le tableau avec l'index results car se trouve dedans les informations voulues
	//on a besoin d'index pour nommer l'article et comparer ensuite si cet article existe deja
	//pour eviter les doublons
	foreach( $remote_posts["results"] as $index=>$remote_post ) {

		//on prepare l'argument de la fonction wp_insert_post
		$le_post = array(
            'post_title'    => "pokemon $index",
            'post_content'  => $remote_post["name"]. '<br>' .$remote_post["url"],
            'post_status'   => 'publish',
            'post_type' => "post",
            'post_name' => "pokemon $index"//c est le slug
          );

		 //on verifie si le titre de notre article n'existe pas deja en base en comparant
		 //la valeur que nous allons poster avec les valeurs en base($tableau créé avec
		 //$wpdb plus haut)
		  if(!in_array("pokemon $index",$tableauTitrePost)){
				wp_insert_post($le_post);
		  }
		
	}
}
//si il y a un probleme de requete a l'API, on envoi ce message d'erreur
else{
	echo 'la requete ne marche pas';
}

//affichage des posts
if ( have_posts() ) {

	// Load posts loop.
	while ( have_posts() ) {
		the_post();

		get_template_part( 'template-parts/content/content', get_theme_mod( 'display_excerpt_or_full_post', 'excerpt' ) );
	}
	// Previous/next page navigation.
	twenty_twenty_one_the_posts_navigation();

} else {

	// If no content, include the "No posts found" template.
	get_template_part( 'template-parts/content/content-none' );

}

echo do_shortcode('[index]');

get_footer();
