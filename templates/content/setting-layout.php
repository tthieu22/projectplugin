<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="setting-project-wrapper">
    <h1 class="m-0">Project Settings</h1><br><br>
</div>

<div class="tab-setting-control">
    <button type="button" class="w3-bar-item w3-button active" onclick="openCity('Single')">Single</button>
    <button type="button" class="w3-bar-item w3-button" onclick="openCity('Archive')">Archive</button>
</div>

<?php TemplateLoader::get_template('form/form-setting-single.php' ); ?> 
<?php TemplateLoader::get_template('form/form-setting-archive.php' ); ?> 