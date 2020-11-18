const
  gulp         = require('gulp'),
  minify       = require('gulp-minifier'),
  sass         = require('gulp-sass'),
  autoprefixer = require('gulp-autoprefixer'),
  concat       = require('gulp-concat')
  jsValidate   = require('gulp-jsvalidate'),
  babel        = require('gulp-babel'),
  gutil        = require('gulp-util'),
  plumber      = require('gulp-plumber'),
  gulpif       = require('gulp-if')

/* ---
  Config
--- */

  let
    watchMode = false
    files     = {
      css : [
        {
          source : [
            'assets/src/scss/Acf/Flexible.scss',
            'assets/src/scss/Acf/Icons.scss',
            'assets/src/scss/Admin/Publishbox.scss',
            'assets/src/scss/Cache/Widget.scss',
            'assets/src/scss/Forms/Posttype.scss',
            'assets/src/scss/Seo/Share.scss',
            'assets/src/scss/Tools/Cleaner.scss',
            'assets/src/scss/Tools/Stats.scss'
          ],
          output : {
            path : 'assets/dist/Admin',
            file : 'Assets.css'
          }
        },
        {
          source : [
            'assets/src/scss/Admin/Bar.scss'
          ],
          output : {
            path : 'assets/dist/Admin',
            file : 'Bar.css'
          }
        }
      ],
      js : [
        {
          source : [
            'assets/src/js/classes/Admin/Assets.js',
            'assets/src/js/classes/Acf/Flexible.js',
            'assets/src/js/classes/Acf/Icons.js',
            'assets/src/js/classes/Admin/Publishbox.js',
            'assets/src/js/classes/Forms/Posttype.js',
            'assets/src/js/classes/Tools/Categories.js',
            'assets/src/js/classes/Tools/Stats.js',
            'assets/src/js/classes/Translate/Admin.js'
          ],
          output : {
            path : 'assets/dist/Admin',
            file : 'Assets.js'
          },
          babel  : true,
          merge  : false
        },
        {
          source : [
            'assets/src/js/classes/Admin/Bar.js'
          ],
          output : {
            path : 'assets/dist/Admin',
            file : 'Bar.js'
          },
          babel  : true,
          merge  : false
        },
        {
          source : [
            'node_modules/vue/dist/vue.min.js',
            'node_modules/vee-validate/dist/vee-validate.js',
            'node_modules/vue-recaptcha/dist/vue-recaptcha.js',
            'node_modules/axios/dist/axios.js'
          ],
          output : {
            path : 'node_modules/tmp/Forms',
            file : 'Scripts-Vue.js'
          },
          babel  : false,
          merge  : false
        },
        {
          source : [
            'assets/src/js/vendors/polyfills/custom-event.js',
            'assets/src/js/vendors/polyfills/promise.js',
            'assets/src/js/classes/Forms/ScriptsFiles.js',
            'assets/src/js/classes/Forms/ScriptsRecaptcha.js',
            'assets/src/js/classes/Forms/ScriptsClear.js',
            'assets/src/js/classes/Forms/ScriptsAjax.js',
            'assets/src/js/classes/Forms/Scripts.js'
          ],
          output : {
            path : 'node_modules/tmp/Forms',
            file : 'Scripts.js'
          },
          babel  : true,
          merge  : false
        },
        {
          source : [
            'node_modules/tmp/Forms/Scripts-Vue.js',
            'node_modules/tmp/Forms/Scripts.js'
          ],
          output : {
            path : 'assets/dist/Forms',
            file : 'Scripts.js'
          },
          babel  : false,
          merge  : true
        }
      ]
    }

/* ---
  Styles
--- */

  gulp.task('css', function() {

    for (let i = 0; i < files.css.length; i++) {

      gulp
        .src(files.css[i].source)
        .pipe(plumber({
          errorHandler : function(error) {

            gutil.beep()
            gutil.log(gutil.colors.red('Error : ') + error.messageOriginal)
            gutil.log(gutil.colors.red('File  : ') + error.file)
            gutil.log(gutil.colors.red('Line  : ') + error.line)

          }
        }))
        .pipe(sass({
          outputStyle : 'expanded'
        }))
        .pipe(gulpif(!watchMode,
            minify({
              minify   : true,
              minifyJS : true
          })
        ))
        .pipe(concat(files.css[i].output.file))
        .pipe(gulp.dest(files.css[i].output.path))

    }

  })

/* ---
  Scripts
--- */

  gulp.task('js', function() {

    for (let i = 0; i < files.js.length; i++) {

      if ((mergeActive && !files.js[i].merge) || (!mergeActive && files.js[i].merge))
        continue

      gulp
        .src(files.js[i].source)
        .pipe(jsValidate()).on('error', (error) => {

            gutil.beep()
            gutil.log(gutil.colors.red('Error : ') + error.description)
            gutil.log(gutil.colors.red('File  : ') + error.fileName)
            gutil.log(gutil.colors.red('Line  : ') + error.lineNumber)

        })
        .pipe(gulpif(!watchMode && files.js[i].babel,
          babel({
            presets: ['es2015']
          })
        ))
        .pipe(gulpif(!watchMode,
          minify({
            minify   : true,
            minifyJS : true
          })
        ))
        .pipe(concat(files.js[i].output.file))
        .pipe(gulp.dest(files.js[i].output.path))

    }

  })

/* ---
  Tasks
--- */

  let mergeActive = false

  gulp.task('build', ['css', 'js'])
  gulp.task('merge', function() {

    mergeActive = true
    gulp.start(['js'])

  })

  gulp.task('css-watch', function() {

    mergeActive = false
    gulp.start(['css'])

  })
  gulp.task('js-watch', function() {

    mergeActive = false
    gulp.start(['js'])

  })

  gulp.task('watch', function() {

    watchMode = true

    gulp.watch('assets/src/scss/**/*.scss', ['css-watch'])
    gulp.watch('assets/src/js/**/*.js',     ['js-watch'])
    gulp.watch('node_modules/tmp/**/*.js',  ['merge'])

  })