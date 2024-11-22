window.tthieudev_script_max_post = {
    init: function() {
        const dataPostsElement = document.querySelector('.data-posts');
        this.postsPerPage = dataPostsElement.getAttribute('data-posts-per-page');
        this.selectedTags = dataPostsElement.getAttribute('data-selected-tags');
        this.selectedCategories = dataPostsElement.getAttribute('data-selected-categories');
        this.currentPostId = dataPostsElement.getAttribute('data-current_post_id');
        this.selectedTags = this.selectedTags && this.selectedTags.trim() !== '' ? this.selectedTags.split(',') : [];
        this.selectedCategories = this.selectedCategories && this.selectedCategories.trim() !== '' ? this.selectedCategories.split(',') : [];

        // Kiểm tra và in ra các giá trị để xác nhận
        console.log('Selected Tags:', this.selectedTags);
        console.log('Selected Categories:', this.selectedCategories);
        console.log('Current Post ID:', this.currentPostId);
        this.loadColumn();

        this.clickInput(); 
    },

    loadColumn: function(){
        document.querySelectorAll('.content-archive-post').forEach(element => {
            const columns = element.getAttribute('data-columns') || 3;
            element.style.setProperty('--columns', columns);
        });
    },
    clickInput: function() {
        const self = this;
        jQuery(document).on('click', '.elementor-control-posts_per_page input', function() {
            jQuery.ajax({
                url: tthieudev.ajax_url,  
                type: 'POST',
                data: {
                    action: 'handle_your_ajax_request',  
                    security_tthieu: tthieudev.security_tthieu, 
                    selected_tags: self.selectedTags.join(','), 
                    selected_categories: self.selectedCategories.join(','), 
                    current_post_id: self.currentPostId, 
                },
                success: function(response) {
                    console.log('Response:', response); 
                    if (response.success) { 
                        const maxPosts = response.data.max_posts; 
                        console.log('Max posts:', maxPosts);

                        const controlInput = jQuery('.elementor-control-posts_per_page input');
                        controlInput.attr('max', maxPosts);  
                        controlInput.attr('aria-valuemax', maxPosts); 

                        const currentValue = parseInt(controlInput.val(), 10);
                        if (currentValue > maxPosts) {
                            controlInput.val(maxPosts);  
                        }
                        const description = 'Max posts allowed: ' + maxPosts;
                        jQuery('.elementor-control-posts_per_page .elementor-control-field-description').html(description);

                        controlInput.on('input', function() {
                            const value = parseInt(controlInput.val(), 10);
                            if (value > maxPosts) {
                                controlInput.val(maxPosts); 
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
    }
};
jQuery(document).ready(function() {
    tthieudev_script_max_post.init();
});
