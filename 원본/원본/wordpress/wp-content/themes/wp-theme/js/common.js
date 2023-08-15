window.isMobile = false; 
var filter = "win16|win32|win64|mac";
if (navigator.platform) {
  isMobile = filter.indexOf(navigator.platform.toLowerCase()) < 0;
}

window.isAndroid = false
if(/Android/i.test(navigator.userAgent)) {
  isAndroid = true
}

window.isIOS = false
if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
  isIOS = true
}

$(function () {
  var reqID
  function fnGetWInInfo() {
    window.scrT = $(window).scrollTop()
    window.scrL = $(window).scrollLeft()
    window.winH= $(window).height()
    window.winW= $(window).width()
    window.docH = $(document).innerHeight()
  }
  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })
})