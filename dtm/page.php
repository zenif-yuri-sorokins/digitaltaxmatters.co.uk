<?php
  get_header();

  $layout = $app->loader('layout');
  $titlebar = $app->loader('titlebar');
  $_posts = $app->loader('posts');

  echo $titlebar->get_title_bar();
?>
<div id="main-content" class="<?php echo $layout->get_layout()['width']; ?>">
  <div class="gi-row">
    <?php if($layout->get_layout()['sidebar_left_show']):?>
      <div class="sidebar-left <?php echo $layout->get_layout()['sidebar_col']; ?>">
        <?php get_sidebar(); ?>
      </div>
    <?php endif; ?>
    <div id="primary" class="content-area <?php echo $layout->get_layout()['primary_col']; ?>">
      <div id="content" class="site-content">
        <?php
          while(have_posts()):
            the_post();
            $post_content_type = 'content';

            if($_posts->get_post_type() != 'normal-page'){
              $post_content_type .= '-' . $_posts->get_post_type();
            }

            get_template_part('template-parts/' . $post_content_type, 'page');
          endwhile;
        ?>
      </div>
    </div>
    <?php if($layout->get_layout()['sidebar_right_show']): ?>
      <div class="sidebar-left <?php echo $layout->get_layout()['sidebar_col'];?>">
        <?php get_sidebar(); ?>
      </div>
    <?php endif;?>
  </div>
</div>
<?php
  get_footer();