window.isMobile = false; 
var filter = "win16|win32|win64|mac";
if (navigator.platform) {
    isMobile = filter.indexOf(navigator.platform.toLowerCase()) < 0;
}
/* 모든 웹사이트에서 다 검사를 해줘야한다. 모바일로 접속하면 true */


window.isAndroid = false
if( /Android/i.test(navigator.userAgent)) {
  isAndroid = true
  // 안드로이드면 true
}


window.isIOS = false
if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
  isIOS = true
  // iOS 아이폰, 아이패드, 아이팟으로 접속하면 true !
}



$(function(){
  var reqID 
  function fnGetWInInfo(){
    window.scrT = $(window).scrollTop() 
    /* var는 지역변수로 이 함수 내에서만 쓸 수 있기때문에
    이 함수 밖에서 콘솔로그로 호출하면 호출이 안돼! 그래서 사용 안하고 
    window는 모든곳에서 다 호출이 가능한 전역변수이기때문에 이걸 쓸거야! */  
    window.scrL = $(window).scrollLeft()
    window.winH = $(window).height()
    window.winW = $(window).width()
    /* 전체에 선언한거기때문에 다른곳에서 또 같은 이름의 변수를 만들어서 사용하면 안돼 */

  }
  fnGetWInInfo()
  $(window).scroll(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  })

  
})