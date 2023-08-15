$(function(){
  var reqID
  function fnGetWInInfo() {
    $(`.page-section-area div, .page-section-area p`).each(function () {
      var offT = $(this).offset().top
      if(scrT >= offT - winH * 0.8){
        $(this).addClass(`active`)
      }else{
        $(this).removeClass(`active`)
      }
    })
  }
  fnGetWInInfo()
  $(window).scroll(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  })
})