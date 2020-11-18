class Slider {

  constructor() {

    if (!this.setVars())
      return

    this.setEvents()
    this.sliderHeight()

  }

  setVars() {

    this.section = document.querySelector('.slider')

    if (!this.section)
      return

    this.outer        = this.section.querySelector('.slider__outer')
    this.inner        = this.outer.querySelector('.slider__inner')
    this.scrollButton = this.section.querySelector('.slider__scroll')
    this.scrollHeight = window.innerHeight / 1.5
    this.scrollTime   = 1000
    this.windowWidth  = 0

    return true

  }

  setEvents() {

    window.addEventListener('resize', (e) => {
      this.scrollHeight = window.innerHeight / 1.5
      this.sliderHeight()
    })

    window.addEventListener('scroll', (e) => {
      this.hideContent()
    })

    this.scrollButton.addEventListener('click', (e) => {
      e.preventDefault()
      this.scrollToNextSection()
    })

  }

  /* ---
    Slider height
  --- */

    sliderHeight() {

      if (window.innerWidth == this.windowWidth)
        return

      this.windowWidth          = window.innerWidth
      this.section.style.height = window.innerHeight + 'px'
      this.outer.style.height   = window.innerHeight + 'px'

    }

  /* ---
    Content
  --- */

    hideContent() {

      let scroll  = getCurrentScroll()
      let percent = scroll / this.scrollHeight

      if (percent > 1)
        percent = 1

      percent = (1 - percent)

      this.inner.style.opacity         = percent
      this.inner.style.transform       = 'translateY(' + (-scroll / 4) + 'px)'
      this.inner.style.webkitTransform = 'translateY(' + (-scroll / 4) + 'px)'

    }

  /* ---
    Scroll button
  --- */

    scrollToNextSection() {

      let offset = window.innerHeight - 60
      TweenLite.to(window, (this.scrollTime / 1000), {scrollTo : offset })

    }

}