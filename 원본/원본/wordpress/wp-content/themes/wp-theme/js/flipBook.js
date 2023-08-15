function flipBook(el) {
  this.el = $(el)
  this.sheetCnt = this.el.children('.sheet').size()
  this.flip(1)
}

flipBook.prototype.flip = function (n) {

  if (n > 1 && n <= this.sheetCnt) {
    this.el.addClass('active').removeClass('deactive')
  } else if (n > this.sheetCnt) {
    this.el.addClass('deactive').removeClass('active')
  }else{
    this.el.removeClass('active deactive')
  }

  var z
  if (n === this.sheetCnt + 1) {

    z = this.sheetCnt - 1
    this.el.children('.sheet' + n).prevAll('.sheet').each(function () {
      z--
      $(this).css({ 'z-index': z })
    })
    this.el.children('.sheet' + (n - 1)).css({ 'z-index': this.sheetCnt-1 })

    this.el.children('.sheet' + (n - 1)).prevAll('.sheet').addClass('active')
    this.el.children('.sheet' + (n - 1)).addClass('active')

  } else {
    z = this.sheetCnt
    this.el.children('.sheet' + n).prevAll('.sheet').each(function () {
      z--
      $(this).css({ 'z-index': z })
    })
    z = this.sheetCnt - n
    this.el.children('.sheet' + n).css({ 'z-index': z })

    z = this.sheetCnt - n - 1
    this.el.children('.sheet' + n).nextAll('.sheet').each(function () {
      z--
      $(this).css({ 'z-index': z })
    })
    this.el.children('.sheet' + n).prevAll('.sheet').addClass('active')
    this.el.children('.sheet' + n).removeClass('active')
    this.el.children('.sheet' + n).nextAll('.sheet').removeClass('active')
  }
}