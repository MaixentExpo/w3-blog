
<!-- Affichage des méta données de l'article -->
<?php
//if ($post->post_type == 'post'):
if (true):
		$cat = get_the_category_list('</span> <span class="w3-tag w3-round-large w3-theme">');
    $tag = get_the_tag_list('', '</span> <span class="w3-tag w3-round-large w3-theme">');
    ?>
		    <hr/>
		    <p>
		    <?php edit_post_link('edit', '<span>', '</span>', '', 'pbi_edit_post');?>
		    <span class=""> publié le
		    <time class="entry-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
		        <?php echo esc_html(get_the_date()); ?>
		    </time> dans </span>
		    <span class="w3-tag w3-round-large w3-theme"><?php echo $cat; ?></span>
		    <span class="w3-tag w3-round-large w3-theme"><?php echo $tag; ?></span>
		    </p>
	    <?php
endif;?>
