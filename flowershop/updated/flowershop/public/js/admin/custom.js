/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./public/admin/js/custom.js":
/*!***********************************!*\
  !*** ./public/admin/js/custom.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  function get_notification() {
    $.ajax({
      url: notification_action,
      type: 'POST',
      dataType: 'json',
      data: {
        _token: $('meta[name="csrf_token"]').attr('content')
      },
      success: function success(r) {
        if (r.status == 200) {
          $('#notification-list').html(r.list);
          $('.notification-count').html(r.list_count);
        }
      }
    });
  } // get_notification();
  // setInterval(get_notification, 2*1000 ); 


  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  /* Code to set sidebar li active */

  $('.page-sidebar-menu li').filter(function () {
    return $(this).hasClass('active');
  }).parent('ul').parent('li').addClass('active open');
  $('.page-sidebar-menu li').filter(function () {
    return $(this).hasClass('active');
  }).parent('ul').siblings('a').children('span.arrow').addClass('open');
  /**
   * Delete record from database
   */

  $(document).on('click', '.act-delete', function (e) {
    e.preventDefault();
    var action = $(this).attr('href');
    bootbox.confirm('Are you sure you want to delete this record?', function (res) {
      if (res) {
        $.ajax({
          url: action,
          type: 'DELETE',
          dataType: 'json',
          beforeSend: addOverlay,
          data: {
            _token: $('meta[name="csrf_token"]').attr('content')
          },
          success: function success(r) {
            showMessage(r.status, r.message);
            removeOverlay();
            $('#totalCount').html(r.count || '0');

            if (typeof oTable.draw !== "undefined") {
              oTable.draw();
            } else if (typeof oTable.fnDraw !== "undefined") {
              oTable.fnDraw();
            }
          },
          complete: removeOverlay
        });
      }
    });
  });
  $(document).on('click', '.delete-request', function (e) {
    var button = $(this);
    e.preventDefault();
    bootbox.confirm('Are you sure! you want to delete this record?', function (res) {
      if (res) {
        button.parents('form').submit();
      }
    });
  });
  $(document).on('switchChange.bootstrapSwitch', '.status-switch', function (event, state) {
    var $this = $(this);
    var customAct = typeof $(this).data('getaction') != 'undefined' ? $(this).data('getaction') : '';
    var val = state ? 'y' : 'n';
    var url = $(this).data('url');
    var action = customAct != '' ? customAct : 'change_status';
    $.ajax({
      url: url,
      type: 'PUT',
      dataType: 'json',
      beforeSend: addOverlay,
      data: {
        _token: $('meta[name="csrf_token"]').attr('content'),
        action: action,
        value: val
      },
      success: function success(r) {
        showMessage(r.status, r.message);

        if (r.status != 200) {
          $this.prop("checked", !$this.prop("checked"));
        } else {
          if (oTable.attr('id') == 'device_table_DT') {
            oTable.fnDraw();
          }
        }

        removeOverlay();
      },
      complete: removeOverlay
    });
  }); //start select all and delete records

  $(document).on('click', '.all_select', function () {
    // console.log($(this).hasClass('allChecked'));
    if ($(this).hasClass('allChecked')) {
      $('.dataTable tbody input[class="small-chk"]').prop('checked', false);
    } else {
      $('.dataTable tbody input[class="small-chk"]').prop('checked', true);
    }

    $(this).toggleClass('allChecked');
  });
  $(document).on('click', '.dataTable tbody input[class=small-chk]', function () {
    var numberOfChecked = $('.dataTable tbody input[class="small-chk"]:checked').length;
    var totalCheckboxes = $('.dataTable tbody input[class="small-chk"]').length;

    if (numberOfChecked > 0) {
      if (numberOfChecked == totalCheckboxes) {
        $('.all_select').prop('indeterminate', false);
        $('.all_select').prop('checked', true);
        $('.all_select').addClass('allChecked');
      } else {
        if ($('.all_select').hasClass('allChecked')) {
          $('.all_select').removeClass('allChecked');
        }

        $('.all_select').prop('indeterminate', true);
      }
    } else {
      $('.all_select').prop('indeterminate', false);
      $('.all_select').prop('checked', false);
    }
  });
  $(document).on("click", ".delete_all_link", function (e) {
    $(".delete_all_link").attr("disabled", "disabled");
    e.preventDefault();
    var url = $(this).attr('href');
    var searchIDs = [];
    $(".dataTable tbody input[class='small-chk']:checked").each(function () {
      searchIDs.push($(this).val());
    });

    if (searchIDs.length > 0) {
      var ids = searchIDs.join();
      bootbox.confirm("Are you sure you want to delete selected records?", function (result) {
        if (result) {
          $.ajax({
            url: url,
            type: 'DELETE',
            beforeSend: addOverlay,
            dataType: 'json',
            data: {
              action: 'delete_all',
              ids: ids,
              _token: $('meta[name="csrf_token"]').attr('content')
            },
            success: function success(r) {
              showMessage(r.status, r.message);
              $('#totalCount').html(r.count || '0');

              if (typeof oTable.draw !== "undefined") {
                oTable.draw();
              } else if (typeof oTable.fnDraw !== "undefined") {
                oTable.fnDraw();
              }

              setTimeout(function () {
                $('.all_select').prop('indeterminate', false);
                $('.all_select').prop('checked', false);

                if ($('.all_select').hasClass('allChecked')) {
                  $('.all_select').removeClass('allChecked');
                }
              }, 1000);
            },
            complete: removeOverlay
          });
        }

        $(".delete_all_link").removeAttr("disabled");
      });
    } else {
      bootbox.alert('Select at-least one record', function () {
        $('.all_select').prop('indeterminate', false);
        $(".delete_all_link").removeAttr("disabled");
      });
    }
  });
});

