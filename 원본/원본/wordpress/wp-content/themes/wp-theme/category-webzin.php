<?php include "sub-header.php" ?>
<script src="<?php bloginfo('template_directory'); ?>/js/category-webzin.js"></script>
<h2 class="sub-title"><?php single_cat_title(' '); ?></h2>
<p class="theme-guide">
  본 컨텐츠는 카테고리로 제작되었으며,
  category-webzin.php템플릿을 이용해 수정·편집 하실 수 있습니다
  <button><i class="fa-solid fa-circle-xmark"></i></button>
</p>
<div class="sub-desc">
  <?php echo category_description(); ?>
</div>
<section class="category-webzin-section">
  <ul>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <li>
          <div class="meta">
            <address><?php echo get_the_author(); ?></address>
            <time><?php echo get_the_date(); ?></time>
            <b><?php single_cat_title(' '); ?></b>
          </div>
          <figure>
            <?php if (has_post_thumbnail()) {
              the_post_thumbnail('thumbnail');
            } ?>
          </figure>
          <div class="textbox">
            <h3><?php the_title(); ?></h3>
            <?php the_excerpt(); ?>
            <a href="<?php the_permalink(); ?>">해당글 보기</a>
          </div>
        </li>
      <?php endwhile;
    else : ?>
    <?php endif; ?>
  </ul>
</section>
<?php
global $wp_query;
$big = 999999999;
echo paginate_links(array(
  'type'        => 'list',
  'base'        => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
  'format'      => '?paged=%#%',
  'current'     => max(1, get_query_var('paged')),
  'total'       => $wp_query->max_num_pages,
  'prev_text'   => __('<i class="fa-solid fa-circle-arrow-left"></i>'),
  'next_text'   => __('<i class="fa-solid fa-circle-arrow-right"></i>'),
));
?>
<?php include "sub-footer.php" ?>