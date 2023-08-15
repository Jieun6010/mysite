$(function () {
  // 몇 번 카테고리인지 ? 1인지 2인지 3인지 4인지 ? 
  var url = location.href // 주소가 뭐인지
  var dep1 // 대메뉴 번호
  var dep2 // 소메뉴 번호 
  //주소에 이 문자가 포함되어있으면 트루/폴스 //정확히 적는게 가장 좋다.
  if (url.match('/greet.php')) {
    dep1 = 1; dep2 = 1
  } else if (url.match('/location.php')) {
    dep1 = 1; dep2 = 2
  } else if (url.match('/video.php')) {
    dep1 = 1; dep2 = 3
  } else if (url.match('/biz-intro.php')) {
    dep1 = 2; dep2 = 1
  } else if (url.match('/biz-area.php')) {
    dep1 = 2; dep2 = 2
  } else if (url.match('/gallery1.php')) {
    dep1 = 3; dep2 = 1
  } else if (url.match('/gallery2.php')) {
    dep1 = 3; dep2 = 2
  } else if (url.match('/gallery3.php')) {
    dep1 = 3; dep2 = 3
  } else if (url.match('/gallery4.php')) {
    dep1 = 3; dep2 = 4
  } else if (url.match('/gallery5.php')) {
    dep1 = 3; dep2 = 5
  } else if (url.match('/contact.php')) {
    dep1 = 4; dep2 = 1
  } else if (url.match('/notice.php')) {
    dep1 = 5; dep2 = 1
  } else if (url.match('/faq.php')) {
    dep1 = 5; dep2 = 2
  } else if (url.match('/freeboard.php')) {
    dep1 = 5; dep2 = 3
  } else if (url.match('/login.php')) {
    dep1 = 6; dep2 = 1
  } else if (url.match('/register.php')) {
    dep1 = 6; dep2 = 2
  } else if (url.match('/member.php')) {
    dep1 = 6; dep2 = 3
  }
  
  $(`.snb .menu${dep1}`).show()
  $(`.snb .menu${dep1}-${dep2}`).addClass(`active`)
  /*
  $(`.sub_visual .visual${dep1} `).show() /* 디스플레이를 블록으로 바꿔버린다 디스플레이가 none인 상탸에서 show를 하면 하ㅏㄴ도 적용이 안된다. show가 된 다음에 어느정도 시간이 지나야 트랜지션이 살아난다.
  setTimeout(function(){
    $(`.sub_visual .visual${dep1} `).addClass(`active`)
  },1)
  밑에처럼 이렇게하면 셋타임아웃을 굳이 안 써도 된다. 
  fadeIn자체가 show를 계속 반복하는거기때문에 // 바닐라스크립트에서는 fadeIn이 없어서 셋타임아웃으로해야댐
  디스플레이가 none인 상태에서는 트랜지션이 죽는다 !!! */
  $(`.sub_visual .visual${dep1} `).fadeIn().addClass(`active`)

  /* 서브비주얼 */

  var dep1_title = $(`.gnb.lg .menu${dep1} h6`).text()
  /* .gnb.lg를 빼면 menu들이 4개 다 호출되니까 한놈만 꼭 정확하게 찝어줘야해 ! */
  var dep2_title = $(`.gnb.lg .menu${dep1}-${dep2}`).text()
  $(`.breadcrumb .dep1`).text(dep1_title)
  $(`.breadcrumb .dep2`).text(dep2_title)
  $(`.site_guide button`).click(function(){
    $(`.site_guide`).slideUp()
  })

  
  
}) //ready