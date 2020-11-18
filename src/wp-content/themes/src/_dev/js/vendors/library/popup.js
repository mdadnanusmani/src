class Popup {

  constructor(options) {

    this.inner = options

    if (this.setVars())
      this.setEvents()

  }

  setVars() {

    this.template = document.getElementById('popup-template')

    if (!this.template)
      return

    return true

  }

  setEvents() {

    this.openPopup()

  }

  openPopup() {

    const div     = document.createElement('div');
    div.innerHTML = this.template.innerHTML
    const content = div.querySelector('.popup')

    document.body.appendChild(content)
    Scroll.lock()

    const inner = content.querySelector('.popup__content')
    inner.appendChild(this.inner)

    content.addEventListener('click', () => {

      document.body.bindCustomEvent('popup-close')
      content.parentNode.removeChild(content)

      Scroll.unlock()

    })

    content.querySelector('.popup__inner').addEventListener('click', (e) => {

      e.stopPropagation()

    })

    content.querySelector('.popup__prev').addEventListener('click', (e) => {

      e.preventDefault()

      document.body.bindCustomEvent('popup-prev')
      content.parentNode.removeChild(content)

    })

    content.querySelector('.popup__next').addEventListener('click', (e) => {

      e.preventDefault()

      document.body.bindCustomEvent('popup-next')
      content.parentNode.removeChild(content)

    })

  }

}