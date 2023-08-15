<?php include "sub_header.php" ?>
<script src="./js/video.js"></script>
<h2 class="sub_title">홍보영상</h2>
<section class="video_section">
  <p class="site_guide">
    유튜브 API를 이용하여 영상갤러리 페이지를 설계하였습니다.
    <button>
      <i class="fa-solid fa-circle-xmark"></i>
    </button>
  </p>

  <p class="sub_desc">
    <em class="emphasis">자사의 홍보영상 갤러리입니다.</em>
  </p>

  <article class="video">
    <!--
  zGXGA1dMYu4
  lH8ift_hyW4
  xeJA507xL8I
  Ls_BzmUzSQo
  eGv6ju_5egA
  SH25ChTfELc
  RSk0SnWotEs
  8-ciXzckzhI    -->
    <div class="youtube_wrap">
      <!-- before : padding-top (56.25%) -->
      <iframe src="https://www.youtube.com/embed/zGXGA1dMYu4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>

    <ul class="video_list">
      <li>
        <button class="active" value="zGXGA1dMYu4">
        <img src="https://img.youtube.com/vi/zGXGA1dMYu4/default.jpg" alt="">
        </button>
      </li>

      <li>
        <button value="lH8ift_hyW4">
        <img src="https://img.youtube.com/vi/lH8ift_hyW4/default.jpg" alt="">
        </button>
      </li>

      <li>
        <button value="xeJA507xL8I">
        <img src="https://img.youtube.com/vi/xeJA507xL8I/default.jpg" alt="">
        </button>
      </li>

      <li>
        <button value="Ls_BzmUzSQo">
        <img src="https://img.youtube.com/vi/Ls_BzmUzSQo/default.jpg" alt="">
        </button>
      </li>

      <li>
        <button value="eGv6ju_5egA">
        <img src="https://img.youtube.com/vi/eGv6ju_5egA/default.jpg" alt="">
        </button>
      </li>

      <li>
        <button value="SH25ChTfELc">
        <img src="https://img.youtube.com/vi/SH25ChTfELc/default.jpg" alt="">
        </button>
      </li>

      <li>
        <button value="RSk0SnWotEs">
        <img src="https://img.youtube.com/vi/RSk0SnWotEs/default.jpg" alt="">
        </button>
      </li>

      <li>
        <button value="8-ciXzckzhI">
        <img src="https://img.youtube.com/vi/8-ciXzckzhI/default.jpg" alt="">
        </button>
      </li>
        
    </ul>

  </article>
</section>
<?php include "sub_footer.php" ?>