<?php include "sub_header.php" ?>
<h2 class="sub_title">온라인문의</h2>
<section class="contact_section">
  <p class="site_guide">
    접근성을 고려한 반응형 폼 form UI를 설계 하였습니다<br>
    전송 기능은 구현되지 않은 디자인 페이지입니다
    <button>
      <i class="fa-solid fa-circle-xmark"></i>
    </button>
  </p>
  
  <p class="sub_desc">
    <em class="emphasis">궁금하신 사항이나 프로젝트 문의사항을 작성해 주세요.</em>
    담당자가 확인후 빠른 회신을 약속합니다.
  </p>

  <form class="contact_form">
    <fieldset>
      <div>
        <label for="id1">성명</label> <!-- 레이블은 접근성때문에 한다 ! 시각장애인분들은 읽어드려야하니까 !-->
        <div>
          <input require id="id1" type="text" placeholder="단체인 경우 회사이름을 입력해주세요">
        </div>
      </div>

      <div>
        <!-- 라벨을 속성으로 쓸 수 있는건 옵션밖에 없어
        레이블이 최우선이지만 타이틀로 대체를 할 수 있어  -->
        <label>연락처</label>
        <div class="tel">
          <select>
            <option value="" title="통신사를 하단의 옵션중에 선택해주세요">통신사</option>
            <option value="" label="KT">KT</option>
            <option value="" label="LGU+">LGU+</option>
            <option value="" label="SKT">SKT</option>
          </select>
          <span>-</span>
          <label class="hidden" for="id2-1">연락처 첫번째 세자리 수를 입력하세요</label>
          <input type="tel" name="" id="id2-1" size="1"> 
          <span>-</span>
          <label class="hidden" for="id2-2">연락처 두번째 네자리 수를 입력하세요</label>
          <input type="tel" name="" id="id2-2" size="1"> 
          <span>-</span>
          <label class="hidden" for="id2-3">연락처 세번째 네자리 수를 입력하세요</label>
          <input type="tel" name="" id="id2-3" size="1">
        </div>
      </div>

      <div>
        <label for="">email</label>
        <div>
          <input type="email" id="id3">
        </div>
      </div>

      <div>
        <label>질문분야</label> <!-- 이 레이블은 그냥 가짜 레이블 -->
        <div>
          <label for="id3-1"><input type="radio" name="q" id="id3-1">웹사이트제작</label> <!-- 진짜 레이블 -->
          <label for="id3-2"><input type="radio" name="q" id="id3-2"> 앱제작</label>
          <label for="id3-3"><input type="radio" name="q" id="id3-3"> 쇼핑몰제작</label>
          <label for="id3-4"><input type="radio" name="q" id="id3-4"> 기타</label>
        </div>
      </div>
      <div>
        <label for="id4">제목</label>
        <div>
          <input type="text" id="id4">
        </div>
      </div>

      <div>
        <label for="id5">문의내용</label>
        <div>
          <textarea id="id5"></textarea><!-- 내용으로 인식되어버려서 여백넣으면 안댐!-->
        </div>
      </div>

      <div>
        <label for="id6">첨부파일</label>
        <div>
          <input type="file" id="id6" accept="image/*" title="이미지 파일만 업로드가 가능합니다"> <!-- 이미지 모든파일을 업로드할 수 있다! -->
        </div>
      </div>

      <div>
        <label>개인정보수집동의</label>
        <div>
          <label for="id7-1">
            <input type="radio" name="agree" id="id7-1" require> <!-- require은 필수입력항목에 다 달아줘야하는거야 -->
            동의
          </label>
          <label for="id7-2">
            <input type="radio" name="agree" id="id7-2" require checked>
            비동의
          </label>
        </div>
      </div>

      <div class="btns">
        <button>문의하기</button> <!-- button type=submit 이 디폴트값이야 -->
        <button type="reset">취소</button>
      </div>

    </fieldset>
  </form>
</section>
<?php include "sub_footer.php" ?>