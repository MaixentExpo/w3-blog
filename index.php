<?php get_header();?>

<!-- PAGE ACCUEIL -->
<div class="w3-main" style="margin-top: 64px">
  <!-- Grid -->
  <div class="w3-row">
    <!-- Content -->
    <div class="w3-col l8 s12">
    <!--  Le contenuu de l'article article-accueil -->
      <?php
$query = new WP_Query(array(
    'post_type' => 'post',
    'name' => 'accueil',
    'post_status' => 'publish',
));
if ($query->have_posts()): ?>
            <?php while ($query->have_posts()): $query->the_post();?>
	              <?php
    if (is_user_logged_in()
    and is_pbi_cookie("pbi_private_checked")):
        if ($post->post_status == 'private'):
            get_template_part('content');
        else:
            get_template_part('page-404');
        endif;
    else:
        if ($post->post_status == 'publish'):
            get_template_part('content');
        else:
            get_template_part('page-404');
        endif;
    endif;
    ?>
	            <?php endwhile;
wp_reset_postdata();?>
        <?php else: ?>
          <?php get_template_part('page-404');?>
        <?php endif;?>
      </div><!-- w3-col -->
    <?php get_template_part('sidebar');?>
  </div><!-- w3-row -->
</div><!-- w3-main -->

<?php get_footer();?>
