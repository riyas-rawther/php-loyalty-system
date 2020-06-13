var telInput = $("#phone"),
  errorMsg = $("#error-msg"),
  validMsg = $("#valid-msg");

// initialise plugin
telInput.intlTelInput({
  
  preferredCountries: ['ae', 'sa', 'om'],
  
	  nationalMode: false,
      numberType: "MOBILE",
	  	numberFormat: "INTERNATIONAL",
	  utilsScript: "utils.js"
});

var reset = function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
  validMsg.addClass("hide");
};

// on blur: validate
telInput.blur(function() {
  reset();
  if ($.trim(telInput.val())) {
    if (telInput.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
    } else {
      telInput.addClass("error");
      errorMsg.removeClass("hide");
	  alert ("The phone number is not valid");
	  document.getElementById("phone").focus();
    }
  }
});

// on keyup / change flag: reset
telInput.on("keyup change", reset);

