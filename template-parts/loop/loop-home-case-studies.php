<li class="<?php echo ( $is_first ? 'is-active ' : '' ); ?>orbit-slide">
    
    <div class="row">
        
        <div class="small-12 medium-6 columns image-container">
        
            <?php echo wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'full', false, array() ); ?>
            
        </div>
        
        <div class="small-12 medium-6 columns text-container">
        
            <?php the_content(); ?>
        
        </div>
        
    </div>
    
</li>

<?php

$is_first = false;