<?php
get_header();
while (have_posts()):
    the_post();
    ?>
 <main class="clear">

        <div class="news-detail section-wrap">
            <div class="all">

                <div class="section-title">
                    <h1 class="fz-36 f-title"><?php _e('Tin tức', 'monamedia'); ?></h1>
                    <div class="position">
                        <a href="<?php echo get_home_url(); ?>"><?php _e('Trang chủ', 'monamedia'); ?></a>
                        /
                        <span class="color"><?php the_title(); ?></span>
                    </div>
                </div>

                <div class="news-detail__content">

                    <div class="side-left">
                        <div class="title">
                            <div class="date">
                                <p class="fz-14"><?php _e('By','monamedia');?> <a href="" class="color"><?php the_author(); ?></a> - <?php echo get_the_date(); ?></p>
                            </div>
                            <h3 class="fz-24"><?php the_title(); ?></h3>
                        </div>

                        <div class="content">
                            <div class="ct__text">
                                <div class="img"><?php the_post_thumbnail('full'); ?></div>
                                <div class="mona-content"><?php the_content(); ?></div>
                            </div>
                        </div>

                        <div class="br br-small">
                            <i class="diamond"></i>
                            <i class="diamond"></i>
                        </div>

                        <?php comments_template(); ?>
                    </div>

                    <aside class="side-right">

                        <div class="title">
                            <h3 class="fz-24"><?php _e('Tin liên quan'); ?></h3>
                        </div>

                        <ul class="list">
                            <?php
                            $args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 10,
                                'order' => 'DESC',
                                'orderby' => 'date',
                                'post__not_in' => array(get_the_ID()),
                            );
                            $tags = get_the_tags();
                            if(is_array($tags)){
                                $in =array();
                                foreach ($tags as $tag){
                                    $in[]=$tag->term_id;
                                }
                                $args['tag__in']=$in;
                            }
                            $my_query = new WP_Query($args);
                            while ($my_query->have_posts()){
                                $my_query->the_post();
                                ?>
                                 <li class="item">
                                     <div class="img"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail');?></a></div>
                                <div class="content">
                                    <h6 class="sub-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                                    <p class="date"><?php _e('By','monamedia');?>: <span class="color"><?php the_author(); ?></span> - <?php echo get_the_date();?></p>
                                </div>
                            </li>   
                                <?php
                            }
                            wp_reset_query();
                            ?>
                            
                        </ul>

                    </aside>

                </div>

            </div>


        </div>
    </div>

    </main>
    <?php
endwhile;
get_footer();
?>