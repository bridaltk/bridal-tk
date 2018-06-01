<div class="related-products">
                            <h3 class="lbl">Các sản phẩm khác</h3>
                            
                            <ul class="list clear">
                                <?php
                $tags = wp_get_post_tags(get_the_ID());

                if ($tags) {
                    $tag_ids = array();
                    foreach ($tags as $individual_tag)
                        $tag_ids[] = $individual_tag->term_id;
                    $args = array(
                        'tag__in' => $tag_ids,
                        'post__not_in' => array(get_the_ID()),
                        'posts_per_page' => 3, // Number of related posts to display.
                    );

                    $my_query = new wp_query($args);

                    while ($my_query->have_posts()) {
                        $my_query->the_post();
                        ?>
                        <li>
                                    <div class="box">
                                        <div class="tmb">
                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                                        </div>
                                        <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    </div>
                                </li>

                        <?php
                    }
                }
                wp_reset_query();
                ?>
