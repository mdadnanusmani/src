class JobsList {

  constructor() {

    const list = document.querySelectorAll('.jobsList')

    list.each((section) => {
      new JobsListCore(section)
    })

  }

}

class JobsListCore {

  constructor(section) {

    this.section = section

    if (!this.setVars())
      return

    this.initSelectr()
    this.setEvents()

  }

  setVars() {

    if (!this.section)
      return

    this.wrapper     = this.section.querySelector('.jobsList__items')
    this.items       = this.wrapper.querySelectorAll('.jobsList__item')
    this.select      = this.section.querySelector('.jobsList__selectField')
    this.more        = this.section.querySelector('.jobsList__more')
    this.pageCount   = parseInt(this.wrapper.getAttribute('data-page-limit'))
    this.currentPage = 0
    this.visibleList = this.items

    return true

  }

  setEvents() {

    this.select.addEventListener('change', (e) => {
      this.showItems(e.currentTarget.value)
    })

    this.more.addEventListener('click', (e) => {

      e.preventDefault()
      this.showNextPage()

    })

  }

  initSelectr() {

    new Selectr(this.select, {
      searchable: false
    })

  }

  showItems(category) {

    this.items.removeClass('jobsList__item--active')

    this.visibleList = (category != '') ? this.wrapper.querySelectorAll('.jobsList__item[data-category="' + category + '"]') : this.items
    this.currentPage = 0
    this.showItemsPage()

  }

  showItemsPage() {

    const index = this.currentPage * this.pageCount
    const max   = index + this.pageCount

    this.visibleList.each((item, index) => {

      if (!item)
        return true

      if (index == max)
        return false

      item.addClass('jobsList__item--active')

    })

    if (this.visibleList.length > max)
      this.more.addClass('jobsList__more--active')
    else
      this.more.removeClass('jobsList__more--active')

  }

  showNextPage() {

    this.currentPage++
    this.showItemsPage()

  }

}