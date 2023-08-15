<?php include "sub-header.php" ?>
<h2 class="sub-title"><?php single_cat_title(' '); ?></h2>
  <div class="sub-desc">
  <?php echo category_description(); ?>
  </div>
  
  <ul>
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>   
  <li> 
  <?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); } ?>
  <?php the_title(); ?>
  <?php echo get_the_author(); ?>
  <?php echo get_the_date(); ?> <?php echo get_the_time(); ?>
  <?php the_excerpt(); ?>
  <a href="<?php the_permalink(); ?>">해당글 보기</a>
  </li>
  <?php endwhile; else: ?>
  <?php endif; ?>
  </ul>

  <?php
    global $wp_query;
    $big = 999999999;
    echo paginate_links( array(
      'type'        => 'list',
      'base'        => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
      'format'      => '?paged=%#%',
      'current'     => max( 1, get_query_var('paged') ),
      'total'       => $wp_query->max_num_pages,
      'prev_text'   => __('<'),
      'next_text'   => __('>'),
      ) );
      ?>
 <?php include "sub-footer.php" ?>
