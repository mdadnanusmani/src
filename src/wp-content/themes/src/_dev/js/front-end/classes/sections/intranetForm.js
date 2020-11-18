class IntranetForm {

  constructor() {

    if (!this.setVars())
      return

    this.initFieldPlaceholder()
    this.initFieldDate()
    this.initInputField()
    this.initSelect()

  }

  setVars() {

    this.section = document.querySelector('.intranetForm')

    if (!this.section)
      return

    this.listField     = this.section.querySelectorAll('.intranetForm label input, label textarea')
    this.listDateField = this.section.querySelectorAll('.intranetForm__datepicker')
    this.listSelect    = document.querySelectorAll('.intranetForm select')
    this.template      = document.getElementById('upload-file-template')
    this.isArabic      = (document.documentElement.getAttribute('dir') == 'rtl')

    return true

  }

  /* ---
    Field placeholder
  --- */

    initFieldPlaceholder() {

      const toggleEvent = (e) => {

        const label = e.currentTarget.closest('label')

        if (e.currentTarget.value || (e.currentTarget.value == '---'))
          label.addClass('intranetForm__label--active')
        else
          label.removeClass('intranetForm__label--active') 

      }

      this.listField.each((item) => {

        item.addEventListener('focus', (e) => {
          item.closest('label').addClass('intranetForm__label--active')
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

      const labels = form.querySelectorAll('.intranetForm__label')
      labels.removeClass('intranetForm__label--active')

    }

  /* ---
    Input date
  --- */

    initFieldDate() {

      this.listDateField.each((item) => {

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

            items.each((item) => {
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

      window.addEventListener('wpfFormUploadFiles', (e) => {
        this.addFile(e.detail)
      })

    }

    addFile(data) {

      const wrapper = data.input.closest('.intranetForm__label')
      const files   = wrapper.querySelectorAll('.intranetForm__file')
      const handle  = data.handle

      files.each((item) => {
        wrapper.removeChild(item)
      })

      data.list.each((item) => {

        let div       = document.createElement('div');
        div.innerHTML = this.template.innerHTML
        let content   = div.querySelector('.intranetForm__file')

        let filename = content.querySelector('.intranetForm__fileName')
        let remove   = content.querySelector('.intranetForm__fileRemove')

        filename.innerHTML = item.name
        wrapper.appendChild(content)

        remove.addEventListener('click', (e) => {

          e.preventDefault()

          const formID    = wrapper.closest('div[data-form-id]').getAttribute('data-form-id')
          const inputName = wrapper.querySelector('input').getAttribute('name')
          const fields    = wrapper.querySelectorAll('.intranetForm__file')
          const index     = Array.prototype.slice.call(fields).indexOf(content)

          handle.$emit('removeFile', inputName, index)
          wrapper.removeChild(content)

        })

      })

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