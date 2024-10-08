;(function () {
  var warnTextNode
  // extend swal with a function for adding forms
  Swal.withForm = function () {
    // initialize with field values supplied on `swal.withForm` call
    var swalForm = new SwalForm(arguments[0].formFields)
    // make form values inserted by the user available at `doneFunction`
    swalForm.addWayToGetFormValuesInDoneFunction(arguments)

    // Prepare arguments with the form html and html flag
    arguments[0].text = swalForm.generateHtmlForm()
    arguments[0].html = true

    // forward arguments
    Swal.apply({}, arguments)

    swalForm.allowClickingDirectlyOnInputs()
    swalForm.focusOnFirstInput()
    swalForm.markFirstRadioButtons()
    swalForm.addTabOrder()
  }

  // constructor for helper object
  function SwalForm (formFields) {
    this.formFields = formFields
  }

  // helper methods
  extend(SwalForm.prototype, {
    formClass: 'swal-form',
    generateHtmlForm: function () {
      var form = {
        clazz: this.formClass,
        innerHtml: this.formFields.map(toFormTag.bind(this)).reduce(toSingleString)
      }

      return t("<div class='{clazz}'>{innerHtml}</div>", form)

      function toFormTag (field) {
        var input = Input(field)
        // to separate groups of checkboxes and radiobuttons in different lines
        var conditionalLineBreak = (input.isRadioOrCheckbox() && this.lastFieldName !== field.name) ? '<br>' : ''
        this.lastFieldName = field.name

        return conditionalLineBreak + input.toHtml()
      }
    },
    addWayToGetFormValuesInDoneFunction: function (swalArgs) {
      var swalFormInstance = this
      var doneFunction = swalArgs[1]
      swalArgs[1] = function (isConfirm) {
        // make form values available at `this` variable inside doneFunction
        this.swalForm = swalFormInstance.getFormValues(isConfirm)

        if (doneFunction.apply(this, arguments) !== false) {
          // clean form to not interfere in normals sweet alerts
          document.querySelector('.swal-form').innerHTML = ''
        }
      }
    },
    getFormValues: function (isConfirm) {
      var inputHtmlCollection = document.getElementsByClassName('swal-form-field')
      var inputArray = [].slice.call(inputHtmlCollection)

      return inputArray
        .filter(uncheckedRadiosAndCheckboxes)
        .map(toValuableAttrs)
        .reduce(toSingleObject, {})

      function uncheckedRadiosAndCheckboxes (tag) {
        return (isRadioOrCheckbox(tag) ? tag.checked : true)
      }

      function toValuableAttrs (tag) {
        var attr = {}
        attr[tag.id || tag.name] = tag.value
        if (isConfirm && tag.dataset.swalFormsRequired && !tag.value) {
          var warnMsg = 'Missing required attribute: ' + (tag.name || tag.id)
          warnTextNode && warnTextNode.remove && warnTextNode.remove()
          warnTextNode = document.createTextNode(warnMsg)
          document.querySelector('.swal-form').appendChild(warnTextNode)
          throw new Error(warnMsg)
        }
        return attr
      }

      function toSingleObject (obj1, obj2) {
        return extendPreventingOverrides(obj1, obj2)

        // for checkboxes we want to obtain all selected values in an array
        function extendPreventingOverrides (a, b) {
          Object.keys(b).forEach(addContentFromBtoA)
          return a

          function addContentFromBtoA (key) {
            if (a.hasOwnProperty(key)) {
              mergeIntoAnArray(a, b, key)
            } else {
              a[key] = b[key]
            }
          }
        }

        function mergeIntoAnArray (a, b, key) {
          if (Array.isArray(a[key])) {
            a[key].push(b[key])
          } else {
            a[key] = [a[key], b[key]]
          }
        }
      }
    },
    allowClickingDirectlyOnInputs: function () {
      // sweet-alert attaches an onblur handler which prevents clicks on of non
      // button elements until click is made on the modal
      document.querySelector('.sweet-alert button.confirm').onblur = function () {}
      document.querySelector('.sweet-alert button.cancel').onblur = function () {}
    },
    getSelector: function () {
      var firstField = this.formFields[0]
      return (firstField.id ? t('#{id}', firstField) : t("[name='{name}']", firstField))
    },
    focusOnFirstInput: function () {
      setTimeout(focus.bind(this))

      function focus () {
        document.querySelector(this.getSelector()).focus()
      }
    },
    markFirstRadioButtons: function () {
      setTimeout(markAsChecked.bind(this))

      function markAsChecked () {
        document.querySelector(this.getSelector()).checked = true
      }
    },
    addTabOrder: function () {
      var formFields = Array.prototype.slice.call(document.querySelectorAll('.swal-form .swal-form-field'))
      formFields.forEach(addToTabNavigation)

      function addToTabNavigation (formField, index) {
        var myInput = formField
        var nextInput = formFields[index + 1]

        var keyHandler = function (e) {
          var TABKEY = 9
          if (e.keyCode === TABKEY) {
            var next = this
            setTimeout(function () { next.focus() })
          }
        }

        if (myInput.addEventListener) {
          myInput.addEventListener('keydown', keyHandler.bind(nextInput), false)
        } else if (myInput.attachEvent) {
          myInput.attachEvent('onkeydown', keyHandler.bind(nextInput)) /* damn IE hack */
        }
      }
    }
  })

  function isRadioOrCheckbox (tag) {
    return tag.type === 'radio' || tag.type === 'checkbox'
  }

  function extend (o1, o2) {
    for (var key in o2) {
      if (o2.hasOwnProperty(key)) {
        o1[key] = o2[key]
      }
    }
    return o1
  }

  function Input (field) {
    var input = {
      id: field.id || '',
      name: field.name || '',
      label: field.label || '',
      clazz: field.clazz || '',
      placeholder: field.placeholder || camelCaseToHuman(field.id),
      value: field.value || '',
      type: field.type || 'text',
      options: field.options || [],
      required: field.required,
      isRadioOrCheckbox: function () {
        return isRadioOrCheckbox(input)
      },
      toHtml: function () {
        var inputTag
        if (input.type !== 'select') {
          inputTag = t("<input id='{id}' class='{clazz} swal-form-field' type='{type}' name='{name}'" +
            " value='{value}' title='{placeholder}' placeholder='{placeholder}'" +
            ' data-swal-forms-required={required}>', input)
        } else {
          inputTag = t("<select id='{id}' class='{clazz} swal-form-field' name='{name}'" +
            " value='{value}' title='{placeholder}' style='width:100%'>" +
            ' data-swal-forms-required={}', input) +
              input.options.reduce(toHtmlOptions, '') +
            '</select>'
        }
        var labelTag = t("<label for='{id}'>{label}</label>", input)

        return inputTag + labelTag

        function toHtmlOptions (optionsString, option) {
          option.selected = option.selected ? ' selected' : ''
          return optionsString + t("<option value='{value}'{selected}>{text}</option>", option)
        }
      }
    }
    // Should this label be set to title or id instead of value?
    input.label = input.isRadioOrCheckbox() && input.label === '' ? input.value : input.label
    input.clazz += input.isRadioOrCheckbox() ? ' patch-swal-styles-for-inputs' : ' nice-input'

    return input

    function camelCaseToHuman (arg) {
      if (arg) {
        return arg
          .replace(/([A-Z])/g, ' $1') // insert a space before all caps
          .replace(/^./, function (str) { return str.toUpperCase() }) // uppercase the first character
      } else {
        return ''
      }
    }
  }

  // string interpolation hack
  function t (template, data) {
    for (var key in data) {
      template = template.replace(new RegExp('{' + key + '}', 'g'), data[key] || '')
    }
    return template
  }

  function toSingleString (s1, s2) {
    return s1 + s2
  }

  swal.withFormAsync = function (options) {
    return new Promise(function (resolve, reject) {
      swal.withForm(options, function (isConfirm) {
        this._isConfirm = isConfirm
        resolve(this)
      })
    })
  }
})()
