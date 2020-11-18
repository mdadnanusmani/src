class WordPressFramework_Forms_Scripts_Files {

  constructor(instance, config) {

    this.instance = instance
    this.config   = config

  }

  /* ---
    Methods
  --- */

    uploadFiles(key, isMultiple) {

      let list    = []
      const files = this.instance.$refs[key].files

      const length = files.length
      for (let i = 0; i < length; i++)
        list.push(files[i])

      if (isMultiple)
        list = this.instance.$data.form[key].concat(list)

      this.instance.$validator.validate(key, list).then((response) => {

        if (!response)
          return

        this.instance.$data.form[key] = list
        this.triggerFileChangeEvent(this.instance.$refs[key], list)

      })

    }

    removeFile(name, index) {

      let list = this.instance.$data.form[name]
      list.splice(index, 1)

      this.instance[name] = list

      if (list[0])
        return

      this.instance.$refs[name].value = []
      this.instance.$validator.validate(name)

    }

    triggerFileChangeEvent(input, files) {

      window.dispatchEvent(new CustomEvent('wpfFormUploadFiles', {
        detail : {
          form_id : this.config.form_id,
          handle  : this.instance,
          input   : input,
          list    : files
        }
      }))

    }

}