$(function(){
  var reqID
  function fnGetWInInfo(){
    var elT = $(`.section6 .contact`).offset().top - headerH
    var meta = 0 + (scrT - elT) * 0.7
    if(meta > 0 ) meta = 0
    $(`.section6 .car`).css({'transform' : `translateX(${meta}px)`})
    var meta = 0 + (scrT - elT) * 0.3
    $(`.section6 .bg`).css({'transform' : `scale(1.3) translateY (${meta}px)`})
  } // fn
  fnGetWInInfo()
  $(window).scroll(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  })
}) 