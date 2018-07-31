<footer id="footer">
    <div class="all">
      <div class="ft-infos clear">

        <div class="ft__child name mona-w30">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_1')) : ?><?php endif; ?>
        </div>
        <div class="ft__child contact-form mona-w40">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_2')) : ?><?php endif; ?>
        </div>
        <div class="ft__child social mona-w30">
        <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_3')) : ?><?php endif; ?>
        </div>
      </div>
    </div>
    <div class="ft-sys center-txt clear">
        <?php echo mona_option('mona_coppyright'); ?>    
    </div>
</footer>

<a href="javascript:;" class="scroll-top-link" id="scroll-top"><i class="fa fa-angle-up"></i></a>
<script src="<?php echo site_url(); ?>/template/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo site_url(); ?>/template/js/slick/slick.min.js"></script>
<script src="<?php echo site_url(); ?>/template/js/google-map.js"></script>
<script src="<?php echo site_url(); ?>/template/js/select2/select2.min.js"></script>
<script src="<?php echo site_url(); ?>/template/js/master.js"></script>
<!--<script async="" type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_roqaeKE7ULRUNw5wG0i8TqvWRsSJ2JY&amp;callback=loadGoogleMap"></script>-->
<?php

if(is_page_template('page-template/thong-tin-cong-ty.php')){
    ?><script async="" type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_roqaeKE7ULRUNw5wG0i8TqvWRsSJ2JY&amp;callback=loadGoogleMap2"></script>
<?php
}
?>
<?php wp_footer(); ?>
</body>
</html>
