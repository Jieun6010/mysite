$(function(){
  var reqID
  function fnGetWInInfo(){
    if(scrT >= 35)$(`header`).addClass(`active`)
    else $(`header`).removeClass(`active`)
  }
  
  fnGetWInInfo()
  $(window).scroll(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function(){
    reqID = requestAnimationFrame(fnGetWInInfo)
  })
})