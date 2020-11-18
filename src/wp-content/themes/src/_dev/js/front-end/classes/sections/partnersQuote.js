class PartnersQuote {

  constructor() {

    const list = document.querySelectorAll('.partnersQuote')

    list.each((section) => {
      new PartnersQuoteCore(section)
    })

  }

}

class PartnersQuoteCore {

  constructor(section) {

    this.section = section

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    if (!this.section)
      return

    this.wrapper = this.section.querySelector('.gSlider')

    return true

  }

  setEvents() {

    window.addEventListener('load', (e) => {
      setTimeout(() => { this.initSlider() }, 0)
    })

    window.addEventListener('resize', (e) => {

      const orientation = (Math.round(this.section.offsetWidth / this.wrapper.offsetWidth) == 1) ? 'horizontal' : 'vertical'
    
      this.slider.config.orientation = orientation
      this.slider.config.items       = (orientation == 'horizontal') ? 'auto' : 3
      this.slider.refresh()
    
    })

  }

  initSlider() {

    const orientation = (Math.round(this.section.offsetWidth / this.wrapper.offsetWidth) == 1) ? 'horizontal' : 'vertical'

    this.slider = new gSlider({
      wrapper     : this.wrapper,
      orientation : orientation,
      items       : (orientation == 'horizontal') ? 'auto' : 3
    })

  }

}