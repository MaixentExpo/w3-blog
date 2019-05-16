<?php global $wp_query;
$big = 999999999; // need an unlikely integer
$total_pages = $wp_query->max_num_pages;
if ($total_pages > 1): ?>
        <div class="w3-container">
            <div class="w3-bar">
                <?php echo paginate_links(array(
    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
    'format' => '/page/%#%',
    'current' => max(1, get_query_var('paged')),
    'total' => $total_pages,
    'prev_next' => true,
    'prev_text' => '<<',
    'next_text' => '>>',
)); ?>
            </div>
        </div>
<?php endif;?>
