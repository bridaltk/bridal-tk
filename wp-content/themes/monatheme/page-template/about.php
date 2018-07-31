<?php
/**
 * Template name: About Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    $about = get_field('mona_about_table_item');
    ?>
    <main>


        <div class="thongtincongty">
            <div class="all">

                <div class="section-title">
                    <p class="fz-36 f-title"><?php the_title(); ?></p>
                    <div class="position">
                        <a href="<?php echo get_home_url(); ?>"><?php _e('Trang chủ', 'monamedia'); ?></a>
                        /
                        <span class="color"><?php the_title(); ?></span>
                    </div>
                </div>

                <div class="sv__entry clear">

                    <div class="side-left">

                        <?php
        get_sidebar();
                        ?>
                    </div>

                    <div class="side-right ">
                        <ul class="list system-tag-content mona-about">
                            <?php
                            if (is_array($about)) {
                                $item = $about;
                                ?><li class="mona-item tag-list active">
                                        <?php
                                        if (is_array($item)) {
                                            foreach ($item as $table) {
                                                ?>
                                                <div class="summary">
                                                    <?php
                                                    if ($table['title'] != '') {
                                                        echo '<div class="title"><h3>' . $table['title'] . '</h3></div>';
                                                    }
                                                    ?>

                                                    <ul class="sum-list">
                                                        <?php
                                                        if (is_array($table['content'])) {
                                                            foreach ($table['content'] as $content) {
                                                                ?>
                                                                <li>
                                                                    <?php
                                                                    if ($content['image'] != '' || $content['name'] != '') {
                                                                        ?>
                                                                        <div class="subject">
                                                                            <?php
                                                                            if ($content['image'] != '') {
                                                                                echo '<div class="img">' . wp_get_attachment_image($content['image'], 'thumbnail') . '</div>';
                                                                            }
                                                                            if ($content['name'] != '') {
                                                                                echo '<p>' . $content['name'] . '</p>';
                                                                            }
                                                                            ?>


                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    if ($content['content'] != '') {
                                                                        echo '<div class="content mona-content">' . $content['content'] . '</div>';
                                                                    }
                                                                    ?>


                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </ul>
                                                </div>

                                                <div class="br br-small">
                                                    <i class="diamond"></i>
                                                    <i class="diamond"></i>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </li><?php
                            }
                            ?>
                        </ul>

                    </div>

                </div>

            </div>


        </div>

    </main>
<?php
endwhile;
get_footer();
?>
