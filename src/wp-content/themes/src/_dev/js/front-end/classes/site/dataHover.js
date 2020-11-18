class DataHover {

  constructor() {

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    this.items    = document.querySelectorAll('*[data-hover]')
    this.length   = this.items.length
    this.template = document.getElementById('data-hover-template')

    if (!this.items.length || !this.template)
      return

    return true

  }

  setEvents() {

    this.items.each((item, index) => {
      this.loadHover(index)
    })

  }

  loadHover(index) {

    const div     = document.createElement('div');
    div.innerHTML = this.template.innerHTML
    const content = div.querySelector('svg')

    this.items[index].appendChild(content)

  }

}