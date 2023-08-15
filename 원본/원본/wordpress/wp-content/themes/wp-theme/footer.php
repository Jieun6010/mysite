<script src="<?php bloginfo('template_directory'); ?>/js/footer.js"></script>
<footer>
  <div class="center">
    <nav class="fnb">
      <button class="active">SiteMap</button>
      <?php wp_nav_menu(array('theme_location' => 'menu')); ?>
    </nav>
    <address>
      <i>주소 : 부산광역시 해운대구 좌동 273-10</i>
      <i>상호 : 디자인선샤인</i>
      <i>사업자등록번호 : 123-456-7890</i>
      <i>Tel : 070-7155-1979</i>
      <i>Fax : 02-2139-1142</i>
      <i>E-mail : gijung23@nate.com</i>
    </address>
    <p>
      Copyright ⓒ Sunsine.com All Rights Reserved.
    </p>
  </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>