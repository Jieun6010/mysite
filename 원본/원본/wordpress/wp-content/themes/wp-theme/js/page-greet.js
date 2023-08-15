$(function(){
  var reqID
  function fnGetWInInfo(){
    $(`.page-section-greet p`).each(function(){
      var offT = $(this).offset().top
      if(scrT >= offT - winH * 0.8){
        $(this).addClass(`active`)
      }else{
        $(this).removeClass(`active`)
      }
    })
    offT = $(`.page-section-greet figure`).offset().top
    var elH = $(`.page-section-greet figure`).innerHeight()
    var meta = 0 + (scrT - (offT - winH * 0.5 + elH * 0.5)) * 0.1
    $(`.page-section-greet figure img`).css({'transform' : `rotateX(${meta}deg)`})
  }
  fnGetWInInfo()
  $(window).scroll(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  })
})