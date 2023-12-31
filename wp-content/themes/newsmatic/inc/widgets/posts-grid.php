<?php
/**
 * Adds Newsmatic_Posts_Grid_Widget widget.
 * 
 * @package Newsmatic
 * @since 1.0.0
 */
class Newsmatic_Posts_Grid_Widget extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'newsmatic_posts_grid_widget',
            esc_html__( 'Newsmatic : Posts Grid', 'newsmatic' ),
            array( 'description' => __( 'A collection of posts from specific category displayed in grid layout.', 'newsmatic' ) )
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $widget_title = isset( $instance['widget_title'] ) ? $instance['widget_title'] : '';
        $posts_category = isset( $instance['posts_category'] ) ? $instance['posts_category'] : '';
        $posts_count = isset( $instance['posts_count'] ) ? $instance['posts_count'] : 3;
        $image_size = isset( $instance['image_size'] ) ? $instance['image_size'] : 'newsmatic-grid';
        $image_ratio = isset( $instance['image_ratio'] ) ? $instance['image_ratio'] : json_encode(array('desktop'   => 0.6,'tablet'    => 0.6,'smartphone'=> 0.6));
        $image_border_radius = isset( $instance['image_border_radius'] ) ? $instance['image_border_radius'] : json_encode(array('desktop'   => 0,'tablet'    => 0,'smartphone'=> 0));

        echo wp_kses_post($before_widget);

        if( isset( $args['widget_id'] ) ) :
            ?>
                <style id="<?php echo esc_attr( $args['widget_id'] ); ?>">
                    <?php
                        $image_ratio = json_decode($image_ratio);

                        echo "#" .$args['widget_id']. " figure.post-thumb { padding-bottom: calc( " .$image_ratio->desktop. " * 100% ) }\n";
                        echo "@media (max-width: 769px){ #" .$args['widget_id']. " figure.post-thumb { padding-bottom: calc( " .$image_ratio->tablet. " * 100% ) } }\n";
                        echo "@media (max-width: 548px){ #" .$args['widget_id']. " figure.post-thumb { padding-bottom: calc( " .$image_ratio->smartphone. " * 100% ) } }\n";


                        $image_border_radius = json_decode($image_border_radius);

                        echo "#" .$args['widget_id']. " figure.post-thumb img { border-radius: " .$image_border_radius->desktop. "px }\n";
                        echo "@media (max-width: 769px){ #" .$args['widget_id']. " figure.post-thumb img { border-radius: " .$image_border_radius->tablet. "px } }\n";
                        echo "@media (max-width: 548px){ #" .$args['widget_id']. " figure.post-thumb img { border-radius: " .$image_border_radius->smartphone. "px } }\n";
                    ?>
                </style>
            <?php endif;


            if ( ! empty( $widget_title ) ) {
                echo $before_title . esc_html( $widget_title ) . $after_title;
            }
    ?>
            <div class="posts-wrap posts-grid-wrap feature-post-block layout-one">
                <?php
                    $post = new WP_Query( 
                        array( 
                            'category_name'    => esc_html( $posts_category ),
                            'posts_per_page' => absint( $posts_count ),
                            'ignore_sticky_posts'    => true
                        )
                    );
                    if( $post->have_posts() ) :
                        while( $post->have_posts() ) : $post->the_post();
                            $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), $image_size);
                            $categories = get_the_category();
                    ?>
                            <div class="post-item format-standard">
                                <div class="post_thumb_image post-thumb <?php if( !$thumbnail_url ) echo esc_attr('no-feat-img'); ?>">
                                    <figure class="post-thumb">
                                        <?php if( $thumbnail_url ) : ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php echo esc_url( $thumbnail_url ); ?>" loading="<?php newsmatic_lazy_load_value(); ?>">
                                            </a>
                                        <?php endif; ?>
                                    </figure>
                                    <?php
                                        echo '<div class="bmm-post-cats-wrap bmm-post-meta-item post-categories">';
                                            $count = 0;
                                            foreach( $categories as $cat ) {
                                                echo '<h5 class="card__content-category cat-item cat-' .esc_attr( $cat->cat_ID ). '"><a href="' .esc_url( get_term_link( $cat->cat_ID ) ). '">' .esc_html( $cat->name ). '</a></h5>';
                                                if( $count > 0 ) break;
                                                $count++;
                                            }
                                        echo '</div>';
                                    ?>
                                </div>
                                <div class="post-content-wrap card__content">
                                    <div class="newsmatic-post-title card__content-title post-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                ?>
            </div>
    <?php
        echo wp_kses_post($after_widget);
    }

    /**
     * Widgets fields
     * 
     */
    function widget_fields() {
        $categories = get_categories();
        $categories_options[''] = esc_html__( 'Select category', 'newsmatic' );
        foreach( $categories as $category ) :
            $categories_options[$category->slug] = $category->name. ' (' .$category->count. ') ';
        endforeach;
        return array(
                array(
                    'name'      => 'widget_title',
                    'type'      => 'text',
                    'title'     => esc_html__( 'Widget Title', 'newsmatic' ),
                    'description'=> esc_html__( 'Add the widget title here', 'newsmatic' ),
                    'default'   => esc_html__( 'Trending News', 'newsmatic' )
                ),
                array(
                    'name'      => 'posts_category',
                    'type'      => 'select',
                    'title'     => esc_html__( 'Categories', 'newsmatic' ),
                    'description'=> esc_html__( 'Choose the category to display list of posts', 'newsmatic' ),
                    'options'   => $categories_options
                ),
                array(
                    'name'      => 'posts_count',
                    'type'      => 'number',
                    'title'     => esc_html__( 'Number of posts to show', 'newsmatic' ),
                    'default'   => 4
                ),
                array(
                    'name'      => 'image_setting_heading',
                    'type'      => 'heading',
                    'label'     => esc_html__( 'Image Setting', 'newsmatic' )
                ),
                array(
                    'name'      => 'image_size',
                    'type'      => 'select',
                    'title'     => esc_html__( 'Image Size', 'newsmatic' ),
                    'default'   => 'newsmatic-grid',
                    'options'   => newsmatic_get_image_sizes_option_array()
                ),
                array(
                    'name'  => 'image_ratio',
                    'type'  => 'responsive-number',
                    'title' => esc_html__( 'Image Ratio', 'newsmatic' ),
                    'min'   => 0,
                    'max'   => 2,
                    'step'  => 0.1,
                    'default'   => json_encode(array(
                        'desktop'   => 0.6,
                        'tablet'    => 0.6,
                        'smartphone'=> 0.6
                    ))
                ),
                array(
                    'name'  => 'image_border_radius',
                    'type'  => 'responsive-number',
                    'title' => esc_html__( 'Image Border Radius', 'newsmatic' ),
                    'min'   => 0,
                    'max'   => 200,
                    'step'  => 1,
                    'default'   => json_encode(array(
                        'desktop'   => 0,
                        'tablet'    => 0,
                        'smartphone'=> 0
                    ))
                )
            );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();
        foreach( $widget_fields as $widget_field ) :
            if ( isset( $instance[ $widget_field['name'] ] ) ) {
                $field_value = $instance[ $widget_field['name'] ];
            } else if( isset( $widget_field['default'] ) ) {
                $field_value = $widget_field['default'];
            } else {
                $field_value = '';
            }
            newsmatic_widget_fields( $this, $widget_field, $field_value );
        endforeach;
    }
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $widget_fields = $this->widget_fields();
        if( ! is_array( $widget_fields ) ) {
            return $instance;
        }
        foreach( $widget_fields as $widget_field ) :
            $instance[$widget_field['name']] = newsmatic_sanitize_widget_fields( $widget_field, $new_instance );
        endforeach;

        return $instance;
    }
 
} // class Newsmatic_Posts_Grid_Widget