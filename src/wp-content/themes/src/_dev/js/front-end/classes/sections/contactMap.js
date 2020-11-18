class ContactMap {

  constructor() {

    if (!this.setVars())
      return

    this.loadGoogleApi()

  }

  setVars() {
    
    this.section = document.querySelector('.contactMap')

    if (!this.section)
      return

    this.wrapper  = this.section.querySelector('.contactMap__map')
    this.key      = this.wrapper.getAttribute('data-key')
    this.callback = this.initMap

    return true

  }

  loadGoogleApi() {

    window.addEventListener('load', () => {
    
      const script = document.createElement('script');
      script.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=' + this.key + '&callback=document.dev.contactMap.callback');
      document.head.appendChild(script);
    
    })

  }

  initMap() {

    const position = {
      'lat' : parseFloat(this.wrapper.getAttribute('data-lat')),
      'lng' : parseFloat(this.wrapper.getAttribute('data-lng'))
    }

    const map = new google.maps.Map(this.wrapper, {
      zoom: 11,
      center: position,
      styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}],
      mapTypeControl: false,
      streetViewControl: false,
      scrollwheel: false,
      zoomControl: true,
      fullscreenControl: true
    })

  }

}