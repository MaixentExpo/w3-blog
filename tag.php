<?php get_header();?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-top: 64px">
  <!-- Grid -->
  <div class="w3-row">
    <!-- Content -->
    <div class="w3-col l8 s12">
      <!-- Blog entry -->
      <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post();?>
	          <?php
    if (is_user_logged_in()
    and is_pbi_cookie("pbi_private_checked")):
        if ($post->post_status == 'private'):
            get_template_part('excerpt');
        else:
            get_template_part('page-404');
        endif;
    else:
        if ($post->post_status == 'publish'):
            get_template_part('excerpt');
        else:
            get_template_part('page-404');
        endif;
    endif;
    break; // un seul article
    ?>
	        <?php endwhile;?>
      <?php else: ?>
        <?php get_template_part('page-404');?>
      <?php endif;?>
      <?php wp_reset_postdata();?>
      <?php get_template_part('paginate');?>
    </div><!-- w3-col -->

    <?php get_template_part('sidebar');?>

  </div><!-- w3-row -->
</div><!-- w3-main -->

<?php get_footer();?>
