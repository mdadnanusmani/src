class TextMedia {

  constructor() {

    const list = document.querySelectorAll('.textMedia__video')

    list.each((section) => {
      new TextMediaCore(section)
    })

  }

}

class TextMediaCore {

  constructor(section) {

    this.section = section

    if (!this.setVars())
      return

    this.setEvents()

  }

  setVars() {

    if (!this.section)
      return

    this.wrapper     = this.section.querySelector('.textMedia__videoWrapper')
    this.buttonPlay  = this.section.querySelector('.textMedia__videoButton--play')
    this.buttonPause = this.section.querySelector('.textMedia__videoButton--pause')
    this.videoId     = this.wrapper.getAttribute('data-video')
    this.player      = null

    return true

  }

  setEvents() {

    this.buttonPlay.addEventListener('click', (e) => {
    
      e.preventDefault()
      this.loadVideo()
    
    })

    this.buttonPause.addEventListener('click', (e) => {
    
      e.preventDefault()
      this.pauseVideo()
    
    })

  }

  loadVideo() {

    this.buttonPlay.addClass('textMedia__videoButton--hidden')
    this.buttonPlay.addClass('textMedia__videoButton--hidden')
    this.loadYouTubeApi()

  }

  loadYouTubeApi() {

    if (document.dev.youtubeLoaded)
      this.playVideo()

    let tag = document.createElement('script')
    tag.src = 'https://www.youtube.com/player_api'
    let firstScriptTag = document.getElementsByTagName('script')[0]
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag)

    window.onYouTubeIframeAPIReady = () => {

      document.dev.youtubeLoaded = true
      this.playVideo()

    }

  }

  pauseVideo() {

    if (!this.player)
      return

    this.player.pauseVideo()
    this.section.removeClass('textMedia__video--playing')

    this.buttonPause.addClass('textMedia__videoButton--hidden')
    this.buttonPlay.removeClass('textMedia__videoButton--hidden')

  }

  playVideo() {

    if (this.player) {

      this.startVideo()
      return

    }

    const playAction   = (e) => {
      this.startVideo()
    }
    const changeAction = (e) => {

      if (e.data != YT.PlayerState.PLAYING)
        this.section.removeClass('textMedia__video--playing')
      else
        this.section.addClass('textMedia__video--playing')

    }

    this.player = new YT.Player(this.wrapper, {
      videoId    : this.videoId,
      playerVars : {
        'controls' : 0,
        'rel'      : 0,
        'showinfo' : 0,
        'loop'     : 1,
        'origin'   : window.location.protocol + '//' + window.location.hostname,
      },
      events     : {
        'onReady'       : playAction,
        'onStateChange' : changeAction
      }
    })

  }

  startVideo() {

    this.player.playVideo()

    this.buttonPlay.addClass('textMedia__videoButton--hidden')
    this.buttonPause.removeClass('textMedia__videoButton--hidden')

  }

}