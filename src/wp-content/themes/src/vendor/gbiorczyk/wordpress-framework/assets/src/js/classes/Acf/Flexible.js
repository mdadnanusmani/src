class WordPressFramework_Acf_Flexible {

  constructor() {

    if (!this.setVars())
      return
    
    this.setEvents()
    this.getDefaultRows()
    this.hideItems()

  }

  setVars() {

    this.rows = document.querySelectorAll('.acf-field[data-name=fc_layout]')

    if (!this.rows.length)
      return

    this.list = [];

    return true

  }

  setEvents() {

    $('body').on('click', '.acf-fl-actions .duplicate-layout, .acf-fl-actions .add-layout', () => {
      this.openNewItem()
    })

  }

  getDefaultRows() {

    const length = this.rows.length
    for (let i = 0; i < length; i++)
      this.list.push(this.rows[i])

  }

  hideItems() {

    const length = this.rows.length
    for (let i = 0; i < length; i++) {

      const duplicate = this.rows[i].querySelector('.acf-fc-duplicate')
      const toggle    = document.createElement('a')
      toggle.setAttribute('href', '#')
      $(toggle).addClass('acf-flexible-toggle')
      $(toggle).addClass('button')
      $(toggle).addClass('button-primary')
      toggle.innerHTML = wpF.adminTranslate.acf_flexible_expand

      const wrapper = this.rows[i].querySelector('.acf-input')
      wrapper.appendChild(toggle)

      const list = this.rows[i].querySelector('.acf-field-list-wrap')
      $(list).addClass('acf-flexible-hidden')

      toggle.addEventListener('click', (e) => {

        e.preventDefault()

        const parent = toggle.parentNode
        const list   = parent.querySelector('.acf-field-list-wrap')
        $(list).removeClass('acf-flexible-hidden')
        parent.removeChild(toggle)
      
      });

    }

  }

  openNewItem() {

    const rows   = document.querySelectorAll('.acf-field[data-name=fc_layout]')
    const length = rows.length
    for (let i = 0; i < length; i++) {

      if (this.list.indexOf(rows[i]) > -1)
        continue

      const toggle = rows[i].querySelector('.acf-flexible-toggle')
      const list   = rows[i].querySelector('.acf-flexible-hidden')

      if (toggle)
        toggle.parentNode.removeChild(toggle)

      if (list)
        $(list).removeClass('acf-flexible-hidden')

    }

  }

}

new WordPressFramework_Acf_Flexible()