(function ($) {
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/get_list_project.default', function ($scope, $) {
            // Code xử lý logic của bạn
            console.log('Tthieudev Widget Ready!');
        });

        // Áp dụng cho tất cả các widget
        elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope, $) {
            console.log('Global Widget Ready!');
        });
    });

    // Xử lý thay đổi trong control 'posts_per_page'
    $(document).on('click', '.elementor-control-posts_per_page input', function () {
        const control = $(this);

        $.ajax({
            url: tthieudev.ajax_url,  // URL AJAX
            type: 'POST',
            data: {
                action: 'handle_your_ajax_request',  // Action hook trong WordPress
                security_tthieu: tthieudev.security_tthieu  // Nonce bảo mật
            },

            success: function(response) {
                console.log('Response:', response); // Ghi lại toàn bộ phản hồi

                if (response.success) {
                    const maxPosts = response.data.max_posts;
                    console.log('Max posts:', maxPosts);

                    // Cập nhật giá trị tối đa vào control 'posts_per_page'
                    const controlInput = $('.elementor-control-posts_per_page input');
                    controlInput.attr('max', maxPosts);  // Cập nhật giá trị tối đa
                    controlInput.attr('aria-valuemax', maxPosts); // Cập nhật giá trị aria

                    // Giới hạn giá trị tối đa không vượt quá max_posts
                    const currentValue = parseInt(controlInput.val(), 10);
                    if (currentValue > maxPosts) {
                        controlInput.val(maxPosts);  // Đặt lại giá trị nếu người dùng nhập vượt quá max
                    }

                    // Cập nhật mô tả về số lượng bài viết tối đa
                    const description = 'Max posts allowed: ' + maxPosts;
                    $('.elementor-control-posts_per_page .elementor-control-field-description').html(description);

                    // Lắng nghe sự thay đổi giá trị để kiểm tra giới hạn
                    controlInput.on('input', function() {
                        const value = parseInt(controlInput.val(), 10);
                        if (value > maxPosts) {
                            controlInput.val(maxPosts);  // Đặt lại giá trị nếu người dùng nhập vượt quá max
                        }
                    });
                } else {
                    alert('Không thể lấy số lượng bài viết tối đa.');
                }

            },
            error: function(xhr, status, error) {
                console.log('Error fetching max posts:', error);
                alert('Có lỗi xảy ra khi lấy số lượng bài viết tối đa.');
            }
        });
    });
})(jQuery);
