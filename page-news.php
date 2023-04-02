<!--
This is part of a WordPress custom theme. The script generates the structure and layout of the news section, including a search form, pagination, and other elements. I used AJAX to fetch news articles from the WordPress REST API based on user input and displays the results on the page. It also includes a feature to "like" news articles and store the likes in Database.

Here's a general overview of the various parts of the script:

PHP code: The PHP code generates the HTML structure of the news section and includes WordPress functions to fetch and display data from the database, such as the header, post title, featured image, and more.

JavaScript/jQuery code: This script is responsible for handling user interactions, such as searching, pagination, and liking news articles. It makes AJAX requests to fetch news articles based on user input and updates the page's content accordingly.

Additional JavaScript code: The last part of the script deals with the "like" feature for news articles. It stores the user's likes in cookies and updates the like count for the article in the database then show it again to the users.
-->

<?php
/**
 * Template Name: News
 */
get_header();

?>

<section class="inner-content news" data-aos="fade-up" data-aos-duration="600" data-aos-delay="1000">
    <div class="subpage-banner">
        <div class="banner-highlights" <?php if (get_field('page_header_image')) { ?> style="background-image: url(<?php echo get_field('page_header_image'); ?>) ;"<?php } ?>>
            <div class="dc-breadcrumb" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                <div class="container">
                    <?php \Functions\start::breadcrumbs(); ?>
                </div>
            </div>
            <div class="container">
                <div class="card-title">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 col-12">
                            <div class="title right-space" data-aos="fade-up" data-aos-duration="600"
                                 data-aos-delay="1200">
                                <h1><?php the_title(); ?></h1>
                            </div>
                        </div>
                    </div>

                    <form action="" class=" search-form active">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <input type="text" value="" class="form-control" id="search" placeholder="<?php _t('keyword'); ?>">
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-3">
                                <select class="form-select" id="categories">
                                    <option value=" "><?php _t('category'); ?></option>
                                    <?php
                                    $news_args = array(
                                        'taxonomy' => 'news_category',
                                        'orderby' => 'count',
                                        'order' => 'DESC',
                                        'hide_empty' => true,
                                    );
                                    $news_query = new WP_Term_Query($news_args);
                                    foreach ($news_query->get_terms() as $term) {
                                        ?>
                                        <option value="<?php echo $term->term_id ?>">
                                            <?php echo $term->name ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-2">
                                <div class="date-wrap">
                                    <input class="form-control date-field datepicker_5" id="datepickerFrom" value="" placeholder="<?php _t('from'); ?>">
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-2">
                                <div class="date-wrap">
                                    <input class="form-control date-field datepicker_6" id="datepickerTo" value="" placeholder="<?php _t('to'); ?>">
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-2">
                                <button class="submit-btn" id="submit"> <?php _t('search'); ?> <i class="fi-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="news-content-box">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="news-banner-box" data-aos="fade-up" data-aos-duration="600" data-aos-delay="1200" id="topStory">
                            <div class="owl-carousel news-banner-slider">
                                <?php
                                $highlighted_args = array(
                                    'post_type' => 'news',
                                    'posts_per_page' => 5,
                                    'orderby' => 'post_date',
                                    'order' => 'DESC',
                                    'post_status' => 'publish',
                                    'meta_query' => array(
                                        array(
                                            'key' => 'news_top_story',
                                            'value' => 'yes',
                                            'compare' => 'LIKE',
                                        ),
                                    ),
                                );
                                $highlighted_query = new WP_Query($highlighted_args);
                                if ($highlighted_query->have_posts()) :
                                    while ($highlighted_query->have_posts()) :
                                        $highlighted_query->the_post();
                                        $news_likes = (float)get_field('news_likes');
                                        ?>
                                        <div class="item">
                                            <span class="newsTopStory" data-id="<?php the_ID(); ?>"></span>
                                            <div class="img-box">
                                                <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title() ?>" title="<?php the_title() ?>">
                                                <a href="<?php the_permalink() ?>" class="sec-desc">
                                                    <?php the_title() ?>
                                                </a>
                                            </div>
                                            <div class="detail-box">
                                                <div class="date">
                                                    <span><?php echo get_the_date('d') ?></span>
                                                    <?php echo get_the_date('M') ?> <br/>
                                                    <?php echo get_the_date('Y') ?>
                                                </div>
                                                <a href="#" class="share">
                                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                                        <a class="a2a_dd action sub secondary right" href="https://www.addtoany.com/share" title="<?php echo _t('share') ?>"><i class="fi-share"></i>
                                                        </a>
                                                    </div>
                                                    <script async src="https://static.addtoany.com/menu/page.js"></script>
                                                </a>


                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </div>
                        </div>
                        <div class="news-list-wrap" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200" id="listing">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="pagination-wrap" id="pagination-wrapper">
                        <div class="left">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Previous" id="previous-item" title="<?php _t('previous'); ?>">
                                            <i class="fi-arrow-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <input type="text" class="current-page" data-toggle="current" value="1" id="enter-page-number">
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0)" aria-label="Next" id="next-item" title="<?php _t('next'); ?>">
                                            <i class="fi-arrow-right"></i><span style="display:none">i</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <?php _t('of'); ?> &nbsp;<span id="total-pages"></span>
                        </div>
                        <div class="right">
                            <div class="total">
                                <?php _t('total_items'); ?>: <span id="total-items"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>

