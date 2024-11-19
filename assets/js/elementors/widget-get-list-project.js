jQuery(document).ready(function ($) {
    var currentPage = 1; // Current page number
    var totalPages = 0; // Total number of pages

    // Initial load to fetch the posts for the first page
    loadPosts(currentPage);

    // Handle click events on pagination links
    $(document).on('click', '.page-link', function (e) {
        e.preventDefault();
        var clickedPage = $(this).data('page');

        // If the clicked page is already the current page, do nothing
        if (clickedPage === currentPage) return;

        currentPage = clickedPage; // Update the current page
        loadPosts(currentPage); // Load posts for the selected page
    });

    /**
     * Function to load posts via AJAX
     * @param {number} page The page number to load
     */
    function loadPosts(page) {
        var loadMoreBtn = $('#wpshare247-load-more'); // Button for "Load More" functionality

        $.ajax({
            url: ajax_object.ajax_url, // Correct AJAX URL from wp_localize_script
            type: 'POST',
            data: {
                action: 'load_post_project_ajax', // Action defined in PHP for AJAX
                paged: page,
                security: ajax_object.security, // Security nonce
            },
            dataType: 'json',
            beforeSend: function () {
                loadMoreBtn.text('Loading...'); // Show loading text
                loadMoreBtn.prop('disabled', true); // Disable the button while processing
            },
            success: function (response) {
                if (response.success) {
                    $('#posts-container').html(response.data.posts); // Render posts in the container
                    totalPages = response.data.total_pages; // Update total pages
                    displayPagination(totalPages, page); // Render pagination links
                } else {
                    $('#posts-container').html('<p>No posts found.</p>'); // Show message if no posts
                    $('#pagination-container').empty(); // Clear pagination if no posts
                }
            },
            error: function () {
                alert('An error occurred while loading posts.'); // Show error message on failure
            },
            complete: function () {
                loadMoreBtn.text('Load More'); // Reset button text
                loadMoreBtn.prop('disabled', false); // Enable the button again
            },
        });
    }

    /**
     * Function to display pagination
     * @param {number} totalPages The total number of pages
     * @param {number} currentPage The current active page
     */
    function displayPagination(totalPages, currentPage) {
        var paginationHtml = ''; // HTML string for pagination links

        if (totalPages > 1) {
            // Add "Prev" button if not on the first page
            if (currentPage > 1) {
                paginationHtml +=
                    '<a href="#" class="page-link prev" data-page="' +
                    (currentPage - 1) +
                    '"><i class="fas fa-chevron-left"></i></a> ';
            }

            // Add individual page links
            for (var i = 1; i <= totalPages; i++) {
                var activeClass = i === currentPage ? 'active' : ''; // Highlight the current page
                paginationHtml +=
                    '<a href="#" class="page-link ' +
                    activeClass +
                    '" data-page="' +
                    i +
                    '">' +
                    i +
                    '</a> ';
            }

            // Add "Next" button if not on the last page
            if (currentPage < totalPages) {
                paginationHtml +=
                    '<a href="#" class="page-link next" data-page="' +
                    (currentPage + 1) +
                    '"><i class="fas fa-chevron-right"></i></a>';
            }
        }

        // Update the pagination container with the generated HTML
        $('#pagination-container').html(paginationHtml);
    }
});
