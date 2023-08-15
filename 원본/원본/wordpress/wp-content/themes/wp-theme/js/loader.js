$(`body`).css({ 'overflow': `hidden` })

$(function () {
  $(`.gnb>div>ul>li>ul>li>a, .snb>div>ul>li>ul>li>a, .fnb>div>ul>li>a `).click(function (e) {
    e.preventDefault();
    $(`body`).css({ 'overflow': `hidden` })
    $(`.loader`).removeClass(`active`)
    var href = $(this).attr('href')
    var timeoutID
    clearTimeout(timeoutID)
    timeoutID = setTimeout(function () {
      location.href = href
    }, 500)
  })
})

$(window).load(function () {
  $(`.loader`).addClass(`active`)
  setTimeout(function () {
    $(`body`).css({ 'overflow': `auto` })
  }, 500)

})