<script>
    jQuery(document).ready(function ($) {
        var newsToExclude = [];
        $('.newsTopStory').each(function () {
            newsToExclude.push($(this).data('id'))
        })
        var lang = 'en', noItems = 'No results found!', read_more = 'Read more', search = '', page = 1, news_category = ' ', from_date = '1990-01-01T00:00:00', to_date = '2030-01-01T00:00:00';
        if (window.location.href.indexOf('/en/') !== -1) {
            lang = 'en';
            noItems = 'No results found!';
            read_more = 'Read more';
        } else {
            lang = 'ar';
            noItems = 'لم يتم العثور على نتائج!';
            read_more = 'إقرأ المزيد';
        }

        $("#submit").on("click", function (e) {
            e.preventDefault();
            search = $('#search').val();
            news_category = $('#categories').val();
            if ($('#datepickerFrom').val()) {

                var dateFrom = $('#datepickerFrom').val();
                var dateFrom_ = dateFrom.split("-").reverse().join("-")
                from_date = dateFrom_ + 'T00:00:00';
                console.log(from_date);
            } else {
                from_date = '1990-01-01T00:00:00';
            }
            if ($('#datepickerTo').val()) {
                var dateTo = $('#datepickerTo').val();
                var dateTo_ = dateTo.split("-").reverse().join("-")
                to_date = dateTo_ + 'T00:00:00';
                console.log(to_date);
            } else {
                to_date = '2030-01-01T00:00:00';
            }
            if ($('#search').val() == '' && $('#datepickerFrom').val() == '' && $('#datepickerTo').val() == '' && $('#categories').val() == ' ') {
                $('#topStory').show();
                $('.newsTopStory').each(function () {
                    newsToExclude.push($(this).data('id'))
                })
            } else {
                $('#topStory').hide();
                newsToExclude = [];
            }
            getListing(search, news_category, page, from_date, to_date);

        });
        if (window.location.href.indexOf("archive") > -1) {
            $("#datepickerTo").val('2019-12-31');
            $("#submit").trigger('click');
        }
        getListing(search, news_category, page, from_date, to_date);

        function getListing(search, news_category, page, from_date, to_date) {
            var content = '', featuredmedia = '';
            var request = $.ajax({
                url: '/wp-json/wp/v2/news?_embed&search=' + search + '&news_category=' + news_category + '&exclude=' + newsToExclude + '&after=' + from_date + '&before=' + to_date + '&orderby=' + 'date' + '&order=desc&per_page=9&page=' + page + '&lang=' + lang,
                method: "GET",
                dataType: "json",
                async: false,
            });
            request.done(function (data, textStatus, jqXHR) {
                if (data.length > 0) {
                    $('#pagination-wrapper').show();
                    console.log(data);
                    $.each(data, function (index, value) {
                        if (value.featured_media !== 0) {
                            featuredmedia = value._embedded["wp:featuredmedia"][0].source_url;
                        } else {
                            featuredmedia = '';
                        }
                        content +=
                            '<div class="news-list">' +
                            '<div class="img-box">' +
                            '<img src="' + featuredmedia + '" alt="' + value.title.rendered + '" title="' + value.title.rendered + '">' +
                            '</div>' +
                            '<div class="content-box">' +
                            '<div class="date">' + formatDate(value.date) + '</div>' +
                            '<a href="' + value.link + '" class="sec-title">' + value.title.rendered + '</a>' +
                            '<p class="sec-desc">' + value.excerpt.rendered + '</p>' +
                            '<a href="' + value.link + '" class="action-btn">' + read_more + ' <i class="fi-arrow-right"></i></a>' +
                            '</div>' +
                            '</div>';
                    });
                    $('#listing').html(content);
                    var show_per_page = 9;
                    var number_of_items = jqXHR.getResponseHeader("X-WP-Total");
                    var number_of_pages = Math.ceil(number_of_items / show_per_page);
                    $('.current-page').text(page);
                    $('#total-pages').text(number_of_pages);
                    $('#total-items').text(number_of_items);
                    $('#listing').children().css('display', 'none');
                    $('#listing').children().slice(0, show_per_page).css('display', 'flex');
                } else {
                    $('#pagination-wrapper').hide();
                    $('#listing').html(noItems);
                }
            });
            request.fail(function (jqXHR, textStatus) {
                console.log(textStatus)
            });

        }

        $(document).on("change", "#enter-page-number", function () {
            go_to_page($(this).val())
        });
        $(document).on("click", "#first-item", function () {
            first();
        });
        $(document).on("click", "#previous-item", function () {
            previous();
        });
        $(document).on("click", "#next-item", function () {
            next();
        });
        $(document).on("click", "#last-item", function () {
            last();
        });

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();
            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;
            return [day, month, year].join('-');
        }

        function go_to_page(page_num) {
            $('#enter-page-number').val(page_num);
            page_num = parseInt(page_num);
            var show_per_page = parseInt($('#show_per_page').val(), 0);
            start_from = page_num * show_per_page;
            end_on = start_from + show_per_page;
            $('#listing').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');
            getListing(search, news_category, page_num, from_date, to_date);
            $("html, body").animate({scrollTop: "500"}, 1000);
        }

        function previous() {
            var currentPage = parseInt($('.current-page').text());
            if (currentPage > 1)
                go_to_page(currentPage - 1);
        }

        function next() {
            var currentPage = parseInt($('.current-page').text());
            var totalPages = parseInt($('#total-pages').text());
            if (currentPage < totalPages)
                go_to_page(currentPage + 1);
        }

        function first() {
            go_to_page(1);
        }

        function last() {
            var totalPages = parseInt($('#total-pages').text());
            go_to_page(totalPages);
        }
    });
