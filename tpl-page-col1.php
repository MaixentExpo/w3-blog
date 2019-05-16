<?php
/*
Template Name: Page Une Colonne
 */
?>
<?php get_header();?>

<!-- !PAGE CONTENT! -->
<div class="w3-main">
    <section class="w3-container" style="margin-top: 64px" id="showcase">
        <div class="w3-hide-large" style="margin-top: 60px"></div>
        <!--  Le contenuu de la page -->
        <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post();?>
	            <!-- le contenu de l'article -->
	            <?php get_template_part('content');?>
	        <?php endwhile;?>
        <?php endif;?>

    </section>
  </div><!-- w3-main -->

<?php get_footer();?>
