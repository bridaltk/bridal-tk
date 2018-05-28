<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @author : monamedia
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
        <title><?php wp_title('|', true, 'right'); ?></title>
        <!-- Meta
                ================================================== -->
        <meta charset="<?php bloginfo('charset'); ?>">
            <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
                <?php wp_site_icon(); ?>
                <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
                <link rel="stylesheet" href="<?php echo get_site_url() ?>/template/js/bootstrap-datepicker/bootstrap-datepicker.standalone.css"/>
                  <link rel="stylesheet" href="<?php echo get_site_url() ?>/template/js/select2/select2.min.css"/>
                <link rel="stylesheet" href="<?php echo get_site_url() ?>/template/css/style.css"/>
                <link rel="stylesheet" href="<?php echo get_site_url() ?>/template/css/responsive.css" media="all"/>
                <?php wp_head(); ?>
                </head>
                <?php
                if (wp_is_mobile()) {
                    $body = 'mobile-detect';
                } else {
                    $body = 'desktop-detect';
                }
                ?>
                <body <?php body_class($body); ?>>
                    <header id="header">

                        <div class="all">

                            <div class="hd-wrap">
                                <div class="hd-left">
                                    <div class="logo">
                                        <div class="img">
                                            <?php 
                                            if(is_front_page()){
                                             echo get_custom_logo();   
                                            }else{
                                                $logo = mona_option('mona_header_custom_logo');
                                                if($logo !=''){
                                                    echo '<a href="'.  get_home_url().'" class="custom-logo-link" rel="home" itemprop="url"><img width="227" height="130" src="'.$logo.'" class="custom-logo" alt="タケシ結婚相談所" itemprop="logo"  sizes="(max-width: 227px) 100vw, 227px"></a>';
                                                }
                                            }
                                             ?></div>
                                    </div>
                                </div>

                                <div class="hd-main">
                                    <div class="main__top">
<!--                                        <div class="lang item">
                                            <span class="global"><i class="fas fa-globe"></i></span>
                                            <span class="down"><i class="fas fa-caret-down"></i></span>
                                            <select class="form-control">
                                                <option selected>Tiếng Việt</option>
                                                <option>Japanese</option>
                                            </select>
                                        </div>-->
                                        <?php get_template_part('patch/social','icon');?>
                                    </div>

                                    <div class="navbar-toggle">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </div>

                                    <div class="main__bot">

                                        <div class="nav-wrap" id="hd-nav">
                                            <div class="nav-overlay"></div>
                                            <?php
                                            wp_nav_menu(array(
                                                'container' => false,
                                                'container_class' => 'nav-ul',
                                                'menu_class' => 'mona-main-menu nav-ul clear',
                                                'theme_location' => 'primary-menu',
                                                'before' => '',
                                                'after' => '',
                                                'link_before' => '',
                                                'link_after' => '',
                                                'fallback_cb' => false,
                                                    //'walker' => new Mona_Custom_Walker_Nav_Menu,
                                            ));
                                            ?> 
                                        </div>

                                    </div>
                                </div>

                            </div>

                    </header>
