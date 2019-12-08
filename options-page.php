<?php // display the admin options page
// http://ottopress.com/2009/wordpress-settings-api-tutorial/

/**
    Affichage de la page des Options
 */
function theme_options_page()
{
    ?>
<div>
    <h1>Options du thème</h1>
    <form action="options.php" method="post">
    <?php settings_fields('theme_options'); // sécurisation de la transaction ?>
    <?php do_settings_sections('options_theme'); // section des champs input ?>

    <input name="Submit" type="submit" value="<?php esc_attr_e('Enregistrer');?>" />
    </form>
</div>
<?php
}

/**
    Affichage de la section
 */
function options_section_text()
{
    echo '<p>Les goûts et couleurs, prenez votre décision ici <a href="https://www.w3schools.com/w3css/w3css_color_themes.asp" target="_blank">W3.CSS</a></p>';
}

/**
    Saisie du champ theme_w3css
 */
function pbi_setting_theme_w3css()
{
    $themes = array('indigo', 'dark-grey', 'brown', 'blue-grey', 'deep-purple', 'blue'
        , 'teal', 'red', 'deep-orange', 'pink', 'light-blue', 'green', 'purple', 'cyan'
        , 'light-green', 'lime', 'khaki', 'yellow', 'amber', 'orange', 'grey', 'black', 'w3school');
    $options = get_option('theme_options');
    echo '<select id="theme_options[theme_w3css]" name="theme_options[theme_w3css]">';
    foreach ($themes as $theme) {
        echo '<option value="' . $theme . '"'
            . ($theme == $options["theme_w3css"] ? " selected" : "")
            . '>' . $theme . '</option>';
    }
}

/**
    Saisie du champ theme_sort
 */
function pbi_setting_theme_sort()
{
    $items = array('non', 'oui');
    $options = get_option('theme_options');
    echo '<select id="theme_options[theme_sort]" name="theme_options[theme_sort]">';
    foreach ($items as $item) {
        echo '<option value="' . $item . '"'
            . ($item == $options["theme_sort"] ? " selected" : "")
            . '>' . $item . '</option>';
    }
}

/**
    Saisie du champ theme_article_title
 */
function pbi_setting_theme_article_title()
{
    $options = get_option('theme_options');
    $value = empty($options["theme_article_title"]) ? "Articles classés dans " : $options["theme_article_title"];
    echo '<input type="text" id="theme_options[theme_article_title]" name="theme_options[theme_article_title]" 
        value="'.$value.'">';
}

/**
    Saisie du champ theme_news_title
 */
function pbi_setting_theme_news_title()
{
    $options = get_option('theme_options');
    $value = empty($options["theme_news_title"]) ? "Les derniers articles" : $options["theme_news_title"];
    echo '<input type="text" id="theme_options[theme_news_title]" name="theme_options[theme_news_title]" 
        value="'.$value.'">';
}
/**
    Saisie du champ theme_classement_title
 */
function pbi_setting_theme_classement_title()
{
    $options = get_option('theme_options');
    $value = empty($options["theme_classement_title"]) ? "Classement des articles" : $options["theme_classement_title"];
    echo '<input type="text" id="theme_options[theme_classement_title]" name="theme_options[theme_classement_title]" 
        value="'.$value.'">';
}

/**
    Validation du champ de saisie
 */
function theme_options_validate($input)
{
    $options = get_option('theme_options');
    $options['theme_w3css'] = trim($input['theme_w3css']);
    $options['theme_sort'] = trim($input['theme_sort']);
    $options['theme_article_title'] = trim($input['theme_article_title']);
    $options['theme_news_title'] = trim($input['theme_news_title']);
    $options['theme_classement_title'] = trim($input['theme_classement_title']);
    return $options;
}
