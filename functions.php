<?php  

function pageBanner($args = NULL) {


    if(!$args['title']){
        $args['title'] = get_the_title();
    }

    if(!$args['subtitle']){
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

        if(!$args['photo']){
            if(get_field('page_banner_background_image')){
                $args['photo'] = get_field('page_banner_background_image') ['sizes'] ['pageBanner'];
            }        
            else{
                $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
            }
        }

    // Set default values
    $defaults = array(
        'title' => get_the_title(),
        'subtitle' => get_field('page_banner_subtitle'),
        'photo' => get_field('page_banner_background_image')
    );

    // Merge default values with provided arguments
    $args = wp_parse_args($args, $defaults);

    // Ensure 'photo' is always an array with the 'sizes' key
    if (!$args['photo']) {
        $args['photo'] = array(
            'sizes' => array(
                'pageBanner' => get_template_directory_uri() . '/path/to/default-image.jpg' // Replace with the path to your default image
            )
        );
    }

    // Output the banner HTML
    ?>
<div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?> )"></div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
          <p><?php echo $args['subtitle']; ?></p>
        </div>
      </div>
    </div>
<?php }



function  university_files(){
    wp_enqueue_script('main-univerdity-js', get_theme_file_uri('build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
    // wp_enqueue_style('custom-font-glinte', get_theme_file_uri('/webfonts/Glinte.ttf'), array(), '1.0');
    // wp_enqueue_style('university_extra_font', get_theme_file_uri('/build/fonts.css'));

}

add_action('wp_enqueue_scripts', 'university_files');

function university_features(){
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    // register_nav_menu('footerLocationOne', 'Footer Location One');
    // register_nav_menu('footerLocationTwo', 'Footer Location Two');
     add_theme_support('title-tag');
     add_theme_support('post-thumbnails');
     add_image_size('professorLandscape',400, 260, true);
     add_image_size('professorPortrait',480, 650, true);
     add_image_size('pageBanner',1500, 350, true);


}

add_action('after_setup_theme', 'university_features');


    function university_adjust_queries($query) {
        if (!is_admin() && $query->is_main_query() && is_post_type_archive('program')){
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');  
            $query->set('posts_per_page', -1);
        }




        // Check if it's the main query and if we're on the events archive page
        if (!is_admin() && $query->is_main_query() && is_post_type_archive('event')) {
            $today = date('Ymd');
            $query->set('posts_per_page', -1); // Adjust this number to limit events per page
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                )
            ));
        }
    }


add_action('pre_get_posts','university_adjust_queries');