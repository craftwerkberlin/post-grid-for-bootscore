<?php
/*Plugin Name: Post Grid for bootScore
Plugin URI: https://bootscore.me
Description: Post slider for bootScore theme https://bootscore.me. Use Shortcode like this [post-grid type="post" category="sample-category" order="ASC" orderby="title" posts="12"] and read readme.txt in PlugIn folder for options.
Version: 1.0.0
Author: craftwerk - Bastian Kreiter
Author URI: https://crftwrk.de
License: GPLv2
*/




// Post Grid Shortcode
add_shortcode( 'post-grid', 'bootscore_post_grid' );
function bootscore_post_grid( $atts ) {
	ob_start();
	extract( shortcode_atts( array (
		'type' => 'post',
		'order' => 'date',
		'orderby' => 'date',
		'posts' => -1,
		'category' => '',
	), $atts ) );
	$options = array(
		'post_type' => $type,
		'order' => $order,
		'orderby' => $orderby,
		'posts_per_page' => $posts,
		'category_name' => $category,
	);
	$query = new WP_Query( $options );
	if ( $query->have_posts() ) { ?>


<div class="row">
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <!-- Featured Image-->
            <?php the_post_thumbnail('medium', array('class' => 'card-img-top')); ?>

            <div class="card-body d-flex flex-column">
                <div class="mb-2">
                    <!-- Category Badge -->
                    <?php
				        $thelist = '';
				        $i = 0;
				        foreach( get_the_category() as $category ) {
				            if ( 0 < $i ) $thelist .= ' ';
				                $thelist .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="badge badge-secondary">' . $category->name.'</a>';
								$i++;
				        }
				        echo $thelist;
				    ?>
                </div>
                <!-- Title -->
                <h2 class="blog-post-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <!-- Meta -->
                <?php if ( 'post' === get_post_type() ) : ?>
                <small class="text-secondary mb-2">
                    <?php
				        bootscore_date();
				        bootscore_author();
				        bootscore_comments();
				        bootscore_edit();
				    ?>
                </small>
                <?php endif; ?>
                <!-- Excerpt & Read more -->
                <div class="card-text mt-auto">
                    <?php the_excerpt(); ?> <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read more', 'bootscore'); ?></a>
                </div>
                <!-- Tags -->
                <?php bootscore_tags(); ?>
            </div>
        </div>
    </div>
    <?php endwhile; wp_reset_postdata(); ?>
</div>

<?php $myvariable = ob_get_clean();
	return $myvariable;
	}	
}

// Post Grid Shortcode End
