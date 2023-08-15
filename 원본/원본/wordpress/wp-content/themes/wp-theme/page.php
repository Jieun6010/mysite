<?php include "sub-header.php" ?>

<h2 class="sub-title"><?php the_title(); ?></h2>

<section class="page-section">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile;
  else : ?>
  <?php endif; ?>
</section>
<?php include "sub-footer.php" ?>

<div>
<label for="mail-id1">이름</label>
[text* client-name id:mail-id1 placeholder '이름이나 회사명을 입력해주세요' ]
</div>

<div>
<label for="mail-id2">연락처</label>
[tel* client-tel id:mail-id2 placeholder '숫자만 입력해주세요']
</div>

<div>
<label for="mail-id3">이메일</label>
[email* client-email id:mail-id3 placeholder '회신받으실 이메일 주소를 입력해주세요' ]
</div>

<div>
<label for="mail-id4">제목</label>
[text* client-title id:mail-id4 placeholder '제목을 입력해 주세요.']
</div>

<div>
<label for="mail-id5">내용</label>
[textarea* client-desc id:mail-id5 placeholder '세부내용을 상세하게 입력해주세요']
</div>

<div>
[acceptance acceptance id:mail-id6 optional] 개인정보 제공에 동의합니다 [/acceptance]
</div>

<div>
[submit "문의하기"]
</div>