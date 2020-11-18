class TeamPeople {

  constructor() {

    const list = document.querySelectorAll('.teamPeople')

    list.each((section) => {
      new TeamPeopleCore(section)
    })

  }

}

class TeamPeopleCore {

  constructor(section) {

    this.section = section

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    if (!this.section)
      return

    this.wrappers      = this.section.querySelectorAll('.gSlider')
    this.sliders       = []
    this.tabs          = this.section.querySelectorAll('.teamPeople__category')
    this.items         = this.section.querySelectorAll('.teamPeople__item')
    this.popupsButtons = this.section.querySelectorAll('.teamPeople__sliderItem')
    this.popups        = []

    return true

  }

  setEvents() {

    window.addEventListener('load', (e) => {
      setTimeout(() => { this.initSliders() }, 0)
    })

    window.addEventListener('resize', (e) => {
      this.refreshSliders()
    })

    this.tabs.each((item, index) => {

      item.addEventListener('click', (e) => {
        e.preventDefault()
        this.toggleItems(index)
      })

    })

    this.popupsButtons.each((item, index) => {

      item.addEventListener('click', (e) => {
        e.preventDefault()
        this.openPopup(index)
      })

    })

  }

  initSliders() {

    this.wrappers.each((item, index) => {

      this.sliders[index] = new gSlider({
        wrapper     : item,
        orientation : 'horizontal',
        items       : (window.innerWidth >= 1024) ? 4 : (window.innerWidth >= 768) ? 3 : (window.innerWidth >= 480) ? 2 : 1
      })

    })

  }

  refreshSliders() {

    this.sliders.each((item) => {

      item.config.items = (window.innerWidth >= 1024) ? 4 : (window.innerWidth >= 768) ? 3 : (window.innerWidth >= 480) ? 2 : 1
      item.refresh()

    })

  }

  toggleItems(index) {

    this.tabs.removeClass('teamPeople__category--active')
    this.tabs[index].addClass('teamPeople__category--active')

    this.items.removeClass('teamPeople__item--active')
    this.items[index].addClass('teamPeople__item--active')

    this.sliders[index].refresh()

  }

  openPopup(index) {

    if (this.popupsButtons[index].closest('.gSlider__itemsOuter').hasClass('gSlider__itemsOuter--move'))
      return

    if (!this.popups[index]) {

      const popup = this.popupsButtons[index].querySelector('.peoplePopup')

      document.body.appendChild(popup)
      this.popups[index] = popup

    }

    const inner = this.popups[index].querySelector('.peoplePopup__inner')

    this.popups[index].addClass('peoplePopup--active')
    Scroll.lock()

    this.popups[index].addEventListener('click', (e) => {
      this.popups[index].removeClass('peoplePopup--active')
      Scroll.unlock()
    })

    inner.addEventListener('click', (e) => {
      e.stopPropagation()
    })

  }

}