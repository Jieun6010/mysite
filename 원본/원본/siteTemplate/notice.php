<?php include "sub_header.php" ?>
<h2 class="sub_title">공지사항</h2>
<section class="board_section notice_section">
  <p class="site_guide">
    반응형을 이용한 게시판 리스트를 설계하였습니다 <br>
    읽기 , 쓰기 페이지는 구현되지 않았습니다.
    <button>
      <i class="fa-solid fa-circle-xmark"></i>
    </button>
  </p>
  <p class="sub_desc">
    <em class="emphasis">고객님의 소중한 의견을 주셔서 감사합니다.</em>
    언제나 고객님의 눈높이에 맞추어 최상의 서비스가 되기 위해 노력하겠습니다.
  </p>
  <table class="board">
    <thead>
      <tr>
        <th scope="row">번호</th>
        <th scope="row">제목</th>
        <th scope="row">작성자</th>
        <th scope="row">작성일자</th>
        <th scope="row">조회수</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>6</td>
        <td> <a href="#">공지사항 게시판 테스트 6번 글</a></td>
        <td>관리자 dasasdasdasdasd</td>
        <td>20230-03-23</td>
        <td>12</td>
      </tr>
      <tr>
        <td>5</td>
        <td><a href="#">공지사항 게시판 테스트 6번 글</a></td>
        <td>관리자</td>
        <td>20230-03-23</td>
        <td>12</td>
      </tr>
      <tr>
        <td>4</td>
        <td> <a href="#">공지사항 게시판 테스트 6번 글</a></td>
        <td>관리자</td>
        <td>20230-03-23</td>
        <td>12</td>
      </tr>
      <tr>
        <td>3</td>
        <td> <a href="#">공지사항 게시판 테스트 6번 글</a></td>
        <td>관리자</td>
        <td>20230-03-23</td>
        <td>12</td>
      </tr>
      <tr>
        <td>2</td>
        <td> <a href="#">공지사항 게시판 테스트 6번 글</a></td>
        <td>관리자</td>
        <td>20230-03-23</td>
        <td>12</td>
      </tr>
      <tr>
        <td>1</td>
        <td> <a href="#"> 공지사항 게시판 테스트 6번 글</a></td>
        <td>관리자</td>
        <td>20230-03-23</td>
        <td>12</td>
      </tr>
    </tbody>
  </table>

  <nav class="board_paging"> <!-- 다음장으로 넘어가는 버튼들 ! -->
    <a class="active" href="#">1</a> <!-- 현재페이지는 도드라지게 -->
    <a href="#">2</a>
    <a href="#">3</a>
  </nav>

  <form class=" board_search">
    <fieldset><!-- 폼 안의 영역 ! 정보 분류를 해주는 -->
      <select>
        <!-- 옵션은 레이블을 따로 연결못하니까 옵션만 레이블 속성을 따로 제공함 -->
        <option label="내용" title="내용으로 검색할 경우 선택하세요">내용</option>
        <option label="제목" title="내용으로 검색할 경우 선택하세요">제목</option>
        <option label="작성자" title="내용으로 검색할 경우 선택하세요">작성자</option>
        <!-- 타이틀이 있으면 레이블을 작성 안해도돼 -->
      </select>
      <!-- 인풋도 레이블이나 타이틀을 꼭 달아줘야해 근데 레이블을 권장함 -->
      <label class="hidden" for="">검색어를 입력하세요</label>
      <input id="search_input" type="text">
      <button>검색</button>
      
    </fieldset>
  </form>
</section> 
<?php include "sub_footer.php" ?>