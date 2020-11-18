class Table {

  constructor() {

    const list = document.querySelectorAll('.table')

    list.each((section) => {
      new TableCore(section)
    })

  }

}

class TableCore {

  constructor(section) {

    this.section = section

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    if (!this.section)
      return

    this.headerCell = this.section.querySelector('.table__row:nth-child(2) .table__cell')
    this.hiddenCell = this.section.querySelector('.table__row:nth-child(1) .table__cell')

    return true

  }

  setEvents() {

    window.addEventListener('load', () => {
      this.resizeCell()
    })

    window.addEventListener('resize', () => {
      this.resizeCell()
    })

  }

  resizeCell() {

    const width = this.headerCell.offsetWidth
    this.hiddenCell.style.width = width + 'px'

  }

}