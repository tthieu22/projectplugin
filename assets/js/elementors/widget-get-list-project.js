window.tthieudev_script = {
    init: function() {
        this.currentPage = 1;
        this.totalPages = 0;
        this.postsPerPage = $('.data-posts').data('posts-per-page');
        this.selectedTags = $('.data-posts').data('selected-tags'); // Convert to array
        this.selectedCategories = $('.data-posts').data('selected-categories'); // Convert to array
        this.currentPostId = $('.data-posts').data('current_post_id');

        this.loadPosts(this.currentPage);
        this.setupPagination();
        this.loadColumn();
    },

    setupPagination: function() {
        const self = this;
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            var clickedPage = $(this).data('page');
            if (clickedPage === self.currentPage) return;

            self.currentPage = clickedPage; 
            self.loadPosts(self.currentPage); 
        });
    },
    loadColumn: function() {
        document.querySelectorAll('.content-archive-post-widget').forEach(element => {
            const columns = element.getAttribute('data-columns') || 3;
            element.style.setProperty('--columns', columns);

            if (columns == 1) {
                document.documentElement.style.setProperty('--columns-1024', '1');
            } else {
                document.documentElement.style.setProperty('--columns-1024', '2');
            }
        });
    },

    parseDataAttribute: function(data) {
        if (typeof data !== 'string') {
            return [];
        }
        return data.length > 0 ? data.split(',') : [];
    },

    loadPosts: function(page) {
        const self = this;
        $('#posts-container').removeClass('loaded').addClass('loading');

        $.ajax({
            url: ajax_object.ajax_url, 
            type: 'POST',
            data: {
                action: 'load_post_project_ajax',
                paged: page,
                posts_per_page: self.postsPerPage,
                selected_tags: self.selectedTags,
                selected_categories: self.selectedCategories,
                current_post_id: self.currentPostId,
                security: ajax_object.security, 
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#posts-container').html(response.data.posts); 
                    self.totalPages = response.data.total_pages; 
                    self.displayPagination(self.totalPages, page); 
                } else {
                    $('#posts-container').html('<p>No posts found.</p>');
                    $('#pagination-container').empty();
                }
            },
            error: function() {
                alert('An error occurred while loading posts.'); 
            },
             complete: function() {
                setTimeout(() => {
                    $('#posts-container').removeClass('loading').addClass('loaded');
                }, 300); 
            }
        });
    },

    displayPagination: function(totalPages, currentPage) {
        var paginationHtml = ''; 

        if (totalPages > 1) {
            if (currentPage > 1) {
                paginationHtml +=
                    '<a href="#" class="page-link prev" data-page="' +
                    (currentPage - 1) +
                    '"><i class="fas fa-chevron-left"></i></a> ';
            }

            if (totalPages <= 5) {
                for (var i = 1; i <= totalPages; i++) {
                    var activeClass = i === currentPage ? 'active' : '';
                    paginationHtml +=
                        '<a href="#" class="page-link ' +
                        activeClass +
                        '" data-page="' +
                        i +
                        '">' +
                        i +
                        '</a> ';
                }
            } else {
                if (currentPage <= 3) {
                    for (var i = 1; i <= 4; i++) {
                        var activeClass = i === currentPage ? 'active' : ''; 
                        paginationHtml +=
                            '<a href="#" class="page-link ' +
                            activeClass +
                            '" data-page="' +
                            i +
                            '">' +
                            i +
                            '</a> ';
                    }
                    paginationHtml += '<a href="#" class="page-link dots page-num" data-page="...">...</a> ';
                    paginationHtml +=
                        '<a href="#" class="page-link" data-page="' +
                        totalPages +
                        '">' +
                        totalPages +
                        '</a>';
                } else if (currentPage >= totalPages - 2) {
                    paginationHtml +=
                        '<a href="#" class="page-link" data-page="1">1</a> ';
                    paginationHtml += '<a href="#" class="page-link dots page-num" data-page="...">...</a> ';
                    for (var i = totalPages - 3; i <= totalPages; i++) {
                        var activeClass = i === currentPage ? 'active' : ''; 
                        paginationHtml +=
                            '<a href="#" class="page-link ' +
                            activeClass +
                            '" data-page="' +
                            i +
                            '">' +
                            i +
                            '</a> ';
                    }
                } else {
                    paginationHtml +=
                        '<a href="#" class="page-link" data-page="1">1</a> ';
                    paginationHtml += '<a href="#" class="page-link dots page-num" data-page="...">...</a> ';
                    for (var i = currentPage - 1; i <= currentPage + 1; i++) {
                        var activeClass = i === currentPage ? 'active' : ''; 
                        paginationHtml +=
                            '<a href="#" class="page-link ' +
                            activeClass +
                            '" data-page="' +
                            i +
                            '">' +
                            i +
                            '</a> ';
                    }
                    paginationHtml += '<a href="#" class="page-link dots page-num" data-page="...">...</a> ';
                    paginationHtml +=
                        '<a href="#" class="page-link" data-page="' +
                        totalPages +
                        '">' +
                        totalPages +
                        '</a>';
                }
            }
            if (currentPage < totalPages) {
                paginationHtml +=
                    '<a href="#" class="page-link next" data-page="' +
                    (currentPage + 1) +
                    '"><i class="fas fa-chevron-right"></i></a>';
            }
        }

        $('#pagination-container').html(paginationHtml);
    }

};

$(document).ready(function() {
    tthieudev_script.init();
});
