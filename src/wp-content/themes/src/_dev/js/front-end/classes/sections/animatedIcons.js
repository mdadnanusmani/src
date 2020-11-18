class AnimatedIcons {

  constructor() {

    const list = document.querySelectorAll('.animatedIcons')

    list.each((section) => {
      new AnimatedIconsCore(section)
    })

  }

}

class AnimatedIconsCore {

  constructor(section) {

    this.section = section

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    if (!this.section)
      return

    this.wrapper     = this.section.querySelector('.animatedIcons__circleInner')
    this.items       = this.wrapper.querySelectorAll('.animatedIcons__item')
    this.arrows      = this.wrapper.querySelectorAll('.animatedIcons__arrow')
    this.contents    = this.section.querySelectorAll('.animatedIcons__content')
    this.limit       = this.items.length
    this.turnsNumber = 0
    this.activeItem  = 0
    this.events      = {}
    this.isArabic    = (document.documentElement.getAttribute('dir') == 'rtl')

    return true

  }

  setEvents() {

    /* ---
      Hover
    --- */

      this.items.each((item) => {

        item.addEventListener('mouseenter', (e) => {
          item.addClass('animatedIcons__item--hover')
        })

        item.addEventListener('mouseleave', (e) => {
          item.removeClass('animatedIcons__item--hover')
        })

      })

      this.arrows.each((item) => {

        item.addEventListener('mouseenter', (e) => {
          item.addClass('animatedIcons__arrow--hover')
        })

        item.addEventListener('mouseleave', (e) => {
          item.removeClass('animatedIcons__arrow--hover')
        })

      })

    /* ---
      Navigate
    --- */

      this.items.each((item, index) => {

        item.addEventListener('click', (e) => {

          e.preventDefault()
          this.setSlide(index)

        })

      })

      this.arrows.each((item, index) => {

        item.addEventListener('click', (e) => {

          e.preventDefault()
          this.nextSlide()

        })

      })

  }

  setSlide(index) {

    let change = index - this.activeItem

    if (change < 0)
      change = 4 + change

    this.activeItem   = index
    this.turnsNumber += change

    this.turnToSlide()

  }

  nextSlide() {

    let index = this.activeItem + 1

    if (index == this.limit)
      index = 0

    this.setSlide(index)

  }

  turnToSlide(index) {
    
    this.items.removeClass('animatedIcons__item--hover')
    this.arrows.removeClass('animatedIcons__arrow--hover')

    this.items.removeClass('animatedIcons__item--active')
    this.items[this.activeItem].addClass('animatedIcons__item--active')

    this.arrows.removeClass('animatedIcons__arrow--active')
    this.arrows[this.activeItem].addClass('animatedIcons__arrow--active')

    this.contents.removeClass('animatedIcons__content--active')
    this.contents[this.activeItem].addClass('animatedIcons__content--active')

    const value = this.turnsNumber * (!this.isArabic ? 90 : -90)

    this.wrapper.style.transform       = 'rotate(' + value + 'deg)'
    this.wrapper.style.webkitTransform = 'rotate(' + value + 'deg)'

    this.items.each((item) => {

      item.style.transform       = 'rotate(' + -value + 'deg)'
      item.style.webkitTransform = 'rotate(' + -value + 'deg)'

    })

  }

}