/*!
 * AdminLTE v3.2.0-rc (https://adminlte.io)
 * Copyright 2014-2021 Colorlib <https://colorlib.com>
 * Licensed under MIT (https://github.com/ColorlibHQ/AdminLTE/blob/master/LICENSE)
 */
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports, require('jquery')) :
    typeof define === 'function' && define.amd ? define(['exports', 'jquery'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.adminlte = {}, global.jQuery));
  }(this, (function (exports, $) { 'use strict';
  
    function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }
  
    var $__default = /*#__PURE__*/_interopDefaultLegacy($);
  
   
  
  
    /**
     * --------------------------------------------
     * AdminLTE ControlSidebar.js
     * License MIT
     * --------------------------------------------
     */
    /**
     * Constants
     * ====================================================
     */
  
    var NAME$c = 'ControlSidebar';
    var DATA_KEY$c = 'lte.controlsidebar';
    var EVENT_KEY$5 = "." + DATA_KEY$c;
    var JQUERY_NO_CONFLICT$c = $__default['default'].fn[NAME$c];
    var EVENT_COLLAPSED$3 = "collapsed" + EVENT_KEY$5;
    var EVENT_COLLAPSED_DONE$1 = "collapsed-done" + EVENT_KEY$5;
    var EVENT_EXPANDED$2 = "expanded" + EVENT_KEY$5;
    var SELECTOR_CONTROL_SIDEBAR = '.control-sidebar';
    var SELECTOR_CONTROL_SIDEBAR_CONTENT$1 = '.control-sidebar-content';
    var SELECTOR_DATA_TOGGLE$4 = '[data-widget="control-sidebar"]';
    var SELECTOR_HEADER$1 = '.main-header';
    var SELECTOR_FOOTER$1 = '.main-footer';
    var CLASS_NAME_CONTROL_SIDEBAR_ANIMATE = 'control-sidebar-animate';
    var CLASS_NAME_CONTROL_SIDEBAR_OPEN$1 = 'control-sidebar-open';
    var CLASS_NAME_CONTROL_SIDEBAR_SLIDE = 'control-sidebar-slide-open';
    var CLASS_NAME_LAYOUT_FIXED$1 = 'layout-fixed';
    var CLASS_NAME_NAVBAR_FIXED = 'layout-navbar-fixed';
    var CLASS_NAME_NAVBAR_SM_FIXED = 'layout-sm-navbar-fixed';
    var CLASS_NAME_NAVBAR_MD_FIXED = 'layout-md-navbar-fixed';
    var CLASS_NAME_NAVBAR_LG_FIXED = 'layout-lg-navbar-fixed';
    var CLASS_NAME_NAVBAR_XL_FIXED = 'layout-xl-navbar-fixed';
    var CLASS_NAME_FOOTER_FIXED = 'layout-footer-fixed';
    var CLASS_NAME_FOOTER_SM_FIXED = 'layout-sm-footer-fixed';
    var CLASS_NAME_FOOTER_MD_FIXED = 'layout-md-footer-fixed';
    var CLASS_NAME_FOOTER_LG_FIXED = 'layout-lg-footer-fixed';
    var CLASS_NAME_FOOTER_XL_FIXED = 'layout-xl-footer-fixed';
    var Default$a = {
      controlsidebarSlide: true,
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'l',
      target: SELECTOR_CONTROL_SIDEBAR,
      animationSpeed: 300
    };
    /**
     * Class Definition
     * ====================================================
     */
  
    var ControlSidebar = /*#__PURE__*/function () {
      function ControlSidebar(element, config) {
        this._element = element;
        this._config = config;
      } // Public
  
  
      var _proto = ControlSidebar.prototype;
  
      _proto.collapse = function collapse() {
        var _this = this;
  
        var $body = $__default['default']('body');
        var $html = $__default['default']('html');
        var target = this._config.target; // Show the control sidebar
  
        if (this._config.controlsidebarSlide) {
          $html.addClass(CLASS_NAME_CONTROL_SIDEBAR_ANIMATE);
          $body.removeClass(CLASS_NAME_CONTROL_SIDEBAR_SLIDE).delay(300).queue(function () {
            $__default['default'](target).hide();
            $html.removeClass(CLASS_NAME_CONTROL_SIDEBAR_ANIMATE);
            $__default['default'](this).dequeue();
          });
        } else {
          $body.removeClass(CLASS_NAME_CONTROL_SIDEBAR_OPEN$1);
        }
  
        $__default['default'](this._element).trigger($__default['default'].Event(EVENT_COLLAPSED$3));
        setTimeout(function () {
          $__default['default'](_this._element).trigger($__default['default'].Event(EVENT_COLLAPSED_DONE$1));
        }, this._config.animationSpeed);
      };
  
      _proto.show = function show() {
        var $body = $__default['default']('body');
        var $html = $__default['default']('html'); // Collapse the control sidebar
  
        if (this._config.controlsidebarSlide) {
          $html.addClass(CLASS_NAME_CONTROL_SIDEBAR_ANIMATE);
          $__default['default'](this._config.target).show().delay(10).queue(function () {
            $body.addClass(CLASS_NAME_CONTROL_SIDEBAR_SLIDE).delay(300).queue(function () {
              $html.removeClass(CLASS_NAME_CONTROL_SIDEBAR_ANIMATE);
              $__default['default'](this).dequeue();
            });
            $__default['default'](this).dequeue();
          });
        } else {
          $body.addClass(CLASS_NAME_CONTROL_SIDEBAR_OPEN$1);
        }
  
        this._fixHeight();
  
        this._fixScrollHeight();
  
        $__default['default'](this._element).trigger($__default['default'].Event(EVENT_EXPANDED$2));
      };
  
      _proto.toggle = function toggle() {
        var $body = $__default['default']('body');
        var shouldClose = $body.hasClass(CLASS_NAME_CONTROL_SIDEBAR_OPEN$1) || $body.hasClass(CLASS_NAME_CONTROL_SIDEBAR_SLIDE);
  
        if (shouldClose) {
          // Close the control sidebar
          this.collapse();
        } else {
          // Open the control sidebar
          this.show();
        }
      } // Private
      ;
  
      _proto._init = function _init() {
        var _this2 = this;
  
        var $body = $__default['default']('body');
        var shouldNotHideAll = $body.hasClass(CLASS_NAME_CONTROL_SIDEBAR_OPEN$1) || $body.hasClass(CLASS_NAME_CONTROL_SIDEBAR_SLIDE);
  
        if (shouldNotHideAll) {
          $__default['default'](SELECTOR_CONTROL_SIDEBAR).not(this._config.target).hide();
          $__default['default'](this._config.target).css('display', 'block');
        } else {
          $__default['default'](SELECTOR_CONTROL_SIDEBAR).hide();
        }
  
        this._fixHeight();
  
        this._fixScrollHeight();
  
        $__default['default'](window).resize(function () {
          _this2._fixHeight();
  
          _this2._fixScrollHeight();
        });
        $__default['default'](window).scroll(function () {
          var $body = $__default['default']('body');
          var shouldFixHeight = $body.hasClass(CLASS_NAME_CONTROL_SIDEBAR_OPEN$1) || $body.hasClass(CLASS_NAME_CONTROL_SIDEBAR_SLIDE);
  
          if (shouldFixHeight) {
            _this2._fixScrollHeight();
          }
        });
      };
  
      _proto._isNavbarFixed = function _isNavbarFixed() {
        var $body = $__default['default']('body');
        return $body.hasClass(CLASS_NAME_NAVBAR_FIXED) || $body.hasClass(CLASS_NAME_NAVBAR_SM_FIXED) || $body.hasClass(CLASS_NAME_NAVBAR_MD_FIXED) || $body.hasClass(CLASS_NAME_NAVBAR_LG_FIXED) || $body.hasClass(CLASS_NAME_NAVBAR_XL_FIXED);
      };
  
      _proto._isFooterFixed = function _isFooterFixed() {
        var $body = $__default['default']('body');
        return $body.hasClass(CLASS_NAME_FOOTER_FIXED) || $body.hasClass(CLASS_NAME_FOOTER_SM_FIXED) || $body.hasClass(CLASS_NAME_FOOTER_MD_FIXED) || $body.hasClass(CLASS_NAME_FOOTER_LG_FIXED) || $body.hasClass(CLASS_NAME_FOOTER_XL_FIXED);
      };
  
      _proto._fixScrollHeight = function _fixScrollHeight() {
        var $body = $__default['default']('body');
        var $controlSidebar = $__default['default'](this._config.target);
  
        if (!$body.hasClass(CLASS_NAME_LAYOUT_FIXED$1)) {
          return;
        }
  
        var heights = {
          scroll: $__default['default'](document).height(),
          window: $__default['default'](window).height(),
          header: $__default['default'](SELECTOR_HEADER$1).outerHeight(),
          footer: $__default['default'](SELECTOR_FOOTER$1).outerHeight()
        };
        var positions = {
          bottom: Math.abs(heights.window + $__default['default'](window).scrollTop() - heights.scroll),
          top: $__default['default'](window).scrollTop()
        };
        var navbarFixed = this._isNavbarFixed() && $__default['default'](SELECTOR_HEADER$1).css('position') === 'fixed';
        var footerFixed = this._isFooterFixed() && $__default['default'](SELECTOR_FOOTER$1).css('position') === 'fixed';
        var $controlsidebarContent = $__default['default'](this._config.target + ", " + this._config.target + " " + SELECTOR_CONTROL_SIDEBAR_CONTENT$1);
  
        if (positions.top === 0 && positions.bottom === 0) {
          $controlSidebar.css({
            bottom: heights.footer,
            top: heights.header
          });
          $controlsidebarContent.css('height', heights.window - (heights.header + heights.footer));
        } else if (positions.bottom <= heights.footer) {
          if (footerFixed === false) {
            var top = heights.header - positions.top;
            $controlSidebar.css('bottom', heights.footer - positions.bottom).css('top', top >= 0 ? top : 0);
            $controlsidebarContent.css('height', heights.window - (heights.footer - positions.bottom));
          } else {
            $controlSidebar.css('bottom', heights.footer);
          }
        } else if (positions.top <= heights.header) {
          if (navbarFixed === false) {
            $controlSidebar.css('top', heights.header - positions.top);
            $controlsidebarContent.css('height', heights.window - (heights.header - positions.top));
          } else {
            $controlSidebar.css('top', heights.header);
          }
        } else if (navbarFixed === false) {
          $controlSidebar.css('top', 0);
          $controlsidebarContent.css('height', heights.window);
        } else {
          $controlSidebar.css('top', heights.header);
        }
  
        if (footerFixed && navbarFixed) {
          $controlsidebarContent.css('height', '100%');
          $controlSidebar.css('height', '');
        } else if (footerFixed || navbarFixed) {
          $controlsidebarContent.css('height', '100%');
          $controlsidebarContent.css('height', '');
        }
      };
  
      _proto._fixHeight = function _fixHeight() {
        var $body = $__default['default']('body');
        var $controlSidebar = $__default['default'](this._config.target + " " + SELECTOR_CONTROL_SIDEBAR_CONTENT$1);
  
        if (!$body.hasClass(CLASS_NAME_LAYOUT_FIXED$1)) {
          $controlSidebar.attr('style', '');
          return;
        }
  
        var heights = {
          window: $__default['default'](window).height(),
          header: $__default['default'](SELECTOR_HEADER$1).outerHeight(),
          footer: $__default['default'](SELECTOR_FOOTER$1).outerHeight()
        };
        var sidebarHeight = heights.window - heights.header;
  
        if (this._isFooterFixed() && $__default['default'](SELECTOR_FOOTER$1).css('position') === 'fixed') {
          sidebarHeight = heights.window - heights.header - heights.footer;
        }
  
        $controlSidebar.css('height', sidebarHeight);
  
        if (typeof $__default['default'].fn.overlayScrollbars !== 'undefined') {
          $controlSidebar.overlayScrollbars({
            className: this._config.scrollbarTheme,
            sizeAutoCapable: true,
            scrollbars: {
              autoHide: this._config.scrollbarAutoHide,
              clickScrolling: true
            }
          });
        }
      } // Static
      ;
  
      ControlSidebar._jQueryInterface = function _jQueryInterface(operation) {
        return this.each(function () {
          var data = $__default['default'](this).data(DATA_KEY$c);
  
          var _options = $__default['default'].extend({}, Default$a, $__default['default'](this).data());
  
          if (!data) {
            data = new ControlSidebar(this, _options);
            $__default['default'](this).data(DATA_KEY$c, data);
          }
  
          if (data[operation] === 'undefined') {
            throw new Error(operation + " is not a function");
          }
  
          data[operation]();
        });
      };
  
      return ControlSidebar;
    }();
    /**
     *
     * Data Api implementation
     * ====================================================
     */
  
  
    $__default['default'](document).on('click', SELECTOR_DATA_TOGGLE$4, function (event) {
      event.preventDefault();
  
      ControlSidebar._jQueryInterface.call($__default['default'](this), 'toggle');
    });
    $__default['default'](document).ready(function () {
      ControlSidebar._jQueryInterface.call($__default['default'](SELECTOR_DATA_TOGGLE$4), '_init');
    });
    /**
     * jQuery API
     * ====================================================
     */
  
    $__default['default'].fn[NAME$c] = ControlSidebar._jQueryInterface;
    $__default['default'].fn[NAME$c].Constructor = ControlSidebar;
  
    $__default['default'].fn[NAME$c].noConflict = function () {
      $__default['default'].fn[NAME$c] = JQUERY_NO_CONFLICT$c;
      return ControlSidebar._jQueryInterface;
    };
  
    /**
     * --------------------------------------------
     * AdminLTE Fullscreen.js
     * License MIT
     * --------------------------------------------
     */
    /**
     * Constants
     * ====================================================
     */
  
    var NAME$8 = 'Fullscreen';
    var DATA_KEY$8 = 'lte.fullscreen';
    var JQUERY_NO_CONFLICT$8 = $__default['default'].fn[NAME$8];
    var SELECTOR_DATA_WIDGET$2 = '[data-widget="fullscreen"]';
    var SELECTOR_ICON = SELECTOR_DATA_WIDGET$2 + " i";
    var EVENT_FULLSCREEN_CHANGE = 'webkitfullscreenchange mozfullscreenchange fullscreenchange MSFullscreenChange';
    var Default$8 = {
      minimizeIcon: 'fa-compress-arrows-alt',
      maximizeIcon: 'fa-expand-arrows-alt'
    };
    /**
     * Class Definition
     * ====================================================
     */
  
    var Fullscreen = /*#__PURE__*/function () {
      function Fullscreen(_element, _options) {
        this.element = _element;
        this.options = $__default['default'].extend({}, Default$8, _options);
      } // Public
  
  
      var _proto = Fullscreen.prototype;
  
      _proto.toggle = function toggle() {
        if (document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
          this.windowed();
        } else {
          this.fullscreen();
        }
      };
  
      _proto.toggleIcon = function toggleIcon() {
        if (document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement) {
          $__default['default'](SELECTOR_ICON).removeClass(this.options.maximizeIcon).addClass(this.options.minimizeIcon);
        } else {
          $__default['default'](SELECTOR_ICON).removeClass(this.options.minimizeIcon).addClass(this.options.maximizeIcon);
        }
      };
  
      _proto.fullscreen = function fullscreen() {
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      };
  
      _proto.windowed = function windowed() {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      } // Static
      ;
  
      Fullscreen._jQueryInterface = function _jQueryInterface(config) {
        var data = $__default['default'](this).data(DATA_KEY$8);
  
        if (!data) {
          data = $__default['default'](this).data();
        }
  
        var _options = $__default['default'].extend({}, Default$8, typeof config === 'object' ? config : data);
  
        var plugin = new Fullscreen($__default['default'](this), _options);
        $__default['default'](this).data(DATA_KEY$8, typeof config === 'object' ? config : data);
  
        if (typeof config === 'string' && /toggle|toggleIcon|fullscreen|windowed/.test(config)) {
          plugin[config]();
        } else {
          plugin.init();
        }
      };
  
      return Fullscreen;
    }();
    /**
      * Data API
      * ====================================================
      */
  
  
    $__default['default'](document).on('click', SELECTOR_DATA_WIDGET$2, function () {
      Fullscreen._jQueryInterface.call($__default['default'](this), 'toggle');
    });
    $__default['default'](document).on(EVENT_FULLSCREEN_CHANGE, function () {
      Fullscreen._jQueryInterface.call($__default['default'](SELECTOR_DATA_WIDGET$2), 'toggleIcon');
    });
    /**
     * jQuery API
     * ====================================================
     */
  
    $__default['default'].fn[NAME$8] = Fullscreen._jQueryInterface;
    $__default['default'].fn[NAME$8].Constructor = Fullscreen;
  
    $__default['default'].fn[NAME$8].noConflict = function () {
      $__default['default'].fn[NAME$8] = JQUERY_NO_CONFLICT$8;
      return Fullscreen._jQueryInterface;
    };
  
    exports.ControlSidebar = ControlSidebar;
    exports.Fullscreen = Fullscreen;
  
    Object.defineProperty(exports, '__esModule', { value: true });
  
  })));
  