class Menu {

  constructor() {

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    this.menu = document.querySelector('.header__menuMobile')

    if (!this.menu)
      return

    this.toggle   = document.querySelector('.header__toggle')
    this.isArabic = (document.documentElement.getAttribute('dir') == 'rtl')

    return true

  }

  setEvents() {

    /* ---
      Touch closing
    --- */

      this.menu.addEventListener('touchstart', (e) => {
        this.startPageX = e.touches[0].pageX;
      })

      this.menu.addEventListener('touchmove', (e) => {
        this.endPageX = e.touches[0].pageX;
      })

      this.menu.addEventListener('touchend', (e) => {

        if (!this.endPageX || (this.startPageX == this.endPageX))
          return

        if ((!this.isArabic && (this.endPageX < (this.startPageX + 50))) || (this.isArabic && (this.endPageX > (this.startPageX - 50))))
          return

        this.toggle.removeClass('header__toggle--active')
        this.menu.removeClass('header__menuMobile--open')
      
      })

    /* ---
      Click closing
    --- */

      document.addEventListener('click', (e) => {

        this.toggle.removeClass('header__toggle--active')
        this.menu.removeClass('header__menuMobile--open')
      
      })

      this.menu.addEventListener('click', (e) => {

        e.stopPropagation()
      
      })

      this.toggle.addEventListener('click', (e) => {
      
        e.preventDefault()
        e.stopPropagation()

        this.toggle.toggleClass('header__toggle--active')
        this.menu.toggleClass('header__menuMobile--open')
      
      })

  }

}