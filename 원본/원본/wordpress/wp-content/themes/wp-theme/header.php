<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
  <title><?php bloginfo('name'); ?> <?php wp_title('|'); ?></title>
  <?php wp_head(); ?> <!-- 이 아래쪽으로 작성해주자 ! -->

  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/reset.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/style.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/header.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/footer.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/sub.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/category.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/single.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/wp-member.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ultimate-faqs.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/contact-form-7.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/page-intro.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/page-greet.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/page-location.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/page-area.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/carousel.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/flipBook.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/home.css">
  <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/loader.css">

  <script src="https://kit.fontawesome.com/a45f44bad8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/type_effect.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/particles.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/carousel_3d.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/flipBook.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/common.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/ultimate-faqs.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/masonry-docs.min.js"></script>
  <script src="<?php bloginfo('template_directory'); ?>/js/jquery.ripples-min.js"></script>
</head>

<body <?php body_class(); ?>>
  <?php include "loader.php"?>
  <script src="<?php bloginfo('template_directory'); ?>/js/header.js"></script>

  <header>
    <div class="top">
      <?php include "member.php" ?>
    </div>

    <div class="center">
      <h1>
        <span class="hidden"> 워드프레스</span>
        <a href="<?php bloginfo('url'); ?>">
          <img src="<?php bloginfo('template_directory'); ?>/img/icon/logo.png" alt="">
        </a>
      </h1>

      <nav class="gnb gnb-lg">
        <?php wp_nav_menu(array('theme_location' => 'menu')); ?>
      </nav>

      <nav class="gnb gnb-sm">
        <video src="<?php bloginfo('template_directory'); ?>/video/nav.mp4" muted></video>
        <span id="particles-js-star"></span>
        <h6>Wordpress</h6>
        <?php wp_nav_menu(array('theme_location' => 'menu')); ?>

        <button class="mbtn mbtn-close">
          <i class="fa-solid fa-xmark"></i>
        </button>

      </nav>

      <button class="mbtn mbtn-open">
        <i class="fa-solid fa-bars-staggered"></i>
      </button>

    </div>

  </header>

  <svg style='display:none;'>
    <filter id="filter">
      <feTurbulence id="water" numOctaves="3" seed="1" baseFrequency="0.02 0.5" />
      <feDisplacementMap scale="10" in="SourceGraphic" />
      <animate href="#water" attributeName="baseFrequency" keyTimes="0;0.5;1" values="0.002;0.008;0.002" dur="10s" repeatCount="indefinite" />
    </filter>
  </svg>