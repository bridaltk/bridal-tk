<?php
/**
 * Template name: About Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    $about = get_field('mona_about');
    ?>
    <main>
        <div class="flower-right bot">
            <img src="<?php echo get_site_url(); ?>/template/images/flower-right.png" alt="bg flower">
        </div>
        <div class="flower-fall-2">
            <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
        </div>

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

                        <ul class="list mona-nav-item-action">
                            <?php
                            if (is_array($about)) {
                                $active = "active";
                                foreach ($about as $k=>$item) {
                                    ?>
                                    <li class="item  <?php echo $active; ?>">
                                        <div class="icon"><i class="<?php echo $item['icon']; ?>"></i></div>
                                        <div class="info"><a class="link" href="#<?php echo 'mona-active-menu-'.$k; ?>"><?php echo ($item['title']); ?></a></div>
                                    </li>   
                                    <?php
                                    $active = '';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="side-right ">
                        <ul class="list system-tag-content mona-about">
                            <?php
                            if (is_array($about)) {
                                $active = "active";
                                foreach ($about as $k=>$item) {
                                    ?>
                                    <li class="mona-item tag-list <?php echo $active; ?>" id="<?php echo 'mona-active-menu-'.$k; ?>">
                                        <?php
                                        if (is_array($item['table_item'])) {
                                            foreach ($item['table_item'] as $table) {
                                                ?>
                                                <div class="summary" style="background: white;">
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

                                    </li>    
                                    <?php
                                    $active='';
                                }
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
