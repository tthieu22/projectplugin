<?php defined( 'ABSPATH' ) || exit; ?>

<form method="get">
    <p class="search-box search-list-project-admin">
        <label class="screen-reader-text" for="<?php //echo esc_attr( $input_id ); ?>">
            <?php// echo esc_html( $text ); ?>:
        </label>
        <span class="box">
            <label for="id-search">Search by ID:</label>
            <input type="number" id="id-search" name="id_search" value="<?php echo esc_attr( isset( $_GET['id_search'] ) ? $_GET['id_search'] : '' ); ?>" placeholder="Enter ID" />
        </span>

        <span class="box">
            <label for="title-search">Search by Title:</label>
            <input type="text" id="title-search" name="title_search" value="<?php echo esc_attr( isset( $_GET['title_search'] ) ? $_GET['title_search'] : '' ); ?>" placeholder="Enter title" />
        </span>

        <span class="box">
            <label for="client-search">Search by Client:</label>
            <input type="text" id="client-search" name="client_search" value="<?php echo esc_attr( isset( $_GET['client_search'] ) ? $_GET['client_search'] : '' ); ?>" placeholder="Enter client name" />
        </span>
        <span class="box">
            <label for="date-search">Search by Date:</label>
            <input type="date" id="date-search" name="date_search" value="<?php echo esc_attr( isset( $_GET['date_search'] ) ? $_GET['date_search'] : '' ); ?>" />
        </span>

        <span class="box">
            <label for="date-search"></label>
            <a href="<?php echo esc_url( remove_query_arg( ['id_search', 'title_search', 'client_search', 'date_search' ] ) ); ?>" class="button" id="clear-search">Clear</a>
        </span>

        <span class="box">
            <label for="date-search"></label>
            <?php
            submit_button( 'Search Project', '', '', false, [
                'id' => 'filter-submit',
            ] );
            ?>
        </span>
    </p>
</form>