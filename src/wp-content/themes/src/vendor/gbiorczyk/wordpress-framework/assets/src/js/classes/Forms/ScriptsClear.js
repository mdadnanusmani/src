class WordPressFramework_Forms_Scripts_Clear {

  constructor(instance, config) {

    this.instance = instance
    this.config   = config

  }

  /* ---
    Methods
  --- */

    clearForm() {

      const length = this.config.fields_keys.length
      for (let i = 0; i < length; i++) {

        let key = this.config.fields_keys[i]
        this.instance.$data.form[key] = (typeof this.instance.$data.form[key] === 'string') ? '' : null
        this.instance.$refs.value     = ''

      }

      for (let key in this.instance.$refs) {

        if ((this.instance.$refs[key].nodeType != 1) || (this.instance.$refs[key].getAttribute('type') != 'file'))
          continue

        this.instance.$refs[key].value = []
        this.instance.$files.triggerFileChangeEvent(this.instance.$refs[key], [])

      }

      this.instance.$recaptcha.resetRecaptcha()

      setTimeout(() => {
        this.instance.$validator.reset()
        this.instance.errors.clear()
      }, 0)

    }

}