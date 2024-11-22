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

<?php TemplateLoader::get_template('forms/form-setting-single.php' ); ?> 
<?php TemplateLoader::get_template('forms/form-setting-archive.php' ); ?> 
<script>
    function openCity(cityName) {
        // Lấy tất cả các phần tử có class "city" và ẩn chúng
        var cities = document.getElementsByClassName("city");
        for (var i = 0; i < cities.length; i++) {
            cities[i].style.display = "none";
        }

        // Xóa class "active" từ tất cả các nút
        var buttons = document.getElementsByClassName("w3-button");
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].classList.remove("active");
        }

        // Hiển thị tab được chọn và thêm class "active" cho nút được chọn
        document.getElementById(cityName).style.display = "block";
        event.currentTarget.classList.add("active");
    }

    // Hiển thị tab đầu tiên (Single) khi trang được tải
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("Single").style.display = "block";
    });
</script>
