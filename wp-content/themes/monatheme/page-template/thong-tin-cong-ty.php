<?php
/**
 * Template name: Thông tin công ty Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
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
                    <div class="row100">
                        <div class="col-left50">
                            <div class="title"><h3><?php the_field('mona_cty_ss1_title'); ?></h3></div>
                            <ul class="sum-list">
                                <?php
                                $infos = get_field('mona_cty_ss1_content');
                                if (is_array($infos)) {
                                    foreach ($infos as $item) {
                                        ?>
                                        <li>
                                            <div class="subject">
                                                <p><?php echo $item['title']; ?></p>
                                            </div>
                                            <div class="content mona-content">
                                                <?php echo $item['description']; ?>
                                            </div>
                                        </li>    
                                        <?php
                                    }
                                }
                                ?>

                            </ul>
                        </div>
                        <div class="col-right50">
                            <script>
                                var $lat = "<?php the_field('mona_cty_ss2_map_latitude'); ?>";
                                        var $long = "<?php the_field('mona_cty_ss2_map_longtitude'); ?>";
                                        var $content = "<?php the_field('mona_cty_ss2_map_content'); ?>";
                                
                            </script>
                            <div class="map" id="map_canvas"></div>
                        </div>
                    </div>
                    <div class="row100 mona-term">
                        <div class="title"><h3><?php the_field('mona_cty_ss3_title'); ?></h3></div>
                        <ul class="list-term mona-term">
                            <?php
                            $terms = get_field('mona_cty_ss3_team');
                            if (is_array($terms)) {
                                foreach ($terms as $item) {
                                    ?>
                                    <li class="item">
                                        <div class="term-wrap">
                                            <?php
                                            if($item['avatar'] !=''){
                                                ?>
                                                <div class="avt">
                                               <?php echo wp_get_attachment_image($item['avatar'],'large'); ?>
                                                </div>    
                                                <?php
                                            }
                                            ?>
                                            
                                            <h4 class="name"><?php echo $item['name'];?></h4>
                                            <div class="position"><?php echo $item['position'];?></div>
                                            <div class="mona-content">
                                               <?php echo $item['description'];?>
                                            </div>
                                        </div>
                                    </li>    
                                    <?php
                                }
                            }
                            ?>

                        </ul>
                    </div>
                    <div class="rơw100">
                        <div class="mona-content">
                            <?php the_content(); ?>
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
