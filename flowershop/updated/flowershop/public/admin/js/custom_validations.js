/**
 * check for password contains atleast one Uppercase letter one lowercase letter one number and one symbol
 */
$.validator.addMethod("uplownumsym", function (value) {    
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]/.test(value)
});

/**
 * check for password contains at least one letter and one number 
 */
$.validator.addMethod("letternum", function (value) {    
    return /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]/.test(value)
});

/**
 * check for password contains at least one letter, one number and one special character
 */
$.validator.addMethod("letternumsym", function (value) {    
    return /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]/.test(value)
});

/**
 * check for password contains at least one uppercase letter, one lowercase letter and one number
 */
$.validator.addMethod("uplownum", function (value) {    
    return /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]/.test(value)
});

/**
 * Check to allow only alphabets and numbers
 */
$.validator.addMethod("alphanum", function(value, element) {
	return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
}); 

/**
 * Check to allow only alphabets
 */
$.validator.addMethod("alphaonly", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z]+$/);
 });

$.validator.addMethod("alphaspecial", function(value, element) {
    return this.optional(element) || value == value.match(/^[a-zA-Z.,\b]+$/);
 });



/* start jquery validation methos */
$.validator.addMethod("not_empty", function(value, element) {
    return this.optional(element) || /\S/.test(value);
}, "Only space is not allowed.");

$.validator.addMethod("valid_email", function(value, element) {
    return this.optional(element) || /^([\w-\.\+\_]+@([\w-]+\.)+([\w-]{2,})+)?$/.test(value);
}, "Please enter a valid email address.");

$.validator.addMethod("no_space", function(value, element) { 
    return value.indexOf(" ") < 0 && value != "";
}, "Space is not allowed.");

$.validator.addMethod("alpha_numeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
}, "This field may only contain letters, numbers and space.");

$.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
}, "Please enter only letters."); 

$.validator.addMethod("not_equal", function(value, element, param) {
  return this.optional(element) || value != $(param).val();
}, "Please specify a different value.");

$.validator.addMethod("valid_url", function(value, element) {
  return this.optional(element) || /^(?:http(s)?:\/\/)?(www\.)?[A-Za-z]+(\.[a-z]{2,})*$/gm.test(value);
}, "Please enter valid link.");

$.validator.addMethod("social_link", function(value, element) {
  return this.optional(element) || /^(?:http(s)?:\/\/)(www\.)?[A-Za-z]+(\.[a-z]{2,})+(\/[A-Z.a-z0-9]+)\/*$/gm.test(value);
  // return this.optional(element) || /^(?:http(s)?:\/\/)?(www\.)[A-Za-z]+(\.[a-z]{2,})+(\/[A-Za-z0-9]+)*$/gm.test(value);
}, "Please enter valid link.");

// $.validator.addMethod('imageFixHeight', function(value, element, size) {
//     var file, img;
//     var _URL = window.URL || window.webkitURL;
//     if ((file = element.files[0])) {
//         img = new Image(); 
//         img.onload = function() {
//             return this.width == size
//         };
//         img.src = _URL.createObjectURL(file);
//     }
// }, function(size, element) {
//     return "Image height must be equal to " + size + " px.";
// });

// $.validator.addMethod('imageFixWidth', function(value, element, size) {
//     var file, img;
//   var _URL = window.URL || window.webkitURL;
//   if ((file = element.files[0])) {
//       img = new Image();
//       console.log(this.width);
//       img.onload = function() {
//         return this.width == size
//       };
//       img.src = _URL.createObjectURL(file);
//   }
// }, function(size, element) {
//     return "Image width must be equal to " + size + " px.";
// });

$.validator.addMethod('imageWidth', function(value, element, width) {
    return $(element).data('imageWidth') == width || $(element).data('imageWidth') == undefined;
}, function(width, element) {
    return "Image width must be equal to " + width + " px.";
});

$.validator.addMethod('imageHeight', function(value, element, height) {
    return $(element).data('imageHeight') == height || $(element).data('imageHeight') == undefined;
}, function(height, element) {
    return "Image height must be equal to " + height + " px.";
});
/* end jquery validation methods */


/* Check valid date */
// $.validator.addMethod("date_validate", function (value) {    
//     var dtArray = value.split('-');
//     var date = new Date();
//     date.setFullYear(parseInt(dtArray[0]),parseInt(dtArray[1])-1, parseInt(dtArray[2]));
//     if( parseInt(date.getDate())-15 == parseInt(dtArray[2]) && date.getMonth() == parseInt(dtArray[1]-1) && date.getFullYear() == parseInt(dtArray[0]) ){
//         console.log(true);
//     }
// });