<?php get_header();?>

<!-- !PAGE CONTENT! -->
<section class="w3-main" style="margin-top: 64px">
  <div class="w3-row">
    <!-- Content -->
    <div class="w3-col l8 s12">
      <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post();?>
	          <!-- Header -->
	          <div class="w3-card-4 w3-margin w3-white">
	            <div class="w3-container w3-xlarge w3-text-theme">
	              <h1><b><?php the_title();?></b></h1>
	            </div>
	            <div class="w3-container">
	              <?php the_content(); ?>
                <hr/>
                <p>
                <?php edit_post_link('edit', '<span>', '</span>', '', 'pbi_edit_post');?>
                <span class=""> publié le
                <time class="entry-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date()); ?>
                </time>
                </p>
	            </div><!-- /container -->
	          </div><!-- /w3-card -->
	        <?php endwhile;?>
      <?php else: ?>
        <?php get_template_part('page-404');?>
      <?php endif;?>
    </div><!-- end w3-col -->

    <?php get_template_part('sidebar');?>

  </div><!-- /row -->
  </section><!-- w3-main -->

<?php get_footer();?>
