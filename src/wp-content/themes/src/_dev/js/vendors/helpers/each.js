Array.prototype.each = function(fn) {

  if (typeof fn !== 'function')
    return

  const length = this.length
  for (let i = 0; i < length; i++) {

    if (fn(this[i], i) === false)
      break

  }

}

NodeList.prototype.each       = Array.prototype.each
HTMLCollection.prototype.each = Array.prototype.each