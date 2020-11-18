class TextWrap {

  constructor() {

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    this.items = document.querySelectorAll('.textWrap')

    if (!this.items.length)
      return

    return true

  }

  setEvents() {

    window.addEventListener('load', () => {
      this.items.textWrap()
    })

    window.addEventListener('resize', () => {

      setTimeout(() => {
        this.items.textWrap()
      }, 100)

    })

    document.global.body.addCustomEvent('text-wrap', () => {
      this.items.textWrap()
    })

  }

}