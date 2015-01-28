<?php
/**
 * Creates widget for Blog
 */
class UOU_CountCompany_Widget extends WP_Widget {
    /**
     * Widget init
     */
    function UOU_CountCompany_Widget () {

            $widget_opts = array (
                'classname' => 'UOU_CountCompany_Widget',
                'description' => __( 'Count Companies', 'metrodir')
            );

            /* Create the widget */
            $this->WP_Widget( 'uou-countcompany-widget', __( '&rarr; UOUapps &rarr; Count Companies', 'metrodir'), $widget_opts );
    }

    /**
     * Start the widget
     */
    function widget( $args, $instance ) {



        extract( $args );
        $title = (!empty($instance['title'])) ? do_shortcode($instance['title']) : '';
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        echo $before_widget;
        if ( $title) {
            echo $before_title . $title . $after_title;
        }
            ?>

        <ul class="entries-list">

            <div class="description-text">
             <?php
             $count_company = wp_count_posts('company');
             $total_company = $count_company->publish;
             echo 'There are currently '.$total_company. ' companies inside the directory';
             ?>
            </div>
        </ul>

        <?php
        wp_reset_query();
        wp_reset_postdata();


        echo $after_widget.'</div>';

    }

    /**
     * Widget Update or Save Settings
     */
    function update ( $new_instance, $old_instance ) {
        $old_instance['title'] = strip_tags( $new_instance['title'] );
        return $old_instance;
    }

    /**
     * Widget settings
     */
    function form ( $instance ) {
        $instance = wp_parse_args( (array) $instance, array(
            'title' => ''
        ) );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title', 'metrodir' ); ?>:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" style="width:100%;" />
        </p>
    <?php
    }
}
register_widget( 'UOU_CountCompany_Widget' );
