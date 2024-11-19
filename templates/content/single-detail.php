<?php 
defined("ABSPATH") or die("You can not access directly");
?>
<div class="wrapper">
   <div class="container">
       <div class="row">
           <div class="col-9">
                <div class="img-detail ">
                    <?php if (get_option('checked-show-image') == '1') { ?>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="project-thumbnail img-fluid">
                                <?php the_post_thumbnail( 'large' ); // Hiển thị ảnh đại diện với kích thước lớn ?>
                            </div>
                        <?php endif; ?>
                    <?php } ?>
                </div>
           </div>
           <div class="col-3">
                <?php TemplateLoader::get_template('item/post-meta.php' ); ?> 
           </div>
       </div>
   </div>
   <div class="container">
       <div class="row">
           <div class="col-12">
                <div class="single-page-content">
                   <?php the_content() ?>
                </div>
           </div>
       </div>
   </div>
</div>
