<?php
  list($app, $config) = init();

  $_posts = $app->loader('posts');
  $published_date = get_the_date('Y-m-d') . 'T' . get_the_date('H:i:s');
?>
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php
    echo $_posts->hentry();
  ?>
  <div class="entry-content" itemprop="suggestedAnswer acceptedAnswer" itemscope itemtype="http://schema.org/Answer">
    <div itemprop="text">
      <?php
        the_content();
      ?>
    </div>
    <span itemprop="dateCreated" class="hidden"><?php echo $published_date; ?></span>
    <span itemprop="upvoteCount" class="hidden">1</span>
    <div itemprop="author" itemscope itemtype="http://schema.org/Person">
      <meta itemprop="name" content="<?php echo $config->read('company/name') ?>">
    </div>
    <a itemprop="url" href="<?php echo get_permalink(); ?>" class="hidden">Answer Link</a>
  </div>
</div>