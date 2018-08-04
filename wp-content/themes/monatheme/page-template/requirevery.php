<?php
/**
 * Template name: Require Verify Page
 * @author : Hy Hý
 */
$check = mona_check_veryfi(@$_GET['key'], @$_GET['login']);
if (!is_wp_error($check)) {
    $user_data = get_user_by('login', $_GET['login']);
    if(!$user_data){
        $user_data = get_user_by('email', $_GET['login']);
    } 
    if ($user_data) {
        update_user_meta($user_data->data->ID, '__none_active', 'false');
        wp_redirect(get_site_url());
        exit();
    }
} else {
    get_header();
    ?>
<main class="clear">
<div class="flower-right bot">
      <img src="<?php echo get_site_url();?>/template/images/flower-right.png" alt="bg flower">
    </div>
        <div class="flower-fall-2">
      <img src="<?php echo get_site_url();?>/template/images/flower-fall-2.png" alt="flower">
    </div>
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
        <h4 class="center-txt" style="color: red;">  Oops! url verofy không tồn tại </h4>
        </div>

      </div>
    </div>
    
  </main>
    <?php
    get_footer();
}
?>