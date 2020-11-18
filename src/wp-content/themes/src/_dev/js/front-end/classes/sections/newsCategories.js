class NewsCategories {

  constructor() {

    if (!this.setVars())
      return

    this.initStickySide()
    this.setEvents()

  }

  setVars() {

    this.section = document.querySelector('.newsCategories')

    if (!this.section)
      return

    this.wrapper = this.section.querySelector('.newsCategories__wrapper')
    this.side    = this.section.querySelector('.newsCategories__categories')
    this.header  = document.querySelector('.header')
    this.cats    = this.side ? this.side.querySelectorAll('.newsCategories__categoryLink') : []
    this.posts   = this.section.querySelector('.newsCategories__items')
    this.more    = this.section.querySelector('.newsCategories__more')
    this.limit   = parseInt(this.posts.getAttribute('data-limit'))

    return true

  }

  setEvents() {

    this.more.addEventListener('click', (e) => {
      e.preventDefault()
      this.loadMore()
    })

    this.cats.each((item, index) => {

      item.addEventListener('click', (e) => {
        e.preventDefault()
        this.getPosts(index)
      })

    })

  }

  /* ---
    Sticky side
  --- */

    initStickySide() {

      if (!this.side)
        return

      this.stickySide = new StickySide({
        wrapper          : this.wrapper,
        side             : this.side,
        header           : this.header,
        headerTransition : 300,
        headerOffset     : 20
      })

    }

  /* ---
    Load more
  --- */

    loadMore() {

      const list = this.posts.querySelectorAll('.newsCategories__item--hidden')

      list.each((item, index) => {

        if ((index + 1) > this.limit)
          return

        item.removeClass('newsCategories__item--hidden')

      })

      this.checkMoreButton()

    }

    checkMoreButton() {

      const list = this.posts.querySelectorAll('.newsCategories__item--hidden')

      if (list.length)
        this.more.removeClass('newsCategories__more--hidden')
      else
        this.more.addClass('newsCategories__more--hidden')

    }

  /* ---
    Load posts
  --- */

    getPosts(index) {

      let _this = this
      let xhttp = new XMLHttpRequest()

      xhttp.onreadystatechange = function() { _this.showPosts(this, url) }

      const url = this.cats[index].getAttribute('href')
      xhttp.open('GET', url + '?ajax', true)
      xhttp.send()

      this.posts.addClass('newsCategories__items--loading')
      this.cats.removeClass('newsCategories__categoryLink--active')
      this.cats[index].addClass('newsCategories__categoryLink--active')

    }

    showPosts(response, url) {

      if ((response.readyState != 4) || (response.status != 200))
        return

      this.posts.innerHTML = response.responseText
      this.posts.removeClass('newsCategories__items--loading')

      window.history.replaceState({}, document.title, url)

      this.checkMoreButton()
      this.stickySide.refreshPositions()

    }

}