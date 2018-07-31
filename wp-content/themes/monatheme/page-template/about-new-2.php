<?php
/**
 * Template name: About New 2 Page
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
                                        <div class="mona-content ">
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
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </main>
    <?php
endwhile;
get_footer();
?>
