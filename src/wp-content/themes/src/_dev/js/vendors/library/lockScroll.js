/* ---
 
  How to use?

    • include this file
    • use functions in your JS code:

      • lock scrolling:
        Scroll.lock()

      • unlock scrolling:
        Scroll.unlock()

--- */

class ScrollCore {

  constructor() {

    this.touchStart = 0
    this.scrollY    = 0

    this.actionTouch      = (e) => { this.touchStart = e.touches[0].pageY }
    this.actionScroll     = (e) => { this.findScrollableElementInside(e) }
    this.actionLockScroll = (e) => { window.scroll(0, this.scrollY) }

  }

  /* ---
    Lock scroll
  --- */

    lock() {

      this.scrollY = window.scrollY || window.pageYOffset || document.documentElement.scrollTop

      window.addEventListener('mousewheel', this.actionScroll, { passive: false })
      window.addEventListener('touchmove',  this.actionScroll, { passive: false })
      window.addEventListener('touchstart', this.actionTouch)
      window.addEventListener('scroll',     this.actionLockScroll)

    }

  /* ---
    Unlock scroll
  --- */

    unlock() {

      window.removeEventListener('mousewheel', this.actionScroll, { passive: false })
      window.removeEventListener('touchmove',  this.actionScroll, { passive: false })
      window.removeEventListener('touchstart', this.actionTouch)
      window.removeEventListener('scroll',     this.actionLockScroll)

    }

  /* ---
    Find scrollable element inside
  --- */

    findScrollableElementInside(e) {

      let element      = e.target
      const touchStart = this.touchStart

      if (element === document) {

        e.preventDefault()
        return true

      }

      while (element.nodeName.toLowerCase() != 'body') {

        const overflowY   = window.getComputedStyle(element, null).getPropertyValue('overflow-y')
        const scrollingUp = e.wheelDelta ? (-e.wheelDelta < 0) : (e.touches[0].pageY > touchStart)

        if ((overflowY == 'scroll') || (overflowY == 'auto')) {

          if (!scrollingUp && (element.scrollTop < (element.scrollHeight - element.clientHeight)))
            return true
          else if (scrollingUp && (element.scrollTop > 0))
            return true

        }

        element = element.parentNode

      }

      e.preventDefault()
      return true

    }

}

const Scroll = new ScrollCore()