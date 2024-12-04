window.tthieudev_script_shortcode = {
	init: function() {
        this.loadColumn();
    },

    loadColumn: function(){
        document.querySelectorAll('.project-list-content').forEach(element => {
            const columns = element.getAttribute('data-columns') || 3;
            element.style.setProperty('--columns', columns);

            if (columns == 1) {
                element.style.setProperty('--columns-1024', '1');
            } else {
                element.style.setProperty('--columns-1024', '2');
            }
        });
    },

}

document.addEventListener("DOMContentLoaded", function () {
    tthieudev_script_shortcode.init();
});
