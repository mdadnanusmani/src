window.addEventListener('load', () => {
  new WordPressFramework_Admin_Bar()
})

class WordPressFramework_Admin_Bar {

  constructor() {

    if (!this.setVars())
      return
    
    this.setEvents()

  }

  setVars() {

    this.bar = document.querySelector('#wpadminbar')

    if (!this.bar)
      return

    this.toggleButton = this.bar.querySelector('#wp-admin-bar-wp-logo > .ab-item')
    this.showBar      = (localStorage.adminBar && (localStorage.adminBar === true))

    return true

  }

  setEvents() {

    this.toggleButton.addEventListener('click', (e) => {
    
      e.preventDefault()
      this.toggleBar()
    
    })

  }

  toggleBar() {

    if (!this.showBar) {

      this.bar.classList.add('open')
      localStorage.adminBar = true
      this.showBar          = true

    } else {

      this.bar.classList.remove('open')
      localStorage.adminBar = false
      this.showBar          = false

    }

  }

}