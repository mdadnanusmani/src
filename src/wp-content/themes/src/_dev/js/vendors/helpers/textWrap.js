/* ---
  Text wrap
--- */

  Element.prototype.textWrap = function() {

    let title = this.getAttribute('data-title')

    if (!title) {

      title = this.innerHTML
      this.setAttribute('title',      title.replace(/<[^>]+>[^<]{0,}<\/[^>]+>/ig, '').replace(/<[^>]+>/ig, ''))
      this.setAttribute('data-title', title)

    }

    this.innerHTML = title

    const height = this.offsetHeight
    const width  = this.offsetWidth

    this.style.position  = 'absolute'
    this.style.width     = width + 'px'
    this.style.height    = 'auto'
    this.style.maxHeight = 'inherit'

    let currentHeight   = this.offsetHeight
    let words           = title.split(' ');
    const count         = words.length
    let number          = 0

    while (currentHeight > height) {

      number++

      title = words.slice(0, (count - number)).join(' ') + '...'
      this.innerHTML = title

      currentHeight = this.offsetHeight

    }

    if (this.getAttribute('data-title') == title)
      this.removeAttribute('title')

    this.style.position  = ''
    this.style.width     = ''
    this.style.height    = ''
    this.style.maxHeight = ''

  }

  NodeList.prototype.textWrap = function() {

    const length = this.length

    for (let i = 0; i < length; i++)
      this[i].textWrap()

  }

  HTMLCollection.prototype.textWrap = NodeList.prototype.textWrap