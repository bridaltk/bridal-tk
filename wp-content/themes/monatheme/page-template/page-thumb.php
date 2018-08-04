<?php
/**
 * Template name: Page thumb
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
            <?php the_field('mona_page_thumb_descripiton');  ?>
          </div>
        </div>
      </div>
    </div>

    <div class="sec-wrap policy">
      <div class="all">
      <div class="sec-pad">
          <div class="mona-content">
           <?php the_content(); ?>   
          </div>
              
      </div>
      </div>
    </div>

  </main>
<?php
endwhile;
get_footer();
?>
