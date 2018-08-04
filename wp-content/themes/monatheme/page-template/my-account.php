<?php
/**
 * Template name: My acount Page
 * @author : Hy Hý
 */
if (!is_user_logged_in()) {
    mona_redierect_login();
}
get_header();
$var = get_query_var('my_account_var');
$u = get_userdata(get_current_user_id());
$user = new Mona_user(get_current_user_id());
$post_id = $user->get_post_id();
while (have_posts()){
    the_post();

?>
<main>
    <div class="flower-right bot">
        <img src="<?php echo get_site_url(); ?>/template/images/flower-right.png" alt="bg flower">
    </div>
    <div class="flower-fall-2">
        <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
    </div>

    <div class="account section-wrap">
        <div class="all">

            <div class="section-title">
                <h1 class="fz-36 f-title"><?php _e('Tài khoản', 'monamedia'); ?></h1>
            </div>

            <div class="account-detail__content clear">

                <div class="side-left">

                    <ul class="list">
                        <li class="item <?php echo ($var != 'doi-mat-khau' && $var != 'lich-su' && $var != 'chuyen-di' ? 'active' : ''); ?>" >
                            <div class="icon"><i class="fas fa-fw fa-user"></i></div>
                            <div class="info"><h4 class="fz-18"><a href="<?php the_permalink(); ?>"><?php _e('Quản lý tài khoản', 'monamedia'); ?></a></h4></div>
                        </li>
                        <li class="item <?php echo ($var == 'chuyen-di'?'active':'');  ?>">
                            <div class="icon"><i class="far fa-fw fa-clock"></i></div>
                            <div class="info"><h4 class="fz-18"><a href="<?php the_permalink();   ?>/chuyen-di/"><?php _e('Chuyến đi', 'monamedia');   ?></a></h4></div>
                        </li>
                        <li class="item">
                            <div class="icon"><i class="far fa-address-card"></i></div>
                            <div class="info"><h4 class="fz-18"><a href="<?php echo get_the_permalink(MONA_BOOKING);   ?>"><?php _e('Đăng ký gặp mặt', 'monamedia');   ?></a></h4></div>
                        </li>
                        <li class="item <?php echo ($var == 'doi-mat-khau' ? 'active' : ''); ?>" >
                            <div class="icon"><i class="fas fa-fw fa-lock"></i></div>
                            <div class="info"><h4 class="fz-18"><a href="<?php the_permalink(); ?>/doi-mat-khau/"><?php _e('Thay đổi mật khẩu', 'monamedia'); ?></a></h4></div>
                        </li>
                        <li class="item">
                            <div class="icon"><i class="fas fa-fw fa-sign-out-alt"></i></div>
                            <div class="info"><h4 class="fz-18"><a class="mona-logout-action" href="<?php echo wp_logout_url(get_home_url()); ?>"><?php _e('Đăng xuất', 'monamedia'); ?></a></h4></div>
                        </li>
                    </ul>
                </div>

                <div class="side-right">

                    <?php
                    if ((!in_array('mona_khac_hang', $u->roles) || mona_iswp_error($post_id) || @$post_id == '')) {
                        ?>
                        <p class="mona-thank-text" style="color:red;"><?php _e('Oops! Tài khoản của bạn không đủ quyền để thao tác trên trang này', 'monamedia'); ?></p>   
                        <p class="mona-thank-text" style="color:red;"><?php _e('Phiền bạn ', 'monamedia'); ?><a href="<?php echo esc_url(wp_logout_url('//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])); ?>" style=" color: #528ee2; font-weight: bold; text-decoration: underline; "><?php _e('đăng xuất', 'monamedia'); ?></a><?php _e(' để tiếp tục', 'monamedia'); ?></p>   

                        <?php
                    } else {
                        get_template_part('patch/account/account', $var);
                    }
                    ?>
                </div>

            </div>

        </div>


    </div>

</main>    
<?php
}
get_footer();
?>