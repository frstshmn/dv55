/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

//require('./bootstrap');
//require('alpinejs');
function getSidebarModule(module) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: '/courses/sidebar/module',
    type: 'POST',
    data: {
      id: module
    },
    success: function success(result) {
      $('#sidebar #module_' + module).empty();
      $('#sidebar #module_' + module).append(result);
    }
  });
}

function getSidebarTotal() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: '/courses/sidebar/total',
    type: 'POST',
    data: {
      id: $('#total').data('course')
    },
    success: function success(result) {
      $('#sidebar #total').empty();
      $('#sidebar #total').append(result);
    }
  });
}

$(document).on("click", ".material", function () {
  $('#material_content').attr({
    'style': 'display: none!important'
  });
  $('#material_content_loader').attr({
    'style': 'display: flex!important'
  });
  $.get("/materials/" + $(this).data("id"), function (data) {
    $('#material_content').attr({
      'style': 'display: block!important'
    });
    $('#material_content_loader').attr({
      'style': 'display: none!important'
    });
    $("#material_content").html(data);
  });
});
$(document).on("click", ".next-material", function () {
  $('#material_content').attr({
    'style': 'display: none!important'
  });
  $('#material_content_loader').attr({
    'style': 'display: flex!important'
  });
  var next = $(this).data("next");
  var module = $(this).data("module");
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: '/usercomplection',
    type: 'POST',
    data: {
      user_id: $(this).data("user"),
      material_id: $(this).data("current")
    },
    success: function success(result) {
      $.get("/materials/" + next, function (data) {
        getSidebarTotal();
        getSidebarModule(module);
        $('#material_content').attr({
          'style': 'display: block!important'
        });
        $('#material_content_loader').attr({
          'style': 'display: none!important'
        });
        $("#material_content").html(data);
      });
    }
  });
});
$(document).on("click", ".next-test", function () {
  $('#material_content').attr({
    'style': 'display: none!important'
  });
  $('#material_content_loader').attr({
    'style': 'display: flex!important'
  });
  var next = $(this).data("next");
  var module = $(this).data("module");
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: '/usercomplection',
    type: 'POST',
    data: {
      user_id: $(this).data("user"),
      material_id: $(this).data("current")
    },
    success: function success(result) {
      getSidebarTotal();
      getSidebarModule(module);
      $.get("/tests/" + next, function (data) {
        $('#material_content').attr({
          'style': 'display: block!important'
        });
        $('#material_content_loader').attr({
          'style': 'display: none!important'
        });
        $("#material_content").html(data);
      });
    }
  });
});
$('.test').on("click", function () {
  $('#material_content').attr({
    'style': 'display: none!important'
  });
  $('#material_content_loader').attr({
    'style': 'display: flex!important'
  });
  $.get("/tests/" + $(this).data("id"), function (data) {
    $('#material_content').attr({
      'style': 'display: block!important'
    });
    $('#material_content_loader').attr({
      'style': 'display: none!important'
    });
    $("#material_content").html(data);
  });
});
$(document).on("click", '#start_test', function () {
  $.get("/tests/questions/" + $(this).data("id"), function (data) {
    $("#material_content").html(data);
    var timeMinut = parseInt($('#test_timer').text()) * 60;
    var timer = setInterval(function () {
      seconds = timeMinut % 60;
      minutes = timeMinut / 60 % 60;

      if (timeMinut <= 0) {
        clearInterval(timer);
        $('#test').submit();
      } else {
        var _strTimer = "".concat(Math.trunc(minutes), ":").concat(seconds);

        $('#test_timer').text(_strTimer);
      }

      --timeMinut;
      console.log(strTimer);
    }, 1000);
  });
  $('#sidebar').remove();
  $('#sidebar_thumb').removeClass("d-none").addClass("d-flex");
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					result = fn();
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;