/* ---
  Add custom event
--- */

  Element.prototype.addCustomEvent = function(name, fn) {

    this.events       = this.events || {}
    this.events[name] = fn

  }

/* ---
  Bind custom event
--- */

  Element.prototype.bindCustomEvent = function(name, args) {

    if (!this.events || !this.events[name])
      return;
    
    args = args || ''
    this.events[name](args)

  }

/* ---
  Remove custom event
--- */

  Element.prototype.removeCustomEvent = function(name) {

    if (!this.events || !this.events[name])
      return

    delete this.events[name]

  }