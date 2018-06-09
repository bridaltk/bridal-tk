<?php
/**
 * Template name: List gai Page
 * @author : Hy Hý
 */
get_header();
while (have_posts()):
    the_post();
    $ms = @$_GET['mhv'];
    $time_from = @$_GET['time-from'];
    $time_to = @$_GET['time-to'];
    $height_from = @$_GET['height-from'];
    $height_to = @$_GET['height-to'];
    $weight_from = @$_GET['weight-from'];
    $weight_to = @$_GET['weight-to'];
    $quocgia = @$_GET['quocgia'];
    $tuoi_from = @$_GET['year-old-f'];
    $tuoi_to = @$_GET['year-old-t'];
    $hv = @$_GET['hv'];
    $per_page = @$_GET['pagi-nation'];
    $sort = @$_GET['order-by'];
    $per = ((int) $per_page > 47 ? $per_page : 48);
    $page = get_query_var('paged');
    $page = max(1, $page);
    $offset = ($page - 1) * $per;
    $sql = "SELECT SQL_CALC_FOUND_ROWS wp_posts.ID FROM wp_posts INNER JOIN `mona_gai_data` AS gai_data ON (wp_posts.ID = gai_data.post_id) WHERE ";
    $where = array("1=1");
    if ($ms != '') {
        $where[] = "gai_data.`mhv` LIKE '%{$ms}%'";
    }
    if ($time_from != '') {
        $time = explode('/', $time_from);
        $time_num = @$time[2] . @$time[0] . @$time[1];
        $where[] = "gai_data.`ngay_nhap_hoi` >= {$time_num}";
    }
    if ($time_to != '') {
        $time = explode('/', $time_to);
        $time_num = @$time[2] . @$time[0] . @$time[1];
        $where[] = "gai_data.`ngay_nhap_hoi` <= {$time_num}";
    }
    if ($height_from != '') {
        $where[] = "gai_data.`height` >= {$height_from}";
    }
    if ($height_to != '') {
        $where[] = "gai_data.`height` <= {$height_to}";
    }
    if ($weight_from != '') {
        $where[] = "gai_data.`weight` >= {$weight_from}";
    }
    if ($weight_to != '') {
        $where[] = "gai_data.`weight` <= {$weight_to}";
    }
    if ($quocgia != '') {
        $where[] = "gai_data.`quocgia` = '{$quocgia}'";
    }
    if ($tuoi_from != '') {
        $y = date('Y');
        $y = (int) $y - (int) $tuoi_from;
        if ($y > 0) {
            $where[] = "gai_data.`birthday` <= '{$y}1231'";
        }
    }
    if ($tuoi_to != '') {
        $y = date('Y');
        $y = (int) $y - (int) $tuoi_to;
        if ($y > 0) {
            $where[] = "gai_data.`birthday` >= '{$y}0101'";
        }
    }
    if ($hv != '') {
        $check = false;
        $term = array(
            'tieu_hoc',
            'trung_hoc',
            'pho_thong',
            'trung_cap',
            'cao_dang',
            'dai_hoc',
        );
        foreach ($term as $k => $i) {
            if ($i != $hv) {
                unset($term[$k]);
            } else {
                break;
            }
        }
        if(count($term)>0){
             $where[] = "gai_data.`hocvan` IN (\"".  implode('","', $term)."\")";
        }
    }
    $group = 'GROUP BY wp_posts.ID';
    $order_by = "ORDER BY gai_data.`ngay_nhap_hoi`  DESC, wp_posts.`post_date` DESC";
    if ($sort != '') {
        if ($sort == 'old-asc') {
            $order_by = "ORDER BY gai_data.`birthday` DESC , wp_posts.`post_date` DESC";
        } elseif ($sort == 'hoc-van') {
            $order_by = "ORDER BY FIELD(gai_data.`hocvan` , 'dai_hoc','cao_dang','trung_cap','pho_thong','trung_hoc','tieu_hoc') ASC,  wp_posts.`post_date` DESC";
        }
    }
    $limit = "LIMIT {$offset}, {$per}";
    $sql .=implode(' AND ', $where) . ' ' . $group . ' ' . $order_by;
    global $wpdb;
    $query_page_total = $wpdb->get_results($sql);
    $sql .=' ' . $limit;
    $query_page = $wpdb->get_results($sql);
    $total = count($query_page_total);
    $max_page = ceil($total / $per);
    ?>
    <main class="main clear">

        <div class="member-list">
            <div class="flower-fall-2">
                <img src="<?php echo get_site_url(); ?>/template/images/flower-fall-2.png" alt="flower">
            </div>
            <div class="all">
                <div class="section-title">
                    <p class="fz-36 f-title"><?php the_title(); ?></p>
                    <div class="position">
                        <a href="<?php echo get_home_url(); ?>"><?php _e('Trang chủ', 'monamedia'); ?></a>
                        /
                        <span class="color"><?php the_title(); ?></span>
                    </div>
                </div>

                <div class="main-content clear ">

                    <aside class="aside-left">
                        <div class="wrapp-mobile clear">
                            <form action="<?php the_permalink(); ?>" method="get" id="mona-filter-form">
                                <div class="box-filter">
                                    <h6 class="box__title"><?php _e('Mã hội viên', 'monamedia'); ?></h6>
                                    <div class="filter">
                                        <div class="filter__child mona-no-padding">
                                            <input value="<?php echo $ms; ?>" type="text" name="mhv" class="form-control" placeholder="V1043">
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-filter x2r">
                                    <h6 class="box__title"><?php _e('Ngày nhập hội', 'monamedia'); ?></h6>
                                    <div class="filter">
                                        <div class="filter__child">
                                            <span class="icon color"><i class="fas fa-calendar-alt"></i></span>
                                            <input value="<?php echo $time_from; ?>" name="time-from" type="text" class="form-control input-birthdate" placeholder="<?php _e('Ex: Từ', 'monamedia'); ?>">
                                        </div>
                                        <div class="filter__child">
                                            <span class="icon color"><i class="fas fa-calendar-alt"></i></span>
                                            <input value="<?php echo $time_to; ?>" name="time-to" type="text" class="form-control input-birthdate" placeholder="<?php _e('Ex: Đến', 'monamedia'); ?>">
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-filter x2r">
                                    <h6 class="box__title"><?php _e('Chiều cao (cm)', 'monamedia'); ?></h6>
                                    <div class="filter">
                                        <div class="filter__child">
                                            <input min="1" value="<?php echo $height_from; ?>" name="height-from" type="number" class="form-control " placeholder="<?php _e('Ex: Từ', 'monamedia'); ?>">
                                        </div>
                                        <div class="filter__child">
                                            <input min="1" value="<?php echo $height_to; ?>" name="height-to" type="number" class="form-control " placeholder="<?php _e('Ex: Đến', 'monamedia'); ?>">
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-filter x2r">
                                    <h6 class="box__title"><?php _e('Cân nặng', 'monamedia'); ?></h6>
                                    <div class="filter">
                                        <div class="filter__child">
                                            <input min="1" value="<?php echo $weight_from; ?>" name="weight-from" type="number" class="form-control " placeholder="<?php _e('Ex: Từ', 'monamedia'); ?>">
                                        </div>
                                        <div class="filter__child">
                                            <input min="1" value="<?php echo $weight_to; ?>" name="weight-to" type="number" class="form-control " placeholder="<?php _e('Ex: Đến', 'monamedia'); ?>">
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-filter">
                                    <h6 class="box__title"><?php _e('Quốc gia', 'monamedia'); ?></h6>
                                    <div class="filter">
                                        <div class="filter__child">

                                            <span class="icon color"><i class="fas fa-map-marker-alt"></i></span>
                                            <select class="form-control" name="quocgia">
                                                <option value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                                <option <?php echo ($quocgia == 'vn' ? 'selected' : '') ?> value="vn"><?php _e('Việt nam', 'monamedia'); ?></option>
                                                <option <?php echo ($quocgia == 'nhat' ? 'selected' : '') ?> value="nhat"><?php _e('Nhật', 'monamedia'); ?></option>
                                            </select>
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-filter x2r">
                                    <h6 class="box__title"><?php _e('Tuổi', 'monamedia'); ?></h6>
                                    <div class="filter">
                                        <div class="filter__child">
                                            <input value="<?php echo $tuoi_from; ?>" name="year-old-f" type="text" class="form-control" placeholder="<?php _e('Ex: Từ', 'monamedia'); ?>">
                                        </div>
                                        <div class="filter__child">
                                            <input value="<?php echo $tuoi_to; ?>" name="year-old-t" type="text" class="form-control" placeholder="<?php _e('Ex: Đến', 'monamedia'); ?>">
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-filter">
                                    <h6 class="box__title"><?php _e('Học vấn', 'monamedia'); ?></h6>
                                    <div class="filter">
                                        <div class="filter__child">
                                            <span  class="icon color"><i class="fas fa-caret-down"></i></span>
                                            <select class="form-control" name="hv">
                                                <option value=""><?php _e('Chọn', 'monamedia'); ?></option>
                                                <option <?php echo ($hv == 'tieu_hoc' ? 'selected' : '') ?> value="tieu_hoc"><?php _e('Tiểu học', 'monamedia'); ?></option>
                                                <option <?php echo ($hv == 'trung_hoc' ? 'selected' : '') ?> value="trung_hoc"><?php _e('Trung học', 'monamedia'); ?></option>
                                                <option <?php echo ($hv == 'pho_thong' ? 'selected' : '') ?> value="pho_thong"><?php _e('Phổ thông', 'monamedia'); ?></option>
                                                <option <?php echo ($hv == 'trung_cap' ? 'selected' : '') ?> value="trung_cap"><?php _e('Trung cấp', 'monamedia'); ?></option>
                                                <option <?php echo ($hv == 'cao_dang' ? 'selected' : '') ?> value="cao_dang"><?php _e('Cao đẳng', 'monamedia'); ?></option>
                                                <option <?php echo ($hv == 'dai_hoc' ? 'selected' : '') ?> value="dai_hoc"><?php _e('Đại học', 'monamedia'); ?></option>
                                            </select> 
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="box-filter clear right-txt full">
                                    <div class="filter">
                                        <div class="filter__child right-txt">
                                            <button type="submit" class="primary-btn"><?php _e('Lọc', 'monamedia'); ?></button>
                                        </div>
                                        <div class="br br-small">
                                            <i class="diamond"></i>
                                            <i class="diamond"></i>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="pagi-nation" id="pagi-nation" value="<?php echo $per_page; ?>"/>
                                <input type="hidden" name="order-by" id="order-by" value="<?php echo $sort; ?>"/>
                            </form>
                        </div>
                    </aside>
                    <div class="detail-right">

                        <div class="right__top">

                            <div class="nav-page">
                                <?php 
                                $ps = $page;
                                mona_page_navi_sql($ps, $max_page); ?>
                            </div>
                            <div class="box-filter">
                                <h6 class="box__title"><?php _e('Số người 1 trang', 'monamedia'); ?></h6>
                                <div class="filter">
                                    <div class="filter__child">
                                        <span class="icon color"><i class="fas fa-caret-down"></i></span>
                                        <select class="form-control mona-select-appent" data-name="pagi-nation">
                                            <option <?php echo ($per_page == '48' ? 'selected' : '') ?> value="48">48</option>
                                            <option <?php echo ($per_page == '72' ? 'selected' : '') ?> value="72">72</option>
                                            <option <?php echo ($per_page == '96' ? 'selected' : '') ?> value="96">96</option>
                                            <option <?php echo ($per_page == '120' ? 'selected' : '') ?> value="120">120</option>
                                            <option <?php echo ($per_page == '192' ? 'selected' : '') ?> value="192">192</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-filter">
                                <h6 class="box__title"><?php _e('Sắp xếp theo', 'monamedia'); ?></h6>
                                <div class="filter">
                                    <div class="filter__child">
                                        <span class="icon color"><i class="fas fa-caret-down"></i></span>
                                        <select class="form-control mona-select-appent" data-name="order-by">
                                            <option <?php echo ($sort == 'day-join' ? 'selected' : '') ?> value="day-join"><?php _e('Mới nhập hội', 'monamedia'); ?></option>
                                            <option <?php echo ($sort == 'old-asc' ? 'selected' : '') ?> value="old-asc"><?php _e('Trẻ tuổi nhất', 'monamedia'); ?></option>
                                            <option <?php echo ($sort == 'hoc-van' ? 'selected' : '') ?> value="hoc-van"><?php _e('học vấn cao nhất', 'monamedia'); ?></option>


                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="br br-small">
                            <i class="diamond"></i>
                            <i class="diamond"></i>
                        </div>

                        <div class="right__list clear">
                            <?php
                            if (count($query_page) > 0) {
                                foreach ($query_page as $item) {
                                    mona_gai_loop($item->ID);
                                }
                            } else {
                                echo '<p class="center-txt">' . __('Oops! no girl from search', 'monamedia') . '</p>';
                            }
                            ?>

                        </div>

                        <div class="br br-small">
                            <i class="diamond"></i>
                            <i class="diamond"></i>
                        </div>

                        <div class="right__bot">
                            <div class="nav-page">
                                <?php 
                                mona_page_navi_sql($ps, $max_page);; ?>
                            </div>
                        </div>
                    </div>
                    <aside class="aside-left">
                        <div class="promo">
                            <h3 class="fz-24 f-title"><?php _e('Promotion', 'monamedia'); ?></h3>

                            <?php
                            $args = array(
                                'post_type' => 'mona_promotion',
                                'posts_per_page' => 1,
                                'order' => 'DESC',
                                'orderby' => 'date',
                            );
                            $my_query = new WP_Query($args);
                            while ($my_query->have_posts()) {
                                $my_query->the_post();
                                ?>
                                <div class="content" style="background-image: url(<?php the_post_thumbnail_url('large'); ?>);">
                                    <div class="info"><?php the_field('mona_tour_Summary'); ?>
                                        <a href="<?php the_permalink(); ?>" class="btn btn-1"><?php _e('View Details', 'monamedia'); ?></a>
                                    </div> 
                                </div>
                                <?php
                            }
                            wp_reset_query();
                            ?>

                        </div>
                    </aside>
                </div>

            </div>
        </div>

    </main>
    <?php
endwhile;
get_footer();
?>