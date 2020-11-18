/* ---
  Check if element is clicked 
--- */

  let isClicked = function(element, selector) {

    if (element.matches(selector))
      return true

    if (element.parentNode.nodeType == 1)
      return isClicked(element.parentNode, selector)
    else
      return false

  }