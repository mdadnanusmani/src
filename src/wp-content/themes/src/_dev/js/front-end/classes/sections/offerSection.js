class OfferSection {

  constructor() {

    if (!this.setVars())
      return

    this.initStickySide()

  }

  setVars() {

    this.section = document.querySelector('.offerSection')

    if (!this.section)
      return

    this.wrapper = this.section.querySelector('.offerSection__wrapper')
    this.side    = this.section.querySelector('.offerSection__box')
    this.header  = document.querySelector('.header')

    return true

  }

  initStickySide() {

    new StickySide({
      wrapper          : this.wrapper,
      side             : this.side,
      header           : this.header,
      headerTransition : 300,
      headerOffset     : 30
    })

  }

}