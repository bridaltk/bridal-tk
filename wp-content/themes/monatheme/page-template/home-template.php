<?php
/**
 * Template name: Home Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    ?>
    <main class="clear">

        <div class="flower-fall">
            <img src="<?php echo get_site_url(); ?>/template/images/flower-fall.png" alt="flower">
        </div>

        <div class="banner">

            <div class="banner-slide">
                <?php
                $slider = get_field('mona_home_banner');
                if (is_array($slider)) {
                    foreach ($slider as $item) {
                        ?>
                        <div class="item">
                            <div class="bg">
                                <div class="img"><?php
                                    if ($item['image'] != '') {
                                        echo wp_get_attachment_image($item['image'], 'slider-full');
                                    }
                                    ?></div>
                            </div>
                            <div class="info">
                                <div class="all">
                                    <div class="title">
                                        <p class="fz-30" <?php echo ($item['subtitle_color'] !=''?'style="color:'.$item['subtitle_color'].';"':'');?>><?php echo $item['subtitle']; ?></p>
                                        <h1 class="fz-72" <?php echo ($item['title_1_color'] !=''?'style="color:'.$item['title_1_color'].';"':'');?>><?php echo $item['title_1']; ?></h1>
                                        <h2 class="fz-72 blue" <?php echo ($item['title_2_color'] !=''?'style="color:'.$item['title_2_color'].';"':'');?>><?php echo $item['title_2']; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>   
                        <?php
                    }
                }
                ?>

            </div>
        </div>

        <div class="promotion">
            <div class="all">
                <div class="wrap">
                    <div class="promo__title">
                        <p class="fz-36 f-title" style="font-weight: bold;"><?php //_e('Promotion', 'monamedia');   ?></p>
                    </div>
                    <?php
                    $args = array(
                        'post_type' => 'mona_promotion',
                        'posts_per_page' => 1,
                        'order' => 'DESC',
                        'orderby' => 'date',
                    );
                    $my_query = new WP_Query($args);
                    while ($my_query->have_posts()) {
                        $my_query->the_post();
                        ?>
                        <div class="promo__main">

                            <div class="img">
                                <a href="<?php the_permalink(); ?>"><?php
                                    the_post_thumbnail('full');
                                    ?></a>
                            </div>
                            <div class="promo-wrapp-info">
                                <div class="info">
                                    <div class="content">
                                        <?php the_field('mona_tour_Summary'); ?>
                                    </div>
                                    <?php
                                    echo '<div class="button"> <a href="' . get_the_permalink() . '" class="btn btn-1">' . __('View Details', 'monamedia') . '</a> </div>';
                                    ?>

                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_query();
                    ?>

                    <div class="br">
                        <i class="diamond"></i>
                        <i class="diamond"></i>
                    </div>
                </div>

            </div>
        </div>

        <div class="recent">
            <div class="all">
                <div class="bg">
                    <div class="img"><img src="<?php echo get_site_url(); ?>/template/images/recent-img.png" alt="recent img"></div>
                </div>
                
                <div class="content">
                    <div class="wrap-recent">
                        <div class="title"><p class="fz-36 f-title" style="font-weight: bold;"><?php _e('Những hoạt động gần đây', 'monamedia'); ?></p></div>
                        <ul class="list">
                            <?php
                            $hds = get_field('mona_home_hoat_dong');
                            if (is_array($hds)) {
                                foreach ($hds as $item) {
                                    if ($item['mona_home_day'] != '' || $item['content'] != '') {
                                        ?>
                                        <li class="item">
                                            <span class="date"><?php echo $item['mona_home_day']; ?></span>
                                            <div class="detail" style=" display: inline-block; "><?php echo $item['content']; ?></div>
                                        </li>   
                                        <?php
                                    }
                                }
                            }
                            
                            ?>
                        </ul>
                    </div>

                </div>
                <div class="br">
                    <i class="diamond"></i>
                    <i class="diamond"></i>
                </div>
            </div>
        </div>

        <div class="newmem">
            <div class="all">

                <div class="title">
                    <p class="fz-36 f-title" style="font-weight: bold;"><?php _e('Hội viên mới gia nhập', 'monamedia'); ?></p>
                </div>

                <div class="newmem-slide">
                    <?php
                    $args = array(
                        'post_type' => 'mona_gai',
                        'posts_per_page' => 30,
                        'order' => 'DESC',
                        'orderby' => 'date',
                    );
                    $my_query = new WP_Query($args);
                    while ($my_query->have_posts()) {
                        $my_query->the_post();
                        mona_gai_loop(get_the_ID());
                    }
                    wp_reset_query();
                    ?>

                </div>

                <div class="br">
                    <i class="diamond"></i>
                    <i class="diamond"></i>
                </div>

            </div>
        </div>
        <div class="newmem">
            <div class="all">

                <div class="title">
                    <p class="fz-36 f-title" style="font-weight: bold;"><?php _e('Hội viên được chú ý', 'monamedia'); ?></p>
                </div>

                <div class="newmem-slide">
                    <?php
                    $args = array(
                        'post_type' => 'mona_gai',
                        'posts_per_page' => 30,
                        'order' => 'DESC',
                        'orderby' => 'date',
                        'meta_query' => array(
                            array(
                                'key' => 'mona_gai_sticky',
                                'value' => '1',
                                'compare' => '='
                            )
                        )
                    );
                    $my_query = new WP_Query($args);
                    while ($my_query->have_posts()) {
                        $my_query->the_post();

                        mona_gai_loop(get_the_ID());
                    }
                    wp_reset_query();
                    ?>

                </div>

                <div class="br">
                    <i class="diamond"></i>
                    <i class="diamond"></i>
                </div>

            </div>
        </div>
    </main>
    <?php
endwhile;
get_footer();
?>
