$(function(){
  $(`.tab_menu button`).click(function(){
    var n = $(this).val()
    $(`.map`).hide()
    $(`.map${n}`).show()
    $(`.tab_menu button`).removeClass(`active`)
    $(this).addClass(`active`)
  })
})