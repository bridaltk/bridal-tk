<?php get_header(); ?>

<div id="main-wrap">
    <div class="all">
        <div class="main">
            <div class="main-cont">
                <div class="mona-wrapper-number-404">
                    <h1 class="page-title">404</h1>
                    <h3 >Oops, the page you are<br> looking for does not exist.</h3>
                </div>
                <div class="mona-context-404">
                    <p>You may want to head back to the homepage.<br>If you think something is broken, report a problem.</p>
                </div>
                <div class="clear"></div>
                <div class="mona-context-404-button">
                    <a href="<?php echo home_url(); ?>" class="btn mona-button-style"><?php _e('Về Trang Chủ','monamedia');?></a>
            </div>
        </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
