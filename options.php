<?php
add_action('admin_menu', 'email_inliner_admin_add_page');
function email_inliner_admin_add_page() {
    add_options_page(
        'Email Inliner Options',
        'Email Inliner Menu',
        'manage_options',
        'email_inliner',
        'email_inliner_options_page'
    );
}
?>

<?php
function email_inliner_options_page() {
?>
<div class="wrap">
  <h1>Email Inliner Options</h1>
  <form method="post" action="options.php">
    <?php settings_fields('email_inliner_group'); ?>
    <?php do_settings_sections('email_inliner'); ?>
    <?php submit_button(); ?>
  </form>
</div>
<?php } ?>

<?php
add_action('admin_init', 'email_inliner_admin_init');
function email_inliner_admin_init() {
    register_setting('email_inliner_group', 'email_inliner_group', 'inliner_url_validate');
    add_settings_section('inliner_main', 'Main Settings', 'inliner_section_text', 'email_inliner');
    add_settings_field('inliner_plugin_string', 'Inliner URL', 'inliner_setting_string', 'email_inliner', 'inliner_main');
}
?>

<?php function inliner_section_text() {
    echo '<p>Add URL to email inliner</p>';
} ?>

<?php function inliner_setting_string() {
    $options = get_option('email_inliner_group');
    echo "<input id='inliner_plugin_string' name='email_inliner_group[inliner_url]' size='40' type='text' value='{$options['inliner_url']}' />";
} ?>

<?php function inliner_url_validate($input) {
    return $input;
} ?>
