/* ---
  Find parent element
--- */

  let closestElement = function(element, selector) {

    const parent = element.parentNode

    if (parent.tagName === undefined)
      return
    else if (parent.matches(selector))
      return parent

    return closestElement(parent, selector)

  };