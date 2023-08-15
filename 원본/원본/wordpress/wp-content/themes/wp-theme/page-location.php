<?php include "sub-header.php" ?>
<script src="<?php bloginfo('template_directory'); ?>/js/page-location.js"></script>

<h2 class="sub-title"><?php the_title(); ?></h2>

<p class="theme-guide">
  본 컨텐츠는 카테고리로 제작되었으며,
  page-location.php템플릿을 이용해 수정·편집 하실 수 있습니다
  <button><i class="fa-solid fa-circle-xmark"></i></button>
</p>

<div class="sub-desc">
  <b>찾아오시는 길 안내</b>입니다. <br>
  여러분들의 방문을 환영합니다.
</div>

<section class="page-section page-section-location ">
<table>
  <colgroup>
  <col style="width:25%">
  <col style="width:75%">
  </colgroup>
  <tbody class="table">
    <tr>
      <th>오시는 길</th>
      <td>인천광역시 부평구 부평 1동</td>
    </tr>

    <tr>
      <th>전화번호</th>
      <td> 032-521-8889</td>
    </tr>

    <tr>
      <th>팩스번호</th>
      <td>02-2139-1142</td>
    </tr>
  </tbody>
</table>

  <h3 class="hidden">구글맵</h3>
  <div class="tab_menu">
    <button value="1" class="active"></button>
  </div>
  <div class="pane">
    <div>
      <iframe class="map map1" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3165.717525262385!2d126.71838271558694!3d37.49099173620818!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357b7c4657c1fbbb%3A0x960379a8e77c411e!2z642U7KGw7J2A7Lu07ZOo7YSw7ZWZ7JuQ!5e0!3m2!1sko!2skr!4v1679969636868!5m2!1sko!2skr" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</section>

<?php include "sub-footer.php" ?>