</script>

<script>
    jQuery(document).ready(function ($) {
        $('.likeNews').each(function () {
            var newsId = $(this).data('newsid');
            var likeNewsCookie = getCookie("like_news_" + newsId);
            if (likeNewsCookie == "1") {
                $(this).find('i').removeClass();
                $(this).find('i').addClass('fi-like-fill')
            }
            if (likeNewsCookie == "0" || !likeNewsCookie) {
                $(this).find('i').removeClass();
                $(this).find('i').addClass('fi-like')
            }
        });

        $('.likeNews').on('click', function () {

            var newsId = $(this).data('newsid');
            if ($(this).find('i').hasClass('fi-like')) {
                console.log('newsId' + newsId);
                setCookie("like_news_" + newsId, "1", 1000);
                $(this).find('i').removeClass('fi-like');
                $(this).find('i').addClass('fi-like-fill')

                $.ajaxSetup({
                    beforeSend: function (xhr, options) {
                        options.url = window.location.href;
                    }
                });
                var ajaxurl = window.location.href, data = {'newsIdSet': newsId};
                $.post(ajaxurl, data, function (response) {
                    console.log(response);
                });


            } else {
                setCookie("like_news_" + newsId, "0", 1000);
                $(this).find('i').removeClass('fi-like-fill');
                $(this).find('i').addClass('fi-like')


                $.ajaxSetup({
                    beforeSend: function (xhr, options) {
                        options.url = window.location.href;
                    }
                });
                var ajaxurl1 = window.location.href, data1 = {'newsIdRemove': newsId};
                $.post(ajaxurl1, data1, function (response) {

                });
            }
        });

        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }


    });
</script>
<?php get_footer(); ?>



