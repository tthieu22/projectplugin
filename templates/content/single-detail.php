<?php 
defined("ABSPATH") or die("You can not access directly");
?>
<div class="wrapper">
   <div class="container">
       <div class="row">
           <div class="col-9">
                <div class="img-detail ">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="project-thumbnail img-fluid">
                            <?php the_post_thumbnail( 'large' ); // Hiển thị ảnh đại diện với kích thước lớn ?>
                        </div>
                    <?php endif; ?>
                </div>
           </div>
           <div class="col-3">
                <?php tthieudev_get_template( './item/post-infor.php' ); ?> 
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
