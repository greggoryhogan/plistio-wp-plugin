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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/index.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/gif-box.js":
/*!************************!*\
  !*** ./src/gif-box.js ***!
  \************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);


var __ = wp.i18n.__; // The __() for internationalization.




var GifBox = function GifBox(_ref) {
  var attributes = _ref.attributes,
      setCaption = _ref.setCaption,
      setAttributes = _ref.setAttributes,
      plugin_settings = _ref.plugin_settings;
  // extract the properties we will use from user data
  var currentGif = attributes.currentGif,
      currentGifWidth = attributes.currentGifWidth,
      currentGifHeight = attributes.currentGifHeight,
      align = attributes.align,
      captionText = attributes.captionText,
      altText = attributes.altText,
      gifBoxWidth = attributes.gifBoxWidth,
      gifBoxHeight = attributes.gifBoxHeight;

  if (!currentGif && plugin_settings.tenor_api_key == '') {
    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__["RichText"].Content, {
      tagName: "p",
      value: sprintf(__('Please enter your Tenor API key on the <a href="%s">settings page</a>.', 'gg'), plugin_settings.gg_settings_page)
    });
  }

  if (!currentGif) {
    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
      className: "nogif"
    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__["RichText"].Content, {
      tagName: "p",
      value: __('Use the search in the block settings to find a gif...', 'gg')
    }));
  }

  var classes = 'align' + align;
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
    className: "wp-block-image gg-gif-block"
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("figure", {
    className: classes
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__["ResizableBox"], {
    size: {
      height: gifBoxHeight,
      width: gifBoxWidth
    },
    minHeight: "50",
    minWidth: "50",
    enable: {
      top: false,
      right: true,
      bottom: false,
      left: true,
      topRight: false,
      bottomRight: false,
      bottomLeft: false,
      topLeft: false
    },
    lockAspectRatio: "true",
    onResizeStop: function onResizeStop(event, direction, elt, delta) {
      setAttributes({
        gifBoxHeight: parseInt(gifBoxHeight + delta.height, 10),
        gifBoxWidth: parseInt(gifBoxWidth + delta.width, 10)
      });
    },
    onResizeStart: function onResizeStart() {}
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("img", {
    src: currentGif,
    width: currentGifWidth,
    height: currentGifHeight,
    alt: altText
  })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("figcaption", null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__["RichText"], {
    tagName: "span" // The tag here is the element output and editable in the admin
    ,
    value: captionText // Any existing content, either from the database or an attribute default
    ,
    onChange: function onChange(newCaption) {
      return setCaption(newCaption);
    },
    placeholder: __('Enter a caption. Via Tenor') // Display this text before any content has been added by the user

  }))));
};

/* harmony default export */ __webpack_exports__["default"] = (GifBox);

/***/ }),

/***/ "./src/gif-results.js":
/*!****************************!*\
  !*** ./src/gif-results.js ***!
  \****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);


var __ = wp.i18n.__; // The __() for internationalization.



var GifResults = function GifResults(_ref) {
  var attributes = _ref.attributes,
      gifResults = _ref.gifResults,
      setGif = _ref.setGif,
      setGifSearch = _ref.setGifSearch,
      pagePos = _ref.pagePos,
      searchTerm = _ref.searchTerm,
      hasNextPage = _ref.hasNextPage,
      isLoading = _ref.isLoading;
  // extract the properties we will use from user data
  var currentGif = attributes.currentGif,
      currentGifWidth = attributes.currentGifWidth,
      currentGifHeight = attributes.currentGifHeight,
      altText = attributes.altText;

  if (isLoading) {
    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
      class: "centercontent"
    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Spinner"], null));
  }

  var prevPage = function prevPage(where) {
    setGifSearch(searchTerm, 'prev');
  };

  var nextPage = function nextPage(where) {
    setGifSearch(searchTerm, 'next');
  };

  var prevdisabled = true;

  if (pagePos > 0 || hasNextPage == false) {
    prevdisabled = false;
  }

  var prev = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Button"], {
    className: "is-primary",
    onClick: prevPage,
    disabled: prevdisabled
  }, "Previous");
  var nextdisabled = true;

  if (pagePos != null && hasNextPage != false) {
    nextdisabled = false;
  }

  var next = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Button"], {
    className: "is-primary",
    onClick: nextPage,
    disabled: nextdisabled
  }, "Next");

  if (!gifResults) {
    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
      class: "gifresults"
    }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
      class: "gif-navigation"
    }, prev, next));
  } // if we do not have any results to show, show the message and prevent code from further rendering


  if (!gifResults.length) return '';
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
    class: "gifresults"
  }, gifResults.map(function (value) {
    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("img", {
      src: value.preview,
      width: value.width,
      height: value.height,
      url: value.url,
      onClick: function onClick() {
        return setGif(value);
      }
    });
  })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
    class: "gif-navigation"
  }, prev, next));
};

/* harmony default export */ __webpack_exports__["default"] = (GifResults);

/***/ }),

/***/ "./src/gif-search.js":
/*!***************************!*\
  !*** ./src/gif-search.js ***!
  \***************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _gif_results__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./gif-results */ "./src/gif-results.js");





 // Fragment will be used as wrapper if we do not want to include markup, like div, etc

