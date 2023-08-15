$(function(){
  var reqID
  function fnGetWInInfo(){
    $(`.page-section-intro li`).each(function(){
      var offT = $(this).offset().top
      if(scrT >= offT - winH * 0.8){
        $(this).addClass(`active`)
      }else{
        $(this).removeClass(`active`)
      }
    })
    $(`.page-section-intro li figure`).each(function(){
       offT = $(this).offset().top
       elH = $(this).innerHeight()
       meta = 0 + (scrT - (offT - winH * 0.5 + elH * 0.5)) * 0.1
       if(meta > 15 ) {meta = 15}
       if(meta < -15 ) {meta = -15}
       $(this).children(`img`).css({'transform':`scale(1.4) translateY(${meta}%)` })
    })
    
  }
  fnGetWInInfo()
  $(window).scroll(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  })
})