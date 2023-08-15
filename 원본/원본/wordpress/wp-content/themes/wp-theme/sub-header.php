<?php get_header(); ?>
<script src="<?php bloginfo('template_directory'); ?>/js/sub.js"></script>

<section class="sub-visual">

<script src="<?php bloginfo('template_directory'); ?>/js/app_particle_default.js"></script>
<div id="particles-js"></div>
<div class="breadcrumb">
<?php if(function_exists('bcn_display')){ bcn_display(); }?>
</div>
</section>

<script src = "<?php bloginfo('template_directory'); ?>/js/subVisualStore.js"></script>

<script>
  subVisualArr.forEach((v)=>{
    $(`.sub-visual`).append(`
      <figure class="${v.title}">
        <img src="<?php bloginfo('template_directory');?>${v.imgPath}" alt>
        <figcaption>
          <h6><sapn>${v.title}</sapn></h6>
          <p><sapn>${v.desc}</sapn></p>
        </figcaption>
      </figure>
    `)
  })
</script>

<nav class="snb">
  <?php wp_nav_menu(array('theme_location' => 'menu')); ?>
</nav>

<main class="sub-content">