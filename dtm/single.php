<?php
  get_header();

  $layout = $app->loader('layout');
  $titlebar = $app->loader('titlebar');
  $_posts = $app->loader('posts');

  if(!in_category(3)){
    echo $titlebar->get_title_bar();
  }
?>
<?php
  if(!in_category(3)){
?>
<div class="sec <?php echo $layout->get_sc_layout()['section']; ?>">
  <div id="main-content" class="<?php echo $layout->get_sc_layout()['container']; ?>">
    <div class="gi-row">
      <?php if($layout->get_layout()['sidebar_left_show']): ?>
        <div class="sidebar-left <?php echo $layout->get_layout()['sidebar_col']; ?>">
          <?php get_sidebar(); ?>
        </div>
      <?php endif;?> 
      <div id="primary" class="content-area <?php echo $layout->get_layout()['primary_col']; ?>">
<?php
  }
?>
        <div id="content" class="site-content" role="main">
          <?php
            while(have_posts()): the_post();
              $post_content_type = 'content';

              if(!empty($_posts->get_post_type())){
                $post_content_type .= '-' . $_posts->get_post_type();
              }

              get_template_part('template-parts/' . $post_content_type, get_post_format());
            endwhile;
          ?>
        </div>
<?php
  if(!in_category(3)){
?>
      </div>
      <?php if($layout->get_layout()['sidebar_right_show']):?>
        <div class="sidebar-right <?php echo $layout->get_layout()['sidebar_col']; ?>">
          <?php get_sidebar();?>
        </div>
      <?php endif;?>
    </div>
  </div>
</div>
<?php
  }
get_footer();