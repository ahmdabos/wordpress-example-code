<?php
$requires = ['Base.php', 'Start.php', 'CustomPostType.php', 'CustomTaxonomy.php', 'TwitterAPIExchange.php'];
foreach ($requires as $require) {
    require get_template_directory() . '/inc/' . $require;
}
use Functions\{Base, Start, CustomPostType, CustomTaxonomy};
$customPostTypesList = array(
    array(
        'singular_name' => 'slider',
        'plural_name' => 'sliders',
        'slug' => 'events',
        'menu_position' => 19,
        'supports' => ['title', 'thumbnail', 'revisions', 'page-attributes', 'editor'],
        'taxonomies' => []
    ),
    array(
        'singular_name' => 'event',
        'plural_name' => 'events',
        'slug' => 'events',
        'menu_position' => 19,
        'supports' => ['title', 'thumbnail', 'revisions', 'page-attributes', 'excerpt', 'editor'],
        'taxonomies' => []
    ),
    array(
        'singular_name' => 'news',
        'plural_name' => 'news',
        'slug' => 'news',
        'menu_position' => 19,
        'supports' => ['title', 'thumbnail', 'revisions', 'page-attributes', 'excerpt', 'editor'],
        'taxonomies' => []
    )
);
$customTaxonomyList = array();
$base = new Base();
$start = new Start();
$customPostType = new CustomPostType();
$customTaxonomy = new CustomTaxonomy();
$base->register();
$start->register();
$customPostType->createCustomPostType($customPostTypesList);
$customTaxonomy->createCustomTaxonomy($customTaxonomyList);