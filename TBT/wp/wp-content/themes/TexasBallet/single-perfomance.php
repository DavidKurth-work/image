<?php
get_header();
$category = get_queried_object();
$metaFields = get_term_meta($category->term_id);
$singlePostCategory = get_the_terms(get_the_ID(), 'location');
$singleSeasonName = get_the_terms(get_the_ID(), 'season');
$currentId = get_the_ID();
$slug = get_post_field( 'post_name', get_post() ); // Get slug name for performance specific calls.
$today = current_time('timestamp'); // Set today's date in UNIX timestamp to compare against event date.
$startDate = get_field('start_date');  
$endDate = get_field('end_date');
$startTimestamp = strtotime($startDate); //Convert start date to Unix for comparison to today's date.
$endTimestamp = strtotime($endDate); //Convert start date to Unix for comparison to today's date.
?>

    <section class="single_perfomance">

        <section class="hero_block">
            <div class="single_item">
                <div class="image d-flex align-items-center" style="background-image: url(<?= get_the_post_thumbnail_url('', 'full') ?>)">
                    <div class="container-fluid">
                        <div class="row d-flex flex-row-reverse align-items-center">
                            <div class="image_holder_single">
                                <img src="<?= get_the_post_thumbnail_url('', 'full') ?>"
                                        alt=""
                                        class="img-fluid">
                            </div>
                            <div class="info_holder">
                                <div class="season_info">
                                    <h6>
                                        <?php
                                        $i = 0;
                                        foreach ($singlePostCategory as $single) {

                                            echo ($i >= 1) ? ' & ' : '';
                                            echo $single->name;

                                            $i++;
                                        }
                                        ?> </h6>
                                </div>
                                <div class="title">
                                    <h1>
                                        <?= get_the_title(); ?>
                                    </h1>
                                </div>
                                <?php  if ($today <= $endTimestamp) { ?>
                                <div class="additional_info">
                                    <p>
                                        <?php
                                            // Load field values for start and end date.
                                            $start_date = get_field('start_date');
                                            $end_date = get_field('end_date');

                                            // Create DateTime object from value in ACF.
                                            $date_first = DateTime::createFromFormat('Y-m-d', $start_date);
                                            $date_last = DateTime::createFromFormat('Y-m-d', $end_date);

                                            //Print the dates.
                                            echo $date_first->format('M d');
                                            //Display hyphen for a range of dates or ampersand for one date per location.
                                            // if ($slug === 'the-nutty-nutcracker' ) {
                                            //     echo ' & ';
                                            // }
                                            // else {
                                            //     echo ' - ';
                                            // }
                                            

                                            echo ' - ';
                                            echo $date_last->format('M d, Y');
                                        ?>
                                    </p>
                                </div>
                                
                                    <?php if (have_rows('top_info_block')) {
                                        while (have_rows('top_info_block')) {
                                            the_row(); ?>
                                            <div class="button_group">
                                                <?php if (get_sub_field('buy_button_url')) { ?>
                                                    <a href="<?php the_sub_field('buy_button_url'); ?>" class="dark_btn">buy tickets</a>
                                                <?php } else {}?>
                                                <?php 
                                                if ( $slug === 'the-nutty-nutcracker' ) {
                                                } else {?>
                                                <?php 
                                                $link = get_sub_field('see_package_url');
                                                if( $link ): 
                                                    $link_url = $link['url'];
                                                    $link_title = $link['title'];
                                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                                    ?>
                                                    <a class="dark_btn" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                                                <?php endif; ?>
                                                <?php } ?>
                                                
                                                
                                            </div>
                                        <?php }
                                    } //endif info block
                                } //endif timestamp check
                                else { ?>
                                    <div class="additional_info">
                                        <p>Performance Complete</p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <?php /// Main info block?>
        <?php if (have_rows('main_info_block')) {
            while (have_rows('main_info_block')) {
                the_row(); ?>
                <section class="main_info_block">

                    <?php /// Main info section?>
                    <div class="container main_container">
                        <div class="row justify-content-center">
                            <div class=" col-md-10 col-12">

                                <div class="main_title">
                                    <h6><?= get_the_title(); ?></h6>
                                    <h3>
                                    <?php the_sub_field('main_info_title'); ?>
                                    </h3>
                                </div>

                                <div class="main_info">
                                    <?php the_sub_field('main_info_description'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php /// repeater block section
                    if (have_rows('perfomances')) { ?>

                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-12">
                                <div class="row">
                                    <?php while (have_rows('perfomances')) {
                                        the_row(); ?>
                                        <div class="col">
                                            <div class="single_info">
                                                <div class="title">
                                                    <h4>
                                                        <?php the_sub_field('title'); ?>
                                                    </h4>
                                                </div>
                                                <div class="description">
                                                    <?php the_sub_field('description'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                </div>
                            </div><!--row2-->
                        </div>

                    <?php } ?>

                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="additional_info">
                                    <?php 
                                    if ($today <= $endTimestamp) {
                                        the_sub_field('performing_place'); 
                                    }
                                    else {?>
                                        - Performance Complete -
                                    <? } ?>
                                </div>
                            </div>
                        </div>
                    </div>


                </section>
            <?php }
        } ?>

        <?php if ($today <= $endTimestamp) : ?>

        <!--TABS SECTION -->
        <?php if (have_rows('tabs_section')) {
            while (have_rows('tabs_section')) {
                the_row(); ?>
            


                <section class="tabs_content">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <?php 
                                    $row = get_row('tabs_section'); 
                                    $venues = get_sub_field('opener');
                                    ?>
                                    <!--IF FORT WORTH, DISPLAY TAB FIRST -->
                                    <?php if ($venues == 'fort_worth') : ?>
                                        <?php if ($row['fort_worth']) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" id="fort_worth-tab" data-toggle="tab"
                                                href="#fort_worth"
                                                role="tab" aria-controls="fort_worth" aria-selected="false">
                                                    Fort Worth
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ($row['dallas_section']) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" id="dallas-tab" data-toggle="tab" href="#dallas"
                                                role="tab" aria-controls="dallas" aria-selected="true">
                                                    Dallas
                                                </a>
                                            </li>
                                        <?php } 
                                    endif; ?>
                                    <!--IF DALLAS, DISPLAY TAB FIRST -->
                                    <?php if ($venues == 'dallas') : ?> 
                                        <?php if ($row['dallas_section']) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" id="dallas-tab" data-toggle="tab" href="#dallas"
                                                role="tab" aria-controls="dallas" aria-selected="true">
                                                    Dallas
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ($row['fort_worth']) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" id="fort_worth-tab" data-toggle="tab"
                                                href="#fort_worth"
                                                role="tab" aria-controls="fort_worth" aria-selected="false">
                                                    Fort Worth
                                                </a>
                                            </li>
                                        <?php } 
                                    endif; ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="calendar-tab" data-toggle="tab" href="#calendar"
                                           role="tab" aria-controls="calendar" aria-selected="false">
                                            CALENDAR
                                        </a>
                                    </li>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                   
                                <?php if ($venues == 'dallas') : //Show Fort Worth rows first if opening performance ?>
                                    <?php if (have_rows('dallas_section')) { ?>
                                        <div class="tab-pane fade" id="dallas" role="tabpanel"
                                             aria-labelledby="dallas-tab">
                                             
                                            <?php while (have_rows('dallas_section')) {
                                                the_row();
                                                $orgDate = get_sub_field('date'); // Get Date from ACF
                                                $eventDate = strtotime($orgDate); // Create UNIX Timestamp for ACF Field
                                                if ( $today <= $eventDate ) { // Compare Today's Date to Event Date
                                                ?>
                                                 <!-- Use this code to add to class below to turn back on out of stock/disable option 
                                                <= (get_sub_field('availability') === 'out_of_stock') ? 'disable' : ''; ?>
                                                -->
                                                <div class="tab_row disable">
                                                    <div class="tab_col usual_text date_col">
                                                        <?php
                                                        
                                                        $newDate = date("l, F d", $eventDate); //Convert Date to Day of Week, Month Date
                                                        echo $newDate; ?>
                                                    </div>
                                                    <div class="tab_col usual_text time_col">
                                                        <?php the_sub_field('time'); ?>
                                                    </div>
                                                    <div class="tab_col additional_info">
                                                        <?php the_sub_field('additional_info'); ?>
                                                    </div>
                                                    <div class="tab_col btn_col">
                                                        <a href="#" class="dark_btn" target="_blank">COMING SOON</a>
                                                        <!--
                                                        <php if (get_sub_field('buy_url')) { ?>
                                                            <a href="<php the_sub_field('buy_url'); ?>" class="dark_btn" target="_blank">
                                                            <= (get_sub_field('availability') === 'out_of_stock') ? 'sold out' : 'BUY TICKETS'; ?>
                                                            </a>
                                                        <php } else { 
                                                            $buy_link = get_field('buy_tickets', 'options');
                                                            if( $buy_link ) { ?>
                                                                <a href="<php echo esc_url( $buy_link['url'] ); ?>" target="<php echo esc_attr( $buy_link['target'] ); ?>" class="dark_btn"><php echo esc_html( $buy_link['title'] ); ?></a>
                                                            <php }
                                                        } ?>-->
                                                    </div>
                                                </div>
                                                <?php }
                                            } ?>
                                        </div>
                                    <?php } ?>

                                    <?php 

                                    if (have_rows('fort_worth')) {
                                            ?>
                                        <div class="tab-pane fade " id="fort_worth" role="tabpanel"
                                                aria-labelledby="fort_worth-tab">
                                            <?php while (have_rows('fort_worth')) {
                                                the_row();
                                                $orgDate = get_sub_field('date'); // Get Date from ACF
                                                $eventDate = strtotime($orgDate); // Create UNIX Timestamp for ACF Field
                                                if ( $today <= $eventDate ) { // Compare Today's Date to Event Date
                                                ?>
                                               
                                                <div class="tab_row disable">
                                                    <div class="tab_col usual_text date_col">
                                                        <?php
                                                        $orgDate = get_sub_field('date');
                                                        $newDate = date("l, F d", strtotime($orgDate)); //Convert Date to Day of Week, Month Date
                                                        echo $newDate; ?>
                                                    </div>
                                                    <div class="tab_col usual_text time_col">
                                                        <?php the_sub_field('time'); ?>
                                                        
                                                    </div>
                                                    <div class="tab_col additional_info">
                                                        <?php the_sub_field('additional_info'); ?>
                                                    </div>
                                                    <div class="tab_col btn_col">
                                                        <a href="#" class="dark_btn" target="_blank">COMING SOON</a>
                                                        <!--
                                                        <php if (get_sub_field('buy_url')) { ?>
                                                            <a href="<php the_sub_field('buy_url'); ?>" class="dark_btn" target="_blank">
                                                            <= (get_sub_field('availability') === 'out_of_stock') ? 'sold out' : 'BUY TICKETS'; ?>
                                                            </a>
                                                        <php } else { 
                                                            $buy_link = get_field('buy_tickets', 'options');
                                                            if( $buy_link ) { ?>
                                                                <a href="<php echo esc_url( $buy_link['url'] ); ?>" target="<php echo esc_attr( $buy_link['target'] ); ?>" class="dark_btn"><php echo esc_html( $buy_link['title'] ); ?></a>
                                                            <php }
                                                        } ?>-->
                                                    </div>
                                                </div>
                                                <?php }
                                            } ?>
                                        </div>
                                    <?php } ?>
                                <?php endif; ?>

                                <?php if($venues == 'fort_worth') : //Show Fort Worth rows first if opening performance ?>
                                    <?php if (have_rows('fort_worth')) { ?>
                                        <div class="tab-pane fade " id="fort_worth" role="tabpanel"
                                                aria-labelledby="fort_worth-tab">
                                            <?php while (have_rows('fort_worth')) {
                                                the_row();
                                                $orgDate = get_sub_field('date'); // Get Date from ACF
                                                $eventDate = strtotime($orgDate); // Create UNIX Timestamp for ACF Field
                                                if ( $today <= $eventDate ) { // Compare Today's Date to Event Date
                                                ?>
                                                <div class="tab_row disable">
                                                    <div class="tab_col usual_text date_col">
                                                        <?php
                                                        $orgDate = get_sub_field('date');
                                                        $newDate = date("l, F d", strtotime($orgDate)); //Convert Date to Day of Week, Month Date
                                                        echo $newDate; ?>
                                                    </div>
                                                    <div class="tab_col usual_text time_col">
                                                        <?php the_sub_field('time'); ?>
                                                        
                                                    </div>
                                                    <div class="tab_col additional_info">
                                                        <?php the_sub_field('additional_info'); ?>
                                                    </div>
                                                    <div class="tab_col btn_col">
                                                        <a href="#" class="dark_btn" target="_blank">COMING SOON</a>
                                                        <!--
                                                        <php if (get_sub_field('buy_url')) { ?>
                                                            <a href="<php the_sub_field('buy_url'); ?>" class="dark_btn" target="_blank">
                                                            <= (get_sub_field('availability') === 'out_of_stock') ? 'sold out' : 'BUY TICKETS'; ?>
                                                            </a>
                                                        <php } else { 
                                                            $buy_link = get_field('buy_tickets', 'options');
                                                            if( $buy_link ) { ?>
                                                                <a href="<php echo esc_url( $buy_link['url'] ); ?>" target="<php echo esc_attr( $buy_link['target'] ); ?>" class="dark_btn"><php echo esc_html( $buy_link['title'] ); ?></a>
                                                            <php }
                                                        } ?>-->
                                                    </div>
                                                </div>
                                                <?php }
                                            } ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (have_rows('dallas_section')) { ?>
                                        <div class="tab-pane fade" id="dallas" role="tabpanel"
                                             aria-labelledby="dallas-tab">
                                             
                                            <?php while (have_rows('dallas_section')) {
                                                the_row();
                                                $orgDate = get_sub_field('date'); // Get Date from ACF
                                                $eventDate = strtotime($orgDate); // Create UNIX Timestamp for ACF Field
                                                if ( $today <= $eventDate ) { // Compare Today's Date to Event Date
                                                ?>
                                                <div class="tab_row disable">
                                                    <div class="tab_col usual_text date_col">
                                                        <?php
                                                        
                                                        $newDate = date("l, F d", $eventDate); //Convert Date to Day of Week, Month Date
                                                        echo $newDate; ?>
                                                    </div>
                                                    <div class="tab_col usual_text time_col">
                                                        <?php the_sub_field('time'); ?>
                                                    </div>
                                                    <div class="tab_col additional_info">
                                                        <?php the_sub_field('additional_info'); ?>
                                                    </div>
                                                    <div class="tab_col btn_col">
                                                        <a href="#" class="dark_btn" target="_blank">COMING SOON</a>
                                                        <!--
                                                        <php if (get_sub_field('buy_url')) { ?>
                                                            <a href="<php the_sub_field('buy_url'); ?>" class="dark_btn" target="_blank">
                                                            <= (get_sub_field('availability') === 'out_of_stock') ? 'sold out' : 'BUY TICKETS'; ?>
                                                            </a>
                                                        <php } else { 
                                                            $buy_link = get_field('buy_tickets', 'options');
                                                            if( $buy_link ) { ?>
                                                                <a href="<php echo esc_url( $buy_link['url'] ); ?>" target="<php echo esc_attr( $buy_link['target'] ); ?>" class="dark_btn"><php echo esc_html( $buy_link['title'] ); ?></a>
                                                            <php }
                                                        } ?>-->
                                                    </div>
                                                </div>
                                                <?php }
                                            } ?>
                                        </div>
                                    <?php } ?>
                                <?php endif; ?>

                                    <div class="tab-pane fade" id="calendar" role="tabpanel"
                                         aria-labelledby="calendar-tab">
                                        <div id='calendar_block'></div>

                                        <script>

                                            jQuery(document).ready(function () {
                                                var today = new Date();
                                                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

                                                var calendarEl = document.getElementById('calendar_block');
                                                <?php $newEndDate = date('Y-m-d', strtotime($endDate . '+1 day')); ?>
                                                var calendar = new FullCalendar.Calendar(calendarEl, {
                                                    plugins: ['dayGrid'],
                                                    contentHeight: 'auto',
                                                    fixedWeekCount: false,
                                                    validRange: {
                                                        start: '<?php echo $startDate; ?>',
                                                        end: '<?php echo $newEndDate; ?>'
                                                    },
                                                   
                                                    events: [
                                                        <?php 
                                                        
                                                        if (have_rows('dallas_section')) {
                                                            while (have_rows('dallas_section')){ 
                                                                the_row();
                                                                $orgDate = get_sub_field('date'); // Get Date from ACF
                                                                $eventDate = strtotime($orgDate); // Create UNIX Timestamp for ACF Field
                                                                if ( $today <= $eventDate ) { // Compare Today's Date to Event Date
                                                            ?>
                                                                    {
                                                                        title: 'DAL / <?php the_sub_field('time'); ?>',
                                                                        start: '<?php the_sub_field('date');?>',
                                                                        url: '<?php the_sub_field('buy_url'); ?>',
                                                                        className: 'out_of_stock'
                                                                        // Use in ClassName when site is turned back on for sales:
                                                                        //<php the_sub_field('availability');?>
                                                                    },
                                                            <?php }
                                                            }
                                                        }?>

                                                        <?php if (have_rows('fort_worth')) {
                                                            while (have_rows('fort_worth')){ 
                                                                the_row();
                                                                $orgDate = get_sub_field('date'); // Get Date from ACF
                                                                $eventDate = strtotime($orgDate); // Create UNIX Timestamp for ACF Field
                                                                if ( $today <= $eventDate ) { // Compare Today's Date to Event Date
                                                            ?>
                                                                    {
                                                                        title: 'FW / <?php the_sub_field('time'); ?>',
                                                                        start: '<?php the_sub_field('date');?>',
                                                                        url: '<?php the_sub_field('buy_url'); ?>',
                                                                        className: 'out_of_stock'
                                                                    },
                                                            <?php }
                                                            }
                                                        }?>

                                                    ]
                                                });
                                                var num = 1;

                                                function calendarRender() {
                                                    calendar.render()
                                                }

                                                jQuery('#calendar-tab').on('click', function () {
                                                    setTimeout(calendarRender, 200);

                                                    num++;
                                                })
                                                jQuery('.out_of_stock').on('click', function (e) {
                                                    e.preventDefault();
                                                })

                                            });

                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            <?php } ?>
            <section class="additional_links">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="links">
                                <a href="<?php the_field('security_policy_url'); ?>" target="_blank" class="link_hover_black">
                                    BASS HALL SECURITY POLICY >
                                </a>

                                <a href="<?php the_field('return_policy_url'); ?>" class="link_hover_black">
                                    RETURN POLICY >
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>

        <?php endif; //End statement if performance has passed or not ?>


        <?php /// Staff ?>
        <?php if (have_rows('staff_info')) { ?>

            <section class="staff_block">
                <div class="container">
                    <div class="row">
                        <?php while (have_rows('staff_info')) {
                            the_row(); ?>
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="single_person">
                                    <div class="position">
                                        <?php the_sub_field('position'); ?>
                                    </div>
                                    <div class="name">
                                        <?php the_sub_field('name'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <?php
        } ?>


        <?php /// gallery?>
        <section class="gallery">
            <div class="container">
                <div class="row">
                        <?php
                        $images = get_field('image_gallery');
                        $size = 'full'; // (thumbnail, medium, large, full or custom size)
                        if ($images): ?>
                            <div class="performance_gallery">
                                <?php foreach ($images as $image_id): ?>
                                    <div class="item">
                                        <a href="<?= $image_id['url'] ?>" data-toggle="lightbox" data-gallery="performance-gallery" data-title="<?= get_the_title(); ?>">
                                            <img src="<?= $image_id['url'] ?>" alt="" class="img-fluid">
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                </div>
            </div>
        </section>


        <section class="posts_navigation">
                
            <? // COUNT PAGE OFFSET
            $count = 1;
            $page = get_post_field( 'menu_order', $currentId);
            if (($page < 5) AND ($today<=$endTimestamp)) {
                $offset = ( $page - 1) * $count;

            ?>
            
                <div class="nav_col browse_all">
                    <a href="<?= $singleSeasonName[0]->slug ?>" class="link_hover_black">
                        <svg id="Component_14_1" data-name="Component 14 – 1" xmlns="http://www.w3.org/2000/svg" width="14"
                            height="14" viewBox="0 0 14 14">
                            <g id="Group_448" data-name="Group 448">
                                <rect id="Rectangle_307" data-name="Rectangle 307" width="4" height="4" rx="2"/>
                                <rect id="Rectangle_310" data-name="Rectangle 310" width="4" height="4" rx="2"
                                    transform="translate(0 5)"/>
                                <rect id="Rectangle_313" data-name="Rectangle 313" width="4" height="4" rx="2"
                                    transform="translate(0 10)"/>
                                <rect id="Rectangle_308" data-name="Rectangle 308" width="4" height="4" rx="2"
                                    transform="translate(5)"/>
                                <rect id="Rectangle_311" data-name="Rectangle 311" width="4" height="4" rx="2"
                                    transform="translate(5 5)"/>
                                <rect id="Rectangle_314" data-name="Rectangle 314" width="4" height="4" rx="2"
                                    transform="translate(5 10)"/>
                                <rect id="Rectangle_309" data-name="Rectangle 309" width="4" height="4" rx="2"
                                    transform="translate(10)"/>
                                <rect id="Rectangle_312" data-name="Rectangle 312" width="4" height="4" rx="2"
                                    transform="translate(10 5)"/>
                                <rect id="Rectangle_315" data-name="Rectangle 315" width="4" height="4" rx="2"
                                    transform="translate(10 10)"/>
                            </g>
                        </svg>
                        <span>ALL PERFORMANCES</span>
                    </a>
                </div>
                <?
                $posts = get_posts(array(
                    'numberposts' => 1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                    'include' => array(),
                    'exclude' => $currentId,
                    'offset' => $offset,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'season',
                            'field' => 'term_id',
                            'terms' => $singleSeasonName[0]->term_id,
                        )
                    ),
                    'post_type' => 'perfomance',
                ));
                foreach ($posts as $post) {
                    setup_postdata($post); ?>
                    <div class="nav_col border_exist">
                        <a href="<?= get_the_permalink(); ?>" class="link_hover_black">
                            <?= strip_tags(get_the_title()) ?>&nbsp;&gt;
                        </a>
                    </div>
                
                <?php  }

                wp_reset_postdata(); ?>


                
                <div class="nav_col">
                    <?
                    $posts = get_posts(array(
                        'numberposts' => 1,
                        'orderby' => 'menu_order',
                        'order' => 'ASC',
                        'include' => array(),
                        'exclude' => $currentId,
                        'offset' => $offset + 1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'season',
                                'field' => 'term_id',
                                'terms' => $singleSeasonName[0]->term_id,
                            )
                        ),
                        'post_type' => 'perfomance',
                    ));

                    foreach ($posts as $post) {
                        setup_postdata($post); ?>
                        <a href="<?= get_the_permalink(); ?>" class="link_hover_black">
                            <?= strip_tags(get_the_title()) ?>&nbsp;&gt;
                        </a>
                    <?php }

                    wp_reset_postdata();?>
                </div>
            <?php }

            else { ?>
                <div class="nav_col browse_all" style="flex: 0 0 100%;">
                    <a href="/season/<?= $singleSeasonName[0]->slug ?>" class="link_hover_black">
                        <svg id="Component_14_1" data-name="Component 14 – 1" xmlns="http://www.w3.org/2000/svg" width="14"
                            height="14" viewBox="0 0 14 14">
                            <g id="Group_448" data-name="Group 448">
                                <rect id="Rectangle_307" data-name="Rectangle 307" width="4" height="4" rx="2"/>
                                <rect id="Rectangle_310" data-name="Rectangle 310" width="4" height="4" rx="2"
                                    transform="translate(0 5)"/>
                                <rect id="Rectangle_313" data-name="Rectangle 313" width="4" height="4" rx="2"
                                    transform="translate(0 10)"/>
                                <rect id="Rectangle_308" data-name="Rectangle 308" width="4" height="4" rx="2"
                                    transform="translate(5)"/>
                                <rect id="Rectangle_311" data-name="Rectangle 311" width="4" height="4" rx="2"
                                    transform="translate(5 5)"/>
                                <rect id="Rectangle_314" data-name="Rectangle 314" width="4" height="4" rx="2"
                                    transform="translate(5 10)"/>
                                <rect id="Rectangle_309" data-name="Rectangle 309" width="4" height="4" rx="2"
                                    transform="translate(10)"/>
                                <rect id="Rectangle_312" data-name="Rectangle 312" width="4" height="4" rx="2"
                                    transform="translate(10 5)"/>
                                <rect id="Rectangle_315" data-name="Rectangle 315" width="4" height="4" rx="2"
                                    transform="translate(10 10)"/>
                            </g>
                        </svg>
                        <span>BROWSE ALL</span>
                    </a>
                </div>
            <?php } ?>            
        </section>
    </section>


    <script>

        var firtsTab = jQuery('#myTab .nav-item')[0];
        var firstContent = jQuery('#myTabContent .tab-pane')[0]

        jQuery(firtsTab).find('a').addClass('active');
        jQuery(firstContent).addClass('active show');
    </script>
<?php
get_footer();
