<?php include "sub_header.php" ?>
<script src="./js/gallery3.js"></script>
<h2 class="sub_title">Gallery_Grid</h2>
<section class="gallery3_section">
  <p class="site_guide">
    gird system을 이용한 반응형 그리드 레이아웃을 설계 하였습니다.
    <button>
      <i class="fa-solid fa-circle-xmark"></i>
    </button>
  </p>

  <p class="sub_desc">
    <em class="emphasis">갤러리 및 시공사례입니다.</em>
    선샤인의 다양한 제작물을 살펴보실 수 있습니다.
  </p>
  <ul class="grid_container">
  </ul>
  <script>
    for(var i=1; i<=9; i++){
      $(`.grid_container`).append(`
      <li class="item${i}">
      <a href="#">
        <figure>
          <img src="./img/sub3/${i}.jpg" alt="">
          <figcaption>
            <h3>Title${i}</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
          </figcaption>
          
        </figure>
      </a>  
    </li>
    `)
  }
  </script>
</section>
<?php include "sub_footer.php" ?>