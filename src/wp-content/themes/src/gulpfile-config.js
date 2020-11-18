const paths = {
  css       : '_dev/scss/',
  outputCss : 'assets/css/',
  js        : '_dev/js/',
  outputJs  : 'assets/js/',
  tmp       : 'node_modules/.tmp/'
}

/* ---

  Options:
    • label (name of task)
    • import (list of files to merge)
    • output (list of output files)
    • babel (adding support for ES5 using Babel)
    • bundle (task starting at the end - second order, e.g. for merge output files from other tasks; file compression)

--- */

exports.files = {
  css : [

    /* ---
      Front-end
    --- */

      {
        label  : 'SCSS [front-end]',
        import : [
          paths.css + 'front-end/**/*.scss'
        ],
        output : [
          {
            path        : paths.outputCss,
            file        : 'styles.css',
            browserSync : true
          }
        ],
        bundle : true
      },

    /* ---
      Admin
    --- */

      {
        label  : 'SCSS [admin]',
        import : [
          paths.css + 'admin/**/*.scss'
        ],
        output : [
          {
            path        : paths.outputCss,
            file        : 'admin.css',
            browserSync : true
          }
        ],
        bundle : true
      },

  ],
  js : [

    /* ---
      Vendors
    --- */

      {
        label  : 'JS [vendors]',
        import : [
          paths.js + 'vendors/polyfills/**/*.js',
          paths.js + 'vendors/helpers/*.js',
          paths.js + 'vendors/library/*.js'
        ],
        output : [
          {
            path : paths.tmp,
            file : 'vendors.js'
          }
        ],
        babel  : true,
        bundle : false
      },

    /* ---
      Front-end
    --- */

      {
        label  : 'JS [front-end library]',
        import : [
          paths.js + 'front-end/libs/gsap/TweenLite.js',
          paths.js + 'front-end/libs/gsap/plugins/CSSPlugin.js',
          paths.js + 'front-end/libs/gsap/plugins/ScrollToPlugin.js',
          paths.js + 'front-end/libs/*.js'
        ],
        output : [
          {
            path : paths.tmp,
            file : 'frontend-library.js'
          }
        ],
        babel  : false,
        bundle : false
      },
      {
        label  : 'JS [front-end scripts]',
        import : [
          paths.js + 'front-end/classes/site/*.js',
          paths.js + 'front-end/classes/sections/*.js',
          paths.js + 'front-end/classes/*.js'
        ],
        output : [
          {
            path : paths.tmp,
            file : 'frontend-scripts.js'
          }
        ],
        babel  : true,
        bundle : false
      },
      {
        label  : 'JS [front-end]',
        import : [
          paths.tmp + 'vendors.js',
          paths.tmp + 'frontend-library.js',
          paths.tmp + 'frontend-scripts.js',
        ],
        output : [
          {
            path : paths.outputJs,
            file : 'scripts.js'
          }
        ],
        babel  : false,
        bundle : true
      },

  ]
}

exports.autoprefixerOptions = {
  browsers : ['> 1%', 'safari 8'],
  cascade  : false
},

exports.browserSyncOptions = {
  port  : 3000,
  proxy : 'src.crafton.local'
}