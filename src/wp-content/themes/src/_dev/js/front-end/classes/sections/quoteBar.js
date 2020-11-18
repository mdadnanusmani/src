class QuoteBar {

  constructor() {

    const list = document.querySelectorAll('.quoteBar')

    list.each((section) => {
      new QuoteBarCore(section)
    })

  }

}

class QuoteBarCore {

  constructor(section) {

    this.section = section

    if (!this.setVars())
      return

    this.setEvents()
    this.moveWords()

  }

  setVars() {

    if (!this.section)
      return

    this.whiteText = this.section.querySelector('.quoteBar__textWhite')
    this.blueText  = this.section.querySelector('.quoteBar__textBlue')
    this.text      = this.blueText.innerHTML

    return true

  }

  setEvents() {

    window.addEventListener('resize', () => {
      this.moveWords()
    })

  }

  moveWords() {

    const max    = parseInt(window.getComputedStyle(this.blueText).getPropertyValue('line-height')) * 2
    const parts  = this.text.split(' ')
    const length = parts.length
    let i        = 1

    for (i; i <= length; i++) {

      this.whiteText.innerHTML = parts.slice(0, i).join(' ')
      let current = this.whiteText.offsetHeight

      if (current > max)
        break

    }

    this.whiteText.innerHTML = parts.slice(0, (i - 1)).join(' ')
    this.blueText.innerHTML  = parts.slice((i - 1)).join(' ')

  }

}