<?php
/**
 * Template name: Login Page
 * @author : Hy Hý
 */
if (is_user_logged_in()) {
    if (isset($_GET['redierect']) && $_GET['redierect'] != '') {
        wp_redirect($_GET['redierect']);
        die;
    } else {
        wp_redirect(get_home_url());
        die;
    }
}
$error = '';
$notvery = false;
if (isset($_POST['mona_user_name']) && isset($_POST['mona_user_pass'])) {
    $user = get_user_by('email', $_POST['mona_user_name']);
    if ($user == false) {
        $user = get_user_by('login', $_POST['mona_user_name']);
    }
    if ($user == false) {
        $error = __('Không tồn tại user', 'monamedia');
    } else {
        $check_pass = wp_check_password($_POST['mona_user_pass'], $user->data->user_pass, $user->data->ID);
        if ($check_pass == false) {
            $error = __('Mật khẩu không đúng', 'monamedia');
        } else {
            $check = mona_check_has_verify($_POST['mona_user_name']);
            if ($check == false) {
                $notvery = true;
            } else {
                $sing = wp_signon(array(
                    'user_login' => $_POST['mona_user_name'],
                    'user_password' => $_POST['mona_user_pass'],
                ));
                if (!is_wp_error($sing)) {

                    if (isset($_GET['redierect']) && $_GET['redierect'] != '') {
                        wp_redirect($_GET['redierect']);
                        die;
                    } elseif (isset($_POST['mona_redierect']) && $_POST['mona_redierect'] != '') {
                        wp_redirect($_POST['mona_redierect']);
                        die;
                    } else {
                        wp_redirect(get_home_url());
                        die;
                    }
                }
            }
        }
    }
}
get_header();
while (have_posts()):
    the_post();
    ?>
    <main>


        <div class="join section-wrap">
            <div class="flower-right">
                <img src="<?php echo get_site_url(); ?>/template/images/flower-right.png" alt="bg flower">
            </div>
            <div class="flower-fall-2">
                <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
            </div>

            <div class="all">

                <div class="section-title">
                    <h1 class="fz-36 f-title"><?php _e('Đăng nhập', 'monamedia'); ?></h1>
                </div>

                <div class="join-detail__content clear">

                    <div class="side-left">
                        <div id="login-none-veri">
                            
                        </div>
                        <?php
                        if ($error != '') {
                            echo '<p style="color:red;margin-bottom:  20px;">' . $error . '</p>';
                        }else{
                            if($notvery==true){
                                mona_send_email_veryfi($_POST['mona_user_name']);
                                $userlogin= $_POST['mona_user_name'];
                            get_template_part('patch/success', 'sendveryfi'); 
                            }
                        }
                        ?>
                        <form method="post" action="" id="mona-submit-login">
                            <div class="box__input">
                                <div class="content">

                                    <div class="input__child full">
                                        <h6 class="input__title"><?php _e('Tên đăng nhập', 'monamedia'); ?></h6>
                                        <div class="form">
                                            <input type="text" class="form-control" required name="mona_user_name">
                                        </div>
                                    </div>
                                    <div class="input__child full">
                                        <h6 class="input__title"><?php _e('Mật khẩu', 'monamedia'); ?></h6>
                                        <div class="form">
                                            <input type="password" class="form-control" required name="mona_user_pass">
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($_GET['redierect']) && $_GET['redierect'] != '') {
                                        echo '<input type="hidden" name="mona_redierect" value="' . esc_url($_GET['redierect']) . '"/>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="box__input">
                                <div class="mona-login-action input__child full">
                                    <button type="submit" class="primary-btn mona-button"><?php _e('Đăng nhập', 'monamedia'); ?></button>
                                    <div class="mona-text">
                                        <p><?php _e('Bạn chưa có tài khoản? ', 'monamedia') ?><a href="<?php echo get_the_permalink(MONA_REGISTER); ?>"><?php _e('Đăng ký ngay', 'monamedia') ?></a></p>
                                        <p><?php _e('Bạn quên mật khẩu? ', 'monamedia') ?><a href="<?php echo get_the_permalink(MONA_LOST_PASS); ?>"><?php _e('Tìm lại mật khẩu', 'monamedia') ?></a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="br br-small">
                                <i class="diamond"></i>
                                <i class="diamond"></i>
                            </div>
                        </form>
                    </div>

                </div>

            </div>


        </div>
    </div>

    </main>
    <?php
endwhile;
get_footer();
?>