class SectionLink {

  constructor() {

    if (this.setVars())
      this.setEvents()

  }

  setVars() {

    this.links      = document.querySelectorAll('a[href^="#"]')
    this.scrollTime = 1000

    return true

  }

  setEvents() {

    if (this.links) {

      this.links.each((item) => {

        item.addEventListener('click', (e) => {
          this.scrollToSection(e)
        })
        
      })

    }

    window.addEventListener('load', () => {

      if (!window.location.hash)
        return

      this.findSection(window.location.hash)
      window.history.replaceState({}, document.title, window.location.href.split('#')[0])
    
    })

  }

  scrollToSection(e) {

    let href = e.currentTarget.getAttribute('href')

    if (href == '#')
      return

    if (this.findSection(href))
      e.preventDefault()

  }

  findSection(hash) {

    hash = hash.substr(1)
    const section = document.querySelector('.section[data-name="' + hash + '"]')

    if (!section)
      return

    const scroll = (getCurrentScroll() + section.getBoundingClientRect().top) - 100
    TweenLite.to(window, (this.scrollTime / 1000), {scrollTo : scroll })

    return true

  }

}