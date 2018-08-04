<?php
if(isset($_POST['mona_admin_user_status'])){
    update_user_meta($_GET['user_id'], '__status', $_POST['mona_admin_user_status']);
                
}
if(isset($_POST['mona_admin_user_sub_status'])){
    update_user_meta($_GET['user_id'], '__sub_status', $_POST['mona_admin_user_sub_status']);
}
$user = get_userdata($_GET['user_id']);
?>
<div class="wrap mona-wrapp-page">
    <h1 class="wp-heading-inline">Khách hàng: <?php echo $user->data->display_name; ?></h1>
    <div class="clear"></div>
    <form method="post">
    <table class="wp-list-table widefat fixed striped posts">
        <tbody id="the-list">
            <tr>
                <td>
                    Ảnh đại diện
                </td>
                <td>
                    <?php
                    $avatar = get_user_meta($user->data->ID, '__avatar', true);
                    if ($avatar != '') {
                        echo wp_get_attachment_image($avatar, 'thumbnail');
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    Thông tin
                </td>
                <td>
                    <p>Tên: <?php echo $user->data->display_name; ?></p>
                    <p>Email: <?php echo $user->data->user_email; ?></p>
                    <p>Điện thoại: <?php echo get_user_meta($user->data->ID, '__phone', true); ?></p>
                </td>
            </tr>
            <tr>
                <td>
                    Tình trạng
                </td>
                <td>
                    <div class="item">
                        <p>Tình trạng</p>
                        <?php
                        $status = get_user_meta($user->data->ID,'__status',true);
                        ?>
                        <select name="mona_admin_user_status">
                            <option value="">Chọn</option>
                            <option <?php echo ($status=='doc_than'?'selected':'');?> value="doc_than">Độc thân</option>
                            <option <?php echo ($status=='dinh_hon'?'selected':'');?> value="dinh_hon">Đính hôn</option>
                            <option <?php echo ($status=='ket_hon'?'selected':'');?> value="ket_hon">Kết hôn</option>
                        </select>
                    </div>
                    <div class="item">
                        <p>trạng thái</p>
                        <?php
                        $sub = get_user_meta($user->data->ID,'__sub_status',true);
                        ?>
                        <select name="mona_admin_user_sub_status">
                            <option value="">Chưa liên hệ</option>
                            <option <?php echo ($sub=='lien_he'?'selected':'');?> value="lien_he">Đã liên hệ</option>
                            <option <?php echo ($sub=='hoan_tat'?'selected':'');?> value="hoan_tat">Hoàn tất</option>
                        </select>
                    </div>
                    
                </td>
            </tr>
            
        </tbody>
        <tfoot>
            <tr></tr>
        </tfoot>
    </table>
        <?php submit_button(); ?>
    </form>
    <div id="ajax-response"></div>
    <br class="clear"> </div>