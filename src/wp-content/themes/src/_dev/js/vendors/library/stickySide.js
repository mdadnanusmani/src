class StickySide {

  constructor(options) {

    this.wrapper          = options.wrapper
    this.side             = options.side
    this.header           = options.header
    this.headerTransition = options.headerTransition || 0
    this.headerOffset     = options.headerOffset

    if (this.setVars())
      this.setEvents()

  }

  setVars() {

    if (!this.wrapper)
      return

    this.positions     = {}
    this.prevScroll    = getCurrentScroll()
    this.detectTimeout = null
    this.checkCount    = 0
    this.checkMax      = this.headerTransition ? Math.ceil(this.headerTransition / 10) : 0

    return true

  }

  setEvents() {

    window.addEventListener('load', () => {

      this.refreshPositions()
      window.addEventListener('scroll', () => {

        this.boxSticky()

      })

    })

    window.addEventListener('resize', () => {

      this.refreshPositions()

    })

  }

  /* ---
    Refresh
  --- */

    refreshPositions() {

      this.resetSticky()
      this.getMenuPosition()

    }

    resetSticky() {

      this.side.style.position        = ''
      this.side.style.top             = ''
      this.side.style.left            = ''
      this.side.style.width           = ''
      this.side.style.transform       = ''
      this.side.style.webkitTransform = ''

    }

    getMenuPosition() {

      const position = this.side.getBoundingClientRect()
      const data     = {
        top   : position.top + getCurrentScroll(),
        left  : position.left,
        width : this.side.offsetWidth,
        max   : this.wrapper.offsetHeight - this.side.offsetHeight
      }

      this.positions = data

    }

  /* ---
    Set sticky
  --- */

    boxSticky(isScroll = true) {

      let offsetTop = this.header.offsetHeight + this.headerOffset
      let scrollTop = getCurrentScroll() + offsetTop

      if (scrollTop >= (this.positions.top + this.positions.max)) {

        this.side.style.position        = ''
        this.side.style.top             = ''
        this.side.style.left            = ''
        this.side.style.width           = ''
        this.side.style.transform       = 'translateY(' + this.positions.max + 'px)'
        this.side.style.webkitTransform = 'translateY(' + this.positions.max + 'px)'

      } else if (scrollTop >= this.positions.top) {

        this.side.style.position        = 'fixed'
        this.side.style.top             = offsetTop + 'px'
        this.side.style.left            = this.positions.left + 'px'
        this.side.style.width           = this.positions.width + 'px'
        this.side.style.transform       = ''
        this.side.style.webkitTransform = ''

      } else {

        this.resetSticky()

      }

      if (isScroll && this.checkMax)
        this.detectHeaderResize()

    }

    detectHeaderResize() {

      if (this.detectTimeout)
        clearTimeout(this.detectTimeout)

      if (this.checkCount > this.checkMax) {

        this.checkCount = 0
        return

      }

      this.detectTimeout = setTimeout(() => {

        this.checkCount++

        this.boxSticky(false)
        this.detectHeaderResize()

      }, 10)

    }

}