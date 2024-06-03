<?php  
get_header();
while(have_posts()){
    the_post();
    
    pageBanner(array(
      'title'=> 'Hello this is a title',
      'subtitle'=> 'Hello this is a subtitle',
      // 'photo'=> 'https://www.hdwallpapers.in/download/clouds_grass_field_trees_blue_sky_nature_wallpaper_background_4k_hd_nature-2560x1440.jpg'

    )); 
    ?>
   

    <div class="container container--narrow page-section">
<?php 
$theParent = wp_get_post_parent_id(get_the_ID());
if($theParent) { //wp_get_post_parent_id(get_the_ID()) is se hamain parent ki id mil rhi h and if id is 0 so condition will false and not exute and if id is greater than 0 if statement will execute.
    ?>
    
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php  echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php  echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php echo the_title(); ?></span>
        </p>
      </div>
<?php
}
?>
<?php 
$testArray = get_pages(array(
    'child_of'=> get_the_ID(),
))
?>

<?php if($theParent or $testArray){ ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
        <ul class="min-list">
          <?php 
          if($theParent){
            $findChildrenOf = $theParent;

          }
          else{
            $findChildrenOf = get_the_ID();
          }
          wp_list_pages(array(
            'title_li' => NULL,
            'child_of' => $findChildrenOf,
            'sort_column' => 'menu_order',
          ))
          
          ?>
        </ul>
      </div>
      <?php } ?>

      <div class="generic-content">
      <?php the_content() ?>
      </div>
    </div>
    
    
    
    <?php }
get_footer();

?>