<?php
/**
 * Template name: Gói Về Page
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

        <div class="sec-wrap callvn">
            <div class="all">


                <?php
                $blocks = get_field('mona_goive_top_block');
                if (is_array($blocks)) {
                    $f = true;
                    foreach ($blocks as $item) {
                        if ($f != true) {
                            ?>
                            <div class="sec-break">
                                <span class="shape-left"></span>
                                <span class="line"></span>
                                <span class="shape-right"></span>
                            </div>    
                            <?php
                        }
                        if ($item['style'] != 2) {
                            ?>
                            <div class="sec-pad clear">
                                <div class="row100">
                                    <div class="col-left50 no-padbot">
                                        <div class="callvn-title">
                                            <div class="title-ct">
                                                <h2 class="hd"><?php echo $item['toptitle']; ?></h2>
                                                <?php echo $item['description']; ?>
                                            </div>
                                            <div class="title-fee-block">
                                                <p><?php echo $item['title_feed']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row100">
                                    <div class="col-left50">
                                        <div class="mona-content content-table"><?php echo $item['left_content']; ?></div>
                                   <?php
                                        if($item['button_text'] !=''){
                                            ?>
                                            <div class="more-button">
                                                <a href="<?php echo esc_url($item['button_url']); ?>" class="btn btn-1"><?php echo $item['button_text']?></a>
                                        </div>    
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-right50">
                                        <div class="mona-content content-table"><?php echo $item['right_conten']; ?></div>
                                   
                                    </div>
                                </div>
                            </div>


                            <?php
                        } else {
                            ?>
                            <div class="sec-pad clear">
                                <div class="row100">
                                    <div class="col-left50">
                                        <div class="callvn-title">
                                            <div class="title-ct">
                                                <h2 class="hd"><?php echo $item['toptitle']; ?></h2>
                                                <?php echo $item['description']; ?>
                                            </div>
                                            <div class="title-fee-block">
                                                <p><?php echo $item['title_feed']; ?></p>
                                            </div>
                                        </div>
                                        <div class="callvn-table"><div class="mona-content content-table"><?php echo $item['left_content']; ?></div></div>
                                        <?php
                                        if ($item['button_text'] != '') {
                                            ?>
                                            <div class="more-button">
                                                <a href="<?php echo esc_url($item['button_url']); ?>" class="btn btn-1"><?php echo $item['button_text'] ?></a>
                                            </div>    
                                            <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="col-right50">
                                        <div class=" callvn-note-block mona-content content-table"><?php echo $item['right_conten']; ?></div>
                                    </div>
                                </div>
                            </div><?php
                        }
                        
                        $f = false;
                    }
                }
                ?>
            </div>
        </div>

    </main>
    <?php
endwhile;
get_footer();
?>
