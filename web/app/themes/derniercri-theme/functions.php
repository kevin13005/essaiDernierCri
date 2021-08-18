<?php

function twentytwentyone_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri(),
	array( 'twenty-twenty-one-style' ), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'twentytwentyone_styles');


/**********************************************************************************************
 * modification apporté au theme twenty twenty one directement ici dans functions.php exceptionnellement.
 * Pas besoin d'un theme enfant car c'est un essai donc on ne mettra pas a jour et les modifications ne seront pas effacées
 **********************************************************************************************/

/**
 * ajout d'une fonction qui crée un custom post type nommé News, qui
 * est non hierarchique, et qui fixe les capabilities, les droits à realiser des actions sur le CPT
 */
function ajout_news_custom_post_type(){

	register_post_type('news', [
		'label' => 'news',
		'public' =>true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'rewrite'            => array( 'slug' => 'news' ),
		'query_var'          => true,
		'show_in_rest' => true,//accessible à l'API REST avec true en ajoutant wp-json/wp/v2/news/ à l'url
		'hierarchical'       => false,
		'supports'=> array( 'title', 'editor', 'author', 'thumbnail' ),
		'capability_type'    => 'post',
		'capabilities' => array(
			'edit_post'                   => 'edit_new',
			'read_post'                   => 'read_new',
			'delete_post'                 => 'delete_new',
			'edit_posts'                  => 'edit_news',
			'edit_others_posts'           => 'edit_others_news',
			'read_others_posts'           => 'read_others_news',
			'publish_posts'               => 'publish_news',
			'publish_pages'               => 'publish_pages_news',
			'read_private_posts'          => 'read_private_news',
			'create_posts'                => 'create_private_news',
			'edit_published_posts'        => 'edit_published_news',
			'delete_published_posts'      => 'delete_published_news',
			'delete_others_posts'         => 'delete_others_news',
			'edit_private_posts'          => 'edit_private_News',
			'delete_private_posts'        => 'delete_private_news',
		 ),
	]);
}
/**
 * ajout avec un hook de la fonction ci dessus d'ajout du custom post type News
 */
add_action('init', 'ajout_news_custom_post_type');

//modifier les droits de l'administrateur pour creer des news avec le CPT news
function modification_droits(){

//changer les capabilities du role administrator que nous utilisons pour
//avoir acces au CPT News
$role_administrateur = get_role( 'administrator' );
$capabilities_admin = array(
    'edit_new',
    'read_new',
    'delete_new',
    'edit_news',
    'edit_others_news',
    'read_others_news',
    'publish_news',
    'publish_pages_news',
    'read_private_news',
    'create_private_news',
    'edit_published_news',
    'delete_published_news',
    'delete_others_news',
    'edit_private_news',
    'delete_private_news',
);
//on parcours le tableau de capabilities que nous avons fixé
//et on ajoute avec add_cap chaque capability pour avoir la possibilité d'ajouter
//dans CPT News un post
foreach( $capabilities_admin as $capabilitie_admin ) {
	$role_administrateur->add_cap( $capabilitie_admin );
}

}

add_action('admin_init', 'modification_droits');

/******************************************************************************************
 * ********************Gestion de La partie front en de l'application de l'app*/

//ajouter vue js à l'application
add_action( 'wp_enqueue_scripts', 'enqueue_vue' );
function enqueue_vue() {

	//on enregistre vue js
    wp_register_script( 'vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"' );

  // on enregistre notre propre fichier js qui va gerer les vues
 	wp_register_script( 'my-app', get_template_directory_uri().'/js/my-app.js','vue', true);
}
/*
add_shortcode('index', 'vue_front_page');
function vue_front_page(){
	wp_enqueue_script('vue');
	wp_enqueue_script('my-app');
	
	$str= "<div id='divWpVue'>"
  ."Message from Vue: {{ message }}"
  ."</div>";

  return $str;
	
	
}*/
