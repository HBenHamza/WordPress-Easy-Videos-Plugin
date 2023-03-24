<?php

/*
 * Easy Videos - Admin Template
 *
 */

if ( $posts -> have_posts() ) : ?>
    <div class="container">
        <div class="row clearfix">
            <?php while ( $posts -> have_posts() ) : $posts->the_post();
                $videoId = get_post_meta(get_the_ID(),'videoId');
                $output .= '<div class="col-md-6 col-sm-6 col-xs-12">';
                    $output .='<div class="items">';
                        $output .= '<iframe src="https://www.youtube.com/embed/'. $videoId .'?rel=0&amp;showinfo=0" width="600" height="338" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                    $output .='</div>';
                $output .= '</div>';
            endwhile; ?>
        <?php echo $output; ?> 
        </div>
        </div>
        <?php endif;
wp_reset_query(); ?>

