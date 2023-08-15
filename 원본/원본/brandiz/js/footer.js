$(function () {
  var reqID
  function fnGetWInInfo() {
    $(`.footer-height`).height(
      $(`footer`).innerHeight()
    )
  } //fnGetWInInfo

  fnGetWInInfo()
  $(window).scroll(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  }).resize(function () {
    reqID = requestAnimationFrame(fnGetWInInfo)
  })
})