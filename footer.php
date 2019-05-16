
<footer class="w3-container w3-theme w3-padding-16 noPrint" style="margin-top: 16px">
    <!-- Return to Top -->
    <a href="javascript:" id="return-to-top" class="w3-theme-action"><i class="fa fa-arrow-up"></i></a>
    <div class="w3-row">
        <div class="w3-col m3">
            <div class="w3-bar-block">
            <img style="height: 128px" src="<?php echo get_site_icon_url(); ?>" />
            </div>
        </div><!-- /w3-col -->
        <div class="w3-col m3">
            <?php
$locations = get_nav_menu_locations();
$menuID = $locations['location_menu_footer_public'];
if (!empty($menuID)) {
    // echo '<h5 class=""><b>Liens</b></h5>';
    // echo '<hr style="width:50px;border:2px solid" class="w3-round w3-text-theme">';
    echo '<div class="w3-bar-block">';
    $menuNav = wp_get_nav_menu_items($menuID);
    foreach ($menuNav as $navItem):
        echo '<a href="' . $navItem->url . '" title="' . $navItem->title . '" class="w3-bar-item w3-button w3-hover-text-theme w3-theme">' . $navItem->title . '</a>';
    endforeach;
    echo '</div>'; // end w3-bar
}
?>
        </div><!-- /w3-col -->
        <div class="w3-col m3">
            <?php
$locations = get_nav_menu_locations();
$menuID = $locations['location_menu_footer_public2'];
if (!empty($menuID)) {
    // echo '<h5 class=""><b>Liens</b></h5>';
    // echo '<hr style="width:50px;border:2px solid" class="w3-round w3-text-theme">';
    echo '<div class="w3-bar-block">';
    $menuNav = wp_get_nav_menu_items($menuID);
    foreach ($menuNav as $navItem):
        echo '<a href="' . $navItem->url . '" title="' . $navItem->title . '" class="w3-bar-item w3-button w3-hover-text-theme w3-theme">' . $navItem->title . '</a>';
    endforeach;
    echo '</div>'; // end w3-bar
}
?>
        </div><!-- /w3-col -->
        <div class="w3-col m3">
            <?php
$locations = get_nav_menu_locations();
$menuID = $locations['location_menu_footer_prive'];
if (!empty($menuID)) {
    // echo '<h5 class=""><b>Administration</b></h5>';
    // echo '<hr style="width:50px;border:2px solid" class="w3-round w3-text-theme">';
    echo '<div class="w3-bar-block">';
    if (is_user_logged_in()) {
        $menuNav = wp_get_nav_menu_items($menuID);
        foreach ($menuNav as $navItem):
            echo '<a href="' . $navItem->url . '" title="' . $navItem->title . '" class="w3-bar-item w3-button w3-hover-text-theme w3-theme">' . $navItem->title . '</a>';
        endforeach;
        echo '<a href="' . wp_logout_url("/") . '" title="Se déconnecter" class="w3-bar-item w3-button w3-hover-text-theme w3-theme">' . "Se déconnecter" . '</a>';
        echo '<a href="/intrafoire" title="Intrafoire" class="w3-bar-item w3-button w3-hover-text-theme w3-theme">' . "Intrafoire" . '</a>';
        echo '<a href="/calendar" title="Agenda" class="w3-bar-item w3-button w3-hover-text-theme w3-theme">' . "Agenda" . '</a>';
    } else {
        echo '<a href="' . wp_login_url("/") . '" title="Se connecter" class="w3-bar-item w3-button w3-hover-text-theme w3-theme">' . "Se connecter..." . '</a>';
    } // endif
    echo '</div>'; // end w3-bar
}
?>
        </div><!-- /w3-col -->
    </div><!-- /w3-row -->
</footer>
<?php wp_footer();?>

</body>
</html>