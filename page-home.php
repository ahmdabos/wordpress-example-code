<?php
/**
 * Template Name: Home
 */

get_header();
?>
    <!-- Banner -->
    <section class="home-banner" data-aos="fade-up" data-aos-duration="700" data-aos-delay="800">
        <div class="main-banner owl-carousel owl-theme">
            <?php
            $slider_args = array(
                'post_type' => 'sliders',
                'post_status' => 'publish',
                'posts_per_page' => 5,
                'order' => 'DESC',
                'orderby' => 'menu_order'
            );
            $slider_query = new WP_Query($slider_args);
            ?>
            <?php
            if ($slider_query->have_posts()) :
                while ($slider_query->have_posts()) :
                    $slider_query->the_post();
                    ?>
                    <div class="item">
                        <div class="banner-wrap">
                            <div class="container">
                                <div class="banner-content">
                                    <h1><?php the_title(); ?></h1>
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                        <img class="banner-img" src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>" title="<?php the_title() ?>"/>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <div class="particle-network-animation"></div>
    </section>
    <!-- about -->
    <section class="home-about" data-aos="fade-up" data-aos-duration="700" data-aos-delay="800">
        <div class="container">
            <div class="row column-reverse">
                <?php
                $about_args = array(
                    'post_type' => 'page',
                    'posts_per_page' => 1,
                    'post__in' => array(320)
                );
                $about_query = new WP_Query($about_args);
                if ($about_query->have_posts()) : ?>
                    <?php while ($about_query->have_posts()) : $about_query->the_post(); ?>
                        <div class="col-lg-6 col-md-12">
                            <div class="about-wrap focus-content box-f box-r-40">
                                <p class="bold"><?php the_excerpt(); ?></p>
                                <div class="action-wrap">
                                    <a href="<?php the_permalink(); ?>" class="action-box"><?php _t('read_more') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="about-wrap about-title box-f box-l-40">
                                <h2 class="title-wrap"><?php the_title() ?></h2>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <!-- news -->
    <section class="news-sec" data-aos="fade-up" data-aos-duration="700" data-aos-delay="800">
        <div class="container">
            <div class="head-top">
                <h2 class="title"><?php _t('news') ?></h2>
                <div class="action-wrap">
                    <a href="<?php if (get_locale() == 'en') {
                        echo get_permalink('312');
                    } else {
                        echo get_permalink('383');
                    } ?>" class="action-box"><?php _t('view_all') ?></a>
                </div>
            </div>
            <?php
            $news_args = array(
                'post_type' => 'news',
                'post_status' => 'publish',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC',
            );
            $news_query = new WP_Query($news_args);
            ?>
            <div class="news-show">
                <div class="row">
                    <?php
                    if ($news_query->have_posts()):
                        while ($news_query->have_posts()):
                            $news_query->the_post();
                            ?>
                            <?php
                            if ($news_query->current_post == 0) {
                                ?>
                                <div class="col-xl-4 col-lg-4 col-md-12 ">
                                    <div class="news-card left">
                                        <div class="news-img">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                                            </a>
                                        </div>
                                        <div class="news-content">
                                            <div class="top">
                                                <div class="date"><span><?php _t('published_on') ?>&nbsp;<?php echo " "; ?><?php echo get_the_date() ?></span></div>
                                                <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
                                                <p><?php the_excerpt(); ?></p>
                                            </div>
                                            <div class="bottom">
                                                <div class="action-link">
                                                    <a href="<?php the_permalink(); ?>" class="action-box"><?php _t('read_more') ?></a>
                                                </div>
                                                <div class="card-action">
                                                    <ul>
                                                        <!--<li>
                                                            <a href="#">
                                                                <i class="fi-like"> </i>
                                                                <span>Like</span>
                                                            </a>
                                                        </li>-->
                                                        <li>
                                                            <a href="#" class="share">
                                                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                                                    <a class="a2a_dd action sub secondary right" href="https://www.addtoany.com/share" title="<?php echo _t('share') ?>"><i class="fi-share"></i> </a>
                                                                </div>
                                                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($news_query->current_post == 1) { ?>
                            <div class="col-xl-8 col-lg-8 col-md-12 ">
                            <div class="news-card mb-4">
                                <div class="row g-0 column-reverse">
                                    <div class="col-xl-6 col-lg-6 col-md-12 ">
                                        <div class="news-content">
                                            <div class="top">
                                                <div class="date"><span><?php _t('published_on') ?><?php echo " "; ?><?php echo get_the_date() ?></span></div>
                                                <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
                                                <p><?php the_excerpt(); ?></p>
                                            </div>
                                            <div class="bottom">
                                                <div class="action-link">
                                                    <a href="<?php the_permalink(); ?>" class="action-box"><?php _t('read_more') ?></a>
                                                </div>
                                                <div class="card-action">
                                                    <ul>
                                                        <!--<li>
                                                            <a href="#">
                                                                <i class="fi-like"> </i>
                                                                <span>Like</span>
                                                            </a>
                                                        </li>-->
                                                        <li>
                                                            <a href="#" class="share">
                                                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                                                    <a class="a2a_dd action sub secondary right" href="https://www.addtoany.com/share" title="<?php echo _t('share') ?>"><i class="fi-share"></i> </a>
                                                                </div>
                                                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 ">
                                        <div class="news-img">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                            <?php if ($news_query->current_post == 2) { ?>
                            <div class="news-card">
                                <div class="row g-0">
                                    <div class="col-xl-6 col-lg-6 col-md-12 ">
                                        <div class="news-img">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 ">
                                        <div class="news-content">
                                            <div class="top">
                                                <div class="date"><span><?php _t('published_on') ?><?php echo " "; ?><?php echo get_the_date() ?></span></div>
                                                <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
                                                <p><?php the_excerpt(); ?></p>
                                            </div>
                                            <div class="bottom">
                                                <div class="action-link">
                                                    <a href="<?php the_permalink(); ?>" class="action-box"><?php _t('read_more') ?></a>
                                                </div>
                                                <div class="card-action">
                                                    <ul>
                                                        <!-- <li>
                                                             <a href="#">
                                                                 <i class="fi-like"> </i>
                                                                 <span>Like</span>
                                                             </a>
                                                         </li>-->
                                                        <li>
                                                            <a href="#" class="share">
                                                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                                                    <a class="a2a_dd action sub secondary right" href="https://www.addtoany.com/share" title="<?php echo _t('share') ?>"><i class="fi-share"></i> </a>
                                                                </div>
                                                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php } ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section>
  
    <section class="social-sec" data-aos="fade-up" data-aos-duration="700" data-aos-delay="800">
        <div class="container">
            <h2 class="title"><?php _t('social_media_feed') ?></h2>
            <p><?php _t('we_share_our_news_on_social_media') ?></p>
            <div class="feeds-show">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-6 col-md-12 ">
                        <a class="twitter-timeline" data-height="550" href="https://twitter.com/DCDigiEconomy?ref_src=twsrc%5Etfw"><?php _t('tweets_by_dubaichambers_digital') ?></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <div><?php the_content(); ?></div>
<?php
get_footer();