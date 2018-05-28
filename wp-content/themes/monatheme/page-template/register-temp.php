<?php
/**
 * Template name: Register temp
 * @author : Hy Hý
 */

get_header();
while (have_posts()):
    the_post();
 //mona_send_email_veryfi('kanawan');
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
                    <h1 class="fz-36 f-title"><?php _e('Đăng ký', 'monamedia'); ?></h1>
                </div>

                <div class="join-detail__content clear">

                    <div class="side-left"><div class="box__input">

    <div class="title"><h3 class="fz-24 sub-title2" style=" color: #4CAF50; font-weight: normal; "><?php _e('Đăng ký thành công', 'monamedia'); ?></h3></div>
    <div class="content success-register">
        <?php
        _e('chúng tôi đã gửi 1 email để xác nhận tài khoản của bạn', 'monamedia');
        ?>
        <div id="mona-action-re-email" style="margin-top: 20px; display: none;">
            <p><span style="color:red;">*</span><?php _e('Không nhận được email', 'monamedia'); ?></p>
            <a  class="primary-btn small-btn" href="<?php echo get_home_url(); ?>"><?php _e('Gửi lại email', 'monamedia'); ?></a>
        </div>
    </div>
</div></div>

                </div>

            </div>


        </div>
    </div>

    </main>
    <?php
endwhile; 
get_footer();
?>