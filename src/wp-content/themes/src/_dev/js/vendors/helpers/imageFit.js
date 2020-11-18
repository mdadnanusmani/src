/* ---
  Image size fit
--- */

  Element.prototype.imageFit = function() {

    this.style.width     = ''
    this.style.height    = ''
    this.style.minWidth  = 'initial'
    this.style.minHeight = 'initial'

    const parentWidth  = this.parentNode.offsetWidth
    const parentHeight = this.parentNode.offsetHeight
    const parentRatio  = parentWidth / parentHeight
    const imageWidth   = this.offsetWidth
    const imageHeight  = this.offsetHeight
    const imageRatio   = imageWidth / imageHeight

    if (imageRatio >= parentRatio) {

      this.style.width  = 'auto'
      this.style.height = parentHeight + 'px'

    } else {

      this.style.width  = parentWidth + 'px'
      this.style.height = 'auto'

    }

  }

  NodeList.prototype.imageFit = function() {

    const length = this.length

    for (let i = 0; i < length; i++)
      this[i].imageFit()

  }

  HTMLCollection.prototype.imageFit = NodeList.prototype.imageFit