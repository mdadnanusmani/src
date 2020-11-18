class WordPressFramework_Forms_Scripts {

  constructor(config) {

    this.config = config

    if (!this.setVars())
      return
    
    this.loadRecaptchaApi()
    this.initValidate()
    this.initVue()

  }

  setVars() {

    this.section = document.querySelector(`#wpf-contact-form-${this.config.form_id}`)

    if (!this.section)
      return

    this.lockSubmit = false

    return true

  }

  /* ---
    reCAPTCHA
  --- */

    loadRecaptchaApi() {

      const url = 'https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded'

      if (!this.config.recaptcha_key || document.querySelector(`script[src="${url}"]`))
        return

      const script = document.createElement('script')
      script.setAttribute('src', url)
      document.body.appendChild(script)

    }

  /* ---
    Validate
  --- */

    initValidate() {

      VeeValidate.Validator.localize({
        en: {
          name      : 'en',
          messages  : this.getValidateMessages(),
          attributes: {}
        }
      })

      this.initCustomValidateRules()

      Vue.use(VeeValidate, {
        locale: 'en'
      })

    }

    getValidateMessages() {

      let list = {}

      for (let key in this.config.messages.validate) {

        const message = this.config.messages.validate[key]

        if (!message)
          continue

        if (message.indexOf('%s') > -1) {

          let parts = message.split('%s')
          list[key] = (field, [value]) => `${parts[0]} ${value} ${parts[1]}`

        } else {

          list[key] = (field) => message

        }

      }

      return list

    }

    initCustomValidateRules() {

      VeeValidate.Validator.extend('numeric', {
        validate(value, args) {
          return /^([+-](?=\.?\d))?(\d+)?(\.\d+)?$/.test(String(value))
        }
      })

      VeeValidate.Validator.extend('step', {
        validate(value, args) {

          let number = Math.round((value - args[1]) * 1e5)
          let step   = Math.round(args[0] * 1e5)

          return (number % step === 0)

        }
      })

    }

  /* ---
    Vue.js app
  --- */

    initVue() {

      const _this   = this
      const wrapper = `#wpf-contact-form-${this.config.form_id}`

      const base = {
        el: wrapper,
        components: { VueRecaptcha },
        mounted() {

          this.$files     = new WordPressFramework_Forms_Scripts_Files(this, _this.config)
          this.$recaptcha = new WordPressFramework_Forms_Scripts_Recaptcha(this, _this.config)
          this.$clear     = new WordPressFramework_Forms_Scripts_Clear(this, _this.config)
          this.$ajax      = new WordPressFramework_Forms_Scripts_Ajax(this, _this.config)

          this.$on('removeFile', this.removeFile)

        },
        data() { return _this.config.data },
        watch: {

          errors: {
            handler(value) {

              const count = value.items.length

              this.$data.status.errors_validation = (count > 0)
              this.$data.status.errors            = ((count > 0) || this.$data.status.errors_response)

            },
            deep: true 
          }

        },
        methods: {
          uploadFiles(key, isMultiple) {
            this.$files.uploadFiles(key, isMultiple)
          },
          removeFile(name, index) {
            this.$files.removeFile(name, index)
          },
          onCaptchaExpired(recaptchaToken) {
            this.$recaptcha.onCaptchaVerified(recaptchaToken)
          },
          onCaptchaVerified(recaptchaToken) {
            this.$recaptcha.onCaptchaVerified(recaptchaToken)
          },
          onSubmit() {
            this.$ajax.submitForm()
          }
        }
      };

      window.wpF  = window.wpF  || {}
      wpF.vueForm = wpF.vueForm || []

      Vue.config.devtools = this.config.is_localhost

      const extend = window[this.config.inst_extension] || {}
      wpF.vueForm[this.config.form_id] = new Vue({
        mixins: [base, extend]
      })

    }

}