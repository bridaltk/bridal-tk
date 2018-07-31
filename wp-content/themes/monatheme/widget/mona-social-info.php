<?php

/**
 * Mona_Social_Info_Widget
 * create social info widget
 *
 * @package 	Anna
 * @author   	alenastudio
 */
class Mona_Social_Info_Widget extends WP_Widget {

    function __construct() {
        $widget_ops  = array(
            'classname'   => 'social_info',
            'description' => esc_html__('Displaying your contact information', 'mono-theme'));
        $control_ops = array(
            'width'  => 250,
            'height' => 100);
        parent::__construct('mona_social_info_widget', esc_html__('Mona Social Network', 'mono-theme'), $widget_ops, $control_ops);
    }

    // display the widget in the theme
    function widget($args, $instance) {
        extract($args);

        $title       = apply_filters('widget_title', $instance['title']);
        $twitter     = strip_tags($instance['twitter']);
        $facebook    = strip_tags($instance['facebook']);
        $google_plus = strip_tags($instance['google_plus']);
        $youtube     = strip_tags($instance['youtube']);
        $vimeo       = strip_tags($instance['vimeo']);
        $dribbble    = strip_tags($instance['dribbble']);
        $behance     = strip_tags($instance['behance']);
        $flickr      = strip_tags($instance['flickr']);
        $tumblr      = strip_tags($instance['tumblr']);
        $pinterest   = strip_tags($instance['pinterest']);
        $linkedin    = strip_tags($instance['linkedin']);
        $instagram   = strip_tags($instance['instagram']);
        $github      = strip_tags($instance['github']);
        $dropbox     = strip_tags($instance['dropbox']);
        $foursquare  = strip_tags($instance['foursquare']);

        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
        ?>		
        <div class="mona-social-icon">
            
                <?php
                if ($twitter)
                    echo '<a class="btn" href="' . esc_url($twitter) . '" title="Twitter"><span class="fab fa-twitter"></span></a>';
                if ($facebook)
                    echo '<a class="btn" href="' . esc_url($facebook) . '" title="Facebook"><span class="fab fa-facebook"></span></a>';
                if ($google_plus)
                    echo '<a class="btn" href="' . esc_url($google_plus) . '" title="Google Plus"><span class="fab fa-google-plus"></span></a>';
                if ($youtube)
                    echo '<a class="btn" href="' . esc_url($youtube) . '" title="Youtube"><span class="fab fa-youtube"></span></a>';
                if ($vimeo)
                    echo '<a class="btn" href="' . esc_url($vimeo) . '" title="Vimeo"><span class="fab fa-vimeo-square"></span></a>';
                if ($dribbble)
                    echo '<a class="btn" href="' . esc_url($dribbble) . '" title="Dribbble"><span class="fab fa-dribbble"></span></a>';
                if ($behance)
                    echo '<a class="btn" href="' . esc_url($behance) . '" title="Behance"><span class="fab fa-behance"></span></a>';
                if ($flickr)
                    echo '<a class="btn" href="' . esc_url($flickr) . '" title="Flickr"><span class="fab fa-flickr"></span></a>';
                if ($tumblr)
                    echo '<a class="btn" href="' . esc_url($tumblr) . '" title="Tumblr"><span class="fab fa-tumblr"></span></a>';
                if ($pinterest)
                    echo '<a class="btn" href="' . esc_url($pinterest) . '" title="Pinterest"><span class="fab fa-pinterest"></span></a>';
                if ($linkedin)
                    echo '<a class="btn" href="' . esc_url($linkedin) . '" title="Linkedin"><span class="fab fa-linkedin"></span></a>';
                if ($instagram)
                    echo '<a class="btn" href="' . esc_url($instagram) . '" title="Instagram"><span class="fab fa-instagram"></span></a>';
                if ($github)
                    echo '<a class="btn" href="' . esc_url($github) . '" title="Github"><span class="fab fa-github"></span></a>';
                if ($dropbox)
                    echo '<a class="btn" href="' . esc_url($dropbox) . '" title="Dropbox"><span class="fab fa-dropbox"></span></a>';
                if ($foursquare)
                    echo '<a class="btn" href="' . esc_url($foursquare) . '" title="Foursquare"><span class="fab fa-foursquare"></span></a>';
                ?>
        </div>
        <?php
        echo $args['after_widget'];

        //end
    }