var Fragment = wp.element.Fragment; // InspectorControls will be used to wrap Panel body component
// we need this two wrapper component if we want to display our settings
// in the right panel (where we have document and block tabs, next to the content)

var InspectorControls = wp.editor.InspectorControls;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    Text = _wp$components.Text;
var __ = wp.i18n.__; // The __() for internationalization.

var GifSearch = function GifSearch(_ref) {
  var attributes = _ref.attributes,
      setAttributes = _ref.setAttributes,
      searchTerm = _ref.searchTerm,
      setGifSearch = _ref.setGifSearch,
      gifResults = _ref.gifResults,
      pagePos = _ref.pagePos,
      hasNextPage = _ref.hasNextPage,
      isLoading = _ref.isLoading,
      setGif = _ref.setGif,
      plugin_settings = _ref.plugin_settings;
  var altText = attributes.altText,
      currentGif = attributes.currentGif;
  var keyLabel = sprintf(__('Please enter your Tenor API key on the <a href="%s">settings page</a>.', 'gg'), plugin_settings.gg_settings_page); //alt text box

  var altTextInput = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["TextControl"], {
    label: __('Alt text (alternative text)'),
    value: altText,
    help: Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["ExternalLink"], {
      href: "https://www.w3.org/WAI/tutorials/images/decision-tree"
    }, "Describe the purpose of the image"),
    onChange: function onChange(value) {
      return setAttributes({
        altText: value
      });
    }
  }); //remove alt text box if not key has been entered

  if (!currentGif && plugin_settings.tenor_api_key == '') {
    altTextInput = '';
  } //input for searching for gifs


  var gifSearchInput = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(Fragment, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
    class: "powered-by"
  }, __('Powered by Tenor')), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["__experimentalInputControl"], {
    label: __('Set Gif'),
    placeholder: __('Search Tenor'),
    value: searchTerm,
    isPressEnterToChange: "true",
    suffix: Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Button"], {
      className: "is-primary"
    }, __('Search')),
    onChange: function onChange(newSearchTerm) {
      return setGifSearch(newSearchTerm, 'reset');
    }
  })); //remove input if they havent entered their key

  if (plugin_settings.tenor_api_key == '') {
    gifSearchInput = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(Fragment, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["RichText"].Content, {
      tagName: "p",
      value: keyLabel
    }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Button"], {
      className: "components-button is-secondary",
      href: plugin_settings.gg_settings_page
    }, __('Visit Settings Page')));
  }

  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(Fragment, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(InspectorControls, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(PanelBody, {
    title: __('Settings')
  }, altTextInput, gifSearchInput, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_gif_results__WEBPACK_IMPORTED_MODULE_5__["default"], {
    attributes: attributes,
    gifResults: gifResults,
    pagePos: pagePos,
    setGifSearch: setGifSearch,
    searchTerm: searchTerm,
    hasNextPage: hasNextPage,
    isLoading: isLoading,
    setGif: setGif
  }))));
}; // wrap the component with withState so we can manipulate the state
// by using nativelly supporeted WordPress functions


/* harmony default export */ __webpack_exports__["default"] = (Object(_wordpress_compose__WEBPACK_IMPORTED_MODULE_3__["withState"])()(GifSearch));

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _gif_search__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./gif-search */ "./src/gif-search.js");
/* harmony import */ var _gif_box__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./gif-box */ "./src/gif-box.js");







 //to add alignment without using support

var __ = wp.i18n.__; // The __() for internationalization.

var registerBlockType = wp.blocks.registerBlockType; // The registerBlockType() to register blocks.

var Fragment = wp.element.Fragment; // Wrapper we can use instead of adding markup, like div, etc

var plugin_settings = gg_settings; //localized settings from enqueue scripts

