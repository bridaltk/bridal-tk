<?php

if (class_exists('Kirki')) {

    /**
     * Add sections
     */
    function kirki_demo_scripts() {
        wp_enqueue_style('kirki-demo', get_stylesheet_uri(), array(), time());
    }

    add_action('wp_enqueue_scripts', 'kirki_demo_scripts');
    $priority = 1;
    Kirki::add_section('general', array(
        'title' => esc_attr__('General Option', 'monamedia'),
        'priority' => $priority++,
        'capability' => 'edit_theme_options',
    ));
    Kirki::add_section('header', array(
        'title' => esc_attr__('Header Option', 'monamedia'),
        'priority' => $priority++,
        'capability' => 'edit_theme_options',
    ));
    Kirki::add_section('social', array(
        'title' => esc_attr__('Social Link', 'monamedia'),
        'priority' => $priority++,
        'capability' => 'edit_theme_options',
    ));
    Kirki::add_section('footer', array(
        'title' => esc_attr__('Footer Option', 'monamedia'),
        'priority' => $priority++,
        'capability' => 'edit_theme_options',
    ));
    /**
     * Add fields
     */
    // Header
   
// Footer Tab
        Kirki::add_field('mona_setting', array(
        'type' => 'image',
        'settings' => 'mona_header_custom_logo',
        'label' => esc_attr__('Header Logo', 'monamedia'),
        'description' => esc_attr__('', 'monamedia'),
        'help' => esc_attr__('Enter your Logo', 'monamedia'),
        'section' => 'header',
        'default' => '',
        'priority' => $priority++,
    ));
    Kirki::add_field('mona_setting', array(
        'type' => 'image',
        'settings' => 'mona_footer_logo',
        'label' => esc_attr__('Footer Logo', 'monamedia'),
        'description' => esc_attr__('', 'monamedia'),
        'help' => esc_attr__('Enter your Logo', 'monamedia'),
        'section' => 'footer',
        'default' => '',
        'priority' => $priority++,
    ));
    Kirki::add_field('mona_setting', array(
        'type' => 'textarea',
        'settings' => 'mona_coppyright',
        'label' => esc_attr__('Coppyright', 'monamedia'),
        'description' => esc_attr__('', 'monamedia'),
        'help' => esc_attr__('Enter your Coppyright', 'monamedia'),
        'section' => 'footer',
        'default' => '',
        'priority' => $priority++,
    ));
// Social Tab    
    Kirki::add_field('mona_setting', array(
        'type' => 'text',
        'settings' => 'mona_sticky_header_facebook',
        'label' => esc_attr__('Facebook', 'monamedia'),
        'description' => esc_attr__('', 'monamedia'),
        'help' => esc_attr__('Enter your Facebook Link', 'monamedia'),
        'section' => 'social',
        'default' => '',
        'priority' => $priority++,
    ));
    Kirki::add_field('mona_setting', array(
        'type' => 'text',
        'settings' => 'mona_sticky_header_goolgeplus',
        'label' => esc_attr__('Google +', 'monamedia'),
        'description' => esc_attr__('', 'monamedia'),
        'help' => esc_attr__('Enter your G+ Link', 'monamedia'),
        'section' => 'social',
        'default' => '',
        'priority' => $priority++,
    ));
    Kirki::add_field('mona_setting', array(
        'type' => 'text',
        'settings' => 'mona_sticky_header_instagram',
        'label' => esc_attr__('Instagram', 'monamedia'),
        'description' => esc_attr__('', 'monamedia'),
        'help' => esc_attr__('Enter your Instagram Link', 'monamedia'),
        'section' => 'social',
        'default' => '',
        'priority' => $priority++,
    ));
    Kirki::add_field('mona_setting', array(
        'type' => 'text',
        'settings' => 'mona_sticky_header_linkedin',
        'label' => esc_attr__('Linkedin', 'monamedia'),
        'description' => esc_attr__('', 'monamedia'),
        'help' => esc_attr__('Enter your Linkedin Link', 'monamedia'),
        'section' => 'social',
        'default' => '',
        'priority' => $priority++,
    ));
    Kirki::add_field('mona_setting', array(
        'type' => 'text',
        'settings' => 'mona_sticky_header_youtube',
        'label' => esc_attr__('Youtube', 'monamedia'),
        'description' => esc_attr__('', 'monamedia'),
        'help' => esc_attr__('Enter your Youtube Link', 'monamedia'),
        'section' => 'social',
        'default' => '',
        'priority' => $priority++,
    ));
    Kirki::add_field('mona_setting', array(
        'type' => 'text',
        'settings' => 'mona_sticky_header_twitter',
        'label' => esc_attr__('Twitter', 'monamedia'),
        'description' => esc_attr__('', 'monamedia'),
        'help' => esc_attr__('Enter your Twitter Link', 'monamedia'),
        'section' => 'social',
        'default' => '',
        'priority' => $priority++,
    ));
}
if (!function_exists('mona_option')) {

    function mona_option($setting, $default = '') {
        if (class_exists('Kirki')) {
            $value = $default;
            $options = get_option('option_name', array());
            $options = get_theme_mod($setting, $default);
            if (isset($options)) {
                $value = $options;
            }
            return $value;
        }
        return $default;
    }

}