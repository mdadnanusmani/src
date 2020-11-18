class gSlider {

  constructor(options) {

    this.wrapper = options.wrapper
    this.config  = {
      orientation : options.orientation,
      items       : options.items
    }

    if (this.setVars())
      this.setEvents()

  }

  setVars() {

    this.itemWrapper = this.wrapper.querySelector('.gSlider__itemsOuter')
    this.itemInner   = this.itemWrapper.querySelector('.gSlider__items')
    this.items       = this.itemInner.querySelectorAll('.gSlider__item')
    this.prevButton  = this.wrapper.querySelector('.gSlider__navPrev')
    this.nextButton  = this.wrapper.querySelector('.gSlider__navNext')
    this.values      = {
      'indexMax'        : this.items.length - 1,
      'indexActive'     : 0,
      'indexLatest'     : 0,
      'itemsLength'     : 0,
      'itemsPositions'  : [],
      'translateMax'    : 0,
      'moveX'           : 0,
      'moveStart'       : 0,
      'moveCurrent'     : 0,
      'moveBottomSpace' : 30
    }
    this.classes     = {
      'move'         : 'gSlider__itemsOuter--move',
      'prevDisabled' : 'gSlider__navPrev--disabled',
      'nextDisabled' : 'gSlider__navNext--disabled'
    }
    this.isArabic    = (document.documentElement.getAttribute('dir') == 'rtl')

    return true

  }

  setEvents() {

    this.refresh()

    window.addEventListener('resize', (e) => {
    
      setTimeout(() => { this.refresh() }, 0)
    
    })

    /* ---
      Mouse
    --- */

      const eventMouseMove = (e) => {

        const position = this.wrapper.getBoundingClientRect()
        const current  = (this.config.orientation == 'vertical') ? (e.clientY - position.top) : (e.clientX - position.left)

        if (current != this.values.moveX)
          this.itemWrapper.addClass(this.classes.move)

        this.scrollMove(current)

      }

      const eventMouseUp = (e) => {

        document.removeEventListener('mousemove', eventMouseMove)
        document.removeEventListener('mouseup',   eventMouseUp)

        setTimeout(() => {

          this.itemWrapper.removeClass(this.classes.move)

          if (this.values.moveCurrent != this.values.moveStart)
            this.scrollTranslateNearest()

        }, 0)

      }

      this.itemInner.addEventListener('mousedown', (e) => {

        e.preventDefault()

        const position = this.wrapper.getBoundingClientRect()
        const current  = ((this.config.orientation == 'vertical') ? (e.clientY - position.top) : (e.clientX - position.left)) - this.getCurrentTranslate()

        this.values.moveStart = current
        this.values.moveX     = (this.config.orientation == 'vertical') ? (e.clientY - position.top) : (e.clientX - position.left)

        document.addEventListener('mousemove', eventMouseMove)
        document.addEventListener('mouseup',   eventMouseUp)
      
      })

    /* ---
      Touch
    --- */

      const eventTouchMove = (e) => {

        e.preventDefault()

        const position = this.wrapper.getBoundingClientRect()
        const current  = (this.config.orientation == 'vertical') ? (e.touches[0].clientY - position.top) : (e.touches[0].clientX - position.left)

        this.scrollMove(current)

      }

      const eventTouchEnd = (e) => {

        document.removeEventListener('touchmove', eventTouchMove)
        document.removeEventListener('touchend',  eventTouchEnd)

        this.itemWrapper.removeClass(this.classes.move)
        this.scrollTranslateNearest()

      }

      this.itemInner.addEventListener('touchstart', (e) => {

        const position = this.wrapper.getBoundingClientRect()
        const current  = ((this.config.orientation == 'vertical') ? (e.touches[0].clientY - position.top) : (e.touches[0].clientX - position.left)) - this.getCurrentTranslate()

        this.values.moveStart = current
        this.itemWrapper.addClass(this.classes.move)

        document.addEventListener('touchmove', eventTouchMove, { passive: false })
        document.addEventListener('touchend',  eventTouchEnd)
      
      }, { passive: false })

    /* ---
      Nav
    --- */

      this.prevButton.addEventListener('click', (e) => {
      
        e.preventDefault()
        this.prevItem()
      
      })

      this.nextButton.addEventListener('click', (e) => {
      
        e.preventDefault()
        this.nextItem()
      
      })

  }

  /* ---
    Build
  --- */

    refresh() {

      if (this.config.orientation == 'vertical') {

        this.wrapper.addClass('gSlider--vertical')
        this.wrapper.removeClass('gSlider--horizontal')

        this.setItemsSize()

        const length = this.itemInner.offsetHeight
        let list     = []
        let value    = 0

        for (let i = 0; i <= this.values.indexMax; i++) {

          value = -this.items[i].offsetTop

          const offset = value / length
          list.push(offset)

        }

        this.values.itemsPositions = list
        this.values.itemsLength    = length
        this.values.translateMin   = -(length - this.itemWrapper.offsetHeight)
        this.values.translateMax   = 0

      } else {

        this.wrapper.addClass('gSlider--horizontal')
        this.wrapper.removeClass('gSlider--vertical')

        this.setItemsSize()

        const length = this.itemInner.offsetWidth
        let list     = []
        let value    = 0

        for (let i = 0; i <= this.values.indexMax; i++) {

          if (this.isArabic)
            value = this.wrapper.offsetWidth - this.items[i].offsetLeft - this.items[i].offsetWidth
          else
            value = this.items[i].offsetLeft

          const offset = value / length
          list.push(offset)

        }

        this.values.itemsPositions = list
        this.values.itemsLength    = !this.isArabic ? -length : length
        this.values.translateMin   = !this.isArabic ? -(length - this.wrapper.offsetWidth) : 0
        this.values.translateMax   = !this.isArabic ? 0 : (length - this.wrapper.offsetWidth)

      }

      let translate = (this.values.itemsPositions[this.values.indexActive] * this.values.itemsLength)
      this.scrollTranslate(translate)
      this.findMaxItem()

    }

    setItemsSize() {

      this.itemInner.style.width  = ''
      this.itemInner.style.height = ''

      const length = this.items.length
      for (let i = 0; i < length; i++) {

        this.items[i].style.width  = ''
        this.items[i].style.height = ''

      }

      if (this.config.orientation == 'vertical') {

        if (this.config.items == 'auto') {

          let count = 0

          for (let i = 0; i < length; i++) {

            this.items[i].style.height = 'auto'
            count += this.items[i].offsetHeight

          }

          this.itemInner.style.height = (count + 1) + 'px'

        } else {

          const limit = this.itemWrapper.offsetHeight
          const value = limit / this.config.items

          for (let i = 0; i < length; i++)
            this.items[i].style.height = value + 'px'

          this.itemInner.style.height = (value * length) + 'px'

        }

      } else if (this.config.orientation == 'horizontal') {

        if (this.config.items == 'auto') {

          let count = 0

          for (let i = 0; i < length; i++) {

            this.items[i].style.width = 'auto'
            count += this.items[i].offsetWidth

          }

          this.itemInner.style.width = (count + 1) + 'px'

        } else {

          const limit = this.itemWrapper.offsetWidth
          const value = limit / this.config.items

          for (let i = 0; i < length; i++)
            this.items[i].style.width = value + 'px'

          this.itemInner.style.width = (value * length) + 'px'

        }

      }

    }

    findMaxItem() {

      let current = 0
      let limit   = (this.config.orientation == 'vertical') ? this.itemWrapper.offsetHeight : this.itemWrapper.offsetWidth
      let index

      for (let i = this.values.indexMax; i >= 0; i--) {

        current += (this.config.orientation == 'vertical') ? this.items[i].offsetHeight : this.items[i].offsetWidth

        if (current > limit)
          break

        index = i

      }

      this.values.indexLatest = index

    }

  /* ---
    Nav
  --- */

    prevItem() {

      if (!this.isArabic && (this.values.indexActive <= 0))
        return

      this.nextButton.removeClass(this.classes.nextDisabled)

      this.values.indexActive--

      const translate = (this.values.itemsPositions[this.values.indexActive] * this.values.itemsLength)
      this.scrollTranslate(translate)
      this.setNavClasses()

    }

    nextItem() {

      if (this.values.indexActive >= this.values.indexLatest)
        return

      this.prevButton.removeClass(this.classes.prevDisabled)

      this.values.indexActive++

      const translate = (this.values.itemsPositions[this.values.indexActive] * this.values.itemsLength)
      this.scrollTranslate(translate)
      this.setNavClasses()

    }

    setItem(index) {

      if (index >= this.values.indexLatest)
        index = this.values.indexLatest
      else if (!this.isArabic && (index <= 0))
        index = 0

      this.values.indexActive = index

      const translate = (this.values.itemsPositions[this.values.indexActive] * this.values.itemsLength)
      this.scrollTranslate(translate)
      this.setNavClasses()

    }

    setNavClasses() {

      this.prevButton.removeClass(this.classes.prevDisabled)
      this.nextButton.removeClass(this.classes.nextDisabled)

      if (this.values.indexActive <= 0)
        this.prevButton.addClass(this.classes.prevDisabled)
      else if (this.values.indexActive >= this.values.indexLatest)
        this.nextButton.addClass(this.classes.nextDisabled)

    }

  /* ---
    Change slide
  --- */

    scrollMove(value) {

      value = value - this.values.moveStart

      if (value < this.values.translateMin)
        value = this.values.translateMin
      else if (value > this.values.translateMax)
        value = this.values.translateMax

      this.values.moveCurrent = value

      const percent   = value / this.values.itemsLength
      const translate = (percent * this.values.itemsLength)

      this.scrollTranslate(translate)

    }

    scrollTranslateNearest() {

      if ((!this.isArabic) && (this.values.moveCurrent <= (this.values.translateMin + this.values.moveBottomSpace))) {

        this.values.indexActive = this.values.indexLatest
        this.scrollTranslate(this.values.translateMin)
        this.setNavClasses()

        return

      } else if ((this.isArabic) && (this.values.moveCurrent >= (this.values.translateMax - this.values.moveBottomSpace))) {

        this.values.indexActive = this.values.indexLatest
        this.scrollTranslate(this.values.translateMax)
        this.setNavClasses()

        return

      }

      const percent = this.values.moveCurrent / this.values.itemsLength
      const closest = this.values.itemsPositions.reduce((prev, curr) => {
        return (Math.abs(curr - percent) < Math.abs(prev - percent) ? curr : prev)
      })

      let index     = this.values.itemsPositions.indexOf(closest)
      let translate = (this.values.itemsPositions[index] * this.values.itemsLength)

      this.values.indexActive = index

      this.scrollTranslate(translate)
      this.setNavClasses()

    }

    scrollTranslate(value) {

      if (value < this.values.translateMin)
        value = this.values.translateMin
      else if (value > this.values.translateMax)
        value = this.values.translateMax

      if (this.config.orientation == 'vertical') {

        this.itemWrapper.style.transform       = 'translateY(' + value + 'px)'
        this.itemWrapper.style.webkitTransform = 'translateY(' + value + 'px)'

      } else {

        this.itemWrapper.style.transform       = 'translateX(' + value + 'px)'
        this.itemWrapper.style.webkitTransform = 'translateX(' + value + 'px)'

      }

    }

  /* ---
    Helpers
  --- */

    getCurrentTranslate() {

      const matches = this.itemWrapper.style.transform.match(/\d+/)
      let translate = matches ? parseInt(matches[0]) : 0

      if (!this.isArabic || (this.config.orientation == 'vertical'))
        translate = -translate

      return translate

    }

}