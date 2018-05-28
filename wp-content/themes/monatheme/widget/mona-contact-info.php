<?php
/* ----------------------------------------------------------------------------------- */
/* Setting Contact Form */
/* ----------------------------------------------------------------------------------- */

class Mona_contact_info extends WP_Widget {

    function __construct() {
        $widget_ops = array(
            'classname' => 'mona_contact_info',
            'description' => esc_html__('Displaying your contact information', 'mono-theme'));
        $control_ops = array(
            'width' => 250,
            'height' => 100);
        parent::__construct('Mona_contact_info_widget', esc_html__('Mona Contact Info', 'mono-theme'), $widget_ops, $control_ops);
    }

    // display the widget in the theme
    function widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget_title', $instance['title']);
        $mail = strip_tags($instance['mail']);
        $phone = strip_tags($instance['phone']);
        $address = strip_tags($instance['address']);
        $social = isset($instance['social']) ? $instance['social'] : false;
        $xtra_info = strip_tags($instance['xtra_info']);

        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];
        ?>		
        <div class="contact-info-widget-wrapper">
            <ul class="contact-info-widget">
                <?php
                if ($address)
                    echo '<li><span class="as-icon-contact-wrapper"><span class="dslc-icon dslc-icon-map-marker"></span></span>Address:<p>' . esc_html($address) . '</p><div class="clearfix"></div></li>';
                if ($phone)
                    echo '<li><span class="as-icon-contact-wrapper"><span class="dslc-icon dslc-icon-phone"></span></span>Phone number<p>' . esc_html($phone) . '</p><div class="clearfix"></div></li>';
                if ($mail)
                    echo '<li><span class="as-icon-contact-wrapper"><span class="dslc-icon dslc-icon-envelope"></span></span>Email<p>' . is_email($mail) . '</p><div class="clearfix"></div></li>';
                if ($xtra_info)
                    echo '<li><span class="as-icon-contact-wrapper"><span class="dslc-icon dslc-icon-info-sign"></span></span>Info<p>' . esc_textarea($xtra_info) . '</p><div class="clearfix"></div></li>';
                if ($social != false){
                    echo '<li class="mona-widget-social">'.get_template_part('patch/social-icon').'</li>';
                }
                    
                    
                ?>

            </ul>
        </div>
        <?php
        echo $args['after_widget'];

        //end
    }

    // update the widget when new options have been entered
    function update($new_instance, $old_instance) {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['mail'] = strip_tags($new_instance['mail']);
        $instance['phone'] = strip_tags($new_instance['phone']);
        $instance['address'] = strip_tags($new_instance['address']);
        $instance['social'] = isset($new_instance['social']) ? (bool) $new_instance['social'] : false;
        $instance['xtra_info'] = strip_tags($new_instance['xtra_info']);
        return $instance;
    }

    // print the widget option form on the widget management screen
    function form($instance) {
        // combine provided fields with defaults
        $instance = wp_parse_args((array) $instance, array(
            'title' => 'Contact Info',
            'name' => '',
            'mail' => '',
            'phone' => '',
            'address' => '',
            'xtra_info' => ''));
        $mail = strip_tags($instance['mail']);
        $phone = strip_tags($instance['phone']);
        $address = strip_tags($instance['address']);
        $xtra_info = strip_tags($instance['xtra_info']);
        $title = strip_tags($instance['title']);
        $social = isset($instance['social']) ? (bool) $instance['social'] : false;
        // print the form fields
        ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php
            echo
            esc_attr($title);
            ?>" /></p>



        <p><label for="<?php echo esc_attr($this->get_field_id('address')); ?>">
                <?php esc_html_e('Address:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text" value="<?php
            echo
            esc_attr($address);
            ?>" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id('phone')); ?>">
                <?php esc_html_e('Phone:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php
            echo
            esc_attr($phone);
            ?>" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id('mail')); ?>">
                <?php esc_html_e('Mail:', 'mono-theme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('mail')); ?>" name="<?php echo esc_attr($this->get_field_name('mail')); ?>" type="text" value="<?php
            echo
            esc_attr($mail);
            ?>" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id('xtra_info')); ?>">
                <?php esc_html_e('Extra Info:', 'mono-theme'); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('xtra_info')); ?>" name="<?php echo esc_attr($this->get_field_name('xtra_info')); ?>"><?php
                echo
                esc_attr($xtra_info);
                ?></textarea></p>


        <p>
            <input class="checkbox" type="checkbox" <?php checked($social); ?> id="<?php echo esc_attr($this->get_field_id('social')); ?>" name="<?php echo esc_attr($this->get_field_name('social')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('social')); ?>"><?php esc_html_e('Display Social Icon?', 'monamedia'); ?></label>
        </p>
        <?php
    }

}
