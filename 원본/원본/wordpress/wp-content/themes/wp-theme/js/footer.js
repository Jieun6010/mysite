$(function () {
 $('.fnb button').click(function () {
  $('.fnb > div').stop().slideToggle()
  $(this).toggleClass('active')
 })
})