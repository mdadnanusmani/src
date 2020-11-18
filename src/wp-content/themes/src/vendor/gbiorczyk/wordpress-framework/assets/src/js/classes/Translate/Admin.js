class WordPressFramework_Translate_Admin {

  constructor() {

    if (!this.setVars())
      return
    
    this.setEvents()

  }

  setVars() {

    this.switcher = document.querySelector('select[name=post_lang_choice]')

    if (!this.switcher)
      return

    this.default = this.switcher.value

    return true

  }

  setEvents() {

    this.switcher.addEventListener('change', (e) => { this.lockChange(e) })

  }

  lockChange(e) {

    const answer = confirm(wpF.adminTranslate.polylang_switcher)

    if (!answer) {

      this.switcher.value = this.default
      e.preventDefault()

    } else {

      this.default = this.switcher.value

    }

  }

}

new WordPressFramework_Translate_Admin()