<?php
/*
http://www.geekpress.fr/wp-query-creez-des-requetes-personnalisees-dans-vos-themes-wordpress/
 */

/**
  Chargement des scripts du front-end
 */
define('PBI_VERSION', '19.12.20');

// Filtre pour autoriser l'import de média issus d'un export de site
add_filter('http_request_host_is_external', '__return_true');

// Chargement dans le front-end
function pbi_enqueue_scripts()
{
    // chargement des fonts

    wp_enqueue_style('theme-fonts', 'https://fonts.googleapis.com/css?family=Raleway', array(), PBI_VERSION, 'all');
    wp_enqueue_style('theme-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), PBI_VERSION, 'all');

    // chargement des styles du modèle
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/css/w3.css', array(), PBI_VERSION, 'all');
    // le thème W3
    //wp_enqueue_style('theme-w3-theme', get_template_directory_uri() . '/css/w3-theme-teal.css', array('theme-w3'), PBI_VERSION, 'all');

    $options = get_option('theme_options');
    if ($options) {
        wp_enqueue_style('theme-w3css', 'https://www.w3schools.com/lib/w3-theme-' . $options['theme_w3css'] . '.css', array('theme-style'), PBI_VERSION, 'all');
    } else {
        wp_enqueue_style('theme-w3css', 'https://www.w3schools.com/lib/w3-theme-dark-grey.css', array('theme-style'), PBI_VERSION, 'all');
    }

    // le style du site
    wp_enqueue_style('theme-site', get_template_directory_uri() . '/style.css', array('theme-style'), PBI_VERSION, 'all');

    // chargement des scripts du thème
    wp_enqueue_script('script-theme', get_template_directory_uri() . '/js/w3.js', array('jquery'), PBI_VERSION, true);
    // chargement des scripts du site
    wp_enqueue_script('script-site', get_template_directory_uri() . '/js/site.js', array('jquery', 'script-theme'), PBI_VERSION, true);

} // fin function pbi_enqueue_scripts

add_action('wp_enqueue_scripts', 'pbi_enqueue_scripts');

/**
Chargement dans l'admin
 */
function pbi_admin_init()
{
    // *** action 1
    function pbi_admin_scripts()
    {
        // chargement des styles admin
        wp_enqueue_style('theme-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), PBI_VERSION, 'all');
        // chargement des styles
        wp_enqueue_style('theme-w3', get_template_directory_uri() . '/css/w3.css', array(), PBI_VERSION, 'all');

    } // fin function pbi_admin_scripts
    // add_action('admin_enqueue_scripts', 'pbi_admin_scripts');

    // *** action 2 - Setting des options
    // Enregistrement des options
    register_setting(
        'theme_options', // nom du groupe d'options utilisé par settings_fields
        'theme_options', // nom des options
        'theme_options_validate' // fonction qui validera la saisie
    ); 
    // Création de la section des options
    add_settings_section(
        'options_main', // identifiant unique de la section
        'Options du thème', // titre de la section
        'options_section_text', // fonction d'affichage de la section
        'options_theme' // slug de la page
    ); // slug de la page fonction appelé par do_settings_sections
    // Création des champs de saisie
    add_settings_field(
        'theme__w3css', // id du champ
        'Nom du thème W3.CSS', // son label
        'pbi_setting_theme_w3css', // sa fonction pour l'afficher
        'options_theme', // le slug de la page
        'options_main' // id de la section
    );
    add_settings_field(
        'theme__sort', // id du champ
        'Tri des articles sur le titre', // son label
        'pbi_setting_theme_sort', // sa fonction pour l'afficher
        'options_theme', // le slug de la page
        'options_main' // id de la section
    );
    add_settings_field(
        'theme__news_title', // id du champ
        'Titre du bloc Articles Mis en avant', // son label
        'pbi_setting_theme_news_title', // sa fonction pour l'afficher
        'options_theme', // le slug de la page
        'options_main' // id de la section
    );
    add_settings_field(
        'theme__article_title', // id du champ
        'Titre du bloc liste des articles', // son label
        'pbi_setting_theme_article_title', // sa fonction pour l'afficher
        'options_theme', // le slug de la page
        'options_main' // id de la section
    );
    add_settings_field(
        'theme__classement_title', // id du champ
        'Titre du bloc des catégories', // son label
        'pbi_setting_theme_classement_title', // sa fonction pour l'afficher
        'options_theme', // le slug de la page
        'options_main' // id de la section
    );

} // pbi_admin_init
add_action('admin_init', 'pbi_admin_init');

/**
    Ajout d'un menu dans les options du thème
    https://codex.wordpress.org/Adding_Administration_Menus
 */
function pbi_admin_menus()
{
    // Menu Raccroché en bas
    //  add_menu_page(
    //      'Theme Options', // Title de la page du menu
    //      'Options du thème', // Titre de la page
    //      'manage_options', // le menu sera placé en dessous
    //      'options_theme', // slug du menu
    //      'theme_options_page' // function qui affichera la page
    //  );

    // // Menu ajouté dans le menu Apparence
    add_theme_page(
        'Theme Options', // Title de la page du menu
        'Options du thème', // Titre de la page
        'manage_options', // le menu sera placé en dessous
        'options_theme', // slug du menu
        'theme_options_page' // function qui affichera la page
    );
    // Pas de gestion des couleurs car traité par la feuille de style
    //$wp_customize->remove_section( 'colors' );

    // Contient la fonction theme_options_page
    include 'options-page.php';

}
add_action('admin_menu', 'pbi_admin_menus');

/**
 * Suppression des sections de personnalisation du thème
 */
function pbi_theme_section( $wp_customize ) {
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'static_front_page' );
    $wp_customize->remove_section( 'custom_css' );
}
add_action( 'customize_register', 'pbi_theme_section' );


/**
 * Ajout du filtre "Etiquette" dans l'administration des articles
 */
// add_action('restrict_manage_posts','pbi_post_type_filter',10,2);
// function pbi_post_type_filter($post_type, $which){
//     if('post' !== $post_type){
//       return; //check to make sure this is your cpt
//     }
//     $taxonomy_slug = 'post_tag';
//     $taxonomy = get_taxonomy($taxonomy_slug);
//     $request_attr = 'my_type'; //this will show up in the url
//     if ( isset($_REQUEST[$request_attr] ) ) {
//       $selected = $_REQUEST[$request_attr]; //in case the current page is already filtered
//     }
//     wp_dropdown_categories(array(
//       'show_option_all' =>  __("Toutes les {$taxonomy->label}"),
//       'taxonomy'        =>  $taxonomy_slug,
//       'name'            =>  $request_attr,
//       'orderby'         =>  'name',
//       'selected'        =>  true,
//       'hierarchical'    =>  true,
//       'depth'           =>  3,
//       'show_count'      =>  false, // Show number of post in parent term
//       'hide_empty'      =>  false, // Don't show posts w/o terms
//     ));
// }
// add_filter( 'parse_query', 'pbi_filter_request_query' , 10);
// function pbi_filter_request_query($query){
//     //modify the query only if it is admin and main query.
//     if( !(is_admin() AND $query->is_main_query()) ){
//       return $query;
//     }
//     //we want to modify the query for the targeted custom post.
//     if( 'post' !== $query->query['post_type'] ){
//       return $query;
//     }
//     //type filter
//     if( isset($_REQUEST['my_type']) &&  0 != $_REQUEST['my_type']){
//       $term =  $_REQUEST['my_type'];
//       $taxonomy_slug = 'post_tag';
//       $query->query_vars['tax_query'] = array(
//         array(
//             'taxonomy'  => $taxonomy_slug,
//             'field'     => 'ID',
//             'terms'     => array($term)
//         )
//       );
//     }
//     return $query;
// }

// function pbi_add_taxonomy_filters()
// {
//     global $typenow;

//     // an array of all the taxonomyies you want to display. Use the taxonomy name or slug
//     $my_taxonomies = array('post_tag');
//     switch ($typenow) {

//         case 'post':

//             foreach ($my_taxonomies as $tax_slug) {

//                 $tax_obj = get_taxonomy($tax_slug);
//                 $tax_name = $tax_obj->labels->name;
//                 $terms = get_terms($tax_slug);
//                 if (count($terms) > 0) {
//                     echo "<select name='$tax_slug' id='$tax_slug' class='postform alignleft actions'>";
//                     echo "<option value=''>Toutes les $tax_name</option>";
//                     foreach ($terms as $term) {
//                         echo '<option value="', $term->slug, '" ', selected(@$_GET[$tax_slug] == $term->slug, $current = true, $echo = false), '>', $term->name, ' (', $term->count, ')</option>';
//                     }
//                     echo "</select>";
//                 }

//             }

//             break;
//     }
// }
// add_action('restrict_manage_posts', 'pbi_add_taxonomy_filters');

/**
Utilitaires
 */
function pbi_setup()
{

    // support des vignettes
    add_theme_support('post-thumbnails');

    // Création nouveau format image front-slider 1140x420
    //add_image_size('front-slider', 1140, 420, true);

    // enlève générateur de version
    remove_action('wp_head', 'wp_generator');

    // enlève les guillemets à la française
    remove_filter('the_content', 'wptexturize');

    // support du titre
    add_theme_support('title-tag');

    // support background image
    add_theme_support('custom-background');

    // Logo du site
    // add_theme_support('custom-logo');

    // support custom header
    $defaults = array(
        'default-image' => '',
        'width' => 0,
        'height' => 200,
        'flex-height' => true,
        'flex-width' => true,
        'uploads' => true,
        'random-default' => false,
        'header-text' => true,
        'default-text-color' => '',
        'wp-head-callback' => '',
        'admin-head-callback' => '',
        'admin-preview-callback' => '',
    );
    add_theme_support('custom-header');

    // active la gestion des menus dans l'administration
    register_nav_menus(array(
        'location_menu_primary' => 'Location haut page',
        'location_menu_footer_public' => "Location bas page gauche",
        'location_menu_footer_public2' => "Location bas page centre",
        'location_menu_footer_prive' => "Location bas page droite",
        // 'location_menu_sidebar' => "Location Menu Sidebar",
    ));

    // // le rôle editor aura les possiblités de gérer le menu
    $roleObject = get_role('editor');
    if (!$roleObject->has_cap('edit_theme_options')) {
        $roleObject->add_cap('edit_theme_options');
    }

    // les abonnés pouront lire les artcles privés
    $unRole = get_role('subscriber');
    $unRole->add_cap('read_private_pages');
    $unRole->add_cap('read_private_posts');

} // fin pbi_setup

add_action('after_setup_theme', 'pbi_setup');

/**
Modification du texte "lire la suite"
 */
function pbi_excert_more($more)
{
    return ' <a class="more-link" href="' . get_permalink() . '"> [lire la suite]</a> ';
}
add_filter('excerpt_more', 'pbi_excert_more');

// /**
// Changement du menu footer si le user est connecté
// */
// function pbi_wp_nav_menu_args($args = '')
// {
//     if ( $args->theme_location == 'footer_menu' ) {
//         if( is_user_logged_in() ) {
//             $args['menu'] = 'footer_menu_abonne';
//         } else {
//             $args['menu'] = 'footer_menu';
//         }
//     }
//     return $args;
// }
// // événement nav_menu émis dans footer.php
// // wp_nav_menu( array( 'theme_location' => 'footer_menu', 'menu_class' => 'nav-menu' ) );
// add_filter('wp_nav_menu_args', 'pbi_wp_nav_menu_args');

/**
Dump d'une variable dans le navigateur
 */
function dump($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

if (!function_exists('pbi_journal')) {
    function pbi_journal($message, $type = "info")
    {
        if (is_array($message) or is_object($message)) {
            // $message = json_encode($message);
            $message = print_r($message, true);
        }
        $file = fopen(dirname(__FILE__) . "/journal.log", "a");
        fwrite($file, "\n" . date('Y-m-d h:i:s') . " :: " . $type . " " . $message);
        fclose($file);
    }
}

/**
Ajout category et post_tag aux attachments
Seront gérés ensuite par le plugin "F4 Media Taxonomies"
 */
function pbi_add_categories_to_attachments()
{
    // Création d'une nouvelle catégorie "Dossiers"
    // https://code.tutsplus.com/articles/applying-categories-tags-and-custom-taxonomies-to-media-attachments--wp-32319
    // $labels = array(
    //     'name' => 'Dossiers',
    //     'singular_name' => 'Dossier',
    //     'search_items' => 'Rechercher dans les dossiers',
    //     'all_items' => 'Tous les dossiers',
    //     'parent_item' => 'Dossier parent',
    //     'parent_item_colon' => 'Dossier parent:',
    //     'edit_item' => 'Modifier le dossier',
    //     'update_item' => 'Mettre à jour le dossier',
    //     'add_new_item' => 'Ajouter un nouveau dossier',
    //     'new_item_name' => 'Nouveau nom de dossier',
    //     'menu_name' => 'Dossiers',
    // );
    // $args = array(
    //     'labels' => $labels,
    //     'hierarchical' => true,
    //     'query_var' => 'true',
    //     'rewrite' => 'true',
    //     'show_admin_column' => 'true',
    // );
    // Enregistrement des taxonomies pour les Media
    //register_taxonomy('dossier', 'attachment', $args);
    // register_taxonomy_for_object_type('category', 'attachment');
    // register_taxonomy_for_object_type('post_tag', 'attachment');

}
add_action('init', 'pbi_add_categories_to_attachments');

/**
Ajout de widgets
 */
// function pbi_widgets_init()
// {
//     register_sidebar(array(
//         'name' => 'Footer Widget Zone',
//         'description' => 'Widgets affichés dans le footer: 3 au maximum',
//         'id' => 'widgetized-footer',
//         'before_widget' => '<div id="%1$s" class="w3-col m4 %2$s">',
//         'after_widget' => '</div>',
//         'before_title' => '<h3">',
//         'after_title' => '</h3>',
//     ));
// }
// add_action('widgets_init', 'pbi_widgets_init');

/**
Obtention des catégories et tags des articles publiés (ou privés si connecté)
 */
function pbi_get_categories_tags($status)
{
    // dump($status);
    $args = array(
        'post_type' => 'post',
        'post_status' => $status, // ça ne marche pas
        'posts_per_page' => -1,
    );
    $req = new WP_Query($args);
    $cata = array();
    $taga = array();
    if ($req->have_posts()) {
        while ($req->have_posts()) {
            $req->the_post();
            global $post;
            if (strpos($status, $post->post_status) !== false):
                $cats = get_the_category();
                foreach ($cats as $cat) {
                    $cata[$cat->slug] = $cat->name;
                }
                $tags = get_the_tags();
                if ($tags) {
                    foreach ($tags as $tag) {
                        $taga[$tag->slug] = $tag->name;
                    }
                }
            endif;
        }
    }
    wp_reset_postdata();
    return array('categories' => $cata, 'tags' => $taga);
}

/**
Obtention des catégories d'un tag particulier
 */
function pbi_get_categories_from_tag($status, $tag)
{
    // dump($status);
    $args = array(
        'post_type' => 'post',
        'post_status' => $status, // ça ne marche pas
        'posts_per_page' => -1,
        'cat' => $tag,
    );
    $req = new WP_Query($args);
    $cata = array();
    $taga = array();
    if ($req->have_posts()) {
        while ($req->have_posts()) {
            $req->the_post();
            global $post;
            if (strpos($status, $post->post_status) !== false):
                $cats = get_the_category();
                foreach ($cats as $cat) {
                    $cata[$cat->slug] = $cat->name;
                }
                $tags = get_the_tags();
                if ($tags) {
                    foreach ($tags as $tag) {
                        $taga[$tag->slug] = $tag->name;
                    }
                }
            endif;
        }
    }
    wp_reset_postdata();
    return array('categories' => $cata, 'tags' => $taga);
}

/**
Is cookie
 */
function is_pbi_cookie($cookie_name)
{
    // dump($_COOKIE[$cookie_name]);
    if (isset($_COOKIE[$cookie_name]) and $_COOKIE[$cookie_name] != "") {
        return true;
    } else {
        return false;
    }
}

/**
 * Modification de la requête avant envoi
 * https://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
 */
function pbi_pre_get_posts($query)
{
    if ((is_category() || is_tag() || is_home()) && $query->is_main_query()) {
        // This is the main query (not on an admin screen page)
        $options = get_option('theme_options');
        if ( $options['theme-sort'] == "oui") {
            $query->set('orderby', "title");
            $query->set('order', "ASC");
        }
        $query->set('post_per_page', 1);
        $query->set('post_status', array('publish'));
    }
}
add_action('pre_get_posts', 'pbi_pre_get_posts');

function get_cat_slug($cat_id)
{
    $cat_id = (int) $cat_id;
    $category = &get_category($cat_id);
    return $category->slug;
}

add_action('pre_get_posts', 'pbi_custom_pre_get_posts');
function pbi_custom_pre_get_posts($query)
{
    if (!$query->is_home() || !$query->is_main_query()) {
        return;
    }

    global $withcomments;
    $withcomments = true;
    $query->set('posts_per_page', '1');
    $query->set('ignore_sticky_posts', '1');
}
