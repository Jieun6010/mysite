<?php include "sub-header.php" ?>
<script src="<?php bloginfo('template_directory'); ?>/js/single.js"></script>

<?php
$category = get_the_category();
$categoryID = $category[0]->cat_ID;
$categoryName = $category[0]->cat_name;
$categoryUrl = get_category_link($category[0]);
$categoryDesc = category_description($category[0]);
?>

<h2 class="sub-title"><?php echo $categoryName ?></h2>

<p class="theme-guide">
  본 컨텐츠는 관리자/글메뉴/글에서 작성되었으며,
  single.php 템플릿을 이용해 수정·편집 하실 수 있습니다.
  <button><i class="fa-solid fa-circle-xmark"></i></button>
</p>

<div class="sub-desc">
  <?php echo category_description($categoryID) ?>
</div>

<section class="single-section">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <dl class="meta">
        <dt>제목</dt>
        <dd><?php the_title(); ?></dd>
        <dt>작성자</dt>
        <dd><?php echo get_the_author(); ?></dd>
        <dt>작성 시간</dt>
        <dd><?php echo get_the_date(); ?></dd>
      </dl>

      <article>
        <?php the_content(); ?>
      </article>

      <nav class="post-nav">
        <?php previous_post_link('%link', '<i class="fa-solid fa-arrow-left"></i>'); ?>
        <a href="<?php echo $categoryUrl; ?>"><i class="fa-solid fa-list"></i></a><!--해당 카테고리 정보를 가져와야 함-->
        <?php next_post_link('%link', '<i class="fa-solid fa-arrow-right"></i>'); ?>
      </nav>

      <?php endwhile; else : ?>
    <?php endif; ?>
</section>

<?php include "sub-footer.php" ?>