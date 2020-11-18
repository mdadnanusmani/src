/* ---
  Get current window scrollTop
--- */

  const getCurrentScroll = function() {

    let scroll = window.scrollY || window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop || 0

    if (document.body.style.position == 'fixed')
      scroll = -parseInt(document.body.style.top)

    return scroll

  }
