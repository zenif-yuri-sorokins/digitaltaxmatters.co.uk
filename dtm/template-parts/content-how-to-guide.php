<?php
  list($app, $config) = init();

  $_posts = $app->loader('posts');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php
    echo $_posts->hentry();
  ?>
  <div class="entry-body">
    <div class="entry-content">
      <?php
        the_content(sprintf(
          wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'grapefruit'), array('span' => array('class' => array()))),
          the_title('<span class="screen-reader-text">"', '"</span>', false)
        ));
      ?>
    </div>
  </div>
  <div class="post-meta-area">
    <?php
      if(!in_category($config->read('post/exclude_categories'))){
        echo $_posts->share();
        echo $_posts->related_posts();
        echo $_posts->prev_next_post();
      }
    ?>
  </div>
</article>