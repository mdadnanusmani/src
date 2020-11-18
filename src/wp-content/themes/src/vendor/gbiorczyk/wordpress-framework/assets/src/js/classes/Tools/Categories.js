window.addEventListener('load', () => {
  new WordPressFramework_Tools_Categories()
})

class WordPressFramework_Tools_Categories {

  constructor() {

    if (!this.setVars())
      return

    this.getCategories()
    this.setEvents()

  }

  setVars() {

    this.form  = document.querySelector('form[name=post]')
    this.terms = document.querySelectorAll('.categorydiv')

    if (!wpF.categories || !this.form || !this.terms.length)
      return

    this.buttonSubmit = document.querySelector('#publish')
    this.buttonSave   = document.querySelector('#save-post')
    this.list         = wpF.categories.list
    this.alerts       = wpF.categories.alerts

    return true

  }

  setEvents() {

    const eventClick = (e) => {

      if (this.checkCategories())
        return

      e.preventDefault()
      e.stopPropagation()

    }

    this.buttonSubmit.addEventListener('click', eventClick)

    if (this.buttonSave)
      this.buttonSave.addEventListener('click', eventClick)

  }

  getCategories() {

    let list = []

    const length = this.list.length
    for (let i = 0; i < length; i++) {

      const wrapper     = document.querySelector('#' + this.list[i].slug + 'div')
      let issetPostType = false

      const pLength = this.list[i].post_types.length
      for (let j = 0; j < pLength; j++) {

        if ($('body').hasClass('post-type-' + this.list[i].post_types[j])) {

          issetPostType = true
          break

        }

      }

      if (!wrapper || !issetPostType)
        continue

      list.push({
        'min'     : this.list[i].min_checked,
        'max'     : this.list[i].max_checked,
        'wrapper' : wrapper.querySelector('#' + this.list[i].slug + '-all ul')
      })

    }

    this.categories = list

  }

  checkCategories(e) {

    this.removeAlerts()

    const length = this.categories.length
    for (let i = 0; i < length; i++) {

      const empty   = this.categories[i].wrapper.querySelector('input[type="checkbox"][value="1"]:checked')
      const checked = this.categories[i].wrapper.querySelectorAll('input[type="checkbox"]:checked')
      const count   = checked.length - (empty ? 1 : 0)
      const isError = false

      if ((this.categories[i].min > -1) && (count < this.categories[i].min)) {

        this.showAlert(this.categories[i], 'min')
        return false

      } else if ((this.categories[i].max > -1) && (count > this.categories[i].max)) {

        this.showAlert(this.categories[i], 'max')
        return false

      }

    }

    return true

  }

  removeAlerts() {

    let alerts = document.querySelectorAll('.wfCategoryAlert')

    const length = alerts.length
    for (let i = 0; i < length; i++)
      alerts[i].parentNode.removeChild(alerts[i])

  }

  showAlert(category, mode) {

    const title = category.wrapper.parentNode.parentNode.parentNode.parentNode.querySelector('h2 span').innerHTML
    const alert = document.createElement('div')
    let message = ''

    $(alert).addClass('wfCategoryAlert')
    $(alert).addClass('notice')
    $(alert).addClass('notice-error')

    if (mode == 'min') {

      message = this.alerts.min
      message = message.replace('%s', '<strong>' + title + '</strong>')
      message = message.replace('%d', '<strong>' + category.min + '</strong>')

    } else if (mode == 'max') {

      message = this.alerts.max
      message = message.replace('%s', '<strong>' + title + '</strong>')
      message = message.replace('%d', '<strong>' + category.max + '</strong>')

    }

    alert.innerHTML = '<p>' + message + '</p>'
    this.form.insertBefore(alert, this.form.children[0])

    $('html, body').animate({ scrollTop: 0 }, 1000)

  }

}