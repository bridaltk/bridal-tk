<?php
/**
 * Template name: About New Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    ?>
    <main>

        <div class="all">

            <div class="section-title">
                <p class="fz-36 f-title"><?php the_title(); ?></p>
                <div class="position">
                    <a href="<?php echo get_home_url(); ?>"><?php _e('Trang chủ', 'monamedia'); ?></a>
                    /
                    <span class="color"><?php the_title(); ?></span>
                </div>
            </div>

        </div>
        <div class="mona-about-item">
            <?php
            $secs = get_field('mona_about_n_item');
            if (is_array($secs)) {
                foreach ($secs as $item) {
                    ?>
                    <div class="sec-wrap mona-about-sec">
                        <div class="all">
                            <div class="sec-pad ">
                                <div class="block-2-col img-dt">
                                    <div class="img">
                                        <?php
                                        echo wp_get_attachment_image($item['image'], 'slider-full');
                                        ?>
                                    </div>
                                    <div class="detail mona-content">
                                        <h3 class="hd"><?php echo $item['title']; ?></h3>
                                        <div class="mona-content mona-about-content">
                                            <?php echo $item['description']; ?>
                                        </div>
                                        <?php
                                        if (is_array($item['button']) && count($item['button'])>0) {
                                            echo '<div class="button">';
                                            foreach ($item['button'] as $btns){
                                                  echo ' <a href="' . esc_url($btns['url']) . '" class="btn btn-1">' . $btns['text'] . '</a>';
                                            }
                                          
                                       echo '</div>';
                                            }
                                        ?>

                                    </div>
                                </div>
                                <div class="sec-break abso-break">
                                    <span class="shape-left"></span>
                                    <span class="line"></span>
                                    <span class="shape-right"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            $title = get_field('mona_about_n_mem_title');
            $des = get_field('mona_about_n_mem_description');
            if ($title != '' || $des != '') {
                ?>
                <div class="sec-wrap mona-about-sec">
                    <div class="all">
                        <div class="sec-pad">
                            <div class="members-section">
                                <div class="title"><h3><?php echo $title; ?></h3></div>
                                <ul class="list-img-member">
                                    <?php
                                    $args = array(
                                        'post_type' => 'mona_gai',
                                        'posts_per_page' => 5,
                                        'order' => 'DESC',
                                        'orderby' => 'date',
                                    );
                                    $my_query = new wp_query($args);
                                    while ($my_query->have_posts()){
                                        $my_query->the_post();
                                        ?>
                                        <li class="member-img">
                                            <div class="img"><a target="_blank" href="<?php the_permalink(); ?>"><span class="mona-span-avt" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'thumbnail');?>);"></span></a></div>
                                    </li>    
                                        <?php
                                    }
                                    wp_reset_query();
                                    ?>
                                    
                                </ul>
                                <div class="content mona-content"><?php echo $des; ?> </div>
                                <div class="button">
                                    <a href="<?php echo get_the_permalink(MONA_MEMBER); ?>" class="btn btn-1"><?php echo get_the_title(MONA_MEMBER); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    <?php
endwhile;
get_footer();
?>
