class IntranetProfile {

  constructor() {

    if (!this.setVars())
      return

    this.setContactsHeight()
    this.setEvents()

  }

  setVars() {

    this.section = document.querySelector('.intranetProfile')

    if (!this.section)
      return

    this.buttons       = this.section.querySelectorAll('.intranetProfile__tabsItem')
    this.wrapper       = this.section.querySelector('.intranetProfile__tabsNewsItems')
    this.items         = this.wrapper.querySelectorAll('.intranetProfile__tabsNewsItem')
    this.more          = this.section.querySelector('.intranetProfile__tabsMore')
    this.sideOuter     = this.section.querySelector('.intranetProfile__sideOuter')
    this.sideInner     = this.sideOuter.querySelector('.intranetProfile__sideInner')
    this.contacts      = this.sideInner.querySelector('.intranetProfile__contactItems')
    this.pageCount     = parseInt(this.wrapper.getAttribute('data-page-limit'))
    this.searchInput   = this.sideInner.querySelector('.intranetProfile__searchInput')
    this.searchButton  = this.sideInner.querySelector('.intranetProfile__searchButton')
    this.users         = this.contacts ? this.contacts.querySelectorAll('.personInfo') : []
    this.usersFavorite = this.contacts ? this.contacts.querySelectorAll('.personInfo__star') : []
    this.currentPage   = 0

    let currentCategory = this.buttons[0].getAttribute('data-category')
    this.visibleList    = this.wrapper.querySelectorAll('.intranetProfile__tabsNewsItem[data-category="' + currentCategory + '"]')

    return true

  }

  setEvents() {

    /* ---
      Tabs
    --- */

    this.buttons.each((item, index) => {

      item.addEventListener('click', (e) => {
        e.preventDefault()
        this.showItems(index)
      })

    })

    this.more.addEventListener('click', (e) => {
      e.preventDefault()
      this.showNextPage()
    })

    /* ---
      Users
    --- */

      window.addEventListener('resize', (e) => {
        this.setContactsHeight()
      })

      this.searchInput.addEventListener('keyup', (e) => {
        this.findUsers()
      })

      this.searchButton.addEventListener('click', (e) => {
        e.preventDefault()
        this.findUsers()
      })

      this.usersFavorite.each((item, index) => {

        item.addEventListener('click', (e) => {
          e.preventDefault()
          this.switchUser(index)
        })

      })

  }

  /* ---
    Users search
  --- */

    findUsers() {

      this.users.removeClass('personInfo--hidden')
      let text = this.clearString(this.searchInput.value)

      if (text == '')
        return

      this.users.each((item) => {

        let content = this.clearString(item.innerHTML)

        if (content.indexOf(text) == -1)
          item.addClass('personInfo--hidden')

      })

    }

    clearString(string) {

      string = string.replace(/<(?:.|\n)*?>/gm, ' ')
      string = string.replace(/[^a-zA-Z0-9 ]/gi, ' ')
      string = string.replace(/\s\s+/g, ' ')
      string = string.toLowerCase()

      return string

    }

  /* ---
    Contact height
  --- */

    setContactsHeight() {

      this.contacts.style.height = '0px'
      const height = this.sideOuter.offsetHeight - this.sideInner.offsetHeight

      this.contacts.style.height = height + 'px'

    }

  /* ---
    News categories
  --- */

    showItems(index) {

      let category = this.buttons[index].getAttribute('data-category')

      this.buttons.removeClass('intranetProfile__tabsItem--active')
      this.buttons[index].addClass('intranetProfile__tabsItem--active')
      this.items.removeClass('intranetProfile__tabsNewsItem--active')

      this.visibleList = (category != '') ? this.wrapper.querySelectorAll('.intranetProfile__tabsNewsItem[data-category="' + category + '"]') : this.items
      this.currentPage = 0
      this.showItemsPage()

    }

    showItemsPage() {

      const index = this.currentPage * this.pageCount
      const max   = index + this.pageCount

      this.visibleList.each((item, index) => {

        if (!item)
          return true

        if (index == max)
          return false

        item.addClass('intranetProfile__tabsNewsItem--active')

      })

      if (this.visibleList.length > max)
        this.more.addClass('intranetProfile__tabsMore--active')
      else
        this.more.removeClass('intranetProfile__tabsMore--active')

      this.setContactsHeight()

    }

    showNextPage() {

      this.currentPage++
      this.showItemsPage()

    }

  /* ---
    Favorites users
  --- */

    switchUser(index) {

      let _this = this
      let xhttp = new XMLHttpRequest()

      xhttp.onreadystatechange = function() { _this.switchUserClass(this, wrapper) }

      const wrapper = this.users[index]
      const userId  = wrapper.getAttribute('data-user-id')

      const url = wpF.ajaxurl + '?action=intranet_favorite&user_id=' + userId
      xhttp.open('GET', url, true)
      xhttp.send()

    }

    switchUserClass(response, wrapper) {

      if ((response.readyState != 4) || (response.status != 200))
        return

      wrapper.toggleClass('personInfo--favorite')

    }

}