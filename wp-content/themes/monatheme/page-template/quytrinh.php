<?php
/**
 * Template name: Quy trinh Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    ?>
    <main>
        <div class="pagebg-title" <?php echo (has_post_thumbnail()?'style="background-image: url('.  get_the_post_thumbnail_url(get_the_ID(),'full').');"':'');?> >
            <div class="p-title-wrap">
                <div class="all">
                    <div class="p-title-ct">
                        <h2 class="hd"><?php the_title(); ?></h2>
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="all">
            <?php
            $f = true;
            $steps = get_field('mona_qt_step');
            if (is_array($steps)) {
                foreach ($steps as $step) {
                    ?>
                    <div class="step-section">
                        <div class="step-wrap">
                            <div class="stepst-header">
                                <div class="step-hd__hl"><p><?php echo $step['step_title']; ?></p></div>
                                <div class="step-hd__ct"><h3 class="hd"><?php echo $step['title']; ?></h3></div>
                            </div>
                            <div class="stepst-body">
                                <?php
                                if (is_array($step['child_step'])) {
                                    foreach ($step['child_step'] as $child_step) {
                                        ?>
                                        <div class="stepst-block">
                                            <div class="has-circle">
                                                <div class="c-circle border"><?php echo $child_step['number']; ?></div>
                                                <div class="c-ct">
                                                    <h4 class="hd"><?php echo $child_step['title']; ?></h4>
                                                    <div class="mona-content mona-step-content content-table">
                                                        <?php echo $child_step['content']; ?>
                                                    </div>
                                                    <div class="button">
                                                        <?php
                                                        if (is_array($child_step['button'])) {
                                                            foreach ($child_step['button'] as $btn) {
                                                                if ($btn['text'] != '') {
                                                                    echo '<a href="' . esc_url($btn['url']) . '" class="btn btn-bd">' . $btn['text'] . '</a>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                    <?php
                    if ($f == false) {
                        ?>
                        <div class="sec-break">
                            <span class="shape-left"></span>
                            <span class="line"></span>
                            <span class="shape-right"></span>
                        </div>
                        <?php
                        $f = false;
                    }
                }
            }
            ?>

        </div>

    </main>
    <?php
endwhile;
get_footer();
?>
