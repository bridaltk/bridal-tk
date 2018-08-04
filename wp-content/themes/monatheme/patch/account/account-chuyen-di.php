<?php
$error = array();
$success = array();
$user = new Mona_user(get_current_user_id());
$user = new Mona_user(33);
$post_id = $user->get_post_id();
$udata = $user->get_user_data();
?>
<div class="content-nav">
    <div class="box__input">
        <div class="title">
            <h3 class="fz-24 sub-title2"><?php _e('Chuyến đi', 'monamedia'); ?></h3></div>
        <div class="content">
            <?php
            $args = array(
                'post_type' => 'mona_tour',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date',
                'meta_query' => array(
                    array(
                        'key' => 'mona_tour_customer',
                        'value' => $post_id,
                        'compare' => '='
                    )
                )
            );
            $my_query = new WP_Query($args);
            ?>
            <table id="mona-chuyen-di-table" class="mona-account-table">
                <thead>
                    <tr>
                        <th>
                            <?php _e('Ngày đi', 'monamedia'); ?>
                        </th>
                        <th>
                            <?php _e('Loại chuyến đi', 'monamedia'); ?>
                        </th>
                        <th>
                            <?php _e('Chuyến bay', 'monamedia'); ?>
                        </th>
                        <th>
                            <?php _e('Phiên dịch', 'monamedia'); ?>
                        </th>
                        <th class="actions">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($my_query->have_posts()) {
                        $tarr = array(
                            'di_gap_mat' => __('Meeting', 'monamedia'),
                            'di_ket_hon' => __('Wedding', 'monamedia'),
                            'di_choi' => __('Free', 'monamedia'),
                            'di_cong_chuyen' => __('Business', 'monamedia'),
                        );
                        while ($my_query->have_posts()) {
                            $my_query->the_post();
                            $type = get_field('mona_tour_type');
                            ?>
                            <tr class="<?php echo $type; ?>" id="<?php the_ID(); ?>">
                                <td><?php the_field('mona_tour_flight_date'); ?></td>
                                <td><?php echo @$tarr[$type]; ?></td>
                                <td><?php the_field('mona_tour_flight_num'); ?></td>
                                <td><?php the_field('mona_tour_translate'); ?></td>
                                <td class="action-view-tour">
                                    <a href="javascript:;" class="mona-view-schedule"><?php _e('Xem lịch biểu', 'monamedia'); ?></a>
                                </td>
                            </tr> 
                            <?php
                        }
                        wp_reset_query();
                    } else {
                        ?>
                        <tr><td colspan="5"><?php _e('Chưa có chuyến đi nào dành cho bạn', 'monamedia'); ?></td></tr>    
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="br br-small">
            <i class="diamond"></i>
            <i class="diamond"></i>
        </div>
    </div>
    
    <div class="box__input">
        <div class="title">
            <h3 class="fz-24 sub-title2"><?php _e('Gặp mặt', 'monamedia'); ?></h3></div>
        <div class="content">
            <?php
            $args = array(
                'post_type' => 'mona_order',
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date',
                'post_status'=>array('publish','pending','trash'),
                'author' => get_current_user_id()
            );
            $my_query = new WP_Query($args);
            ?>
            <table id="mona-order-table" class="mona-account-table">
                <thead>
                    <tr>
                        <th>
                            <?php _e('Ngày đi', 'monamedia'); ?>
                        </th>
                        <th>
                            <?php _e('Member', 'monamedia'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($my_query->have_posts()) {
                        while ($my_query->have_posts()) {
                            $my_query->the_post();
                            $type =  get_post_type();
                            ?>
                            <tr class="<?php echo $type; ?>" id="<?php the_ID(); ?>">
                                <td><?php echo get_post_meta(get_the_ID(),'__time_start',true); ?></td>
                                <td><?php 
                                $gais = get_post_meta(get_the_ID(),'__gai',true);
                                if(is_array($gais) && count($gais)>0){
                                    echo '<ul class="table-gai-list clear">';
                                    foreach ($gais as $gai){
                                        echo '<li class="item-view"><div class="img mona-thumb-img" style="background-image:url(' . get_the_post_thumbnail_url($gai, 'medium') . ');"></div><p><strong>#' . get_field('mona_gai_ma_hoi_vien',$gai) . '</strong></p></li>';
                                    }
                                    echo '</ul>';
                                }
                                ?></td>
                                
                            </tr> 
                            <?php
                        }
                        wp_reset_query();
                    } else {
                        ?>
                        <tr><td colspan="2"><?php _e('Bạn chưa chọn gặp mặt nào', 'monamedia'); ?></td></tr>    
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="br br-small">
            <i class="diamond"></i>
            <i class="diamond"></i>
        </div>
    </div>
</div>
