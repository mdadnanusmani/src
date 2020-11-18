class AnimationNumber {

  constructor() {

    if (!this.setVars())
      return

    this.initStats()

  }

  setVars() {

    this.items = document.querySelectorAll('*[data-animation-number]')

    if (!this.items.length)
      return

    this.animations = []
    this.isArabic   = (document.documentElement.getAttribute('dir') == 'rtl')

    return true

  }

  initStats() {

    this.items.each((item, index) => {

      item.addCustomEvent('show-item', () => {
        this.showStat(index)
      })

    })

  }

  showStat(index) {

    const wrapper = this.items[index].querySelector('*[data-number]')

    wrapper.innerHTML      = '0'
    const value            = parseInt(wrapper.getAttribute('data-number'))
    this.animations[index] = new Animation()

    this.animations[index].start(
      0,
      value,
      2500,
      'easeOutQuart',
      (value, element, suffix) => { this.increaseNumber(value, wrapper, wrapper.getAttribute('data-suffix')) }
    )

  }

  increaseNumber(value, element, suffix) {

    value = Math.round(value).toString()
    value = value.replace(/\B(?=(\w{3})+(?!\w))/g, ' ')

    if (this.isArabic)
      value = arabicNumbers(value)

    if (suffix != '')
      element.innerHTML = '<span>' + value + '</span>' + '<span>' + suffix + '</span>'
    else
      element.innerHTML = '<span>' + value + '</span>'

  }


}