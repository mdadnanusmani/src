/* ---
  Parse numbers to arabic 
--- */

  let arabicNumbers = function(value) {
    value = value.toString()
    const latin  = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0']
    const arabic = ['۱', '۲', '۳', '٤', '۵', '٦', '۷', '۸', '۹', '۰']

    for (let i = 0; i < 10; i++)
      value = value.replace(new RegExp(latin[i], 'g'), arabic[i])
    return value
  }