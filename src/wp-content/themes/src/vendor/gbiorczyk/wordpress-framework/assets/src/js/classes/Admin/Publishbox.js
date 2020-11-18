window.addEventListener('load', () => {
  new WordPressFramework_Admin_Publishbox()
})

class WordPressFramework_Admin_Publishbox {

  constructor() {

    if (!this.setVars())
      return
    
    this.setEvents()

  }

  setVars() {

    this.section = document.querySelector('form[action="post.php"]')

    if (!this.section)
      return

    this.side       = this.section.querySelector('#side-sortables')
    this.box        = this.side.querySelector('#submitdiv')
    this.saveButton = this.box.querySelector('#publish')
    this.adminBar   = document.querySelector('#wpadminbar')
    this.config     = {
      'post_id'    : this.section.querySelector('#post_ID').getAttribute('value'),
      'offset'     : (this.side.getBoundingClientRect().top + window.pageYOffset + this.side.offsetHeight) - this.adminBar.offsetHeight,
      'key_prefix' : 'current_scroll_'
    }
    this.isSafari   = /^((?!chrome|android).)*safari/i.test(navigator.userAgent.toLowerCase())
    this.bodyScroll = this.isSafari ? (document.body || document.documentElement) : (document.documentElement || document.body)

    return true

  }

  setEvents() {

    window.addEventListener('load', () => {
      this.restoreScrollPosition()
    })

    window.addEventListener('scroll', () => {
      this.sideBoxSticky()
    })

    this.saveButton.addEventListener('click', () => {
      this.saveScrollPosition()
    })

  }

  restoreScrollPosition() {

    const key = this.config.key_prefix + this.config.post_id
    let value = sessionStorage.getItem(key)

    if (!value)
      return

    value = parseInt(value) + this.getNoticesHeight()
    this.bodyScroll.scrollTop = value

  }

  sideBoxSticky() {

    if (this.bodyScroll.scrollTop >= this.config.offset)
      $(this.box).addClass('sticky')
    else
      $(this.box).removeClass('sticky')

  }

  saveScrollPosition() {

    const key   = this.config.key_prefix + this.config.post_id
    const value = this.bodyScroll.scrollTop - this.getNoticesHeight()

    sessionStorage.setItem(key, value)

  }

  getNoticesHeight() {

    const notices = document.querySelectorAll('#wpbody-content > .wrap > .notice')
    const length  = notices.length
    let heights   = 0

    for (let i = 0; i < length; i++) {

      if ($(notices[i]).hasClass('hidden'))
        continue

      const styles = getComputedStyle(notices[i])
      const height = notices[i].offsetHeight + parseInt(styles.marginTop) + parseInt(styles.marginBottom)

      heights += height
    
    }

    return heights

  }

}