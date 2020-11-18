class Core {

  constructor() {

    document.dev = {}

    /* ---
      Site
    --- */

      document.dev.animationNumber = new AnimationNumber()
      document.dev.contactForm     = new ContactForm()
      document.dev.dataHover       = new DataHover()
      document.dev.header          = new Header()
      document.dev.hideScroll      = new HideScroll()
      document.dev.menu            = new Menu()
      document.dev.sectionLink     = new SectionLink()
      document.dev.sectionScroll   = new SectionScroll()
      document.dev.textWrap        = new TextWrap()

    /* ---
      Sections
    --- */

      document.dev.animatedIcons   = new AnimatedIcons()
      document.dev.contactMap      = new ContactMap()
      document.dev.faqTabs         = new FaqTabs()
      document.dev.gallerySection  = new GallerySection()
      document.dev.intranetProfile = new IntranetProfile()
      document.dev.intranetForm    = new IntranetForm()
      document.dev.jobsList        = new JobsList()
      document.dev.newsCategories  = new NewsCategories()
      document.dev.offerSection    = new OfferSection()
      document.dev.partnersQuote   = new PartnersQuote()
      document.dev.productsTabs    = new ProductsTabs()
      document.dev.quoteBar        = new QuoteBar()
      document.dev.slider          = new Slider()
      document.dev.table           = new Table()
      document.dev.teamPeople      = new TeamPeople()
      document.dev.textMedia       = new TextMedia()

  }

}

let domReady = callback => {

  if ((document.readyState === 'interactive') || (document.readyState === 'complete'))
    callback()
  else
    document.addEventListener('DOMContentLoaded', callback)

}

domReady(() => new Core())