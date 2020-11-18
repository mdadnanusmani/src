class WordPressFramework_Forms_Scripts_Ajax {

  constructor(instance, config) {

    this.instance   = instance
    this.config     = config
    this.lockSubmit = false

  }

  /* ---
    Methods
  --- */

    submitForm() {

      if (this.lockSubmit)
        return

      this.setFlags(false, false, true, false)

      this.instance.$validator.validateAll().then((response) => {

        if (!response)
          this.showValidateError()
        else
          this.sendAjax()

      }).catch(() => {

        this.showValidateError()

      })

    }

    showValidateError() {

      this.setFlags(true, false, false, false)

      this.instance.response.submit_error   = this.config.messages.send.validate
      this.instance.response.submit_success = ''

    }

    sendAjax() {

      if (!this.actionBeforeSend())
        return

      axios.post(this.config.ajax_url,
        this.getFormData(),
        {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      ).then((response) => {

        response = response.data

        if (response.success)
          this.showSendSuccess()
        else
          this.showSendError(response)

      })
      .catch(() => {

        this.showSendError()

      })

    }

    getFormData() {

      let formData = new FormData()
      formData.append('wpf_form_id', this.config.form_id)

      const length = this.config.fields_keys.length
      for (let i = 0; i < length; i++) {

        const key = this.config.fields_keys[i]

        if (typeof this.instance.$data.form[key] === 'object') {

          for (let j = 0; j < this.instance.$data.form[key].length; j++)
            formData.append(key + '[]', this.instance.$data.form[key][j])

        } else {

          formData.append(key, this.instance.$data.form[key])

        }

      }

      return formData

    }

    showSendError(response = false) {

      this.setFlags(false, true, false, false)

      if (response && response.data)
        this.instance.response.submit_error = response.data
      else
        this.instance.response.submit_error = this.config.messages.send.error

      this.instance.response.submit_success = ''
      this.actionAfterSend(false)

    }

    showSendSuccess() {

      this.setFlags(false, false, false, true)

      this.instance.response.submit_error   = ''
      this.instance.response.submit_success = this.config.messages.send.success

      this.instance.$clear.clearForm()
      this.actionAfterSend(true)

    }

    actionBeforeSend() {

      const event = new CustomEvent('wpfFormSendBefore', {
        detail     : {
          form : this.instance.$el
        },
        cancelable : true
      })

      return window.dispatchEvent(event)

    }

    actionAfterSend(isSuccess) {

      if (this.instance.$recaptcha !== undefined)
        this.instance.$recaptcha.resetRecaptcha()

      const event = new CustomEvent('wpfFormSendAfter', {
        detail : {
          form    : this.instance.$el,
          success : isSuccess
        }
      })

      window.dispatchEvent(event)

    }

    setFlags(validation, response, sending, sent) {

      validation = validation  ? true : false
      response   = response    ? true : false
      sending    = sending     ? true : false
      sent       = sent        ? true : false

      this.instance.status.errors            = (validation || response)
      this.instance.status.errors_validation = validation
      this.instance.status.errors_response   = response
      this.instance.status.sending           = sending
      this.instance.status.sent              = sent

      this.lockSubmit = sending

    }

}