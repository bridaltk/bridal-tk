<?php get_header(); ?>

<main id="main-wrap">
    <div class="news-cont">
        <div class="news-head">
            <div class="right">
                <div class="search-input">
                    <?php
                    echo get_template_part('searchform');
                    ?>
                </div>
            </div>
            <div class="clear"></div>
            <div class="page-title">
                <div class="center-txt"><h1 class="news-title">Tìm Kiếm :<?php
                        global $wp_query;
                        echo $wp_query->query['s'];
                        ?></h1></div>
            </div>
        </div>
        <div class="news-body">
            <ul class="news-list-ul">
                <?php
                while (have_posts()):
                    the_post();
                    ?>
                    <li class="post-<?php echo get_the_ID(); ?>">
                        <div class="news-item">
                            <?php
                            $thumb = get_the_post_thumbnail_url();
                            $image = '';
                            if ($thumb) {
                                $image = aq_resize($thumb, 260, 150, true);
                            }
                            ?>
                            <a href="<?php echo get_permalink(); ?>" class="img" style="background-image:url(<?php echo $image; ?>)">

                            </a>
                            <div class="info">
                                <p class="meta"><strong><?php echo date('d/m/Y'); ?></strong></p>
                                <h4 class="title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <div class="spec"><?php the_excerpt(); ?></div>
                                <p class="right-txt"><a href="<?php echo get_permalink(); ?>" class="link read-more-link"><?php _e('Xem thêm','monamedia');?></a></p>
                            </div>
                        </div>
                    </li>
                    <?php
                endwhile;
                ?>
                <?php mona_page_navi(); ?>
            </ul>
        </div>
    </div>
</main>


<?php get_footer(); ?>
