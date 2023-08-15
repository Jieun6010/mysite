<?php include "sub_header.php" ?>
<script src="./js/location.js"></script>
<h2 class="sub_title">오시는길</h2>
<section class="location_section">
  <p class="site_guide">
    탭 메뉴UI와 이용한 구글맵 API를 이용하여 찾아오시는 길 페이지를 설계하였습니다.
    <button>
      <i class="fa-solid fa-circle-xmark"></i>
    </button>
  </p>

  <p class="sub_desc">
    <em class="emphasis">찾아오시는 길 안내입니다.</em>
    방문전 연락을 주시면 친절하게 안내 해 드립니다.
  </p>

  <article>
    <h3 class="hidden">구글맵,약도</h3>
    <div class="tab_menu">
      <button value="1" class="active">구글맵</button>
      <button value="2">약도</button>
    </div>
    <div class="pane">
      <div>
        <iframe class="map map1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3165.717525262385!2d126.71838271558694!3d37.49099173620818!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357b7c4657c1fbbb%3A0x960379a8e77c411e!2z642U7KGw7J2A7Lu07ZOo7YSw7ZWZ7JuQ!5e0!3m2!1sko!2skr!4v1679969636868!5m2!1sko!2skr" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <img class="map map2" src="./img/sub1/KakaoTalk_20230328_110456372.jpg" alt="">
      </div>
    </div>
  </article>
</section>
<?php include "sub_footer.php" ?>