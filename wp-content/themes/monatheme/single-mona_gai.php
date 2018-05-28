<?php
get_header();
while (have_posts()):
    the_post();
    $gais = new Mona_gai(get_the_ID());
    $ms = $gais->get_ms();
    $data = $gais->get_data();
    $family = $gais->get_family();
    ?>
    <main class="clear">

        <div class="flower-right bot">
            <img src="<?php echo get_site_url(); ?>/template/images/flower-right.png" alt="bg flower">
        </div>
        <div class="flower-fall-2">
            <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
        </div>

        <div class="information section-wrap">

            <div class="all">

                <div class="section-title">
                    <h1 class="fz-36 f-title"><?php _e('Thông tin hội viên', 'monamedia'); ?></h1>
                    <div class="position">
                        <a href="<?php echo get_home_url(); ?>"><?php _e('Trang chủ', 'monamedia'); ?></a>
                        /
                        <span class="color"><?php echo '#' . $ms; ?></span>
                    </div>
                </div>

                <div class="information-detail__content">

                    <div class="side-left">
                        <?php
                        $video = get_field('mona_gai_video_url');
                        if ($video != '') {
                            $embed = wp_oembed_get($video);
                            if ($embed) {
                                ?>
                                <div class="video">
                                    <div class="title">
                                        <h3 class="fz-24 sub-title2"><?php _e('Video', 'monamedia'); ?></h3>
                                    </div>
                                    <div class="flex-video">
                                        <?php echo $embed; ?>
                                    </div>
                                </div>
                                <div class="br br-small">
                                    <i class="diamond"></i>
                                    <i class="diamond"></i>
                                </div>
                                <?php
                            }
                        }
                        ?>




                        <div class="images clear">
                            <div class="title">
                                <h3 class="fz-24 sub-title2"><?php _e('Gallery', 'monamedia'); ?></h3>
                            </div>
                            <div class="images-slide slide-mix">
                                <?php
                                $gallerys = get_field('mona_gai_gallery_image');
                                if (is_array($gallerys)) {
                                    foreach ($gallerys as $item) {
                                        ?>
                                        <div class="item">
                                            <div class="wrap">
                                                <div class="img"><a href="<?php echo wp_get_attachment_image_src($item['ID'], 'full')[0]; ?>"><?php echo wp_get_attachment_image($item['ID'], 'mona_thumb'); ?></a></div>
                                            </div>
                                        </div>   
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="br br-small">
                                    <i class="diamond"></i>
                                    <i class="diamond"></i>
                                </div>
                         <?php
                         if(!wp_is_mobile()){
                             comments_template(); 
                         }
                       
                        ?>
                    </div>

                    <div class="side-right">

                        <div class="title">
                            <h3 class="fz-24 sub-title2"><?php _e('Thông tin chung', 'monamedia'); ?></h3>
                        </div>

                        <ul class="list clear">
                            <?php
                            if (is_array($data)) {
                                foreach ($data as $item) {
                                    if (trim($item['value']) != '') {
                                        ?>
                                        <li class="item">
                                            <div class="subject"><h6><?php echo $item['label']; ?></h6></div>
                                            <div class="info"><p><?php echo $item['value']; ?></p></div>
                                        </li>  
                                        <?php
                                    }
                                }
                            }
                            ?>

                        </ul>

                        <div class="br br-small">
                            <i class="diamond"></i>
                            <i class="diamond"></i>
                        </div>
                        <div class="title">
                            <h3 class="fz-24 sub-title2"><?php _e('Thông tin Gia cảnh', 'monamedia'); ?></h3>
                        </div>

                        <ul class="list clear">
                            <?php
                            if (is_array($family)) {
                                foreach ($family as $item) {
                                    if (trim($item['value']) != '') {
                                        ?>
                                        <li class="item">
                                            <div class="subject"><h6><?php echo $item['label']; ?></h6></div>
                                            <div class="info"><p><?php echo $item['value']; ?></p></div>
                                        </li>  
                                        <?php
                                    }
                                }
                            }
                            ?>

                        </ul>

                        <div class="br br-small">
                            <i class="diamond"></i>
                            <i class="diamond"></i>
                        </div>
                        <div class="button">
                            <a href="<?php echo get_the_permalink(MONA_BOOKING); ?>?choice=<?php the_permalink(); ?>" class="btn btn-1"><i class="far fa-heart"></i><?php _e('Chọn cô gái này', 'monamedia'); ?></a>
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
<script>
    jQuery(document).ready(function ($) {
        $('.images-slide').magnificPopup({
            delegate: 'a',
            type: 'image',
            tLoading: 'Loading image #%curr%...',
            mainClass: 'mfp-img-mobile mfp-no-margins mfp-with-zoom',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            },
            image: {
                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                titleSrc: function (item) {
                    return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
                }
            }
        });
        if ($('.information .images-slide .item').length > 6) {
            $('.information .images-slide').slick({
                rows: 2,
                infinite: true,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
                dots: true,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 470,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    }
                ]
            });
        }

    })
</script>
