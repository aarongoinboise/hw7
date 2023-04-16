// Wait for the DOM to be ready
$(function () {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='resetPassword']").validate({
      // Specify validation rules
      rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        email: {
          // Specify that email should be validated
          // by the built-in "email" rule
          required: true,
          email: true
        },
        password: "required",
        newPassword: {
          required: true
        },
        reenterNewPassword: {
            required: true,
            equalTo: "#newPassword"
        },
        hint:"required"
  
        },
  
        // Specify validation error messages
        messages: {
          email: "Email must be an actual email: (ex: email@gmail.com)",
          password: "Password must be provided",
          newPassword: "Password must be newer than the current password",
          reenterNewPassword: "Reentered password must equal the above password",
          hint:"A hint is required"
  
          // tutor: {
          //   required: "Please enter the word " / tutor / " or a legitimate tutor number",
          //   number: ""
          // }
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function (form) {
          form.submit();
        }
      });
  });