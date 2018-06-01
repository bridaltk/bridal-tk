<?php get_header(); ?>

<main id="main-wrap">
    <div class="news-cont">
        <div class="news-head">
            <div class="right">
                <ul class="filter-news-ul">
                    <li class="" data-id="-1"><a href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>">Mới</a></li>
                    <?php
                    global $wp_query;
                    $cats = get_categories();
                    $current_term = $wp_query->get_queried_object();
                    $current_slug = esc_html($current_term->slug);
                    foreach ($cats as $cat) {
                        if ($cat->term_id != '1') {
                            echo '<li class="' . ($cat->slug == $current_slug ? 'active' : '') . '" data-id="' . $cat->term_id . '"><a href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a></li>';
                        }
                    }
                    ?>
                </ul>
                <div class="search-input">
                    <?php
                    echo get_template_part('searchform');
                    ?>
                </div>
            </div>
            <div class="clear"></div>
            <div class="page-title">
                <div class="center-txt"><h1 class="news-title"><?php echo $current_term->name; ?></h1></div>
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
                            $image ='';
                            if($thumb){
                                $image = aq_resize($thumb,260,150,true);
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
