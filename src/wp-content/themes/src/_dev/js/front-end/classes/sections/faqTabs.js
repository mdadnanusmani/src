class FaqTabs {

  constructor() {

    const list = document.querySelectorAll('.faqTabs')

    list.each((section) => {
      new FaqTabsCore(section)
    })

  }

}

class FaqTabsCore {

  constructor(section) {

    this.section = section

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    if (!this.section)
      return

    this.categories      = this.section.querySelectorAll('.faqTabs__categoryLink')
    this.items           = this.section.querySelectorAll('.faqTabs__item')
    this.questions       = this.section.querySelectorAll('.faqTabs__question')
    this.questionsToggle = this.section.querySelectorAll('.faqTabs__questionToggle')
    this.questionsTitle  = this.section.querySelectorAll('.faqTabs__questionTitle')

    return true

  }

  setEvents() {

    this.questions.each((item, index) => {

      item.addEventListener('click', (e) => {  
        e.preventDefault()
        this.showQuestion(index)
      })

      item.addEventListener('click', (e) => {
        e.preventDefault()
        this.showQuestion(index)
      })

    })

    this.categories.each((item, index) => {

      item.addEventListener('click', (e) => {
        e.preventDefault()
        this.showItem(index)
      })

    })

  }

  showQuestion(current) {

    if (this.questions[current].hasClass('faqTabs__question--active'))
      return

    this.questions.removeClass('faqTabs__question--active')
    this.questions[current].addClass('faqTabs__question--active')

    let wrapper = this.questions[current].querySelector('.faqTabs__questionWrapper')

    TweenLite.set(wrapper, { height: 'auto' })
    TweenLite.from(wrapper, 0.5, { height: 0 })

    this.questions.each((item, index) => {

      if (index == current)
        return
    
      let wrapper = item.querySelector('.faqTabs__questionWrapper')
      TweenLite.to(wrapper, 0.5, { height: 0 })

    })

  }

  showItem(index) {

    this.categories.removeClass('faqTabs__categoryLink--active')
    this.categories[index].addClass('faqTabs__categoryLink--active')
    this.items.removeClass('faqTabs__item--active')
    this.items[index].addClass('faqTabs__item--active')

  }

}