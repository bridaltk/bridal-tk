<?php
require_once( get_template_directory() . '/includes/class/mona_admin_user.php' );
$users = new Mona_admin_user();
$khach_hang = $users->get_khach_hang();
?>
<div class="wrap mona-wrapp-page">
    <h1 class="wp-heading-inline">Khách hàng</h1>
    <div class="clear"></div>
    <!--        <ul class="subsubsub">
        <li class="all"><a href="admin.php?page=mona_author" class="current" aria-current="page">Tất cả <span class="count">(1)</span></a> |</li>
        <li class="publish"><a href="admin.php?page=mona_author&action=ket_hon">Đã kết hôn <span class="count">(1)</span></a></li>
    </ul>-->
    <table class="wp-list-table widefat fixed striped posts">
        <thead>
            <tr>
                <th scope="col" id="name" class="manage-column column-username column-primary sortable desc"> 
                    Ảnh đại diện
                </th>
                <th scope="col" id="username" class="manage-column column-username column-primary sortable desc"> 
                    Tên
                </th>
                <th scope="col" id="name" class="manage-column column-name">Email</th>
                <th scope="col" id="role" class="manage-column column-role">Điện thoại</th>
                <th scope="col" id="role" class="manage-column column-role">Tình trạng</th>
                <th scope="col" id="role" class="manage-column column-role">trạng thái</th>
            </tr>
        </thead>
        <tbody id="the-list">
            <?php
            if (is_array($khach_hang)) {
                foreach ($khach_hang as $user_id) {
                    $user = get_userdata($user_id->ID);
                    ?>
                    <tr id="post-309" class="iedit author-other level-0 post-309 type-mona_tour status-publish hentry">
                        <td class="title column-username has-row-actions column-primary page-title" >
                            <?php
                            $avatar = get_user_meta($user->data->ID,'__avatar',true);
                            if($avatar !=''){
                                echo wp_get_attachment_image($avatar,'thumbnail');
                            }
                            ?>
                        </td>
                        <td class="title column-username has-row-actions column-primary page-title" >
                            <strong><?php echo $user->display_name; ?></strong>
                            <div class="row-actions">
                                <span class="edit">
                                    <a href="admin.php?page=mona_author&user_id=<?php echo $user->data->ID; ?>">Chỉnh sửa</a> </span>
                            </div>
                        </td>
                        <td class="author column-name" >
                            <?php echo $user->user_email; ?>
                        </td>
                        <td class="author column-role"  >
                            <?php echo get_user_meta($user->data->ID, '__phone', true); ?>
                        </td>
                         <td class="author column-name" >
                            <?php 
                            $stt = get_user_meta($user->data->ID,'__status',true);
                            if($stt =='doc_than'){
                                echo 'Độc thân';
                            }elseif($stt =='dinh_hon'){
                                 echo 'Đính hôn';
                            }elseif($stt =='ket_hon'){
                                 echo 'Kết hôn';
                            }
                            ?>
                        </td>
                         <td class="author column-name" >
                            <?php $sub_stt= get_user_meta($user->data->ID,'__sub_status',true);
                             if($sub_stt ==''){
                                echo 'Chưa liên hệ';
                            }elseif($sub_stt =='lien_he'){
                                 echo 'Đã liên hệ';
                            }elseif($sub_stt =='hoan_tat'){
                                 echo 'Hoàn tất';
                            }
                            ?>
                        </td>
                    </tr>    
                    <?php
                }
            }
            ?>

        </tbody>
        <tfoot>
            <tr></tr>
        </tfoot>
    </table>
    <div id="ajax-response"></div>
    <br class="clear"> </div>