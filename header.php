<!doctype html>
<html <?php language_attributes();?>>
<head>
  <meta charset="<?php bloginfo('charset');?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- description de la page pour les moteurs de recherche -->
  <?php if (is_home()): ?>
    <meta name="description" content="Page du blog">
  <?php endif;?>
  <?php if (is_front_page()): ?>
    <meta name="description" content="Page d'accueil">
  <?php endif;?>
  <?php if (is_page() && !is_front_page()): ?>
    <meta name="description" content="Page de contenu">
  <?php endif;?>
  <?php if (is_single()): ?>
    <meta name="description" content="Page d'un article">
  <?php endif;?>
  <?php if (is_category()): ?>
    <meta name="description" content="Liste des articles pour la catégorie [<?php single_cat_title('', true)?>] ">
  <?php endif;?>
  <?php if (is_tag()): ?>
    <meta name="description" content="Liste des articles avec l'étiquette [<?php single_tag_title('', true)?>]">
  <?php endif;?>

  <?php wp_head();?>

</head>
<body class="w3-theme-l2 custom-background flex-wrapper">
<!-- Navbar (site on top) -->
<div class="w3-top noPrint">
  <div class="w3-bar w3-theme w3-card" id="myNavbar">
    <!-- Hide left-floated links on small screens and replace them with a menu icon -->
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-left w3-hide-large" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a> 
    <?php if ( empty(get_header_image()) ) : ?>
      <a href="<?php echo get_home_url(); ?>" class="w3-bar-item w3-button w3-wide"><b><?php echo bloginfo("name"); ?></b></a>
    <?php else: ?>
      <a href="<?php echo get_home_url(); ?>" class="w3-bar-item"><img style="height: 40px" src="<?php echo get_header_image(); ?>"/></a>
    <?php endif; ?>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-medium w3-hide-small">
      <?php
$locations = get_nav_menu_locations();
$menuID = $locations['location_menu_primary'];
if (!empty($menuID)) {
    $menuNav = wp_get_nav_menu_items($menuID);
    foreach ($menuNav as $navItem):
        echo '<a href="' . $navItem->url . '" title="' . $navItem->title . '" onclick="w3_close()" class="w3-bar-item w3-button">' . $navItem->title . '</a>';
    endforeach;
}
?>
    </div>
  </div>
</div>

<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-theme w3-card w3-animate-left w3-hide-large" style="display:none" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Fermer &times;</a>
  <?php
$locations = get_nav_menu_locations();
$menuID = $locations['location_menu_primary'];
if (!empty($menuID)) {
    $menuNav = wp_get_nav_menu_items($menuID);
    foreach ($menuNav as $navItem):
        echo '<a href="' . $navItem->url . '" title="' . $navItem->title . '" onclick="w3_close()" class="w3-bar-item w3-button">' . $navItem->title . '</a>';
    endforeach;
}
?>
</nav>

