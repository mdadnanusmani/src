class SectionScroll {

  constructor() {

    if (!this.setVars())
      return

    this.findSections()
    this.setEvents()

  }

  setVars() {

    this.panel = document.querySelector('.scrollTool')

    if (!this.panel)
      return

    this.sections   = document.querySelectorAll('.section--scroll')
    this.buttonUp   = this.panel.querySelector('.scrollTool__up')
    this.buttonDown = this.panel.querySelector('.scrollTool__down')
    this.buttonTop  = this.panel.querySelector('.scrollTool__top')
    this.positions  = []
    this.current    = -1
    this.animation  = new Animation()
    this.scrollTime = 1000

    return true

  }

  setEvents() {

    window.addEventListener('scroll', (e) => {
      this.findCurrentSection()
    })

    this.buttonUp.addEventListener('click', (e) => {
      e.preventDefault()
      this.scrollSectionUp()
    })

    this.buttonDown.addEventListener('click', (e) => {
      e.preventDefault()
      this.scrollSectionDown()
    })

    this.buttonTop.addEventListener('click', (e) => {
      e.preventDefault()
      this.initScroll(0)
    })

  }

  /* ---
    Sections nav
  --- */

    scrollSectionUp() {

      if (this.current <= 0)
        return

      const value = this.positions[(this.current - 1)]
      this.initScroll(value)

    }

    scrollSectionDown() {

      if (this.current >= (this.positions.length - 1))
        return

      const value = this.positions[(this.current + 1)]
      this.initScroll(value)

    }

  /* ---
    Sections list
  --- */

    findSections() {

      if (!this.sections)
        return

      let current    = getCurrentScroll() - (window.innerHeight / 4)
      this.positions = []

      this.sections.each((item) => {

        const position = item.getBoundingClientRect()
        const value    = current + position.top

        this.positions.push(value)

      })

      this.findCurrentSection()

    }

    findCurrentSection() {

      let scrollTop = getCurrentScroll()
      let current   = scrollTop + (window.innerHeight / 4)

      this.positions.each((value, index) => {

        if (value > current) {

          this.current = (index - 1)
          return false

        }

        this.current = index

      })

      this.buttonUp.addClass('scrollTool__up--hidden')
      this.buttonDown.addClass('scrollTool__down--hidden')
      this.buttonTop.addClass('scrollTool__top--hidden')

      if (this.current > 0) {

        this.buttonUp.removeClass('scrollTool__up--hidden')

        if (this.current < (this.positions.length - 1))
          this.buttonDown.removeClass('scrollTool__down--hidden')

      }

      if (scrollTop > window.innerHeight)
        this.buttonTop.removeClass('scrollTool__top--hidden')

    }

  /* ---
    Scrolling
  --- */

    initScroll(targetValue) {

      TweenLite.to(window, (this.scrollTime / 1000), {scrollTo : targetValue })

    }

}