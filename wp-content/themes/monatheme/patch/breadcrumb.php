
<?php 
 $body_class = get_body_class();
 if( !(in_array('home', $body_class))):?>
    <div class="breadcrumbs container">
                <?php
                //BREADCRUM TITLE
                $is_archive_class = true;
                $breadcrumb_title = "";
                if (is_tax('product_cat')) {
                    global $wp_query;
                    $current_term = $wp_query->get_queried_object();
                    $breadcrumb_title = esc_html($current_term->name);
                } elseif (is_search()) {
                    $breadcrumb_title = translate('Search Results For: ', 'mona_media') . " " . esc_attr(apply_filters('the_search_query', get_search_query(false)));
                } elseif (is_archive()) {
                    if (is_category()) {
                        $breadcrumb_title = translate('Category: ', 'mona_media') . ' "' . single_cat_title('', false) . '"';
                    } elseif (is_tag()) {
                        $breadcrumb_title = translate('Posts Tagged: ', 'mona_media') . ' "' . single_tag_title('', false) . '"';
                    } elseif (is_day()) {
                        $breadcrumb_title = translate('Archive For: ', 'mona_media') . ' "' . apply_filters('the_time', get_the_time('F jS, Y'), 'F jS, Y') . '"';
                    } elseif (is_month()) {
                        $breadcrumb_title = translate('Archive For: ', 'mona_media') . ' "' . apply_filters('the_time', get_the_time('F, Y'), 'F, Y') . '"';
                    } elseif (is_year()) {
                        $breadcrumb_title = translate('Archive For: ', 'mona_media') . ' "' . apply_filters('the_time', get_the_time('Y'), 'Y') . '"';
                    } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
                        $breadcrumb_title = translate('Blog Archives', 'mona_media');
                    } else if (is_shop()) {
                        $breadcrumb_title = translate('Shop', 'mona_media');
                    }
                } elseif (is_404()) {
                    $breadcrumb_title = translate('"404 ! Page not found !"', 'mona_media');
                } else {
                    $is_archive_class = false;
                    if (!is_singular('post') && !is_singular('portfolio')) {
                        if (!is_home()) {
                            $breadcrumb_title = empty($post->post_parent) ? get_the_title($post->ID) : get_the_title($post->post_parent);
                        } else {
                            $breadcrumb_title = translate('Blog', 'mona_media');
                        }
                    } else {
                        if (is_singular('post')) {
                            $breadcrumb_title = translate('Blog', 'mona_media');
                        } elseif (is_singular('portfolio')) {
                            $breadcrumb_title = '' . get_the_title();
                        }
                    }
                }
                //BREADCRUM CONTENT
                $breadcrum_content = array();
                $breadcrum_divider = "";
                $breadcrum_divider_html = $breadcrum_divider_html = '</li> <li><span class="as-breadcrumb-divider">' . $breadcrum_divider . '</span></li><li>';
                if (!is_home() || !is_front_page()) {
                    $breadcrum_content[] = array(
                        "title" => __("Trang chủ", 'mona_media'),
                        "url" => esc_url(home_url('/'))
                    );

                    if (is_category() || is_singular('post')) {
                        $breadcrum_content[] = get_the_category_list($breadcrum_divider_html);

                        if (is_single()) {
                            $breadcrum_content[] = the_title("", "", false);
                        }
                    } elseif (is_tax('product_cat')) {
                        global $wp_query;
                        $current_term = $wp_query->get_queried_object();
                        $ancestors = array_reverse(get_ancestors($current_term->term_id, 'product_cat'));
                        foreach ($ancestors as $ancestor) {
                            $ancestor = get_term($ancestor, 'product_cat');
                            $breadcrum_content[] = array(
                                "title" => esc_html($ancestor->name),
                                "url" => get_term_link($ancestor)
                            );
                        }
                        $breadcrum_content[] = esc_html($current_term->name);
                    } elseif (is_singular('portfolio')) {
                        $breadcrum_content[] = get_the_term_list($post->ID, 'portfolio_cats', '', $breadcrum_divider_html);
                        $breadcrum_content[] = the_title("", "", false);
                    } elseif (is_singular('product')) {
                        $breadcrum_content[] = get_the_term_list($post->ID, 'product_cat', '', $breadcrum_divider_html);
                        $breadcrum_content[] = the_title("", "", false);
                    } elseif (is_page()) {
                        if (!empty($post->post_parent)) {
                            $breadcrum_content[] = array(
                                "title" => get_the_title($post->post_parent),
                                "url" => get_permalink($post->post_parent)
                            );
                        }
                        $breadcrum_content[] = the_title("", "", false);
                    } else if (is_page('Shop')) {
                        $breadcrum_content[] = "Shop";
                    } else if (in_array('blog', get_body_class())) {
                        $breadcrum_content[] = "Tin Tức";
                    }
                    
                } elseif (is_tag()) {
                    $breadcrum_content[] = single_tag_title();
                } elseif (is_day()) {
                    $breadcrum_content[] = translate('Archive for', 'mona_media') . apply_filters('the_time', get_the_time('F jS, Y'), 'F jS, Y');
                } elseif (is_month()) {
                    $breadcrum_content[] = translate('Archive for', 'mona_media') . apply_filters('the_time', get_the_time('F, Y'), 'F, Y');
                } elseif (is_year()) {
                    $breadcrum_content[] = translate('Archive for', 'mona_media') . apply_filters('the_time', get_the_time('Y'), 'Y');
                } elseif (is_author()) {
                    $breadcrum_content[] = translate('Author Archive', 'mona_media');
                } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
                    $breadcrum_content[] = translate('Blog Archives', 'mona_media');
                } elseif (is_search()) {
                    $breadcrum_content[] = translate('Search Results', 'mona_media');
                } elseif (is_404()) {
                    $breadcrum_content[] = translate('404 page not found', 'mona_media');
                }
                settype($as_header_check, 'array');
                ?>    
                <!-- Breadcrumb Content -->
                <ul class="as-breadcrumb-link">
                    <?php
                    if (!empty($breadcrum_content)) {
                        $count = 0;
                        foreach ($breadcrum_content as $link) {
                            $count++;
                            echo "<li>";
                            if (is_array($link)) {
                                ?>
                                <a href="<?php echo esc_url($link["url"]) ?>"><?php echo esc_html($link["title"]); ?><i class="arrow fa fa-angle-right"></i></a>
                                <?php
                            } else {
                                echo '<span>'.balanceTags($link, true).'</span>';
                            }
                            echo "</li>";
                        }
                    }
                    ?>
                </ul>
    </div>
<?php endif; ?>