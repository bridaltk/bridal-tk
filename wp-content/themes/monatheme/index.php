<?php
get_header();
?>
<main class="clear">

    <div class="news section-wrap">
      <div class="all">

        <div class="section-title">
            <h1 class="fz-36 f-title"><?php _e('Tin tức','monamedia');?></h1>
          <div class="position">
              <a href="<?php echo get_home_url(); ?>"><?php _e('Trang chủ','monamedia');?></a>
            /
            <span class="color"><?php _e('Tin tức','monamedia');?></span>
          </div>
        </div>

        <div class="news__content">
            <?php
            while (have_posts()){
                the_post();
                ?>
                <div class="news__child">
                    <div class="img"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog_large');?></a></div>
            <div class="content">
                <h6 class="sub-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
                <p class="date"><?php _e('By','monamedia');?>: <span class="color"><?php the_author();?></span> - <?php echo get_the_date(); ?></p>
                <p><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>" class="btn btn-right"><?php _e('Xem thêm','monamedia');?></a>
            </div>
          </div>    
                <?php
            }
            mona_page_navi();
            ?>
          
        </div>

      </div>
    </div>
    
  </main>
<?php get_footer();
