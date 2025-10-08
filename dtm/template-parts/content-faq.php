<?php
  list($app, $config) = init();

  $_posts = $app->loader('posts');
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php
    echo $_posts->hentry();
  ?>
  <div class="entry-content" itemprop="mainEntityOfPage">
    <?php
      the_content();
    ?>
  </div>
</div>