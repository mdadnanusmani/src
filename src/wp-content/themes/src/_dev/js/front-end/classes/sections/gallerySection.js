class GallerySection {

  constructor() {

    const list = document.querySelectorAll('.gallerySection')

    list.each((section) => {
      new GallerySectionCore(section)
    })

  }

}

class GallerySectionCore {

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
    this.items   = this.wrapper.querySelectorAll('.gallerySection__item')
    this.limit   = this.items.length
    this.popup   = null

    return true

  }

  setEvents() {

    window.addEventListener('load', (e) => {
      setTimeout(() => { this.initSlider() }, 0)
    })

    window.addEventListener('resize', (e) => {
      this.slider.refresh()
    })

    this.items.each((item, index) => {

      item.addEventListener('click', (e) => {
      
        e.preventDefault()
        this.openPopup(index)
      
      })

    })

  }

  initSlider() {

    this.slider = new gSlider({
      wrapper     : this.wrapper,
      orientation : 'horizontal',
      items       : 'auto'
    })

  }

  openPopup(index) {

    let image = document.createElement('img')
    image.setAttribute('src', this.items[index].getAttribute('data-image'))

    this.popup = new Popup(image)

    document.body.addCustomEvent('popup-close', () => {
      this.closePopup()
    })

    document.body.addCustomEvent('popup-prev', () => {

      this.closePopup()

      index = (index > 0) ? (index - 1) : (this.limit - 1)
      this.openPopup(index)
      this.slider.setItem(index)

    })

    document.body.addCustomEvent('popup-next', () => {

      this.closePopup()

      index = (index < (this.limit - 1)) ? (index + 1) : 0
      this.openPopup(index)
      this.slider.setItem(index)

    })

  }

  closePopup() {

    document.body.removeCustomEvent('popup-close')
    document.body.removeCustomEvent('popup-prev')
    document.body.removeCustomEvent('popup-next')

  }

}