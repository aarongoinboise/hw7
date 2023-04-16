// Wait for the DOM to be ready
$(function () {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='signup']").validate({
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
      reenterPassword: {
        required: true,
        equalTo: "#password"
      },
      hint:"required",
      tutor:"required"

      },

      // Specify validation error messages
      messages: {
        email: "Email must be an actual email: (ex: email@gmail.com)",
        password: "Password must be provided",
        reenterPassword: "Reentered password must equal the above password",
        hint:"A hint is required",
        tutor:"The word \"tutor\" or a tutor number is required"

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