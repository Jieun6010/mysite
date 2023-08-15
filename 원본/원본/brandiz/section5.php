<script src="./js/section5.js"></script>
<section class="section5">
  <article class="bg">
    <img src="./img/section5/section5_bg.jpg" alt="">
    <video src="./img/section5/bg.mp4" autoplay muted playsinline loop></video>
  </article>
  <article class="earth">
    <figure>
      <img class="dummy" src="./img/section5/earth-1.png" alt=""> <!-- 그냥 높이 목적으로 사용하는 벽돌기능 -->
    </figure>
    <script>
      for (i = 1; i <= 48; i++) {
        $(`.earth figure`).append(`
        <img class="img img${i}" src="./img/section5/earth-${i}.png" alt>
        `)
        /* 지구 48개가 나오기때문에 position을 줘서 겹치게 만들어야함 */
      }
    </script>
  </article>

  <article class="progress">
    <ul>
      <li>
        <?php include "img/svg/badge.php" ?>
        <div class="textbox">
          <i class="fa-solid fa-building"></i>
          <h3>설립년도</h3>
          <b data-t="2012" class="progress-num progress-num1">0</b>
        </div> <!-- textbox -->
      </li>

      <li>
        <?php include "img/svg/badge.php" ?>
        <div class="textbox">
          <i class="fa-solid fa-hand-holding-dollar"></i>
          <h3>계약건수</h3>
          <b data-t="2452" class="progress-num progress-num2">0</b>
        </div> <!-- textbox -->
      </li>

      <li>
        <?php include "img/svg/badge.php" ?>
        <div class="textbox">
          <i class="fa-solid fa-handshake"></i>
          <h3>파트너</h3>
          <b data-t="1256" class="progress-num progress-num3">0</b>
        </div> <!-- textbox -->
      </li>

      <li>
        <?php include "img/svg/badge.php" ?>
        <div class="textbox">
          <i class="fa-solid fa-passport"></i>
          <h3>특허보유</h3>
          <b data-t="456" class="progress-num progress-num4">0</b>
        </div> <!-- textbox -->
      </li>

    </ul>

  </article>

  <div class=" dummy-scroll"></div>
  <!-- 부모가 끌고갈때 멈춰있는 시간을 길게하려고(높이만 주기위해 ) 만든 더미 스크롤! 회전시간을 늘리기 위해!-->
</section>