<?php get_header();?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-top: 64px">
  <!-- Grid -->
  <div class="w3-row">
    <!-- Content -->
    <div class="w3-col l8 s12">
    <div class="w3-container w3-margin-top">
    <span class="w3-tag w3-large w3-round-large w3-theme-action">Tous les articles</span>
      </div><!-- container -->

      <!-- Blog entry -->
      <?php 
if (have_posts()):
    while (have_posts()):
        the_post();
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
    endwhile;
    wp_reset_postdata();
    get_template_part('paginate');
else:
    get_template_part('page-404');
endif;
?>
    </div><!-- w3-col -->

    <?php get_template_part('sidebar');?>

  </div><!-- w3-row -->
</div><!-- w3-main -->

<?php get_footer();?>
