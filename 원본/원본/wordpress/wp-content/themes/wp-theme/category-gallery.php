<?php include "sub-header.php" ?>
<script src="<?php bloginfo('template_directory'); ?>/js/category-gallery.js"></script>
<h2 class="sub-title"><?php single_cat_title(' '); ?></h2>
<p class="theme-guide">
  본 컨텐츠는 카테고리로 제작되었으며,
  category-gallery.php 템플릿을 이용해 수정.편집하실 수 있습니다.
  <button><i class="fa-solid fa-circle-xmark"></i></button>
</p>
<section class="category-gallery-section">
  <div class="sub-desc">
    <?php echo category_description(); ?>
  </div>
  <ul>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <li>
          <a href="<?php the_permalink(); ?>">
            <figure>
              <?php if (has_post_thumbnail()) {
                the_post_thumbnail('thumbnail');
              } ?>
              <figcaption>
                <h3><?php the_title(); ?></h3>
                <p><?php the_excerpt(); ?></p>
              </figcaption>
            </figure>
          </a>
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