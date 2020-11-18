class HideScroll {

  constructor() {

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    this.items = document.querySelectorAll('.hideScroll')

    if (!this.items)
      return

    this.offsetTop    = 70
    this.offsetBottom = 50
    this.delay        = 200
    this.list         = []
    this.showList     = []

    return true

  }

  setEvents() {

    window.addEventListener('load', () => {

      setTimeout(() => {
        this.findItems()
        window.addEventListener('scroll', () => { this.showItems() })
      }, 0)

    })

  }

  /* ---
    Push items to cache
  --- */

    findItems(reload = false) {

      if (reload)
        this.items = document.querySelectorAll('.hideScroll')

      const scroll = getCurrentScroll()
      let list     = []

      this.items.each((item, index) => {

        if (item.hasClass('hideScroll--active'))
          return true

        const isFixed  = this.detectParentFixed(item)
        const position = item.getBoundingClientRect()
      
        item.addClass('hideScroll--hidden')

        list.push({
          index : index,
          dom   : item,
          top   : isFixed ? position.top : (position.top + scroll),
          left  : position.left
        })

      })

      list.sort(function(a, b) {

        if (a.top == b.top) {

          if (a.left == b.left)
            return 0;

          return (a.left < b.left) ? -1 : 1;

        }

        return (a.top < b.top) ? -1 : 1;

      })

      this.showItems(list, reload)

    }

    detectParentFixed(element) {

      if (window.getComputedStyle(element).getPropertyValue('position') == 'fixed')
        return true

      if (element.parentNode.nodeType == 1)
        return this.detectParentFixed(element.parentNode)

      return

    }

  /* ---
    Show items
  --- */

    showItems(list = this.list, noDelay = false) {

      if (!list.length)
        return

      this.currentTop    = getCurrentScroll() + this.offsetTop
      this.currentBottom = this.currentTop + window.innerHeight - this.offsetTop - this.offsetBottom

      let others = []

      list.each((item, index) => {

        if (item.top <= this.currentBottom)
          this.showList.push(item)
        else
          others.push(item)

      })

      this.list = others

      if (!this.timeout && this.showList.length)
        this.timeout = setTimeout(() => { this.showItem() }, (!noDelay ? this.delay : 0))

    }

    showItem() {

      clearTimeout(this.timeout)
      this.timeout = undefined

      if (!this.showList.length)
        return

      const item = this.showList.shift()
      let time   = this.delay

      if (item !== undefined) {

        time = (item.top > this.currentTop) ? time : 0

        item.dom.addClass('hideScroll--active')
        item.dom.bindCustomEvent('show-item')

        setTimeout(() => {

          item.dom.removeClass('hideScroll')
          item.dom.removeClass('hideScroll--left')
          item.dom.removeClass('hideScroll--right')
          item.dom.removeClass('hideScroll--hidden')
          item.dom.removeClass('hideScroll--active')

        }, 1000);

      }

      this.timeout = setTimeout(() => { this.showItem() }, time)

    }

}