<?php
/**
 * Template name: thủ tục Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    $sections = get_field('mona_thutuc_seasion');
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
        <?php
        if (is_array($sections)) {
            foreach ($sections as $sec) {
                ?>
                <div class="sec-wrap">
                    <div class="all">
                        <div class="sec-pad">

                            <div class="formal">
                                <div class="formal-title">
                                    <h2 class="hd"><?php echo $sec['title']; ?></h2>
                                </div>
                                <div class="formal-detail"><div class="mona-content content-table"><?php echo $sec['content']; ?></div></div>
                                <div class="row100">
                                    <?php
                                    $class='col-left50';
                                    if(is_array($sec['block'])){
                                        foreach ($sec['block'] as $block){
                                            ?>
                                            <div class="<?php echo $class; ?>">
                                        <div class="formal-table">
                                            <div class="t-head">
                                                <h4 class="hd"><?php echo $block['title']; ?></h4>
                                            </div>
                                            <div class="t-body">
                                                <div class="t-row"><?php echo $block['description']; ?></div>
                                                <div class="t-row">
                                                    <h4 class="hd"><?php echo $block['subtitle']; ?></h4>
                                                    <div class="mona-content mona-content-arrow-ul">
                                                        <?php echo $block['content']; ?>
                                                    </div>
                                                    <?php
                                                    if($block['button_text'] !=''){
                                                       ?>
                                                        <div class="button">
                                                        <a href="<?php echo $block['button_url']; ?>" class="btn btn-1"><?php echo $block['button_text']; ?></a>
                                                    </div>
                                                        <?php 
                                                    }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                            <?php
                                          if($class=='col-left50'){
                                             $class='col-right50';
                                        }else{
                                            $class='col-left50';
                                        }  
                                        }
                                        
                                       
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>         
                <?php
            }
        }
        ?>  
    </main>
    <?php
endwhile;
get_footer();
?>
