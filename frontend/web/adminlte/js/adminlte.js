(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
    typeof define === 'function' && define.amd ? define(['exports'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.adminlte = {}));
})(this, (function (exports) { 'use strict';

    /*! *****************************************************************************
    Copyright (c) Microsoft Corporation.

    Permission to use, copy, modify, and/or distribute this software for any
    purpose with or without fee is hereby granted.

    THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
    REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
    AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
    INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
    LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
    OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
    PERFORMANCE OF THIS SOFTWARE.
    ***************************************************************************** */

    var __assign = function() {
        __assign = Object.assign || function __assign(t) {
            for (var s, i = 1, n = arguments.length; i < n; i++) {
                s = arguments[i];
                for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
            }
            return t;
        };
        return __assign.apply(this, arguments);
    };

    var domReady = function (callBack) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callBack);
        }
        else {
            callBack();
        }
    };
    /* SLIDE UP */
    var slideUp = function (target, duration) {
        if (duration === void 0) { duration = 500; }
        target.style.transitionProperty = 'height, margin, padding';
        target.style.transitionDuration = duration + "ms";
        target.style.boxSizing = 'border-box';
        target.style.height = target.offsetHeight + "px";
        target.style.overflow = 'hidden';
        window.setTimeout(function () {
            target.style.height = '0';
            target.style.paddingTop = '0';
            target.style.paddingBottom = '0';
            target.style.marginTop = '0';
            target.style.marginBottom = '0';
        }, 1);
        window.setTimeout(function () {
            target.style.display = 'none';
            target.style.removeProperty('height');
            target.style.removeProperty('padding-top');
            target.style.removeProperty('padding-bottom');
            target.style.removeProperty('margin-top');
            target.style.removeProperty('margin-bottom');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
        }, duration);
    };
    /* SLIDE DOWN */
    var slideDown = function (target, duration) {
        if (duration === void 0) { duration = 500; }
        target.style.removeProperty('display');
        var display = window.getComputedStyle(target).display;
        if (display === 'none') {
            display = 'block';
        }
        target.style.display = display;
        var height = target.offsetHeight;
        target.style.overflow = 'hidden';
        target.style.height = '0';
        target.style.paddingTop = '0';
        target.style.paddingBottom = '0';
        target.style.marginTop = '0';
        target.style.marginBottom = '0';
        window.setTimeout(function () {
            target.style.boxSizing = 'border-box';
            target.style.transitionProperty = 'height, margin, padding';
            target.style.transitionDuration = duration + "ms";
            target.style.height = height + "px";
            target.style.removeProperty('padding-top');
            target.style.removeProperty('padding-bottom');
            target.style.removeProperty('margin-top');
            target.style.removeProperty('margin-bottom');
        }, 1);
        window.setTimeout(function () {
            target.style.removeProperty('height');
            target.style.removeProperty('overflow');
            target.style.removeProperty('transition-duration');
            target.style.removeProperty('transition-property');
        }, duration);
    };

    /**
     * --------------------------------------------
     * AdminLTE layout.ts
     * License MIT
     * --------------------------------------------
     */
    /**
     * ------------------------------------------------------------------------
     * Constants
     * ------------------------------------------------------------------------
     */
    var CLASS_NAME_HOLD_TRANSITIONS = 'hold-transition';
    var SELECTOR_SIDEBAR$1 = '.sidebar';
    var Default$2 = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave'
    };
    /**
     * Class Definition
     * ====================================================
     */
    var Layout = /** @class */ (function () {
        function Layout(element, config) {
            this._element = element;
            this._config = __assign(__assign({}, Default$2), config);
        }
        Layout.prototype.holdTransition = function () {
            var resizeTimer;
            window.addEventListener('resize', function () {
                document.body.classList.add(CLASS_NAME_HOLD_TRANSITIONS);
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function () {
                    document.body.classList.remove(CLASS_NAME_HOLD_TRANSITIONS);
                }, 400);
            });
        };
        return Layout;
    }());
    domReady(function () {
        var data = new Layout(document.body, Default$2);
        data.holdTransition();
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
        if (typeof OverlayScrollbars !== 'undefined') {
            // eslint-disable-next-line @typescript-eslint/ban-ts-comment
            // @ts-expect-error
            // eslint-disable-next-line @typescript-eslint/no-unsafe-call
            OverlayScrollbars(document.querySelectorAll(SELECTOR_SIDEBAR$1), {
                className: Default$2.scrollbarTheme,
                sizeAutoCapable: true,
                scrollbars: {
                    autoHide: Default$2.scrollbarAutoHide,
                    clickScrolling: true
                }
            });
        }
    });

    /**
     * --------------------------------------------
     * AdminLTE push-menu.ts
     * License MIT
     * --------------------------------------------
     */
    /**
     * ------------------------------------------------------------------------
     * Constants
     * ------------------------------------------------------------------------
     */
    var CLASS_NAME_SIDEBAR_MINI = 'sidebar-mini';
    var CLASS_NAME_SIDEBAR_MINI_HAD = 'sidebar-mini-had';
    var CLASS_NAME_SIDEBAR_HORIZONTAL = 'sidebar-horizontal';
    var CLASS_NAME_SIDEBAR_COLLAPSE = 'sidebar-collapse';
    var CLASS_NAME_SIDEBAR_CLOSE = 'sidebar-close';
    var CLASS_NAME_SIDEBAR_OPEN = 'sidebar-open';
    var CLASS_NAME_SIDEBAR_OPENING = 'sidebar-is-opening';
    var CLASS_NAME_SIDEBAR_COLLAPSING = 'sidebar-is-collapsing';
    var CLASS_NAME_SIDEBAR_IS_HOVER = 'sidebar-is-hover';
    var CLASS_NAME_MENU_OPEN$1 = 'menu-open';
    var CLASS_NAME_LAYOUT_MOBILE = 'layout-mobile';
    var SELECTOR_SIDEBAR = '.sidebar';
    var SELECTOR_NAV_SIDEBAR = '.nav-sidebar';
    var SELECTOR_NAV_ITEM$1 = '.nav-item';
    var SELECTOR_NAV_TREEVIEW = '.nav-treeview';
    var SELECTOR_MINI_TOGGLE = '[data-lte-toggle="sidebar-mini"]';
    var SELECTOR_FULL_TOGGLE = '[data-lte-toggle="sidebar-full"]';
    var SELECTOR_SIDEBAR_SM = "." + CLASS_NAME_LAYOUT_MOBILE;
    var SELECTOR_CONTENT_WRAPPER = '.content-wrapper';
    var Defaults = {
        onLayouMobile: 992
    };
    /**
     * Class Definition
     * ====================================================
     */
    var PushMenu = /** @class */ (function () {
        function PushMenu(element, config) {
            this._element = element;
            var bodyElement = document.body;
            this._bodyClass = bodyElement.classList;
            this._config = config;
        }
        PushMenu.prototype.sidebarOpening = function () {
            var _this = this;
            this._bodyClass.add(CLASS_NAME_SIDEBAR_OPENING);
            setTimeout(function () {
                _this._bodyClass.remove(CLASS_NAME_SIDEBAR_OPENING);
            }, 1000);
        };
        PushMenu.prototype.sidebarColllapsing = function () {
            var _this = this;
            this._bodyClass.add(CLASS_NAME_SIDEBAR_COLLAPSING);
            setTimeout(function () {
                _this._bodyClass.remove(CLASS_NAME_SIDEBAR_COLLAPSING);
            }, 1000);
        };
        PushMenu.prototype.menusClose = function () {
            var navTreeview = document.querySelectorAll(SELECTOR_NAV_TREEVIEW);
            for (var _i = 0, navTreeview_1 = navTreeview; _i < navTreeview_1.length; _i++) {
                var navTree = navTreeview_1[_i];
                navTree.style.removeProperty('display');
                navTree.style.removeProperty('height');
            }
            var navSidebar = document.querySelector(SELECTOR_NAV_SIDEBAR);
            var navItem = navSidebar === null || navSidebar === void 0 ? void 0 : navSidebar.querySelectorAll(SELECTOR_NAV_ITEM$1);
            if (navItem) {
                for (var _a = 0, navItem_1 = navItem; _a < navItem_1.length; _a++) {
                    var navI = navItem_1[_a];
                    navI.classList.remove(CLASS_NAME_MENU_OPEN$1);
                }
            }
        };
        PushMenu.prototype.expand = function () {
            this.sidebarOpening();
            this._bodyClass.remove(CLASS_NAME_SIDEBAR_CLOSE);
            this._bodyClass.remove(CLASS_NAME_SIDEBAR_COLLAPSE);
            this._bodyClass.add(CLASS_NAME_SIDEBAR_OPEN);
        };
        PushMenu.prototype.collapse = function () {
            this.sidebarColllapsing();
            this._bodyClass.add(CLASS_NAME_SIDEBAR_COLLAPSE);
        };
        PushMenu.prototype.close = function () {
            this._bodyClass.add(CLASS_NAME_SIDEBAR_CLOSE);
            this._bodyClass.remove(CLASS_NAME_SIDEBAR_OPEN);
            this._bodyClass.remove(CLASS_NAME_SIDEBAR_COLLAPSE);
            if (this._bodyClass.contains(CLASS_NAME_SIDEBAR_HORIZONTAL)) {
                this.menusClose();
            }
        };
        PushMenu.prototype.sidebarHover = function () {
            var _this = this;
            var selSidebar = document.querySelector(SELECTOR_SIDEBAR);
            if (selSidebar) {
                selSidebar.addEventListener('mouseover', function () {
                    _this._bodyClass.add(CLASS_NAME_SIDEBAR_IS_HOVER);
                });
                selSidebar.addEventListener('mouseout', function () {
                    _this._bodyClass.remove(CLASS_NAME_SIDEBAR_IS_HOVER);
                });
            }
        };
        PushMenu.prototype.addSidebaBreakPoint = function () {
            var bodyClass = document.body.classList;
            var widthOutput = window.innerWidth;
            if (widthOutput >= Defaults.onLayouMobile) {
                bodyClass.remove(CLASS_NAME_LAYOUT_MOBILE);
            }
            else {
                bodyClass.add(CLASS_NAME_LAYOUT_MOBILE);
            }
        };
        PushMenu.prototype.removeOverlaySidebar = function () {
            var bodyClass = document.body.classList;
            if (bodyClass.contains(CLASS_NAME_LAYOUT_MOBILE)) {
                bodyClass.remove(CLASS_NAME_SIDEBAR_OPEN);
                bodyClass.remove(CLASS_NAME_SIDEBAR_COLLAPSE);
                bodyClass.add(CLASS_NAME_SIDEBAR_CLOSE);
            }
        };
        PushMenu.prototype.closeSidebar = function () {
            var widthOutput = window.innerWidth;
            if (widthOutput < Defaults.onLayouMobile) {
                document.body.classList.add(CLASS_NAME_SIDEBAR_CLOSE);
            }
        };
        PushMenu.prototype.toggleFull = function () {
            if (this._bodyClass.contains(CLASS_NAME_SIDEBAR_CLOSE)) {
                this.expand();
            }
            else {
                this.close();
            }
            if (this._bodyClass.contains(CLASS_NAME_SIDEBAR_MINI)) {
                this._bodyClass.remove(CLASS_NAME_SIDEBAR_MINI);
                this._bodyClass.add(CLASS_NAME_SIDEBAR_MINI_HAD);
            }
        };
        PushMenu.prototype.toggleMini = function () {
            if (this._bodyClass.contains(CLASS_NAME_SIDEBAR_MINI_HAD)) {
                this._bodyClass.remove(CLASS_NAME_SIDEBAR_MINI_HAD);
                this._bodyClass.add(CLASS_NAME_SIDEBAR_MINI);
            }
            if (this._bodyClass.contains(CLASS_NAME_SIDEBAR_COLLAPSE)) {
                this.expand();
            }
            else {
                this.collapse();
            }
        };
        PushMenu.prototype.init = function () {
            this.addSidebaBreakPoint();
            this.sidebarHover();
            var selSidebarSm = document.querySelector(SELECTOR_SIDEBAR_SM);
            var selContentWrapper = selSidebarSm === null || selSidebarSm === void 0 ? void 0 : selSidebarSm.querySelector(SELECTOR_CONTENT_WRAPPER);
            if (selContentWrapper) {
                selContentWrapper.addEventListener('touchstart', this.removeOverlaySidebar);
                selContentWrapper.addEventListener('click', this.removeOverlaySidebar);
            }
            this.closeSidebar();
        };
        return PushMenu;
    }());
    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */
    domReady(function () {
        var data = new PushMenu(null, null);
        data.init();
        window.addEventListener('resize', function () {
            data.init();
        });
        var fullBtn = document.querySelectorAll(SELECTOR_FULL_TOGGLE);
        for (var _i = 0, fullBtn_1 = fullBtn; _i < fullBtn_1.length; _i++) {
            var btn = fullBtn_1[_i];
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                var button = event.currentTarget;
                if ((button === null || button === void 0 ? void 0 : button.dataset.lteToggle) !== 'sidebar-full') {
                    button = button === null || button === void 0 ? void 0 : button.closest(SELECTOR_FULL_TOGGLE);
                }
                if (button) {
                    var data_1 = new PushMenu(button, null);
                    data_1.toggleFull();
                }
            });
        }
        var miniBtn = document.querySelectorAll(SELECTOR_MINI_TOGGLE);
        for (var _a = 0, miniBtn_1 = miniBtn; _a < miniBtn_1.length; _a++) {
            var btn = miniBtn_1[_a];
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                var button = event.currentTarget;
                if ((button === null || button === void 0 ? void 0 : button.dataset.lteToggle) !== 'sidebar-mini') {
                    button = button === null || button === void 0 ? void 0 : button.closest(SELECTOR_FULL_TOGGLE);
                }
                if (button) {
                    var data_2 = new PushMenu(button, null);
                    data_2.toggleMini();
                }
            });
        }
    });

    /**
     * --------------------------------------------
     * AdminLTE treeview.ts
     * License MIT
     * --------------------------------------------
     */
    /**
     * ------------------------------------------------------------------------
     * Constants
     * ------------------------------------------------------------------------
     */
    // const NAME = 'Treeview'
    var DATA_KEY = 'lte.treeview';
    var EVENT_KEY = "." + DATA_KEY;
    var EVENT_EXPANDED = "expanded" + EVENT_KEY;
    var EVENT_COLLAPSED = "collapsed" + EVENT_KEY;
    // const EVENT_LOAD_DATA_API = `load${EVENT_KEY}`
    var CLASS_NAME_MENU_OPEN = 'menu-open';
    var CLASS_NAME_MENU_IS_OPEN = 'menu-is-open';
    var SELECTOR_NAV_ITEM = '.nav-item';
    var SELECTOR_TREEVIEW_MENU = '.nav-treeview';
    var SELECTOR_DATA_TOGGLE$1 = '[data-lte-toggle="treeview"]';
    var Default$1 = {
        animationSpeed: 300
    };
    /**
     * Class Definition
     * ====================================================
     */
    var Treeview = /** @class */ (function () {
        function Treeview(element, config) {
            var _a, _b;
            this._element = element;
            this._navItem = (_a = this._element) === null || _a === void 0 ? void 0 : _a.closest(SELECTOR_NAV_ITEM);
            this._childNavItem = (_b = this._navItem) === null || _b === void 0 ? void 0 : _b.querySelector(SELECTOR_TREEVIEW_MENU);
            this._config = __assign(__assign({}, Default$1), config);
        }
        Treeview.prototype.open = function () {
            var event = new CustomEvent(EVENT_EXPANDED);
            if (this._navItem) {
                this._navItem.classList.add(CLASS_NAME_MENU_OPEN);
                this._navItem.classList.add(CLASS_NAME_MENU_IS_OPEN);
            }
            if (this._childNavItem) {
                slideDown(this._childNavItem, this._config.animationSpeed);
                this._element.dispatchEvent(event);
            }
        };
        Treeview.prototype.close = function () {
            var event = new CustomEvent(EVENT_COLLAPSED);
            if (this._navItem) {
                this._navItem.classList.remove(CLASS_NAME_MENU_IS_OPEN);
                this._navItem.classList.remove(CLASS_NAME_MENU_OPEN);
            }
            if (this._childNavItem) {
                slideUp(this._childNavItem, this._config.animationSpeed);
                this._element.dispatchEvent(event);
            }
        };
        Treeview.prototype.toggle = function () {
            var _a;
            if ((_a = this._navItem) === null || _a === void 0 ? void 0 : _a.classList.contains(CLASS_NAME_MENU_OPEN)) {
                this.close();
            }
            else {
                this.open();
            }
        };
        return Treeview;
    }());
    /**
     * ------------------------------------------------------------------------
     * Data Api implementation
     * ------------------------------------------------------------------------
     */
    domReady(function () {
        var button = document.querySelectorAll(SELECTOR_DATA_TOGGLE$1);
        for (var _i = 0, button_1 = button; _i < button_1.length; _i++) {
            var btn = button_1[_i];
            btn.addEventListener('click', function (event) {
                // event.preventDefault()
                var treeviewMenu = event.target;
                var data = new Treeview(treeviewMenu, Default$1);
                data.toggle();
            });
        }
    });

    /**
     * --------------------------------------------
     * AdminLTE direct-chat.ts
     * License MIT
     * --------------------------------------------
     */
    /**
     * Constants
     * ====================================================
     */
    var SELECTOR_DATA_TOGGLE = '[data-lte-toggle="chat-pane"]';
    var SELECTOR_DIRECT_CHAT = '.direct-chat';
    var CLASS_NAME_DIRECT_CHAT_OPEN = 'direct-chat-contacts-open';
    /**
     * Class Definition
     * ====================================================
     */
    var DirectChat = /** @class */ (function () {
        function DirectChat() {
        }
        DirectChat.prototype.toggle = function (chatPane) {
            var _a;
            // chatPane
            (_a = chatPane.closest(SELECTOR_DIRECT_CHAT)) === null || _a === void 0 ? void 0 : _a.classList.toggle(CLASS_NAME_DIRECT_CHAT_OPEN);
        };
        return DirectChat;
    }());
    /**
     *
     * Data Api implementation
     * ====================================================
     */
    domReady(function () {
        var button = document.querySelectorAll(SELECTOR_DATA_TOGGLE);
        for (var _i = 0, button_1 = button; _i < button_1.length; _i++) {
            var btn = button_1[_i];
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                var chatPane = event.target;
                var data = new DirectChat();
                data.toggle(chatPane);
            });
        }
    });

    /**
     * --------------------------------------------
     * AdminLTE card-widget.ts
     * License MIT
     * --------------------------------------------
     */
    /**
     * Constants
     * ====================================================
     */
    var CLASS_NAME_CARD = 'card';
    var CLASS_NAME_COLLAPSED = 'collapsed-card';
    var CLASS_NAME_COLLAPSING = 'collapsing-card';
    var CLASS_NAME_EXPANDING = 'expanding-card';
    var CLASS_NAME_WAS_COLLAPSED = 'was-collapsed';
    var CLASS_NAME_MAXIMIZED = 'maximized-card';
    var SELECTOR_DATA_REMOVE = '[data-lte-dismiss="card-remove"]';
    var SELECTOR_DATA_COLLAPSE = '[data-lte-toggle="card-collapse"]';
    var SELECTOR_DATA_MAXIMIZE = '[data-lte-toggle="card-maximize"]';
    var SELECTOR_CARD = "." + CLASS_NAME_CARD;
    var SELECTOR_CARD_HEADER = '.card-header';
    var SELECTOR_CARD_BODY = '.card-body';
    var SELECTOR_CARD_FOOTER = '.card-footer';
    var Default = {
        animationSpeed: 500,
        collapseTrigger: SELECTOR_DATA_COLLAPSE,
        removeTrigger: SELECTOR_DATA_REMOVE,
        maximizeTrigger: SELECTOR_DATA_MAXIMIZE,
        collapseIcon: 'fa-minus',
        expandIcon: 'fa-plus',
        maximizeIcon: 'fa-expand',
        minimizeIcon: 'fa-compress'
    };
    var CardWidget = /** @class */ (function () {
        function CardWidget(element, config) {
            this._element = element;
            this._parent = element.closest(SELECTOR_CARD);
            if (element.classList.contains(CLASS_NAME_CARD)) {
                this._parent = element;
            }
            this._config = __assign(__assign({}, Default), config);
        }
        CardWidget.prototype.collapse = function () {
            var _this = this;
            var _a, _b;
            if (this._parent) {
                this._parent.classList.add(CLASS_NAME_COLLAPSING);
                var elm = (_a = this._parent) === null || _a === void 0 ? void 0 : _a.querySelectorAll(SELECTOR_CARD_BODY + ", " + SELECTOR_CARD_FOOTER);
                if (elm !== undefined) {
                    for (var _i = 0, elm_1 = elm; _i < elm_1.length; _i++) {
                        var el = elm_1[_i];
                        if (el instanceof HTMLElement) {
                            slideUp(el, this._config.animationSpeed);
                        }
                    }
                }
                setTimeout(function () {
                    if (_this._parent) {
                        _this._parent.classList.add(CLASS_NAME_COLLAPSED);
                        _this._parent.classList.remove(CLASS_NAME_COLLAPSING);
                    }
                }, this._config.animationSpeed);
            }
            var icon = (_b = this._parent) === null || _b === void 0 ? void 0 : _b.querySelector(SELECTOR_CARD_HEADER + " " + this._config.collapseTrigger + " ." + this._config.collapseIcon);
            if (icon) {
                icon.classList.remove(this._config.collapseIcon);
                icon.classList.add(this._config.expandIcon);
            }
        };
        CardWidget.prototype.expand = function () {
            var _this = this;
            var _a, _b;
            if (this._parent) {
                this._parent.classList.add(CLASS_NAME_EXPANDING);
                var elm = (_a = this._parent) === null || _a === void 0 ? void 0 : _a.querySelectorAll(SELECTOR_CARD_BODY + ", " + SELECTOR_CARD_FOOTER);
                if (elm !== undefined) {
                    for (var _i = 0, elm_2 = elm; _i < elm_2.length; _i++) {
                        var el = elm_2[_i];
                        if (el instanceof HTMLElement) {
                            slideDown(el, this._config.animationSpeed);
                        }
                    }
                }
                setTimeout(function () {
                    if (_this._parent) {
                        _this._parent.classList.remove(CLASS_NAME_COLLAPSED);
                        _this._parent.classList.remove(CLASS_NAME_EXPANDING);
                    }
                }, this._config.animationSpeed);
            }
            var icon = (_b = this._parent) === null || _b === void 0 ? void 0 : _b.querySelector(SELECTOR_CARD_HEADER + " " + this._config.collapseTrigger + " ." + this._config.expandIcon);
            if (icon) {
                icon.classList.add(this._config.collapseIcon);
                icon.classList.remove(this._config.expandIcon);
            }
        };
        CardWidget.prototype.remove = function () {
            if (this._parent) {
                slideUp(this._parent, this._config.animationSpeed);
            }
        };
        CardWidget.prototype.toggle = function () {
            var _a;
            if ((_a = this._parent) === null || _a === void 0 ? void 0 : _a.classList.contains(CLASS_NAME_COLLAPSED)) {
                this.expand();
                return;
            }
            this.collapse();
        };
        CardWidget.prototype.maximize = function () {
            var _this = this;
            if (this._parent) {
                var maxElm = this._parent.querySelector(this._config.maximizeTrigger + " ." + this._config.maximizeIcon);
                if (maxElm) {
                    maxElm.classList.add(this._config.minimizeIcon);
                    maxElm.classList.remove(this._config.maximizeIcon);
                }
                this._parent.style.height = this._parent.scrollHeight + "px";
                this._parent.style.width = this._parent.scrollWidth + "px";
                this._parent.style.transition = 'all .15s';
                setTimeout(function () {
                    var htmlTag = document.querySelector('html');
                    if (htmlTag) {
                        htmlTag.classList.add(CLASS_NAME_MAXIMIZED);
                    }
                    if (_this._parent) {
                        _this._parent.classList.add(CLASS_NAME_MAXIMIZED);
                        if (_this._parent.classList.contains(CLASS_NAME_COLLAPSED)) {
                            _this._parent.classList.add(CLASS_NAME_WAS_COLLAPSED);
                        }
                    }
                }, 150);
            }
        };
        CardWidget.prototype.minimize = function () {
            var _this = this;
            if (this._parent) {
                var minElm = this._parent.querySelector(this._config.maximizeTrigger + " ." + this._config.minimizeIcon);
                if (minElm) {
                    minElm.classList.add(this._config.maximizeIcon);
                    minElm.classList.remove(this._config.minimizeIcon);
                }
                this._parent.style.cssText = "height: " + this._parent.style.height + " !important; width: " + this._parent.style.width + " !important; transition: all .15s;";
                setTimeout(function () {
                    var _a;
                    var htmlTag = document.querySelector('html');
                    if (htmlTag) {
                        htmlTag.classList.remove(CLASS_NAME_MAXIMIZED);
                    }
                    if (_this._parent) {
                        _this._parent.classList.remove(CLASS_NAME_MAXIMIZED);
                        if ((_a = _this._parent) === null || _a === void 0 ? void 0 : _a.classList.contains(CLASS_NAME_WAS_COLLAPSED)) {
                            _this._parent.classList.remove(CLASS_NAME_WAS_COLLAPSED);
                        }
                    }
                }, 10);
            }
        };
        CardWidget.prototype.toggleMaximize = function () {
            var _a;
            if ((_a = this._parent) === null || _a === void 0 ? void 0 : _a.classList.contains(CLASS_NAME_MAXIMIZED)) {
                this.minimize();
                return;
            }
            this.maximize();
        };
        return CardWidget;
    }());
    /**
     *
     * Data Api implementation
     * ====================================================
     */
    domReady(function () {
        var collapseBtn = document.querySelectorAll(SELECTOR_DATA_COLLAPSE);
        for (var _i = 0, collapseBtn_1 = collapseBtn; _i < collapseBtn_1.length; _i++) {
            var btn = collapseBtn_1[_i];
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                var target = event.target;
                var data = new CardWidget(target, Default);
                data.toggle();
            });
        }
        var removeBtn = document.querySelectorAll(SELECTOR_DATA_REMOVE);
        for (var _a = 0, removeBtn_1 = removeBtn; _a < removeBtn_1.length; _a++) {
            var btn = removeBtn_1[_a];
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                var target = event.target;
                var data = new CardWidget(target, Default);
                data.remove();
            });
        }
        var maxBtn = document.querySelectorAll(SELECTOR_DATA_MAXIMIZE);
        for (var _b = 0, maxBtn_1 = maxBtn; _b < maxBtn_1.length; _b++) {
            var btn = maxBtn_1[_b];
            btn.addEventListener('click', function (event) {
                event.preventDefault();
                var target = event.target;
                var data = new CardWidget(target, Default);
                data.toggleMaximize();
            });
        }
    });

    exports.CardWidget = CardWidget;
    exports.DirectChat = DirectChat;
    exports.Layout = Layout;
    exports.PushMenu = PushMenu;
    exports.Treeview = Treeview;

    Object.defineProperty(exports, '__esModule', { value: true });

}));
//# sourceMappingURL=adminlte.js.map