    // update the widget when new options have been entered
    function update($new_instance, $old_instance) {

        $instance                = $old_instance;
        $instance['title']       = strip_tags($new_instance['title']);
        $instance['twitter']     = strip_tags($new_instance['twitter']);
        $instance['facebook']    = strip_tags($new_instance['facebook']);
        $instance['google_plus'] = strip_tags($new_instance['google_plus']);
        $instance['youtube']     = strip_tags($new_instance['youtube']);
        $instance['vimeo']       = strip_tags($new_instance['vimeo']);
        $instance['dribbble']    = strip_tags($new_instance['dribbble']);
        $instance['behance']     = strip_tags($new_instance['behance']);
        $instance['flickr']      = strip_tags($new_instance['flickr']);
        $instance['tumblr']      = strip_tags($new_instance['tumblr']);
        $instance['pinterest']   = strip_tags($new_instance['pinterest']);
        $instance['linkedin']    = strip_tags($new_instance['linkedin']);
        $instance['instagram']   = strip_tags($new_instance['instagram']);
        $instance['github']      = strip_tags($new_instance['github']);
        $instance['dropbox']     = strip_tags($new_instance['dropbox']);
        $instance['foursquare']  = strip_tags($new_instance['foursquare']);
        return $instance;
    }

    // print the widget option form on the widget management screen
    function form($instance) {
        // combine provided fields with defaults
        $instance    = wp_parse_args(
                (array) $instance, array(
            'title'       => 'Contact Info',
            'twitter'     => '',
            'facebook'    => '',
            'google_plus' => '',
            'youtube'     => '',
            'vimeo'       => '',
            'dribbble'    => '',
            'behance'     => '',
            'flickr'      => '',
            'tumblr'      => '',
            'pinterest'   => '',
            'linkedin'    => '',
            'instagram'   => '',
            'github'      => '',
            'dropbox'     => '',
            'foursquare'  => '',
                )
        );
        $title       = strip_tags($instance['title']);
        $twitter     = strip_tags($instance['twitter']);
        $facebook    = strip_tags($instance['facebook']);
        $google_plus = strip_tags($instance['google_plus']);
        $youtube     = strip_tags($instance['youtube']);
        $vimeo       = strip_tags($instance['vimeo']);
        $dribbble    = strip_tags($instance['dribbble']);
        $behance     = strip_tags($instance['behance']);
        $flickr      = strip_tags($instance['flickr']);
        $tumblr      = strip_tags($instance['tumblr']);
        $pinterest   = strip_tags($instance['pinterest']);
        $linkedin    = strip_tags($instance['linkedin']);
        $instagram   = strip_tags($instance['instagram']);
        $github      = strip_tags($instance['github']);
        $dropbox     = strip_tags($instance['dropbox']);
        $foursquare  = strip_tags($instance['foursquare']);

        // print the form fields
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php esc_html_e('Twitter URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php esc_html_e('Facebook URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('google_plus')); ?>"><?php esc_html_e('Google Plus URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('google_plus')); ?>" name="<?php echo esc_attr($this->get_field_name('google_plus')); ?>" type="text" value="<?php echo esc_attr($google_plus); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('youtube')); ?>"><?php esc_html_e('Youtube URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" type="text" value="<?php echo esc_attr($youtube); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('vimeo')); ?>"><?php esc_html_e('Vimeo URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('vimeo')); ?>" name="<?php echo esc_attr($this->get_field_name('vimeo')); ?>" type="text" value="<?php echo esc_attr($vimeo); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('dribbble')); ?>"><?php esc_html_e('Dribbble URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('dribbble')); ?>" name="<?php echo esc_attr($this->get_field_name('dribbble')); ?>" type="text" value="<?php echo esc_attr($dribbble); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('behance')); ?>"><?php esc_html_e('Behance URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('behance')); ?>" name="<?php echo esc_attr($this->get_field_name('behance')); ?>" type="text" value="<?php echo esc_attr($behance); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('flickr')); ?>"><?php esc_html_e('Flickr URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr')); ?>" type="text" value="<?php echo esc_attr($flickr); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('tumblr')); ?>"><?php esc_html_e('Tumblr URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('tumblr')); ?>" name="<?php echo esc_attr($this->get_field_name('tumblr')); ?>" type="text" value="<?php echo esc_attr($tumblr); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"><?php esc_html_e('Pinterest URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" type="text" value="<?php echo esc_attr($pinterest); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php esc_html_e('Linkedin URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>"><?php esc_html_e('Instagram URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" type="text" value="<?php echo esc_attr($instagram); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('github')); ?>"><?php esc_html_e('Github URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('github')); ?>" name="<?php echo esc_attr($this->get_field_name('github')); ?>" type="text" value="<?php echo esc_attr($github); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('dropbox')); ?>"><?php esc_html_e('Dropbox URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('dropbox')); ?>" name="<?php echo esc_attr($this->get_field_name('dropbox')); ?>" type="text" value="<?php echo esc_attr($dropbox); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('foursquare')); ?>"><?php esc_html_e('Foursquare URL:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('foursquare')); ?>" name="<?php echo esc_attr($this->get_field_name('foursquare')); ?>" type="text" value="<?php echo esc_attr($foursquare); ?>" />
        </p>    

        <?php
    }

}
