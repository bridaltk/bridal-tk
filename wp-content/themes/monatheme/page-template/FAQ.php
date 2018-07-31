<?php
/**
 * Template name: FAQ Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    ?>
    <main>

        <div class="pagebg-title" <?php echo (has_post_thumbnail() ? 'style="background-image: url(' . get_the_post_thumbnail_url(get_the_ID(), 'full') . ');"' : ''); ?> >
            <div class="p-title-wrap">
                <div class="all">
                    <div class="p-title-ct">
                        <h2 class="hd"><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec-wrap">
            <div class="all">

                <div class="faq-section clear sec-pad">
                    <div class="faq-col">
                        <ul class="list-faq">
                            <?php
                            $faqs = get_field('mona_faq');
                            if (is_array($faqs)) {
                                $col = round(count($faqs)/2,0,PHP_ROUND_HALF_DOWN);
                                foreach ($faqs as $k => $item) {
                                    ?>
                                    <li class="faq__item">
                                        <div class="title">
                                            <h4 class="hd"><?php echo $item['title'];?></h4>
                                        </div>
                                        <div class="content mona-content"><?php echo $item['content'];?> </div>
                                    </li>     
                                    <?php
                                    if($k==$col){
                                        echo '</ul> </div><div class="faq-col"><ul class="list-faq">';
                                    }
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
  <script>
    jQuery(document).ready(function ($) {
      $('.faq__item .title').on('click', function (e) {
       e.preventDefault();
        $(this).toggleClass('active');
        $(this).siblings('.content').stop().slideToggle();
      })
    })
  </script>