$(function(){
  /* gnb sm ---------------------------------------------------------------- */
  $(`.gnb.sm > ul > li > a`).click(function(e){ /* 이벤트 리스너 / 이벤트받는애들을 제어해주는거 */
    /* 링크(a)가 걸려있기때문에 클릭해도 링크타고 가버리기때문에 링크를 막아주자 */
    e.preventDefault()
    $(`.gnb.sm > ul > li > ul`).stop().slideUp(300) /* 네비접기 / 0.3?초 */
    $(this).siblings(`ul`).stop().slideToggle(300) /* 네비펼치기 */
    $(`.gnb.sm > ul > li > a`).not(this).removeClass(`active`)
    $(this).toggleClass(`active`)
  })
  /* mbtn -------------------------------------------------------- */
  $(`.mbtn`).click(function(){
    /* 이런 애니메이션들은 무조건 stop이 나와야함 / 옆으로 왔다갔다 토글까지 페이드 인 옆에 같이 써도 됨*/
    $(`.gnb.sm`).stop().fadeToggle().toggleClass(`active`)
    /* 슬라이드 다 올려 */
    $(`.gnb.sm > ul > li > ul`).stop().slideUp()
    /* 슬라이드를 끄면 글자색도 다시 원래대로 */
    $(`.gnb.sm > ul > li > a`).removeClass(`active`) 
    $(this).toggleClass(`active`)
  })

  /* gnb.lg ------------------------------------------ */
  $(`.gnb.lg > ul > li`).mouseenter(function(){ /* 마우스가 들어갔을때 일어나는 일 */
    $(this).children(`ul`).stop().slideDown(200) /* 네비 펼치기 */
  })
  $(`.gnb.lg > ul > li`).mouseleave(function(){
    $(this).children(`ul`).stop().slideUp(200) /* 네비 접기 */
  })
})
