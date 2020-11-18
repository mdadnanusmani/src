window.addEventListener('load', () => {
  new WordPressFramework_Forms_Posttype()
})

class WordPressFramework_Forms_Posttype {

  constructor() {

    if (!this.setVars())
      return

    this.regenerateShortcodes()
    this.setEvents()

  }

  setVars() {

    this.section = document.querySelector('.acf-field-repeater[data-name="fields"]')

    if (!this.section)
      return

    this.wrapper = this.section.querySelector(':scope > .acf-input > .acf-repeater > .acf-table > tbody')
    this.info    = this.section.parentNode.querySelector('.acf-field-message .acf-input')

    return true

  }

  setEvents() {

    $('body').on('keyup', '.acf-field-repeater[data-name="fields"] .acf-field-text[data-name="name"] input', () => {
      this.regenerateShortcodes()
    })

  }

  regenerateShortcodes() {

    const items = this.wrapper.querySelectorAll(':scope > .acf-row')
    const list  = []

    const length = items.length
    for (let i = 0; i < length; i++) {

      if (items[i].getAttribute('data-id') == 'acfcloneindex')
        continue

      let value = items[i].querySelector('.acf-field-text[data-name="name"] input').value
      list.push(value)

    }

    const message       = list ? '<strong>[' + list.join(']</strong><strong>[') + ']</strong>' : ''
    this.info.innerHTML = message

  }

}