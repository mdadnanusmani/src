class ContactForm {

  constructor() {

    if (!this.setVars())
      return

    this.initFieldPlaceholder()
    this.initFieldDate()
    this.initInputField()
    this.initSelect()

  }

  setVars() {

    this.listField      = document.querySelectorAll('.contactForm label input, label select, label textarea')
    this.listDateField  = document.querySelectorAll('.contactForm__datepicker')
    this.listFileRemove = document.querySelectorAll('.contactForm__dropzoneRemove')
    this.listSelect     = document.querySelectorAll('.contactForm select, .newsletterSection select')
    this.isArabic       = (document.documentElement.getAttribute('dir') == 'rtl')
    this.handles        = {}

    return true

  }

  /* ---
    Field placeholder
  --- */

    initFieldPlaceholder() {

      const toggleEvent = (e) => {

        const label = e.currentTarget.closest('label')

        if (e.currentTarget.value || (e.currentTarget.value == '---'))
          label.addClass('contactForm__label--active')
        else
          label.removeClass('contactForm__label--active') 

      }

      this.listField.each((item) => {

        item.addEventListener('focus', (e) => {
          item.closest('label').addClass('contactForm__label--active')
        })

        item.addEventListener('blur',   toggleEvent)
        item.addEventListener('keyup',  toggleEvent)
        item.addEventListener('change', toggleEvent)

      })

      window.addEventListener('wpfFormSendBefore', (e) => {
        e.detail.form.querySelector('button[type=submit]').addClass('button--loading')
      })

      window.addEventListener('wpfFormSendAfter', (e) => {

        e.detail.form.querySelector('button[type=submit]').removeClass('button--loading')

        if (e.detail.success)
          this.clearForm(e.detail.form)

      })

    }

    clearForm(form) {

      const labels = form.querySelectorAll('.contactForm__label')
      labels.removeClass('contactForm__label--active')

    }

  /* ---
    Input date
  --- */

    initFieldDate() {

      this.listDateField.each((item, index) => {

        new Pikaday({
          field    : item,
          onSelect : (date) => {

            date       = new Date(date)
            let year   = date.getFullYear()
            let month  = ('0' + (date.getMonth() + 1)).slice(-2)
            let day    = ('0' + date.getDate()).slice(-2)
            let output = [year, month, day].join('-')

            item.value = output
            item.dispatchEvent(new Event('input'))

          },
          firstDay : 1,
          isRTL    : this.isArabic,
          i18n     : {
            previousMonth : '',
            nextMonth     : '',
            months        : wpF.translate.months,
            weekdays      : ['', '', '', '', '', '', ''],
            weekdaysShort : wpF.translate.weekdays
          },
          onDraw   : () => {

            if (!this.isArabic)
              return

            const items = document.querySelectorAll('.pika-day, .pika-label')

            items.each((item, index) => {
              item.innerHTML = arabicNumbers(item.innerHTML)
            })

          }
        })

      })

    }

  /* ---
    Input field
  --- */

    initInputField() {

      this.listFileRemove.each((item, index) => {

        item.addEventListener('click', (e) => {
          e.preventDefault()
          this.removeFile(index)
        })

      })

      window.addEventListener('wpfFormUploadFiles', (e) => {
        this.addFile(e.detail)
      })

    }

    addFile(data) {

      const dropzone             = data.input.closest('.contactForm__dropzone')
      this.handles[data.form_id] = data.handle

      if (!dropzone)
        return

      const wrapper  = dropzone.querySelector('.contactForm__dropzoneWrapper')
      const filename = dropzone.querySelector('.contactForm__dropzoneFilename')

      if (data.list[0]) {

        wrapper.addClass('contactForm__dropzoneWrapper--active')
        filename.innerHTML = data.list[0].name

      } else {

        wrapper.removeClass('contactForm__dropzoneWrapper--active')

      }

    }

    removeFile(index) {

      const form      = this.listFileRemove[index].closest('div[data-form-id]')
      const formID    = form.getAttribute('data-form-id')
      const dropzone  = this.listFileRemove[index].closest('.contactForm__dropzone')
      const wrapper   = dropzone.querySelector('.contactForm__dropzoneWrapper')
      const input     = dropzone.querySelector('input')
      const inputName = input.getAttribute('name')

      this.handles[formID].$emit('removeFile', inputName, 0)
      wrapper.removeClass('contactForm__dropzoneWrapper--active')

    }

  /* ---
    Select
  --- */

    initSelect() {

      this.listSelect.each((item) => {

        new Selectr(item, {
          searchable: false
        })

      })

    }

}