/**
 * Register: a Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

registerBlockType("gg/tenor-for-gutenberg", {
  title: __("Gif"),
  // Our block title
  description: __('Search and embed gifs directly from Tenor.', 'gg'),
  icon: "format-image",
  category: "media",
  // pick a category from core provided ones or create a custom one
  keywords: [__("Tenor"), __("Gif")],
  supports: {// Declare support for block's alignment.
    // This adds support for all the options:
    // left, center, right, wide, and full.
  },
  // attributes start here
  attributes: {
    currentGif: {
      type: 'string'
    },
    currentGifWidth: {
      type: 'number'
    },
    currentGifHeight: {
      type: 'number'
    },
    altText: {
      type: 'string'
    },
    captionText: {
      type: 'string'
    },
    align: {
      type: "string",
      default: "center"
    },
    gifBoxWidth: {
      type: 'number'
    },
    gifBoxHeight: {
      type: 'number'
    }
  },
  // attributes end here
  //show example when hovering to select block
  example: {
    attributes: {
      currentGif: 'https://media.tenor.com/images/a8e4ceb0e6e1eaa33da1233bad36bd98/tenor.gif',
      currentGifWidth: 500,
      currentGifHeight: 280,
      gifBoxWidth: 500,
      gifBoxHeight: 280,
      captionText: 'Via Tenor'
    }
  },

  /**
   * Edit function will render our block code
   * inside the Gutemberg editor once inserted
   */
  edit: Object(_wordpress_compose__WEBPACK_IMPORTED_MODULE_2__["withState"])({
    gifResults: []
  })(function (_ref) {
    var gifResults = _ref.gifResults,
        setState = _ref.setState,
        attributes = _ref.attributes,
        setAttributes = _ref.setAttributes,
        searchTerm = _ref.searchTerm,
        pagePos = _ref.pagePos,
        hasNextPage = _ref.hasNextPage,
        isLoading = _ref.isLoading,
        hasPreviousGif = _ref.hasPreviousGif;

    var setGifSearch = function setGifSearch(newSearchTerm) {
      var where = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

      if (where == 'reset') {
        //new search, reset counter
        pagePos = 0;
      } else if (where == 'prev') {
        //previous button pushed
        pagePos = pagePos - 1;
      } else {
        //next button pushed
        pagePos = pagePos + 1;
      }

      if (newSearchTerm) {
        //show spinner
        setState({
          isLoading: true
        }); //get results

        _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_3___default()({
          path: '/gg/v1/search/' + newSearchTerm + '/pos/' + pagePos
        }).then(function (response) {
          //see if we have a next page
          hasNextPage = true;

          if (response.last_page == 1) {
            hasNextPage = false;
          } //set state to update display


          setState({
            gifResults: response.options,
            pagePos: pagePos,
            searchTerm: newSearchTerm,
            hasNextPage: hasNextPage,
            isLoading: false
          });
        });
      }
    };

    var setCaption = function setCaption(caption) {
      if (!caption.includes('Via Tenor')) {
        caption = caption + ' Via Tenor';
      }

      setAttributes({
        captionText: caption
      });
    };

    var setGif = function setGif(newGif) {
      setAttributes({
        currentGif: newGif.url,
        currentGifWidth: newGif.width,
        currentGifHeight: newGif.height,
        gifBoxWidth: newGif.width,
        //reset resizable box container
        gifBoxHeight: newGif.height //reset resizable box container

      });
    };

    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(Fragment, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["BlockControls"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["BlockAlignmentToolbar"], {
      value: attributes.align,
      onChange: function onChange(nextAlign) {
        setAttributes({
          align: nextAlign
        });
      }
    })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_gif_search__WEBPACK_IMPORTED_MODULE_5__["default"], {
      attributes: attributes,
      gifResults: gifResults,
      setAttributes: setAttributes,
      setGifSearch: setGifSearch,
      searchTerm: searchTerm,
      pagePos: pagePos,
      hasNextPage: hasNextPage,
      isLoading: isLoading,
      setGif: setGif,
      plugin_settings: plugin_settings
    }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_gif_box__WEBPACK_IMPORTED_MODULE_6__["default"], {
      attributes: attributes,
      setCaption: setCaption,
      setAttributes: setAttributes,
      plugin_settings: plugin_settings
    }));
  }),

  /**
   * Save function will handle the client side rendering
   * This is the code (html markup) which will be saved into the_content
   * once post is saved
   */
  save: function save(props) {
    var attributes = props.attributes;
    var currentGif = attributes.currentGif,
        currentGifWidth = attributes.currentGifWidth,
        currentGifHeight = attributes.currentGifHeight,
        align = attributes.align,
        captionText = attributes.captionText,
        altText = attributes.altText,
        gifBoxWidth = attributes.gifBoxWidth,
        gifBoxHeight = attributes.gifBoxHeight;
    if (!currentGif) return '';
    var classes = 'align' + align;
    var caption = 'Via Tenor';

    if (captionText) {
      caption = captionText;
    }

    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(Fragment, null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
      className: "wp-block-image gg-gif-block"
    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("figure", {
      className: classes,
      style: {
        width: gifBoxWidth
      }
    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
      className: "components-resizable-box__container"
    }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("img", {
      src: currentGif,
      width: currentGifWidth,
      height: currentGifHeight,
      alt: altText
    })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("figcaption", null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["RichText"].Content, {
      tagName: "span",
      value: caption
    })))));
  }
});

/***/ }),

/***/ "@wordpress/api-fetch":
/*!*******************************************!*\
  !*** external {"this":["wp","apiFetch"]} ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["apiFetch"]; }());

/***/ }),

/***/ "@wordpress/block-editor":
/*!**********************************************!*\
  !*** external {"this":["wp","blockEditor"]} ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["blockEditor"]; }());

/***/ }),

/***/ "@wordpress/components":
/*!*********************************************!*\
  !*** external {"this":["wp","components"]} ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["components"]; }());

/***/ }),

/***/ "@wordpress/compose":
/*!******************************************!*\
  !*** external {"this":["wp","compose"]} ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["compose"]; }());

/***/ }),

/***/ "@wordpress/element":
/*!******************************************!*\
  !*** external {"this":["wp","element"]} ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["wp"]["element"]; }());

/***/ }),

/***/ "react":
/*!*********************************!*\
  !*** external {"this":"React"} ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = this["React"]; }());

/***/ })

/******/ });
//# sourceMappingURL=index.js.map