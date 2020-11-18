class ProductsTabs {

  constructor() {

    const list = document.querySelectorAll('.productsTabs')

    list.each((section) => {
      new ProductsTabsCore(section)
    })

  }

}

class ProductsTabsCore {

  constructor(section) {

    this.section = section

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    if (!this.section)
      return

    this.tabs  = this.section.querySelectorAll('.productsTabs__button')
    this.items = this.section.querySelectorAll('.productsTabs__item')

    return true

  }

  setEvents() {

    this.tabs.each((item, index) => {

      item.addEventListener('click', (e) => {
        e.preventDefault()
        this.toggleItems(index)
      })

    })

  }

  toggleItems(index) {

    this.tabs.removeClass('productsTabs__button--active')
    this.tabs[index].addClass('productsTabs__button--active')

    this.items.removeClass('productsTabs__item--active')
    this.items[index].addClass('productsTabs__item--active')

  }

}