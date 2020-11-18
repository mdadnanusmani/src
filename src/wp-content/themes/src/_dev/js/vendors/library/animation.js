/* ---
 
  How to use?

    • include this file
    • use functions in your JS code:

      • run animation:

        this.animation = new Animation()
        this.animation.start(
          start,
          delta,
          duration,
          'easeOutCubic',
          (value) => { this.callback(value) }
        )

      • stop animation:

        this.animation.stop()

--- */

class Animation {

  constructor() {

    this.fReady    = true
    this.time      = null
    this.inLoop    = false
    this.animation = null
    this.easings   = {
      linear         : function(t) { return t },
      easeInQuad     : function(t) { return t*t },
      easeOutQuad    : function(t) { return t*(2-t) },
      easeInOutQuad  : function(t) { return t<.5 ? 2*t*t : -1+(4-2*t)*t },
      easeInCubic    : function(t) { return t*t*t },
      easeOutCubic   : function(t) { return (--t)*t*t+1 },
      easeInOutCubic : function(t) { return t<.5 ? 4*t*t*t : (t-1)*(2*t-2)*(2*t-2)+1 },
      easeInQuart    : function(t) { return t*t*t*t },
      easeOutQuart   : function(t) { return 1-(--t)*t*t*t },
      easeInOutQuart : function(t) { return t<.5 ? 8*t*t*t*t : 1-8*(--t)*t*t*t },
      easeInQuint    : function(t) { return t*t*t*t*t },
      easeOutQuint   : function(t) { return 1+(--t)*t*t*t*t },
      easeInOutQuint : function(t) { return t<.5 ? 16*t*t*t*t*t : 1+16*(--t)*t*t*t*t }
    }

  }

  /* ---
    Actions
  --- */

    start(start, delta, duration, easing, action) {

      if (this.inLoop)
        return

      this.sTime    = window.performance.now()
      this.eTime    = this.sTime + duration
      this.duration = duration
      this.sValue   = start
      this.dValue   = delta
      this.easing   = this.easings[easing]
      this.action   = action

      this.startLoop()

    }

    stop() {

      this.stopLoop()

    }

  /* ---
    Loop
  --- */

    startLoop() {

      this.inLoop    = true
      this.animation = requestAnimationFrame(() => { this.loop() })

    }

    loop() {

      this.animation = requestAnimationFrame(() => { this.loop() })

      if (!this.fReady)
        return

      this.fReady = false
      this.time   = window.performance.now()
      this.update(this.time)
      this.fReady = true

    }

    update(time) {

      if (time > this.eTime) {

        this.stopLoop()
        return

      }

      let fract   = (time - this.sTime) / this.duration
      fract       = this.easing(fract)
      const value = this.sValue + fract * this.dValue

      this.action(value)

    }

    stopLoop() {

      cancelAnimationFrame(this.animation)
      this.animation = null
      this.inLoop    = false

    }

}