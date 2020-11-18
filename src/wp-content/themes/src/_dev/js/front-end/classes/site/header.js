class Header {

  constructor() {

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    this.header = document.querySelector('.header')

    if (!this.header)
      return

    this.prevScroll   = getCurrentScroll()
    this.search       = this.header.querySelector('.header__menuSearch')
    this.searchButton = this.search ? this.search.querySelector('.header__menuSearchButton') : null

    return true

  }

  setEvents() {

    window.addEventListener('load',   () => { this.headerSticky() })
    window.addEventListener('scroll', () => { this.headerSticky() })

    /* ---
      Search form
    --- */

      if (this.search) {

        const documentClick = () => {

          this.search.removeClass('header__menuSearch--active')

          document.removeEventListener('click',    documentClick)
          this.search.removeEventListener('click', wrapperClick)

        }

        const wrapperClick = (e) => {

          e.stopPropagation()

        }

        this.searchButton.addEventListener('click', (e) => {
        
          if (this.search.hasClass('header__menuSearch--active'))
            return

          e.preventDefault()
          this.search.addClass('header__menuSearch--active')

          document.addEventListener('click',    documentClick)
          this.search.addEventListener('click', wrapperClick)
        
        })

      }

  }

  headerSticky() {

    let scrollTop = getCurrentScroll()

    if (scrollTop > (this.prevScroll + 100)) {

      this.header.removeClass('header--topVisible')
      this.prevScroll = scrollTop

    } else if (scrollTop < this.prevScroll) {

      this.header.addClass('header--topVisible')
      this.prevScroll = scrollTop

    }

    if (scrollTop > 0) {

      this.header.addClass('header--sticky')

    } else {

      this.header.removeClass('header--sticky')
      this.header.removeClass('header--topVisible')

    }

  }

}