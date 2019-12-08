<?php
global $post;
$current_post_slug = $post->post_name;

if ( !empty($_REQUEST['tag']) ) {
  $is_tag = true;
  $term_id = $_REQUEST['tag'];
  $term_name = $term_id;
}
if ( is_tag() ) {
  $is_tag = true;
  $term_id = get_query_var('tag');
  $term_name = $term_id;
}
if ( !empty($_REQUEST['category']) ) {
  $is_category = true;
  $category = get_category_by_slug($_REQUEST['category']);
  $term_id = $category->cat_ID;
  $term_slug = $category->slug;
  $term_name = $category->cat_name;
}
if ( is_category() ) {
  $is_category = true;
  $term_id = get_query_var('cat');
  $term_slug = get_cat_slug($term_id);
  $term_name = single_cat_title('', false );
}
$options = get_option('theme_options');
?>
<!-- SIDEBAR -->
<div class="w3-col l4 noPrint">
  <!-- A LA UNE / LES DERNIERS ARTICLES -->
  <div class="w3-card w3-margin">
    <div class="w3-container w3-padding w3-theme w3-opacity-min" style="">
    <?php if ( $is_tag or $is_category ): ?>
      <span class="w3-large"><?php echo $options["theme_article_title"]; ?></span>
      <span class="w3-tag w3-round-large w3-white w3-large w3-opacity-min-off">
        <?php echo $term_name; ?>
      </span>
    <?php else: ?>
      <span class="w3-large"><?php echo $options["theme_news_title"]; ?></span>
    <?php endif; ?>
    </div>
<?php
$options = get_option('theme_options');
if ( $is_category ):
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'cat' => $term_id
  );
  if ( $options['theme-sort'] == "oui"):
    $args['orderby'] = 'title';
    $args['order'] = 'ASC';
  endif;
elseif ( $is_tag ):
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'tag' => $term_id
  );
else:
  $args = array(
    'post_type' => 'post',
    'post__in' => get_option('sticky_posts')
  );
  if ( $options['theme-sort'] == "oui"):
    $args['orderby'] = 'title';
    $args['order'] = 'ASC';
  endif;
endif;
$req_blog = new WP_Query($args);
?>
    <ul class="w3-ul w3-hoverable w3-white">
    <?php if ($req_blog->have_posts()): ?>
      <?php while ($req_blog->have_posts()): $req_blog->the_post();?>
        <?php 
          global $post;
          $post_slug = $post->post_name;
          $style_class = $post_slug == $current_post_slug ? "w3-theme-l4" : ""; 
          $tag = get_the_tag_list('', '</div> <div class="w3-tag w3-round-large w3-theme w3-right">');
        
          if ( is_home() and ! is_sticky() ) continue;

          if ( $is_tag ):
            $url = get_permalink() . '?tag=' . $term_id;
          elseif ( $is_category ):
            $url = get_permalink() . '?category=' . $term_slug;
          else:
            $url = get_permalink();
          endif;

          if ( is_user_logged_in() and is_pbi_cookie("pbi_private_checked") ):
            if ( $post->post_status == 'private' ):?>
              <li class="w3-padding-16 <?php echo $style_class; ?>">
                <div class="w3-tag w3-round-large w3-theme w3-right"><?php echo $tag; ?></div>
                <a href="<?php echo $url;?>"><span class="w3-large"><?php the_title();?></span></a>
              </li>
            <?php endif; ?>
          <?php else: ?>
            <?php if ( $post->post_status == 'publish' ):?>
              <li class="w3-padding-16 <?php echo $style_class; ?>">
                <div class="w3-tag w3-round-large w3-theme w3-right"><?php echo $tag; ?></div>
                <a href="<?php echo $url;?>"><span class="w3-large"><?php the_title();?></span></a>
              </li>
            <?php endif; ?>
          <?php endif; ?>
      <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata();?>
    </ul>
  </div><!-- w3-card -->
  <!-- /A LA UNE -->
  <p class="w3-tiny">&nbsp;</p>
  <!-- CLASSEMENT -->
  <div class="w3-card w3-margin">
    <div class="w3-container w3-padding w3-theme w3-opacity-min">
      <span class="w3-large"><?php echo $options["theme_classement_title"]; ?></span>
    </div>
    <div class="w3-container w3-white">
      <p>
    <?php
      if ( is_user_logged_in(  ) ) {
        if ( is_pbi_cookie("pbi_private_checked")) {
          $cats_tags = pbi_get_categories_tags('private'); 
        } else {
          $cats_tags = pbi_get_categories_tags('publish'); 
        }
      } else {
        $cats_tags = pbi_get_categories_tags('publish'); 
      }
      $cats = $cats_tags['categories'];
      $tags = $cats_tags['tags'];
      asort($cats);
      krsort($tags);
      ?>
    <?php foreach ($cats as $slug => $name): ?>
      <span class="w3-tag w3-round-large w3-margin-bottom w3-theme">
      <a href="<?php echo get_home_url() . '/category/' . $slug;?>" style="text-decoration: none;">
      <?php echo $name;?></a>
      </span>
    <?php endforeach;?>
      </p>
      <p>
    <?php foreach ($tags as $slug => $name): ?>
      <span class="w3-tag w3-round-large w3-margin-bottom w3-theme">
      <a href="<?php echo get_home_url() . '/tag/' . $slug;?>" style="text-decoration: none;">
      <?php echo $name;?></a>
      </span>
    <?php endforeach;?>
      </p>
    </div><!-- container -->
  </div><!-- w3-card -->
  <!-- /CLASSEMENT -->
</div><!-- w3-col -->
<!-- /SIDEBAR -->
