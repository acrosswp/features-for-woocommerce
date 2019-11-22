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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/front/front-index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./includes/ffw_change_quantity_on_checkout/front.js":
/*!***********************************************************!*\
  !*** ./includes/ffw_change_quantity_on_checkout/front.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("jQuery(document).ready(function ($) {\n  jQuery('body.woocommerce-checkout form.woocommerce-checkout').on('change', 'input.ffw-qty', function () {\n    // This does the ajax request\n    $.ajax({\n      url: woocommerce_params.ajax_url,\n      // or example_ajax_obj.ajaxurl if using on frontend\n      data: {\n        'action': 'ffw_change_quantity_on_checkout',\n        'woocommerce-process-checkout-nonce': wc_checkout_params.update_order_review_nonce,\n        'form_value': jQuery(this).closest('form').serialize()\n      },\n      success: function success(data) {\n        if ('success' === data.result) {\n          jQuery('body').trigger('update_checkout');\n        } else {\n          alert(data.message);\n        }\n      },\n      error: function error(errorThrown) {\n        console.log(errorThrown);\n      }\n    });\n  });\n});\n\n//# sourceURL=webpack:///./includes/ffw_change_quantity_on_checkout/front.js?");

/***/ }),

/***/ "./includes/ffw_remove_product_on_checkout/front.js":
/*!**********************************************************!*\
  !*** ./includes/ffw_remove_product_on_checkout/front.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("jQuery(document).ready(function ($) {\n  jQuery('body.woocommerce-checkout form.woocommerce-checkout').on('click', '.ffw_remove_product_on_checkout', function (e) {\n    if (0 < $(this).parent().find('input.ffw-qty').length) {\n      e.preventDefault();\n      $(this).parent().find('input.ffw-qty').val(0).trigger(\"change\");\n    }\n  });\n});\n\n//# sourceURL=webpack:///./includes/ffw_remove_product_on_checkout/front.js?");

/***/ }),

/***/ "./includes/ffw_update_product_price_on_the_fly/front.js":
/*!***************************************************************!*\
  !*** ./includes/ffw_update_product_price_on_the_fly/front.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("jQuery(document).ready(function ($) {\n  jQuery('body.single-product form.cart').on('change', 'input.qty', function (e) {\n    var qty = $(this).val();\n\n    if ($(this).closest('form').hasClass('variations_form cart')) {\n      $(this).closest('form').find('.woocommerce-Price-amount').each(function (index) {\n        ffw_update_product_price_on_the_fly(this, qty);\n      });\n    } else {\n      $(this).closest('.summary').find('.woocommerce-Price-amount').each(function (index) {\n        ffw_update_product_price_on_the_fly(this, qty);\n      });\n    }\n  });\n});\n/**\n * Update price dynamic\n * @param $this\n */\n\nfunction ffw_update_product_price_on_the_fly($this, qty) {\n  var $html = jQuery($this).text();\n  var $symbol = jQuery($this).find('span').text();\n  var main_price = $html.replace($symbol, '');\n\n  if (jQuery($this).attr('single_price')) {\n    single_price = jQuery($this).attr('single_price');\n  } else {\n    jQuery($this).attr('single_price', main_price);\n    single_price = main_price;\n  }\n\n  price = parseInt(qty) * parseFloat(single_price);\n  jQuery($this).html(jQuery($this).html().replace(main_price, price.toFixed(2)));\n  jQuery($this).attr('single_price', single_price);\n}\n\n//# sourceURL=webpack:///./includes/ffw_update_product_price_on_the_fly/front.js?");

/***/ }),

/***/ "./src/front/components/front.js":
/*!***************************************!*\
  !*** ./src/front/components/front.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("/**\n * Test frontend component.\n *\n * src/front/components/front.js\n */\n// Required in our shared function.\n__webpack_require__(/*! ../../../includes/ffw_change_quantity_on_checkout/front */ \"./includes/ffw_change_quantity_on_checkout/front.js\");\n\n__webpack_require__(/*! ../../../includes/ffw_remove_product_on_checkout/front */ \"./includes/ffw_remove_product_on_checkout/front.js\");\n\n__webpack_require__(/*! ../../../includes/ffw_update_product_price_on_the_fly/front */ \"./includes/ffw_update_product_price_on_the_fly/front.js\");\n\n//# sourceURL=webpack:///./src/front/components/front.js?");

/***/ }),

/***/ "./src/front/front-index.js":
/*!**********************************!*\
  !*** ./src/front/front-index.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("/**\n * Frontend entry point.\n *\n * src/front/front-index.js\n */\n__webpack_require__(/*! ./components/front */ \"./src/front/components/front.js\"); // Contain front index code\n\n//# sourceURL=webpack:///./src/front/front-index.js?");

/***/ })

/******/ });