<?php include "sub_header.php" ?>
<script src="./js/gallery2.js"></script>
<h2 class="sub_title">갤러리2</h2>
<section class="gallery2_section">
  <p class="site_guide">
    flex속성을 이용한 반응형 그리드 레이아웃을 설계 하였습니다 <br>
    <button>
      <i class="fa-solid fa-circle-xmark"></i>
    </button>
  </p>
  <p class="sub_desc">
    <em class="emphasis">갤러리 및 시공사례입니다.</em>
    선샤인의 다양한 제작물을 살펴보실 수 있습니다.
  </p>
  <ul class="flex_container">
    <!--  -->
  </ul><!-- 동적으로 엘리먼트 추가나 제어를 스크립ㅌ트로 할것임 -->
  <script>
    for (var i = 1; i <= 9; i++) {
      $(`.flex_container`).append(`
      <li class="box">
      <a href="./img/sub3/${i}.jpg">
        <figure>
          <img src="./img/sub3/${i}.jpg" alt="">
          <figcaption>
            <h3>img title${i}</h3>
            <p>
              Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            </p>
          </figcaption>
        </figure>
      </a>
    </li>  
      `)
    }
  </script>
</section>
<?php include "sub_footer.php" ?>