function getStatusText(code) {
  sText = "";

  if (code !== undefined) {
    switch (code) {
      case 200:
        {
          sText = 'Success';
          break;
        }

      case 404:
        {
          sText = 'Error';
          break;
        }

      case 403:
        {
          sText = 'Error';
          break;
        }

      case 500:
        {
          sText = 'Error';
          break;
        }

      case "success":
        {
          sText = "Success";
          break;
        }

      case "danger":
        {
          sText = 'Error';
          break;
        }

      case "warning":
        {
          sText = 'Error';
          break;
        }

      default:
        {
          sText = 'Error';
        }
    }
  }

  return sText;
}

function showMessage(sType, sText) {
  sType = getStatusText(sType);
  toastr[sType.toLowerCase()](sText);
}

function addOverlay() {
  $('<section id="overlayDocument"><div id="loader"></div></section>').appendTo(document.body);
} // function addOverlay(){$('<svg width="30px" height="25px" viewBox="0 0 30 25" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" data-llp-composed="true" id="Line2" class="lazy-line-painter"> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" stroke-linecap="square"> <polyline id="Line-2" fill-rule="nonzero" points="0.5 12.5 4.5 12.5 4.5 3 6.63110352 1.378115 8.76708984 3 8.76708984 22.1298828 10.8634033 24.0819092 12.954834 22.1298828 12.954834 3 15.1396484 1.138283 17.342105 3 17.342105 22.1298828 19.4074707 24.0819092 21.342105 22.1298828 21.342105 3 23.5494385 1.138283 25.7672586 3 25.7672586 12.5649414 29.7792969 12.5649414" data-llp-id="Line2-0" data-llp-duration="1480" data-llp-delay="0" fill-opacity="1" style="" data-llp-stroke-cap="" data-llp-stroke-join=""/> </g></svg>').appendTo(document.body);}
// function addOverlay(){$('<div id="overlayDocument"><div class="loader"><div class="line1"></div><div class="line2"></div></div></div>').appendTo(document.body);}
// function addOverlay(){$('<div id="overlayDocument"><img src="' + IMAGES + '/loading.gif" /></div>').appendTo(document.body);}


function removeOverlay() {
  $('#overlayDocument').remove();
}

jQuery.validator.addMethod("not_empty", function (value, element) {
  return this.optional(element) || /\S/.test(value);
}, "Only space is not allowed.");
jQuery.validator.addMethod("not_equal", function (value, element, compare_with) {
  return value != $(compare_with).val();
}, "Same values are not allowed.");
jQuery.validator.addMethod("no_space", function (value, element) {
  return value.indexOf(" ") < 0 && value != "";
}, "Space is not allowed.");
jQuery.validator.addMethod("alpha_numeric", function (value, element) {
  return this.optional(element) || /^[a-zA-Z0-9\s.]+$/.test(value);
}, "This field may only contain letters, numbers and space.");

function getAudioVideoLength(seconds) {
  return (seconds - (seconds %= 60)) / 60 + (9 < seconds ? ':' : ':0') + Math.floor(seconds);
}
/**
 * Delete record from database
 */


$(document).on('click', '.act-recover', function (e) {
  e.preventDefault();
  var action = $(this).attr('href');
  bootbox.confirm('Are you sure you want to recover this record?', function (res) {
    if (res) {
      $.ajax({
        url: action,
        type: 'POST',
        dataType: 'json',
        beforeSend: addOverlay,
        data: {
          _token: $('meta[name="csrf_token"]').attr('content')
        },
        success: function success(r) {
          showMessage(r.status, r.message);
          removeOverlay();
          $('#totalCount').html(r.count || '0');

          if (typeof oTable.draw !== "undefined") {
            oTable.draw();
          } else if (typeof oTable.fnDraw !== "undefined") {
            oTable.fnDraw();
          }
        },
        complete: removeOverlay
      });
    }
  });
});
$(document).on("click", ".recover_all_link", function (e) {
  $(".recover_all_link").attr("disabled", "disabled");
  e.preventDefault();
  var url = $(this).attr('href');
  var searchIDs = [];
  $(".dataTable tbody input[class='small-chk']:checked").each(function () {
    searchIDs.push($(this).val());
  });

  if (searchIDs.length > 0) {
    var ids = searchIDs.join();
    bootbox.confirm("Are you sure you want to recover selected records?", function (result) {
      if (result) {
        $.ajax({
          url: url,
          type: 'POST',
          beforeSend: addOverlay,
          dataType: 'json',
          data: {
            action: 'recover_all',
            ids: ids,
            _token: $('meta[name="csrf_token"]').attr('content')
          },
          success: function success(r) {
            showMessage(r.status, r.message);
            $('#totalCount').html(r.count || '0');

            if (typeof oTable.draw !== "undefined") {
              oTable.draw();
            } else if (typeof oTable.fnDraw !== "undefined") {
              oTable.fnDraw();
            }

            setTimeout(function () {
              $('.all_select').prop('indeterminate', false);
              $('.all_select').prop('checked', false);

              if ($('.all_select').hasClass('allChecked')) {
                $('.all_select').removeClass('allChecked');
              }
            }, 1000);
          },
          complete: removeOverlay
        });
      }

      $(".delete_all_link").removeAttr("disabled");
    });
  } else {
    bootbox.alert('Select at-least one record', function () {
      $('.all_select').prop('indeterminate', false);
      $(".delete_all_link").removeAttr("disabled");
    });
  }
});

/***/ }),

/***/ 2:
/*!*****************************************!*\
  !*** multi ./public/admin/js/custom.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\yudiz\laravel\FLOWER-SHOP\flowers-shop\public\admin\js\custom.js */"./public/admin/js/custom.js");


/***/ })

/******/ });