<?php
get_header();
while (have_posts()):
    the_post();
    ?>
    <main class="clear">
    <div class="pages section-wrap">
      <div class="all">

        <div class="section-title">
            <h1 class="fz-36 f-title"><?php the_title(); ?></h1>
          <div class="position">
              <a href="<?php echo get_home_url(); ?>"><?php _e('Trang chủ','monamedia');?></a>
            /
            <span class="color"><?php the_title(); ?></span>
          </div>
        </div>

        <div class="page__content mona-content">
        <?php the_content(); ?>
        </div>

      </div>
    </div>
    
  </main>
    <?php
endwhile;
get_footer();
?>