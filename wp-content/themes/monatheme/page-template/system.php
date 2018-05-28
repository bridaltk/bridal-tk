<?php
/**
 * Template name: system Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    $systems = get_field('mona_system');
    ?>
    <main>
        <div class="flower-right bot">
            <img src="<?php echo get_site_url(); ?>/template/images/flower-right.png" alt="bg flower">
        </div>
        <div class="flower-fall-2">
            <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
        </div>

        <div class="hethong">
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
                            if (is_array($systems)) {
                                $active = "active";
                                foreach ($systems as $k => $item) {
                                    ?>
                                    <li class="item  <?php echo $active; ?>">
                                        <div class="icon"><i class="<?php echo $item['icon']; ?>"></i></div>
                                        <div class="info"><h1><a class="link" href="#<?php echo 'mona-active-item-' . $k; ?>"><?php echo ($item['title']); ?></a></h1></div>
                                    </li>   
                                    <?php
                                    $active = '';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="side-right">

                        <div class="system-tag-content">

                            <?php
                            if (is_array($systems)) {
                                $active = 'active';
                                foreach ($systems as $k => $item) {
                                    ?>
                                    <ul class="tag-list <?php echo $active; ?>" id="<?php echo 'mona-active-item-' . $k; ?>">
                                        <?php
                                        if (is_array($item['table_item'])) {
                                            $sub_active = 'active';
                                            $style = 'style="display: block;"';
                                            foreach ($item['table_item'] as $tab_item) {
                                                ?>
                                                <li class="mona-system-item <?php echo $sub_active; ?>">
                                                    <div class="nav-item">
                                                        <div class="icon"><i class="<?php echo $tab_item['icon']; ?>"></i></div>
                                                        <div class="detail">
                                                            <a href="javascript:;" class="item-action"><?php echo $tab_item['title']; ?></a>
                                                        </div>
                                                    </div>
                                                    <div class="system-content mona-content" <?php echo $style; ?> >
                                                        <?php echo $tab_item['content']; ?>
                                                    </div>
                                                </li>    
                                                <?php
                                                $style = 'style="display: none;"';
                                                $sub_active = '';
                                            }
                                        }
                                        ?>

                                    </ul>
                                    <?php
                                    $active = '';
                                }
                            }
                            ?>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>

    </main>
    <?php
endwhile;
get_footer();
?>
