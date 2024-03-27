﻿/*
Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function () {
    if (!window.CKEDITOR || !window.CKEDITOR.dom) {
        window.CKEDITOR || (window.CKEDITOR = function () {
            var a = /(^|.*[\\\/])ckeditor\.js(?:\?.*|;.*)?$/i, g = {
                timestamp: "K496", version: "4.15.0 (Full)", revision: "17ab3be534", rnd: Math.floor(900 * Math.random()) + 100, _: { pending: [], basePathSrcPattern: a }, status: "unloaded", basePath: function () {
                    var b = window.CKEDITOR_BASEPATH || ""; if (!b) for (var e = document.getElementsByTagName("script"), h = 0; h < e.length; h++) { var l = e[h].src.match(a); if (l) { b = l[1]; break } } -1 == b.indexOf(":/") &&
                        "//" != b.slice(0, 2) && (b = 0 === b.indexOf("/") ? location.href.match(/^.*?:\/\/[^\/]*/)[0] + b : location.href.match(/^[^\?]*\/(?:)/)[0] + b); if (!b) throw 'The CKEditor installation path could not be automatically detected. Please set the global variable "CKEDITOR_BASEPATH" before creating editor instances.'; return b
                }(), getUrl: function (a) {
                    -1 == a.indexOf(":/") && 0 !== a.indexOf("/") && (a = this.basePath + a); this.timestamp && "/" != a.charAt(a.length - 1) && !/[&?]t=/.test(a) && (a += (0 <= a.indexOf("?") ? "\x26" : "?") + "t\x3d" + this.timestamp);
                    return a
                }, domReady: function () {
                    function a() { try { document.addEventListener ? (document.removeEventListener("DOMContentLoaded", a, !1), b()) : document.attachEvent && "complete" === document.readyState && (document.detachEvent("onreadystatechange", a), b()) } catch (l) { } } function b() { for (var a; a = e.shift();)a() } var e = []; return function (b) {
                        function c() { try { document.documentElement.doScroll("left") } catch (f) { setTimeout(c, 1); return } a() } e.push(b); "complete" === document.readyState && setTimeout(a, 1); if (1 == e.length) if (document.addEventListener) document.addEventListener("DOMContentLoaded",
                            a, !1), window.addEventListener("load", a, !1); else if (document.attachEvent) { document.attachEvent("onreadystatechange", a); window.attachEvent("onload", a); b = !1; try { b = !window.frameElement } catch (k) { } document.documentElement.doScroll && b && c() }
                    }
                }()
            }, e = window.CKEDITOR_GETURL; if (e) { var b = g.getUrl; g.getUrl = function (a) { return e.call(g, a) || b.call(g, a) } } return g
        }()); CKEDITOR.event || (CKEDITOR.event = function () { }, CKEDITOR.event.implementOn = function (a) { var g = CKEDITOR.event.prototype, e; for (e in g) null == a[e] && (a[e] = g[e]) },
            CKEDITOR.event.prototype = function () {
                function a(a) { var d = g(this); return d[a] || (d[a] = new e(a)) } var g = function (a) { a = a.getPrivate && a.getPrivate() || a._ || (a._ = {}); return a.events || (a.events = {}) }, e = function (a) { this.name = a; this.listeners = [] }; e.prototype = { getListenerIndex: function (a) { for (var d = 0, e = this.listeners; d < e.length; d++)if (e[d].fn == a) return d; return -1 } }; return {
                    define: function (b, d) { var e = a.call(this, b); CKEDITOR.tools.extend(e, d, !0) }, on: function (b, d, e, h, l) {
                        function c(a, f, n, c) {
                            a = {
                                name: b, sender: this, editor: a,
                                data: f, listenerData: h, stop: n, cancel: c, removeListener: k
                            }; return !1 === d.call(e, a) ? !1 : a.data
                        } function k() { n.removeListener(b, d) } var f = a.call(this, b); if (0 > f.getListenerIndex(d)) { f = f.listeners; e || (e = this); isNaN(l) && (l = 10); var n = this; c.fn = d; c.priority = l; for (var p = f.length - 1; 0 <= p; p--)if (f[p].priority <= l) return f.splice(p + 1, 0, c), { removeListener: k }; f.unshift(c) } return { removeListener: k }
                    }, once: function () {
                        var a = Array.prototype.slice.call(arguments), d = a[1]; a[1] = function (a) {
                            a.removeListener(); return d.apply(this,
                                arguments)
                        }; return this.on.apply(this, a)
                    }, capture: function () { CKEDITOR.event.useCapture = 1; var a = this.on.apply(this, arguments); CKEDITOR.event.useCapture = 0; return a }, fire: function () {
                        var a = 0, d = function () { a = 1 }, e = 0, h = function () { e = 1 }; return function (l, c, k) {
                            var f = g(this)[l]; l = a; var n = e; a = e = 0; if (f) { var p = f.listeners; if (p.length) for (var p = p.slice(0), t, q = 0; q < p.length; q++) { if (f.errorProof) try { t = p[q].call(this, k, c, d, h) } catch (r) { } else t = p[q].call(this, k, c, d, h); !1 === t ? e = 1 : "undefined" != typeof t && (c = t); if (a || e) break } } c =
                                e ? !1 : "undefined" == typeof c ? !0 : c; a = l; e = n; return c
                        }
                    }(), fireOnce: function (a, d, e) { d = this.fire(a, d, e); delete g(this)[a]; return d }, removeListener: function (a, d) { var e = g(this)[a]; if (e) { var h = e.getListenerIndex(d); 0 <= h && e.listeners.splice(h, 1) } }, removeAllListeners: function () { var a = g(this), d; for (d in a) delete a[d] }, hasListeners: function (a) { return (a = g(this)[a]) && 0 < a.listeners.length }
                }
            }()); CKEDITOR.editor || (CKEDITOR.editor = function () { CKEDITOR._.pending.push([this, arguments]); CKEDITOR.event.call(this) }, CKEDITOR.editor.prototype.fire =
                function (a, g) { a in { instanceReady: 1, loaded: 1 } && (this[a] = !0); return CKEDITOR.event.prototype.fire.call(this, a, g, this) }, CKEDITOR.editor.prototype.fireOnce = function (a, g) { a in { instanceReady: 1, loaded: 1 } && (this[a] = !0); return CKEDITOR.event.prototype.fireOnce.call(this, a, g, this) }, CKEDITOR.event.implementOn(CKEDITOR.editor.prototype)); CKEDITOR.env || (CKEDITOR.env = function () {
                    var a = navigator.userAgent.toLowerCase(), g = a.match(/edge[ \/](\d+.?\d*)/), e = -1 < a.indexOf("trident/"), e = !(!g && !e), e = {
                        ie: e, edge: !!g, webkit: !e &&
                            -1 < a.indexOf(" applewebkit/"), air: -1 < a.indexOf(" adobeair/"), mac: -1 < a.indexOf("macintosh"), quirks: "BackCompat" == document.compatMode && (!document.documentMode || 10 > document.documentMode), mobile: -1 < a.indexOf("mobile"), iOS: /(ipad|iphone|ipod)/.test(a), isCustomDomain: function () { if (!this.ie) return !1; var a = document.domain, b = window.location.hostname; return a != b && a != "[" + b + "]" }, secure: "https:" == location.protocol
                    }; e.gecko = "Gecko" == navigator.product && !e.webkit && !e.ie; e.webkit && (-1 < a.indexOf("chrome") ? e.chrome =
                        !0 : e.safari = !0); var b = 0; e.ie && (b = g ? parseFloat(g[1]) : e.quirks || !document.documentMode ? parseFloat(a.match(/msie (\d+)/)[1]) : document.documentMode, e.ie9Compat = 9 == b, e.ie8Compat = 8 == b, e.ie7Compat = 7 == b, e.ie6Compat = 7 > b || e.quirks); e.gecko && (g = a.match(/rv:([\d\.]+)/)) && (g = g[1].split("."), b = 1E4 * g[0] + 100 * (g[1] || 0) + 1 * (g[2] || 0)); e.air && (b = parseFloat(a.match(/ adobeair\/(\d+)/)[1])); e.webkit && (b = parseFloat(a.match(/ applewebkit\/(\d+)/)[1])); e.version = b; e.isCompatible = !(e.ie && 7 > b) && !(e.gecko && 4E4 > b) && !(e.webkit &&
                            534 > b); e.hidpi = 2 <= window.devicePixelRatio; e.needsBrFiller = e.gecko || e.webkit || e.ie && 10 < b; e.needsNbspFiller = e.ie && 11 > b; e.cssClass = "cke_browser_" + (e.ie ? "ie" : e.gecko ? "gecko" : e.webkit ? "webkit" : "unknown"); e.quirks && (e.cssClass += " cke_browser_quirks"); e.ie && (e.cssClass += " cke_browser_ie" + (e.quirks ? "6 cke_browser_iequirks" : e.version)); e.air && (e.cssClass += " cke_browser_air"); e.iOS && (e.cssClass += " cke_browser_ios"); e.hidpi && (e.cssClass += " cke_hidpi"); return e
                }()); "unloaded" == CKEDITOR.status && function () {
                    CKEDITOR.event.implementOn(CKEDITOR);
                    CKEDITOR.loadFullCore = function () { if ("basic_ready" != CKEDITOR.status) CKEDITOR.loadFullCore._load = 1; else { delete CKEDITOR.loadFullCore; var a = document.createElement("script"); a.type = "text/javascript"; a.src = CKEDITOR.basePath + "ckeditor.js"; document.getElementsByTagName("head")[0].appendChild(a) } }; CKEDITOR.loadFullCoreTimeout = 0; CKEDITOR.add = function (a) { (this._.pending || (this._.pending = [])).push(a) }; (function () {
                        CKEDITOR.domReady(function () {
                            var a = CKEDITOR.loadFullCore, g = CKEDITOR.loadFullCoreTimeout; a && (CKEDITOR.status =
                                "basic_ready", a && a._load ? a() : g && setTimeout(function () { CKEDITOR.loadFullCore && CKEDITOR.loadFullCore() }, 1E3 * g))
                        })
                    })(); CKEDITOR.status = "basic_loaded"
                }(); "use strict"; CKEDITOR.VERBOSITY_WARN = 1; CKEDITOR.VERBOSITY_ERROR = 2; CKEDITOR.verbosity = CKEDITOR.VERBOSITY_WARN | CKEDITOR.VERBOSITY_ERROR; CKEDITOR.warn = function (a, g) { CKEDITOR.verbosity & CKEDITOR.VERBOSITY_WARN && CKEDITOR.fire("log", { type: "warn", errorCode: a, additionalData: g }) }; CKEDITOR.error = function (a, g) {
                    CKEDITOR.verbosity & CKEDITOR.VERBOSITY_ERROR && CKEDITOR.fire("log",
                        { type: "error", errorCode: a, additionalData: g })
                }; CKEDITOR.on("log", function (a) { if (window.console && window.console.log) { var g = console[a.data.type] ? a.data.type : "log", e = a.data.errorCode; if (a = a.data.additionalData) console[g]("[CKEDITOR] Error code: " + e + ".", a); else console[g]("[CKEDITOR] Error code: " + e + "."); console[g]("[CKEDITOR] For more information about this error go to https://ckeditor.com/docs/ckeditor4/latest/guide/dev_errors.html#" + e) } }, null, null, 999); CKEDITOR.dom = {}; (function () {
                    function a(a, f, c) {
                        this._minInterval =
                        a; this._context = c; this._lastOutput = this._scheduledTimer = 0; this._output = CKEDITOR.tools.bind(f, c || {}); var b = this; this.input = function () { function a() { b._lastOutput = (new Date).getTime(); b._scheduledTimer = 0; b._call() } if (!b._scheduledTimer || !1 !== b._reschedule()) { var f = (new Date).getTime() - b._lastOutput; f < b._minInterval ? b._scheduledTimer = setTimeout(a, b._minInterval - f) : a() } }
                    } function g(f, c, b) {
                        a.call(this, f, c, b); this._args = []; var k = this; this.input = CKEDITOR.tools.override(this.input, function (a) {
                            return function () {
                                k._args =
                                Array.prototype.slice.call(arguments); a.call(this)
                            }
                        })
                    } var e = [], b = CKEDITOR.env.gecko ? "-moz-" : CKEDITOR.env.webkit ? "-webkit-" : CKEDITOR.env.ie ? "-ms-" : "", d = /&/g, m = />/g, h = /</g, l = /"/g, c = /&(lt|gt|amp|quot|nbsp|shy|#\d{1,5});/g, k = { lt: "\x3c", gt: "\x3e", amp: "\x26", quot: '"', nbsp: " ", shy: "­" }, f = function (a, f) { return "#" == f[0] ? String.fromCharCode(parseInt(f.slice(1), 10)) : k[f] }; CKEDITOR.on("reset", function () { e = [] }); CKEDITOR.tools = {
                        arrayCompare: function (a, f) {
                            if (!a && !f) return !0; if (!a || !f || a.length != f.length) return !1;
                            for (var c = 0; c < a.length; c++)if (a[c] != f[c]) return !1; return !0
                        }, getIndex: function (a, f) { for (var c = 0; c < a.length; ++c)if (f(a[c])) return c; return -1 }, clone: function (a) { var f; if (a && a instanceof Array) { f = []; for (var c = 0; c < a.length; c++)f[c] = CKEDITOR.tools.clone(a[c]); return f } if (null === a || "object" != typeof a || a instanceof String || a instanceof Number || a instanceof Boolean || a instanceof Date || a instanceof RegExp || a.nodeType || a.window === a) return a; f = new a.constructor; for (c in a) f[c] = CKEDITOR.tools.clone(a[c]); return f },
                        capitalize: function (a, f) { return a.charAt(0).toUpperCase() + (f ? a.slice(1) : a.slice(1).toLowerCase()) }, extend: function (a) { var f = arguments.length, c, b; "boolean" == typeof (c = arguments[f - 1]) ? f-- : "boolean" == typeof (c = arguments[f - 2]) && (b = arguments[f - 1], f -= 2); for (var k = 1; k < f; k++) { var l = arguments[k] || {}; CKEDITOR.tools.array.forEach(CKEDITOR.tools.object.keys(l), function (f) { if (!0 === c || null == a[f]) if (!b || f in b) a[f] = l[f] }) } return a }, prototypedCopy: function (a) { var f = function () { }; f.prototype = a; return new f }, copy: function (a) {
                            var f =
                                {}, c; for (c in a) f[c] = a[c]; return f
                        }, isArray: function (a) { return "[object Array]" == Object.prototype.toString.call(a) }, isEmpty: function (a) { for (var f in a) if (a.hasOwnProperty(f)) return !1; return !0 }, cssVendorPrefix: function (a, f, c) { if (c) return b + a + ":" + f + ";" + a + ":" + f; c = {}; c[a] = f; c[b + a] = f; return c }, cssStyleToDomStyle: function () {
                            var a = document.createElement("div").style, f = "undefined" != typeof a.cssFloat ? "cssFloat" : "undefined" != typeof a.styleFloat ? "styleFloat" : "float"; return function (a) {
                                return "float" == a ? f : a.replace(/-./g,
                                    function (a) { return a.substr(1).toUpperCase() })
                            }
                        }(), buildStyleHtml: function (a) { a = [].concat(a); for (var f, c = [], b = 0; b < a.length; b++)if (f = a[b]) /@import|[{}]/.test(f) ? c.push("\x3cstyle\x3e" + f + "\x3c/style\x3e") : c.push('\x3clink type\x3d"text/css" rel\x3dstylesheet href\x3d"' + f + '"\x3e'); return c.join("") }, htmlEncode: function (a) { return void 0 === a || null === a ? "" : String(a).replace(d, "\x26amp;").replace(m, "\x26gt;").replace(h, "\x26lt;") }, htmlDecode: function (a) { return a.replace(c, f) }, htmlEncodeAttr: function (a) {
                            return CKEDITOR.tools.htmlEncode(a).replace(l,
                                "\x26quot;")
                        }, htmlDecodeAttr: function (a) { return CKEDITOR.tools.htmlDecode(a) }, transformPlainTextToHtml: function (a, f) {
                            var c = f == CKEDITOR.ENTER_BR, b = this.htmlEncode(a.replace(/\r\n/g, "\n")), b = b.replace(/\t/g, "\x26nbsp;\x26nbsp; \x26nbsp;"), k = f == CKEDITOR.ENTER_P ? "p" : "div"; if (!c) { var l = /\n{2}/g; if (l.test(b)) var d = "\x3c" + k + "\x3e", e = "\x3c/" + k + "\x3e", b = d + b.replace(l, function () { return e + d }) + e } b = b.replace(/\n/g, "\x3cbr\x3e"); c || (b = b.replace(new RegExp("\x3cbr\x3e(?\x3d\x3c/" + k + "\x3e)"), function (a) {
                                return CKEDITOR.tools.repeat(a,
                                    2)
                            })); b = b.replace(/^ | $/g, "\x26nbsp;"); return b = b.replace(/(>|\s) /g, function (a, f) { return f + "\x26nbsp;" }).replace(/ (?=<)/g, "\x26nbsp;")
                        }, getNextNumber: function () { var a = 0; return function () { return ++a } }(), getNextId: function () { return "cke_" + this.getNextNumber() }, getUniqueId: function () { for (var a = "e", f = 0; 8 > f; f++)a += Math.floor(65536 * (1 + Math.random())).toString(16).substring(1); return a }, override: function (a, f) { var c = f(a); c.prototype = a.prototype; return c }, setTimeout: function (a, f, c, b, k) {
                            k || (k = window); c || (c =
                                k); return k.setTimeout(function () { b ? a.apply(c, [].concat(b)) : a.apply(c) }, f || 0)
                        }, throttle: function (a, f, c) { return new this.buffers.throttle(a, f, c) }, trim: function () { var a = /(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g; return function (f) { return f.replace(a, "") } }(), ltrim: function () { var a = /^[ \t\n\r]+/g; return function (f) { return f.replace(a, "") } }(), rtrim: function () { var a = /[ \t\n\r]+$/g; return function (f) { return f.replace(a, "") } }(), indexOf: function (a, f) {
                            if ("function" == typeof f) for (var c = 0, b = a.length; c < b; c++) { if (f(a[c])) return c } else {
                                if (a.indexOf) return a.indexOf(f);
                                c = 0; for (b = a.length; c < b; c++)if (a[c] === f) return c
                            } return -1
                        }, search: function (a, f) { var c = CKEDITOR.tools.indexOf(a, f); return 0 <= c ? a[c] : null }, bind: function (a, f) { var c = Array.prototype.slice.call(arguments, 2); return function () { return a.apply(f, c.concat(Array.prototype.slice.call(arguments))) } }, createClass: function (a) {
                            var f = a.$, c = a.base, b = a.privates || a._, k = a.proto; a = a.statics; !f && (f = function () { c && this.base.apply(this, arguments) }); if (b) var l = f, f = function () {
                                var a = this._ || (this._ = {}), f; for (f in b) {
                                    var c = b[f];
                                    a[f] = "function" == typeof c ? CKEDITOR.tools.bind(c, this) : c
                                } l.apply(this, arguments)
                            }; c && (f.prototype = this.prototypedCopy(c.prototype), f.prototype.constructor = f, f.base = c, f.baseProto = c.prototype, f.prototype.base = function u() { this.base = c.prototype.base; c.apply(this, arguments); this.base = u }); k && this.extend(f.prototype, k, !0); a && this.extend(f, a, !0); return f
                        }, addFunction: function (a, f) { return e.push(function () { return a.apply(f || this, arguments) }) - 1 }, removeFunction: function (a) { e[a] = null }, callFunction: function (a) {
                            var f =
                                e[a]; return f && f.apply(window, Array.prototype.slice.call(arguments, 1))
                        }, cssLength: function () { var a = /^-?\d+\.?\d*px$/, f; return function (c) { f = CKEDITOR.tools.trim(c + "") + "px"; return a.test(f) ? f : c || "" } }(), convertToPx: function () {
                            var a; return function (f) {
                                a || (a = CKEDITOR.dom.element.createFromHtml('\x3cdiv style\x3d"position:absolute;left:-9999px;top:-9999px;margin:0px;padding:0px;border:0px;"\x3e\x3c/div\x3e', CKEDITOR.document), CKEDITOR.document.getBody().append(a)); if (!/%$/.test(f)) {
                                    var c = 0 > parseFloat(f);
                                    c && (f = f.replace("-", "")); a.setStyle("width", f); f = a.$.clientWidth; return c ? -f : f
                                } return f
                            }
                        }(), repeat: function (a, f) { return Array(f + 1).join(a) }, tryThese: function () { for (var a, f = 0, c = arguments.length; f < c; f++) { var b = arguments[f]; try { a = b(); break } catch (k) { } } return a }, genKey: function () { return Array.prototype.slice.call(arguments).join("-") }, defer: function (a) { return function () { var f = arguments, c = this; window.setTimeout(function () { a.apply(c, f) }, 0) } }, normalizeCssText: function (a, f) {
                            var c = [], b, k = CKEDITOR.tools.parseCssText(a,
                                !0, f); for (b in k) c.push(b + ":" + k[b]); c.sort(); return c.length ? c.join(";") + ";" : ""
                        }, convertRgbToHex: function (a) { return a.replace(/(?:rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\))/gi, function (a, f, c, b) { a = [f, c, b]; for (f = 0; 3 > f; f++)a[f] = ("0" + parseInt(a[f], 10).toString(16)).slice(-2); return "#" + a.join("") }) }, normalizeHex: function (a) { return a.replace(/#(([0-9a-f]{3}){1,2})($|;|\s+)/gi, function (a, f, c, b) { a = f.toLowerCase(); 3 == a.length && (a = a.split(""), a = [a[0], a[0], a[1], a[1], a[2], a[2]].join("")); return "#" + a + b }) }, parseCssText: function (a,
                            f, c) { var b = {}; c && (a = (new CKEDITOR.dom.element("span")).setAttribute("style", a).getAttribute("style") || ""); a && (a = CKEDITOR.tools.normalizeHex(CKEDITOR.tools.convertRgbToHex(a))); if (!a || ";" == a) return b; a.replace(/&quot;/g, '"').replace(/\s*([^:;\s]+)\s*:\s*([^;]+)\s*(?=;|$)/g, function (a, c, n) { f && (c = c.toLowerCase(), "font-family" == c && (n = n.replace(/\s*,\s*/g, ",")), n = CKEDITOR.tools.trim(n)); b[c] = n }); return b }, writeCssText: function (a, f) { var c, b = []; for (c in a) b.push(c + ":" + a[c]); f && b.sort(); return b.join("; ") },
                        objectCompare: function (a, f, c) { var b; if (!a && !f) return !0; if (!a || !f) return !1; for (b in a) if (a[b] != f[b]) return !1; if (!c) for (b in f) if (a[b] != f[b]) return !1; return !0 }, objectKeys: function (a) { return CKEDITOR.tools.object.keys(a) }, convertArrayToObject: function (a, f) { var c = {}; 1 == arguments.length && (f = !0); for (var b = 0, k = a.length; b < k; ++b)c[a[b]] = f; return c }, fixDomain: function () {
                            for (var a; ;)try { a = window.parent.document.domain; break } catch (f) {
                                a = a ? a.replace(/.+?(?:\.|$)/, "") : document.domain; if (!a) break; document.domain =
                                    a
                            } return !!a
                        }, eventsBuffer: function (a, f, c) { return new this.buffers.event(a, f, c) }, enableHtml5Elements: function (a, f) { for (var c = "abbr article aside audio bdi canvas data datalist details figcaption figure footer header hgroup main mark meter nav output progress section summary time video".split(" "), b = c.length, k; b--;)k = a.createElement(c[b]), f && a.appendChild(k) }, checkIfAnyArrayItemMatches: function (a, f) { for (var c = 0, b = a.length; c < b; ++c)if (a[c].match(f)) return !0; return !1 }, checkIfAnyObjectPropertyMatches: function (a,
                            f) { for (var c in a) if (c.match(f)) return !0; return !1 }, keystrokeToString: function (a, f) { var c = this.keystrokeToArray(a, f); c.display = c.display.join("+"); c.aria = c.aria.join("+"); return c }, keystrokeToArray: function (a, f) {
                                var c = f & 16711680, b = f & 65535, k = CKEDITOR.env.mac, l = [], d = []; c & CKEDITOR.CTRL && (l.push(k ? "⌘" : a[17]), d.push(k ? a[224] : a[17])); c & CKEDITOR.ALT && (l.push(k ? "⌥" : a[18]), d.push(a[18])); c & CKEDITOR.SHIFT && (l.push(k ? "⇧" : a[16]), d.push(a[16])); b && (a[b] ? (l.push(a[b]), d.push(a[b])) : (l.push(String.fromCharCode(b)),
                                    d.push(String.fromCharCode(b)))); return { display: l, aria: d }
                            }, transparentImageData: "data:image/gif;base64,R0lGODlhAQABAPABAP///wAAACH5BAEKAAAALAAAAAABAAEAAAICRAEAOw\x3d\x3d", getCookie: function (a) { a = a.toLowerCase(); for (var f = document.cookie.split(";"), c, b, k = 0; k < f.length; k++)if (c = f[k].split("\x3d"), b = decodeURIComponent(CKEDITOR.tools.trim(c[0]).toLowerCase()), b === a) return decodeURIComponent(1 < c.length ? c[1] : ""); return null }, setCookie: function (a, f) {
                                document.cookie = encodeURIComponent(a) + "\x3d" + encodeURIComponent(f) +
                                    ";path\x3d/"
                            }, getCsrfToken: function () { var a = CKEDITOR.tools.getCookie("ckCsrfToken"); if (!a || 40 != a.length) { var a = [], f = ""; if (window.crypto && window.crypto.getRandomValues) a = new Uint8Array(40), window.crypto.getRandomValues(a); else for (var c = 0; 40 > c; c++)a.push(Math.floor(256 * Math.random())); for (c = 0; c < a.length; c++)var b = "abcdefghijklmnopqrstuvwxyz0123456789".charAt(a[c] % 36), f = f + (.5 < Math.random() ? b.toUpperCase() : b); a = f; CKEDITOR.tools.setCookie("ckCsrfToken", a) } return a }, escapeCss: function (a) {
                                return a ? window.CSS &&
                                    CSS.escape ? CSS.escape(a) : isNaN(parseInt(a.charAt(0), 10)) ? a : "\\3" + a.charAt(0) + " " + a.substring(1, a.length) : ""
                            }, getMouseButton: function (a) { return (a = a && a.data ? a.data.$ : a) ? CKEDITOR.tools.normalizeMouseButton(a.button) : !1 }, normalizeMouseButton: function (a, f) {
                                if (!CKEDITOR.env.ie || 9 <= CKEDITOR.env.version && !CKEDITOR.env.ie6Compat) return a; for (var c = [[CKEDITOR.MOUSE_BUTTON_LEFT, 1], [CKEDITOR.MOUSE_BUTTON_MIDDLE, 4], [CKEDITOR.MOUSE_BUTTON_RIGHT, 2]], b = 0; b < c.length; b++) {
                                    var k = c[b]; if (k[0] === a && f) return k[1]; if (!f &&
                                        k[1] === a) return k[0]
                                }
                            }, convertHexStringToBytes: function (a) { var f = [], c = a.length / 2, b; for (b = 0; b < c; b++)f.push(parseInt(a.substr(2 * b, 2), 16)); return f }, convertBytesToBase64: function (a) { var f = "", c = a.length, b; for (b = 0; b < c; b += 3) { var k = a.slice(b, b + 3), l = k.length, d = [], e; if (3 > l) for (e = l; 3 > e; e++)k[e] = 0; d[0] = (k[0] & 252) >> 2; d[1] = (k[0] & 3) << 4 | k[1] >> 4; d[2] = (k[1] & 15) << 2 | (k[2] & 192) >> 6; d[3] = k[2] & 63; for (e = 0; 4 > e; e++)f = e <= l ? f + "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(d[e]) : f + "\x3d" } return f },
                        style: {
                            parse: {
                                _colors: {
                                    aliceblue: "#F0F8FF", antiquewhite: "#FAEBD7", aqua: "#00FFFF", aquamarine: "#7FFFD4", azure: "#F0FFFF", beige: "#F5F5DC", bisque: "#FFE4C4", black: "#000000", blanchedalmond: "#FFEBCD", blue: "#0000FF", blueviolet: "#8A2BE2", brown: "#A52A2A", burlywood: "#DEB887", cadetblue: "#5F9EA0", chartreuse: "#7FFF00", chocolate: "#D2691E", coral: "#FF7F50", cornflowerblue: "#6495ED", cornsilk: "#FFF8DC", crimson: "#DC143C", cyan: "#00FFFF", darkblue: "#00008B", darkcyan: "#008B8B", darkgoldenrod: "#B8860B", darkgray: "#A9A9A9", darkgreen: "#006400",
                                    darkgrey: "#A9A9A9", darkkhaki: "#BDB76B", darkmagenta: "#8B008B", darkolivegreen: "#556B2F", darkorange: "#FF8C00", darkorchid: "#9932CC", darkred: "#8B0000", darksalmon: "#E9967A", darkseagreen: "#8FBC8F", darkslateblue: "#483D8B", darkslategray: "#2F4F4F", darkslategrey: "#2F4F4F", darkturquoise: "#00CED1", darkviolet: "#9400D3", deeppink: "#FF1493", deepskyblue: "#00BFFF", dimgray: "#696969", dimgrey: "#696969", dodgerblue: "#1E90FF", firebrick: "#B22222", floralwhite: "#FFFAF0", forestgreen: "#228B22", fuchsia: "#FF00FF", gainsboro: "#DCDCDC",
                                    ghostwhite: "#F8F8FF", gold: "#FFD700", goldenrod: "#DAA520", gray: "#808080", green: "#008000", greenyellow: "#ADFF2F", grey: "#808080", honeydew: "#F0FFF0", hotpink: "#FF69B4", indianred: "#CD5C5C", indigo: "#4B0082", ivory: "#FFFFF0", khaki: "#F0E68C", lavender: "#E6E6FA", lavenderblush: "#FFF0F5", lawngreen: "#7CFC00", lemonchiffon: "#FFFACD", lightblue: "#ADD8E6", lightcoral: "#F08080", lightcyan: "#E0FFFF", lightgoldenrodyellow: "#FAFAD2", lightgray: "#D3D3D3", lightgreen: "#90EE90", lightgrey: "#D3D3D3", lightpink: "#FFB6C1", lightsalmon: "#FFA07A",
                                    lightseagreen: "#20B2AA", lightskyblue: "#87CEFA", lightslategray: "#778899", lightslategrey: "#778899", lightsteelblue: "#B0C4DE", lightyellow: "#FFFFE0", lime: "#00FF00", limegreen: "#32CD32", linen: "#FAF0E6", magenta: "#FF00FF", maroon: "#800000", mediumaquamarine: "#66CDAA", mediumblue: "#0000CD", mediumorchid: "#BA55D3", mediumpurple: "#9370DB", mediumseagreen: "#3CB371", mediumslateblue: "#7B68EE", mediumspringgreen: "#00FA9A", mediumturquoise: "#48D1CC", mediumvioletred: "#C71585", midnightblue: "#191970", mintcream: "#F5FFFA", mistyrose: "#FFE4E1",
                                    moccasin: "#FFE4B5", navajowhite: "#FFDEAD", navy: "#000080", oldlace: "#FDF5E6", olive: "#808000", olivedrab: "#6B8E23", orange: "#FFA500", orangered: "#FF4500", orchid: "#DA70D6", palegoldenrod: "#EEE8AA", palegreen: "#98FB98", paleturquoise: "#AFEEEE", palevioletred: "#DB7093", papayawhip: "#FFEFD5", peachpuff: "#FFDAB9", peru: "#CD853F", pink: "#FFC0CB", plum: "#DDA0DD", powderblue: "#B0E0E6", purple: "#800080", rebeccapurple: "#663399", red: "#FF0000", rosybrown: "#BC8F8F", royalblue: "#4169E1", saddlebrown: "#8B4513", salmon: "#FA8072", sandybrown: "#F4A460",
                                    seagreen: "#2E8B57", seashell: "#FFF5EE", sienna: "#A0522D", silver: "#C0C0C0", skyblue: "#87CEEB", slateblue: "#6A5ACD", slategray: "#708090", slategrey: "#708090", snow: "#FFFAFA", springgreen: "#00FF7F", steelblue: "#4682B4", tan: "#D2B48C", teal: "#008080", thistle: "#D8BFD8", tomato: "#FF6347", turquoise: "#40E0D0", violet: "#EE82EE", windowtext: "windowtext", wheat: "#F5DEB3", white: "#FFFFFF", whitesmoke: "#F5F5F5", yellow: "#FFFF00", yellowgreen: "#9ACD32"
                                }, _borderStyle: "none hidden dotted dashed solid double groove ridge inset outset".split(" "),
                                _widthRegExp: /^(thin|medium|thick|[\+-]?\d+(\.\d+)?[a-z%]+|[\+-]?0+(\.0+)?|\.\d+[a-z%]+)$/, _rgbaRegExp: /rgba?\(\s*\d+%?\s*,\s*\d+%?\s*,\s*\d+%?\s*(?:,\s*[0-9.]+\s*)?\)/gi, _hslaRegExp: /hsla?\(\s*[0-9.]+\s*,\s*\d+%\s*,\s*\d+%\s*(?:,\s*[0-9.]+\s*)?\)/gi, background: function (a) { var f = {}, c = this._findColor(a); c.length && (f.color = c[0], CKEDITOR.tools.array.forEach(c, function (f) { a = a.replace(f, "") })); if (a = CKEDITOR.tools.trim(a)) f.unprocessed = a; return f }, margin: function (a) {
                                    return CKEDITOR.tools.style.parse.sideShorthand(a,
                                        function (a) { return a.match(/(?:\-?[\.\d]+(?:%|\w*)|auto|inherit|initial|unset|revert)/g) || ["0px"] })
                                }, sideShorthand: function (a, f) { function c(a) { b.top = k[a[0]]; b.right = k[a[1]]; b.bottom = k[a[2]]; b.left = k[a[3]] } var b = {}, k = f ? f(a) : a.split(/\s+/); switch (k.length) { case 1: c([0, 0, 0, 0]); break; case 2: c([0, 1, 0, 1]); break; case 3: c([0, 1, 2, 1]); break; case 4: c([0, 1, 2, 3]) }return b }, border: function (a) { return CKEDITOR.tools.style.border.fromCssRule(a) }, _findColor: function (a) {
                                    var f = [], c = CKEDITOR.tools.array, f = f.concat(a.match(this._rgbaRegExp) ||
                                        []), f = f.concat(a.match(this._hslaRegExp) || []); return f = f.concat(c.filter(a.split(/\s+/), function (a) { return a.match(/^\#[a-f0-9]{3}(?:[a-f0-9]{3})?$/gi) ? !0 : a.toLowerCase() in CKEDITOR.tools.style.parse._colors }))
                                }
                            }
                        }, array: {
                            filter: function (a, f, c) { var b = []; this.forEach(a, function (k, l) { f.call(c, k, l, a) && b.push(k) }); return b }, find: function (a, f, c) { for (var b = a.length, k = 0; k < b;) { if (f.call(c, a[k], k, a)) return a[k]; k++ } }, forEach: function (a, f, c) { var b = a.length, k; for (k = 0; k < b; k++)f.call(c, a[k], k, a) }, map: function (a,
                                f, c) { for (var b = [], k = 0; k < a.length; k++)b.push(f.call(c, a[k], k, a)); return b }, reduce: function (a, f, c, b) { for (var k = 0; k < a.length; k++)c = f.call(b, c, a[k], k, a); return c }, every: function (a, f, c) { if (!a.length) return !0; f = this.filter(a, f, c); return a.length === f.length }, some: function (a, f, c) { for (var b = 0; b < a.length; b++)if (f.call(c, a[b], b, a)) return !0; return !1 }
                        }, object: {
                            DONT_ENUMS: "toString toLocaleString valueOf hasOwnProperty isPrototypeOf propertyIsEnumerable constructor".split(" "), entries: function (a) {
                                return CKEDITOR.tools.array.map(CKEDITOR.tools.object.keys(a),
                                    function (f) { return [f, a[f]] })
                            }, values: function (a) { return CKEDITOR.tools.array.map(CKEDITOR.tools.object.keys(a), function (f) { return a[f] }) }, keys: function (a) {
                                var f = Object.prototype.hasOwnProperty, c = [], b = CKEDITOR.tools.object.DONT_ENUMS; if (CKEDITOR.env.ie && 9 > CKEDITOR.env.version && (!a || "object" !== typeof a)) { f = []; if ("string" === typeof a) for (c = 0; c < a.length; c++)f.push(String(c)); return f } for (var k in a) c.push(k); if (CKEDITOR.env.ie && 9 > CKEDITOR.env.version) for (k = 0; k < b.length; k++)f.call(a, b[k]) && c.push(b[k]);
                                return c
                            }, findKey: function (a, f) { if ("object" !== typeof a) return null; for (var c in a) if (a[c] === f) return c; return null }, merge: function (a, f) { var c = CKEDITOR.tools, b = c.clone(a), k = c.clone(f); c.array.forEach(c.object.keys(k), function (a) { b[a] = "object" === typeof k[a] && "object" === typeof b[a] ? c.object.merge(b[a], k[a]) : k[a] }); return b }
                        }, getAbsoluteRectPosition: function (a, f) {
                            function c(a) { if (a) { var f = a.getClientRect(); b.top += f.top; b.left += f.left; "x" in b && "y" in b && (b.x += f.x, b.y += f.y); c(a.getWindow().getFrame()) } }
                            var b = CKEDITOR.tools.copy(f); c(a.getFrame()); var k = CKEDITOR.document.getWindow().getScrollPosition(); b.top += k.y; b.left += k.x; "x" in b && "y" in b && (b.y += k.y, b.x += k.x); b.right = b.left + b.width; b.bottom = b.top + b.height; return b
                        }
                    }; a.prototype = { reset: function () { this._lastOutput = 0; this._clearTimer() }, _reschedule: function () { return !1 }, _call: function () { this._output() }, _clearTimer: function () { this._scheduledTimer && clearTimeout(this._scheduledTimer); this._scheduledTimer = 0 } }; g.prototype = CKEDITOR.tools.prototypedCopy(a.prototype);
                    g.prototype._reschedule = function () { this._scheduledTimer && this._clearTimer() }; g.prototype._call = function () { this._output.apply(this._context, this._args) }; CKEDITOR.tools.buffers = {}; CKEDITOR.tools.buffers.event = a; CKEDITOR.tools.buffers.throttle = g; CKEDITOR.tools.style.border = CKEDITOR.tools.createClass({
                        $: function (a) { a = a || {}; this.width = a.width; this.style = a.style; this.color = a.color; this._.normalize() }, _: {
                            normalizeMap: { color: [[/windowtext/g, "black"]] }, normalize: function () {
                                for (var a in this._.normalizeMap) {
                                    var f =
                                        this[a]; f && (this[a] = CKEDITOR.tools.array.reduce(this._.normalizeMap[a], function (a, f) { return a.replace(f[0], f[1]) }, f))
                                }
                            }
                        }, proto: { toString: function () { return CKEDITOR.tools.array.filter([this.width, this.style, this.color], function (a) { return !!a }).join(" ") } }, statics: {
                            fromCssRule: function (a) {
                                var f = {}, c = a.split(/\s+/g); a = CKEDITOR.tools.style.parse._findColor(a); a.length && (f.color = a[0]); CKEDITOR.tools.array.forEach(c, function (a) {
                                    f.style || -1 === CKEDITOR.tools.indexOf(CKEDITOR.tools.style.parse._borderStyle,
                                        a) ? !f.width && CKEDITOR.tools.style.parse._widthRegExp.test(a) && (f.width = a) : f.style = a
                                }); return new CKEDITOR.tools.style.border(f)
                            }, splitCssValues: function (a, f) {
                                f = f || {}; var c = CKEDITOR.tools.array.reduce(["width", "style", "color"], function (c, b) { var k = a["border-" + b] || f[b]; c[b] = k ? CKEDITOR.tools.style.parse.sideShorthand(k) : null; return c }, {}); return CKEDITOR.tools.array.reduce(["top", "right", "bottom", "left"], function (f, b) {
                                    var k = {}, l; for (l in c) { var d = a["border-" + b + "-" + l]; k[l] = d ? d : c[l] && c[l][b] } f["border-" +
                                        b] = new CKEDITOR.tools.style.border(k); return f
                                }, {})
                            }
                        }
                    }); CKEDITOR.tools.array.indexOf = CKEDITOR.tools.indexOf; CKEDITOR.tools.array.isArray = CKEDITOR.tools.isArray; CKEDITOR.MOUSE_BUTTON_LEFT = 0; CKEDITOR.MOUSE_BUTTON_MIDDLE = 1; CKEDITOR.MOUSE_BUTTON_RIGHT = 2
                })(); CKEDITOR.dtd = function () {
                    var a = CKEDITOR.tools.extend, g = function (a, f) { for (var c = CKEDITOR.tools.clone(a), b = 1; b < arguments.length; b++) { f = arguments[b]; for (var l in f) delete c[l] } return c }, e = {}, b = {}, d = {
                        address: 1, article: 1, aside: 1, blockquote: 1, details: 1, div: 1,
                        dl: 1, fieldset: 1, figure: 1, footer: 1, form: 1, h1: 1, h2: 1, h3: 1, h4: 1, h5: 1, h6: 1, header: 1, hgroup: 1, hr: 1, main: 1, menu: 1, nav: 1, ol: 1, p: 1, pre: 1, section: 1, table: 1, ul: 1
                    }, m = { command: 1, link: 1, meta: 1, noscript: 1, script: 1, style: 1 }, h = {}, l = { "#": 1 }, c = { center: 1, dir: 1, noframes: 1 }; a(e, {
                        a: 1, abbr: 1, area: 1, audio: 1, b: 1, bdi: 1, bdo: 1, br: 1, button: 1, canvas: 1, cite: 1, code: 1, command: 1, datalist: 1, del: 1, dfn: 1, em: 1, embed: 1, i: 1, iframe: 1, img: 1, input: 1, ins: 1, kbd: 1, keygen: 1, label: 1, map: 1, mark: 1, meter: 1, noscript: 1, object: 1, output: 1, progress: 1,
                        q: 1, ruby: 1, s: 1, samp: 1, script: 1, select: 1, small: 1, span: 1, strong: 1, sub: 1, sup: 1, textarea: 1, time: 1, u: 1, "var": 1, video: 1, wbr: 1
                    }, l, { acronym: 1, applet: 1, basefont: 1, big: 1, font: 1, isindex: 1, strike: 1, style: 1, tt: 1 }); a(b, d, e, c); g = {
                        a: g(e, { a: 1, button: 1 }), abbr: e, address: b, area: h, article: b, aside: b, audio: a({ source: 1, track: 1 }, b), b: e, base: h, bdi: e, bdo: e, blockquote: b, body: b, br: h, button: g(e, { a: 1, button: 1 }), canvas: e, caption: b, cite: e, code: e, col: h, colgroup: { col: 1 }, command: h, datalist: a({ option: 1 }, e), dd: b, del: e, details: a({ summary: 1 },
                            b), dfn: e, div: b, dl: { dt: 1, dd: 1 }, dt: b, em: e, embed: h, fieldset: a({ legend: 1 }, b), figcaption: b, figure: a({ figcaption: 1 }, b), footer: b, form: b, h1: e, h2: e, h3: e, h4: e, h5: e, h6: e, head: a({ title: 1, base: 1 }, m), header: b, hgroup: { h1: 1, h2: 1, h3: 1, h4: 1, h5: 1, h6: 1 }, hr: h, html: a({ head: 1, body: 1 }, b, m), i: e, iframe: l, img: h, input: h, ins: e, kbd: e, keygen: h, label: e, legend: e, li: b, link: h, main: b, map: b, mark: e, menu: a({ li: 1 }, b), meta: h, meter: g(e, { meter: 1 }), nav: b, noscript: a({ link: 1, meta: 1, style: 1 }, e), object: a({ param: 1 }, e), ol: { li: 1 }, optgroup: { option: 1 },
                        option: l, output: e, p: e, param: h, pre: e, progress: g(e, { progress: 1 }), q: e, rp: e, rt: e, ruby: a({ rp: 1, rt: 1 }, e), s: e, samp: e, script: l, section: b, select: { optgroup: 1, option: 1 }, small: e, source: h, span: e, strong: e, style: l, sub: e, summary: a({ h1: 1, h2: 1, h3: 1, h4: 1, h5: 1, h6: 1 }, e), sup: e, table: { caption: 1, colgroup: 1, thead: 1, tfoot: 1, tbody: 1, tr: 1 }, tbody: { tr: 1 }, td: b, textarea: l, tfoot: { tr: 1 }, th: b, thead: { tr: 1 }, time: g(e, { time: 1 }), title: l, tr: { th: 1, td: 1 }, track: h, u: e, ul: { li: 1 }, "var": e, video: a({ source: 1, track: 1 }, b), wbr: h, acronym: e, applet: a({ param: 1 },
                            b), basefont: h, big: e, center: b, dialog: h, dir: { li: 1 }, font: e, isindex: h, noframes: b, strike: e, tt: e
                    }; a(g, {
                        $block: a({ audio: 1, dd: 1, dt: 1, figcaption: 1, li: 1, video: 1 }, d, c), $blockLimit: { article: 1, aside: 1, audio: 1, body: 1, caption: 1, details: 1, dir: 1, div: 1, dl: 1, fieldset: 1, figcaption: 1, figure: 1, footer: 1, form: 1, header: 1, hgroup: 1, main: 1, menu: 1, nav: 1, ol: 1, section: 1, table: 1, td: 1, th: 1, tr: 1, ul: 1, video: 1 }, $cdata: { script: 1, style: 1 }, $editable: {
                            address: 1, article: 1, aside: 1, blockquote: 1, body: 1, details: 1, div: 1, fieldset: 1, figcaption: 1,
                            footer: 1, form: 1, h1: 1, h2: 1, h3: 1, h4: 1, h5: 1, h6: 1, header: 1, hgroup: 1, main: 1, nav: 1, p: 1, pre: 1, section: 1
                        }, $empty: { area: 1, base: 1, basefont: 1, br: 1, col: 1, command: 1, dialog: 1, embed: 1, hr: 1, img: 1, input: 1, isindex: 1, keygen: 1, link: 1, meta: 1, param: 1, source: 1, track: 1, wbr: 1 }, $inline: e, $list: { dl: 1, ol: 1, ul: 1 }, $listItem: { dd: 1, dt: 1, li: 1 }, $nonBodyContent: a({ body: 1, head: 1, html: 1 }, g.head), $nonEditable: { applet: 1, audio: 1, button: 1, embed: 1, iframe: 1, map: 1, object: 1, option: 1, param: 1, script: 1, textarea: 1, video: 1 }, $object: {
                            applet: 1, audio: 1,
                            button: 1, hr: 1, iframe: 1, img: 1, input: 1, object: 1, select: 1, table: 1, textarea: 1, video: 1
                        }, $removeEmpty: { abbr: 1, acronym: 1, b: 1, bdi: 1, bdo: 1, big: 1, cite: 1, code: 1, del: 1, dfn: 1, em: 1, font: 1, i: 1, ins: 1, label: 1, kbd: 1, mark: 1, meter: 1, output: 1, q: 1, ruby: 1, s: 1, samp: 1, small: 1, span: 1, strike: 1, strong: 1, sub: 1, sup: 1, time: 1, tt: 1, u: 1, "var": 1 }, $tabIndex: { a: 1, area: 1, button: 1, input: 1, object: 1, select: 1, textarea: 1 }, $tableContent: { caption: 1, col: 1, colgroup: 1, tbody: 1, td: 1, tfoot: 1, th: 1, thead: 1, tr: 1 }, $transparent: {
                            a: 1, audio: 1, canvas: 1, del: 1,
                            ins: 1, map: 1, noscript: 1, object: 1, video: 1
                        }, $intermediate: { caption: 1, colgroup: 1, dd: 1, dt: 1, figcaption: 1, legend: 1, li: 1, optgroup: 1, option: 1, rp: 1, rt: 1, summary: 1, tbody: 1, td: 1, tfoot: 1, th: 1, thead: 1, tr: 1 }
                    }); return g
                }(); CKEDITOR.dom.event = function (a) { this.$ = a }; CKEDITOR.dom.event.prototype = {
                    getKey: function () { return this.$.keyCode || this.$.which }, getKeystroke: function () { var a = this.getKey(); if (this.$.ctrlKey || this.$.metaKey) a += CKEDITOR.CTRL; this.$.shiftKey && (a += CKEDITOR.SHIFT); this.$.altKey && (a += CKEDITOR.ALT); return a },
                    preventDefault: function (a) { var g = this.$; g.preventDefault ? g.preventDefault() : g.returnValue = !1; a && this.stopPropagation() }, stopPropagation: function () { var a = this.$; a.stopPropagation ? a.stopPropagation() : a.cancelBubble = !0 }, getTarget: function () { var a = this.$.target || this.$.srcElement; return a ? new CKEDITOR.dom.node(a) : null }, getPhase: function () { return this.$.eventPhase || 2 }, getPageOffset: function () {
                        var a = this.getTarget().getDocument().$; return {
                            x: this.$.pageX || this.$.clientX + (a.documentElement.scrollLeft || a.body.scrollLeft),
                            y: this.$.pageY || this.$.clientY + (a.documentElement.scrollTop || a.body.scrollTop)
                        }
                    }
                }; CKEDITOR.CTRL = 1114112; CKEDITOR.SHIFT = 2228224; CKEDITOR.ALT = 4456448; CKEDITOR.EVENT_PHASE_CAPTURING = 1; CKEDITOR.EVENT_PHASE_AT_TARGET = 2; CKEDITOR.EVENT_PHASE_BUBBLING = 3; CKEDITOR.dom.domObject = function (a) { a && (this.$ = a) }; CKEDITOR.dom.domObject.prototype = function () {
                    var a = function (a, e) { return function (b) { "undefined" != typeof CKEDITOR && a.fire(e, new CKEDITOR.dom.event(b)) } }; return {
                        getPrivate: function () {
                            var a; (a = this.getCustomData("_")) ||
                                this.setCustomData("_", a = {}); return a
                        }, on: function (g) { var e = this.getCustomData("_cke_nativeListeners"); e || (e = {}, this.setCustomData("_cke_nativeListeners", e)); e[g] || (e = e[g] = a(this, g), this.$.addEventListener ? this.$.addEventListener(g, e, !!CKEDITOR.event.useCapture) : this.$.attachEvent && this.$.attachEvent("on" + g, e)); return CKEDITOR.event.prototype.on.apply(this, arguments) }, removeListener: function (a) {
                            CKEDITOR.event.prototype.removeListener.apply(this, arguments); if (!this.hasListeners(a)) {
                                var e = this.getCustomData("_cke_nativeListeners"),
                                b = e && e[a]; b && (this.$.removeEventListener ? this.$.removeEventListener(a, b, !1) : this.$.detachEvent && this.$.detachEvent("on" + a, b), delete e[a])
                            }
                        }, removeAllListeners: function () { try { var a = this.getCustomData("_cke_nativeListeners"), e; for (e in a) { var b = a[e]; this.$.detachEvent ? this.$.detachEvent("on" + e, b) : this.$.removeEventListener && this.$.removeEventListener(e, b, !1); delete a[e] } } catch (d) { if (!CKEDITOR.env.edge || -2146828218 !== d.number) throw d; } CKEDITOR.event.prototype.removeAllListeners.call(this) }
                    }
                }(); (function (a) {
                    var g =
                        {}; CKEDITOR.on("reset", function () { g = {} }); a.equals = function (a) { try { return a && a.$ === this.$ } catch (b) { return !1 } }; a.setCustomData = function (a, b) { var d = this.getUniqueId(); (g[d] || (g[d] = {}))[a] = b; return this }; a.getCustomData = function (a) { var b = this.$["data-cke-expando"]; return (b = b && g[b]) && a in b ? b[a] : null }; a.removeCustomData = function (a) { var b = this.$["data-cke-expando"], b = b && g[b], d, m; b && (d = b[a], m = a in b, delete b[a]); return m ? d : null }; a.clearCustomData = function () {
                            this.removeAllListeners(); var a = this.getUniqueId();
                            a && delete g[a]
                        }; a.getUniqueId = function () { return this.$["data-cke-expando"] || (this.$["data-cke-expando"] = CKEDITOR.tools.getNextNumber()) }; CKEDITOR.event.implementOn(a)
                })(CKEDITOR.dom.domObject.prototype); CKEDITOR.dom.node = function (a) {
                    return a ? new CKEDITOR.dom[a.nodeType == CKEDITOR.NODE_DOCUMENT ? "document" : a.nodeType == CKEDITOR.NODE_ELEMENT ? "element" : a.nodeType == CKEDITOR.NODE_TEXT ? "text" : a.nodeType == CKEDITOR.NODE_COMMENT ? "comment" : a.nodeType == CKEDITOR.NODE_DOCUMENT_FRAGMENT ? "documentFragment" : "domObject"](a) :
                        this
                }; CKEDITOR.dom.node.prototype = new CKEDITOR.dom.domObject; CKEDITOR.NODE_ELEMENT = 1; CKEDITOR.NODE_DOCUMENT = 9; CKEDITOR.NODE_TEXT = 3; CKEDITOR.NODE_COMMENT = 8; CKEDITOR.NODE_DOCUMENT_FRAGMENT = 11; CKEDITOR.POSITION_IDENTICAL = 0; CKEDITOR.POSITION_DISCONNECTED = 1; CKEDITOR.POSITION_FOLLOWING = 2; CKEDITOR.POSITION_PRECEDING = 4; CKEDITOR.POSITION_IS_CONTAINED = 8; CKEDITOR.POSITION_CONTAINS = 16; CKEDITOR.tools.extend(CKEDITOR.dom.node.prototype, {
                    appendTo: function (a, g) { a.append(this, g); return a }, clone: function (a, g) {
                        function e(b) {
                            b["data-cke-expando"] &&
                            (b["data-cke-expando"] = !1); if (b.nodeType == CKEDITOR.NODE_ELEMENT || b.nodeType == CKEDITOR.NODE_DOCUMENT_FRAGMENT) if (g || b.nodeType != CKEDITOR.NODE_ELEMENT || b.removeAttribute("id", !1), a) { b = b.childNodes; for (var d = 0; d < b.length; d++)e(b[d]) }
                        } function b(d) { if (d.type == CKEDITOR.NODE_ELEMENT || d.type == CKEDITOR.NODE_DOCUMENT_FRAGMENT) { if (d.type != CKEDITOR.NODE_DOCUMENT_FRAGMENT) { var e = d.getName(); ":" == e[0] && d.renameNode(e.substring(1)) } if (a) for (e = 0; e < d.getChildCount(); e++)b(d.getChild(e)) } } var d = this.$.cloneNode(a);
                        e(d); d = new CKEDITOR.dom.node(d); CKEDITOR.env.ie && 9 > CKEDITOR.env.version && (this.type == CKEDITOR.NODE_ELEMENT || this.type == CKEDITOR.NODE_DOCUMENT_FRAGMENT) && b(d); return d
                    }, hasPrevious: function () { return !!this.$.previousSibling }, hasNext: function () { return !!this.$.nextSibling }, insertAfter: function (a) { a.$.parentNode.insertBefore(this.$, a.$.nextSibling); return a }, insertBefore: function (a) { a.$.parentNode.insertBefore(this.$, a.$); return a }, insertBeforeMe: function (a) {
                        this.$.parentNode.insertBefore(a.$, this.$);
                        return a
                    }, getAddress: function (a) { for (var g = [], e = this.getDocument().$.documentElement, b = this; b && b != e;) { var d = b.getParent(); d && g.unshift(this.getIndex.call(b, a)); b = d } return g }, getDocument: function () { return new CKEDITOR.dom.document(this.$.ownerDocument || this.$.parentNode.ownerDocument) }, getIndex: function (a) {
                        function g(a, b) { var d = b ? a.getNext() : a.getPrevious(); return d && d.type == CKEDITOR.NODE_TEXT ? d.isEmpty() ? g(d, b) : d : null } var e = this, b = -1, d; if (!this.getParent() || a && e.type == CKEDITOR.NODE_TEXT && e.isEmpty() &&
                            !g(e) && !g(e, !0)) return -1; do if (!a || e.equals(this) || e.type != CKEDITOR.NODE_TEXT || !d && !e.isEmpty()) b++, d = e.type == CKEDITOR.NODE_TEXT; while (e = e.getPrevious()); return b
                    }, getNextSourceNode: function (a, g, e) {
                        if (e && !e.call) { var b = e; e = function (a) { return !a.equals(b) } } a = !a && this.getFirst && this.getFirst(); var d; if (!a) { if (this.type == CKEDITOR.NODE_ELEMENT && e && !1 === e(this, !0)) return null; a = this.getNext() } for (; !a && (d = (d || this).getParent());) { if (e && !1 === e(d, !0)) return null; a = d.getNext() } return !a || e && !1 === e(a) ? null : g &&
                            g != a.type ? a.getNextSourceNode(!1, g, e) : a
                    }, getPreviousSourceNode: function (a, g, e) { if (e && !e.call) { var b = e; e = function (a) { return !a.equals(b) } } a = !a && this.getLast && this.getLast(); var d; if (!a) { if (this.type == CKEDITOR.NODE_ELEMENT && e && !1 === e(this, !0)) return null; a = this.getPrevious() } for (; !a && (d = (d || this).getParent());) { if (e && !1 === e(d, !0)) return null; a = d.getPrevious() } return !a || e && !1 === e(a) ? null : g && a.type != g ? a.getPreviousSourceNode(!1, g, e) : a }, getPrevious: function (a) {
                        var g = this.$, e; do e = (g = g.previousSibling) &&
                            10 != g.nodeType && new CKEDITOR.dom.node(g); while (e && a && !a(e)); return e
                    }, getNext: function (a) { var g = this.$, e; do e = (g = g.nextSibling) && new CKEDITOR.dom.node(g); while (e && a && !a(e)); return e }, getParent: function (a) { var g = this.$.parentNode; return g && (g.nodeType == CKEDITOR.NODE_ELEMENT || a && g.nodeType == CKEDITOR.NODE_DOCUMENT_FRAGMENT) ? new CKEDITOR.dom.node(g) : null }, getParents: function (a) { var g = this, e = []; do e[a ? "push" : "unshift"](g); while (g = g.getParent()); return e }, getCommonAncestor: function (a) {
                        if (a.equals(this)) return this;
                        if (a.contains && a.contains(this)) return a; var g = this.contains ? this : this.getParent(); do if (g.contains(a)) return g; while (g = g.getParent()); return null
                    }, getPosition: function (a) {
                        var g = this.$, e = a.$; if (g.compareDocumentPosition) return g.compareDocumentPosition(e); if (g == e) return CKEDITOR.POSITION_IDENTICAL; if (this.type == CKEDITOR.NODE_ELEMENT && a.type == CKEDITOR.NODE_ELEMENT) {
                            if (g.contains) {
                                if (g.contains(e)) return CKEDITOR.POSITION_CONTAINS + CKEDITOR.POSITION_PRECEDING; if (e.contains(g)) return CKEDITOR.POSITION_IS_CONTAINED +
                                    CKEDITOR.POSITION_FOLLOWING
                            } if ("sourceIndex" in g) return 0 > g.sourceIndex || 0 > e.sourceIndex ? CKEDITOR.POSITION_DISCONNECTED : g.sourceIndex < e.sourceIndex ? CKEDITOR.POSITION_PRECEDING : CKEDITOR.POSITION_FOLLOWING
                        } g = this.getAddress(); a = a.getAddress(); for (var e = Math.min(g.length, a.length), b = 0; b < e; b++)if (g[b] != a[b]) return g[b] < a[b] ? CKEDITOR.POSITION_PRECEDING : CKEDITOR.POSITION_FOLLOWING; return g.length < a.length ? CKEDITOR.POSITION_CONTAINS + CKEDITOR.POSITION_PRECEDING : CKEDITOR.POSITION_IS_CONTAINED + CKEDITOR.POSITION_FOLLOWING
                    },
                    getAscendant: function (a, g) { var e = this.$, b, d; g || (e = e.parentNode); "function" == typeof a ? (d = !0, b = a) : (d = !1, b = function (b) { b = "string" == typeof b.nodeName ? b.nodeName.toLowerCase() : ""; return "string" == typeof a ? b == a : b in a }); for (; e;) { if (b(d ? new CKEDITOR.dom.node(e) : e)) return new CKEDITOR.dom.node(e); try { e = e.parentNode } catch (m) { e = null } } return null }, hasAscendant: function (a, g) { var e = this.$; g || (e = e.parentNode); for (; e;) { if (e.nodeName && e.nodeName.toLowerCase() == a) return !0; e = e.parentNode } return !1 }, move: function (a, g) {
                        a.append(this.remove(),
                            g)
                    }, remove: function (a) { var g = this.$, e = g.parentNode; if (e) { if (a) for (; a = g.firstChild;)e.insertBefore(g.removeChild(a), g); e.removeChild(g) } return this }, replace: function (a) { this.insertBefore(a); a.remove() }, trim: function () { this.ltrim(); this.rtrim() }, ltrim: function () { for (var a; this.getFirst && (a = this.getFirst());) { if (a.type == CKEDITOR.NODE_TEXT) { var g = CKEDITOR.tools.ltrim(a.getText()), e = a.getLength(); if (g) g.length < e && (a.split(e - g.length), this.$.removeChild(this.$.firstChild)); else { a.remove(); continue } } break } },
                    rtrim: function () { for (var a; this.getLast && (a = this.getLast());) { if (a.type == CKEDITOR.NODE_TEXT) { var g = CKEDITOR.tools.rtrim(a.getText()), e = a.getLength(); if (g) g.length < e && (a.split(g.length), this.$.lastChild.parentNode.removeChild(this.$.lastChild)); else { a.remove(); continue } } break } CKEDITOR.env.needsBrFiller && (a = this.$.lastChild) && 1 == a.type && "br" == a.nodeName.toLowerCase() && a.parentNode.removeChild(a) }, isReadOnly: function (a) {
                        var g = this; this.type != CKEDITOR.NODE_ELEMENT && (g = this.getParent()); CKEDITOR.env.edge &&
                            g && g.is("textarea", "input") && (a = !0); if (!a && g && "undefined" != typeof g.$.isContentEditable) return !(g.$.isContentEditable || g.data("cke-editable")); for (; g;) { if (g.data("cke-editable")) return !1; if (g.hasAttribute("contenteditable")) return "false" == g.getAttribute("contenteditable"); g = g.getParent() } return !0
                    }
                }); CKEDITOR.dom.window = function (a) { CKEDITOR.dom.domObject.call(this, a) }; CKEDITOR.dom.window.prototype = new CKEDITOR.dom.domObject; CKEDITOR.tools.extend(CKEDITOR.dom.window.prototype, {
                    focus: function () { this.$.focus() },
                    getViewPaneSize: function () { var a = this.$.document, g = "CSS1Compat" == a.compatMode; return { width: (g ? a.documentElement.clientWidth : a.body.clientWidth) || 0, height: (g ? a.documentElement.clientHeight : a.body.clientHeight) || 0 } }, getScrollPosition: function () { var a = this.$; if ("pageXOffset" in a) return { x: a.pageXOffset || 0, y: a.pageYOffset || 0 }; a = a.document; return { x: a.documentElement.scrollLeft || a.body.scrollLeft || 0, y: a.documentElement.scrollTop || a.body.scrollTop || 0 } }, getFrame: function () {
                        var a = this.$.frameElement; return a ?
                            new CKEDITOR.dom.element.get(a) : null
                    }
                }); CKEDITOR.dom.document = function (a) { CKEDITOR.dom.domObject.call(this, a) }; CKEDITOR.dom.document.prototype = new CKEDITOR.dom.domObject; CKEDITOR.tools.extend(CKEDITOR.dom.document.prototype, {
                    type: CKEDITOR.NODE_DOCUMENT, appendStyleSheet: function (a) { if (this.$.createStyleSheet) this.$.createStyleSheet(a); else { var g = new CKEDITOR.dom.element("link"); g.setAttributes({ rel: "stylesheet", type: "text/css", href: a }); this.getHead().append(g) } }, appendStyleText: function (a) {
                        if (this.$.createStyleSheet) {
                            var g =
                                this.$.createStyleSheet(""); g.cssText = a
                        } else { var e = new CKEDITOR.dom.element("style", this); e.append(new CKEDITOR.dom.text(a, this)); this.getHead().append(e) } return g || e.$.sheet
                    }, createElement: function (a, g) { var e = new CKEDITOR.dom.element(a, this); g && (g.attributes && e.setAttributes(g.attributes), g.styles && e.setStyles(g.styles)); return e }, createText: function (a) { return new CKEDITOR.dom.text(a, this) }, focus: function () { this.getWindow().focus() }, getActive: function () { var a; try { a = this.$.activeElement } catch (g) { return null } return new CKEDITOR.dom.element(a) },
                    getById: function (a) { return (a = this.$.getElementById(a)) ? new CKEDITOR.dom.element(a) : null }, getByAddress: function (a, g) { for (var e = this.$.documentElement, b = 0; e && b < a.length; b++) { var d = a[b]; if (g) for (var m = -1, h = 0; h < e.childNodes.length; h++) { var l = e.childNodes[h]; if (!0 !== g || 3 != l.nodeType || !l.previousSibling || 3 != l.previousSibling.nodeType) if (m++, m == d) { e = l; break } } else e = e.childNodes[d] } return e ? new CKEDITOR.dom.node(e) : null }, getElementsByTag: function (a, g) {
                        CKEDITOR.env.ie && 8 >= document.documentMode || !g || (a = g + ":" +
                            a); return new CKEDITOR.dom.nodeList(this.$.getElementsByTagName(a))
                    }, getHead: function () { var a = this.$.getElementsByTagName("head")[0]; return a = a ? new CKEDITOR.dom.element(a) : this.getDocumentElement().append(new CKEDITOR.dom.element("head"), !0) }, getBody: function () { return new CKEDITOR.dom.element(this.$.body) }, getDocumentElement: function () { return new CKEDITOR.dom.element(this.$.documentElement) }, getWindow: function () { return new CKEDITOR.dom.window(this.$.parentWindow || this.$.defaultView) }, write: function (a) {
                        this.$.open("text/html",
                            "replace"); CKEDITOR.env.ie && (a = a.replace(/(?:^\s*<!DOCTYPE[^>]*?>)|^/i, '$\x26\n\x3cscript data-cke-temp\x3d"1"\x3e(' + CKEDITOR.tools.fixDomain + ")();\x3c/script\x3e")); this.$.write(a); this.$.close()
                    }, find: function (a) { return new CKEDITOR.dom.nodeList(this.$.querySelectorAll(a)) }, findOne: function (a) { return (a = this.$.querySelector(a)) ? new CKEDITOR.dom.element(a) : null }, _getHtml5ShivFrag: function () {
                        var a = this.getCustomData("html5ShivFrag"); a || (a = this.$.createDocumentFragment(), CKEDITOR.tools.enableHtml5Elements(a,
                            !0), this.setCustomData("html5ShivFrag", a)); return a
                    }
                }); CKEDITOR.dom.nodeList = function (a) { this.$ = a }; CKEDITOR.dom.nodeList.prototype = { count: function () { return this.$.length }, getItem: function (a) { return 0 > a || a >= this.$.length ? null : (a = this.$[a]) ? new CKEDITOR.dom.node(a) : null }, toArray: function () { return CKEDITOR.tools.array.map(this.$, function (a) { return new CKEDITOR.dom.node(a) }) } }; CKEDITOR.dom.element = function (a, g) {
                    "string" == typeof a && (a = (g ? g.$ : document).createElement(a)); CKEDITOR.dom.domObject.call(this,
                        a)
                }; CKEDITOR.dom.element.get = function (a) { return (a = "string" == typeof a ? document.getElementById(a) || document.getElementsByName(a)[0] : a) && (a.$ ? a : new CKEDITOR.dom.element(a)) }; CKEDITOR.dom.element.prototype = new CKEDITOR.dom.node; CKEDITOR.dom.element.createFromHtml = function (a, g) { var e = new CKEDITOR.dom.element("div", g); e.setHtml(a); return e.getFirst().remove() }; CKEDITOR.dom.element.setMarker = function (a, g, e, b) {
                    var d = g.getCustomData("list_marker_id") || g.setCustomData("list_marker_id", CKEDITOR.tools.getNextNumber()).getCustomData("list_marker_id"),
                    m = g.getCustomData("list_marker_names") || g.setCustomData("list_marker_names", {}).getCustomData("list_marker_names"); a[d] = g; m[e] = 1; return g.setCustomData(e, b)
                }; CKEDITOR.dom.element.clearAllMarkers = function (a) { for (var g in a) CKEDITOR.dom.element.clearMarkers(a, a[g], 1) }; CKEDITOR.dom.element.clearMarkers = function (a, g, e) {
                    var b = g.getCustomData("list_marker_names"), d = g.getCustomData("list_marker_id"), m; for (m in b) g.removeCustomData(m); g.removeCustomData("list_marker_names"); e && (g.removeCustomData("list_marker_id"),
                        delete a[d])
                }; (function () {
                    function a(a, c) { return -1 < (" " + a + " ").replace(m, " ").indexOf(" " + c + " ") } function g(a) { var c = !0; a.$.id || (a.$.id = "cke_tmp_" + CKEDITOR.tools.getNextNumber(), c = !1); return function () { c || a.removeAttribute("id") } } function e(a, c) { var b = CKEDITOR.tools.escapeCss(a.$.id); return "#" + b + " " + c.split(/,\s*/).join(", #" + b + " ") } function b(a) { for (var c = 0, b = 0, f = h[a].length; b < f; b++)c += parseFloat(this.getComputedStyle(h[a][b]) || 0, 10) || 0; return c } var d = document.createElement("_").classList, d = "undefined" !==
                        typeof d && null !== String(d.add).match(/\[Native code\]/gi), m = /[\n\t\r]/g; CKEDITOR.tools.extend(CKEDITOR.dom.element.prototype, {
                            type: CKEDITOR.NODE_ELEMENT, addClass: d ? function (a) { this.$.classList.add(a); return this } : function (b) { var c = this.$.className; c && (a(c, b) || (c += " " + b)); this.$.className = c || b; return this }, removeClass: d ? function (a) { var c = this.$; c.classList.remove(a); c.className || c.removeAttribute("class"); return this } : function (b) {
                                var c = this.getAttribute("class"); c && a(c, b) && ((c = c.replace(new RegExp("(?:^|\\s+)" +
                                    b + "(?\x3d\\s|$)"), "").replace(/^\s+/, "")) ? this.setAttribute("class", c) : this.removeAttribute("class")); return this
                            }, hasClass: function (b) { return a(this.$.className, b) }, append: function (a, c) { "string" == typeof a && (a = this.getDocument().createElement(a)); c ? this.$.insertBefore(a.$, this.$.firstChild) : this.$.appendChild(a.$); return a }, appendHtml: function (a) { if (this.$.childNodes.length) { var c = new CKEDITOR.dom.element("div", this.getDocument()); c.setHtml(a); c.moveChildren(this) } else this.setHtml(a) }, appendText: function (a) {
                                null !=
                                this.$.text && CKEDITOR.env.ie && 9 > CKEDITOR.env.version ? this.$.text += a : this.append(new CKEDITOR.dom.text(a))
                            }, appendBogus: function (a) { if (a || CKEDITOR.env.needsBrFiller) { for (a = this.getLast(); a && a.type == CKEDITOR.NODE_TEXT && !CKEDITOR.tools.rtrim(a.getText());)a = a.getPrevious(); a && a.is && a.is("br") || (a = this.getDocument().createElement("br"), CKEDITOR.env.gecko && a.setAttribute("type", "_moz"), this.append(a)) } }, breakParent: function (a, c) {
                                var b = new CKEDITOR.dom.range(this.getDocument()); b.setStartAfter(this); b.setEndAfter(a);
                                var f = b.extractContents(!1, c || !1), d; b.insertNode(this.remove()); if (CKEDITOR.env.ie && !CKEDITOR.env.edge) { for (b = new CKEDITOR.dom.element("div"); d = f.getFirst();)d.$.style.backgroundColor && (d.$.style.backgroundColor = d.$.style.backgroundColor), b.append(d); b.insertAfter(this); b.remove(!0) } else f.insertAfterNode(this)
                            }, contains: document.compareDocumentPosition ? function (a) { return !!(this.$.compareDocumentPosition(a.$) & 16) } : function (a) {
                                var c = this.$; return a.type != CKEDITOR.NODE_ELEMENT ? c.contains(a.getParent().$) :
                                    c != a.$ && c.contains(a.$)
                            }, focus: function () { function a() { try { this.$.focus() } catch (c) { } } return function (c) { c ? CKEDITOR.tools.setTimeout(a, 100, this) : a.call(this) } }(), getHtml: function () { var a = this.$.innerHTML; return CKEDITOR.env.ie ? a.replace(/<\?[^>]*>/g, "") : a }, getOuterHtml: function () { if (this.$.outerHTML) return this.$.outerHTML.replace(/<\?[^>]*>/, ""); var a = this.$.ownerDocument.createElement("div"); a.appendChild(this.$.cloneNode(!0)); return a.innerHTML }, getClientRect: function (a) {
                                var c = CKEDITOR.tools.extend({},
                                    this.$.getBoundingClientRect()); !c.width && (c.width = c.right - c.left); !c.height && (c.height = c.bottom - c.top); return a ? CKEDITOR.tools.getAbsoluteRectPosition(this.getWindow(), c) : c
                            }, setHtml: CKEDITOR.env.ie && 9 > CKEDITOR.env.version ? function (a) {
                                try { var c = this.$; if (this.getParent()) return c.innerHTML = a; var b = this.getDocument()._getHtml5ShivFrag(); b.appendChild(c); c.innerHTML = a; b.removeChild(c); return a } catch (f) {
                                    this.$.innerHTML = ""; c = new CKEDITOR.dom.element("body", this.getDocument()); c.$.innerHTML = a; for (c = c.getChildren(); c.count();)this.append(c.getItem(0));
                                    return a
                                }
                            } : function (a) { return this.$.innerHTML = a }, setText: function () { var a = document.createElement("p"); a.innerHTML = "x"; a = a.textContent; return function (c) { this.$[a ? "textContent" : "innerText"] = c } }(), getAttribute: function () {
                                var a = function (a) { return this.$.getAttribute(a, 2) }; return CKEDITOR.env.ie && (CKEDITOR.env.ie7Compat || CKEDITOR.env.quirks) ? function (a) {
                                    switch (a) {
                                        case "class": a = "className"; break; case "http-equiv": a = "httpEquiv"; break; case "name": return this.$.name; case "tabindex": return a = this.$.getAttribute(a,
                                            2), 0 !== a && 0 === this.$.tabIndex && (a = null), a; case "checked": return a = this.$.attributes.getNamedItem(a), (a.specified ? a.nodeValue : this.$.checked) ? "checked" : null; case "hspace": case "value": return this.$[a]; case "style": return this.$.style.cssText; case "contenteditable": case "contentEditable": return this.$.attributes.getNamedItem("contentEditable").specified ? this.$.getAttribute("contentEditable") : null
                                    }return this.$.getAttribute(a, 2)
                                } : a
                            }(), getAttributes: function (a) {
                                var c = {}, b = this.$.attributes, f; a = CKEDITOR.tools.isArray(a) ?
                                    a : []; for (f = 0; f < b.length; f++)-1 === CKEDITOR.tools.indexOf(a, b[f].name) && (c[b[f].name] = b[f].value); return c
                            }, getChildren: function () { return new CKEDITOR.dom.nodeList(this.$.childNodes) }, getClientSize: function () { return { width: this.$.clientWidth, height: this.$.clientHeight } }, getComputedStyle: document.defaultView && document.defaultView.getComputedStyle ? function (a) { var c = this.getWindow().$.getComputedStyle(this.$, null); return c ? c.getPropertyValue(a) : "" } : function (a) { return this.$.currentStyle[CKEDITOR.tools.cssStyleToDomStyle(a)] },
                            getDtd: function () { var a = CKEDITOR.dtd[this.getName()]; this.getDtd = function () { return a }; return a }, getElementsByTag: CKEDITOR.dom.document.prototype.getElementsByTag, getTabIndex: function () { var a = this.$.tabIndex; return 0 !== a || CKEDITOR.dtd.$tabIndex[this.getName()] || 0 === parseInt(this.getAttribute("tabindex"), 10) ? a : -1 }, getText: function () { return this.$.textContent || this.$.innerText || "" }, getWindow: function () { return this.getDocument().getWindow() }, getId: function () { return this.$.id || null }, getNameAtt: function () {
                                return this.$.name ||
                                    null
                            }, getName: function () { var a = this.$.nodeName.toLowerCase(); if (CKEDITOR.env.ie && 8 >= document.documentMode) { var c = this.$.scopeName; "HTML" != c && (a = c.toLowerCase() + ":" + a) } this.getName = function () { return a }; return this.getName() }, getValue: function () { return this.$.value }, getFirst: function (a) { var c = this.$.firstChild; (c = c && new CKEDITOR.dom.node(c)) && a && !a(c) && (c = c.getNext(a)); return c }, getLast: function (a) { var c = this.$.lastChild; (c = c && new CKEDITOR.dom.node(c)) && a && !a(c) && (c = c.getPrevious(a)); return c }, getStyle: function (a) { return this.$.style[CKEDITOR.tools.cssStyleToDomStyle(a)] },
                            is: function () { var a = this.getName(); if ("object" == typeof arguments[0]) return !!arguments[0][a]; for (var c = 0; c < arguments.length; c++)if (arguments[c] == a) return !0; return !1 }, isEditable: function (a) {
                                var c = this.getName(); return this.isReadOnly() || "none" == this.getComputedStyle("display") || "hidden" == this.getComputedStyle("visibility") || CKEDITOR.dtd.$nonEditable[c] || CKEDITOR.dtd.$empty[c] || this.is("a") && (this.data("cke-saved-name") || this.hasAttribute("name")) && !this.getChildCount() ? !1 : !1 !== a ? (a = CKEDITOR.dtd[c] ||
                                    CKEDITOR.dtd.span, !(!a || !a["#"])) : !0
                            }, isIdentical: function (a) {
                                var c = this.clone(0, 1); a = a.clone(0, 1); c.removeAttributes(["_moz_dirty", "data-cke-expando", "data-cke-saved-href", "data-cke-saved-name"]); a.removeAttributes(["_moz_dirty", "data-cke-expando", "data-cke-saved-href", "data-cke-saved-name"]); if (c.$.isEqualNode) return c.$.style.cssText = CKEDITOR.tools.normalizeCssText(c.$.style.cssText), a.$.style.cssText = CKEDITOR.tools.normalizeCssText(a.$.style.cssText), c.$.isEqualNode(a.$); c = c.getOuterHtml(); a =
                                    a.getOuterHtml(); if (CKEDITOR.env.ie && 9 > CKEDITOR.env.version && this.is("a")) { var b = this.getParent(); b.type == CKEDITOR.NODE_ELEMENT && (b = b.clone(), b.setHtml(c), c = b.getHtml(), b.setHtml(a), a = b.getHtml()) } return c == a
                            }, isVisible: function () { var a = (this.$.offsetHeight || this.$.offsetWidth) && "hidden" != this.getComputedStyle("visibility"), c, b; a && CKEDITOR.env.webkit && (c = this.getWindow(), !c.equals(CKEDITOR.document.getWindow()) && (b = c.$.frameElement) && (a = (new CKEDITOR.dom.element(b)).isVisible())); return !!a }, isEmptyInlineRemoveable: function () {
                                if (!CKEDITOR.dtd.$removeEmpty[this.getName()]) return !1;
                                for (var a = this.getChildren(), c = 0, b = a.count(); c < b; c++) { var f = a.getItem(c); if (f.type != CKEDITOR.NODE_ELEMENT || !f.data("cke-bookmark")) if (f.type == CKEDITOR.NODE_ELEMENT && !f.isEmptyInlineRemoveable() || f.type == CKEDITOR.NODE_TEXT && CKEDITOR.tools.trim(f.getText())) return !1 } return !0
                            }, hasAttributes: CKEDITOR.env.ie && (CKEDITOR.env.ie7Compat || CKEDITOR.env.quirks) ? function () {
                                for (var a = this.$.attributes, c = 0; c < a.length; c++) {
                                    var b = a[c]; switch (b.nodeName) {
                                        case "class": if (this.getAttribute("class")) return !0; case "data-cke-expando": continue;
                                        default: if (b.specified) return !0
                                    }
                                } return !1
                            } : function () { var a = this.$.attributes, c = a.length, b = { "data-cke-expando": 1, _moz_dirty: 1 }; return 0 < c && (2 < c || !b[a[0].nodeName] || 2 == c && !b[a[1].nodeName]) }, hasAttribute: function () {
                                function a(c) {
                                    var b = this.$.attributes.getNamedItem(c); if ("input" == this.getName()) switch (c) { case "class": return 0 < this.$.className.length; case "checked": return !!this.$.checked; case "value": return c = this.getAttribute("type"), "checkbox" == c || "radio" == c ? "on" != this.$.value : !!this.$.value }return b ?
                                        b.specified : !1
                                } return CKEDITOR.env.ie ? 8 > CKEDITOR.env.version ? function (c) { return "name" == c ? !!this.$.name : a.call(this, c) } : a : function (a) { return !!this.$.attributes.getNamedItem(a) }
                            }(), hide: function () { this.setStyle("display", "none") }, moveChildren: function (a, c) { var b = this.$; a = a.$; if (b != a) { var f; if (c) for (; f = b.lastChild;)a.insertBefore(b.removeChild(f), a.firstChild); else for (; f = b.firstChild;)a.appendChild(b.removeChild(f)) } }, mergeSiblings: function () {
                                function a(c, b, f) {
                                    if (b && b.type == CKEDITOR.NODE_ELEMENT) {
                                        for (var d =
                                            []; b.data("cke-bookmark") || b.isEmptyInlineRemoveable();)if (d.push(b), b = f ? b.getNext() : b.getPrevious(), !b || b.type != CKEDITOR.NODE_ELEMENT) return; if (c.isIdentical(b)) { for (var e = f ? c.getLast() : c.getFirst(); d.length;)d.shift().move(c, !f); b.moveChildren(c, !f); b.remove(); e && e.type == CKEDITOR.NODE_ELEMENT && e.mergeSiblings() }
                                    }
                                } return function (c) { if (!1 === c || CKEDITOR.dtd.$removeEmpty[this.getName()] || this.is("a")) a(this, this.getNext(), !0), a(this, this.getPrevious()) }
                            }(), show: function () {
                                this.setStyles({
                                    display: "",
                                    visibility: ""
                                })
                            }, setAttribute: function () {
                                var a = function (a, b) { this.$.setAttribute(a, b); return this }; return CKEDITOR.env.ie && (CKEDITOR.env.ie7Compat || CKEDITOR.env.quirks) ? function (c, b) { "class" == c ? this.$.className = b : "style" == c ? this.$.style.cssText = b : "tabindex" == c ? this.$.tabIndex = b : "checked" == c ? this.$.checked = b : "contenteditable" == c ? a.call(this, "contentEditable", b) : a.apply(this, arguments); return this } : CKEDITOR.env.ie8Compat && CKEDITOR.env.secure ? function (c, b) {
                                    if ("src" == c && b.match(/^http:\/\//)) try {
                                        a.apply(this,
                                            arguments)
                                    } catch (f) { } else a.apply(this, arguments); return this
                                } : a
                            }(), setAttributes: function (a) { for (var c in a) this.setAttribute(c, a[c]); return this }, setValue: function (a) { this.$.value = a; return this }, removeAttribute: function () { var a = function (a) { this.$.removeAttribute(a) }; return CKEDITOR.env.ie && (CKEDITOR.env.ie7Compat || CKEDITOR.env.quirks) ? function (a) { "class" == a ? a = "className" : "tabindex" == a ? a = "tabIndex" : "contenteditable" == a && (a = "contentEditable"); this.$.removeAttribute(a) } : a }(), removeAttributes: function (a) {
                                if (CKEDITOR.tools.isArray(a)) for (var c =
                                    0; c < a.length; c++)this.removeAttribute(a[c]); else for (c in a = a || this.getAttributes(), a) a.hasOwnProperty(c) && this.removeAttribute(c)
                            }, removeStyle: function (a) {
                                var c = this.$.style; if (c.removeProperty || "border" != a && "margin" != a && "padding" != a) c.removeProperty ? c.removeProperty(a) : c.removeAttribute(CKEDITOR.tools.cssStyleToDomStyle(a)), this.$.style.cssText || this.removeAttribute("style"); else {
                                    var b = ["top", "left", "right", "bottom"], f; "border" == a && (f = ["color", "style", "width"]); for (var c = [], d = 0; d < b.length; d++)if (f) for (var e =
                                        0; e < f.length; e++)c.push([a, b[d], f[e]].join("-")); else c.push([a, b[d]].join("-")); for (a = 0; a < c.length; a++)this.removeStyle(c[a])
                                }
                            }, setStyle: function (a, c) { this.$.style[CKEDITOR.tools.cssStyleToDomStyle(a)] = c; return this }, setStyles: function (a) { for (var c in a) this.setStyle(c, a[c]); return this }, setOpacity: function (a) { CKEDITOR.env.ie && 9 > CKEDITOR.env.version ? (a = Math.round(100 * a), this.setStyle("filter", 100 <= a ? "" : "progid:DXImageTransform.Microsoft.Alpha(opacity\x3d" + a + ")")) : this.setStyle("opacity", a) }, unselectable: function () {
                                this.setStyles(CKEDITOR.tools.cssVendorPrefix("user-select",
                                    "none")); if (CKEDITOR.env.ie) { this.setAttribute("unselectable", "on"); for (var a, c = this.getElementsByTag("*"), b = 0, f = c.count(); b < f; b++)a = c.getItem(b), a.setAttribute("unselectable", "on") }
                            }, getPositionedAncestor: function () { for (var a = this; "html" != a.getName();) { if ("static" != a.getComputedStyle("position")) return a; a = a.getParent() } return null }, getDocumentPosition: function (a) {
                                var c = 0, b = 0, f = this.getDocument(), d = f.getBody(), e = "BackCompat" == f.$.compatMode; if (document.documentElement.getBoundingClientRect && (CKEDITOR.env.ie ?
                                    8 !== CKEDITOR.env.version : 1)) { var h = this.$.getBoundingClientRect(), g = f.$.documentElement, m = g.clientTop || d.$.clientTop || 0, w = g.clientLeft || d.$.clientLeft || 0, x = !0; CKEDITOR.env.ie && (x = f.getDocumentElement().contains(this), f = f.getBody().contains(this), x = e && f || !e && x); x && (CKEDITOR.env.webkit || CKEDITOR.env.ie && 12 <= CKEDITOR.env.version ? (c = d.$.scrollLeft || g.scrollLeft, b = d.$.scrollTop || g.scrollTop) : (b = e ? d.$ : g, c = b.scrollLeft, b = b.scrollTop), c = h.left + c - w, b = h.top + b - m) } else for (m = this, w = null; m && "body" != m.getName() &&
                                        "html" != m.getName();) { c += m.$.offsetLeft - m.$.scrollLeft; b += m.$.offsetTop - m.$.scrollTop; m.equals(this) || (c += m.$.clientLeft || 0, b += m.$.clientTop || 0); for (; w && !w.equals(m);)c -= w.$.scrollLeft, b -= w.$.scrollTop, w = w.getParent(); w = m; m = (h = m.$.offsetParent) ? new CKEDITOR.dom.element(h) : null } a && (h = this.getWindow(), m = a.getWindow(), !h.equals(m) && h.$.frameElement && (a = (new CKEDITOR.dom.element(h.$.frameElement)).getDocumentPosition(a), c += a.x, b += a.y)); document.documentElement.getBoundingClientRect || !CKEDITOR.env.gecko ||
                                            e || (c += this.$.clientLeft ? 1 : 0, b += this.$.clientTop ? 1 : 0); return { x: c, y: b }
                            }, scrollIntoView: function (a) { var b = this.getParent(); if (b) { do if ((b.$.clientWidth && b.$.clientWidth < b.$.scrollWidth || b.$.clientHeight && b.$.clientHeight < b.$.scrollHeight) && !b.is("body") && this.scrollIntoParent(b, a, 1), b.is("html")) { var d = b.getWindow(); try { var f = d.$.frameElement; f && (b = new CKEDITOR.dom.element(f)) } catch (e) { } } while (b = b.getParent()) } }, scrollIntoParent: function (a, b, d) {
                                var f, e, h, g; function m(f, b) {
                                    /body|html/.test(a.getName()) ?
                                    a.getWindow().$.scrollBy(f, b) : (a.$.scrollLeft += f, a.$.scrollTop += b)
                                } function r(a, f) { var b = { x: 0, y: 0 }; if (!a.is(x ? "body" : "html")) { var c = a.$.getBoundingClientRect(); b.x = c.left; b.y = c.top } c = a.getWindow(); c.equals(f) || (c = r(CKEDITOR.dom.element.get(c.$.frameElement), f), b.x += c.x, b.y += c.y); return b } function w(a, f) { return parseInt(a.getComputedStyle("margin-" + f) || 0, 10) || 0 } !a && (a = this.getWindow()); h = a.getDocument(); var x = "BackCompat" == h.$.compatMode; a instanceof CKEDITOR.dom.window && (a = x ? h.getBody() : h.getDocumentElement());
                                CKEDITOR.env.webkit && (h = this.getEditor(!1)) && (h._.previousScrollTop = null); h = a.getWindow(); e = r(this, h); var u = r(a, h), A = this.$.offsetHeight; f = this.$.offsetWidth; var v = a.$.clientHeight, z = a.$.clientWidth; h = e.x - w(this, "left") - u.x || 0; g = e.y - w(this, "top") - u.y || 0; f = e.x + f + w(this, "right") - (u.x + z) || 0; e = e.y + A + w(this, "bottom") - (u.y + v) || 0; (0 > g || 0 < e) && m(0, !0 === b ? g : !1 === b ? e : 0 > g ? g : e); d && (0 > h || 0 < f) && m(0 > h ? h : f, 0)
                            }, setState: function (a, b, d) {
                                b = b || "cke"; switch (a) {
                                    case CKEDITOR.TRISTATE_ON: this.addClass(b + "_on"); this.removeClass(b +
                                        "_off"); this.removeClass(b + "_disabled"); d && this.setAttribute("aria-pressed", !0); d && this.removeAttribute("aria-disabled"); break; case CKEDITOR.TRISTATE_DISABLED: this.addClass(b + "_disabled"); this.removeClass(b + "_off"); this.removeClass(b + "_on"); d && this.setAttribute("aria-disabled", !0); d && this.removeAttribute("aria-pressed"); break; default: this.addClass(b + "_off"), this.removeClass(b + "_on"), this.removeClass(b + "_disabled"), d && this.removeAttribute("aria-pressed"), d && this.removeAttribute("aria-disabled")
                                }
                            },
                            getFrameDocument: function () { var a = this.$; try { a.contentWindow.document } catch (b) { a.src = a.src } return a && new CKEDITOR.dom.document(a.contentWindow.document) }, copyAttributes: function (a, b) {
                                var d = this.$.attributes; b = b || {}; for (var f = 0; f < d.length; f++) { var e = d[f], h = e.nodeName.toLowerCase(), g; if (!(h in b)) if ("checked" == h && (g = this.getAttribute(h))) a.setAttribute(h, g); else if (!CKEDITOR.env.ie || this.hasAttribute(h)) g = this.getAttribute(h), null === g && (g = e.nodeValue), a.setAttribute(h, g) } "" !== this.$.style.cssText &&
                                    (a.$.style.cssText = this.$.style.cssText)
                            }, renameNode: function (a) { if (this.getName() != a) { var b = this.getDocument(); a = new CKEDITOR.dom.element(a, b); this.copyAttributes(a); this.moveChildren(a); this.getParent(!0) && this.$.parentNode.replaceChild(a.$, this.$); a.$["data-cke-expando"] = this.$["data-cke-expando"]; this.$ = a.$; delete this.getName } }, getChild: function () {
                                function a(b, d) { var f = b.childNodes; if (0 <= d && d < f.length) return f[d] } return function (b) {
                                    var d = this.$; if (b.slice) for (b = b.slice(); 0 < b.length && d;)d = a(d,
                                        b.shift()); else d = a(d, b); return d ? new CKEDITOR.dom.node(d) : null
                                }
                            }(), getChildCount: function () { return this.$.childNodes.length }, disableContextMenu: function () { function a(b) { return b.type == CKEDITOR.NODE_ELEMENT && b.hasClass("cke_enable_context_menu") } this.on("contextmenu", function (b) { b.data.getTarget().getAscendant(a, !0) || b.data.preventDefault() }) }, getDirection: function (a) {
                                return a ? this.getComputedStyle("direction") || this.getDirection() || this.getParent() && this.getParent().getDirection(1) || this.getDocument().$.dir ||
                                    "ltr" : this.getStyle("direction") || this.getAttribute("dir")
                            }, data: function (a, b) { a = "data-" + a; if (void 0 === b) return this.getAttribute(a); !1 === b ? this.removeAttribute(a) : this.setAttribute(a, b); return null }, getEditor: function (a) { var b = CKEDITOR.instances, d, f, e; a = a || void 0 === a; for (d in b) if (f = b[d], f.element.equals(this) && f.elementMode != CKEDITOR.ELEMENT_MODE_APPENDTO || !a && (e = f.editable()) && (e.equals(this) || e.contains(this))) return f; return null }, find: function (a) {
                                var b = g(this); a = new CKEDITOR.dom.nodeList(this.$.querySelectorAll(e(this,
                                    a))); b(); return a
                            }, findOne: function (a) { var b = g(this); a = this.$.querySelector(e(this, a)); b(); return a ? new CKEDITOR.dom.element(a) : null }, forEach: function (a, b, d) { if (!(d || b && this.type != b)) var f = a(this); if (!1 !== f) { d = this.getChildren(); for (var e = 0; e < d.count(); e++)f = d.getItem(e), f.type == CKEDITOR.NODE_ELEMENT ? f.forEach(a, b) : b && f.type != b || a(f) } }, fireEventHandler: function (a, b) {
                                var d = "on" + a, f = this.$; if (CKEDITOR.env.ie && 9 > CKEDITOR.env.version) {
                                    var e = f.ownerDocument.createEventObject(), h; for (h in b) e[h] = b[h]; f.fireEvent(d,
                                        e)
                                } else f[f[a] ? a : d](b)
                            }, isDetached: function () { var a = this.getDocument(), b = a.getDocumentElement(); return b.equals(this) || b.contains(this) ? !CKEDITOR.env.ie || 8 < CKEDITOR.env.version && !CKEDITOR.env.quirks ? !a.$.defaultView : !1 : !0 }
                        }); var h = { width: ["border-left-width", "border-right-width", "padding-left", "padding-right"], height: ["border-top-width", "border-bottom-width", "padding-top", "padding-bottom"] }; CKEDITOR.dom.element.prototype.setSize = function (a, c, d) {
                            "number" == typeof c && (!d || CKEDITOR.env.ie && CKEDITOR.env.quirks ||
                                (c -= b.call(this, a)), this.setStyle(a, c + "px"))
                        }; CKEDITOR.dom.element.prototype.getSize = function (a, c) { var d = Math.max(this.$["offset" + CKEDITOR.tools.capitalize(a)], this.$["client" + CKEDITOR.tools.capitalize(a)]) || 0; c && (d -= b.call(this, a)); return d }
                })(); CKEDITOR.dom.documentFragment = function (a) { a = a || CKEDITOR.document; this.$ = a.type == CKEDITOR.NODE_DOCUMENT ? a.$.createDocumentFragment() : a }; CKEDITOR.tools.extend(CKEDITOR.dom.documentFragment.prototype, CKEDITOR.dom.element.prototype, {
                    type: CKEDITOR.NODE_DOCUMENT_FRAGMENT,
                    insertAfterNode: function (a) { a = a.$; a.parentNode.insertBefore(this.$, a.nextSibling) }, getHtml: function () { var a = new CKEDITOR.dom.element("div"); this.clone(1, 1).appendTo(a); return a.getHtml().replace(/\s*data-cke-expando=".*?"/g, "") }
                }, !0, { append: 1, appendBogus: 1, clone: 1, getFirst: 1, getHtml: 1, getLast: 1, getParent: 1, getNext: 1, getPrevious: 1, appendTo: 1, moveChildren: 1, insertBefore: 1, insertAfterNode: 1, replace: 1, trim: 1, type: 1, ltrim: 1, rtrim: 1, getDocument: 1, getChildCount: 1, getChild: 1, getChildren: 1 }); CKEDITOR.tools.extend(CKEDITOR.dom.documentFragment.prototype,
                    CKEDITOR.dom.document.prototype, !0, { find: 1, findOne: 1 }); (function () {
                        function a(a, f) {
                            var b = this.range; if (this._.end) return null; if (!this._.start) { this._.start = 1; if (b.collapsed) return this.end(), null; b.optimize() } var c, d = b.startContainer; c = b.endContainer; var e = b.startOffset, k = b.endOffset, n, h = this.guard, g = this.type, l = a ? "getPreviousSourceNode" : "getNextSourceNode"; if (!a && !this._.guardLTR) {
                                var m = c.type == CKEDITOR.NODE_ELEMENT ? c : c.getParent(), C = c.type == CKEDITOR.NODE_ELEMENT ? c.getChild(k) : c.getNext(); this._.guardLTR =
                                    function (a, f) { return (!f || !m.equals(a)) && (!C || !a.equals(C)) && (a.type != CKEDITOR.NODE_ELEMENT || !f || !a.equals(b.root)) }
                            } if (a && !this._.guardRTL) { var F = d.type == CKEDITOR.NODE_ELEMENT ? d : d.getParent(), G = d.type == CKEDITOR.NODE_ELEMENT ? e ? d.getChild(e - 1) : null : d.getPrevious(); this._.guardRTL = function (a, f) { return (!f || !F.equals(a)) && (!G || !a.equals(G)) && (a.type != CKEDITOR.NODE_ELEMENT || !f || !a.equals(b.root)) } } var I = a ? this._.guardRTL : this._.guardLTR; n = h ? function (a, f) { return !1 === I(a, f) ? !1 : h(a, f) } : I; this.current ? c = this.current[l](!1,
                                g, n) : (a ? c.type == CKEDITOR.NODE_ELEMENT && (c = 0 < k ? c.getChild(k - 1) : !1 === n(c, !0) ? null : c.getPreviousSourceNode(!0, g, n)) : (c = d, c.type == CKEDITOR.NODE_ELEMENT && ((c = c.getChild(e)) || (c = !1 === n(d, !0) ? null : d.getNextSourceNode(!0, g, n)))), c && !1 === n(c) && (c = null)); for (; c && !this._.end;) { this.current = c; if (!this.evaluator || !1 !== this.evaluator(c)) { if (!f) return c } else if (f && this.evaluator) return !1; c = c[l](!1, g, n) } this.end(); return this.current = null
                        } function g(f) { for (var b, c = null; b = a.call(this, f);)c = b; return c } CKEDITOR.dom.walker =
                            CKEDITOR.tools.createClass({ $: function (a) { this.range = a; this._ = {} }, proto: { end: function () { this._.end = 1 }, next: function () { return a.call(this) }, previous: function () { return a.call(this, 1) }, checkForward: function () { return !1 !== a.call(this, 0, 1) }, checkBackward: function () { return !1 !== a.call(this, 1, 1) }, lastForward: function () { return g.call(this) }, lastBackward: function () { return g.call(this, 1) }, reset: function () { delete this.current; this._ = {} } } }); var e = {
                                block: 1, "list-item": 1, table: 1, "table-row-group": 1, "table-header-group": 1,
                                "table-footer-group": 1, "table-row": 1, "table-column-group": 1, "table-column": 1, "table-cell": 1, "table-caption": 1
                            }, b = { absolute: 1, fixed: 1 }; CKEDITOR.dom.element.prototype.isBlockBoundary = function (a) { return "none" != this.getComputedStyle("float") || this.getComputedStyle("position") in b || !e[this.getComputedStyle("display")] ? !!(this.is(CKEDITOR.dtd.$block) || a && this.is(a)) : !0 }; CKEDITOR.dom.walker.blockBoundary = function (a) { return function (f) { return !(f.type == CKEDITOR.NODE_ELEMENT && f.isBlockBoundary(a)) } }; CKEDITOR.dom.walker.listItemBoundary =
                                function () { return this.blockBoundary({ br: 1 }) }; CKEDITOR.dom.walker.bookmark = function (a, f) { function b(a) { return a && a.getName && "span" == a.getName() && a.data("cke-bookmark") } return function (c) { var d, e; d = c && c.type != CKEDITOR.NODE_ELEMENT && (e = c.getParent()) && b(e); d = a ? d : d || b(c); return !!(f ^ d) } }; CKEDITOR.dom.walker.whitespaces = function (a) {
                                    return function (f) {
                                        var b; f && f.type == CKEDITOR.NODE_TEXT && (b = !CKEDITOR.tools.trim(f.getText()) || CKEDITOR.env.webkit && f.getText() == CKEDITOR.dom.selection.FILLING_CHAR_SEQUENCE);
                                        return !!(a ^ b)
                                    }
                                }; CKEDITOR.dom.walker.invisible = function (a) { var f = CKEDITOR.dom.walker.whitespaces(), b = CKEDITOR.env.webkit ? 1 : 0; return function (c) { f(c) ? c = 1 : (c.type == CKEDITOR.NODE_TEXT && (c = c.getParent()), c = c.$.offsetWidth <= b); return !!(a ^ c) } }; CKEDITOR.dom.walker.nodeType = function (a, f) { return function (b) { return !!(f ^ b.type == a) } }; CKEDITOR.dom.walker.bogus = function (a) {
                                    function f(a) { return !m(a) && !h(a) } return function (b) {
                                        var c = CKEDITOR.env.needsBrFiller ? b.is && b.is("br") : b.getText && d.test(b.getText()); c && (c = b.getParent(),
                                            b = b.getNext(f), c = c.isBlockBoundary() && (!b || b.type == CKEDITOR.NODE_ELEMENT && b.isBlockBoundary())); return !!(a ^ c)
                                    }
                                }; CKEDITOR.dom.walker.temp = function (a) { return function (f) { f.type != CKEDITOR.NODE_ELEMENT && (f = f.getParent()); f = f && f.hasAttribute("data-cke-temp"); return !!(a ^ f) } }; var d = /^[\t\r\n ]*(?:&nbsp;|\xa0)$/, m = CKEDITOR.dom.walker.whitespaces(), h = CKEDITOR.dom.walker.bookmark(), l = CKEDITOR.dom.walker.temp(), c = function (a) { return h(a) || m(a) || a.type == CKEDITOR.NODE_ELEMENT && a.is(CKEDITOR.dtd.$inline) && !a.is(CKEDITOR.dtd.$empty) };
                        CKEDITOR.dom.walker.ignored = function (a) { return function (f) { f = m(f) || h(f) || l(f); return !!(a ^ f) } }; var k = CKEDITOR.dom.walker.ignored(); CKEDITOR.dom.walker.empty = function (a) { return function (f) { for (var b = 0, c = f.getChildCount(); b < c; ++b)if (!k(f.getChild(b))) return !!a; return !a } }; var f = CKEDITOR.dom.walker.empty(), n = CKEDITOR.dom.walker.validEmptyBlockContainers = CKEDITOR.tools.extend(function (a) { var f = {}, b; for (b in a) CKEDITOR.dtd[b]["#"] && (f[b] = 1); return f }(CKEDITOR.dtd.$block), { caption: 1, td: 1, th: 1 }); CKEDITOR.dom.walker.editable =
                            function (a) { return function (b) { b = k(b) ? !1 : b.type == CKEDITOR.NODE_TEXT || b.type == CKEDITOR.NODE_ELEMENT && (b.is(CKEDITOR.dtd.$inline) || b.is("hr") || "false" == b.getAttribute("contenteditable") || !CKEDITOR.env.needsBrFiller && b.is(n) && f(b)) ? !0 : !1; return !!(a ^ b) } }; CKEDITOR.dom.element.prototype.getBogus = function () { var a = this; do a = a.getPreviousSourceNode(); while (c(a)); return a && (CKEDITOR.env.needsBrFiller ? a.is && a.is("br") : a.getText && d.test(a.getText())) ? a : !1 }
                    })(); CKEDITOR.dom.range = function (a) {
                        this.endOffset = this.endContainer =
                            this.startOffset = this.startContainer = null; this.collapsed = !0; var g = a instanceof CKEDITOR.dom.document; this.document = g ? a : a.getDocument(); this.root = g ? a.getBody() : a
                    }; (function () {
                        function a(a) { a.collapsed = a.startContainer && a.endContainer && a.startContainer.equals(a.endContainer) && a.startOffset == a.endOffset } function g(a, b, c, d, e) {
                            function k(a, f, b, c) { var d = b ? a.getPrevious() : a.getNext(); if (c && l) return d; v || c ? f.append(a.clone(!0, e), b) : (a.remove(), m && f.append(a, b)); return d } function h() {
                                var a, f, b, c = Math.min(J.length,
                                    K.length); for (a = 0; a < c; a++)if (f = J[a], b = K[a], !f.equals(b)) return a; return a - 1
                            } function g() {
                                var b = E - 1, c = I && H && !z.equals(y); b < R - 1 || b < P - 1 || c ? (c ? a.moveToPosition(y, CKEDITOR.POSITION_BEFORE_START) : P == b + 1 && G ? a.moveToPosition(K[b], CKEDITOR.POSITION_BEFORE_END) : a.moveToPosition(K[b + 1], CKEDITOR.POSITION_BEFORE_START), d && (b = J[b + 1]) && b.type == CKEDITOR.NODE_ELEMENT && (c = CKEDITOR.dom.element.createFromHtml('\x3cspan data-cke-bookmark\x3d"1" style\x3d"display:none"\x3e\x26nbsp;\x3c/span\x3e', a.document), c.insertAfter(b),
                                    b.mergeSiblings(!1), a.moveToBookmark({ startNode: c }))) : a.collapse(!0)
                            } a.optimizeBookmark(); var l = 0 === b, m = 1 == b, v = 2 == b; b = v || m; var z = a.startContainer, y = a.endContainer, B = a.startOffset, C = a.endOffset, F, G, I, H, D, M; if (v && y.type == CKEDITOR.NODE_TEXT && (z.equals(y) || z.type === CKEDITOR.NODE_ELEMENT && z.getFirst().equals(y))) c.append(a.document.createText(y.substring(B, C))); else {
                                y.type == CKEDITOR.NODE_TEXT ? v ? M = !0 : y = y.split(C) : 0 < y.getChildCount() ? C >= y.getChildCount() ? (y = y.getChild(C - 1), G = !0) : y = y.getChild(C) : H = G = !0; z.type ==
                                    CKEDITOR.NODE_TEXT ? v ? D = !0 : z.split(B) : 0 < z.getChildCount() ? 0 === B ? (z = z.getChild(B), F = !0) : z = z.getChild(B - 1) : I = F = !0; for (var J = z.getParents(), K = y.getParents(), E = h(), R = J.length - 1, P = K.length - 1, N = c, X, U, Y, ha = -1, O = E; O <= R; O++) { U = J[O]; Y = U.getNext(); for (O != R || U.equals(K[O]) && R < P ? b && (X = N.append(U.clone(0, e))) : F ? k(U, N, !1, I) : D && N.append(a.document.createText(U.substring(B))); Y;) { if (Y.equals(K[O])) { ha = O; break } Y = k(Y, N) } N = X } N = c; for (O = E; O <= P; O++)if (c = K[O], Y = c.getPrevious(), c.equals(J[O])) b && (N = N.getChild(0)); else {
                                        O !=
                                        P || c.equals(J[O]) && P < R ? b && (X = N.append(c.clone(0, e))) : G ? k(c, N, !1, H) : M && N.append(a.document.createText(c.substring(0, C))); if (O > ha) for (; Y;)Y = k(Y, N, !0); N = X
                                    } v || g()
                            }
                        } function e() { var a = !1, b = CKEDITOR.dom.walker.whitespaces(), c = CKEDITOR.dom.walker.bookmark(!0), d = CKEDITOR.dom.walker.bogus(); return function (e) { return c(e) || b(e) ? !0 : d(e) && !a ? a = !0 : e.type == CKEDITOR.NODE_TEXT && (e.hasAscendant("pre") || CKEDITOR.tools.trim(e.getText()).length) || e.type == CKEDITOR.NODE_ELEMENT && !e.is(m) ? !1 : !0 } } function b(a) {
                            var b = CKEDITOR.dom.walker.whitespaces(),
                            c = CKEDITOR.dom.walker.bookmark(1); return function (d) { return c(d) || b(d) ? !0 : !a && h(d) || d.type == CKEDITOR.NODE_ELEMENT && d.is(CKEDITOR.dtd.$removeEmpty) }
                        } function d(a) { return function () { var b; return this[a ? "getPreviousNode" : "getNextNode"](function (a) { !b && k(a) && (b = a); return c(a) && !(h(a) && a.equals(b)) }) } } var m = { abbr: 1, acronym: 1, b: 1, bdo: 1, big: 1, cite: 1, code: 1, del: 1, dfn: 1, em: 1, font: 1, i: 1, ins: 1, label: 1, kbd: 1, q: 1, samp: 1, small: 1, span: 1, strike: 1, strong: 1, sub: 1, sup: 1, tt: 1, u: 1, "var": 1 }, h = CKEDITOR.dom.walker.bogus(),
                            l = /^[\t\r\n ]*(?:&nbsp;|\xa0)$/, c = CKEDITOR.dom.walker.editable(), k = CKEDITOR.dom.walker.ignored(!0); CKEDITOR.dom.range.prototype = {
                                clone: function () { var a = new CKEDITOR.dom.range(this.root); a._setStartContainer(this.startContainer); a.startOffset = this.startOffset; a._setEndContainer(this.endContainer); a.endOffset = this.endOffset; a.collapsed = this.collapsed; return a }, collapse: function (a) {
                                    a ? (this._setEndContainer(this.startContainer), this.endOffset = this.startOffset) : (this._setStartContainer(this.endContainer),
                                        this.startOffset = this.endOffset); this.collapsed = !0
                                }, cloneContents: function (a) { var b = new CKEDITOR.dom.documentFragment(this.document); this.collapsed || g(this, 2, b, !1, "undefined" == typeof a ? !0 : a); return b }, deleteContents: function (a) { this.collapsed || g(this, 0, null, a) }, extractContents: function (a, b) { var c = new CKEDITOR.dom.documentFragment(this.document); this.collapsed || g(this, 1, c, a, "undefined" == typeof b ? !0 : b); return c }, equals: function (a) {
                                    return this.startOffset === a.startOffset && this.endOffset === a.endOffset &&
                                        this.startContainer.equals(a.startContainer) && this.endContainer.equals(a.endContainer)
                                }, createBookmark: function (a) {
                                    function b(a) { return a.getAscendant(function (a) { var b; if (b = a.data && a.data("cke-temp")) b = -1 === CKEDITOR.tools.array.indexOf(["cke_copybin", "cke_pastebin"], a.getAttribute("id")); return b }, !0) } var c = this.startContainer, d = this.endContainer, e = this.collapsed, k, h, g, l; k = this.document.createElement("span"); k.data("cke-bookmark", 1); k.setStyle("display", "none"); k.setHtml("\x26nbsp;"); a && (g = "cke_bm_" +
                                        CKEDITOR.tools.getNextNumber(), k.setAttribute("id", g + (e ? "C" : "S"))); e || (h = k.clone(), h.setHtml("\x26nbsp;"), a && h.setAttribute("id", g + "E"), l = this.clone(), b(d) && (d = b(d), l.moveToPosition(d, CKEDITOR.POSITION_AFTER_END)), l.collapse(), l.insertNode(h)); l = this.clone(); b(c) && (d = b(c), l.moveToPosition(d, CKEDITOR.POSITION_BEFORE_START)); l.collapse(!0); l.insertNode(k); h ? (this.setStartAfter(k), this.setEndBefore(h)) : this.moveToPosition(k, CKEDITOR.POSITION_AFTER_END); return {
                                            startNode: a ? g + (e ? "C" : "S") : k, endNode: a ? g +
                                                "E" : h, serializable: a, collapsed: e
                                        }
                                }, createBookmark2: function () {
                                    function a(b) {
                                        var f = b.container, d = b.offset, e; e = f; var k = d; e = e.type != CKEDITOR.NODE_ELEMENT || 0 === k || k == e.getChildCount() ? 0 : e.getChild(k - 1).type == CKEDITOR.NODE_TEXT && e.getChild(k).type == CKEDITOR.NODE_TEXT; e && (f = f.getChild(d - 1), d = f.getLength()); if (f.type == CKEDITOR.NODE_ELEMENT && 0 < d) { a: { for (e = f; d--;)if (k = e.getChild(d).getIndex(!0), 0 <= k) { d = k; break a } d = -1 } d += 1 } if (f.type == CKEDITOR.NODE_TEXT) {
                                            e = f; for (k = 0; (e = e.getPrevious()) && e.type == CKEDITOR.NODE_TEXT;)k +=
                                                e.getText().replace(CKEDITOR.dom.selection.FILLING_CHAR_SEQUENCE, "").length; e = k; f.isEmpty() ? (k = f.getPrevious(c), e ? (d = e, f = k ? k.getNext() : f.getParent().getFirst()) : (f = f.getParent(), d = k ? k.getIndex(!0) + 1 : 0)) : d += e
                                        } b.container = f; b.offset = d
                                    } function b(a, f) { var c = f.getCustomData("cke-fillingChar"); if (c) { var d = a.container; c.equals(d) && (a.offset -= CKEDITOR.dom.selection.FILLING_CHAR_SEQUENCE.length, 0 >= a.offset && (a.offset = d.getIndex(), a.container = d.getParent())) } } var c = CKEDITOR.dom.walker.nodeType(CKEDITOR.NODE_TEXT,
                                        !0); return function (c) { var d = this.collapsed, e = { container: this.startContainer, offset: this.startOffset }, k = { container: this.endContainer, offset: this.endOffset }; c && (a(e), b(e, this.root), d || (a(k), b(k, this.root))); return { start: e.container.getAddress(c), end: d ? null : k.container.getAddress(c), startOffset: e.offset, endOffset: k.offset, normalized: c, collapsed: d, is2: !0 } }
                                }(), moveToBookmark: function (a) {
                                    if (a.is2) {
                                        var b = this.document.getByAddress(a.start, a.normalized), c = a.startOffset, d = a.end && this.document.getByAddress(a.end,
                                            a.normalized); a = a.endOffset; this.setStart(b, c); d ? this.setEnd(d, a) : this.collapse(!0)
                                    } else b = (c = a.serializable) ? this.document.getById(a.startNode) : a.startNode, a = c ? this.document.getById(a.endNode) : a.endNode, this.setStartBefore(b), b.remove(), a ? (this.setEndBefore(a), a.remove()) : this.collapse(!0)
                                }, getBoundaryNodes: function () {
                                    var a = this.startContainer, b = this.endContainer, c = this.startOffset, d = this.endOffset, e; if (a.type == CKEDITOR.NODE_ELEMENT) if (e = a.getChildCount(), e > c) a = a.getChild(c); else if (1 > e) a = a.getPreviousSourceNode();
                                    else { for (a = a.$; a.lastChild;)a = a.lastChild; a = new CKEDITOR.dom.node(a); a = a.getNextSourceNode() || a } if (b.type == CKEDITOR.NODE_ELEMENT) if (e = b.getChildCount(), e > d) b = b.getChild(d).getPreviousSourceNode(!0); else if (1 > e) b = b.getPreviousSourceNode(); else { for (b = b.$; b.lastChild;)b = b.lastChild; b = new CKEDITOR.dom.node(b) } a.getPosition(b) & CKEDITOR.POSITION_FOLLOWING && (a = b); return { startNode: a, endNode: b }
                                }, getCommonAncestor: function (a, b) {
                                    var c = this.startContainer, d = this.endContainer, c = c.equals(d) ? a && c.type == CKEDITOR.NODE_ELEMENT &&
                                        this.startOffset == this.endOffset - 1 ? c.getChild(this.startOffset) : c : c.getCommonAncestor(d); return b && !c.is ? c.getParent() : c
                                }, optimize: function () { var a = this.startContainer, b = this.startOffset; a.type != CKEDITOR.NODE_ELEMENT && (b ? b >= a.getLength() && this.setStartAfter(a) : this.setStartBefore(a)); a = this.endContainer; b = this.endOffset; a.type != CKEDITOR.NODE_ELEMENT && (b ? b >= a.getLength() && this.setEndAfter(a) : this.setEndBefore(a)) }, optimizeBookmark: function () {
                                    var a = this.startContainer, b = this.endContainer; a.is && a.is("span") &&
                                        a.data("cke-bookmark") && this.setStartAt(a, CKEDITOR.POSITION_BEFORE_START); b && b.is && b.is("span") && b.data("cke-bookmark") && this.setEndAt(b, CKEDITOR.POSITION_AFTER_END)
                                }, trim: function (a, b) {
                                    var c = this.startContainer, d = this.startOffset, e = this.collapsed; if ((!a || e) && c && c.type == CKEDITOR.NODE_TEXT) {
                                        if (d) if (d >= c.getLength()) d = c.getIndex() + 1, c = c.getParent(); else {
                                            var k = c.split(d), d = c.getIndex() + 1, c = c.getParent(); this.startContainer.equals(this.endContainer) ? this.setEnd(k, this.endOffset - this.startOffset) : c.equals(this.endContainer) &&
                                                (this.endOffset += 1)
                                        } else d = c.getIndex(), c = c.getParent(); this.setStart(c, d); if (e) { this.collapse(!0); return }
                                    } c = this.endContainer; d = this.endOffset; b || e || !c || c.type != CKEDITOR.NODE_TEXT || (d ? (d >= c.getLength() || c.split(d), d = c.getIndex() + 1) : d = c.getIndex(), c = c.getParent(), this.setEnd(c, d))
                                }, enlarge: function (a, b) {
                                    function c(a) { return a && a.type == CKEDITOR.NODE_ELEMENT && a.hasAttribute("contenteditable") ? null : a } var d = new RegExp(/[^\s\ufeff]/); switch (a) {
                                        case CKEDITOR.ENLARGE_INLINE: var e = 1; case CKEDITOR.ENLARGE_ELEMENT: var k =
                                            function (a, b) { var f = new CKEDITOR.dom.range(g); f.setStart(a, b); f.setEndAt(g, CKEDITOR.POSITION_BEFORE_END); var f = new CKEDITOR.dom.walker(f), c; for (f.guard = function (a) { return !(a.type == CKEDITOR.NODE_ELEMENT && a.isBlockBoundary()) }; c = f.next();) { if (c.type != CKEDITOR.NODE_TEXT) return !1; F = c != a ? c.getText() : c.substring(b); if (d.test(F)) return !1 } return !0 }; if (this.collapsed) break; var h = this.getCommonAncestor(), g = this.root, l, m, v, z, y, B = !1, C, F; C = this.startContainer; var G = this.startOffset; C.type == CKEDITOR.NODE_TEXT ?
                                                (G && (C = !CKEDITOR.tools.trim(C.substring(0, G)).length && C, B = !!C), C && ((z = C.getPrevious()) || (v = C.getParent()))) : (G && (z = C.getChild(G - 1) || C.getLast()), z || (v = C)); for (v = c(v); v || z;) {
                                                    if (v && !z) { !y && v.equals(h) && (y = !0); if (e ? v.isBlockBoundary() : !g.contains(v)) break; B && "inline" == v.getComputedStyle("display") || (B = !1, y ? l = v : this.setStartBefore(v)); z = v.getPrevious() } for (; z;)if (C = !1, z.type == CKEDITOR.NODE_COMMENT) z = z.getPrevious(); else {
                                                        if (z.type == CKEDITOR.NODE_TEXT) F = z.getText(), d.test(F) && (z = null), C = /[\s\ufeff]$/.test(F);
                                                        else if ((z.$.offsetWidth > (CKEDITOR.env.webkit ? 1 : 0) || b && z.is("br")) && !z.data("cke-bookmark")) if (B && CKEDITOR.dtd.$removeEmpty[z.getName()]) { F = z.getText(); if (d.test(F)) z = null; else for (var G = z.$.getElementsByTagName("*"), I = 0, H; H = G[I++];)if (!CKEDITOR.dtd.$removeEmpty[H.nodeName.toLowerCase()]) { z = null; break } z && (C = !!F.length) } else z = null; C && (B ? y ? l = v : v && this.setStartBefore(v) : B = !0); if (z) { C = z.getPrevious(); if (!v && !C) { v = z; z = null; break } z = C } else v = null
                                                    } v && (v = c(v.getParent()))
                                                } C = this.endContainer; G = this.endOffset;
                                            v = z = null; y = B = !1; C.type == CKEDITOR.NODE_TEXT ? CKEDITOR.tools.trim(C.substring(G)).length ? B = !0 : (B = !C.getLength(), G == C.getLength() ? (z = C.getNext()) || (v = C.getParent()) : k(C, G) && (v = C.getParent())) : (z = C.getChild(G)) || (v = C); for (; v || z;) {
                                                if (v && !z) { !y && v.equals(h) && (y = !0); if (e ? v.isBlockBoundary() : !g.contains(v)) break; B && "inline" == v.getComputedStyle("display") || (B = !1, y ? m = v : v && this.setEndAfter(v)); z = v.getNext() } for (; z;) {
                                                    C = !1; if (z.type == CKEDITOR.NODE_TEXT) F = z.getText(), k(z, 0) || (z = null), C = /^[\s\ufeff]/.test(F); else if (z.type ==
                                                        CKEDITOR.NODE_ELEMENT) { if ((0 < z.$.offsetWidth || b && z.is("br")) && !z.data("cke-bookmark")) if (B && CKEDITOR.dtd.$removeEmpty[z.getName()]) { F = z.getText(); if (d.test(F)) z = null; else for (G = z.$.getElementsByTagName("*"), I = 0; H = G[I++];)if (!CKEDITOR.dtd.$removeEmpty[H.nodeName.toLowerCase()]) { z = null; break } z && (C = !!F.length) } else z = null } else C = 1; C && B && (y ? m = v : this.setEndAfter(v)); if (z) { C = z.getNext(); if (!v && !C) { v = z; z = null; break } z = C } else v = null
                                                } v && (v = c(v.getParent()))
                                            } l && m && (h = l.contains(m) ? m : l, this.setStartBefore(h),
                                                this.setEndAfter(h)); break; case CKEDITOR.ENLARGE_BLOCK_CONTENTS: case CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS: v = new CKEDITOR.dom.range(this.root); g = this.root; v.setStartAt(g, CKEDITOR.POSITION_AFTER_START); v.setEnd(this.startContainer, this.startOffset); v = new CKEDITOR.dom.walker(v); var D, M, J = CKEDITOR.dom.walker.blockBoundary(a == CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS ? { br: 1 } : null), K = null, E = function (a) {
                                                    if (a.type == CKEDITOR.NODE_ELEMENT && "false" == a.getAttribute("contenteditable")) if (K) { if (K.equals(a)) { K = null; return } } else K =
                                                        a; else if (K) return; var b = J(a); b || (D = a); return b
                                                }, e = function (a) { var b = E(a); !b && a.is && a.is("br") && (M = a); return b }; v.guard = E; v = v.lastBackward(); D = D || g; this.setStartAt(D, !D.is("br") && (!v && this.checkStartOfBlock() || v && D.contains(v)) ? CKEDITOR.POSITION_AFTER_START : CKEDITOR.POSITION_AFTER_END); if (a == CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS) {
                                                    v = this.clone(); v = new CKEDITOR.dom.walker(v); var R = CKEDITOR.dom.walker.whitespaces(), P = CKEDITOR.dom.walker.bookmark(); v.evaluator = function (a) { return !R(a) && !P(a) }; if ((v = v.previous()) &&
                                                        v.type == CKEDITOR.NODE_ELEMENT && v.is("br")) break
                                                } v = this.clone(); v.collapse(); v.setEndAt(g, CKEDITOR.POSITION_BEFORE_END); v = new CKEDITOR.dom.walker(v); v.guard = a == CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS ? e : E; D = K = M = null; v = v.lastForward(); D = D || g; this.setEndAt(D, !v && this.checkEndOfBlock() || v && D.contains(v) ? CKEDITOR.POSITION_BEFORE_END : CKEDITOR.POSITION_BEFORE_START); M && this.setEndAfter(M)
                                    }
                                }, shrink: function (a, b, c) {
                                    var d = "boolean" === typeof c ? c : c && "boolean" === typeof c.shrinkOnBlockBoundary ? c.shrinkOnBlockBoundary :
                                        !0, e = c && c.skipBogus; if (!this.collapsed) {
                                            a = a || CKEDITOR.SHRINK_TEXT; var k = this.clone(), h = this.startContainer, g = this.endContainer, l = this.startOffset, m = this.endOffset, v = c = 1; h && h.type == CKEDITOR.NODE_TEXT && (l ? l >= h.getLength() ? k.setStartAfter(h) : (k.setStartBefore(h), c = 0) : k.setStartBefore(h)); g && g.type == CKEDITOR.NODE_TEXT && (m ? m >= g.getLength() ? k.setEndAfter(g) : (k.setEndAfter(g), v = 0) : k.setEndBefore(g)); var k = new CKEDITOR.dom.walker(k), z = CKEDITOR.dom.walker.bookmark(), y = CKEDITOR.dom.walker.bogus(); k.evaluator =
                                                function (b) { return b.type == (a == CKEDITOR.SHRINK_ELEMENT ? CKEDITOR.NODE_ELEMENT : CKEDITOR.NODE_TEXT) }; var B; k.guard = function (b, c) { if (e && y(b) || z(b)) return !0; if (a == CKEDITOR.SHRINK_ELEMENT && b.type == CKEDITOR.NODE_TEXT || c && b.equals(B) || !1 === d && b.type == CKEDITOR.NODE_ELEMENT && b.isBlockBoundary() || b.type == CKEDITOR.NODE_ELEMENT && b.hasAttribute("contenteditable")) return !1; c || b.type != CKEDITOR.NODE_ELEMENT || (B = b); return !0 }; c && (h = k[a == CKEDITOR.SHRINK_ELEMENT ? "lastForward" : "next"]()) && this.setStartAt(h, b ? CKEDITOR.POSITION_AFTER_START :
                                                    CKEDITOR.POSITION_BEFORE_START); v && (k.reset(), (k = k[a == CKEDITOR.SHRINK_ELEMENT ? "lastBackward" : "previous"]()) && this.setEndAt(k, b ? CKEDITOR.POSITION_BEFORE_END : CKEDITOR.POSITION_AFTER_END)); return !(!c && !v)
                                        }
                                }, insertNode: function (a) { this.optimizeBookmark(); this.trim(!1, !0); var b = this.startContainer, c = b.getChild(this.startOffset); c ? a.insertBefore(c) : b.append(a); a.getParent() && a.getParent().equals(this.endContainer) && this.endOffset++; this.setStartBefore(a) }, moveToPosition: function (a, b) {
                                    this.setStartAt(a,
                                        b); this.collapse(!0)
                                }, moveToRange: function (a) { this.setStart(a.startContainer, a.startOffset); this.setEnd(a.endContainer, a.endOffset) }, selectNodeContents: function (a) { this.setStart(a, 0); this.setEnd(a, a.type == CKEDITOR.NODE_TEXT ? a.getLength() : a.getChildCount()) }, setStart: function (b, c) { b.type == CKEDITOR.NODE_ELEMENT && CKEDITOR.dtd.$empty[b.getName()] && (c = b.getIndex(), b = b.getParent()); this._setStartContainer(b); this.startOffset = c; this.endContainer || (this._setEndContainer(b), this.endOffset = c); a(this) }, setEnd: function (b,
                                    c) { b.type == CKEDITOR.NODE_ELEMENT && CKEDITOR.dtd.$empty[b.getName()] && (c = b.getIndex() + 1, b = b.getParent()); this._setEndContainer(b); this.endOffset = c; this.startContainer || (this._setStartContainer(b), this.startOffset = c); a(this) }, setStartAfter: function (a) { this.setStart(a.getParent(), a.getIndex() + 1) }, setStartBefore: function (a) { this.setStart(a.getParent(), a.getIndex()) }, setEndAfter: function (a) { this.setEnd(a.getParent(), a.getIndex() + 1) }, setEndBefore: function (a) { this.setEnd(a.getParent(), a.getIndex()) }, setStartAt: function (b,
                                        c) { switch (c) { case CKEDITOR.POSITION_AFTER_START: this.setStart(b, 0); break; case CKEDITOR.POSITION_BEFORE_END: b.type == CKEDITOR.NODE_TEXT ? this.setStart(b, b.getLength()) : this.setStart(b, b.getChildCount()); break; case CKEDITOR.POSITION_BEFORE_START: this.setStartBefore(b); break; case CKEDITOR.POSITION_AFTER_END: this.setStartAfter(b) }a(this) }, setEndAt: function (b, c) {
                                            switch (c) {
                                                case CKEDITOR.POSITION_AFTER_START: this.setEnd(b, 0); break; case CKEDITOR.POSITION_BEFORE_END: b.type == CKEDITOR.NODE_TEXT ? this.setEnd(b,
                                                    b.getLength()) : this.setEnd(b, b.getChildCount()); break; case CKEDITOR.POSITION_BEFORE_START: this.setEndBefore(b); break; case CKEDITOR.POSITION_AFTER_END: this.setEndAfter(b)
                                            }a(this)
                                        }, fixBlock: function (a, b) { var c = this.createBookmark(), d = this.document.createElement(b); this.collapse(a); this.enlarge(CKEDITOR.ENLARGE_BLOCK_CONTENTS); this.extractContents().appendTo(d); d.trim(); this.insertNode(d); var e = d.getBogus(); e && e.remove(); d.appendBogus(); this.moveToBookmark(c); return d }, splitBlock: function (a, b) {
                                            var c =
                                                new CKEDITOR.dom.elementPath(this.startContainer, this.root), d = new CKEDITOR.dom.elementPath(this.endContainer, this.root), e = c.block, k = d.block, h = null; if (!c.blockLimit.equals(d.blockLimit)) return null; "br" != a && (e || (e = this.fixBlock(!0, a), k = (new CKEDITOR.dom.elementPath(this.endContainer, this.root)).block), k || (k = this.fixBlock(!1, a))); c = e && this.checkStartOfBlock(); d = k && this.checkEndOfBlock(); this.deleteContents(); e && e.equals(k) && (d ? (h = new CKEDITOR.dom.elementPath(this.startContainer, this.root), this.moveToPosition(k,
                                                    CKEDITOR.POSITION_AFTER_END), k = null) : c ? (h = new CKEDITOR.dom.elementPath(this.startContainer, this.root), this.moveToPosition(e, CKEDITOR.POSITION_BEFORE_START), e = null) : (k = this.splitElement(e, b || !1), e.is("ul", "ol") || e.appendBogus())); return { previousBlock: e, nextBlock: k, wasStartOfBlock: c, wasEndOfBlock: d, elementPath: h }
                                        }, splitElement: function (a, b) {
                                            if (!this.collapsed) return null; this.setEndAt(a, CKEDITOR.POSITION_BEFORE_END); var c = this.extractContents(!1, b || !1), d = a.clone(!1, b || !1); c.appendTo(d); d.insertAfter(a);
                                            this.moveToPosition(a, CKEDITOR.POSITION_AFTER_END); return d
                                        }, removeEmptyBlocksAtEnd: function () {
                                            function a(f) { return function (a) { return b(a) || c(a) || a.type == CKEDITOR.NODE_ELEMENT && a.isEmptyInlineRemoveable() || f.is("table") && a.is("caption") ? !1 : !0 } } var b = CKEDITOR.dom.walker.whitespaces(), c = CKEDITOR.dom.walker.bookmark(!1); return function (b) {
                                                for (var c = this.createBookmark(), d = this[b ? "endPath" : "startPath"](), e = d.block || d.blockLimit, k; e && !e.equals(d.root) && !e.getFirst(a(e));)k = e.getParent(), this[b ? "setEndAt" :
                                                    "setStartAt"](e, CKEDITOR.POSITION_AFTER_END), e.remove(1), e = k; this.moveToBookmark(c)
                                            }
                                        }(), startPath: function () { return new CKEDITOR.dom.elementPath(this.startContainer, this.root) }, endPath: function () { return new CKEDITOR.dom.elementPath(this.endContainer, this.root) }, checkBoundaryOfElement: function (a, c) {
                                            var d = c == CKEDITOR.START, e = this.clone(); e.collapse(d); e[d ? "setStartAt" : "setEndAt"](a, d ? CKEDITOR.POSITION_AFTER_START : CKEDITOR.POSITION_BEFORE_END); e = new CKEDITOR.dom.walker(e); e.evaluator = b(d); return e[d ?
                                                "checkBackward" : "checkForward"]()
                                        }, checkStartOfBlock: function () { var a = this.startContainer, b = this.startOffset; CKEDITOR.env.ie && b && a.type == CKEDITOR.NODE_TEXT && (a = CKEDITOR.tools.ltrim(a.substring(0, b)), l.test(a) && this.trim(0, 1)); this.trim(); a = new CKEDITOR.dom.elementPath(this.startContainer, this.root); b = this.clone(); b.collapse(!0); b.setStartAt(a.block || a.blockLimit, CKEDITOR.POSITION_AFTER_START); a = new CKEDITOR.dom.walker(b); a.evaluator = e(); return a.checkBackward() }, checkEndOfBlock: function () {
                                            var a = this.endContainer,
                                            b = this.endOffset; CKEDITOR.env.ie && a.type == CKEDITOR.NODE_TEXT && (a = CKEDITOR.tools.rtrim(a.substring(b)), l.test(a) && this.trim(1, 0)); this.trim(); a = new CKEDITOR.dom.elementPath(this.endContainer, this.root); b = this.clone(); b.collapse(!1); b.setEndAt(a.block || a.blockLimit, CKEDITOR.POSITION_BEFORE_END); a = new CKEDITOR.dom.walker(b); a.evaluator = e(); return a.checkForward()
                                        }, getPreviousNode: function (a, b, c) {
                                            var d = this.clone(); d.collapse(1); d.setStartAt(c || this.root, CKEDITOR.POSITION_AFTER_START); c = new CKEDITOR.dom.walker(d);
                                            c.evaluator = a; c.guard = b; return c.previous()
                                        }, getNextNode: function (a, b, c) { var d = this.clone(); d.collapse(); d.setEndAt(c || this.root, CKEDITOR.POSITION_BEFORE_END); c = new CKEDITOR.dom.walker(d); c.evaluator = a; c.guard = b; return c.next() }, checkReadOnly: function () {
                                            function a(b, c) { for (; b;) { if (b.type == CKEDITOR.NODE_ELEMENT) { if ("false" == b.getAttribute("contentEditable") && !b.data("cke-editable")) return 0; if (b.is("html") || "true" == b.getAttribute("contentEditable") && (b.contains(c) || b.equals(c))) break } b = b.getParent() } return 1 }
                                            return function () { var b = this.startContainer, c = this.endContainer; return !(a(b, c) && a(c, b)) }
                                        }(), moveToElementEditablePosition: function (a, b) {
                                            if (a.type == CKEDITOR.NODE_ELEMENT && !a.isEditable(!1)) return this.moveToPosition(a, b ? CKEDITOR.POSITION_AFTER_END : CKEDITOR.POSITION_BEFORE_START), !0; for (var c = 0; a;) {
                                                if (a.type == CKEDITOR.NODE_TEXT) {
                                                    b && this.endContainer && this.checkEndOfBlock() && l.test(a.getText()) ? this.moveToPosition(a, CKEDITOR.POSITION_BEFORE_START) : this.moveToPosition(a, b ? CKEDITOR.POSITION_AFTER_END :
                                                        CKEDITOR.POSITION_BEFORE_START); c = 1; break
                                                } if (a.type == CKEDITOR.NODE_ELEMENT) if (a.isEditable()) this.moveToPosition(a, b ? CKEDITOR.POSITION_BEFORE_END : CKEDITOR.POSITION_AFTER_START), c = 1; else if (b && a.is("br") && this.endContainer && this.checkEndOfBlock()) this.moveToPosition(a, CKEDITOR.POSITION_BEFORE_START); else if ("false" == a.getAttribute("contenteditable") && a.is(CKEDITOR.dtd.$block)) return this.setStartBefore(a), this.setEndAfter(a), !0; var d = a, e = c, h = void 0; d.type == CKEDITOR.NODE_ELEMENT && d.isEditable(!1) &&
                                                    (h = d[b ? "getLast" : "getFirst"](k)); e || h || (h = d[b ? "getPrevious" : "getNext"](k)); a = h
                                            } return !!c
                                        }, moveToClosestEditablePosition: function (a, b) {
                                            var c, d = 0, e, k, h = [CKEDITOR.POSITION_AFTER_END, CKEDITOR.POSITION_BEFORE_START]; a ? (c = new CKEDITOR.dom.range(this.root), c.moveToPosition(a, h[b ? 0 : 1])) : c = this.clone(); if (a && !a.is(CKEDITOR.dtd.$block)) d = 1; else if (e = c[b ? "getNextEditableNode" : "getPreviousEditableNode"]()) d = 1, (k = e.type == CKEDITOR.NODE_ELEMENT) && e.is(CKEDITOR.dtd.$block) && "false" == e.getAttribute("contenteditable") ?
                                                (c.setStartAt(e, CKEDITOR.POSITION_BEFORE_START), c.setEndAt(e, CKEDITOR.POSITION_AFTER_END)) : !CKEDITOR.env.needsBrFiller && k && e.is(CKEDITOR.dom.walker.validEmptyBlockContainers) ? (c.setEnd(e, 0), c.collapse()) : c.moveToPosition(e, h[b ? 1 : 0]); d && this.moveToRange(c); return !!d
                                        }, moveToElementEditStart: function (a) { return this.moveToElementEditablePosition(a) }, moveToElementEditEnd: function (a) { return this.moveToElementEditablePosition(a, !0) }, getEnclosedNode: function () {
                                            var a = this.clone(); a.optimize(); if (a.startContainer.type !=
                                                CKEDITOR.NODE_ELEMENT || a.endContainer.type != CKEDITOR.NODE_ELEMENT) return null; var a = new CKEDITOR.dom.walker(a), b = CKEDITOR.dom.walker.bookmark(!1, !0), c = CKEDITOR.dom.walker.whitespaces(!0); a.evaluator = function (a) { return c(a) && b(a) }; var d = a.next(); a.reset(); return d && d.equals(a.previous()) ? d : null
                                        }, getTouchedStartNode: function () { var a = this.startContainer; return this.collapsed || a.type != CKEDITOR.NODE_ELEMENT ? a : a.getChild(this.startOffset) || a }, getTouchedEndNode: function () {
                                            var a = this.endContainer; return this.collapsed ||
                                                a.type != CKEDITOR.NODE_ELEMENT ? a : a.getChild(this.endOffset - 1) || a
                                        }, getNextEditableNode: d(), getPreviousEditableNode: d(1), _getTableElement: function (a) { a = a || { td: 1, th: 1, tr: 1, tbody: 1, thead: 1, tfoot: 1, table: 1 }; var b = this.getTouchedStartNode(), c = this.getTouchedEndNode(), d = b.getAscendant("table", !0), c = c.getAscendant("table", !0); return d && !this.root.contains(d) ? null : this.getEnclosedNode() ? this.getEnclosedNode().getAscendant(a, !0) : d && c && (d.equals(c) || d.contains(c) || c.contains(d)) ? b.getAscendant(a, !0) : null }, scrollIntoView: function () {
                                            var a =
                                                new CKEDITOR.dom.element.createFromHtml("\x3cspan\x3e\x26nbsp;\x3c/span\x3e", this.document), b, c, d, e = this.clone(); e.optimize(); (d = e.startContainer.type == CKEDITOR.NODE_TEXT) ? (c = e.startContainer.getText(), b = e.startContainer.split(e.startOffset), a.insertAfter(e.startContainer)) : e.insertNode(a); a.scrollIntoView(); d && (e.startContainer.setText(c), b.remove()); a.remove()
                                        }, getClientRects: function () {
                                            function a(b, c) {
                                                var f = CKEDITOR.tools.array.map(b, function (a) { return a }), d = new CKEDITOR.dom.range(c.root), e, k,
                                                h; c.startContainer instanceof CKEDITOR.dom.element && (k = 0 === c.startOffset && c.startContainer.hasAttribute("data-widget")); c.endContainer instanceof CKEDITOR.dom.element && (h = (h = c.endOffset === (c.endContainer.getChildCount ? c.endContainer.getChildCount() : c.endContainer.length)) && c.endContainer.hasAttribute("data-widget")); k && d.setStart(c.startContainer.getParent(), c.startContainer.getIndex()); h && d.setEnd(c.endContainer.getParent(), c.endContainer.getIndex() + 1); if (k || h) c = d; d = c.cloneContents().find("[data-cke-widget-id]").toArray();
                                                if (d = CKEDITOR.tools.array.map(d, function (a) { var b = c.root.editor; a = a.getAttribute("data-cke-widget-id"); return b.widgets.instances[a].element })) return d = CKEDITOR.tools.array.map(d, function (a) { var b; b = a.getParent().hasClass("cke_widget_wrapper") ? a.getParent() : a; e = this.root.getDocument().$.createRange(); e.setStart(b.getParent().$, b.getIndex()); e.setEnd(b.getParent().$, b.getIndex() + 1); b = e.getClientRects(); b.widgetRect = a.getClientRect(); return b }, c), CKEDITOR.tools.array.forEach(d, function (a) {
                                                    function b(d) {
                                                        CKEDITOR.tools.array.forEach(f,
                                                            function (b, e) { var k = CKEDITOR.tools.objectCompare(a[d], b); k || (k = CKEDITOR.tools.objectCompare(a.widgetRect, b)); k && (Array.prototype.splice.call(f, e, a.length - d, a.widgetRect), c = !0) }); c || (d < f.length - 1 ? b(d + 1) : f.push(a.widgetRect))
                                                    } var c; b(0)
                                                }), f
                                            } function b(a, c, f) {
                                                var e; c.collapsed ? f.startContainer instanceof CKEDITOR.dom.element ? (a = f.checkStartOfBlock(), e = new CKEDITOR.dom.text("​"), a ? f.startContainer.append(e, !0) : 0 === f.startOffset ? e.insertBefore(f.startContainer.getFirst()) : (f = f.startContainer.getChildren().getItem(f.startOffset -
                                                    1), e.insertAfter(f)), c.setStart(e.$, 0), c.setEnd(e.$, 0), a = c.getClientRects(), e.remove()) : f.startContainer instanceof CKEDITOR.dom.text && ("" === f.startContainer.getText() ? (f.startContainer.setText("​"), a = c.getClientRects(), f.startContainer.setText("")) : a = [d(f.createBookmark())]) : a = [d(f.createBookmark())]; return a
                                            } function c(a, b, f) {
                                                a = CKEDITOR.tools.extend({}, a); b && (a = CKEDITOR.tools.getAbsoluteRectPosition(f.document.getWindow(), a)); !a.width && (a.width = a.right - a.left); !a.height && (a.height = a.bottom - a.top);
                                                return a
                                            } function d(a) { var b = a.startNode; a = a.endNode; var c; b.setText("​"); b.removeStyle("display"); a ? (a.setText("​"), a.removeStyle("display"), c = [b.getClientRect(), a.getClientRect()], a.remove()) : c = [b.getClientRect(), b.getClientRect()]; b.remove(); return { right: Math.max(c[0].right, c[1].right), bottom: Math.max(c[0].bottom, c[1].bottom), left: Math.min(c[0].left, c[1].left), top: Math.min(c[0].top, c[1].top), width: Math.abs(c[0].left - c[1].left), height: Math.max(c[0].bottom, c[1].bottom) - Math.min(c[0].top, c[1].top) } }
                                            return void 0 !== this.document.getSelection ? function (d) { var e = this.root.getDocument().$.createRange(), k; e.setStart(this.startContainer.$, this.startOffset); e.setEnd(this.endContainer.$, this.endOffset); k = e.getClientRects(); k = a(k, this); k.length || (k = b(k, e, this)); return CKEDITOR.tools.array.map(k, function (a) { return c(a, d, this) }, this) } : function (a) { return [c(d(this.createBookmark()), a, this)] }
                                        }(), _setStartContainer: function (a) { this.startContainer = a }, _setEndContainer: function (a) { this.endContainer = a }, _find: function (a,
                                            b) { var c = this.getCommonAncestor(), d = this.getBoundaryNodes(), e = [], k, h, g, l; if (c && c.find) for (h = c.find(a), k = 0; k < h.count(); k++)if (c = h.getItem(k), b || !c.isReadOnly()) g = c.getPosition(d.startNode) & CKEDITOR.POSITION_FOLLOWING || d.startNode.equals(c), l = c.getPosition(d.endNode) & CKEDITOR.POSITION_PRECEDING + CKEDITOR.POSITION_IS_CONTAINED || d.endNode.equals(c), g && l && e.push(c); return e }
                            }; CKEDITOR.dom.range.mergeRanges = function (a) {
                                return CKEDITOR.tools.array.reduce(a, function (a, b) {
                                    var c = a[a.length - 1], f = !1; b = b.clone();
                                    b.enlarge(CKEDITOR.ENLARGE_ELEMENT); if (c) { var d = new CKEDITOR.dom.range(b.root), f = new CKEDITOR.dom.walker(d), e = CKEDITOR.dom.walker.whitespaces(); d.setStart(c.endContainer, c.endOffset); d.setEnd(b.startContainer, b.startOffset); for (d = f.next(); e(d) || b.endContainer.equals(d);)d = f.next(); f = !d } f ? c.setEnd(b.endContainer, b.endOffset) : a.push(b); return a
                                }, [])
                            }
                    })(); CKEDITOR.POSITION_AFTER_START = 1; CKEDITOR.POSITION_BEFORE_END = 2; CKEDITOR.POSITION_BEFORE_START = 3; CKEDITOR.POSITION_AFTER_END = 4; CKEDITOR.ENLARGE_ELEMENT =
                        1; CKEDITOR.ENLARGE_BLOCK_CONTENTS = 2; CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS = 3; CKEDITOR.ENLARGE_INLINE = 4; CKEDITOR.START = 1; CKEDITOR.END = 2; CKEDITOR.SHRINK_ELEMENT = 1; CKEDITOR.SHRINK_TEXT = 2; "use strict"; (function () {
                            function a(a) { 1 > arguments.length || (this.range = a, this.forceBrBreak = 0, this.enlargeBr = 1, this.enforceRealBlocks = 0, this._ || (this._ = {})) } function g(a) { var b = []; a.forEach(function (a) { if ("true" == a.getAttribute("contenteditable")) return b.push(a), !1 }, CKEDITOR.NODE_ELEMENT, !0); return b } function e(a, b, c, d) {
                                a: {
                                    null ==
                                    d && (d = g(c)); for (var h; h = d.shift();)if (h.getDtd().p) { d = { element: h, remaining: d }; break a } d = null
                                } if (!d) return 0; if ((h = CKEDITOR.filter.instances[d.element.data("cke-filter")]) && !h.check(b)) return e(a, b, c, d.remaining); b = new CKEDITOR.dom.range(d.element); b.selectNodeContents(d.element); b = b.createIterator(); b.enlargeBr = a.enlargeBr; b.enforceRealBlocks = a.enforceRealBlocks; b.activeFilter = b.filter = h; a._.nestedEditable = { element: d.element, container: c, remaining: d.remaining, iterator: b }; return 1
                            } function b(a, b, c) {
                                if (!b) return !1;
                                a = a.clone(); a.collapse(!c); return a.checkBoundaryOfElement(b, c ? CKEDITOR.START : CKEDITOR.END)
                            } var d = /^[\r\n\t ]+$/, m = CKEDITOR.dom.walker.bookmark(!1, !0), h = CKEDITOR.dom.walker.whitespaces(!0), l = function (a) { return m(a) && h(a) }, c = { dd: 1, dt: 1, li: 1 }; a.prototype = {
                                getNextParagraph: function (a) {
                                    var f, h, g, t, q; a = a || "p"; if (this._.nestedEditable) {
                                        if (f = this._.nestedEditable.iterator.getNextParagraph(a)) return this.activeFilter = this._.nestedEditable.iterator.activeFilter, f; this.activeFilter = this.filter; if (e(this, a,
                                            this._.nestedEditable.container, this._.nestedEditable.remaining)) return this.activeFilter = this._.nestedEditable.iterator.activeFilter, this._.nestedEditable.iterator.getNextParagraph(a); this._.nestedEditable = null
                                    } if (!this.range.root.getDtd()[a]) return null; if (!this._.started) {
                                        var r = this.range.clone(); h = r.startPath(); var w = r.endPath(), x = !r.collapsed && b(r, h.block), u = !r.collapsed && b(r, w.block, 1); r.shrink(CKEDITOR.SHRINK_ELEMENT, !0); x && r.setStartAt(h.block, CKEDITOR.POSITION_BEFORE_END); u && r.setEndAt(w.block,
                                            CKEDITOR.POSITION_AFTER_START); h = r.endContainer.hasAscendant("pre", !0) || r.startContainer.hasAscendant("pre", !0); r.enlarge(this.forceBrBreak && !h || !this.enlargeBr ? CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS : CKEDITOR.ENLARGE_BLOCK_CONTENTS); r.collapsed || (h = new CKEDITOR.dom.walker(r.clone()), w = CKEDITOR.dom.walker.bookmark(!0, !0), h.evaluator = w, this._.nextNode = h.next(), h = new CKEDITOR.dom.walker(r.clone()), h.evaluator = w, h = h.previous(), this._.lastNode = h.getNextSourceNode(!0, null, r.root), this._.lastNode && this._.lastNode.type ==
                                                CKEDITOR.NODE_TEXT && !CKEDITOR.tools.trim(this._.lastNode.getText()) && this._.lastNode.getParent().isBlockBoundary() && (w = this.range.clone(), w.moveToPosition(this._.lastNode, CKEDITOR.POSITION_AFTER_END), w.checkEndOfBlock() && (w = new CKEDITOR.dom.elementPath(w.endContainer, w.root), this._.lastNode = (w.block || w.blockLimit).getNextSourceNode(!0))), this._.lastNode && r.root.contains(this._.lastNode) || (this._.lastNode = this._.docEndMarker = r.document.createText(""), this._.lastNode.insertAfter(h)), r = null); this._.started =
                                                    1; h = r
                                    } w = this._.nextNode; r = this._.lastNode; for (this._.nextNode = null; w;) {
                                        var x = 0, u = w.hasAscendant("pre"), A = w.type != CKEDITOR.NODE_ELEMENT, v = 0; if (A) w.type == CKEDITOR.NODE_TEXT && d.test(w.getText()) && (A = 0); else {
                                            var z = w.getName(); if (CKEDITOR.dtd.$block[z] && "false" == w.getAttribute("contenteditable")) { f = w; e(this, a, f); break } else if (w.isBlockBoundary(this.forceBrBreak && !u && { br: 1 })) {
                                                if ("br" == z) A = 1; else if (!h && !w.getChildCount() && "hr" != z) { f = w; g = w.equals(r); break } h && (h.setEndAt(w, CKEDITOR.POSITION_BEFORE_START),
                                                    "br" != z && (this._.nextNode = w)); x = 1
                                            } else { if (w.getFirst()) { h || (h = this.range.clone(), h.setStartAt(w, CKEDITOR.POSITION_BEFORE_START)); w = w.getFirst(); continue } A = 1 }
                                        } A && !h && (h = this.range.clone(), h.setStartAt(w, CKEDITOR.POSITION_BEFORE_START)); g = (!x || A) && w.equals(r); if (h && !x) for (; !w.getNext(l) && !g;) { z = w.getParent(); if (z.isBlockBoundary(this.forceBrBreak && !u && { br: 1 })) { x = 1; A = 0; g || z.equals(r); h.setEndAt(z, CKEDITOR.POSITION_BEFORE_END); break } w = z; A = 1; g = w.equals(r); v = 1 } A && h.setEndAt(w, CKEDITOR.POSITION_AFTER_END);
                                        w = this._getNextSourceNode(w, v, r); if ((g = !w) || x && h) break
                                    } if (!f) {
                                        if (!h) return this._.docEndMarker && this._.docEndMarker.remove(), this._.nextNode = null; f = new CKEDITOR.dom.elementPath(h.startContainer, h.root); w = f.blockLimit; x = { div: 1, th: 1, td: 1 }; f = f.block; !f && w && !this.enforceRealBlocks && x[w.getName()] && h.checkStartOfBlock() && h.checkEndOfBlock() && !w.equals(h.root) ? f = w : !f || this.enforceRealBlocks && f.is(c) ? (f = this.range.document.createElement(a), h.extractContents().appendTo(f), f.trim(), h.insertNode(f), t = q = !0) :
                                            "li" != f.getName() ? h.checkStartOfBlock() && h.checkEndOfBlock() || (f = f.clone(!1), h.extractContents().appendTo(f), f.trim(), q = h.splitBlock(), t = !q.wasStartOfBlock, q = !q.wasEndOfBlock, h.insertNode(f)) : g || (this._.nextNode = f.equals(r) ? null : this._getNextSourceNode(h.getBoundaryNodes().endNode, 1, r))
                                    } t && (t = f.getPrevious()) && t.type == CKEDITOR.NODE_ELEMENT && ("br" == t.getName() ? t.remove() : t.getLast() && "br" == t.getLast().$.nodeName.toLowerCase() && t.getLast().remove()); q && (t = f.getLast()) && t.type == CKEDITOR.NODE_ELEMENT &&
                                        "br" == t.getName() && (!CKEDITOR.env.needsBrFiller || t.getPrevious(m) || t.getNext(m)) && t.remove(); this._.nextNode || (this._.nextNode = g || f.equals(r) || !r ? null : this._getNextSourceNode(f, 1, r)); return f
                                }, _getNextSourceNode: function (a, b, c) { function d(a) { return !(a.equals(c) || a.equals(e)) } var e = this.range.root; for (a = a.getNextSourceNode(b, null, d); !m(a);)a = a.getNextSourceNode(b, null, d); return a }
                            }; CKEDITOR.dom.range.prototype.createIterator = function () { return new a(this) }
                        })(); CKEDITOR.command = function (a, g) {
                            this.uiItems =
                            []; this.exec = function (b) { if (this.state == CKEDITOR.TRISTATE_DISABLED || !this.checkAllowed()) return !1; this.editorFocus && a.focus(); return !1 === this.fire("exec") ? !0 : !1 !== g.exec.call(this, a, b) }; this.refresh = function (a, d) {
                                if (!this.readOnly && a.readOnly) return !0; if (this.context && !d.isContextFor(this.context) || !this.checkAllowed(!0)) return this.disable(), !0; this.startDisabled || this.enable(); this.modes && !this.modes[a.mode] && this.disable(); return !1 === this.fire("refresh", { editor: a, path: d }) ? !0 : g.refresh && !1 !== g.refresh.apply(this,
                                    arguments)
                            }; var e; this.checkAllowed = function (b) { return b || "boolean" != typeof e ? e = a.activeFilter.checkFeature(this) : e }; CKEDITOR.tools.extend(this, g, { modes: { wysiwyg: 1 }, editorFocus: 1, contextSensitive: !!g.context, state: CKEDITOR.TRISTATE_DISABLED }); CKEDITOR.event.call(this)
                        }; CKEDITOR.command.prototype = {
                            enable: function () { this.state == CKEDITOR.TRISTATE_DISABLED && this.checkAllowed() && this.setState(this.preserveState && "undefined" != typeof this.previousState ? this.previousState : CKEDITOR.TRISTATE_OFF) }, disable: function () { this.setState(CKEDITOR.TRISTATE_DISABLED) },
                            setState: function (a) { if (this.state == a || a != CKEDITOR.TRISTATE_DISABLED && !this.checkAllowed()) return !1; this.previousState = this.state; this.state = a; this.fire("state"); return !0 }, toggleState: function () { this.state == CKEDITOR.TRISTATE_OFF ? this.setState(CKEDITOR.TRISTATE_ON) : this.state == CKEDITOR.TRISTATE_ON && this.setState(CKEDITOR.TRISTATE_OFF) }
                        }; CKEDITOR.event.implementOn(CKEDITOR.command.prototype); CKEDITOR.ENTER_P = 1; CKEDITOR.ENTER_BR = 2; CKEDITOR.ENTER_DIV = 3; CKEDITOR.config = {
                            customConfig: "config.js", autoUpdateElement: !0,
                            language: "", defaultLanguage: "en", contentsLangDirection: "", enterMode: CKEDITOR.ENTER_P, forceEnterMode: !1, shiftEnterMode: CKEDITOR.ENTER_BR, docType: "\x3c!DOCTYPE html\x3e", bodyId: "", bodyClass: "", fullPage: !1, height: 200, contentsCss: CKEDITOR.getUrl("contents.css"), extraPlugins: "", removePlugins: "", protectedSource: [], tabIndex: 0, width: "", baseFloatZIndex: 1E4, blockedKeystrokes: [CKEDITOR.CTRL + 66, CKEDITOR.CTRL + 73, CKEDITOR.CTRL + 85]
                        }; (function () {
                            function a(a, b, c, f, d) {
                                var e, k; a = []; for (e in b) {
                                    k = b[e]; k = "boolean" ==
                                        typeof k ? {} : "function" == typeof k ? { match: k } : I(k); "$" != e.charAt(0) && (k.elements = e); c && (k.featureName = c.toLowerCase()); var g = k; g.elements = h(g.elements, /\s+/) || null; g.propertiesOnly = g.propertiesOnly || !0 === g.elements; var l = /\s*,\s*/, m = void 0; for (m in M) { g[m] = h(g[m], l) || null; var n = g, z = J[m], w = h(g[J[m]], l), y = g[m], p = [], E = !0, u = void 0; w ? E = !1 : w = {}; for (u in y) "!" == u.charAt(0) && (u = u.slice(1), p.push(u), w[u] = !0, E = !1); for (; u = p.pop();)y[u] = y["!" + u], delete y["!" + u]; n[z] = (E ? !1 : w) || null } g.match = g.match || null; f.push(k);
                                    a.push(k)
                                } b = d.elements; d = d.generic; var P; c = 0; for (f = a.length; c < f; ++c) {
                                    e = I(a[c]); k = !0 === e.classes || !0 === e.styles || !0 === e.attributes; g = e; m = z = l = void 0; for (l in M) g[l] = x(g[l]); n = !0; for (m in J) { l = J[m]; z = g[l]; w = []; y = void 0; for (y in z) -1 < y.indexOf("*") ? w.push(new RegExp("^" + y.replace(/\*/g, ".*") + "$")) : w.push(y); z = w; z.length && (g[l] = z, n = !1) } g.nothingRequired = n; g.noProperties = !(g.attributes || g.classes || g.styles); if (!0 === e.elements || null === e.elements) d[k ? "unshift" : "push"](e); else for (P in g = e.elements, delete e.elements,
                                        g) if (b[P]) b[P][k ? "unshift" : "push"](e); else b[P] = [e]
                                }
                            } function g(a, b, c, f) { if (!a.match || a.match(b)) if (f || l(a, b)) if (a.propertiesOnly || (c.valid = !0), c.allAttributes || (c.allAttributes = e(a.attributes, b.attributes, c.validAttributes)), c.allStyles || (c.allStyles = e(a.styles, b.styles, c.validStyles)), !c.allClasses) { a = a.classes; b = b.classes; f = c.validClasses; if (a) if (!0 === a) a = !0; else { for (var d = 0, k = b.length, h; d < k; ++d)h = b[d], f[h] || (f[h] = a(h)); a = !1 } else a = !1; c.allClasses = a } } function e(a, b, c) {
                                if (!a) return !1; if (!0 === a) return !0;
                                for (var f in b) c[f] || (c[f] = a(f)); return !1
                            } function b(a, b, c) { if (!a.match || a.match(b)) { if (a.noProperties) return !1; c.hadInvalidAttribute = d(a.attributes, b.attributes) || c.hadInvalidAttribute; c.hadInvalidStyle = d(a.styles, b.styles) || c.hadInvalidStyle; a = a.classes; b = b.classes; if (a) { for (var f = !1, e = !0 === a, k = b.length; k--;)if (e || a(b[k])) b.splice(k, 1), f = !0; a = f } else a = !1; c.hadInvalidClass = a || c.hadInvalidClass } } function d(a, b) { if (!a) return !1; var c = !1, f = !0 === a, d; for (d in b) if (f || a(d)) delete b[d], c = !0; return c } function m(a,
                                b, c) { if (a.disabled || a.customConfig && !c || !b) return !1; a._.cachedChecks = {}; return !0 } function h(a, b) { if (!a) return !1; if (!0 === a) return a; if ("string" == typeof a) return a = H(a), "*" == a ? !0 : CKEDITOR.tools.convertArrayToObject(a.split(b)); if (CKEDITOR.tools.isArray(a)) return a.length ? CKEDITOR.tools.convertArrayToObject(a) : !1; var c = {}, f = 0, d; for (d in a) c[d] = a[d], f++; return f ? c : !1 } function l(a, b) {
                                    if (a.nothingRequired) return !0; var f, d, e, k; if (e = a.requiredClasses) for (k = b.classes, f = 0; f < e.length; ++f)if (d = e[f], "string" ==
                                        typeof d) { if (-1 == CKEDITOR.tools.indexOf(k, d)) return !1 } else if (!CKEDITOR.tools.checkIfAnyArrayItemMatches(k, d)) return !1; return c(b.styles, a.requiredStyles) && c(b.attributes, a.requiredAttributes)
                                } function c(a, b) { if (!b) return !0; for (var c = 0, f; c < b.length; ++c)if (f = b[c], "string" == typeof f) { if (!(f in a)) return !1 } else if (!CKEDITOR.tools.checkIfAnyObjectPropertyMatches(a, f)) return !1; return !0 } function k(a) { if (!a) return {}; a = a.split(/\s*,\s*/).sort(); for (var b = {}; a.length;)b[a.shift()] = "cke-test"; return b } function f(a) {
                                    var b,
                                    c, f, d, e = {}, k = 1; for (a = H(a); b = a.match(K);)(c = b[2]) ? (f = n(c, "styles"), d = n(c, "attrs"), c = n(c, "classes")) : f = d = c = null, e["$" + k++] = { elements: b[1], classes: c, styles: f, attributes: d }, a = a.slice(b[0].length); return e
                                } function n(a, b) { var c = a.match(E[b]); return c ? H(c[1]) : null } function p(a) { var b = a.styleBackup = a.attributes.style, c = a.classBackup = a.attributes["class"]; a.styles || (a.styles = CKEDITOR.tools.parseCssText(b || "", 1)); a.classes || (a.classes = c ? c.split(/\s+/) : []) } function t(a, c, f, d) {
                                    var e = 0, k; d.toHtml && (c.name = c.name.replace(R,
                                        "$1")); if (d.doCallbacks && a.elementCallbacks) { a: { k = a.elementCallbacks; for (var h = 0, l = k.length, m; h < l; ++h)if (m = k[h](c)) { k = m; break a } k = void 0 } if (k) return k } if (d.doTransform && (k = a._.transformations[c.name])) { p(c); for (h = 0; h < k.length; ++h)z(a, c, k[h]); r(c) } if (d.doFilter) {
                                            a: {
                                                h = c.name; l = a._; a = l.allowedRules.elements[h]; k = l.allowedRules.generic; h = l.disallowedRules.elements[h]; l = l.disallowedRules.generic; m = d.skipRequired; var n = {
                                                    valid: !1, validAttributes: {}, validClasses: {}, validStyles: {}, allAttributes: !1, allClasses: !1,
                                                    allStyles: !1, hadInvalidAttribute: !1, hadInvalidClass: !1, hadInvalidStyle: !1
                                                }, y, E; if (a || k) { p(c); if (h) for (y = 0, E = h.length; y < E; ++y)if (!1 === b(h[y], c, n)) { a = null; break a } if (l) for (y = 0, E = l.length; y < E; ++y)b(l[y], c, n); if (a) for (y = 0, E = a.length; y < E; ++y)g(a[y], c, n, m); if (k) for (y = 0, E = k.length; y < E; ++y)g(k[y], c, n, m); a = n } else a = null
                                            } if (!a || !a.valid) return f.push(c), 1; E = a.validAttributes; var x = a.validStyles; k = a.validClasses; var h = c.attributes, u = c.styles, l = c.classes; m = c.classBackup; var B = c.styleBackup, H, G, t = [], n = [], C = /^data-cke-/;
                                            y = !1; delete h.style; delete h["class"]; delete c.classBackup; delete c.styleBackup; if (!a.allAttributes) for (H in h) E[H] || (C.test(H) ? H == (G = H.replace(/^data-cke-saved-/, "")) || E[G] || (delete h[H], y = !0) : (delete h[H], y = !0)); if (!a.allStyles || a.hadInvalidStyle) { for (H in u) a.allStyles || x[H] ? t.push(H + ":" + u[H]) : y = !0; t.length && (h.style = t.sort().join("; ")) } else B && (h.style = B); if (!a.allClasses || a.hadInvalidClass) {
                                                for (H = 0; H < l.length; ++H)(a.allClasses || k[l[H]]) && n.push(l[H]); n.length && (h["class"] = n.sort().join(" "));
                                                m && n.length < m.split(/\s+/).length && (y = !0)
                                            } else m && (h["class"] = m); y && (e = 1); if (!d.skipFinalValidation && !w(c)) return f.push(c), 1
                                        } d.toHtml && (c.name = c.name.replace(P, "cke:$1")); return e
                                } function q(a) { var b = [], c; for (c in a) -1 < c.indexOf("*") && b.push(c.replace(/\*/g, ".*")); return b.length ? new RegExp("^(?:" + b.join("|") + ")$") : null } function r(a) { var b = a.attributes, c; delete b.style; delete b["class"]; if (c = CKEDITOR.tools.writeCssText(a.styles, !0)) b.style = c; a.classes.length && (b["class"] = a.classes.sort().join(" ")) }
                            function w(a) { switch (a.name) { case "a": if (!(a.children.length || a.attributes.name || a.attributes.id)) return !1; break; case "img": if (!a.attributes.src) return !1 }return !0 } function x(a) { if (!a) return !1; if (!0 === a) return !0; var b = q(a); return function (c) { return c in a || b && c.match(b) } } function u() { return new CKEDITOR.htmlParser.element("br") } function A(a) { return a.type == CKEDITOR.NODE_ELEMENT && ("br" == a.name || G.$block[a.name]) } function v(a, b, c) {
                                var f = a.name; if (G.$empty[f] || !a.children.length) "hr" == f && "br" == b ? a.replaceWith(u()) :
                                    (a.parent && c.push({ check: "it", el: a.parent }), a.remove()); else if (G.$block[f] || "tr" == f) if ("br" == b) a.previous && !A(a.previous) && (b = u(), b.insertBefore(a)), a.next && !A(a.next) && (b = u(), b.insertAfter(a)), a.replaceWithChildren(); else {
                                        var f = a.children, d; b: { d = G[b]; for (var e = 0, k = f.length, h; e < k; ++e)if (h = f[e], h.type == CKEDITOR.NODE_ELEMENT && !d[h.name]) { d = !1; break b } d = !0 } if (d) a.name = b, a.attributes = {}, c.push({ check: "parent-down", el: a }); else {
                                            d = a.parent; for (var e = d.type == CKEDITOR.NODE_DOCUMENT_FRAGMENT || "body" == d.name,
                                                g, l, k = f.length; 0 < k;)h = f[--k], e && (h.type == CKEDITOR.NODE_TEXT || h.type == CKEDITOR.NODE_ELEMENT && G.$inline[h.name]) ? (g || (g = new CKEDITOR.htmlParser.element(b), g.insertAfter(a), c.push({ check: "parent-down", el: g })), g.add(h, 0)) : (g = null, l = G[d.name] || G.span, h.insertAfter(a), d.type == CKEDITOR.NODE_DOCUMENT_FRAGMENT || h.type != CKEDITOR.NODE_ELEMENT || l[h.name] || c.push({ check: "el-up", el: h })); a.remove()
                                        }
                                    } else f in { style: 1, script: 1 } ? a.remove() : (a.parent && c.push({ check: "it", el: a.parent }), a.replaceWithChildren())
                            } function z(a,
                                b, c) { var f, d; for (f = 0; f < c.length; ++f)if (d = c[f], !(d.check && !a.check(d.check, !1) || d.left && !d.left(b))) { d.right(b, N); break } } function y(a, b) { var c = b.getDefinition(), f = c.attributes, d = c.styles, e, k, h, g; if (a.name != c.element) return !1; for (e in f) if ("class" == e) for (c = f[e].split(/\s+/), h = a.classes.join("|"); g = c.pop();) { if (-1 == h.indexOf(g)) return !1 } else if (a.attributes[e] != f[e]) return !1; for (k in d) if (a.styles[k] != d[k]) return !1; return !0 } function B(a, b) {
                                    var c, f; "string" == typeof a ? c = a : a instanceof CKEDITOR.style ? f =
                                        a : (c = a[0], f = a[1]); return [{ element: c, left: f, right: function (a, c) { c.transform(a, b) } }]
                                } function C(a) { return function (b) { return y(b, a) } } function F(a) { return function (b, c) { c[a](b) } } var G = CKEDITOR.dtd, I = CKEDITOR.tools.copy, H = CKEDITOR.tools.trim, D = ["", "p", "br", "div"]; CKEDITOR.FILTER_SKIP_TREE = 2; CKEDITOR.filter = function (a, b) {
                                    this.allowedContent = []; this.disallowedContent = []; this.elementCallbacks = null; this.disabled = !1; this.editor = null; this.id = CKEDITOR.tools.getNextNumber(); this._ = {
                                        allowedRules: {
                                            elements: {},
                                            generic: []
                                        }, disallowedRules: { elements: {}, generic: [] }, transformations: {}, cachedTests: {}, cachedChecks: {}
                                    }; CKEDITOR.filter.instances[this.id] = this; var c = this.editor = a instanceof CKEDITOR.editor ? a : null; if (c && !b) { this.customConfig = !0; var f = c.config.allowedContent; !0 === f ? this.disabled = !0 : (f || (this.customConfig = !1), this.allow(f, "config", 1), this.allow(c.config.extraAllowedContent, "extra", 1), this.allow(D[c.enterMode] + " " + D[c.shiftEnterMode], "default", 1), this.disallow(c.config.disallowedContent)) } else this.customConfig =
                                        !1, this.allow(b || a, "default", 1)
                                }; CKEDITOR.filter.instances = {}; CKEDITOR.filter.prototype = {
                                    allow: function (b, c, d) {
                                        if (!m(this, b, d)) return !1; var e, k; if ("string" == typeof b) b = f(b); else if (b instanceof CKEDITOR.style) {
                                            if (b.toAllowedContentRules) return this.allow(b.toAllowedContentRules(this.editor), c, d); e = b.getDefinition(); b = {}; d = e.attributes; b[e.element] = e = { styles: e.styles, requiredStyles: e.styles && CKEDITOR.tools.object.keys(e.styles) }; d && (d = I(d), e.classes = d["class"] ? d["class"].split(/\s+/) : null, e.requiredClasses =
                                                e.classes, delete d["class"], e.attributes = d, e.requiredAttributes = d && CKEDITOR.tools.object.keys(d))
                                        } else if (CKEDITOR.tools.isArray(b)) { for (e = 0; e < b.length; ++e)k = this.allow(b[e], c, d); return k } a(this, b, c, this.allowedContent, this._.allowedRules); return !0
                                    }, applyTo: function (a, b, c, f) {
                                        if (this.disabled) return !1; var d = this, e = [], k = this.editor && this.editor.config.protectedSource, h, g = !1, l = { doFilter: !c, doTransform: !0, doCallbacks: !0, toHtml: b }; a.forEach(function (a) {
                                            if (a.type == CKEDITOR.NODE_ELEMENT) {
                                                if ("off" == a.attributes["data-cke-filter"]) return !1;
                                                if (!b || "span" != a.name || !~CKEDITOR.tools.object.keys(a.attributes).join("|").indexOf("data-cke-")) if (h = t(d, a, e, l), h & 1) g = !0; else if (h & 2) return !1
                                            } else if (a.type == CKEDITOR.NODE_COMMENT && a.value.match(/^\{cke_protected\}(?!\{C\})/)) {
                                                var c; a: {
                                                    var f = decodeURIComponent(a.value.replace(/^\{cke_protected\}/, "")); c = []; var m, n, z; if (k) for (n = 0; n < k.length; ++n)if ((z = f.match(k[n])) && z[0].length == f.length) { c = !0; break a } f = CKEDITOR.htmlParser.fragment.fromHtml(f); 1 == f.children.length && (m = f.children[0]).type == CKEDITOR.NODE_ELEMENT &&
                                                        t(d, m, c, l); c = !c.length
                                                } c || e.push(a)
                                            }
                                        }, null, !0); e.length && (g = !0); var m; a = []; f = D[f || (this.editor ? this.editor.enterMode : CKEDITOR.ENTER_P)]; for (var n; c = e.pop();)c.type == CKEDITOR.NODE_ELEMENT ? v(c, f, a) : c.remove(); for (; m = a.pop();)if (c = m.el, c.parent) switch (n = G[c.parent.name] || G.span, m.check) {
                                            case "it": G.$removeEmpty[c.name] && !c.children.length ? v(c, f, a) : w(c) || v(c, f, a); break; case "el-up": c.parent.type == CKEDITOR.NODE_DOCUMENT_FRAGMENT || n[c.name] || v(c, f, a); break; case "parent-down": c.parent.type == CKEDITOR.NODE_DOCUMENT_FRAGMENT ||
                                                n[c.name] || v(c.parent, f, a)
                                        }return g
                                    }, checkFeature: function (a) { if (this.disabled || !a) return !0; a.toFeature && (a = a.toFeature(this.editor)); return !a.requiredContent || this.check(a.requiredContent) }, disable: function () { this.disabled = !0 }, disallow: function (b) { if (!m(this, b, !0)) return !1; "string" == typeof b && (b = f(b)); a(this, b, null, this.disallowedContent, this._.disallowedRules); return !0 }, addContentForms: function (a) {
                                        if (!this.disabled && a) {
                                            var b, c, f = [], d; for (b = 0; b < a.length && !d; ++b)c = a[b], ("string" == typeof c || c instanceof
                                                CKEDITOR.style) && this.check(c) && (d = c); if (d) { for (b = 0; b < a.length; ++b)f.push(B(a[b], d)); this.addTransformations(f) }
                                        }
                                    }, addElementCallback: function (a) { this.elementCallbacks || (this.elementCallbacks = []); this.elementCallbacks.push(a) }, addFeature: function (a) {
                                        if (this.disabled || !a) return !0; a.toFeature && (a = a.toFeature(this.editor)); this.allow(a.allowedContent, a.name); this.addTransformations(a.contentTransformations); this.addContentForms(a.contentForms); return a.requiredContent && (this.customConfig || this.disallowedContent.length) ?
                                            this.check(a.requiredContent) : !0
                                    }, addTransformations: function (a) {
                                        var b, c; if (!this.disabled && a) {
                                            var f = this._.transformations, d; for (d = 0; d < a.length; ++d) {
                                                b = a[d]; var e = void 0, k = void 0, h = void 0, g = void 0, l = void 0, m = void 0; c = []; for (k = 0; k < b.length; ++k)h = b[k], "string" == typeof h ? (h = h.split(/\s*:\s*/), g = h[0], l = null, m = h[1]) : (g = h.check, l = h.left, m = h.right), e || (e = h, e = e.element ? e.element : g ? g.match(/^([a-z0-9]+)/i)[0] : e.left.getDefinition().element), l instanceof CKEDITOR.style && (l = C(l)), c.push({
                                                    check: g == e ? null : g, left: l,
                                                    right: "string" == typeof m ? F(m) : m
                                                }); b = e; f[b] || (f[b] = []); f[b].push(c)
                                            }
                                        }
                                    }, check: function (a, b, c) {
                                        if (this.disabled) return !0; if (CKEDITOR.tools.isArray(a)) { for (var d = a.length; d--;)if (this.check(a[d], b, c)) return !0; return !1 } var e, h; if ("string" == typeof a) {
                                            h = a + "\x3c" + (!1 === b ? "0" : "1") + (c ? "1" : "0") + "\x3e"; if (h in this._.cachedChecks) return this._.cachedChecks[h]; e = f(a).$1; var g = e.styles, d = e.classes; e.name = e.elements; e.classes = d = d ? d.split(/\s*,\s*/) : []; e.styles = k(g); e.attributes = k(e.attributes); e.children = []; d.length &&
                                                (e.attributes["class"] = d.join(" ")); g && (e.attributes.style = CKEDITOR.tools.writeCssText(e.styles))
                                        } else e = a.getDefinition(), g = e.styles, d = e.attributes || {}, g && !CKEDITOR.tools.isEmpty(g) ? (g = I(g), d.style = CKEDITOR.tools.writeCssText(g, !0)) : g = {}, e = { name: e.element, attributes: d, classes: d["class"] ? d["class"].split(/\s+/) : [], styles: g, children: [] }; var g = CKEDITOR.tools.clone(e), l = [], m; if (!1 !== b && (m = this._.transformations[e.name])) { for (d = 0; d < m.length; ++d)z(this, e, m[d]); r(e) } t(this, g, l, {
                                            doFilter: !0, doTransform: !1 !==
                                                b, skipRequired: !c, skipFinalValidation: !c
                                        }); 0 < l.length ? c = !1 : ((b = e.attributes["class"]) && (e.attributes["class"] = e.attributes["class"].split(" ").sort().join(" ")), c = CKEDITOR.tools.objectCompare(e.attributes, g.attributes, !0), b && (e.attributes["class"] = b)); "string" == typeof a && (this._.cachedChecks[h] = c); return c
                                    }, getAllowedEnterMode: function () {
                                        var a = ["p", "div", "br"], b = { p: CKEDITOR.ENTER_P, div: CKEDITOR.ENTER_DIV, br: CKEDITOR.ENTER_BR }; return function (c, f) {
                                            var d = a.slice(), e; if (this.check(D[c])) return c; for (f ||
                                                (d = d.reverse()); e = d.pop();)if (this.check(e)) return b[e]; return CKEDITOR.ENTER_BR
                                        }
                                    }(), clone: function () { var a = new CKEDITOR.filter, b = CKEDITOR.tools.clone; a.allowedContent = b(this.allowedContent); a._.allowedRules = b(this._.allowedRules); a.disallowedContent = b(this.disallowedContent); a._.disallowedRules = b(this._.disallowedRules); a._.transformations = b(this._.transformations); a.disabled = this.disabled; a.editor = this.editor; return a }, destroy: function () {
                                        delete CKEDITOR.filter.instances[this.id]; delete this._; delete this.allowedContent;
                                        delete this.disallowedContent
                                    }
                                }; var M = { styles: 1, attributes: 1, classes: 1 }, J = { styles: "requiredStyles", attributes: "requiredAttributes", classes: "requiredClasses" }, K = /^([a-z0-9\-*\s]+)((?:\s*\{[!\w\-,\s\*]+\}\s*|\s*\[[!\w\-,\s\*]+\]\s*|\s*\([!\w\-,\s\*]+\)\s*){0,3})(?:;\s*|$)/i, E = { styles: /{([^}]+)}/, attrs: /\[([^\]]+)\]/, classes: /\(([^\)]+)\)/ }, R = /^cke:(object|embed|param)$/, P = /^(object|embed|param)$/, N; N = CKEDITOR.filter.transformationsTools = {
                                    sizeToStyle: function (a) {
                                        this.lengthToStyle(a, "width"); this.lengthToStyle(a,
                                            "height")
                                    }, sizeToAttribute: function (a) { this.lengthToAttribute(a, "width"); this.lengthToAttribute(a, "height") }, lengthToStyle: function (a, b, c) { c = c || b; if (!(c in a.styles)) { var f = a.attributes[b]; f && (/^\d+$/.test(f) && (f += "px"), a.styles[c] = f) } delete a.attributes[b] }, lengthToAttribute: function (a, b, c) { c = c || b; if (!(c in a.attributes)) { var f = a.styles[b], d = f && f.match(/^(\d+)(?:\.\d*)?px$/); d ? a.attributes[c] = d[1] : "cke-test" == f && (a.attributes[c] = "cke-test") } delete a.styles[b] }, alignmentToStyle: function (a) {
                                        if (!("float" in
                                            a.styles)) { var b = a.attributes.align; if ("left" == b || "right" == b) a.styles["float"] = b } delete a.attributes.align
                                    }, alignmentToAttribute: function (a) { if (!("align" in a.attributes)) { var b = a.styles["float"]; if ("left" == b || "right" == b) a.attributes.align = b } delete a.styles["float"] }, splitBorderShorthand: function (a) {
                                        if (a.styles.border) {
                                            var b = CKEDITOR.tools.style.parse.border(a.styles.border); b.color && (a.styles["border-color"] = b.color); b.style && (a.styles["border-style"] = b.style); b.width && (a.styles["border-width"] = b.width);
                                            delete a.styles.border
                                        }
                                    }, listTypeToStyle: function (a) { if (a.attributes.type) switch (a.attributes.type) { case "a": a.styles["list-style-type"] = "lower-alpha"; break; case "A": a.styles["list-style-type"] = "upper-alpha"; break; case "i": a.styles["list-style-type"] = "lower-roman"; break; case "I": a.styles["list-style-type"] = "upper-roman"; break; case "1": a.styles["list-style-type"] = "decimal"; break; default: a.styles["list-style-type"] = a.attributes.type } }, splitMarginShorthand: function (a) {
                                        function b(f) {
                                            a.styles["margin-top"] =
                                            c[f[0]]; a.styles["margin-right"] = c[f[1]]; a.styles["margin-bottom"] = c[f[2]]; a.styles["margin-left"] = c[f[3]]
                                        } if (a.styles.margin) { var c = a.styles.margin.match(/(\-?[\.\d]+\w+)/g) || ["0px"]; switch (c.length) { case 1: b([0, 0, 0, 0]); break; case 2: b([0, 1, 0, 1]); break; case 3: b([0, 1, 2, 1]); break; case 4: b([0, 1, 2, 3]) }delete a.styles.margin }
                                    }, matchesStyle: y, transform: function (a, b) {
                                        if ("string" == typeof b) a.name = b; else {
                                            var c = b.getDefinition(), f = c.styles, d = c.attributes, e, k, h, g; a.name = c.element; for (e in d) if ("class" == e) for (c =
                                                a.classes.join("|"), h = d[e].split(/\s+/); g = h.pop();)-1 == c.indexOf(g) && a.classes.push(g); else a.attributes[e] = d[e]; for (k in f) a.styles[k] = f[k]
                                        }
                                    }
                                }
                        })(); (function () {
                            CKEDITOR.focusManager = function (a) { if (a.focusManager) return a.focusManager; this.hasFocus = !1; this.currentActive = null; this._ = { editor: a }; return this }; CKEDITOR.focusManager._ = { blurDelay: 200 }; CKEDITOR.focusManager.prototype = {
                                focus: function (a) {
                                    this._.timer && clearTimeout(this._.timer); a && (this.currentActive = a); this.hasFocus || this._.locked || ((a = CKEDITOR.currentInstance) &&
                                        a.focusManager.blur(1), this.hasFocus = !0, (a = this._.editor.container) && a.addClass("cke_focus"), this._.editor.fire("focus"))
                                }, lock: function () { this._.locked = 1 }, unlock: function () { delete this._.locked }, blur: function (a) {
                                    function g() { if (this.hasFocus) { this.hasFocus = !1; var a = this._.editor.container; a && a.removeClass("cke_focus"); this._.editor.fire("blur") } } if (!this._.locked) {
                                        this._.timer && clearTimeout(this._.timer); var e = CKEDITOR.focusManager._.blurDelay; a || !e ? g.call(this) : this._.timer = CKEDITOR.tools.setTimeout(function () {
                                            delete this._.timer;
                                            g.call(this)
                                        }, e, this)
                                    }
                                }, add: function (a, g) { var e = a.getCustomData("focusmanager"); if (!e || e != this) { e && e.remove(a); var e = "focus", b = "blur"; g && (CKEDITOR.env.ie ? (e = "focusin", b = "focusout") : CKEDITOR.event.useCapture = 1); var d = { blur: function () { a.equals(this.currentActive) && this.blur() }, focus: function () { this.focus(a) } }; a.on(e, d.focus, this); a.on(b, d.blur, this); g && (CKEDITOR.event.useCapture = 0); a.setCustomData("focusmanager", this); a.setCustomData("focusmanager_handlers", d) } }, remove: function (a) {
                                    a.removeCustomData("focusmanager");
                                    var g = a.removeCustomData("focusmanager_handlers"); a.removeListener("blur", g.blur); a.removeListener("focus", g.focus)
                                }
                            }
                        })(); CKEDITOR.keystrokeHandler = function (a) { if (a.keystrokeHandler) return a.keystrokeHandler; this.keystrokes = {}; this.blockedKeystrokes = {}; this._ = { editor: a }; return this }; (function () {
                            var a, g = function (b) {
                                b = b.data; var d = b.getKeystroke(), e = this.keystrokes[d], h = this._.editor; a = !1 === h.fire("key", { keyCode: d, domEvent: b }); a || (e && (a = !1 !== h.execCommand(e, { from: "keystrokeHandler" })), a || (a = !!this.blockedKeystrokes[d]));
                                a && b.preventDefault(!0); return !a
                            }, e = function (b) { a && (a = !1, b.data.preventDefault(!0)) }; CKEDITOR.keystrokeHandler.prototype = { attach: function (a) { a.on("keydown", g, this); if (CKEDITOR.env.gecko && CKEDITOR.env.mac) a.on("keypress", e, this) } }
                        })(); (function () {
                            CKEDITOR.lang = {
                                languages: {
                                    af: 1, ar: 1, az: 1, bg: 1, bn: 1, bs: 1, ca: 1, cs: 1, cy: 1, da: 1, de: 1, "de-ch": 1, el: 1, "en-au": 1, "en-ca": 1, "en-gb": 1, en: 1, eo: 1, es: 1, "es-mx": 1, et: 1, eu: 1, fa: 1, fi: 1, fo: 1, "fr-ca": 1, fr: 1, gl: 1, gu: 1, he: 1, hi: 1, hr: 1, hu: 1, id: 1, is: 1, it: 1, ja: 1, ka: 1, km: 1, ko: 1,
                                    ku: 1, lt: 1, lv: 1, mk: 1, mn: 1, ms: 1, nb: 1, nl: 1, no: 1, oc: 1, pl: 1, "pt-br": 1, pt: 1, ro: 1, ru: 1, si: 1, sk: 1, sl: 1, sq: 1, "sr-latn": 1, sr: 1, sv: 1, th: 1, tr: 1, tt: 1, ug: 1, uk: 1, vi: 1, "zh-cn": 1, zh: 1
                                }, rtl: { ar: 1, fa: 1, he: 1, ku: 1, ug: 1 }, load: function (a, g, e) { a && CKEDITOR.lang.languages[a] || (a = this.detect(g, a)); var b = this; g = function () { b[a].dir = b.rtl[a] ? "rtl" : "ltr"; e(a, b[a]) }; this[a] ? g() : CKEDITOR.scriptLoader.load(CKEDITOR.getUrl("lang/" + a + ".js"), g, this) }, detect: function (a, g) {
                                    var e = this.languages; g = g || navigator.userLanguage || navigator.language ||
                                        a; var b = g.toLowerCase().match(/([a-z]+)(?:-([a-z]+))?/), d = b[1], b = b[2]; e[d + "-" + b] ? d = d + "-" + b : e[d] || (d = null); CKEDITOR.lang.detect = d ? function () { return d } : function (a) { return a }; return d || a
                                }
                            }
                        })(); CKEDITOR.scriptLoader = function () {
                            var a = {}, g = {}; return {
                                load: function (e, b, d, m) {
                                    var h = "string" == typeof e; h && (e = [e]); d || (d = CKEDITOR); var l = e.length, c = [], k = [], f = function (a) { b && (h ? b.call(d, a) : b.call(d, c, k)) }; if (0 === l) f(!0); else {
                                        var n = function (a, b) {
                                            (b ? c : k).push(a); 0 >= --l && (m && CKEDITOR.document.getDocumentElement().removeStyle("cursor"),
                                                f(b))
                                        }, p = function (b, c) { a[b] = 1; var f = g[b]; delete g[b]; for (var d = 0; d < f.length; d++)f[d](b, c) }, t = function (c) {
                                            if (a[c]) n(c, !0); else {
                                                var f = g[c] || (g[c] = []); f.push(n); if (!(1 < f.length)) {
                                                    var d = new CKEDITOR.dom.element("script"); d.setAttributes({ type: "text/javascript", src: c }); b && (CKEDITOR.env.ie && (8 >= CKEDITOR.env.version || CKEDITOR.env.ie9Compat) ? d.$.onreadystatechange = function () { if ("loaded" == d.$.readyState || "complete" == d.$.readyState) d.$.onreadystatechange = null, p(c, !0) } : (d.$.onload = function () {
                                                        setTimeout(function () {
                                                            d.$.onload =
                                                            null; d.$.onerror = null; p(c, !0)
                                                        }, 0)
                                                    }, d.$.onerror = function () { d.$.onload = null; d.$.onerror = null; p(c, !1) })); d.appendTo(CKEDITOR.document.getHead())
                                                }
                                            }
                                        }; m && CKEDITOR.document.getDocumentElement().setStyle("cursor", "wait"); for (var q = 0; q < l; q++)t(e[q])
                                    }
                                }, queue: function () { function a() { var d; (d = b[0]) && this.load(d.scriptUrl, d.callback, CKEDITOR, 0) } var b = []; return function (d, g) { var h = this; b.push({ scriptUrl: d, callback: function () { g && g.apply(this, arguments); b.shift(); a.call(h) } }); 1 == b.length && a.call(this) } }()
                            }
                        }(); CKEDITOR.resourceManager =
                            function (a, g) { this.basePath = a; this.fileName = g; this.registered = {}; this.loaded = {}; this.externals = {}; this._ = { waitingList: {} } }; CKEDITOR.resourceManager.prototype = {
                                add: function (a, g) { if (this.registered[a]) throw Error('[CKEDITOR.resourceManager.add] The resource name "' + a + '" is already registered.'); var e = this.registered[a] = g || {}; e.name = a; e.path = this.getPath(a); CKEDITOR.fire(a + CKEDITOR.tools.capitalize(this.fileName) + "Ready", e); return this.get(a) }, get: function (a) { return this.registered[a] || null }, getPath: function (a) {
                                    var g =
                                        this.externals[a]; return CKEDITOR.getUrl(g && g.dir || this.basePath + a + "/")
                                }, getFilePath: function (a) { var g = this.externals[a]; return CKEDITOR.getUrl(this.getPath(a) + (g ? g.file : this.fileName + ".js")) }, addExternal: function (a, g, e) { e || (g = g.replace(/[^\/]+$/, function (a) { e = a; return "" })); e = e || this.fileName + ".js"; a = a.split(","); for (var b = 0; b < a.length; b++)this.externals[a[b]] = { dir: g, file: e } }, load: function (a, g, e) {
                                    CKEDITOR.tools.isArray(a) || (a = a ? [a] : []); for (var b = this.loaded, d = this.registered, m = [], h = {}, l = {}, c = 0; c <
                                        a.length; c++) { var k = a[c]; if (k) if (b[k] || d[k]) l[k] = this.get(k); else { var f = this.getFilePath(k); m.push(f); f in h || (h[f] = []); h[f].push(k) } } CKEDITOR.scriptLoader.load(m, function (a, c) { if (c.length) throw Error('[CKEDITOR.resourceManager.load] Resource name "' + h[c[0]].join(",") + '" was not found at "' + c[0] + '".'); for (var f = 0; f < a.length; f++)for (var d = h[a[f]], k = 0; k < d.length; k++) { var m = d[k]; l[m] = this.get(m); b[m] = 1 } g.call(e, l) }, this)
                                }
                            }; CKEDITOR.plugins = new CKEDITOR.resourceManager("plugins/", "plugin"); CKEDITOR.plugins.load =
                                CKEDITOR.tools.override(CKEDITOR.plugins.load, function (a) {
                                    var g = {}; return function (e, b, d) {
                                        var m = {}, h = function (e) {
                                            a.call(this, e, function (a) {
                                                CKEDITOR.tools.extend(m, a); var e = [], f; for (f in a) {
                                                    var l = a[f], p = l && l.requires; if (!g[f]) { if (l.icons) for (var t = l.icons.split(","), q = t.length; q--;)CKEDITOR.skin.addIcon(t[q], l.path + "icons/" + (CKEDITOR.env.hidpi && l.hidpi ? "hidpi/" : "") + t[q] + ".png"); l.isSupportedEnvironment = l.isSupportedEnvironment || function () { return !0 }; g[f] = 1 } if (p) for (p.split && (p = p.split(",")), l = 0; l < p.length; l++)m[p[l]] ||
                                                        e.push(p[l])
                                                } if (e.length) h.call(this, e); else { for (f in m) l = m[f], l.onLoad && !l.onLoad._called && (!1 === l.onLoad() && delete m[f], l.onLoad._called = 1); b && b.call(d || window, m) }
                                            }, this)
                                        }; h.call(this, e)
                                    }
                                }); CKEDITOR.plugins.setLang = function (a, g, e) { var b = this.get(a); a = b.langEntries || (b.langEntries = {}); b = b.lang || (b.lang = []); b.split && (b = b.split(",")); -1 == CKEDITOR.tools.indexOf(b, g) && b.push(g); a[g] = e }; CKEDITOR.ui = function (a) { if (a.ui) return a.ui; this.items = {}; this.instances = {}; this.editor = a; this._ = { handlers: {} }; return this };
        CKEDITOR.ui.prototype = {
            add: function (a, g, e) { e.name = a.toLowerCase(); var b = this.items[a] = { type: g, command: e.command || null, args: Array.prototype.slice.call(arguments, 2) }; CKEDITOR.tools.extend(b, e) }, get: function (a) { return this.instances[a] }, create: function (a) { var g = this.items[a], e = g && this._.handlers[g.type], b = g && g.command && this.editor.getCommand(g.command), e = e && e.create.apply(this, g.args); this.instances[a] = e; b && b.uiItems.push(e); e && !e.type && (e.type = g.type); return e }, addHandler: function (a, g) {
                this._.handlers[a] =
                g
            }, space: function (a) { return CKEDITOR.document.getById(this.spaceId(a)) }, spaceId: function (a) { return this.editor.id + "_" + a }
        }; CKEDITOR.event.implementOn(CKEDITOR.ui); (function () {
            function a(a, c, f) {
                CKEDITOR.event.call(this); a = a && CKEDITOR.tools.clone(a); if (void 0 !== c) {
                    if (!(c instanceof CKEDITOR.dom.element)) throw Error("Expect element of type CKEDITOR.dom.element."); if (!f) throw Error("One of the element modes must be specified."); if (CKEDITOR.env.ie && CKEDITOR.env.quirks && f == CKEDITOR.ELEMENT_MODE_INLINE) throw Error("Inline element mode is not supported on IE quirks.");
                    if (!e(c, f)) throw Error('The specified element mode is not supported on element: "' + c.getName() + '".'); this.element = c; this.elementMode = f; this.name = this.elementMode != CKEDITOR.ELEMENT_MODE_APPENDTO && (c.getId() || c.getNameAtt())
                } else this.elementMode = CKEDITOR.ELEMENT_MODE_NONE; this._ = {}; this.commands = {}; this.templates = {}; this.name = this.name || g(); this.id = CKEDITOR.tools.getNextId(); this.status = "unloaded"; this.config = CKEDITOR.tools.prototypedCopy(CKEDITOR.config); this.ui = new CKEDITOR.ui(this); this.focusManager =
                    new CKEDITOR.focusManager(this); this.keystrokeHandler = new CKEDITOR.keystrokeHandler(this); this.on("readOnly", b); this.on("selectionChange", function (a) { m(this, a.data.path) }); this.on("activeFilterChange", function () { m(this, this.elementPath(), !0) }); this.on("mode", b); CKEDITOR.dom.selection.setupEditorOptimization(this); this.on("instanceReady", function () {
                        if (this.config.startupFocus) {
                            if ("end" === this.config.startupFocus) {
                                var a = this.createRange(); a.selectNodeContents(this.editable()); a.shrink(CKEDITOR.SHRINK_ELEMENT,
                                    !0); a.collapse(); this.getSelection().selectRanges([a])
                            } this.focus()
                        }
                    }); CKEDITOR.fire("instanceCreated", null, this); CKEDITOR.add(this); CKEDITOR.tools.setTimeout(function () { this.isDestroyed() || this.isDetached() || l(this, a) }, 0, this)
            } function g() { do var a = "editor" + ++q; while (CKEDITOR.instances[a]); return a } function e(a, b) { return b == CKEDITOR.ELEMENT_MODE_INLINE ? a.is(CKEDITOR.dtd.$editable) || a.is("textarea") : b == CKEDITOR.ELEMENT_MODE_REPLACE ? !a.is(CKEDITOR.dtd.$nonBodyContent) : 1 } function b() {
                var a = this.commands,
                b; for (b in a) d(this, a[b])
            } function d(a, b) { b[b.startDisabled ? "disable" : a.readOnly && !b.readOnly ? "disable" : b.modes[a.mode] ? "enable" : "disable"]() } function m(a, b, c) { if (b) { var f, d, e = a.commands; for (d in e) f = e[d], (c || f.contextSensitive) && f.refresh(a, b) } } function h(a) {
                var b = a.config.customConfig; if (!b) return !1; var b = CKEDITOR.getUrl(b), c = r[b] || (r[b] = {}); c.fn ? (c.fn.call(a, a.config), CKEDITOR.getUrl(a.config.customConfig) != b && h(a) || a.fireOnce("customConfigLoaded")) : CKEDITOR.scriptLoader.queue(b, function () {
                    c.fn =
                    CKEDITOR.editorConfig ? CKEDITOR.editorConfig : function () { }; h(a)
                }); return !0
            } function l(a, b) {
                a.on("customConfigLoaded", function () {
                    if (b) { if (b.on) for (var f in b.on) a.on(f, b.on[f]); CKEDITOR.tools.extend(a.config, b, !0); delete a.config.on } f = a.config; a.readOnly = f.readOnly ? !0 : a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ? a.element.is("textarea") ? a.element.hasAttribute("disabled") || a.element.hasAttribute("readonly") : a.element.isReadOnly() : a.elementMode == CKEDITOR.ELEMENT_MODE_REPLACE ? a.element.hasAttribute("disabled") ||
                        a.element.hasAttribute("readonly") : !1; a.blockless = a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ? !(a.element.is("textarea") || CKEDITOR.dtd[a.element.getName()].p) : !1; a.tabIndex = f.tabIndex || a.element && a.element.getAttribute("tabindex") || 0; a.activeEnterMode = a.enterMode = a.blockless ? CKEDITOR.ENTER_BR : f.enterMode; a.activeShiftEnterMode = a.shiftEnterMode = a.blockless ? CKEDITOR.ENTER_BR : f.shiftEnterMode; f.skin && (CKEDITOR.skinName = f.skin); a.fireOnce("configLoaded"); a.dataProcessor = new CKEDITOR.htmlDataProcessor(a);
                    a.filter = a.activeFilter = new CKEDITOR.filter(a); c(a)
                }); b && null != b.customConfig && (a.config.customConfig = b.customConfig); h(a) || a.fireOnce("customConfigLoaded")
            } function c(a) { CKEDITOR.skin.loadPart("editor", function () { k(a) }) } function k(a) {
                CKEDITOR.lang.load(a.config.language, a.config.defaultLanguage, function (b, c) {
                    var d = a.config.title; a.langCode = b; a.lang = CKEDITOR.tools.prototypedCopy(c); a.title = "string" == typeof d || !1 === d ? d : [a.lang.editor, a.name].join(", "); a.config.contentsLangDirection || (a.config.contentsLangDirection =
                        a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ? a.element.getDirection(1) : a.lang.dir); a.fire("langLoaded"); f(a)
                })
            } function f(a) { a.getStylesSet(function (b) { a.once("loaded", function () { a.fire("stylesSet", { styles: b }) }, null, null, 1); n(a) }) } function n(a) {
                function b(a) { if (!a) return ""; CKEDITOR.tools.isArray(a) && (a = a.join(",")); return a.replace(/\s/g, "") } var c = a.config, f = b(c.plugins), d = b(c.extraPlugins), e = b(c.removePlugins); if (d) var k = new RegExp("(?:^|,)(?:" + d.replace(/,/g, "|") + ")(?\x3d,|$)", "g"), f = f.replace(k,
                    ""), f = f + ("," + d); if (e) var h = new RegExp("(?:^|,)(?:" + e.replace(/,/g, "|") + ")(?\x3d,|$)", "g"), f = f.replace(h, ""); CKEDITOR.env.air && (f += ",adobeair"); CKEDITOR.plugins.load(f.split(","), function (b) {
                        var f = [], d = [], e = []; a.plugins = CKEDITOR.tools.extend({}, a.plugins, b); for (var k in b) {
                            var g = b[k], l = g.lang, m = null, n = g.requires, z; CKEDITOR.tools.isArray(n) && (n = n.join(",")); if (n && (z = n.match(h))) for (; n = z.pop();)CKEDITOR.error("editor-plugin-required", { plugin: n.replace(",", ""), requiredBy: k }); l && !a.lang[k] && (l.split &&
                                (l = l.split(",")), 0 <= CKEDITOR.tools.indexOf(l, a.langCode) ? m = a.langCode : (m = a.langCode.replace(/-.*/, ""), m = m != a.langCode && 0 <= CKEDITOR.tools.indexOf(l, m) ? m : 0 <= CKEDITOR.tools.indexOf(l, "en") ? "en" : l[0]), g.langEntries && g.langEntries[m] ? (a.lang[k] = g.langEntries[m], m = null) : e.push(CKEDITOR.getUrl(g.path + "lang/" + m + ".js"))); d.push(m); f.push(g)
                        } CKEDITOR.scriptLoader.load(e, function () {
                            if (!a.isDestroyed() && !a.isDetached()) {
                                for (var b = ["beforeInit", "init", "afterInit"], e = 0; e < b.length; e++)for (var k = 0; k < f.length; k++) {
                                    var h =
                                        f[k]; 0 === e && d[k] && h.lang && h.langEntries && (a.lang[h.name] = h.langEntries[d[k]]); if (h[b[e]]) h[b[e]](a)
                                } a.fireOnce("pluginsLoaded"); c.keystrokes && a.setKeystroke(a.config.keystrokes); for (k = 0; k < a.config.blockedKeystrokes.length; k++)a.keystrokeHandler.blockedKeystrokes[a.config.blockedKeystrokes[k]] = 1; a.status = "loaded"; a.fireOnce("loaded"); CKEDITOR.fire("instanceLoaded", null, a)
                            }
                        })
                    })
            } function p() {
                var a = this.element; if (a && this.elementMode != CKEDITOR.ELEMENT_MODE_APPENDTO) {
                    var b = this.getData(); this.config.htmlEncodeOutput &&
                        (b = CKEDITOR.tools.htmlEncode(b)); a.is("textarea") ? a.setValue(b) : a.setHtml(b); return !0
                } return !1
            } function t(a, b) {
                function c(a) { var b = a.startContainer, f = a.endContainer; return b.is && (b.is("tr") || b.is("td") && b.equals(f) && a.endOffset === b.getChildCount()) ? !0 : !1 } function f(a) { var b = a.startContainer; return b.is("tr") ? a.cloneContents() : b.clone(!0) } for (var d = new CKEDITOR.dom.documentFragment, e, k, h, g = 0; g < a.length; g++) {
                    var l = a[g], m = l.startContainer.getAscendant("tr", !0); c(l) ? (e || (e = m.getAscendant("table").clone(),
                        e.append(m.getAscendant({ thead: 1, tbody: 1, tfoot: 1 }).clone()), d.append(e), e = e.findOne("thead, tbody, tfoot")), k && k.equals(m) || (k = m, h = m.clone(), e.append(h)), h.append(f(l))) : d.append(l.cloneContents())
                } return e ? d : b.getHtmlFromRange(a[0])
            } a.prototype = CKEDITOR.editor.prototype; CKEDITOR.editor = a; var q = 0, r = {}; CKEDITOR.tools.extend(CKEDITOR.editor.prototype, {
                plugins: {
                    detectConflict: function (a, b) {
                        for (var c = 0; c < b.length; c++) {
                            var f = b[c]; if (this[f]) return CKEDITOR.warn("editor-plugin-conflict", { plugin: a, replacedWith: f }),
                                !0
                        } return !1
                    }
                }, addCommand: function (a, b) { b.name = a.toLowerCase(); var c = b instanceof CKEDITOR.command ? b : new CKEDITOR.command(this, b); this.mode && d(this, c); return this.commands[a] = c }, _attachToForm: function () {
                    function a(b) { c.updateElement(); c._.required && !f.getValue() && !1 === c.fire("required") && b.data.preventDefault() } function b(a) { return !!(a && a.call && a.apply) } var c = this, f = c.element, d = new CKEDITOR.dom.element(f.$.form); f.is("textarea") && d && (d.on("submit", a), b(d.$.submit) && (d.$.submit = CKEDITOR.tools.override(d.$.submit,
                        function (b) { return function () { a(); b.apply ? b.apply(this) : b() } })), c.on("destroy", function () { d.removeListener("submit", a) }))
                }, destroy: function (a) {
                    var b = CKEDITOR.filter.instances, c = this; this.fire("beforeDestroy"); !a && p.call(this); this.editable(null); this.filter && delete this.filter; CKEDITOR.tools.array.forEach(CKEDITOR.tools.object.keys(b), function (a) { a = b[a]; c === a.editor && a.destroy() }); delete this.activeFilter; this.status = "destroyed"; this.fire("destroy"); this.removeAllListeners(); CKEDITOR.remove(this);
                    CKEDITOR.fire("instanceDestroyed", null, this)
                }, elementPath: function (a) { if (!a) { a = this.getSelection(); if (!a) return null; a = a.getStartElement() } return a ? new CKEDITOR.dom.elementPath(a, this.editable()) : null }, createRange: function () { var a = this.editable(); return a ? new CKEDITOR.dom.range(a) : null }, execCommand: function (a, b) {
                    var c = this.getCommand(a), f = { name: a, commandData: b || {}, command: c }; return c && c.state != CKEDITOR.TRISTATE_DISABLED && !1 !== this.fire("beforeCommandExec", f) && (f.returnValue = c.exec(f.commandData),
                        !c.async && !1 !== this.fire("afterCommandExec", f)) ? f.returnValue : !1
                }, getCommand: function (a) { return this.commands[a] }, getData: function (a) { !a && this.fire("beforeGetData"); var b = this._.data; "string" != typeof b && (b = (b = this.element) && this.elementMode == CKEDITOR.ELEMENT_MODE_REPLACE ? b.is("textarea") ? b.getValue() : b.getHtml() : ""); b = { dataValue: b }; !a && this.fire("getData", b); return b.dataValue }, getSnapshot: function () {
                    var a = this.fire("getSnapshot"); "string" != typeof a && (a = (a = this.element) && this.elementMode == CKEDITOR.ELEMENT_MODE_REPLACE ?
                        a.is("textarea") ? a.getValue() : a.getHtml() : ""); return a
                }, loadSnapshot: function (a) { this.fire("loadSnapshot", a) }, setData: function (a, b, c) { var f = !0, d = b; b && "object" == typeof b && (c = b.internal, d = b.callback, f = !b.noSnapshot); !c && f && this.fire("saveSnapshot"); if (d || !c) this.once("dataReady", function (a) { !c && f && this.fire("saveSnapshot"); d && d.call(a.editor) }); a = { dataValue: a }; !c && this.fire("setData", a); this._.data = a.dataValue; !c && this.fire("afterSetData", a) }, setReadOnly: function (a) {
                    a = null == a || a; this.readOnly != a && (this.readOnly =
                        a, this.keystrokeHandler.blockedKeystrokes[8] = +a, this.editable().setReadOnly(a), this.fire("readOnly"))
                }, insertHtml: function (a, b, c) { this.fire("insertHtml", { dataValue: a, mode: b, range: c }) }, insertText: function (a) { this.fire("insertText", a) }, insertElement: function (a) { this.fire("insertElement", a) }, getSelectedHtml: function (a) { var b = this.editable(), c = this.getSelection(), c = c && c.getRanges(); if (!b || !c || 0 === c.length) return null; b = t(c, b); return a ? b.getHtml() : b }, extractSelectedHtml: function (a, b) {
                    var c = this.editable(),
                    f = this.getSelection().getRanges(), d = new CKEDITOR.dom.documentFragment, e; if (!c || 0 === f.length) return null; for (e = 0; e < f.length; e++)d.append(c.extractHtmlFromRange(f[e], b)); b || this.getSelection().selectRanges([f[0]]); return a ? d.getHtml() : d
                }, focus: function () { this.fire("beforeFocus") }, checkDirty: function () { return "ready" == this.status && this._.previousValue !== this.getSnapshot() }, resetDirty: function () { this._.previousValue = this.getSnapshot() }, updateElement: function () { return p.call(this) }, setKeystroke: function () {
                    for (var a =
                        this.keystrokeHandler.keystrokes, b = CKEDITOR.tools.isArray(arguments[0]) ? arguments[0] : [[].slice.call(arguments, 0)], c, f, d = b.length; d--;)c = b[d], f = 0, CKEDITOR.tools.isArray(c) && (f = c[1], c = c[0]), f ? a[c] = f : delete a[c]
                }, getCommandKeystroke: function (a, b) { var c = "string" === typeof a ? this.getCommand(a) : a, f = []; if (c) { var d = CKEDITOR.tools.object.findKey(this.commands, c), e = this.keystrokeHandler.keystrokes; if (c.fakeKeystroke) f.push(c.fakeKeystroke); else for (var k in e) e[k] === d && f.push(k) } return b ? f : f[0] || null }, addFeature: function (a) { return this.filter.addFeature(a) },
                setActiveFilter: function (a) { a || (a = this.filter); this.activeFilter !== a && (this.activeFilter = a, this.fire("activeFilterChange"), a === this.filter ? this.setActiveEnterMode(null, null) : this.setActiveEnterMode(a.getAllowedEnterMode(this.enterMode), a.getAllowedEnterMode(this.shiftEnterMode, !0))) }, setActiveEnterMode: function (a, b) {
                    a = a ? this.blockless ? CKEDITOR.ENTER_BR : a : this.enterMode; b = b ? this.blockless ? CKEDITOR.ENTER_BR : b : this.shiftEnterMode; if (this.activeEnterMode != a || this.activeShiftEnterMode != b) this.activeEnterMode =
                        a, this.activeShiftEnterMode = b, this.fire("activeEnterModeChange")
                }, showNotification: function (a) { alert(a) }, isDetached: function () { return !!this.container && this.container.isDetached() }, isDestroyed: function () { return "destroyed" === this.status }
            }); CKEDITOR.editor._getEditorElement = function (a) {
                if (!CKEDITOR.env.isCompatible) return null; var b = CKEDITOR.dom.element.get(a); return b ? b.getEditor() ? (CKEDITOR.error("editor-element-conflict", { editorName: b.getEditor().name }), null) : b : (CKEDITOR.error("editor-incorrect-element",
                    { element: a }), null)
            }
        })(); CKEDITOR.ELEMENT_MODE_NONE = 0; CKEDITOR.ELEMENT_MODE_REPLACE = 1; CKEDITOR.ELEMENT_MODE_APPENDTO = 2; CKEDITOR.ELEMENT_MODE_INLINE = 3; CKEDITOR.htmlParser = function () { this._ = { htmlPartsRegex: /<(?:(?:\/([^>]+)>)|(?:!--([\S|\s]*?)--\x3e)|(?:([^\/\s>]+)((?:\s+[\w\-:.]+(?:\s*=\s*?(?:(?:"[^"]*")|(?:'[^']*')|[^\s"'\/>]+))?)*)[\S\s]*?(\/?)>))/g } }; (function () {
            var a = /([\w\-:.]+)(?:(?:\s*=\s*(?:(?:"([^"]*)")|(?:'([^']*)')|([^\s>]+)))|(?=\s|$))/g, g = {
                checked: 1, compact: 1, declare: 1, defer: 1, disabled: 1,
                ismap: 1, multiple: 1, nohref: 1, noresize: 1, noshade: 1, nowrap: 1, readonly: 1, selected: 1
            }; CKEDITOR.htmlParser.prototype = {
                onTagOpen: function () { }, onTagClose: function () { }, onText: function () { }, onCDATA: function () { }, onComment: function () { }, parse: function (e) {
                    for (var b, d, m = 0, h; b = this._.htmlPartsRegex.exec(e);) {
                        d = b.index; if (d > m) if (m = e.substring(m, d), h) h.push(m); else this.onText(m); m = this._.htmlPartsRegex.lastIndex; if (d = b[1]) if (d = d.toLowerCase(), h && CKEDITOR.dtd.$cdata[d] && (this.onCDATA(h.join("")), h = null), !h) {
                            this.onTagClose(d);
                            continue
                        } if (h) h.push(b[0]); else if (d = b[3]) { if (d = d.toLowerCase(), !/="/.test(d)) { var l = {}, c, k = b[4]; b = !!b[5]; if (k) for (; c = a.exec(k);) { var f = c[1].toLowerCase(); c = c[2] || c[3] || c[4] || ""; l[f] = !c && g[f] ? f : CKEDITOR.tools.htmlDecodeAttr(c) } this.onTagOpen(d, l, b); !h && CKEDITOR.dtd.$cdata[d] && (h = []) } } else if (d = b[2]) this.onComment(d)
                    } if (e.length > m) this.onText(e.substring(m, e.length))
                }
            }
        })(); CKEDITOR.htmlParser.basicWriter = CKEDITOR.tools.createClass({
            $: function () { this._ = { output: [] } }, proto: {
                openTag: function (a) {
                    this._.output.push("\x3c",
                        a)
                }, openTagClose: function (a, g) { g ? this._.output.push(" /\x3e") : this._.output.push("\x3e") }, attribute: function (a, g) { "string" == typeof g && (g = CKEDITOR.tools.htmlEncodeAttr(g)); this._.output.push(" ", a, '\x3d"', g, '"') }, closeTag: function (a) { this._.output.push("\x3c/", a, "\x3e") }, text: function (a) { this._.output.push(a) }, comment: function (a) { this._.output.push("\x3c!--", a, "--\x3e") }, write: function (a) { this._.output.push(a) }, reset: function () { this._.output = []; this._.indent = !1 }, getHtml: function (a) {
                    var g = this._.output.join("");
                    a && this.reset(); return g
                }
            }
        }); "use strict"; (function () {
            CKEDITOR.htmlParser.node = function () { }; CKEDITOR.htmlParser.node.prototype = {
                remove: function () { var a = this.parent.children, g = CKEDITOR.tools.indexOf(a, this), e = this.previous, b = this.next; e && (e.next = b); b && (b.previous = e); a.splice(g, 1); this.parent = null }, replaceWith: function (a) { var g = this.parent.children, e = CKEDITOR.tools.indexOf(g, this), b = a.previous = this.previous, d = a.next = this.next; b && (b.next = a); d && (d.previous = a); g[e] = a; a.parent = this.parent; this.parent = null },
                insertAfter: function (a) { var g = a.parent.children, e = CKEDITOR.tools.indexOf(g, a), b = a.next; g.splice(e + 1, 0, this); this.next = a.next; this.previous = a; a.next = this; b && (b.previous = this); this.parent = a.parent }, insertBefore: function (a) { var g = a.parent.children, e = CKEDITOR.tools.indexOf(g, a); g.splice(e, 0, this); this.next = a; (this.previous = a.previous) && (a.previous.next = this); a.previous = this; this.parent = a.parent }, getAscendant: function (a) {
                    var g = "function" == typeof a ? a : "string" == typeof a ? function (b) { return b.name == a } : function (b) {
                        return b.name in
                            a
                    }, e = this.parent; for (; e && e.type == CKEDITOR.NODE_ELEMENT;) { if (g(e)) return e; e = e.parent } return null
                }, wrapWith: function (a) { this.replaceWith(a); a.add(this); return a }, getIndex: function () { return CKEDITOR.tools.indexOf(this.parent.children, this) }, getFilterContext: function (a) { return a || {} }
            }
        })(); "use strict"; CKEDITOR.htmlParser.comment = function (a) { this.value = a; this._ = { isBlockLike: !1 } }; CKEDITOR.htmlParser.comment.prototype = CKEDITOR.tools.extend(new CKEDITOR.htmlParser.node, {
            type: CKEDITOR.NODE_COMMENT, filter: function (a,
                g) { var e = this.value; if (!(e = a.onComment(g, e, this))) return this.remove(), !1; if ("string" != typeof e) return this.replaceWith(e), !1; this.value = e; return !0 }, writeHtml: function (a, g) { g && this.filter(g); a.comment(this.value) }
        }); "use strict"; (function () {
            CKEDITOR.htmlParser.text = function (a) { this.value = a; this._ = { isBlockLike: !1 } }; CKEDITOR.htmlParser.text.prototype = CKEDITOR.tools.extend(new CKEDITOR.htmlParser.node, {
                type: CKEDITOR.NODE_TEXT, filter: function (a, g) {
                    if (!(this.value = a.onText(g, this.value, this))) return this.remove(),
                        !1
                }, writeHtml: function (a, g) { g && this.filter(g); a.text(this.value) }
            })
        })(); "use strict"; (function () { CKEDITOR.htmlParser.cdata = function (a) { this.value = a }; CKEDITOR.htmlParser.cdata.prototype = CKEDITOR.tools.extend(new CKEDITOR.htmlParser.node, { type: CKEDITOR.NODE_TEXT, filter: function () { }, writeHtml: function (a) { a.write(this.value) } }) })(); "use strict"; CKEDITOR.htmlParser.fragment = function () { this.children = []; this.parent = null; this._ = { isBlockLike: !0, hasInlineStarted: !1 } }; (function () {
            function a(a) {
                return a.attributes["data-cke-survive"] ?
                    !1 : "a" == a.name && a.attributes.href || CKEDITOR.dtd.$removeEmpty[a.name]
            } var g = CKEDITOR.tools.extend({ table: 1, ul: 1, ol: 1, dl: 1 }, CKEDITOR.dtd.table, CKEDITOR.dtd.ul, CKEDITOR.dtd.ol, CKEDITOR.dtd.dl), e = { ol: 1, ul: 1 }, b = CKEDITOR.tools.extend({}, { html: 1 }, CKEDITOR.dtd.html, CKEDITOR.dtd.body, CKEDITOR.dtd.head, { style: 1, script: 1 }), d = { ul: "li", ol: "li", dl: "dd", table: "tbody", tbody: "tr", thead: "tr", tfoot: "tr", tr: "td" }; CKEDITOR.htmlParser.fragment.fromHtml = function (m, h, l) {
                function c(a) {
                    var b; if (0 < w.length) for (var c = 0; c < w.length; c++) {
                        var f =
                            w[c], d = f.name, e = CKEDITOR.dtd[d], h = u.name && CKEDITOR.dtd[u.name]; h && !h[d] || a && e && !e[a] && CKEDITOR.dtd[a] ? d == u.name && (n(u, u.parent, 1), c--) : (b || (k(), b = 1), f = f.clone(), f.parent = u, u = f, w.splice(c, 1), c--)
                    }
                } function k() { for (; x.length;)n(x.shift(), u) } function f(a) { if (a._.isBlockLike && "pre" != a.name && "textarea" != a.name) { var b = a.children.length, c = a.children[b - 1], f; c && c.type == CKEDITOR.NODE_TEXT && ((f = CKEDITOR.tools.rtrim(c.value)) ? c.value = f : a.children.length = b - 1) } } function n(b, c, d) {
                    c = c || u || r; var e = u; void 0 === b.previous &&
                        (p(c, b) && (u = c, q.onTagOpen(l, {}), b.returnPoint = c = u), f(b), a(b) && !b.children.length || c.add(b), "pre" == b.name && (v = !1), "textarea" == b.name && (A = !1)); b.returnPoint ? (u = b.returnPoint, delete b.returnPoint) : u = d ? c : e
                } function p(a, b) { if ((a == r || "body" == a.name) && l && (!a.name || CKEDITOR.dtd[a.name][l])) { var c, f; return (c = b.attributes && (f = b.attributes["data-cke-real-element-type"]) ? f : b.name) && c in CKEDITOR.dtd.$inline && !(c in CKEDITOR.dtd.head) && !b.isOrphan || b.type == CKEDITOR.NODE_TEXT } } function t(a, b) {
                    return a in CKEDITOR.dtd.$listItem ||
                        a in CKEDITOR.dtd.$tableContent ? a == b || "dt" == a && "dd" == b || "dd" == a && "dt" == b : !1
                } var q = new CKEDITOR.htmlParser, r = h instanceof CKEDITOR.htmlParser.element ? h : "string" == typeof h ? new CKEDITOR.htmlParser.element(h) : new CKEDITOR.htmlParser.fragment, w = [], x = [], u = r, A = "textarea" == r.name, v = "pre" == r.name; q.onTagOpen = function (f, d, h, l) {
                    d = new CKEDITOR.htmlParser.element(f, d); d.isUnknown && h && (d.isEmpty = !0); d.isOptionalClose = l; if (a(d)) w.push(d); else {
                        if ("pre" == f) v = !0; else {
                            if ("br" == f && v) {
                                u.add(new CKEDITOR.htmlParser.text("\n"));
                                return
                            } "textarea" == f && (A = !0)
                        } if ("br" == f) x.push(d); else {
                            for (; !(l = (h = u.name) ? CKEDITOR.dtd[h] || (u._.isBlockLike ? CKEDITOR.dtd.div : CKEDITOR.dtd.span) : b, d.isUnknown || u.isUnknown || l[f]);)if (u.isOptionalClose) q.onTagClose(h); else if (f in e && h in e) h = u.children, (h = h[h.length - 1]) && "li" == h.name || n(h = new CKEDITOR.htmlParser.element("li"), u), !d.returnPoint && (d.returnPoint = u), u = h; else if (f in CKEDITOR.dtd.$listItem && !t(f, h)) q.onTagOpen("li" == f ? "ul" : "dl", {}, 0, 1); else if (h in g && !t(f, h)) !d.returnPoint && (d.returnPoint =
                                u), u = u.parent; else if (h in CKEDITOR.dtd.$inline && w.unshift(u), u.parent) n(u, u.parent, 1); else { d.isOrphan = 1; break } c(f); k(); d.parent = u; d.isEmpty ? n(d) : u = d
                        }
                    }
                }; q.onTagClose = function (a) { for (var b = w.length - 1; 0 <= b; b--)if (a == w[b].name) { w.splice(b, 1); return } for (var c = [], f = [], d = u; d != r && d.name != a;)d._.isBlockLike || f.unshift(d), c.push(d), d = d.returnPoint || d.parent; if (d != r) { for (b = 0; b < c.length; b++) { var e = c[b]; n(e, e.parent) } u = d; d._.isBlockLike && k(); n(d, d.parent); d == u && (u = u.parent); w = w.concat(f) } "body" == a && (l = !1) }; q.onText =
                    function (a) { if (!(u._.hasInlineStarted && !x.length || v || A) && (a = CKEDITOR.tools.ltrim(a), 0 === a.length)) return; var f = u.name, e = f ? CKEDITOR.dtd[f] || (u._.isBlockLike ? CKEDITOR.dtd.div : CKEDITOR.dtd.span) : b; if (!A && !e["#"] && f in g) q.onTagOpen(d[f] || ""), q.onText(a); else { k(); c(); v || A || (a = a.replace(/[\t\r\n ]{2,}|[\t\r\n]/g, " ")); a = new CKEDITOR.htmlParser.text(a); if (p(u, a)) this.onTagOpen(l, {}, 0, 1); u.add(a) } }; q.onCDATA = function (a) { u.add(new CKEDITOR.htmlParser.cdata(a)) }; q.onComment = function (a) { k(); c(); u.add(new CKEDITOR.htmlParser.comment(a)) };
                q.parse(m); for (k(); u != r;)n(u, u.parent, 1); f(r); return r
            }; CKEDITOR.htmlParser.fragment.prototype = {
                type: CKEDITOR.NODE_DOCUMENT_FRAGMENT, add: function (a, b) {
                    isNaN(b) && (b = this.children.length); var d = 0 < b ? this.children[b - 1] : null; if (d) { if (a._.isBlockLike && d.type == CKEDITOR.NODE_TEXT && (d.value = CKEDITOR.tools.rtrim(d.value), 0 === d.value.length)) { this.children.pop(); this.add(a); return } d.next = a } a.previous = d; a.parent = this; this.children.splice(b, 0, a); this._.hasInlineStarted || (this._.hasInlineStarted = a.type == CKEDITOR.NODE_TEXT ||
                        a.type == CKEDITOR.NODE_ELEMENT && !a._.isBlockLike)
                }, filter: function (a, b) { b = this.getFilterContext(b); a.onRoot(b, this); this.filterChildren(a, !1, b) }, filterChildren: function (a, b, d) { if (this.childrenFilteredBy != a.id) { d = this.getFilterContext(d); if (b && !this.parent) a.onRoot(d, this); this.childrenFilteredBy = a.id; for (b = 0; b < this.children.length; b++)!1 === this.children[b].filter(a, d) && b-- } }, writeHtml: function (a, b) { b && this.filter(b); this.writeChildrenHtml(a) }, writeChildrenHtml: function (a, b, d) {
                    var c = this.getFilterContext();
                    if (d && !this.parent && b) b.onRoot(c, this); b && this.filterChildren(b, !1, c); b = 0; d = this.children; for (c = d.length; b < c; b++)d[b].writeHtml(a)
                }, forEach: function (a, b, d) { if (!(d || b && this.type != b)) var c = a(this); if (!1 !== c) { d = this.children; for (var e = 0; e < d.length; e++)c = d[e], c.type == CKEDITOR.NODE_ELEMENT ? c.forEach(a, b) : b && c.type != b || a(c) } }, getFilterContext: function (a) { return a || {} }
            }
        })(); "use strict"; (function () {
            function a() { this.rules = [] } function g(e, b, d, g) { var h, l; for (h in b) (l = e[h]) || (l = e[h] = new a), l.add(b[h], d, g) }
            CKEDITOR.htmlParser.filter = CKEDITOR.tools.createClass({
                $: function (e) { this.id = CKEDITOR.tools.getNextNumber(); this.elementNameRules = new a; this.attributeNameRules = new a; this.elementsRules = {}; this.attributesRules = {}; this.textRules = new a; this.commentRules = new a; this.rootRules = new a; e && this.addRules(e, 10) }, proto: {
                    addRules: function (a, b) {
                        var d; "number" == typeof b ? d = b : b && "priority" in b && (d = b.priority); "number" != typeof d && (d = 10); "object" != typeof b && (b = {}); a.elementNames && this.elementNameRules.addMany(a.elementNames,
                            d, b); a.attributeNames && this.attributeNameRules.addMany(a.attributeNames, d, b); a.elements && g(this.elementsRules, a.elements, d, b); a.attributes && g(this.attributesRules, a.attributes, d, b); a.text && this.textRules.add(a.text, d, b); a.comment && this.commentRules.add(a.comment, d, b); a.root && this.rootRules.add(a.root, d, b)
                    }, applyTo: function (a) { a.filter(this) }, onElementName: function (a, b) { return this.elementNameRules.execOnName(a, b) }, onAttributeName: function (a, b) { return this.attributeNameRules.execOnName(a, b) }, onText: function (a,
                        b, d) { return this.textRules.exec(a, b, d) }, onComment: function (a, b, d) { return this.commentRules.exec(a, b, d) }, onRoot: function (a, b) { return this.rootRules.exec(a, b) }, onElement: function (a, b) { for (var d = [this.elementsRules["^"], this.elementsRules[b.name], this.elementsRules.$], g, h = 0; 3 > h; h++)if (g = d[h]) { g = g.exec(a, b, this); if (!1 === g) return null; if (g && g != b) return this.onNode(a, g); if (b.parent && !b.name) break } return b }, onNode: function (a, b) {
                            var d = b.type; return d == CKEDITOR.NODE_ELEMENT ? this.onElement(a, b) : d == CKEDITOR.NODE_TEXT ?
                                new CKEDITOR.htmlParser.text(this.onText(a, b.value, b)) : d == CKEDITOR.NODE_COMMENT ? new CKEDITOR.htmlParser.comment(this.onComment(a, b.value, b)) : null
                        }, onAttribute: function (a, b, d, g) { return (d = this.attributesRules[d]) ? d.exec(a, g, b, this) : g }
                }
            }); CKEDITOR.htmlParser.filterRulesGroup = a; a.prototype = {
                add: function (a, b, d) { this.rules.splice(this.findIndex(b), 0, { value: a, priority: b, options: d }) }, addMany: function (a, b, d) {
                    for (var g = [this.findIndex(b), 0], h = 0, l = a.length; h < l; h++)g.push({ value: a[h], priority: b, options: d }); this.rules.splice.apply(this.rules,
                        g)
                }, findIndex: function (a) { for (var b = this.rules, d = b.length - 1; 0 <= d && a < b[d].priority;)d--; return d + 1 }, exec: function (a, b) {
                    var d = b instanceof CKEDITOR.htmlParser.node || b instanceof CKEDITOR.htmlParser.fragment, g = Array.prototype.slice.call(arguments, 1), h = this.rules, l = h.length, c, k, f, n; for (n = 0; n < l; n++)if (d && (c = b.type, k = b.name), f = h[n], !(a.nonEditable && !f.options.applyToAll || a.nestedEditable && f.options.excludeNestedEditable)) {
                        f = f.value.apply(null, g); if (!1 === f || d && f && (f.name != k || f.type != c)) return f; null != f &&
                            (g[0] = b = f)
                    } return b
                }, execOnName: function (a, b) { for (var d = 0, g = this.rules, h = g.length, l; b && d < h; d++)l = g[d], a.nonEditable && !l.options.applyToAll || a.nestedEditable && l.options.excludeNestedEditable || (b = b.replace(l.value[0], l.value[1])); return b }
            }
        })(); (function () {
            function a(a, c) {
                function f(a) { return a || CKEDITOR.env.needsNbspFiller ? new CKEDITOR.htmlParser.text(" ") : new CKEDITOR.htmlParser.element("br", { "data-cke-bogus": 1 }) } function k(a, c) {
                    return function (d) {
                        if (d.type != CKEDITOR.NODE_DOCUMENT_FRAGMENT) {
                            var k =
                                [], h = e(d), l, z; if (h) for (g(h, 1) && k.push(h); h;)m(h) && (l = b(h)) && g(l) && ((z = b(l)) && !m(z) ? k.push(l) : (f(n).insertAfter(l), l.remove())), h = h.previous; for (h = 0; h < k.length; h++)k[h].remove(); if (k = !a || !1 !== ("function" == typeof c ? c(d) : c)) n || CKEDITOR.env.needsBrFiller || d.type != CKEDITOR.NODE_DOCUMENT_FRAGMENT ? n || CKEDITOR.env.needsBrFiller || !(7 < document.documentMode || d.name in CKEDITOR.dtd.tr || d.name in CKEDITOR.dtd.$listItem) ? (k = e(d), k = !k || "form" == d.name && "input" == k.name) : k = !1 : k = !1; k && d.add(f(a))
                        }
                    }
                } function g(a, b) {
                    if ((!n ||
                        CKEDITOR.env.needsBrFiller) && a.type == CKEDITOR.NODE_ELEMENT && "br" == a.name && !a.attributes["data-cke-eol"]) return !0; var c; return a.type == CKEDITOR.NODE_TEXT && (c = a.value.match(x)) && (c.index && ((new CKEDITOR.htmlParser.text(a.value.substring(0, c.index))).insertBefore(a), a.value = c[0]), !CKEDITOR.env.needsBrFiller && n && (!b || a.parent.name in E) || !n && ((c = a.previous) && "br" == c.name || !c || m(c))) ? !0 : !1
                } var l = { elements: {} }, n = "html" == c, E = CKEDITOR.tools.extend({}, z), p; for (p in E) "#" in A[p] || delete E[p]; for (p in E) l.elements[p] =
                    k(n, a.config.fillEmptyBlocks); l.root = k(n, !1); l.elements.br = function (a) { return function (c) { if (c.parent.type != CKEDITOR.NODE_DOCUMENT_FRAGMENT) { var e = c.attributes; if ("data-cke-bogus" in e || "data-cke-eol" in e) delete e["data-cke-bogus"]; else { for (e = c.next; e && d(e);)e = e.next; var k = b(c); !e && m(c.parent) ? h(c.parent, f(a)) : m(e) && k && !m(k) && f(a).insertBefore(e) } } } }(n); return l
            } function g(a, b) { return a != CKEDITOR.ENTER_BR && !1 !== b ? a == CKEDITOR.ENTER_DIV ? "div" : "p" : !1 } function e(a) {
                for (a = a.children[a.children.length - 1]; a &&
                    d(a);)a = a.previous; return a
            } function b(a) { for (a = a.previous; a && d(a);)a = a.previous; return a } function d(a) { return a.type == CKEDITOR.NODE_TEXT && !CKEDITOR.tools.trim(a.value) || a.type == CKEDITOR.NODE_ELEMENT && a.attributes["data-cke-bookmark"] } function m(a) { return a && (a.type == CKEDITOR.NODE_ELEMENT && a.name in z || a.type == CKEDITOR.NODE_DOCUMENT_FRAGMENT) } function h(a, b) { var c = a.children[a.children.length - 1]; a.children.push(b); b.parent = a; c && (c.next = b, b.previous = c) } function l(a) {
                a = a.attributes; "false" != a.contenteditable &&
                    (a["data-cke-editable"] = a.contenteditable ? "true" : 1); a.contenteditable = "false"
            } function c(a) { a = a.attributes; switch (a["data-cke-editable"]) { case "true": a.contenteditable = "true"; break; case "1": delete a.contenteditable } } function k(a) { return a.replace(G, function (a, b, c) { return "\x3c" + b + c.replace(I, function (a, b) { return H.test(b) && -1 == c.indexOf("data-cke-saved-" + b) ? " data-cke-saved-" + a + " data-cke-" + CKEDITOR.rnd + "-" + a : a }) + "\x3e" }) } function f(a, b) {
                return a.replace(b, function (a, b, c) {
                    0 === a.indexOf("\x3ctextarea") &&
                    (a = b + t(c).replace(/</g, "\x26lt;").replace(/>/g, "\x26gt;") + "\x3c/textarea\x3e"); return "\x3ccke:encoded\x3e" + encodeURIComponent(a) + "\x3c/cke:encoded\x3e"
                })
            } function n(a) { return a.replace(J, function (a, b) { return decodeURIComponent(b) }) } function p(a) { return a.replace(/\x3c!--(?!{cke_protected})[\s\S]+?--\x3e/g, function (a) { return "\x3c!--" + u + "{C}" + encodeURIComponent(a).replace(/--/g, "%2D%2D") + "--\x3e" }) } function t(a) { return a.replace(/\x3c!--\{cke_protected\}\{C\}([\s\S]+?)--\x3e/g, function (a, b) { return decodeURIComponent(b) }) }
            function q(a, b) { var c = b._.dataStore; return a.replace(/\x3c!--\{cke_protected\}([\s\S]+?)--\x3e/g, function (a, b) { return decodeURIComponent(b) }).replace(/\{cke_protected_(\d+)\}/g, function (a, b) { return c && c[b] || "" }) } function r(a, b) {
                var c = [], f = b.config.protectedSource, d = b._.dataStore || (b._.dataStore = { id: 1 }), e = /<\!--\{cke_temp(comment)?\}(\d*?)--\x3e/g, f = [/<script[\s\S]*?(<\/script>|$)/gi, /<noscript[\s\S]*?<\/noscript>/gi, /<meta[\s\S]*?\/?>/gi].concat(f); a = a.replace(/\x3c!--[\s\S]*?--\x3e/g, function (a) {
                    return "\x3c!--{cke_tempcomment}" +
                        (c.push(a) - 1) + "--\x3e"
                }); for (var k = 0; k < f.length; k++)a = a.replace(f[k], function (a) { a = a.replace(e, function (a, b, f) { return c[f] }); return /cke_temp(comment)?/.test(a) ? a : "\x3c!--{cke_temp}" + (c.push(a) - 1) + "--\x3e" }); a = a.replace(e, function (a, b, f) { return "\x3c!--" + u + (b ? "{C}" : "") + encodeURIComponent(c[f]).replace(/--/g, "%2D%2D") + "--\x3e" }); a = a.replace(/<\w+(?:\s+(?:(?:[^\s=>]+\s*=\s*(?:[^'"\s>]+|'[^']*'|"[^"]*"))|[^\s=\/>]+))+\s*\/?>/g, function (a) {
                    return a.replace(/\x3c!--\{cke_protected\}([^>]*)--\x3e/g, function (a,
                        b) { d[d.id] = decodeURIComponent(b); return "{cke_protected_" + d.id++ + "}" })
                }); return a = a.replace(/<(title|iframe|textarea)([^>]*)>([\s\S]*?)<\/\1>/g, function (a, c, f, d) { return "\x3c" + c + f + "\x3e" + q(t(d), b) + "\x3c/" + c + "\x3e" })
            } var w; CKEDITOR.htmlDataProcessor = function (b) {
                var c, d, e = this; this.editor = b; this.dataFilter = c = new CKEDITOR.htmlParser.filter; this.htmlFilter = d = new CKEDITOR.htmlParser.filter; this.writer = new CKEDITOR.htmlParser.basicWriter; c.addRules(y); c.addRules(B, { applyToAll: !0 }); c.addRules(a(b, "data"),
                    { applyToAll: !0 }); d.addRules(C); d.addRules(F, { applyToAll: !0 }); d.addRules(a(b, "html"), { applyToAll: !0 }); b.on("toHtml", function (a) {
                        a = a.data; var c = a.dataValue, d, c = w(c), c = r(c, b), c = f(c, M), c = k(c), c = f(c, D), c = c.replace(K, "$1cke:$2"), c = c.replace(R, "\x3ccke:$1$2\x3e\x3c/cke:$1\x3e"), c = c.replace(/(<pre\b[^>]*>)(\r\n|\n)/g, "$1$2$2"), c = c.replace(/([^a-z0-9<\-])(on\w{3,})(?!>)/gi, "$1data-cke-" + CKEDITOR.rnd + "-$2"); d = a.context || b.editable().getName(); var e; CKEDITOR.env.ie && 9 > CKEDITOR.env.version && "pre" == d && (d = "div",
                            c = "\x3cpre\x3e" + c + "\x3c/pre\x3e", e = 1); d = b.document.createElement(d); d.setHtml("a" + c); c = d.getHtml().substr(1); c = c.replace(new RegExp("data-cke-" + CKEDITOR.rnd + "-", "ig"), ""); e && (c = c.replace(/^<pre>|<\/pre>$/gi, "")); c = c.replace(E, "$1$2"); c = n(c); c = t(c); d = !1 === a.fixForBody ? !1 : g(a.enterMode, b.config.autoParagraph); c = CKEDITOR.htmlParser.fragment.fromHtml(c, a.context, d); d && (e = c, !e.children.length && CKEDITOR.dtd[e.name][d] && (d = new CKEDITOR.htmlParser.element(d), e.add(d))); a.dataValue = c
                    }, null, null, 5); b.on("toHtml",
                        function (a) { a.data.filter.applyTo(a.data.dataValue, !0, a.data.dontFilter, a.data.enterMode) && b.fire("dataFiltered") }, null, null, 6); b.on("toHtml", function (a) { a.data.dataValue.filterChildren(e.dataFilter, !0) }, null, null, 10); b.on("toHtml", function (a) { a = a.data; var b = a.dataValue, c = new CKEDITOR.htmlParser.basicWriter; b.writeChildrenHtml(c); b = c.getHtml(!0); a.dataValue = p(b) }, null, null, 15); b.on("toDataFormat", function (a) {
                            var c = a.data.dataValue; a.data.enterMode != CKEDITOR.ENTER_BR && (c = c.replace(/^<br *\/?>/i, ""));
                            a.data.dataValue = CKEDITOR.htmlParser.fragment.fromHtml(c, a.data.context, g(a.data.enterMode, b.config.autoParagraph))
                        }, null, null, 5); b.on("toDataFormat", function (a) { a.data.dataValue.filterChildren(e.htmlFilter, !0) }, null, null, 10); b.on("toDataFormat", function (a) { a.data.filter.applyTo(a.data.dataValue, !1, !0) }, null, null, 11); b.on("toDataFormat", function (a) { var c = a.data.dataValue, f = e.writer; f.reset(); c.writeChildrenHtml(f); c = f.getHtml(!0); c = t(c); c = q(c, b); a.data.dataValue = c }, null, null, 15)
            }; CKEDITOR.htmlDataProcessor.prototype =
            {
                toHtml: function (a, b, c, f) { var d = this.editor, e, k, h, g; b && "object" == typeof b ? (e = b.context, c = b.fixForBody, f = b.dontFilter, k = b.filter, h = b.enterMode, g = b.protectedWhitespaces) : e = b; e || null === e || (e = d.editable().getName()); return d.fire("toHtml", { dataValue: a, context: e, fixForBody: c, dontFilter: f, filter: k || d.filter, enterMode: h || d.enterMode, protectedWhitespaces: g }).dataValue }, toDataFormat: function (a, b) {
                    var c, f, d; b && (c = b.context, f = b.filter, d = b.enterMode); c || null === c || (c = this.editor.editable().getName()); return this.editor.fire("toDataFormat",
                        { dataValue: a, filter: f || this.editor.filter, context: c, enterMode: d || this.editor.enterMode }).dataValue
                }
            }; var x = /(?:&nbsp;|\xa0)$/, u = "{cke_protected}", A = CKEDITOR.dtd, v = "caption colgroup col thead tfoot tbody".split(" "), z = CKEDITOR.tools.extend({}, A.$blockLimit, A.$block), y = { elements: { input: l, textarea: l } }, B = {
                attributeNames: [[/^on/, "data-cke-pa-on"], [/^srcdoc/, "data-cke-pa-srcdoc"], [/^data-cke-expando$/, ""]], elements: {
                    iframe: function (a) {
                        if (a.attributes && a.attributes.src) {
                            var b = a.attributes.src.toLowerCase().replace(/[^a-z]/gi,
                                ""); if (0 === b.indexOf("javascript") || 0 === b.indexOf("data")) a.attributes["data-cke-pa-src"] = a.attributes.src, delete a.attributes.src
                        }
                    }
                }
            }, C = { elements: { embed: function (a) { var b = a.parent; if (b && "object" == b.name) { var c = b.attributes.width, b = b.attributes.height; c && (a.attributes.width = c); b && (a.attributes.height = b) } }, a: function (a) { var b = a.attributes; if (!(a.children.length || b.name || b.id || a.attributes["data-cke-saved-name"])) return !1 } } }, F = {
                elementNames: [[/^cke:/, ""], [/^\?xml:namespace$/, ""]], attributeNames: [[/^data-cke-(saved|pa)-/,
                    ""], [/^data-cke-.*/, ""], ["hidefocus", ""]], elements: {
                        $: function (a) { var b = a.attributes; if (b) { if (b["data-cke-temp"]) return !1; for (var c = ["name", "href", "src"], f, d = 0; d < c.length; d++)f = "data-cke-saved-" + c[d], f in b && delete b[c[d]] } return a }, table: function (a) {
                            a.children.slice(0).sort(function (a, b) {
                                var c, f; a.type == CKEDITOR.NODE_ELEMENT && b.type == a.type && (c = CKEDITOR.tools.indexOf(v, a.name), f = CKEDITOR.tools.indexOf(v, b.name)); -1 < c && -1 < f && c != f || (c = a.parent ? a.getIndex() : -1, f = b.parent ? b.getIndex() : -1); return c > f ?
                                    1 : -1
                            })
                        }, param: function (a) { a.children = []; a.isEmpty = !0; return a }, span: function (a) { "Apple-style-span" == a.attributes["class"] && delete a.name }, html: function (a) { delete a.attributes.contenteditable; delete a.attributes["class"] }, body: function (a) { delete a.attributes.spellcheck; delete a.attributes.contenteditable }, style: function (a) { var b = a.children[0]; b && b.value && (b.value = CKEDITOR.tools.trim(b.value)); a.attributes.type || (a.attributes.type = "text/css") }, title: function (a) {
                            var b = a.children[0]; !b && h(a, b = new CKEDITOR.htmlParser.text);
                            b.value = a.attributes["data-cke-title"] || ""
                        }, input: c, textarea: c
                    }, attributes: { "class": function (a) { return CKEDITOR.tools.ltrim(a.replace(/(?:^|\s+)cke_[^\s]*/g, "")) || !1 } }
            }; CKEDITOR.env.ie && (F.attributes.style = function (a) { return a.replace(/(^|;)([^\:]+)/g, function (a) { return a.toLowerCase() }) }); var G = /<(a|area|img|input|source)\b([^>]*)>/gi, I = /([\w-:]+)\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|(?:[^ "'>]+))/gi, H = /^(href|src|name)$/i, D = /(?:<style(?=[ >])[^>]*>[\s\S]*?<\/style>)|(?:<(:?link|meta|base)[^>]*>)/gi,
                M = /(<textarea(?=[ >])[^>]*>)([\s\S]*?)(?:<\/textarea>)/gi, J = /<cke:encoded>([^<]*)<\/cke:encoded>/gi, K = /(<\/?)((?:object|embed|param|html|body|head|title)([\s][^>]*)?>)/gi, E = /(<\/?)cke:((?:html|body|head|title)[^>]*>)/gi, R = /<cke:(param|embed)([^>]*?)\/?>(?!\s*<\/cke:\1)/gi; w = function () {
                    function a(c) { return CKEDITOR.tools.array.reduce(c.split(""), function (a, c) { var f = c.toLowerCase(), d = c.toUpperCase(), e = b(f); f !== d && (e += "|" + b(d)); return a + ("(" + e + ")") }, "") } function b(a) {
                        var c; c = a.charCodeAt(0); var f = c.toString(16);
                        c = { htmlCode: "\x26#" + c + ";?", hex: "\x26#x0*" + f + ";?", entity: { "\x3c": "\x26lt;", "\x3e": "\x26gt;", ":": "\x26colon;" }[a] }; for (var d in c) c[d] && (a += "|" + c[d]); return a
                    } var c = new RegExp("(" + a("\x3ccke:encoded\x3e") + "(.*?)" + a("\x3c/cke:encoded\x3e") + ")|(" + a("\x3c") + a("/") + "?" + a("cke:encoded\x3e") + ")", "gi"), f = new RegExp("((" + a("{cke_protected") + ")(_[0-9]*)?" + a("}") + ")", "gi"); return function (a) { return a.replace(c, "").replace(f, "") }
                }()
        })(); "use strict"; CKEDITOR.htmlParser.element = function (a, g) {
            this.name = a; this.attributes =
                g || {}; this.children = []; var e = a || "", b = e.match(/^cke:(.*)/); b && (e = b[1]); e = !!(CKEDITOR.dtd.$nonBodyContent[e] || CKEDITOR.dtd.$block[e] || CKEDITOR.dtd.$listItem[e] || CKEDITOR.dtd.$tableContent[e] || CKEDITOR.dtd.$nonEditable[e] || "br" == e); this.isEmpty = !!CKEDITOR.dtd.$empty[a]; this.isUnknown = !CKEDITOR.dtd[a]; this._ = { isBlockLike: e, hasInlineStarted: this.isEmpty || !e }
        }; CKEDITOR.htmlParser.cssStyle = function (a) {
            var g = {}; ((a instanceof CKEDITOR.htmlParser.element ? a.attributes.style : a) || "").replace(/&quot;/g, '"').replace(/\s*([^ :;]+)\s*:\s*([^;]+)\s*(?=;|$)/g,
                function (a, b, d) { "font-family" == b && (d = d.replace(/["']/g, "")); g[b.toLowerCase()] = d }); return { rules: g, populate: function (a) { var b = this.toString(); b && (a instanceof CKEDITOR.dom.element ? a.setAttribute("style", b) : a instanceof CKEDITOR.htmlParser.element ? a.attributes.style = b : a.style = b) }, toString: function () { var a = [], b; for (b in g) g[b] && a.push(b, ":", g[b], ";"); return a.join("") } }
        }; (function () {
            function a(a) { return function (d) { return d.type == CKEDITOR.NODE_ELEMENT && ("string" == typeof a ? d.name == a : d.name in a) } } var g =
                function (a, d) { a = a[0]; d = d[0]; return a < d ? -1 : a > d ? 1 : 0 }, e = CKEDITOR.htmlParser.fragment.prototype; CKEDITOR.htmlParser.element.prototype = CKEDITOR.tools.extend(new CKEDITOR.htmlParser.node, {
                    type: CKEDITOR.NODE_ELEMENT, add: e.add, clone: function () { return new CKEDITOR.htmlParser.element(this.name, this.attributes) }, filter: function (a, d) {
                        var e = this, h, g; d = e.getFilterContext(d); if (!e.parent) a.onRoot(d, e); for (; ;) {
                            h = e.name; if (!(g = a.onElementName(d, h))) return this.remove(), !1; e.name = g; if (!(e = a.onElement(d, e))) return this.remove(),
                                !1; if (e !== this) return this.replaceWith(e), !1; if (e.name == h) break; if (e.type != CKEDITOR.NODE_ELEMENT) return this.replaceWith(e), !1; if (!e.name) return this.replaceWithChildren(), !1
                        } h = e.attributes; var c, k; for (c in h) { for (g = h[c]; ;)if (k = a.onAttributeName(d, c)) if (k != c) delete h[c], c = k; else break; else { delete h[c]; break } k && (!1 === (g = a.onAttribute(d, e, k, g)) ? delete h[k] : h[k] = g) } e.isEmpty || this.filterChildren(a, !1, d); return !0
                    }, filterChildren: e.filterChildren, writeHtml: function (a, d) {
                        d && this.filter(d); var e = this.name,
                            h = [], l = this.attributes, c, k; a.openTag(e, l); for (c in l) h.push([c, l[c]]); a.sortAttributes && h.sort(g); c = 0; for (k = h.length; c < k; c++)l = h[c], a.attribute(l[0], l[1]); a.openTagClose(e, this.isEmpty); this.writeChildrenHtml(a); this.isEmpty || a.closeTag(e)
                    }, writeChildrenHtml: e.writeChildrenHtml, replaceWithChildren: function () { for (var a = this.children, d = a.length; d;)a[--d].insertAfter(this); this.remove() }, forEach: e.forEach, getFirst: function (b) {
                        if (!b) return this.children.length ? this.children[0] : null; "function" != typeof b &&
                            (b = a(b)); for (var d = 0, e = this.children.length; d < e; ++d)if (b(this.children[d])) return this.children[d]; return null
                    }, getHtml: function () { var a = new CKEDITOR.htmlParser.basicWriter; this.writeChildrenHtml(a); return a.getHtml() }, setHtml: function (a) { a = this.children = CKEDITOR.htmlParser.fragment.fromHtml(a).children; for (var d = 0, e = a.length; d < e; ++d)a[d].parent = this }, getOuterHtml: function () { var a = new CKEDITOR.htmlParser.basicWriter; this.writeHtml(a); return a.getHtml() }, split: function (a) {
                        for (var d = this.children.splice(a,
                            this.children.length - a), e = this.clone(), h = 0; h < d.length; ++h)d[h].parent = e; e.children = d; d[0] && (d[0].previous = null); 0 < a && (this.children[a - 1].next = null); this.parent.add(e, this.getIndex() + 1); return e
                    }, find: function (a, d) { void 0 === d && (d = !1); var e = [], h; for (h = 0; h < this.children.length; h++) { var g = this.children[h]; "function" == typeof a && a(g) ? e.push(g) : "string" == typeof a && g.name === a && e.push(g); d && g.find && (e = e.concat(g.find(a, d))) } return e }, findOne: function (a, d) {
                        var e = null, h = CKEDITOR.tools.array.find(this.children,
                            function (h) { var c = "function" === typeof a ? a(h) : h.name === a; if (c || !d) return c; h.children && h.findOne && (e = h.findOne(a, !0)); return !!e }); return e || h || null
                    }, addClass: function (a) { if (!this.hasClass(a)) { var d = this.attributes["class"] || ""; this.attributes["class"] = d + (d ? " " : "") + a } }, removeClass: function (a) { var d = this.attributes["class"]; d && ((d = CKEDITOR.tools.trim(d.replace(new RegExp("(?:\\s+|^)" + a + "(?:\\s+|$)"), " "))) ? this.attributes["class"] = d : delete this.attributes["class"]) }, hasClass: function (a) {
                        var d = this.attributes["class"];
                        return d ? (new RegExp("(?:^|\\s)" + a + "(?\x3d\\s|$)")).test(d) : !1
                    }, getFilterContext: function (a) { var d = []; a || (a = { nonEditable: !1, nestedEditable: !1 }); a.nonEditable || "false" != this.attributes.contenteditable ? a.nonEditable && !a.nestedEditable && "true" == this.attributes.contenteditable && d.push("nestedEditable", !0) : d.push("nonEditable", !0); if (d.length) { a = CKEDITOR.tools.copy(a); for (var e = 0; e < d.length; e += 2)a[d[e]] = d[e + 1] } return a }
                }, !0)
        })(); (function () {
            var a = /{([^}]+)}/g; CKEDITOR.template = function (a) {
                this.source =
                "function" === typeof a ? a : String(a)
            }; CKEDITOR.template.prototype.output = function (g, e) { var b = ("function" === typeof this.source ? this.source(g) : this.source).replace(a, function (a, b) { return void 0 !== g[b] ? g[b] : a }); return e ? e.push(b) : b }
        })(); delete CKEDITOR.loadFullCore; CKEDITOR.instances = {}; CKEDITOR.document = new CKEDITOR.dom.document(document); CKEDITOR.add = function (a) {
            function g() { CKEDITOR.currentInstance == a && (CKEDITOR.currentInstance = null, CKEDITOR.fire("currentInstance")) } CKEDITOR.instances[a.name] = a; a.on("focus",
                function () { CKEDITOR.currentInstance != a && (CKEDITOR.currentInstance = a, CKEDITOR.fire("currentInstance")) }); a.on("blur", g); a.on("destroy", g); CKEDITOR.fire("instance", null, a)
        }; CKEDITOR.remove = function (a) { delete CKEDITOR.instances[a.name] }; (function () { var a = {}; CKEDITOR.addTemplate = function (g, e) { var b = a[g]; if (b) return b; b = { name: g, source: e }; CKEDITOR.fire("template", b); return a[g] = new CKEDITOR.template(b.source) }; CKEDITOR.getTemplate = function (g) { return a[g] } })(); (function () {
            var a = []; CKEDITOR.addCss = function (g) { a.push(g) };
            CKEDITOR.getCss = function () { return a.join("\n") }
        })(); CKEDITOR.on("instanceDestroyed", function () { CKEDITOR.tools.isEmpty(this.instances) && CKEDITOR.fire("reset") }); CKEDITOR.TRISTATE_ON = 1; CKEDITOR.TRISTATE_OFF = 2; CKEDITOR.TRISTATE_DISABLED = 0; (function () {
            CKEDITOR.inline = function (a, g) {
                a = CKEDITOR.editor._getEditorElement(a); if (!a) return null; var e = new CKEDITOR.editor(g, a, CKEDITOR.ELEMENT_MODE_INLINE), b = a.is("textarea") ? a : null; b ? (e.setData(b.getValue(), null, !0), a = CKEDITOR.dom.element.createFromHtml('\x3cdiv contenteditable\x3d"' +
                    !!e.readOnly + '" class\x3d"cke_textarea_inline"\x3e' + b.getValue() + "\x3c/div\x3e", CKEDITOR.document), a.insertAfter(b), b.hide(), b.$.form && e._attachToForm()) : e.setData(a.getHtml(), null, !0); e.on("loaded", function () { e.fire("uiReady"); e.editable(a); e.container = a; e.ui.contentsElement = a; e.setData(e.getData(1)); e.resetDirty(); e.fire("contentDom"); e.mode = "wysiwyg"; e.fire("mode"); e.status = "ready"; e.fireOnce("instanceReady"); CKEDITOR.fire("instanceReady", null, e) }, null, null, 1E4); e.on("destroy", function () {
                        var a =
                            e.container; b && a && (a.clearCustomData(), a.remove()); b && b.show(); e.element.clearCustomData(); delete e.element
                    }); return e
            }; CKEDITOR.inlineAll = function () { var a, g, e; for (e in CKEDITOR.dtd.$editable) for (var b = CKEDITOR.document.getElementsByTag(e), d = 0, m = b.count(); d < m; d++)a = b.getItem(d), "true" == a.getAttribute("contenteditable") && (g = { element: a, config: {} }, !1 !== CKEDITOR.fire("inline", g) && CKEDITOR.inline(a, g.config)) }; CKEDITOR.domReady(function () { !CKEDITOR.disableAutoInline && CKEDITOR.inlineAll() })
        })(); CKEDITOR.replaceClass =
            "ckeditor"; (function () {
                function a(a, d, m, h) {
                    a = CKEDITOR.editor._getEditorElement(a); if (!a) return null; var l = new CKEDITOR.editor(d, a, h); h == CKEDITOR.ELEMENT_MODE_REPLACE && (a.setStyle("visibility", "hidden"), l._.required = a.hasAttribute("required"), a.removeAttribute("required")); m && l.setData(m, null, !0); l.on("loaded", function () {
                        l.isDestroyed() || l.isDetached() || (e(l), h == CKEDITOR.ELEMENT_MODE_REPLACE && l.config.autoUpdateElement && a.$.form && l._attachToForm(), l.setMode(l.config.startupMode, function () {
                            l.resetDirty();
                            l.status = "ready"; l.fireOnce("instanceReady"); CKEDITOR.fire("instanceReady", null, l)
                        }))
                    }); l.on("destroy", g); return l
                } function g() { var a = this.container, d = this.element; a && (a.clearCustomData(), a.remove()); d && (d.clearCustomData(), this.elementMode == CKEDITOR.ELEMENT_MODE_REPLACE && (d.show(), this._.required && d.setAttribute("required", "required")), delete this.element) } function e(a) {
                    var d = a.name, e = a.element, h = a.elementMode, g = a.fire("uiSpace", { space: "top", html: "" }).html, c = a.fire("uiSpace", { space: "bottom", html: "" }).html,
                    k = new CKEDITOR.template('\x3c{outerEl} id\x3d"cke_{name}" class\x3d"{id} cke cke_reset cke_chrome cke_editor_{name} cke_{langDir} ' + CKEDITOR.env.cssClass + '"  dir\x3d"{langDir}" lang\x3d"{langCode}" role\x3d"application"' + (a.title ? ' aria-labelledby\x3d"cke_{name}_arialbl"' : "") + "\x3e" + (a.title ? '\x3cspan id\x3d"cke_{name}_arialbl" class\x3d"cke_voice_label"\x3e{voiceLabel}\x3c/span\x3e' : "") + '\x3c{outerEl} class\x3d"cke_inner cke_reset" role\x3d"presentation"\x3e{topHtml}\x3c{outerEl} id\x3d"{contentId}" class\x3d"cke_contents cke_reset" role\x3d"presentation"\x3e\x3c/{outerEl}\x3e{bottomHtml}\x3c/{outerEl}\x3e\x3c/{outerEl}\x3e'),
                    d = CKEDITOR.dom.element.createFromHtml(k.output({ id: a.id, name: d, langDir: a.lang.dir, langCode: a.langCode, voiceLabel: a.title, topHtml: g ? '\x3cspan id\x3d"' + a.ui.spaceId("top") + '" class\x3d"cke_top cke_reset_all" role\x3d"presentation" style\x3d"height:auto"\x3e' + g + "\x3c/span\x3e" : "", contentId: a.ui.spaceId("contents"), bottomHtml: c ? '\x3cspan id\x3d"' + a.ui.spaceId("bottom") + '" class\x3d"cke_bottom cke_reset_all" role\x3d"presentation"\x3e' + c + "\x3c/span\x3e" : "", outerEl: CKEDITOR.env.ie ? "span" : "div" })); h == CKEDITOR.ELEMENT_MODE_REPLACE ?
                        (e.hide(), d.insertAfter(e)) : e.append(d); a.container = d; a.ui.contentsElement = a.ui.space("contents"); g && a.ui.space("top").unselectable(); c && a.ui.space("bottom").unselectable(); e = a.config.width; h = a.config.height; e && d.setStyle("width", CKEDITOR.tools.cssLength(e)); h && a.ui.space("contents").setStyle("height", CKEDITOR.tools.cssLength(h)); d.disableContextMenu(); CKEDITOR.env.webkit && d.on("focus", function () { a.focus() }); a.fireOnce("uiReady")
                } CKEDITOR.replace = function (b, d) { return a(b, d, null, CKEDITOR.ELEMENT_MODE_REPLACE) };
                CKEDITOR.appendTo = function (b, d, e) { return a(b, d, e, CKEDITOR.ELEMENT_MODE_APPENDTO) }; CKEDITOR.replaceAll = function () { for (var a = document.getElementsByTagName("textarea"), d = 0; d < a.length; d++) { var e = null, h = a[d]; if (h.name || h.id) { if ("string" == typeof arguments[0]) { if (!(new RegExp("(?:^|\\s)" + arguments[0] + "(?:$|\\s)")).test(h.className)) continue } else if ("function" == typeof arguments[0] && (e = {}, !1 === arguments[0](h, e))) continue; this.replace(h, e) } } }; CKEDITOR.editor.prototype.addMode = function (a, d) {
                    (this._.modes || (this._.modes =
                        {}))[a] = d
                }; CKEDITOR.editor.prototype.setMode = function (a, d) {
                    var e = this, h = this._.modes; if (a != e.mode && h && h[a]) {
                        e.fire("beforeSetMode", a); if (e.mode) { var g = e.checkDirty(), h = e._.previousModeData, c, k = 0; e.fire("beforeModeUnload"); e.editable(0); e._.previousMode = e.mode; e._.previousModeData = c = e.getData(1); "source" == e.mode && h == c && (e.fire("lockSnapshot", { forceUpdate: !0 }), k = 1); e.ui.space("contents").setHtml(""); e.mode = "" } else e._.previousModeData = e.getData(1); this._.modes[a](function () {
                            e.mode = a; void 0 !== g && !g &&
                                e.resetDirty(); k ? e.fire("unlockSnapshot") : "wysiwyg" == a && e.fire("saveSnapshot"); setTimeout(function () { e.isDestroyed() || e.isDetached() || (e.fire("mode"), d && d.call(e)) }, 0)
                        })
                    }
                }; CKEDITOR.editor.prototype.resize = function (a, d, e, h) {
                    var g = this.container, c = this.ui.space("contents"), k = CKEDITOR.env.webkit && this.document && this.document.getWindow().$.frameElement; h = h ? this.container.getFirst(function (a) { return a.type == CKEDITOR.NODE_ELEMENT && a.hasClass("cke_inner") }) : g; h.setSize("width", a, !0); k && (k.style.width = "1%");
                    var f = (h.$.offsetHeight || 0) - (c.$.clientHeight || 0), g = Math.max(d - (e ? 0 : f), 0); d = e ? d + f : d; c.setStyle("height", g + "px"); k && (k.style.width = "100%"); this.fire("resize", { outerHeight: d, contentsHeight: g, outerWidth: a || h.getSize("width") })
                }; CKEDITOR.editor.prototype.getResizable = function (a) { return a ? this.ui.space("contents") : this.container }; CKEDITOR.domReady(function () { CKEDITOR.replaceClass && CKEDITOR.replaceAll(CKEDITOR.replaceClass) })
            })(); CKEDITOR.config.startupMode = "wysiwyg"; (function () {
                function a(a) {
                    var c = a.editor,
                    f = a.data.path, d = f.blockLimit, e = a.data.selection, k = e.getRanges()[0], l; if (CKEDITOR.env.gecko || CKEDITOR.env.ie && CKEDITOR.env.needsBrFiller) if (e = g(e, f)) e.appendBogus(), l = CKEDITOR.env.ie && !CKEDITOR.env.edge || CKEDITOR.env.edge && c._.previousActive; h(c, f.block, d) && k.collapsed && !k.getCommonAncestor().isReadOnly() && (f = k.clone(), f.enlarge(CKEDITOR.ENLARGE_BLOCK_CONTENTS), d = new CKEDITOR.dom.walker(f), d.guard = function (a) { return !b(a) || a.type == CKEDITOR.NODE_COMMENT || a.isReadOnly() }, !d.checkForward() || f.checkStartOfBlock() &&
                        f.checkEndOfBlock()) && (c = k.fixBlock(!0, c.activeEnterMode == CKEDITOR.ENTER_DIV ? "div" : "p"), CKEDITOR.env.needsBrFiller || (c = c.getFirst(b)) && c.type == CKEDITOR.NODE_TEXT && CKEDITOR.tools.trim(c.getText()).match(/^(?:&nbsp;|\xa0)$/) && c.remove(), l = 1, a.cancel()); l && k.select()
                } function g(a, c) { if (a.isFake) return 0; var f = c.block || c.blockLimit, d = f && f.getLast(b); if (!(!f || !f.isBlockBoundary() || d && d.type == CKEDITOR.NODE_ELEMENT && d.isBlockBoundary() || f.is("pre") || f.getBogus())) return f } function e(a) {
                    var b = a.data.getTarget();
                    b.is("input") && (b = b.getAttribute("type"), "submit" != b && "reset" != b || a.data.preventDefault())
                } function b(a) { return n(a) && p(a) } function d(a, b) { return function (c) { var f = c.data.$.toElement || c.data.$.fromElement || c.data.$.relatedTarget; (f = f && f.nodeType == CKEDITOR.NODE_ELEMENT ? new CKEDITOR.dom.element(f) : null) && (b.equals(f) || b.contains(f)) || a.call(this, c) } } function m(a) {
                    function c(a) { return function (c, d) { d && c.type == CKEDITOR.NODE_ELEMENT && c.is(e) && (f = c); if (!(d || !b(c) || a && q(c))) return !1 } } var f, d = a.getRanges()[0];
                    a = a.root; var e = { table: 1, ul: 1, ol: 1, dl: 1 }; if (d.startPath().contains(e)) { var k = d.clone(); k.collapse(1); k.setStartAt(a, CKEDITOR.POSITION_AFTER_START); a = new CKEDITOR.dom.walker(k); a.guard = c(); a.checkBackward(); if (f) return k = d.clone(), k.collapse(), k.setEndAt(f, CKEDITOR.POSITION_AFTER_END), a = new CKEDITOR.dom.walker(k), a.guard = c(!0), f = !1, a.checkForward(), f } return null
                } function h(a, b, c) { return !1 !== a.config.autoParagraph && a.activeEnterMode != CKEDITOR.ENTER_BR && (a.editable().equals(c) && !b || b && "true" == b.getAttribute("contenteditable")) }
                function l(a) { return a.activeEnterMode != CKEDITOR.ENTER_BR && !1 !== a.config.autoParagraph ? a.activeEnterMode == CKEDITOR.ENTER_DIV ? "div" : "p" : !1 } function c(a) { a && a.isEmptyInlineRemoveable() && a.remove() } function k(a) { var b = a.editor; b.getSelection().scrollIntoView(); setTimeout(function () { b.fire("saveSnapshot") }, 0) } function f(a, b, c) { var f = a.getCommonAncestor(b); for (b = a = c ? b : a; (a = a.getParent()) && !f.equals(a) && 1 == a.getChildCount();)b = a; b.remove() } var n, p, t, q, r, w, x, u, A, v; CKEDITOR.editable = CKEDITOR.tools.createClass({
                    base: CKEDITOR.dom.element,
                    $: function (a, b) { this.base(b.$ || b); this.editor = a; this.status = "unloaded"; this.hasFocus = !1; this.setup() }, proto: {
                        focus: function () {
                            var a; if (CKEDITOR.env.webkit && !this.hasFocus && (a = this.editor._.previousActive || this.getDocument().getActive(), this.contains(a))) { a.focus(); return } CKEDITOR.env.edge && 14 < CKEDITOR.env.version && !this.hasFocus && this.getDocument().equals(CKEDITOR.document) && (this.editor._.previousScrollTop = this.$.scrollTop); try {
                                if (!CKEDITOR.env.ie || CKEDITOR.env.edge && 14 < CKEDITOR.env.version || !this.getDocument().equals(CKEDITOR.document)) if (CKEDITOR.env.chrome) {
                                    var b =
                                        this.$.scrollTop; this.$.focus(); this.$.scrollTop = b
                                } else this.$.focus(); else this.$.setActive()
                            } catch (c) { if (!CKEDITOR.env.ie) throw c; } CKEDITOR.env.safari && !this.isInline() && (a = CKEDITOR.document.getActive(), a.equals(this.getWindow().getFrame()) || this.getWindow().focus())
                        }, on: function (a, b) { var c = Array.prototype.slice.call(arguments, 0); CKEDITOR.env.ie && /^focus|blur$/.exec(a) && (a = "focus" == a ? "focusin" : "focusout", b = d(b, this), c[0] = a, c[1] = b); return CKEDITOR.dom.element.prototype.on.apply(this, c) }, attachListener: function (a) {
                            !this._.listeners &&
                            (this._.listeners = []); var b = Array.prototype.slice.call(arguments, 1), b = a.on.apply(a, b); this._.listeners.push(b); return b
                        }, clearListeners: function () { var a = this._.listeners; try { for (; a.length;)a.pop().removeListener() } catch (b) { } }, restoreAttrs: function () { var a = this._.attrChanges, b, c; for (c in a) a.hasOwnProperty(c) && (b = a[c], null !== b ? this.setAttribute(c, b) : this.removeAttribute(c)) }, attachClass: function (a) {
                            var b = this.getCustomData("classes"); this.hasClass(a) || (!b && (b = []), b.push(a), this.setCustomData("classes",
                                b), this.addClass(a))
                        }, changeAttr: function (a, b) { var c = this.getAttribute(a); b !== c && (!this._.attrChanges && (this._.attrChanges = {}), a in this._.attrChanges || (this._.attrChanges[a] = c), this.setAttribute(a, b)) }, insertText: function (a) { this.editor.focus(); this.insertHtml(this.transformPlainTextToHtml(a), "text") }, transformPlainTextToHtml: function (a) {
                            var b = this.editor.getSelection().getStartElement().hasAscendant("pre", !0) ? CKEDITOR.ENTER_BR : this.editor.activeEnterMode; return CKEDITOR.tools.transformPlainTextToHtml(a,
                                b)
                        }, insertHtml: function (a, b, c) { var f = this.editor; f.focus(); f.fire("saveSnapshot"); c || (c = f.getSelection().getRanges()[0]); w(this, b || "html", a, c); c.select(); k(this); this.editor.fire("afterInsertHtml", {}) }, insertHtmlIntoRange: function (a, b, c) { w(this, c || "html", a, b); this.editor.fire("afterInsertHtml", { intoRange: b }) }, insertElement: function (a, c) {
                            var f = this.editor; f.focus(); f.fire("saveSnapshot"); var d = f.activeEnterMode, f = f.getSelection(), e = a.getName(), e = CKEDITOR.dtd.$block[e]; c || (c = f.getRanges()[0]); this.insertElementIntoRange(a,
                                c) && (c.moveToPosition(a, CKEDITOR.POSITION_AFTER_END), e && ((e = a.getNext(function (a) { return b(a) && !q(a) })) && e.type == CKEDITOR.NODE_ELEMENT && e.is(CKEDITOR.dtd.$block) ? e.getDtd()["#"] ? c.moveToElementEditStart(e) : c.moveToElementEditEnd(a) : e || d == CKEDITOR.ENTER_BR || (e = c.fixBlock(!0, d == CKEDITOR.ENTER_DIV ? "div" : "p"), c.moveToElementEditStart(e)))); f.selectRanges([c]); k(this)
                        }, insertElementIntoSelection: function (a) { this.insertElement(a) }, insertElementIntoRange: function (a, b) {
                            var f = this.editor, d = f.config.enterMode,
                            e = a.getName(), k = CKEDITOR.dtd.$block[e]; if (b.checkReadOnly()) return !1; b.deleteContents(1); b.startContainer.type == CKEDITOR.NODE_ELEMENT && (b.startContainer.is({ tr: 1, table: 1, tbody: 1, thead: 1, tfoot: 1 }) ? x(b) : b.startContainer.is(CKEDITOR.dtd.$list) && u(b)); var h, g; if (k) for (; (h = b.getCommonAncestor(0, 1)) && (g = CKEDITOR.dtd[h.getName()]) && (!g || !g[e]);)if (h.getName() in CKEDITOR.dtd.span) { var k = b.splitElement(h), l = b.createBookmark(); c(h); c(k); b.moveToBookmark(l) } else b.checkStartOfBlock() && b.checkEndOfBlock() ? (b.setStartBefore(h),
                                b.collapse(!0), h.remove()) : b.splitBlock(d == CKEDITOR.ENTER_DIV ? "div" : "p", f.editable()); b.insertNode(a); return !0
                        }, setData: function (a, b) { b || (a = this.editor.dataProcessor.toHtml(a)); this.setHtml(a); this.fixInitialSelection(); "unloaded" == this.status && (this.status = "ready"); this.editor.fire("dataReady") }, getData: function (a) { var b = this.getHtml(); a || (b = this.editor.dataProcessor.toDataFormat(b)); return b }, setReadOnly: function (a) { this.setAttribute("contenteditable", !a) }, detach: function () {
                            this.status = "detached";
                            this.editor.setData(this.editor.getData(), { internal: !0 }); this.clearListeners(); try { this._.cleanCustomData() } catch (a) { if (!CKEDITOR.env.ie || -2146828218 !== a.number) throw a; } this.editor.fire("contentDomUnload"); delete this.editor.document; delete this.editor.window; delete this.editor
                        }, isInline: function () { return this.getDocument().equals(CKEDITOR.document) }, fixInitialSelection: function () {
                            function a() {
                                var b = c.getDocument().$, f = b.getSelection(), d; a: if (f.anchorNode && f.anchorNode == c.$) d = !0; else {
                                    if (CKEDITOR.env.webkit &&
                                        (d = c.getDocument().getActive()) && d.equals(c) && !f.anchorNode) { d = !0; break a } d = void 0
                                } d && (d = new CKEDITOR.dom.range(c), d.moveToElementEditStart(c), b = b.createRange(), b.setStart(d.startContainer.$, d.startOffset), b.collapse(!0), f.removeAllRanges(), f.addRange(b))
                            } function b() {
                                var a = c.getDocument().$, f = a.selection, d = c.getDocument().getActive(); "None" == f.type && d.equals(c) && (f = new CKEDITOR.dom.range(c), a = a.body.createTextRange(), f.moveToElementEditStart(c), f = f.startContainer, f.type != CKEDITOR.NODE_ELEMENT && (f =
                                    f.getParent()), a.moveToElementText(f.$), a.collapse(!0), a.select())
                            } var c = this; if (CKEDITOR.env.ie && (9 > CKEDITOR.env.version || CKEDITOR.env.quirks)) this.hasFocus && (this.focus(), b()); else if (this.hasFocus) this.focus(), a(); else this.once("focus", function () { a() }, null, null, -999)
                        }, getHtmlFromRange: function (a) {
                            if (a.collapsed) return new CKEDITOR.dom.documentFragment(a.document); a = { doc: this.getDocument(), range: a.clone() }; A.eol.detect(a, this); A.bogus.exclude(a); A.cell.shrink(a); a.fragment = a.range.cloneContents();
                            A.tree.rebuild(a, this); A.eol.fix(a, this); return new CKEDITOR.dom.documentFragment(a.fragment.$)
                        }, extractHtmlFromRange: function (a, b) {
                            var c = v, f = { range: a, doc: a.document }, d = this.getHtmlFromRange(a); if (a.collapsed) return a.optimize(), d; a.enlarge(CKEDITOR.ENLARGE_INLINE, 1); c.table.detectPurge(f); f.bookmark = a.createBookmark(); delete f.range; var e = this.editor.createRange(); e.moveToPosition(f.bookmark.startNode, CKEDITOR.POSITION_BEFORE_START); f.targetBookmark = e.createBookmark(); c.list.detectMerge(f, this);
                            c.table.detectRanges(f, this); c.block.detectMerge(f, this); f.tableContentsRanges ? (c.table.deleteRanges(f), a.moveToBookmark(f.bookmark), f.range = a) : (a.moveToBookmark(f.bookmark), f.range = a, a.extractContents(c.detectExtractMerge(f))); a.moveToBookmark(f.targetBookmark); a.optimize(); c.fixUneditableRangePosition(a); c.list.merge(f, this); c.table.purge(f, this); c.block.merge(f, this); if (b) {
                                c = a.startPath(); if (f = a.checkStartOfBlock() && a.checkEndOfBlock() && c.block && !a.root.equals(c.block)) {
                                    a: {
                                        var f = c.block.getElementsByTag("span"),
                                        e = 0, k; if (f) for (; k = f.getItem(e++);)if (!p(k)) { f = !0; break a } f = !1
                                    } f = !f
                                } f && (a.moveToPosition(c.block, CKEDITOR.POSITION_BEFORE_START), c.block.remove())
                            } else c.autoParagraph(this.editor, a), t(a.startContainer) && a.startContainer.appendBogus(); a.startContainer.mergeSiblings(); return d
                        }, setup: function () {
                            var a = this.editor; this.attachListener(a, "beforeGetData", function () { var b = this.getData(); this.is("textarea") || !1 !== a.config.ignoreEmptyParagraph && (b = b.replace(r, function (a, b) { return b })); a.setData(b, null, 1) },
                                this); this.attachListener(a, "getSnapshot", function (a) { a.data = this.getData(1) }, this); this.attachListener(a, "afterSetData", function () { this.setData(a.getData(1)) }, this); this.attachListener(a, "loadSnapshot", function (a) { this.setData(a.data, 1) }, this); this.attachListener(a, "beforeFocus", function () { var b = a.getSelection(); (b = b && b.getNative()) && "Control" == b.type || this.focus() }, this); this.attachListener(a, "insertHtml", function (a) { this.insertHtml(a.data.dataValue, a.data.mode, a.data.range) }, this); this.attachListener(a,
                                    "insertElement", function (a) { this.insertElement(a.data) }, this); this.attachListener(a, "insertText", function (a) { this.insertText(a.data) }, this); this.setReadOnly(a.readOnly); this.attachClass("cke_editable"); a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ? this.attachClass("cke_editable_inline") : a.elementMode != CKEDITOR.ELEMENT_MODE_REPLACE && a.elementMode != CKEDITOR.ELEMENT_MODE_APPENDTO || this.attachClass("cke_editable_themed"); this.attachClass("cke_contents_" + a.config.contentsLangDirection); a.keystrokeHandler.blockedKeystrokes[8] =
                                        +a.readOnly; a.keystrokeHandler.attach(this); this.on("blur", function () { this.hasFocus = !1 }, null, null, -1); this.on("focus", function () { this.hasFocus = !0 }, null, null, -1); if (CKEDITOR.env.webkit) this.on("scroll", function () { a._.previousScrollTop = a.editable().$.scrollTop }, null, null, -1); if (CKEDITOR.env.edge && 14 < CKEDITOR.env.version) {
                                            var c = function () {
                                                var b = a.editable(); null != a._.previousScrollTop && b.getDocument().equals(CKEDITOR.document) && (b.$.scrollTop = a._.previousScrollTop, a._.previousScrollTop = null, this.removeListener("scroll",
                                                    c))
                                            }; this.on("scroll", c)
                                        } a.focusManager.add(this); this.equals(CKEDITOR.document.getActive()) && (this.hasFocus = !0, a.once("contentDom", function () { a.focusManager.focus(this) }, this)); this.isInline() && this.changeAttr("tabindex", a.tabIndex); if (!this.is("textarea")) {
                                            a.document = this.getDocument(); a.window = this.getWindow(); var d = a.document; this.changeAttr("spellcheck", !a.config.disableNativeSpellChecker); var k = a.config.contentsLangDirection; this.getDirection(1) != k && this.changeAttr("dir", k); var h = CKEDITOR.getCss();
                                            if (h) { var k = d.getHead(), g = k.getCustomData("stylesheet"); g ? h != g.getText() && (CKEDITOR.env.ie && 9 > CKEDITOR.env.version ? g.$.styleSheet.cssText = h : g.setText(h)) : (h = d.appendStyleText(h), h = new CKEDITOR.dom.element(h.ownerNode || h.owningElement), k.setCustomData("stylesheet", h), h.data("cke-temp", 1)) } k = d.getCustomData("stylesheet_ref") || 0; d.setCustomData("stylesheet_ref", k + 1); this.setCustomData("cke_includeReadonly", !a.config.disableReadonlyStyling); this.attachListener(this, "click", function (a) {
                                                a = a.data; var b =
                                                    (new CKEDITOR.dom.elementPath(a.getTarget(), this)).contains("a"); b && 2 != a.$.button && b.isReadOnly() && a.preventDefault()
                                            }); var l = { 8: 1, 46: 1 }; this.attachListener(a, "key", function (b) {
                                                if (a.readOnly) return !0; var c = b.data.domEvent.getKey(), f; b = a.getSelection(); if (0 !== b.getRanges().length) {
                                                    if (c in l) {
                                                        var d, e = b.getRanges()[0], k = e.startPath(), h, g, p, c = 8 == c; CKEDITOR.env.ie && 11 > CKEDITOR.env.version && (d = b.getSelectedElement()) || (d = m(b)) ? (a.fire("saveSnapshot"), e.moveToPosition(d, CKEDITOR.POSITION_BEFORE_START), d.remove(),
                                                            e.select(), a.fire("saveSnapshot"), f = 1) : e.collapsed && ((h = k.block) && (p = h[c ? "getPrevious" : "getNext"](n)) && p.type == CKEDITOR.NODE_ELEMENT && p.is("table") && e[c ? "checkStartOfBlock" : "checkEndOfBlock"]() ? (a.fire("saveSnapshot"), e[c ? "checkEndOfBlock" : "checkStartOfBlock"]() && h.remove(), e["moveToElementEdit" + (c ? "End" : "Start")](p), e.select(), a.fire("saveSnapshot"), f = 1) : k.blockLimit && k.blockLimit.is("td") && (g = k.blockLimit.getAscendant("table")) && e.checkBoundaryOfElement(g, c ? CKEDITOR.START : CKEDITOR.END) && (p = g[c ?
                                                                "getPrevious" : "getNext"](n)) ? (a.fire("saveSnapshot"), e["moveToElementEdit" + (c ? "End" : "Start")](p), e.checkStartOfBlock() && e.checkEndOfBlock() ? p.remove() : e.select(), a.fire("saveSnapshot"), f = 1) : (g = k.contains(["td", "th", "caption"])) && e.checkBoundaryOfElement(g, c ? CKEDITOR.START : CKEDITOR.END) && (f = 1))
                                                    } return !f
                                                }
                                            }); a.blockless && CKEDITOR.env.ie && CKEDITOR.env.needsBrFiller && this.attachListener(this, "keyup", function (c) {
                                                c.data.getKeystroke() in l && !this.getFirst(b) && (this.appendBogus(), c = a.createRange(), c.moveToPosition(this,
                                                    CKEDITOR.POSITION_AFTER_START), c.select())
                                            }); this.attachListener(this, "dblclick", function (b) { if (a.readOnly) return !1; b = { element: b.data.getTarget() }; a.fire("doubleclick", b) }); CKEDITOR.env.ie && this.attachListener(this, "click", e); CKEDITOR.env.ie && !CKEDITOR.env.edge || this.attachListener(this, "mousedown", function (b) { var c = b.data.getTarget(); c.is("img", "hr", "input", "textarea", "select") && !c.isReadOnly() && (a.getSelection().selectElement(c), c.is("input", "textarea", "select") && b.data.preventDefault()) }); CKEDITOR.env.edge &&
                                                this.attachListener(this, "mouseup", function (b) { (b = b.data.getTarget()) && b.is("img") && !b.isReadOnly() && a.getSelection().selectElement(b) }); CKEDITOR.env.gecko && this.attachListener(this, "mouseup", function (b) { if (2 == b.data.$.button && (b = b.data.getTarget(), !b.getAscendant("table") && !b.getOuterHtml().replace(r, ""))) { var c = a.createRange(); c.moveToElementEditStart(b); c.select(!0) } }); CKEDITOR.env.webkit && (this.attachListener(this, "click", function (a) { a.data.getTarget().is("input", "select") && a.data.preventDefault() }),
                                                    this.attachListener(this, "mouseup", function (a) { a.data.getTarget().is("input", "textarea") && a.data.preventDefault() })); CKEDITOR.env.webkit && this.attachListener(a, "key", function (b) {
                                                        if (a.readOnly) return !0; var c = b.data.domEvent.getKey(); if (c in l && (b = a.getSelection(), 0 !== b.getRanges().length)) {
                                                            var c = 8 == c, d = b.getRanges()[0]; b = d.startPath(); if (d.collapsed) a: {
                                                                var e = b.block; if (e && d[c ? "checkStartOfBlock" : "checkEndOfBlock"]() && d.moveToClosestEditablePosition(e, !c) && d.collapsed) {
                                                                    if (d.startContainer.type == CKEDITOR.NODE_ELEMENT) {
                                                                        var k =
                                                                            d.startContainer.getChild(d.startOffset - (c ? 1 : 0)); if (k && k.type == CKEDITOR.NODE_ELEMENT && k.is("hr")) { a.fire("saveSnapshot"); k.remove(); b = !0; break a }
                                                                    } d = d.startPath().block; if (!d || d && d.contains(e)) b = void 0; else { a.fire("saveSnapshot"); var h; (h = (c ? d : e).getBogus()) && h.remove(); h = a.getSelection(); k = h.createBookmarks(); (c ? e : d).moveChildren(c ? d : e, !1); b.lastElement.mergeSiblings(); f(e, d, !c); h.selectBookmarks(k); b = !0 }
                                                                } else b = !1
                                                            } else c = d, h = b.block, d = c.endPath().block, h && d && !h.equals(d) ? (a.fire("saveSnapshot"),
                                                                (e = h.getBogus()) && e.remove(), c.enlarge(CKEDITOR.ENLARGE_INLINE), c.deleteContents(), d.getParent() && (d.moveChildren(h, !1), b.lastElement.mergeSiblings(), f(h, d, !0)), c = a.getSelection().getRanges()[0], c.collapse(1), c.optimize(), "" === c.startContainer.getHtml() && c.startContainer.appendBogus(), c.select(), b = !0) : b = !1; if (!b) return; a.getSelection().scrollIntoView(); a.fire("saveSnapshot"); return !1
                                                        }
                                                    }, this, null, 100)
                                        }
                        }, getUniqueId: function () {
                            var a; try { this._.expandoNumber = a = CKEDITOR.dom.domObject.prototype.getUniqueId.call(this) } catch (b) {
                                a =
                                this._ && this._.expandoNumber
                            } return a
                        }
                    }, _: { cleanCustomData: function () { this.removeClass("cke_editable"); this.restoreAttrs(); for (var a = this.removeCustomData("classes"); a && a.length;)this.removeClass(a.pop()); if (!this.is("textarea")) { var a = this.getDocument(), b = a.getHead(); if (b.getCustomData("stylesheet")) { var c = a.getCustomData("stylesheet_ref"); --c ? a.setCustomData("stylesheet_ref", c) : (a.removeCustomData("stylesheet_ref"), b.removeCustomData("stylesheet").remove()) } } } }
                }); CKEDITOR.editor.prototype.editable =
                    function (a) { var b = this._.editable; if (b && a) return 0; if (!arguments.length) return b; a ? b = a instanceof CKEDITOR.editable ? a : new CKEDITOR.editable(this, a) : (b && b.detach(), b = null); return this._.editable = b }; CKEDITOR.on("instanceLoaded", function (b) {
                        var c = b.editor; c.on("insertElement", function (a) {
                            a = a.data; a.type == CKEDITOR.NODE_ELEMENT && (a.is("input") || a.is("textarea")) && ("false" != a.getAttribute("contentEditable") && a.data("cke-editable", a.hasAttribute("contenteditable") ? "true" : "1"), a.setAttribute("contentEditable",
                                !1))
                        }); c.on("selectionChange", function (b) { if (!c.readOnly) { var f = c.getSelection(); f && !f.isLocked && (f = c.checkDirty(), c.fire("lockSnapshot"), a(b), c.fire("unlockSnapshot"), !f && c.resetDirty()) } })
                    }); CKEDITOR.on("instanceCreated", function (a) {
                        var b = a.editor; b.on("mode", function () {
                            var a = b.editable(); if (a && a.isInline()) {
                                var c = b.title; a.changeAttr("role", "textbox"); a.changeAttr("aria-multiline", "true"); a.changeAttr("aria-label", c); c && a.changeAttr("title", c); var f = b.fire("ariaEditorHelpLabel", {}).label; if (f &&
                                    (c = this.ui.space(this.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ? "top" : "contents"))) { var d = CKEDITOR.tools.getNextId(), f = CKEDITOR.dom.element.createFromHtml('\x3cspan id\x3d"' + d + '" class\x3d"cke_voice_label"\x3e' + f + "\x3c/span\x3e"); c.append(f); a.changeAttr("aria-describedby", d) }
                            }
                        })
                    }); CKEDITOR.addCss(".cke_editable{cursor:text}.cke_editable img,.cke_editable input,.cke_editable textarea{cursor:default}"); n = CKEDITOR.dom.walker.whitespaces(!0); p = CKEDITOR.dom.walker.bookmark(!1, !0); t = CKEDITOR.dom.walker.empty();
                q = CKEDITOR.dom.walker.bogus(); r = /(^|<body\b[^>]*>)\s*<(p|div|address|h\d|center|pre)[^>]*>\s*(?:<br[^>]*>|&nbsp;|\u00A0|&#160;)?\s*(:?<\/\2>)?\s*(?=$|<\/body>)/gi; w = function () {
                    function a(b) { return b.type == CKEDITOR.NODE_ELEMENT } function f(b, c) {
                        var d, e, k, h, g = [], l = c.range.startContainer; d = c.range.startPath(); for (var l = m[l.getName()], n = 0, p = b.getChildren(), w = p.count(), u = -1, t = -1, x = 0, v = d.contains(m.$list); n < w; ++n)d = p.getItem(n), a(d) ? (k = d.getName(), v && k in CKEDITOR.dtd.$list ? g = g.concat(f(d, c)) : (h = !!l[k],
                            "br" != k || !d.data("cke-eol") || n && n != w - 1 || (x = (e = n ? g[n - 1].node : p.getItem(n + 1)) && (!a(e) || !e.is("br")), e = e && a(e) && m.$block[e.getName()]), -1 != u || h || (u = n), h || (t = n), g.push({ isElement: 1, isLineBreak: x, isBlock: d.isBlockBoundary(), hasBlockSibling: e, node: d, name: k, allowed: h }), e = x = 0)) : g.push({ isElement: 0, node: d, allowed: 1 }); -1 < u && (g[u].firstNotAllowed = 1); -1 < t && (g[t].lastNotAllowed = 1); return g
                    } function d(b, c) {
                        var f = [], e = b.getChildren(), k = e.count(), h, g = 0, l = m[c], n = !b.is(m.$inline) || b.is("br"); for (n && f.push(" "); g < k; g++)h =
                            e.getItem(g), a(h) && !h.is(l) ? f = f.concat(d(h, c)) : f.push(h); n && f.push(" "); return f
                    } function e(b) { return a(b.startContainer) && b.startContainer.getChild(b.startOffset - 1) } function k(b) { return b && a(b) && (b.is(m.$removeEmpty) || b.is("a") && !b.isBlockBoundary()) } function g(b, c, f, d) {
                        var e = b.clone(), k, h; e.setEndAt(c, CKEDITOR.POSITION_BEFORE_END); (k = (new CKEDITOR.dom.walker(e)).next()) && a(k) && p[k.getName()] && (h = k.getPrevious()) && a(h) && !h.getParent().equals(b.startContainer) && f.contains(h) && d.contains(k) && k.isIdentical(h) &&
                            (k.moveChildren(h), k.remove(), g(b, c, f, d))
                    } function n(b, c) { function f(b, c) { if (c.isBlock && c.isElement && !c.node.is("br") && a(b) && b.is("br")) return b.remove(), 1 } var d = c.endContainer.getChild(c.endOffset), e = c.endContainer.getChild(c.endOffset - 1); d && f(d, b[b.length - 1]); e && f(e, b[0]) && (c.setEnd(c.endContainer, c.endOffset - 1), c.collapse()) } var m = CKEDITOR.dtd, p = { p: 1, div: 1, h1: 1, h2: 1, h3: 1, h4: 1, h5: 1, h6: 1, ul: 1, ol: 1, li: 1, pre: 1, dl: 1, blockquote: 1 }, w = { p: 1, div: 1, h1: 1, h2: 1, h3: 1, h4: 1, h5: 1, h6: 1 }, u = CKEDITOR.tools.extend({},
                        m.$inline); delete u.br; return function (p, E, t, x) {
                            var v = p.editor, q = !1; "unfiltered_html" == E && (E = "html", q = !0); if (!x.checkReadOnly()) {
                                var r = (new CKEDITOR.dom.elementPath(x.startContainer, x.root)).blockLimit || x.root; E = { type: E, dontFilter: q, editable: p, editor: v, range: x, blockLimit: r, mergeCandidates: [], zombies: [] }; var q = E.range, r = E.mergeCandidates, A = "html" === E.type, D, O, V, aa, ba, W; "text" == E.type && q.shrink(CKEDITOR.SHRINK_ELEMENT, !0, !1) && (O = CKEDITOR.dom.element.createFromHtml("\x3cspan\x3e\x26nbsp;\x3c/span\x3e",
                                    q.document), q.insertNode(O), q.setStartAfter(O)); V = new CKEDITOR.dom.elementPath(q.startContainer); E.endPath = aa = new CKEDITOR.dom.elementPath(q.endContainer); if (!q.collapsed) { D = aa.block || aa.blockLimit; var da = q.getCommonAncestor(); D && !D.equals(da) && !D.contains(da) && q.checkEndOfBlock() && E.zombies.push(D); q.deleteContents() } for (; (ba = e(q)) && a(ba) && ba.isBlockBoundary() && V.contains(ba);)q.moveToPosition(ba, CKEDITOR.POSITION_BEFORE_END); g(q, E.blockLimit, V, aa); O && (q.setEndBefore(O), q.collapse(), O.remove());
                                O = q.startPath(); if (D = O.contains(k, !1, 1)) W = q.splitElement(D), E.inlineStylesRoot = D, E.inlineStylesPeak = O.lastElement; O = q.createBookmark(); A && (c(D), c(W)); (D = O.startNode.getPrevious(b)) && a(D) && k(D) && r.push(D); (D = O.startNode.getNext(b)) && a(D) && k(D) && r.push(D); for (D = O.startNode; (D = D.getParent()) && k(D);)r.push(D); q.moveToBookmark(O); v.enterMode === CKEDITOR.ENTER_DIV && "" === v.getData(!0) && ((v = p.getFirst()) && v.remove(), x.setStartAt(p, CKEDITOR.POSITION_AFTER_START), x.collapse(!0)); if (p = t) {
                                    p = E.range; if ("text" ==
                                        E.type && E.inlineStylesRoot) { x = E.inlineStylesPeak; v = x.getDocument().createText("{cke-peak}"); for (W = E.inlineStylesRoot.getParent(); !x.equals(W);)v = v.appendTo(x.clone()), x = x.getParent(); t = v.getOuterHtml().split("{cke-peak}").join(t) } x = E.blockLimit.getName(); if (/^\s+|\s+$/.test(t) && "span" in CKEDITOR.dtd[x]) { var Z = '\x3cspan data-cke-marker\x3d"1"\x3e\x26nbsp;\x3c/span\x3e'; t = Z + t + Z } t = E.editor.dataProcessor.toHtml(t, {
                                            context: null, fixForBody: !1, protectedWhitespaces: !!Z, dontFilter: E.dontFilter, filter: E.editor.activeFilter,
                                            enterMode: E.editor.activeEnterMode
                                        }); x = p.document.createElement("body"); x.setHtml(t); Z && (x.getFirst().remove(), x.getLast().remove()); if ((Z = p.startPath().block) && (1 != Z.getChildCount() || !Z.getBogus())) a: { var Q; if (1 == x.getChildCount() && a(Q = x.getFirst()) && Q.is(w) && !Q.hasAttribute("contenteditable")) { Z = Q.getElementsByTag("*"); p = 0; for (W = Z.count(); p < W; p++)if (v = Z.getItem(p), !v.is(u)) break a; Q.moveChildren(Q.getParent(1)); Q.remove() } } E.dataWrapper = x; p = t
                                } if (p) {
                                    Q = E.range; p = Q.document; x = E.blockLimit; W = 0; var T,
                                        Z = [], S, L; t = O = 0; var ca, v = Q.startContainer; ba = E.endPath.elements[0]; var fa, q = ba.getPosition(v), r = !!ba.getCommonAncestor(v) && q != CKEDITOR.POSITION_IDENTICAL && !(q & CKEDITOR.POSITION_CONTAINS + CKEDITOR.POSITION_IS_CONTAINED), v = f(E.dataWrapper, E); for (n(v, Q); W < v.length; W++) {
                                            q = v[W]; if (A = q.isLineBreak) A = Q, D = x, aa = V = void 0, q.hasBlockSibling ? A = 1 : (V = A.startContainer.getAscendant(m.$block, 1)) && V.is({ div: 1, p: 1 }) ? (aa = V.getPosition(D), aa == CKEDITOR.POSITION_IDENTICAL || aa == CKEDITOR.POSITION_CONTAINS ? A = 0 : (D = A.splitElement(V),
                                                A.moveToPosition(D, CKEDITOR.POSITION_AFTER_START), A = 1)) : A = 0; if (A) t = 0 < W; else {
                                                    A = Q.startPath(); !q.isBlock && h(E.editor, A.block, A.blockLimit) && (L = l(E.editor)) && (L = p.createElement(L), L.appendBogus(), Q.insertNode(L), CKEDITOR.env.needsBrFiller && (T = L.getBogus()) && T.remove(), Q.moveToPosition(L, CKEDITOR.POSITION_BEFORE_END)); if ((A = Q.startPath().block) && !A.equals(S)) { if (T = A.getBogus()) T.remove(), Z.push(A); S = A } q.firstNotAllowed && (O = 1); if (O && q.isElement) {
                                                        A = Q.startContainer; for (D = null; A && !m[A.getName()][q.name];) {
                                                            if (A.equals(x)) {
                                                                A =
                                                                null; break
                                                            } D = A; A = A.getParent()
                                                        } if (A) D && (ca = Q.splitElement(D), E.zombies.push(ca), E.zombies.push(D)); else { D = x.getName(); fa = !W; A = W == v.length - 1; D = d(q.node, D); V = []; aa = D.length; for (var da = 0, ja = void 0, ga = 0, ea = -1; da < aa; da++)ja = D[da], " " == ja ? (ga || fa && !da || (V.push(new CKEDITOR.dom.text(" ")), ea = V.length), ga = 1) : (V.push(ja), ga = 0); A && ea == V.length && V.pop(); fa = V }
                                                    } if (fa) { for (; A = fa.pop();)Q.insertNode(A); fa = 0 } else Q.insertNode(q.node); q.lastNotAllowed && W < v.length - 1 && ((ca = r ? ba : ca) && Q.setEndAt(ca, CKEDITOR.POSITION_AFTER_START),
                                                        O = 0); Q.collapse()
                                                }
                                        } 1 != v.length ? T = !1 : (T = v[0], T = T.isElement && "false" == T.node.getAttribute("contenteditable")); T && (t = !0, A = v[0].node, Q.setStartAt(A, CKEDITOR.POSITION_BEFORE_START), Q.setEndAt(A, CKEDITOR.POSITION_AFTER_END)); E.dontMoveCaret = t; E.bogusNeededBlocks = Z
                                } T = E.range; var ia; ca = E.bogusNeededBlocks; for (fa = T.createBookmark(); S = E.zombies.pop();)S.getParent() && (L = T.clone(), L.moveToElementEditStart(S), L.removeEmptyBlocksAtEnd()); if (ca) for (; S = ca.pop();)CKEDITOR.env.needsBrFiller ? S.appendBogus() : S.append(T.document.createText(" "));
                                for (; S = E.mergeCandidates.pop();)S.mergeSiblings(); T.moveToBookmark(fa); if (!E.dontMoveCaret) { for (S = e(T); S && a(S) && !S.is(m.$empty);) { if (S.isBlockBoundary()) T.moveToPosition(S, CKEDITOR.POSITION_BEFORE_END); else { if (k(S) && S.getHtml().match(/(\s|&nbsp;)$/g)) { ia = null; break } ia = T.clone(); ia.moveToPosition(S, CKEDITOR.POSITION_BEFORE_END) } S = S.getLast(b) } ia && T.moveToRange(ia) }
                            }
                        }
                }(); x = function () {
                    function a(b) {
                        b = new CKEDITOR.dom.walker(b); b.guard = function (a, b) { if (b) return !1; if (a.type == CKEDITOR.NODE_ELEMENT) return a.is(CKEDITOR.dtd.$tableContent) };
                        b.evaluator = function (a) { return a.type == CKEDITOR.NODE_ELEMENT }; return b
                    } function b(a, c, f) { c = a.getDocument().createElement(c); a.append(c, f); return c } function c(a) { var b = a.count(), f; for (b; 0 < b--;)f = a.getItem(b), CKEDITOR.tools.trim(f.getHtml()) || (f.appendBogus(), CKEDITOR.env.ie && 9 > CKEDITOR.env.version && f.getChildCount() && f.getFirst().remove()) } return function (f) {
                        var d = f.startContainer, e = d.getAscendant("table", 1), k = !1; c(e.getElementsByTag("td")); c(e.getElementsByTag("th")); e = f.clone(); e.setStart(d, 0); e =
                            a(e).lastBackward(); e || (e = f.clone(), e.setEndAt(d, CKEDITOR.POSITION_BEFORE_END), e = a(e).lastForward(), k = !0); e || (e = d); e.is("table") ? (f.setStartAt(e, CKEDITOR.POSITION_BEFORE_START), f.collapse(!0), e.remove()) : (e.is({ tbody: 1, thead: 1, tfoot: 1 }) && (e = b(e, "tr", k)), e.is("tr") && (e = b(e, e.getParent().is("thead") ? "th" : "td", k)), (d = e.getBogus()) && d.remove(), f.moveToPosition(e, k ? CKEDITOR.POSITION_AFTER_START : CKEDITOR.POSITION_BEFORE_END))
                    }
                }(); u = function () {
                    function a(b) {
                        b = new CKEDITOR.dom.walker(b); b.guard = function (a,
                            b) { if (b) return !1; if (a.type == CKEDITOR.NODE_ELEMENT) return a.is(CKEDITOR.dtd.$list) || a.is(CKEDITOR.dtd.$listItem) }; b.evaluator = function (a) { return a.type == CKEDITOR.NODE_ELEMENT && a.is(CKEDITOR.dtd.$listItem) }; return b
                    } return function (b) {
                        var c = b.startContainer, f = !1, d; d = b.clone(); d.setStart(c, 0); d = a(d).lastBackward(); d || (d = b.clone(), d.setEndAt(c, CKEDITOR.POSITION_BEFORE_END), d = a(d).lastForward(), f = !0); d || (d = c); d.is(CKEDITOR.dtd.$list) ? (b.setStartAt(d, CKEDITOR.POSITION_BEFORE_START), b.collapse(!0), d.remove()) :
                            ((c = d.getBogus()) && c.remove(), b.moveToPosition(d, f ? CKEDITOR.POSITION_AFTER_START : CKEDITOR.POSITION_BEFORE_END), b.select())
                    }
                }(); A = {
                    eol: {
                        detect: function (a, b) {
                            var c = a.range, f = c.clone(), d = c.clone(), e = new CKEDITOR.dom.elementPath(c.startContainer, b), k = new CKEDITOR.dom.elementPath(c.endContainer, b); f.collapse(1); d.collapse(); e.block && f.checkBoundaryOfElement(e.block, CKEDITOR.END) && (c.setStartAfter(e.block), a.prependEolBr = 1); k.block && d.checkBoundaryOfElement(k.block, CKEDITOR.START) && (c.setEndBefore(k.block),
                                a.appendEolBr = 1)
                        }, fix: function (a, b) { var c = b.getDocument(), f; a.appendEolBr && (f = this.createEolBr(c), a.fragment.append(f)); !a.prependEolBr || f && !f.getPrevious() || a.fragment.append(this.createEolBr(c), 1) }, createEolBr: function (a) { return a.createElement("br", { attributes: { "data-cke-eol": 1 } }) }
                    }, bogus: { exclude: function (a) { var b = a.range.getBoundaryNodes(), c = b.startNode, b = b.endNode; !b || !q(b) || c && c.equals(b) || a.range.setEndBefore(b) } }, tree: {
                        rebuild: function (a, b) {
                            var c = a.range, f = c.getCommonAncestor(), d = new CKEDITOR.dom.elementPath(f,
                                b), e = new CKEDITOR.dom.elementPath(c.startContainer, b), c = new CKEDITOR.dom.elementPath(c.endContainer, b), k; f.type == CKEDITOR.NODE_TEXT && (f = f.getParent()); if (d.blockLimit.is({ tr: 1, table: 1 })) { var h = d.contains("table").getParent(); k = function (a) { return !a.equals(h) } } else if (d.block && d.block.is(CKEDITOR.dtd.$listItem) && (e = e.contains(CKEDITOR.dtd.$list), c = c.contains(CKEDITOR.dtd.$list), !e.equals(c))) { var g = d.contains(CKEDITOR.dtd.$list).getParent(); k = function (a) { return !a.equals(g) } } k || (k = function (a) {
                                    return !a.equals(d.block) &&
                                        !a.equals(d.blockLimit)
                                }); this.rebuildFragment(a, b, f, k)
                        }, rebuildFragment: function (a, b, c, f) { for (var d; c && !c.equals(b) && f(c);)d = c.clone(0, 1), a.fragment.appendTo(d), a.fragment = d, c = c.getParent() }
                    }, cell: { shrink: function (a) { a = a.range; var b = a.startContainer, c = a.endContainer, f = a.startOffset, d = a.endOffset; b.type == CKEDITOR.NODE_ELEMENT && b.equals(c) && b.is("tr") && ++f == d && a.shrink(CKEDITOR.SHRINK_TEXT) } }
                }; v = function () {
                    function a(b, c) { var f = b.getParent(); if (f.is(CKEDITOR.dtd.$inline)) b[c ? "insertBefore" : "insertAfter"](f) }
                    function b(c, f, d) { a(f); a(d, 1); for (var e; e = d.getNext();)e.insertAfter(f), f = e; t(c) && c.remove() } function c(a, b) { var f = new CKEDITOR.dom.range(a); f.setStartAfter(b.startNode); f.setEndBefore(b.endNode); return f } return {
                        list: {
                            detectMerge: function (a, b) {
                                var f = c(b, a.bookmark), d = f.startPath(), e = f.endPath(), k = d.contains(CKEDITOR.dtd.$list), h = e.contains(CKEDITOR.dtd.$list); a.mergeList = k && h && k.getParent().equals(h.getParent()) && !k.equals(h); a.mergeListItems = d.block && e.block && d.block.is(CKEDITOR.dtd.$listItem) &&
                                    e.block.is(CKEDITOR.dtd.$listItem); if (a.mergeList || a.mergeListItems) f = f.clone(), f.setStartBefore(a.bookmark.startNode), f.setEndAfter(a.bookmark.endNode), a.mergeListBookmark = f.createBookmark()
                            }, merge: function (a, c) {
                                if (a.mergeListBookmark) {
                                    var f = a.mergeListBookmark.startNode, d = a.mergeListBookmark.endNode, e = new CKEDITOR.dom.elementPath(f, c), k = new CKEDITOR.dom.elementPath(d, c); if (a.mergeList) { var h = e.contains(CKEDITOR.dtd.$list), g = k.contains(CKEDITOR.dtd.$list); h.equals(g) || (g.moveChildren(h), g.remove()) } a.mergeListItems &&
                                        (e = e.contains(CKEDITOR.dtd.$listItem), k = k.contains(CKEDITOR.dtd.$listItem), e.equals(k) || b(k, f, d)); f.remove(); d.remove()
                                }
                            }
                        }, block: {
                            detectMerge: function (a, b) { if (!a.tableContentsRanges && !a.mergeListBookmark) { var c = new CKEDITOR.dom.range(b); c.setStartBefore(a.bookmark.startNode); c.setEndAfter(a.bookmark.endNode); a.mergeBlockBookmark = c.createBookmark() } }, merge: function (a, c) {
                                if (a.mergeBlockBookmark && !a.purgeTableBookmark) {
                                    var f = a.mergeBlockBookmark.startNode, d = a.mergeBlockBookmark.endNode, e = new CKEDITOR.dom.elementPath(f,
                                        c), k = new CKEDITOR.dom.elementPath(d, c), e = e.block, k = k.block; e && k && !e.equals(k) && b(k, f, d); f.remove(); d.remove()
                                }
                            }
                        }, table: function () {
                            function a(c) {
                                var d = [], e, k = new CKEDITOR.dom.walker(c), h = c.startPath().contains(f), g = c.endPath().contains(f), l = {}; k.guard = function (a, k) {
                                    if (a.type == CKEDITOR.NODE_ELEMENT) { var n = "visited_" + (k ? "out" : "in"); if (a.getCustomData(n)) return; CKEDITOR.dom.element.setMarker(l, a, n, 1) } if (k && h && a.equals(h)) e = c.clone(), e.setEndAt(h, CKEDITOR.POSITION_BEFORE_END), d.push(e); else if (!k && g &&
                                        a.equals(g)) e = c.clone(), e.setStartAt(g, CKEDITOR.POSITION_AFTER_START), d.push(e); else { if (n = !k) n = a.type == CKEDITOR.NODE_ELEMENT && a.is(f) && (!h || b(a, h)) && (!g || b(a, g)); if (!n && (n = k)) if (a.is(f)) var n = h && h.getAscendant("table", !0), m = g && g.getAscendant("table", !0), p = a.getAscendant("table", !0), n = n && n.contains(p) || m && m.contains(p); else n = void 0; n && (e = c.clone(), e.selectNodeContents(a), d.push(e)) }
                                }; k.lastForward(); CKEDITOR.dom.element.clearAllMarkers(l); return d
                            } function b(a, c) {
                                var f = CKEDITOR.POSITION_CONTAINS +
                                    CKEDITOR.POSITION_IS_CONTAINED, d = a.getPosition(c); return d === CKEDITOR.POSITION_IDENTICAL ? !1 : 0 === (d & f)
                            } var f = { td: 1, th: 1, caption: 1 }; return {
                                detectPurge: function (a) {
                                    var b = a.range, c = b.clone(); c.enlarge(CKEDITOR.ENLARGE_ELEMENT); var c = new CKEDITOR.dom.walker(c), d = 0; c.evaluator = function (a) { a.type == CKEDITOR.NODE_ELEMENT && a.is(f) && ++d }; c.checkForward(); if (1 < d) {
                                        var c = b.startPath().contains("table"), e = b.endPath().contains("table"); c && e && b.checkBoundaryOfElement(c, CKEDITOR.START) && b.checkBoundaryOfElement(e,
                                            CKEDITOR.END) && (b = a.range.clone(), b.setStartBefore(c), b.setEndAfter(e), a.purgeTableBookmark = b.createBookmark())
                                    }
                                }, detectRanges: function (d, e) {
                                    var k = c(e, d.bookmark), h = k.clone(), g, l, n = k.getCommonAncestor(); n.is(CKEDITOR.dtd.$tableContent) && !n.is(f) && (n = n.getAscendant("table", !0)); l = n; n = new CKEDITOR.dom.elementPath(k.startContainer, l); l = new CKEDITOR.dom.elementPath(k.endContainer, l); n = n.contains("table"); l = l.contains("table"); if (n || l) n && l && b(n, l) ? (d.tableSurroundingRange = h, h.setStartAt(n, CKEDITOR.POSITION_AFTER_END),
                                        h.setEndAt(l, CKEDITOR.POSITION_BEFORE_START), h = k.clone(), h.setEndAt(n, CKEDITOR.POSITION_AFTER_END), g = k.clone(), g.setStartAt(l, CKEDITOR.POSITION_BEFORE_START), g = a(h).concat(a(g))) : n ? l || (d.tableSurroundingRange = h, h.setStartAt(n, CKEDITOR.POSITION_AFTER_END), k.setEndAt(n, CKEDITOR.POSITION_AFTER_END)) : (d.tableSurroundingRange = h, h.setEndAt(l, CKEDITOR.POSITION_BEFORE_START), k.setStartAt(l, CKEDITOR.POSITION_AFTER_START)), d.tableContentsRanges = g ? g : a(k)
                                }, deleteRanges: function (a) {
                                    for (var b; b = a.tableContentsRanges.pop();)b.extractContents(),
                                        t(b.startContainer) && b.startContainer.appendBogus(); a.tableSurroundingRange && a.tableSurroundingRange.extractContents()
                                }, purge: function (a) { if (a.purgeTableBookmark) { var b = a.doc, c = a.range.clone(), b = b.createElement("p"); b.insertBefore(a.purgeTableBookmark.startNode); c.moveToBookmark(a.purgeTableBookmark); c.deleteContents(); a.range.moveToPosition(b, CKEDITOR.POSITION_AFTER_START) } }
                            }
                        }(), detectExtractMerge: function (a) { return !(a.range.startPath().contains(CKEDITOR.dtd.$listItem) && a.range.endPath().contains(CKEDITOR.dtd.$listItem)) },
                        fixUneditableRangePosition: function (a) { a.startContainer.getDtd()["#"] || a.moveToClosestEditablePosition(null, !0) }, autoParagraph: function (a, b) { var c = b.startPath(), f; h(a, c.block, c.blockLimit) && (f = l(a)) && (f = b.document.createElement(f), f.appendBogus(), b.insertNode(f), b.moveToPosition(f, CKEDITOR.POSITION_AFTER_START)) }
                    }
                }()
            })(); (function () {
                function a(a) { return CKEDITOR.plugins.widget && CKEDITOR.plugins.widget.isDomWidget(a) } function g(b, c) {
                    if (0 === b.length || a(b[0].getEnclosedNode())) return !1; var f, d; if ((f =
                        !c && 1 === b.length) && !(f = b[0].collapsed)) { var e = b[0]; f = e.startContainer.getAscendant({ td: 1, th: 1 }, !0); var k = e.endContainer.getAscendant({ td: 1, th: 1 }, !0); d = CKEDITOR.tools.trim; f && f.equals(k) && !f.findOne("td, th, tr, tbody, table") ? (e = e.cloneContents(), f = e.getFirst() ? d(e.getFirst().getText()) !== d(f.getText()) : !0) : f = !1 } if (f) return !1; for (d = 0; d < b.length; d++)if (f = b[d]._getTableElement(), !f) return !1; return !0
                } function e(a) {
                    function b(a) {
                        a = a.find("td, th"); var c = [], f; for (f = 0; f < a.count(); f++)c.push(a.getItem(f));
                        return c
                    } var c = [], f, d; for (d = 0; d < a.length; d++)f = a[d]._getTableElement(), f.is && f.is({ td: 1, th: 1 }) ? c.push(f) : c = c.concat(b(f)); return c
                } function b(a) { a = e(a); var b = "", c = [], f, d; for (d = 0; d < a.length; d++)f && !f.equals(a[d].getAscendant("tr")) ? (b += c.join("\t") + "\n", f = a[d].getAscendant("tr"), c = []) : 0 === d && (f = a[d].getAscendant("tr")), c.push(a[d].getText()); return b += c.join("\t") } function d(a) {
                    var c = this.root.editor, f = c.getSelection(1); this.reset(); v = !0; f.root.once("selectionchange", function (a) { a.cancel() }, null, null,
                        0); f.selectRanges([a[0]]); f = this._.cache; f.ranges = new CKEDITOR.dom.rangeList(a); f.type = CKEDITOR.SELECTION_TEXT; f.selectedElement = a[0]._getTableElement(); f.selectedText = b(a); f.nativeSel = null; this.isFake = 1; this.rev = x++; c._.fakeSelection = this; v = !1; this.root.fire("selectionchange")
                } function m() {
                    var b = this._.fakeSelection, c; if (b) {
                        c = this.getSelection(1); var f; if (!(f = !c) && (f = !c.isHidden())) {
                            f = b; var d = c.getRanges(), e = f.getRanges(), k = d.length && d[0]._getTableElement() && d[0]._getTableElement().getAscendant("table",
                                !0), h = e.length && e[0]._getTableElement() && e[0]._getTableElement().getAscendant("table", !0), l = 1 === d.length && d[0]._getTableElement() && d[0]._getTableElement().is("table"), n = 1 === e.length && e[0]._getTableElement() && e[0]._getTableElement().is("table"); if (a(f.getSelectedElement())) f = !1; else { var m = 1 === d.length && d[0].collapsed, e = g(d, !!CKEDITOR.env.webkit) && g(e); k = k && h ? k.equals(h) || h.contains(k) : !1; k && (m || e) ? (l && !n && f.selectRanges(d), f = !0) : f = !1 } f = !f
                        } f && (b.reset(), b = 0)
                    } if (!b && (b = c || this.getSelection(1), !b || b.getType() ==
                        CKEDITOR.SELECTION_NONE)) return; this.fire("selectionCheck", b); c = this.elementPath(); c.compare(this._.selectionPreviousPath) || (f = this._.selectionPreviousPath && this._.selectionPreviousPath.blockLimit.equals(c.blockLimit), !CKEDITOR.env.webkit && !CKEDITOR.env.gecko || f || (this._.previousActive = this.document.getActive()), this._.selectionPreviousPath = c, this.fire("selectionChange", { selection: b, path: c }))
                } function h() { y = !0; z || (l.call(this), z = CKEDITOR.tools.setTimeout(l, 200, this)) } function l() {
                    z = null; y && (CKEDITOR.tools.setTimeout(m,
                        0, this), y = !1)
                } function c(a) { return B(a) || a.type == CKEDITOR.NODE_ELEMENT && !a.is(CKEDITOR.dtd.$empty) ? !0 : !1 } function k(a) { function b(c, f) { return c && c.type != CKEDITOR.NODE_TEXT ? a.clone()["moveToElementEdit" + (f ? "End" : "Start")](c) : !1 } if (!(a.root instanceof CKEDITOR.editable)) return !1; var f = a.startContainer, d = a.getPreviousNode(c, null, f), e = a.getNextNode(c, null, f); return b(d) || b(e, 1) || !(d || e || f.type == CKEDITOR.NODE_ELEMENT && f.isBlockBoundary() && f.getBogus()) ? !0 : !1 } function f(a) {
                    n(a, !1); var b = a.getDocument().createText(u);
                    a.setCustomData("cke-fillingChar", b); return b
                } function n(a, b) {
                    var c = a && a.removeCustomData("cke-fillingChar"); if (c) {
                        if (!1 !== b) { var f = a.getDocument().getSelection().getNative(), d = f && "None" != f.type && f.getRangeAt(0), e = u.length; if (c.getLength() > e && d && d.intersectsNode(c.$)) { var k = [{ node: f.anchorNode, offset: f.anchorOffset }, { node: f.focusNode, offset: f.focusOffset }]; f.anchorNode == c.$ && f.anchorOffset > e && (k[0].offset -= e); f.focusNode == c.$ && f.focusOffset > e && (k[1].offset -= e) } } c.setText(p(c.getText(), 1)); k && (c = a.getDocument().$,
                            f = c.getSelection(), c = c.createRange(), c.setStart(k[0].node, k[0].offset), c.collapse(!0), f.removeAllRanges(), f.addRange(c), f.extend(k[1].node, k[1].offset))
                    }
                } function p(a, b) { return b ? a.replace(A, function (a, b) { return b ? " " : "" }) : a.replace(u, "") } function t(a, b) {
                    var c = b && CKEDITOR.tools.htmlEncode(b) || "\x26nbsp;", c = CKEDITOR.dom.element.createFromHtml('\x3cdiv data-cke-hidden-sel\x3d"1" data-cke-temp\x3d"1" style\x3d"' + (CKEDITOR.env.ie && 14 > CKEDITOR.env.version ? "display:none" : "position:fixed;top:0;left:-1000px;width:0;height:0;overflow:hidden;") +
                        '"\x3e' + c + "\x3c/div\x3e", a.document); a.fire("lockSnapshot"); a.editable().append(c); var f = a.getSelection(1), d = a.createRange(), e = f.root.on("selectionchange", function (a) { a.cancel() }, null, null, 0); d.setStartAt(c, CKEDITOR.POSITION_AFTER_START); d.setEndAt(c, CKEDITOR.POSITION_BEFORE_END); f.selectRanges([d]); e.removeListener(); a.fire("unlockSnapshot"); a._.hiddenSelectionContainer = c
                } function q(a) {
                    var b = { 37: 1, 39: 1, 8: 1, 46: 1 }; return function (c) {
                        var f = c.data.getKeystroke(); if (b[f]) {
                            var d = a.getSelection().getRanges(),
                            e = d[0]; 1 == d.length && e.collapsed && (f = e[38 > f ? "getPreviousEditableNode" : "getNextEditableNode"]()) && f.type == CKEDITOR.NODE_ELEMENT && "false" == f.getAttribute("contenteditable") && (a.getSelection().fake(f), c.data.preventDefault(), c.cancel())
                        }
                    }
                } function r(a) {
                    for (var b = 0; b < a.length; b++) {
                        var c = a[b]; c.getCommonAncestor().isReadOnly() && a.splice(b, 1); if (!c.collapsed) {
                            if (c.startContainer.isReadOnly()) for (var f = c.startContainer, d; f && !((d = f.type == CKEDITOR.NODE_ELEMENT) && f.is("body") || !f.isReadOnly());)d && "false" ==
                                f.getAttribute("contentEditable") && c.setStartAfter(f), f = f.getParent(); f = c.startContainer; d = c.endContainer; var e = c.startOffset, k = c.endOffset, h = c.clone(); f && f.type == CKEDITOR.NODE_TEXT && (e >= f.getLength() ? h.setStartAfter(f) : h.setStartBefore(f)); d && d.type == CKEDITOR.NODE_TEXT && (k ? h.setEndAfter(d) : h.setEndBefore(d)); f = new CKEDITOR.dom.walker(h); f.evaluator = function (f) {
                                    if (f.type == CKEDITOR.NODE_ELEMENT && f.isReadOnly()) {
                                        var d = c.clone(); c.setEndBefore(f); c.collapsed && a.splice(b--, 1); f.getPosition(h.endContainer) &
                                            CKEDITOR.POSITION_CONTAINS || (d.setStartAfter(f), d.collapsed || a.splice(b + 1, 0, d)); return !0
                                    } return !1
                                }; f.next()
                        }
                    } return a
                } var w = "function" != typeof window.getSelection, x = 1, u = CKEDITOR.tools.repeat("​", 7), A = new RegExp(u + "( )?", "g"), v, z, y, B = CKEDITOR.dom.walker.invisible(1), C = function () {
                    function a(b) { return function (a) { var c = a.editor.createRange(); c.moveToClosestEditablePosition(a.selected, b) && a.editor.getSelection().selectRanges([c]); return !1 } } function b(a) {
                        return function (b) {
                            var c = b.editor, f = c.createRange(),
                            d; if (!c.readOnly) return (d = f.moveToClosestEditablePosition(b.selected, a)) || (d = f.moveToClosestEditablePosition(b.selected, !a)), d && c.getSelection().selectRanges([f]), c.fire("saveSnapshot"), b.selected.remove(), d || (f.moveToElementEditablePosition(c.editable()), c.getSelection().selectRanges([f])), c.fire("saveSnapshot"), !1
                        }
                    } var c = a(), f = a(1); return { 37: c, 38: c, 39: f, 40: f, 8: b(), 46: b(1) }
                }(); CKEDITOR.on("instanceCreated", function (a) {
                    function b() { var a = c.getSelection(); a && a.removeAllRanges() } var c = a.editor; c.on("contentDom",
                        function () {
                            function a() { t = new CKEDITOR.dom.selection(c.getSelection()); t.lock() } function b() { k.removeListener("mouseup", b); p.removeListener("mouseup", b); var a = CKEDITOR.document.$.selection, c = a.createRange(); "None" != a.type && c.parentElement() && c.parentElement().ownerDocument == e.$ && c.select() } function f(a) { var b, c; b = (b = this.document.getActive()) ? "input" === b.getName() || "textarea" === b.getName() : !1; b || (b = this.getSelection(1), (c = d(b)) && !c.equals(g) && (b.selectElement(c), a.data.preventDefault())) } function d(a) {
                                a =
                                a.getRanges()[0]; return a ? (a = a.startContainer.getAscendant(function (a) { return a.type == CKEDITOR.NODE_ELEMENT && a.hasAttribute("contenteditable") }, !0)) && "false" === a.getAttribute("contenteditable") ? a : null : null
                            } var e = c.document, k = CKEDITOR.document, g = c.editable(), l = e.getBody(), p = e.getDocumentElement(), u = g.isInline(), x, t; CKEDITOR.env.gecko && g.attachListener(g, "focus", function (a) {
                                a.removeListener(); 0 !== x && (a = c.getSelection().getNative()) && a.isCollapsed && a.anchorNode == g.$ && (a = c.createRange(), a.moveToElementEditStart(g),
                                    a.select())
                            }, null, null, -2); g.attachListener(g, CKEDITOR.env.webkit || CKEDITOR.env.gecko ? "focusin" : "focus", function () { if (x && (CKEDITOR.env.webkit || CKEDITOR.env.gecko)) { x = c._.previousActive && c._.previousActive.equals(e.getActive()); var a = null != c._.previousScrollTop && c._.previousScrollTop != g.$.scrollTop; CKEDITOR.env.webkit && x && a && (g.$.scrollTop = c._.previousScrollTop) } c.unlockSelection(x); x = 0 }, null, null, -1); g.attachListener(g, "mousedown", function () { x = 0 }); if (CKEDITOR.env.ie || CKEDITOR.env.gecko || u) w ? g.attachListener(g,
                                "beforedeactivate", a, null, null, -1) : g.attachListener(c, "selectionCheck", a, null, null, -1), g.attachListener(g, CKEDITOR.env.webkit || CKEDITOR.env.gecko ? "focusout" : "blur", function () { var a = t && (t.isFake || 2 > t.getRanges().length); CKEDITOR.env.gecko && !u && a || (c.lockSelection(t), x = 1) }, null, null, -1), g.attachListener(g, "mousedown", function () { x = 0 }); if (CKEDITOR.env.ie && !u) {
                                    var y; g.attachListener(g, "mousedown", function (a) { 2 == a.data.$.button && ((a = c.document.getSelection()) && a.getType() != CKEDITOR.SELECTION_NONE || (y = c.window.getScrollPosition())) });
                                    g.attachListener(g, "mouseup", function (a) { 2 == a.data.$.button && y && (c.document.$.documentElement.scrollLeft = y.x, c.document.$.documentElement.scrollTop = y.y); y = null }); if ("BackCompat" != e.$.compatMode) {
                                        if (CKEDITOR.env.ie7Compat || CKEDITOR.env.ie6Compat) {
                                            var v, r; p.on("mousedown", function (a) {
                                                function b(a) { a = a.data.$; if (v) { var c = l.$.createTextRange(); try { c.moveToPoint(a.clientX, a.clientY) } catch (f) { } v.setEndPoint(0 > r.compareEndPoints("StartToStart", c) ? "EndToEnd" : "StartToStart", c); v.select() } } function c() {
                                                    p.removeListener("mousemove",
                                                        b); k.removeListener("mouseup", c); p.removeListener("mouseup", c); v.select()
                                                } a = a.data; if (a.getTarget().is("html") && a.$.y < p.$.clientHeight && a.$.x < p.$.clientWidth) { v = l.$.createTextRange(); try { v.moveToPoint(a.$.clientX, a.$.clientY) } catch (f) { } r = v.duplicate(); p.on("mousemove", b); k.on("mouseup", c); p.on("mouseup", c) }
                                            })
                                        } if (7 < CKEDITOR.env.version && 11 > CKEDITOR.env.version) p.on("mousedown", function (a) { a.data.getTarget().is("html") && (k.on("mouseup", b), p.on("mouseup", b)) })
                                    }
                                } g.attachListener(g, "selectionchange", m,
                                    c); g.attachListener(g, "keyup", h, c); g.attachListener(g, "touchstart", h, c); g.attachListener(g, "touchend", h, c); CKEDITOR.env.ie && g.attachListener(g, "keydown", f, c); g.attachListener(g, CKEDITOR.env.webkit || CKEDITOR.env.gecko ? "focusin" : "focus", function () { c.forceNextSelectionCheck(); c.selectionChange(1) }); if (u && (CKEDITOR.env.webkit || CKEDITOR.env.gecko)) { var A; g.attachListener(g, "mousedown", function () { A = 1 }); g.attachListener(e.getDocumentElement(), "mouseup", function () { A && h.call(c); A = 0 }) } else g.attachListener(CKEDITOR.env.ie ?
                                        g : e.getDocumentElement(), "mouseup", h, c); CKEDITOR.env.webkit && g.attachListener(e, "keydown", function (a) { switch (a.data.getKey()) { case 13: case 33: case 34: case 35: case 36: case 37: case 39: case 8: case 45: case 46: g.hasFocus && n(g) } }, null, null, -1); g.attachListener(g, "keydown", q(c), null, null, -1)
                        }); c.on("setData", function () { c.unlockSelection(); CKEDITOR.env.webkit && b() }); c.on("contentDomUnload", function () { c.unlockSelection() }); if (CKEDITOR.env.ie9Compat) c.on("beforeDestroy", b, null, null, 9); c.on("dataReady", function () {
                            delete c._.fakeSelection;
                            delete c._.hiddenSelectionContainer; c.selectionChange(1)
                        }); c.on("loadSnapshot", function () { var a = CKEDITOR.dom.walker.nodeType(CKEDITOR.NODE_ELEMENT), b = c.editable().getLast(a); b && b.hasAttribute("data-cke-hidden-sel") && (b.remove(), CKEDITOR.env.gecko && (a = c.editable().getFirst(a)) && a.is("br") && a.getAttribute("_moz_editor_bogus_node") && a.remove()) }, null, null, 100); c.on("key", function (a) {
                            if ("wysiwyg" == c.mode) {
                                var b = c.getSelection(); if (b.isFake) {
                                    var f = C[a.data.keyCode]; if (f) return f({
                                        editor: c, selected: b.getSelectedElement(),
                                        selection: b, keyEvent: a
                                    })
                                }
                            }
                        })
                }); if (CKEDITOR.env.webkit) CKEDITOR.on("instanceReady", function (a) {
                    var b = a.editor; b.on("selectionChange", function () { var a = b.editable(), c = a.getCustomData("cke-fillingChar"); c && (c.getCustomData("ready") ? (n(a), a.editor.fire("selectionCheck")) : c.setCustomData("ready", 1)) }, null, null, -1); b.on("beforeSetMode", function () { n(b.editable()) }, null, null, -1); b.on("getSnapshot", function (a) { a.data && (a.data = p(a.data)) }, b, null, 20); b.on("toDataFormat", function (a) { a.data.dataValue = p(a.data.dataValue) },
                        null, null, 0)
                }); CKEDITOR.editor.prototype.selectionChange = function (a) { (a ? m : h).call(this) }; CKEDITOR.editor.prototype.getSelection = function (a) { return !this._.savedSelection && !this._.fakeSelection || a ? (a = this.editable()) && "wysiwyg" == this.mode ? new CKEDITOR.dom.selection(a) : null : this._.savedSelection || this._.fakeSelection }; CKEDITOR.editor.prototype.getSelectedRanges = function (a) { var b = this.getSelection(); return b && b.getRanges(a) || [] }; CKEDITOR.editor.prototype.lockSelection = function (a) {
                    a = a || this.getSelection(1);
                    return a.getType() != CKEDITOR.SELECTION_NONE ? (!a.isLocked && a.lock(), this._.savedSelection = a, !0) : !1
                }; CKEDITOR.editor.prototype.unlockSelection = function (a) { var b = this._.savedSelection; return b ? (b.unlock(a), delete this._.savedSelection, !0) : !1 }; CKEDITOR.editor.prototype.forceNextSelectionCheck = function () { delete this._.selectionPreviousPath }; CKEDITOR.dom.document.prototype.getSelection = function () { return new CKEDITOR.dom.selection(this) }; CKEDITOR.dom.range.prototype.select = function () {
                    var a = this.root instanceof
                        CKEDITOR.editable ? this.root.editor.getSelection() : new CKEDITOR.dom.selection(this.root); a.selectRanges([this]); return a
                }; CKEDITOR.SELECTION_NONE = 1; CKEDITOR.SELECTION_TEXT = 2; CKEDITOR.SELECTION_ELEMENT = 3; CKEDITOR.dom.selection = function (a) {
                    if (a instanceof CKEDITOR.dom.selection) { var b = a; a = a.root } var c = a instanceof CKEDITOR.dom.element; this.rev = b ? b.rev : x++; this.document = a instanceof CKEDITOR.dom.document ? a : a.getDocument(); this.root = c ? a : this.document.getBody(); this.isLocked = 0; this._ = { cache: {} }; if (b) return CKEDITOR.tools.extend(this._.cache,
                        b._.cache), this.isFake = b.isFake, this.isLocked = b.isLocked, this; a = this.getNative(); var f, d; if (a) if (a.getRangeAt) f = (d = a.rangeCount && a.getRangeAt(0)) && new CKEDITOR.dom.node(d.commonAncestorContainer); else { try { d = a.createRange() } catch (e) { } f = d && CKEDITOR.dom.element.get(d.item && d.item(0) || d.parentElement()) } if (!f || f.type != CKEDITOR.NODE_ELEMENT && f.type != CKEDITOR.NODE_TEXT || !this.root.equals(f) && !this.root.contains(f)) this._.cache.type = CKEDITOR.SELECTION_NONE, this._.cache.startElement = null, this._.cache.selectedElement =
                            null, this._.cache.selectedText = "", this._.cache.ranges = new CKEDITOR.dom.rangeList; return this
                }; var F = { img: 1, hr: 1, li: 1, table: 1, tr: 1, td: 1, th: 1, embed: 1, object: 1, ol: 1, ul: 1, a: 1, input: 1, form: 1, select: 1, textarea: 1, button: 1, fieldset: 1, thead: 1, tfoot: 1 }; CKEDITOR.tools.extend(CKEDITOR.dom.selection, { _removeFillingCharSequenceString: p, _createFillingCharSequenceNode: f, FILLING_CHAR_SEQUENCE: u }); CKEDITOR.dom.selection.prototype = {
                    getNative: function () {
                        return void 0 !== this._.cache.nativeSel ? this._.cache.nativeSel : this._.cache.nativeSel =
                            w ? this.document.$.selection : this.document.getWindow().$.getSelection()
                    }, getType: w ? function () { var a = this._.cache; if (a.type) return a.type; var b = CKEDITOR.SELECTION_NONE; try { var c = this.getNative(), f = c.type; "Text" == f && (b = CKEDITOR.SELECTION_TEXT); "Control" == f && (b = CKEDITOR.SELECTION_ELEMENT); c.createRange().parentElement() && (b = CKEDITOR.SELECTION_TEXT) } catch (d) { } return a.type = b } : function () {
                        var a = this._.cache; if (a.type) return a.type; var b = CKEDITOR.SELECTION_TEXT, c = this.getNative(); if (!c || !c.rangeCount) b = CKEDITOR.SELECTION_NONE;
                        else if (1 == c.rangeCount) { var c = c.getRangeAt(0), f = c.startContainer; f == c.endContainer && 1 == f.nodeType && 1 == c.endOffset - c.startOffset && F[f.childNodes[c.startOffset].nodeName.toLowerCase()] && (b = CKEDITOR.SELECTION_ELEMENT) } return a.type = b
                    }, getRanges: function () {
                        var a = w ? function () {
                            function a(b) { return (new CKEDITOR.dom.node(b)).getIndex() } var b = function (b, c) {
                                b = b.duplicate(); b.collapse(c); var f = b.parentElement(); if (!f.hasChildNodes()) return { container: f, offset: 0 }; for (var d = f.children, e, k, h = b.duplicate(), g = 0,
                                    l = d.length - 1, n = -1, m, p; g <= l;)if (n = Math.floor((g + l) / 2), e = d[n], h.moveToElementText(e), m = h.compareEndPoints("StartToStart", b), 0 < m) l = n - 1; else if (0 > m) g = n + 1; else return { container: f, offset: a(e) }; if (-1 == n || n == d.length - 1 && 0 > m) {
                                        h.moveToElementText(f); h.setEndPoint("StartToStart", b); h = h.text.replace(/(\r\n|\r)/g, "\n").length; d = f.childNodes; if (!h) return e = d[d.length - 1], e.nodeType != CKEDITOR.NODE_TEXT ? { container: f, offset: d.length } : { container: e, offset: e.nodeValue.length }; for (f = d.length; 0 < h && 0 < f;)k = d[--f], k.nodeType ==
                                            CKEDITOR.NODE_TEXT && (p = k, h -= k.nodeValue.length); return { container: p, offset: -h }
                                    } h.collapse(0 < m ? !0 : !1); h.setEndPoint(0 < m ? "StartToStart" : "EndToStart", b); h = h.text.replace(/(\r\n|\r)/g, "\n").length; if (!h) return { container: f, offset: a(e) + (0 < m ? 0 : 1) }; for (; 0 < h;)try { k = e[0 < m ? "previousSibling" : "nextSibling"], k.nodeType == CKEDITOR.NODE_TEXT && (h -= k.nodeValue.length, p = k), e = k } catch (w) { return { container: f, offset: a(e) } } return { container: p, offset: 0 < m ? -h : p.nodeValue.length + h }
                            }; return function () {
                                var a = this.getNative(), c = a &&
                                    a.createRange(), f = this.getType(); if (!a) return []; if (f == CKEDITOR.SELECTION_TEXT) return a = new CKEDITOR.dom.range(this.root), f = b(c, !0), a.setStart(new CKEDITOR.dom.node(f.container), f.offset), f = b(c), a.setEnd(new CKEDITOR.dom.node(f.container), f.offset), a.endContainer.getPosition(a.startContainer) & CKEDITOR.POSITION_PRECEDING && a.endOffset <= a.startContainer.getIndex() && a.collapse(), [a]; if (f == CKEDITOR.SELECTION_ELEMENT) {
                                        for (var f = [], d = 0; d < c.length; d++) {
                                            for (var e = c.item(d), k = e.parentNode, h = 0, a = new CKEDITOR.dom.range(this.root); h <
                                                k.childNodes.length && k.childNodes[h] != e; h++); a.setStart(new CKEDITOR.dom.node(k), h); a.setEnd(new CKEDITOR.dom.node(k), h + 1); f.push(a)
                                        } return f
                                    } return []
                            }
                        }() : function () { var a = [], b, c = this.getNative(); if (!c) return a; for (var f = 0; f < c.rangeCount; f++) { var d = c.getRangeAt(f); b = new CKEDITOR.dom.range(this.root); b.setStart(new CKEDITOR.dom.node(d.startContainer), d.startOffset); b.setEnd(new CKEDITOR.dom.node(d.endContainer), d.endOffset); a.push(b) } return a }; return function (b) {
                            var c = this._.cache, f = c.ranges; f || (c.ranges =
                                f = new CKEDITOR.dom.rangeList(a.call(this))); return b ? r(new CKEDITOR.dom.rangeList(f.slice())) : f
                        }
                    }(), getStartElement: function () {
                        var a = this._.cache; if (void 0 !== a.startElement) return a.startElement; var b; switch (this.getType()) {
                            case CKEDITOR.SELECTION_ELEMENT: return this.getSelectedElement(); case CKEDITOR.SELECTION_TEXT: var c = this.getRanges()[0]; if (c) {
                                if (c.collapsed) b = c.startContainer, b.type != CKEDITOR.NODE_ELEMENT && (b = b.getParent()); else {
                                    for (c.optimize(); b = c.startContainer, c.startOffset == (b.getChildCount ?
                                        b.getChildCount() : b.getLength()) && !b.isBlockBoundary();)c.setStartAfter(b); b = c.startContainer; if (b.type != CKEDITOR.NODE_ELEMENT) return b.getParent(); if ((b = b.getChild(c.startOffset)) && b.type == CKEDITOR.NODE_ELEMENT) for (c = b.getFirst(); c && c.type == CKEDITOR.NODE_ELEMENT;)b = c, c = c.getFirst(); else b = c.startContainer
                                } b = b.$
                            }
                        }return a.startElement = b ? new CKEDITOR.dom.element(b) : null
                    }, getSelectedElement: function () {
                        var a = this._.cache; if (void 0 !== a.selectedElement) return a.selectedElement; var b = this, c = CKEDITOR.tools.tryThese(function () { return b.getNative().createRange().item(0) },
                            function () { for (var a = b.getRanges()[0].clone(), c, f, d = 2; d && !((c = a.getEnclosedNode()) && c.type == CKEDITOR.NODE_ELEMENT && F[c.getName()] && (f = c)); d--)a.shrink(CKEDITOR.SHRINK_ELEMENT); return f && f.$ }); return a.selectedElement = c ? new CKEDITOR.dom.element(c) : null
                    }, getSelectedText: function () { var a = this._.cache; if (void 0 !== a.selectedText) return a.selectedText; var b = this.getNative(), b = w ? "Control" == b.type ? "" : b.createRange().text : b.toString(); return a.selectedText = b }, lock: function () {
                        this.getRanges(); this.getStartElement();
                        this.getSelectedElement(); this.getSelectedText(); this._.cache.nativeSel = null; this.isLocked = 1
                    }, unlock: function (a) { if (this.isLocked) { if (a) var b = this.getSelectedElement(), c = this.getRanges(), f = this.isFake; this.isLocked = 0; this.reset(); a && (a = b || c[0] && c[0].getCommonAncestor()) && a.getAscendant("body", 1) && (this.root.editor.plugins.tableselection && g(c) ? d.call(this, c) : f ? this.fake(b) : b && 2 > c.length ? this.selectElement(b) : this.selectRanges(c)) } }, reset: function () {
                        this._.cache = {}; this.isFake = 0; var a = this.root.editor;
                        if (a && a._.fakeSelection) if (this.rev == a._.fakeSelection.rev) { delete a._.fakeSelection; var b = a._.hiddenSelectionContainer; if (b) { var c = a.checkDirty(); a.fire("lockSnapshot"); b.remove(); a.fire("unlockSnapshot"); !c && a.resetDirty() } delete a._.hiddenSelectionContainer } else CKEDITOR.warn("selection-fake-reset"); this.rev = x++
                    }, selectElement: function (a) { var b = new CKEDITOR.dom.range(this.root); b.setStartBefore(a); b.setEndAfter(a); this.selectRanges([b]) }, selectRanges: function (a) {
                        var b = this.root.editor, c = b && b._.hiddenSelectionContainer;
                        this.reset(); if (c) for (var c = this.root, e, h = 0; h < a.length; ++h)e = a[h], e.endContainer.equals(c) && (e.endOffset = Math.min(e.endOffset, c.getChildCount())); if (a.length) if (this.isLocked) { var l = CKEDITOR.document.getActive(); this.unlock(); this.selectRanges(a); this.lock(); l && !l.equals(this.root) && l.focus() } else {
                            var m; a: {
                                var p, u; if (1 == a.length && !(u = a[0]).collapsed && (m = u.getEnclosedNode()) && m.type == CKEDITOR.NODE_ELEMENT && (u = u.clone(), u.shrink(CKEDITOR.SHRINK_ELEMENT, !0), (p = u.getEnclosedNode()) && p.type == CKEDITOR.NODE_ELEMENT &&
                                    (m = p), "false" == m.getAttribute("contenteditable"))) break a; m = void 0
                            } if (m) this.fake(m); else if (b && b.plugins.tableselection && b.plugins.tableselection.isSupportedEnvironment() && g(a) && !v && !a[0]._getTableElement({ table: 1 }).hasAttribute("data-cke-tableselection-ignored")) d.call(this, a); else {
                                if (w) {
                                    p = CKEDITOR.dom.walker.whitespaces(!0); m = /\ufeff|\u00a0/; u = { table: 1, tbody: 1, tr: 1 }; 1 < a.length && (b = a[a.length - 1], a[0].setEnd(b.endContainer, b.endOffset)); b = a[0]; a = b.collapsed; var x, t, y; if ((c = b.getEnclosedNode()) &&
                                        c.type == CKEDITOR.NODE_ELEMENT && c.getName() in F && (!c.is("a") || !c.getText())) try { y = c.$.createControlRange(); y.addElement(c.$); y.select(); return } catch (q) { } if (b.startContainer.type == CKEDITOR.NODE_ELEMENT && b.startContainer.getName() in u || b.endContainer.type == CKEDITOR.NODE_ELEMENT && b.endContainer.getName() in u) b.shrink(CKEDITOR.NODE_ELEMENT, !0), a = b.collapsed; y = b.createBookmark(); u = y.startNode; a || (l = y.endNode); y = b.document.$.body.createTextRange(); y.moveToElementText(u.$); y.moveStart("character", 1); l ? (m =
                                            b.document.$.body.createTextRange(), m.moveToElementText(l.$), y.setEndPoint("EndToEnd", m), y.moveEnd("character", -1)) : (x = u.getNext(p), t = u.hasAscendant("pre"), x = !(x && x.getText && x.getText().match(m)) && (t || !u.hasPrevious() || u.getPrevious().is && u.getPrevious().is("br")), t = b.document.createElement("span"), t.setHtml("\x26#65279;"), t.insertBefore(u), x && b.document.createText("﻿").insertBefore(u)); b.setStartBefore(u); u.remove(); a ? (x ? (y.moveStart("character", -1), y.select(), b.document.$.selection.clear()) : y.select(),
                                                b.moveToPosition(t, CKEDITOR.POSITION_BEFORE_START), t.remove()) : (b.setEndBefore(l), l.remove(), y.select())
                                } else {
                                    l = this.getNative(); if (!l) return; this.removeAllRanges(); for (y = 0; y < a.length; y++) {
                                        if (y < a.length - 1 && (x = a[y], t = a[y + 1], m = x.clone(), m.setStart(x.endContainer, x.endOffset), m.setEnd(t.startContainer, t.startOffset), !m.collapsed && (m.shrink(CKEDITOR.NODE_ELEMENT, !0), b = m.getCommonAncestor(), m = m.getEnclosedNode(), b.isReadOnly() || m && m.isReadOnly()))) {
                                            t.setStart(x.startContainer, x.startOffset); a.splice(y--,
                                                1); continue
                                        } b = a[y]; t = this.document.$.createRange(); b.collapsed && CKEDITOR.env.webkit && k(b) && (m = f(this.root), b.insertNode(m), (x = m.getNext()) && !m.getPrevious() && x.type == CKEDITOR.NODE_ELEMENT && "br" == x.getName() ? (n(this.root), b.moveToPosition(x, CKEDITOR.POSITION_BEFORE_START)) : b.moveToPosition(m, CKEDITOR.POSITION_AFTER_END)); t.setStart(b.startContainer.$, b.startOffset); try { t.setEnd(b.endContainer.$, b.endOffset) } catch (r) {
                                            if (0 <= r.toString().indexOf("NS_ERROR_ILLEGAL_VALUE")) b.collapse(1), t.setEnd(b.endContainer.$,
                                                b.endOffset); else throw r;
                                        } l.addRange(t)
                                    }
                                } this.reset(); this.root.fire("selectionchange")
                            }
                        }
                    }, fake: function (a, b) {
                        var c = this.root.editor; void 0 === b && a.hasAttribute("aria-label") && (b = a.getAttribute("aria-label")); this.reset(); t(c, b); var f = this._.cache, d = new CKEDITOR.dom.range(this.root); d.setStartBefore(a); d.setEndAfter(a); f.ranges = new CKEDITOR.dom.rangeList(d); f.selectedElement = f.startElement = a; f.type = CKEDITOR.SELECTION_ELEMENT; f.selectedText = f.nativeSel = null; this.isFake = 1; this.rev = x++; c._.fakeSelection =
                            this; this.root.fire("selectionchange")
                    }, isHidden: function () { var a = this.getCommonAncestor(); a && a.type == CKEDITOR.NODE_TEXT && (a = a.getParent()); return !(!a || !a.data("cke-hidden-sel")) }, isInTable: function (a) { return g(this.getRanges(), a) }, isCollapsed: function () { var a = this.getRanges(); return 1 === a.length && a[0].collapsed }, createBookmarks: function (a) { a = this.getRanges().createBookmarks(a); this.isFake && (a.isFake = 1); return a }, createBookmarks2: function (a) {
                        a = this.getRanges().createBookmarks2(a); this.isFake && (a.isFake =
                            1); return a
                    }, selectBookmarks: function (a) { for (var b = [], c, f = 0; f < a.length; f++) { var d = new CKEDITOR.dom.range(this.root); d.moveToBookmark(a[f]); b.push(d) } a.isFake && (c = g(b) ? b[0]._getTableElement() : b[0].getEnclosedNode(), c && c.type == CKEDITOR.NODE_ELEMENT || (CKEDITOR.warn("selection-not-fake"), a.isFake = 0)); a.isFake && !g(b) ? this.fake(c) : this.selectRanges(b); return this }, getCommonAncestor: function () { var a = this.getRanges(); return a.length ? a[0].startContainer.getCommonAncestor(a[a.length - 1].endContainer) : null },
                    scrollIntoView: function () { this.type != CKEDITOR.SELECTION_NONE && this.getRanges()[0].scrollIntoView() }, removeAllRanges: function () { if (this.getType() != CKEDITOR.SELECTION_NONE) { var a = this.getNative(); try { a && a[w ? "empty" : "removeAllRanges"]() } catch (b) { } this.reset() } }
                }
            })(); "use strict"; CKEDITOR.STYLE_BLOCK = 1; CKEDITOR.STYLE_INLINE = 2; CKEDITOR.STYLE_OBJECT = 3; (function () {
                function a(a, b) {
                    for (var c, f; (a = a.getParent()) && !a.equals(b);)if (a.getAttribute("data-nostyle")) c = a; else if (!f) {
                        var d = a.getAttribute("contentEditable");
                        "false" == d ? c = a : "true" == d && (f = 1)
                    } return c
                } function g(a, b, c, f) { return (a.getPosition(b) | f) == f && (!c.childRule || c.childRule(a)) } function e(b) {
                    var c = b.document; if (b.collapsed) c = x(this, c), b.insertNode(c), b.moveToPosition(c, CKEDITOR.POSITION_BEFORE_END); else {
                        var f = this.element, k = this._.definition, h, l = k.ignoreReadonly, n = l || k.includeReadonly; null == n && (n = b.root.getCustomData("cke_includeReadonly")); var m = CKEDITOR.dtd[f]; m || (h = !0, m = CKEDITOR.dtd.span); b.enlarge(CKEDITOR.ENLARGE_INLINE, 1); b.trim(); var p = b.createBookmark(),
                            u = p.startNode, w = p.endNode, t = u, y; if (!l) { var v = b.getCommonAncestor(), l = a(u, v), v = a(w, v); l && (t = l.getNextSourceNode(!0)); v && (w = v) } for (t.getPosition(w) == CKEDITOR.POSITION_FOLLOWING && (t = 0); t;) {
                                l = !1; if (t.equals(w)) t = null, l = !0; else {
                                    var r = t.type == CKEDITOR.NODE_ELEMENT ? t.getName() : null, v = r && "false" == t.getAttribute("contentEditable"), A = r && t.getAttribute("data-nostyle"); if (r && t.data("cke-bookmark") || t.type === CKEDITOR.NODE_COMMENT) { t = t.getNextSourceNode(!0); continue } if (v && n && CKEDITOR.dtd.$block[r]) for (var z = t,
                                        B = d(z), F = void 0, L = B.length, ca = 0, z = L && new CKEDITOR.dom.range(z.getDocument()); ca < L; ++ca) { var F = B[ca], fa = CKEDITOR.filter.instances[F.data("cke-filter")]; if (fa ? fa.check(this) : 1) z.selectNodeContents(F), e.call(this, z) } B = r ? !m[r] || A ? 0 : v && !n ? 0 : g(t, w, k, M) : 1; if (B) if (F = t.getParent(), B = k, L = f, ca = h, !F || !(F.getDtd() || CKEDITOR.dtd.span)[L] && !ca || B.parentRule && !B.parentRule(F)) l = !0; else {
                                            if (y || r && CKEDITOR.dtd.$removeEmpty[r] && (t.getPosition(w) | M) != M || (y = b.clone(), y.setStartBefore(t)), r = t.type, r == CKEDITOR.NODE_TEXT ||
                                                v || r == CKEDITOR.NODE_ELEMENT && !t.getChildCount()) { for (var r = t, C; (l = !r.getNext(H)) && (C = r.getParent(), m[C.getName()]) && g(C, u, k, J);)r = C; y.setEndAfter(r) }
                                        } else l = !0; t = t.getNextSourceNode(A || v)
                                } if (l && y && !y.collapsed) {
                                    for (var l = x(this, c), v = l.hasAttributes(), A = y.getCommonAncestor(), r = {}, B = {}, F = {}, L = {}, ga, ea, I; l && A;) {
                                        if (A.getName() == f) {
                                            for (ga in k.attributes) !L[ga] && (I = A.getAttribute(ea)) && (l.getAttribute(ga) == I ? B[ga] = 1 : L[ga] = 1); for (ea in k.styles) !F[ea] && (I = A.getStyle(ea)) && (l.getStyle(ea) == I ? r[ea] = 1 : F[ea] =
                                                1)
                                        } A = A.getParent()
                                    } for (ga in B) l.removeAttribute(ga); for (ea in r) l.removeStyle(ea); v && !l.hasAttributes() && (l = null); l ? (y.extractContents().appendTo(l), y.insertNode(l), q.call(this, l), l.mergeSiblings(), CKEDITOR.env.ie || l.$.normalize()) : (l = new CKEDITOR.dom.element("span"), y.extractContents().appendTo(l), y.insertNode(l), q.call(this, l), l.remove(!0)); y = null
                                }
                            } b.moveToBookmark(p); b.shrink(CKEDITOR.SHRINK_TEXT); b.shrink(CKEDITOR.NODE_ELEMENT, !0)
                    }
                } function b(a) {
                    function b() {
                        for (var a = new CKEDITOR.dom.elementPath(f.getParent()),
                            c = new CKEDITOR.dom.elementPath(n.getParent()), d = null, e = null, k = 0; k < a.elements.length; k++) { var h = a.elements[k]; if (h == a.block || h == a.blockLimit) break; m.checkElementRemovable(h, !0) && (d = h) } for (k = 0; k < c.elements.length; k++) { h = c.elements[k]; if (h == c.block || h == c.blockLimit) break; m.checkElementRemovable(h, !0) && (e = h) } e && n.breakParent(e); d && f.breakParent(d)
                    } a.enlarge(CKEDITOR.ENLARGE_INLINE, 1); var c = a.createBookmark(), f = c.startNode, d = this._.definition.alwaysRemoveElement; if (a.collapsed) {
                        for (var e = new CKEDITOR.dom.elementPath(f.getParent(),
                            a.root), k, h = 0, g; h < e.elements.length && (g = e.elements[h]) && g != e.block && g != e.blockLimit; h++)if (this.checkElementRemovable(g)) { var l; !d && a.collapsed && (a.checkBoundaryOfElement(g, CKEDITOR.END) || (l = a.checkBoundaryOfElement(g, CKEDITOR.START))) ? (k = g, k.match = l ? "start" : "end") : (g.mergeSiblings(), g.is(this.element) ? t.call(this, g) : r(g, v(this)[g.getName()])) } if (k) { d = f; for (h = 0; ; h++) { g = e.elements[h]; if (g.equals(k)) break; else if (g.match) continue; else g = g.clone(); g.append(d); d = g } d["start" == k.match ? "insertBefore" : "insertAfter"](k) }
                    } else {
                        var n =
                            c.endNode, m = this; b(); for (e = f; !e.equals(n);)k = e.getNextSourceNode(), e.type == CKEDITOR.NODE_ELEMENT && this.checkElementRemovable(e) && (e.getName() == this.element ? t.call(this, e) : r(e, v(this)[e.getName()]), k.type == CKEDITOR.NODE_ELEMENT && k.contains(f) && (b(), k = f.getNext())), e = k
                    } a.moveToBookmark(c); a.shrink(CKEDITOR.NODE_ELEMENT, !0)
                } function d(a) { var b = []; a.forEach(function (a) { if ("true" == a.getAttribute("contenteditable")) return b.push(a), !1 }, CKEDITOR.NODE_ELEMENT, !0); return b } function m(a) {
                    var b = a.getEnclosedNode() ||
                        a.getCommonAncestor(!1, !0); (a = (new CKEDITOR.dom.elementPath(b, a.root)).contains(this.element, 1)) && !a.isReadOnly() && u(a, this)
                } function h(a) { var b = a.getCommonAncestor(!0, !0); if (a = (new CKEDITOR.dom.elementPath(b, a.root)).contains(this.element, 1)) { var b = this._.definition, c = b.attributes; if (c) for (var f in c) a.removeAttribute(f, c[f]); if (b.styles) for (var d in b.styles) b.styles.hasOwnProperty(d) && a.removeStyle(d) } } function l(a) {
                    var b = a.createBookmark(!0), c = a.createIterator(); c.enforceRealBlocks = !0; this._.enterMode &&
                        (c.enlargeBr = this._.enterMode != CKEDITOR.ENTER_BR); for (var f, d = a.document, e; f = c.getNextParagraph();)!f.isReadOnly() && (c.activeFilter ? c.activeFilter.check(this) : 1) && (e = x(this, d, f), k(f, e)); a.moveToBookmark(b)
                } function c(a) {
                    var b = a.createBookmark(1), c = a.createIterator(); c.enforceRealBlocks = !0; c.enlargeBr = this._.enterMode != CKEDITOR.ENTER_BR; for (var f, d; f = c.getNextParagraph();)this.checkElementRemovable(f) && (f.is("pre") ? ((d = this._.enterMode == CKEDITOR.ENTER_BR ? null : a.document.createElement(this._.enterMode ==
                        CKEDITOR.ENTER_P ? "p" : "div")) && f.copyAttributes(d), k(f, d)) : t.call(this, f)); a.moveToBookmark(b)
                } function k(a, b) {
                    var c = !b; c && (b = a.getDocument().createElement("div"), a.copyAttributes(b)); var d = b && b.is("pre"), e = a.is("pre"), k = !d && e; if (d && !e) {
                        e = b; (k = a.getBogus()) && k.remove(); k = a.getHtml(); k = n(k, /(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g, ""); k = k.replace(/[ \t\r\n]*(<br[^>]*>)[ \t\r\n]*/gi, "$1"); k = k.replace(/([ \t\n\r]+|&nbsp;)/g, " "); k = k.replace(/<br\b[^>]*>/gi, "\n"); if (CKEDITOR.env.ie) {
                            var h = a.getDocument().createElement("div");
                            h.append(e); e.$.outerHTML = "\x3cpre\x3e" + k + "\x3c/pre\x3e"; e.copyAttributes(h.getFirst()); e = h.getFirst().remove()
                        } else e.setHtml(k); b = e
                    } else k ? b = p(c ? [a.getHtml()] : f(a), b) : a.moveChildren(b); b.replace(a); if (d) { var c = b, g; (g = c.getPrevious(D)) && g.type == CKEDITOR.NODE_ELEMENT && g.is("pre") && (d = n(g.getHtml(), /\n$/, "") + "\n\n" + n(c.getHtml(), /^\n/, ""), CKEDITOR.env.ie ? c.$.outerHTML = "\x3cpre\x3e" + d + "\x3c/pre\x3e" : c.setHtml(d), g.remove()) } else c && w(b)
                } function f(a) {
                    var b = []; n(a.getOuterHtml(), /(\S\s*)\n(?:\s|(<span[^>]+data-cke-bookmark.*?\/span>))*\n(?!$)/gi,
                        function (a, b, c) { return b + "\x3c/pre\x3e" + c + "\x3cpre\x3e" }).replace(/<pre\b.*?>([\s\S]*?)<\/pre>/gi, function (a, c) { b.push(c) }); return b
                } function n(a, b, c) { var f = "", d = ""; a = a.replace(/(^<span[^>]+data-cke-bookmark.*?\/span>)|(<span[^>]+data-cke-bookmark.*?\/span>$)/gi, function (a, b, c) { b && (f = b); c && (d = c); return "" }); return f + a.replace(b, c) + d } function p(a, b) {
                    var c; 1 < a.length && (c = new CKEDITOR.dom.documentFragment(b.getDocument())); for (var f = 0; f < a.length; f++) {
                        var d = a[f], d = d.replace(/(\r\n|\r)/g, "\n"), d = n(d, /^[ \t]*\n/,
                            ""), d = n(d, /\n$/, ""), d = n(d, /^[ \t]+|[ \t]+$/g, function (a, b) { return 1 == a.length ? "\x26nbsp;" : b ? " " + CKEDITOR.tools.repeat("\x26nbsp;", a.length - 1) : CKEDITOR.tools.repeat("\x26nbsp;", a.length - 1) + " " }), d = d.replace(/\n/g, "\x3cbr\x3e"), d = d.replace(/[ \t]{2,}/g, function (a) { return CKEDITOR.tools.repeat("\x26nbsp;", a.length - 1) + " " }); if (c) { var e = b.clone(); e.setHtml(d); c.append(e) } else b.setHtml(d)
                    } return c || b
                } function t(a, b) {
                    var c = this._.definition, f = c.attributes, c = c.styles, d = v(this)[a.getName()], e = CKEDITOR.tools.isEmpty(f) &&
                        CKEDITOR.tools.isEmpty(c), k; for (k in f) if ("class" != k && !this._.definition.fullMatch || a.getAttribute(k) == z(k, f[k])) b && "data-" == k.slice(0, 5) || (e = a.hasAttribute(k), a.removeAttribute(k)); for (var h in c) this._.definition.fullMatch && a.getStyle(h) != z(h, c[h], !0) || (e = e || !!a.getStyle(h), a.removeStyle(h)); r(a, d, C[a.getName()]); e && (this._.definition.alwaysRemoveElement ? w(a, 1) : !CKEDITOR.dtd.$block[a.getName()] || this._.enterMode == CKEDITOR.ENTER_BR && !a.hasAttributes() ? w(a) : a.renameNode(this._.enterMode == CKEDITOR.ENTER_P ?
                            "p" : "div"))
                } function q(a) { for (var b = v(this), c = a.getElementsByTag(this.element), f, d = c.count(); 0 <= --d;)f = c.getItem(d), f.isReadOnly() || t.call(this, f, !0); for (var e in b) if (e != this.element) for (c = a.getElementsByTag(e), d = c.count() - 1; 0 <= d; d--)f = c.getItem(d), f.isReadOnly() || r(f, b[e]) } function r(a, b, c) { if (b = b && b.attributes) for (var f = 0; f < b.length; f++) { var d = b[f][0], e; if (e = a.getAttribute(d)) { var k = b[f][1]; (null === k || k.test && k.test(e) || "string" == typeof k && e == k) && a.removeAttribute(d) } } c || w(a) } function w(a, b) {
                    if (!a.hasAttributes() ||
                        b) if (CKEDITOR.dtd.$block[a.getName()]) { var c = a.getPrevious(D), f = a.getNext(D); !c || c.type != CKEDITOR.NODE_TEXT && c.isBlockBoundary({ br: 1 }) || a.append("br", 1); !f || f.type != CKEDITOR.NODE_TEXT && f.isBlockBoundary({ br: 1 }) || a.append("br"); a.remove(!0) } else c = a.getFirst(), f = a.getLast(), a.remove(!0), c && (c.type == CKEDITOR.NODE_ELEMENT && c.mergeSiblings(), f && !c.equals(f) && f.type == CKEDITOR.NODE_ELEMENT && f.mergeSiblings())
                } function x(a, b, c) {
                    var f; f = a.element; "*" == f && (f = "span"); f = new CKEDITOR.dom.element(f, b); c && c.copyAttributes(f);
                    f = u(f, a); b.getCustomData("doc_processing_style") && f.hasAttribute("id") ? f.removeAttribute("id") : b.setCustomData("doc_processing_style", 1); return f
                } function u(a, b) { var c = b._.definition, f = c.attributes, c = CKEDITOR.style.getStyleText(c); if (f) for (var d in f) a.setAttribute(d, f[d]); c && a.setAttribute("style", c); a.getDocument().removeCustomData("doc_processing_style"); return a } function A(a, b) { for (var c in a) a[c] = a[c].replace(I, function (a, c) { return b[c] }) } function v(a) {
                    if (a._.overrides) return a._.overrides; var b =
                        a._.overrides = {}, c = a._.definition.overrides; if (c) { CKEDITOR.tools.isArray(c) || (c = [c]); for (var f = 0; f < c.length; f++) { var d = c[f], e, k; "string" == typeof d ? e = d.toLowerCase() : (e = d.element ? d.element.toLowerCase() : a.element, k = d.attributes); d = b[e] || (b[e] = {}); if (k) { var d = d.attributes = d.attributes || [], h; for (h in k) d.push([h.toLowerCase(), k[h]]) } } } return b
                } function z(a, b, c) { var f = new CKEDITOR.dom.element("span"); f[c ? "setStyle" : "setAttribute"](a, b); return f[c ? "getStyle" : "getAttribute"](a) } function y(a, b) {
                    function c(a,
                        b) { return "font-family" == b.toLowerCase() ? a.replace(/["']/g, "") : a } "string" == typeof a && (a = CKEDITOR.tools.parseCssText(a)); "string" == typeof b && (b = CKEDITOR.tools.parseCssText(b, !0)); for (var f in a) if (!(f in b) || c(b[f], f) != c(a[f], f) && "inherit" != a[f] && "inherit" != b[f]) return !1; return !0
                } function B(a, b, c) { var f = a.getRanges(); b = b ? this.removeFromRange : this.applyToRange; for (var d, e = f.createIterator(); d = e.getNextRange();)b.call(this, d, c); a.selectRanges(f) } var C = {
                    address: 1, div: 1, h1: 1, h2: 1, h3: 1, h4: 1, h5: 1, h6: 1, p: 1,
                    pre: 1, section: 1, header: 1, footer: 1, nav: 1, article: 1, aside: 1, figure: 1, dialog: 1, hgroup: 1, time: 1, meter: 1, menu: 1, command: 1, keygen: 1, output: 1, progress: 1, details: 1, datagrid: 1, datalist: 1
                }, F = { a: 1, blockquote: 1, embed: 1, hr: 1, img: 1, li: 1, object: 1, ol: 1, table: 1, td: 1, tr: 1, th: 1, ul: 1, dl: 1, dt: 1, dd: 1, form: 1, audio: 1, video: 1 }, G = /\s*(?:;\s*|$)/, I = /#\((.+?)\)/g, H = CKEDITOR.dom.walker.bookmark(0, 1), D = CKEDITOR.dom.walker.whitespaces(1); CKEDITOR.style = function (a, b) {
                    if ("string" == typeof a.type) return new CKEDITOR.style.customHandlers[a.type](a);
                    var c = a.attributes; c && c.style && (a.styles = CKEDITOR.tools.extend({}, a.styles, CKEDITOR.tools.parseCssText(c.style)), delete c.style); b && (a = CKEDITOR.tools.clone(a), A(a.attributes, b), A(a.styles, b)); c = this.element = a.element ? "string" == typeof a.element ? a.element.toLowerCase() : a.element : "*"; this.type = a.type || (C[c] ? CKEDITOR.STYLE_BLOCK : F[c] ? CKEDITOR.STYLE_OBJECT : CKEDITOR.STYLE_INLINE); "object" == typeof this.element && (this.type = CKEDITOR.STYLE_OBJECT); this._ = { definition: a }
                }; CKEDITOR.style.prototype = {
                    apply: function (a) {
                        if (a instanceof
                            CKEDITOR.dom.document) return B.call(this, a.getSelection()); if (this.checkApplicable(a.elementPath(), a)) { var b = this._.enterMode; b || (this._.enterMode = a.activeEnterMode); B.call(this, a.getSelection(), 0, a); this._.enterMode = b }
                    }, remove: function (a) { if (a instanceof CKEDITOR.dom.document) return B.call(this, a.getSelection(), 1); if (this.checkApplicable(a.elementPath(), a)) { var b = this._.enterMode; b || (this._.enterMode = a.activeEnterMode); B.call(this, a.getSelection(), 1, a); this._.enterMode = b } }, applyToRange: function (a) {
                        this.applyToRange =
                        this.type == CKEDITOR.STYLE_INLINE ? e : this.type == CKEDITOR.STYLE_BLOCK ? l : this.type == CKEDITOR.STYLE_OBJECT ? m : null; return this.applyToRange(a)
                    }, removeFromRange: function (a) { this.removeFromRange = this.type == CKEDITOR.STYLE_INLINE ? b : this.type == CKEDITOR.STYLE_BLOCK ? c : this.type == CKEDITOR.STYLE_OBJECT ? h : null; return this.removeFromRange(a) }, applyToObject: function (a) { u(a, this) }, checkActive: function (a, b) {
                        switch (this.type) {
                            case CKEDITOR.STYLE_BLOCK: return this.checkElementRemovable(a.block || a.blockLimit, !0, b); case CKEDITOR.STYLE_OBJECT: case CKEDITOR.STYLE_INLINE: for (var c =
                                a.elements, f = 0, d; f < c.length; f++)if (d = c[f], this.type != CKEDITOR.STYLE_INLINE || d != a.block && d != a.blockLimit) { if (this.type == CKEDITOR.STYLE_OBJECT) { var e = d.getName(); if (!("string" == typeof this.element ? e == this.element : e in this.element)) continue } if (this.checkElementRemovable(d, !0, b)) return !0 }
                        }return !1
                    }, checkApplicable: function (a, b, c) { b && b instanceof CKEDITOR.filter && (c = b); if (c && !c.check(this)) return !1; switch (this.type) { case CKEDITOR.STYLE_OBJECT: return !!a.contains(this.element); case CKEDITOR.STYLE_BLOCK: return !!a.blockLimit.getDtd()[this.element] }return !0 },
                    checkElementMatch: function (a, b) {
                        var c = this._.definition; if (!a || !c.ignoreReadonly && a.isReadOnly()) return !1; var f = a.getName(); if ("string" == typeof this.element ? f == this.element : f in this.element) {
                            if (!b && !a.hasAttributes()) return !0; if (f = c._AC) c = f; else { var f = {}, d = 0, e = c.attributes; if (e) for (var k in e) d++, f[k] = e[k]; if (k = CKEDITOR.style.getStyleText(c)) f.style || d++, f.style = k; f._length = d; c = c._AC = f } if (c._length) {
                                for (var h in c) if ("_length" != h) if (f = a.getAttribute(h) || "", "style" == h ? y(c[h], f) : c[h] == f) { if (!b) return !0 } else if (b) return !1;
                                if (b) return !0
                            } else return !0
                        } return !1
                    }, checkElementRemovable: function (a, b, c) { if (this.checkElementMatch(a, b, c)) return !0; if (b = v(this)[a.getName()]) { var f; if (!(b = b.attributes)) return !0; for (c = 0; c < b.length; c++)if (f = b[c][0], f = a.getAttribute(f)) { var d = b[c][1]; if (null === d) return !0; if ("string" == typeof d) { if (f == d) return !0 } else if (d.test(f)) return !0 } } return !1 }, buildPreview: function (a) {
                        var b = this._.definition, c = [], f = b.element; "bdo" == f && (f = "span"); var c = ["\x3c", f], d = b.attributes; if (d) for (var e in d) c.push(" ",
                            e, '\x3d"', d[e], '"'); (d = CKEDITOR.style.getStyleText(b)) && c.push(' style\x3d"', d, '"'); c.push("\x3e", a || b.name, "\x3c/", f, "\x3e"); return c.join("")
                    }, getDefinition: function () { return this._.definition }
                }; CKEDITOR.style.getStyleText = function (a) { var b = a._ST; if (b) return b; var b = a.styles, c = a.attributes && a.attributes.style || "", f = ""; c.length && (c = c.replace(G, ";")); for (var d in b) { var e = b[d], k = (d + ":" + e).replace(G, ";"); "inherit" == e ? f += k : c += k } c.length && (c = CKEDITOR.tools.normalizeCssText(c, !0)); return a._ST = c + f }; CKEDITOR.style.customHandlers =
                    {}; CKEDITOR.style.addCustomHandler = function (a) { var b = function (a) { this._ = { definition: a }; this.setup && this.setup(a) }; b.prototype = CKEDITOR.tools.extend(CKEDITOR.tools.prototypedCopy(CKEDITOR.style.prototype), { assignedTo: CKEDITOR.STYLE_OBJECT }, a, !0); return this.customHandlers[a.type] = b }; var M = CKEDITOR.POSITION_PRECEDING | CKEDITOR.POSITION_IDENTICAL | CKEDITOR.POSITION_IS_CONTAINED, J = CKEDITOR.POSITION_FOLLOWING | CKEDITOR.POSITION_IDENTICAL | CKEDITOR.POSITION_IS_CONTAINED
            })(); CKEDITOR.styleCommand = function (a,
                g) { this.requiredContent = this.allowedContent = this.style = a; CKEDITOR.tools.extend(this, g, !0) }; CKEDITOR.styleCommand.prototype.exec = function (a) { a.focus(); this.state == CKEDITOR.TRISTATE_OFF ? a.applyStyle(this.style) : this.state == CKEDITOR.TRISTATE_ON && a.removeStyle(this.style) }; CKEDITOR.stylesSet = new CKEDITOR.resourceManager("", "stylesSet"); CKEDITOR.addStylesSet = CKEDITOR.tools.bind(CKEDITOR.stylesSet.add, CKEDITOR.stylesSet); CKEDITOR.loadStylesSet = function (a, g, e) {
                    CKEDITOR.stylesSet.addExternal(a, g, ""); CKEDITOR.stylesSet.load(a,
                        e)
                }; CKEDITOR.tools.extend(CKEDITOR.editor.prototype, {
                    attachStyleStateChange: function (a, g) { var e = this._.styleStateChangeCallbacks; e || (e = this._.styleStateChangeCallbacks = [], this.on("selectionChange", function (a) { for (var d = 0; d < e.length; d++) { var g = e[d], h = g.style.checkActive(a.data.path, this) ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF; g.fn.call(this, h) } })); e.push({ style: a, fn: g }) }, applyStyle: function (a) { a.apply(this) }, removeStyle: function (a) { a.remove(this) }, getStylesSet: function (a) {
                        if (this._.stylesDefinitions) a(this._.stylesDefinitions);
                        else { var g = this, e = g.config.stylesCombo_stylesSet || g.config.stylesSet; if (!1 === e) a(null); else if (e instanceof Array) g._.stylesDefinitions = e, a(e); else { e || (e = "default"); var e = e.split(":"), b = e[0]; CKEDITOR.stylesSet.addExternal(b, e[1] ? e.slice(1).join(":") : CKEDITOR.getUrl("styles.js"), ""); CKEDITOR.stylesSet.load(b, function (d) { g._.stylesDefinitions = d[b]; a(g._.stylesDefinitions) }) } }
                    }
                }); (function () {
                    if (window.Promise) CKEDITOR.tools.promise = Promise; else {
                        var a = CKEDITOR.getUrl("vendor/promise.js"); if ("function" ===
                            typeof window.define && window.define.amd && "function" === typeof window.require) return window.require([a], function (a) { CKEDITOR.tools.promise = a }); CKEDITOR.scriptLoader.load(a, function (g) { if (!g) return CKEDITOR.error("no-vendor-lib", { path: a }); if ("undefined" !== typeof window.ES6Promise) return CKEDITOR.tools.promise = ES6Promise })
                    }
                })(); (function () {
                    function a(a, d, m) { a.once("selectionCheck", function (a) { if (!g) { var b = a.data.getRanges()[0]; m.equals(b) ? a.cancel() : d.equals(b) && (e = !0) } }, null, null, -1) } var g = !0, e = !1; CKEDITOR.dom.selection.setupEditorOptimization =
                        function (a) { a.on("selectionCheck", function (a) { a.data && !e && a.data.optimizeInElementEnds(); e = !1 }); a.on("contentDom", function () { var d = a.editable(); d && (d.attachListener(d, "keydown", function (a) { this._.shiftPressed = a.data.$.shiftKey }, this), d.attachListener(d, "keyup", function (a) { this._.shiftPressed = a.data.$.shiftKey }, this)) }) }; CKEDITOR.dom.selection.prototype.optimizeInElementEnds = function () {
                            var b = this.getRanges()[0], d = this.root.editor, e; if (this.root.editor._.shiftPressed || this.isFake || b.isCollapsed || b.startContainer.equals(b.endContainer)) e =
                                !1; else if (0 === b.endOffset) e = !0; else { e = b.startContainer.type === CKEDITOR.NODE_TEXT; var h = b.endContainer.type === CKEDITOR.NODE_TEXT, l = e ? b.startContainer.getLength() : b.startContainer.getChildCount(); e = b.startOffset === l || e ^ h } e && (e = b.clone(), b.shrink(CKEDITOR.SHRINK_TEXT, !1, { skipBogus: !CKEDITOR.env.webkit }), g = !1, a(d, b, e), b.select(), g = !0)
                        }
                })(); CKEDITOR.dom.comment = function (a, g) { "string" == typeof a && (a = (g ? g.$ : document).createComment(a)); CKEDITOR.dom.domObject.call(this, a) }; CKEDITOR.dom.comment.prototype = new CKEDITOR.dom.node;
        CKEDITOR.tools.extend(CKEDITOR.dom.comment.prototype, { type: CKEDITOR.NODE_COMMENT, getOuterHtml: function () { return "\x3c!--" + this.$.nodeValue + "--\x3e" } }); "use strict"; (function () {
            var a = {}, g = {}, e; for (e in CKEDITOR.dtd.$blockLimit) e in CKEDITOR.dtd.$list || (a[e] = 1); for (e in CKEDITOR.dtd.$block) e in CKEDITOR.dtd.$blockLimit || e in CKEDITOR.dtd.$empty || (g[e] = 1); CKEDITOR.dom.elementPath = function (b, d) {
                var e = null, h = null, l = [], c = b, k; d = d || b.getDocument().getBody(); c || (c = d); do if (c.type == CKEDITOR.NODE_ELEMENT) {
                    l.push(c);
                    if (!this.lastElement && (this.lastElement = c, c.is(CKEDITOR.dtd.$object) || "false" == c.getAttribute("contenteditable"))) continue; if (c.equals(d)) break; if (!h && (k = c.getName(), "true" == c.getAttribute("contenteditable") ? h = c : !e && g[k] && (e = c), a[k])) { if (k = !e && "div" == k) { a: { k = c.getChildren(); for (var f = 0, n = k.count(); f < n; f++) { var p = k.getItem(f); if (p.type == CKEDITOR.NODE_ELEMENT && CKEDITOR.dtd.$block[p.getName()]) { k = !0; break a } } k = !1 } k = !k } k ? e = c : h = c }
                } while (c = c.getParent()); h || (h = d); this.block = e; this.blockLimit = h; this.root =
                    d; this.elements = l
            }
        })(); CKEDITOR.dom.elementPath.prototype = {
            compare: function (a) { var g = this.elements; a = a && a.elements; if (!a || g.length != a.length) return !1; for (var e = 0; e < g.length; e++)if (!g[e].equals(a[e])) return !1; return !0 }, contains: function (a, g, e) {
                var b = 0, d; "string" == typeof a && (d = function (b) { return b.getName() == a }); a instanceof CKEDITOR.dom.element ? d = function (b) { return b.equals(a) } : CKEDITOR.tools.isArray(a) ? d = function (b) { return -1 < CKEDITOR.tools.indexOf(a, b.getName()) } : "function" == typeof a ? d = a : "object" ==
                    typeof a && (d = function (b) { return b.getName() in a }); var m = this.elements, h = m.length; g && (e ? b += 1 : --h); e && (m = Array.prototype.slice.call(m, 0), m.reverse()); for (; b < h; b++)if (d(m[b])) return m[b]; return null
            }, isContextFor: function (a) { var g; return a in CKEDITOR.dtd.$block ? (g = this.contains(CKEDITOR.dtd.$intermediate) || this.root.equals(this.block) && this.block || this.blockLimit, !!g.getDtd()[a]) : !0 }, direction: function () { return (this.block || this.blockLimit || this.root).getDirection(1) }
        }; CKEDITOR.dom.text = function (a, g) {
            "string" ==
            typeof a && (a = (g ? g.$ : document).createTextNode(a)); this.$ = a
        }; CKEDITOR.dom.text.prototype = new CKEDITOR.dom.node; CKEDITOR.tools.extend(CKEDITOR.dom.text.prototype, {
            type: CKEDITOR.NODE_TEXT, getLength: function () { return this.$.nodeValue.length }, getText: function () { return this.$.nodeValue }, setText: function (a) { this.$.nodeValue = a }, isEmpty: function (a) { var g = this.getText(); a && (g = CKEDITOR.tools.trim(g)); return !g || g === CKEDITOR.dom.selection.FILLING_CHAR_SEQUENCE }, split: function (a) {
                var g = this.$.parentNode, e = g.childNodes.length,
                b = this.getLength(), d = this.getDocument(), m = new CKEDITOR.dom.text(this.$.splitText(a), d); g.childNodes.length == e && (a >= b ? (m = d.createText(""), m.insertAfter(this)) : (a = d.createText(""), a.insertAfter(m), a.remove())); return m
            }, substring: function (a, g) { return "number" != typeof g ? this.$.nodeValue.substr(a) : this.$.nodeValue.substring(a, g) }
        }); (function () {
            function a(a, b, d) {
                var g = a.serializable, h = b[d ? "endContainer" : "startContainer"], l = d ? "endOffset" : "startOffset", c = g ? b.document.getById(a.startNode) : a.startNode; a = g ?
                    b.document.getById(a.endNode) : a.endNode; h.equals(c.getPrevious()) ? (b.startOffset = b.startOffset - h.getLength() - a.getPrevious().getLength(), h = a.getNext()) : h.equals(a.getPrevious()) && (b.startOffset -= h.getLength(), h = a.getNext()); h.equals(c.getParent()) && b[l]++; h.equals(a.getParent()) && b[l]++; b[d ? "endContainer" : "startContainer"] = h; return b
            } CKEDITOR.dom.rangeList = function (a) { if (a instanceof CKEDITOR.dom.rangeList) return a; a ? a instanceof CKEDITOR.dom.range && (a = [a]) : a = []; return CKEDITOR.tools.extend(a, g) };
            var g = {
                createIterator: function () {
                    var a = this, b = CKEDITOR.dom.walker.bookmark(), d = [], g; return {
                        getNextRange: function (h) {
                            g = void 0 === g ? 0 : g + 1; var l = a[g]; if (l && 1 < a.length) {
                                if (!g) for (var c = a.length - 1; 0 <= c; c--)d.unshift(a[c].createBookmark(!0)); if (h) for (var k = 0; a[g + k + 1];) { var f = l.document; h = 0; c = f.getById(d[k].endNode); for (f = f.getById(d[k + 1].startNode); ;) { c = c.getNextSourceNode(!1); if (f.equals(c)) h = 1; else if (b(c) || c.type == CKEDITOR.NODE_ELEMENT && c.isBlockBoundary()) continue; break } if (!h) break; k++ } for (l.moveToBookmark(d.shift()); k--;)c =
                                    a[++g], c.moveToBookmark(d.shift()), l.setEnd(c.endContainer, c.endOffset)
                            } return l
                        }
                    }
                }, createBookmarks: function (e) { for (var b = [], d, g = 0; g < this.length; g++) { b.push(d = this[g].createBookmark(e, !0)); for (var h = g + 1; h < this.length; h++)this[h] = a(d, this[h]), this[h] = a(d, this[h], !0) } return b }, createBookmarks2: function (a) { for (var b = [], d = 0; d < this.length; d++)b.push(this[d].createBookmark2(a)); return b }, moveToBookmarks: function (a) { for (var b = 0; b < this.length; b++)this[b].moveToBookmark(a[b]) }
            }
        })(); (function () {
            function a() {
                return CKEDITOR.getUrl(CKEDITOR.skinName.split(",")[1] ||
                    "skins/" + CKEDITOR.skinName.split(",")[0] + "/")
            } function g(b) { var c = CKEDITOR.skin["ua_" + b], d = CKEDITOR.env; if (c) for (var c = c.split(",").sort(function (a, b) { return a > b ? -1 : 1 }), e = 0, h; e < c.length; e++)if (h = c[e], d.ie && (h.replace(/^ie/, "") == d.version || d.quirks && "iequirks" == h) && (h = "ie"), d[h]) { b += "_" + c[e]; break } return CKEDITOR.getUrl(a() + b + ".css") } function e(a, b) { m[a] || (CKEDITOR.document.appendStyleSheet(g(a)), m[a] = 1); b && b() } function b(a) {
                var b = a.getById(h); b || (b = a.getHead().append("style"), b.setAttribute("id",
                    h), b.setAttribute("type", "text/css")); return b
            } function d(a, b, c) { var d, e, h; if (CKEDITOR.env.webkit) for (b = b.split("}").slice(0, -1), e = 0; e < b.length; e++)b[e] = b[e].split("{"); for (var g = 0; g < a.length; g++)if (CKEDITOR.env.webkit) for (e = 0; e < b.length; e++) { h = b[e][1]; for (d = 0; d < c.length; d++)h = h.replace(c[d][0], c[d][1]); a[g].$.sheet.addRule(b[e][0], h) } else { h = b; for (d = 0; d < c.length; d++)h = h.replace(c[d][0], c[d][1]); CKEDITOR.env.ie && 11 > CKEDITOR.env.version ? a[g].$.styleSheet.cssText += h : a[g].$.innerHTML += h } } var m = {}; CKEDITOR.skin =
            {
                path: a, loadPart: function (b, c) { CKEDITOR.skin.name != CKEDITOR.skinName.split(",")[0] ? CKEDITOR.scriptLoader.load(CKEDITOR.getUrl(a() + "skin.js"), function () { e(b, c) }) : e(b, c) }, getPath: function (a) { return CKEDITOR.getUrl(g(a)) }, icons: {}, addIcon: function (a, b, c, d) { a = a.toLowerCase(); this.icons[a] || (this.icons[a] = { path: b, offset: c || 0, bgsize: d || "16px" }) }, getIconStyle: function (a, b, c, d, e) {
                    var h; a && (a = a.toLowerCase(), b && (h = this.icons[a + "-rtl"]), h || (h = this.icons[a])); a = c || h && h.path || ""; d = d || h && h.offset; e = e || h && h.bgsize ||
                        "16px"; a && (a = a.replace(/'/g, "\\'")); return a && "background-image:url('" + CKEDITOR.getUrl(a) + "');background-position:0 " + d + "px;background-size:" + e + ";"
                }
            }; CKEDITOR.tools.extend(CKEDITOR.editor.prototype, { getUiColor: function () { return this.uiColor }, setUiColor: function (a) { var f = b(CKEDITOR.document); return (this.setUiColor = function (a) { this.uiColor = a; var b = CKEDITOR.skin.chameleon, e = "", k = ""; "function" == typeof b && (e = b(this, "editor"), k = b(this, "panel")); a = [[c, a]]; d([f], e, a); d(l, k, a) }).call(this, a) } }); var h = "cke_ui_color",
                l = [], c = /\$color/g; CKEDITOR.on("instanceLoaded", function (a) { if (!CKEDITOR.env.ie || !CKEDITOR.env.quirks) { var f = a.editor; a = function (a) { a = (a.data[0] || a.data).element.getElementsByTag("iframe").getItem(0).getFrameDocument(); if (!a.getById("cke_ui_color")) { var e = b(a); l.push(e); f.on("destroy", function () { l = CKEDITOR.tools.array.filter(l, function (a) { return e !== a }) }); (a = f.getUiColor()) && d([e], CKEDITOR.skin.chameleon(f, "panel"), [[c, a]]) } }; f.on("panelShow", a); f.on("menuShow", a); f.config.uiColor && f.setUiColor(f.config.uiColor) } })
        })();
        (function () {
            if (CKEDITOR.env.webkit) CKEDITOR.env.hc = !1; else { var a = CKEDITOR.dom.element.createFromHtml('\x3cdiv style\x3d"width:0;height:0;position:absolute;left:-10000px;border:1px solid;border-color:red blue"\x3e\x3c/div\x3e', CKEDITOR.document); a.appendTo(CKEDITOR.document.getHead()); try { var g = a.getComputedStyle("border-top-color"), e = a.getComputedStyle("border-right-color"); CKEDITOR.env.hc = !(!g || g != e) } catch (b) { CKEDITOR.env.hc = !1 } a.remove() } CKEDITOR.env.hc && (CKEDITOR.env.cssClass += " cke_hc"); CKEDITOR.document.appendStyleText(".cke{visibility:hidden;}");
            CKEDITOR.status = "loaded"; CKEDITOR.fireOnce("loaded"); if (a = CKEDITOR._.pending) for (delete CKEDITOR._.pending, g = 0; g < a.length; g++)CKEDITOR.editor.prototype.constructor.apply(a[g][0], a[g][1]), CKEDITOR.add(a[g][0])
        })(); CKEDITOR.skin.name = "moono-lisa"; CKEDITOR.skin.ua_editor = "ie,iequirks,ie8,gecko"; CKEDITOR.skin.ua_dialog = "ie,iequirks,ie8"; CKEDITOR.skin.chameleon = function () {
            var a = function () {
                return function (a, b) {
                    for (var d = a.match(/[^#]./g), g = 0; 3 > g; g++) {
                        var h = g, l; l = parseInt(d[g], 16); l = ("0" + (0 > b ? 0 | l * (1 + b) :
                            0 | l + (255 - l) * b).toString(16)).slice(-2); d[h] = l
                    } return "#" + d.join("")
                }
            }(), g = {
                editor: new CKEDITOR.template("{id}.cke_chrome [border-color:{defaultBorder};] {id} .cke_top [ background-color:{defaultBackground};border-bottom-color:{defaultBorder};] {id} .cke_bottom [background-color:{defaultBackground};border-top-color:{defaultBorder};] {id} .cke_resizer [border-right-color:{ckeResizer}] {id} .cke_dialog_title [background-color:{defaultBackground};border-bottom-color:{defaultBorder};] {id} .cke_dialog_footer [background-color:{defaultBackground};outline-color:{defaultBorder};] {id} .cke_dialog_tab [background-color:{dialogTab};border-color:{defaultBorder};] {id} .cke_dialog_tab:hover [background-color:{lightBackground};] {id} .cke_dialog_contents [border-top-color:{defaultBorder};] {id} .cke_dialog_tab_selected, {id} .cke_dialog_tab_selected:hover [background:{dialogTabSelected};border-bottom-color:{dialogTabSelectedBorder};] {id} .cke_dialog_body [background:{dialogBody};border-color:{defaultBorder};] {id} a.cke_button_off:hover,{id} a.cke_button_off:focus,{id} a.cke_button_off:active [background-color:{darkBackground};border-color:{toolbarElementsBorder};] {id} .cke_button_on [background-color:{ckeButtonOn};border-color:{toolbarElementsBorder};] {id} .cke_toolbar_separator,{id} .cke_toolgroup a.cke_button:last-child:after,{id} .cke_toolgroup a.cke_button.cke_button_disabled:hover:last-child:after [background-color: {toolbarElementsBorder};border-color: {toolbarElementsBorder};] {id} a.cke_combo_button:hover,{id} a.cke_combo_button:focus,{id} .cke_combo_on a.cke_combo_button [border-color:{toolbarElementsBorder};background-color:{darkBackground};] {id} .cke_combo:after [border-color:{toolbarElementsBorder};] {id} .cke_path_item [color:{elementsPathColor};] {id} a.cke_path_item:hover,{id} a.cke_path_item:focus,{id} a.cke_path_item:active [background-color:{darkBackground};] {id}.cke_panel [border-color:{defaultBorder};] "),
                panel: new CKEDITOR.template(".cke_panel_grouptitle [background-color:{lightBackground};border-color:{defaultBorder};] .cke_menubutton_icon [background-color:{menubuttonIcon};] .cke_menubutton:hover,.cke_menubutton:focus,.cke_menubutton:active [background-color:{menubuttonHover};] .cke_menubutton:hover .cke_menubutton_icon, .cke_menubutton:focus .cke_menubutton_icon, .cke_menubutton:active .cke_menubutton_icon [background-color:{menubuttonIconHover};] .cke_menubutton_disabled:hover .cke_menubutton_icon,.cke_menubutton_disabled:focus .cke_menubutton_icon,.cke_menubutton_disabled:active .cke_menubutton_icon [background-color:{menubuttonIcon};] .cke_menuseparator [background-color:{menubuttonIcon};] a:hover.cke_colorbox, a:active.cke_colorbox [border-color:{defaultBorder};] a:hover.cke_colorauto, a:hover.cke_colormore, a:active.cke_colorauto, a:active.cke_colormore [background-color:{ckeColorauto};border-color:{defaultBorder};] ")
            };
            return function (e, b) { var d = a(e.uiColor, .4), d = { id: "." + e.id, defaultBorder: a(d, -.2), toolbarElementsBorder: a(d, -.25), defaultBackground: d, lightBackground: a(d, .8), darkBackground: a(d, -.15), ckeButtonOn: a(d, .4), ckeResizer: a(d, -.4), ckeColorauto: a(d, .8), dialogBody: a(d, .7), dialogTab: a(d, .65), dialogTabSelected: "#FFF", dialogTabSelectedBorder: "#FFF", elementsPathColor: a(d, -.6), menubuttonHover: a(d, .1), menubuttonIcon: a(d, .5), menubuttonIconHover: a(d, .3) }; return g[b].output(d).replace(/\[/g, "{").replace(/\]/g, "}") }
        }();
        CKEDITOR.plugins.add("dialogui", {
            onLoad: function () {
                var a = function (a) { this._ || (this._ = {}); this._["default"] = this._.initValue = a["default"] || ""; this._.required = a.required || !1; for (var b = [this._], f = 1; f < arguments.length; f++)b.push(arguments[f]); b.push(!0); CKEDITOR.tools.extend.apply(CKEDITOR.tools, b); return this._ }, g = { build: function (a, b, f) { return new CKEDITOR.ui.dialog.textInput(a, b, f) } }, e = { build: function (a, b, f) { return new CKEDITOR.ui.dialog[b.type](a, b, f) } }, b = {
                    isChanged: function () {
                        return this.getValue() !=
                            this.getInitValue()
                    }, reset: function (a) { this.setValue(this.getInitValue(), a) }, setInitValue: function () { this._.initValue = this.getValue() }, resetInitValue: function () { this._.initValue = this._["default"] }, getInitValue: function () { return this._.initValue }
                }, d = CKEDITOR.tools.extend({}, CKEDITOR.ui.dialog.uiElement.prototype.eventProcessors, {
                    onChange: function (a, b) {
                        this._.domOnChangeRegistered || (a.on("load", function () {
                            this.getInputElement().on("change", function () { a.parts.dialog.isVisible() && this.fire("change", { value: this.getValue() }) },
                                this)
                        }, this), this._.domOnChangeRegistered = !0); this.on("change", b)
                    }
                }, !0), m = /^on([A-Z]\w+)/, h = function (a) { for (var b in a) (m.test(b) || "title" == b || "type" == b) && delete a[b]; return a }, l = function (a) { a = a.data.getKeystroke(); a == CKEDITOR.SHIFT + CKEDITOR.ALT + 36 ? this.setDirectionMarker("ltr") : a == CKEDITOR.SHIFT + CKEDITOR.ALT + 35 && this.setDirectionMarker("rtl") }; CKEDITOR.tools.extend(CKEDITOR.ui.dialog, {
                    labeledElement: function (b, d, f, e) {
                        if (!(4 > arguments.length)) {
                            var h = a.call(this, d); h.labelId = CKEDITOR.tools.getNextId() +
                                "_label"; this._.children = []; var g = { role: d.role || "presentation" }; d.includeLabel && (g["aria-labelledby"] = h.labelId); CKEDITOR.ui.dialog.uiElement.call(this, b, d, f, "div", null, g, function () {
                                    var a = [], f = d.required ? " cke_required" : ""; "horizontal" != d.labelLayout ? a.push('\x3clabel class\x3d"cke_dialog_ui_labeled_label' + f + '" ', ' id\x3d"' + h.labelId + '"', h.inputId ? ' for\x3d"' + h.inputId + '"' : "", (d.labelStyle ? ' style\x3d"' + d.labelStyle + '"' : "") + "\x3e", d.label, "\x3c/label\x3e", '\x3cdiv class\x3d"cke_dialog_ui_labeled_content"',
                                        d.controlStyle ? ' style\x3d"' + d.controlStyle + '"' : "", ' role\x3d"presentation"\x3e', e.call(this, b, d), "\x3c/div\x3e") : (f = {
                                            type: "hbox", widths: d.widths, padding: 0, children: [{ type: "html", html: '\x3clabel class\x3d"cke_dialog_ui_labeled_label' + f + '" id\x3d"' + h.labelId + '" for\x3d"' + h.inputId + '"' + (d.labelStyle ? ' style\x3d"' + d.labelStyle + '"' : "") + "\x3e" + CKEDITOR.tools.htmlEncode(d.label) + "\x3c/label\x3e" }, {
                                                type: "html", html: '\x3cspan class\x3d"cke_dialog_ui_labeled_content"' + (d.controlStyle ? ' style\x3d"' + d.controlStyle +
                                                    '"' : "") + "\x3e" + e.call(this, b, d) + "\x3c/span\x3e"
                                            }]
                                        }, CKEDITOR.dialog._.uiElementBuilders.hbox.build(b, f, a)); return a.join("")
                                })
                        }
                    }, textInput: function (b, d, f) {
                        if (!(3 > arguments.length)) {
                            a.call(this, d); var e = this._.inputId = CKEDITOR.tools.getNextId() + "_textInput", h = { "class": "cke_dialog_ui_input_" + d.type, id: e, type: d.type }; d.validate && (this.validate = d.validate); d.maxLength && (h.maxlength = d.maxLength); d.size && (h.size = d.size); d.inputStyle && (h.style = d.inputStyle); var g = this, m = !1; b.on("load", function () {
                                g.getInputElement().on("keydown",
                                    function (a) { 13 == a.data.getKeystroke() && (m = !0) }); g.getInputElement().on("keyup", function (a) { 13 == a.data.getKeystroke() && m && (b.getButton("ok") && setTimeout(function () { b.getButton("ok").click() }, 0), m = !1); g.bidi && l.call(g, a) }, null, null, 1E3)
                            }); CKEDITOR.ui.dialog.labeledElement.call(this, b, d, f, function () {
                                var a = ['\x3cdiv class\x3d"cke_dialog_ui_input_', d.type, '" role\x3d"presentation"']; d.width && a.push('style\x3d"width:' + d.width + '" '); a.push("\x3e\x3cinput "); h["aria-labelledby"] = this._.labelId; this._.required &&
                                    (h["aria-required"] = this._.required); for (var b in h) a.push(b + '\x3d"' + h[b] + '" '); a.push(" /\x3e\x3c/div\x3e"); return a.join("")
                            })
                        }
                    }, textarea: function (b, d, f) {
                        if (!(3 > arguments.length)) {
                            a.call(this, d); var e = this, h = this._.inputId = CKEDITOR.tools.getNextId() + "_textarea", g = {}; d.validate && (this.validate = d.validate); g.rows = d.rows || 5; g.cols = d.cols || 20; g["class"] = "cke_dialog_ui_input_textarea " + (d["class"] || ""); "undefined" != typeof d.inputStyle && (g.style = d.inputStyle); d.dir && (g.dir = d.dir); if (e.bidi) b.on("load",
                                function () { e.getInputElement().on("keyup", l) }, e); CKEDITOR.ui.dialog.labeledElement.call(this, b, d, f, function () { g["aria-labelledby"] = this._.labelId; this._.required && (g["aria-required"] = this._.required); var a = ['\x3cdiv class\x3d"cke_dialog_ui_input_textarea" role\x3d"presentation"\x3e\x3ctextarea id\x3d"', h, '" '], b; for (b in g) a.push(b + '\x3d"' + CKEDITOR.tools.htmlEncode(g[b]) + '" '); a.push("\x3e", CKEDITOR.tools.htmlEncode(e._["default"]), "\x3c/textarea\x3e\x3c/div\x3e"); return a.join("") })
                        }
                    }, checkbox: function (b,
                        d, f) {
                            if (!(3 > arguments.length)) {
                                var e = a.call(this, d, { "default": !!d["default"] }); d.validate && (this.validate = d.validate); CKEDITOR.ui.dialog.uiElement.call(this, b, d, f, "span", null, null, function () {
                                    var a = CKEDITOR.tools.extend({}, d, { id: d.id ? d.id + "_checkbox" : CKEDITOR.tools.getNextId() + "_checkbox" }, !0), f = [], g = CKEDITOR.tools.getNextId() + "_label", l = { "class": "cke_dialog_ui_checkbox_input", type: "checkbox", "aria-labelledby": g }; h(a); d["default"] && (l.checked = "checked"); "undefined" != typeof a.inputStyle && (a.style = a.inputStyle);
                                    e.checkbox = new CKEDITOR.ui.dialog.uiElement(b, a, f, "input", null, l); f.push(' \x3clabel id\x3d"', g, '" for\x3d"', l.id, '"' + (d.labelStyle ? ' style\x3d"' + d.labelStyle + '"' : "") + "\x3e", CKEDITOR.tools.htmlEncode(d.label), "\x3c/label\x3e"); return f.join("")
                                })
                            }
                    }, radio: function (b, d, f) {
                        if (!(3 > arguments.length)) {
                            a.call(this, d); this._["default"] || (this._["default"] = this._.initValue = d.items[0][1]); d.validate && (this.validate = d.validate); var e = [], g = this; d.role = "radiogroup"; d.includeLabel = !0; CKEDITOR.ui.dialog.labeledElement.call(this,
                                b, d, f, function () {
                                    for (var a = [], f = [], l = (d.id ? d.id : CKEDITOR.tools.getNextId()) + "_radio", m = 0; m < d.items.length; m++) {
                                        var x = d.items[m], u = void 0 !== x[2] ? x[2] : x[0], A = void 0 !== x[1] ? x[1] : x[0], v = CKEDITOR.tools.getNextId() + "_radio_input", z = v + "_label", v = CKEDITOR.tools.extend({}, d, { id: v, title: null, type: null }, !0), u = CKEDITOR.tools.extend({}, v, { title: u }, !0), y = { type: "radio", "class": "cke_dialog_ui_radio_input", name: l, value: A, "aria-labelledby": z }, B = []; g._["default"] == A && (y.checked = "checked"); h(v); h(u); "undefined" != typeof v.inputStyle &&
                                            (v.style = v.inputStyle); v.keyboardFocusable = !0; e.push(new CKEDITOR.ui.dialog.uiElement(b, v, B, "input", null, y)); B.push(" "); new CKEDITOR.ui.dialog.uiElement(b, u, B, "label", null, { id: z, "for": y.id }, x[0]); a.push(B.join(""))
                                    } new CKEDITOR.ui.dialog.hbox(b, e, a, f); return f.join("")
                                }); this._.children = e
                        }
                    }, button: function (b, d, f) {
                        if (arguments.length) {
                            "function" == typeof d && (d = d(b.getParentEditor())); a.call(this, d, { disabled: d.disabled || !1 }); CKEDITOR.event.implementOn(this); var e = this; b.on("load", function () {
                                var a = this.getElement();
                                (function () { a.on("click", function (a) { e.click(); a.data.preventDefault() }); a.on("keydown", function (a) { a.data.getKeystroke() in { 32: 1 } && (e.click(), a.data.preventDefault()) }) })(); a.unselectable()
                            }, this); var h = CKEDITOR.tools.extend({}, d); delete h.style; var g = CKEDITOR.tools.getNextId() + "_label"; CKEDITOR.ui.dialog.uiElement.call(this, b, h, f, "a", null, { style: d.style, href: "javascript:void(0)", title: d.label, hidefocus: "true", "class": d["class"], role: "button", "aria-labelledby": g }, '\x3cspan id\x3d"' + g + '" class\x3d"cke_dialog_ui_button"\x3e' +
                                CKEDITOR.tools.htmlEncode(d.label) + "\x3c/span\x3e")
                        }
                    }, select: function (b, d, f) {
                        if (!(3 > arguments.length)) {
                            var e = a.call(this, d); d.validate && (this.validate = d.validate); e.inputId = CKEDITOR.tools.getNextId() + "_select"; CKEDITOR.ui.dialog.labeledElement.call(this, b, d, f, function () {
                                var a = CKEDITOR.tools.extend({}, d, { id: d.id ? d.id + "_select" : CKEDITOR.tools.getNextId() + "_select" }, !0), f = [], g = [], l = { id: e.inputId, "class": "cke_dialog_ui_input_select", "aria-labelledby": this._.labelId }; f.push('\x3cdiv class\x3d"cke_dialog_ui_input_',
                                    d.type, '" role\x3d"presentation"'); d.width && f.push('style\x3d"width:' + d.width + '" '); f.push("\x3e"); void 0 !== d.size && (l.size = d.size); void 0 !== d.multiple && (l.multiple = d.multiple); h(a); for (var m = 0, x; m < d.items.length && (x = d.items[m]); m++)g.push('\x3coption value\x3d"', CKEDITOR.tools.htmlEncode(void 0 !== x[1] ? x[1] : x[0]).replace(/"/g, "\x26quot;"), '" /\x3e ', CKEDITOR.tools.htmlEncode(x[0])); "undefined" != typeof a.inputStyle && (a.style = a.inputStyle); e.select = new CKEDITOR.ui.dialog.uiElement(b, a, f, "select", null,
                                        l, g.join("")); f.push("\x3c/div\x3e"); return f.join("")
                            })
                        }
                    }, file: function (b, d, f) {
                        if (!(3 > arguments.length)) {
                            void 0 === d["default"] && (d["default"] = ""); var e = CKEDITOR.tools.extend(a.call(this, d), { definition: d, buttons: [] }); d.validate && (this.validate = d.validate); b.on("load", function () { CKEDITOR.document.getById(e.frameId).getParent().addClass("cke_dialog_ui_input_file") }); CKEDITOR.ui.dialog.labeledElement.call(this, b, d, f, function () {
                                e.frameId = CKEDITOR.tools.getNextId() + "_fileInput"; var a = ['\x3ciframe frameborder\x3d"0" allowtransparency\x3d"0" class\x3d"cke_dialog_ui_input_file" role\x3d"presentation" id\x3d"',
                                    e.frameId, '" title\x3d"', d.label, '" src\x3d"javascript:void(']; a.push(CKEDITOR.env.ie ? "(function(){" + encodeURIComponent("document.open();(" + CKEDITOR.tools.fixDomain + ")();document.close();") + "})()" : "0"); a.push(')"\x3e\x3c/iframe\x3e'); return a.join("")
                            })
                        }
                    }, fileButton: function (b, d, f) {
                        var e = this; if (!(3 > arguments.length)) {
                            a.call(this, d); d.validate && (this.validate = d.validate); var h = CKEDITOR.tools.extend({}, d), g = h.onClick; h.className = (h.className ? h.className + " " : "") + "cke_dialog_ui_button"; h.onClick = function (a) {
                                var f =
                                    d["for"]; a = g ? g.call(this, a) : !1; !1 !== a && ("xhr" !== a && b.getContentElement(f[0], f[1]).submit(), this.disable())
                            }; b.on("load", function () { b.getContentElement(d["for"][0], d["for"][1])._.buttons.push(e) }); CKEDITOR.ui.dialog.button.call(this, b, h, f)
                        }
                    }, html: function () {
                        var a = /^\s*<[\w:]+\s+([^>]*)?>/, b = /^(\s*<[\w:]+(?:\s+[^>]*)?)((?:.|\r|\n)+)$/, f = /\/$/; return function (d, e, h) {
                            if (!(3 > arguments.length)) {
                                var g = [], l = e.html; "\x3c" != l.charAt(0) && (l = "\x3cspan\x3e" + l + "\x3c/span\x3e"); var m = e.focus; if (m) {
                                    var x = this.focus;
                                    this.focus = function () { ("function" == typeof m ? m : x).call(this); this.fire("focus") }; e.isFocusable && (this.isFocusable = this.isFocusable); this.keyboardFocusable = !0
                                } CKEDITOR.ui.dialog.uiElement.call(this, d, e, g, "span", null, null, ""); g = g.join("").match(a); l = l.match(b) || ["", "", ""]; f.test(l[1]) && (l[1] = l[1].slice(0, -1), l[2] = "/" + l[2]); h.push([l[1], " ", g[1] || "", l[2]].join(""))
                            }
                        }
                    }(), fieldset: function (a, b, f, d, e) {
                        var h = e.label; this._ = { children: b }; CKEDITOR.ui.dialog.uiElement.call(this, a, e, d, "fieldset", null, null, function () {
                            var a =
                                []; h && a.push("\x3clegend" + (e.labelStyle ? ' style\x3d"' + e.labelStyle + '"' : "") + "\x3e" + h + "\x3c/legend\x3e"); for (var b = 0; b < f.length; b++)a.push(f[b]); return a.join("")
                        })
                    }
                }, !0); CKEDITOR.ui.dialog.html.prototype = new CKEDITOR.ui.dialog.uiElement; CKEDITOR.ui.dialog.labeledElement.prototype = CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement, {
                    setLabel: function (a) {
                        var b = CKEDITOR.document.getById(this._.labelId); 1 > b.getChildCount() ? (new CKEDITOR.dom.text(a, CKEDITOR.document)).appendTo(b) : b.getChild(0).$.nodeValue =
                            a; return this
                    }, getLabel: function () { var a = CKEDITOR.document.getById(this._.labelId); return !a || 1 > a.getChildCount() ? "" : a.getChild(0).getText() }, eventProcessors: d
                }, !0); CKEDITOR.ui.dialog.button.prototype = CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement, {
                    click: function () { return this._.disabled ? !1 : this.fire("click", { dialog: this._.dialog }) }, enable: function () { this._.disabled = !1; var a = this.getElement(); a && a.removeClass("cke_disabled") }, disable: function () { this._.disabled = !0; this.getElement().addClass("cke_disabled") },
                    isVisible: function () { return this.getElement().getFirst().isVisible() }, isEnabled: function () { return !this._.disabled }, eventProcessors: CKEDITOR.tools.extend({}, CKEDITOR.ui.dialog.uiElement.prototype.eventProcessors, { onClick: function (a, b) { this.on("click", function () { b.apply(this, arguments) }) } }, !0), accessKeyUp: function () { this.click() }, accessKeyDown: function () { this.focus() }, keyboardFocusable: !0
                }, !0); CKEDITOR.ui.dialog.textInput.prototype = CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.labeledElement, {
                    getInputElement: function () { return CKEDITOR.document.getById(this._.inputId) },
                    focus: function () { var a = this.selectParentTab(); setTimeout(function () { var b = a.getInputElement(); b && b.$.focus() }, 0) }, select: function () { var a = this.selectParentTab(); setTimeout(function () { var b = a.getInputElement(); b && (b.$.focus(), b.$.select()) }, 0) }, accessKeyUp: function () { this.select() }, setValue: function (a) { if (this.bidi) { var b = a && a.charAt(0); (b = "‪" == b ? "ltr" : "‫" == b ? "rtl" : null) && (a = a.slice(1)); this.setDirectionMarker(b) } a || (a = ""); return CKEDITOR.ui.dialog.uiElement.prototype.setValue.apply(this, arguments) },
                    getValue: function () { var a = CKEDITOR.ui.dialog.uiElement.prototype.getValue.call(this); if (this.bidi && a) { var b = this.getDirectionMarker(); b && (a = ("ltr" == b ? "‪" : "‫") + a) } return a }, setDirectionMarker: function (a) { var b = this.getInputElement(); a ? b.setAttributes({ dir: a, "data-cke-dir-marker": a }) : this.getDirectionMarker() && b.removeAttributes(["dir", "data-cke-dir-marker"]) }, getDirectionMarker: function () { return this.getInputElement().data("cke-dir-marker") }, keyboardFocusable: !0
                }, b, !0); CKEDITOR.ui.dialog.textarea.prototype =
                    new CKEDITOR.ui.dialog.textInput; CKEDITOR.ui.dialog.select.prototype = CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.labeledElement, {
                        getInputElement: function () { return this._.select.getElement() }, add: function (a, b, f) { var d = new CKEDITOR.dom.element("option", this.getDialog().getParentEditor().document), e = this.getInputElement().$; d.$.text = a; d.$.value = void 0 === b || null === b ? a : b; void 0 === f || null === f ? CKEDITOR.env.ie ? e.add(d.$) : e.add(d.$, null) : e.add(d.$, f); return this }, remove: function (a) {
                            this.getInputElement().$.remove(a);
                            return this
                        }, clear: function () { for (var a = this.getInputElement().$; 0 < a.length;)a.remove(0); return this }, keyboardFocusable: !0
                    }, b, !0); CKEDITOR.ui.dialog.checkbox.prototype = CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement, {
                        getInputElement: function () { return this._.checkbox.getElement() }, setValue: function (a, b) { this.getInputElement().$.checked = a; !b && this.fire("change", { value: a }) }, getValue: function () { return this.getInputElement().$.checked }, accessKeyUp: function () { this.setValue(!this.getValue()) }, eventProcessors: {
                            onChange: function (a,
                                b) { if (!CKEDITOR.env.ie || 8 < CKEDITOR.env.version) return d.onChange.apply(this, arguments); a.on("load", function () { var a = this._.checkbox.getElement(); a.on("propertychange", function (b) { b = b.data.$; "checked" == b.propertyName && this.fire("change", { value: a.$.checked }) }, this) }, this); this.on("change", b); return null }
                        }, keyboardFocusable: !0
                    }, b, !0); CKEDITOR.ui.dialog.radio.prototype = CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement, {
                        setValue: function (a, b) {
                            for (var f = this._.children, d, e = 0; e < f.length && (d = f[e]); e++)d.getElement().$.checked =
                                d.getValue() == a; !b && this.fire("change", { value: a })
                        }, getValue: function () { for (var a = this._.children, b = 0; b < a.length; b++)if (a[b].getElement().$.checked) return a[b].getValue(); return null }, accessKeyUp: function () { var a = this._.children, b; for (b = 0; b < a.length; b++)if (a[b].getElement().$.checked) { a[b].getElement().focus(); return } a[0].getElement().focus() }, eventProcessors: {
                            onChange: function (a, b) {
                                if (!CKEDITOR.env.ie || 8 < CKEDITOR.env.version) return d.onChange.apply(this, arguments); a.on("load", function () {
                                    for (var a =
                                        this._.children, b = this, c = 0; c < a.length; c++)a[c].getElement().on("propertychange", function (a) { a = a.data.$; "checked" == a.propertyName && this.$.checked && b.fire("change", { value: this.getAttribute("value") }) })
                                }, this); this.on("change", b); return null
                            }
                        }
                    }, b, !0); CKEDITOR.ui.dialog.file.prototype = CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.labeledElement, b, {
                        getInputElement: function () {
                            var a = CKEDITOR.document.getById(this._.frameId).getFrameDocument(); return 0 < a.$.forms.length ? new CKEDITOR.dom.element(a.$.forms[0].elements[0]) :
                                this.getElement()
                        }, submit: function () { this.getInputElement().getParent().$.submit(); return this }, getAction: function () { return this.getInputElement().getParent().$.action }, registerEvents: function (a) { var b = /^on([A-Z]\w+)/, f, d = function (a, b, c, f) { a.on("formLoaded", function () { a.getInputElement().on(c, f, a) }) }, e; for (e in a) if (f = e.match(b)) this.eventProcessors[e] ? this.eventProcessors[e].call(this, this._.dialog, a[e]) : d(this, this._.dialog, f[1].toLowerCase(), a[e]); return this }, reset: function () {
                            function a() {
                                f.$.open();
                                var c = ""; d.size && (c = d.size - (CKEDITOR.env.ie ? 7 : 0)); var u = b.frameId + "_input"; f.$.write(['\x3chtml dir\x3d"' + l + '" lang\x3d"' + m + '"\x3e\x3chead\x3e\x3ctitle\x3e\x3c/title\x3e\x3c/head\x3e\x3cbody style\x3d"margin: 0; overflow: hidden; background: transparent;"\x3e', '\x3cform enctype\x3d"multipart/form-data" method\x3d"POST" dir\x3d"' + l + '" lang\x3d"' + m + '" action\x3d"', CKEDITOR.tools.htmlEncode(d.action), '"\x3e\x3clabel id\x3d"', b.labelId, '" for\x3d"', u, '" style\x3d"display:none"\x3e', CKEDITOR.tools.htmlEncode(d.label),
                                    '\x3c/label\x3e\x3cinput style\x3d"width:100%" id\x3d"', u, '" aria-labelledby\x3d"', b.labelId, '" type\x3d"file" name\x3d"', CKEDITOR.tools.htmlEncode(d.id || "cke_upload"), '" size\x3d"', CKEDITOR.tools.htmlEncode(0 < c ? c : ""), '" /\x3e\x3c/form\x3e\x3c/body\x3e\x3c/html\x3e\x3cscript\x3e', CKEDITOR.env.ie ? "(" + CKEDITOR.tools.fixDomain + ")();" : "", "window.parent.CKEDITOR.tools.callFunction(" + h + ");", "window.onbeforeunload \x3d function() {window.parent.CKEDITOR.tools.callFunction(" + g + ")}", "\x3c/script\x3e"].join(""));
                                f.$.close(); for (c = 0; c < e.length; c++)e[c].enable()
                            } var b = this._, f = CKEDITOR.document.getById(b.frameId).getFrameDocument(), d = b.definition, e = b.buttons, h = this.formLoadedNumber, g = this.formUnloadNumber, l = b.dialog._.editor.lang.dir, m = b.dialog._.editor.langCode; h || (h = this.formLoadedNumber = CKEDITOR.tools.addFunction(function () { this.fire("formLoaded") }, this), g = this.formUnloadNumber = CKEDITOR.tools.addFunction(function () { this.getInputElement().clearCustomData() }, this), this.getDialog()._.editor.on("destroy", function () {
                                CKEDITOR.tools.removeFunction(h);
                                CKEDITOR.tools.removeFunction(g)
                            })); CKEDITOR.env.gecko ? setTimeout(a, 500) : a()
                        }, getValue: function () { return this.getInputElement().$.value || "" }, setInitValue: function () { this._.initValue = "" }, eventProcessors: { onChange: function (a, b) { this._.domOnChangeRegistered || (this.on("formLoaded", function () { this.getInputElement().on("change", function () { this.fire("change", { value: this.getValue() }) }, this) }, this), this._.domOnChangeRegistered = !0); this.on("change", b) } }, keyboardFocusable: !0
                    }, !0); CKEDITOR.ui.dialog.fileButton.prototype =
                        new CKEDITOR.ui.dialog.button; CKEDITOR.ui.dialog.fieldset.prototype = CKEDITOR.tools.clone(CKEDITOR.ui.dialog.hbox.prototype); CKEDITOR.dialog.addUIElement("text", g); CKEDITOR.dialog.addUIElement("password", g); CKEDITOR.dialog.addUIElement("tel", g); CKEDITOR.dialog.addUIElement("textarea", e); CKEDITOR.dialog.addUIElement("checkbox", e); CKEDITOR.dialog.addUIElement("radio", e); CKEDITOR.dialog.addUIElement("button", e); CKEDITOR.dialog.addUIElement("select", e); CKEDITOR.dialog.addUIElement("file", e); CKEDITOR.dialog.addUIElement("fileButton",
                            e); CKEDITOR.dialog.addUIElement("html", e); CKEDITOR.dialog.addUIElement("fieldset", { build: function (a, b, f) { for (var d = b.children, e, h = [], g = [], l = 0; l < d.length && (e = d[l]); l++) { var m = []; h.push(m); g.push(CKEDITOR.dialog._.uiElementBuilders[e.type].build(a, e, m)) } return new CKEDITOR.ui.dialog[b.type](a, g, h, f, b) } })
            }
        }); CKEDITOR.DIALOG_RESIZE_NONE = 0; CKEDITOR.DIALOG_RESIZE_WIDTH = 1; CKEDITOR.DIALOG_RESIZE_HEIGHT = 2; CKEDITOR.DIALOG_RESIZE_BOTH = 3; CKEDITOR.DIALOG_STATE_IDLE = 1; CKEDITOR.DIALOG_STATE_BUSY = 2; (function () {
            function a(a) {
                a._.tabBarMode =
                !0; a._.tabs[a._.currentTabId][0].focus(); a._.currentFocusIndex = -1
            } function g() { for (var a = this._.tabIdList.length, b = CKEDITOR.tools.indexOf(this._.tabIdList, this._.currentTabId) + a, c = b - 1; c > b - a; c--)if (this._.tabs[this._.tabIdList[c % a]][0].$.offsetHeight) return this._.tabIdList[c % a]; return null } function e() {
                for (var a = this._.tabIdList.length, b = CKEDITOR.tools.indexOf(this._.tabIdList, this._.currentTabId), c = b + 1; c < b + a; c++)if (this._.tabs[this._.tabIdList[c % a]][0].$.offsetHeight) return this._.tabIdList[c % a];
                return null
            } function b(a, b) { for (var c = a.$.getElementsByTagName("input"), f = 0, d = c.length; f < d; f++) { var e = new CKEDITOR.dom.element(c[f]); "text" == e.getAttribute("type").toLowerCase() && (b ? (e.setAttribute("value", e.getCustomData("fake_value") || ""), e.removeCustomData("fake_value")) : (e.setCustomData("fake_value", e.getAttribute("value")), e.setAttribute("value", ""))) } } function d(a, b) {
                var c = this.getInputElement(); c && (a ? c.removeAttribute("aria-invalid") : c.setAttribute("aria-invalid", !0)); a || (this.select ? this.select() :
                    this.focus()); b && alert(b); this.fire("validated", { valid: a, msg: b })
            } function m() { var a = this.getInputElement(); a && a.removeAttribute("aria-invalid") } function h(a) {
                var b = CKEDITOR.dom.element.createFromHtml(CKEDITOR.addTemplate("dialog", I).output({ id: CKEDITOR.tools.getNextNumber(), editorId: a.id, langDir: a.lang.dir, langCode: a.langCode, editorDialogClass: "cke_editor_" + a.name.replace(/\./g, "\\.") + "_dialog", closeTitle: a.lang.common.close, hidpi: CKEDITOR.env.hidpi ? "cke_hidpi" : "" })), c = b.getChild([0, 0, 0, 0, 0]), f = c.getChild(0),
                d = c.getChild(1); a.plugins.clipboard && CKEDITOR.plugins.clipboard.preventDefaultDropOnElement(c); !CKEDITOR.env.ie || CKEDITOR.env.quirks || CKEDITOR.env.edge || (a = "javascript:void(function(){" + encodeURIComponent("document.open();(" + CKEDITOR.tools.fixDomain + ")();document.close();") + "}())", CKEDITOR.dom.element.createFromHtml('\x3ciframe frameBorder\x3d"0" class\x3d"cke_iframe_shim" src\x3d"' + a + '" tabIndex\x3d"-1"\x3e\x3c/iframe\x3e').appendTo(c.getParent())); f.unselectable(); d.unselectable(); return {
                    element: b,
                    parts: { dialog: b.getChild(0), title: f, close: d, tabs: c.getChild(2), contents: c.getChild([3, 0, 0, 0]), footer: c.getChild([3, 0, 1, 0]) }
                }
            } function l(a, b, c) { this.element = b; this.focusIndex = c; this.tabIndex = 0; this.isFocusable = function () { return !b.getAttribute("disabled") && b.isVisible() }; this.focus = function () { a._.currentFocusIndex = this.focusIndex; this.element.focus() }; b.on("keydown", function (a) { a.data.getKeystroke() in { 32: 1, 13: 1 } && this.fire("click") }); b.on("focus", function () { this.fire("mouseover") }); b.on("blur", function () { this.fire("mouseout") }) }
            function c(a) { function b() { a.layout() } var c = CKEDITOR.document.getWindow(); c.on("resize", b); a.on("hide", function () { c.removeListener("resize", b) }) } function k(a, b) { this.dialog = a; for (var c = b.contents, d = 0, e; e = c[d]; d++)c[d] = e && new f(a, e); CKEDITOR.tools.extend(this, b) } function f(a, b) { this._ = { dialog: a }; CKEDITOR.tools.extend(this, b) } function n(a) {
                function b(c) {
                    var k = a.getSize(), l = a.parts.dialog.getParent().getClientSize(), n = c.data.$.screenX, m = c.data.$.screenY, p = n - f.x, u = m - f.y; f = { x: n, y: m }; d.x += p; d.y += u; n = d.x +
                        g[3] < h ? -g[3] : d.x - g[1] > l.width - k.width - h ? l.width - k.width + ("rtl" == e.lang.dir ? 0 : g[1]) : d.x; k = d.y + g[0] < h ? -g[0] : d.y - g[2] > l.height - k.height - h ? l.height - k.height + g[2] : d.y; n = Math.floor(n); k = Math.floor(k); a.move(n, k, 1); c.data.preventDefault()
                } function c() { CKEDITOR.document.removeListener("mousemove", b); CKEDITOR.document.removeListener("mouseup", c); if (CKEDITOR.env.ie6Compat) { var a = F.getChild(0).getFrameDocument(); a.removeListener("mousemove", b); a.removeListener("mouseup", c) } } var f = null, d = null, e = a.getParentEditor(),
                    h = e.config.dialog_magnetDistance, g = CKEDITOR.skin.margins || [0, 0, 0, 0]; "undefined" == typeof h && (h = 20); a.parts.title.on("mousedown", function (e) { if (!a._.moved) { var h = a._.element; h.getFirst().setStyle("position", "absolute"); h.removeStyle("display"); a._.moved = !0; a.layout() } f = { x: e.data.$.screenX, y: e.data.$.screenY }; CKEDITOR.document.on("mousemove", b); CKEDITOR.document.on("mouseup", c); d = a.getPosition(); CKEDITOR.env.ie6Compat && (h = F.getChild(0).getFrameDocument(), h.on("mousemove", b), h.on("mouseup", c)); e.data.preventDefault() },
                        a)
            } function p(a) {
                function b(c) {
                    var m = "rtl" == e.lang.dir, p = n.width, u = n.height, x = p + (c.data.$.screenX - l.x) * (m ? -1 : 1) * (a._.moved ? 1 : 2), y = u + (c.data.$.screenY - l.y) * (a._.moved ? 1 : 2), w = a._.element.getFirst(), w = m && parseInt(w.getComputedStyle("right"), 10), v = a.getPosition(); v.x = v.x || 0; v.y = v.y || 0; v.y + y > k.height && (y = k.height - v.y); (m ? w : v.x) + x > k.width && (x = k.width - (m ? w : v.x)); y = Math.floor(y); x = Math.floor(x); if (f == CKEDITOR.DIALOG_RESIZE_WIDTH || f == CKEDITOR.DIALOG_RESIZE_BOTH) p = Math.max(d.minWidth || 0, x - h); if (f == CKEDITOR.DIALOG_RESIZE_HEIGHT ||
                        f == CKEDITOR.DIALOG_RESIZE_BOTH) u = Math.max(d.minHeight || 0, y - g); a.resize(p, u); a._.moved && t(a, a._.position.x, a._.position.y); a._.moved || a.layout(); c.data.preventDefault()
                } function c() { CKEDITOR.document.removeListener("mouseup", c); CKEDITOR.document.removeListener("mousemove", b); m && (m.remove(), m = null); if (CKEDITOR.env.ie6Compat) { var a = F.getChild(0).getFrameDocument(); a.removeListener("mouseup", c); a.removeListener("mousemove", b) } } var d = a.definition, f = d.resizable; if (f != CKEDITOR.DIALOG_RESIZE_NONE) {
                    var e =
                        a.getParentEditor(), h, g, k, l, n, m, p = CKEDITOR.tools.addFunction(function (f) {
                            function d(a) { return a.isVisible() } n = a.getSize(); var e = a.parts.contents, p = e.$.getElementsByTagName("iframe").length, u = !(CKEDITOR.env.gecko || CKEDITOR.env.ie && CKEDITOR.env.quirks); p && (m = CKEDITOR.dom.element.createFromHtml('\x3cdiv class\x3d"cke_dialog_resize_cover" style\x3d"height: 100%; position: absolute; width: 100%; left:0; top:0;"\x3e\x3c/div\x3e'), e.append(m)); g = n.height - a.parts.contents.getFirst(d).getSize("height", u);
                            h = n.width - a.parts.contents.getFirst(d).getSize("width", 1); l = { x: f.screenX, y: f.screenY }; k = CKEDITOR.document.getWindow().getViewPaneSize(); CKEDITOR.document.on("mousemove", b); CKEDITOR.document.on("mouseup", c); CKEDITOR.env.ie6Compat && (e = F.getChild(0).getFrameDocument(), e.on("mousemove", b), e.on("mouseup", c)); f.preventDefault && f.preventDefault()
                        }); a.on("load", function () {
                            var b = ""; f == CKEDITOR.DIALOG_RESIZE_WIDTH ? b = " cke_resizer_horizontal" : f == CKEDITOR.DIALOG_RESIZE_HEIGHT && (b = " cke_resizer_vertical"); b = CKEDITOR.dom.element.createFromHtml('\x3cdiv class\x3d"cke_resizer' +
                                b + " cke_resizer_" + e.lang.dir + '" title\x3d"' + CKEDITOR.tools.htmlEncode(e.lang.common.resize) + '" onmousedown\x3d"CKEDITOR.tools.callFunction(' + p + ', event )"\x3e' + ("ltr" == e.lang.dir ? "◢" : "◣") + "\x3c/div\x3e"); a.parts.footer.append(b, 1)
                        }); e.on("destroy", function () { CKEDITOR.tools.removeFunction(p) })
                }
            } function t(a, b, c) {
                var f = a.parts.dialog.getParent().getClientSize(), d = a.getSize(), e = a._.viewportRatio, h = Math.max(f.width - d.width, 0), f = Math.max(f.height - d.height, 0); e.width = h ? b / h : e.width; e.height = f ? c / f : e.height;
                a._.viewportRatio = e
            } function q(a) { a.data.preventDefault(1) } function r(a) {
                var b = a.config, c = CKEDITOR.skinName || a.config.skin, f = b.dialog_backgroundCoverColor || ("moono-lisa" == c ? "black" : "white"), c = b.dialog_backgroundCoverOpacity, d = b.baseFloatZIndex, b = CKEDITOR.tools.genKey(f, c, d), e = J[b]; CKEDITOR.document.getBody().addClass("cke_dialog_open"); e ? e.show() : (d = ['\x3cdiv tabIndex\x3d"-1" style\x3d"position: ', CKEDITOR.env.ie6Compat ? "absolute" : "fixed", "; z-index: ", d, "; top: 0px; left: 0px; ", "; width: 100%; height: 100%;",
                    CKEDITOR.env.ie6Compat ? "" : "background-color: " + f, '" class\x3d"cke_dialog_background_cover"\x3e'], CKEDITOR.env.ie6Compat && (f = "\x3chtml\x3e\x3cbody style\x3d\\'background-color:" + f + ";\\'\x3e\x3c/body\x3e\x3c/html\x3e", d.push('\x3ciframe hidefocus\x3d"true" frameborder\x3d"0" id\x3d"cke_dialog_background_iframe" src\x3d"javascript:'), d.push("void((function(){" + encodeURIComponent("document.open();(" + CKEDITOR.tools.fixDomain + ")();document.write( '" + f + "' );document.close();") + "})())"), d.push('" style\x3d"position:absolute;left:0;top:0;width:100%;height: 100%;filter: progid:DXImageTransform.Microsoft.Alpha(opacity\x3d0)"\x3e\x3c/iframe\x3e')),
                    d.push("\x3c/div\x3e"), e = CKEDITOR.dom.element.createFromHtml(d.join("")), e.setOpacity(void 0 !== c ? c : .5), e.on("keydown", q), e.on("keypress", q), e.on("keyup", q), e.appendTo(CKEDITOR.document.getBody()), J[b] = e); a.focusManager.add(e); F = e; CKEDITOR.env.mac && CKEDITOR.env.webkit || e.focus()
            } function w(a) { CKEDITOR.document.getBody().removeClass("cke_dialog_open"); F && (a.focusManager.remove(F), F.hide()) } function x(a) {
                var b = a.data.$.ctrlKey || a.data.$.metaKey, c = a.data.$.altKey, f = a.data.$.shiftKey, d = String.fromCharCode(a.data.$.keyCode);
                (b = K[(b ? "CTRL+" : "") + (c ? "ALT+" : "") + (f ? "SHIFT+" : "") + d]) && b.length && (b = b[b.length - 1], b.keydown && b.keydown.call(b.uiElement, b.dialog, b.key), a.data.preventDefault())
            } function u(a) { var b = a.data.$.ctrlKey || a.data.$.metaKey, c = a.data.$.altKey, f = a.data.$.shiftKey, d = String.fromCharCode(a.data.$.keyCode); (b = K[(b ? "CTRL+" : "") + (c ? "ALT+" : "") + (f ? "SHIFT+" : "") + d]) && b.length && (b = b[b.length - 1], b.keyup && (b.keyup.call(b.uiElement, b.dialog, b.key), a.data.preventDefault())) } function A(a, b, c, f, d) {
                (K[c] || (K[c] = [])).push({
                    uiElement: a,
                    dialog: b, key: c, keyup: d || a.accessKeyUp, keydown: f || a.accessKeyDown
                })
            } function v(a) { for (var b in K) { for (var c = K[b], f = c.length - 1; 0 <= f; f--)c[f].dialog != a && c[f].uiElement != a || c.splice(f, 1); 0 === c.length && delete K[b] } } function z(a, b) { a._.accessKeyMap[b] && a.selectPage(a._.accessKeyMap[b]) } function y() { } var B = CKEDITOR.tools.cssLength, C, F, G = !CKEDITOR.env.ie || CKEDITOR.env.edge, I = '\x3cdiv class\x3d"cke_reset_all cke_dialog_container {editorId} {editorDialogClass} {hidpi}" dir\x3d"{langDir}" style\x3d"' + (G ? "display:flex" :
                "") + '" lang\x3d"{langCode}" role\x3d"dialog" aria-labelledby\x3d"cke_dialog_title_{id}"\x3e\x3ctable class\x3d"cke_dialog ' + CKEDITOR.env.cssClass + ' cke_{langDir}" style\x3d"' + (G ? "margin:auto" : "position:absolute") + '" role\x3d"presentation"\x3e\x3ctr\x3e\x3ctd role\x3d"presentation"\x3e\x3cdiv class\x3d"cke_dialog_body" role\x3d"presentation"\x3e\x3cdiv id\x3d"cke_dialog_title_{id}" class\x3d"cke_dialog_title" role\x3d"presentation"\x3e\x3c/div\x3e\x3ca id\x3d"cke_dialog_close_button_{id}" class\x3d"cke_dialog_close_button" href\x3d"javascript:void(0)" title\x3d"{closeTitle}" role\x3d"button"\x3e\x3cspan class\x3d"cke_label"\x3eX\x3c/span\x3e\x3c/a\x3e\x3cdiv id\x3d"cke_dialog_tabs_{id}" class\x3d"cke_dialog_tabs" role\x3d"tablist"\x3e\x3c/div\x3e\x3ctable class\x3d"cke_dialog_contents" role\x3d"presentation"\x3e\x3ctr\x3e\x3ctd id\x3d"cke_dialog_contents_{id}" class\x3d"cke_dialog_contents_body" role\x3d"presentation"\x3e\x3c/td\x3e\x3c/tr\x3e\x3ctr\x3e\x3ctd id\x3d"cke_dialog_footer_{id}" class\x3d"cke_dialog_footer" role\x3d"presentation"\x3e\x3c/td\x3e\x3c/tr\x3e\x3c/table\x3e\x3c/div\x3e\x3c/td\x3e\x3c/tr\x3e\x3c/table\x3e\x3c/div\x3e';
            CKEDITOR.dialog = function (b, c) {
                function f() { var a = B._.focusList; a.sort(function (a, b) { return a.tabIndex != b.tabIndex ? b.tabIndex - a.tabIndex : a.focusIndex - b.focusIndex }); for (var b = a.length, c = 0; c < b; c++)a[c].focusIndex = c } function l(a) {
                    var b = B._.focusList; a = a || 0; if (!(1 > b.length)) {
                        var c = B._.currentFocusIndex; B._.tabBarMode && 0 > a && (c = 0); try { b[c].getInputElement().$.blur() } catch (f) { } var d = c, e = 1 < B._.pageCount; do {
                            d += a; if (e && !B._.tabBarMode && (d == b.length || -1 == d)) {
                                B._.tabBarMode = !0; B._.tabs[B._.currentTabId][0].focus();
                                B._.currentFocusIndex = -1; return
                            } d = (d + b.length) % b.length; if (d == c) break
                        } while (a && !b[d].isFocusable()); b[d].focus(); "text" == b[d].type && b[d].select()
                    }
                } function u(c) {
                    if (B == CKEDITOR.dialog._.currentTop) {
                        var f = c.data.getKeystroke(), d = "rtl" == b.lang.dir, h = [37, 38, 39, 40]; z = q = 0; if (9 == f || f == CKEDITOR.SHIFT + 9) l(f == CKEDITOR.SHIFT + 9 ? -1 : 1), z = 1; else if (f == CKEDITOR.ALT + 121 && !B._.tabBarMode && 1 < B.getPageCount()) a(B), z = 1; else if (-1 != CKEDITOR.tools.indexOf(h, f) && B._.tabBarMode) f = -1 != CKEDITOR.tools.indexOf([d ? 39 : 37, 38], f) ?
                            g.call(B) : e.call(B), B.selectPage(f), B._.tabs[f][0].focus(), z = 1; else if (13 != f && 32 != f || !B._.tabBarMode) if (13 == f) f = c.data.getTarget(), f.is("a", "button", "select", "textarea") || f.is("input") && "button" == f.$.type || ((f = this.getButton("ok")) && CKEDITOR.tools.setTimeout(f.click, 0, f), z = 1), q = 1; else if (27 == f) (f = this.getButton("cancel")) ? CKEDITOR.tools.setTimeout(f.click, 0, f) : !1 !== this.fire("cancel", { hide: !0 }).hide && this.hide(), q = 1; else return; else this.selectPage(this._.currentTabId), this._.tabBarMode = !1, this._.currentFocusIndex =
                                -1, l(1), z = 1; x(c)
                    }
                } function x(a) { z ? a.data.preventDefault(1) : q && a.data.stopPropagation() } var y = CKEDITOR.dialog._.dialogDefinitions[c], w = CKEDITOR.tools.clone(C), v = b.config.dialog_buttonsOrder || "OS", t = b.lang.dir, A = {}, z, q; ("OS" == v && CKEDITOR.env.mac || "rtl" == v && "ltr" == t || "ltr" == v && "rtl" == t) && w.buttons.reverse(); y = CKEDITOR.tools.extend(y(b), w); y = CKEDITOR.tools.clone(y); y = new k(this, y); w = h(b); this._ = {
                    editor: b, element: w.element, name: c, model: null, contentSize: { width: 0, height: 0 }, size: { width: 0, height: 0 }, contents: {},
                    buttons: {}, accessKeyMap: {}, viewportRatio: { width: .5, height: .5 }, tabs: {}, tabIdList: [], currentTabId: null, currentTabIndex: null, pageCount: 0, lastTab: null, tabBarMode: !1, focusList: [], currentFocusIndex: 0, hasFocus: !1
                }; this.parts = w.parts; CKEDITOR.tools.setTimeout(function () { b.fire("ariaWidget", this.parts.contents) }, 0, this); w = { top: 0, visibility: "hidden" }; CKEDITOR.env.ie6Compat && (w.position = "absolute"); w["rtl" == t ? "right" : "left"] = 0; this.parts.dialog.setStyles(w); CKEDITOR.event.call(this); this.definition = y = CKEDITOR.fire("dialogDefinition",
                    { name: c, definition: y, dialog: this }, b).definition; if (!("removeDialogTabs" in b._) && b.config.removeDialogTabs) { w = b.config.removeDialogTabs.split(";"); for (t = 0; t < w.length; t++)if (v = w[t].split(":"), 2 == v.length) { var r = v[0]; A[r] || (A[r] = []); A[r].push(v[1]) } b._.removeDialogTabs = A } if (b._.removeDialogTabs && (A = b._.removeDialogTabs[c])) for (t = 0; t < A.length; t++)y.removeContents(A[t]); if (y.onLoad) this.on("load", y.onLoad); if (y.onShow) this.on("show", y.onShow); if (y.onHide) this.on("hide", y.onHide); if (y.onOk) this.on("ok",
                        function (a) { b.fire("saveSnapshot"); setTimeout(function () { b.fire("saveSnapshot") }, 0); !1 === y.onOk.call(this, a) && (a.data.hide = !1) }); this.state = CKEDITOR.DIALOG_STATE_IDLE; if (y.onCancel) this.on("cancel", function (a) { !1 === y.onCancel.call(this, a) && (a.data.hide = !1) }); var B = this, F = function (a) { var b = B._.contents, c = !1, f; for (f in b) for (var d in b[f]) if (c = a.call(this, b[f][d])) return }; this.on("ok", function (a) {
                            F(function (b) {
                                if (b.validate) {
                                    var c = b.validate(this), f = "string" == typeof c || !1 === c; f && (a.data.hide = !1, a.stop());
                                    d.call(b, !f, "string" == typeof c ? c : void 0); return f
                                }
                            })
                        }, this, null, 0); this.on("cancel", function (a) { F(function (c) { if (c.isChanged()) return b.config.dialog_noConfirmCancel || confirm(b.lang.common.confirmCancel) || (a.data.hide = !1), !0 }) }, this, null, 0); this.parts.close.on("click", function (a) { !1 !== this.fire("cancel", { hide: !0 }).hide && this.hide(); a.data.preventDefault() }, this); this.changeFocus = l; var I = this._.element; b.focusManager.add(I, 1); this.on("show", function () {
                            I.on("keydown", u, this); if (CKEDITOR.env.gecko) I.on("keypress",
                                x, this)
                        }); this.on("hide", function () { I.removeListener("keydown", u); CKEDITOR.env.gecko && I.removeListener("keypress", x); F(function (a) { m.apply(a) }) }); this.on("iframeAdded", function (a) { (new CKEDITOR.dom.document(a.data.iframe.$.contentWindow.document)).on("keydown", u, this, null, 0) }); this.on("show", function () {
                            f(); var a = 1 < B._.pageCount; b.config.dialog_startupFocusTab && a ? (B._.tabBarMode = !0, B._.tabs[B._.currentTabId][0].focus(), B._.currentFocusIndex = -1) : this._.hasFocus || (this._.currentFocusIndex = a ? -1 : this._.focusList.length -
                                1, y.onFocus ? (a = y.onFocus.call(this)) && a.focus() : l(1))
                        }, this, null, 4294967295); if (CKEDITOR.env.ie6Compat) this.on("load", function () { var a = this.getElement(), b = a.getFirst(); b.remove(); b.appendTo(a) }, this); n(this); p(this); (new CKEDITOR.dom.text(y.title, CKEDITOR.document)).appendTo(this.parts.title); for (t = 0; t < y.contents.length; t++)(A = y.contents[t]) && this.addPage(A); this.parts.tabs.on("click", function (b) {
                            var c = b.data.getTarget(); c.hasClass("cke_dialog_tab") && (c = c.$.id, this.selectPage(c.substring(4, c.lastIndexOf("_"))),
                                a(this), b.data.preventDefault())
                        }, this); t = []; A = CKEDITOR.dialog._.uiElementBuilders.hbox.build(this, { type: "hbox", className: "cke_dialog_footer_buttons", widths: [], children: y.buttons }, t).getChild(); this.parts.footer.setHtml(t.join("")); for (t = 0; t < A.length; t++)this._.buttons[A[t].id] = A[t]
            }; CKEDITOR.dialog.prototype = {
                destroy: function () { this.hide(); this._.element.remove() }, resize: function (a, b) {
                    if (!this._.contentSize || this._.contentSize.width != a || this._.contentSize.height != b) {
                        CKEDITOR.dialog.fire("resize",
                            { dialog: this, width: a, height: b }, this._.editor); this.fire("resize", { width: a, height: b }, this._.editor); this.parts.contents.setStyles({ width: a + "px", height: b + "px" }); if ("rtl" == this._.editor.lang.dir && this._.position) { var c = this.parts.dialog.getParent().getClientSize().width; this._.position.x = c - this._.contentSize.width - parseInt(this._.element.getFirst().getStyle("right"), 10) } this._.contentSize = { width: a, height: b }
                    }
                }, getSize: function () {
                    var a = this._.element.getFirst(); return {
                        width: a.$.offsetWidth || 0, height: a.$.offsetHeight ||
                            0
                    }
                }, move: function (a, b, c) {
                    var f = this._.element.getFirst(), d = "rtl" == this._.editor.lang.dir; CKEDITOR.env.ie && f.setStyle("zoom", "100%"); var e = this.parts.dialog.getParent().getClientSize(), h = this.getSize(), g = this._.viewportRatio, k = Math.max(e.width - h.width, 0), e = Math.max(e.height - h.height, 0); this._.position && this._.position.x == a && this._.position.y == b ? (a = Math.floor(k * g.width), b = Math.floor(e * g.height)) : t(this, a, b); this._.position = { x: a, y: b }; d && (a = k - a); b = { top: (0 < b ? b : 0) + "px" }; b[d ? "right" : "left"] = (0 < a ? a : 0) + "px";
                    f.setStyles(b); c && (this._.moved = 1)
                }, getPosition: function () { return CKEDITOR.tools.extend({}, this._.position) }, show: function () {
                    var a = this._.element, b = this.definition, f = CKEDITOR.document.getBody(), d = this._.editor.config.baseFloatZIndex; a.getParent() && a.getParent().equals(f) ? a.setStyle("display", G ? "flex" : "block") : a.appendTo(f); this.resize(this._.contentSize && this._.contentSize.width || b.width || b.minWidth, this._.contentSize && this._.contentSize.height || b.height || b.minHeight); this.reset(); null === this._.currentTabId &&
                        this.selectPage(this.definition.contents[0].id); null === CKEDITOR.dialog._.currentZIndex && (CKEDITOR.dialog._.currentZIndex = d); this._.element.getFirst().setStyle("z-index", CKEDITOR.dialog._.currentZIndex += 10); this.getElement().setStyle("z-index", CKEDITOR.dialog._.currentZIndex); null === CKEDITOR.dialog._.currentTop ? (CKEDITOR.dialog._.currentTop = this, this._.parentDialog = null, r(this._.editor)) : (this._.parentDialog = CKEDITOR.dialog._.currentTop, f = this._.parentDialog.getElement().getFirst(), f.$.style.zIndex -=
                            Math.floor(d / 2), this._.parentDialog.getElement().setStyle("z-index", f.$.style.zIndex), CKEDITOR.dialog._.currentTop = this); a.on("keydown", x); a.on("keyup", u); this._.hasFocus = !1; for (var e in b.contents) if (b.contents[e]) {
                                var a = b.contents[e], d = this._.tabs[a.id], f = a.requiredContent, h = 0; if (d) {
                                    for (var g in this._.contents[a.id]) {
                                        var k = this._.contents[a.id][g]; "hbox" != k.type && "vbox" != k.type && k.getInputElement() && (k.requiredContent && !this._.editor.activeFilter.check(k.requiredContent) ? k.disable() : (k.enable(),
                                            h++))
                                    } !h || f && !this._.editor.activeFilter.check(f) ? d[0].addClass("cke_dialog_tab_disabled") : d[0].removeClass("cke_dialog_tab_disabled")
                                }
                            } CKEDITOR.tools.setTimeout(function () { this.layout(); c(this); this.parts.dialog.setStyle("visibility", ""); this.fireOnce("load", {}); CKEDITOR.ui.fire("ready", this); this.fire("show", {}); this._.editor.fire("dialogShow", this); this._.parentDialog || this._.editor.focusManager.lock(); this.foreach(function (a) { a.setInitValue && a.setInitValue() }) }, 100, this)
                }, layout: function () {
                    var a =
                        this.parts.dialog; if (this._.moved || !G) { var b = this.getSize(), c = CKEDITOR.document.getWindow().getViewPaneSize(), f; this._.moved && this._.position ? (f = this._.position.x, b = this._.position.y) : (f = (c.width - b.width) / 2, b = (c.height - b.height) / 2); CKEDITOR.env.ie6Compat || (a.setStyle("position", "absolute"), a.removeStyle("margin")); f = Math.floor(f); b = Math.floor(b); this.move(f, b) }
                }, foreach: function (a) { for (var b in this._.contents) for (var c in this._.contents[b]) a.call(this, this._.contents[b][c]); return this }, reset: function () {
                    var a =
                        function (a) { a.reset && a.reset(1) }; return function () { this.foreach(a); return this }
                }(), setupContent: function () { var a = arguments; this.foreach(function (b) { b.setup && b.setup.apply(b, a) }) }, commitContent: function () { var a = arguments; this.foreach(function (b) { CKEDITOR.env.ie && this._.currentFocusIndex == b.focusIndex && b.getInputElement().$.blur(); b.commit && b.commit.apply(b, a) }) }, hide: function () {
                    if (this.parts.dialog.isVisible()) {
                        this.fire("hide", {}); this._.editor.fire("dialogHide", this); this.selectPage(this._.tabIdList[0]);
                        var a = this._.element; a.setStyle("display", "none"); this.parts.dialog.setStyle("visibility", "hidden"); for (v(this); CKEDITOR.dialog._.currentTop != this;)CKEDITOR.dialog._.currentTop.hide(); if (this._.parentDialog) { var b = this._.parentDialog.getElement().getFirst(); this._.parentDialog.getElement().removeStyle("z-index"); b.setStyle("z-index", parseInt(b.$.style.zIndex, 10) + Math.floor(this._.editor.config.baseFloatZIndex / 2)) } else w(this._.editor); if (CKEDITOR.dialog._.currentTop = this._.parentDialog) CKEDITOR.dialog._.currentZIndex -=
                            10; else { CKEDITOR.dialog._.currentZIndex = null; a.removeListener("keydown", x); a.removeListener("keyup", u); var c = this._.editor; c.focus(); setTimeout(function () { c.focusManager.unlock(); CKEDITOR.env.iOS && c.window.focus() }, 0) } delete this._.parentDialog; this.foreach(function (a) { a.resetInitValue && a.resetInitValue() }); this.setState(CKEDITOR.DIALOG_STATE_IDLE)
                    }
                }, addPage: function (a) {
                    if (!a.requiredContent || this._.editor.filter.check(a.requiredContent)) {
                        for (var b = [], c = a.label ? ' title\x3d"' + CKEDITOR.tools.htmlEncode(a.label) +
                            '"' : "", f = CKEDITOR.dialog._.uiElementBuilders.vbox.build(this, { type: "vbox", className: "cke_dialog_page_contents", children: a.elements, expand: !!a.expand, padding: a.padding, style: a.style || "width: 100%;" }, b), d = this._.contents[a.id] = {}, e = f.getChild(), h = 0; f = e.shift();)f.notAllowed || "hbox" == f.type || "vbox" == f.type || h++, d[f.id] = f, "function" == typeof f.getChild && e.push.apply(e, f.getChild()); h || (a.hidden = !0); b = CKEDITOR.dom.element.createFromHtml(b.join("")); b.setAttribute("role", "tabpanel"); b.setStyle("min-height",
                                "100%"); f = CKEDITOR.env; d = "cke_" + a.id + "_" + CKEDITOR.tools.getNextNumber(); c = CKEDITOR.dom.element.createFromHtml(['\x3ca class\x3d"cke_dialog_tab"', 0 < this._.pageCount ? " cke_last" : "cke_first", c, a.hidden ? ' style\x3d"display:none"' : "", ' id\x3d"', d, '"', f.gecko && !f.hc ? "" : ' href\x3d"javascript:void(0)"', ' tabIndex\x3d"-1" hidefocus\x3d"true" role\x3d"tab"\x3e', a.label, "\x3c/a\x3e"].join("")); b.setAttribute("aria-labelledby", d); this._.tabs[a.id] = [c, b]; this._.tabIdList.push(a.id); !a.hidden && this._.pageCount++;
                        this._.lastTab = c; this.updateStyle(); b.setAttribute("name", a.id); b.appendTo(this.parts.contents); c.unselectable(); this.parts.tabs.append(c); a.accessKey && (A(this, this, "CTRL+" + a.accessKey, y, z), this._.accessKeyMap["CTRL+" + a.accessKey] = a.id)
                    }
                }, selectPage: function (a) {
                    if (this._.currentTabId != a && !this._.tabs[a][0].hasClass("cke_dialog_tab_disabled") && !1 !== this.fire("selectPage", { page: a, currentPage: this._.currentTabId })) {
                        for (var c in this._.tabs) {
                            var f = this._.tabs[c][0], d = this._.tabs[c][1]; c != a && (f.removeClass("cke_dialog_tab_selected"),
                                f.removeAttribute("aria-selected"), d.hide()); d.setAttribute("aria-hidden", c != a)
                        } var e = this._.tabs[a]; e[0].addClass("cke_dialog_tab_selected"); e[0].setAttribute("aria-selected", !0); CKEDITOR.env.ie6Compat || CKEDITOR.env.ie7Compat ? (b(e[1]), e[1].show(), setTimeout(function () { b(e[1], 1) }, 0)) : e[1].show(); this._.currentTabId = a; this._.currentTabIndex = CKEDITOR.tools.indexOf(this._.tabIdList, a)
                    }
                }, updateStyle: function () { this.parts.dialog[(1 === this._.pageCount ? "add" : "remove") + "Class"]("cke_single_page") }, hidePage: function (a) {
                    var b =
                        this._.tabs[a] && this._.tabs[a][0]; b && 1 != this._.pageCount && b.isVisible() && (a == this._.currentTabId && this.selectPage(g.call(this)), b.hide(), this._.pageCount--, this.updateStyle())
                }, showPage: function (a) { if (a = this._.tabs[a] && this._.tabs[a][0]) a.show(), this._.pageCount++, this.updateStyle() }, getElement: function () { return this._.element }, getName: function () { return this._.name }, getContentElement: function (a, b) { var c = this._.contents[a]; return c && c[b] }, getValueOf: function (a, b) { return this.getContentElement(a, b).getValue() },
                setValueOf: function (a, b, c) { return this.getContentElement(a, b).setValue(c) }, getButton: function (a) { return this._.buttons[a] }, click: function (a) { return this._.buttons[a].click() }, disableButton: function (a) { return this._.buttons[a].disable() }, enableButton: function (a) { return this._.buttons[a].enable() }, getPageCount: function () { return this._.pageCount }, getParentEditor: function () { return this._.editor }, getSelectedElement: function () { return this.getParentEditor().getSelection().getSelectedElement() }, addFocusable: function (a,
                    b) { if ("undefined" == typeof b) b = this._.focusList.length, this._.focusList.push(new l(this, a, b)); else { this._.focusList.splice(b, 0, new l(this, a, b)); for (var c = b + 1; c < this._.focusList.length; c++)this._.focusList[c].focusIndex++ } }, setState: function (a) {
                        if (this.state != a) {
                            this.state = a; if (a == CKEDITOR.DIALOG_STATE_BUSY) {
                                if (!this.parts.spinner) {
                                    var b = this.getParentEditor().lang.dir, c = { attributes: { "class": "cke_dialog_spinner" }, styles: { "float": "rtl" == b ? "right" : "left" } }; c.styles["margin-" + ("rtl" == b ? "left" : "right")] =
                                        "8px"; this.parts.spinner = CKEDITOR.document.createElement("div", c); this.parts.spinner.setHtml("\x26#8987;"); this.parts.spinner.appendTo(this.parts.title, 1)
                                } this.parts.spinner.show(); this.getButton("ok").disable()
                            } else a == CKEDITOR.DIALOG_STATE_IDLE && (this.parts.spinner && this.parts.spinner.hide(), this.getButton("ok").enable()); this.fire("state", a)
                        }
                    }, getModel: function (a) { return this._.model ? this._.model : this.definition.getModel ? this.definition.getModel(a) : null }, setModel: function (a) { this._.model = a }, getMode: function (a) {
                        if (this.definition.getMode) return this.definition.getMode(a);
                        a = this.getModel(a); return !a || a instanceof CKEDITOR.dom.element && !a.getParent() ? CKEDITOR.dialog.CREATION_MODE : CKEDITOR.dialog.EDITING_MODE
                    }
            }; CKEDITOR.tools.extend(CKEDITOR.dialog, {
                CREATION_MODE: 0, EDITING_MODE: 1, add: function (a, b) { this._.dialogDefinitions[a] && "function" != typeof b || (this._.dialogDefinitions[a] = b) }, exists: function (a) { return !!this._.dialogDefinitions[a] }, getCurrent: function () { return CKEDITOR.dialog._.currentTop }, isTabEnabled: function (a, b, c) {
                    a = a.config.removeDialogTabs; return !(a && a.match(new RegExp("(?:^|;)" +
                        b + ":" + c + "(?:$|;)", "i")))
                }, okButton: function () { var a = function (a, b) { b = b || {}; return CKEDITOR.tools.extend({ id: "ok", type: "button", label: a.lang.common.ok, "class": "cke_dialog_ui_button_ok", onClick: function (a) { a = a.data.dialog; !1 !== a.fire("ok", { hide: !0 }).hide && a.hide() } }, b, !0) }; a.type = "button"; a.override = function (b) { return CKEDITOR.tools.extend(function (c) { return a(c, b) }, { type: "button" }, !0) }; return a }(), cancelButton: function () {
                    var a = function (a, b) {
                        b = b || {}; return CKEDITOR.tools.extend({
                            id: "cancel", type: "button",
                            label: a.lang.common.cancel, "class": "cke_dialog_ui_button_cancel", onClick: function (a) { a = a.data.dialog; !1 !== a.fire("cancel", { hide: !0 }).hide && a.hide() }
                        }, b, !0)
                    }; a.type = "button"; a.override = function (b) { return CKEDITOR.tools.extend(function (c) { return a(c, b) }, { type: "button" }, !0) }; return a
                }(), addUIElement: function (a, b) { this._.uiElementBuilders[a] = b }
            }); CKEDITOR.dialog._ = { uiElementBuilders: {}, dialogDefinitions: {}, currentTop: null, currentZIndex: null }; CKEDITOR.event.implementOn(CKEDITOR.dialog); CKEDITOR.event.implementOn(CKEDITOR.dialog.prototype);
            C = { resizable: CKEDITOR.DIALOG_RESIZE_BOTH, minWidth: 600, minHeight: 400, buttons: [CKEDITOR.dialog.okButton, CKEDITOR.dialog.cancelButton] }; var H = function (a, b, c) { for (var f = 0, d; d = a[f]; f++)if (d.id == b || c && d[c] && (d = H(d[c], b, c))) return d; return null }, D = function (a, b, c, f, d) { if (c) { for (var e = 0, h; h = a[e]; e++) { if (h.id == c) return a.splice(e, 0, b), b; if (f && h[f] && (h = D(h[f], b, c, f, !0))) return h } if (d) return null } a.push(b); return b }, M = function (a, b, c) {
                for (var f = 0, d; d = a[f]; f++) {
                    if (d.id == b) return a.splice(f, 1); if (c && d[c] && (d = M(d[c],
                        b, c))) return d
                } return null
            }; k.prototype = { getContents: function (a) { return H(this.contents, a) }, getButton: function (a) { return H(this.buttons, a) }, addContents: function (a, b) { return D(this.contents, a, b) }, addButton: function (a, b) { return D(this.buttons, a, b) }, removeContents: function (a) { M(this.contents, a) }, removeButton: function (a) { M(this.buttons, a) } }; f.prototype = {
                get: function (a) { return H(this.elements, a, "children") }, add: function (a, b) { return D(this.elements, a, b, "children") }, remove: function (a) {
                    M(this.elements, a,
                        "children")
                }
            }; var J = {}, K = {}; (function () {
                CKEDITOR.ui.dialog = {
                    uiElement: function (a, b, c, f, d, e, h) {
                        if (!(4 > arguments.length)) {
                            var g = (f.call ? f(b) : f) || "div", k = ["\x3c", g, " "], l = (d && d.call ? d(b) : d) || {}, n = (e && e.call ? e(b) : e) || {}, m = (h && h.call ? h.call(this, a, b) : h) || "", p = this.domId = n.id || CKEDITOR.tools.getNextId() + "_uiElement"; b.requiredContent && !a.getParentEditor().filter.check(b.requiredContent) && (l.display = "none", this.notAllowed = !0); n.id = p; var u = {}; b.type && (u["cke_dialog_ui_" + b.type] = 1); b.className && (u[b.className] =
                                1); b.disabled && (u.cke_disabled = 1); for (var y = n["class"] && n["class"].split ? n["class"].split(" ") : [], p = 0; p < y.length; p++)y[p] && (u[y[p]] = 1); y = []; for (p in u) y.push(p); n["class"] = y.join(" "); b.title && (n.title = b.title); u = (b.style || "").split(";"); b.align && (y = b.align, l["margin-left"] = "left" == y ? 0 : "auto", l["margin-right"] = "right" == y ? 0 : "auto"); for (p in l) u.push(p + ":" + l[p]); b.hidden && u.push("display:none"); for (p = u.length - 1; 0 <= p; p--)"" === u[p] && u.splice(p, 1); 0 < u.length && (n.style = (n.style ? n.style + "; " : "") + u.join("; "));
                            for (p in n) k.push(p + '\x3d"' + CKEDITOR.tools.htmlEncode(n[p]) + '" '); k.push("\x3e", m, "\x3c/", g, "\x3e"); c.push(k.join("")); (this._ || (this._ = {})).dialog = a; "boolean" == typeof b.isChanged && (this.isChanged = function () { return b.isChanged }); "function" == typeof b.isChanged && (this.isChanged = b.isChanged); "function" == typeof b.setValue && (this.setValue = CKEDITOR.tools.override(this.setValue, function (a) { return function (c) { a.call(this, b.setValue.call(this, c)) } })); "function" == typeof b.getValue && (this.getValue = CKEDITOR.tools.override(this.getValue,
                                function (a) { return function () { return b.getValue.call(this, a.call(this)) } })); CKEDITOR.event.implementOn(this); this.registerEvents(b); this.accessKeyUp && this.accessKeyDown && b.accessKey && A(this, a, "CTRL+" + b.accessKey); var x = this; a.on("load", function () {
                                    var b = x.getInputElement(); if (b) {
                                        var c = x.type in { checkbox: 1, ratio: 1 } && CKEDITOR.env.ie && 8 > CKEDITOR.env.version ? "cke_dialog_ui_focused" : ""; b.on("focus", function () { a._.tabBarMode = !1; a._.hasFocus = !0; x.fire("focus"); c && this.addClass(c) }); b.on("blur", function () {
                                            x.fire("blur");
                                            c && this.removeClass(c)
                                        })
                                    }
                                }); CKEDITOR.tools.extend(this, b); this.keyboardFocusable && (this.tabIndex = b.tabIndex || 0, this.focusIndex = a._.focusList.push(this) - 1, this.on("focus", function () { a._.currentFocusIndex = x.focusIndex }))
                        }
                    }, hbox: function (a, b, c, f, d) {
                        if (!(4 > arguments.length)) {
                            this._ || (this._ = {}); var e = this._.children = b, h = d && d.widths || null, g = d && d.height || null, k, l = { role: "presentation" }; d && d.align && (l.align = d.align); CKEDITOR.ui.dialog.uiElement.call(this, a, d || { type: "hbox" }, f, "table", {}, l, function () {
                                var a =
                                    ['\x3ctbody\x3e\x3ctr class\x3d"cke_dialog_ui_hbox"\x3e']; for (k = 0; k < c.length; k++) {
                                        var b = "cke_dialog_ui_hbox_child", f = []; 0 === k && (b = "cke_dialog_ui_hbox_first"); k == c.length - 1 && (b = "cke_dialog_ui_hbox_last"); a.push('\x3ctd class\x3d"', b, '" role\x3d"presentation" '); h ? h[k] && f.push("width:" + B(h[k])) : f.push("width:" + Math.floor(100 / c.length) + "%"); g && f.push("height:" + B(g)); d && void 0 !== d.padding && f.push("padding:" + B(d.padding)); CKEDITOR.env.ie && CKEDITOR.env.quirks && e[k].align && f.push("text-align:" + e[k].align);
                                        0 < f.length && a.push('style\x3d"' + f.join("; ") + '" '); a.push("\x3e", c[k], "\x3c/td\x3e")
                                    } a.push("\x3c/tr\x3e\x3c/tbody\x3e"); return a.join("")
                            })
                        }
                    }, vbox: function (a, b, c, f, d) {
                        if (!(3 > arguments.length)) {
                            this._ || (this._ = {}); var e = this._.children = b, h = d && d.width || null, g = d && d.heights || null; CKEDITOR.ui.dialog.uiElement.call(this, a, d || { type: "vbox" }, f, "div", null, { role: "presentation" }, function () {
                                var b = ['\x3ctable role\x3d"presentation" cellspacing\x3d"0" border\x3d"0" ']; b.push('style\x3d"'); d && d.expand && b.push("height:100%;");
                                b.push("width:" + B(h || "100%"), ";"); CKEDITOR.env.webkit && b.push("float:none;"); b.push('"'); b.push('align\x3d"', CKEDITOR.tools.htmlEncode(d && d.align || ("ltr" == a.getParentEditor().lang.dir ? "left" : "right")), '" '); b.push("\x3e\x3ctbody\x3e"); for (var f = 0; f < c.length; f++) {
                                    var k = []; b.push('\x3ctr\x3e\x3ctd role\x3d"presentation" '); h && k.push("width:" + B(h || "100%")); g ? k.push("height:" + B(g[f])) : d && d.expand && k.push("height:" + Math.floor(100 / c.length) + "%"); d && void 0 !== d.padding && k.push("padding:" + B(d.padding)); CKEDITOR.env.ie &&
                                        CKEDITOR.env.quirks && e[f].align && k.push("text-align:" + e[f].align); 0 < k.length && b.push('style\x3d"', k.join("; "), '" '); b.push(' class\x3d"cke_dialog_ui_vbox_child"\x3e', c[f], "\x3c/td\x3e\x3c/tr\x3e")
                                } b.push("\x3c/tbody\x3e\x3c/table\x3e"); return b.join("")
                            })
                        }
                    }
                }
            })(); CKEDITOR.ui.dialog.uiElement.prototype = {
                getElement: function () { return CKEDITOR.document.getById(this.domId) }, getInputElement: function () { return this.getElement() }, getDialog: function () { return this._.dialog }, setValue: function (a, b) {
                    this.getInputElement().setValue(a);
                    !b && this.fire("change", { value: a }); return this
                }, getValue: function () { return this.getInputElement().getValue() }, isChanged: function () { return !1 }, selectParentTab: function () { for (var a = this.getInputElement(); (a = a.getParent()) && -1 == a.$.className.search("cke_dialog_page_contents");); if (!a) return this; a = a.getAttribute("name"); this._.dialog._.currentTabId != a && this._.dialog.selectPage(a); return this }, focus: function () { this.selectParentTab().getInputElement().focus(); return this }, registerEvents: function (a) {
                    var b =
                        /^on([A-Z]\w+)/, c, f = function (a, b, c, f) { b.on("load", function () { a.getInputElement().on(c, f, a) }) }, d; for (d in a) if (c = d.match(b)) this.eventProcessors[d] ? this.eventProcessors[d].call(this, this._.dialog, a[d]) : f(this, this._.dialog, c[1].toLowerCase(), a[d]); return this
                }, eventProcessors: { onLoad: function (a, b) { a.on("load", b, this) }, onShow: function (a, b) { a.on("show", b, this) }, onHide: function (a, b) { a.on("hide", b, this) } }, accessKeyDown: function () { this.focus() }, accessKeyUp: function () { }, disable: function () {
                    var a = this.getElement();
                    this.getInputElement().setAttribute("disabled", "true"); a.addClass("cke_disabled")
                }, enable: function () { var a = this.getElement(); this.getInputElement().removeAttribute("disabled"); a.removeClass("cke_disabled") }, isEnabled: function () { return !this.getElement().hasClass("cke_disabled") }, isVisible: function () { return this.getInputElement().isVisible() }, isFocusable: function () { return this.isEnabled() && this.isVisible() ? !0 : !1 }
            }; CKEDITOR.ui.dialog.hbox.prototype = CKEDITOR.tools.extend(new CKEDITOR.ui.dialog.uiElement,
                { getChild: function (a) { if (1 > arguments.length) return this._.children.concat(); a.splice || (a = [a]); return 2 > a.length ? this._.children[a[0]] : this._.children[a[0]] && this._.children[a[0]].getChild ? this._.children[a[0]].getChild(a.slice(1, a.length)) : null } }, !0); CKEDITOR.ui.dialog.vbox.prototype = new CKEDITOR.ui.dialog.hbox; (function () {
                    var a = {
                        build: function (a, b, c) {
                            for (var f = b.children, d, e = [], h = [], g = 0; g < f.length && (d = f[g]); g++) { var k = []; e.push(k); h.push(CKEDITOR.dialog._.uiElementBuilders[d.type].build(a, d, k)) } return new CKEDITOR.ui.dialog[b.type](a,
                                h, e, c, b)
                        }
                    }; CKEDITOR.dialog.addUIElement("hbox", a); CKEDITOR.dialog.addUIElement("vbox", a)
                })(); CKEDITOR.dialogCommand = function (a, b) { this.dialogName = a; CKEDITOR.tools.extend(this, b, !0) }; CKEDITOR.dialogCommand.prototype = { exec: function (a) { var b = this.tabId; a.openDialog(this.dialogName, function (a) { b && a.selectPage(b) }) }, canUndo: !1, editorFocus: 1 }; (function () {
                    var a = /^([a]|[^a])+$/, b = /^\d*$/, c = /^\d*(?:\.\d+)?$/, f = /^(((\d*(\.\d+))|(\d*))(px|\%)?)?$/, d = /^(((\d*(\.\d+))|(\d*))(px|em|ex|in|cm|mm|pt|pc|\%)?)?$/i,
                    e = /^(\s*[\w-]+\s*:\s*[^:;]+(?:;|$))*$/; CKEDITOR.VALIDATE_OR = 1; CKEDITOR.VALIDATE_AND = 2; CKEDITOR.dialog.validate = {
                        functions: function () {
                            var a = arguments; return function () {
                                var b = this && this.getValue ? this.getValue() : a[0], c, f = CKEDITOR.VALIDATE_AND, d = [], e; for (e = 0; e < a.length; e++)if ("function" == typeof a[e]) d.push(a[e]); else break; e < a.length && "string" == typeof a[e] && (c = a[e], e++); e < a.length && "number" == typeof a[e] && (f = a[e]); var h = f == CKEDITOR.VALIDATE_AND ? !0 : !1; for (e = 0; e < d.length; e++)h = f == CKEDITOR.VALIDATE_AND ? h &&
                                    d[e](b) : h || d[e](b); return h ? !0 : c
                            }
                        }, regex: function (a, b) { return function (c) { c = this && this.getValue ? this.getValue() : c; return a.test(c) ? !0 : b } }, notEmpty: function (b) { return this.regex(a, b) }, integer: function (a) { return this.regex(b, a) }, number: function (a) { return this.regex(c, a) }, cssLength: function (a) { return this.functions(function (a) { return d.test(CKEDITOR.tools.trim(a)) }, a) }, htmlLength: function (a) { return this.functions(function (a) { return f.test(CKEDITOR.tools.trim(a)) }, a) }, inlineStyle: function (a) {
                            return this.functions(function (a) { return e.test(CKEDITOR.tools.trim(a)) },
                                a)
                        }, equals: function (a, b) { return this.functions(function (b) { return b == a }, b) }, notEqual: function (a, b) { return this.functions(function (b) { return b != a }, b) }
                    }; CKEDITOR.on("instanceDestroyed", function (a) { if (CKEDITOR.tools.isEmpty(CKEDITOR.instances)) { for (var b; b = CKEDITOR.dialog._.currentTop;)b.hide(); for (var c in J) J[c].remove(); J = {} } a = a.editor._.storedDialogs; for (var f in a) a[f].destroy() })
                })(); CKEDITOR.tools.extend(CKEDITOR.editor.prototype, {
                    openDialog: function (a, b, c) {
                        var f = null, d = CKEDITOR.dialog._.dialogDefinitions[a];
                        null === CKEDITOR.dialog._.currentTop && r(this); if ("function" == typeof d) d = this._.storedDialogs || (this._.storedDialogs = {}), f = d[a] || (d[a] = new CKEDITOR.dialog(this, a)), f.setModel(c), b && b.call(f, f), f.show(); else {
                            if ("failed" == d) throw w(this), Error('[CKEDITOR.dialog.openDialog] Dialog "' + a + '" failed when loading definition.'); "string" == typeof d && CKEDITOR.scriptLoader.load(CKEDITOR.getUrl(d), function () {
                                "function" != typeof CKEDITOR.dialog._.dialogDefinitions[a] && (CKEDITOR.dialog._.dialogDefinitions[a] = "failed");
                                this.openDialog(a, b, c)
                            }, this, 0, 1)
                        } CKEDITOR.skin.loadPart("dialog"); if (f) f.once("hide", function () { f.setModel(null) }, null, null, 999); return f
                    }
                })
        })(); var ka = !1; CKEDITOR.plugins.add("dialog", { requires: "dialogui", init: function (a) { ka || (CKEDITOR.document.appendStyleSheet(this.path + "styles/dialog.css"), ka = !0); a.on("doubleclick", function (g) { g.data.dialog && a.openDialog(g.data.dialog) }, null, null, 999) } }); (function () {
            CKEDITOR.plugins.add("a11yhelp", {
                requires: "dialog", availableLangs: {
                    af: 1, ar: 1, az: 1, bg: 1, ca: 1, cs: 1,
                    cy: 1, da: 1, de: 1, "de-ch": 1, el: 1, en: 1, "en-au": 1, "en-gb": 1, eo: 1, es: 1, "es-mx": 1, et: 1, eu: 1, fa: 1, fi: 1, fo: 1, fr: 1, "fr-ca": 1, gl: 1, gu: 1, he: 1, hi: 1, hr: 1, hu: 1, id: 1, it: 1, ja: 1, km: 1, ko: 1, ku: 1, lt: 1, lv: 1, mk: 1, mn: 1, nb: 1, nl: 1, no: 1, oc: 1, pl: 1, pt: 1, "pt-br": 1, ro: 1, ru: 1, si: 1, sk: 1, sl: 1, sq: 1, sr: 1, "sr-latn": 1, sv: 1, th: 1, tr: 1, tt: 1, ug: 1, uk: 1, vi: 1, zh: 1, "zh-cn": 1
                }, init: function (a) {
                    var g = this; a.addCommand("a11yHelp", {
                        exec: function () {
                            var e = a.langCode, e = g.availableLangs[e] ? e : g.availableLangs[e.replace(/-.*/, "")] ? e.replace(/-.*/, "") :
                                "en"; CKEDITOR.scriptLoader.load(CKEDITOR.getUrl(g.path + "dialogs/lang/" + e + ".js"), function () { a.lang.a11yhelp = g.langEntries[e]; a.openDialog("a11yHelp") })
                        }, modes: { wysiwyg: 1, source: 1 }, readOnly: 1, canUndo: !1
                    }); a.setKeystroke(CKEDITOR.ALT + 48, "a11yHelp"); CKEDITOR.dialog.add("a11yHelp", this.path + "dialogs/a11yhelp.js"); a.on("ariaEditorHelpLabel", function (e) { e.data.label = a.lang.common.editorHelp })
                }
            })
        })(); CKEDITOR.plugins.add("about", {
            requires: "dialog", init: function (a) {
                var g = a.addCommand("about", new CKEDITOR.dialogCommand("about"));
                g.modes = { wysiwyg: 1, source: 1 }; g.canUndo = !1; g.readOnly = 1; a.ui.addButton && a.ui.addButton("About", { label: a.lang.about.dlgTitle, command: "about", toolbar: "about" }); CKEDITOR.dialog.add("about", this.path + "dialogs/about.js")
            }
        }); CKEDITOR.plugins.add("basicstyles", {
            init: function (a) {
                var g = 0, e = function (d, e, c, k) {
                    if (k) {
                        k = new CKEDITOR.style(k); var f = b[c]; f.unshift(k); a.attachStyleStateChange(k, function (b) { !a.readOnly && a.getCommand(c).setState(b) }); a.addCommand(c, new CKEDITOR.styleCommand(k, { contentForms: f })); a.ui.addButton &&
                            a.ui.addButton(d, { label: e, command: c, toolbar: "basicstyles," + (g += 10) })
                    }
                }, b = { bold: ["strong", "b", ["span", function (a) { a = a.styles["font-weight"]; return "bold" == a || 700 <= +a }]], italic: ["em", "i", ["span", function (a) { return "italic" == a.styles["font-style"] }]], underline: ["u", ["span", function (a) { return "underline" == a.styles["text-decoration"] }]], strike: ["s", "strike", ["span", function (a) { return "line-through" == a.styles["text-decoration"] }]], subscript: ["sub"], superscript: ["sup"] }, d = a.config, m = a.lang.basicstyles; e("Bold",
                    m.bold, "bold", d.coreStyles_bold); e("Italic", m.italic, "italic", d.coreStyles_italic); e("Underline", m.underline, "underline", d.coreStyles_underline); e("Strike", m.strike, "strike", d.coreStyles_strike); e("Subscript", m.subscript, "subscript", d.coreStyles_subscript); e("Superscript", m.superscript, "superscript", d.coreStyles_superscript); a.setKeystroke([[CKEDITOR.CTRL + 66, "bold"], [CKEDITOR.CTRL + 73, "italic"], [CKEDITOR.CTRL + 85, "underline"]])
            }
        }); CKEDITOR.config.coreStyles_bold = { element: "strong", overrides: "b" }; CKEDITOR.config.coreStyles_italic =
            { element: "em", overrides: "i" }; CKEDITOR.config.coreStyles_underline = { element: "u" }; CKEDITOR.config.coreStyles_strike = { element: "s", overrides: "strike" }; CKEDITOR.config.coreStyles_subscript = { element: "sub" }; CKEDITOR.config.coreStyles_superscript = { element: "sup" }; (function () {
                function a(a, b, c, d) {
                    if (!a.isReadOnly() && !a.equals(c.editable())) {
                        CKEDITOR.dom.element.setMarker(d, a, "bidi_processed", 1); d = a; for (var e = c.editable(); (d = d.getParent()) && !d.equals(e);)if (d.getCustomData("bidi_processed")) {
                            a.removeStyle("direction");
                            a.removeAttribute("dir"); return
                        } d = "useComputedState" in c.config ? c.config.useComputedState : 1; (d ? a.getComputedStyle("direction") : a.getStyle("direction") || a.hasAttribute("dir")) != b && (a.removeStyle("direction"), d ? (a.removeAttribute("dir"), b != a.getComputedStyle("direction") && a.setAttribute("dir", b)) : a.setAttribute("dir", b), c.forceNextSelectionCheck())
                    }
                } function g(a, b, c) {
                    var d = a.getCommonAncestor(!1, !0); a = a.clone(); a.enlarge(c == CKEDITOR.ENTER_BR ? CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS : CKEDITOR.ENLARGE_BLOCK_CONTENTS);
                    if (a.checkBoundaryOfElement(d, CKEDITOR.START) && a.checkBoundaryOfElement(d, CKEDITOR.END)) { for (var e; d && d.type == CKEDITOR.NODE_ELEMENT && (e = d.getParent()) && 1 == e.getChildCount() && !(d.getName() in b);)d = e; return d.type == CKEDITOR.NODE_ELEMENT && d.getName() in b && d }
                } function e(b) {
                    return {
                        context: "p", allowedContent: { "h1 h2 h3 h4 h5 h6 table ul ol blockquote div tr p div li td": { propertiesOnly: !0, attributes: "dir" } }, requiredContent: "p[dir]", refresh: function (a, b) {
                            var c = a.config.useComputedState, d, c = void 0 === c || c;
                            if (!c) { d = b.lastElement; for (var f = a.editable(); d && !(d.getName() in h || d.equals(f));) { var e = d.getParent(); if (!e) break; d = e } } d = d || b.block || b.blockLimit; d.equals(a.editable()) && (f = a.getSelection().getRanges()[0].getEnclosedNode()) && f.type == CKEDITOR.NODE_ELEMENT && (d = f); d && (c = c ? d.getComputedStyle("direction") : d.getStyle("direction") || d.getAttribute("dir"), a.getCommand("bidirtl").setState("rtl" == c ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF), a.getCommand("bidiltr").setState("ltr" == c ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF));
                            c = (b.block || b.blockLimit || a.editable()).getDirection(1); c != (a._.selDir || a.lang.dir) && (a._.selDir = c, a.fire("contentDirChanged", c))
                        }, exec: function (c) {
                            var e = c.getSelection(), h = c.config.enterMode, k = e.getRanges(); if (k && k.length) {
                                for (var l = {}, w = e.createBookmarks(), k = k.createIterator(), x, u = 0; x = k.getNextRange(1);) {
                                    var A = x.getEnclosedNode(); A && (!A || A.type == CKEDITOR.NODE_ELEMENT && A.getName() in m) || (A = g(x, d, h)); A && a(A, b, c, l); var v = new CKEDITOR.dom.walker(x), z = w[u].startNode, y = w[u++].endNode; v.evaluator = function (a) {
                                        var b =
                                            h == CKEDITOR.ENTER_P ? "p" : "div", c; if (c = (a ? a.type == CKEDITOR.NODE_ELEMENT : !1) && a.getName() in d) { if (b = a.is(b)) b = (b = a.getParent()) ? b.type == CKEDITOR.NODE_ELEMENT : !1; c = !(b && a.getParent().is("blockquote")) } return !!(c && a.getPosition(z) & CKEDITOR.POSITION_FOLLOWING && (a.getPosition(y) & CKEDITOR.POSITION_PRECEDING + CKEDITOR.POSITION_CONTAINS) == CKEDITOR.POSITION_PRECEDING)
                                    }; for (; A = v.next();)a(A, b, c, l); x = x.createIterator(); for (x.enlargeBr = h != CKEDITOR.ENTER_BR; A = x.getNextParagraph(h == CKEDITOR.ENTER_P ? "p" : "div");)a(A,
                                        b, c, l)
                                } CKEDITOR.dom.element.clearAllMarkers(l); c.forceNextSelectionCheck(); e.selectBookmarks(w); c.focus()
                            }
                        }
                    }
                } function b(a) {
                    var b = a == l.setAttribute, c = a == l.removeAttribute, d = /\bdirection\s*:\s*(.*?)\s*(:?$|;)/; return function (e, h) {
                        if (!this.isReadOnly()) {
                            var g; if (g = e == (b || c ? "dir" : "direction") || "style" == e && (c || d.test(h))) { a: { g = this; for (var k = g.getDocument().getBody().getParent(); g;) { if (g.equals(k)) { g = !1; break a } g = g.getParent() } g = !0 } g = !g } if (g && (g = this.getDirection(1), k = a.apply(this, arguments), g != this.getDirection(1))) return this.getDocument().fire("dirChanged",
                                this), k
                        } return a.apply(this, arguments)
                    }
                } var d = { table: 1, ul: 1, ol: 1, blockquote: 1, div: 1 }, m = {}, h = {}; CKEDITOR.tools.extend(m, d, { tr: 1, p: 1, div: 1, li: 1 }); CKEDITOR.tools.extend(h, m, { td: 1 }); CKEDITOR.plugins.add("bidi", {
                    init: function (a) {
                        function b(c, d, e, h, g) { a.addCommand(e, new CKEDITOR.command(a, h)); a.ui.addButton && a.ui.addButton(c, { label: d, command: e, toolbar: "bidi," + g }) } if (!a.blockless) {
                            var c = a.lang.bidi; b("BidiLtr", c.ltr, "bidiltr", e("ltr"), 10); b("BidiRtl", c.rtl, "bidirtl", e("rtl"), 20); a.on("contentDom", function () {
                                a.document.on("dirChanged",
                                    function (b) { a.fire("dirChanged", { node: b.data, dir: b.data.getDirection(1) }) })
                            }); a.on("contentDirChanged", function (b) { b = (a.lang.dir != b.data ? "add" : "remove") + "Class"; var c = a.ui.space(a.config.toolbarLocation); if (c) c[b]("cke_mixed_dir_content") })
                        }
                    }
                }); for (var l = CKEDITOR.dom.element.prototype, c = ["setStyle", "removeStyle", "setAttribute", "removeAttribute"], k = 0; k < c.length; k++)l[c[k]] = CKEDITOR.tools.override(l[c[k]], b)
            })(); (function () {
                var a = {
                    exec: function (a) {
                        var e = a.getCommand("blockquote").state, b = a.getSelection(),
                        d = b && b.getRanges()[0]; if (d) {
                            var m = b.createBookmarks(); if (CKEDITOR.env.ie) { var h = m[0].startNode, l = m[0].endNode, c; if (h && "blockquote" == h.getParent().getName()) for (c = h; c = c.getNext();)if (c.type == CKEDITOR.NODE_ELEMENT && c.isBlockBoundary()) { h.move(c, !0); break } if (l && "blockquote" == l.getParent().getName()) for (c = l; c = c.getPrevious();)if (c.type == CKEDITOR.NODE_ELEMENT && c.isBlockBoundary()) { l.move(c); break } } var k = d.createIterator(); k.enlargeBr = a.config.enterMode != CKEDITOR.ENTER_BR; if (e == CKEDITOR.TRISTATE_OFF) {
                                for (h =
                                    []; e = k.getNextParagraph();)h.push(e); 1 > h.length && (e = a.document.createElement(a.config.enterMode == CKEDITOR.ENTER_P ? "p" : "div"), l = m.shift(), d.insertNode(e), e.append(new CKEDITOR.dom.text("﻿", a.document)), d.moveToBookmark(l), d.selectNodeContents(e), d.collapse(!0), l = d.createBookmark(), h.push(e), m.unshift(l)); c = h[0].getParent(); d = []; for (l = 0; l < h.length; l++)e = h[l], c = c.getCommonAncestor(e.getParent()); for (e = { table: 1, tbody: 1, tr: 1, ol: 1, ul: 1 }; e[c.getName()];)c = c.getParent(); for (l = null; 0 < h.length;) {
                                        for (e = h.shift(); !e.getParent().equals(c);)e =
                                            e.getParent(); e.equals(l) || d.push(e); l = e
                                    } for (; 0 < d.length;)if (e = d.shift(), "blockquote" == e.getName()) { for (l = new CKEDITOR.dom.documentFragment(a.document); e.getFirst();)l.append(e.getFirst().remove()), h.push(l.getLast()); l.replace(e) } else h.push(e); d = a.document.createElement("blockquote"); for (d.insertBefore(h[0]); 0 < h.length;)e = h.shift(), d.append(e)
                            } else if (e == CKEDITOR.TRISTATE_ON) {
                                l = []; for (c = {}; e = k.getNextParagraph();) {
                                    for (h = d = null; e.getParent();) {
                                        if ("blockquote" == e.getParent().getName()) {
                                            d = e.getParent();
                                            h = e; break
                                        } e = e.getParent()
                                    } d && h && !h.getCustomData("blockquote_moveout") && (l.push(h), CKEDITOR.dom.element.setMarker(c, h, "blockquote_moveout", !0))
                                } CKEDITOR.dom.element.clearAllMarkers(c); e = []; h = []; for (c = {}; 0 < l.length;)k = l.shift(), d = k.getParent(), k.getPrevious() ? k.getNext() ? (k.breakParent(k.getParent()), h.push(k.getNext())) : k.remove().insertAfter(d) : k.remove().insertBefore(d), d.getCustomData("blockquote_processed") || (h.push(d), CKEDITOR.dom.element.setMarker(c, d, "blockquote_processed", !0)), e.push(k); CKEDITOR.dom.element.clearAllMarkers(c);
                                for (l = h.length - 1; 0 <= l; l--) { d = h[l]; a: { c = d; for (var k = 0, f = c.getChildCount(), n = void 0; k < f && (n = c.getChild(k)); k++)if (n.type == CKEDITOR.NODE_ELEMENT && n.isBlockBoundary()) { c = !1; break a } c = !0 } c && d.remove() } if (a.config.enterMode == CKEDITOR.ENTER_BR) for (d = !0; e.length;)if (k = e.shift(), "div" == k.getName()) {
                                    l = new CKEDITOR.dom.documentFragment(a.document); !d || !k.getPrevious() || k.getPrevious().type == CKEDITOR.NODE_ELEMENT && k.getPrevious().isBlockBoundary() || l.append(a.document.createElement("br")); for (d = k.getNext() &&
                                        !(k.getNext().type == CKEDITOR.NODE_ELEMENT && k.getNext().isBlockBoundary()); k.getFirst();)k.getFirst().remove().appendTo(l); d && l.append(a.document.createElement("br")); l.replace(k); d = !1
                                }
                            } b.selectBookmarks(m); a.focus()
                        }
                    }, refresh: function (a, e) { this.setState(a.elementPath(e.block || e.blockLimit).contains("blockquote", 1) ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF) }, context: "blockquote", allowedContent: "blockquote", requiredContent: "blockquote"
                }; CKEDITOR.plugins.add("blockquote", {
                    init: function (g) {
                        g.blockless ||
                        (g.addCommand("blockquote", a), g.ui.addButton && g.ui.addButton("Blockquote", { label: g.lang.blockquote.toolbar, command: "blockquote", toolbar: "blocks,10" }))
                    }
                })
            })(); "use strict"; (function () {
                function a(a, b) { CKEDITOR.tools.extend(this, b, { editor: a, id: "cke-" + CKEDITOR.tools.getUniqueId(), area: a._.notificationArea }); b.type || (this.type = "info"); this.element = this._createElement(); a.plugins.clipboard && CKEDITOR.plugins.clipboard.preventDefaultDropOnElement(this.element) } function g(a) {
                    var b = this; this.editor = a; this.notifications =
                        []; this.element = this._createElement(); this._uiBuffer = CKEDITOR.tools.eventsBuffer(10, this._layout, this); this._changeBuffer = CKEDITOR.tools.eventsBuffer(500, this._layout, this); a.on("destroy", function () { b._removeListeners(); b.element.remove() })
                } CKEDITOR.plugins.add("notification", {
                    init: function (a) {
                        function b(a) {
                            var b = new CKEDITOR.dom.element("div"); b.setStyles({ position: "fixed", "margin-left": "-9999px" }); b.setAttributes({ "aria-live": "assertive", "aria-atomic": "true" }); b.setText(a); CKEDITOR.document.getBody().append(b);
                            setTimeout(function () { b.remove() }, 100)
                        } a._.notificationArea = new g(a); a.showNotification = function (b, g, h) { var l, c; "progress" == g ? l = h : c = h; b = new CKEDITOR.plugins.notification(a, { message: b, type: g, progress: l, duration: c }); b.show(); return b }; a.on("key", function (d) { if (27 == d.data.keyCode) { var g = a._.notificationArea.notifications; g.length && (b(a.lang.notification.closed), g[g.length - 1].hide(), d.cancel()) } })
                    }
                }); a.prototype = {
                    show: function () {
                        !1 !== this.editor.fire("notificationShow", { notification: this }) && (this.area.add(this),
                            this._hideAfterTimeout())
                    }, update: function (a) {
                        var b = !0; !1 === this.editor.fire("notificationUpdate", { notification: this, options: a }) && (b = !1); var d = this.element, g = d.findOne(".cke_notification_message"), h = d.findOne(".cke_notification_progress"), l = a.type; d.removeAttribute("role"); a.progress && "progress" != this.type && (l = "progress"); l && (d.removeClass(this._getClass()), d.removeAttribute("aria-label"), this.type = l, d.addClass(this._getClass()), d.setAttribute("aria-label", this.type), "progress" != this.type || h ? "progress" !=
                            this.type && h && h.remove() : (h = this._createProgressElement(), h.insertBefore(g))); void 0 !== a.message && (this.message = a.message, g.setHtml(this.message)); void 0 !== a.progress && (this.progress = a.progress, h && h.setStyle("width", this._getPercentageProgress())); b && a.important && (d.setAttribute("role", "alert"), this.isVisible() || this.area.add(this)); this.duration = a.duration; this._hideAfterTimeout()
                    }, hide: function () { !1 !== this.editor.fire("notificationHide", { notification: this }) && this.area.remove(this) }, isVisible: function () {
                        return 0 <=
                            CKEDITOR.tools.indexOf(this.area.notifications, this)
                    }, _createElement: function () {
                        var a = this, b, d, g = this.editor.lang.common.close; b = new CKEDITOR.dom.element("div"); b.addClass("cke_notification"); b.addClass(this._getClass()); b.setAttributes({ id: this.id, role: "alert", "aria-label": this.type }); "progress" == this.type && b.append(this._createProgressElement()); d = new CKEDITOR.dom.element("p"); d.addClass("cke_notification_message"); d.setHtml(this.message); b.append(d); d = CKEDITOR.dom.element.createFromHtml('\x3ca class\x3d"cke_notification_close" href\x3d"javascript:void(0)" title\x3d"' +
                            g + '" role\x3d"button" tabindex\x3d"-1"\x3e\x3cspan class\x3d"cke_label"\x3eX\x3c/span\x3e\x3c/a\x3e'); b.append(d); d.on("click", function () { a.editor.focus(); a.hide() }); return b
                    }, _getClass: function () { return "progress" == this.type ? "cke_notification_info" : "cke_notification_" + this.type }, _createProgressElement: function () { var a = new CKEDITOR.dom.element("span"); a.addClass("cke_notification_progress"); a.setStyle("width", this._getPercentageProgress()); return a }, _getPercentageProgress: function () {
                        return Math.round(100 *
                            (this.progress || 0)) + "%"
                    }, _hideAfterTimeout: function () { var a = this, b; this._hideTimeoutId && clearTimeout(this._hideTimeoutId); if ("number" == typeof this.duration) b = this.duration; else if ("info" == this.type || "success" == this.type) b = "number" == typeof this.editor.config.notification_duration ? this.editor.config.notification_duration : 5E3; b && (a._hideTimeoutId = setTimeout(function () { a.hide() }, b)) }
                }; g.prototype = {
                    add: function (a) {
                        this.notifications.push(a); this.element.append(a.element); 1 == this.element.getChildCount() &&
                            (CKEDITOR.document.getBody().append(this.element), this._attachListeners()); this._layout()
                    }, remove: function (a) { var b = CKEDITOR.tools.indexOf(this.notifications, a); 0 > b || (this.notifications.splice(b, 1), a.element.remove(), this.element.getChildCount() || (this._removeListeners(), this.element.remove())) }, _createElement: function () {
                        var a = this.editor, b = a.config, d = new CKEDITOR.dom.element("div"); d.addClass("cke_notifications_area"); d.setAttribute("id", "cke_notifications_area_" + a.name); d.setStyle("z-index", b.baseFloatZIndex -
                            2); return d
                    }, _attachListeners: function () { var a = CKEDITOR.document.getWindow(), b = this.editor; a.on("scroll", this._uiBuffer.input); a.on("resize", this._uiBuffer.input); b.on("change", this._changeBuffer.input); b.on("floatingSpaceLayout", this._layout, this, null, 20); b.on("blur", this._layout, this, null, 20) }, _removeListeners: function () {
                        var a = CKEDITOR.document.getWindow(), b = this.editor; a.removeListener("scroll", this._uiBuffer.input); a.removeListener("resize", this._uiBuffer.input); b.removeListener("change", this._changeBuffer.input);
                        b.removeListener("floatingSpaceLayout", this._layout); b.removeListener("blur", this._layout)
                    }, _layout: function () {
                        function a() { b.setStyle("left", x(u + g.width - n - p)) } var b = this.element, d = this.editor, g = d.ui.contentsElement.getClientRect(), h = d.ui.contentsElement.getDocumentPosition(), l, c, k = b.getClientRect(), f, n = this._notificationWidth, p = this._notificationMargin; f = CKEDITOR.document.getWindow(); var t = f.getScrollPosition(), q = f.getViewPaneSize(), r = CKEDITOR.document.getBody(), w = r.getDocumentPosition(), x = CKEDITOR.tools.cssLength;
                        n && p || (f = this.element.getChild(0), n = this._notificationWidth = f.getClientRect().width, p = this._notificationMargin = parseInt(f.getComputedStyle("margin-left"), 10) + parseInt(f.getComputedStyle("margin-right"), 10)); d.toolbar && (l = d.ui.space("top"), c = l.getClientRect()); l && l.isVisible() && c.bottom > g.top && c.bottom < g.bottom - k.height ? b.setStyles({ position: "fixed", top: x(c.bottom) }) : 0 < g.top ? b.setStyles({ position: "absolute", top: x(h.y) }) : h.y + g.height - k.height > t.y ? b.setStyles({ position: "fixed", top: 0 }) : b.setStyles({
                            position: "absolute",
                            top: x(h.y + g.height - k.height)
                        }); var u = "fixed" == b.getStyle("position") ? g.left : "static" != r.getComputedStyle("position") ? h.x - w.x : h.x; g.width < n + p ? h.x + n + p > t.x + q.width ? a() : b.setStyle("left", x(u)) : h.x + n + p > t.x + q.width ? b.setStyle("left", x(u)) : h.x + g.width / 2 + n / 2 + p > t.x + q.width ? b.setStyle("left", x(u - h.x + t.x + q.width - n - p)) : 0 > g.left + g.width - n - p ? a() : 0 > g.left + g.width / 2 - n / 2 ? b.setStyle("left", x(u - h.x + t.x)) : b.setStyle("left", x(u + g.width / 2 - n / 2 - p / 2))
                    }
                }; CKEDITOR.plugins.notification = a
            })(); (function () {
                var a = '\x3ca id\x3d"{id}" class\x3d"cke_button cke_button__{name} cke_button_{state} {cls}"' +
                    (CKEDITOR.env.gecko && !CKEDITOR.env.hc ? "" : " href\x3d\"javascript:void('{titleJs}')\"") + ' title\x3d"{title}" tabindex\x3d"-1" hidefocus\x3d"true" role\x3d"button" aria-labelledby\x3d"{id}_label" aria-describedby\x3d"{id}_description" aria-haspopup\x3d"{hasArrow}" aria-disabled\x3d"{ariaDisabled}"'; CKEDITOR.env.gecko && CKEDITOR.env.mac && (a += ' onkeypress\x3d"return false;"'); CKEDITOR.env.gecko && (a += ' onblur\x3d"this.style.cssText \x3d this.style.cssText;"'); var g = ""; CKEDITOR.env.ie && (g = 'return false;" onmouseup\x3d"CKEDITOR.tools.getMouseButton(event)\x3d\x3dCKEDITOR.MOUSE_BUTTON_LEFT\x26\x26');
                var a = a + (' onkeydown\x3d"return CKEDITOR.tools.callFunction({keydownFn},event);" onfocus\x3d"return CKEDITOR.tools.callFunction({focusFn},event);" onclick\x3d"' + g + 'CKEDITOR.tools.callFunction({clickFn},this);return false;"\x3e\x3cspan class\x3d"cke_button_icon cke_button__{iconName}_icon" style\x3d"{style}"') + '\x3e\x26nbsp;\x3c/span\x3e\x3cspan id\x3d"{id}_label" class\x3d"cke_button_label cke_button__{name}_label" aria-hidden\x3d"false"\x3e{label}\x3c/span\x3e\x3cspan id\x3d"{id}_description" class\x3d"cke_button_label" aria-hidden\x3d"false"\x3e{ariaShortcut}\x3c/span\x3e{arrowHtml}\x3c/a\x3e',
                    e = CKEDITOR.addTemplate("buttonArrow", '\x3cspan class\x3d"cke_button_arrow"\x3e' + (CKEDITOR.env.hc ? "\x26#9660;" : "") + "\x3c/span\x3e"), b = CKEDITOR.addTemplate("button", a); CKEDITOR.plugins.add("button", { beforeInit: function (a) { a.ui.addHandler(CKEDITOR.UI_BUTTON, CKEDITOR.ui.button.handler) } }); CKEDITOR.UI_BUTTON = "button"; CKEDITOR.ui.button = function (a) { CKEDITOR.tools.extend(this, a, { title: a.label, click: a.click || function (b) { b.execCommand(a.command) } }); this._ = {} }; CKEDITOR.ui.button.handler = { create: function (a) { return new CKEDITOR.ui.button(a) } };
                CKEDITOR.ui.button.prototype = {
                    render: function (a, g) {
                        function h() { var b = a.mode; b && (b = this.modes[b] ? void 0 !== l[b] ? l[b] : CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED, b = a.readOnly && !this.readOnly ? CKEDITOR.TRISTATE_DISABLED : b, this.setState(b), this.refresh && this.refresh()) } var l = null, c = CKEDITOR.env, k = this._.id = CKEDITOR.tools.getNextId(), f = "", n = this.command, p, t, q; this._.editor = a; var r = {
                            id: k, button: this, editor: a, focus: function () { CKEDITOR.document.getById(k).focus() }, execute: function () { this.button.click(a) },
                            attach: function (a) { this.button.attach(a) }
                        }, w = CKEDITOR.tools.addFunction(function (a) { if (r.onkey) return a = new CKEDITOR.dom.event(a), !1 !== r.onkey(r, a.getKeystroke()) }), x = CKEDITOR.tools.addFunction(function (a) { var b; r.onfocus && (b = !1 !== r.onfocus(r, new CKEDITOR.dom.event(a))); return b }), u = 0; r.clickFn = p = CKEDITOR.tools.addFunction(function () { u && (a.unlockSelection(1), u = 0); r.execute(); c.iOS && a.focus() }); this.modes ? (l = {}, a.on("beforeModeUnload", function () {
                            a.mode && this._.state != CKEDITOR.TRISTATE_DISABLED && (l[a.mode] =
                                this._.state)
                        }, this), a.on("activeFilterChange", h, this), a.on("mode", h, this), !this.readOnly && a.on("readOnly", h, this)) : n && (n = a.getCommand(n)) && (n.on("state", function () { this.setState(n.state) }, this), f += n.state == CKEDITOR.TRISTATE_ON ? "on" : n.state == CKEDITOR.TRISTATE_DISABLED ? "disabled" : "off"); var A; if (this.directional) a.on("contentDirChanged", function (b) {
                            var c = CKEDITOR.document.getById(this._.id), f = c.getFirst(); b = b.data; b != a.lang.dir ? c.addClass("cke_" + b) : c.removeClass("cke_ltr").removeClass("cke_rtl"); f.setAttribute("style",
                                CKEDITOR.skin.getIconStyle(A, "rtl" == b, this.icon, this.iconOffset))
                        }, this); n ? (t = a.getCommandKeystroke(n)) && (q = CKEDITOR.tools.keystrokeToString(a.lang.common.keyboard, t)) : f += "off"; t = this.name || this.command; var v = null, z = this.icon; A = t; this.icon && !/\./.test(this.icon) ? (A = this.icon, z = null) : (this.icon && (v = this.icon), CKEDITOR.env.hidpi && this.iconHiDpi && (v = this.iconHiDpi)); v ? (CKEDITOR.skin.addIcon(v, v), z = null) : v = A; f = {
                            id: k, name: t, iconName: A, label: this.label, cls: (this.hasArrow ? "cke_button_expandable " : "") + (this.className ||
                                ""), state: f, ariaDisabled: "disabled" == f ? "true" : "false", title: this.title + (q ? " (" + q.display + ")" : ""), ariaShortcut: q ? a.lang.common.keyboardShortcut + " " + q.aria : "", titleJs: c.gecko && !c.hc ? "" : (this.title || "").replace("'", ""), hasArrow: "string" === typeof this.hasArrow && this.hasArrow || (this.hasArrow ? "true" : "false"), keydownFn: w, focusFn: x, clickFn: p, style: CKEDITOR.skin.getIconStyle(v, "rtl" == a.lang.dir, z, this.iconOffset), arrowHtml: this.hasArrow ? e.output() : ""
                        }; b.output(f, g); if (this.onRender) this.onRender(); return r
                    },
                    setState: function (a) { if (this._.state == a) return !1; this._.state = a; var b = CKEDITOR.document.getById(this._.id); return b ? (b.setState(a, "cke_button"), b.setAttribute("aria-disabled", a == CKEDITOR.TRISTATE_DISABLED), this.hasArrow ? b.setAttribute("aria-expanded", a == CKEDITOR.TRISTATE_ON) : a === CKEDITOR.TRISTATE_ON ? b.setAttribute("aria-pressed", !0) : b.removeAttribute("aria-pressed"), !0) : !1 }, getState: function () { return this._.state }, toFeature: function (a) {
                        if (this._.feature) return this._.feature; var b = this; this.allowedContent ||
                            this.requiredContent || !this.command || (b = a.getCommand(this.command) || b); return this._.feature = b
                    }
                }; CKEDITOR.ui.prototype.addButton = function (a, b) { this.add(a, CKEDITOR.UI_BUTTON, b) }
            })(); (function () {
                function a(a) {
                    function b() { for (var c = e(), f = CKEDITOR.tools.clone(a.config.toolbarGroups) || g(a), k = 0; k < f.length; k++) { var m = f[k]; if ("/" != m) { "string" == typeof m && (m = f[k] = { name: m }); var r, w = m.groups; if (w) for (var x = 0; x < w.length; x++)r = w[x], (r = c[r]) && l(m, r); (r = c[m.name]) && l(m, r) } } return f } function e() {
                        var b = {}, c, f, h; for (c in a.ui.items) f =
                            a.ui.items[c], h = f.toolbar || "others", h = h.split(","), f = h[0], h = parseInt(h[1] || -1, 10), b[f] || (b[f] = []), b[f].push({ name: c, order: h }); for (f in b) b[f] = b[f].sort(function (a, b) { return a.order == b.order ? 0 : 0 > b.order ? -1 : 0 > a.order ? 1 : a.order < b.order ? -1 : 1 }); return b
                    } function l(b, c) { if (c.length) { b.items ? b.items.push(a.ui.create("-")) : b.items = []; for (var f; f = c.shift();)f = "string" == typeof f ? f : f.name, k && -1 != CKEDITOR.tools.indexOf(k, f) || (f = a.ui.create(f)) && a.addFeature(f) && b.items.push(f) } } function c(a) {
                        var b = [], c, f, d; for (c =
                            0; c < a.length; ++c)f = a[c], d = {}, "/" == f ? b.push(f) : CKEDITOR.tools.isArray(f) ? (l(d, CKEDITOR.tools.clone(f)), b.push(d)) : f.items && (l(d, CKEDITOR.tools.clone(f.items)), d.name = f.name, b.push(d)); return b
                    } var k = a.config.removeButtons, k = k && k.split(","), f = a.config.toolbar; "string" == typeof f && (f = a.config["toolbar_" + f]); return a.toolbar = f ? c(f) : b()
                } function g(a) {
                    return a._.toolbarGroups || (a._.toolbarGroups = [{ name: "document", groups: ["mode", "document", "doctools"] }, { name: "clipboard", groups: ["clipboard", "undo"] }, {
                        name: "editing",
                        groups: ["find", "selection", "spellchecker"]
                    }, { name: "forms" }, "/", { name: "basicstyles", groups: ["basicstyles", "cleanup"] }, { name: "paragraph", groups: ["list", "indent", "blocks", "align", "bidi"] }, { name: "links" }, { name: "insert" }, "/", { name: "styles" }, { name: "colors" }, { name: "tools" }, { name: "others" }, { name: "about" }])
                } var e = function () { this.toolbars = []; this.focusCommandExecuted = !1 }; e.prototype.focus = function () { for (var a = 0, b; b = this.toolbars[a++];)for (var e = 0, g; g = b.items[e++];)if (g.focus) { g.focus(); return } }; var b = {
                    modes: {
                        wysiwyg: 1,
                        source: 1
                    }, readOnly: 1, exec: function (a) { a.toolbox && (a.toolbox.focusCommandExecuted = !0, CKEDITOR.env.ie || CKEDITOR.env.air ? setTimeout(function () { a.toolbox.focus() }, 100) : a.toolbox.focus()) }
                }; CKEDITOR.plugins.add("toolbar", {
                    requires: "button", init: function (d) {
                        var g, h = function (a, b) {
                            var e, f = "rtl" == d.lang.dir, n = d.config.toolbarGroupCycling, p = f ? 37 : 39, f = f ? 39 : 37, n = void 0 === n || n; switch (b) {
                                case 9: case CKEDITOR.SHIFT + 9: for (; !e || !e.items.length;)if (e = 9 == b ? (e ? e.next : a.toolbar.next) || d.toolbox.toolbars[0] : (e ? e.previous :
                                    a.toolbar.previous) || d.toolbox.toolbars[d.toolbox.toolbars.length - 1], e.items.length) for (a = e.items[g ? e.items.length - 1 : 0]; a && !a.focus;)(a = g ? a.previous : a.next) || (e = 0); a && a.focus(); return !1; case p: e = a; do e = e.next, !e && n && (e = a.toolbar.items[0]); while (e && !e.focus); e ? e.focus() : h(a, 9); return !1; case 40: return a.button && a.button.hasArrow ? a.execute() : h(a, 40 == b ? p : f), !1; case f: case 38: e = a; do e = e.previous, !e && n && (e = a.toolbar.items[a.toolbar.items.length - 1]); while (e && !e.focus); e ? e.focus() : (g = 1, h(a, CKEDITOR.SHIFT +
                                        9), g = 0); return !1; case 27: return d.focus(), !1; case 13: case 32: return a.execute(), !1
                            }return !0
                        }; d.on("uiSpace", function (b) {
                            if (b.data.space == d.config.toolbarLocation) {
                                b.removeListener(); d.toolbox = new e; var c = CKEDITOR.tools.getNextId(), g = ['\x3cspan id\x3d"', c, '" class\x3d"cke_voice_label"\x3e', d.lang.toolbar.toolbars, "\x3c/span\x3e", '\x3cspan id\x3d"' + d.ui.spaceId("toolbox") + '" class\x3d"cke_toolbox" role\x3d"group" aria-labelledby\x3d"', c, '" onmousedown\x3d"return false;"\x3e'], c = !1 !== d.config.toolbarStartupExpanded,
                                    f, n; d.config.toolbarCanCollapse && d.elementMode != CKEDITOR.ELEMENT_MODE_INLINE && g.push('\x3cspan class\x3d"cke_toolbox_main"' + (c ? "\x3e" : ' style\x3d"display:none"\x3e')); for (var m = d.toolbox.toolbars, t = a(d), q = t.length, r = 0; r < q; r++) {
                                        var w, x = 0, u, A = t[r], v = "/" !== A && ("/" === t[r + 1] || r == q - 1), z; if (A) if (f && (g.push("\x3c/span\x3e"), n = f = 0), "/" === A) g.push('\x3cspan class\x3d"cke_toolbar_break"\x3e\x3c/span\x3e'); else {
                                            z = A.items || A; for (var y = 0; y < z.length; y++) {
                                                var B = z[y], C; if (B) {
                                                    var F = function (a) {
                                                        a = a.render(d, g); G = x.items.push(a) -
                                                            1; 0 < G && (a.previous = x.items[G - 1], a.previous.next = a); a.toolbar = x; a.onkey = h; a.onfocus = function () { d.toolbox.focusCommandExecuted || d.focus() }
                                                    }; if (B.type == CKEDITOR.UI_SEPARATOR) n = f && B; else {
                                                        C = !1 !== B.canGroup; if (!x) {
                                                            w = CKEDITOR.tools.getNextId(); x = { id: w, items: [] }; u = A.name && (d.lang.toolbar.toolbarGroups[A.name] || A.name); g.push('\x3cspan id\x3d"', w, '" class\x3d"cke_toolbar' + (v ? ' cke_toolbar_last"' : '"'), u ? ' aria-labelledby\x3d"' + w + '_label"' : "", ' role\x3d"toolbar"\x3e'); u && g.push('\x3cspan id\x3d"', w, '_label" class\x3d"cke_voice_label"\x3e',
                                                                u, "\x3c/span\x3e"); g.push('\x3cspan class\x3d"cke_toolbar_start"\x3e\x3c/span\x3e'); var G = m.push(x) - 1; 0 < G && (x.previous = m[G - 1], x.previous.next = x)
                                                        } C ? f || (g.push('\x3cspan class\x3d"cke_toolgroup" role\x3d"presentation"\x3e'), f = 1) : f && (g.push("\x3c/span\x3e"), f = 0); n && (F(n), n = 0); F(B)
                                                    }
                                                }
                                            } f && (g.push("\x3c/span\x3e"), n = f = 0); x && g.push('\x3cspan class\x3d"cke_toolbar_end"\x3e\x3c/span\x3e\x3c/span\x3e')
                                        }
                                    } d.config.toolbarCanCollapse && g.push("\x3c/span\x3e"); if (d.config.toolbarCanCollapse && d.elementMode != CKEDITOR.ELEMENT_MODE_INLINE) {
                                        var I =
                                            CKEDITOR.tools.addFunction(function () { d.execCommand("toolbarCollapse") }); d.on("destroy", function () { CKEDITOR.tools.removeFunction(I) }); d.addCommand("toolbarCollapse", {
                                                readOnly: 1, exec: function (a) {
                                                    var b = a.ui.space("toolbar_collapser"), c = b.getPrevious(), f = a.ui.space("contents"), d = c.getParent(), e = parseInt(f.$.style.height, 10), h = d.$.offsetHeight, g = b.hasClass("cke_toolbox_collapser_min"); g ? (c.show(), b.removeClass("cke_toolbox_collapser_min"), b.setAttribute("title", a.lang.toolbar.toolbarCollapse)) : (c.hide(),
                                                        b.addClass("cke_toolbox_collapser_min"), b.setAttribute("title", a.lang.toolbar.toolbarExpand)); b.getFirst().setText(g ? "▲" : "◀"); f.setStyle("height", e - (d.$.offsetHeight - h) + "px"); a.fire("resize", { outerHeight: a.container.$.offsetHeight, contentsHeight: f.$.offsetHeight, outerWidth: a.container.$.offsetWidth })
                                                }, modes: { wysiwyg: 1, source: 1 }
                                            }); d.setKeystroke(CKEDITOR.ALT + (CKEDITOR.env.ie || CKEDITOR.env.webkit ? 189 : 109), "toolbarCollapse"); g.push('\x3ca title\x3d"' + (c ? d.lang.toolbar.toolbarCollapse : d.lang.toolbar.toolbarExpand) +
                                                '" id\x3d"' + d.ui.spaceId("toolbar_collapser") + '" tabIndex\x3d"-1" class\x3d"cke_toolbox_collapser'); c || g.push(" cke_toolbox_collapser_min"); g.push('" onclick\x3d"CKEDITOR.tools.callFunction(' + I + ')"\x3e', '\x3cspan class\x3d"cke_arrow"\x3e\x26#9650;\x3c/span\x3e', "\x3c/a\x3e")
                                    } g.push("\x3c/span\x3e"); b.data.html += g.join("")
                            }
                        }); d.on("destroy", function () {
                            if (this.toolbox) {
                                var a, b = 0, d, f, e; for (a = this.toolbox.toolbars; b < a.length; b++)for (f = a[b].items, d = 0; d < f.length; d++)e = f[d], e.clickFn && CKEDITOR.tools.removeFunction(e.clickFn),
                                    e.keyDownFn && CKEDITOR.tools.removeFunction(e.keyDownFn)
                            }
                        }); d.on("uiReady", function () { var a = d.ui.space("toolbox"); a && d.focusManager.add(a, 1) }); d.addCommand("toolbarFocus", b); d.setKeystroke(CKEDITOR.ALT + 121, "toolbarFocus"); d.ui.add("-", CKEDITOR.UI_SEPARATOR, {}); d.ui.addHandler(CKEDITOR.UI_SEPARATOR, { create: function () { return { render: function (a, b) { b.push('\x3cspan class\x3d"cke_toolbar_separator" role\x3d"separator"\x3e\x3c/span\x3e'); return {} } } } })
                    }
                }); CKEDITOR.ui.prototype.addToolbarGroup = function (a, b,
                    e) { var l = g(this.editor), c = 0 === b, k = { name: a }; if (e) { if (e = CKEDITOR.tools.search(l, function (a) { return a.name == e })) { !e.groups && (e.groups = []); if (b && (b = CKEDITOR.tools.indexOf(e.groups, b), 0 <= b)) { e.groups.splice(b + 1, 0, a); return } c ? e.groups.splice(0, 0, a) : e.groups.push(a); return } b = null } b && (b = CKEDITOR.tools.indexOf(l, function (a) { return a.name == b })); c ? l.splice(0, 0, a) : "number" == typeof b ? l.splice(b + 1, 0, k) : l.push(a) }
            })(); CKEDITOR.UI_SEPARATOR = "separator"; CKEDITOR.config.toolbarLocation = "top"; "use strict"; (function () {
                function a(a,
                    b, c) { b.type || (b.type = "auto"); if (c && !1 === a.fire("beforePaste", b) || !b.dataValue && b.dataTransfer.isEmpty()) return !1; b.dataValue || (b.dataValue = ""); if (CKEDITOR.env.gecko && "drop" == b.method && a.toolbox) a.once("afterPaste", function () { a.toolbox.focus() }); return a.fire("paste", b) } function g(b) {
                        function c() {
                            var a = b.editable(); if (CKEDITOR.plugins.clipboard.isCustomCopyCutSupported) {
                                var d = function (a) { b.getSelection().isCollapsed() || (b.readOnly && "cut" == a.name || C.initPasteDataTransfer(a, b), a.data.preventDefault()) };
                                a.on("copy", d); a.on("cut", d); a.on("cut", function () { b.readOnly || b.extractSelectedHtml() }, null, null, 999)
                            } a.on(C.mainPasteEvent, function (a) { "beforepaste" == C.mainPasteEvent && F || z(a) }); "beforepaste" == C.mainPasteEvent && (a.on("paste", function (a) { G || (h(), a.data.preventDefault(), z(a), k("paste")) }), a.on("contextmenu", g, null, null, 0), a.on("beforepaste", function (a) { !a.data || a.data.$.ctrlKey || a.data.$.shiftKey || g() }, null, null, 0)); a.on("beforecut", function () { !F && l(b) }); var e; a.attachListener(CKEDITOR.env.ie ? a : b.document.getDocumentElement(),
                                "mouseup", function () { e = setTimeout(y, 0) }); b.on("destroy", function () { clearTimeout(e) }); a.on("keyup", y)
                        } function d(a) { return { type: a, canUndo: "cut" == a, startDisabled: !0, fakeKeystroke: "cut" == a ? CKEDITOR.CTRL + 88 : CKEDITOR.CTRL + 67, exec: function () { "cut" == this.type && l(); var a; var c = this.type; if (CKEDITOR.env.ie) a = k(c); else try { a = b.document.$.execCommand(c, !1, null) } catch (d) { a = !1 } a || b.showNotification(b.lang.clipboard[this.type + "Error"]); return a } } } function e() {
                            return {
                                canUndo: !1, async: !0, fakeKeystroke: CKEDITOR.CTRL +
                                    86, exec: function (b, c) {
                                        function d(c, h) { h = "undefined" !== typeof h ? h : !0; c ? (c.method = "paste", c.dataTransfer || (c.dataTransfer = C.initPasteDataTransfer()), a(b, c, h)) : e && !b._.forcePasteDialog && b.showNotification(k, "info", b.config.clipboard_notificationDuration); b._.forcePasteDialog = !1; b.fire("afterCommandExec", { name: "paste", command: f, returnValue: !!c }) } c = "undefined" !== typeof c && null !== c ? c : {}; var f = this, e = "undefined" !== typeof c.notification ? c.notification : !0, h = c.type, g = CKEDITOR.tools.keystrokeToString(b.lang.common.keyboard,
                                            b.getCommandKeystroke(this)), k = "string" === typeof e ? e : b.lang.clipboard.pasteNotification.replace(/%1/, '\x3ckbd aria-label\x3d"' + g.aria + '"\x3e' + g.display + "\x3c/kbd\x3e"), g = "string" === typeof c ? c : c.dataValue; h && !0 !== b.config.forcePasteAsPlainText && "allow-word" !== b.config.forcePasteAsPlainText ? b._.nextPasteType = h : delete b._.nextPasteType; "string" === typeof g ? d({ dataValue: g }) : b.getClipboardData(d)
                                    }
                            }
                        } function h() { G = 1; setTimeout(function () { G = 0 }, 100) } function g() { F = 1; setTimeout(function () { F = 0 }, 10) } function k(a) {
                            var c =
                                b.document, d = c.getBody(), e = !1, h = function () { e = !0 }; d.on(a, h); 7 < CKEDITOR.env.version ? c.$.execCommand(a) : c.$.selection.createRange().execCommand(a); d.removeListener(a, h); return e
                        } function l() {
                            if (CKEDITOR.env.ie && !CKEDITOR.env.quirks) {
                                var a = b.getSelection(), c, d, e; a.getType() == CKEDITOR.SELECTION_ELEMENT && (c = a.getSelectedElement()) && (d = a.getRanges()[0], e = b.document.createText(""), e.insertBefore(c), d.setStartBefore(e), d.setEndAfter(c), a.selectRanges([d]), setTimeout(function () { c.getParent() && (e.remove(), a.selectElement(c)) },
                                    0))
                            }
                        } function m(a, c) {
                            var d = b.document, e = b.editable(), h = function (a) { a.cancel() }, g; if (!d.getById("cke_pastebin")) {
                                var k = b.getSelection(), l = k.createBookmarks(); CKEDITOR.env.ie && k.root.fire("selectionchange"); var n = new CKEDITOR.dom.element(!CKEDITOR.env.webkit && !e.is("body") || CKEDITOR.env.ie ? "div" : "body", d); n.setAttributes({ id: "cke_pastebin", "data-cke-temp": "1" }); var p = 0, d = d.getWindow(); CKEDITOR.env.webkit ? (e.append(n), n.addClass("cke_editable"), e.is("body") || (p = "static" != e.getComputedStyle("position") ?
                                    e : CKEDITOR.dom.element.get(e.$.offsetParent), p = p.getDocumentPosition().y)) : e.getAscendant(CKEDITOR.env.ie ? "body" : "html", 1).append(n); n.setStyles({ position: "absolute", top: d.getScrollPosition().y - p + 10 + "px", width: "1px", height: Math.max(1, d.getViewPaneSize().height - 20) + "px", overflow: "hidden", margin: 0, padding: 0 }); CKEDITOR.env.safari && n.setStyles(CKEDITOR.tools.cssVendorPrefix("user-select", "text")); (p = n.getParent().isReadOnly()) ? (n.setOpacity(0), n.setAttribute("contenteditable", !0)) : n.setStyle("ltr" == b.config.contentsLangDirection ?
                                        "left" : "right", "-10000px"); b.on("selectionChange", h, null, null, 0); if (CKEDITOR.env.webkit || CKEDITOR.env.gecko) g = e.once("blur", h, null, null, -100); p && n.focus(); p = new CKEDITOR.dom.range(n); p.selectNodeContents(n); var u = p.select(); CKEDITOR.env.ie && (g = e.once("blur", function () { b.lockSelection(u) })); var y = CKEDITOR.document.getWindow().getScrollPosition().y; setTimeout(function () {
                                            CKEDITOR.env.webkit && (CKEDITOR.document.getBody().$.scrollTop = y); g && g.removeListener(); CKEDITOR.env.ie && e.focus(); k.selectBookmarks(l);
                                            n.remove(); var a; CKEDITOR.env.webkit && (a = n.getFirst()) && a.is && a.hasClass("Apple-style-span") && (n = a); b.removeListener("selectionChange", h); c(n.getHtml())
                                        }, 0)
                            }
                        } function A() { if ("paste" == C.mainPasteEvent) return b.fire("beforePaste", { type: "auto", method: "paste" }), !1; b.focus(); h(); var a = b.focusManager; a.lock(); if (b.editable().fire(C.mainPasteEvent) && !k("paste")) return a.unlock(), !1; a.unlock(); return !0 } function v(a) {
                            if ("wysiwyg" == b.mode) switch (a.data.keyCode) {
                                case CKEDITOR.CTRL + 86: case CKEDITOR.SHIFT + 45: a =
                                    b.editable(); h(); "paste" == C.mainPasteEvent && a.fire("beforepaste"); break; case CKEDITOR.CTRL + 88: case CKEDITOR.SHIFT + 46: b.fire("saveSnapshot"), setTimeout(function () { b.fire("saveSnapshot") }, 50)
                            }
                        } function z(c) {
                            var d = { type: "auto", method: "paste", dataTransfer: C.initPasteDataTransfer(c) }; d.dataTransfer.cacheData(); var e = !1 !== b.fire("beforePaste", d); e && C.canClipboardApiBeTrusted(d.dataTransfer, b) ? (c.data.preventDefault(), setTimeout(function () { a(b, d) }, 0)) : m(c, function (c) {
                                d.dataValue = c.replace(/<span[^>]+data-cke-bookmark[^<]*?<\/span>/ig,
                                    ""); e && a(b, d)
                            })
                        } function y() { if ("wysiwyg" == b.mode) { var a = B("paste"); b.getCommand("cut").setState(B("cut")); b.getCommand("copy").setState(B("copy")); b.getCommand("paste").setState(a); b.fire("pasteState", a) } } function B(a) {
                            var c = b.getSelection(), c = c && c.getRanges()[0]; if ((b.readOnly || c && c.checkReadOnly()) && a in { paste: 1, cut: 1 }) return CKEDITOR.TRISTATE_DISABLED; if ("paste" == a) return CKEDITOR.TRISTATE_OFF; a = b.getSelection(); c = a.getRanges(); return a.getType() == CKEDITOR.SELECTION_NONE || 1 == c.length && c[0].collapsed ?
                                CKEDITOR.TRISTATE_DISABLED : CKEDITOR.TRISTATE_OFF
                        } var C = CKEDITOR.plugins.clipboard, F = 0, G = 0; (function () {
                            b.on("key", v); b.on("contentDom", c); b.on("selectionChange", y); if (b.contextMenu) { b.contextMenu.addListener(function () { return { cut: B("cut"), copy: B("copy"), paste: B("paste") } }); var a = null; b.on("menuShow", function () { a && (a.removeListener(), a = null); var c = b.contextMenu.findItemByCommandName("paste"); c && c.element && (a = c.element.on("touchend", function () { b._.forcePasteDialog = !0 })) }) } if (b.ui.addButton) b.once("instanceReady",
                                function () { b._.pasteButtons && CKEDITOR.tools.array.forEach(b._.pasteButtons, function (a) { if (a = b.ui.get(a)) if (a = CKEDITOR.document.getById(a._.id)) a.on("touchend", function () { b._.forcePasteDialog = !0 }) }) })
                        })(); (function () {
                            function a(c, d, e, h, g) { var k = b.lang.clipboard[d]; b.addCommand(d, e); b.ui.addButton && b.ui.addButton(c, { label: k, command: d, toolbar: "clipboard," + h }); b.addMenuItems && b.addMenuItem(d, { label: k, command: d, group: "clipboard", order: g }) } a("Cut", "cut", d("cut"), 10, 1); a("Copy", "copy", d("copy"), 20, 4); a("Paste",
                                "paste", e(), 30, 8); b._.pasteButtons || (b._.pasteButtons = []); b._.pasteButtons.push("Paste")
                        })(); b.getClipboardData = function (a, c) {
                            function d(a) { a.removeListener(); a.cancel(); c(a.data) } function e(a) { a.removeListener(); a.cancel(); c({ type: g, dataValue: a.data.dataValue, dataTransfer: a.data.dataTransfer, method: "paste" }) } var h = !1, g = "auto"; c || (c = a, a = null); b.on("beforePaste", function (a) { a.removeListener(); h = !0; g = a.data.type }, null, null, 1E3); b.on("paste", d, null, null, 0); !1 === A() && (b.removeListener("paste", d), b._.forcePasteDialog &&
                                h && b.fire("pasteDialog") ? (b.on("pasteDialogCommit", e), b.on("dialogHide", function (a) { a.removeListener(); a.data.removeListener("pasteDialogCommit", e); a.data._.committed || c(null) })) : c(null))
                        }
                    } function e(a) {
                        if (CKEDITOR.env.webkit) { if (!a.match(/^[^<]*$/g) && !a.match(/^(<div><br( ?\/)?><\/div>|<div>[^<]*<\/div>)*$/gi)) return "html" } else if (CKEDITOR.env.ie) { if (!a.match(/^([^<]|<br( ?\/)?>)*$/gi) && !a.match(/^(<p>([^<]|<br( ?\/)?>)*<\/p>|(\r\n))*$/gi)) return "html" } else if (CKEDITOR.env.gecko) { if (!a.match(/^([^<]|<br( ?\/)?>)*$/gi)) return "html" } else return "html";
                        return "htmlifiedtext"
                    } function b(a, b) {
                        function c(a) { return CKEDITOR.tools.repeat("\x3c/p\x3e\x3cp\x3e", ~~(a / 2)) + (1 == a % 2 ? "\x3cbr\x3e" : "") } b = b.replace(/(?!\u3000)\s+/g, " ").replace(/> +</g, "\x3e\x3c").replace(/<br ?\/>/gi, "\x3cbr\x3e"); b = b.replace(/<\/?[A-Z]+>/g, function (a) { return a.toLowerCase() }); if (b.match(/^[^<]$/)) return b; CKEDITOR.env.webkit && -1 < b.indexOf("\x3cdiv\x3e") && (b = b.replace(/^(<div>(<br>|)<\/div>)(?!$|(<div>(<br>|)<\/div>))/g, "\x3cbr\x3e").replace(/^(<div>(<br>|)<\/div>){2}(?!$)/g, "\x3cdiv\x3e\x3c/div\x3e"),
                            b.match(/<div>(<br>|)<\/div>/) && (b = "\x3cp\x3e" + b.replace(/(<div>(<br>|)<\/div>)+/g, function (a) { return c(a.split("\x3c/div\x3e\x3cdiv\x3e").length + 1) }) + "\x3c/p\x3e"), b = b.replace(/<\/div><div>/g, "\x3cbr\x3e"), b = b.replace(/<\/?div>/g, "")); CKEDITOR.env.gecko && a.enterMode != CKEDITOR.ENTER_BR && (CKEDITOR.env.gecko && (b = b.replace(/^<br><br>$/, "\x3cbr\x3e")), -1 < b.indexOf("\x3cbr\x3e\x3cbr\x3e") && (b = "\x3cp\x3e" + b.replace(/(<br>){2,}/g, function (a) { return c(a.length / 4) }) + "\x3c/p\x3e")); return h(a, b)
                    } function d(a) {
                        function b() {
                            var a =
                                {}, c; for (c in CKEDITOR.dtd) "$" != c.charAt(0) && "div" != c && "span" != c && (a[c] = 1); return a
                        } var c = {}; return { get: function (d) { return "plain-text" == d ? c.plainText || (c.plainText = new CKEDITOR.filter(a, "br")) : "semantic-content" == d ? ((d = c.semanticContent) || (d = new CKEDITOR.filter(a, {}), d.allow({ $1: { elements: b(), attributes: !0, styles: !1, classes: !1 } }), d = c.semanticContent = d), d) : d ? new CKEDITOR.filter(a, d) : null } }
                    } function m(a, b, c) {
                        b = CKEDITOR.htmlParser.fragment.fromHtml(b); var d = new CKEDITOR.htmlParser.basicWriter; c.applyTo(b,
                            !0, !1, a.activeEnterMode); b.writeHtml(d); return d.getHtml()
                    } function h(a, b) { a.enterMode == CKEDITOR.ENTER_BR ? b = b.replace(/(<\/p><p>)+/g, function (a) { return CKEDITOR.tools.repeat("\x3cbr\x3e", a.length / 7 * 2) }).replace(/<\/?p>/g, "") : a.enterMode == CKEDITOR.ENTER_DIV && (b = b.replace(/<(\/)?p>/g, "\x3c$1div\x3e")); return b } function l(a) { a.data.preventDefault(); a.data.$.dataTransfer.dropEffect = "none" } function c(b) {
                        var c = CKEDITOR.plugins.clipboard; b.on("contentDom", function () {
                            function d(c, e, h) {
                                e.select(); a(b, {
                                    dataTransfer: h,
                                    method: "drop"
                                }, 1); h.sourceEditor.fire("saveSnapshot"); h.sourceEditor.editable().extractHtmlFromRange(c); h.sourceEditor.getSelection().selectRanges([c]); h.sourceEditor.fire("saveSnapshot")
                            } function e(d, h) { d.select(); a(b, { dataTransfer: h, method: "drop" }, 1); c.resetDragDataTransfer() } function h(a, c, d) { var e = { $: a.data.$, target: a.data.getTarget() }; c && (e.dragRange = c); d && (e.dropRange = d); !1 === b.fire(a.name, e) && a.data.preventDefault() } function g(a) { a.type != CKEDITOR.NODE_ELEMENT && (a = a.getParent()); return a.getChildCount() }
                            var k = b.editable(), l = CKEDITOR.plugins.clipboard.getDropTarget(b), m = b.ui.space("top"), A = b.ui.space("bottom"); c.preventDefaultDropOnElement(m); c.preventDefaultDropOnElement(A); k.attachListener(l, "dragstart", h); k.attachListener(b, "dragstart", c.resetDragDataTransfer, c, null, 1); k.attachListener(b, "dragstart", function (a) { c.initDragDataTransfer(a, b) }, null, null, 2); k.attachListener(b, "dragstart", function () {
                                var a = c.dragRange = b.getSelection().getRanges()[0]; CKEDITOR.env.ie && 10 > CKEDITOR.env.version && (c.dragStartContainerChildCount =
                                    a ? g(a.startContainer) : null, c.dragEndContainerChildCount = a ? g(a.endContainer) : null)
                            }, null, null, 100); k.attachListener(l, "dragend", h); k.attachListener(b, "dragend", c.initDragDataTransfer, c, null, 1); k.attachListener(b, "dragend", c.resetDragDataTransfer, c, null, 100); k.attachListener(l, "dragover", function (a) {
                                if (CKEDITOR.env.edge) a.data.preventDefault(); else {
                                    var b = a.data.getTarget(); b && b.is && b.is("html") ? a.data.preventDefault() : CKEDITOR.env.ie && CKEDITOR.plugins.clipboard.isFileApiSupported && a.data.$.dataTransfer.types.contains("Files") &&
                                        a.data.preventDefault()
                                }
                            }); k.attachListener(l, "drop", function (a) { if (!a.data.$.defaultPrevented && (a.data.preventDefault(), !b.readOnly)) { var d = a.data.getTarget(); if (!d.isReadOnly() || d.type == CKEDITOR.NODE_ELEMENT && d.is("html")) { var d = c.getRangeAtDropPosition(a, b), e = c.dragRange; d && h(a, e, d) } } }, null, null, 9999); k.attachListener(b, "drop", c.initDragDataTransfer, c, null, 1); k.attachListener(b, "drop", function (a) {
                                if (a = a.data) {
                                    var h = a.dropRange, g = a.dragRange, k = a.dataTransfer; k.getTransferType(b) == CKEDITOR.DATA_TRANSFER_INTERNAL ?
                                        setTimeout(function () { c.internalDrop(g, h, k, b) }, 0) : k.getTransferType(b) == CKEDITOR.DATA_TRANSFER_CROSS_EDITORS ? d(g, h, k) : e(h, k)
                                }
                            }, null, null, 9999)
                        })
                    } var k; CKEDITOR.plugins.add("clipboard", {
                        requires: "dialog,notification,toolbar", init: function (a) {
                            function h(a) { if (!a || r === a.id) return !1; var b = a.getTypes(), b = 1 === b.length && "Files" === b[0]; a = 1 === a.getFilesCount(); return b && a } var k, l = d(a); a.config.forcePasteAsPlainText ? k = "plain-text" : a.config.pasteFilter ? k = a.config.pasteFilter : !CKEDITOR.env.webkit || "pasteFilter" in
                                a.config || (k = "semantic-content"); a.pasteFilter = l.get(k); g(a); c(a); CKEDITOR.dialog.add("paste", CKEDITOR.getUrl(this.path + "dialogs/paste.js")); if (CKEDITOR.env.gecko) {
                                    var q = ["image/png", "image/jpeg", "image/gif"], r; a.on("paste", function (b) {
                                        var c = b.data, d = c.dataTransfer; if (!c.dataValue && "paste" == c.method && h(d) && (d = d.getFile(0), -1 != CKEDITOR.tools.indexOf(q, d.type))) {
                                            var e = new FileReader; e.addEventListener("load", function () { b.data.dataValue = '\x3cimg src\x3d"' + e.result + '" /\x3e'; a.fire("paste", b.data) }, !1);
                                            e.addEventListener("abort", function () { a.fire("paste", b.data) }, !1); e.addEventListener("error", function () { a.fire("paste", b.data) }, !1); e.readAsDataURL(d); r = c.dataTransfer.id; b.stop()
                                        }
                                    }, null, null, 1)
                                } a.on("paste", function (b) {
                                    b.data.dataTransfer || (b.data.dataTransfer = new CKEDITOR.plugins.clipboard.dataTransfer); if (!b.data.dataValue) {
                                        var c = b.data.dataTransfer, d = c.getData("text/html"); if (d) b.data.dataValue = d, b.data.type = "html"; else if (d = c.getData("text/plain")) b.data.dataValue = a.editable().transformPlainTextToHtml(d),
                                            b.data.type = "text"
                                    }
                                }, null, null, 1); a.on("paste", function (a) {
                                    var b = a.data.dataValue, c = CKEDITOR.dtd.$block; -1 < b.indexOf("Apple-") && (b = b.replace(/<span class="Apple-converted-space">&nbsp;<\/span>/gi, " "), "html" != a.data.type && (b = b.replace(/<span class="Apple-tab-span"[^>]*>([^<]*)<\/span>/gi, function (a, b) { return b.replace(/\t/g, "\x26nbsp;\x26nbsp; \x26nbsp;") })), -1 < b.indexOf('\x3cbr class\x3d"Apple-interchange-newline"\x3e') && (a.data.startsWithEOL = 1, a.data.preSniffing = "html", b = b.replace(/<br class="Apple-interchange-newline">/,
                                        "")), b = b.replace(/(<[^>]+) class="Apple-[^"]*"/gi, "$1")); if (b.match(/^<[^<]+cke_(editable|contents)/i)) { var d, f, e = new CKEDITOR.dom.element("div"); for (e.setHtml(b); 1 == e.getChildCount() && (d = e.getFirst()) && d.type == CKEDITOR.NODE_ELEMENT && (d.hasClass("cke_editable") || d.hasClass("cke_contents"));)e = f = d; f && (b = f.getHtml().replace(/<br>$/i, "")) } CKEDITOR.env.ie ? b = b.replace(/^&nbsp;(?: |\r\n)?<(\w+)/g, function (b, d) { return d.toLowerCase() in c ? (a.data.preSniffing = "html", "\x3c" + d) : b }) : CKEDITOR.env.webkit ? b = b.replace(/<\/(\w+)><div><br><\/div>$/,
                                            function (b, d) { return d in c ? (a.data.endsWithEOL = 1, "\x3c/" + d + "\x3e") : b }) : CKEDITOR.env.gecko && (b = b.replace(/(\s)<br>$/, "$1")); a.data.dataValue = b
                                }, null, null, 3); a.on("paste", function (c) {
                                    c = c.data; var d = a._.nextPasteType || c.type, h = c.dataValue, g, k = a.config.clipboard_defaultContentType || "html", n = c.dataTransfer.getTransferType(a) == CKEDITOR.DATA_TRANSFER_EXTERNAL, p = !0 === a.config.forcePasteAsPlainText; g = "html" == d || "html" == c.preSniffing ? "html" : e(h); delete a._.nextPasteType; "htmlifiedtext" == g && (h = b(a.config, h));
                                    if ("text" == d && "html" == g) h = m(a, h, l.get("plain-text")); else if (n && a.pasteFilter && !c.dontFilter || p) h = m(a, h, a.pasteFilter); c.startsWithEOL && (h = '\x3cbr data-cke-eol\x3d"1"\x3e' + h); c.endsWithEOL && (h += '\x3cbr data-cke-eol\x3d"1"\x3e'); "auto" == d && (d = "html" == g || "html" == k ? "html" : "text"); c.type = d; c.dataValue = h; delete c.preSniffing; delete c.startsWithEOL; delete c.endsWithEOL
                                }, null, null, 6); a.on("paste", function (b) {
                                    b = b.data; b.dataValue && (a.insertHtml(b.dataValue, b.type, b.range), setTimeout(function () { a.fire("afterPaste") },
                                        0))
                                }, null, null, 1E3); a.on("pasteDialog", function (b) { setTimeout(function () { a.openDialog("paste", b.data) }, 0) })
                        }
                    }); CKEDITOR.plugins.clipboard = {
                        isCustomCopyCutSupported: CKEDITOR.env.ie && 16 > CKEDITOR.env.version || CKEDITOR.env.iOS && 605 > CKEDITOR.env.version ? !1 : !0, isCustomDataTypesSupported: !CKEDITOR.env.ie || 16 <= CKEDITOR.env.version, isFileApiSupported: !CKEDITOR.env.ie || 9 < CKEDITOR.env.version, mainPasteEvent: CKEDITOR.env.ie && !CKEDITOR.env.edge ? "beforepaste" : "paste", addPasteButton: function (a, b, c) {
                            a.ui.addButton &&
                            (a.ui.addButton(b, c), a._.pasteButtons || (a._.pasteButtons = []), a._.pasteButtons.push(b))
                        }, canClipboardApiBeTrusted: function (a, b) { return a.getTransferType(b) != CKEDITOR.DATA_TRANSFER_EXTERNAL || CKEDITOR.env.chrome && !a.isEmpty() || CKEDITOR.env.gecko && (a.getData("text/html") || a.getFilesCount()) || CKEDITOR.env.safari && 603 <= CKEDITOR.env.version && !CKEDITOR.env.iOS || CKEDITOR.env.iOS && 605 <= CKEDITOR.env.version || CKEDITOR.env.edge && 16 <= CKEDITOR.env.version ? !0 : !1 }, getDropTarget: function (a) {
                            var b = a.editable(); return CKEDITOR.env.ie &&
                                9 > CKEDITOR.env.version || b.isInline() ? b : a.document
                        }, fixSplitNodesAfterDrop: function (a, b, c, d) {
                            function e(a, c, d) { var f = a; f.type == CKEDITOR.NODE_TEXT && (f = a.getParent()); if (f.equals(c) && d != c.getChildCount()) return a = b.startContainer.getChild(b.startOffset - 1), c = b.startContainer.getChild(b.startOffset), a && a.type == CKEDITOR.NODE_TEXT && c && c.type == CKEDITOR.NODE_TEXT && (d = a.getLength(), a.setText(a.getText() + c.getText()), c.remove(), b.setStart(a, d), b.collapse(!0)), !0 } var h = b.startContainer; "number" == typeof d && "number" ==
                                typeof c && h.type == CKEDITOR.NODE_ELEMENT && (e(a.startContainer, h, c) || e(a.endContainer, h, d))
                        }, isDropRangeAffectedByDragRange: function (a, b) { var c = b.startContainer, d = b.endOffset; return a.endContainer.equals(c) && a.endOffset <= d || a.startContainer.getParent().equals(c) && a.startContainer.getIndex() < d || a.endContainer.getParent().equals(c) && a.endContainer.getIndex() < d ? !0 : !1 }, internalDrop: function (b, c, d, e) {
                            var h = CKEDITOR.plugins.clipboard, g = e.editable(), k, l; e.fire("saveSnapshot"); e.fire("lockSnapshot", { dontUpdate: 1 });
                            CKEDITOR.env.ie && 10 > CKEDITOR.env.version && this.fixSplitNodesAfterDrop(b, c, h.dragStartContainerChildCount, h.dragEndContainerChildCount); (l = this.isDropRangeAffectedByDragRange(b, c)) || (k = b.createBookmark(!1)); h = c.clone().createBookmark(!1); l && (k = b.createBookmark(!1)); b = k.startNode; c = k.endNode; l = h.startNode; c && b.getPosition(l) & CKEDITOR.POSITION_PRECEDING && c.getPosition(l) & CKEDITOR.POSITION_FOLLOWING && l.insertBefore(b); b = e.createRange(); b.moveToBookmark(k); g.extractHtmlFromRange(b, 1); c = e.createRange();
                            h.startNode.getCommonAncestor(g) || (h = e.getSelection().createBookmarks()[0]); c.moveToBookmark(h); a(e, { dataTransfer: d, method: "drop", range: c }, 1); e.fire("unlockSnapshot")
                        }, getRangeAtDropPosition: function (a, b) {
                            var c = a.data.$, d = c.clientX, e = c.clientY, h = b.getSelection(!0).getRanges()[0], g = b.createRange(); if (a.data.testRange) return a.data.testRange; if (document.caretRangeFromPoint && b.document.$.caretRangeFromPoint(d, e)) c = b.document.$.caretRangeFromPoint(d, e), g.setStart(CKEDITOR.dom.node(c.startContainer), c.startOffset),
                                g.collapse(!0); else if (c.rangeParent) g.setStart(CKEDITOR.dom.node(c.rangeParent), c.rangeOffset), g.collapse(!0); else {
                                    if (CKEDITOR.env.ie && 8 < CKEDITOR.env.version && h && b.editable().hasFocus) return h; if (document.body.createTextRange) {
                                        b.focus(); c = b.document.getBody().$.createTextRange(); try {
                                            for (var k = !1, l = 0; 20 > l && !k; l++) { if (!k) try { c.moveToPoint(d, e - l), k = !0 } catch (m) { } if (!k) try { c.moveToPoint(d, e + l), k = !0 } catch (v) { } } if (k) {
                                                var z = "cke-temp-" + (new Date).getTime(); c.pasteHTML('\x3cspan id\x3d"' + z + '"\x3e​\x3c/span\x3e');
                                                var y = b.document.getById(z); g.moveToPosition(y, CKEDITOR.POSITION_BEFORE_START); y.remove()
                                            } else { var B = b.document.$.elementFromPoint(d, e), C = new CKEDITOR.dom.element(B), F; if (C.equals(b.editable()) || "html" == C.getName()) return h && h.startContainer && !h.startContainer.equals(b.editable()) ? h : null; F = C.getClientRect(); d < F.left ? g.setStartAt(C, CKEDITOR.POSITION_AFTER_START) : g.setStartAt(C, CKEDITOR.POSITION_BEFORE_END); g.collapse(!0) }
                                        } catch (G) { return null }
                                    } else return null
                                } return g
                        }, initDragDataTransfer: function (a,
                            b) { var c = a.data.$ ? a.data.$.dataTransfer : null, d = new this.dataTransfer(c, b); "dragstart" === a.name && d.storeId(); c ? this.dragData && d.id == this.dragData.id ? d = this.dragData : this.dragData = d : this.dragData ? d = this.dragData : this.dragData = d; a.data.dataTransfer = d }, resetDragDataTransfer: function () { this.dragData = null }, initPasteDataTransfer: function (a, b) {
                                if (this.isCustomCopyCutSupported) {
                                    if (a && a.data && a.data.$) {
                                        var c = a.data.$.clipboardData, d = new this.dataTransfer(c, b); "copy" !== a.name && "cut" !== a.name || d.storeId(); this.copyCutData &&
                                            d.id == this.copyCutData.id ? (d = this.copyCutData, d.$ = c) : this.copyCutData = d; return d
                                    } return new this.dataTransfer(null, b)
                                } return new this.dataTransfer(CKEDITOR.env.edge && a && a.data.$ && a.data.$.clipboardData || null, b)
                            }, preventDefaultDropOnElement: function (a) { a && a.on("dragover", l) }
                    }; k = CKEDITOR.plugins.clipboard.isCustomDataTypesSupported ? "cke/id" : "Text"; CKEDITOR.plugins.clipboard.dataTransfer = function (a, b) {
                        a && (this.$ = a); this._ = {
                            metaRegExp: /^<meta.*?>/i, bodyRegExp: /<body(?:[\s\S]*?)>([\s\S]*)<\/body>/i, fragmentRegExp: /\s*\x3c!--StartFragment--\x3e|\x3c!--EndFragment--\x3e\s*/g,
                            data: {}, files: [], nativeHtmlCache: "", normalizeType: function (a) { a = a.toLowerCase(); return "text" == a || "text/plain" == a ? "Text" : "url" == a ? "URL" : a }
                        }; this._.fallbackDataTransfer = new CKEDITOR.plugins.clipboard.fallbackDataTransfer(this); this.id = this.getData(k); this.id || (this.id = "Text" == k ? "" : "cke-" + CKEDITOR.tools.getUniqueId()); b && (this.sourceEditor = b, this.setData("text/html", b.getSelectedHtml(1)), "Text" == k || this.getData("text/plain") || this.setData("text/plain", b.getSelection().getSelectedText()))
                    }; CKEDITOR.DATA_TRANSFER_INTERNAL =
                        1; CKEDITOR.DATA_TRANSFER_CROSS_EDITORS = 2; CKEDITOR.DATA_TRANSFER_EXTERNAL = 3; CKEDITOR.plugins.clipboard.dataTransfer.prototype = {
                            getData: function (a, b) {
                                a = this._.normalizeType(a); var c = "text/html" == a && b ? this._.nativeHtmlCache : this._.data[a]; if (void 0 === c || null === c || "" === c) { if (this._.fallbackDataTransfer.isRequired()) c = this._.fallbackDataTransfer.getData(a, b); else try { c = this.$.getData(a) || "" } catch (d) { c = "" } "text/html" != a || b || (c = this._stripHtml(c)) } "Text" == a && CKEDITOR.env.gecko && this.getFilesCount() && "file://" ==
                                    c.substring(0, 7) && (c = ""); if ("string" === typeof c) var e = c.indexOf("\x3c/html\x3e"), c = -1 !== e ? c.substring(0, e + 7) : c; return c
                            }, setData: function (a, b) { a = this._.normalizeType(a); "text/html" == a ? (this._.data[a] = this._stripHtml(b), this._.nativeHtmlCache = b) : this._.data[a] = b; if (CKEDITOR.plugins.clipboard.isCustomDataTypesSupported || "URL" == a || "Text" == a) if ("Text" == k && "Text" == a && (this.id = b), this._.fallbackDataTransfer.isRequired()) this._.fallbackDataTransfer.setData(a, b); else try { this.$.setData(a, b) } catch (c) { } }, storeId: function () {
                                "Text" !==
                                k && this.setData(k, this.id)
                            }, getTransferType: function (a) { return this.sourceEditor ? this.sourceEditor == a ? CKEDITOR.DATA_TRANSFER_INTERNAL : CKEDITOR.DATA_TRANSFER_CROSS_EDITORS : CKEDITOR.DATA_TRANSFER_EXTERNAL }, cacheData: function () {
                                function a(c) { c = b._.normalizeType(c); var d = b.getData(c); "text/html" == c && (b._.nativeHtmlCache = b.getData(c, !0), d = b._stripHtml(d)); d && (b._.data[c] = d) } if (this.$) {
                                    var b = this, c, d; if (CKEDITOR.plugins.clipboard.isCustomDataTypesSupported) { if (this.$.types) for (c = 0; c < this.$.types.length; c++)a(this.$.types[c]) } else a("Text"),
                                        a("URL"); d = this._getImageFromClipboard(); if (this.$ && this.$.files || d) { this._.files = []; if (this.$.files && this.$.files.length) for (c = 0; c < this.$.files.length; c++)this._.files.push(this.$.files[c]); 0 === this._.files.length && d && this._.files.push(d) }
                                }
                            }, getFilesCount: function () { return this._.files.length ? this._.files.length : this.$ && this.$.files && this.$.files.length ? this.$.files.length : this._getImageFromClipboard() ? 1 : 0 }, getFile: function (a) {
                                return this._.files.length ? this._.files[a] : this.$ && this.$.files && this.$.files.length ?
                                    this.$.files[a] : 0 === a ? this._getImageFromClipboard() : void 0
                            }, isEmpty: function () { var a = {}, b; if (this.getFilesCount()) return !1; CKEDITOR.tools.array.forEach(CKEDITOR.tools.object.keys(this._.data), function (b) { a[b] = 1 }); if (this.$) if (CKEDITOR.plugins.clipboard.isCustomDataTypesSupported) { if (this.$.types) for (var c = 0; c < this.$.types.length; c++)a[this.$.types[c]] = 1 } else a.Text = 1, a.URL = 1; "Text" != k && (a[k] = 0); for (b in a) if (a[b] && "" !== this.getData(b)) return !1; return !0 }, getTypes: function () {
                                return this.$ && this.$.types ?
                                    [].slice.call(this.$.types) : []
                            }, _getImageFromClipboard: function () { var a; try { if (this.$ && this.$.items && this.$.items[0] && (a = this.$.items[0].getAsFile()) && a.type) return a } catch (b) { } }, _stripHtml: function (a) { if (a && a.length) { a = a.replace(this._.metaRegExp, ""); var b = this._.bodyRegExp.exec(a); b && b.length && (a = b[1], a = a.replace(this._.fragmentRegExp, "")) } return a }
                        }; CKEDITOR.plugins.clipboard.fallbackDataTransfer = function (a) { this._dataTransfer = a; this._customDataFallbackType = "text/html" }; CKEDITOR.plugins.clipboard.fallbackDataTransfer._isCustomMimeTypeSupported =
                            null; CKEDITOR.plugins.clipboard.fallbackDataTransfer._customTypes = []; CKEDITOR.plugins.clipboard.fallbackDataTransfer.prototype = {
                                isRequired: function () {
                                    var a = CKEDITOR.plugins.clipboard.fallbackDataTransfer, b = this._dataTransfer.$; if (null === a._isCustomMimeTypeSupported) if (b) { a._isCustomMimeTypeSupported = !1; if (CKEDITOR.env.edge && 17 <= CKEDITOR.env.version) return !0; try { b.setData("cke/mimetypetest", "cke test value"), a._isCustomMimeTypeSupported = "cke test value" === b.getData("cke/mimetypetest"), b.clearData("cke/mimetypetest") } catch (c) { } } else return !1;
                                    return !a._isCustomMimeTypeSupported
                                }, getData: function (a, b) { var c = this._getData(this._customDataFallbackType, !0); if (b) return c; var c = this._extractDataComment(c), d = null, d = a === this._customDataFallbackType ? c.content : c.data && c.data[a] ? c.data[a] : this._getData(a, !0); return null !== d ? d : "" }, setData: function (a, b) {
                                    var c = a === this._customDataFallbackType; c && (b = this._applyDataComment(b, this._getFallbackTypeData())); var d = b, e = this._dataTransfer.$; try { e.setData(a, d), c && (this._dataTransfer._.nativeHtmlCache = d) } catch (h) {
                                        if (this._isUnsupportedMimeTypeError(h)) {
                                            c =
                                            CKEDITOR.plugins.clipboard.fallbackDataTransfer; -1 === CKEDITOR.tools.indexOf(c._customTypes, a) && c._customTypes.push(a); var c = this._getFallbackTypeContent(), g = this._getFallbackTypeData(); g[a] = d; try { d = this._applyDataComment(c, g), e.setData(this._customDataFallbackType, d), this._dataTransfer._.nativeHtmlCache = d } catch (k) { d = "" }
                                        }
                                    } return d
                                }, _getData: function (a, b) { var c = this._dataTransfer._.data; if (!b && c[a]) return c[a]; try { return this._dataTransfer.$.getData(a) } catch (d) { return null } }, _getFallbackTypeContent: function () {
                                    var a =
                                        this._dataTransfer._.data[this._customDataFallbackType]; a || (a = this._extractDataComment(this._getData(this._customDataFallbackType, !0)).content); return a
                                }, _getFallbackTypeData: function () { var a = CKEDITOR.plugins.clipboard.fallbackDataTransfer._customTypes, b = this._extractDataComment(this._getData(this._customDataFallbackType, !0)).data || {}, c = this._dataTransfer._.data; CKEDITOR.tools.array.forEach(a, function (a) { void 0 !== c[a] ? b[a] = c[a] : void 0 !== b[a] && (b[a] = b[a]) }, this); return b }, _isUnsupportedMimeTypeError: function (a) {
                                    return a.message &&
                                        -1 !== a.message.search(/element not found/gi)
                                }, _extractDataComment: function (a) { var b = { data: null, content: a || "" }; if (a && 16 < a.length) { var c; (c = /\x3c!--cke-data:(.*?)--\x3e/g.exec(a)) && c[1] && (b.data = JSON.parse(decodeURIComponent(c[1])), b.content = a.replace(c[0], "")) } return b }, _applyDataComment: function (a, b) { var c = ""; b && CKEDITOR.tools.object.keys(b).length && (c = "\x3c!--cke-data:" + encodeURIComponent(JSON.stringify(b)) + "--\x3e"); return c + (a && a.length ? a : "") }
                            }
            })(); CKEDITOR.config.clipboard_notificationDuration =
                1E4; CKEDITOR.plugins.add("panelbutton", {
                    requires: "button", onLoad: function () {
                        function a(a) { var e = this._; e.state != CKEDITOR.TRISTATE_DISABLED && (this.createPanel(a), e.on ? e.panel.hide() : e.panel.showBlock(this._.id, this.document.getById(this._.id), 4)) } CKEDITOR.ui.panelButton = CKEDITOR.tools.createClass({
                            base: CKEDITOR.ui.button, $: function (g) {
                                var e = g.panel || {}; delete g.panel; this.base(g); this.document = e.parent && e.parent.getDocument() || CKEDITOR.document; e.block = { attributes: e.attributes }; e.toolbarRelated = !0;
                                this.hasArrow = "listbox"; this.click = a; this._ = { panelDefinition: e }
                            }, statics: { handler: { create: function (a) { return new CKEDITOR.ui.panelButton(a) } } }, proto: {
                                createPanel: function (a) {
                                    var e = this._; if (!e.panel) {
                                        var b = this._.panelDefinition, d = this._.panelDefinition.block, m = b.parent || CKEDITOR.document.getBody(), h = this._.panel = new CKEDITOR.ui.floatPanel(a, m, b), b = h.addBlock(e.id, d), l = this, c = a.getCommand(this.command); h.onShow = function () {
                                            l.className && this.element.addClass(l.className + "_panel"); l.setState(CKEDITOR.TRISTATE_ON);
                                            e.on = 1; l.editorFocus && a.focus(); if (l.onOpen) l.onOpen()
                                        }; h.onHide = function (b) { l.className && this.element.getFirst().removeClass(l.className + "_panel"); !l.modes && c ? l.setStateFromCommand(c) : l.setState(l.modes && l.modes[a.mode] ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED); e.on = 0; if (!b && l.onClose) l.onClose() }; h.onEscape = function () { h.hide(1); l.document.getById(e.id).focus() }; if (this.onBlock) this.onBlock(h, b); b.onHide = function () { e.on = 0; !l.modes && l.command ? l.setStateFromCommand(c) : l.setState(CKEDITOR.TRISTATE_OFF) }
                                    }
                                },
                                setStateFromCommand: function (a) { this.setState(a.state) }
                            }
                        })
                    }, beforeInit: function (a) { a.ui.addHandler(CKEDITOR.UI_PANELBUTTON, CKEDITOR.ui.panelButton.handler) }
                }); CKEDITOR.UI_PANELBUTTON = "panelbutton"; (function () {
                    CKEDITOR.plugins.add("panel", { beforeInit: function (a) { a.ui.addHandler(CKEDITOR.UI_PANEL, CKEDITOR.ui.panel.handler) } }); CKEDITOR.UI_PANEL = "panel"; CKEDITOR.ui.panel = function (a, d) {
                        d && CKEDITOR.tools.extend(this, d); CKEDITOR.tools.extend(this, { className: "", css: [] }); this.id = CKEDITOR.tools.getNextId();
                        this.document = a; this.isFramed = this.forceIFrame || this.css.length; this._ = { blocks: {} }
                    }; CKEDITOR.ui.panel.handler = { create: function (a) { return new CKEDITOR.ui.panel(a) } }; var a = CKEDITOR.addTemplate("panel", '\x3cdiv lang\x3d"{langCode}" id\x3d"{id}" dir\x3d{dir} class\x3d"cke cke_reset_all {editorId} cke_panel cke_panel {cls} cke_{dir}" style\x3d"z-index:{z-index}" role\x3d"presentation"\x3e{frame}\x3c/div\x3e'), g = CKEDITOR.addTemplate("panel-frame", '\x3ciframe id\x3d"{id}" class\x3d"cke_panel_frame" role\x3d"presentation" frameborder\x3d"0" src\x3d"{src}"\x3e\x3c/iframe\x3e'),
                        e = CKEDITOR.addTemplate("panel-frame-inner", '\x3c!DOCTYPE html\x3e\x3chtml class\x3d"cke_panel_container {env}" dir\x3d"{dir}" lang\x3d"{langCode}"\x3e\x3chead\x3e{css}\x3c/head\x3e\x3cbody class\x3d"cke_{dir}" style\x3d"margin:0;padding:0" onload\x3d"{onload}"\x3e\x3c/body\x3e\x3c/html\x3e'); CKEDITOR.ui.panel.prototype = {
                            render: function (b, d) {
                                var m = { editorId: b.id, id: this.id, langCode: b.langCode, dir: b.lang.dir, cls: this.className, frame: "", env: CKEDITOR.env.cssClass, "z-index": b.config.baseFloatZIndex + 1 };
                                this.getHolderElement = function () {
                                    var a = this._.holder; if (!a) {
                                        if (this.isFramed) {
                                            var a = this.document.getById(this.id + "_frame"), b = a.getParent(), a = a.getFrameDocument(); CKEDITOR.env.iOS && b.setStyles({ overflow: "scroll", "-webkit-overflow-scrolling": "touch" }); b = CKEDITOR.tools.addFunction(CKEDITOR.tools.bind(function () { this.isLoaded = !0; if (this.onLoad) this.onLoad() }, this)); a.write(e.output(CKEDITOR.tools.extend({
                                                css: CKEDITOR.tools.buildStyleHtml(this.css), onload: "window.parent.CKEDITOR.tools.callFunction(" +
                                                    b + ");"
                                            }, m))); a.getWindow().$.CKEDITOR = CKEDITOR; a.on("keydown", function (a) { var b = a.data.getKeystroke(), c = this.document.getById(this.id).getAttribute("dir"); if ("input" !== a.data.getTarget().getName() || 37 !== b && 39 !== b) this._.onKeyDown && !1 === this._.onKeyDown(b) ? "input" === a.data.getTarget().getName() && 32 === b || a.data.preventDefault() : (27 == b || b == ("rtl" == c ? 39 : 37)) && this.onEscape && !1 === this.onEscape(b) && a.data.preventDefault() }, this); a = a.getBody(); a.unselectable(); CKEDITOR.env.air && CKEDITOR.tools.callFunction(b)
                                        } else a =
                                            this.document.getById(this.id); this._.holder = a
                                    } return a
                                }; if (this.isFramed) { var h = CKEDITOR.env.air ? "javascript:void(0)" : CKEDITOR.env.ie && !CKEDITOR.env.edge ? "javascript:void(function(){" + encodeURIComponent("document.open();(" + CKEDITOR.tools.fixDomain + ")();document.close();") + "}())" : ""; m.frame = g.output({ id: this.id + "_frame", src: h }) } h = a.output(m); d && d.push(h); return h
                            }, addBlock: function (a, d) {
                                d = this._.blocks[a] = d instanceof CKEDITOR.ui.panel.block ? d : new CKEDITOR.ui.panel.block(this.getHolderElement(), d);
                                this._.currentBlock || this.showBlock(a); return d
                            }, getBlock: function (a) { return this._.blocks[a] }, showBlock: function (a) { a = this._.blocks[a]; var d = this._.currentBlock, e = !this.forceIFrame || CKEDITOR.env.ie ? this._.holder : this.document.getById(this.id + "_frame"); d && d.hide(); this._.currentBlock = a; CKEDITOR.fire("ariaWidget", e); a._.focusIndex = -1; this._.onKeyDown = a.onKeyDown && CKEDITOR.tools.bind(a.onKeyDown, a); a.show(); return a }, destroy: function () { this.element && this.element.remove() }
                        }; CKEDITOR.ui.panel.block = CKEDITOR.tools.createClass({
                            $: function (a,
                                d) { this.element = a.append(a.getDocument().createElement("div", { attributes: { tabindex: -1, "class": "cke_panel_block" }, styles: { display: "none" } })); d && CKEDITOR.tools.extend(this, d); this.element.setAttributes({ role: this.attributes.role || "presentation", "aria-label": this.attributes["aria-label"], title: this.attributes.title || this.attributes["aria-label"] }); this.keys = {}; this._.focusIndex = -1; this.element.disableContextMenu() }, _: {
                                    markItem: function (a) {
                                        -1 != a && (a = this._.getItems().getItem(this._.focusIndex = a), CKEDITOR.env.webkit &&
                                            a.getDocument().getWindow().focus(), a.focus(), this.onMark && this.onMark(a))
                                    }, markFirstDisplayed: function (a) { for (var d = function (a) { return a.type == CKEDITOR.NODE_ELEMENT && "none" == a.getStyle("display") }, e = this._.getItems(), h, g, c = e.count() - 1; 0 <= c; c--)if (h = e.getItem(c), h.getAscendant(d) || (g = h, this._.focusIndex = c), "true" == h.getAttribute("aria-selected")) { g = h; this._.focusIndex = c; break } g && (a && a(), CKEDITOR.env.webkit && g.getDocument().getWindow().focus(), g.focus(), this.onMark && this.onMark(g)) }, getItems: function () { return this.element.find("a,input") }
                                },
                            proto: {
                                show: function () { this.element.setStyle("display", "") }, hide: function () { this.onHide && !0 === this.onHide.call(this) || this.element.setStyle("display", "none") }, onKeyDown: function (a, d) {
                                    var e = this.keys[a]; switch (e) {
                                        case "next": for (var h = this._.focusIndex, e = this._.getItems(), g; g = e.getItem(++h);)if (g.getAttribute("_cke_focus") && g.$.offsetWidth) { this._.focusIndex = h; g.focus(!0); break } return g || d ? !1 : (this._.focusIndex = -1, this.onKeyDown(a, 1)); case "prev": h = this._.focusIndex; for (e = this._.getItems(); 0 < h && (g =
                                            e.getItem(--h));) { if (g.getAttribute("_cke_focus") && g.$.offsetWidth) { this._.focusIndex = h; g.focus(!0); break } g = null } return g || d ? !1 : (this._.focusIndex = e.count(), this.onKeyDown(a, 1)); case "click": case "mouseup": return h = this._.focusIndex, (g = 0 <= h && this._.getItems().getItem(h)) && g.fireEventHandler(e, { button: CKEDITOR.tools.normalizeMouseButton(CKEDITOR.MOUSE_BUTTON_LEFT, !0) }), !1
                                    }return !0
                                }
                            }
                        })
                })(); CKEDITOR.plugins.add("floatpanel", { requires: "panel" }); (function () {
                    function a(a, b, d, m, h) {
                        h = CKEDITOR.tools.genKey(b.getUniqueId(),
                            d.getUniqueId(), a.lang.dir, a.uiColor || "", m.css || "", h || ""); var l = g[h]; l || (l = g[h] = new CKEDITOR.ui.panel(b, m), l.element = d.append(CKEDITOR.dom.element.createFromHtml(l.render(a), b)), l.element.setStyles({ display: "none", position: "absolute" })); return l
                    } var g = {}; CKEDITOR.ui.floatPanel = CKEDITOR.tools.createClass({
                        $: function (e, b, d, g) {
                            function h() { f.hide() } d.forceIFrame = 1; d.toolbarRelated && e.elementMode == CKEDITOR.ELEMENT_MODE_INLINE && (b = CKEDITOR.document.getById("cke_" + e.name)); var l = b.getDocument(); g = a(e, l,
                                b, d, g || 0); var c = g.element, k = c.getFirst(), f = this; c.disableContextMenu(); this.element = c; this._ = { editor: e, panel: g, parentElement: b, definition: d, document: l, iframe: k, children: [], dir: e.lang.dir, showBlockParams: null, markFirst: void 0 !== d.markFirst ? d.markFirst : !0 }; e.on("mode", h); e.on("resize", h); l.getWindow().on("resize", function () { this.reposition() }, this)
                        }, proto: {
                            addBlock: function (a, b) { return this._.panel.addBlock(a, b) }, addListBlock: function (a, b) { return this._.panel.addListBlock(a, b) }, getBlock: function (a) { return this._.panel.getBlock(a) },
                            showBlock: function (a, b, d, g, h, l) {
                                var c = this._.panel, k = c.showBlock(a); this._.showBlockParams = [].slice.call(arguments); this.allowBlur(!1); var f = this._.editor.editable(); this._.returnFocus = f.hasFocus ? f : new CKEDITOR.dom.element(CKEDITOR.document.$.activeElement); this._.hideTimeout = 0; var n = this.element, f = this._.iframe, f = CKEDITOR.env.ie && !CKEDITOR.env.edge ? f : new CKEDITOR.dom.window(f.$.contentWindow), p = n.getDocument(), t = this._.parentElement.getPositionedAncestor(), q = b.getDocumentPosition(p), p = t ? t.getDocumentPosition(p) :
                                    { x: 0, y: 0 }, r = "rtl" == this._.dir, w = q.x + (g || 0) - p.x, x = q.y + (h || 0) - p.y; !r || 1 != d && 4 != d ? r || 2 != d && 3 != d || (w += b.$.offsetWidth - 1) : w += b.$.offsetWidth; if (3 == d || 4 == d) x += b.$.offsetHeight - 1; this._.panel._.offsetParentId = b.getId(); n.setStyles({ top: x + "px", left: 0, display: "" }); n.setOpacity(0); n.getFirst().removeStyle("width"); this._.editor.focusManager.add(f); this._.blurSet || (CKEDITOR.event.useCapture = !0, f.on("blur", function (a) {
                                        function b() { delete this._.returnFocus; this.hide() } this.allowBlur() && a.data.getPhase() == CKEDITOR.EVENT_PHASE_AT_TARGET &&
                                            this.visible && !this._.activeChild && (CKEDITOR.env.iOS ? this._.hideTimeout || (this._.hideTimeout = CKEDITOR.tools.setTimeout(b, 0, this)) : b.call(this))
                                    }, this), f.on("focus", function () { this._.focused = !0; this.hideChild(); this.allowBlur(!0) }, this), CKEDITOR.env.iOS && (f.on("touchstart", function () { clearTimeout(this._.hideTimeout) }, this), f.on("touchend", function () { this._.hideTimeout = 0; this.focus() }, this)), CKEDITOR.event.useCapture = !1, this._.blurSet = 1); c.onEscape = CKEDITOR.tools.bind(function (a) {
                                        if (this.onEscape &&
                                            !1 === this.onEscape(a)) return !1
                                    }, this); CKEDITOR.tools.setTimeout(function () {
                                        var a = CKEDITOR.tools.bind(function () {
                                            var a = n; a.removeStyle("width"); if (k.autoSize) {
                                                var b = k.element.getDocument(), b = (CKEDITOR.env.webkit || CKEDITOR.env.edge ? k.element : b.getBody()).$.scrollWidth; CKEDITOR.env.ie && CKEDITOR.env.quirks && 0 < b && (b += (a.$.offsetWidth || 0) - (a.$.clientWidth || 0) + 3); a.setStyle("width", b + 10 + "px"); b = k.element.$.scrollHeight; CKEDITOR.env.ie && CKEDITOR.env.quirks && 0 < b && (b += (a.$.offsetHeight || 0) - (a.$.clientHeight ||
                                                    0) + 3); a.setStyle("height", b + "px"); c._.currentBlock.element.setStyle("display", "none").removeStyle("display")
                                            } else a.removeStyle("height"); r && (w -= n.$.offsetWidth); n.setStyle("left", w + "px"); var b = c.element.getWindow(), a = n.$.getBoundingClientRect(), b = b.getViewPaneSize(), d = a.width || a.right - a.left, f = a.height || a.bottom - a.top, e = r ? a.right : b.width - a.left, h = r ? b.width - a.right : a.left; r ? e < d && (w = h > d ? w + d : b.width > d ? w - a.left : w - a.right + b.width) : e < d && (w = h > d ? w - d : b.width > d ? w - a.right + b.width : w - a.left); d = a.top; b.height -
                                                a.top < f && (x = d > f ? x - f : b.height > f ? x - a.bottom + b.height : x - a.top); CKEDITOR.env.ie && !CKEDITOR.env.edge && ((b = a = n.$.offsetParent && new CKEDITOR.dom.element(n.$.offsetParent)) && "html" == b.getName() && (b = b.getDocument().getBody()), b && "rtl" == b.getComputedStyle("direction") && (w = CKEDITOR.env.ie8Compat ? w - 2 * n.getDocument().getDocumentElement().$.scrollLeft : w - (a.$.scrollWidth - a.$.clientWidth))); var a = n.getFirst(), g; (g = a.getCustomData("activePanel")) && g.onHide && g.onHide.call(this, 1); a.setCustomData("activePanel", this);
                                            n.setStyles({ top: x + "px", left: w + "px" }); n.setOpacity(1); l && l()
                                        }, this); c.isLoaded ? a() : c.onLoad = a; CKEDITOR.tools.setTimeout(function () {
                                            var a = CKEDITOR.env.webkit && CKEDITOR.document.getWindow().getScrollPosition().y; this.focus(); k.element.focus(); CKEDITOR.env.webkit && (CKEDITOR.document.getBody().$.scrollTop = a); this.allowBlur(!0); this._.markFirst && (CKEDITOR.env.ie ? CKEDITOR.tools.setTimeout(function () { k.markFirstDisplayed ? k.markFirstDisplayed() : k._.markFirstDisplayed() }, 0) : k.markFirstDisplayed ? k.markFirstDisplayed() :
                                                k._.markFirstDisplayed()); this._.editor.fire("panelShow", this)
                                        }, 0, this)
                                    }, CKEDITOR.env.air ? 200 : 0, this); this.visible = 1; this.onShow && this.onShow.call(this)
                            }, reposition: function () { var a = this._.showBlockParams; this.visible && this._.showBlockParams && (this.hide(), this.showBlock.apply(this, a)) }, focus: function () { if (CKEDITOR.env.webkit) { var a = CKEDITOR.document.getActive(); a && !a.equals(this._.iframe) && a.$.blur() } (this._.lastFocused || this._.iframe.getFrameDocument().getWindow()).focus() }, blur: function () {
                                var a =
                                    this._.iframe.getFrameDocument().getActive(); a && a.is("a") && (this._.lastFocused = a)
                            }, hide: function (a) {
                                if (this.visible && (!this.onHide || !0 !== this.onHide.call(this))) {
                                    this.hideChild(); CKEDITOR.env.gecko && this._.iframe.getFrameDocument().$.activeElement.blur(); this.element.setStyle("display", "none"); this.visible = 0; this.element.getFirst().removeCustomData("activePanel"); if (a = a && this._.returnFocus) CKEDITOR.env.webkit && a.type && a.getWindow().$.focus(), a.focus(); delete this._.lastFocused; this._.showBlockParams =
                                        null; this._.editor.fire("panelHide", this)
                                }
                            }, allowBlur: function (a) { var b = this._.panel; void 0 !== a && (b.allowBlur = a); return b.allowBlur }, showAsChild: function (a, b, d, g, h, l) {
                                if (this._.activeChild != a || a._.panel._.offsetParentId != d.getId()) this.hideChild(), a.onHide = CKEDITOR.tools.bind(function () { CKEDITOR.tools.setTimeout(function () { this._.focused || this.hide() }, 0, this) }, this), this._.activeChild = a, this._.focused = !1, a.showBlock(b, d, g, h, l), this.blur(), (CKEDITOR.env.ie7Compat || CKEDITOR.env.ie6Compat) && setTimeout(function () {
                                    a.element.getChild(0).$.style.cssText +=
                                    ""
                                }, 100)
                            }, hideChild: function (a) { var b = this._.activeChild; b && (delete b.onHide, delete this._.activeChild, b.hide(), a && this.focus()) }
                        }
                    }); CKEDITOR.on("instanceDestroyed", function () { var a = CKEDITOR.tools.isEmpty(CKEDITOR.instances), b; for (b in g) { var d = g[b]; a ? d.destroy() : d.element.hide() } a && (g = {}) })
                })(); CKEDITOR.plugins.add("colorbutton", {
                    requires: "panelbutton,floatpanel", init: function (a) {
                        function g(b) {
                            var c = b.name, g = b.type, k = b.title, q = b.order, r = b.commandName; b = b.contentTransformations || {}; var w = new CKEDITOR.style(h["colorButton_" +
                                g + "Style"]), x = CKEDITOR.tools.getNextId() + "_colorBox", u = { type: g }, A = new CKEDITOR.style(h["colorButton_" + g + "Style"], { color: "inherit" }), v; a.addCommand(r, { contextSensitive: !0, exec: function (a, b) { if (!a.readOnly) { var c = b.newStyle; a.removeStyle(A); a.focus(); c && a.applyStyle(c); a.fire("saveSnapshot") } }, refresh: function (a, b) { A.checkApplicable(b, a, a.activeFilter) ? A.checkActive(b, a) ? this.setState(CKEDITOR.TRISTATE_ON) : this.setState(CKEDITOR.TRISTATE_OFF) : this.setState(CKEDITOR.TRISTATE_DISABLED) } }); a.ui.add(c,
                                    CKEDITOR.UI_PANELBUTTON, {
                                        label: k, title: k, command: r, editorFocus: 0, toolbar: "colors," + q, allowedContent: w, requiredContent: w, contentTransformations: b, panel: { css: CKEDITOR.skin.getPath("editor"), attributes: { role: "listbox", "aria-label": l.panelTitle } }, select: function (a) { var b = h.colorButton_colors.split(","); a = CKEDITOR.tools.array.find(b, a); a = m(a); d(v, a); v._.markFirstDisplayed() }, onBlock: function (b, c) {
                                            v = c; c.autoSize = !0; c.element.addClass("cke_colorblock"); c.element.setHtml(e({
                                                type: g, colorBoxId: x, colorData: u,
                                                commandName: r
                                            })); c.element.getDocument().getBody().setStyle("overflow", "hidden"); CKEDITOR.ui.fire("ready", this); var d = c.keys, f = "rtl" == a.lang.dir; d[f ? 37 : 39] = "next"; d[40] = "next"; d[9] = "next"; d[f ? 39 : 37] = "prev"; d[38] = "prev"; d[CKEDITOR.SHIFT + 9] = "prev"; d[32] = "click"
                                        }, onOpen: function () {
                                            var b = a.getSelection(), c = b && b.getStartElement(), f = a.elementPath(c); if (!f) return null; c = f.block || f.blockLimit || a.document.getBody(); do f = c && c.getComputedStyle("back" == g ? "background-color" : "color") || "transparent"; while ("back" ==
                                                g && "transparent" == f && c && (c = c.getParent())); f && "transparent" != f || (f = "#ffffff"); !1 !== h.colorButton_enableAutomatic && this._.panel._.iframe.getFrameDocument().getById(x).setStyle("background-color", f); if (c = b && b.getRanges()[0]) {
                                                    for (var b = new CKEDITOR.dom.walker(c), e = c.collapsed ? c.startContainer : b.next(), c = ""; e;) { e.type !== CKEDITOR.NODE_ELEMENT && (e = e.getParent()); e = m(e.getComputedStyle("back" == g ? "background-color" : "color")); c = c || e; if (c !== e) { c = ""; break } e = b.next() } "transparent" == c && (c = ""); "fore" == g && (u.automaticTextColor =
                                                        "#" + m(f)); u.selectionColor = c ? "#" + c : ""; d(v, c)
                                                } return f
                                        }
                                })
                        } function e(c) {
                            function d(b, c) { var f = {}; b && (f.color = b); c && (f.colorName = c); f = !CKEDITOR.tools.isEmpty(f) && new CKEDITOR.style(v, f); a.execCommand(m, { newStyle: f }) } var e = c.type, g = c.colorBoxId, k = c.colorData, m = c.commandName; c = []; var w = h.colorButton_colors.split(","), x = h.colorButton_colorsPerRow || 6, u = a.plugins.colordialog && !1 !== h.colorButton_enableMore, A = w.length + (u ? 2 : 1), v = a.config["colorButton_" + e + "Style"]; v.childRule = "back" == e ? function (a) { return b(a) } :
                                function (a) { return !(a.is("a") || a.getElementsByTag("a").count()) || b(a) }; var z = CKEDITOR.tools.addFunction(function (b, c) { a.focus(); a.fire("saveSnapshot"); "?" == b ? a.getColorFromDialog(function (a) { a && d(a) }, null, k) : d(b && "#" + b, c) }); !1 !== h.colorButton_enableAutomatic && c.push('\x3ca class\x3d"cke_colorauto" _cke_focus\x3d1 hidefocus\x3dtrue title\x3d"', l.auto, '" draggable\x3d"false" ondragstart\x3d"return false;" onclick\x3d"CKEDITOR.tools.callFunction(', z, ",null, null,'", e, "');return false;\" href\x3d\"javascript:void('",
                                    l.auto, '\')" role\x3d"option" aria-posinset\x3d"1" aria-setsize\x3d"', A, '"\x3e\x3ctable role\x3d"presentation" cellspacing\x3d0 cellpadding\x3d0 width\x3d"100%"\x3e\x3ctr\x3e\x3ctd colspan\x3d"' + x + '" align\x3d"center"\x3e\x3cspan class\x3d"cke_colorbox" id\x3d"', g, '"\x3e\x3c/span\x3e', l.auto, "\x3c/td\x3e\x3c/tr\x3e\x3c/table\x3e\x3c/a\x3e"); c.push('\x3ctable role\x3d"presentation" cellspacing\x3d0 cellpadding\x3d0 width\x3d"100%"\x3e'); for (g = 0; g < w.length; g++) {
                                        0 === g % x && c.push("\x3c/tr\x3e\x3ctr\x3e");
                                        var y = w[g].split("/"), B = y[0], C = y[1] || B; c.push('\x3ctd\x3e\x3ca class\x3d"cke_colorbox" _cke_focus\x3d1 hidefocus\x3dtrue title\x3d"', y[1] ? B : a.lang.colorbutton.colors[C] || C, '" draggable\x3d"false" ondragstart\x3d"return false;" onclick\x3d"CKEDITOR.tools.callFunction(', z, ",'", C, "','", B, "','", e, "'); return false;\" href\x3d\"javascript:void('", C, '\')" data-value\x3d"' + C + '" role\x3d"option" aria-posinset\x3d"', g + 2, '" aria-setsize\x3d"', A, '"\x3e\x3cspan class\x3d"cke_colorbox" style\x3d"background-color:#',
                                            C, '"\x3e\x3c/span\x3e\x3c/a\x3e\x3c/td\x3e')
                                    } u && c.push('\x3c/tr\x3e\x3ctr\x3e\x3ctd colspan\x3d"' + x + '" align\x3d"center"\x3e\x3ca class\x3d"cke_colormore" _cke_focus\x3d1 hidefocus\x3dtrue title\x3d"', l.more, '" draggable\x3d"false" ondragstart\x3d"return false;" onclick\x3d"CKEDITOR.tools.callFunction(', z, ",'?', '?','", e, "');return false;\" href\x3d\"javascript:void('", l.more, "')\"", ' role\x3d"option" aria-posinset\x3d"', A, '" aria-setsize\x3d"', A, '"\x3e', l.more, "\x3c/a\x3e\x3c/td\x3e"); c.push("\x3c/tr\x3e\x3c/table\x3e");
                            return c.join("")
                        } function b(a) { return "false" == a.getAttribute("contentEditable") || a.getAttribute("data-nostyle") } function d(a, b) { for (var c = a._.getItems(), d = 0; d < c.count(); d++) { var e = c.getItem(d); e.removeAttribute("aria-selected"); b && b == m(e.getAttribute("data-value")) && e.setAttribute("aria-selected", !0) } } function m(a) { return CKEDITOR.tools.normalizeHex("#" + CKEDITOR.tools.convertRgbToHex(a || "")).replace(/#/g, "") } var h = a.config, l = a.lang.colorbutton; if (!CKEDITOR.env.hc) {
                            g({
                                name: "TextColor", type: "fore",
                                commandName: "textColor", title: l.textColorTitle, order: 10, contentTransformations: [[{ element: "font", check: "span{color}", left: function (a) { return !!a.attributes.color }, right: function (a) { a.name = "span"; a.attributes.color && (a.styles.color = a.attributes.color); delete a.attributes.color } }]]
                            }); var c, k = a.config.colorButton_normalizeBackground; if (void 0 === k || k) c = [[{
                                element: "span", left: function (a) {
                                    var b = CKEDITOR.tools; if ("span" != a.name || !a.styles || !a.styles.background) return !1; a = b.style.parse.background(a.styles.background);
                                    return a.color && 1 === b.object.keys(a).length
                                }, right: function (b) { var c = (new CKEDITOR.style(a.config.colorButton_backStyle, { color: b.styles.background })).getDefinition(); b.name = c.element; b.styles = c.styles; b.attributes = c.attributes || {}; return b }
                            }]]; g({ name: "BGColor", type: "back", commandName: "bgColor", title: l.bgColorTitle, order: 20, contentTransformations: c })
                        }
                    }
                }); CKEDITOR.config.colorButton_colors = "1ABC9C,2ECC71,3498DB,9B59B6,4E5F70,F1C40F,16A085,27AE60,2980B9,8E44AD,2C3E50,F39C12,E67E22,E74C3C,ECF0F1,95A5A6,DDD,FFF,D35400,C0392B,BDC3C7,7F8C8D,999,000";
        CKEDITOR.config.colorButton_foreStyle = { element: "span", styles: { color: "#(color)" }, overrides: [{ element: "font", attributes: { color: null } }] }; CKEDITOR.config.colorButton_backStyle = { element: "span", styles: { "background-color": "#(color)" } }; CKEDITOR.plugins.colordialog = {
            requires: "dialog", init: function (a) {
                var g = new CKEDITOR.dialogCommand("colordialog"); g.editorFocus = !1; a.addCommand("colordialog", g); CKEDITOR.dialog.add("colordialog", this.path + "dialogs/colordialog.js"); a.getColorFromDialog = function (e, b, d) {
                    var g,
                    h, l, c; g = function (a) { l(this); a = "ok" == a.name ? this.getValueOf("picker", "selectedColor") : null; /^[0-9a-f]{3}([0-9a-f]{3})?$/i.test(a) && (a = "#" + a); e.call(b, a) }; h = function (a) { d && (a.data = d) }; l = function (a) { a.removeListener("ok", g); a.removeListener("cancel", g); a.removeListener("show", h) }; c = function (a) { a.on("ok", g); a.on("cancel", g); a.on("show", h, null, null, 5) }; a.execCommand("colordialog"); if (a._.storedDialogs && a._.storedDialogs.colordialog) c(a._.storedDialogs.colordialog); else CKEDITOR.on("dialogDefinition", function (a) {
                        if ("colordialog" ==
                            a.data.name) { var b = a.data.definition; a.removeListener(); b.onLoad = CKEDITOR.tools.override(b.onLoad, function (a) { return function () { c(this); b.onLoad = a; "function" == typeof a && a.call(this) } }) }
                    })
                }
            }
        }; CKEDITOR.plugins.add("colordialog", CKEDITOR.plugins.colordialog); (function () {
            function a(a, b, c, d) { var f = new CKEDITOR.dom.walker(a); if (a = a.startContainer.getAscendant(b, !0) || a.endContainer.getAscendant(b, !0)) if (c(a), d) return; for (; a = f.next();)if (a = a.getAscendant(b, !0)) if (c(a), d) break } function g(a, d) {
                var c = {
                    ul: "ol",
                    ol: "ul"
                }; return -1 !== b(d, function (b) { return b.element === a || b.element === c[a] })
            } function e(a) { this.styles = null; this.sticky = !1; this.editor = a; this.filter = new CKEDITOR.filter(a, a.config.copyFormatting_allowRules); !0 === a.config.copyFormatting_allowRules && (this.filter.disabled = !0); a.config.copyFormatting_disallowRules && this.filter.disallow(a.config.copyFormatting_disallowRules) } var b = CKEDITOR.tools.indexOf, d = CKEDITOR.tools.getMouseButton, m = !1; CKEDITOR.plugins.add("copyformatting", {
                lang: "az,de,en,it,ja,nb,nl,oc,pl,pt-br,ru,sv,tr,zh,zh-cn",
                icons: "copyformatting", hidpi: !0, init: function (a) {
                    var e = CKEDITOR.plugins.copyformatting; e._addScreenReaderContainer(); m || (CKEDITOR.document.appendStyleSheet(this.path + "styles/copyformatting.css"), m = !0); a.addContentsCss && a.addContentsCss(this.path + "styles/copyformatting.css"); a.copyFormatting = new e.state(a); a.addCommand("copyFormatting", e.commands.copyFormatting); a.addCommand("applyFormatting", e.commands.applyFormatting); a.ui.addButton("CopyFormatting", {
                        label: a.lang.copyformatting.label, command: "copyFormatting",
                        toolbar: "cleanup,0"
                    }); a.on("contentDom", function () {
                        var b = a.getCommand("copyFormatting"), e = a.editable(), f = e.isInline() ? e : a.document, g = a.ui.get("CopyFormatting"); e.attachListener(f, "mouseup", function (f) { d(f) === CKEDITOR.MOUSE_BUTTON_LEFT && b.state === CKEDITOR.TRISTATE_ON && a.execCommand("applyFormatting") }); e.attachListener(CKEDITOR.document, "mouseup", function (f) { d(f) !== CKEDITOR.MOUSE_BUTTON_LEFT || b.state !== CKEDITOR.TRISTATE_ON || e.contains(f.data.getTarget()) || a.execCommand("copyFormatting") }); g && (f = CKEDITOR.document.getById(g._.id),
                            e.attachListener(f, "dblclick", function () { a.execCommand("copyFormatting", { sticky: !0 }) }), e.attachListener(f, "mouseup", function (a) { a.data.stopPropagation() }))
                    }); a.config.copyFormatting_keystrokeCopy && a.setKeystroke(a.config.copyFormatting_keystrokeCopy, "copyFormatting"); a.on("key", function (b) { var d = a.getCommand("copyFormatting"); b = b.data.domEvent; b.getKeystroke && 27 === b.getKeystroke() && d.state === CKEDITOR.TRISTATE_ON && a.execCommand("copyFormatting") }); a.copyFormatting.on("extractFormatting", function (b) {
                        var d =
                            b.data.element; if (d.contains(a.editable()) || d.equals(a.editable())) return b.cancel(); d = e._convertElementToStyleDef(d); if (!a.copyFormatting.filter.check(new CKEDITOR.style(d), !0, !0)) return b.cancel(); b.data.styleDef = d
                    }); a.copyFormatting.on("applyFormatting", function (c) {
                        if (!c.data.preventFormatStripping) {
                            var d = c.data.range, f = e._extractStylesFromRange(a, d), m = e._determineContext(d), p, t; if (a.copyFormatting._isContextAllowed(m)) for (t = 0; t < f.length; t++)m = f[t], p = d.createBookmark(), -1 === b(e.preservedElements,
                                m.element) ? CKEDITOR.env.webkit && !CKEDITOR.env.chrome ? f[t].removeFromRange(c.data.range, c.editor) : f[t].remove(c.editor) : g(m.element, c.data.styles) && e._removeStylesFromElementInRange(d, m.element), d.moveToBookmark(p)
                        }
                    }); a.copyFormatting.on("applyFormatting", function (b) {
                        var d = CKEDITOR.plugins.copyformatting, f = d._determineContext(b.data.range); "list" === f && a.copyFormatting._isContextAllowed("list") ? d._applyStylesToListContext(b.editor, b.data.range, b.data.styles) : "table" === f && a.copyFormatting._isContextAllowed("table") ?
                            d._applyStylesToTableContext(b.editor, b.data.range, b.data.styles) : a.copyFormatting._isContextAllowed("text") && d._applyStylesToTextContext(b.editor, b.data.range, b.data.styles)
                    }, null, null, 999)
                }
            }); e.prototype._isContextAllowed = function (a) { var d = this.editor.config.copyFormatting_allowedContexts; return !0 === d || -1 !== b(d, a) }; CKEDITOR.event.implementOn(e.prototype); CKEDITOR.plugins.copyformatting = {
                state: e, inlineBoundary: "h1 h2 h3 h4 h5 h6 p div".split(" "), excludedAttributes: ["id", "style", "href", "data-cke-saved-href",
                    "dir"], elementsForInlineTransform: ["li"], excludedElementsFromInlineTransform: ["table", "thead", "tbody", "ul", "ol"], excludedAttributesFromInlineTransform: ["value", "type"], preservedElements: "ul ol li td th tr thead tbody table".split(" "), breakOnElements: ["ul", "ol", "table"], _initialKeystrokePasteCommand: null, commands: {
                        copyFormatting: {
                            exec: function (a, b) {
                                var c = CKEDITOR.plugins.copyformatting, d = a.copyFormatting, f = b ? "keystrokeHandler" == b.from : !1, e = b ? b.sticky || f : !1, g = c._getCursorContainer(a), m = CKEDITOR.document.getDocumentElement();
                                if (this.state === CKEDITOR.TRISTATE_ON) return d.styles = null, d.sticky = !1, g.removeClass("cke_copyformatting_active"), m.removeClass("cke_copyformatting_disabled"), m.removeClass("cke_copyformatting_tableresize_cursor"), c._putScreenReaderMessage(a, "canceled"), c._detachPasteKeystrokeHandler(a), this.setState(CKEDITOR.TRISTATE_OFF); d.styles = c._extractStylesFromElement(a, a.elementPath().lastElement); this.setState(CKEDITOR.TRISTATE_ON); f || (g.addClass("cke_copyformatting_active"), m.addClass("cke_copyformatting_tableresize_cursor"),
                                    a.config.copyFormatting_outerCursor && m.addClass("cke_copyformatting_disabled")); d.sticky = e; c._putScreenReaderMessage(a, "copied"); c._attachPasteKeystrokeHandler(a)
                            }
                        }, applyFormatting: {
                            editorFocus: CKEDITOR.env.ie && !CKEDITOR.env.edge ? !1 : !0, exec: function (a, b) {
                                var c = a.getCommand("copyFormatting"), d = b ? "keystrokeHandler" == b.from : !1, f = CKEDITOR.plugins.copyformatting, e = a.copyFormatting, g = f._getCursorContainer(a), m = CKEDITOR.document.getDocumentElement(); if (d && !e.styles) return f._putScreenReaderMessage(a, "failed"),
                                    f._detachPasteKeystrokeHandler(a), !1; d = f._applyFormat(a, e.styles); e.sticky || (e.styles = null, g.removeClass("cke_copyformatting_active"), m.removeClass("cke_copyformatting_disabled"), m.removeClass("cke_copyformatting_tableresize_cursor"), c.setState(CKEDITOR.TRISTATE_OFF), f._detachPasteKeystrokeHandler(a)); f._putScreenReaderMessage(a, d ? "applied" : "canceled")
                            }
                        }
                    }, _getCursorContainer: function (a) { return a.elementMode === CKEDITOR.ELEMENT_MODE_INLINE ? a.editable() : a.editable().getParent() }, _convertElementToStyleDef: function (a) {
                        var b =
                            CKEDITOR.tools, c = a.getAttributes(CKEDITOR.plugins.copyformatting.excludedAttributes), b = b.parseCssText(a.getAttribute("style"), !0, !0); return { element: a.getName(), type: CKEDITOR.STYLE_INLINE, attributes: c, styles: b }
                    }, _extractStylesFromElement: function (a, d) {
                        var c = {}, e = []; do if (d.type === CKEDITOR.NODE_ELEMENT && !d.hasAttribute("data-cke-bookmark") && (c.element = d, a.copyFormatting.fire("extractFormatting", c, a) && c.styleDef && e.push(new CKEDITOR.style(c.styleDef)), d.getName && -1 !== b(CKEDITOR.plugins.copyformatting.breakOnElements,
                            d.getName()))) break; while ((d = d.getParent()) && d.type === CKEDITOR.NODE_ELEMENT); return e
                    }, _extractStylesFromRange: function (a, b) { for (var c = [], d = new CKEDITOR.dom.walker(b), f; f = d.next();)c = c.concat(CKEDITOR.plugins.copyformatting._extractStylesFromElement(a, f)); return c }, _removeStylesFromElementInRange: function (a, d) { for (var c = -1 !== b(["ol", "ul", "table"], d), e = new CKEDITOR.dom.walker(a), f; f = e.next();)if (f = f.getAscendant(d, !0)) if (f.removeAttributes(f.getAttributes()), c) break }, _getSelectedWordOffset: function (a) {
                        function d(a,
                            b) { return a[b ? "getPrevious" : "getNext"](function (a) { return a.type !== CKEDITOR.NODE_COMMENT }) } function c(a) { return a.type == CKEDITOR.NODE_ELEMENT ? (a = a.getHtml().replace(/<span.*?>&nbsp;<\/span>/g, ""), a.replace(/<.*?>/g, "")) : a.getText() } function e(a, f) {
                                var g = a, h = /\s/g, m = "p br ol ul li td th div caption body".split(" "), n = !1, y = !1, p, r; do { for (p = d(g, f); !p && g.getParent();) { g = g.getParent(); if (-1 !== b(m, g.getName())) { y = n = !0; break } p = d(g, f) } if (p && p.getName && -1 !== b(m, p.getName())) { n = !0; break } g = p } while (g && g.getStyle &&
                                    ("none" == g.getStyle("display") || !g.getText())); for (g || (g = a); g.type !== CKEDITOR.NODE_TEXT;)g = !n || f || y ? g.getChild(0) : g.getChild(g.getChildCount() - 1); for (m = c(g); null != (y = h.exec(m)) && (r = y.index, f);); if ("number" !== typeof r && !n) return e(g, f); if (n) f ? r = 0 : (h = /([\.\b]*$)/, r = (y = h.exec(m)) ? y.index : m.length); else if (f && (r += 1, r > m.length)) return e(g); return { node: g, offset: r }
                            } var f = /\b\w+\b/ig, g, m, t, q, r; t = q = r = a.startContainer; for (g = c(t); null != (m = f.exec(g));)if (m.index + m[0].length >= a.startOffset) return a = m.index, f =
                                m.index + m[0].length, 0 === m.index && (m = e(t, !0), q = m.node, a = m.offset), f >= g.length && (g = e(t), r = g.node, f = g.offset), { startNode: q, startOffset: a, endNode: r, endOffset: f }; return null
                    }, _filterStyles: function (a) { var b = CKEDITOR.tools.isEmpty, c = [], d, f; for (f = 0; f < a.length; f++)d = a[f]._.definition, -1 !== CKEDITOR.tools.indexOf(CKEDITOR.plugins.copyformatting.inlineBoundary, d.element) && (d.element = a[f].element = "span"), "span" === d.element && b(d.attributes) && b(d.styles) || c.push(a[f]); return c }, _determineContext: function (a) {
                        function b(c) {
                            var d =
                                new CKEDITOR.dom.walker(a), f; if (a.startContainer.getAscendant(c, !0) || a.endContainer.getAscendant(c, !0)) return !0; for (; f = d.next();)if (f.getAscendant(c, !0)) return !0
                        } return b({ ul: 1, ol: 1 }) ? "list" : b("table") ? "table" : "text"
                    }, _applyStylesToTextContext: function (a, d, c) {
                        var e = CKEDITOR.plugins.copyformatting, f = e.excludedAttributesFromInlineTransform, g, m; CKEDITOR.env.webkit && !CKEDITOR.env.chrome && a.getSelection().selectRanges([d]); for (g = 0; g < c.length; g++)if (d = c[g], -1 === b(e.excludedElementsFromInlineTransform, d.element)) {
                            if (-1 !==
                                b(e.elementsForInlineTransform, d.element)) for (d.element = d._.definition.element = "span", m = 0; m < f.length; m++)d._.definition.attributes[f[m]] && delete d._.definition.attributes[f[m]]; d.apply(a)
                        }
                    }, _applyStylesToListContext: function (b, d, c) {
                        var e, f, g; for (g = 0; g < c.length; g++)e = c[g], f = d.createBookmark(), "ol" === e.element || "ul" === e.element ? a(d, { ul: 1, ol: 1 }, function (a) { var b = e; a.getName() !== b.element && a.renameNode(b.element); b.applyToObject(a) }, !0) : "li" === e.element ? a(d, "li", function (a) { e.applyToObject(a) }) : CKEDITOR.plugins.copyformatting._applyStylesToTextContext(b,
                            d, [e]), d.moveToBookmark(f)
                    }, _applyStylesToTableContext: function (d, e, c) {
                        function g(a, b) { a.getName() !== b.element && (b = b.getDefinition(), b.element = a.getName(), b = new CKEDITOR.style(b)); b.applyToObject(a) } var f, m, p; for (p = 0; p < c.length; p++)f = c[p], m = e.createBookmark(), -1 !== b(["table", "tr"], f.element) ? a(e, f.element, function (a) { f.applyToObject(a) }) : -1 !== b(["td", "th"], f.element) ? a(e, { td: 1, th: 1 }, function (a) { g(a, f) }) : -1 !== b(["thead", "tbody"], f.element) ? a(e, { thead: 1, tbody: 1 }, function (a) { g(a, f) }) : CKEDITOR.plugins.copyformatting._applyStylesToTextContext(d,
                            e, [f]), e.moveToBookmark(m)
                    }, _applyFormat: function (a, b) {
                        var c = a.getSelection().getRanges()[0], d = CKEDITOR.plugins.copyformatting, f, e; if (!c) return !1; if (c.collapsed) { e = a.getSelection().createBookmarks(); if (!(f = d._getSelectedWordOffset(c))) return; c = a.createRange(); c.setStart(f.startNode, f.startOffset); c.setEnd(f.endNode, f.endOffset); c.select() } b = d._filterStyles(b); if (!a.copyFormatting.fire("applyFormatting", { styles: b, range: c, preventFormatStripping: !1 }, a)) return !1; e && a.getSelection().selectBookmarks(e);
                        return !0
                    }, _putScreenReaderMessage: function (a, b) { var c = this._getScreenReaderContainer(); c && c.setText(a.lang.copyformatting.notification[b]) }, _addScreenReaderContainer: function () { if (this._getScreenReaderContainer()) return this._getScreenReaderContainer(); if (!CKEDITOR.env.ie6Compat && !CKEDITOR.env.ie7Compat) return CKEDITOR.document.getBody().append(CKEDITOR.dom.element.createFromHtml('\x3cdiv class\x3d"cke_screen_reader_only cke_copyformatting_notification"\x3e\x3cdiv aria-live\x3d"polite"\x3e\x3c/div\x3e\x3c/div\x3e')).getChild(0) },
                _getScreenReaderContainer: function () { if (!CKEDITOR.env.ie6Compat && !CKEDITOR.env.ie7Compat) return CKEDITOR.document.getBody().findOne(".cke_copyformatting_notification div[aria-live]") }, _attachPasteKeystrokeHandler: function (a) { var b = a.config.copyFormatting_keystrokePaste; b && (this._initialKeystrokePasteCommand = a.keystrokeHandler.keystrokes[b], a.setKeystroke(b, "applyFormatting")) }, _detachPasteKeystrokeHandler: function (a) {
                    var b = a.config.copyFormatting_keystrokePaste; b && a.setKeystroke(b, this._initialKeystrokePasteCommand ||
                        !1)
                }
            }; CKEDITOR.config.copyFormatting_outerCursor = !0; CKEDITOR.config.copyFormatting_allowRules = "b s u i em strong span p div td th ol ul li(*)[*]{*}"; CKEDITOR.config.copyFormatting_disallowRules = "*[data-cke-widget*,data-widget*,data-cke-realelement](cke_widget*)"; CKEDITOR.config.copyFormatting_allowedContexts = !0; CKEDITOR.config.copyFormatting_keystrokeCopy = CKEDITOR.CTRL + CKEDITOR.SHIFT + 67; CKEDITOR.config.copyFormatting_keystrokePaste = CKEDITOR.CTRL + CKEDITOR.SHIFT + 86
        })(); CKEDITOR.plugins.add("menu", {
            requires: "floatpanel",
            beforeInit: function (a) { for (var g = a.config.menu_groups.split(","), e = a._.menuGroups = {}, b = a._.menuItems = {}, d = 0; d < g.length; d++)e[g[d]] = d + 1; a.addMenuGroup = function (a, b) { e[a] = b || 100 }; a.addMenuItem = function (a, d) { e[d.group] && (b[a] = new CKEDITOR.menuItem(this, a, d)) }; a.addMenuItems = function (a) { for (var b in a) this.addMenuItem(b, a[b]) }; a.getMenuItem = function (a) { return b[a] }; a.removeMenuItem = function (a) { delete b[a] } }
        }); (function () {
            function a(a) {
                a.sort(function (a, b) {
                    return a.group < b.group ? -1 : a.group > b.group ? 1 : a.order <
                        b.order ? -1 : a.order > b.order ? 1 : 0
                })
            } var g = '\x3cspan class\x3d"cke_menuitem"\x3e\x3ca id\x3d"{id}" class\x3d"cke_menubutton cke_menubutton__{name} cke_menubutton_{state} {cls}" href\x3d"{href}" title\x3d"{title}" tabindex\x3d"-1" _cke_focus\x3d1 hidefocus\x3d"true" role\x3d"{role}" aria-label\x3d"{attrLabel}" aria-describedby\x3d"{id}_description" aria-haspopup\x3d"{hasPopup}" aria-disabled\x3d"{disabled}" {ariaChecked} draggable\x3d"false"', e = ""; CKEDITOR.env.gecko && CKEDITOR.env.mac && (g += ' onkeypress\x3d"return false;"');
            CKEDITOR.env.gecko && (g += ' onblur\x3d"this.style.cssText \x3d this.style.cssText;" ondragstart\x3d"return false;"'); CKEDITOR.env.ie && (e = 'return false;" onmouseup\x3d"CKEDITOR.tools.getMouseButton(event)\x3d\x3d\x3dCKEDITOR.MOUSE_BUTTON_LEFT\x26\x26'); var g = g + (' onmouseover\x3d"CKEDITOR.tools.callFunction({hoverFn},{index});" onmouseout\x3d"CKEDITOR.tools.callFunction({moveOutFn},{index});" onclick\x3d"' + e + 'CKEDITOR.tools.callFunction({clickFn},{index}); return false;"\x3e') + '\x3cspan class\x3d"cke_menubutton_inner"\x3e\x3cspan class\x3d"cke_menubutton_icon"\x3e\x3cspan class\x3d"cke_button_icon cke_button__{iconName}_icon" style\x3d"{iconStyle}"\x3e\x3c/span\x3e\x3c/span\x3e\x3cspan class\x3d"cke_menubutton_label"\x3e{label}\x3c/span\x3e{shortcutHtml}{arrowHtml}\x3c/span\x3e\x3c/a\x3e\x3cspan id\x3d"{id}_description" class\x3d"cke_voice_label" aria-hidden\x3d"false"\x3e{ariaShortcut}\x3c/span\x3e\x3c/span\x3e',
                b = CKEDITOR.addTemplate("menuItem", g), d = CKEDITOR.addTemplate("menuArrow", '\x3cspan class\x3d"cke_menuarrow"\x3e\x3cspan\x3e{label}\x3c/span\x3e\x3c/span\x3e'), m = CKEDITOR.addTemplate("menuShortcut", '\x3cspan class\x3d"cke_menubutton_label cke_menubutton_shortcut"\x3e{shortcut}\x3c/span\x3e'); CKEDITOR.menu = CKEDITOR.tools.createClass({
                    $: function (a, b) {
                        b = this._.definition = b || {}; this.id = CKEDITOR.tools.getNextId(); this.editor = a; this.items = []; this._.listeners = []; this._.level = b.level || 1; var c = CKEDITOR.tools.extend({},
                            b.panel, { css: [CKEDITOR.skin.getPath("editor")], level: this._.level - 1, block: {} }), d = c.block.attributes = c.attributes || {}; !d.role && (d.role = "menu"); this._.panelDefinition = c
                    }, _: {
                        onShow: function () { var a = this.editor.getSelection(), b = a && a.getStartElement(), c = this.editor.elementPath(), d = this._.listeners; this.removeAll(); for (var f = 0; f < d.length; f++) { var e = d[f](b, a, c); if (e) for (var g in e) { var m = this.editor.getMenuItem(g); !m || m.command && !this.editor.getCommand(m.command).state || (m.state = e[g], this.add(m)) } } }, onClick: function (a) {
                            this.hide();
                            if (a.onClick) a.onClick(); else a.command && this.editor.execCommand(a.command)
                        }, onEscape: function (a) { var b = this.parent; b ? b._.panel.hideChild(1) : 27 == a && this.hide(1); return !1 }, onHide: function () { this.onHide && this.onHide() }, showSubMenu: function (a) {
                            var b = this._.subMenu, c = this.items[a]; if (c = c.getItems && c.getItems()) {
                                b ? b.removeAll() : (b = this._.subMenu = new CKEDITOR.menu(this.editor, CKEDITOR.tools.extend({}, this._.definition, { level: this._.level + 1 }, !0)), b.parent = this, b._.onClick = CKEDITOR.tools.bind(this._.onClick,
                                    this)); for (var d in c) { var e = this.editor.getMenuItem(d); e && (e.state = c[d], b.add(e)) } var g = this._.panel.getBlock(this.id).element.getDocument().getById(this.id + String(a)); setTimeout(function () { b.show(g, 2) }, 0)
                            } else this._.panel.hideChild(1)
                        }
                    }, proto: {
                        add: function (a) { a.order || (a.order = this.items.length); this.items.push(a) }, removeAll: function () { this.items = [] }, show: function (b, d, c, e) {
                            if (!this.parent && (this._.onShow(), !this.items.length)) return; d = d || ("rtl" == this.editor.lang.dir ? 2 : 1); var f = this.items, g = this.editor,
                                m = this._.panel, t = this._.element; if (!m) {
                                    m = this._.panel = new CKEDITOR.ui.floatPanel(this.editor, CKEDITOR.document.getBody(), this._.panelDefinition, this._.level); m.onEscape = CKEDITOR.tools.bind(function (a) { if (!1 === this._.onEscape(a)) return !1 }, this); m.onShow = function () { m._.panel.getHolderElement().getParent().addClass("cke").addClass("cke_reset_all") }; m.onHide = CKEDITOR.tools.bind(function () { this._.onHide && this._.onHide() }, this); t = m.addBlock(this.id, this._.panelDefinition.block); t.autoSize = !0; var q = t.keys;
                                    q[40] = "next"; q[9] = "next"; q[38] = "prev"; q[CKEDITOR.SHIFT + 9] = "prev"; q["rtl" == g.lang.dir ? 37 : 39] = CKEDITOR.env.ie ? "mouseup" : "click"; q[32] = CKEDITOR.env.ie ? "mouseup" : "click"; CKEDITOR.env.ie && (q[13] = "mouseup"); t = this._.element = t.element; q = t.getDocument(); q.getBody().setStyle("overflow", "hidden"); q.getElementsByTag("html").getItem(0).setStyle("overflow", "hidden"); this._.itemOverFn = CKEDITOR.tools.addFunction(function (a) {
                                        clearTimeout(this._.showSubTimeout); this._.showSubTimeout = CKEDITOR.tools.setTimeout(this._.showSubMenu,
                                            g.config.menu_subMenuDelay || 400, this, [a])
                                    }, this); this._.itemOutFn = CKEDITOR.tools.addFunction(function () { clearTimeout(this._.showSubTimeout) }, this); this._.itemClickFn = CKEDITOR.tools.addFunction(function (a) { var b = this.items[a]; if (b.state == CKEDITOR.TRISTATE_DISABLED) this.hide(1); else if (b.getItems) this._.showSubMenu(a); else this._.onClick(b) }, this)
                                } a(f); for (var q = g.elementPath(), q = ['\x3cdiv class\x3d"cke_menu' + (q && q.direction() != g.lang.dir ? " cke_mixed_dir_content" : "") + '" role\x3d"presentation"\x3e'],
                                    r = f.length, w = r && f[0].group, x = 0; x < r; x++) { var u = f[x]; w != u.group && (q.push('\x3cdiv class\x3d"cke_menuseparator" role\x3d"separator"\x3e\x3c/div\x3e'), w = u.group); u.render(this, x, q) } q.push("\x3c/div\x3e"); t.setHtml(q.join("")); CKEDITOR.ui.fire("ready", this); this.parent ? this.parent._.panel.showAsChild(m, this.id, b, d, c, e) : m.showBlock(this.id, b, d, c, e); g.fire("menuShow", [m])
                        }, addListener: function (a) { this._.listeners.push(a) }, hide: function (a) { this._.onHide && this._.onHide(); this._.panel && this._.panel.hide(a) },
                        findItemByCommandName: function (a) { var b = CKEDITOR.tools.array.filter(this.items, function (b) { return a === b.command }); return b.length ? (b = b[0], { item: b, element: this._.element.findOne("." + b.className) }) : null }
                    }
                }); CKEDITOR.menuItem = CKEDITOR.tools.createClass({
                    $: function (a, b, c) { CKEDITOR.tools.extend(this, c, { order: 0, className: "cke_menubutton__" + b }); this.group = a._.menuGroups[this.group]; this.editor = a; this.name = b }, proto: {
                        render: function (a, e, c) {
                            var g = a.id + String(e), f = "undefined" == typeof this.state ? CKEDITOR.TRISTATE_OFF :
                                this.state, n = "", p = this.editor, t, q, r = f == CKEDITOR.TRISTATE_ON ? "on" : f == CKEDITOR.TRISTATE_DISABLED ? "disabled" : "off"; this.role in { menuitemcheckbox: 1, menuitemradio: 1 } && (n = ' aria-checked\x3d"' + (f == CKEDITOR.TRISTATE_ON ? "true" : "false") + '"'); var w = this.getItems, x = "\x26#" + ("rtl" == this.editor.lang.dir ? "9668" : "9658") + ";", u = this.name; this.icon && !/\./.test(this.icon) && (u = this.icon); this.command && (t = p.getCommand(this.command), (t = p.getCommandKeystroke(t)) && (q = CKEDITOR.tools.keystrokeToString(p.lang.common.keyboard,
                                    t))); t = CKEDITOR.tools.htmlEncodeAttr(this.label); a = {
                                        id: g, name: this.name, iconName: u, label: this.label, attrLabel: t, cls: this.className || "", state: r, hasPopup: w ? "true" : "false", disabled: f == CKEDITOR.TRISTATE_DISABLED, title: t + (q ? " (" + q.display + ")" : ""), ariaShortcut: q ? p.lang.common.keyboardShortcut + " " + q.aria : "", href: "javascript:void('" + (t || "").replace("'") + "')", hoverFn: a._.itemOverFn, moveOutFn: a._.itemOutFn, clickFn: a._.itemClickFn, index: e, iconStyle: CKEDITOR.skin.getIconStyle(u, "rtl" == this.editor.lang.dir, u ==
                                            this.icon ? null : this.icon, this.iconOffset), shortcutHtml: q ? m.output({ shortcut: q.display }) : "", arrowHtml: w ? d.output({ label: x }) : "", role: this.role ? this.role : "menuitem", ariaChecked: n
                                    }; b.output(a, c)
                        }
                    }
                })
        })(); CKEDITOR.config.menu_groups = "clipboard,form,tablecell,tablecellproperties,tablerow,tablecolumn,table,anchor,link,image,flash,checkbox,radio,textfield,hiddenfield,imagebutton,button,select,textarea,div"; CKEDITOR.plugins.add("contextmenu", {
            requires: "menu", onLoad: function () {
                CKEDITOR.plugins.contextMenu = CKEDITOR.tools.createClass({
                    base: CKEDITOR.menu,
                    $: function (a) { this.base.call(this, a, { panel: { css: a.config.contextmenu_contentsCss, className: "cke_menu_panel", attributes: { "aria-label": a.lang.contextmenu.options } } }) }, proto: {
                        addTarget: function (a, g) {
                            function e() { d = !1 } var b, d; a.on("contextmenu", function (a) {
                                a = a.data; var e = CKEDITOR.env.webkit ? b : CKEDITOR.env.mac ? a.$.metaKey : a.$.ctrlKey; if (!g || !e) if (a.preventDefault(), !d) {
                                    if (CKEDITOR.env.mac && CKEDITOR.env.webkit) {
                                        var e = this.editor, c = (new CKEDITOR.dom.elementPath(a.getTarget(), e.editable())).contains(function (a) { return a.hasAttribute("contenteditable") },
                                            !0); c && "false" == c.getAttribute("contenteditable") && e.getSelection().fake(c)
                                    } var c = a.getTarget().getDocument(), k = a.getTarget().getDocument().getDocumentElement(), e = !c.equals(CKEDITOR.document), c = c.getWindow().getScrollPosition(), f = e ? a.$.clientX : a.$.pageX || c.x + a.$.clientX, m = e ? a.$.clientY : a.$.pageY || c.y + a.$.clientY; CKEDITOR.tools.setTimeout(function () { this.open(k, null, f, m) }, CKEDITOR.env.ie ? 200 : 0, this)
                                }
                            }, this); if (CKEDITOR.env.webkit) {
                                var m = function () { b = 0 }; a.on("keydown", function (a) {
                                    b = CKEDITOR.env.mac ?
                                        a.data.$.metaKey : a.data.$.ctrlKey
                                }); a.on("keyup", m); a.on("contextmenu", m)
                            } CKEDITOR.env.gecko && !CKEDITOR.env.mac && (a.on("keydown", function (a) { a.data.$.shiftKey && 121 === a.data.$.keyCode && (d = !0) }, null, null, 0), a.on("keyup", e), a.on("contextmenu", e))
                        }, open: function (a, g, e, b) { !1 !== this.editor.config.enableContextMenu && this.editor.getSelection().getType() !== CKEDITOR.SELECTION_NONE && (this.editor.focus(), a = a || CKEDITOR.document.getDocumentElement(), this.editor.selectionChange(1), this.show(a, g, e, b)) }
                    }
                })
            }, beforeInit: function (a) {
                var g =
                    a.contextMenu = new CKEDITOR.plugins.contextMenu(a); a.on("contentDom", function () { g.addTarget(a.editable(), !1 !== a.config.browserContextMenuOnCtrl) }); a.addCommand("contextMenu", { exec: function (a) { var b = 0, d = 0, g = a.getSelection().getRanges(), g = g[g.length - 1].getClientRects(a.editable().isInline()); if (g = g[g.length - 1]) b = g["rtl" === a.lang.dir ? "left" : "right"], d = g.bottom; a.contextMenu.open(a.document.getBody().getParent(), null, b, d) } }); a.setKeystroke(CKEDITOR.SHIFT + 121, "contextMenu"); a.setKeystroke(CKEDITOR.CTRL +
                        CKEDITOR.SHIFT + 121, "contextMenu")
            }
        }); (function () {
            function a(a) { var d = this.att; a = a && a.hasAttribute(d) && a.getAttribute(d) || ""; void 0 !== a && this.setValue(a) } function g() { for (var a, d = 0; d < arguments.length; d++)if (arguments[d] instanceof CKEDITOR.dom.element) { a = arguments[d]; break } if (a) { var d = this.att, e = this.getValue(); e ? a.setAttribute(d, e) : a.removeAttribute(d, e) } } var e = { id: 1, dir: 1, classes: 1, styles: 1 }; CKEDITOR.plugins.add("dialogadvtab", {
                requires: "dialog", allowedContent: function (a) {
                    a || (a = e); var d = []; a.id &&
                        d.push("id"); a.dir && d.push("dir"); var g = ""; d.length && (g += "[" + d.join(",") + "]"); a.classes && (g += "(*)"); a.styles && (g += "{*}"); return g
                }, createAdvancedTab: function (b, d, m) {
                    d || (d = e); var h = b.lang.common, l = { id: "advanced", label: h.advancedTab, title: h.advancedTab, elements: [{ type: "vbox", padding: 1, children: [] }] }, c = []; if (d.id || d.dir) d.id && c.push({ id: "advId", att: "id", type: "text", requiredContent: m ? m + "[id]" : null, label: h.id, setup: a, commit: g }), d.dir && c.push({
                        id: "advLangDir", att: "dir", type: "select", requiredContent: m ? m +
                            "[dir]" : null, label: h.langDir, "default": "", style: "width:100%", items: [[h.notSet, ""], [h.langDirLTR, "ltr"], [h.langDirRTL, "rtl"]], setup: a, commit: g
                    }), l.elements[0].children.push({ type: "hbox", widths: ["50%", "50%"], children: [].concat(c) }); if (d.styles || d.classes) c = [], d.styles && c.push({
                        id: "advStyles", att: "style", type: "text", requiredContent: m ? m + "{cke-xyz}" : null, label: h.styles, "default": "", validate: CKEDITOR.dialog.validate.inlineStyle(h.invalidInlineStyle), onChange: function () { }, getStyle: function (a, b) {
                            var c = this.getValue().match(new RegExp("(?:^|;)\\s*" +
                                a + "\\s*:\\s*([^;]*)", "i")); return c ? c[1] : b
                        }, updateStyle: function (a, c) { var d = this.getValue(), e = b.document.createElement("span"); e.setAttribute("style", d); e.setStyle(a, c); d = CKEDITOR.tools.normalizeCssText(e.getAttribute("style")); this.setValue(d, 1) }, setup: a, commit: g
                    }), d.classes && c.push({ type: "hbox", widths: ["45%", "55%"], children: [{ id: "advCSSClasses", att: "class", type: "text", requiredContent: m ? m + "(cke-xyz)" : null, label: h.cssClasses, "default": "", setup: a, commit: g }] }), l.elements[0].children.push({
                        type: "hbox",
                        widths: ["50%", "50%"], children: [].concat(c)
                    }); return l
                }
            })
        })(); (function () {
            CKEDITOR.plugins.add("div", {
                requires: "dialog", init: function (a) {
                    if (!a.blockless) {
                        var g = a.lang.div, e = "div(*)"; CKEDITOR.dialog.isTabEnabled(a, "editdiv", "advanced") && (e += ";div[dir,id,lang,title]{*}"); a.addCommand("creatediv", new CKEDITOR.dialogCommand("creatediv", {
                            allowedContent: e, requiredContent: "div", contextSensitive: !0, contentTransformations: [["div: alignmentToStyle"]], refresh: function (a, d) {
                                this.setState("div" in (a.config.div_wrapTable ?
                                    d.root : d.blockLimit).getDtd() ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED)
                            }
                        })); a.addCommand("editdiv", new CKEDITOR.dialogCommand("editdiv", { requiredContent: "div" })); a.addCommand("removediv", {
                            requiredContent: "div", exec: function (a) {
                                function d(c) { (c = CKEDITOR.plugins.div.getSurroundDiv(a, c)) && !c.data("cke-div-added") && (k.push(c), c.data("cke-div-added")) } for (var e = a.getSelection(), g = e && e.getRanges(), l, c = e.createBookmarks(), k = [], f = 0; f < g.length; f++)l = g[f], l.collapsed ? d(e.getStartElement()) : (l = new CKEDITOR.dom.walker(l),
                                    l.evaluator = d, l.lastForward()); for (f = 0; f < k.length; f++)k[f].remove(!0); e.selectBookmarks(c)
                            }
                        }); a.ui.addButton && a.ui.addButton("CreateDiv", { label: g.toolbar, command: "creatediv", toolbar: "blocks,50" }); a.addMenuItems && (a.addMenuItems({ editdiv: { label: g.edit, command: "editdiv", group: "div", order: 1 }, removediv: { label: g.remove, command: "removediv", group: "div", order: 5 } }), a.contextMenu && a.contextMenu.addListener(function (b) {
                            return !b || b.isReadOnly() ? null : CKEDITOR.plugins.div.getSurroundDiv(a) ? {
                                editdiv: CKEDITOR.TRISTATE_OFF,
                                removediv: CKEDITOR.TRISTATE_OFF
                            } : null
                        })); CKEDITOR.dialog.add("creatediv", this.path + "dialogs/div.js"); CKEDITOR.dialog.add("editdiv", this.path + "dialogs/div.js")
                    }
                }
            }); CKEDITOR.plugins.div = { getSurroundDiv: function (a, g) { var e = a.elementPath(g); return a.elementPath(e.blockLimit).contains(function (a) { return a.is("div") && !a.isReadOnly() }, 1) } }
        })(); (function () {
            function a(a, e) {
                function h(b) {
                    b = f.list[b]; var c; b.equals(a.editable()) || "true" == b.getAttribute("contenteditable") ? (c = a.createRange(), c.selectNodeContents(b),
                        c = c.select()) : (c = a.getSelection(), c.selectElement(b)); CKEDITOR.env.ie && a.fire("selectionChange", { selection: c, path: new CKEDITOR.dom.elementPath(b) }); a.focus()
                } function l() { k && k.setHtml('\x3cspan class\x3d"cke_path_empty"\x3e\x26nbsp;\x3c/span\x3e'); delete f.list } var c = a.ui.spaceId("path"), k, f = a._.elementsPath, n = f.idBase; e.html += '\x3cspan id\x3d"' + c + '_label" class\x3d"cke_voice_label"\x3e' + a.lang.elementspath.eleLabel + '\x3c/span\x3e\x3cspan id\x3d"' + c + '" class\x3d"cke_path" role\x3d"group" aria-labelledby\x3d"' +
                    c + '_label"\x3e\x3cspan class\x3d"cke_path_empty"\x3e\x26nbsp;\x3c/span\x3e\x3c/span\x3e'; a.on("uiReady", function () { var b = a.ui.space("path"); b && a.focusManager.add(b, 1) }); f.onClick = h; var p = CKEDITOR.tools.addFunction(h), t = CKEDITOR.tools.addFunction(function (b, c) {
                        var e = f.idBase, g; c = new CKEDITOR.dom.event(c); g = "rtl" == a.lang.dir; switch (c.getKeystroke()) {
                            case g ? 39 : 37: case 9: return (g = CKEDITOR.document.getById(e + (b + 1))) || (g = CKEDITOR.document.getById(e + "0")), g.focus(), !1; case g ? 37 : 39: case CKEDITOR.SHIFT + 9: return (g =
                                CKEDITOR.document.getById(e + (b - 1))) || (g = CKEDITOR.document.getById(e + (f.list.length - 1))), g.focus(), !1; case 27: return a.focus(), !1; case 13: case 32: return h(b), !1
                        }return !0
                    }); a.on("selectionChange", function (e) {
                        for (var g = [], h = f.list = [], l = [], m = f.filters, A = !0, v = e.data.path.elements, z = v.length; z--;) {
                            var y = v[z], B = 0; e = y.data("cke-display-name") ? y.data("cke-display-name") : y.data("cke-real-element-type") ? y.data("cke-real-element-type") : y.getName(); (A = y.hasAttribute("contenteditable") ? "true" == y.getAttribute("contenteditable") :
                                A) || y.hasAttribute("contenteditable") || (B = 1); for (var C = 0; C < m.length; C++) { var F = m[C](y, e); if (!1 === F) { B = 1; break } e = F || e } B || (h.unshift(y), l.unshift(e))
                        } h = h.length; for (m = 0; m < h; m++)e = l[m], A = a.lang.elementspath.eleTitle.replace(/%1/, e), e = b.output({ id: n + m, label: A, text: e, jsTitle: "javascript:void('" + e + "')", index: m, keyDownFn: t, clickFn: p }), g.unshift(e); k || (k = CKEDITOR.document.getById(c)); l = k; l.setHtml(g.join("") + '\x3cspan class\x3d"cke_path_empty"\x3e\x26nbsp;\x3c/span\x3e'); a.fire("elementsPathUpdate", { space: l })
                    });
                a.on("readOnly", l); a.on("contentDomUnload", l); a.addCommand("elementsPathFocus", g.toolbarFocus); a.setKeystroke(CKEDITOR.ALT + 122, "elementsPathFocus")
            } var g = { toolbarFocus: { editorFocus: !1, readOnly: 1, exec: function (a) { (a = CKEDITOR.document.getById(a._.elementsPath.idBase + "0")) && a.focus(CKEDITOR.env.ie || CKEDITOR.env.air) } } }, e = ""; CKEDITOR.env.gecko && CKEDITOR.env.mac && (e += ' onkeypress\x3d"return false;"'); CKEDITOR.env.gecko && (e += ' onblur\x3d"this.style.cssText \x3d this.style.cssText;"'); var b = CKEDITOR.addTemplate("pathItem",
                '\x3ca id\x3d"{id}" href\x3d"{jsTitle}" tabindex\x3d"-1" class\x3d"cke_path_item" title\x3d"{label}"' + e + ' hidefocus\x3d"true"  draggable\x3d"false"  ondragstart\x3d"return false;" onkeydown\x3d"return CKEDITOR.tools.callFunction({keyDownFn},{index}, event );" onclick\x3d"CKEDITOR.tools.callFunction({clickFn},{index}); return false;" role\x3d"button" aria-label\x3d"{label}"\x3e{text}\x3c/a\x3e'); CKEDITOR.plugins.add("elementspath", {
                    init: function (b) {
                        b._.elementsPath = {
                            idBase: "cke_elementspath_" + CKEDITOR.tools.getNextNumber() +
                                "_", filters: []
                        }; b.on("uiSpace", function (e) { "bottom" == e.data.space && a(b, e.data) })
                    }
                })
        })(); (function () {
            function a(a, b, c) { c = a.config.forceEnterMode || c; if ("wysiwyg" == a.mode) { b || (b = a.activeEnterMode); var d = a.elementPath(); d && !d.isContextFor("p") && (b = CKEDITOR.ENTER_BR, c = 1); a.fire("saveSnapshot"); b == CKEDITOR.ENTER_BR ? h(a, b, null, c) : l(a, b, null, c); a.fire("saveSnapshot") } } function g(a) { a = a.getSelection().getRanges(!0); for (var b = a.length - 1; 0 < b; b--)a[b].deleteContents(); return a[0] } function e(a) {
                var b = a.startContainer.getAscendant(function (a) {
                    return a.type ==
                        CKEDITOR.NODE_ELEMENT && "true" == a.getAttribute("contenteditable")
                }, !0); if (a.root.equals(b)) return a; b = new CKEDITOR.dom.range(b); b.moveToRange(a); return b
            } CKEDITOR.plugins.add("enterkey", { init: function (b) { b.addCommand("enter", { modes: { wysiwyg: 1 }, editorFocus: !1, exec: function (b) { a(b) } }); b.addCommand("shiftEnter", { modes: { wysiwyg: 1 }, editorFocus: !1, exec: function (b) { a(b, b.activeShiftEnterMode, 1) } }); b.setKeystroke([[13, "enter"], [CKEDITOR.SHIFT + 13, "shiftEnter"]]) } }); var b = CKEDITOR.dom.walker.whitespaces(), d =
                CKEDITOR.dom.walker.bookmark(), m, h, l, c; CKEDITOR.plugins.enterkey = {
                    enterBlock: function (a, f, l, m) {
                        function t(a) { var b; if (a === CKEDITOR.ENTER_BR || -1 === CKEDITOR.tools.indexOf(["td", "th"], x.lastElement.getName()) || 1 !== x.lastElement.getChildCount()) return !1; a = x.lastElement.getChild(0).clone(!0); (b = a.getBogus()) && b.remove(); return a.getText().length ? !1 : !0 } if (l = l || g(a)) {
                            l = e(l); var q = l.document, r = l.checkStartOfBlock(), w = l.checkEndOfBlock(), x = a.elementPath(l.startContainer), u = x.block, A = f == CKEDITOR.ENTER_DIV ?
                                "div" : "p", v; if (u && r && w) {
                                    r = u.getParent(); if (r.is("li") && 1 < r.getChildCount()) { q = new CKEDITOR.dom.element("li"); v = a.createRange(); q.insertAfter(r); u.remove(); v.setStart(q, 0); a.getSelection().selectRanges([v]); return } if (u.is("li") || u.getParent().is("li")) {
                                        u.is("li") || (u = u.getParent(), r = u.getParent()); v = r.getParent(); l = !u.hasPrevious(); var z = !u.hasNext(); m = a.getSelection(); var A = m.createBookmarks(), y = u.getDirection(1), w = u.getAttribute("class"), B = u.getAttribute("style"), C = v.getDirection(1) != y; a = a.enterMode !=
                                            CKEDITOR.ENTER_BR || C || B || w; if (v.is("li")) l || z ? (l && z && r.remove(), u[z ? "insertAfter" : "insertBefore"](v)) : u.breakParent(v); else {
                                                if (a) if (x.block.is("li") ? (v = q.createElement(f == CKEDITOR.ENTER_P ? "p" : "div"), C && v.setAttribute("dir", y), B && v.setAttribute("style", B), w && v.setAttribute("class", w), u.moveChildren(v)) : v = x.block, l || z) v[l ? "insertBefore" : "insertAfter"](r); else u.breakParent(r), v.insertAfter(r); else if (u.appendBogus(!0), l || z) for (; q = u[l ? "getFirst" : "getLast"]();)q[l ? "insertBefore" : "insertAfter"](r); else for (u.breakParent(r); q =
                                                    u.getLast();)q.insertAfter(r); u.remove()
                                            } m.selectBookmarks(A); return
                                    } if (u && u.getParent().is("blockquote")) { u.breakParent(u.getParent()); u.getPrevious().getFirst(CKEDITOR.dom.walker.invisible(1)) || u.getPrevious().remove(); u.getNext().getFirst(CKEDITOR.dom.walker.invisible(1)) || u.getNext().remove(); l.moveToElementEditStart(u); l.select(); return }
                                } else if (u && u.is("pre") && !w) { h(a, f, l, m); return } if (B = l.splitBlock(A)) {
                                    a = B.previousBlock; u = B.nextBlock; r = B.wasStartOfBlock; w = B.wasEndOfBlock; u ? (z = u.getParent(),
                                        z.is("li") && (u.breakParent(z), u.move(u.getNext(), 1))) : a && (z = a.getParent()) && z.is("li") && (a.breakParent(z), z = a.getNext(), l.moveToElementEditStart(z), a.move(a.getPrevious())); if (r || w) if (t(f)) l.moveToElementEditStart(l.getTouchedStartNode()); else {
                                            if (a) { if (a.is("li") || !c.test(a.getName()) && !a.is("pre")) v = a.clone() } else u && (v = u.clone()); v ? m && !v.is("li") && v.renameNode(A) : z && z.is("li") ? v = z : (v = q.createElement(A), a && (y = a.getDirection()) && v.setAttribute("dir", y)); if (q = B.elementPath) for (f = 0, m = q.elements.length; f <
                                                m; f++) { A = q.elements[f]; if (A.equals(q.block) || A.equals(q.blockLimit)) break; CKEDITOR.dtd.$removeEmpty[A.getName()] && (A = A.clone(), v.moveChildren(A), v.append(A)) } v.appendBogus(); v.getParent() || l.insertNode(v); v.is("li") && v.removeAttribute("value"); !CKEDITOR.env.ie || !r || w && a.getChildCount() || (l.moveToElementEditStart(w ? a : v), l.select()); l.moveToElementEditStart(r && !w ? u : v)
                                        } else u.is("li") && (v = l.clone(), v.selectNodeContents(u), v = new CKEDITOR.dom.walker(v), v.evaluator = function (a) {
                                            return !(d(a) || b(a) || a.type ==
                                                CKEDITOR.NODE_ELEMENT && a.getName() in CKEDITOR.dtd.$inline && !(a.getName() in CKEDITOR.dtd.$empty))
                                        }, (z = v.next()) && z.type == CKEDITOR.NODE_ELEMENT && z.is("ul", "ol") && (CKEDITOR.env.needsBrFiller ? q.createElement("br") : q.createText(" ")).insertBefore(z)), u && l.moveToElementEditStart(u); l.select(); l.scrollIntoView()
                                }
                        }
                    }, enterBr: function (a, b, d, e) {
                        if (d = d || g(a)) {
                            var h = d.document, m = d.checkEndOfBlock(), r = new CKEDITOR.dom.elementPath(a.getSelection().getStartElement()), w = r.block, x = w && r.block.getName(); e || "li" != x ? (!e &&
                                m && c.test(x) ? (m = w.getDirection()) ? (h = h.createElement("div"), h.setAttribute("dir", m), h.insertAfter(w), d.setStart(h, 0)) : (h.createElement("br").insertAfter(w), CKEDITOR.env.gecko && h.createText("").insertAfter(w), d.setStartAt(w.getNext(), CKEDITOR.env.ie ? CKEDITOR.POSITION_BEFORE_START : CKEDITOR.POSITION_AFTER_START)) : (a = "pre" == x && CKEDITOR.env.ie && 8 > CKEDITOR.env.version ? h.createText("\r") : h.createElement("br"), d.deleteContents(), d.insertNode(a), CKEDITOR.env.needsBrFiller ? (h.createText("﻿").insertAfter(a),
                                    m && (w || r.blockLimit).appendBogus(), a.getNext().$.nodeValue = "", d.setStartAt(a.getNext(), CKEDITOR.POSITION_AFTER_START)) : d.setStartAt(a, CKEDITOR.POSITION_AFTER_END)), d.collapse(!0), d.select(), d.scrollIntoView()) : l(a, b, d, e)
                        }
                    }
                }; m = CKEDITOR.plugins.enterkey; h = m.enterBr; l = m.enterBlock; c = /^h[1-6]$/
        })(); (function () {
            function a(a, e) {
                var b = {}, d = [], m = { nbsp: " ", shy: "­", gt: "\x3e", lt: "\x3c", amp: "\x26", apos: "'", quot: '"' }; a = a.replace(/\b(nbsp|shy|gt|lt|amp|apos|quot)(?:,|$)/g, function (a, c) {
                    var g = e ? "\x26" + c + ";" : m[c];
                    b[g] = e ? m[c] : "\x26" + c + ";"; d.push(g); return ""
                }); a = a.replace(/,$/, ""); if (!e && a) { a = a.split(","); var h = document.createElement("div"), l; h.innerHTML = "\x26" + a.join(";\x26") + ";"; l = h.innerHTML; h = null; for (h = 0; h < l.length; h++) { var c = l.charAt(h); b[c] = "\x26" + a[h] + ";"; d.push(c) } } b.regex = d.join(e ? "|" : ""); return b
            } CKEDITOR.plugins.add("entities", {
                afterInit: function (g) {
                    function e(a) { return c[a] } function b(a) { return "force" != d.entities_processNumerical && h[a] ? h[a] : "\x26#" + a.charCodeAt(0) + ";" } var d = g.config; if (g = (g = g.dataProcessor) &&
                        g.htmlFilter) {
                            var m = []; !1 !== d.basicEntities && m.push("nbsp,gt,lt,amp"); d.entities && (m.length && m.push("quot,iexcl,cent,pound,curren,yen,brvbar,sect,uml,copy,ordf,laquo,not,shy,reg,macr,deg,plusmn,sup2,sup3,acute,micro,para,middot,cedil,sup1,ordm,raquo,frac14,frac12,frac34,iquest,times,divide,fnof,bull,hellip,prime,Prime,oline,frasl,weierp,image,real,trade,alefsym,larr,uarr,rarr,darr,harr,crarr,lArr,uArr,rArr,dArr,hArr,forall,part,exist,empty,nabla,isin,notin,ni,prod,sum,minus,lowast,radic,prop,infin,ang,and,or,cap,cup,int,there4,sim,cong,asymp,ne,equiv,le,ge,sub,sup,nsub,sube,supe,oplus,otimes,perp,sdot,lceil,rceil,lfloor,rfloor,lang,rang,loz,spades,clubs,hearts,diams,circ,tilde,ensp,emsp,thinsp,zwnj,zwj,lrm,rlm,ndash,mdash,lsquo,rsquo,sbquo,ldquo,rdquo,bdquo,dagger,Dagger,permil,lsaquo,rsaquo,euro"),
                                d.entities_latin && m.push("Agrave,Aacute,Acirc,Atilde,Auml,Aring,AElig,Ccedil,Egrave,Eacute,Ecirc,Euml,Igrave,Iacute,Icirc,Iuml,ETH,Ntilde,Ograve,Oacute,Ocirc,Otilde,Ouml,Oslash,Ugrave,Uacute,Ucirc,Uuml,Yacute,THORN,szlig,agrave,aacute,acirc,atilde,auml,aring,aelig,ccedil,egrave,eacute,ecirc,euml,igrave,iacute,icirc,iuml,eth,ntilde,ograve,oacute,ocirc,otilde,ouml,oslash,ugrave,uacute,ucirc,uuml,yacute,thorn,yuml,OElig,oelig,Scaron,scaron,Yuml"), d.entities_greek && m.push("Alpha,Beta,Gamma,Delta,Epsilon,Zeta,Eta,Theta,Iota,Kappa,Lambda,Mu,Nu,Xi,Omicron,Pi,Rho,Sigma,Tau,Upsilon,Phi,Chi,Psi,Omega,alpha,beta,gamma,delta,epsilon,zeta,eta,theta,iota,kappa,lambda,mu,nu,xi,omicron,pi,rho,sigmaf,sigma,tau,upsilon,phi,chi,psi,omega,thetasym,upsih,piv"),
                                d.entities_additional && m.push(d.entities_additional)); var h = a(m.join(",")), l = h.regex ? "[" + h.regex + "]" : "a^"; delete h.regex; d.entities && d.entities_processNumerical && (l = "[^ -~]|" + l); var l = new RegExp(l, "g"), c = a("nbsp,gt,lt,amp,shy", !0), k = new RegExp(c.regex, "g"); g.addRules({ text: function (a) { return a.replace(k, e).replace(l, b) } }, { applyToAll: !0, excludeNestedEditable: !0 })
                    }
                }
            })
        })(); CKEDITOR.config.basicEntities = !0; CKEDITOR.config.entities = !0; CKEDITOR.config.entities_latin = !0; CKEDITOR.config.entities_greek = !0;
        CKEDITOR.config.entities_additional = "#39"; CKEDITOR.plugins.add("popup"); CKEDITOR.tools.extend(CKEDITOR.editor.prototype, {
            popup: function (a, g, e, b) {
                g = g || "80%"; e = e || "70%"; "string" == typeof g && 1 < g.length && "%" == g.substr(g.length - 1, 1) && (g = parseInt(window.screen.width * parseInt(g, 10) / 100, 10)); "string" == typeof e && 1 < e.length && "%" == e.substr(e.length - 1, 1) && (e = parseInt(window.screen.height * parseInt(e, 10) / 100, 10)); 640 > g && (g = 640); 420 > e && (e = 420); var d = parseInt((window.screen.height - e) / 2, 10), m = parseInt((window.screen.width -
                    g) / 2, 10); b = (b || "location\x3dno,menubar\x3dno,toolbar\x3dno,dependent\x3dyes,minimizable\x3dno,modal\x3dyes,alwaysRaised\x3dyes,resizable\x3dyes,scrollbars\x3dyes") + ",width\x3d" + g + ",height\x3d" + e + ",top\x3d" + d + ",left\x3d" + m; var h = window.open("", null, b, !0); if (!h) return !1; try { -1 == navigator.userAgent.toLowerCase().indexOf(" chrome/") && (h.moveTo(m, d), h.resizeTo(g, e)), h.focus(), h.location.href = a } catch (l) { window.open(a, null, b, !0) } return !0
            }
        }); "use strict"; (function () {
            function a(a) {
                this.editor = a; this.loaders =
                    []
            } function g(a, b, g) { var l = a.config.fileTools_defaultFileName; this.editor = a; this.lang = a.lang; "string" === typeof b ? (this.data = b, this.file = e(this.data), this.loaded = this.total = this.file.size) : (this.data = null, this.file = b, this.total = this.file.size, this.loaded = 0); g ? this.fileName = g : this.file.name ? this.fileName = this.file.name : (a = this.file.type.split("/"), l && (a[0] = l), this.fileName = a.join(".")); this.uploaded = 0; this.responseData = this.uploadTotal = null; this.status = "created"; this.abort = function () { this.changeStatus("abort") } }
            function e(a) { var e = a.match(b)[1]; a = a.replace(b, ""); a = atob(a); var g = [], l, c, k, f; for (l = 0; l < a.length; l += 512) { c = a.slice(l, l + 512); k = Array(c.length); for (f = 0; f < c.length; f++)k[f] = c.charCodeAt(f); c = new Uint8Array(k); g.push(c) } return new Blob(g, { type: e }) } CKEDITOR.plugins.add("filetools", {
                beforeInit: function (b) {
                    b.uploadRepository = new a(b); b.on("fileUploadRequest", function (a) { var b = a.data.fileLoader; b.xhr.open("POST", b.uploadUrl, !0); a.data.requestData.upload = { file: b.file, name: b.fileName } }, null, null, 5); b.on("fileUploadRequest",
                        function (a) { var e = a.data.fileLoader, g = new FormData; a = a.data.requestData; var c = b.config.fileTools_requestHeaders, k, f; for (f in a) { var n = a[f]; "object" === typeof n && n.file ? g.append(f, n.file, n.name) : g.append(f, n) } g.append("ckCsrfToken", CKEDITOR.tools.getCsrfToken()); if (c) for (k in c) e.xhr.setRequestHeader(k, c[k]); e.xhr.send(g) }, null, null, 999); b.on("fileUploadResponse", function (a) {
                            var b = a.data.fileLoader, d = b.xhr, c = a.data; try {
                                var e = JSON.parse(d.responseText); e.error && e.error.message && (c.message = e.error.message);
                                if (e.uploaded) for (var f in e) c[f] = e[f]; else a.cancel()
                            } catch (g) { c.message = b.lang.filetools.responseError, CKEDITOR.warn("filetools-response-error", { responseText: d.responseText }), a.cancel() }
                        }, null, null, 999)
                }
            }); a.prototype = { create: function (a, b, e) { e = e || g; var l = this.loaders.length; a = new e(this.editor, a, b); a.id = l; this.loaders[l] = a; this.fire("instanceCreated", a); return a }, isFinished: function () { for (var a = 0; a < this.loaders.length; ++a)if (!this.loaders[a].isFinished()) return !1; return !0 } }; g.prototype = {
                loadAndUpload: function (a,
                    b) { var e = this; this.once("loaded", function (g) { g.cancel(); e.once("update", function (a) { a.cancel() }, null, null, 0); e.upload(a, b) }, null, null, 0); this.load() }, load: function () {
                        var a = this, b = this.reader = new FileReader; a.changeStatus("loading"); this.abort = function () { a.reader.abort() }; b.onabort = function () { a.changeStatus("abort") }; b.onerror = function () { a.message = a.lang.filetools.loadError; a.changeStatus("error") }; b.onprogress = function (b) { a.loaded = b.loaded; a.update() }; b.onload = function () {
                            a.loaded = a.total; a.data = b.result;
                            a.changeStatus("loaded")
                        }; b.readAsDataURL(this.file)
                    }, upload: function (a, b) { var e = b || {}; a ? (this.uploadUrl = a, this.xhr = new XMLHttpRequest, this.attachRequestListeners(), this.editor.fire("fileUploadRequest", { fileLoader: this, requestData: e }) && this.changeStatus("uploading")) : (this.message = this.lang.filetools.noUrlError, this.changeStatus("error")) }, attachRequestListeners: function () {
                        function a() { "error" != e.status && (e.message = e.lang.filetools.networkError, e.changeStatus("error")) } function b() {
                            "abort" != e.status &&
                            e.changeStatus("abort")
                        } var e = this, g = this.xhr; e.abort = function () { g.abort(); b() }; g.onerror = a; g.onabort = b; g.upload ? (g.upload.onprogress = function (a) { a.lengthComputable && (e.uploadTotal || (e.uploadTotal = a.total), e.uploaded = a.loaded, e.update()) }, g.upload.onerror = a, g.upload.onabort = b) : (e.uploadTotal = e.total, e.update()); g.onload = function () {
                            e.update(); if ("abort" != e.status) if (e.uploaded = e.uploadTotal, 200 > g.status || 299 < g.status) e.message = e.lang.filetools["httpError" + g.status], e.message || (e.message = e.lang.filetools.httpError.replace("%1",
                                g.status)), e.changeStatus("error"); else { for (var a = { fileLoader: e }, b = ["message", "fileName", "url"], d = e.editor.fire("fileUploadResponse", a), m = 0; m < b.length; m++) { var p = b[m]; "string" === typeof a[p] && (e[p] = a[p]) } e.responseData = a; delete e.responseData.fileLoader; !1 === d ? e.changeStatus("error") : e.changeStatus("uploaded") }
                        }
                    }, changeStatus: function (a) { this.status = a; if ("error" == a || "abort" == a || "loaded" == a || "uploaded" == a) this.abort = function () { }; this.fire(a); this.update() }, update: function () { this.fire("update") }, isFinished: function () { return !!this.status.match(/^(?:loaded|uploaded|error|abort)$/) }
            };
            CKEDITOR.event.implementOn(a.prototype); CKEDITOR.event.implementOn(g.prototype); var b = /^data:(\S*?);base64,/; CKEDITOR.fileTools || (CKEDITOR.fileTools = {}); CKEDITOR.tools.extend(CKEDITOR.fileTools, {
                uploadRepository: a, fileLoader: g, getUploadUrl: function (a, b) {
                    var e = CKEDITOR.tools.capitalize; return b && a[b + "UploadUrl"] ? a[b + "UploadUrl"] : a.uploadUrl ? a.uploadUrl : b && a["filebrowser" + e(b, 1) + "UploadUrl"] ? a["filebrowser" + e(b, 1) + "UploadUrl"] + "\x26responseType\x3djson" : a.filebrowserUploadUrl ? a.filebrowserUploadUrl +
                        "\x26responseType\x3djson" : null
                }, isTypeSupported: function (a, b) { return !!a.type.match(b) }, isFileUploadSupported: "function" === typeof FileReader && "function" === typeof (new FileReader).readAsDataURL && "function" === typeof FormData && "function" === typeof (new FormData).append && "function" === typeof XMLHttpRequest && "function" === typeof Blob
            })
        })(); (function () {
            function a(a, b) { var c = []; if (b) for (var d in b) c.push(d + "\x3d" + encodeURIComponent(b[d])); else return a; return a + (-1 != a.indexOf("?") ? "\x26" : "?") + c.join("\x26") }
            function g(b) { return !b.match(/command=QuickUpload/) || b.match(/(\?|&)responseType=json/) ? b : a(b, { responseType: "json" }) } function e(a) { a += ""; return a.charAt(0).toUpperCase() + a.substr(1) } function b() {
                var b = this.getDialog(), c = b.getParentEditor(); c._.filebrowserSe = this; var d = c.config["filebrowser" + e(b.getName()) + "WindowWidth"] || c.config.filebrowserWindowWidth || "80%", b = c.config["filebrowser" + e(b.getName()) + "WindowHeight"] || c.config.filebrowserWindowHeight || "70%", f = this.filebrowser.params || {}; f.CKEditor = c.name;
                f.CKEditorFuncNum = c._.filebrowserFn; f.langCode || (f.langCode = c.langCode); f = a(this.filebrowser.url, f); c.popup(f, d, b, c.config.filebrowserWindowFeatures || c.config.fileBrowserWindowFeatures)
            } function d(a) { var b = new CKEDITOR.dom.element(a.$.form); b && ((a = b.$.elements.ckCsrfToken) ? a = new CKEDITOR.dom.element(a) : (a = new CKEDITOR.dom.element("input"), a.setAttributes({ name: "ckCsrfToken", type: "hidden" }), b.append(a)), a.setAttribute("value", CKEDITOR.tools.getCsrfToken())) } function m() {
                var a = this.getDialog(); a.getParentEditor()._.filebrowserSe =
                    this; return a.getContentElement(this["for"][0], this["for"][1]).getInputElement().$.value && a.getContentElement(this["for"][0], this["for"][1]).getAction() ? !0 : !1
            } function h(b, c, d) { var e = d.params || {}; e.CKEditor = b.name; e.CKEditorFuncNum = b._.filebrowserFn; e.langCode || (e.langCode = b.langCode); c.action = a(d.url, e); c.filebrowser = d } function l(a, k, t, q) {
                if (q && q.length) for (var r, w = q.length; w--;)if (r = q[w], "hbox" != r.type && "vbox" != r.type && "fieldset" != r.type || l(a, k, t, r.children), r.filebrowser) if ("string" == typeof r.filebrowser &&
                    (r.filebrowser = { action: "fileButton" == r.type ? "QuickUpload" : "Browse", target: r.filebrowser }), "Browse" == r.filebrowser.action) { var x = r.filebrowser.url; void 0 === x && (x = a.config["filebrowser" + e(k) + "BrowseUrl"], void 0 === x && (x = a.config.filebrowserBrowseUrl)); x && (r.onClick = b, r.filebrowser.url = x, r.hidden = !1) } else if ("QuickUpload" == r.filebrowser.action && r["for"] && (x = r.filebrowser.url, void 0 === x && (x = a.config["filebrowser" + e(k) + "UploadUrl"], void 0 === x && (x = a.config.filebrowserUploadUrl)), x)) {
                        var u = r.onClick; r.onClick =
                            function (b) {
                                var e = b.sender, h = e.getDialog().getContentElement(this["for"][0], this["for"][1]).getInputElement(), k = CKEDITOR.fileTools && CKEDITOR.fileTools.isFileUploadSupported; if (u && !1 === u.call(e, b)) return !1; if (m.call(e, b)) {
                                    if ("form" !== a.config.filebrowserUploadMethod && k) return b = a.uploadRepository.create(h.$.files[0]), b.on("uploaded", function (a) { var b = a.sender.responseData; f.call(a.sender.editor, b.url, b.message) }), b.on("error", c.bind(this)), b.on("abort", c.bind(this)), b.loadAndUpload(g(x)), "xhr"; d(h);
                                    return !0
                                } return !1
                            }; r.filebrowser.url = x; r.hidden = !1; h(a, t.getContents(r["for"][0]).get(r["for"][1]), r.filebrowser)
                    }
            } function c(a) { var b = {}; try { b = JSON.parse(a.sender.xhr.response) || {} } catch (c) { } this.enable(); alert(b.error ? b.error.message : a.sender.message) } function k(a, b, c) { if (-1 !== c.indexOf(";")) { c = c.split(";"); for (var d = 0; d < c.length; d++)if (k(a, b, c[d])) return !0; return !1 } return (a = a.getContents(b).get(c).filebrowser) && a.url } function f(a, b) {
                var c = this._.filebrowserSe.getDialog(), d = this._.filebrowserSe["for"],
                e = this._.filebrowserSe.filebrowser.onSelect; d && c.getContentElement(d[0], d[1]).reset(); if ("function" != typeof b || !1 !== b.call(this._.filebrowserSe)) if (!e || !1 !== e.call(this._.filebrowserSe, a, b)) if ("string" == typeof b && b && alert(b), a && (d = this._.filebrowserSe, c = d.getDialog(), d = d.filebrowser.target || null)) if (d = d.split(":"), e = c.getContentElement(d[0], d[1])) e.setValue(a), c.selectPage(d[0])
            } CKEDITOR.plugins.add("filebrowser", {
                requires: "popup,filetools", init: function (a) {
                    a._.filebrowserFn = CKEDITOR.tools.addFunction(f,
                        a); a.on("destroy", function () { CKEDITOR.tools.removeFunction(this._.filebrowserFn) })
                }
            }); CKEDITOR.on("dialogDefinition", function (a) { if (a.editor.plugins.filebrowser) for (var b = a.data.definition, c, d = 0; d < b.contents.length; ++d)if (c = b.contents[d]) l(a.editor, a.data.name, b, c.elements), c.hidden && c.filebrowser && (c.hidden = !k(b, c.id, c.filebrowser)) })
        })(); CKEDITOR.plugins.add("find", {
            requires: "dialog", init: function (a) {
                var g = a.addCommand("find", new CKEDITOR.dialogCommand("find")), e = a.addCommand("replace", new CKEDITOR.dialogCommand("find",
                    { tabId: "replace" })); g.canUndo = !1; g.readOnly = 1; e.canUndo = !1; a.ui.addButton && (a.ui.addButton("Find", { label: a.lang.find.find, command: "find", toolbar: "find,10" }), a.ui.addButton("Replace", { label: a.lang.find.replace, command: "replace", toolbar: "find,20" })); CKEDITOR.dialog.add("find", this.path + "dialogs/find.js")
            }
        }); CKEDITOR.config.find_highlight = { element: "span", styles: { "background-color": "#004", color: "#fff" } }; (function () {
            function a(a, d) {
                var e = b.exec(a), c = b.exec(d); if (e) {
                    if (!e[2] && "px" == c[2]) return c[1]; if ("px" ==
                        e[2] && !c[2]) return c[1] + "px"
                } return d
            } var g = CKEDITOR.htmlParser.cssStyle, e = CKEDITOR.tools.cssLength, b = /^((?:\d*(?:\.\d+))|(?:\d+))(.*)?$/i, d = { elements: { $: function (b) { var d = b.attributes; if ((d = (d = (d = d && d["data-cke-realelement"]) && new CKEDITOR.htmlParser.fragment.fromHtml(decodeURIComponent(d))) && d.children[0]) && b.attributes["data-cke-resizable"]) { var e = (new g(b)).rules; b = d.attributes; var c = e.width, e = e.height; c && (b.width = a(b.width, c)); e && (b.height = a(b.height, e)) } return d } } }; CKEDITOR.plugins.add("fakeobjects",
                { init: function (a) { a.filter.allow("img[!data-cke-realelement,src,alt,title](*){*}", "fakeobjects") }, afterInit: function (a) { (a = (a = a.dataProcessor) && a.htmlFilter) && a.addRules(d, { applyToAll: !0 }) } }); CKEDITOR.editor.prototype.createFakeElement = function (a, b, d, c) {
                    var k = this.lang.fakeobjects, k = k[d] || k.unknown; b = { "class": b, "data-cke-realelement": encodeURIComponent(a.getOuterHtml()), "data-cke-real-node-type": a.type, alt: k, title: k, align: a.getAttribute("align") || "" }; CKEDITOR.env.hc || (b.src = CKEDITOR.tools.transparentImageData);
                    d && (b["data-cke-real-element-type"] = d); c && (b["data-cke-resizable"] = c, d = new g, c = a.getAttribute("width"), a = a.getAttribute("height"), c && (d.rules.width = e(c)), a && (d.rules.height = e(a)), d.populate(b)); return this.document.createElement("img", { attributes: b })
                }; CKEDITOR.editor.prototype.createFakeParserElement = function (a, b, d, c) {
                    var k = this.lang.fakeobjects, k = k[d] || k.unknown, f; f = new CKEDITOR.htmlParser.basicWriter; a.writeHtml(f); f = f.getHtml(); b = {
                        "class": b, "data-cke-realelement": encodeURIComponent(f), "data-cke-real-node-type": a.type,
                        alt: k, title: k, align: a.attributes.align || ""
                    }; CKEDITOR.env.hc || (b.src = CKEDITOR.tools.transparentImageData); d && (b["data-cke-real-element-type"] = d); c && (b["data-cke-resizable"] = c, c = a.attributes, a = new g, d = c.width, c = c.height, void 0 !== d && (a.rules.width = e(d)), void 0 !== c && (a.rules.height = e(c)), a.populate(b)); return new CKEDITOR.htmlParser.element("img", b)
                }; CKEDITOR.editor.prototype.restoreRealElement = function (b) {
                    if (b.data("cke-real-node-type") != CKEDITOR.NODE_ELEMENT) return null; var d = CKEDITOR.dom.element.createFromHtml(decodeURIComponent(b.data("cke-realelement")),
                        this.document); if (b.data("cke-resizable")) { var e = b.getStyle("width"); b = b.getStyle("height"); e && d.setAttribute("width", a(d.getAttribute("width"), e)); b && d.setAttribute("height", a(d.getAttribute("height"), b)) } return d
                }
        })(); (function () {
            function a(a) { a = a.attributes; return "application/x-shockwave-flash" == a.type || e.test(a.src || "") } function g(a, d) { return a.createFakeParserElement(d, "cke_flash", "flash", !0) } var e = /\.swf(?:$|\?)/i; CKEDITOR.plugins.add("flash", {
                requires: "dialog,fakeobjects", onLoad: function () {
                    CKEDITOR.addCss("img.cke_flash{background-image: url(" +
                        CKEDITOR.getUrl(this.path + "images/placeholder.png") + ");background-position: center center;background-repeat: no-repeat;border: 1px solid #a9a9a9;width: 80px;height: 80px;}")
                }, init: function (a) {
                    var d = "object[classid,codebase,height,hspace,vspace,width];param[name,value];embed[height,hspace,pluginspage,src,type,vspace,width]"; CKEDITOR.dialog.isTabEnabled(a, "flash", "properties") && (d += ";object[align]; embed[allowscriptaccess,quality,scale,wmode]"); CKEDITOR.dialog.isTabEnabled(a, "flash", "advanced") && (d +=
                        ";object[id]{*}; embed[bgcolor]{*}(*)"); a.addCommand("flash", new CKEDITOR.dialogCommand("flash", { allowedContent: d, requiredContent: "embed" })); a.ui.addButton && a.ui.addButton("Flash", { label: a.lang.common.flash, command: "flash", toolbar: "insert,20" }); CKEDITOR.dialog.add("flash", this.path + "dialogs/flash.js"); a.addMenuItems && a.addMenuItems({ flash: { label: a.lang.flash.properties, command: "flash", group: "flash" } }); a.on("doubleclick", function (a) {
                            var b = a.data.element; b.is("img") && "flash" == b.data("cke-real-element-type") &&
                                (a.data.dialog = "flash")
                        }); a.contextMenu && a.contextMenu.addListener(function (a) { if (a && a.is("img") && !a.isReadOnly() && "flash" == a.data("cke-real-element-type")) return { flash: CKEDITOR.TRISTATE_OFF } })
                }, afterInit: function (b) {
                    var d = b.dataProcessor; (d = d && d.dataFilter) && d.addRules({
                        elements: {
                            "cke:object": function (d) {
                                var e = d.attributes; if (!(e.classid && String(e.classid).toLowerCase() || a(d))) { for (e = 0; e < d.children.length; e++)if ("cke:embed" == d.children[e].name) { if (!a(d.children[e])) break; return g(b, d) } return null } return g(b,
                                    d)
                            }, "cke:embed": function (d) { return a(d) ? g(b, d) : null }
                        }
                    }, 5)
                }
            })
        })(); CKEDITOR.tools.extend(CKEDITOR.config, { flashEmbedTagOnly: !1, flashAddEmbedTag: !0, flashConvertOnEdit: !1 }); (function () {
            function a(a) {
                var d = a.config, m = a.fire("uiSpace", { space: "top", html: "" }).html, h = function () {
                    function f(a, b, d) { c.setStyle(b, e(d)); c.setStyle("position", a) } function k(a) {
                        var b = m.getDocumentPosition(); switch (a) {
                            case "top": f("absolute", "top", b.y - u - z); break; case "pin": f("fixed", "top", B); break; case "bottom": f("absolute", "top", b.y +
                                (w.height || w.bottom - w.top) + z)
                        }l = a
                    } var l, m, r, w, x, u, A, v = d.floatSpaceDockedOffsetX || 0, z = d.floatSpaceDockedOffsetY || 0, y = d.floatSpacePinnedOffsetX || 0, B = d.floatSpacePinnedOffsetY || 0; return function (f) {
                        if (m = a.editable()) {
                            var n = f && "focus" == f.name; n && c.show(); a.fire("floatingSpaceLayout", { show: n }); c.removeStyle("left"); c.removeStyle("right"); r = c.getClientRect(); w = m.getClientRect(); x = g.getViewPaneSize(); u = r.height; A = "pageXOffset" in g.$ ? g.$.pageXOffset : CKEDITOR.document.$.documentElement.scrollLeft; l ? (u + z <=
                                w.top ? k("top") : u + z > x.height - w.bottom ? k("pin") : k("bottom"), f = x.width / 2, f = d.floatSpacePreferRight ? "right" : 0 < w.left && w.right < x.width && w.width > r.width ? "rtl" == d.contentsLangDirection ? "right" : "left" : f - w.left > w.right - f ? "left" : "right", r.width > x.width ? (f = "left", n = 0) : (n = "left" == f ? 0 < w.left ? w.left : 0 : w.right < x.width ? x.width - w.right : 0, n + r.width > x.width && (f = "left" == f ? "right" : "left", n = 0)), c.setStyle(f, e(("pin" == l ? y : v) + n + ("pin" == l ? 0 : "left" == f ? A : -A)))) : (l = "pin", k("pin"), h(f))
                        }
                    }
                }(); if (m) {
                    var l = new CKEDITOR.template('\x3cdiv id\x3d"cke_{name}" class\x3d"cke {id} cke_reset_all cke_chrome cke_editor_{name} cke_float cke_{langDir} ' +
                        CKEDITOR.env.cssClass + '" dir\x3d"{langDir}" title\x3d"' + (CKEDITOR.env.gecko ? " " : "") + '" lang\x3d"{langCode}" role\x3d"application" style\x3d"{style}"' + (a.title ? ' aria-labelledby\x3d"cke_{name}_arialbl"' : " ") + "\x3e" + (a.title ? '\x3cspan id\x3d"cke_{name}_arialbl" class\x3d"cke_voice_label"\x3e{voiceLabel}\x3c/span\x3e' : " ") + '\x3cdiv class\x3d"cke_inner"\x3e\x3cdiv id\x3d"{topId}" class\x3d"cke_top" role\x3d"presentation"\x3e{content}\x3c/div\x3e\x3c/div\x3e\x3c/div\x3e'), c = CKEDITOR.document.getBody().append(CKEDITOR.dom.element.createFromHtml(l.output({
                            content: m,
                            id: a.id, langDir: a.lang.dir, langCode: a.langCode, name: a.name, style: "display:none;z-index:" + (d.baseFloatZIndex - 1), topId: a.ui.spaceId("top"), voiceLabel: a.title
                        }))), k = CKEDITOR.tools.eventsBuffer(500, h), f = CKEDITOR.tools.eventsBuffer(100, h); c.unselectable(); c.on("mousedown", function (a) { a = a.data; a.getTarget().hasAscendant("a", 1) || a.preventDefault() }); a.on("focus", function (c) { h(c); a.on("change", k.input); g.on("scroll", f.input); g.on("resize", f.input) }); a.on("blur", function () {
                            c.hide(); a.removeListener("change",
                                k.input); g.removeListener("scroll", f.input); g.removeListener("resize", f.input)
                        }); a.on("destroy", function () { g.removeListener("scroll", f.input); g.removeListener("resize", f.input); c.clearCustomData(); c.remove() }); a.focusManager.hasFocus && c.show(); a.focusManager.add(c, 1)
                }
            } var g = CKEDITOR.document.getWindow(), e = CKEDITOR.tools.cssLength; CKEDITOR.plugins.add("floatingspace", { init: function (b) { b.on("loaded", function () { a(this) }, null, null, 20) } })
        })(); CKEDITOR.plugins.add("listblock", {
            requires: "panel", onLoad: function () {
                var a =
                    CKEDITOR.addTemplate("panel-list", '\x3cul role\x3d"presentation" class\x3d"cke_panel_list"\x3e{items}\x3c/ul\x3e'), g = CKEDITOR.addTemplate("panel-list-item", '\x3cli id\x3d"{id}" class\x3d"cke_panel_listItem" role\x3dpresentation\x3e\x3ca id\x3d"{id}_option" _cke_focus\x3d1 hidefocus\x3dtrue title\x3d"{title}" draggable\x3d"false" ondragstart\x3d"return false;" href\x3d"javascript:void(\'{val}\')"  onclick\x3d"{onclick}CKEDITOR.tools.callFunction({clickFn},\'{val}\'); return false;" role\x3d"option"\x3e{text}\x3c/a\x3e\x3c/li\x3e'),
                e = CKEDITOR.addTemplate("panel-list-group", '\x3ch1 id\x3d"{id}" draggable\x3d"false" ondragstart\x3d"return false;" class\x3d"cke_panel_grouptitle" role\x3d"presentation" \x3e{label}\x3c/h1\x3e'), b = /\'/g; CKEDITOR.ui.panel.prototype.addListBlock = function (a, b) { return this.addBlock(a, new CKEDITOR.ui.listBlock(this.getHolderElement(), b)) }; CKEDITOR.ui.listBlock = CKEDITOR.tools.createClass({
                    base: CKEDITOR.ui.panel.block, $: function (a, b) {
                        b = b || {}; var e = b.attributes || (b.attributes = {}); (this.multiSelect = !!b.multiSelect) &&
                            (e["aria-multiselectable"] = !0); !e.role && (e.role = "listbox"); this.base.apply(this, arguments); this.element.setAttribute("role", e.role); e = this.keys; e[40] = "next"; e[9] = "next"; e[38] = "prev"; e[CKEDITOR.SHIFT + 9] = "prev"; e[32] = CKEDITOR.env.ie ? "mouseup" : "click"; CKEDITOR.env.ie && (e[13] = "mouseup"); this._.pendingHtml = []; this._.pendingList = []; this._.items = {}; this._.groups = {}
                    }, _: {
                        close: function () {
                            if (this._.started) {
                                var b = a.output({ items: this._.pendingList.join("") }); this._.pendingList = []; this._.pendingHtml.push(b);
                                delete this._.started
                            }
                        }, getClick: function () { this._.click || (this._.click = CKEDITOR.tools.addFunction(function (a) { var b = this.toggle(a); if (this.onClick) this.onClick(a, b) }, this)); return this._.click }
                    }, proto: {
                        add: function (a, e, h) {
                            var l = CKEDITOR.tools.getNextId(); this._.started || (this._.started = 1, this._.size = this._.size || 0); this._.items[a] = l; var c; c = CKEDITOR.tools.htmlEncodeAttr(a).replace(b, "\\'"); a = {
                                id: l, val: c, onclick: CKEDITOR.env.ie ? 'return false;" onmouseup\x3d"CKEDITOR.tools.getMouseButton(event)\x3d\x3d\x3dCKEDITOR.MOUSE_BUTTON_LEFT\x26\x26' :
                                    "", clickFn: this._.getClick(), title: CKEDITOR.tools.htmlEncodeAttr(h || a), text: e || a
                            }; this._.pendingList.push(g.output(a))
                        }, startGroup: function (a) { this._.close(); var b = CKEDITOR.tools.getNextId(); this._.groups[a] = b; this._.pendingHtml.push(e.output({ id: b, label: a })) }, commit: function () { this._.close(); this.element.appendHtml(this._.pendingHtml.join("")); delete this._.size; this._.pendingHtml = [] }, toggle: function (a) { var b = this.isMarked(a); b ? this.unmark(a) : this.mark(a); return !b }, hideGroup: function (a) {
                            var b = (a =
                                this.element.getDocument().getById(this._.groups[a])) && a.getNext(); a && (a.setStyle("display", "none"), b && "ul" == b.getName() && b.setStyle("display", "none"))
                        }, hideItem: function (a) { this.element.getDocument().getById(this._.items[a]).setStyle("display", "none") }, showAll: function () {
                            var a = this._.items, b = this._.groups, e = this.element.getDocument(), g; for (g in a) e.getById(a[g]).setStyle("display", ""); for (var c in b) a = e.getById(b[c]), g = a.getNext(), a.setStyle("display", ""), g && "ul" == g.getName() && g.setStyle("display",
                                "")
                        }, mark: function (a) { this.multiSelect || this.unmarkAll(); a = this._.items[a]; var b = this.element.getDocument().getById(a); b.addClass("cke_selected"); this.element.getDocument().getById(a + "_option").setAttribute("aria-selected", !0); this.onMark && this.onMark(b) }, markFirstDisplayed: function () { var a = this; this._.markFirstDisplayed(function () { a.multiSelect || a.unmarkAll() }) }, unmark: function (a) {
                            var b = this.element.getDocument(); a = this._.items[a]; var e = b.getById(a); e.removeClass("cke_selected"); b.getById(a + "_option").removeAttribute("aria-selected");
                            this.onUnmark && this.onUnmark(e)
                        }, unmarkAll: function () { var a = this._.items, b = this.element.getDocument(), e; for (e in a) { var g = a[e]; b.getById(g).removeClass("cke_selected"); b.getById(g + "_option").removeAttribute("aria-selected") } this.onUnmark && this.onUnmark() }, isMarked: function (a) { return this.element.getDocument().getById(this._.items[a]).hasClass("cke_selected") }, focus: function (a) {
                            this._.focusIndex = -1; var b = this.element.getElementsByTag("a"), e, g = -1; if (a) for (e = this.element.getDocument().getById(this._.items[a]).getFirst(); a =
                                b.getItem(++g);) { if (a.equals(e)) { this._.focusIndex = g; break } } else this.element.focus(); e && setTimeout(function () { e.focus() }, 0)
                        }
                    }
                })
            }
        }); CKEDITOR.plugins.add("richcombo", { requires: "floatpanel,listblock,button", beforeInit: function (a) { a.ui.addHandler(CKEDITOR.UI_RICHCOMBO, CKEDITOR.ui.richCombo.handler) } }); (function () {
            var a = '\x3cspan id\x3d"{id}" class\x3d"cke_combo cke_combo__{name} {cls}" role\x3d"presentation"\x3e\x3cspan id\x3d"{id}_label" class\x3d"cke_combo_label"\x3e{label}\x3c/span\x3e\x3ca class\x3d"cke_combo_button" title\x3d"{title}" tabindex\x3d"-1"' +
                (CKEDITOR.env.gecko && !CKEDITOR.env.hc ? "" : " href\x3d\"javascript:void('{titleJs}')\"") + ' hidefocus\x3d"true" role\x3d"button" aria-labelledby\x3d"{id}_label" aria-haspopup\x3d"listbox"', g = ""; CKEDITOR.env.gecko && CKEDITOR.env.mac && (a += ' onkeypress\x3d"return false;"'); CKEDITOR.env.gecko && (a += ' onblur\x3d"this.style.cssText \x3d this.style.cssText;"'); CKEDITOR.env.ie && (g = 'return false;" onmouseup\x3d"CKEDITOR.tools.getMouseButton(event)\x3d\x3dCKEDITOR.MOUSE_BUTTON_LEFT\x26\x26'); var a = a + (' onkeydown\x3d"return CKEDITOR.tools.callFunction({keydownFn},event,this);" onfocus\x3d"return CKEDITOR.tools.callFunction({focusFn},event);" onclick\x3d"' +
                    g + 'CKEDITOR.tools.callFunction({clickFn},this);return false;"\x3e\x3cspan id\x3d"{id}_text" class\x3d"cke_combo_text cke_combo_inlinelabel"\x3e{label}\x3c/span\x3e\x3cspan class\x3d"cke_combo_open"\x3e\x3cspan class\x3d"cke_combo_arrow"\x3e' + (CKEDITOR.env.hc ? "\x26#9660;" : CKEDITOR.env.air ? "\x26nbsp;" : "") + "\x3c/span\x3e\x3c/span\x3e\x3c/a\x3e\x3c/span\x3e"), e = CKEDITOR.addTemplate("combo", a); CKEDITOR.UI_RICHCOMBO = "richcombo"; CKEDITOR.ui.richCombo = CKEDITOR.tools.createClass({
                        $: function (a) {
                            CKEDITOR.tools.extend(this,
                                a, { canGroup: !1, title: a.label, modes: { wysiwyg: 1 }, editorFocus: 1 }); a = this.panel || {}; delete this.panel; this.id = CKEDITOR.tools.getNextNumber(); this.document = a.parent && a.parent.getDocument() || CKEDITOR.document; a.className = "cke_combopanel"; a.block = { multiSelect: a.multiSelect, attributes: a.attributes }; a.toolbarRelated = !0; this._ = { panelDefinition: a, items: {}, listeners: [] }
                        }, proto: {
                            renderHtml: function (a) { var d = []; this.render(a, d); return d.join("") }, render: function (a, d) {
                                function g() {
                                    if (this.getState() != CKEDITOR.TRISTATE_ON) {
                                        var c =
                                            this.modes[a.mode] ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED; a.readOnly && !this.readOnly && (c = CKEDITOR.TRISTATE_DISABLED); this.setState(c); this.setValue(""); c != CKEDITOR.TRISTATE_DISABLED && this.refresh && this.refresh()
                                    }
                                } var h = CKEDITOR.env, l, c, k = "cke_" + this.id, f = CKEDITOR.tools.addFunction(function (d) { c && (a.unlockSelection(1), c = 0); l.execute(d) }, this), n = this; l = {
                                    id: k, combo: this, focus: function () { CKEDITOR.document.getById(k).getChild(1).focus() }, execute: function (c) {
                                        var d = n._; if (d.state != CKEDITOR.TRISTATE_DISABLED) if (n.createPanel(a),
                                            d.on) d.panel.hide(); else { n.commit(); var e = n.getValue(); e ? d.list.mark(e) : d.list.unmarkAll(); d.panel.showBlock(n.id, new CKEDITOR.dom.element(c), 4) }
                                    }, clickFn: f
                                }; this._.listeners.push(a.on("activeFilterChange", g, this)); this._.listeners.push(a.on("mode", g, this)); this._.listeners.push(a.on("selectionChange", g, this)); !this.readOnly && this._.listeners.push(a.on("readOnly", g, this)); var p = CKEDITOR.tools.addFunction(function (a, b) {
                                    a = new CKEDITOR.dom.event(a); var c = a.getKeystroke(); switch (c) {
                                        case 13: case 32: case 40: CKEDITOR.tools.callFunction(f,
                                            b); break; default: l.onkey(l, c)
                                    }a.preventDefault()
                                }), t = CKEDITOR.tools.addFunction(function () { l.onfocus && l.onfocus() }); c = 0; l.keyDownFn = p; h = { id: k, name: this.name || this.command, label: this.label, title: this.title, cls: this.className || "", titleJs: h.gecko && !h.hc ? "" : (this.title || "").replace("'", ""), keydownFn: p, focusFn: t, clickFn: f }; e.output(h, d); if (this.onRender) this.onRender(); return l
                            }, createPanel: function (a) {
                                if (!this._.panel) {
                                    var d = this._.panelDefinition, e = this._.panelDefinition.block, g = d.parent || CKEDITOR.document.getBody(),
                                    l = "cke_combopanel__" + this.name, c = new CKEDITOR.ui.floatPanel(a, g, d), d = c.addListBlock(this.id, e), k = this; c.onShow = function () { this.element.addClass(l); k.setState(CKEDITOR.TRISTATE_ON); k._.on = 1; k.editorFocus && !a.focusManager.hasFocus && a.focus(); if (k.onOpen) k.onOpen() }; c.onHide = function (c) { this.element.removeClass(l); k.setState(k.modes && k.modes[a.mode] ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED); k._.on = 0; if (!c && k.onClose) k.onClose() }; c.onEscape = function () { c.hide(1) }; d.onClick = function (a, b) {
                                        k.onClick &&
                                        k.onClick.call(k, a, b); c.hide()
                                    }; this._.panel = c; this._.list = d; c.getBlock(this.id).onHide = function () { k._.on = 0; k.setState(CKEDITOR.TRISTATE_OFF) }; this.init && this.init()
                                }
                            }, setValue: function (a, d) { this._.value = a; var e = this.document.getById("cke_" + this.id + "_text"); e && (a || d ? e.removeClass("cke_combo_inlinelabel") : (d = this.label, e.addClass("cke_combo_inlinelabel")), e.setText("undefined" != typeof d ? d : a)) }, getValue: function () { return this._.value || "" }, unmarkAll: function () { this._.list.unmarkAll() }, mark: function (a) { this._.list.mark(a) },
                            hideItem: function (a) { this._.list.hideItem(a) }, hideGroup: function (a) { this._.list.hideGroup(a) }, showAll: function () { this._.list.showAll() }, add: function (a, d, e) { this._.items[a] = e || a; this._.list.add(a, d, e) }, startGroup: function (a) { this._.list.startGroup(a) }, commit: function () { this._.committed || (this._.list.commit(), this._.committed = 1, CKEDITOR.ui.fire("ready", this)); this._.committed = 1 }, setState: function (a) {
                                if (this._.state != a) {
                                    var d = this.document.getById("cke_" + this.id); d.setState(a, "cke_combo"); a == CKEDITOR.TRISTATE_DISABLED ?
                                        d.setAttribute("aria-disabled", !0) : d.removeAttribute("aria-disabled"); this._.state = a
                                }
                            }, getState: function () { return this._.state }, enable: function () { this._.state == CKEDITOR.TRISTATE_DISABLED && this.setState(this._.lastState) }, disable: function () { this._.state != CKEDITOR.TRISTATE_DISABLED && (this._.lastState = this._.state, this.setState(CKEDITOR.TRISTATE_DISABLED)) }, destroy: function () { CKEDITOR.tools.array.forEach(this._.listeners, function (a) { a.removeListener() }); this._.listeners = [] }, select: function (a) {
                                if (!CKEDITOR.tools.isEmpty(this._.items)) for (var d in this._.items) if (a({
                                    value: d,
                                    text: this._.items[d]
                                })) { this.setValue(d); break }
                            }
                        }, statics: { handler: { create: function (a) { return new CKEDITOR.ui.richCombo(a) } } }
                    }); CKEDITOR.ui.prototype.addRichCombo = function (a, d) { this.add(a, CKEDITOR.UI_RICHCOMBO, d) }
        })(); (function () {
            function a(a, e) {
                var h = a.config, l = e.lang, c = new CKEDITOR.style(e.styleDefinition), k = new b({ entries: e.entries, styleVariable: e.styleVariable, styleDefinition: e.styleDefinition }), f; a.addCommand(e.commandName, {
                    exec: function (a, b) {
                        var c = b.newStyle, d = b.oldStyle, e = a.getSelection().getRanges()[0],
                        f = void 0 === c; if (d || c) if (d && e.collapsed && g({ editor: a, range: e, style: d }), f) a.removeStyle(d); else { if (e = d) e = d instanceof CKEDITOR.style && c instanceof CKEDITOR.style ? CKEDITOR.style.getStyleText(d.getDefinition()) === CKEDITOR.style.getStyleText(c.getDefinition()) : !1, e = !e; e && a.removeStyle(d); a.applyStyle(c) }
                    }, refresh: function (a, b) { c.checkApplicable(b, a, a.activeFilter) || this.setState(CKEDITOR.TRISTATE_DISABLED) }
                }); f = a.getCommand(e.commandName); a.ui.addRichCombo(e.comboName, {
                    label: l.label, title: l.panelTitle,
                    command: e.commandName, toolbar: "styles," + e.order, defaultValue: "cke-default", allowedContent: c, requiredContent: c, contentTransformations: "span" === e.styleDefinition.element ? [[{
                        element: "font", check: "span", left: function (a) { return !!a.attributes.size || !!a.attributes.align || !!a.attributes.face }, right: function (a) {
                            var b = " x-small small medium large x-large xx-large 48px".split(" "); a.name = "span"; a.attributes.size && (a.styles["font-size"] = b[a.attributes.size], delete a.attributes.size); a.attributes.align && (a.styles["text-align"] =
                                a.attributes.align, delete a.attributes.align); a.attributes.face && (a.styles["font-family"] = a.attributes.face, delete a.attributes.face)
                        }
                    }]] : null, panel: { css: [CKEDITOR.skin.getPath("editor")].concat(h.contentsCss), multiSelect: !1, attributes: { "aria-label": l.panelTitle } }, init: function () { var b = "(" + a.lang.common.optionDefault + ")"; this.startGroup(l.panelTitle); this.add(this.defaultValue, b, b); k.addToCombo(this) }, onClick: function (b) {
                        var c = this.getValue(); a.focus(); a.fire("saveSnapshot"); a.execCommand(e.commandName,
                            { newStyle: k.getStyle(b), oldStyle: k.getStyle(c) }); a.fire("saveSnapshot")
                    }, onRender: function () { a.on("selectionChange", function (b) { var c = this.getValue(); (b = k.getMatchingValue(a, b.data.path)) ? b != c && this.setValue(b) : this.setValue("", e.defaultLabel) }, this); f.on("state", function () { this.setState(f.state) }, this) }, refresh: function () { this.setState(f.state) }
                })
            } function g(a) {
                var b = a.editor, g = a.range, l = a.style, c, k, f; c = b.elementPath(); if (a = c.contains(function (a) { return l.checkElementRemovable(a) })) {
                    k = g.checkBoundaryOfElement(a,
                        CKEDITOR.START); f = g.checkBoundaryOfElement(a, CKEDITOR.END); if (k && f) { for (k = g.createBookmark(); c = a.getFirst();)c.insertBefore(a); a.remove(); g.moveToBookmark(k) } else k || f ? g.moveToPosition(a, k ? CKEDITOR.POSITION_BEFORE_START : CKEDITOR.POSITION_AFTER_END) : (g.splitElement(a), g.moveToPosition(a, CKEDITOR.POSITION_AFTER_END)), e(g, c.elements.slice(), a); b.getSelection().selectRanges([g])
                }
            } function e(a, b, g) {
                var l = b.pop(); if (l) {
                    if (g) return e(a, b, l.equals(g) ? null : g); g = l.clone(); a.insertNode(g); a.moveToPosition(g,
                        CKEDITOR.POSITION_AFTER_START); e(a, b)
                }
            } var b = CKEDITOR.tools.createClass({
                $: function (a) { var b = a.entries.split(";"); this._.data = {}; this._.names = []; for (var e = 0; e < b.length; e++) { var g = b[e], c, k; g ? (g = g.split("/"), c = g[0], g = g[1], k = {}, k[a.styleVariable] = g || c, this._.data[c] = new CKEDITOR.style(a.styleDefinition, k), this._.data[c]._.definition.name = c, this._.names.push(c)) : (b.splice(e, 1), e--) } }, proto: {
                    getStyle: function (a) { return this._.data[a] }, addToCombo: function (a) {
                        for (var b = 0; b < this._.names.length; b++) {
                            var e =
                                this._.names[b]; a.add(e, this.getStyle(e).buildPreview(), e)
                        }
                    }, getMatchingValue: function (a, b) { for (var e = b.elements, g = 0, c; g < e.length; g++)if (c = e[g], c = this._.findMatchingStyleName(a, c)) return c; return null }
                }, _: { findMatchingStyleName: function (a, b) { return CKEDITOR.tools.array.find(this._.names, function (e) { return this.getStyle(e).checkElementMatch(b, !0, a) }, this) } }
            }); CKEDITOR.plugins.add("font", {
                requires: "richcombo", init: function (b) {
                    var e = b.config; a(b, {
                        comboName: "Font", commandName: "font", styleVariable: "family",
                        lang: b.lang.font, entries: e.font_names, defaultLabel: e.font_defaultLabel, styleDefinition: e.font_style, order: 30
                    }); a(b, { comboName: "FontSize", commandName: "fontSize", styleVariable: "size", lang: b.lang.font.fontSize, entries: e.fontSize_sizes, defaultLabel: e.fontSize_defaultLabel, styleDefinition: e.fontSize_style, order: 40 })
                }
            })
        })(); CKEDITOR.config.font_names = "Arial/Arial, Helvetica, sans-serif;Comic Sans MS/Comic Sans MS, cursive;Courier New/Courier New, Courier, monospace;Georgia/Georgia, serif;Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;Tahoma/Tahoma, Geneva, sans-serif;Times New Roman/Times New Roman, Times, serif;Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;Verdana/Verdana, Geneva, sans-serif";
        CKEDITOR.config.font_defaultLabel = ""; CKEDITOR.config.font_style = { element: "span", styles: { "font-family": "#(family)" }, overrides: [{ element: "font", attributes: { face: null } }] }; CKEDITOR.config.fontSize_sizes = "8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px"; CKEDITOR.config.fontSize_defaultLabel = ""; CKEDITOR.config.fontSize_style = { element: "span", styles: { "font-size": "#(size)" }, overrides: [{ element: "font", attributes: { size: null } }] }; CKEDITOR.plugins.add("format",
            {
                requires: "richcombo", init: function (a) {
                    if (!a.blockless) {
                        for (var g = a.config, e = a.lang.format, b = g.format_tags.split(";"), d = {}, m = 0, h = [], l = 0; l < b.length; l++) { var c = b[l], k = new CKEDITOR.style(g["format_" + c]); if (!a.filter.customConfig || a.filter.check(k)) m++, d[c] = k, d[c]._.enterMode = a.config.enterMode, h.push(k) } 0 !== m && a.ui.addRichCombo("Format", {
                            label: e.label, title: e.panelTitle, toolbar: "styles,20", allowedContent: h, panel: { css: [CKEDITOR.skin.getPath("editor")].concat(g.contentsCss), multiSelect: !1, attributes: { "aria-label": e.panelTitle } },
                            init: function () { this.startGroup(e.panelTitle); for (var a in d) { var b = e["tag_" + a]; this.add(a, d[a].buildPreview(b), b) } }, onClick: function (b) { a.focus(); a.fire("saveSnapshot"); b = d[b]; var c = a.elementPath(); b.checkActive(c, a) || a.applyStyle(b); setTimeout(function () { a.fire("saveSnapshot") }, 0) }, onRender: function () {
                                a.on("selectionChange", function (b) { var c = this.getValue(); b = b.data.path; this.refresh(); for (var e in d) if (d[e].checkActive(b, a)) { e != c && this.setValue(e, a.lang.format["tag_" + e]); return } this.setValue("") },
                                    this)
                            }, onOpen: function () { this.showAll(); for (var b in d) a.activeFilter.check(d[b]) || this.hideItem(b) }, refresh: function () { var b = a.elementPath(); if (b) { if (b.isContextFor("p")) for (var c in d) if (a.activeFilter.check(d[c])) return; this.setState(CKEDITOR.TRISTATE_DISABLED) } }
                        })
                    }
                }
            }); CKEDITOR.config.format_tags = "p;h1;h2;h3;h4;h5;h6;pre;address;div"; CKEDITOR.config.format_p = { element: "p" }; CKEDITOR.config.format_div = { element: "div" }; CKEDITOR.config.format_pre = { element: "pre" }; CKEDITOR.config.format_address = { element: "address" };
        CKEDITOR.config.format_h1 = { element: "h1" }; CKEDITOR.config.format_h2 = { element: "h2" }; CKEDITOR.config.format_h3 = { element: "h3" }; CKEDITOR.config.format_h4 = { element: "h4" }; CKEDITOR.config.format_h5 = { element: "h5" }; CKEDITOR.config.format_h6 = { element: "h6" }; CKEDITOR.plugins.add("forms", {
            requires: "dialog,fakeobjects", onLoad: function () {
                CKEDITOR.addCss(".cke_editable form{border: 1px dotted #FF0000;padding: 2px;}\n"); CKEDITOR.addCss("img.cke_hidden{background-image: url(" + CKEDITOR.getUrl(this.path + "images/hiddenfield.gif") +
                    ");background-position: center center;background-repeat: no-repeat;border: 1px solid #a9a9a9;width: 16px !important;height: 16px !important;}")
            }, init: function (a) {
                var g = a.lang, e = 0, b = { email: 1, password: 1, search: 1, tel: 1, text: 1, url: 1 }, d = {
                    checkbox: "input[type,name,checked,required]", radio: "input[type,name,checked,required]", textfield: "input[type,name,value,size,maxlength,required]", textarea: "textarea[cols,rows,name,required]", select: "select[name,size,multiple,required]; option[value,selected]", button: "input[type,name,value]",
                    form: "form[action,name,id,enctype,target,method]", hiddenfield: "input[type,name,value]", imagebutton: "input[type,alt,src]{width,height,border,border-width,border-style,margin,float}"
                }, m = { checkbox: "input", radio: "input", textfield: "input", textarea: "textarea", select: "select", button: "input", form: "form", hiddenfield: "input", imagebutton: "input" }, h = function (b, c, h) {
                    var l = { allowedContent: d[c], requiredContent: m[c] }; "form" == c && (l.context = "form"); a.addCommand(c, new CKEDITOR.dialogCommand(c, l)); a.ui.addButton && a.ui.addButton(b,
                        { label: g.common[b.charAt(0).toLowerCase() + b.slice(1)], command: c, toolbar: "forms," + (e += 10) }); CKEDITOR.dialog.add(c, h)
                }, l = this.path + "dialogs/"; !a.blockless && h("Form", "form", l + "form.js"); h("Checkbox", "checkbox", l + "checkbox.js"); h("Radio", "radio", l + "radio.js"); h("TextField", "textfield", l + "textfield.js"); h("Textarea", "textarea", l + "textarea.js"); h("Select", "select", l + "select.js"); h("Button", "button", l + "button.js"); var c = a.plugins.image; c && !a.plugins.image2 && h("ImageButton", "imagebutton", CKEDITOR.plugins.getPath("image") +
                    "dialogs/image.js"); h("HiddenField", "hiddenfield", l + "hiddenfield.js"); a.addMenuItems && (h = {
                        checkbox: { label: g.forms.checkboxAndRadio.checkboxTitle, command: "checkbox", group: "checkbox" }, radio: { label: g.forms.checkboxAndRadio.radioTitle, command: "radio", group: "radio" }, textfield: { label: g.forms.textfield.title, command: "textfield", group: "textfield" }, hiddenfield: { label: g.forms.hidden.title, command: "hiddenfield", group: "hiddenfield" }, button: { label: g.forms.button.title, command: "button", group: "button" }, select: {
                            label: g.forms.select.title,
                            command: "select", group: "select"
                        }, textarea: { label: g.forms.textarea.title, command: "textarea", group: "textarea" }
                    }, c && (h.imagebutton = { label: g.image.titleButton, command: "imagebutton", group: "imagebutton" }), !a.blockless && (h.form = { label: g.forms.form.menu, command: "form", group: "form" }), a.addMenuItems(h)); a.contextMenu && (!a.blockless && a.contextMenu.addListener(function (a, b, c) { if ((a = c.contains("form", 1)) && !a.isReadOnly()) return { form: CKEDITOR.TRISTATE_OFF } }), a.contextMenu.addListener(function (a) {
                        if (a && !a.isReadOnly()) {
                            var d =
                                a.getName(); if ("select" == d) return { select: CKEDITOR.TRISTATE_OFF }; if ("textarea" == d) return { textarea: CKEDITOR.TRISTATE_OFF }; if ("input" == d) { var e = a.getAttribute("type") || "text"; switch (e) { case "button": case "submit": case "reset": return { button: CKEDITOR.TRISTATE_OFF }; case "checkbox": return { checkbox: CKEDITOR.TRISTATE_OFF }; case "radio": return { radio: CKEDITOR.TRISTATE_OFF }; case "image": return c ? { imagebutton: CKEDITOR.TRISTATE_OFF } : null }if (b[e]) return { textfield: CKEDITOR.TRISTATE_OFF } } if ("img" == d && "hiddenfield" ==
                                    a.data("cke-real-element-type")) return { hiddenfield: CKEDITOR.TRISTATE_OFF }
                        }
                    })); a.on("doubleclick", function (c) {
                        var d = c.data.element; if (!a.blockless && d.is("form")) c.data.dialog = "form"; else if (d.is("select")) c.data.dialog = "select"; else if (d.is("textarea")) c.data.dialog = "textarea"; else if (d.is("img") && "hiddenfield" == d.data("cke-real-element-type")) c.data.dialog = "hiddenfield"; else if (d.is("input")) {
                            d = d.getAttribute("type") || "text"; switch (d) {
                                case "button": case "submit": case "reset": c.data.dialog = "button";
                                    break; case "checkbox": c.data.dialog = "checkbox"; break; case "radio": c.data.dialog = "radio"; break; case "image": c.data.dialog = "imagebutton"
                            }b[d] && (c.data.dialog = "textfield")
                        }
                    })
            }, afterInit: function (a) {
                var g = a.dataProcessor, e = g && g.htmlFilter, g = g && g.dataFilter; CKEDITOR.env.ie && e && e.addRules({ elements: { input: function (a) { a = a.attributes; var d = a.type; d || (a.type = "text"); "checkbox" != d && "radio" != d || "on" != a.value || delete a.value } } }, { applyToAll: !0 }); g && g.addRules({
                    elements: {
                        input: function (b) {
                            if ("hidden" == b.attributes.type) return a.createFakeParserElement(b,
                                "cke_hidden", "hiddenfield")
                        }
                    }
                }, { applyToAll: !0 })
            }
        }); CKEDITOR.plugins.forms = { _setupRequiredAttribute: function (a) { this.setValue(a.hasAttribute("required")) } }; (function () {
            var a = { canUndo: !1, exec: function (a) { var e = a.document.createElement("hr"); a.insertElement(e) }, allowedContent: "hr", requiredContent: "hr" }; CKEDITOR.plugins.add("horizontalrule", {
                init: function (g) {
                    g.blockless || (g.addCommand("horizontalrule", a), g.ui.addButton && g.ui.addButton("HorizontalRule", {
                        label: g.lang.horizontalrule.toolbar, command: "horizontalrule",
                        toolbar: "insert,40"
                    }))
                }
            })
        })(); CKEDITOR.plugins.add("htmlwriter", { init: function (a) { var g = new CKEDITOR.htmlWriter; g.forceSimpleAmpersand = a.config.forceSimpleAmpersand; g.indentationChars = a.config.dataIndentationChars || "\t"; a.dataProcessor.writer = g } }); CKEDITOR.htmlWriter = CKEDITOR.tools.createClass({
            base: CKEDITOR.htmlParser.basicWriter, $: function () {
                this.base(); this.indentationChars = "\t"; this.selfClosingEnd = " /\x3e"; this.lineBreakChars = "\n"; this.sortAttributes = 1; this._.indent = 0; this._.indentation = ""; this._.inPre =
                    0; this._.rules = {}; var a = CKEDITOR.dtd, g; for (g in CKEDITOR.tools.extend({}, a.$nonBodyContent, a.$block, a.$listItem, a.$tableContent)) this.setRules(g, { indent: !a[g]["#"], breakBeforeOpen: 1, breakBeforeClose: !a[g]["#"], breakAfterClose: 1, needsSpace: g in a.$block && !(g in { li: 1, dt: 1, dd: 1 }) }); this.setRules("br", { breakAfterOpen: 1 }); this.setRules("title", { indent: 0, breakAfterOpen: 0 }); this.setRules("style", { indent: 0, breakBeforeClose: 1 }); this.setRules("pre", { breakAfterOpen: 1, indent: 0 })
            }, proto: {
                openTag: function (a) {
                    var g =
                        this._.rules[a]; this._.afterCloser && g && g.needsSpace && this._.needsSpace && this._.output.push("\n"); this._.indent ? this.indentation() : g && g.breakBeforeOpen && (this.lineBreak(), this.indentation()); this._.output.push("\x3c", a); this._.afterCloser = 0
                }, openTagClose: function (a, g) {
                    var e = this._.rules[a]; g ? (this._.output.push(this.selfClosingEnd), e && e.breakAfterClose && (this._.needsSpace = e.needsSpace)) : (this._.output.push("\x3e"), e && e.indent && (this._.indentation += this.indentationChars)); e && e.breakAfterOpen && this.lineBreak();
                    "pre" == a && (this._.inPre = 1)
                }, attribute: function (a, g) { "string" == typeof g && (g = CKEDITOR.tools.htmlEncodeAttr(g), this.forceSimpleAmpersand && (g = g.replace(/&amp;/g, "\x26"))); this._.output.push(" ", a, '\x3d"', g, '"') }, closeTag: function (a) {
                    var g = this._.rules[a]; g && g.indent && (this._.indentation = this._.indentation.substr(this.indentationChars.length)); this._.indent ? this.indentation() : g && g.breakBeforeClose && (this.lineBreak(), this.indentation()); this._.output.push("\x3c/", a, "\x3e"); "pre" == a && (this._.inPre = 0); g &&
                        g.breakAfterClose && (this.lineBreak(), this._.needsSpace = g.needsSpace); this._.afterCloser = 1
                }, text: function (a) { this._.indent && (this.indentation(), !this._.inPre && (a = CKEDITOR.tools.ltrim(a))); this._.output.push(a) }, comment: function (a) { this._.indent && this.indentation(); this._.output.push("\x3c!--", a, "--\x3e") }, lineBreak: function () { !this._.inPre && 0 < this._.output.length && this._.output.push(this.lineBreakChars); this._.indent = 1 }, indentation: function () {
                    !this._.inPre && this._.indentation && this._.output.push(this._.indentation);
                    this._.indent = 0
                }, reset: function () { this._.output = []; this._.indent = 0; this._.indentation = ""; this._.afterCloser = 0; this._.inPre = 0; this._.needsSpace = 0 }, setRules: function (a, g) { var e = this._.rules[a]; e ? CKEDITOR.tools.extend(e, g, !0) : this._.rules[a] = g }
            }
        }); (function () {
            CKEDITOR.plugins.add("iframe", {
                requires: "dialog,fakeobjects", onLoad: function () { CKEDITOR.addCss("img.cke_iframe{background-image: url(" + CKEDITOR.getUrl(this.path + "images/placeholder.png") + ");background-position: center center;background-repeat: no-repeat;border: 1px solid #a9a9a9;width: 80px;height: 80px;}") },
                init: function (a) {
                    var g = a.lang.iframe, e = "iframe[align,longdesc,frameborder,height,name,scrolling,src,title,width]"; a.plugins.dialogadvtab && (e += ";iframe" + a.plugins.dialogadvtab.allowedContent({ id: 1, classes: 1, styles: 1 })); CKEDITOR.dialog.add("iframe", this.path + "dialogs/iframe.js"); a.addCommand("iframe", new CKEDITOR.dialogCommand("iframe", { allowedContent: e, requiredContent: "iframe" })); a.ui.addButton && a.ui.addButton("Iframe", { label: g.toolbar, command: "iframe", toolbar: "insert,80" }); a.on("doubleclick", function (a) {
                        var d =
                            a.data.element; d.is("img") && "iframe" == d.data("cke-real-element-type") && (a.data.dialog = "iframe")
                    }); a.addMenuItems && a.addMenuItems({ iframe: { label: g.title, command: "iframe", group: "image" } }); a.contextMenu && a.contextMenu.addListener(function (a) { if (a && a.is("img") && "iframe" == a.data("cke-real-element-type")) return { iframe: CKEDITOR.TRISTATE_OFF } })
                }, afterInit: function (a) {
                    var g = a.dataProcessor; (g = g && g.dataFilter) && g.addRules({
                        elements: {
                            iframe: function (e) {
                                return a.createFakeParserElement(e, "cke_iframe", "iframe",
                                    !0)
                            }
                        }
                    })
                }
            })
        })(); (function () {
            function a(a, b) { b || (b = a.getSelection().getSelectedElement()); if (b && b.is("img") && !b.data("cke-realelement") && !b.isReadOnly()) return b } function g(a) { var b = a.getStyle("float"); if ("inherit" == b || "none" == b) b = 0; b || (b = a.getAttribute("align")); return b } CKEDITOR.plugins.add("image", {
                requires: "dialog", init: function (e) {
                    if (!e.plugins.detectConflict("image", ["easyimage", "image2"])) {
                        CKEDITOR.dialog.add("image", this.path + "dialogs/image.js"); var b = "img[alt,!src]{border-style,border-width,float,height,margin,margin-bottom,margin-left,margin-right,margin-top,width}";
                        CKEDITOR.dialog.isTabEnabled(e, "image", "advanced") && (b = "img[alt,dir,id,lang,longdesc,!src,title]{*}(*)"); e.addCommand("image", new CKEDITOR.dialogCommand("image", { allowedContent: b, requiredContent: "img[alt,src]", contentTransformations: [["img{width}: sizeToStyle", "img[width]: sizeToAttribute"], ["img{float}: alignmentToStyle", "img[align]: alignmentToAttribute"]] })); e.ui.addButton && e.ui.addButton("Image", { label: e.lang.common.image, command: "image", toolbar: "insert,10" }); e.on("doubleclick", function (a) {
                            var b =
                                a.data.element; !b.is("img") || b.data("cke-realelement") || b.isReadOnly() || (a.data.dialog = "image")
                        }); e.addMenuItems && e.addMenuItems({ image: { label: e.lang.image.menu, command: "image", group: "image" } }); e.contextMenu && e.contextMenu.addListener(function (b) { if (a(e, b)) return { image: CKEDITOR.TRISTATE_OFF } })
                    }
                }, afterInit: function (e) {
                    function b(b) {
                        var m = e.getCommand("justify" + b); if (m) {
                            if ("left" == b || "right" == b) m.on("exec", function (h) {
                                var l = a(e), c; l && (c = g(l), c == b ? (l.removeStyle("float"), b == g(l) && l.removeAttribute("align")) :
                                    l.setStyle("float", b), h.cancel())
                            }); m.on("refresh", function (h) { var l = a(e); l && (l = g(l), this.setState(l == b ? CKEDITOR.TRISTATE_ON : "right" == b || "left" == b ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED), h.cancel()) })
                        }
                    } e.plugins.image2 || (b("left"), b("right"), b("center"), b("block"))
                }
            })
        })(); CKEDITOR.config.image_removeLinkByEmptyURL = !0; (function () {
            function a(a, d) {
                var m, h; d.on("refresh", function (a) { var b = [g], d; for (d in a.data.states) b.push(a.data.states[d]); this.setState(CKEDITOR.tools.search(b, e) ? e : g) }, d,
                    null, 100); d.on("exec", function (d) { m = a.getSelection(); h = m.createBookmarks(1); d.data || (d.data = {}); d.data.done = !1 }, d, null, 0); d.on("exec", function () { a.forceNextSelectionCheck(); m.selectBookmarks(h) }, d, null, 100)
            } var g = CKEDITOR.TRISTATE_DISABLED, e = CKEDITOR.TRISTATE_OFF; CKEDITOR.plugins.add("indent", {
                init: function (b) {
                    var d = CKEDITOR.plugins.indent.genericDefinition; a(b, b.addCommand("indent", new d(!0))); a(b, b.addCommand("outdent", new d)); b.ui.addButton && (b.ui.addButton("Indent", {
                        label: b.lang.indent.indent,
                        command: "indent", directional: !0, toolbar: "indent,20"
                    }), b.ui.addButton("Outdent", { label: b.lang.indent.outdent, command: "outdent", directional: !0, toolbar: "indent,10" })); b.on("dirChanged", function (a) {
                        var d = b.createRange(), e = a.data.node; d.setStartBefore(e); d.setEndAfter(e); for (var c = new CKEDITOR.dom.walker(d), g; g = c.next();)if (g.type == CKEDITOR.NODE_ELEMENT) if (!g.equals(e) && g.getDirection()) d.setStartAfter(g), c = new CKEDITOR.dom.walker(d); else {
                            var f = b.config.indentClasses; if (f) for (var n = "ltr" == a.data.dir ? ["_rtl",
                                ""] : ["", "_rtl"], p = 0; p < f.length; p++)g.hasClass(f[p] + n[0]) && (g.removeClass(f[p] + n[0]), g.addClass(f[p] + n[1])); f = g.getStyle("margin-right"); n = g.getStyle("margin-left"); f ? g.setStyle("margin-left", f) : g.removeStyle("margin-left"); n ? g.setStyle("margin-right", n) : g.removeStyle("margin-right")
                        }
                    })
                }
            }); CKEDITOR.plugins.indent = {
                genericDefinition: function (a) { this.isIndent = !!a; this.startDisabled = !this.isIndent }, specificDefinition: function (a, d, e) {
                    this.name = d; this.editor = a; this.jobs = {}; this.enterBr = a.config.enterMode ==
                        CKEDITOR.ENTER_BR; this.isIndent = !!e; this.relatedGlobal = e ? "indent" : "outdent"; this.indentKey = e ? 9 : CKEDITOR.SHIFT + 9; this.database = {}
                }, registerCommands: function (a, d) {
                    a.on("pluginsLoaded", function () {
                        for (var a in d) (function (a, b) {
                            var c = a.getCommand(b.relatedGlobal), d; for (d in b.jobs) c.on("exec", function (c) { c.data.done || (a.fire("lockSnapshot"), b.execJob(a, d) && (c.data.done = !0), a.fire("unlockSnapshot"), CKEDITOR.dom.element.clearAllMarkers(b.database)) }, this, null, d), c.on("refresh", function (c) {
                                c.data.states ||
                                (c.data.states = {}); c.data.states[b.name + "@" + d] = b.refreshJob(a, d, c.data.path)
                            }, this, null, d); a.addFeature(b)
                        })(this, d[a])
                    })
                }
            }; CKEDITOR.plugins.indent.genericDefinition.prototype = { context: "p", exec: function () { } }; CKEDITOR.plugins.indent.specificDefinition.prototype = { execJob: function (a, d) { var e = this.jobs[d]; if (e.state != g) return e.exec.call(this, a) }, refreshJob: function (a, d, e) { d = this.jobs[d]; a.activeFilter.checkFeature(this) ? d.state = d.refresh.call(this, a, e) : d.state = g; return d.state }, getContext: function (a) { return a.contains(this.context) } }
        })();
        (function () {
            function a(a, b, c) {
                if (!a.getCustomData("indent_processed")) {
                    var d = this.editor, e = this.isIndent; if (b) { d = a.$.className.match(this.classNameRegex); c = 0; d && (d = d[1], c = CKEDITOR.tools.indexOf(b, d) + 1); if (0 > (c += e ? 1 : -1)) return; c = Math.min(c, b.length); c = Math.max(c, 0); a.$.className = CKEDITOR.tools.ltrim(a.$.className.replace(this.classNameRegex, "")); 0 < c && a.addClass(b[c - 1]) } else {
                        b = g(a, c); c = parseInt(a.getStyle(b), 10); var m = d.config.indentOffset || 40; isNaN(c) && (c = 0); c += (e ? 1 : -1) * m; if (0 > c) return; c = Math.max(c,
                            0); c = Math.ceil(c / m) * m; a.setStyle(b, c ? c + (d.config.indentUnit || "px") : ""); "" === a.getAttribute("style") && a.removeAttribute("style")
                    } CKEDITOR.dom.element.setMarker(this.database, a, "indent_processed", 1)
                }
            } function g(a, b) { return "ltr" == (b || a.getComputedStyle("direction")) ? "margin-left" : "margin-right" } var e = CKEDITOR.dtd.$listItem, b = CKEDITOR.dtd.$list, d = CKEDITOR.TRISTATE_DISABLED, m = CKEDITOR.TRISTATE_OFF; CKEDITOR.plugins.add("indentblock", {
                requires: "indent", init: function (h) {
                    function l() {
                        c.specificDefinition.apply(this,
                            arguments); this.allowedContent = { "div h1 h2 h3 h4 h5 h6 ol p pre ul": { propertiesOnly: !0, styles: k ? null : "margin-left,margin-right", classes: k || null } }; this.contentTransformations = [["div: splitMarginShorthand"], ["h1: splitMarginShorthand"], ["h2: splitMarginShorthand"], ["h3: splitMarginShorthand"], ["h4: splitMarginShorthand"], ["h5: splitMarginShorthand"], ["h6: splitMarginShorthand"], ["ol: splitMarginShorthand"], ["p: splitMarginShorthand"], ["pre: splitMarginShorthand"], ["ul: splitMarginShorthand"]]; this.enterBr &&
                                (this.allowedContent.div = !0); this.requiredContent = (this.enterBr ? "div" : "p") + (k ? "(" + k.join(",") + ")" : "{margin-left}"); this.jobs = {
                                    20: {
                                        refresh: function (a, b) {
                                            var c = b.block || b.blockLimit; if (!c.is(e)) var h = c.getAscendant(e), c = h && b.contains(h) || c; c.is(e) && (c = c.getParent()); if (this.enterBr || this.getContext(b)) {
                                                if (k) { var h = k, c = c.$.className.match(this.classNameRegex), l = this.isIndent, h = c ? l ? c[1] != h.slice(-1) : !0 : l; return h ? m : d } return this.isIndent ? m : c ? CKEDITOR[0 >= (parseInt(c.getStyle(g(c)), 10) || 0) ? "TRISTATE_DISABLED" :
                                                    "TRISTATE_OFF"] : d
                                            } return d
                                        }, exec: function (c) { var d = c.getSelection(), d = d && d.getRanges()[0], e; if (e = c.elementPath().contains(b)) a.call(this, e, k); else for (d = d.createIterator(), c = c.config.enterMode, d.enforceRealBlocks = !0, d.enlargeBr = c != CKEDITOR.ENTER_BR; e = d.getNextParagraph(c == CKEDITOR.ENTER_P ? "p" : "div");)e.isReadOnly() || a.call(this, e, k); return !0 }
                                    }
                                }
                    } var c = CKEDITOR.plugins.indent, k = h.config.indentClasses; c.registerCommands(h, { indentblock: new l(h, "indentblock", !0), outdentblock: new l(h, "outdentblock") });
                    CKEDITOR.tools.extend(l.prototype, c.specificDefinition.prototype, { context: { div: 1, dl: 1, h1: 1, h2: 1, h3: 1, h4: 1, h5: 1, h6: 1, ul: 1, ol: 1, p: 1, pre: 1, table: 1 }, classNameRegex: k ? new RegExp("(?:^|\\s+)(" + k.join("|") + ")(?\x3d$|\\s)") : null })
                }
            })
        })(); (function () {
            function a(a) {
                function b(c) {
                    for (var g = m.startContainer, u = m.endContainer; g && !g.getParent().equals(c);)g = g.getParent(); for (; u && !u.getParent().equals(c);)u = u.getParent(); if (!g || !u) return !1; for (var A = [], v = !1; !v;)g.equals(u) && (v = !0), A.push(g), g = g.getNext(); if (1 > A.length) return !1;
                    g = c.getParents(!0); for (u = 0; u < g.length; u++)if (g[u].getName && h[g[u].getName()]) { c = g[u]; break } for (var g = d.isIndent ? 1 : -1, u = A[0], A = A[A.length - 1], v = CKEDITOR.plugins.list.listToArray(c, f), z = v[A.getCustomData("listarray_index")].indent, u = u.getCustomData("listarray_index"); u <= A.getCustomData("listarray_index"); u++)if (v[u].indent += g, 0 < g) { for (var y = v[u].parent, r = u - 1; 0 <= r; r--)if (v[r].indent === g) { y = v[r].parent; break } v[u].parent = new CKEDITOR.dom.element(y.getName(), y.getDocument()) } for (u = A.getCustomData("listarray_index") +
                        1; u < v.length && v[u].indent > z; u++)v[u].indent += g; g = CKEDITOR.plugins.list.arrayToList(v, f, null, a.config.enterMode, c.getDirection()); if (!d.isIndent) { var C; if ((C = c.getParent()) && C.is("li")) for (var A = g.listNode.getChildren(), F = [], t, u = A.count() - 1; 0 <= u; u--)(t = A.getItem(u)) && t.is && t.is("li") && F.push(t) } g && g.listNode.replace(c); if (F && F.length) for (u = 0; u < F.length; u++) {
                            for (t = c = F[u]; (t = t.getNext()) && t.is && t.getName() in h;)CKEDITOR.env.needsNbspFiller && !c.getFirst(e) && c.append(m.document.createText(" ")), c.append(t);
                            c.insertAfter(C)
                        } g && a.fire("contentDomInvalidated"); return !0
                } for (var d = this, f = this.database, h = this.context, m, t = a.getSelection(), t = (t && t.getRanges()).createIterator(); m = t.getNextRange();) {
                    for (var q = m.getCommonAncestor(); q && (q.type != CKEDITOR.NODE_ELEMENT || !h[q.getName()]);) { if (a.editable().equals(q)) { q = !1; break } q = q.getParent() } q || (q = m.startPath().contains(h)) && m.setEndAt(q, CKEDITOR.POSITION_BEFORE_END); if (!q) {
                        var r = m.getEnclosedNode(); r && r.type == CKEDITOR.NODE_ELEMENT && r.getName() in h && (m.setStartAt(r,
                            CKEDITOR.POSITION_AFTER_START), m.setEndAt(r, CKEDITOR.POSITION_BEFORE_END), q = r)
                    } q && m.startContainer.type == CKEDITOR.NODE_ELEMENT && m.startContainer.getName() in h && (r = new CKEDITOR.dom.walker(m), r.evaluator = g, m.startContainer = r.next()); q && m.endContainer.type == CKEDITOR.NODE_ELEMENT && m.endContainer.getName() in h && (r = new CKEDITOR.dom.walker(m), r.evaluator = g, m.endContainer = r.previous()); if (q) return b(q)
                } return 0
            } function g(a) { return a.type == CKEDITOR.NODE_ELEMENT && a.is("li") } function e(a) { return b(a) && d(a) }
            var b = CKEDITOR.dom.walker.whitespaces(!0), d = CKEDITOR.dom.walker.bookmark(!1, !0), m = CKEDITOR.TRISTATE_DISABLED, h = CKEDITOR.TRISTATE_OFF; CKEDITOR.plugins.add("indentlist", {
                requires: "indent", init: function (b) {
                    function c(b) {
                        d.specificDefinition.apply(this, arguments); this.requiredContent = ["ul", "ol"]; b.on("key", function (a) {
                            var c = b.elementPath(); if ("wysiwyg" == b.mode && a.data.keyCode == this.indentKey && c) {
                                var d = this.getContext(c); !d || this.isIndent && CKEDITOR.plugins.indentList.firstItemInPath(this.context, c, d) ||
                                    (b.execCommand(this.relatedGlobal), a.cancel())
                            }
                        }, this); this.jobs[this.isIndent ? 10 : 30] = { refresh: this.isIndent ? function (a, b) { var c = this.getContext(b), d = CKEDITOR.plugins.indentList.firstItemInPath(this.context, b, c); return c && this.isIndent && !d ? h : m } : function (a, b) { return !this.getContext(b) || this.isIndent ? m : h }, exec: CKEDITOR.tools.bind(a, this) }
                    } var d = CKEDITOR.plugins.indent; d.registerCommands(b, { indentlist: new c(b, "indentlist", !0), outdentlist: new c(b, "outdentlist") }); CKEDITOR.tools.extend(c.prototype, d.specificDefinition.prototype,
                        { context: { ol: 1, ul: 1 } })
                }
            }); CKEDITOR.plugins.indentList = {}; CKEDITOR.plugins.indentList.firstItemInPath = function (a, b, d) { var e = b.contains(g); d || (d = b.contains(a)); return d && e && e.equals(d.getFirst(g)) }
        })(); (function () {
            function a(a, d) {
                d = void 0 === d || d; var e; if (d) e = a.getComputedStyle("text-align"); else { for (; !a.hasAttribute || !a.hasAttribute("align") && !a.getStyle("text-align");) { e = a.getParent(); if (!e) break; a = e } e = a.getStyle("text-align") || a.getAttribute("align") || "" } e && (e = e.replace(/(?:-(?:moz|webkit)-)?(?:start|auto)/i,
                    "")); !e && d && (e = "rtl" == a.getComputedStyle("direction") ? "right" : "left"); return e
            } function g(a, d, e) {
                this.editor = a; this.name = d; this.value = e; this.context = "p"; d = a.config.justifyClasses; var g = a.config.enterMode == CKEDITOR.ENTER_P ? "p" : "div"; if (d) {
                    switch (e) { case "left": this.cssClassName = d[0]; break; case "center": this.cssClassName = d[1]; break; case "right": this.cssClassName = d[2]; break; case "justify": this.cssClassName = d[3] }this.cssClassRegex = new RegExp("(?:^|\\s+)(?:" + d.join("|") + ")(?\x3d$|\\s)"); this.requiredContent =
                        g + "(" + this.cssClassName + ")"
                } else this.requiredContent = g + "{text-align}"; this.allowedContent = { "caption div h1 h2 h3 h4 h5 h6 p pre td th li": { propertiesOnly: !0, styles: this.cssClassName ? null : "text-align", classes: this.cssClassName || null } }; a.config.enterMode == CKEDITOR.ENTER_BR && (this.allowedContent.div = !0)
            } function e(a) {
                var d = a.editor, e = d.createRange(); e.setStartBefore(a.data.node); e.setEndAfter(a.data.node); for (var g = new CKEDITOR.dom.walker(e), l; l = g.next();)if (l.type == CKEDITOR.NODE_ELEMENT) if (!l.equals(a.data.node) &&
                    l.getDirection()) e.setStartAfter(l), g = new CKEDITOR.dom.walker(e); else { var c = d.config.justifyClasses; c && (l.hasClass(c[0]) ? (l.removeClass(c[0]), l.addClass(c[2])) : l.hasClass(c[2]) && (l.removeClass(c[2]), l.addClass(c[0]))); c = l.getStyle("text-align"); "left" == c ? l.setStyle("text-align", "right") : "right" == c && l.setStyle("text-align", "left") }
            } g.prototype = {
                exec: function (b) {
                    var d = b.getSelection(), e = b.config.enterMode; if (d) {
                        for (var g = d.createBookmarks(), l = d.getRanges(), c = this.cssClassName, k, f, n = b.config.useComputedState,
                            n = void 0 === n || n, p = l.length - 1; 0 <= p; p--)for (k = l[p].createIterator(), k.enlargeBr = e != CKEDITOR.ENTER_BR; f = k.getNextParagraph(e == CKEDITOR.ENTER_P ? "p" : "div");)if (!f.isReadOnly()) {
                                var t = f.getName(), q; q = b.activeFilter.check(t + "{text-align}"); if ((t = b.activeFilter.check(t + "(" + c + ")")) || q) {
                                    f.removeAttribute("align"); f.removeStyle("text-align"); var r = c && (f.$.className = CKEDITOR.tools.ltrim(f.$.className.replace(this.cssClassRegex, ""))), w = this.state == CKEDITOR.TRISTATE_OFF && (!n || a(f, !0) != this.value); c && t ? w ? f.addClass(c) :
                                        r || f.removeAttribute("class") : w && q && f.setStyle("text-align", this.value)
                                }
                            } b.focus(); b.forceNextSelectionCheck(); d.selectBookmarks(g)
                    }
                }, refresh: function (b, d) {
                    var e = d.block || d.blockLimit, g = e.getName(), l = e.equals(b.editable()), g = this.cssClassName ? b.activeFilter.check(g + "(" + this.cssClassName + ")") : b.activeFilter.check(g + "{text-align}"); l && !CKEDITOR.dtd.$list[d.lastElement.getName()] ? this.setState(CKEDITOR.TRISTATE_OFF) : !l && g ? this.setState(a(e, this.editor.config.useComputedState) == this.value ? CKEDITOR.TRISTATE_ON :
                        CKEDITOR.TRISTATE_OFF) : this.setState(CKEDITOR.TRISTATE_DISABLED)
                }
            }; CKEDITOR.plugins.add("justify", {
                init: function (a) {
                    if (!a.blockless) {
                        var d = new g(a, "justifyleft", "left"), m = new g(a, "justifycenter", "center"), h = new g(a, "justifyright", "right"), l = new g(a, "justifyblock", "justify"); a.addCommand("justifyleft", d); a.addCommand("justifycenter", m); a.addCommand("justifyright", h); a.addCommand("justifyblock", l); a.ui.addButton && (a.ui.addButton("JustifyLeft", { label: a.lang.common.alignLeft, command: "justifyleft", toolbar: "align,10" }),
                            a.ui.addButton("JustifyCenter", { label: a.lang.common.center, command: "justifycenter", toolbar: "align,20" }), a.ui.addButton("JustifyRight", { label: a.lang.common.alignRight, command: "justifyright", toolbar: "align,30" }), a.ui.addButton("JustifyBlock", { label: a.lang.common.justify, command: "justifyblock", toolbar: "align,40" })); a.on("dirChanged", e)
                    }
                }
            })
        })(); CKEDITOR.plugins.add("menubutton", {
            requires: "button,menu", onLoad: function () {
                var a = function (a) {
                    var e = this._, b = e.menu; e.state !== CKEDITOR.TRISTATE_DISABLED && (e.on &&
                        b ? b.hide() : (e.previousState = e.state, b || (b = e.menu = new CKEDITOR.menu(a, { panel: { className: "cke_menu_panel", attributes: { "aria-label": a.lang.common.options } } }), b.onHide = CKEDITOR.tools.bind(function () { var b = this.command ? a.getCommand(this.command).modes : this.modes; this.setState(!b || b[a.mode] ? e.previousState : CKEDITOR.TRISTATE_DISABLED); e.on = 0 }, this), this.onMenu && b.addListener(this.onMenu)), this.setState(CKEDITOR.TRISTATE_ON), e.on = 1, setTimeout(function () { b.show(CKEDITOR.document.getById(e.id), 4) }, 0)))
                }; CKEDITOR.ui.menuButton =
                    CKEDITOR.tools.createClass({ base: CKEDITOR.ui.button, $: function (g) { delete g.panel; this.base(g); this.hasArrow = "menu"; this.click = a }, statics: { handler: { create: function (a) { return new CKEDITOR.ui.menuButton(a) } } } })
            }, beforeInit: function (a) { a.ui.addHandler(CKEDITOR.UI_MENUBUTTON, CKEDITOR.ui.menuButton.handler) }
        }); CKEDITOR.UI_MENUBUTTON = "menubutton"; "use strict"; (function () {
            CKEDITOR.plugins.add("language", {
                requires: "menubutton", init: function (a) {
                    var g = a.config.language_list || ["ar:Arabic:rtl", "fr:French", "es:Spanish"],
                    e = this, b = a.lang.language, d = {}, m, h, l, c; a.addCommand("language", { allowedContent: "span[!lang,!dir]", requiredContent: "span[lang,dir]", contextSensitive: !0, exec: function (a, b) { var c = d["language_" + b]; if (c) a[c.style.checkActive(a.elementPath(), a) ? "removeStyle" : "applyStyle"](c.style) }, refresh: function (a) { this.setState(e.getCurrentLangElement(a) ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF) } }); for (c = 0; c < g.length; c++)m = g[c].split(":"), h = m[0], l = "language_" + h, d[l] = {
                        label: m[1], langId: h, group: "language", order: c, ltr: "rtl" !=
                            ("" + m[2]).toLowerCase(), onClick: function () { a.execCommand("language", this.langId) }, role: "menuitemcheckbox"
                    }, d[l].style = new CKEDITOR.style({ element: "span", attributes: { lang: h, dir: d[l].ltr ? "ltr" : "rtl" } }); d.language_remove = { label: b.remove, group: "language_remove", state: CKEDITOR.TRISTATE_DISABLED, order: d.length, onClick: function () { var b = e.getCurrentLangElement(a); b && a.execCommand("language", b.getAttribute("lang")) } }; a.addMenuGroup("language", 1); a.addMenuGroup("language_remove"); a.addMenuItems(d); a.ui.add("Language",
                        CKEDITOR.UI_MENUBUTTON, { label: b.button, allowedContent: "span[!lang,!dir]", requiredContent: "span[lang,dir]", toolbar: "bidi,30", command: "language", onMenu: function () { var b = {}, c = e.getCurrentLangElement(a), g; for (g in d) b[g] = CKEDITOR.TRISTATE_OFF; b.language_remove = c ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED; c && (b["language_" + c.getAttribute("lang")] = CKEDITOR.TRISTATE_ON); return b } }); a.addRemoveFormatFilter && a.addRemoveFormatFilter(function (a) { return !(a.is("span") && a.getAttribute("dir") && a.getAttribute("lang")) })
                },
                getCurrentLangElement: function (a) { var g = a.elementPath(); a = g && g.elements; var e; if (g) for (var b = 0; b < a.length; b++)g = a[b], !e && "span" == g.getName() && g.hasAttribute("dir") && g.hasAttribute("lang") && (e = g); return e }
            })
        })(); "use strict"; (function () {
            function a(a) { return a.replace(/'/g, "\\$\x26") } function g(a) { for (var b = a.length, c = [], d, e = 0; e < b; e++)d = a.charCodeAt(e), c.push(d); return "String.fromCharCode(" + c.join(",") + ")" } function e(b, c) {
                for (var d = b.plugins.link, e = d.compiledProtectionFunction.params, d = [d.compiledProtectionFunction.name,
                    "("], f, g, h = 0; h < e.length; h++)f = e[h].toLowerCase(), g = c[f], 0 < h && d.push(","), d.push("'", g ? a(encodeURIComponent(c[f])) : "", "'"); d.push(")"); return d.join("")
            } function b(a) { a = a.config.emailProtection || ""; var b; a && "encode" != a && (b = {}, a.replace(/^([^(]+)\(([^)]+)\)$/, function (a, c, d) { b.name = c; b.params = []; d.replace(/[^,\s]+/g, function (a) { b.params.push(a) }) })); return b } CKEDITOR.plugins.add("link", {
                requires: "dialog,fakeobjects", onLoad: function () {
                    function a(b) {
                        return c.replace(/%1/g, "rtl" == b ? "right" : "left").replace(/%2/g,
                            "cke_contents_" + b)
                    } var b = "background:url(" + CKEDITOR.getUrl(this.path + "images" + (CKEDITOR.env.hidpi ? "/hidpi" : "") + "/anchor.png") + ") no-repeat %1 center;border:1px dotted #00f;background-size:16px;", c = ".%2 a.cke_anchor,.%2 a.cke_anchor_empty,.cke_editable.%2 a[name],.cke_editable.%2 a[data-cke-saved-name]{" + b + "padding-%1:18px;cursor:auto;}.%2 img.cke_anchor{" + b + "width:16px;min-height:15px;height:1.15em;vertical-align:text-bottom;}"; CKEDITOR.addCss(a("ltr") + a("rtl"))
                }, init: function (a) {
                    var c = "a[!href]";
                    CKEDITOR.dialog.isTabEnabled(a, "link", "advanced") && (c = c.replace("]", ",accesskey,charset,dir,id,lang,name,rel,tabindex,title,type,download]{*}(*)")); CKEDITOR.dialog.isTabEnabled(a, "link", "target") && (c = c.replace("]", ",target,onclick]")); a.addCommand("link", new CKEDITOR.dialogCommand("link", { allowedContent: c, requiredContent: "a[href]" })); a.addCommand("anchor", new CKEDITOR.dialogCommand("anchor", { allowedContent: "a[!name,id]", requiredContent: "a[name]" })); a.addCommand("unlink", new CKEDITOR.unlinkCommand);
                    a.addCommand("removeAnchor", new CKEDITOR.removeAnchorCommand); a.setKeystroke(CKEDITOR.CTRL + 76, "link"); a.setKeystroke(CKEDITOR.CTRL + 75, "link"); a.ui.addButton && (a.ui.addButton("Link", { label: a.lang.link.toolbar, command: "link", toolbar: "links,10" }), a.ui.addButton("Unlink", { label: a.lang.link.unlink, command: "unlink", toolbar: "links,20" }), a.ui.addButton("Anchor", { label: a.lang.link.anchor.toolbar, command: "anchor", toolbar: "links,30" })); CKEDITOR.dialog.add("link", this.path + "dialogs/link.js"); CKEDITOR.dialog.add("anchor",
                        this.path + "dialogs/anchor.js"); a.on("doubleclick", function (b) { var c = b.data.element.getAscendant({ a: 1, img: 1 }, !0); c && !c.isReadOnly() && (c.is("a") ? (b.data.dialog = !c.getAttribute("name") || c.getAttribute("href") && c.getChildCount() ? "link" : "anchor", b.data.link = c) : CKEDITOR.plugins.link.tryRestoreFakeAnchor(a, c) && (b.data.dialog = "anchor")) }, null, null, 0); a.on("doubleclick", function (b) { b.data.dialog in { link: 1, anchor: 1 } && b.data.link && a.getSelection().selectElement(b.data.link) }, null, null, 20); a.addMenuItems && a.addMenuItems({
                            anchor: {
                                label: a.lang.link.anchor.menu,
                                command: "anchor", group: "anchor", order: 1
                            }, removeAnchor: { label: a.lang.link.anchor.remove, command: "removeAnchor", group: "anchor", order: 5 }, link: { label: a.lang.link.menu, command: "link", group: "link", order: 1 }, unlink: { label: a.lang.link.unlink, command: "unlink", group: "link", order: 5 }
                        }); a.contextMenu && a.contextMenu.addListener(function (b) {
                            if (!b || b.isReadOnly()) return null; b = CKEDITOR.plugins.link.tryRestoreFakeAnchor(a, b); if (!b && !(b = CKEDITOR.plugins.link.getSelectedLink(a))) return null; var c = {}; b.getAttribute("href") &&
                                b.getChildCount() && (c = { link: CKEDITOR.TRISTATE_OFF, unlink: CKEDITOR.TRISTATE_OFF }); b && b.hasAttribute("name") && (c.anchor = c.removeAnchor = CKEDITOR.TRISTATE_OFF); return c
                        }); this.compiledProtectionFunction = b(a)
                }, afterInit: function (a) {
                    a.dataProcessor.dataFilter.addRules({ elements: { a: function (b) { return b.attributes.name ? b.children.length ? null : a.createFakeParserElement(b, "cke_anchor", "anchor") : null } } }); var b = a._.elementsPath && a._.elementsPath.filters; b && b.push(function (b, c) {
                        if ("a" == c && (CKEDITOR.plugins.link.tryRestoreFakeAnchor(a,
                            b) || b.getAttribute("name") && (!b.getAttribute("href") || !b.getChildCount()))) return "anchor"
                    })
                }
            }); var d = /^javascript:/, m = /^(?:mailto)(?:(?!\?(subject|body)=).)+/i, h = /subject=([^;?:@&=$,\/]*)/i, l = /body=([^;?:@&=$,\/]*)/i, c = /^#(.*)$/, k = /^((?:http|https|ftp|news):\/\/)?(.*)$/, f = /^(_(?:self|top|parent|blank))$/, n = /^javascript:void\(location\.href='mailto:'\+String\.fromCharCode\(([^)]+)\)(?:\+'(.*)')?\)$/, p = /^javascript:([^(]+)\(([^)]+)\)$/, t = /\s*window.open\(\s*this\.href\s*,\s*(?:'([^']*)'|null)\s*,\s*'([^']*)'\s*\)\s*;\s*return\s*false;*\s*/,
                q = /(?:^|,)([^=]+)=(\d+|yes|no)/gi, r = /^tel:(.*)$/, w = { id: "advId", dir: "advLangDir", accessKey: "advAccessKey", name: "advName", lang: "advLangCode", tabindex: "advTabIndex", title: "advTitle", type: "advContentType", "class": "advCSSClasses", charset: "advCharset", style: "advStyles", rel: "advRel" }; CKEDITOR.plugins.link = {
                    getSelectedLink: function (a, b) {
                        var c = a.getSelection(), d = c.getSelectedElement(), e = c.getRanges(), f = [], g; if (!b && d && d.is("a")) return d; for (d = 0; d < e.length; d++)if (g = c.getRanges()[d], g.shrink(CKEDITOR.SHRINK_ELEMENT,
                            !0, { skipBogus: !0 }), (g = a.elementPath(g.getCommonAncestor()).contains("a", 1)) && b) f.push(g); else if (g) return g; return b ? f : null
                    }, getEditorAnchors: function (a) {
                        for (var b = a.editable(), c = b.isInline() && !a.plugins.divarea ? a.document : b, b = c.getElementsByTag("a"), c = c.getElementsByTag("img"), d = [], e = 0, f; f = b.getItem(e++);)(f.data("cke-saved-name") || f.hasAttribute("name")) && d.push({ name: f.data("cke-saved-name") || f.getAttribute("name"), id: f.getAttribute("id") }); for (e = 0; f = c.getItem(e++);)(f = this.tryRestoreFakeAnchor(a,
                            f)) && d.push({ name: f.getAttribute("name"), id: f.getAttribute("id") }); return d
                    }, fakeAnchor: !0, tryRestoreFakeAnchor: function (a, b) { if (b && b.data("cke-real-element-type") && "anchor" == b.data("cke-real-element-type")) { var c = a.restoreRealElement(b); if (c.data("cke-saved-name")) return c } }, parseLinkAttributes: function (a, b) {
                        var e = b && (b.data("cke-saved-href") || b.getAttribute("href")) || "", g = a.plugins.link.compiledProtectionFunction, z = a.config.emailProtection, y = {}, B; e.match(d) && ("encode" == z ? e = e.replace(n, function (a,
                            b, c) { c = c || ""; return "mailto:" + String.fromCharCode.apply(String, b.split(",")) + c.replace(/\\'/g, "'") }) : z && e.replace(p, function (a, b, c) { if (b == g.name) { y.type = "email"; a = y.email = {}; b = /(^')|('$)/g; c = c.match(/[^,\s]+/g); for (var d = c.length, e, f, h = 0; h < d; h++)e = decodeURIComponent, f = c[h].replace(b, "").replace(/\\'/g, "'"), f = e(f), e = g.params[h].toLowerCase(), a[e] = f; a.address = [a.name, a.domain].join("@") } })); if (!y.type) if (z = e.match(c)) y.type = "anchor", y.anchor = {}, y.anchor.name = y.anchor.id = z[1]; else if (z = e.match(r)) y.type =
                                "tel", y.tel = z[1]; else if (z = e.match(m)) { B = e.match(h); var e = e.match(l), C = y.email = {}; y.type = "email"; C.address = z[0].replace("mailto:", ""); B && (C.subject = decodeURIComponent(B[1])); e && (C.body = decodeURIComponent(e[1])) } else e && (B = e.match(k)) && (y.type = "url", y.url = {}, y.url.protocol = B[1], y.url.url = B[2]); if (b) {
                                    if (e = b.getAttribute("target")) y.target = { type: e.match(f) ? e : "frame", name: e }; else if (e = (e = b.data("cke-pa-onclick") || b.getAttribute("onclick")) && e.match(t)) for (y.target = { type: "popup", name: e[1] }; z = q.exec(e[2]);)"yes" !=
                                        z[2] && "1" != z[2] || z[1] in { height: 1, width: 1, top: 1, left: 1 } ? isFinite(z[2]) && (y.target[z[1]] = z[2]) : y.target[z[1]] = !0; null !== b.getAttribute("download") && (y.download = !0); var e = {}, F; for (F in w) (z = b.getAttribute(F)) && (e[w[F]] = z); if (F = b.data("cke-saved-name") || e.advName) e.advName = F; CKEDITOR.tools.isEmpty(e) || (y.advanced = e)
                                } return y
                    }, getLinkAttributes: function (b, c) {
                        var d = b.config.emailProtection || "", f = {}; switch (c.type) {
                            case "url": var d = c.url && void 0 !== c.url.protocol ? c.url.protocol : "http://", h = c.url && CKEDITOR.tools.trim(c.url.url) ||
                                ""; f["data-cke-saved-href"] = 0 === h.indexOf("/") ? h : d + h; break; case "anchor": d = c.anchor && c.anchor.id; f["data-cke-saved-href"] = "#" + (c.anchor && c.anchor.name || d || ""); break; case "email": var k = c.email, h = k.address; switch (d) {
                                    case "": case "encode": var l = encodeURIComponent(k.subject || ""), m = encodeURIComponent(k.body || ""), k = []; l && k.push("subject\x3d" + l); m && k.push("body\x3d" + m); k = k.length ? "?" + k.join("\x26") : ""; "encode" == d ? (d = ["javascript:void(location.href\x3d'mailto:'+", g(h)], k && d.push("+'", a(k), "'"), d.push(")")) :
                                        d = ["mailto:", h, k]; break; default: d = h.split("@", 2), k.name = d[0], k.domain = d[1], d = ["javascript:", e(b, k)]
                                }f["data-cke-saved-href"] = d.join(""); break; case "tel": f["data-cke-saved-href"] = "tel:" + c.tel
                        }if (c.target) if ("popup" == c.target.type) {
                            for (var d = ["window.open(this.href, '", c.target.name || "", "', '"], n = "resizable status location toolbar menubar fullscreen scrollbars dependent".split(" "), h = n.length, l = function (a) { c.target[a] && n.push(a + "\x3d" + c.target[a]) }, k = 0; k < h; k++)n[k] += c.target[n[k]] ? "\x3dyes" : "\x3dno";
                            l("width"); l("left"); l("height"); l("top"); d.push(n.join(","), "'); return false;"); f["data-cke-pa-onclick"] = d.join("")
                        } else "notSet" != c.target.type && c.target.name && (f.target = c.target.name); c.download && (f.download = ""); if (c.advanced) { for (var r in w) (d = c.advanced[w[r]]) && (f[r] = d); f.name && (f["data-cke-saved-name"] = f.name) } f["data-cke-saved-href"] && (f.href = f["data-cke-saved-href"]); r = { target: 1, onclick: 1, "data-cke-pa-onclick": 1, "data-cke-saved-name": 1, download: 1 }; c.advanced && CKEDITOR.tools.extend(r, w); for (var p in f) delete r[p];
                        return { set: f, removed: CKEDITOR.tools.object.keys(r) }
                    }, showDisplayTextForElement: function (a, b) { var c = { img: 1, table: 1, tbody: 1, thead: 1, tfoot: 1, input: 1, select: 1, textarea: 1 }, d = b.getSelection(); return b.widgets && b.widgets.focused || d && 1 < d.getRanges().length ? !1 : !a || !a.getName || !a.is(c) }
                }; CKEDITOR.unlinkCommand = function () { }; CKEDITOR.unlinkCommand.prototype = {
                    exec: function (a) {
                        if (CKEDITOR.env.ie) {
                            var b = a.getSelection().getRanges()[0], c = b.getPreviousEditableNode() && b.getPreviousEditableNode().getAscendant("a", !0) ||
                                b.getNextEditableNode() && b.getNextEditableNode().getAscendant("a", !0), d; b.collapsed && c && (d = b.createBookmark(), b.selectNodeContents(c), b.select())
                        } c = new CKEDITOR.style({ element: "a", type: CKEDITOR.STYLE_INLINE, alwaysRemoveElement: 1 }); a.removeStyle(c); d && (b.moveToBookmark(d), b.select())
                    }, refresh: function (a, b) { var c = b.lastElement && b.lastElement.getAscendant("a", !0); c && "a" == c.getName() && c.getAttribute("href") && c.getChildCount() ? this.setState(CKEDITOR.TRISTATE_OFF) : this.setState(CKEDITOR.TRISTATE_DISABLED) },
                    contextSensitive: 1, startDisabled: 1, requiredContent: "a[href]", editorFocus: 1
                }; CKEDITOR.removeAnchorCommand = function () { }; CKEDITOR.removeAnchorCommand.prototype = {
                    exec: function (a) {
                        var b = a.getSelection(), c = b.createBookmarks(), d; if (b && (d = b.getSelectedElement()) && (d.getChildCount() ? d.is("a") : CKEDITOR.plugins.link.tryRestoreFakeAnchor(a, d))) d.remove(1); else if (d = CKEDITOR.plugins.link.getSelectedLink(a)) d.hasAttribute("href") ? (d.removeAttributes({ name: 1, "data-cke-saved-name": 1 }), d.removeClass("cke_anchor")) :
                            d.remove(1); b.selectBookmarks(c)
                    }, requiredContent: "a[name]"
                }; CKEDITOR.tools.extend(CKEDITOR.config, { linkShowAdvancedTab: !0, linkShowTargetTab: !0, linkDefaultProtocol: "http://" })
        })(); (function () {
            function a(a, b, c, d) {
                for (var e = CKEDITOR.plugins.list.listToArray(b.root, c), f = [], g = 0; g < b.contents.length; g++) { var h = b.contents[g]; (h = h.getAscendant("li", !0)) && !h.getCustomData("list_item_processed") && (f.push(h), CKEDITOR.dom.element.setMarker(c, h, "list_item_processed", !0)) } for (var h = b.root.getDocument(), k, l, g = 0; g <
                    f.length; g++) { var m = f[g].getCustomData("listarray_index"); k = e[m].parent; k.is(this.type) || (l = h.createElement(this.type), k.copyAttributes(l, { start: 1, type: 1 }), l.removeStyle("list-style-type"), e[m].parent = l) } c = CKEDITOR.plugins.list.arrayToList(e, c, null, a.config.enterMode); for (var n, e = c.listNode.getChildCount(), g = 0; g < e && (n = c.listNode.getChild(g)); g++)n.getName() == this.type && d.push(n); c.listNode.replace(b.root); a.fire("contentDomInvalidated")
            } function g(a, b, c) {
                var d = b.contents, e = b.root.getDocument(), f =
                    []; if (1 == d.length && d[0].equals(b.root)) { var g = e.createElement("div"); d[0].moveChildren && d[0].moveChildren(g); d[0].append(g); d[0] = g } b = b.contents[0].getParent(); for (g = 0; g < d.length; g++)b = b.getCommonAncestor(d[g].getParent()); a = a.config.useComputedState; var h, k; a = void 0 === a || a; for (g = 0; g < d.length; g++)for (var l = d[g], m; m = l.getParent();) { if (m.equals(b)) { f.push(l); !k && l.getDirection() && (k = 1); l = l.getDirection(a); null !== h && (h = h && h != l ? null : l); break } l = m } if (!(1 > f.length)) {
                        d = f[f.length - 1].getNext(); g = e.createElement(this.type);
                        for (c.push(g); f.length;)c = f.shift(), a = e.createElement("li"), l = c, l.is("pre") || q.test(l.getName()) || "false" == l.getAttribute("contenteditable") ? c.appendTo(a) : (c.copyAttributes(a), h && c.getDirection() && (a.removeStyle("direction"), a.removeAttribute("dir")), c.moveChildren(a), c.remove()), a.appendTo(g); h && k && g.setAttribute("dir", h); d ? g.insertBefore(d) : g.appendTo(b)
                    }
            } function e(a, b, c) {
                function d(c) {
                    if (!(!(l = k[c ? "getFirst" : "getLast"]()) || l.is && l.isBlockBoundary() || !(m = b.root[c ? "getPrevious" : "getNext"](CKEDITOR.dom.walker.invisible(!0))) ||
                        m.is && m.isBlockBoundary({ br: 1 }))) a.document.createElement("br")[c ? "insertBefore" : "insertAfter"](l)
                } for (var e = CKEDITOR.plugins.list.listToArray(b.root, c), f = [], g = 0; g < b.contents.length; g++) { var h = b.contents[g]; (h = h.getAscendant("li", !0)) && !h.getCustomData("list_item_processed") && (f.push(h), CKEDITOR.dom.element.setMarker(c, h, "list_item_processed", !0)) } h = null; for (g = 0; g < f.length; g++)h = f[g].getCustomData("listarray_index"), e[h].indent = -1; for (g = h + 1; g < e.length; g++)if (e[g].indent > e[g - 1].indent + 1) {
                    f = e[g - 1].indent +
                    1 - e[g].indent; for (h = e[g].indent; e[g] && e[g].indent >= h;)e[g].indent += f, g++; g--
                } var k = CKEDITOR.plugins.list.arrayToList(e, c, null, a.config.enterMode, b.root.getAttribute("dir")).listNode, l, m; d(!0); d(); k.replace(b.root); a.fire("contentDomInvalidated")
            } function b(a, b) { this.name = a; this.context = this.type = b; this.allowedContent = b + " li"; this.requiredContent = b } function d(a, b, c, d) {
                for (var e, f; e = a[d ? "getLast" : "getFirst"](r);)(f = e.getDirection(1)) !== b.getDirection(1) && e.setAttribute("dir", f), e.remove(), c ? e[d ? "insertBefore" :
                    "insertAfter"](c) : b.append(e, d), c = e
            } function m(a) { function b(c) { var e = a[c ? "getPrevious" : "getNext"](p); e && e.type == CKEDITOR.NODE_ELEMENT && e.is(a.getName()) && (d(a, e, null, !c), a.remove(), a = e) } b(); b(1) } function h(a) { return a.type == CKEDITOR.NODE_ELEMENT && (a.getName() in CKEDITOR.dtd.$block || a.getName() in CKEDITOR.dtd.$listItem) && CKEDITOR.dtd[a.getName()]["#"] } function l(a, b, e) {
                a.fire("saveSnapshot"); e.enlarge(CKEDITOR.ENLARGE_LIST_ITEM_CONTENTS); var f = e.extractContents(); b.trim(!1, !0); var g = b.createBookmark(),
                    h = new CKEDITOR.dom.elementPath(b.startContainer), k = h.block, h = h.lastElement.getAscendant("li", 1) || k, l = new CKEDITOR.dom.elementPath(e.startContainer), n = l.contains(CKEDITOR.dtd.$listItem), l = l.contains(CKEDITOR.dtd.$list); k ? (k = k.getBogus()) && k.remove() : l && (k = l.getPrevious(p)) && t(k) && k.remove(); (k = f.getLast()) && k.type == CKEDITOR.NODE_ELEMENT && k.is("br") && k.remove(); (k = b.startContainer.getChild(b.startOffset)) ? f.insertBefore(k) : b.startContainer.append(f); n && (f = c(n)) && (h.contains(n) ? (d(f, n.getParent(), n),
                        f.remove()) : h.append(f)); for (; e.checkStartOfBlock() && e.checkEndOfBlock();) { l = e.startPath(); f = l.block; if (!f) break; f.is("li") && (h = f.getParent(), f.equals(h.getLast(p)) && f.equals(h.getFirst(p)) && (f = h)); e.moveToPosition(f, CKEDITOR.POSITION_BEFORE_START); f.remove() } e = e.clone(); f = a.editable(); e.setEndAt(f, CKEDITOR.POSITION_BEFORE_END); e = new CKEDITOR.dom.walker(e); e.evaluator = function (a) { return p(a) && !t(a) }; (e = e.next()) && e.type == CKEDITOR.NODE_ELEMENT && e.getName() in CKEDITOR.dtd.$list && m(e); b.moveToBookmark(g);
                b.select(); a.fire("saveSnapshot")
            } function c(a) { return (a = a.getLast(p)) && a.type == CKEDITOR.NODE_ELEMENT && a.getName() in k ? a : null } var k = { ol: 1, ul: 1 }, f = CKEDITOR.dom.walker.whitespaces(), n = CKEDITOR.dom.walker.bookmark(), p = function (a) { return !(f(a) || n(a)) }, t = CKEDITOR.dom.walker.bogus(); CKEDITOR.plugins.list = {
                listToArray: function (a, b, c, d, e) {
                    if (!k[a.getName()]) return []; d || (d = 0); c || (c = []); for (var f = 0, g = a.getChildCount(); f < g; f++) {
                        var h = a.getChild(f); h.type == CKEDITOR.NODE_ELEMENT && h.getName() in CKEDITOR.dtd.$list &&
                            CKEDITOR.plugins.list.listToArray(h, b, c, d + 1); if ("li" == h.$.nodeName.toLowerCase()) {
                                var l = { parent: a, indent: d, element: h, contents: [] }; e ? l.grandparent = e : (l.grandparent = a.getParent(), l.grandparent && "li" == l.grandparent.$.nodeName.toLowerCase() && (l.grandparent = l.grandparent.getParent())); b && CKEDITOR.dom.element.setMarker(b, h, "listarray_index", c.length); c.push(l); for (var m = 0, n = h.getChildCount(), r; m < n; m++)r = h.getChild(m), r.type == CKEDITOR.NODE_ELEMENT && k[r.getName()] ? CKEDITOR.plugins.list.listToArray(r, b, c,
                                    d + 1, l.grandparent) : l.contents.push(r)
                            }
                    } return c
                }, arrayToList: function (a, b, c, d, e) {
                    c || (c = 0); if (!a || a.length < c + 1) return null; for (var f, g = a[c].parent.getDocument(), h = new CKEDITOR.dom.documentFragment(g), l = null, m = c, r = Math.max(a[c].indent, 0), t = null, q, D, M = d == CKEDITOR.ENTER_P ? "p" : "div"; ;) {
                        var J = a[m]; f = J.grandparent; q = J.element.getDirection(1); if (J.indent == r) {
                            l && a[m].parent.getName() == l.getName() || (l = a[m].parent.clone(!1, 1), e && l.setAttribute("dir", e), h.append(l)); t = l.append(J.element.clone(0, 1)); q != l.getDirection(1) &&
                                t.setAttribute("dir", q); for (f = 0; f < J.contents.length; f++)t.append(J.contents[f].clone(1, 1)); m++
                        } else if (J.indent == Math.max(r, 0) + 1) J = a[m - 1].element.getDirection(1), m = CKEDITOR.plugins.list.arrayToList(a, null, m, d, J != q ? q : null), !t.getChildCount() && CKEDITOR.env.needsNbspFiller && 7 >= g.$.documentMode && t.append(g.createText(" ")), t.append(m.listNode), m = m.nextIndex; else if (-1 == J.indent && !c && f) {
                            k[f.getName()] ? (t = J.element.clone(!1, !0), q != f.getDirection(1) && t.setAttribute("dir", q)) : t = new CKEDITOR.dom.documentFragment(g);
                            var l = f.getDirection(1) != q, K = J.element, E = K.getAttribute("class"), R = K.getAttribute("style"), P = t.type == CKEDITOR.NODE_DOCUMENT_FRAGMENT && (d != CKEDITOR.ENTER_BR || l || R || E), N, X = J.contents.length, U; for (f = 0; f < X; f++)if (N = J.contents[f], n(N) && 1 < X) P ? U = N.clone(1, 1) : t.append(N.clone(1, 1)); else if (N.type == CKEDITOR.NODE_ELEMENT && N.isBlockBoundary()) {
                                l && !N.getDirection() && N.setAttribute("dir", q); D = N; var Y = K.getAttribute("style"); Y && D.setAttribute("style", Y.replace(/([^;])$/, "$1;") + (D.getAttribute("style") || "")); E &&
                                    N.addClass(E); D = null; U && (t.append(U), U = null); t.append(N.clone(1, 1))
                            } else P ? (D || (D = g.createElement(M), t.append(D), l && D.setAttribute("dir", q)), R && D.setAttribute("style", R), E && D.setAttribute("class", E), U && (D.append(U), U = null), D.append(N.clone(1, 1))) : t.append(N.clone(1, 1)); U && ((D || t).append(U), U = null); t.type == CKEDITOR.NODE_DOCUMENT_FRAGMENT && m != a.length - 1 && (CKEDITOR.env.needsBrFiller && (q = t.getLast()) && q.type == CKEDITOR.NODE_ELEMENT && q.is("br") && q.remove(), (q = t.getLast(p)) && q.type == CKEDITOR.NODE_ELEMENT &&
                                q.is(CKEDITOR.dtd.$block) || t.append(g.createElement("br"))); q = t.$.nodeName.toLowerCase(); "div" != q && "p" != q || t.appendBogus(); h.append(t); l = null; m++
                        } else return null; D = null; if (a.length <= m || Math.max(a[m].indent, 0) < r) break
                    } if (b) for (a = h.getFirst(); a;) { if (a.type == CKEDITOR.NODE_ELEMENT && (CKEDITOR.dom.element.clearMarkers(b, a), a.getName() in CKEDITOR.dtd.$listItem && (c = a, g = e = d = void 0, d = c.getDirection()))) { for (e = c.getParent(); e && !(g = e.getDirection());)e = e.getParent(); d == g && c.removeAttribute("dir") } a = a.getNextSourceNode() } return {
                        listNode: h,
                        nextIndex: m
                    }
                }
            }; var q = /^h[1-6]$/, r = CKEDITOR.dom.walker.nodeType(CKEDITOR.NODE_ELEMENT); b.prototype = {
                exec: function (b) {
                    function c(a) { return k[a.root.getName()] && !d(a.root, [CKEDITOR.NODE_COMMENT]) } function d(a, b) { return CKEDITOR.tools.array.filter(a.getChildren().toArray(), function (a) { return -1 === CKEDITOR.tools.array.indexOf(b, a.type) }).length } function f(a) { var b = !0; if (0 === a.getChildCount()) return !1; a.forEach(function (a) { if (a.type !== CKEDITOR.NODE_COMMENT) return b = !1 }, null, !0); return b } this.refresh(b, b.elementPath());
                    var h = b.config, l = b.getSelection(), n = l && l.getRanges(); if (this.state == CKEDITOR.TRISTATE_OFF) { var r = b.editable(); if (r.getFirst(p)) { var t = 1 == n.length && n[0]; (h = t && t.getEnclosedNode()) && h.is && this.type == h.getName() && this.setState(CKEDITOR.TRISTATE_ON) } else h.enterMode == CKEDITOR.ENTER_BR ? r.appendBogus() : n[0].fixBlock(1, h.enterMode == CKEDITOR.ENTER_P ? "p" : "div"), l.selectRanges(n) } for (var h = l.createBookmarks(!0), r = [], q = {}, n = n.createIterator(), G = 0; (t = n.getNextRange()) && ++G;) {
                        var I = t.getBoundaryNodes(), H = I.startNode,
                        D = I.endNode; H.type == CKEDITOR.NODE_ELEMENT && "td" == H.getName() && t.setStartAt(I.startNode, CKEDITOR.POSITION_AFTER_START); D.type == CKEDITOR.NODE_ELEMENT && "td" == D.getName() && t.setEndAt(I.endNode, CKEDITOR.POSITION_BEFORE_END); t = t.createIterator(); for (t.forceBrBreak = this.state == CKEDITOR.TRISTATE_OFF; I = t.getNextParagraph();)if (!I.getCustomData("list_block") && !f(I)) {
                            CKEDITOR.dom.element.setMarker(q, I, "list_block", 1); for (var M = b.elementPath(I), H = M.elements, D = 0, M = M.blockLimit, J, K = H.length - 1; 0 <= K && (J = H[K]); K--)if (k[J.getName()] &&
                                M.contains(J)) { M.removeCustomData("list_group_object_" + G); (H = J.getCustomData("list_group_object")) ? H.contents.push(I) : (H = { root: J, contents: [I] }, r.push(H), CKEDITOR.dom.element.setMarker(q, J, "list_group_object", H)); D = 1; break } D || (D = M, D.getCustomData("list_group_object_" + G) ? D.getCustomData("list_group_object_" + G).contents.push(I) : (H = { root: D, contents: [I] }, CKEDITOR.dom.element.setMarker(q, D, "list_group_object_" + G, H), r.push(H)))
                        }
                    } for (J = []; 0 < r.length;)H = r.shift(), this.state == CKEDITOR.TRISTATE_OFF ? c(H) || (k[H.root.getName()] ?
                        a.call(this, b, H, q, J) : g.call(this, b, H, J)) : this.state == CKEDITOR.TRISTATE_ON && k[H.root.getName()] && !c(H) && e.call(this, b, H, q); for (K = 0; K < J.length; K++)m(J[K]); CKEDITOR.dom.element.clearAllMarkers(q); l.selectBookmarks(h); b.focus()
                }, refresh: function (a, b) { var c = b.contains(k, 1), d = b.blockLimit || b.root; c && d.contains(c) ? this.setState(c.is(this.type) ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF) : this.setState(CKEDITOR.TRISTATE_OFF) }
            }; CKEDITOR.plugins.add("list", {
                requires: "indentlist", init: function (a) {
                    a.blockless ||
                    (a.addCommand("numberedlist", new b("numberedlist", "ol")), a.addCommand("bulletedlist", new b("bulletedlist", "ul")), a.ui.addButton && (a.ui.addButton("NumberedList", { label: a.lang.list.numberedlist, command: "numberedlist", directional: !0, toolbar: "list,10" }), a.ui.addButton("BulletedList", { label: a.lang.list.bulletedlist, command: "bulletedlist", directional: !0, toolbar: "list,20" })), a.on("key", function (b) {
                        var d = b.data.domEvent.getKey(), e; if ("wysiwyg" == a.mode && d in { 8: 1, 46: 1 }) {
                            var f = a.getSelection().getRanges()[0],
                            g = f && f.startPath(); if (f && f.collapsed) {
                                var m = 8 == d, n = a.editable(), r = new CKEDITOR.dom.walker(f.clone()); r.evaluator = function (a) { return p(a) && !t(a) }; r.guard = function (a, b) { return !(b && a.type == CKEDITOR.NODE_ELEMENT && a.is("table")) }; d = f.clone(); if (m) {
                                    var q; (q = g.contains(k)) && f.checkBoundaryOfElement(q, CKEDITOR.START) && (q = q.getParent()) && q.is("li") && (q = c(q)) ? (e = q, q = q.getPrevious(p), d.moveToPosition(q && t(q) ? q : e, CKEDITOR.POSITION_BEFORE_START)) : (r.range.setStartAt(n, CKEDITOR.POSITION_AFTER_START), r.range.setEnd(f.startContainer,
                                        f.startOffset), (q = r.previous()) && q.type == CKEDITOR.NODE_ELEMENT && (q.getName() in k || q.is("li")) && (q.is("li") || (r.range.selectNodeContents(q), r.reset(), r.evaluator = h, q = r.previous()), e = q, d.moveToElementEditEnd(e), d.moveToPosition(d.endPath().block, CKEDITOR.POSITION_BEFORE_END))); if (e) l(a, d, f), b.cancel(); else {
                                            var G = g.contains(k); G && f.checkBoundaryOfElement(G, CKEDITOR.START) && (e = G.getFirst(p), f.checkBoundaryOfElement(e, CKEDITOR.START) && (q = G.getPrevious(p), c(e) ? q && (f.moveToElementEditEnd(q), f.select()) :
                                                a.execCommand("outdent"), b.cancel()))
                                        }
                                } else if (e = g.contains("li")) {
                                    if (r.range.setEndAt(n, CKEDITOR.POSITION_BEFORE_END), m = (n = e.getLast(p)) && h(n) ? n : e, g = 0, (q = r.next()) && q.type == CKEDITOR.NODE_ELEMENT && q.getName() in k && q.equals(n) ? (g = 1, q = r.next()) : f.checkBoundaryOfElement(m, CKEDITOR.END) && (g = 2), g && q) {
                                        f = f.clone(); f.moveToElementEditStart(q); if (1 == g && (d.optimize(), !d.startContainer.equals(e))) { for (e = d.startContainer; e.is(CKEDITOR.dtd.$inline);)G = e, e = e.getParent(); G && d.moveToPosition(G, CKEDITOR.POSITION_AFTER_END) } 2 ==
                                            g && (d.moveToPosition(d.endPath().block, CKEDITOR.POSITION_BEFORE_END), f.endPath().block && f.moveToPosition(f.endPath().block, CKEDITOR.POSITION_AFTER_START)); l(a, d, f); b.cancel()
                                    }
                                } else r.range.setEndAt(n, CKEDITOR.POSITION_BEFORE_END), (q = r.next()) && q.type == CKEDITOR.NODE_ELEMENT && q.is(k) && (q = q.getFirst(p), g.block && f.checkStartOfBlock() && f.checkEndOfBlock() ? (g.block.remove(), f.moveToElementEditStart(q), f.select()) : c(q) ? (f.moveToElementEditStart(q), f.select()) : (f = f.clone(), f.moveToElementEditStart(q), l(a,
                                    d, f)), b.cancel()); setTimeout(function () { a.selectionChange(1) })
                            }
                        }
                    }))
                }
            })
        })(); (function () {
            CKEDITOR.plugins.liststyle = {
                requires: "dialog,contextmenu", init: function (a) {
                    if (!a.blockless) {
                        var g; g = new CKEDITOR.dialogCommand("numberedListStyle", { requiredContent: "ol", allowedContent: "ol{list-style-type}[start]; li{list-style-type}[value]", contentTransformations: [["ol: listTypeToStyle"]] }); g = a.addCommand("numberedListStyle", g); a.addFeature(g); CKEDITOR.dialog.add("numberedListStyle", this.path + "dialogs/liststyle.js");
                        g = new CKEDITOR.dialogCommand("bulletedListStyle", { requiredContent: "ul", allowedContent: "ul{list-style-type}", contentTransformations: [["ul: listTypeToStyle"]] }); g = a.addCommand("bulletedListStyle", g); a.addFeature(g); CKEDITOR.dialog.add("bulletedListStyle", this.path + "dialogs/liststyle.js"); a.addMenuGroup("list", 108); a.addMenuItems({ numberedlist: { label: a.lang.liststyle.numberedTitle, group: "list", command: "numberedListStyle" }, bulletedlist: { label: a.lang.liststyle.bulletedTitle, group: "list", command: "bulletedListStyle" } });
                        a.contextMenu.addListener(function (a) { if (!a || a.isReadOnly()) return null; for (; a;) { var b = a.getName(); if ("ol" == b) return { numberedlist: CKEDITOR.TRISTATE_OFF }; if ("ul" == b) return { bulletedlist: CKEDITOR.TRISTATE_OFF }; a = a.getParent() } return null })
                    }
                }
            }; CKEDITOR.plugins.add("liststyle", CKEDITOR.plugins.liststyle)
        })(); "use strict"; (function () {
            function a(a, b, c) { return n(b) && n(c) && c.equals(b.getNext(function (a) { return !(Q(a) || T(a) || p(a)) })) } function g(a) { this.upper = a[0]; this.lower = a[1]; this.set.apply(this, a.slice(2)) }
            function e(a) { var b = a.element; if (b && n(b) && (b = b.getAscendant(a.triggers, !0)) && a.editable.contains(b)) { var c = h(b); if ("true" == c.getAttribute("contenteditable")) return b; if (c.is(a.triggers)) return c } return null } function b(a, b, c) { v(a, b); v(a, c); a = b.size.bottom; c = c.size.top; return a && c ? 0 | (a + c) / 2 : a || c } function d(a, b, c) { return b = b[c ? "getPrevious" : "getNext"](function (b) { return b && b.type == CKEDITOR.NODE_TEXT && !Q(b) || n(b) && !p(b) && !f(a, b) }) } function m(a, b, c) { return a > b && a < c } function h(a, b) {
                if (a.data("cke-editable")) return null;
                for (b || (a = a.getParent()); a && !a.data("cke-editable");) { if (a.hasAttribute("contenteditable")) return a; a = a.getParent() } return null
            } function l(a) {
                var b = a.doc, d = G('\x3cspan contenteditable\x3d"false" data-cke-magic-line\x3d"1" style\x3d"' + ba + "position:absolute;border-top:1px dashed " + a.boxColor + '"\x3e\x3c/span\x3e', b), e = CKEDITOR.getUrl(this.path + "images/" + (I.hidpi ? "hidpi/" : "") + "icon" + (a.rtl ? "-rtl" : "") + ".png"); C(d, {
                    attach: function () { this.wrap.getParent() || this.wrap.appendTo(a.editable, !0); return this },
                    lineChildren: [C(G('\x3cspan title\x3d"' + a.editor.lang.magicline.title + '" contenteditable\x3d"false"\x3e\x26#8629;\x3c/span\x3e', b), { base: ba + "height:17px;width:17px;" + (a.rtl ? "left" : "right") + ":17px;background:url(" + e + ") center no-repeat " + a.boxColor + ";cursor:pointer;" + (I.hc ? "font-size: 15px;line-height:14px;border:1px solid #fff;text-align:center;" : "") + (I.hidpi ? "background-size: 9px 10px;" : ""), looks: ["top:-8px; border-radius: 2px;", "top:-17px; border-radius: 2px 2px 0px 0px;", "top:-1px; border-radius: 0px 0px 2px 2px;"] }),
                    C(G(da, b), { base: W + "left:0px;border-left-color:" + a.boxColor + ";", looks: ["border-width:8px 0 8px 8px;top:-8px", "border-width:8px 0 0 8px;top:-8px", "border-width:0 0 8px 8px;top:0px"] }), C(G(da, b), { base: W + "right:0px;border-right-color:" + a.boxColor + ";", looks: ["border-width:8px 8px 8px 0;top:-8px", "border-width:8px 8px 0 0;top:-8px", "border-width:0 8px 8px 0;top:0px"] })], detach: function () { this.wrap.getParent() && this.wrap.remove(); return this }, mouseNear: function () {
                        v(a, this); var b = a.holdDistance, c = this.size;
                        return c && m(a.mouse.y, c.top - b, c.bottom + b) && m(a.mouse.x, c.left - b, c.right + b) ? !0 : !1
                    }, place: function () {
                        var b = a.view, c = a.editable, d = a.trigger, e = d.upper, f = d.lower, g = e || f, h = g.getParent(), k = {}; this.trigger = d; e && v(a, e, !0); f && v(a, f, !0); v(a, h, !0); a.inInlineMode && z(a, !0); h.equals(c) ? (k.left = b.scroll.x, k.right = -b.scroll.x, k.width = "") : (k.left = g.size.left - g.size.margin.left + b.scroll.x - (a.inInlineMode ? b.editable.left + b.editable.border.left : 0), k.width = g.size.outerWidth + g.size.margin.left + g.size.margin.right + b.scroll.x,
                            k.right = ""); e && f ? k.top = e.size.margin.bottom === f.size.margin.top ? 0 | e.size.bottom + e.size.margin.bottom / 2 : e.size.margin.bottom < f.size.margin.top ? e.size.bottom + e.size.margin.bottom : e.size.bottom + e.size.margin.bottom - f.size.margin.top : e ? f || (k.top = e.size.bottom + e.size.margin.bottom) : k.top = f.size.top - f.size.margin.top; d.is(P) || m(k.top, b.scroll.y - 15, b.scroll.y + 5) ? (k.top = a.inInlineMode ? 0 : b.scroll.y, this.look(P)) : d.is(N) || m(k.top, b.pane.bottom - 5, b.pane.bottom + 15) ? (k.top = a.inInlineMode ? b.editable.height + b.editable.padding.top +
                                b.editable.padding.bottom : b.pane.bottom - 1, this.look(N)) : (a.inInlineMode && (k.top -= b.editable.top + b.editable.border.top), this.look(X)); a.inInlineMode && (k.top--, k.top += b.editable.scroll.top, k.left += b.editable.scroll.left); for (var l in k) k[l] = CKEDITOR.tools.cssLength(k[l]); this.setStyles(k)
                    }, look: function (a) { if (this.oldLook != a) { for (var b = this.lineChildren.length, c; b--;)(c = this.lineChildren[b]).setAttribute("style", c.base + c.looks[0 | a / 2]); this.oldLook = a } }, wrap: new F("span", a.doc)
                }); for (b = d.lineChildren.length; b--;)d.lineChildren[b].appendTo(d);
                d.look(X); d.appendTo(d.wrap); d.unselectable(); d.lineChildren[0].on("mouseup", function (b) { d.detach(); c(a, function (b) { var c = a.line.trigger; b[c.is(J) ? "insertBefore" : "insertAfter"](c.is(J) ? c.lower : c.upper) }, !0); a.editor.focus(); I.ie || a.enterMode == CKEDITOR.ENTER_BR || a.hotNode.scrollIntoView(); b.data.preventDefault(!0) }); d.on("mousedown", function (a) { a.data.preventDefault(!0) }); a.line = d
            } function c(a, b, c) {
                var d = new CKEDITOR.dom.range(a.doc), e = a.editor, f; I.ie && a.enterMode == CKEDITOR.ENTER_BR ? f = a.doc.createText(U) :
                    (f = (f = h(a.element, !0)) && f.data("cke-enter-mode") || a.enterMode, f = new F(M[f], a.doc), f.is("br") || a.doc.createText(U).appendTo(f)); c && e.fire("saveSnapshot"); b(f); d.moveToPosition(f, CKEDITOR.POSITION_AFTER_START); e.getSelection().selectRanges([d]); a.hotNode = f; c && e.fire("saveSnapshot")
            } function k(a, b) {
                return {
                    canUndo: !0, modes: { wysiwyg: 1 }, exec: function () {
                        function f(d) {
                            var e = I.ie && 9 > I.version ? " " : U, g = a.hotNode && a.hotNode.getText() == e && a.element.equals(a.hotNode) && a.lastCmdDirection === !!b; c(a, function (c) {
                                g &&
                                a.hotNode && a.hotNode.remove(); c[b ? "insertAfter" : "insertBefore"](d); c.setAttributes({ "data-cke-magicline-hot": 1, "data-cke-magicline-dir": !!b }); a.lastCmdDirection = !!b
                            }); I.ie || a.enterMode == CKEDITOR.ENTER_BR || a.hotNode.scrollIntoView(); a.line.detach()
                        } return function (c) {
                            c = c.getSelection().getStartElement(); var g; c = c.getAscendant(V, 1); if (!r(a, c) && c && !c.equals(a.editable) && !c.contains(a.editable)) {
                                (g = h(c)) && "false" == g.getAttribute("contenteditable") && (c = g); a.element = c; g = d(a, c, !b); var k; n(g) && g.is(a.triggers) &&
                                    g.is(O) && (!d(a, g, !b) || (k = d(a, g, !b)) && n(k) && k.is(a.triggers)) ? f(g) : (k = e(a, c), n(k) && (d(a, k, !b) ? (c = d(a, k, !b)) && n(c) && c.is(a.triggers) && f(k) : f(k)))
                            }
                        }
                    }()
                }
            } function f(a, b) { if (!b || b.type != CKEDITOR.NODE_ELEMENT || !b.$) return !1; var c = a.line; return c.wrap.equals(b) || c.wrap.contains(b) } function n(a) { return a && a.type == CKEDITOR.NODE_ELEMENT && a.$ } function p(a) { if (!n(a)) return !1; var b; (b = t(a)) || (n(a) ? (b = { left: 1, right: 1, center: 1 }, b = !(!b[a.getComputedStyle("float")] && !b[a.getAttribute("align")])) : b = !1); return b } function t(a) {
                return !!{
                    absolute: 1,
                    fixed: 1
                }[a.getComputedStyle("position")]
            } function q(a, b) { return n(b) ? b.is(a.triggers) : null } function r(a, b) { if (!b) return !1; for (var c = b.getParents(1), d = c.length; d--;)for (var e = a.tabuList.length; e--;)if (c[d].hasAttribute(a.tabuList[e])) return !0; return !1 } function w(a, b, c) { b = b[c ? "getLast" : "getFirst"](function (b) { return a.isRelevant(b) && !b.is(ha) }); if (!b) return !1; v(a, b); return c ? b.size.top > a.mouse.y : b.size.bottom < a.mouse.y } function x(a) {
                var b = a.editable, c = a.mouse, d = a.view, e = a.triggerOffset; z(a); var h = c.y >
                    (a.inInlineMode ? d.editable.top + d.editable.height / 2 : Math.min(d.editable.height, d.pane.height) / 2), b = b[h ? "getLast" : "getFirst"](function (a) { return !(Q(a) || T(a)) }); if (!b) return null; f(a, b) && (b = a.line.wrap[h ? "getPrevious" : "getNext"](function (a) { return !(Q(a) || T(a)) })); if (!n(b) || p(b) || !q(a, b)) return null; v(a, b); return !h && 0 <= b.size.top && m(c.y, 0, b.size.top + e) ? (a = a.inInlineMode || 0 === d.scroll.y ? P : X, new g([null, b, J, R, a])) : h && b.size.bottom <= d.pane.height && m(c.y, b.size.bottom - e, d.pane.height) ? (a = a.inInlineMode ||
                        m(b.size.bottom, d.pane.height - e, d.pane.height) ? N : X, new g([b, null, K, R, a])) : null
            } function u(a) {
                var b = a.mouse, c = a.view, f = a.triggerOffset, h = e(a); if (!h) return null; v(a, h); var f = Math.min(f, 0 | h.size.outerHeight / 2), k = [], l, L; if (m(b.y, h.size.top - 1, h.size.top + f)) L = !1; else if (m(b.y, h.size.bottom - f, h.size.bottom + 1)) L = !0; else return null; if (p(h) || w(a, h, L) || h.getParent().is(Y)) return null; var r = d(a, h, !L); if (r) {
                    if (r && r.type == CKEDITOR.NODE_TEXT) return null; if (n(r)) {
                        if (p(r) || !q(a, r) || r.getParent().is(Y)) return null;
                        k = [r, h][L ? "reverse" : "concat"]().concat([E, R])
                    }
                } else h.equals(a.editable[L ? "getLast" : "getFirst"](a.isRelevant)) ? (z(a), L && m(b.y, h.size.bottom - f, c.pane.height) && m(h.size.bottom, c.pane.height - f, c.pane.height) ? l = N : m(b.y, 0, h.size.top + f) && (l = P)) : l = X, k = [null, h][L ? "reverse" : "concat"]().concat([L ? K : J, R, l, h.equals(a.editable[L ? "getLast" : "getFirst"](a.isRelevant)) ? L ? N : P : X]); return 0 in k ? new g(k) : null
            } function A(a, b, c, d) {
                for (var e = b.getDocumentPosition(), f = {}, g = {}, h = {}, k = {}, l = L.length; l--;)f[L[l]] = parseInt(b.getComputedStyle.call(b,
                    "border-" + L[l] + "-width"), 10) || 0, h[L[l]] = parseInt(b.getComputedStyle.call(b, "padding-" + L[l]), 10) || 0, g[L[l]] = parseInt(b.getComputedStyle.call(b, "margin-" + L[l]), 10) || 0; c && !d || y(a, d); k.top = e.y - (c ? 0 : a.view.scroll.y); k.left = e.x - (c ? 0 : a.view.scroll.x); k.outerWidth = b.$.offsetWidth; k.outerHeight = b.$.offsetHeight; k.height = k.outerHeight - (h.top + h.bottom + f.top + f.bottom); k.width = k.outerWidth - (h.left + h.right + f.left + f.right); k.bottom = k.top + k.outerHeight; k.right = k.left + k.outerWidth; a.inInlineMode && (k.scroll = {
                        top: b.$.scrollTop,
                        left: b.$.scrollLeft
                    }); return C({ border: f, padding: h, margin: g, ignoreScroll: c }, k, !0)
            } function v(a, b, c) { if (!n(b)) return b.size = null; if (!b.size) b.size = {}; else if (b.size.ignoreScroll == c && b.size.date > new Date - aa) return null; return C(b.size, A(a, b, c), { date: +new Date }, !0) } function z(a, b) { a.view.editable = A(a, a.editable, b, !0) } function y(a, b) {
                a.view || (a.view = {}); var c = a.view; if (!(!b && c && c.date > new Date - aa)) {
                    var d = a.win, c = d.getScrollPosition(), d = d.getViewPaneSize(); C(a.view, {
                        scroll: {
                            x: c.x, y: c.y, width: a.doc.$.documentElement.scrollWidth -
                                d.width, height: a.doc.$.documentElement.scrollHeight - d.height
                        }, pane: { width: d.width, height: d.height, bottom: d.height + c.y }, date: +new Date
                    }, !0)
                }
            } function B(a, b, c, d) { for (var e = d, f = d, h = 0, k = !1, l = !1, m = a.view.pane.height, n = a.mouse; n.y + h < m && 0 < n.y - h;) { k || (k = b(e, d)); l || (l = b(f, d)); !k && 0 < n.y - h && (e = c(a, { x: n.x, y: n.y - h })); !l && n.y + h < m && (f = c(a, { x: n.x, y: n.y + h })); if (k && l) break; h += 2 } return new g([e, f, null, null]) } CKEDITOR.plugins.add("magicline", {
                init: function (a) {
                    var b = a.config, h = b.magicline_triggerOffset || 30, m = {
                        editor: a,
                        enterMode: b.enterMode, triggerOffset: h, holdDistance: 0 | h * (b.magicline_holdDistance || .5), boxColor: b.magicline_color || "#ff0000", rtl: "rtl" == b.contentsLangDirection, tabuList: ["data-cke-hidden-sel"].concat(b.magicline_tabuList || []), triggers: b.magicline_everywhere ? V : { table: 1, hr: 1, div: 1, ul: 1, ol: 1, dl: 1, form: 1, blockquote: 1 }
                    }, L, w, v; m.isRelevant = function (a) { return n(a) && !f(m, a) && !p(a) }; a.on("contentDom", function () {
                        var h = a.editable(), n = a.document, p = a.window; C(m, {
                            editable: h, inInlineMode: h.isInline(), doc: n, win: p,
                            hotNode: null
                        }, !0); m.boundary = m.inInlineMode ? m.editable : m.doc.getDocumentElement(); h.is(D.$inline) || (m.inInlineMode && !t(h) && h.setStyles({ position: "relative", top: null, left: null }), l.call(this, m), y(m), h.attachListener(a, "beforeUndoImage", function () { m.line.detach() }), h.attachListener(a, "beforeGetData", function () { m.line.wrap.getParent() && (m.line.detach(), a.once("getData", function () { m.line.attach() }, null, null, 1E3)) }, null, null, 0), h.attachListener(m.inInlineMode ? n : n.getWindow().getFrame(), "mouseout", function (b) {
                            if ("wysiwyg" ==
                                a.mode) if (m.inInlineMode) { var c = b.data.$.clientX; b = b.data.$.clientY; y(m); z(m, !0); var d = m.view.editable, e = m.view.scroll; c > d.left - e.x && c < d.right - e.x && b > d.top - e.y && b < d.bottom - e.y || (clearTimeout(v), v = null, m.line.detach()) } else clearTimeout(v), v = null, m.line.detach()
                        }), h.attachListener(h, "keyup", function () { m.hiddenMode = 0 }), h.attachListener(h, "keydown", function (b) { if ("wysiwyg" == a.mode) switch (b.data.getKeystroke()) { case 2228240: case 16: m.hiddenMode = 1, m.line.detach() } }), h.attachListener(m.inInlineMode ? h : n,
                            "mousemove", function (b) { w = !0; if ("wysiwyg" == a.mode && !a.readOnly && !v) { var c = { x: b.data.$.clientX, y: b.data.$.clientY }; v = setTimeout(function () { m.mouse = c; v = m.trigger = null; y(m); w && !m.hiddenMode && a.focusManager.hasFocus && !m.line.mouseNear() && (m.element = Z(m, !0)) && ((m.trigger = x(m) || u(m) || S(m)) && !r(m, m.trigger.upper || m.trigger.lower) ? m.line.attach().place() : (m.trigger = null, m.line.detach()), w = !1) }, 30) } }), h.attachListener(p, "scroll", function () {
                                "wysiwyg" == a.mode && (m.line.detach(), I.webkit && (m.hiddenMode = 1, clearTimeout(L),
                                    L = setTimeout(function () { m.mouseDown || (m.hiddenMode = 0) }, 50)))
                            }), h.attachListener(H ? n : p, "mousedown", function () { "wysiwyg" == a.mode && (m.line.detach(), m.hiddenMode = 1, m.mouseDown = 1) }), h.attachListener(H ? n : p, "mouseup", function () { m.hiddenMode = 0; m.mouseDown = 0 }), a.addCommand("accessPreviousSpace", k(m)), a.addCommand("accessNextSpace", k(m, !0)), a.setKeystroke([[b.magicline_keystrokePrevious, "accessPreviousSpace"], [b.magicline_keystrokeNext, "accessNextSpace"]]), a.on("loadSnapshot", function () {
                                var b, c, d, e; for (e in {
                                    p: 1,
                                    br: 1, div: 1
                                }) for (b = a.document.getElementsByTag(e), d = b.count(); d--;)if ((c = b.getItem(d)).data("cke-magicline-hot")) { m.hotNode = c; m.lastCmdDirection = "true" === c.data("cke-magicline-dir") ? !0 : !1; return }
                            }), a._.magiclineBackdoor = { accessFocusSpace: c, boxTrigger: g, isLine: f, getAscendantTrigger: e, getNonEmptyNeighbour: d, getSize: A, that: m, triggerEdge: u, triggerEditable: x, triggerExpand: S })
                    }, this)
                }
            }); var C = CKEDITOR.tools.extend, F = CKEDITOR.dom.element, G = F.createFromHtml, I = CKEDITOR.env, H = CKEDITOR.env.ie && 9 > CKEDITOR.env.version,
                D = CKEDITOR.dtd, M = {}, J = 128, K = 64, E = 32, R = 16, P = 4, N = 2, X = 1, U = " ", Y = D.$listItem, ha = D.$tableContent, O = C({}, D.$nonEditable, D.$empty), V = D.$block, aa = 100, ba = "width:0px;height:0px;padding:0px;margin:0px;display:block;z-index:9999;color:#fff;position:absolute;font-size: 0px;line-height:0px;", W = ba + "border-color:transparent;display:block;border-style:solid;", da = "\x3cspan\x3e" + U + "\x3c/span\x3e"; M[CKEDITOR.ENTER_BR] = "br"; M[CKEDITOR.ENTER_P] = "p"; M[CKEDITOR.ENTER_DIV] = "div"; g.prototype = {
                    set: function (a, b, c) {
                        this.properties =
                        a + b + (c || X); return this
                    }, is: function (a) { return (this.properties & a) == a }
                }; var Z = function () { function a(b, c) { var d = b.$.elementFromPoint(c.x, c.y); return d && d.nodeType ? new CKEDITOR.dom.element(d) : null } return function (b, c, d) { if (!b.mouse) return null; var e = b.doc, g = b.line.wrap; d = d || b.mouse; var h = a(e, d); c && f(b, h) && (g.hide(), h = a(e, d), g.show()); return !h || h.type != CKEDITOR.NODE_ELEMENT || !h.$ || I.ie && 9 > I.version && !b.boundary.equals(h) && !b.boundary.contains(h) ? null : h } }(), Q = CKEDITOR.dom.walker.whitespaces(), T = CKEDITOR.dom.walker.nodeType(CKEDITOR.NODE_COMMENT),
                    S = function () {
                        function c(e) {
                            var f = e.element, g, h, k; if (!n(f) || f.contains(e.editable) || f.isReadOnly()) return null; k = B(e, function (a, b) { return !b.equals(a) }, function (a, b) { return Z(a, !0, b) }, f); g = k.upper; h = k.lower; if (a(e, g, h)) return k.set(E, 8); if (g && f.contains(g)) for (; !g.getParent().equals(f);)g = g.getParent(); else g = f.getFirst(function (a) { return d(e, a) }); if (h && f.contains(h)) for (; !h.getParent().equals(f);)h = h.getParent(); else h = f.getLast(function (a) { return d(e, a) }); if (!g || !h) return null; v(e, g); v(e, h); if (!m(e.mouse.y,
                                g.size.top, h.size.bottom)) return null; for (var f = Number.MAX_VALUE, l, L, r, y; h && !h.equals(g) && (L = g.getNext(e.isRelevant));)l = Math.abs(b(e, g, L) - e.mouse.y), l < f && (f = l, r = g, y = L), g = L, v(e, g); if (!r || !y || !m(e.mouse.y, r.size.top, y.size.bottom)) return null; k.upper = r; k.lower = y; return k.set(E, 8)
                        } function d(a, b) { return !(b && b.type == CKEDITOR.NODE_TEXT || T(b) || p(b) || f(a, b) || b.type == CKEDITOR.NODE_ELEMENT && b.$ && b.is("br")) } return function (b) {
                            var d = c(b), e; if (e = d) {
                                e = d.upper; var f = d.lower; e = !e || !f || p(f) || p(e) || f.equals(e) ||
                                    e.equals(f) || f.contains(e) || e.contains(f) ? !1 : q(b, e) && q(b, f) && a(b, e, f) ? !0 : !1
                            } return e ? d : null
                        }
                    }(), L = ["top", "left", "right", "bottom"]
        })(); CKEDITOR.config.magicline_keystrokePrevious = CKEDITOR.CTRL + CKEDITOR.SHIFT + 51; CKEDITOR.config.magicline_keystrokeNext = CKEDITOR.CTRL + CKEDITOR.SHIFT + 52; (function () {
            function a(a) {
                if (!a || a.type != CKEDITOR.NODE_ELEMENT || "form" != a.getName()) return []; for (var b = [], d = ["style", "className"], c = 0; c < d.length; c++) {
                    var e = a.$.elements.namedItem(d[c]); e && (e = new CKEDITOR.dom.element(e),
                        b.push([e, e.nextSibling]), e.remove())
                } return b
            } function g(a, b) { if (a && a.type == CKEDITOR.NODE_ELEMENT && "form" == a.getName() && 0 < b.length) for (var d = b.length - 1; 0 <= d; d--) { var c = b[d][0], e = b[d][1]; e ? c.insertBefore(e) : c.appendTo(a) } } function e(b, d) { var e = a(b), c = {}, k = b.$; d || (c["class"] = k.className || "", k.className = ""); c.inline = k.style.cssText || ""; d || (k.style.cssText = "position: static; overflow: visible"); g(e); return c } function b(b, d) {
                var e = a(b), c = b.$; "class" in d && (c.className = d["class"]); "inline" in d && (c.style.cssText =
                    d.inline); g(e)
            } function d(a) { if (!a.editable().isInline()) { var b = CKEDITOR.instances, d; for (d in b) { var c = b[d]; "wysiwyg" != c.mode || c.readOnly || (c = c.document.getBody(), c.setAttribute("contentEditable", !1), c.setAttribute("contentEditable", !0)) } a.editable().hasFocus && (a.toolbox.focus(), a.focus()) } } CKEDITOR.plugins.add("maximize", {
                init: function (a) {
                    function g() { var b = k.getViewPaneSize(); a.resize(b.width, b.height, null, !0) } if (a.elementMode != CKEDITOR.ELEMENT_MODE_INLINE) {
                        var l = a.lang, c = CKEDITOR.document, k = c.getWindow(),
                        f, n, p, t = CKEDITOR.TRISTATE_OFF; a.addCommand("maximize", {
                            modes: { wysiwyg: !CKEDITOR.env.iOS, source: !CKEDITOR.env.iOS }, readOnly: 1, editorFocus: !1, exec: function () {
                                var q = a.container.getFirst(function (a) { return a.type == CKEDITOR.NODE_ELEMENT && a.hasClass("cke_inner") }), r = a.ui.space("contents"); if ("wysiwyg" == a.mode) { var w = a.getSelection(); f = w && w.getRanges(); n = k.getScrollPosition() } else { var x = a.editable().$; f = !CKEDITOR.env.ie && [x.selectionStart, x.selectionEnd]; n = [x.scrollLeft, x.scrollTop] } if (this.state == CKEDITOR.TRISTATE_OFF) {
                                    k.on("resize",
                                        g); p = k.getScrollPosition(); for (w = a.container; w = w.getParent();)w.setCustomData("maximize_saved_styles", e(w)), w.setStyle("z-index", a.config.baseFloatZIndex - 5); r.setCustomData("maximize_saved_styles", e(r, !0)); q.setCustomData("maximize_saved_styles", e(q, !0)); r = { overflow: CKEDITOR.env.webkit ? "" : "hidden", width: 0, height: 0 }; c.getDocumentElement().setStyles(r); !CKEDITOR.env.gecko && c.getDocumentElement().setStyle("position", "fixed"); CKEDITOR.env.gecko && CKEDITOR.env.quirks || c.getBody().setStyles(r); CKEDITOR.env.ie ?
                                            setTimeout(function () { k.$.scrollTo(0, 0) }, 0) : k.$.scrollTo(0, 0); q.setStyle("position", CKEDITOR.env.gecko && CKEDITOR.env.quirks ? "fixed" : "absolute"); q.$.offsetLeft; q.setStyles({ "z-index": a.config.baseFloatZIndex - 5, left: "0px", top: "0px" }); q.addClass("cke_maximized"); g(); r = q.getDocumentPosition(); q.setStyles({ left: -1 * r.x + "px", top: -1 * r.y + "px" }); CKEDITOR.env.gecko && d(a)
                                } else if (this.state == CKEDITOR.TRISTATE_ON) {
                                    k.removeListener("resize", g); for (var w = [r, q], u = 0; u < w.length; u++)b(w[u], w[u].getCustomData("maximize_saved_styles")),
                                        w[u].removeCustomData("maximize_saved_styles"); for (w = a.container; w = w.getParent();)b(w, w.getCustomData("maximize_saved_styles")), w.removeCustomData("maximize_saved_styles"); CKEDITOR.env.ie ? setTimeout(function () { k.$.scrollTo(p.x, p.y) }, 0) : k.$.scrollTo(p.x, p.y); q.removeClass("cke_maximized"); CKEDITOR.env.webkit && (q.setStyle("display", "inline"), setTimeout(function () { q.setStyle("display", "block") }, 0)); a.fire("resize", { outerHeight: a.container.$.offsetHeight, contentsHeight: r.$.offsetHeight, outerWidth: a.container.$.offsetWidth })
                                } this.toggleState();
                                if (w = this.uiItems[0]) r = this.state == CKEDITOR.TRISTATE_OFF ? l.maximize.maximize : l.maximize.minimize, w = CKEDITOR.document.getById(w._.id), w.getChild(1).setHtml(r), w.setAttribute("title", r), w.setAttribute("href", 'javascript:void("' + r + '");'); "wysiwyg" == a.mode ? f ? (CKEDITOR.env.gecko && d(a), a.getSelection().selectRanges(f), (x = a.getSelection().getStartElement()) && x.scrollIntoView(!0)) : k.$.scrollTo(n.x, n.y) : (f && (x.selectionStart = f[0], x.selectionEnd = f[1]), x.scrollLeft = n[0], x.scrollTop = n[1]); f = n = null; t = this.state;
                                a.fire("maximize", this.state)
                            }, canUndo: !1
                        }); a.ui.addButton && a.ui.addButton("Maximize", { label: l.maximize.maximize, command: "maximize", toolbar: "tools,10" }); a.on("mode", function () { var b = a.getCommand("maximize"); b.setState(b.state == CKEDITOR.TRISTATE_DISABLED ? CKEDITOR.TRISTATE_DISABLED : t) }, null, null, 100)
                    }
                }
            })
        })(); CKEDITOR.plugins.add("newpage", {
            init: function (a) {
                a.addCommand("newpage", {
                    modes: { wysiwyg: 1, source: 1 }, exec: function (a) {
                        var e = this; a.setData(a.config.newpage_html || "", function () {
                            a.focus(); setTimeout(function () {
                                a.fire("afterCommandExec",
                                    { name: "newpage", command: e }); a.selectionChange()
                            }, 200)
                        })
                    }, async: !0
                }); a.ui.addButton && a.ui.addButton("NewPage", { label: a.lang.newpage.toolbar, command: "newpage", toolbar: "document,20" })
            }
        }); "use strict"; (function () {
            function a(a) { return { "aria-label": a, "class": "cke_pagebreak", contenteditable: "false", "data-cke-display-name": "pagebreak", "data-cke-pagebreak": 1, style: "page-break-after: always", title: a } } CKEDITOR.plugins.add("pagebreak", {
                requires: "fakeobjects", onLoad: function () {
                    var a = ("background:url(" + CKEDITOR.getUrl(this.path +
                        "images/pagebreak.gif") + ") no-repeat center center;clear:both;width:100%;border-top:#999 1px dotted;border-bottom:#999 1px dotted;padding:0;height:7px;cursor:default;").replace(/;/g, " !important;"); CKEDITOR.addCss("div.cke_pagebreak{" + a + "}")
                }, init: function (a) {
                    a.blockless || (a.addCommand("pagebreak", CKEDITOR.plugins.pagebreakCmd), a.ui.addButton && a.ui.addButton("PageBreak", { label: a.lang.pagebreak.toolbar, command: "pagebreak", toolbar: "insert,70" }), CKEDITOR.env.webkit && a.on("contentDom", function () {
                        a.document.on("click",
                            function (e) { e = e.data.getTarget(); e.is("div") && e.hasClass("cke_pagebreak") && a.getSelection().selectElement(e) })
                    }))
                }, afterInit: function (g) {
                    function e(b) { CKEDITOR.tools.extend(b.attributes, a(g.lang.pagebreak.alt), !0); b.children.length = 0 } var b = g.dataProcessor, d = b && b.dataFilter, b = b && b.htmlFilter, m = /page-break-after\s*:\s*always/i, h = /display\s*:\s*none/i; b && b.addRules({
                        attributes: {
                            "class": function (a, b) {
                                var d = a.replace("cke_pagebreak", ""); if (d != a) {
                                    var e = CKEDITOR.htmlParser.fragment.fromHtml('\x3cspan style\x3d"display: none;"\x3e\x26nbsp;\x3c/span\x3e').children[0];
                                    b.children.length = 0; b.add(e); e = b.attributes; delete e["aria-label"]; delete e.contenteditable; delete e.title
                                } return d
                            }
                        }
                    }, { applyToAll: !0, priority: 5 }); d && d.addRules({ elements: { div: function (a) { if (a.attributes["data-cke-pagebreak"]) e(a); else if (m.test(a.attributes.style)) { var b = a.children[0]; b && "span" == b.name && h.test(b.attributes.style) && e(a) } } } })
                }
            }); CKEDITOR.plugins.pagebreakCmd = {
                exec: function (a) { a.insertElement(CKEDITOR.plugins.pagebreak.createElement(a)) }, context: "div", allowedContent: {
                    div: { styles: "!page-break-after" },
                    span: { match: function (a) { return (a = a.parent) && "div" == a.name && a.styles && a.styles["page-break-after"] }, styles: "display" }
                }, requiredContent: "div{page-break-after}"
            }; CKEDITOR.plugins.pagebreak = { createElement: function (g) { return g.document.createElement("div", { attributes: a(g.lang.pagebreak.alt) }) } }
        })(); (function () {
            function a(a, b) { return CKEDITOR.tools.array.filter(a, function (a) { return a.canHandle(b) }).sort(function (a, b) { return a.priority === b.priority ? 0 : a.priority - b.priority }) } function g(a, b) {
                var c = a.shift();
                c && c.handle(b, function () { g(a, b) })
            } function e(a) { var b = CKEDITOR.tools.array.reduce(a, function (a, b) { return CKEDITOR.tools.array.isArray(b.filters) ? a.concat(b.filters) : a }, []); return CKEDITOR.tools.array.filter(b, function (a, d) { return CKEDITOR.tools.array.indexOf(b, a) === d }) } function b(a, b) {
                var c = 0, e, f; if (!CKEDITOR.tools.array.isArray(a) || 0 === a.length) return !0; e = CKEDITOR.tools.array.filter(a, function (a) { return -1 === CKEDITOR.tools.array.indexOf(d, a) }); if (0 < e.length) for (f = 0; f < e.length; f++)(function (a) {
                    CKEDITOR.scriptLoader.queue(a,
                        function (f) { f && d.push(a); ++c === e.length && b() })
                })(e[f]); return 0 === e.length
            } var d = [], m = CKEDITOR.tools.createClass({ $: function () { this.handlers = [] }, proto: { register: function (a) { "number" !== typeof a.priority && (a.priority = 10); this.handlers.push(a) }, addPasteListener: function (d) { d.on("paste", function (l) { var c = a(this.handlers, l), k; if (0 !== c.length) { k = e(c); k = b(k, function () { return d.fire("paste", l.data) }); if (!k) return l.cancel(); g(c, l) } }, this, null, 3) } } }); CKEDITOR.plugins.add("pastetools", {
                requires: "clipboard",
                beforeInit: function (a) { a.pasteTools = new m; a.pasteTools.addPasteListener(a) }
            }); CKEDITOR.plugins.pastetools = {
                filters: {}, loadFilters: b, createFilter: function (a) { var b = CKEDITOR.tools.array.isArray(a.rules) ? a.rules : [a.rules], c = a.additionalTransforms; return function (a, d) { var e = new CKEDITOR.htmlParser.basicWriter, g = new CKEDITOR.htmlParser.filter, h; c && (a = c(a, d)); CKEDITOR.tools.array.forEach(b, function (b) { g.addRules(b(a, d, g)) }); h = CKEDITOR.htmlParser.fragment.fromHtml(a); g.applyTo(h); h.writeHtml(e); return e.getHtml() } },
                getClipboardData: function (a, b) { var c; return CKEDITOR.plugins.clipboard.isCustomDataTypesSupported || "text/html" === b ? (c = a.dataTransfer.getData(b, !0)) || "text/html" !== b ? c : a.dataValue : null }, getConfigValue: function (a, b) { if (a && a.config) { var c = CKEDITOR.tools, d = a.config, e = c.object.keys(d), g = ["pasteTools_" + b, "pasteFromWord_" + b, "pasteFromWord" + c.capitalize(b, !0)], g = c.array.find(g, function (a) { return -1 !== c.array.indexOf(e, a) }); return d[g] } }, getContentGeneratorName: function (a) {
                    if ((a = /<meta\s+name=["']?generator["']?\s+content=["']?(\w+)/gi.exec(a)) &&
                        a.length) return a = a[1].toLowerCase(), 0 === a.indexOf("microsoft") ? "microsoft" : 0 === a.indexOf("libreoffice") ? "libreoffice" : "unknown"
                }
            }; CKEDITOR.pasteFilters = {}
        })(); (function () {
            CKEDITOR.plugins.add("pastefromgdocs", {
                requires: "pastetools", init: function (a) {
                    var g = CKEDITOR.plugins.getPath("pastetools"), e = this.path; a.pasteTools.register({
                        filters: [CKEDITOR.getUrl(g + "filter/common.js"), CKEDITOR.getUrl(e + "filter/default.js")], canHandle: function (a) { return /id=(\"|\')?docs\-internal\-guid\-/.test(a.data.dataValue) },
                        handle: function (b, d) { var e = b.data, g = CKEDITOR.plugins.pastetools.getClipboardData(e, "text/html"); e.dontFilter = !0; e.dataValue = CKEDITOR.pasteFilters.gdocs(g, a); !0 === a.config.forcePasteAsPlainText && (e.type = "text"); d() }
                    })
                }
            })
        })(); (function () {
            CKEDITOR.plugins.add("pastefromlibreoffice", {
                requires: "pastetools", isSupportedEnvironment: function () { var a = CKEDITOR.env.ie && 11 >= CKEDITOR.env.version; return !(CKEDITOR.env.webkit && !CKEDITOR.env.chrome) && !a }, init: function (a) {
                    if (this.isSupportedEnvironment()) {
                        var g = CKEDITOR.plugins.getPath("pastetools"),
                        e = this.path; a.pasteTools.register({
                            priority: 100, filters: [CKEDITOR.getUrl(g + "filter/common.js"), CKEDITOR.getUrl(g + "filter/image.js"), CKEDITOR.getUrl(e + "filter/default.js")], canHandle: function (a) { a = a.data; return (a = a.dataTransfer.getData("text/html", !0) || a.dataValue) ? "libreoffice" === CKEDITOR.plugins.pastetools.getContentGeneratorName(a) : !1 }, handle: function (b, d) {
                                var e = b.data, g = e.dataValue || CKEDITOR.plugins.pastetools.getClipboardData(e, "text/html"); e.dontFilter = !0; g = CKEDITOR.pasteFilters.image(g, a, CKEDITOR.plugins.pastetools.getClipboardData(e,
                                    "text/rtf")); e.dataValue = CKEDITOR.pasteFilters.libreoffice(g, a); !0 === a.config.forcePasteAsPlainText && (e.type = "text"); d()
                            }
                        })
                    }
                }
            })
        })(); (function () {
            CKEDITOR.plugins.add("pastefromword", {
                requires: "pastetools", init: function (a) {
                    function g(a) {
                        var b = CKEDITOR.plugins.pastefromword && CKEDITOR.plugins.pastefromword.images, c, d = []; if (b && a.editor.filter.check("img[src]") && (c = b.extractTagsFromHtml(a.data.dataValue), 0 !== c.length && (b = b.extractFromRtf(a.data.dataTransfer["text/rtf"]), 0 !== b.length && (CKEDITOR.tools.array.forEach(b,
                            function (a) { d.push(a.type ? "data:" + a.type + ";base64," + CKEDITOR.tools.convertBytesToBase64(CKEDITOR.tools.convertHexStringToBytes(a.hex)) : null) }, this), c.length === d.length)))) for (b = 0; b < c.length; b++)0 === c[b].indexOf("file://") && d[b] && (a.data.dataValue = a.data.dataValue.replace(c[b], d[b]))
                    } var e = 0, b = CKEDITOR.plugins.getPath("pastetools"), d = this.path, m = void 0 === a.config.pasteFromWord_inlineImages ? !0 : a.config.pasteFromWord_inlineImages, b = [CKEDITOR.getUrl(b + "filter/common.js"), CKEDITOR.getUrl(d + "filter/default.js")];
                    a.addCommand("pastefromword", { canUndo: !1, async: !0, exec: function (a, b) { e = 1; a.execCommand("paste", { type: "html", notification: b && "undefined" !== typeof b.notification ? b.notification : !0 }) } }); CKEDITOR.plugins.clipboard.addPasteButton(a, "PasteFromWord", { label: a.lang.pastefromword.toolbar, command: "pastefromword", toolbar: "clipboard,50" }); a.pasteTools.register({
                        filters: a.config.pasteFromWordCleanupFile ? [a.config.pasteFromWordCleanupFile] : b, canHandle: function (a) {
                            a = CKEDITOR.plugins.pastetools.getClipboardData(a.data,
                                "text/html"); var b = CKEDITOR.plugins.pastetools.getContentGeneratorName(a), c = /(class="?Mso|style=["'][^"]*?\bmso\-|w:WordDocument|<o:\w+>|<\/font>)/, b = b ? "microsoft" === b : c.test(a); return a && (e || b)
                        }, handle: function (b, d) {
                            var c = b.data, g = CKEDITOR.plugins.pastetools.getClipboardData(c, "text/html"), f = CKEDITOR.plugins.pastetools.getClipboardData(c, "text/rtf"), g = { dataValue: g, dataTransfer: { "text/rtf": f } }; if (!1 !== a.fire("pasteFromWord", g) || e) {
                                c.dontFilter = !0; if (e || !a.config.pasteFromWordPromptCleanup || confirm(a.lang.pastefromword.confirmCleanup)) g.dataValue =
                                    CKEDITOR.cleanWord(g.dataValue, a), a.fire("afterPasteFromWord", g), c.dataValue = g.dataValue, !0 === a.config.forcePasteAsPlainText ? c.type = "text" : CKEDITOR.plugins.clipboard.isCustomCopyCutSupported || "allow-word" !== a.config.forcePasteAsPlainText || (c.type = "html"); e = 0; d()
                            }
                        }
                    }); if (CKEDITOR.plugins.clipboard.isCustomDataTypesSupported && m) a.on("afterPasteFromWord", g)
                }
            })
        })(); (function () {
            var a = {
                canUndo: !1, async: !0, exec: function (a, e) {
                    var b = a.lang, d = CKEDITOR.tools.keystrokeToString(b.common.keyboard, a.getCommandKeystroke(CKEDITOR.env.ie ?
                        a.commands.paste : this)), m = e && "undefined" !== typeof e.notification ? e.notification : !e || !e.from || "keystrokeHandler" === e.from && CKEDITOR.env.ie, b = m && "string" === typeof m ? m : b.pastetext.pasteNotification.replace(/%1/, '\x3ckbd aria-label\x3d"' + d.aria + '"\x3e' + d.display + "\x3c/kbd\x3e"); a.execCommand("paste", { type: "text", notification: m ? b : !1 })
                }
            }; CKEDITOR.plugins.add("pastetext", {
                requires: "clipboard", init: function (g) {
                    var e = CKEDITOR.env.safari ? CKEDITOR.CTRL + CKEDITOR.ALT + CKEDITOR.SHIFT + 86 : CKEDITOR.CTRL + CKEDITOR.SHIFT +
                        86; g.addCommand("pastetext", a); g.setKeystroke(e, "pastetext"); CKEDITOR.plugins.clipboard.addPasteButton(g, "PasteText", { label: g.lang.pastetext.button, command: "pastetext", toolbar: "clipboard,40" }); if (g.config.forcePasteAsPlainText) g.on("beforePaste", function (a) { "html" != a.data.type && (a.data.type = "text") }); g.on("pasteState", function (a) { g.getCommand("pastetext").setState(a.data) })
                }
            })
        })(); (function () {
            function a(a) {
                var e = CKEDITOR.plugins.getPath("preview"), b = a.config, d = a.lang.preview.preview, m = function () {
                    var a =
                        location.origin, d = location.pathname; if (!b.baseHref && !CKEDITOR.env.gecko) return ""; if (b.baseHref) return '\x3cbase href\x3d"{HREF}"\x3e'.replace("{HREF}", b.baseHref); d = d.split("/"); d.pop(); d = d.join("/"); return '\x3cbase href\x3d"{HREF}"\x3e'.replace("{HREF}", a + d + "/")
                }(); return b.fullPage ? a.getData().replace(/<head>/, "$\x26" + m).replace(/[^>]*(?=<\/title>)/, "$\x26 \x26mdash; " + d) : b.docType + '\x3chtml dir\x3d"' + b.contentsLangDirection + '"\x3e\x3chead\x3e' + m + "\x3ctitle\x3e" + d + "\x3c/title\x3e" + CKEDITOR.tools.buildStyleHtml(b.contentsCss) +
                    '\x3clink rel\x3d"stylesheet" media\x3d"screen" href\x3d"' + e + 'styles/screen.css"\x3e\x3c/head\x3e' + function () { var b = "\x3cbody\x3e", d = a.document && a.document.getBody(); if (!d) return b; d.getAttribute("id") && (b = b.replace("\x3e", ' id\x3d"' + d.getAttribute("id") + '"\x3e')); d.getAttribute("class") && (b = b.replace("\x3e", ' class\x3d"' + d.getAttribute("class") + '"\x3e')); return b }() + a.getData() + "\x3c/body\x3e\x3c/html\x3e"
            } CKEDITOR.plugins.add("preview", {
                init: function (a) {
                    a.addCommand("preview", {
                        modes: { wysiwyg: 1 },
                        canUndo: !1, readOnly: 1, exec: CKEDITOR.plugins.preview.createPreview
                    }); a.ui.addButton && a.ui.addButton("Preview", { label: a.lang.preview.preview, command: "preview", toolbar: "document,40" })
                }
            }); CKEDITOR.plugins.preview = {
                createPreview: function (g) {
                    var e, b, d, m = { dataValue: a(g) }, h = window.screen; e = Math.round(.8 * h.width); b = Math.round(.7 * h.height); d = Math.round(.1 * h.width); h = CKEDITOR.env.ie ? "javascript:void( (function(){document.open();" + ("(" + CKEDITOR.tools.fixDomain + ")();").replace(/\/\/.*?\n/g, "").replace(/parent\./g,
                        "window.opener.") + "document.write( window.opener._cke_htmlToLoad );document.close();window.opener._cke_htmlToLoad \x3d null;})() )" : null; var l; l = CKEDITOR.plugins.getPath("preview"); l = CKEDITOR.env.gecko ? CKEDITOR.getUrl(l + "preview.html") : ""; if (!1 === g.fire("contentPreview", m)) return !1; if (h || l) window._cke_htmlToLoad = m.dataValue; g = window.open(l, null, ["toolbar\x3dyes,location\x3dno,status\x3dyes,menubar\x3dyes,scrollbars\x3dyes,resizable\x3dyes", "width\x3d" + e, "height\x3d" + b, "left\x3d" + d].join()); h && g &&
                            (g.location = h); window._cke_htmlToLoad || (e = g.document, e.open(), e.write(m.dataValue), e.close()); return new CKEDITOR.dom.window(g)
                }
            }
        })(); (function () {
            CKEDITOR.plugins.add("print", { requires: "preview", init: function (a) { a.addCommand("print", CKEDITOR.plugins.print); a.ui.addButton && a.ui.addButton("Print", { label: a.lang.print.toolbar, command: "print", toolbar: "document,50" }) } }); CKEDITOR.plugins.print = {
                exec: function (a) {
                    function g() { CKEDITOR.env.gecko ? e.print() : e.document.execCommand("Print"); e.close() } a = CKEDITOR.plugins.preview.createPreview(a);
                    var e; if (a) { e = a.$; if ("complete" === e.document.readyState) return g(); a.once("load", g) }
                }, canUndo: !1, readOnly: 1, modes: { wysiwyg: 1 }
            }
        })(); CKEDITOR.plugins.add("removeformat", { init: function (a) { a.addCommand("removeFormat", CKEDITOR.plugins.removeformat.commands.removeformat); a.ui.addButton && a.ui.addButton("RemoveFormat", { label: a.lang.removeformat.toolbar, command: "removeFormat", toolbar: "cleanup,10" }) } }); CKEDITOR.plugins.removeformat = {
            commands: {
                removeformat: {
                    exec: function (a) {
                        for (var g = a._.removeFormatRegex ||
                            (a._.removeFormatRegex = new RegExp("^(?:" + a.config.removeFormatTags.replace(/,/g, "|") + ")$", "i")), e = a._.removeAttributes || (a._.removeAttributes = a.config.removeFormatAttributes.split(",")), b = CKEDITOR.plugins.removeformat.filter, d = a.getSelection().getRanges().createIterator(), m = function (a) { return a.type == CKEDITOR.NODE_ELEMENT }, h = [], l; l = d.getNextRange();) {
                                var c = l.createBookmark(); l = a.createRange(); l.setStartBefore(c.startNode); c.endNode && l.setEndAfter(c.endNode); l.collapsed || l.enlarge(CKEDITOR.ENLARGE_ELEMENT);
                            var k = l.createBookmark(), f = k.startNode, n = k.endNode, p = function (c) { for (var d = a.elementPath(c), e = d.elements, f = 1, h; (h = e[f]) && !h.equals(d.block) && !h.equals(d.blockLimit); f++)g.test(h.getName()) && b(a, h) && c.breakParent(h) }; p(f); if (n) for (p(n), f = f.getNextSourceNode(!0, CKEDITOR.NODE_ELEMENT); f && !f.equals(n);)if (f.isReadOnly()) { if (f.getPosition(n) & CKEDITOR.POSITION_CONTAINS) break; f = f.getNext(m) } else p = f.getNextSourceNode(!1, CKEDITOR.NODE_ELEMENT), "img" == f.getName() && f.data("cke-realelement") || f.hasAttribute("data-cke-bookmark") ||
                                !b(a, f) || (g.test(f.getName()) ? f.remove(1) : (f.removeAttributes(e), a.fire("removeFormatCleanup", f))), f = p; k.startNode.remove(); k.endNode && k.endNode.remove(); l.moveToBookmark(c); h.push(l)
                        } a.forceNextSelectionCheck(); a.getSelection().selectRanges(h)
                    }
                }
            }, filter: function (a, g) { for (var e = a._.removeFormatFilters || [], b = 0; b < e.length; b++)if (!1 === e[b](g)) return !1; return !0 }
        }; CKEDITOR.editor.prototype.addRemoveFormatFilter = function (a) { this._.removeFormatFilters || (this._.removeFormatFilters = []); this._.removeFormatFilters.push(a) };
        CKEDITOR.config.removeFormatTags = "b,big,cite,code,del,dfn,em,font,i,ins,kbd,q,s,samp,small,span,strike,strong,sub,sup,tt,u,var"; CKEDITOR.config.removeFormatAttributes = "class,style,lang,width,height,align,hspace,valign"; CKEDITOR.plugins.add("resize", {
            init: function (a) {
                function g(d) {
                    var e = c.width, g = c.height, h = e + (d.data.$.screenX - l.x) * ("rtl" == m ? -1 : 1); d = g + (d.data.$.screenY - l.y); k && (e = Math.max(b.resize_minWidth, Math.min(h, b.resize_maxWidth))); f && (g = Math.max(b.resize_minHeight, Math.min(d, b.resize_maxHeight)));
                    a.resize(k ? e : null, g)
                } function e() { CKEDITOR.document.removeListener("mousemove", g); CKEDITOR.document.removeListener("mouseup", e); a.document && (a.document.removeListener("mousemove", g), a.document.removeListener("mouseup", e)) } var b = a.config, d = a.ui.spaceId("resizer"), m = a.element ? a.element.getDirection(1) : "ltr"; !b.resize_dir && (b.resize_dir = "vertical"); void 0 === b.resize_maxWidth && (b.resize_maxWidth = 3E3); void 0 === b.resize_maxHeight && (b.resize_maxHeight = 3E3); void 0 === b.resize_minWidth && (b.resize_minWidth =
                    750); void 0 === b.resize_minHeight && (b.resize_minHeight = 250); if (!1 !== b.resize_enabled) {
                        var h = null, l, c, k = ("both" == b.resize_dir || "horizontal" == b.resize_dir) && b.resize_minWidth != b.resize_maxWidth, f = ("both" == b.resize_dir || "vertical" == b.resize_dir) && b.resize_minHeight != b.resize_maxHeight, n = CKEDITOR.tools.addFunction(function (d) {
                            h || (h = a.getResizable()); c = { width: h.$.offsetWidth || 0, height: h.$.offsetHeight || 0 }; l = { x: d.screenX, y: d.screenY }; b.resize_minWidth > c.width && (b.resize_minWidth = c.width); b.resize_minHeight >
                                c.height && (b.resize_minHeight = c.height); CKEDITOR.document.on("mousemove", g); CKEDITOR.document.on("mouseup", e); a.document && (a.document.on("mousemove", g), a.document.on("mouseup", e)); d.preventDefault && d.preventDefault()
                        }); a.on("destroy", function () { CKEDITOR.tools.removeFunction(n) }); a.on("uiSpace", function (b) {
                            if ("bottom" == b.data.space) {
                                var c = ""; k && !f && (c = " cke_resizer_horizontal"); !k && f && (c = " cke_resizer_vertical"); var e = '\x3cspan id\x3d"' + d + '" class\x3d"cke_resizer' + c + " cke_resizer_" + m + '" title\x3d"' +
                                    CKEDITOR.tools.htmlEncode(a.lang.common.resize) + '" onmousedown\x3d"CKEDITOR.tools.callFunction(' + n + ', event)"\x3e' + ("ltr" == m ? "◢" : "◣") + "\x3c/span\x3e"; "ltr" == m && "ltr" == c ? b.data.html += e : b.data.html = e + b.data.html
                            }
                        }, a, null, 100); a.on("maximize", function (b) { a.ui.space("resizer")[b.data == CKEDITOR.TRISTATE_ON ? "hide" : "show"]() })
                    }
            }
        }); (function () {
            var a = { readOnly: 1, modes: { wysiwyg: 1, source: 1 }, exec: function (a) { if (a.fire("save") && (a = a.element.$.form)) try { a.submit() } catch (e) { a.submit.click && a.submit.click() } } }; CKEDITOR.plugins.add("save",
                { init: function (g) { g.elementMode == CKEDITOR.ELEMENT_MODE_REPLACE && (g.addCommand("save", a).startDisabled = !g.element.$.form, g.ui.addButton && g.ui.addButton("Save", { label: g.lang.save.toolbar, command: "save", toolbar: "document,10" })) } })
        })(); "use strict"; CKEDITOR.plugins.add("scayt", {
            requires: "menubutton,dialog", tabToOpen: null, dialogName: "scaytDialog", onLoad: function (a) {
                "moono-lisa" == (CKEDITOR.skinName || a.config.skin) && CKEDITOR.document.appendStyleSheet(CKEDITOR.getUrl(this.path + "skins/" + CKEDITOR.skin.name +
                    "/scayt.css")); CKEDITOR.document.appendStyleSheet(CKEDITOR.getUrl(this.path + "dialogs/dialog.css"))
            }, init: function (a) {
                var g = this, e = CKEDITOR.plugins.scayt; this.bindEvents(a); this.parseConfig(a); this.addRule(a); CKEDITOR.dialog.add(this.dialogName, CKEDITOR.getUrl(this.path + "dialogs/options.js")); this.addMenuItems(a); var b = a.lang.scayt, d = CKEDITOR.env; a.ui.add("Scayt", CKEDITOR.UI_MENUBUTTON, {
                    label: b.text_title, title: a.plugins.wsc ? a.lang.wsc.title : b.text_title, modes: { wysiwyg: !(d.ie && (8 > d.version || d.quirks)) },
                    toolbar: "spellchecker,20", refresh: function () { var b = a.ui.instances.Scayt.getState(); a.scayt && (b = e.state.scayt[a.name] ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF); a.fire("scaytButtonState", b) }, onRender: function () { var b = this; a.on("scaytButtonState", function (a) { void 0 !== typeof a.data && b.setState(a.data) }) }, onMenu: function () {
                        var b = a.scayt; a.getMenuItem("scaytToggle").label = a.lang.scayt[b && e.state.scayt[a.name] ? "btn_disable" : "btn_enable"]; var d = {
                            scaytToggle: CKEDITOR.TRISTATE_OFF, scaytOptions: b ? CKEDITOR.TRISTATE_OFF :
                                CKEDITOR.TRISTATE_DISABLED, scaytLangs: b ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED, scaytDict: b ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED, scaytAbout: b ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED, WSC: a.plugins.wsc ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED
                        }; a.config.scayt_uiTabs[0] || delete d.scaytOptions; a.config.scayt_uiTabs[1] || delete d.scaytLangs; a.config.scayt_uiTabs[2] || delete d.scaytDict; b && !CKEDITOR.plugins.scayt.isNewUdSupported(b) && (delete d.scaytDict, a.config.scayt_uiTabs[2] =
                            0, CKEDITOR.plugins.scayt.alarmCompatibilityMessage()); return d
                    }
                }); a.contextMenu && a.addMenuItems && (a.contextMenu.addListener(function (b, d) { var e = a.scayt, c, k; e && (k = e.getSelectionNode()) && (c = g.menuGenerator(a, k), e.showBanner("." + a.contextMenu._.definition.panel.className.split(" ").join(" ."))); return c }), a.contextMenu._.onHide = CKEDITOR.tools.override(a.contextMenu._.onHide, function (b) { return function () { var d = a.scayt; d && d.hideBanner(); return b.apply(this) } }))
            }, addMenuItems: function (a) {
                var g = this, e = CKEDITOR.plugins.scayt;
                a.addMenuGroup("scaytButton"); for (var b = a.config.scayt_contextMenuItemsOrder.split("|"), d = 0; d < b.length; d++)b[d] = "scayt_" + b[d]; if ((b = ["grayt_description", "grayt_suggest", "grayt_control"].concat(b)) && b.length) for (d = 0; d < b.length; d++)a.addMenuGroup(b[d], d - 10); a.addCommand("scaytToggle", { exec: function (a) { var b = a.scayt; e.state.scayt[a.name] = !e.state.scayt[a.name]; !0 === e.state.scayt[a.name] ? b || e.createScayt(a) : b && e.destroy(a) } }); a.addCommand("scaytAbout", {
                    exec: function (a) {
                        a.scayt.tabToOpen = "about"; e.openDialog(g.dialogName,
                            a)
                    }
                }); a.addCommand("scaytOptions", { exec: function (a) { a.scayt.tabToOpen = "options"; e.openDialog(g.dialogName, a) } }); a.addCommand("scaytLangs", { exec: function (a) { a.scayt.tabToOpen = "langs"; e.openDialog(g.dialogName, a) } }); a.addCommand("scaytDict", { exec: function (a) { a.scayt.tabToOpen = "dictionaries"; e.openDialog(g.dialogName, a) } }); b = {
                    scaytToggle: { label: a.lang.scayt.btn_enable, group: "scaytButton", command: "scaytToggle" }, scaytAbout: { label: a.lang.scayt.btn_about, group: "scaytButton", command: "scaytAbout" }, scaytOptions: {
                        label: a.lang.scayt.btn_options,
                        group: "scaytButton", command: "scaytOptions"
                    }, scaytLangs: { label: a.lang.scayt.btn_langs, group: "scaytButton", command: "scaytLangs" }, scaytDict: { label: a.lang.scayt.btn_dictionaries, group: "scaytButton", command: "scaytDict" }
                }; a.plugins.wsc && (b.WSC = {
                    label: a.lang.wsc.toolbar, group: "scaytButton", onClick: function () {
                        var b = CKEDITOR.plugins.scayt, d = a.scayt, e = a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ? a.container.getText() : a.document.getBody().getText(); (e = e.replace(/\s/g, "")) ? (d && b.state.scayt[a.name] && d.setMarkupPaused &&
                            d.setMarkupPaused(!0), a.lockSelection(), a.execCommand("checkspell")) : alert("Nothing to check!")
                    }
                }); a.addMenuItems(b)
            }, bindEvents: function (a) {
                var g = CKEDITOR.plugins.scayt, e = a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE, b = function () { g.destroy(a) }, d = function () { !g.state.scayt[a.name] || a.readOnly || a.scayt || g.createScayt(a) }, m = function () {
                    var b = a.editable(); b.attachListener(b, "focus", function (b) {
                        CKEDITOR.plugins.scayt && !a.scayt && setTimeout(d, 0); b = CKEDITOR.plugins.scayt && CKEDITOR.plugins.scayt.state.scayt[a.name] &&
                            a.scayt; var g, f; if ((e || b) && a._.savedSelection) { b = a._.savedSelection.getSelectedElement(); b = !b && a._.savedSelection.getRanges(); for (var h = 0; h < b.length; h++)f = b[h], "string" === typeof f.startContainer.$.nodeValue && (g = f.startContainer.getText().length, (g < f.startOffset || g < f.endOffset) && a.unlockSelection(!1)) }
                    }, this, null, -10)
                }, h = function () {
                    e ? a.config.scayt_inlineModeImmediateMarkup ? d() : (a.on("blur", function () { setTimeout(b, 0) }), a.on("focus", d), a.focusManager.hasFocus && d()) : d(); m(); var g = a.editable(); g.attachListener(g,
                        "mousedown", function (b) { b = b.data.getTarget(); var d = a.widgets && a.widgets.getByElement(b); d && (d.wrapper = b.getAscendant(function (a) { return a.hasAttribute("data-cke-widget-wrapper") }, !0)) }, this, null, -10)
                }; a.on("contentDom", h); a.on("beforeCommandExec", function (b) {
                    var c = a.scayt, d = !1, e = !1, h = !0; b.data.name in g.options.disablingCommandExec && "wysiwyg" == a.mode ? c && (g.destroy(a), a.fire("scaytButtonState", CKEDITOR.TRISTATE_DISABLED)) : "bold" !== b.data.name && "italic" !== b.data.name && "underline" !== b.data.name && "strike" !==
                        b.data.name && "subscript" !== b.data.name && "superscript" !== b.data.name && "enter" !== b.data.name && "cut" !== b.data.name && "language" !== b.data.name || !c || ("cut" === b.data.name && (h = !1, e = !0), "language" === b.data.name && (e = d = !0), a.fire("reloadMarkupScayt", { removeOptions: { removeInside: h, forceBookmark: e, language: d }, timeout: 0 }))
                }); a.on("beforeSetMode", function (b) { if ("source" == b.data) { if (b = a.scayt) g.destroy(a), a.fire("scaytButtonState", CKEDITOR.TRISTATE_DISABLED); a.document && a.document.getBody().removeAttribute("_jquid") } });
                a.on("afterCommandExec", function (b) { "wysiwyg" != a.mode || "undo" != b.data.name && "redo" != b.data.name || setTimeout(function () { g.reloadMarkup(a.scayt) }, 250) }); a.on("readOnly", function (b) { var c; b && (c = a.scayt, !0 === b.editor.readOnly ? c && c.fire("removeMarkupInDocument", {}) : c ? g.reloadMarkup(c) : "wysiwyg" == b.editor.mode && !0 === g.state.scayt[b.editor.name] && (g.createScayt(a), b.editor.fire("scaytButtonState", CKEDITOR.TRISTATE_ON))) }); a.on("beforeDestroy", b); a.on("setData", function () {
                    b(); (a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ||
                        a.plugins.divarea) && h()
                }, this, null, 50); a.on("reloadMarkupScayt", function (b) { var c = b.data && b.data.removeOptions, d = b.data && b.data.timeout, e = b.data && b.data.language, h = a.scayt; h && setTimeout(function () { e && (c.selectionNode = a.plugins.language.getCurrentLangElement(a), c.selectionNode = c.selectionNode && c.selectionNode.$ || null); h.removeMarkupInSelectionNode(c); g.reloadMarkup(h) }, d || 0) }); a.on("insertElement", function () { a.fire("reloadMarkupScayt", { removeOptions: { forceBookmark: !0 } }) }, this, null, 50); a.on("insertHtml",
                    function () { a.scayt && a.scayt.setFocused && a.scayt.setFocused(!0); a.fire("reloadMarkupScayt") }, this, null, 50); a.on("insertText", function () { a.scayt && a.scayt.setFocused && a.scayt.setFocused(!0); a.fire("reloadMarkupScayt") }, this, null, 50); a.on("scaytDialogShown", function (b) { b.data.selectPage(a.scayt.tabToOpen) })
            }, parseConfig: function (a) {
                var g = CKEDITOR.plugins.scayt; g.replaceOldOptionsNames(a.config); "boolean" !== typeof a.config.scayt_autoStartup && (a.config.scayt_autoStartup = !1); g.state.scayt[a.name] = a.config.scayt_autoStartup;
                "boolean" !== typeof a.config.grayt_autoStartup && (a.config.grayt_autoStartup = !1); "boolean" !== typeof a.config.scayt_inlineModeImmediateMarkup && (a.config.scayt_inlineModeImmediateMarkup = !1); g.state.grayt[a.name] = a.config.grayt_autoStartup; a.config.scayt_contextCommands || (a.config.scayt_contextCommands = "ignoreall|add"); a.config.scayt_contextMenuItemsOrder || (a.config.scayt_contextMenuItemsOrder = "suggest|moresuggest|control"); a.config.scayt_sLang || (a.config.scayt_sLang = "en_US"); if (void 0 === a.config.scayt_maxSuggestions ||
                    "number" != typeof a.config.scayt_maxSuggestions || 0 > a.config.scayt_maxSuggestions) a.config.scayt_maxSuggestions = 3; if (void 0 === a.config.scayt_minWordLength || "number" != typeof a.config.scayt_minWordLength || 1 > a.config.scayt_minWordLength) a.config.scayt_minWordLength = 3; if (void 0 === a.config.scayt_customDictionaryIds || "string" !== typeof a.config.scayt_customDictionaryIds) a.config.scayt_customDictionaryIds = ""; if (void 0 === a.config.scayt_userDictionaryName || "string" !== typeof a.config.scayt_userDictionaryName) a.config.scayt_userDictionaryName =
                        null; if ("string" === typeof a.config.scayt_uiTabs && 3 === a.config.scayt_uiTabs.split(",").length) { var e = [], b = []; a.config.scayt_uiTabs = a.config.scayt_uiTabs.split(","); CKEDITOR.tools.search(a.config.scayt_uiTabs, function (a) { 1 === Number(a) || 0 === Number(a) ? (b.push(!0), e.push(Number(a))) : b.push(!1) }); null === CKEDITOR.tools.search(b, !1) ? a.config.scayt_uiTabs = e : a.config.scayt_uiTabs = [1, 1, 1] } else a.config.scayt_uiTabs = [1, 1, 1]; "string" != typeof a.config.scayt_serviceProtocol && (a.config.scayt_serviceProtocol = null);
                "string" != typeof a.config.scayt_serviceHost && (a.config.scayt_serviceHost = null); "string" != typeof a.config.scayt_servicePort && (a.config.scayt_servicePort = null); "string" != typeof a.config.scayt_servicePath && (a.config.scayt_servicePath = null); a.config.scayt_moreSuggestions || (a.config.scayt_moreSuggestions = "on"); "string" !== typeof a.config.scayt_customerId && (a.config.scayt_customerId = "1:WvF0D4-UtPqN1-43nkD4-NKvUm2-daQqk3-LmNiI-z7Ysb4-mwry24-T8YrS3-Q2tpq2"); "string" !== typeof a.config.scayt_customPunctuation &&
                    (a.config.scayt_customPunctuation = "-"); "string" !== typeof a.config.scayt_srcUrl && (g = document.location.protocol, g = -1 != g.search(/https?:/) ? g : "http:", a.config.scayt_srcUrl = g + "//svc.webspellchecker.net/spellcheck31/wscbundle/wscbundle.js"); "boolean" !== typeof CKEDITOR.config.scayt_handleCheckDirty && (CKEDITOR.config.scayt_handleCheckDirty = !0); "boolean" !== typeof CKEDITOR.config.scayt_handleUndoRedo && (CKEDITOR.config.scayt_handleUndoRedo = !0); CKEDITOR.config.scayt_handleUndoRedo = CKEDITOR.plugins.undo ? CKEDITOR.config.scayt_handleUndoRedo :
                        !1; "boolean" !== typeof a.config.scayt_multiLanguageMode && (a.config.scayt_multiLanguageMode = !1); "object" !== typeof a.config.scayt_multiLanguageStyles && (a.config.scayt_multiLanguageStyles = {}); a.config.scayt_ignoreAllCapsWords && "boolean" !== typeof a.config.scayt_ignoreAllCapsWords && (a.config.scayt_ignoreAllCapsWords = !1); a.config.scayt_ignoreDomainNames && "boolean" !== typeof a.config.scayt_ignoreDomainNames && (a.config.scayt_ignoreDomainNames = !1); a.config.scayt_ignoreWordsWithMixedCases && "boolean" !== typeof a.config.scayt_ignoreWordsWithMixedCases &&
                            (a.config.scayt_ignoreWordsWithMixedCases = !1); a.config.scayt_ignoreWordsWithNumbers && "boolean" !== typeof a.config.scayt_ignoreWordsWithNumbers && (a.config.scayt_ignoreWordsWithNumbers = !1); if (a.config.scayt_disableOptionsStorage) {
                                var g = CKEDITOR.tools.isArray(a.config.scayt_disableOptionsStorage) ? a.config.scayt_disableOptionsStorage : "string" === typeof a.config.scayt_disableOptionsStorage ? [a.config.scayt_disableOptionsStorage] : void 0, d = "all options lang ignore-all-caps-words ignore-domain-names ignore-words-with-mixed-cases ignore-words-with-numbers".split(" "),
                                m = ["lang", "ignore-all-caps-words", "ignore-domain-names", "ignore-words-with-mixed-cases", "ignore-words-with-numbers"], h = CKEDITOR.tools.search, l = CKEDITOR.tools.indexOf; a.config.scayt_disableOptionsStorage = function (a) { for (var b = [], e = 0; e < a.length; e++) { var g = a[e], p = !!h(a, "options"); if (!h(d, g) || p && h(m, function (a) { if ("lang" === a) return !1 })) return; h(m, g) && m.splice(l(m, g), 1); if ("all" === g || p && h(a, "lang")) return []; "options" === g && (m = ["lang"]) } return b = b.concat(m) }(g)
                            } a.config.scayt_disableCache && "boolean" !== typeof a.config.scayt_disableCache &&
                                (a.config.scayt_disableCache = !1); if (void 0 === a.config.scayt_cacheSize || "number" != typeof a.config.scayt_cacheSize || 1 > a.config.scayt_cacheSize) a.config.scayt_cacheSize = 4E3
            }, addRule: function (a) {
                var g = CKEDITOR.plugins.scayt, e = a.dataProcessor, b = e && e.htmlFilter, d = a._.elementsPath && a._.elementsPath.filters, e = e && e.dataFilter, m = a.addRemoveFormatFilter, h = function (b) { if (a.scayt && (b.hasAttribute(g.options.data_attribute_name) || b.hasAttribute(g.options.problem_grammar_data_attribute))) return !1 }, l = function (b) {
                    var d =
                        !0; a.scayt && (b.hasAttribute(g.options.data_attribute_name) || b.hasAttribute(g.options.problem_grammar_data_attribute)) && (d = !1); return d
                }; d && d.push(h); e && e.addRules({ elements: { span: function (a) { var b = a.hasClass(g.options.misspelled_word_class) && a.attributes[g.options.data_attribute_name], d = a.hasClass(g.options.problem_grammar_class) && a.attributes[g.options.problem_grammar_data_attribute]; g && (b || d) && delete a.name; return a } } }); b && b.addRules({
                    elements: {
                        span: function (a) {
                            var b = a.hasClass(g.options.misspelled_word_class) &&
                                a.attributes[g.options.data_attribute_name], d = a.hasClass(g.options.problem_grammar_class) && a.attributes[g.options.problem_grammar_data_attribute]; g && (b || d) && delete a.name; return a
                        }
                    }
                }); m && m.call(a, l)
            }, scaytMenuDefinition: function (a) {
                var g = this, e = CKEDITOR.plugins.scayt; a = a.scayt; return {
                    scayt: {
                        scayt_ignore: { label: a.getLocal("btn_ignore"), group: "scayt_control", order: 1, exec: function (a) { a.scayt.ignoreWord() } }, scayt_ignoreall: { label: a.getLocal("btn_ignoreAll"), group: "scayt_control", order: 2, exec: function (a) { a.scayt.ignoreAllWords() } },
                        scayt_add: { label: a.getLocal("btn_addWord"), group: "scayt_control", order: 3, exec: function (a) { var d = a.scayt; setTimeout(function () { d.addWordToUserDictionary() }, 10) } }, scayt_option: { label: a.getLocal("btn_options"), group: "scayt_control", order: 4, exec: function (a) { a.scayt.tabToOpen = "options"; e.openDialog(g.dialogName, a) }, verification: function (a) { return 1 == a.config.scayt_uiTabs[0] ? !0 : !1 } }, scayt_language: {
                            label: a.getLocal("btn_langs"), group: "scayt_control", order: 5, exec: function (a) {
                                a.scayt.tabToOpen = "langs"; e.openDialog(g.dialogName,
                                    a)
                            }, verification: function (a) { return 1 == a.config.scayt_uiTabs[1] ? !0 : !1 }
                        }, scayt_dictionary: { label: a.getLocal("btn_dictionaries"), group: "scayt_control", order: 6, exec: function (a) { a.scayt.tabToOpen = "dictionaries"; e.openDialog(g.dialogName, a) }, verification: function (a) { return 1 == a.config.scayt_uiTabs[2] ? !0 : !1 } }, scayt_about: { label: a.getLocal("btn_about"), group: "scayt_control", order: 7, exec: function (a) { a.scayt.tabToOpen = "about"; e.openDialog(g.dialogName, a) } }
                    }, grayt: {
                        grayt_problemdescription: {
                            label: "Grammar problem description",
                            group: "grayt_description", order: 1, state: CKEDITOR.TRISTATE_DISABLED, exec: function (a) { }
                        }, grayt_ignore: { label: a.getLocal("btn_ignore"), group: "grayt_control", order: 2, exec: function (a) { a.scayt.ignorePhrase() } }, grayt_ignoreall: { label: a.getLocal("btn_ignoreAll"), group: "grayt_control", order: 3, exec: function (a) { a.scayt.ignoreAllPhrases() } }
                    }
                }
            }, buildSuggestionMenuItems: function (a, g, e) {
                var b = {}, d = {}, m = e ? "word" : "phrase", h = e ? "startGrammarCheck" : "startSpellCheck", l = a.scayt; if (0 < g.length && "no_any_suggestions" !== g[0]) if (e) for (e =
                    0; e < g.length; e++) {
                        var c = "scayt_suggest_" + CKEDITOR.plugins.scayt.suggestions[e].replace(" ", "_"); a.addCommand(c, this.createCommand(CKEDITOR.plugins.scayt.suggestions[e], m, h)); e < a.config.scayt_maxSuggestions ? (a.addMenuItem(c, { label: g[e], command: c, group: "scayt_suggest", order: e + 1 }), b[c] = CKEDITOR.TRISTATE_OFF) : (a.addMenuItem(c, { label: g[e], command: c, group: "scayt_moresuggest", order: e + 1 }), d[c] = CKEDITOR.TRISTATE_OFF, "on" === a.config.scayt_moreSuggestions && (a.addMenuItem("scayt_moresuggest", {
                            label: l.getLocal("btn_moreSuggestions"),
                            group: "scayt_moresuggest", order: 10, getItems: function () { return d }
                        }), b.scayt_moresuggest = CKEDITOR.TRISTATE_OFF))
                } else for (e = 0; e < g.length; e++)c = "grayt_suggest_" + CKEDITOR.plugins.scayt.suggestions[e].replace(" ", "_"), a.addCommand(c, this.createCommand(CKEDITOR.plugins.scayt.suggestions[e], m, h)), a.addMenuItem(c, { label: g[e], command: c, group: "grayt_suggest", order: e + 1 }), b[c] = CKEDITOR.TRISTATE_OFF; else b.no_scayt_suggest = CKEDITOR.TRISTATE_DISABLED, a.addCommand("no_scayt_suggest", { exec: function () { } }), a.addMenuItem("no_scayt_suggest",
                    { label: l.getLocal("btn_noSuggestions") || "no_scayt_suggest", command: "no_scayt_suggest", group: "scayt_suggest", order: 0 }); return b
            }, menuGenerator: function (a, g) {
                var e = a.scayt, b = this.scaytMenuDefinition(a), d = {}, m = a.config.scayt_contextCommands.split("|"), h = g.getAttribute(e.getLangAttribute()) || e.getLang(), l, c, k, f; c = e.isScaytNode(g); k = e.isGraytNode(g); c ? (b = b.scayt, l = g.getAttribute(e.getScaytNodeAttributeName()), e.fire("getSuggestionsList", { lang: h, word: l }), d = this.buildSuggestionMenuItems(a, CKEDITOR.plugins.scayt.suggestions,
                    c)) : k && (b = b.grayt, d = g.getAttribute(e.getGraytNodeAttributeName()), e.getGraytNodeRuleAttributeName ? (l = g.getAttribute(e.getGraytNodeRuleAttributeName()), e.getProblemDescriptionText(d, l, h)) : e.getProblemDescriptionText(d, h), f = e.getProblemDescriptionText(d, l, h), b.grayt_problemdescription && f && (f = f.replace(/([.!?])\s/g, "$1\x3cbr\x3e"), b.grayt_problemdescription.label = f), e.fire("getGrammarSuggestionsList", { lang: h, phrase: d, rule: l }), d = this.buildSuggestionMenuItems(a, CKEDITOR.plugins.scayt.suggestions, c)); if (c &&
                        "off" == a.config.scayt_contextCommands) return d; for (var n in b) c && -1 == CKEDITOR.tools.indexOf(m, n.replace("scayt_", "")) && "all" != a.config.scayt_contextCommands || k && "grayt_problemdescription" !== n && -1 == CKEDITOR.tools.indexOf(m, n.replace("grayt_", "")) && "all" != a.config.scayt_contextCommands || (d[n] = "undefined" != typeof b[n].state ? b[n].state : CKEDITOR.TRISTATE_OFF, "function" !== typeof b[n].verification || b[n].verification(a) || delete d[n], a.addCommand(n, { exec: b[n].exec }), a.addMenuItem(n, {
                            label: a.lang.scayt[b[n].label] ||
                                b[n].label, command: n, group: b[n].group, order: b[n].order
                        })); return d
            }, createCommand: function (a, g, e) { return { exec: function (b) { b = b.scayt; var d = {}; d[g] = a; b.replaceSelectionNode(d); "startGrammarCheck" === e && b.removeMarkupInSelectionNode({ grammarOnly: !0 }); b.fire(e) } } }
        }); CKEDITOR.plugins.scayt = {
            charsToObserve: [{
                charName: "cke-fillingChar", charCode: function () {
                    var a = CKEDITOR.version.match(/^\d(\.\d*)*/), a = a && a[0], g; if (a) {
                        g = "4.5.7"; var e, a = a.replace(/\./g, ""); g = g.replace(/\./g, ""); e = a.length - g.length; e = 0 <= e ? e :
                            0; g = parseInt(a) >= parseInt(g) * Math.pow(10, e)
                    } return g ? Array(7).join(String.fromCharCode(8203)) : String.fromCharCode(8203)
                }()
            }], state: { scayt: {}, grayt: {} }, warningCounter: 0, suggestions: [], options: { disablingCommandExec: { source: !0, newpage: !0, templates: !0 }, data_attribute_name: "data-scayt-word", misspelled_word_class: "scayt-misspell-word", problem_grammar_data_attribute: "data-grayt-phrase", problem_grammar_class: "gramm-problem" }, backCompatibilityMap: {
                scayt_service_protocol: "scayt_serviceProtocol", scayt_service_host: "scayt_serviceHost",
                scayt_service_port: "scayt_servicePort", scayt_service_path: "scayt_servicePath", scayt_customerid: "scayt_customerId"
            }, openDialog: function (a, g) { var e = g.scayt; e.isAllModulesReady && !1 === e.isAllModulesReady() || (g.lockSelection(), g.openDialog(a)) }, alarmCompatibilityMessage: function () {
                5 > this.warningCounter && (console.warn("You are using the latest version of SCAYT plugin for CKEditor with the old application version. In order to have access to the newest features, it is recommended to upgrade the application version to latest one as well. Contact us for more details at support@webspellchecker.net."),
                    this.warningCounter += 1)
            }, isNewUdSupported: function (a) { return a.getUserDictionary ? !0 : !1 }, reloadMarkup: function (a) { var g; a && (g = a.getScaytLangList(), a.reloadMarkup ? a.reloadMarkup() : (this.alarmCompatibilityMessage(), g && g.ltr && g.rtl && a.fire("startSpellCheck, startGrammarCheck"))) }, replaceOldOptionsNames: function (a) { for (var g in a) g in this.backCompatibilityMap && (a[this.backCompatibilityMap[g]] = a[g], delete a[g]) }, createScayt: function (a) {
                var g = this, e = CKEDITOR.plugins.scayt; this.loadScaytLibrary(a, function (a) {
                    function d(a) {
                        return new SCAYT.CKSCAYT(a,
                            function () { }, function () { })
                    } var m; a.window && (m = "BODY" == a.editable().$.nodeName ? a.window.getFrame() : a.editable()); if (m) {
                        m = {
                            lang: a.config.scayt_sLang, container: m.$, customDictionary: a.config.scayt_customDictionaryIds, userDictionaryName: a.config.scayt_userDictionaryName, localization: a.langCode, customer_id: a.config.scayt_customerId, customPunctuation: a.config.scayt_customPunctuation, debug: a.config.scayt_debug, data_attribute_name: g.options.data_attribute_name, misspelled_word_class: g.options.misspelled_word_class,
                            problem_grammar_data_attribute: g.options.problem_grammar_data_attribute, problem_grammar_class: g.options.problem_grammar_class, "options-to-restore": a.config.scayt_disableOptionsStorage, focused: a.editable().hasFocus, ignoreElementsRegex: a.config.scayt_elementsToIgnore, ignoreGraytElementsRegex: a.config.grayt_elementsToIgnore, minWordLength: a.config.scayt_minWordLength, multiLanguageMode: a.config.scayt_multiLanguageMode, multiLanguageStyles: a.config.scayt_multiLanguageStyles, graytAutoStartup: a.config.grayt_autoStartup,
                            disableCache: a.config.scayt_disableCache, cacheSize: a.config.scayt_cacheSize, charsToObserve: e.charsToObserve
                        }; a.config.scayt_serviceProtocol && (m.service_protocol = a.config.scayt_serviceProtocol); a.config.scayt_serviceHost && (m.service_host = a.config.scayt_serviceHost); a.config.scayt_servicePort && (m.service_port = a.config.scayt_servicePort); a.config.scayt_servicePath && (m.service_path = a.config.scayt_servicePath); "boolean" === typeof a.config.scayt_ignoreAllCapsWords && (m["ignore-all-caps-words"] = a.config.scayt_ignoreAllCapsWords);
                        "boolean" === typeof a.config.scayt_ignoreDomainNames && (m["ignore-domain-names"] = a.config.scayt_ignoreDomainNames); "boolean" === typeof a.config.scayt_ignoreWordsWithMixedCases && (m["ignore-words-with-mixed-cases"] = a.config.scayt_ignoreWordsWithMixedCases); "boolean" === typeof a.config.scayt_ignoreWordsWithNumbers && (m["ignore-words-with-numbers"] = a.config.scayt_ignoreWordsWithNumbers); var h; try { h = d(m) } catch (l) { g.alarmCompatibilityMessage(), delete m.charsToObserve, h = d(m) } h.subscribe("suggestionListSend",
                            function (a) { for (var b = {}, d = [], e = 0; e < a.suggestionList.length; e++)b["word_" + a.suggestionList[e]] || (b["word_" + a.suggestionList[e]] = a.suggestionList[e], d.push(a.suggestionList[e])); CKEDITOR.plugins.scayt.suggestions = d }); h.subscribe("selectionIsChanged", function (c) { a.getSelection().isLocked && "restoreSelection" !== c.action && a.lockSelection(); "restoreSelection" === c.action && a.selectionChange(!0) }); h.subscribe("graytStateChanged", function (c) { e.state.grayt[a.name] = c.state }); h.addMarkupHandler && h.addMarkupHandler(function (c) {
                                var d =
                                    a.editable(), e = d.getCustomData(c.charName); e && (e.$ = c.node, d.setCustomData(c.charName, e))
                            }); a.scayt = h; a.fire("scaytButtonState", a.readOnly ? CKEDITOR.TRISTATE_DISABLED : CKEDITOR.TRISTATE_ON)
                    } else e.state.scayt[a.name] = !1
                })
            }, destroy: function (a) { a.scayt && a.scayt.destroy(); delete a.scayt; a.fire("scaytButtonState", CKEDITOR.TRISTATE_OFF) }, loadScaytLibrary: function (a, g) {
                var e, b = function () { CKEDITOR.fireOnce("scaytReady"); a.scayt || "function" === typeof g && g(a) }; "undefined" === typeof window.SCAYT || "function" !== typeof window.SCAYT.CKSCAYT ?
                    (e = a.config.scayt_srcUrl, CKEDITOR.scriptLoader.load(e, function (a) { a && b() })) : window.SCAYT && "function" === typeof window.SCAYT.CKSCAYT && b()
            }
        }; CKEDITOR.on("dialogDefinition", function (a) {
            var g = a.data.name; a = a.data.definition.dialog; "scaytDialog" !== g && "checkspell" !== g && (a.on("show", function (a) { a = a.sender && a.sender.getParentEditor(); var b = CKEDITOR.plugins.scayt, d = a.scayt; d && b.state.scayt[a.name] && d.setMarkupPaused && d.setMarkupPaused(!0) }), a.on("hide", function (a) {
                a = a.sender && a.sender.getParentEditor(); var b =
                    CKEDITOR.plugins.scayt, d = a.scayt; d && b.state.scayt[a.name] && d.setMarkupPaused && d.setMarkupPaused(!1)
            })); if ("scaytDialog" === g) a.on("cancel", function (a) { return !1 }, this, null, -1); if ("checkspell" === g) a.on("cancel", function (a) { a = a.sender && a.sender.getParentEditor(); var b = CKEDITOR.plugins.scayt, d = a.scayt; d && b.state.scayt[a.name] && d.setMarkupPaused && d.setMarkupPaused(!1); a.unlockSelection() }, this, null, -2); if ("link" === g) a.on("ok", function (a) {
                var b = a.sender && a.sender.getParentEditor(); b && setTimeout(function () {
                    b.fire("reloadMarkupScayt",
                        { removeOptions: { removeInside: !0, forceBookmark: !0 }, timeout: 0 })
                }, 0)
            }); if ("replace" === g) a.on("hide", function (a) { a = a.sender && a.sender.getParentEditor(); var b = CKEDITOR.plugins.scayt, d = a.scayt; a && setTimeout(function () { d && (d.fire("removeMarkupInDocument", {}), b.reloadMarkup(d)) }, 0) })
        }); CKEDITOR.on("scaytReady", function () {
            if (!0 === CKEDITOR.config.scayt_handleCheckDirty) {
                var a = CKEDITOR.editor.prototype; a.checkDirty = CKEDITOR.tools.override(a.checkDirty, function (a) {
                    return function () {
                        var b = null, d = this.scayt; if (CKEDITOR.plugins.scayt &&
                            CKEDITOR.plugins.scayt.state.scayt[this.name] && this.scayt) { if (b = "ready" == this.status) var g = d.removeMarkupFromString(this.getSnapshot()), d = d.removeMarkupFromString(this._.previousValue), b = b && d !== g } else b = a.call(this); return b
                    }
                }); a.resetDirty = CKEDITOR.tools.override(a.resetDirty, function (a) { return function () { var b = this.scayt; CKEDITOR.plugins.scayt && CKEDITOR.plugins.scayt.state.scayt[this.name] && this.scayt ? this._.previousValue = b.removeMarkupFromString(this.getSnapshot()) : a.call(this) } })
            } if (!0 === CKEDITOR.config.scayt_handleUndoRedo) {
                var a =
                    CKEDITOR.plugins.undo.Image.prototype, g = "function" == typeof a.equalsContent ? "equalsContent" : "equals"; a[g] = CKEDITOR.tools.override(a[g], function (a) { return function (b) { var d = b.editor.scayt, g = this.contents, h = b.contents, l = null; CKEDITOR.plugins.scayt && CKEDITOR.plugins.scayt.state.scayt[b.editor.name] && b.editor.scayt && (this.contents = d.removeMarkupFromString(g) || "", b.contents = d.removeMarkupFromString(h) || ""); l = a.apply(this, arguments); this.contents = g; b.contents = h; return l } })
            }
        }); (function () {
            CKEDITOR.plugins.add("selectall",
                {
                    init: function (a) {
                        a.addCommand("selectAll", { modes: { wysiwyg: 1, source: 1 }, exec: function (a) { var e = a.editable(); if (e.is("textarea")) a = e.$, CKEDITOR.env.ie && a.createTextRange ? a.createTextRange().execCommand("SelectAll") : (a.selectionStart = 0, a.selectionEnd = a.value.length), a.focus(); else { if (e.is("body")) a.document.$.execCommand("SelectAll", !1, null); else { var b = a.createRange(); b.selectNodeContents(e); b.select() } a.forceNextSelectionCheck(); a.selectionChange() } }, canUndo: !1 }); a.ui.addButton && a.ui.addButton("SelectAll",
                            { label: a.lang.selectall.toolbar, command: "selectAll", toolbar: "selection,10" })
                    }
                })
        })(); (function () {
            var a = { readOnly: 1, preserveState: !0, editorFocus: !1, exec: function (a) { this.toggleState(); this.refresh(a) }, refresh: function (a) { if (a.document) { var e = this.state != CKEDITOR.TRISTATE_ON || a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE && !a.focusManager.hasFocus ? "removeClass" : "attachClass"; a.editable()[e]("cke_show_blocks") } } }; CKEDITOR.plugins.add("showblocks", {
                onLoad: function () {
                    var a = "p div pre address blockquote h1 h2 h3 h4 h5 h6".split(" "),
                    e, b, d, m, h = CKEDITOR.getUrl(this.path), l = !(CKEDITOR.env.ie && 9 > CKEDITOR.env.version), c = l ? ":not([contenteditable\x3dfalse]):not(.cke_show_blocks_off)" : "", k, f; for (e = b = d = m = ""; k = a.pop();)f = a.length ? "," : "", e += ".cke_show_blocks " + k + c + f, d += ".cke_show_blocks.cke_contents_ltr " + k + c + f, m += ".cke_show_blocks.cke_contents_rtl " + k + c + f, b += ".cke_show_blocks " + k + c + "{background-image:url(" + CKEDITOR.getUrl(h + "images/block_" + k + ".png") + ")}"; CKEDITOR.addCss((e + "{background-repeat:no-repeat;border:1px dotted gray;padding-top:8px}").concat(b,
                        d + "{background-position:top left;padding-left:8px}", m + "{background-position:top right;padding-right:8px}")); l || CKEDITOR.addCss(".cke_show_blocks [contenteditable\x3dfalse],.cke_show_blocks .cke_show_blocks_off{border:none;padding-top:0;background-image:none}.cke_show_blocks.cke_contents_rtl [contenteditable\x3dfalse],.cke_show_blocks.cke_contents_rtl .cke_show_blocks_off{padding-right:0}.cke_show_blocks.cke_contents_ltr [contenteditable\x3dfalse],.cke_show_blocks.cke_contents_ltr .cke_show_blocks_off{padding-left:0}")
                },
                init: function (g) {
                    function e() { b.refresh(g) } if (!g.blockless) {
                        var b = g.addCommand("showblocks", a); b.canUndo = !1; g.config.startupOutlineBlocks && b.setState(CKEDITOR.TRISTATE_ON); g.ui.addButton && g.ui.addButton("ShowBlocks", { label: g.lang.showblocks.toolbar, command: "showblocks", toolbar: "tools,20" }); g.on("mode", function () { b.state != CKEDITOR.TRISTATE_DISABLED && b.refresh(g) }); g.elementMode == CKEDITOR.ELEMENT_MODE_INLINE && (g.on("focus", e), g.on("blur", e)); g.on("contentDom", function () {
                            b.state != CKEDITOR.TRISTATE_DISABLED &&
                            b.refresh(g)
                        })
                    }
                }
            })
        })(); (function () {
            var a = { preserveState: !0, editorFocus: !1, readOnly: 1, exec: function (a) { this.toggleState(); this.refresh(a) }, refresh: function (a) { if (a.document) { var e = this.state == CKEDITOR.TRISTATE_ON ? "attachClass" : "removeClass"; a.editable()[e]("cke_show_borders") } } }; CKEDITOR.plugins.add("showborders", {
                modes: { wysiwyg: 1 }, onLoad: function () {
                    var a; a = (CKEDITOR.env.ie6Compat ? [".%1 table.%2,", ".%1 table.%2 td, .%1 table.%2 th", "{", "border : #d3d3d3 1px dotted", "}"] : ".%1 table.%2,;.%1 table.%2 \x3e tr \x3e td, .%1 table.%2 \x3e tr \x3e th,;.%1 table.%2 \x3e tbody \x3e tr \x3e td, .%1 table.%2 \x3e tbody \x3e tr \x3e th,;.%1 table.%2 \x3e thead \x3e tr \x3e td, .%1 table.%2 \x3e thead \x3e tr \x3e th,;.%1 table.%2 \x3e tfoot \x3e tr \x3e td, .%1 table.%2 \x3e tfoot \x3e tr \x3e th;{;border : #d3d3d3 1px dotted;}".split(";")).join("").replace(/%2/g,
                        "cke_show_border").replace(/%1/g, "cke_show_borders "); CKEDITOR.addCss(a)
                }, init: function (g) {
                    var e = g.addCommand("showborders", a); e.canUndo = !1; !1 !== g.config.startupShowBorders && e.setState(CKEDITOR.TRISTATE_ON); g.on("mode", function () { e.state != CKEDITOR.TRISTATE_DISABLED && e.refresh(g) }, null, null, 100); g.on("contentDom", function () { e.state != CKEDITOR.TRISTATE_DISABLED && e.refresh(g) }); g.on("removeFormatCleanup", function (a) {
                        a = a.data; g.getCommand("showborders").state == CKEDITOR.TRISTATE_ON && a.is("table") && (!a.hasAttribute("border") ||
                            0 >= parseInt(a.getAttribute("border"), 10)) && a.addClass("cke_show_border")
                    })
                }, afterInit: function (a) {
                    var e = a.dataProcessor; a = e && e.dataFilter; e = e && e.htmlFilter; a && a.addRules({ elements: { table: function (a) { a = a.attributes; var d = a["class"], e = parseInt(a.border, 10); e && !(0 >= e) || d && -1 != d.indexOf("cke_show_border") || (a["class"] = (d || "") + " cke_show_border") } } }); e && e.addRules({
                        elements: {
                            table: function (a) {
                                a = a.attributes; var d = a["class"]; d && (a["class"] = d.replace("cke_show_border", "").replace(/\s{2}/, " ").replace(/^\s+|\s+$/,
                                    ""))
                            }
                        }
                    })
                }
            }); CKEDITOR.on("dialogDefinition", function (a) {
                var e = a.data.name; if ("table" == e || "tableProperties" == e) if (a = a.data.definition, e = a.getContents("info").get("txtBorder"), e.commit = CKEDITOR.tools.override(e.commit, function (a) { return function (d, e) { a.apply(this, arguments); var g = parseInt(this.getValue(), 10); e[!g || 0 >= g ? "addClass" : "removeClass"]("cke_show_border") } }), a = (a = a.getContents("advanced")) && a.get("advCSSClasses")) a.setup = CKEDITOR.tools.override(a.setup, function (a) {
                    return function () {
                        a.apply(this,
                            arguments); this.setValue(this.getValue().replace(/cke_show_border/, ""))
                    }
                }), a.commit = CKEDITOR.tools.override(a.commit, function (a) { return function (d, e) { a.apply(this, arguments); parseInt(e.getAttribute("border"), 10) || e.addClass("cke_show_border") } })
            })
        })(); CKEDITOR.plugins.add("smiley", {
            requires: "dialog", init: function (a) {
                a.config.smiley_path = a.config.smiley_path || this.path + "images/"; a.addCommand("smiley", new CKEDITOR.dialogCommand("smiley", { allowedContent: "img[alt,height,!src,title,width]", requiredContent: "img" }));
                a.ui.addButton && a.ui.addButton("Smiley", { label: a.lang.smiley.toolbar, command: "smiley", toolbar: "insert,50" }); CKEDITOR.dialog.add("smiley", this.path + "dialogs/smiley.js")
            }
        }); CKEDITOR.config.smiley_images = "regular_smile.png sad_smile.png wink_smile.png teeth_smile.png confused_smile.png tongue_smile.png embarrassed_smile.png omg_smile.png whatchutalkingabout_smile.png angry_smile.png angel_smile.png shades_smile.png devil_smile.png cry_smile.png lightbulb.png thumbs_down.png thumbs_up.png heart.png broken_heart.png kiss.png envelope.png".split(" ");
        CKEDITOR.config.smiley_descriptions = "smiley;sad;wink;laugh;frown;cheeky;blush;surprise;indecision;angry;angel;cool;devil;crying;enlightened;no;yes;heart;broken heart;kiss;mail".split(";"); (function () {
            CKEDITOR.plugins.add("sourcearea", {
                init: function (g) {
                    function e() { var a = d && this.equals(CKEDITOR.document.getActive()); this.hide(); this.setStyle("height", this.getParent().$.clientHeight + "px"); this.setStyle("width", this.getParent().$.clientWidth + "px"); this.show(); a && this.focus() } if (g.elementMode != CKEDITOR.ELEMENT_MODE_INLINE) {
                        var b =
                            CKEDITOR.plugins.sourcearea; g.addMode("source", function (b) {
                                var d = g.ui.space("contents").getDocument().createElement("textarea"); d.setStyles(CKEDITOR.tools.extend({ width: CKEDITOR.env.ie7Compat ? "99%" : "100%", height: "100%", resize: "none", outline: "none", "text-align": "left" }, CKEDITOR.tools.cssVendorPrefix("tab-size", g.config.sourceAreaTabSize || 4))); d.setAttribute("dir", "ltr"); d.addClass("cke_source").addClass("cke_reset").addClass("cke_enable_context_menu"); g.ui.space("contents").append(d); d = g.editable(new a(g,
                                    d)); d.setData(g.getData(1)); CKEDITOR.env.ie && (d.attachListener(g, "resize", e, d), d.attachListener(CKEDITOR.document.getWindow(), "resize", e, d), CKEDITOR.tools.setTimeout(e, 0, d)); g.fire("ariaWidget", this); b()
                            }); g.addCommand("source", b.commands.source); g.ui.addButton && g.ui.addButton("Source", { label: g.lang.sourcearea.toolbar, command: "source", toolbar: "mode,10" }); g.on("mode", function () { g.getCommand("source").setState("source" == g.mode ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF) }); var d = CKEDITOR.env.ie && 9 ==
                                CKEDITOR.env.version
                    }
                }
            }); var a = CKEDITOR.tools.createClass({ base: CKEDITOR.editable, proto: { setData: function (a) { this.setValue(a); this.status = "ready"; this.editor.fire("dataReady") }, getData: function () { return this.getValue() }, insertHtml: function () { }, insertElement: function () { }, insertText: function () { }, setReadOnly: function (a) { this[(a ? "set" : "remove") + "Attribute"]("readOnly", "readonly") }, detach: function () { a.baseProto.detach.call(this); this.clearCustomData(); this.remove() } } })
        })(); CKEDITOR.plugins.sourcearea =
            { commands: { source: { modes: { wysiwyg: 1, source: 1 }, editorFocus: !1, readOnly: 1, exec: function (a) { "wysiwyg" == a.mode && a.fire("saveSnapshot"); a.getCommand("source").setState(CKEDITOR.TRISTATE_DISABLED); a.setMode("source" == a.mode ? "wysiwyg" : "source") }, canUndo: !1 } } }; CKEDITOR.plugins.add("specialchar", {
                availableLangs: {
                    af: 1, ar: 1, az: 1, bg: 1, ca: 1, cs: 1, cy: 1, da: 1, de: 1, "de-ch": 1, el: 1, en: 1, "en-au": 1, "en-ca": 1, "en-gb": 1, eo: 1, es: 1, "es-mx": 1, et: 1, eu: 1, fa: 1, fi: 1, fr: 1, "fr-ca": 1, gl: 1, he: 1, hr: 1, hu: 1, id: 1, it: 1, ja: 1, km: 1, ko: 1, ku: 1,
                    lt: 1, lv: 1, nb: 1, nl: 1, no: 1, oc: 1, pl: 1, pt: 1, "pt-br": 1, ro: 1, ru: 1, si: 1, sk: 1, sl: 1, sq: 1, sr: 1, "sr-latn": 1, sv: 1, th: 1, tr: 1, tt: 1, ug: 1, uk: 1, vi: 1, zh: 1, "zh-cn": 1
                }, requires: "dialog", init: function (a) {
                    var g = this; CKEDITOR.dialog.add("specialchar", this.path + "dialogs/specialchar.js"); a.addCommand("specialchar", {
                        exec: function () {
                            var e = a.langCode, e = g.availableLangs[e] ? e : g.availableLangs[e.replace(/-.*/, "")] ? e.replace(/-.*/, "") : "en"; CKEDITOR.scriptLoader.load(CKEDITOR.getUrl(g.path + "dialogs/lang/" + e + ".js"), function () {
                                CKEDITOR.tools.extend(a.lang.specialchar,
                                    g.langEntries[e]); a.openDialog("specialchar")
                            })
                        }, modes: { wysiwyg: 1 }, canUndo: !1
                    }); a.ui.addButton && a.ui.addButton("SpecialChar", { label: a.lang.specialchar.toolbar, command: "specialchar", toolbar: "insert,50" })
                }
            }); CKEDITOR.config.specialChars = "! \x26quot; # $ % \x26amp; ' ( ) * + - . / 0 1 2 3 4 5 6 7 8 9 : ; \x26lt; \x3d \x26gt; ? @ A B C D E F G H I J K L M N O P Q R S T U V W X Y Z [ ] ^ _ ` a b c d e f g h i j k l m n o p q r s t u v w x y z { | } ~ \x26euro; \x26lsquo; \x26rsquo; \x26ldquo; \x26rdquo; \x26ndash; \x26mdash; \x26iexcl; \x26cent; \x26pound; \x26curren; \x26yen; \x26brvbar; \x26sect; \x26uml; \x26copy; \x26ordf; \x26laquo; \x26not; \x26reg; \x26macr; \x26deg; \x26sup2; \x26sup3; \x26acute; \x26micro; \x26para; \x26middot; \x26cedil; \x26sup1; \x26ordm; \x26raquo; \x26frac14; \x26frac12; \x26frac34; \x26iquest; \x26Agrave; \x26Aacute; \x26Acirc; \x26Atilde; \x26Auml; \x26Aring; \x26AElig; \x26Ccedil; \x26Egrave; \x26Eacute; \x26Ecirc; \x26Euml; \x26Igrave; \x26Iacute; \x26Icirc; \x26Iuml; \x26ETH; \x26Ntilde; \x26Ograve; \x26Oacute; \x26Ocirc; \x26Otilde; \x26Ouml; \x26times; \x26Oslash; \x26Ugrave; \x26Uacute; \x26Ucirc; \x26Uuml; \x26Yacute; \x26THORN; \x26szlig; \x26agrave; \x26aacute; \x26acirc; \x26atilde; \x26auml; \x26aring; \x26aelig; \x26ccedil; \x26egrave; \x26eacute; \x26ecirc; \x26euml; \x26igrave; \x26iacute; \x26icirc; \x26iuml; \x26eth; \x26ntilde; \x26ograve; \x26oacute; \x26ocirc; \x26otilde; \x26ouml; \x26divide; \x26oslash; \x26ugrave; \x26uacute; \x26ucirc; \x26uuml; \x26yacute; \x26thorn; \x26yuml; \x26OElig; \x26oelig; \x26#372; \x26#374 \x26#373 \x26#375; \x26sbquo; \x26#8219; \x26bdquo; \x26hellip; \x26trade; \x26#9658; \x26bull; \x26rarr; \x26rArr; \x26hArr; \x26diams; \x26asymp;".split(" ");
        (function () {
            CKEDITOR.plugins.add("stylescombo", {
                requires: "richcombo", init: function (a) {
                    var g = a.config, e = a.lang.stylescombo, b = {}, d = [], m = []; a.on("stylesSet", function (e) {
                        if (e = e.data.styles) {
                            for (var l, c, k, f = 0, n = e.length; f < n; f++)(l = e[f], a.blockless && l.element in CKEDITOR.dtd.$block || "string" == typeof l.type && !CKEDITOR.style.customHandlers[l.type] || (c = l.name, l = new CKEDITOR.style(l), a.filter.customConfig && !a.filter.check(l))) || (l._name = c, l._.enterMode = g.enterMode, l._.type = k = l.assignedTo || l.type, l._.weight =
                                f + 1E3 * (k == CKEDITOR.STYLE_OBJECT ? 1 : k == CKEDITOR.STYLE_BLOCK ? 2 : 3), b[c] = l, d.push(l), m.push(l)); d.sort(function (a, b) { return a._.weight - b._.weight })
                        }
                    }); a.ui.addRichCombo("Styles", {
                        label: e.label, title: e.panelTitle, toolbar: "styles,10", allowedContent: m, panel: { css: [CKEDITOR.skin.getPath("editor")].concat(g.contentsCss), multiSelect: !0, attributes: { "aria-label": e.panelTitle } }, init: function () {
                            var a, b, c, g, f, m; f = 0; for (m = d.length; f < m; f++)a = d[f], b = a._name, g = a._.type, g != c && (this.startGroup(e["panelTitle" + String(g)]),
                                c = g), this.add(b, a.type == CKEDITOR.STYLE_OBJECT ? b : a.buildPreview(), b); this.commit()
                        }, onClick: function (d) { a.focus(); a.fire("saveSnapshot"); d = b[d]; var e = a.elementPath(); if (d.group && d.removeStylesFromSameGroup(a)) a.applyStyle(d); else a[d.checkActive(e, a) ? "removeStyle" : "applyStyle"](d); a.fire("saveSnapshot") }, onRender: function () {
                            a.on("selectionChange", function (d) {
                                var e = this.getValue(); d = d.data.path.elements; for (var c = 0, g = d.length, f; c < g; c++) {
                                    f = d[c]; for (var m in b) if (b[m].checkElementRemovable(f, !0, a)) {
                                        m !=
                                        e && this.setValue(m); return
                                    }
                                } this.setValue("")
                            }, this)
                        }, onOpen: function () {
                            var d = a.getSelection(), d = d.getSelectedElement() || d.getStartElement() || a.editable(), d = a.elementPath(d), g = [0, 0, 0, 0]; this.showAll(); this.unmarkAll(); for (var c in b) { var k = b[c], f = k._.type; k.checkApplicable(d, a, a.activeFilter) ? g[f]++ : this.hideItem(c); k.checkActive(d, a) && this.mark(c) } g[CKEDITOR.STYLE_BLOCK] || this.hideGroup(e["panelTitle" + String(CKEDITOR.STYLE_BLOCK)]); g[CKEDITOR.STYLE_INLINE] || this.hideGroup(e["panelTitle" + String(CKEDITOR.STYLE_INLINE)]);
                            g[CKEDITOR.STYLE_OBJECT] || this.hideGroup(e["panelTitle" + String(CKEDITOR.STYLE_OBJECT)])
                        }, refresh: function () { var d = a.elementPath(); if (d) { for (var e in b) if (b[e].checkApplicable(d, a, a.activeFilter)) return; this.setState(CKEDITOR.TRISTATE_DISABLED) } }, reset: function () { b = {}; d = [] }
                    })
                }
            })
        })(); (function () {
            function a(a) {
                return {
                    editorFocus: !1, canUndo: !1, modes: { wysiwyg: 1 }, exec: function (b) {
                        if (b.editable().hasFocus) {
                            var e = b.getSelection(), g; if (g = (new CKEDITOR.dom.elementPath(e.getCommonAncestor(), e.root)).contains({
                                td: 1,
                                th: 1
                            }, 1)) {
                                var e = b.createRange(), c = CKEDITOR.tools.tryThese(function () { var b = g.getParent().$.cells[g.$.cellIndex + (a ? -1 : 1)]; b.parentNode.parentNode; return b }, function () { var b = g.getParent(), b = b.getAscendant("table").$.rows[b.$.rowIndex + (a ? -1 : 1)]; return b.cells[a ? b.cells.length - 1 : 0] }); if (c || a) if (c) c = new CKEDITOR.dom.element(c), e.moveToElementEditStart(c), e.checkStartOfBlock() && e.checkEndOfBlock() || e.selectNodeContents(c); else return !0; else {
                                    for (var k = g.getAscendant("table").$, c = g.getParent().$.cells, k =
                                        new CKEDITOR.dom.element(k.insertRow(-1), b.document), f = 0, n = c.length; f < n; f++)k.append((new CKEDITOR.dom.element(c[f], b.document)).clone(!1, !1)).appendBogus(); e.moveToElementEditStart(k)
                                } e.select(!0); return !0
                            }
                        } return !1
                    }
                }
            } var g = { editorFocus: !1, modes: { wysiwyg: 1, source: 1 } }, e = { exec: function (a) { a.container.focusNext(!0, a.tabIndex) } }, b = { exec: function (a) { a.container.focusPrevious(!0, a.tabIndex) } }; CKEDITOR.plugins.add("tab", {
                init: function (d) {
                    for (var m = !1 !== d.config.enableTabKeyTools, h = d.config.tabSpaces || 0,
                        l = ""; h--;)l += " "; if (l) d.on("key", function (a) { 9 == a.data.keyCode && (d.insertText(l), a.cancel()) }); if (m) d.on("key", function (a) { (9 == a.data.keyCode && d.execCommand("selectNextCell") || a.data.keyCode == CKEDITOR.SHIFT + 9 && d.execCommand("selectPreviousCell")) && a.cancel() }); d.addCommand("blur", CKEDITOR.tools.extend(e, g)); d.addCommand("blurBack", CKEDITOR.tools.extend(b, g)); d.addCommand("selectNextCell", a()); d.addCommand("selectPreviousCell", a(!0))
                }
            })
        })(); CKEDITOR.dom.element.prototype.focusNext = function (a, g) {
            var e =
                void 0 === g ? this.getTabIndex() : g, b, d, m, h, l, c; if (0 >= e) for (l = this.getNextSourceNode(a, CKEDITOR.NODE_ELEMENT); l;) { if (l.isVisible() && 0 === l.getTabIndex()) { m = l; break } l = l.getNextSourceNode(!1, CKEDITOR.NODE_ELEMENT) } else for (l = this.getDocument().getBody().getFirst(); l = l.getNextSourceNode(!1, CKEDITOR.NODE_ELEMENT);) {
                    if (!b) if (!d && l.equals(this)) { if (d = !0, a) { if (!(l = l.getNextSourceNode(!0, CKEDITOR.NODE_ELEMENT))) break; b = 1 } } else d && !this.contains(l) && (b = 1); if (l.isVisible() && !(0 > (c = l.getTabIndex()))) {
                        if (b && c == e) {
                            m =
                            l; break
                        } c > e && (!m || !h || c < h) ? (m = l, h = c) : m || 0 !== c || (m = l, h = c)
                    }
                } m && m.focus()
        }; CKEDITOR.dom.element.prototype.focusPrevious = function (a, g) {
            for (var e = void 0 === g ? this.getTabIndex() : g, b, d, m, h = 0, l, c = this.getDocument().getBody().getLast(); c = c.getPreviousSourceNode(!1, CKEDITOR.NODE_ELEMENT);) {
                if (!b) if (!d && c.equals(this)) { if (d = !0, a) { if (!(c = c.getPreviousSourceNode(!0, CKEDITOR.NODE_ELEMENT))) break; b = 1 } } else d && !this.contains(c) && (b = 1); if (c.isVisible() && !(0 > (l = c.getTabIndex()))) if (0 >= e) {
                    if (b && 0 === l) { m = c; break } l > h &&
                        (m = c, h = l)
                } else { if (b && l == e) { m = c; break } l < e && (!m || l > h) && (m = c, h = l) }
            } m && m.focus()
        }; CKEDITOR.plugins.add("table", {
            requires: "dialog", init: function (a) {
                function g(a) { return CKEDITOR.tools.extend(a || {}, { contextSensitive: 1, refresh: function (a, b) { this.setState(b.contains("table", 1) ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED) } }) } if (!a.blockless) {
                    var e = a.lang.table; a.addCommand("table", new CKEDITOR.dialogCommand("table", {
                        context: "table", allowedContent: "table{width,height,border-collapse}[align,border,cellpadding,cellspacing,summary];caption tbody thead tfoot;th td tr[scope];td{border*,background-color,vertical-align,width,height}[colspan,rowspan];" +
                            (a.plugins.dialogadvtab ? "table" + a.plugins.dialogadvtab.allowedContent() : ""), requiredContent: "table", contentTransformations: [["table{width}: sizeToStyle", "table[width]: sizeToAttribute"], ["td: splitBorderShorthand"], [{
                                element: "table", right: function (a) {
                                    if (a.styles) {
                                        var d; if (a.styles.border) d = CKEDITOR.tools.style.parse.border(a.styles.border); else if (CKEDITOR.env.ie && 8 === CKEDITOR.env.version) {
                                            var e = a.styles; e["border-left"] && e["border-left"] === e["border-right"] && e["border-right"] === e["border-top"] &&
                                                e["border-top"] === e["border-bottom"] && (d = CKEDITOR.tools.style.parse.border(e["border-top"]))
                                        } d && d.style && "solid" === d.style && d.width && 0 !== parseFloat(d.width) && (a.attributes.border = 1); "collapse" == a.styles["border-collapse"] && (a.attributes.cellspacing = 0)
                                    }
                                }
                            }]]
                    })); a.addCommand("tableProperties", new CKEDITOR.dialogCommand("tableProperties", g())); a.addCommand("tableDelete", g({
                        exec: function (a) {
                            var d = a.elementPath().contains("table", 1); if (d) {
                                var e = d.getParent(), g = a.editable(); 1 != e.getChildCount() || e.is("td",
                                    "th") || e.equals(g) || (d = e); a = a.createRange(); a.moveToPosition(d, CKEDITOR.POSITION_BEFORE_START); d.remove(); a.select()
                            }
                        }
                    })); a.ui.addButton && a.ui.addButton("Table", { label: e.toolbar, command: "table", toolbar: "insert,30" }); CKEDITOR.dialog.add("table", this.path + "dialogs/table.js"); CKEDITOR.dialog.add("tableProperties", this.path + "dialogs/table.js"); a.addMenuItems && a.addMenuItems({
                        table: { label: e.menu, command: "tableProperties", group: "table", order: 5 }, tabledelete: {
                            label: e.deleteTable, command: "tableDelete", group: "table",
                            order: 1
                        }
                    }); a.on("doubleclick", function (a) { a.data.element.is("table") && (a.data.dialog = "tableProperties") }); a.contextMenu && a.contextMenu.addListener(function () { return { tabledelete: CKEDITOR.TRISTATE_OFF, table: CKEDITOR.TRISTATE_OFF } })
                }
            }
        }); (function () {
            function a(a, b) {
                function c(a) { return b ? b.contains(a) && a.getAscendant("table", !0).equals(b) : !0 } function d(a) {
                    var b = /^(?:td|th)$/; 0 < e.length || a.type != CKEDITOR.NODE_ELEMENT || !b.test(a.getName()) || a.getCustomData("selected_cell") || (CKEDITOR.dom.element.setMarker(f,
                        a, "selected_cell", !0), e.push(a))
                } var e = [], f = {}; if (!a) return e; for (var g = a.getRanges(), h = 0; h < g.length; h++) { var k = g[h]; if (k.collapsed) (k = k.getCommonAncestor().getAscendant({ td: 1, th: 1 }, !0)) && c(k) && e.push(k); else { var k = new CKEDITOR.dom.walker(k), l; for (k.guard = d; l = k.next();)l.type == CKEDITOR.NODE_ELEMENT && l.is(CKEDITOR.dtd.table) || (l = l.getAscendant({ td: 1, th: 1 }, !0)) && !l.getCustomData("selected_cell") && c(l) && (CKEDITOR.dom.element.setMarker(f, l, "selected_cell", !0), e.push(l)) } } CKEDITOR.dom.element.clearAllMarkers(f);
                return e
            } function g(b, c) {
                for (var d = q(b) ? b : a(b), e = d[0], f = e.getAscendant("table"), e = e.getDocument(), g = d[0].getParent(), h = g.$.rowIndex, d = d[d.length - 1], k = d.getParent().$.rowIndex + d.$.rowSpan - 1, d = new CKEDITOR.dom.element(f.$.rows[k]), h = c ? h : k, g = c ? g : d, d = CKEDITOR.tools.buildTableMap(f), f = d[h], h = c ? d[h - 1] : d[h + 1], d = d[0].length, e = e.createElement("tr"), k = 0; f[k] && k < d; k++) {
                    var l; 1 < f[k].rowSpan && h && f[k] == h[k] ? (l = f[k], l.rowSpan += 1) : (l = (new CKEDITOR.dom.element(f[k])).clone(), l.removeAttribute("rowSpan"), l.appendBogus(),
                        e.append(l), l = l.$); k += l.colSpan - 1
                } c ? e.insertBefore(g) : e.insertAfter(g); return e
            } function e(b) {
                if (b instanceof CKEDITOR.dom.selection) {
                    var c = b.getRanges(), d = a(b), f = d[0].getAscendant("table"), g = CKEDITOR.tools.buildTableMap(f), h = d[0].getParent().$.rowIndex, d = d[d.length - 1], k = d.getParent().$.rowIndex + d.$.rowSpan - 1, d = []; b.reset(); for (b = h; b <= k; b++) {
                        for (var l = g[b], m = new CKEDITOR.dom.element(f.$.rows[b]), n = 0; n < l.length; n++) {
                            var p = new CKEDITOR.dom.element(l[n]), q = p.getParent().$.rowIndex; 1 == p.$.rowSpan ? p.remove() :
                                (--p.$.rowSpan, q == b && (q = g[b + 1], q[n - 1] ? p.insertAfter(new CKEDITOR.dom.element(q[n - 1])) : (new CKEDITOR.dom.element(f.$.rows[b + 1])).append(p, 1))); n += p.$.colSpan - 1
                        } d.push(m)
                    } g = f.$.rows; c[0].moveToPosition(f, CKEDITOR.POSITION_BEFORE_START); h = new CKEDITOR.dom.element(g[k + 1] || (0 < h ? g[h - 1] : null) || f.$.parentNode); for (b = d.length; 0 <= b; b--)e(d[b]); return f.$.parentNode ? h : (c[0].select(), null)
                } b instanceof CKEDITOR.dom.element && (f = b.getAscendant("table"), 1 == f.$.rows.length ? f.remove() : b.remove()); return null
            } function b(a) {
                for (var b =
                    a.getParent().$.cells, c = 0, d = 0; d < b.length; d++) { var e = b[d], c = c + e.colSpan; if (e == a.$) break } return c - 1
            } function d(a, c) { for (var d = c ? Infinity : 0, e = 0; e < a.length; e++) { var f = b(a[e]); if (c ? f < d : f > d) d = f } return d } function m(b, c) {
                for (var e = q(b) ? b : a(b), f = e[0].getAscendant("table"), g = d(e, 1), e = d(e), h = c ? g : e, k = CKEDITOR.tools.buildTableMap(f), f = [], g = [], e = [], l = k.length, m = 0; m < l; m++) { var n = c ? k[m][h - 1] : k[m][h + 1]; f.push(k[m][h]); g.push(n) } for (m = 0; m < l; m++)f[m] && (1 < f[m].colSpan && g[m] == f[m] ? (k = f[m], k.colSpan += 1) : (h = new CKEDITOR.dom.element(f[m]),
                    k = h.clone(), k.removeAttribute("colSpan"), k.appendBogus(), k[c ? "insertBefore" : "insertAfter"].call(k, h), e.push(k), k = k.$), m += k.rowSpan - 1); return e
            } function h(b) {
                function c(a) {
                    var b = a.getRanges(), d, e; if (1 !== b.length) return a; b = b[0]; if (b.collapsed || 0 !== b.endOffset) return a; d = b.endContainer; e = d.getName().toLowerCase(); if ("td" !== e && "th" !== e) return a; for ((e = d.getPrevious()) || (e = d.getParent().getPrevious().getLast()); e.type !== CKEDITOR.NODE_TEXT && "br" !== e.getName().toLowerCase();)if (e = e.getLast(), !e) return a;
                    b.setEndAt(e, CKEDITOR.POSITION_BEFORE_END); return b.select()
                } CKEDITOR.env.webkit && !b.isFake && (b = c(b)); var d = b.getRanges(), e = a(b), f = e[0], g = e[e.length - 1], e = f.getAscendant("table"), h = CKEDITOR.tools.buildTableMap(e), k, l, m = []; b.reset(); var n = 0; for (b = h.length; n < b; n++)for (var p = 0, q = h[n].length; p < q; p++)void 0 === k && h[n][p] == f.$ && (k = p), h[n][p] == g.$ && (l = p); for (n = k; n <= l; n++)for (p = 0; p < h.length; p++)g = h[p], f = new CKEDITOR.dom.element(e.$.rows[p]), g = new CKEDITOR.dom.element(g[n]), g.$ && (1 == g.$.colSpan ? g.remove() : --g.$.colSpan,
                    p += g.$.rowSpan - 1, f.$.cells.length || m.push(f)); k = h[0].length - 1 > l ? new CKEDITOR.dom.element(h[0][l + 1]) : k && -1 !== h[0][k - 1].cellIndex ? new CKEDITOR.dom.element(h[0][k - 1]) : new CKEDITOR.dom.element(e.$.parentNode); m.length == b && (d[0].moveToPosition(e, CKEDITOR.POSITION_AFTER_END), d[0].select(), e.remove()); return k
            } function l(a, b) { var c = a.getStartElement().getAscendant({ td: 1, th: 1 }, !0); if (c) { var d = c.clone(); d.appendBogus(); b ? d.insertBefore(c) : d.insertAfter(c) } } function c(b) {
                if (b instanceof CKEDITOR.dom.selection) {
                    var d =
                        b.getRanges(), e = a(b), f = e[0] && e[0].getAscendant("table"), g; a: { var h = 0; g = e.length - 1; for (var l = {}, m, n; m = e[h++];)CKEDITOR.dom.element.setMarker(l, m, "delete_cell", !0); for (h = 0; m = e[h++];)if ((n = m.getPrevious()) && !n.getCustomData("delete_cell") || (n = m.getNext()) && !n.getCustomData("delete_cell")) { CKEDITOR.dom.element.clearAllMarkers(l); g = n; break a } CKEDITOR.dom.element.clearAllMarkers(l); h = e[0].getParent(); (h = h.getPrevious()) ? g = h.getLast() : (h = e[g].getParent(), g = (h = h.getNext()) ? h.getChild(0) : null) } b.reset(); for (b =
                            e.length - 1; 0 <= b; b--)c(e[b]); g ? k(g, !0) : f && (d[0].moveToPosition(f, CKEDITOR.POSITION_BEFORE_START), d[0].select(), f.remove())
                } else b instanceof CKEDITOR.dom.element && (d = b.getParent(), 1 == d.getChildCount() ? d.remove() : b.remove())
            } function k(a, b) { var c = a.getDocument(), d = CKEDITOR.document; CKEDITOR.env.ie && 10 == CKEDITOR.env.version && (d.focus(), c.focus()); c = new CKEDITOR.dom.range(c); c["moveToElementEdit" + (b ? "End" : "Start")](a) || (c.selectNodeContents(a), c.collapse(b ? !1 : !0)); c.select(!0) } function f(a, b, c) {
                a = a[b];
                if ("undefined" == typeof c) return a; for (b = 0; a && b < a.length; b++) { if (c.is && a[b] == c.$) return b; if (b == c) return new CKEDITOR.dom.element(a[b]) } return c.is ? -1 : null
            } function n(b, c, d) {
                var e = a(b), g; if ((c ? 1 != e.length : 2 > e.length) || (g = b.getCommonAncestor()) && g.type == CKEDITOR.NODE_ELEMENT && g.is("table")) return !1; b = e[0]; g = b.getAscendant("table"); var h = CKEDITOR.tools.buildTableMap(g), k = h.length, l = h[0].length, m = b.getParent().$.rowIndex, n = f(h, m, b), p; if (c) {
                    var q; try {
                        var t = parseInt(b.getAttribute("rowspan"), 10) || 1; p = parseInt(b.getAttribute("colspan"),
                            10) || 1; q = h["up" == c ? m - t : "down" == c ? m + t : m]["left" == c ? n - p : "right" == c ? n + p : n]
                    } catch (H) { return !1 } if (!q || b.$ == q) return !1; e["up" == c || "left" == c ? "unshift" : "push"](new CKEDITOR.dom.element(q))
                } c = b.getDocument(); var D = m, t = q = 0, M = !d && new CKEDITOR.dom.documentFragment(c), J = 0; for (c = 0; c < e.length; c++) {
                    p = e[c]; var K = p.getParent(), E = p.getFirst(), R = p.$.colSpan, P = p.$.rowSpan, K = K.$.rowIndex, N = f(h, K, p), J = J + R * P, t = Math.max(t, N - n + R); q = Math.max(q, K - m + P); d || (R = p, (P = R.getBogus()) && P.remove(), R.trim(), p.getChildren().count() && (K ==
                        D || !E || E.isBlockBoundary && E.isBlockBoundary({ br: 1 }) || (D = M.getLast(CKEDITOR.dom.walker.whitespaces(!0)), !D || D.is && D.is("br") || M.append("br")), p.moveChildren(M)), c ? p.remove() : p.setHtml("")); D = K
                } if (d) return q * t == J; M.moveChildren(b); b.appendBogus(); t >= l ? b.removeAttribute("rowSpan") : b.$.rowSpan = q; q >= k ? b.removeAttribute("colSpan") : b.$.colSpan = t; d = new CKEDITOR.dom.nodeList(g.$.rows); e = d.count(); for (c = e - 1; 0 <= c; c--)g = d.getItem(c), g.$.cells.length || (g.remove(), e++); return b
            } function p(b, c) {
                var d = a(b); if (1 <
                    d.length) return !1; if (c) return !0; var d = d[0], e = d.getParent(), g = e.getAscendant("table"), h = CKEDITOR.tools.buildTableMap(g), k = e.$.rowIndex, l = f(h, k, d), m = d.$.rowSpan, n; if (1 < m) { n = Math.ceil(m / 2); for (var m = Math.floor(m / 2), e = k + n, g = new CKEDITOR.dom.element(g.$.rows[e]), h = f(h, e), p, e = d.clone(), k = 0; k < h.length; k++)if (p = h[k], p.parentNode == g.$ && k > l) { e.insertBefore(new CKEDITOR.dom.element(p)); break } else p = null; p || g.append(e) } else for (m = n = 1, g = e.clone(), g.insertAfter(e), g.append(e = d.clone()), p = f(h, k), l = 0; l < p.length; l++)p[l].rowSpan++;
                e.appendBogus(); d.$.rowSpan = n; e.$.rowSpan = m; 1 == n && d.removeAttribute("rowSpan"); 1 == m && e.removeAttribute("rowSpan"); return e
            } function t(b, c) {
                var d = a(b); if (1 < d.length) return !1; if (c) return !0; var d = d[0], e = d.getParent(), g = e.getAscendant("table"), g = CKEDITOR.tools.buildTableMap(g), h = f(g, e.$.rowIndex, d), k = d.$.colSpan; if (1 < k) e = Math.ceil(k / 2), k = Math.floor(k / 2); else { for (var k = e = 1, l = [], m = 0; m < g.length; m++) { var n = g[m]; l.push(n[h]); 1 < n[h].rowSpan && (m += n[h].rowSpan - 1) } for (g = 0; g < l.length; g++)l[g].colSpan++ } g = d.clone();
                g.insertAfter(d); g.appendBogus(); d.$.colSpan = e; g.$.colSpan = k; 1 == e && d.removeAttribute("colSpan"); 1 == k && g.removeAttribute("colSpan"); return g
            } var q = CKEDITOR.tools.isArray; CKEDITOR.plugins.tabletools = {
                requires: "table,dialog,contextmenu", init: function (b) {
                    function d(a) { return CKEDITOR.tools.extend(a || {}, { contextSensitive: 1, refresh: function (a, b) { this.setState(b.contains({ td: 1, th: 1 }, 1) ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED) } }) } function f(a, c) { var d = b.addCommand(a, c); b.addFeature(d) } var q = b.lang.table,
                        A = CKEDITOR.tools.style.parse, v = "td{width} td{height} td{border-color} td{background-color} td{white-space} td{vertical-align} td{text-align} td[colspan] td[rowspan] th".split(" "); f("cellProperties", new CKEDITOR.dialogCommand("cellProperties", d({
                            allowedContent: "td th{width,height,border-color,background-color,white-space,vertical-align,text-align}[colspan,rowspan]", requiredContent: v, contentTransformations: [[{
                                element: "td", left: function (a) { return a.styles.background && A.background(a.styles.background).color },
                                right: function (a) { a.styles["background-color"] = A.background(a.styles.background).color }
                            }, { element: "td", check: "td{vertical-align}", left: function (a) { return a.attributes && a.attributes.valign }, right: function (a) { a.styles["vertical-align"] = a.attributes.valign; delete a.attributes.valign } }], [{
                                element: "tr", check: "td{height}", left: function (a) { return a.styles && a.styles.height }, right: function (a) {
                                    CKEDITOR.tools.array.forEach(a.children, function (b) { b.name in { td: 1, th: 1 } && (b.attributes["cke-row-height"] = a.styles.height) });
                                    delete a.styles.height
                                }
                            }], [{ element: "td", check: "td{height}", left: function (a) { return (a = a.attributes) && a["cke-row-height"] }, right: function (a) { a.styles.height = a.attributes["cke-row-height"]; delete a.attributes["cke-row-height"] } }]]
                        }))); CKEDITOR.dialog.add("cellProperties", this.path + "dialogs/tableCell.js"); f("rowDelete", d({ requiredContent: "table", exec: function (a) { a = a.getSelection(); (a = e(a)) && k(a) } })); f("rowInsertBefore", d({ requiredContent: "table", exec: function (b) { b = b.getSelection(); b = a(b); g(b, !0) } }));
                    f("rowInsertAfter", d({ requiredContent: "table", exec: function (b) { b = b.getSelection(); b = a(b); g(b) } })); f("columnDelete", d({ requiredContent: "table", exec: function (a) { a = a.getSelection(); (a = h(a)) && k(a, !0) } })); f("columnInsertBefore", d({ requiredContent: "table", exec: function (b) { b = b.getSelection(); b = a(b); m(b, !0) } })); f("columnInsertAfter", d({ requiredContent: "table", exec: function (b) { b = b.getSelection(); b = a(b); m(b) } })); f("cellDelete", d({ requiredContent: "table", exec: function (a) { a = a.getSelection(); c(a) } })); f("cellMerge",
                        d({ allowedContent: "td[colspan,rowspan]", requiredContent: "td[colspan,rowspan]", exec: function (a, b) { b.cell = n(a.getSelection()); k(b.cell, !0) } })); f("cellMergeRight", d({ allowedContent: "td[colspan]", requiredContent: "td[colspan]", exec: function (a, b) { b.cell = n(a.getSelection(), "right"); k(b.cell, !0) } })); f("cellMergeDown", d({ allowedContent: "td[rowspan]", requiredContent: "td[rowspan]", exec: function (a, b) { b.cell = n(a.getSelection(), "down"); k(b.cell, !0) } })); f("cellVerticalSplit", d({
                            allowedContent: "td[rowspan]", requiredContent: "td[rowspan]",
                            exec: function (a) { k(t(a.getSelection())) }
                        })); f("cellHorizontalSplit", d({ allowedContent: "td[colspan]", requiredContent: "td[colspan]", exec: function (a) { k(p(a.getSelection())) } })); f("cellInsertBefore", d({ requiredContent: "table", exec: function (a) { a = a.getSelection(); l(a, !0) } })); f("cellInsertAfter", d({ requiredContent: "table", exec: function (a) { a = a.getSelection(); l(a) } })); b.addMenuItems && b.addMenuItems({
                            tablecell: {
                                label: q.cell.menu, group: "tablecell", order: 1, getItems: function () {
                                    var c = b.getSelection(), d = a(c), c =
                                    {
                                        tablecell_insertBefore: CKEDITOR.TRISTATE_OFF, tablecell_insertAfter: CKEDITOR.TRISTATE_OFF, tablecell_delete: CKEDITOR.TRISTATE_OFF, tablecell_merge: n(c, null, !0) ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED, tablecell_merge_right: n(c, "right", !0) ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED, tablecell_merge_down: n(c, "down", !0) ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED, tablecell_split_vertical: t(c, !0) ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED, tablecell_split_horizontal: p(c, !0) ? CKEDITOR.TRISTATE_OFF :
                                            CKEDITOR.TRISTATE_DISABLED
                                    }; b.filter.check(v) && (c.tablecell_properties = 0 < d.length ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED); return c
                                }
                            }, tablecell_insertBefore: { label: q.cell.insertBefore, group: "tablecell", command: "cellInsertBefore", order: 5 }, tablecell_insertAfter: { label: q.cell.insertAfter, group: "tablecell", command: "cellInsertAfter", order: 10 }, tablecell_delete: { label: q.cell.deleteCell, group: "tablecell", command: "cellDelete", order: 15 }, tablecell_merge: {
                                label: q.cell.merge, group: "tablecell", command: "cellMerge",
                                order: 16
                            }, tablecell_merge_right: { label: q.cell.mergeRight, group: "tablecell", command: "cellMergeRight", order: 17 }, tablecell_merge_down: { label: q.cell.mergeDown, group: "tablecell", command: "cellMergeDown", order: 18 }, tablecell_split_horizontal: { label: q.cell.splitHorizontal, group: "tablecell", command: "cellHorizontalSplit", order: 19 }, tablecell_split_vertical: { label: q.cell.splitVertical, group: "tablecell", command: "cellVerticalSplit", order: 20 }, tablecell_properties: {
                                label: q.cell.title, group: "tablecellproperties", command: "cellProperties",
                                order: 21
                            }, tablerow: { label: q.row.menu, group: "tablerow", order: 1, getItems: function () { return { tablerow_insertBefore: CKEDITOR.TRISTATE_OFF, tablerow_insertAfter: CKEDITOR.TRISTATE_OFF, tablerow_delete: CKEDITOR.TRISTATE_OFF } } }, tablerow_insertBefore: { label: q.row.insertBefore, group: "tablerow", command: "rowInsertBefore", order: 5 }, tablerow_insertAfter: { label: q.row.insertAfter, group: "tablerow", command: "rowInsertAfter", order: 10 }, tablerow_delete: { label: q.row.deleteRow, group: "tablerow", command: "rowDelete", order: 15 },
                            tablecolumn: { label: q.column.menu, group: "tablecolumn", order: 1, getItems: function () { return { tablecolumn_insertBefore: CKEDITOR.TRISTATE_OFF, tablecolumn_insertAfter: CKEDITOR.TRISTATE_OFF, tablecolumn_delete: CKEDITOR.TRISTATE_OFF } } }, tablecolumn_insertBefore: { label: q.column.insertBefore, group: "tablecolumn", command: "columnInsertBefore", order: 5 }, tablecolumn_insertAfter: { label: q.column.insertAfter, group: "tablecolumn", command: "columnInsertAfter", order: 10 }, tablecolumn_delete: {
                                label: q.column.deleteColumn, group: "tablecolumn",
                                command: "columnDelete", order: 15
                            }
                        }); b.contextMenu && b.contextMenu.addListener(function (a, b, c) { return (a = c.contains({ td: 1, th: 1 }, 1)) && !a.isReadOnly() ? { tablecell: CKEDITOR.TRISTATE_OFF, tablerow: CKEDITOR.TRISTATE_OFF, tablecolumn: CKEDITOR.TRISTATE_OFF } : null })
                }, getCellColIndex: b, insertRow: g, insertColumn: m, getSelectedCells: a
            }; CKEDITOR.plugins.add("tabletools", CKEDITOR.plugins.tabletools)
        })(); CKEDITOR.tools.buildTableMap = function (a, g, e, b, d) {
            a = a.$.rows; e = e || 0; b = "number" === typeof b ? b : a.length - 1; d = "number" === typeof d ?
                d : -1; var m = -1, h = []; for (g = g || 0; g <= b; g++) { m++; !h[m] && (h[m] = []); for (var l = -1, c = e; c <= (-1 === d ? a[g].cells.length - 1 : d); c++) { var k = a[g].cells[c]; if (!k) break; for (l++; h[m][l];)l++; for (var f = isNaN(k.colSpan) ? 1 : k.colSpan, k = isNaN(k.rowSpan) ? 1 : k.rowSpan, n = 0; n < k && !(g + n > b); n++) { h[m + n] || (h[m + n] = []); for (var p = 0; p < f; p++)h[m + n][l + p] = a[g].cells[c] } l += f - 1; if (-1 !== d && l >= d) break } } return h
        }; (function () {
            function a(a) { return CKEDITOR.plugins.widget && CKEDITOR.plugins.widget.isDomWidget(a) } function g(a, b) {
                var d = a.getAscendant("table"),
                e = b.getAscendant("table"), f = CKEDITOR.tools.buildTableMap(d), g = c(a), h = c(b), k = [], l = {}, m, n; d.contains(e) && (b = b.getAscendant({ td: 1, th: 1 }), h = c(b)); g > h && (d = g, g = h, h = d, d = a, a = b, b = d); for (d = 0; d < f[g].length; d++)if (a.$ === f[g][d]) { m = d; break } for (d = 0; d < f[h].length; d++)if (b.$ === f[h][d]) { n = d; break } m > n && (d = m, m = n, n = d); for (d = g; d <= h; d++)for (g = m; g <= n; g++)e = new CKEDITOR.dom.element(f[d][g]), e.$ && !e.getCustomData("selected_cell") && (k.push(e), CKEDITOR.dom.element.setMarker(l, e, "selected_cell", !0)); CKEDITOR.dom.element.clearAllMarkers(l);
                return k
            } function e(a) { return (a = a.editable().findOne(".cke_table-faked-selection")) && a.getAscendant("table") } function b(a, b) {
                var c = a.editable().find(".cke_table-faked-selection"), d = a.editable().findOne("[data-cke-table-faked-selection-table]"), e; a.fire("lockSnapshot"); a.editable().removeClass("cke_table-faked-selection-editor"); for (e = 0; e < c.count(); e++)c.getItem(e).removeClass("cke_table-faked-selection"); d && d.data("cke-table-faked-selection-table", !1); a.fire("unlockSnapshot"); b && (r = { active: !1 }, a.getSelection().isInTable() &&
                    a.getSelection().reset())
            } function d(a, b) { var c = [], d, e; for (e = 0; e < b.length; e++)d = a.createRange(), d.setStartBefore(b[e]), d.setEndAfter(b[e]), c.push(d); a.getSelection().selectRanges(c) } function m(a) { var b = a.editable().find(".cke_table-faked-selection"); 1 > b.count() || (b = g(b.getItem(0), b.getItem(b.count() - 1)), d(a, b)) } function h(c, e, f) {
                var h = x(c.getSelection(!0)); e = e.is("table") ? null : e; var k; (k = r.active && !r.first) && !(k = e) && (k = c.getSelection().getRanges(), k = 1 < h.length || k[0] && !k[0].collapsed ? !0 : !1); if (k) r.first =
                    e || h[0], r.dirty = e ? !1 : 1 !== h.length; else if (r.active && e && r.first.getAscendant("table").equals(e.getAscendant("table"))) { h = g(r.first, e); if (!r.dirty && 1 === h.length && !a(f.data.getTarget())) return b(c, "mouseup" === f.name); r.dirty = !0; r.last = e; d(c, h) }
            } function l(a) {
                var c = (a = a.editor || a.sender.editor) && a.getSelection(), d = c && c.getRanges() || [], e = d && d[0].getEnclosedNode(), e = e && e.type == CKEDITOR.NODE_ELEMENT && e.is("img"), f; if (c && (b(a), c.isInTable() && c.isFake)) if (e) a.getSelection().reset(); else if (!d[0]._getTableElement({ table: 1 }).hasAttribute("data-cke-tableselection-ignored")) {
                    1 ===
                    d.length && d[0]._getTableElement() && d[0]._getTableElement().is("table") && (f = d[0]._getTableElement()); f = x(c, f); a.fire("lockSnapshot"); for (c = 0; c < f.length; c++)f[c].addClass("cke_table-faked-selection"); 0 < f.length && (a.editable().addClass("cke_table-faked-selection-editor"), f[0].getAscendant("table").data("cke-table-faked-selection-table", "")); a.fire("unlockSnapshot")
                }
            } function c(a) { return a.getAscendant("tr", !0).$.rowIndex } function k(c) {
                function d(a, b) {
                    return a && b ? a.equals(b) || a.contains(b) || b.contains(a) ||
                        a.getCommonAncestor(b).is(u) : !1
                } function f(a) { return !a.getAscendant("table", !0) && a.getDocument().equals(l.document) } function g(a, b, c, d) { if ("mousedown" === a.name && (CKEDITOR.tools.getMouseButton(a) === CKEDITOR.MOUSE_BUTTON_LEFT || !d)) return !0; if (b = a.name === (CKEDITOR.env.gecko ? "mousedown" : "mouseup") && !f(a.data.getTarget())) a = a.data.getTarget().getAscendant({ td: 1, th: 1 }, !0), b = !(a && a.hasClass("cke_table-faked-selection")); return b } if (c.data.getTarget().getName && ("mouseup" === c.name || !a(c.data.getTarget()))) {
                    var l =
                        c.editor || c.listenerData.editor, n = l.getSelection(1), p = e(l), q = c.data.getTarget(), t = q && q.getAscendant({ td: 1, th: 1 }, !0), q = q && q.getAscendant("table", !0), u = { table: 1, thead: 1, tbody: 1, tfoot: 1, tr: 1, td: 1, th: 1 }; q && q.hasAttribute("data-cke-tableselection-ignored") || (g(c, n, p, q) && b(l, !0), !r.active && "mousedown" === c.name && CKEDITOR.tools.getMouseButton(c) === CKEDITOR.MOUSE_BUTTON_LEFT && q && (r = { active: !0 }, CKEDITOR.document.on("mouseup", k, null, { editor: l })), (t || q) && h(l, t || q, c), "mouseup" === c.name && (CKEDITOR.tools.getMouseButton(c) ===
                            CKEDITOR.MOUSE_BUTTON_LEFT && (f(c.data.getTarget()) || d(p, q)) && m(l), r = { active: !1 }, CKEDITOR.document.removeListener("mouseup", k)))
                }
            } function f(a) { var b = a.data.getTarget().getAscendant("table", !0); b && b.hasAttribute("data-cke-tableselection-ignored") || (b = a.data.getTarget().getAscendant({ td: 1, th: 1 }, !0)) && !b.hasClass("cke_table-faked-selection") && (a.cancel(), a.data.preventDefault()) } function n(a, b) {
                function c(a) { a.cancel() } var d = a.getSelection(), e = d.createBookmarks(), f = a.document, g = a.createRange(), h = f.getDocumentElement().$,
                    k = CKEDITOR.env.ie && 9 > CKEDITOR.env.version, l = a.blockless || CKEDITOR.env.ie ? "span" : "div", m, n, p, q; f.getById("cke_table_copybin") || (m = f.createElement(l), n = f.createElement(l), n.setAttributes({ id: "cke_table_copybin", "data-cke-temp": "1" }), m.setStyles({ position: "absolute", width: "1px", height: "1px", overflow: "hidden" }), m.setStyle("ltr" == a.config.contentsLangDirection ? "left" : "right", "-5000px"), m.setHtml(a.getSelectedHtml(!0)), a.fire("lockSnapshot"), n.append(m), a.editable().append(n), q = a.on("selectionChange", c,
                        null, null, 0), k && (p = h.scrollTop), g.selectNodeContents(m), g.select(), k && (h.scrollTop = p), setTimeout(function () { n.remove(); d.selectBookmarks(e); q.removeListener(); a.fire("unlockSnapshot"); b && (a.extractSelectedHtml(), a.fire("saveSnapshot")) }, 100))
            } function p(a) { var b = a.editor || a.sender.editor, c = b.getSelection(); c.isInTable() && (c.getRanges()[0]._getTableElement({ table: 1 }).hasAttribute("data-cke-tableselection-ignored") || n(b, "cut" === a.name)) } function t(a) { this._reset(); a && this.setSelectedCells(a) } function q(a,
                b, c) { a.on("beforeCommandExec", function (c) { -1 !== CKEDITOR.tools.array.indexOf(b, c.data.name) && (c.data.selectedCells = x(a.getSelection())) }); a.on("afterCommandExec", function (d) { -1 !== CKEDITOR.tools.array.indexOf(b, d.data.name) && c(a, d.data) }) } var r = { active: !1 }, w, x, u, A, v; t.prototype = {}; t.prototype._reset = function () { this.cells = { first: null, last: null, all: [] }; this.rows = { first: null, last: null } }; t.prototype.setSelectedCells = function (a) {
                    this._reset(); a = a.slice(0); this._arraySortByDOMOrder(a); this.cells.all = a; this.cells.first =
                        a[0]; this.cells.last = a[a.length - 1]; this.rows.first = a[0].getAscendant("tr"); this.rows.last = this.cells.last.getAscendant("tr")
                }; t.prototype.getTableMap = function () { var a = u(this.cells.first), b; a: { b = this.cells.last; var d = b.getAscendant("table"), e = c(b), d = CKEDITOR.tools.buildTableMap(d), f; for (f = 0; f < d[e].length; f++)if ((new CKEDITOR.dom.element(d[e][f])).equals(b)) { b = f; break a } b = void 0 } return CKEDITOR.tools.buildTableMap(this._getTable(), c(this.rows.first), a, c(this.rows.last), b) }; t.prototype._getTable = function () { return this.rows.first.getAscendant("table") };
            t.prototype.insertRow = function (a, b, c) { if ("undefined" === typeof a) a = 1; else if (0 >= a) return; for (var d = this.cells.first.$.cellIndex, e = this.cells.last.$.cellIndex, f = c ? [] : this.cells.all, g, h = 0; h < a; h++)g = A(c ? this.cells.all : f, b), g = CKEDITOR.tools.array.filter(g.find("td, th").toArray(), function (a) { return c ? !0 : a.$.cellIndex >= d && a.$.cellIndex <= e }), f = b ? g.concat(f) : f.concat(g); this.setSelectedCells(f) }; t.prototype.insertColumn = function (a) {
                function b(a) { a = c(a); return a >= f && a <= g } if ("undefined" === typeof a) a = 1; else if (0 >=
                    a) return; for (var d = this.cells, e = d.all, f = c(d.first), g = c(d.last), d = 0; d < a; d++)e = e.concat(CKEDITOR.tools.array.filter(v(e), b)); this.setSelectedCells(e)
            }; t.prototype.emptyCells = function (a) { a = a || this.cells.all; for (var b = 0; b < a.length; b++)a[b].setHtml("") }; t.prototype._arraySortByDOMOrder = function (a) { a.sort(function (a, b) { return a.getPosition(b) & CKEDITOR.POSITION_PRECEDING ? -1 : 1 }) }; var z = {
                onPaste: function (a) {
                    function b(a) { var c = e.createRange(); c.selectNodeContents(a); c.select() } function c(a) {
                        return Math.max.apply(null,
                            CKEDITOR.tools.array.map(a, function (a) { return a.length }, 0))
                    } var e = a.editor, f = e.getSelection(), h = x(f), k = f.isInTable(!0) && this.isBoundarySelection(f), l = this.findTableInPastedContent(e, a.data.dataValue), m, n; (function (a, b, c, d) {
                        a = a.getRanges(); var e = a.length && a[0]._getTableElement({ table: 1 }); if (!b.length || e && e.hasAttribute("data-cke-tableselection-ignored") || d && !c) return !1; if (b = !d) (b = a[0]) ? (b = b.clone(), b.enlarge(CKEDITOR.ENLARGE_ELEMENT), b = (b = b.getEnclosedNode()) && b.is && b.is(CKEDITOR.dtd.$tableContent)) :
                            b = void 0, b = !b; return b ? !1 : !0
                    })(f, h, l, k) && (h = h[0].getAscendant("table"), m = new t(x(f, h)), e.once("afterPaste", function () { var a; if (n) { a = new CKEDITOR.dom.element(n[0][0]); var b = n[n.length - 1]; a = g(a, new CKEDITOR.dom.element(b[b.length - 1])) } else a = m.cells.all; d(e, a) }), l ? (a.stop(), k ? (m.insertRow(1, 1 === k, !0), f.selectElement(m.rows.first)) : (m.emptyCells(), d(e, m.cells.all)), a = m.getTableMap(), n = CKEDITOR.tools.buildTableMap(l), m.insertRow(n.length - a.length), m.insertColumn(c(n) - c(a)), a = m.getTableMap(), this.pasteTable(m,
                        a, n), e.fire("saveSnapshot"), setTimeout(function () { e.fire("afterPaste") }, 0)) : (b(m.cells.first), e.once("afterPaste", function () { e.fire("lockSnapshot"); m.emptyCells(m.cells.all.slice(1)); d(e, m.cells.all); e.fire("unlockSnapshot") })))
                }, isBoundarySelection: function (a) { a = a.getRanges()[0]; var b = a.endContainer.getAscendant("tr", !0); if (b && a.collapsed) { if (a.checkBoundaryOfElement(b, CKEDITOR.START)) return 1; if (a.checkBoundaryOfElement(b, CKEDITOR.END)) return 2 } return 0 }, findTableInPastedContent: function (a, b) {
                    var c =
                        a.dataProcessor, d = new CKEDITOR.dom.element("body"); c || (c = new CKEDITOR.htmlDataProcessor(a)); d.setHtml(c.toHtml(b), { fixForBody: !1 }); return 1 < d.getChildCount() ? null : d.findOne("table")
                }, pasteTable: function (a, b, c) {
                    var d, e = u(a.cells.first), f = a._getTable(), g = {}, h, k, l, m; for (l = 0; l < c.length; l++)for (h = new CKEDITOR.dom.element(f.$.rows[a.rows.first.$.rowIndex + l]), m = 0; m < c[l].length; m++)if (k = new CKEDITOR.dom.element(c[l][m]), d = b[l] && b[l][m] ? new CKEDITOR.dom.element(b[l][m]) : null, k && !k.getCustomData("processed")) {
                        if (d &&
                            d.getParent()) k.replace(d); else if (0 === m || c[l][m - 1]) (d = 0 !== m ? new CKEDITOR.dom.element(c[l][m - 1]) : null) && h.equals(d.getParent()) ? k.insertAfter(d) : 0 < e ? h.$.cells[e] ? k.insertAfter(new CKEDITOR.dom.element(h.$.cells[e])) : h.append(k) : h.append(k, !0); CKEDITOR.dom.element.setMarker(g, k, "processed", !0)
                    } else k.getCustomData("processed") && d && d.remove(); CKEDITOR.dom.element.clearAllMarkers(g)
                }
            }; CKEDITOR.plugins.tableselection = {
                getCellsBetween: g, keyboardIntegration: function (a) {
                    function b(a) {
                        var c = a.getEnclosedNode();
                        c && "function" === typeof c.is && c.is({ td: 1, th: 1 }) ? c.setText("") : a.deleteContents(); CKEDITOR.tools.array.forEach(a._find("td"), function (a) { a.appendBogus() })
                    } var c = a.editable(); c.attachListener(c, "keydown", function (a) {
                        function c(b, d) {
                            if (!d.length) return null; var f = a.createRange(), g = CKEDITOR.dom.range.mergeRanges(d); CKEDITOR.tools.array.forEach(g, function (a) { a.enlarge(CKEDITOR.ENLARGE_ELEMENT) }); var h = g[0].getBoundaryNodes(), k = h.startNode, h = h.endNode; if (k && k.is && k.is(e)) {
                                for (var l = k.getAscendant("table",
                                    !0), m = k.getPreviousSourceNode(!1, CKEDITOR.NODE_ELEMENT, l), n = !1, p = function (a) { return !k.contains(a) && a.is && a.is("td", "th") }; m && !p(m);)m = m.getPreviousSourceNode(!1, CKEDITOR.NODE_ELEMENT, l); !m && h && h.is && !h.is("table") && h.getNext() && (m = h.getNext().findOne("td, th"), n = !0); if (m) f["moveToElementEdit" + (n ? "Start" : "End")](m); else f.setStartBefore(k.getAscendant("table", !0)), f.collapse(!0); g[0].deleteContents(); return [f]
                            } if (k) return f.moveToElementEditablePosition(k), [f]
                        } var d = { 37: 1, 38: 1, 39: 1, 40: 1, 8: 1, 46: 1, 13: 1 },
                            e = CKEDITOR.tools.extend({ table: 1 }, CKEDITOR.dtd.$tableContent); delete e.td; delete e.th; return function (e) {
                                var f = e.data.getKey(), g = e.data.getKeystroke(), h, k = 37 === f || 38 == f, l, m, n; if (d[f] && !a.readOnly && (h = a.getSelection()) && h.isInTable() && h.isFake) {
                                    l = h.getRanges(); m = l[0]._getTableElement(); n = l[l.length - 1]._getTableElement(); if (13 !== f || a.plugins.enterkey) e.data.preventDefault(), e.cancel(); if (36 < f && 41 > f) l[0].moveToElementEditablePosition(k ? m : n, !k), h.selectRanges([l[0]]); else if (13 !== f || 13 === g || g === CKEDITOR.SHIFT +
                                        13) { for (e = 0; e < l.length; e++)b(l[e]); (e = c(m, l)) ? l = e : l[0].moveToElementEditablePosition(m); h.selectRanges(l); 13 === f && a.plugins.enterkey ? (a.fire("lockSnapshot"), 13 === g ? a.execCommand("enter") : a.execCommand("shiftEnter"), a.fire("unlockSnapshot"), a.fire("saveSnapshot")) : 13 !== f && a.fire("saveSnapshot") }
                                }
                            }
                    }(a), null, null, -1); c.attachListener(c, "keypress", function (c) {
                        var d = a.getSelection(), e = c.data.$.charCode || 13 === c.data.getKey(), f; if (!a.readOnly && d && d.isInTable() && d.isFake && e && !(c.data.getKeystroke() & CKEDITOR.CTRL)) {
                            c =
                            d.getRanges(); e = c[0].getEnclosedNode().getAscendant({ td: 1, th: 1 }, !0); for (f = 0; f < c.length; f++)b(c[f]); e && (c[0].moveToElementEditablePosition(e), d.selectRanges([c[0]]))
                        }
                    }, null, null, -1)
                }
            }; CKEDITOR.plugins.add("tableselection", {
                requires: "clipboard,tabletools", isSupportedEnvironment: function () { return !(CKEDITOR.env.ie && 11 > CKEDITOR.env.version) }, onLoad: function () {
                    w = CKEDITOR.plugins.tabletools; x = w.getSelectedCells; u = w.getCellColIndex; A = w.insertRow; v = w.insertColumn; CKEDITOR.document.appendStyleSheet(this.path +
                        "styles/tableselection.css")
                }, init: function (a) {
                    this.isSupportedEnvironment() && (a.addContentsCss && a.addContentsCss(this.path + "styles/tableselection.css"), a.on("contentDom", function () {
                        var b = a.editable(), c = b.isInline() ? b : a.document, d = { editor: a }; b.attachListener(c, "mousedown", k, null, d); b.attachListener(c, "mousemove", k, null, d); b.attachListener(c, "mouseup", k, null, d); b.attachListener(b, "dragstart", f); b.attachListener(a, "selectionCheck", l); CKEDITOR.plugins.tableselection.keyboardIntegration(a); CKEDITOR.plugins.clipboard &&
                            !CKEDITOR.plugins.clipboard.isCustomCopyCutSupported && (b.attachListener(b, "cut", p), b.attachListener(b, "copy", p))
                    }), a.on("paste", z.onPaste, z), q(a, "rowInsertBefore rowInsertAfter columnInsertBefore columnInsertAfter cellInsertBefore cellInsertAfter".split(" "), function (a, b) { d(a, b.selectedCells) }), q(a, ["cellMerge", "cellMergeRight", "cellMergeDown"], function (a, b) { d(a, [b.commandData.cell]) }), q(a, ["cellDelete"], function (a) { b(a, !0) }))
                }
            })
        })(); (function () {
            CKEDITOR.plugins.add("templates", {
                requires: "dialog",
                init: function (a) { CKEDITOR.dialog.add("templates", CKEDITOR.getUrl(this.path + "dialogs/templates.js")); a.addCommand("templates", new CKEDITOR.dialogCommand("templates")); a.ui.addButton && a.ui.addButton("Templates", { label: a.lang.templates.button, command: "templates", toolbar: "doctools,10" }) }
            }); var a = {}, g = {}; CKEDITOR.addTemplates = function (e, b) { a[e] = b }; CKEDITOR.getTemplates = function (e) { return a[e] }; CKEDITOR.loadTemplates = function (a, b) {
                for (var d = [], m = 0, h = a.length; m < h; m++)g[a[m]] || (d.push(a[m]), g[a[m]] = 1); d.length ?
                    CKEDITOR.scriptLoader.load(d, b) : setTimeout(b, 0)
            }
        })(); CKEDITOR.config.templates_files = [CKEDITOR.getUrl("plugins/templates/templates/default.js")]; CKEDITOR.config.templates_replaceContent = !0; "use strict"; (function () {
            function a(a, b) { return CKEDITOR.tools.array.reduce(b, function (a, b) { return b(a) }, a) } var g = [CKEDITOR.CTRL + 90, CKEDITOR.CTRL + 89, CKEDITOR.CTRL + CKEDITOR.SHIFT + 90], e = { 8: 1, 46: 1 }; CKEDITOR.plugins.add("undo", {
                init: function (a) {
                    function d(a) { l.enabled && !1 !== a.data.command.canUndo && l.save() } function e() {
                        l.enabled =
                        a.readOnly ? !1 : "wysiwyg" == a.mode; l.onChange()
                    } var l = a.undoManager = new b(a), m = l.editingHandler = new h(l), t = a.addCommand("undo", { exec: function () { l.undo() && (a.selectionChange(), this.fire("afterUndo")) }, startDisabled: !0, canUndo: !1 }), q = a.addCommand("redo", { exec: function () { l.redo() && (a.selectionChange(), this.fire("afterRedo")) }, startDisabled: !0, canUndo: !1 }); a.setKeystroke([[g[0], "undo"], [g[1], "redo"], [g[2], "redo"]]); l.onChange = function () {
                        t.setState(l.undoable() ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED);
                        q.setState(l.redoable() ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED)
                    }; a.on("beforeCommandExec", d); a.on("afterCommandExec", d); a.on("saveSnapshot", function (a) { l.save(a.data && a.data.contentOnly) }); a.on("contentDom", m.attachListeners, m); a.on("instanceReady", function () { a.fire("saveSnapshot") }); a.on("beforeModeUnload", function () { "wysiwyg" == a.mode && l.save(!0) }); a.on("mode", e); a.on("readOnly", e); a.ui.addButton && (a.ui.addButton("Undo", { label: a.lang.undo.undo, command: "undo", toolbar: "undo,10" }), a.ui.addButton("Redo",
                        { label: a.lang.undo.redo, command: "redo", toolbar: "undo,20" })); a.resetUndo = function () { l.reset(); a.fire("saveSnapshot") }; a.on("updateSnapshot", function () { l.currentImage && l.update() }); a.on("lockSnapshot", function (a) { a = a.data; l.lock(a && a.dontUpdate, a && a.forceUpdate) }); a.on("unlockSnapshot", l.unlock, l)
                }
            }); CKEDITOR.plugins.undo = {}; var b = CKEDITOR.plugins.undo.UndoManager = function (a) {
                this.strokesRecorded = [0, 0]; this.locked = null; this.previousKeyGroup = -1; this.limit = a.config.undoStackSize || 20; this.strokesLimit =
                    25; this._filterRules = []; this.editor = a; this.reset(); CKEDITOR.env.ie && this.addFilterRule(function (a) { return a.replace(/\s+data-cke-expando=".*?"/g, "") })
            }; b.prototype = {
                type: function (a, d) { var e = b.getKeyGroup(a), g = this.strokesRecorded[e] + 1; d = d || g >= this.strokesLimit; this.typing || (this.hasUndo = this.typing = !0, this.hasRedo = !1, this.onChange()); d ? (g = 0, this.editor.fire("saveSnapshot")) : this.editor.fire("change"); this.strokesRecorded[e] = g; this.previousKeyGroup = e }, keyGroupChanged: function (a) {
                    return b.getKeyGroup(a) !=
                        this.previousKeyGroup
                }, reset: function () { this.snapshots = []; this.index = -1; this.currentImage = null; this.hasRedo = this.hasUndo = !1; this.locked = null; this.resetType() }, resetType: function () { this.strokesRecorded = [0, 0]; this.typing = !1; this.previousKeyGroup = -1 }, refreshState: function () { this.hasUndo = !!this.getNextImage(!0); this.hasRedo = !!this.getNextImage(!1); this.resetType(); this.onChange() }, save: function (a, b, e) {
                    var g = this.editor; if (this.locked || "ready" != g.status || "wysiwyg" != g.mode) return !1; var h = g.editable(); if (!h ||
                        "ready" != h.status) return !1; h = this.snapshots; b || (b = new d(g)); if (!1 === b.contents) return !1; if (this.currentImage) if (b.equalsContent(this.currentImage)) { if (a || b.equalsSelection(this.currentImage)) return !1 } else !1 !== e && g.fire("change"); h.splice(this.index + 1, h.length - this.index - 1); h.length == this.limit && h.shift(); this.index = h.push(b) - 1; this.currentImage = b; !1 !== e && this.refreshState(); return !0
                }, restoreImage: function (a) {
                    var b = this.editor, d; a.bookmarks && (b.focus(), d = b.getSelection()); this.locked = { level: 999 }; this.editor.loadSnapshot(a.contents);
                    a.bookmarks ? d.selectBookmarks(a.bookmarks) : CKEDITOR.env.ie && (d = this.editor.document.getBody().$.createTextRange(), d.collapse(!0), d.select()); this.locked = null; this.index = a.index; this.currentImage = this.snapshots[this.index]; this.update(); this.refreshState(); b.fire("change")
                }, getNextImage: function (a) {
                    var b = this.snapshots, d = this.currentImage, e; if (d) if (a) for (e = this.index - 1; 0 <= e; e--) { if (a = b[e], !d.equalsContent(a)) return a.index = e, a } else for (e = this.index + 1; e < b.length; e++)if (a = b[e], !d.equalsContent(a)) return a.index =
                        e, a; return null
                }, redoable: function () { return this.enabled && this.hasRedo }, undoable: function () { return this.enabled && this.hasUndo }, undo: function () { if (this.undoable()) { this.save(!0); var a = this.getNextImage(!0); if (a) return this.restoreImage(a), !0 } return !1 }, redo: function () { if (this.redoable() && (this.save(!0), this.redoable())) { var a = this.getNextImage(!1); if (a) return this.restoreImage(a), !0 } return !1 }, update: function (a) {
                    if (!this.locked) {
                        a || (a = new d(this.editor)); for (var b = this.index, e = this.snapshots; 0 < b && this.currentImage.equalsContent(e[b -
                            1]);)--b; e.splice(b, this.index - b + 1, a); this.index = b; this.currentImage = a
                    }
                }, updateSelection: function (a) { if (!this.snapshots.length) return !1; var b = this.snapshots, d = b[b.length - 1]; return d.equalsContent(a) && !d.equalsSelection(a) ? (this.currentImage = b[b.length - 1] = a, !0) : !1 }, lock: function (a, b) { if (this.locked) this.locked.level++; else if (a) this.locked = { level: 1 }; else { var e = null; if (b) e = !0; else { var g = new d(this.editor, !0); this.currentImage && this.currentImage.equalsContent(g) && (e = g) } this.locked = { update: e, level: 1 } } },
                unlock: function () { if (this.locked && !--this.locked.level) { var a = this.locked.update; this.locked = null; if (!0 === a) this.update(); else if (a) { var b = new d(this.editor, !0); a.equalsContent(b) || this.update() } } }, addFilterRule: function (a) { this._filterRules.push(a) }
            }; b.navigationKeyCodes = { 37: 1, 38: 1, 39: 1, 40: 1, 36: 1, 35: 1, 33: 1, 34: 1 }; b.keyGroups = { PRINTABLE: 0, FUNCTIONAL: 1 }; b.isNavigationKey = function (a) { return !!b.navigationKeyCodes[a] }; b.getKeyGroup = function (a) { var d = b.keyGroups; return e[a] ? d.FUNCTIONAL : d.PRINTABLE }; b.getOppositeKeyGroup =
                function (a) { var d = b.keyGroups; return a == d.FUNCTIONAL ? d.PRINTABLE : d.FUNCTIONAL }; b.ieFunctionalKeysBug = function (a) { return CKEDITOR.env.ie && b.getKeyGroup(a) == b.keyGroups.FUNCTIONAL }; var d = CKEDITOR.plugins.undo.Image = function (b, d) { this.editor = b; b.fire("beforeUndoImage"); var e = b.getSnapshot(); e && (this.contents = a(e, b.undoManager._filterRules)); d || (this.bookmarks = (e = e && b.getSelection()) && e.createBookmarks2(!0)); b.fire("afterUndoImage") }, m = /\b(?:href|src|name)="[^"]*?"/gi; d.prototype = {
                    equalsContent: function (a) {
                        var b =
                            this.contents; a = a.contents; CKEDITOR.env.ie && (CKEDITOR.env.ie7Compat || CKEDITOR.env.quirks) && (b = b.replace(m, ""), a = a.replace(m, "")); return b != a ? !1 : !0
                    }, equalsSelection: function (a) { var b = this.bookmarks; a = a.bookmarks; if (b || a) { if (!b || !a || b.length != a.length) return !1; for (var d = 0; d < b.length; d++) { var e = b[d], g = a[d]; if (e.startOffset != g.startOffset || e.endOffset != g.endOffset || !CKEDITOR.tools.arrayCompare(e.start, g.start) || !CKEDITOR.tools.arrayCompare(e.end, g.end)) return !1 } } return !0 }
                }; var h = CKEDITOR.plugins.undo.NativeEditingHandler =
                    function (a) { this.undoManager = a; this.ignoreInputEvent = !1; this.keyEventsStack = new l; this.lastKeydownImage = null }; h.prototype = {
                        onKeydown: function (a) {
                            var e = a.data.getKey(); if (229 !== e) if (-1 < CKEDITOR.tools.indexOf(g, a.data.getKeystroke())) a.data.preventDefault(); else if (this.keyEventsStack.cleanUp(a), a = this.undoManager, this.keyEventsStack.getLast(e) || this.keyEventsStack.push(e), this.lastKeydownImage = new d(a.editor), b.isNavigationKey(e) || this.undoManager.keyGroupChanged(e)) if (a.strokesRecorded[0] || a.strokesRecorded[1]) a.save(!1,
                                this.lastKeydownImage, !1), a.resetType()
                        }, onInput: function () { if (this.ignoreInputEvent) this.ignoreInputEvent = !1; else { var a = this.keyEventsStack.getLast(); a || (a = this.keyEventsStack.push(0)); this.keyEventsStack.increment(a.keyCode); this.keyEventsStack.getTotalInputs() >= this.undoManager.strokesLimit && (this.undoManager.type(a.keyCode, !0), this.keyEventsStack.resetInputs()) } }, onKeyup: function (a) {
                            var e = this.undoManager; a = a.data.getKey(); var f = this.keyEventsStack.getTotalInputs(); this.keyEventsStack.remove(a);
                            if (!(b.ieFunctionalKeysBug(a) && this.lastKeydownImage && this.lastKeydownImage.equalsContent(new d(e.editor, !0)))) if (0 < f) e.type(a); else if (b.isNavigationKey(a)) this.onNavigationKey(!0)
                        }, onNavigationKey: function (a) { var b = this.undoManager; !a && b.save(!0, null, !1) || b.updateSelection(new d(b.editor)); b.resetType() }, ignoreInputEventListener: function () { this.ignoreInputEvent = !0 }, activateInputEventListener: function () { this.ignoreInputEvent = !1 }, attachListeners: function () {
                            var a = this.undoManager.editor, d = a.editable(),
                            e = this; d.attachListener(d, "keydown", function (a) { e.onKeydown(a); if (b.ieFunctionalKeysBug(a.data.getKey())) e.onInput() }, null, null, 999); d.attachListener(d, CKEDITOR.env.ie ? "keypress" : "input", e.onInput, e, null, 999); d.attachListener(d, "keyup", e.onKeyup, e, null, 999); d.attachListener(d, "paste", e.ignoreInputEventListener, e, null, 999); d.attachListener(d, "drop", e.ignoreInputEventListener, e, null, 999); a.on("afterPaste", e.activateInputEventListener, e, null, 999); d.attachListener(d.isInline() ? d : a.document.getDocumentElement(),
                                "click", function () { e.onNavigationKey() }, null, null, 999); d.attachListener(this.undoManager.editor, "blur", function () { e.keyEventsStack.remove(9) }, null, null, 999)
                        }
                    }; var l = CKEDITOR.plugins.undo.KeyEventsStack = function () { this.stack = [] }; l.prototype = {
                        push: function (a) { a = this.stack.push({ keyCode: a, inputs: 0 }); return this.stack[a - 1] }, getLastIndex: function (a) { if ("number" != typeof a) return this.stack.length - 1; for (var b = this.stack.length; b--;)if (this.stack[b].keyCode == a) return b; return -1 }, getLast: function (a) {
                            a = this.getLastIndex(a);
                            return -1 != a ? this.stack[a] : null
                        }, increment: function (a) { this.getLast(a).inputs++ }, remove: function (a) { a = this.getLastIndex(a); -1 != a && this.stack.splice(a, 1) }, resetInputs: function (a) { if ("number" == typeof a) this.getLast(a).inputs = 0; else for (a = this.stack.length; a--;)this.stack[a].inputs = 0 }, getTotalInputs: function () { for (var a = this.stack.length, b = 0; a--;)b += this.stack[a].inputs; return b }, cleanUp: function (a) { a = a.data.$; a.ctrlKey || a.metaKey || this.remove(17); a.shiftKey || this.remove(16); a.altKey || this.remove(18) }
                    }
        })();
        "use strict"; (function () {
            function a(a, b) { CKEDITOR.tools.extend(this, { editor: a, editable: a.editable(), doc: a.document, win: a.window }, b, !0); this.inline = this.editable.isInline(); this.inline || (this.frame = this.win.getFrame()); this.target = this[this.inline ? "editable" : "doc"] } function g(a, b) { CKEDITOR.tools.extend(this, b, { editor: a }, !0) } function e(a, b) {
                var e = a.editable(); CKEDITOR.tools.extend(this, { editor: a, editable: e, inline: e.isInline(), doc: a.document, win: a.window, container: CKEDITOR.document.getBody(), winTop: CKEDITOR.document.getWindow() },
                    b, !0); this.hidden = {}; this.visible = {}; this.inline || (this.frame = this.win.getFrame()); this.queryViewport(); var g = CKEDITOR.tools.bind(this.queryViewport, this), h = CKEDITOR.tools.bind(this.hideVisible, this), l = CKEDITOR.tools.bind(this.removeAll, this); e.attachListener(this.winTop, "resize", g); e.attachListener(this.winTop, "scroll", g); e.attachListener(this.winTop, "resize", h); e.attachListener(this.win, "scroll", h); e.attachListener(this.inline ? e : this.frame, "mouseout", function (a) {
                        var b = a.data.$.clientX; a = a.data.$.clientY;
                        this.queryViewport(); (b <= this.rect.left || b >= this.rect.right || a <= this.rect.top || a >= this.rect.bottom) && this.hideVisible(); (0 >= b || b >= this.winTopPane.width || 0 >= a || a >= this.winTopPane.height) && this.hideVisible()
                    }, this); e.attachListener(a, "resize", g); e.attachListener(a, "mode", l); a.on("destroy", l); this.lineTpl = (new CKEDITOR.template('\x3cdiv data-cke-lineutils-line\x3d"1" class\x3d"cke_reset_all" style\x3d"{lineStyle}"\x3e\x3cspan style\x3d"{tipLeftStyle}"\x3e\x26nbsp;\x3c/span\x3e\x3cspan style\x3d"{tipRightStyle}"\x3e\x26nbsp;\x3c/span\x3e\x3c/div\x3e')).output({
                        lineStyle: CKEDITOR.tools.writeCssText(CKEDITOR.tools.extend({},
                            m, this.lineStyle, !0)), tipLeftStyle: CKEDITOR.tools.writeCssText(CKEDITOR.tools.extend({}, d, { left: "0px", "border-left-color": "red", "border-width": "6px 0 6px 6px" }, this.tipCss, this.tipLeftStyle, !0)), tipRightStyle: CKEDITOR.tools.writeCssText(CKEDITOR.tools.extend({}, d, { right: "0px", "border-right-color": "red", "border-width": "6px 6px 6px 0" }, this.tipCss, this.tipRightStyle, !0))
                    })
            } function b(a) {
                var b; if (b = a && a.type == CKEDITOR.NODE_ELEMENT) b = !(h[a.getComputedStyle("float")] || h[a.getAttribute("align")]); return b &&
                    !l[a.getComputedStyle("position")]
            } CKEDITOR.plugins.add("lineutils"); CKEDITOR.LINEUTILS_BEFORE = 1; CKEDITOR.LINEUTILS_AFTER = 2; CKEDITOR.LINEUTILS_INSIDE = 4; a.prototype = {
                start: function (a) {
                    var b = this, d = this.editor, e = this.doc, g, h, l, m, w = CKEDITOR.tools.eventsBuffer(50, function () { d.readOnly || "wysiwyg" != d.mode || (b.relations = {}, (h = e.$.elementFromPoint(l, m)) && h.nodeType && (g = new CKEDITOR.dom.element(h), b.traverseSearch(g), isNaN(l + m) || b.pixelSearch(g, l, m), a && a(b.relations, l, m))) }); this.listener = this.editable.attachListener(this.target,
                        "mousemove", function (a) { l = a.data.$.clientX; m = a.data.$.clientY; w.input() }); this.editable.attachListener(this.inline ? this.editable : this.frame, "mouseout", function () { w.reset() })
                }, stop: function () { this.listener && this.listener.removeListener() }, getRange: function () {
                    var a = {}; a[CKEDITOR.LINEUTILS_BEFORE] = CKEDITOR.POSITION_BEFORE_START; a[CKEDITOR.LINEUTILS_AFTER] = CKEDITOR.POSITION_AFTER_END; a[CKEDITOR.LINEUTILS_INSIDE] = CKEDITOR.POSITION_AFTER_START; return function (b) {
                        var d = this.editor.createRange(); d.moveToPosition(this.relations[b.uid].element,
                            a[b.type]); return d
                    }
                }(), store: function () { function a(b, c, d) { var e = b.getUniqueId(); e in d ? d[e].type |= c : d[e] = { element: b, type: c } } return function (d, e) { var g; e & CKEDITOR.LINEUTILS_AFTER && b(g = d.getNext()) && g.isVisible() && (a(g, CKEDITOR.LINEUTILS_BEFORE, this.relations), e ^= CKEDITOR.LINEUTILS_AFTER); e & CKEDITOR.LINEUTILS_INSIDE && b(g = d.getFirst()) && g.isVisible() && (a(g, CKEDITOR.LINEUTILS_BEFORE, this.relations), e ^= CKEDITOR.LINEUTILS_INSIDE); a(d, e, this.relations) } }(), traverseSearch: function (a) {
                    var d, e, g; do if (g = a.$["data-cke-expando"],
                        !(g && g in this.relations)) { if (a.equals(this.editable)) break; if (b(a)) for (d in this.lookups) (e = this.lookups[d](a)) && this.store(a, e) } while ((!a || a.type != CKEDITOR.NODE_ELEMENT || "true" != a.getAttribute("contenteditable")) && (a = a.getParent()))
                }, pixelSearch: function () {
                    function a(c, e, g, h, l) { for (var m = 0, w; l(g);) { g += h; if (25 == ++m) break; if (w = this.doc.$.elementFromPoint(e, g)) if (w == c) m = 0; else if (d(c, w) && (m = 0, b(w = new CKEDITOR.dom.element(w)))) return w } } var d = CKEDITOR.env.ie || CKEDITOR.env.webkit ? function (a, b) { return a.contains(b) } :
                        function (a, b) { return !!(a.compareDocumentPosition(b) & 16) }; return function (d, e, g) { var h = this.win.getViewPaneSize().height, k = a.call(this, d.$, e, g, -1, function (a) { return 0 < a }); e = a.call(this, d.$, e, g, 1, function (a) { return a < h }); if (k) for (this.traverseSearch(k); !k.getParent().equals(d);)k = k.getParent(); if (e) for (this.traverseSearch(e); !e.getParent().equals(d);)e = e.getParent(); for (; k || e;) { k && (k = k.getNext(b)); if (!k || k.equals(e)) break; this.traverseSearch(k); e && (e = e.getPrevious(b)); if (!e || e.equals(k)) break; this.traverseSearch(e) } }
                }(),
                greedySearch: function () { this.relations = {}; for (var a = this.editable.getElementsByTag("*"), d = 0, e, g, h; e = a.getItem(d++);)if (!e.equals(this.editable) && e.type == CKEDITOR.NODE_ELEMENT && (e.hasAttribute("contenteditable") || !e.isReadOnly()) && b(e) && e.isVisible()) for (h in this.lookups) (g = this.lookups[h](e)) && this.store(e, g); return this.relations }
            }; g.prototype = {
                locate: function () {
                    function a(c, d) {
                        var e = c.element[d === CKEDITOR.LINEUTILS_BEFORE ? "getPrevious" : "getNext"](); return e && b(e) ? (c.siblingRect = e.getClientRect(),
                            d == CKEDITOR.LINEUTILS_BEFORE ? (c.siblingRect.bottom + c.elementRect.top) / 2 : (c.elementRect.bottom + c.siblingRect.top) / 2) : d == CKEDITOR.LINEUTILS_BEFORE ? c.elementRect.top : c.elementRect.bottom
                    } return function (b) {
                        var d; this.locations = {}; for (var e in b) d = b[e], d.elementRect = d.element.getClientRect(), d.type & CKEDITOR.LINEUTILS_BEFORE && this.store(e, CKEDITOR.LINEUTILS_BEFORE, a(d, CKEDITOR.LINEUTILS_BEFORE)), d.type & CKEDITOR.LINEUTILS_AFTER && this.store(e, CKEDITOR.LINEUTILS_AFTER, a(d, CKEDITOR.LINEUTILS_AFTER)), d.type &
                            CKEDITOR.LINEUTILS_INSIDE && this.store(e, CKEDITOR.LINEUTILS_INSIDE, (d.elementRect.top + d.elementRect.bottom) / 2); return this.locations
                    }
                }(), sort: function () { var a, b, d, e; return function (g, h) { a = this.locations; b = []; for (var l in a) for (var m in a[l]) if (d = Math.abs(g - a[l][m]), b.length) { for (e = 0; e < b.length; e++)if (d < b[e].dist) { b.splice(e, 0, { uid: +l, type: m, dist: d }); break } e == b.length && b.push({ uid: +l, type: m, dist: d }) } else b.push({ uid: +l, type: m, dist: d }); return "undefined" != typeof h ? b.slice(0, h) : b } }(), store: function (a,
                    b, d) { this.locations[a] || (this.locations[a] = {}); this.locations[a][b] = d }
            }; var d = { display: "block", width: "0px", height: "0px", "border-color": "transparent", "border-style": "solid", position: "absolute", top: "-6px" }, m = { height: "0px", "border-top": "1px dashed red", position: "absolute", "z-index": 9999 }; e.prototype = {
                removeAll: function () { for (var a in this.hidden) this.hidden[a].remove(), delete this.hidden[a]; for (a in this.visible) this.visible[a].remove(), delete this.visible[a] }, hideLine: function (a) {
                    var b = a.getUniqueId();
                    a.hide(); this.hidden[b] = a; delete this.visible[b]
                }, showLine: function (a) { var b = a.getUniqueId(); a.show(); this.visible[b] = a; delete this.hidden[b] }, hideVisible: function () { for (var a in this.visible) this.hideLine(this.visible[a]) }, placeLine: function (a, b) {
                    var d, e, g; if (d = this.getStyle(a.uid, a.type)) {
                        for (g in this.visible) if (this.visible[g].getCustomData("hash") !== this.hash) { e = this.visible[g]; break } if (!e) for (g in this.hidden) if (this.hidden[g].getCustomData("hash") !== this.hash) {
                            this.showLine(e = this.hidden[g]);
                            break
                        } e || this.showLine(e = this.addLine()); e.setCustomData("hash", this.hash); this.visible[e.getUniqueId()] = e; e.setStyles(d); b && b(e)
                    }
                }, getStyle: function (a, b) {
                    var d = this.relations[a], e = this.locations[a][b], g = {}; g.width = d.siblingRect ? Math.max(d.siblingRect.width, d.elementRect.width) : d.elementRect.width; g.top = this.inline ? e + this.winTopScroll.y - this.rect.relativeY : this.rect.top + this.winTopScroll.y + e; if (g.top - this.winTopScroll.y < this.rect.top || g.top - this.winTopScroll.y > this.rect.bottom) return !1; this.inline ?
                        g.left = d.elementRect.left - this.rect.relativeX : (0 < d.elementRect.left ? g.left = this.rect.left + d.elementRect.left : (g.width += d.elementRect.left, g.left = this.rect.left), 0 < (d = g.left + g.width - (this.rect.left + this.winPane.width)) && (g.width -= d)); g.left += this.winTopScroll.x; for (var h in g) g[h] = CKEDITOR.tools.cssLength(g[h]); return g
                }, addLine: function () { var a = CKEDITOR.dom.element.createFromHtml(this.lineTpl); a.appendTo(this.container); return a }, prepare: function (a, b) { this.relations = a; this.locations = b; this.hash = Math.random() },
                cleanup: function () { var a, b; for (b in this.visible) a = this.visible[b], a.getCustomData("hash") !== this.hash && this.hideLine(a) }, queryViewport: function () { this.winPane = this.win.getViewPaneSize(); this.winTopScroll = this.winTop.getScrollPosition(); this.winTopPane = this.winTop.getViewPaneSize(); this.rect = this.getClientRect(this.inline ? this.editable : this.frame) }, getClientRect: function (a) {
                    a = a.getClientRect(); var b = this.container.getDocumentPosition(), d = this.container.getComputedStyle("position"); a.relativeX = a.relativeY =
                        0; "static" != d && (a.relativeY = b.y, a.relativeX = b.x, a.top -= a.relativeY, a.bottom -= a.relativeY, a.left -= a.relativeX, a.right -= a.relativeX); return a
                }
            }; var h = { left: 1, right: 1, center: 1 }, l = { absolute: 1, fixed: 1 }; CKEDITOR.plugins.lineutils = { finder: a, locator: g, liner: e }
        })(); (function () {
            function a(a) { return a.getName && !a.hasAttribute("data-cke-temp") } CKEDITOR.plugins.add("widgetselection", {
                init: function (a) {
                    if (CKEDITOR.env.webkit) {
                        var e = CKEDITOR.plugins.widgetselection; a.on("contentDom", function (a) {
                            a = a.editor; var d =
                                a.editable(); d.attachListener(d, "keydown", function (a) { a.data.getKeystroke() == CKEDITOR.CTRL + 65 && CKEDITOR.tools.setTimeout(function () { e.addFillers(d) || e.removeFillers(d) }, 0) }, null, null, -1); a.on("selectionCheck", function (a) { e.removeFillers(a.editor.editable()) }); a.on("paste", function (a) { a.data.dataValue = e.cleanPasteData(a.data.dataValue) }); "selectall" in a.plugins && e.addSelectAllIntegration(a)
                        })
                    }
                }
            }); CKEDITOR.plugins.widgetselection = {
                startFiller: null, endFiller: null, fillerAttribute: "data-cke-filler-webkit",
                fillerContent: "\x26nbsp;", fillerTagName: "div", addFillers: function (g) { var e = g.editor; if (!this.isWholeContentSelected(g) && 0 < g.getChildCount()) { var b = g.getFirst(a), d = g.getLast(a); b && b.type == CKEDITOR.NODE_ELEMENT && !b.isEditable() && (this.startFiller = this.createFiller(), g.append(this.startFiller, 1)); d && d.type == CKEDITOR.NODE_ELEMENT && !d.isEditable() && (this.endFiller = this.createFiller(!0), g.append(this.endFiller, 0)); if (this.hasFiller(g)) return e = e.createRange(), e.selectNodeContents(g), e.select(), !0 } return !1 },
                removeFillers: function (a) { if (this.hasFiller(a) && !this.isWholeContentSelected(a)) { var e = a.findOne(this.fillerTagName + "[" + this.fillerAttribute + "\x3dstart]"), b = a.findOne(this.fillerTagName + "[" + this.fillerAttribute + "\x3dend]"); this.startFiller && e && this.startFiller.equals(e) ? this.removeFiller(this.startFiller, a) : this.startFiller = e; this.endFiller && b && this.endFiller.equals(b) ? this.removeFiller(this.endFiller, a) : this.endFiller = b } }, cleanPasteData: function (a) {
                    a && a.length && (a = a.replace(this.createFillerRegex(),
                        "").replace(this.createFillerRegex(!0), "")); return a
                }, isWholeContentSelected: function (a) { var e = a.editor.getSelection().getRanges()[0]; return !e || e && e.collapsed ? !1 : (e = e.clone(), e.enlarge(CKEDITOR.ENLARGE_ELEMENT), !!(e && a && e.startContainer && e.endContainer && 0 === e.startOffset && e.endOffset === a.getChildCount() && e.startContainer.equals(a) && e.endContainer.equals(a))) }, hasFiller: function (a) { return 0 < a.find(this.fillerTagName + "[" + this.fillerAttribute + "]").count() }, createFiller: function (a) {
                    var e = new CKEDITOR.dom.element(this.fillerTagName);
                    e.setHtml(this.fillerContent); e.setAttribute(this.fillerAttribute, a ? "end" : "start"); e.setAttribute("data-cke-temp", 1); e.setStyles({ display: "block", width: 0, height: 0, padding: 0, border: 0, margin: 0, position: "absolute", top: 0, left: "-9999px", opacity: 0, overflow: "hidden" }); return e
                }, removeFiller: function (a, e) {
                    if (a) {
                        var b = e.editor, d = e.editor.getSelection().getRanges()[0].startPath(), m = b.createRange(), h, l; d.contains(a) && (h = a.getHtml(), l = !0); d = "start" == a.getAttribute(this.fillerAttribute); a.remove(); h && 0 < h.length &&
                            h != this.fillerContent ? (e.insertHtmlIntoRange(h, b.getSelection().getRanges()[0]), m.setStartAt(e.getChild(e.getChildCount() - 1), CKEDITOR.POSITION_BEFORE_END), b.getSelection().selectRanges([m])) : l && (d ? m.setStartAt(e.getFirst().getNext(), CKEDITOR.POSITION_AFTER_START) : m.setEndAt(e.getLast().getPrevious(), CKEDITOR.POSITION_BEFORE_END), e.editor.getSelection().selectRanges([m]))
                    }
                }, createFillerRegex: function (a) {
                    var e = this.createFiller(a).getOuterHtml().replace(/style="[^"]*"/gi, 'style\x3d"[^"]*"').replace(/>[^<]*</gi,
                        "\x3e[^\x3c]*\x3c"); return new RegExp((a ? "" : "^") + e + (a ? "$" : ""))
                }, addSelectAllIntegration: function (a) { var e = this; a.editable().attachListener(a, "beforeCommandExec", function (b) { var d = a.editable(); "selectAll" == b.data.name && d && e.addFillers(d) }, null, null, 9999) }
            }
        })(); "use strict"; (function () {
            function a(a) {
                this.editor = a; this.registered = {}; this.instances = {}; this.selected = []; this.widgetHoldingFocusedEditable = this.focused = null; this._ = { nextId: 0, upcasts: [], upcastCallbacks: [], filters: {} }; F(this); C(this); this.on("checkWidgets",
                    h); this.editor.on("contentDomInvalidated", this.checkWidgets, this); B(this); v(this); z(this); A(this); y(this)
            } function g(a, b, c, d, e) {
                var f = a.editor; CKEDITOR.tools.extend(this, d, {
                    editor: f, id: b, inline: "span" == c.getParent().getName(), element: c, data: CKEDITOR.tools.extend({}, "function" == typeof d.defaults ? d.defaults() : d.defaults), dataReady: !1, inited: !1, ready: !1, edit: g.prototype.edit, focusedEditable: null, definition: d, repository: a, draggable: !1 !== d.draggable, _: {
                        downcastFn: d.downcast && "string" == typeof d.downcast ?
                            d.downcasts[d.downcast] : d.downcast
                    }
                }, !0); a.fire("instanceCreated", this); P(this, d); this.init && this.init(); this.inited = !0; (a = this.element.data("cke-widget-data")) && this.setData(JSON.parse(decodeURIComponent(a))); e && this.setData(e); this.data.classes || this.setData("classes", this.getClasses()); this.dataReady = !0; da(this); this.fire("data", this.data); this.isInited() && f.editable().contains(this.wrapper) && (this.ready = !0, this.fire("ready"))
            } function e(a, b, c) {
                CKEDITOR.dom.element.call(this, b.$); this.editor = a;
                this._ = {}; b = this.filter = c.filter; CKEDITOR.dtd[this.getName()].p ? (this.enterMode = b ? b.getAllowedEnterMode(a.enterMode) : a.enterMode, this.shiftEnterMode = b ? b.getAllowedEnterMode(a.shiftEnterMode, !0) : a.shiftEnterMode) : this.enterMode = this.shiftEnterMode = CKEDITOR.ENTER_BR
            } function b(a, b) {
                a.addCommand(b.name, {
                    exec: function (a, c) {
                        function d() { a.widgets.finalizeCreation(h) } var e = a.widgets.focused; if (e && e.name == b.name) e.edit(); else if (b.insert) b.insert({ editor: a, commandData: c }); else if (b.template) {
                            var e = "function" ==
                                typeof b.defaults ? b.defaults() : b.defaults, e = CKEDITOR.dom.element.createFromHtml(b.template.output(e), a.document), f, g = a.widgets.wrapElement(e, b.name), h = new CKEDITOR.dom.documentFragment(g.getDocument()); h.append(g); (f = a.widgets.initOn(e, b, c && c.startupData)) ? (e = f.once("edit", function (b) {
                                    if (b.data.dialog) f.once("dialog", function (b) {
                                        b = b.data; var c, e; c = b.once("ok", d, null, null, 20); e = b.once("cancel", function (b) { b.data && !1 === b.data.hide || a.widgets.destroy(f, !0) }); b.once("hide", function () {
                                            c.removeListener();
                                            e.removeListener()
                                        })
                                    }); else d()
                                }, null, null, 999), f.edit(), e.removeListener()) : d()
                        }
                    }, allowedContent: b.allowedContent, requiredContent: b.requiredContent, contentForms: b.contentForms, contentTransformations: b.contentTransformations
                })
            } function d(a, b) {
                function c(a, d) { var e = b.upcast.split(","), f, g; for (g = 0; g < e.length; g++)if (f = e[g], f === a.name) return b.upcasts[f].call(this, a, d); return !1 } function d(b, c, e) {
                    var f = CKEDITOR.tools.getIndex(a._.upcasts, function (a) { return a[2] > e }); 0 > f && (f = a._.upcasts.length); a._.upcasts.splice(f,
                        0, [CKEDITOR.tools.bind(b, c), c.name, e])
                } var e = b.upcast, f = b.upcastPriority || 10; e && ("string" == typeof e ? d(c, b, f) : d(e, b, f))
            } function m(a, b) { a.focused = null; if (b.isInited()) { var c = b.editor.checkDirty(); a.fire("widgetBlurred", { widget: b }); b.setFocused(!1); !c && b.editor.resetDirty() } } function h(a) {
                a = a.data; if ("wysiwyg" == this.editor.mode) {
                    var b = this.editor.editable(), c = this.instances, d, e, f, h; if (b) {
                        for (d in c) c[d].isReady() && !b.contains(c[d].wrapper) && this.destroy(c[d], !0); if (a && a.initOnlyNew) c = this.initOnAll();
                        else { var k = b.find(".cke_widget_wrapper"), c = []; d = 0; for (e = k.count(); d < e; d++) { f = k.getItem(d); if (h = !this.getByElement(f, !0)) { a: { h = r; for (var l = f; l = l.getParent();)if (h(l)) { h = !0; break a } h = !1 } h = !h } h && b.contains(f) && (f.addClass("cke_widget_new"), c.push(this.initOn(f.getFirst(g.isDomWidgetElement)))) } } a && a.focusInited && 1 == c.length && c[0].focus()
                    }
                }
            } function l(a) {
                if ("undefined" != typeof a.attributes && a.attributes["data-widget"]) {
                    var b = c(a), d = k(a), e = !1; b && b.value && b.value.match(/^\s/g) && (b.parent.attributes["data-cke-white-space-first"] =
                        1, b.value = b.value.replace(/^\s/g, "\x26nbsp;"), e = !0); d && d.value && d.value.match(/\s$/g) && (d.parent.attributes["data-cke-white-space-last"] = 1, d.value = d.value.replace(/\s$/g, "\x26nbsp;"), e = !0); e && (a.attributes["data-cke-widget-white-space"] = 1)
                }
            } function c(a) { return a.find(function (a) { return 3 === a.type }, !0).shift() } function k(a) { return a.find(function (a) { return 3 === a.type }, !0).pop() } function f(a, b, c) {
                if (!c.allowedContent && !c.disallowedContent) return null; var d = this._.filters[a]; d || (this._.filters[a] = d =
                    {}); a = d[b]; a || (a = c.allowedContent ? new CKEDITOR.filter(c.allowedContent) : this.editor.filter.clone(), d[b] = a, c.disallowedContent && a.disallow(c.disallowedContent)); return a
            } function n(a) {
                var b = [], c = a._.upcasts, d = a._.upcastCallbacks; return {
                    toBeWrapped: b, iterator: function (a) {
                        var e, f, h, k, l; if ("data-cke-widget-wrapper" in a.attributes) return (a = a.getFirst(g.isParserWidgetElement)) && b.push([a]), !1; if ("data-widget" in a.attributes) return b.push([a]), !1; if (l = c.length) {
                            if (a.attributes["data-cke-widget-upcasted"]) return !1;
                            k = 0; for (e = d.length; k < e; ++k)if (!1 === d[k](a)) return; for (k = 0; k < l; ++k)if (e = c[k], h = {}, f = e[0](a, h)) return f instanceof CKEDITOR.htmlParser.element && (a = f), a.attributes["data-cke-widget-data"] = encodeURIComponent(JSON.stringify(h)), a.attributes["data-cke-widget-upcasted"] = 1, b.push([a, e[1]]), !1
                        }
                    }
                }
            } function p(a, b) { return { tabindex: -1, contenteditable: "false", "data-cke-widget-wrapper": 1, "data-cke-filter": "off", "class": "cke_widget_wrapper cke_widget_new cke_widget_" + (a ? "inline" : "block") + (b ? " cke_widget_" + b : "") } }
            function t(a, b, c) { if (a.type == CKEDITOR.NODE_ELEMENT) { var d = CKEDITOR.dtd[a.name]; if (d && !d[c.name]) { var d = a.split(b), e = a.parent; b = d.getIndex(); a.children.length || (--b, a.remove()); d.children.length || d.remove(); return t(e, b, c) } } a.add(c, b) } function q(a, b) { return "boolean" == typeof a.inline ? a.inline : !!CKEDITOR.dtd.$inline[b] } function r(a) { return a.hasAttribute("data-cke-temp") } function w(a, b, c, d) {
                var e = a.editor; e.fire("lockSnapshot"); c ? (d = c.data("cke-widget-editable"), d = b.editables[d], a.widgetHoldingFocusedEditable =
                    b, b.focusedEditable = d, c.addClass("cke_widget_editable_focused"), d.filter && e.setActiveFilter(d.filter), e.setActiveEnterMode(d.enterMode, d.shiftEnterMode)) : (d || b.focusedEditable.removeClass("cke_widget_editable_focused"), b.focusedEditable = null, a.widgetHoldingFocusedEditable = null, e.setActiveFilter(null), e.setActiveEnterMode(null, null)); e.fire("unlockSnapshot")
            } function x(a) { a.contextMenu && a.contextMenu.addListener(function (b) { if (b = a.widgets.getByElement(b, !0)) return b.fire("contextMenu", {}) }) } function u(a,
                b) { return CKEDITOR.tools.trim(b) } function A(a) {
                    var b = a.editor, c = CKEDITOR.plugins.lineutils; b.on("dragstart", function (c) { var d = c.data.target; g.isDomDragHandler(d) && (d = a.getByElement(d), c.data.dataTransfer.setData("cke/widget-id", d.id), b.focus(), d.focus()) }); b.on("drop", function (c) {
                        var d = c.data.dataTransfer, e = d.getData("cke/widget-id"), f = d.getTransferType(b), d = b.createRange(); if ("" !== e && f === CKEDITOR.DATA_TRANSFER_CROSS_EDITORS) c.cancel(); else if (f == CKEDITOR.DATA_TRANSFER_INTERNAL) if (!e && 0 < b.widgets.selected.length) c.data.dataTransfer.setData("text/html",
                            R(b)); else if (e = a.instances[e]) d.setStartBefore(e.wrapper), d.setEndAfter(e.wrapper), c.data.dragRange = d, delete CKEDITOR.plugins.clipboard.dragStartContainerChildCount, delete CKEDITOR.plugins.clipboard.dragEndContainerChildCount, c.data.dataTransfer.setData("text/html", e.getClipboardHtml()), b.widgets.destroy(e, !0)
                    }); b.on("contentDom", function () {
                        var d = b.editable(); CKEDITOR.tools.extend(a, {
                            finder: new c.finder(b, {
                                lookups: {
                                    "default": function (b) {
                                        if (!b.is(CKEDITOR.dtd.$listItem) && b.is(CKEDITOR.dtd.$block) &&
                                            !g.isDomNestedEditable(b) && !a._.draggedWidget.wrapper.contains(b)) { var c = g.getNestedEditable(d, b); if (c) { b = a._.draggedWidget; if (a.getByElement(c) == b) return; c = CKEDITOR.filter.instances[c.data("cke-filter")]; b = b.requiredContent; if (c && b && !c.check(b)) return } return CKEDITOR.LINEUTILS_BEFORE | CKEDITOR.LINEUTILS_AFTER }
                                    }
                                }
                            }), locator: new c.locator(b), liner: new c.liner(b, { lineStyle: { cursor: "move !important", "border-top-color": "#666" }, tipLeftStyle: { "border-left-color": "#666" }, tipRightStyle: { "border-right-color": "#666" } })
                        },
                            !0)
                    })
                } function v(a) {
                    var b = a.editor; b.on("contentDom", function () {
                        var c = b.editable(), d = c.isInline() ? c : b.document, e, f; c.attachListener(d, "mousedown", function (c) { var d = c.data.getTarget(); e = d instanceof CKEDITOR.dom.element ? a.getByElement(d) : null; f = 0; e && (e.inline && d.type == CKEDITOR.NODE_ELEMENT && d.hasAttribute("data-cke-widget-drag-handler") ? (f = 1, a.focused != e && b.getSelection().removeAllRanges()) : g.getNestedEditable(e.wrapper, d) ? e = null : (c.data.preventDefault(), CKEDITOR.env.ie || e.focus())) }); c.attachListener(d,
                            "mouseup", function () { f && e && e.wrapper && (f = 0, e.focus()) }); CKEDITOR.env.ie && c.attachListener(d, "mouseup", function () { setTimeout(function () { e && e.wrapper && c.contains(e.wrapper) && (e.focus(), e = null) }) })
                    }); b.on("doubleclick", function (b) { var c = a.getByElement(b.data.element); if (c && !g.getNestedEditable(c.wrapper, b.data.element)) return c.fire("doubleclick", { element: b.data.element }) }, null, null, 1)
                } function z(a) {
                    a.editor.on("key", function (b) {
                        var c = a.focused, d = a.widgetHoldingFocusedEditable, e; c ? e = c.fire("key", { keyCode: b.data.keyCode }) :
                            d && (c = b.data.keyCode, b = d.focusedEditable, c == CKEDITOR.CTRL + 65 ? (c = b.getBogus(), d = d.editor.createRange(), d.selectNodeContents(b), c && d.setEndAt(c, CKEDITOR.POSITION_BEFORE_START), d.select(), e = !1) : 8 == c || 46 == c ? (e = d.editor.getSelection().getRanges(), d = e[0], e = !(1 == e.length && d.collapsed && d.checkBoundaryOfElement(b, CKEDITOR[8 == c ? "START" : "END"]))) : e = void 0); return e
                    }, null, null, 1)
                } function y(a) {
                    function b(d) { 1 > a.selected.length || M(c, "cut" === d.name) } var c = a.editor; c.on("contentDom", function () {
                        var a = c.editable();
                        a.attachListener(a, "copy", b); a.attachListener(a, "cut", b)
                    })
                } function B(a) {
                    function b() { var a = e.getSelection(); if ((a = (a && a.getRanges())[0]) && !a.collapsed) { var d = c(a.startContainer), f = c(a.endContainer); !d && f ? (a.setEndBefore(f.wrapper), a.select()) : d && !f && (a.setStartAfter(d.wrapper), a.select()) } } function c(a) { return a ? a.type == CKEDITOR.NODE_TEXT ? c(a.getParent()) : e.widgets.getByElement(a) : null } function d() { a.fire("checkSelection") } var e = a.editor; e.on("selectionCheck", d); e.on("contentDom", function () {
                        e.editable().attachListener(e,
                            "key", function () { setTimeout(d, 10) })
                    }); if (!CKEDITOR.env.ie) a.on("checkSelection", b); a.on("checkSelection", a.checkSelection, a); e.on("selectionChange", function (b) { var c = (b = g.getNestedEditable(e.editable(), b.data.selection.getStartElement())) && a.getByElement(b), d = a.widgetHoldingFocusedEditable; d ? d === c && d.focusedEditable.equals(b) || (w(a, d, null), c && b && w(a, c, b)) : c && b && w(a, c, b) }); e.on("dataReady", function () { G(a).commit() }); e.on("blur", function () {
                        var b; (b = a.focused) && m(a, b); (b = a.widgetHoldingFocusedEditable) &&
                            w(a, b, null)
                    })
                } function C(a) {
                    var b = a.editor, d = {}; b.on("toDataFormat", function (b) {
                        var e = CKEDITOR.tools.getNextNumber(), f = []; b.data.downcastingSessionId = e; d[e] = f; b.data.dataValue.forEach(function (b) {
                            var d = b.attributes, e; if ("data-cke-widget-white-space" in d) { e = c(b); var h = k(b); e.parent.attributes["data-cke-white-space-first"] && (e.value = e.value.replace(/^&nbsp;/g, " ")); h.parent.attributes["data-cke-white-space-last"] && (h.value = h.value.replace(/&nbsp;$/g, " ")) } if ("data-cke-widget-id" in d) {
                                if (d = a.instances[d["data-cke-widget-id"]]) e =
                                    b.getFirst(g.isParserWidgetElement), f.push({ wrapper: b, element: e, widget: d, editables: {} }), "1" != e.attributes["data-cke-widget-keep-attr"] && delete e.attributes["data-widget"]
                            } else if ("data-cke-widget-editable" in d) return 0 < f.length && (f[f.length - 1].editables[d["data-cke-widget-editable"]] = b), !1
                        }, CKEDITOR.NODE_ELEMENT, !0)
                    }, null, null, 8); b.on("toDataFormat", function (a) {
                        if (a.data.downcastingSessionId) for (var b = d[a.data.downcastingSessionId], c, e, f, g, h, k; c = b.shift();) {
                            e = c.widget; f = c.element; g = e._.downcastFn &&
                                e._.downcastFn.call(e, f); a.data.widgetsCopy && e.getClipboardHtml && (g = CKEDITOR.htmlParser.fragment.fromHtml(e.getClipboardHtml()), g = g.children[0]); for (k in c.editables) h = c.editables[k], delete h.attributes.contenteditable, h.setHtml(e.editables[k].getData()); g || (g = f); c.wrapper.replaceWith(g)
                        }
                    }, null, null, 13); b.on("contentDomUnload", function () { a.destroyAll(!0) })
                } function F(a) {
                    var b = a.editor, c, d; b.on("toHtml", function (b) {
                        var d = n(a), e; for (b.data.dataValue.forEach(d.iterator, CKEDITOR.NODE_ELEMENT, !0); e = d.toBeWrapped.pop();) {
                            var f =
                                e[0], h = f.parent; h.type == CKEDITOR.NODE_ELEMENT && h.attributes["data-cke-widget-wrapper"] && h.replaceWith(f); a.wrapElement(e[0], e[1])
                        } c = b.data.protectedWhitespaces ? 3 == b.data.dataValue.children.length && g.isParserWidgetWrapper(b.data.dataValue.children[1]) : 1 == b.data.dataValue.children.length && g.isParserWidgetWrapper(b.data.dataValue.children[0])
                    }, null, null, 8); b.on("dataReady", function () {
                        if (d) for (var c = b.editable().find(".cke_widget_wrapper"), e, f, h = 0, k = c.count(); h < k; ++h)e = c.getItem(h), f = e.getFirst(g.isDomWidgetElement),
                            f.type == CKEDITOR.NODE_ELEMENT && f.data("widget") ? (f.replace(e), a.wrapElement(f)) : e.remove(); d = 0; a.destroyAll(!0); a.initOnAll()
                    }); b.on("loadSnapshot", function (b) { /data-cke-widget/.test(b.data) && (d = 1); a.destroyAll(!0) }, null, null, 9); b.on("paste", function (a) { a = a.data; a.dataValue = a.dataValue.replace(Q, u); a.range && (a = g.getNestedEditable(b.editable(), a.range.startContainer)) && (a = CKEDITOR.filter.instances[a.data("cke-filter")]) && b.setActiveFilter(a) }); b.on("afterInsertHtml", function (d) {
                        d.data.intoRange ? a.checkWidgets({ initOnlyNew: !0 }) :
                        (b.fire("lockSnapshot"), a.checkWidgets({ initOnlyNew: !0, focusInited: c }), b.fire("unlockSnapshot"))
                    })
                } function G(a) {
                    var b = a.selected, c = [], d = b.slice(0), e = null; return {
                        select: function (a) { 0 > CKEDITOR.tools.indexOf(b, a) && c.push(a); a = CKEDITOR.tools.indexOf(d, a); 0 <= a && d.splice(a, 1); return this }, focus: function (a) { e = a; return this }, commit: function () {
                            var f = a.focused !== e, g, h; a.editor.fire("lockSnapshot"); for (f && (g = a.focused) && m(a, g); g = d.pop();)b.splice(CKEDITOR.tools.indexOf(b, g), 1), g.isInited() && (h = g.editor.checkDirty(),
                                g.setSelected(!1), !h && g.editor.resetDirty()); f && e && (h = a.editor.checkDirty(), a.focused = e, a.fire("widgetFocused", { widget: e }), e.setFocused(!0), !h && a.editor.resetDirty()); for (; g = c.pop();)b.push(g), g.setSelected(!0); a.editor.fire("unlockSnapshot")
                        }
                    }
                } function I(a) { a && a.addFilterRule(function (a) { return a.replace(/\s*cke_widget_selected/g, "").replace(/\s*cke_widget_focused/g, "").replace(/<span[^>]*cke_widget_drag_handler_container[^>]*.*?<\/span>/gmi, "") }) } function H(a, b, c) {
                    var d = 0; b = J(b); var e = a.data.classes ||
                        {}, f; if (b) { for (e = CKEDITOR.tools.clone(e); f = b.pop();)c ? e[f] || (d = e[f] = 1) : e[f] && (delete e[f], d = 1); d && a.setData("classes", e) }
                } function D(a) { a.cancel() } function M(a, b) {
                    var c = a.widgets.focused, d, e, f; S.hasCopyBin(a) || (e = new S(a, { beforeDestroy: function () { !b && c && c.focus(); f && a.getSelection().selectBookmarks(f); d && CKEDITOR.plugins.widgetselection.addFillers(a.editable()) }, afterDestroy: function () { b && !a.readOnly && (c ? a.widgets.del(c) : a.extractSelectedHtml(), a.fire("saveSnapshot")) } }), c || (d = CKEDITOR.env.webkit &&
                        CKEDITOR.plugins.widgetselection.isWholeContentSelected(a.editable()), f = a.getSelection().createBookmarks(!0)), e.handle(R(a)))
                } function J(a) { return (a = (a = a.getDefinition().attributes) && a["class"]) ? a.split(/\s+/) : null } function K() { var a = CKEDITOR.document.getActive(), b = this.editor, c = b.editable(); (c.isInline() ? c : b.document.getWindow().getFrame()).equals(a) && b.focusManager.focus(c) } function E() {
                    CKEDITOR.env.gecko && this.editor.unlockSelection(); CKEDITOR.env.webkit || (this.editor.forceNextSelectionCheck(),
                        this.editor.selectionChange(1))
                } function R(a) { var b = a.getSelectedHtml(!0); if (a.widgets.focused) return a.widgets.focused.getClipboardHtml(); a.once("toDataFormat", function (a) { a.data.widgetsCopy = !0 }, null, null, -1); return a.dataProcessor.toDataFormat(b) } function P(a, b) {
                    N(a); X(a); U(a); Y(a); V(a); ba(a); W(a); if (CKEDITOR.env.ie && 9 > CKEDITOR.env.version) a.wrapper.on("dragstart", function (b) { var c = b.data.getTarget(); g.getNestedEditable(a, c) || a.inline && g.isDomDragHandler(c) || b.data.preventDefault() }); a.wrapper.removeClass("cke_widget_new");
                    a.element.addClass("cke_widget_element"); a.on("key", function (b) { b = b.data.keyCode; if (13 == b) a.edit(); else { if (b == CKEDITOR.CTRL + 67 || b == CKEDITOR.CTRL + 88) { M(a.editor, b == CKEDITOR.CTRL + 88); return } if (b in T || CKEDITOR.CTRL & b || CKEDITOR.ALT & b) return } return !1 }, null, null, 999); a.on("doubleclick", function (b) { a.edit() && b.cancel() }); if (b.data) a.on("data", b.data); if (b.edit) a.on("edit", b.edit)
                } function N(a) { (a.wrapper = a.element.getParent()).setAttribute("data-cke-widget-id", a.id) } function X(a, b) {
                    a.partSelectors || (a.partSelectors =
                        a.parts); if (a.parts) { var c = {}, d, e; for (e in a.partSelectors) b || !a.parts[e] || "string" == typeof a.parts[e] ? (d = a.wrapper.findOne(a.partSelectors[e]), c[e] = d) : c[e] = a.parts[e]; a.parts = c }
                } function U(a) { var b = a.editables, c, d; a.editables = {}; if (a.editables) for (c in b) d = b[c], a.initEditable(c, "string" == typeof d ? { selector: d } : d) } function Y(a) {
                    if (!0 === a.mask) ha(a); else if (a.mask) {
                        var b = new CKEDITOR.tools.buffers.throttle(250, O, a), c = CKEDITOR.env.gecko ? 300 : 0, d, e; a.on("focus", function () {
                            b.input(); d = a.editor.on("change",
                                b.input); e = a.on("blur", function () { d.removeListener(); e.removeListener() })
                        }); a.editor.on("instanceReady", function () { setTimeout(function () { b.input() }, c) }); a.editor.on("mode", function () { setTimeout(function () { b.input() }, c) }); if (CKEDITOR.env.gecko) { var f = a.element.find("img"); CKEDITOR.tools.array.forEach(f.toArray(), function (a) { a.on("load", function () { b.input() }) }) } for (var g in a.editables) a.editables[g].on("focus", function () { a.editor.on("change", b.input); e && e.removeListener() }), a.editables[g].on("blur",
                            function () { a.editor.removeListener("change", b.input) }); b.input()
                    }
                } function ha(a) { var b = a.wrapper.findOne(".cke_widget_mask"); b || (b = new CKEDITOR.dom.element("img", a.editor.document), b.setAttributes({ src: CKEDITOR.tools.transparentImageData, "class": "cke_reset cke_widget_mask" }), a.wrapper.append(b)); a.mask = b } function O() {
                    if (this.wrapper) {
                        this.maskPart = this.maskPart || this.mask; var a = this.parts[this.maskPart], b; if (a && "string" != typeof a) {
                            b = this.wrapper.findOne(".cke_widget_partial_mask"); b || (b = new CKEDITOR.dom.element("img",
                                this.editor.document), b.setAttributes({ src: CKEDITOR.tools.transparentImageData, "class": "cke_reset cke_widget_partial_mask" }), this.wrapper.append(b)); this.mask = b; var c = b.$, d = a.$, e = !(c.offsetTop == d.offsetTop && c.offsetLeft == d.offsetLeft); if (c.offsetWidth != d.offsetWidth || c.offsetHeight != d.offsetHeight || e) c = a.getParent(), d = CKEDITOR.plugins.widget.isDomWidget(c), b.setStyles({
                                    top: a.$.offsetTop + (d ? 0 : c.$.offsetTop) + "px", left: a.$.offsetLeft + (d ? 0 : c.$.offsetLeft) + "px", width: a.$.offsetWidth + "px", height: a.$.offsetHeight +
                                        "px"
                                })
                        }
                    }
                } function V(a) {
                    if (a.draggable) {
                        var b = a.editor, c = a.wrapper.getLast(g.isDomDragHandlerContainer), d; c ? d = c.findOne("img") : (c = new CKEDITOR.dom.element("span", b.document), c.setAttributes({ "class": "cke_reset cke_widget_drag_handler_container", style: "background:rgba(220,220,220,0.5);background-image:url(" + b.plugins.widget.path + "images/handle.png);display:none;" }), d = new CKEDITOR.dom.element("img", b.document), d.setAttributes({
                            "class": "cke_reset cke_widget_drag_handler", "data-cke-widget-drag-handler": "1",
                            src: CKEDITOR.tools.transparentImageData, width: 15, title: b.lang.widget.move, height: 15, role: "presentation"
                        }), a.inline && d.setAttribute("draggable", "true"), c.append(d), a.wrapper.append(c)); a.wrapper.on("dragover", function (a) { a.data.preventDefault() }); a.wrapper.on("mouseenter", a.updateDragHandlerPosition, a); setTimeout(function () { a.on("data", a.updateDragHandlerPosition, a) }, 50); if (!a.inline && (d.on("mousedown", aa, a), CKEDITOR.env.ie && 9 > CKEDITOR.env.version)) d.on("dragstart", function (a) { a.data.preventDefault(!0) });
                        a.dragHandlerContainer = c
                    }
                } function aa(a) {
                    function b() { var c; for (p.reset(); c = h.pop();)c.removeListener(); var d = k; c = a.sender; var e = this.repository.finder, f = this.repository.liner, g = this.editor, l = this.editor.editable(); CKEDITOR.tools.isEmpty(f.visible) || (d = e.getRange(d[0]), this.focus(), g.fire("drop", { dropRange: d, target: d.startContainer })); l.removeClass("cke_widget_dragging"); f.hideVisible(); g.fire("dragend", { target: c }) } if (CKEDITOR.tools.getMouseButton(a) === CKEDITOR.MOUSE_BUTTON_LEFT) {
                        var c = this.repository.finder,
                        d = this.repository.locator, e = this.repository.liner, f = this.editor, g = f.editable(), h = [], k = [], l, m; this.repository._.draggedWidget = this; var n = c.greedySearch(), p = CKEDITOR.tools.eventsBuffer(50, function () { l = d.locate(n); k = d.sort(m, 1); k.length && (e.prepare(n, l), e.placeLine(k[0]), e.cleanup()) }); g.addClass("cke_widget_dragging"); h.push(g.on("mousemove", function (a) { m = a.data.$.clientY; p.input() })); f.fire("dragstart", { target: a.sender }); h.push(f.document.once("mouseup", b, this)); g.isInline() || h.push(CKEDITOR.document.once("mouseup",
                            b, this))
                    }
                } function ba(a) { var b = null; a.on("data", function () { var a = this.data.classes, c; if (b != a) { for (c in b) a && a[c] || this.removeClass(c); for (c in a) this.addClass(c); b = a } }) } function W(a) { a.on("data", function () { if (a.wrapper) { var b = this.getLabel ? this.getLabel() : this.editor.lang.widget.label.replace(/%1/, this.pathName || this.element.getName()); a.wrapper.setAttribute("role", "region"); a.wrapper.setAttribute("aria-label", b) } }, null, null, 9999) } function da(a) { a.element.data("cke-widget-data", encodeURIComponent(JSON.stringify(a.data))) }
            function Z() {
                function a() { } function b(a, c, d) { return d && this.checkElement(a) ? (a = d.widgets.getByElement(a, !0)) && a.checkStyleActive(this) : !1 } function c(a) {
                    function b(a, c, d) { for (var e = a.length, f = 0; f < e;) { if (c.call(d, a[f], f, a)) return a[f]; f++ } } function e(a) {
                        function b(a, c) { var d = CKEDITOR.tools.object.keys(a), e = CKEDITOR.tools.object.keys(c); if (d.length !== e.length) return !1; for (var f in a) if (("object" !== typeof a[f] || "object" !== typeof c[f] || !b(a[f], c[f])) && a[f] !== c[f]) return !1; return !0 } return function (c) {
                            return b(a.getDefinition(),
                                c.getDefinition())
                        }
                    } var f = a.widget, g; d[f] || (d[f] = {}); for (var h = 0, k = a.group.length; h < k; h++)g = a.group[h], d[f][g] || (d[f][g] = []), g = d[f][g], b(g, e(a)) || g.push(a)
                } var d = {}; CKEDITOR.style.addCustomHandler({
                    type: "widget", setup: function (a) { this.widget = a.widget; (this.group = "string" == typeof a.group ? [a.group] : a.group) && c(this) }, apply: function (a) { var b; a instanceof CKEDITOR.editor && this.checkApplicable(a.elementPath(), a) && (b = a.widgets.focused, this.group && this.removeStylesFromSameGroup(a), b.applyStyle(this)) }, remove: function (a) {
                        a instanceof
                        CKEDITOR.editor && this.checkApplicable(a.elementPath(), a) && a.widgets.focused.removeStyle(this)
                    }, removeStylesFromSameGroup: function (a) { var b = !1, c, e; if (!(a instanceof CKEDITOR.editor)) return !1; e = a.elementPath(); if (this.checkApplicable(e, a)) for (var f = 0, g = this.group.length; f < g; f++) { c = d[this.widget][this.group[f]]; for (var h = 0; h < c.length; h++)c[h] !== this && c[h].checkActive(e, a) && (a.widgets.focused.removeStyle(c[h]), b = !0) } return b }, checkActive: function (a, b) { return this.checkElementMatch(a.lastElement, 0, b) },
                    checkApplicable: function (a, b) { return b instanceof CKEDITOR.editor ? this.checkElement(a.lastElement) : !1 }, checkElementMatch: b, checkElementRemovable: b, checkElement: function (a) { return g.isDomWidgetWrapper(a) ? (a = a.getFirst(g.isDomWidgetElement)) && a.data("widget") == this.widget : !1 }, buildPreview: function (a) { return a || this._.definition.name }, toAllowedContentRules: function (a) {
                        if (!a) return null; a = a.widgets.registered[this.widget]; var b, c = {}; if (!a) return null; if (a.styleableElements) {
                            b = this.getClassesArray(); if (!b) return null;
                            c[a.styleableElements] = { classes: b, propertiesOnly: !0 }; return c
                        } return a.styleToAllowedContentRules ? a.styleToAllowedContentRules(this) : null
                    }, getClassesArray: function () { var a = this._.definition.attributes && this._.definition.attributes["class"]; return a ? CKEDITOR.tools.trim(a).split(/\s+/) : null }, applyToRange: a, removeFromRange: a, applyToObject: a
                })
            } CKEDITOR.plugins.add("widget", {
                requires: "lineutils,clipboard,widgetselection", onLoad: function () {
                    void 0 !== CKEDITOR.document.$.querySelectorAll && (CKEDITOR.addCss('.cke_widget_wrapper{position:relative;outline:none}.cke_widget_inline{display:inline-block}.cke_widget_wrapper:hover\x3e.cke_widget_element{outline:2px solid #ffd25c;cursor:default}.cke_widget_wrapper:hover .cke_widget_editable{outline:2px solid #ffd25c}.cke_widget_wrapper.cke_widget_focused\x3e.cke_widget_element,.cke_widget_wrapper .cke_widget_editable.cke_widget_editable_focused{outline:2px solid #47a4f5}.cke_widget_editable{cursor:text}.cke_widget_drag_handler_container{position:absolute;width:15px;height:0;display:block;opacity:0.75;transition:height 0s 0.2s;line-height:0}.cke_widget_wrapper:hover\x3e.cke_widget_drag_handler_container{height:15px;transition:none}.cke_widget_drag_handler_container:hover{opacity:1}.cke_editable[contenteditable\x3d"false"] .cke_widget_drag_handler_container{display:none;}img.cke_widget_drag_handler{cursor:move;width:15px;height:15px;display:inline-block}.cke_widget_mask{position:absolute;top:0;left:0;width:100%;height:100%;display:block}.cke_widget_partial_mask{position:absolute;display:block}.cke_editable.cke_widget_dragging, .cke_editable.cke_widget_dragging *{cursor:move !important}'),
                        Z())
                }, beforeInit: function (b) { void 0 !== CKEDITOR.document.$.querySelectorAll && (b.widgets = new a(b)) }, afterInit: function (a) { if (void 0 !== CKEDITOR.document.$.querySelectorAll) { var b = a.widgets.registered, c, d, e; for (d in b) c = b[d], (e = c.button) && a.ui.addButton && a.ui.addButton(CKEDITOR.tools.capitalize(c.name, !0), { label: e, command: c.name, toolbar: "insert,10" }); x(a); I(a.undoManager) } }
            }); a.prototype = {
                MIN_SELECTION_CHECK_INTERVAL: 500, add: function (a, c) {
                    var e = this.editor; c = CKEDITOR.tools.prototypedCopy(c); c.name = a;
                    c._ = c._ || {}; e.fire("widgetDefinition", c); c.template && (c.template = new CKEDITOR.template(c.template)); b(e, c); d(this, c); this.registered[a] = c; if (c.dialog && e.plugins.dialog) var f = CKEDITOR.on("dialogDefinition", function (a) { a = a.data.definition; var b = a.dialog; a.getMode || b.getName() !== c.dialog || (a.getMode = function () { var a = b.getModel(e); return a && a instanceof CKEDITOR.plugins.widget && a.ready ? CKEDITOR.dialog.EDITING_MODE : CKEDITOR.dialog.CREATION_MODE }); f.removeListener() }); return c
                }, addUpcastCallback: function (a) { this._.upcastCallbacks.push(a) },
                checkSelection: function () { var a = this.editor.getSelection(), b = a.getSelectedElement(), c = G(this), d; if (b && (d = this.getByElement(b, !0))) return c.focus(d).select(d).commit(); a = a.getRanges()[0]; if (!a || a.collapsed) return c.commit(); a = new CKEDITOR.dom.walker(a); for (a.evaluator = g.isDomWidgetWrapper; b = a.next();)c.select(this.getByElement(b)); c.commit() }, checkWidgets: function (a) { this.fire("checkWidgets", CKEDITOR.tools.copy(a || {})) }, del: function (a) {
                    if (this.focused === a) {
                        var b = a.editor, c = b.createRange(), d; (d = c.moveToClosestEditablePosition(a.wrapper,
                            !0)) || (d = c.moveToClosestEditablePosition(a.wrapper, !1)); d && b.getSelection().selectRanges([c])
                    } a.wrapper.remove(); this.destroy(a, !0)
                }, destroy: function (a, b) { this.widgetHoldingFocusedEditable === a && w(this, a, null, b); a.destroy(b); delete this.instances[a.id]; this.fire("instanceDestroyed", a) }, destroyAll: function (a, b) {
                    var c, d, e = this.instances; if (b && !a) { d = b.find(".cke_widget_wrapper"); for (var e = d.count(), f = 0; f < e; ++f)(c = this.getByElement(d.getItem(f), !0)) && this.destroy(c) } else for (d in e) c = e[d], this.destroy(c,
                        a)
                }, finalizeCreation: function (a) { (a = a.getFirst()) && g.isDomWidgetWrapper(a) && (this.editor.insertElement(a), a = this.getByElement(a), a.ready = !0, a.fire("ready"), a.focus()) }, getByElement: function () { function a(c) { return c.is(b) && c.data("cke-widget-id") } var b = { div: 1, span: 1 }; return function (b, c) { if (!b) return null; var d = a(b); if (!c && !d) { var e = this.editor.editable(); do b = b.getParent(); while (b && !b.equals(e) && !(d = a(b))) } return this.instances[d] || null } }(), initOn: function (a, b, c) {
                    b ? "string" == typeof b && (b = this.registered[b]) :
                        b = this.registered[a.data("widget")]; if (!b) return null; var d = this.wrapElement(a, b.name); return d ? d.hasClass("cke_widget_new") ? (a = new g(this, this._.nextId++, a, b, c), a.isInited() ? this.instances[a.id] = a : null) : this.getByElement(a) : null
                }, initOnAll: function (a) { a = (a || this.editor.editable()).find(".cke_widget_new"); for (var b = [], c, d = a.count(); d--;)(c = this.initOn(a.getItem(d).getFirst(g.isDomWidgetElement))) && b.push(c); return b }, onWidget: function (a) {
                    var b = Array.prototype.slice.call(arguments); b.shift(); for (var c in this.instances) {
                        var d =
                            this.instances[c]; d.name == a && d.on.apply(d, b)
                    } this.on("instanceCreated", function (c) { c = c.data; c.name == a && c.on.apply(c, b) })
                }, parseElementClasses: function (a) { if (!a) return null; a = CKEDITOR.tools.trim(a).split(/\s+/); for (var b, c = {}, d = 0; b = a.pop();)-1 == b.indexOf("cke_") && (c[b] = d = 1); return d ? c : null }, wrapElement: function (a, b) {
                    var c = null, d, e; if (a instanceof CKEDITOR.dom.element) {
                        b = b || a.data("widget"); d = this.registered[b]; if (!d) return null; if ((c = a.getParent()) && c.type == CKEDITOR.NODE_ELEMENT && c.data("cke-widget-wrapper")) return c;
                        a.hasAttribute("data-cke-widget-keep-attr") || a.data("cke-widget-keep-attr", a.data("widget") ? 1 : 0); a.data("widget", b); (e = q(d, a.getName())) && l(a); c = new CKEDITOR.dom.element(e ? "span" : "div", a.getDocument()); c.setAttributes(p(e, b)); c.data("cke-display-name", d.pathName ? d.pathName : a.getName()); a.getParent(!0) && c.replace(a); a.appendTo(c)
                    } else if (a instanceof CKEDITOR.htmlParser.element) {
                        b = b || a.attributes["data-widget"]; d = this.registered[b]; if (!d) return null; if ((c = a.parent) && c.type == CKEDITOR.NODE_ELEMENT &&
                            c.attributes["data-cke-widget-wrapper"]) return c; "data-cke-widget-keep-attr" in a.attributes || (a.attributes["data-cke-widget-keep-attr"] = a.attributes["data-widget"] ? 1 : 0); b && (a.attributes["data-widget"] = b); (e = q(d, a.name)) && l(a); c = new CKEDITOR.htmlParser.element(e ? "span" : "div", p(e, b)); c.attributes["data-cke-display-name"] = d.pathName ? d.pathName : a.name; d = a.parent; var f; d && (f = a.getIndex(), a.remove()); c.add(a); d && t(d, f, c)
                    } return c
                }, _tests_createEditableFilter: f
            }; CKEDITOR.event.implementOn(a.prototype); g.prototype =
            {
                addClass: function (a) { this.element.addClass(a); this.wrapper.addClass(g.WRAPPER_CLASS_PREFIX + a) }, applyStyle: function (a) { H(this, a, 1) }, checkStyleActive: function (a) { a = J(a); var b; if (!a) return !1; for (; b = a.pop();)if (!this.hasClass(b)) return !1; return !0 }, destroy: function (a) {
                    this.fire("destroy"); if (this.editables) for (var b in this.editables) this.destroyEditable(b, a); a || ("0" == this.element.data("cke-widget-keep-attr") && this.element.removeAttribute("data-widget"), this.element.removeAttributes(["data-cke-widget-data",
                        "data-cke-widget-keep-attr"]), this.element.removeClass("cke_widget_element"), this.element.replace(this.wrapper)); this.wrapper = null
                }, destroyEditable: function (a, b) {
                    var c = this.editables[a], d = !0; c.removeListener("focus", E); c.removeListener("blur", K); this.editor.focusManager.remove(c); if (c.filter) {
                        for (var e in this.repository.instances) { var f = this.repository.instances[e]; f.editables && (f = f.editables[a]) && f !== c && c.filter === f.filter && (d = !1) } d && (c.filter.destroy(), (d = this.repository._.filters[this.name]) &&
                            delete d[a])
                    } b || (this.repository.destroyAll(!1, c), c.removeClass("cke_widget_editable"), c.removeClass("cke_widget_editable_focused"), c.removeAttributes(["contenteditable", "data-cke-widget-editable", "data-cke-enter-mode"])); delete this.editables[a]
                }, edit: function () {
                    var a = { dialog: this.dialog }, b = this; if (!1 === this.fire("edit", a) || !a.dialog) return !1; this.editor.openDialog(a.dialog, function (a) {
                        var c, d; !1 !== b.fire("dialog", a) && (c = a.on("show", function () { a.setupContent(b) }), d = a.on("ok", function () {
                            var c, d = b.on("data",
                                function (a) { c = 1; a.cancel() }, null, null, 0); b.editor.fire("saveSnapshot"); a.commitContent(b); d.removeListener(); c && (b.fire("data", b.data), b.editor.fire("saveSnapshot"))
                        }), a.once("hide", function () { c.removeListener(); d.removeListener() }))
                    }, b); return !0
                }, getClasses: function () { return this.repository.parseElementClasses(this.element.getAttribute("class")) }, getClipboardHtml: function () { var a = this.editor.createRange(); a.setStartBefore(this.wrapper); a.setEndAfter(this.wrapper); return this.editor.editable().getHtmlFromRange(a).getHtml() },
                hasClass: function (a) { return this.element.hasClass(a) }, initEditable: function (a, b) {
                    var c = this._findOneNotNested(b.selector); return c && c.is(CKEDITOR.dtd.$editable) ? (c = new e(this.editor, c, { filter: f.call(this.repository, this.name, a, b) }), this.editables[a] = c, c.setAttributes({ contenteditable: "true", "data-cke-widget-editable": a, "data-cke-enter-mode": c.enterMode }), c.filter && c.data("cke-filter", c.filter.id), c.addClass("cke_widget_editable"), c.removeClass("cke_widget_editable_focused"), b.pathName && c.data("cke-display-name",
                        b.pathName), this.editor.focusManager.add(c), c.on("focus", E, this), CKEDITOR.env.ie && c.on("blur", K, this), c._.initialSetData = !0, c.setData(c.getHtml()), !0) : !1
                }, _findOneNotNested: function (a) { a = this.wrapper.find(a); for (var b, c, d = 0; d < a.count(); d++)if (b = a.getItem(d), c = b.getAscendant(g.isDomWidgetWrapper), this.wrapper.equals(c)) return b; return null }, isInited: function () { return !(!this.wrapper || !this.inited) }, isReady: function () { return this.isInited() && this.ready }, focus: function () {
                    var a = this.editor.getSelection();
                    if (a) { var b = this.editor.checkDirty(); a.fake(this.wrapper); !b && this.editor.resetDirty() } this.editor.focus()
                }, refreshMask: function () { Y(this) }, refreshParts: function (a) { X(this, "undefined" !== typeof a ? a : !0) }, removeClass: function (a) { this.element.removeClass(a); this.wrapper.removeClass(g.WRAPPER_CLASS_PREFIX + a) }, removeStyle: function (a) { H(this, a, 0) }, setData: function (a, b) {
                    var c = this.data, d = 0; if ("string" == typeof a) c[a] !== b && (c[a] = b, d = 1); else { var e = a; for (a in e) c[a] !== e[a] && (d = 1, c[a] = e[a]) } d && this.dataReady &&
                        (da(this), this.fire("data", c)); return this
                }, setFocused: function (a) { this.wrapper[a ? "addClass" : "removeClass"]("cke_widget_focused"); this.fire(a ? "focus" : "blur"); return this }, setSelected: function (a) { this.wrapper[a ? "addClass" : "removeClass"]("cke_widget_selected"); this.fire(a ? "select" : "deselect"); return this }, updateDragHandlerPosition: function () {
                    var a = this.editor, b = this.element.$, c = this._.dragHandlerOffset, b = { x: b.offsetLeft, y: b.offsetTop - 15 }; c && b.x == c.x && b.y == c.y || (c = a.checkDirty(), a.fire("lockSnapshot"),
                        this.dragHandlerContainer.setStyles({ top: b.y + "px", left: b.x + "px" }), this.dragHandlerContainer.removeStyle("display"), a.fire("unlockSnapshot"), !c && a.resetDirty(), this._.dragHandlerOffset = b)
                }
            }; CKEDITOR.event.implementOn(g.prototype); g.getNestedEditable = function (a, b) { return !b || b.equals(a) ? null : g.isDomNestedEditable(b) ? b : g.getNestedEditable(a, b.getParent()) }; g.isDomDragHandler = function (a) { return a.type == CKEDITOR.NODE_ELEMENT && a.hasAttribute("data-cke-widget-drag-handler") }; g.isDomDragHandlerContainer = function (a) {
                return a.type ==
                    CKEDITOR.NODE_ELEMENT && a.hasClass("cke_widget_drag_handler_container")
            }; g.isDomNestedEditable = function (a) { return a.type == CKEDITOR.NODE_ELEMENT && a.hasAttribute("data-cke-widget-editable") }; g.isDomWidgetElement = function (a) { return a.type == CKEDITOR.NODE_ELEMENT && a.hasAttribute("data-widget") }; g.isDomWidgetWrapper = function (a) { return a.type == CKEDITOR.NODE_ELEMENT && a.hasAttribute("data-cke-widget-wrapper") }; g.isDomWidget = function (a) { return a ? this.isDomWidgetWrapper(a) || this.isDomWidgetElement(a) : !1 }; g.isParserWidgetElement =
                function (a) { return a.type == CKEDITOR.NODE_ELEMENT && !!a.attributes["data-widget"] }; g.isParserWidgetWrapper = function (a) { return a.type == CKEDITOR.NODE_ELEMENT && !!a.attributes["data-cke-widget-wrapper"] }; g.WRAPPER_CLASS_PREFIX = "cke_widget_wrapper_"; e.prototype = CKEDITOR.tools.extend(CKEDITOR.tools.prototypedCopy(CKEDITOR.dom.element.prototype), {
                    setData: function (a) {
                        this._.initialSetData || this.editor.widgets.destroyAll(!1, this); this._.initialSetData = !1; a = this.editor.dataProcessor.toHtml(a, {
                            context: this.getName(),
                            filter: this.filter, enterMode: this.enterMode
                        }); this.setHtml(a); this.editor.widgets.initOnAll(this)
                    }, getData: function () { return this.editor.dataProcessor.toDataFormat(this.getHtml(), { context: this.getName(), filter: this.filter, enterMode: this.enterMode }) }
                }); var Q = /^(?:<(?:div|span)(?: data-cke-temp="1")?(?: id="cke_copybin")?(?: data-cke-temp="1")?>)?(?:<(?:div|span)(?: style="[^"]+")?>)?<span [^>]*data-cke-copybin-start="1"[^>]*>.?<\/span>([\s\S]+)<span [^>]*data-cke-copybin-end="1"[^>]*>.?<\/span>(?:<\/(?:div|span)>)?(?:<\/(?:div|span)>)?$/i,
                    T = { 37: 1, 38: 1, 39: 1, 40: 1, 8: 1, 46: 1 }; T[CKEDITOR.SHIFT + 121] = 1; var S = CKEDITOR.tools.createClass({
                        $: function (a, b) { this._.createCopyBin(a, b); this._.createListeners(b) }, _: {
                            createCopyBin: function (a) {
                                var b = a.document, c = CKEDITOR.env.edge && 16 <= CKEDITOR.env.version, d = !a.blockless && !CKEDITOR.env.ie || c ? "div" : "span", c = b.createElement(d), b = b.createElement(d); b.setAttributes({ id: "cke_copybin", "data-cke-temp": "1" }); c.setStyles({ position: "absolute", width: "1px", height: "1px", overflow: "hidden" }); c.setStyle("ltr" == a.config.contentsLangDirection ?
                                    "left" : "right", "-5000px"); this.editor = a; this.copyBin = c; this.container = b
                            }, createListeners: function (a) { a && (a.beforeDestroy && (this.beforeDestroy = a.beforeDestroy), a.afterDestroy && (this.afterDestroy = a.afterDestroy)) }
                        }, proto: {
                            handle: function (a) {
                                var b = this.copyBin, c = this.editor, d = this.container, e = CKEDITOR.env.ie && 9 > CKEDITOR.env.version, f = c.document.getDocumentElement().$, g = c.createRange(), h = this, k = CKEDITOR.env.mac && CKEDITOR.env.webkit, l = k ? 100 : 0, m = window.requestAnimationFrame && !k ? requestAnimationFrame : setTimeout,
                                n, p, q; b.setHtml('\x3cspan data-cke-copybin-start\x3d"1"\x3e​\x3c/span\x3e' + a + '\x3cspan data-cke-copybin-end\x3d"1"\x3e​\x3c/span\x3e'); c.fire("lockSnapshot"); d.append(b); c.editable().append(d); n = c.on("selectionChange", D, null, null, 0); p = c.widgets.on("checkSelection", D, null, null, 0); e && (q = f.scrollTop); g.selectNodeContents(b); g.select(); e && (f.scrollTop = q); return new CKEDITOR.tools.promise(function (a) {
                                    m(function () {
                                        h.beforeDestroy && h.beforeDestroy(); d.remove(); n.removeListener(); p.removeListener(); c.fire("unlockSnapshot");
                                        h.afterDestroy && h.afterDestroy(); a()
                                    }, l)
                                })
                            }
                        }, statics: { hasCopyBin: function (a) { return !!S.getCopyBin(a) }, getCopyBin: function (a) { return a.document.getById("cke_copybin") } }
                    }); CKEDITOR.plugins.widget = g; g.repository = a; g.nestedEditable = e
        })(); (function () {
            function a(a, b, d) { this.editor = a; this.notification = null; this._message = new CKEDITOR.template(b); this._singularMessage = d ? new CKEDITOR.template(d) : null; this._tasks = []; this._doneTasks = this._doneWeights = this._totalWeights = 0 } function g(a) {
                this._weight = a || 1; this._doneWeight =
                    0; this._isCanceled = !1
            } CKEDITOR.plugins.add("notificationaggregator", { requires: "notification" }); a.prototype = {
                createTask: function (a) { a = a || {}; var b = !this.notification, d; b && (this.notification = this._createNotification()); d = this._addTask(a); d.on("updated", this._onTaskUpdate, this); d.on("done", this._onTaskDone, this); d.on("canceled", function () { this._removeTask(d) }, this); this.update(); b && this.notification.show(); return d }, update: function () { this._updateNotification(); this.isFinished() && this.fire("finished") },
                getPercentage: function () { return 0 === this.getTaskCount() ? 1 : this._doneWeights / this._totalWeights }, isFinished: function () { return this.getDoneTaskCount() === this.getTaskCount() }, getTaskCount: function () { return this._tasks.length }, getDoneTaskCount: function () { return this._doneTasks }, _updateNotification: function () { this.notification.update({ message: this._getNotificationMessage(), progress: this.getPercentage() }) }, _getNotificationMessage: function () {
                    var a = this.getTaskCount(), b = {
                        current: this.getDoneTaskCount(), max: a,
                        percentage: Math.round(100 * this.getPercentage())
                    }; return (1 == a && this._singularMessage ? this._singularMessage : this._message).output(b)
                }, _createNotification: function () { return new CKEDITOR.plugins.notification(this.editor, { type: "progress" }) }, _addTask: function (a) { a = new g(a.weight); this._tasks.push(a); this._totalWeights += a._weight; return a }, _removeTask: function (a) {
                    var b = CKEDITOR.tools.indexOf(this._tasks, a); -1 !== b && (a._doneWeight && (this._doneWeights -= a._doneWeight), this._totalWeights -= a._weight, this._tasks.splice(b,
                        1), this.update())
                }, _onTaskUpdate: function (a) { this._doneWeights += a.data; this.update() }, _onTaskDone: function () { this._doneTasks += 1; this.update() }
            }; CKEDITOR.event.implementOn(a.prototype); g.prototype = {
                done: function () { this.update(this._weight) }, update: function (a) { if (!this.isDone() && !this.isCanceled()) { a = Math.min(this._weight, a); var b = a - this._doneWeight; this._doneWeight = a; this.fire("updated", b); this.isDone() && this.fire("done") } }, cancel: function () { this.isDone() || this.isCanceled() || (this._isCanceled = !0, this.fire("canceled")) },
                isDone: function () { return this._weight === this._doneWeight }, isCanceled: function () { return this._isCanceled }
            }; CKEDITOR.event.implementOn(g.prototype); CKEDITOR.plugins.notificationAggregator = a; CKEDITOR.plugins.notificationAggregator.task = g
        })(); "use strict"; (function () {
            CKEDITOR.plugins.add("uploadwidget", { requires: "widget,clipboard,filetools,notificationaggregator", init: function (a) { a.filter.allow("*[!data-widget,!data-cke-upload-id]") }, isSupportedEnvironment: function () { return CKEDITOR.plugins.clipboard.isFileApiSupported } });
            CKEDITOR.fileTools || (CKEDITOR.fileTools = {}); CKEDITOR.tools.extend(CKEDITOR.fileTools, {
                addUploadWidget: function (a, g, e) {
                    var b = CKEDITOR.fileTools, d = a.uploadRepository, m = e.supportedTypes ? 10 : 20; if (e.fileToElement) a.on("paste", function (e) {
                        e = e.data; var l = a.widgets.registered[g], c = e.dataTransfer, k = c.getFilesCount(), f = l.loadMethod || "loadAndUpload", m, p; if (!e.dataValue && k) for (p = 0; p < k; p++)if (m = c.getFile(p), !l.supportedTypes || b.isTypeSupported(m, l.supportedTypes)) {
                            var t = l.fileToElement(m); m = d.create(m, void 0,
                                l.loaderType); t && (m[f](l.uploadUrl, l.additionalRequestParameters), CKEDITOR.fileTools.markElement(t, g, m.id), "loadAndUpload" != f && "upload" != f || l.skipNotifications || CKEDITOR.fileTools.bindNotifications(a, m), e.dataValue += t.getOuterHtml())
                        }
                    }, null, null, m); CKEDITOR.tools.extend(e, {
                        downcast: function () { return new CKEDITOR.htmlParser.text("") }, init: function () {
                            var b = this, e = this.wrapper.findOne("[data-cke-upload-id]").data("cke-upload-id"), c = d.loaders[e], g = CKEDITOR.tools.capitalize, f, m; c.on("update", function (d) {
                                if ("abort" ===
                                    c.status && "function" === typeof b.onAbort) b.onAbort(c); if (b.wrapper && b.wrapper.getParent()) { a.fire("lockSnapshot"); d = "on" + g(c.status); if ("abort" === c.status || "function" !== typeof b[d] || !1 !== b[d](c)) m = "cke_upload_" + c.status, b.wrapper && m != f && (f && b.wrapper.removeClass(f), b.wrapper.addClass(m), f = m), "error" != c.status && "abort" != c.status || a.widgets.del(b); a.fire("unlockSnapshot") } else CKEDITOR.instances[a.name] && a.editable().find('[data-cke-upload-id\x3d"' + e + '"]').count() || c.abort(), d.removeListener()
                            }); c.update()
                        },
                        replaceWith: function (b, d) { if ("" === b.trim()) a.widgets.del(this); else { var c = this == a.widgets.focused, e = a.editable(), f = a.createRange(), g, m; c || (m = a.getSelection().createBookmarks()); f.setStartBefore(this.wrapper); f.setEndAfter(this.wrapper); c && (g = f.createBookmark()); e.insertHtmlIntoRange(b, f, d); a.widgets.checkWidgets({ initOnlyNew: !0 }); a.widgets.destroy(this, !0); c ? (f.moveToBookmark(g), f.select()) : a.getSelection().selectBookmarks(m) } }, _getLoader: function () {
                            var a = this.wrapper.findOne("[data-cke-upload-id]");
                            return a ? this.editor.uploadRepository.loaders[a.data("cke-upload-id")] : null
                        }
                    }); a.widgets.add(g, e)
                }, markElement: function (a, g, e) { a.setAttributes({ "data-cke-upload-id": e, "data-widget": g }) }, bindNotifications: function (a, g) {
                    function e() {
                        b = a._.uploadWidgetNotificaionAggregator; if (!b || b.isFinished()) b = a._.uploadWidgetNotificaionAggregator = new CKEDITOR.plugins.notificationAggregator(a, a.lang.uploadwidget.uploadMany, a.lang.uploadwidget.uploadOne), b.once("finished", function () {
                            var d = b.getTaskCount(); 0 === d ? b.notification.hide() :
                                b.notification.update({ message: 1 == d ? a.lang.uploadwidget.doneOne : a.lang.uploadwidget.doneMany.replace("%1", d), type: "success", important: 1 })
                        })
                    } var b, d = null; g.on("update", function () { !d && g.uploadTotal && (e(), d = b.createTask({ weight: g.uploadTotal })); d && "uploading" == g.status && d.update(g.uploaded) }); g.on("uploaded", function () { d && d.done() }); g.on("error", function () { d && d.cancel(); a.showNotification(g.message, "warning") }); g.on("abort", function () {
                        d && d.cancel(); CKEDITOR.instances[a.name] && a.showNotification(a.lang.uploadwidget.abort,
                            "info")
                    })
                }
            })
        })(); "use strict"; (function () {
            function a(a) { 9 >= a && (a = "0" + a); return String(a) } function g(b) { var d = new Date, d = [d.getFullYear(), d.getMonth() + 1, d.getDate(), d.getHours(), d.getMinutes(), d.getSeconds()]; e += 1; return "image-" + CKEDITOR.tools.array.map(d, a).join("") + "-" + e + "." + b } var e = 0; CKEDITOR.plugins.add("uploadimage", {
                requires: "uploadwidget", onLoad: function () { CKEDITOR.addCss(".cke_upload_uploading img{opacity: 0.3}") }, isSupportedEnvironment: function () { return CKEDITOR.plugins.clipboard.isFileApiSupported },
                init: function (a) {
                    if (this.isSupportedEnvironment()) {
                        var d = CKEDITOR.fileTools, e = d.getUploadUrl(a.config, "image"); e && (d.addUploadWidget(a, "uploadimage", {
                            supportedTypes: /image\/(jpeg|png|gif|bmp)/, uploadUrl: e, fileToElement: function () { var a = new CKEDITOR.dom.element("img"); a.setAttribute("src", "data:image/gif;base64,R0lGODlhDgAOAIAAAAAAAP///yH5BAAAAAAALAAAAAAOAA4AAAIMhI+py+0Po5y02qsKADs\x3d"); return a }, parts: { img: "img" }, onUploading: function (a) { this.parts.img.setAttribute("src", a.data) }, onUploaded: function (a) {
                                var b =
                                    this.parts.img.$; this.replaceWith('\x3cimg src\x3d"' + a.url + '" width\x3d"' + (a.responseData.width || b.naturalWidth) + '" height\x3d"' + (a.responseData.height || b.naturalHeight) + '"\x3e')
                            }
                        }), a.on("paste", function (h) {
                            if (h.data.dataValue.match(/<img[\s\S]+data:/i)) {
                                h = h.data; var l = document.implementation.createHTMLDocument(""), l = new CKEDITOR.dom.element(l.body), c, k, f; l.data("cke-editable", 1); l.appendHtml(h.dataValue); c = l.find("img"); for (f = 0; f < c.count(); f++) {
                                    k = c.getItem(f); var n = k.getAttribute("src"), p = n && "data:" ==
                                        n.substring(0, 5), t = null === k.data("cke-realelement"); p && t && !k.data("cke-upload-id") && !k.isReadOnly(1) && (p = (p = n.match(/image\/([a-z]+?);/i)) && p[1] || "jpg", n = a.uploadRepository.create(n, g(p)), n.upload(e), d.markElement(k, "uploadimage", n.id), d.bindNotifications(a, n))
                                } h.dataValue = l.getHtml()
                            }
                        }))
                    }
                }
            })
        })(); CKEDITOR.plugins.add("wsc", {
            requires: "dialog", parseApi: function (a) {
                a.config.wsc_onFinish = "function" === typeof a.config.wsc_onFinish ? a.config.wsc_onFinish : function () { }; a.config.wsc_onClose = "function" === typeof a.config.wsc_onClose ?
                    a.config.wsc_onClose : function () { }
            }, parseConfig: function (a) {
                a.config.wsc_customerId = a.config.wsc_customerId || CKEDITOR.config.wsc_customerId || "1:ua3xw1-2XyGJ3-GWruD3-6OFNT1-oXcuB1-nR6Bp4-hgQHc-EcYng3-sdRXG3-NOfFk"; a.config.wsc_customDictionaryIds = a.config.wsc_customDictionaryIds || CKEDITOR.config.wsc_customDictionaryIds || ""; a.config.wsc_userDictionaryName = a.config.wsc_userDictionaryName || CKEDITOR.config.wsc_userDictionaryName || ""; a.config.wsc_customLoaderScript = a.config.wsc_customLoaderScript || CKEDITOR.config.wsc_customLoaderScript;
                a.config.wsc_interfaceLang = a.config.wsc_interfaceLang; CKEDITOR.config.wsc_cmd = a.config.wsc_cmd || CKEDITOR.config.wsc_cmd || "spell"; CKEDITOR.config.wsc_version = "v4.3.0-master-d769233"; CKEDITOR.config.wsc_removeGlobalVariable = !0
            }, onLoad: function (a) { "moono-lisa" == (CKEDITOR.skinName || a.config.skin) && CKEDITOR.document.appendStyleSheet(CKEDITOR.getUrl(this.path + "skins/" + CKEDITOR.skin.name + "/wsc.css")) }, init: function (a) {
                var g = CKEDITOR.env; this.parseConfig(a); this.parseApi(a); a.addCommand("checkspell", new CKEDITOR.dialogCommand("checkspell")).modes =
                    { wysiwyg: !CKEDITOR.env.opera && !CKEDITOR.env.air && document.domain == window.location.hostname && !(g.ie && (8 > g.version || g.quirks)) }; "undefined" == typeof a.plugins.scayt && a.ui.addButton && a.ui.addButton("SpellChecker", { label: a.lang.wsc.toolbar, click: function (a) { var b = a.elementMode == CKEDITOR.ELEMENT_MODE_INLINE ? a.container.getText() : a.document.getBody().getText(); (b = b.replace(/\s/g, "")) ? a.execCommand("checkspell") : alert("Nothing to check!") }, toolbar: "spellchecker,10" }); CKEDITOR.dialog.add("checkspell", this.path +
                        (CKEDITOR.env.ie && 7 >= CKEDITOR.env.version ? "dialogs/wsc_ie.js" : window.postMessage ? "dialogs/wsc.js" : "dialogs/wsc_ie.js"))
            }
        }); (function () {
            function a(a) {
                function b(a) {
                    var c = !1; f.attachListener(f, "keydown", function () { var b = l.getBody().getElementsByTag(a); if (!c) { for (var d = 0; d < b.count(); d++)b.getItem(d).setCustomData("retain", !0); c = !0 } }, null, null, 1); f.attachListener(f, "keyup", function () {
                        var b = l.getElementsByTag(a); c && (1 == b.count() && !b.getItem(0).getCustomData("retain") && CKEDITOR.tools.isEmpty(b.getItem(0).getAttributes()) &&
                            b.getItem(0).remove(1), c = !1)
                    })
                } var e = this.editor; if (e && !e.isDetached()) {
                    var l = a.document, c = l.body, k = l.getElementById("cke_actscrpt"); k && k.parentNode.removeChild(k); (k = l.getElementById("cke_shimscrpt")) && k.parentNode.removeChild(k); (k = l.getElementById("cke_basetagscrpt")) && k.parentNode.removeChild(k); c.contentEditable = !0; CKEDITOR.env.ie && (c.hideFocus = !0, c.disabled = !0, c.removeAttribute("disabled")); delete this._.isLoadingData; this.$ = c; l = new CKEDITOR.dom.document(l); this.setup(); this.fixInitialSelection();
                    var f = this; CKEDITOR.env.ie && !CKEDITOR.env.edge && l.getDocumentElement().addClass(l.$.compatMode); CKEDITOR.env.ie && !CKEDITOR.env.edge && e.enterMode != CKEDITOR.ENTER_P ? b("p") : CKEDITOR.env.edge && 15 > CKEDITOR.env.version && e.enterMode != CKEDITOR.ENTER_DIV && b("div"); if (CKEDITOR.env.webkit || CKEDITOR.env.ie && 10 < CKEDITOR.env.version) l.getDocumentElement().on("mousedown", function (a) { a.data.getTarget().is("html") && setTimeout(function () { e.editable().focus() }) }); g(e); try { e.document.$.execCommand("2D-position", !1, !0) } catch (n) { } (CKEDITOR.env.gecko ||
                        CKEDITOR.env.ie && "CSS1Compat" == e.document.$.compatMode) && this.attachListener(this, "keydown", function (a) { var b = a.data.getKeystroke(); if (33 == b || 34 == b) if (CKEDITOR.env.ie) setTimeout(function () { e.getSelection().scrollIntoView() }, 0); else if (e.window.$.innerHeight > this.$.offsetHeight) { var c = e.createRange(); c[33 == b ? "moveToElementEditStart" : "moveToElementEditEnd"](this); c.select(); a.data.preventDefault() } }); CKEDITOR.env.ie && this.attachListener(l, "blur", function () { try { l.$.selection.empty() } catch (a) { } }); CKEDITOR.env.iOS &&
                            this.attachListener(l, "touchend", function () { a.focus() }); c = e.document.getElementsByTag("title").getItem(0); c.data("cke-title", c.getText()); CKEDITOR.env.ie && (e.document.$.title = this._.docTitle); CKEDITOR.tools.setTimeout(function () { "unloaded" == this.status && (this.status = "ready"); e.fire("contentDom"); this._.isPendingFocus && (e.focus(), this._.isPendingFocus = !1); setTimeout(function () { e.fire("dataReady") }, 0) }, 0, this)
                }
            } function g(a) {
                function b() {
                    var c; a.editable().attachListener(a, "selectionChange", function () {
                        var b =
                            a.getSelection().getSelectedElement(); b && (c && (c.detachEvent("onresizestart", e), c = null), b.$.attachEvent("onresizestart", e), c = b.$)
                    })
                } function e(a) { a.returnValue = !1 } if (CKEDITOR.env.gecko) try { var g = a.document.$; g.execCommand("enableObjectResizing", !1, !a.config.disableObjectResizing); g.execCommand("enableInlineTableEditing", !1, !a.config.disableNativeTableHandles) } catch (c) { } else CKEDITOR.env.ie && 11 > CKEDITOR.env.version && a.config.disableObjectResizing && b(a)
            } function e() {
                var a = []; if (8 <= CKEDITOR.document.$.documentMode) {
                    a.push("html.CSS1Compat [contenteditable\x3dfalse]{min-height:0 !important}");
                    var b = [], e; for (e in CKEDITOR.dtd.$removeEmpty) b.push("html.CSS1Compat " + e + "[contenteditable\x3dfalse]"); a.push(b.join(",") + "{display:inline-block}")
                } else CKEDITOR.env.gecko && (a.push("html{height:100% !important}"), a.push("img:-moz-broken{-moz-force-broken-image-icon:1;min-width:24px;min-height:24px}")); a.push("html{cursor:text;*cursor:auto}"); a.push("img,input,textarea{cursor:default}"); return a.join("\n")
            } var b; CKEDITOR.plugins.add("wysiwygarea", {
                init: function (a) {
                    a.config.fullPage && a.addFeature({
                        allowedContent: "html head title; style [media,type]; body (*)[id]; meta link [*]",
                        requiredContent: "body"
                    }); a.addMode("wysiwyg", function (e) {
                        function g(f) { f && f.removeListener(); a.isDestroyed() || a.isDetached() || (a.editable(new b(a, c.$.contentWindow.document.body)), a.setData(a.getData(1), e)) } var l = "document.open();" + (CKEDITOR.env.ie ? "(" + CKEDITOR.tools.fixDomain + ")();" : "") + "document.close();", l = CKEDITOR.env.air ? "javascript:void(0)" : CKEDITOR.env.ie && !CKEDITOR.env.edge ? "javascript:void(function(){" + encodeURIComponent(l) + "}())" : "", c = CKEDITOR.dom.element.createFromHtml('\x3ciframe src\x3d"' +
                            l + '" frameBorder\x3d"0"\x3e\x3c/iframe\x3e'); c.setStyles({ width: "100%", height: "100%" }); c.addClass("cke_wysiwyg_frame").addClass("cke_reset"); l = a.ui.space("contents"); l.append(c); var k = CKEDITOR.env.ie && !CKEDITOR.env.edge || CKEDITOR.env.gecko; if (k) c.on("load", g); var f = a.title, n = a.fire("ariaEditorHelpLabel", {}).label; f && (CKEDITOR.env.ie && n && (f += ", " + n), c.setAttribute("title", f)); if (n) {
                                var f = CKEDITOR.tools.getNextId(), p = CKEDITOR.dom.element.createFromHtml('\x3cspan id\x3d"' + f + '" class\x3d"cke_voice_label"\x3e' +
                                    n + "\x3c/span\x3e"); l.append(p, 1); c.setAttribute("aria-describedby", f)
                            } a.on("beforeModeUnload", function (a) { a.removeListener(); p && p.remove() }); c.setAttributes({ tabIndex: a.tabIndex, allowTransparency: "true" }); !k && g(); a.fire("ariaWidget", c)
                    })
                }
            }); CKEDITOR.editor.prototype.addContentsCss = function (a) { var b = this.config, e = b.contentsCss; CKEDITOR.tools.isArray(e) || (b.contentsCss = e ? [e] : []); b.contentsCss.push(a) }; b = CKEDITOR.tools.createClass({
                $: function () {
                    this.base.apply(this, arguments); this._.frameLoadedHandler =
                        CKEDITOR.tools.addFunction(function (b) { CKEDITOR.tools.setTimeout(a, 0, this, b) }, this); this._.docTitle = this.getWindow().getFrame().getAttribute("title")
                }, base: CKEDITOR.editable, proto: {
                    setData: function (a, b) {
                        var g = this.editor; if (b) this.setHtml(a), this.fixInitialSelection(), g.fire("dataReady"); else {
                            this._.isLoadingData = !0; g._.dataStore = { id: 1 }; var l = g.config, c = l.fullPage, k = l.docType, f = CKEDITOR.tools.buildStyleHtml(e()).replace(/<style>/, '\x3cstyle data-cke-temp\x3d"1"\x3e'); c || (f += CKEDITOR.tools.buildStyleHtml(g.config.contentsCss));
                            var n = l.baseHref ? '\x3cbase href\x3d"' + l.baseHref + '" data-cke-temp\x3d"1" /\x3e' : ""; c && (a = a.replace(/<!DOCTYPE[^>]*>/i, function (a) { g.docType = k = a; return "" }).replace(/<\?xml\s[^\?]*\?>/i, function (a) { g.xmlDeclaration = a; return "" })); a = g.dataProcessor.toHtml(a); c ? (/<body[\s|>]/.test(a) || (a = "\x3cbody\x3e" + a), /<html[\s|>]/.test(a) || (a = "\x3chtml\x3e" + a + "\x3c/html\x3e"), /<head[\s|>]/.test(a) ? /<title[\s|>]/.test(a) || (a = a.replace(/<head[^>]*>/, "$\x26\x3ctitle\x3e\x3c/title\x3e")) : a = a.replace(/<html[^>]*>/, "$\x26\x3chead\x3e\x3ctitle\x3e\x3c/title\x3e\x3c/head\x3e"),
                                n && (a = a.replace(/<head[^>]*?>/, "$\x26" + n)), a = a.replace(/<\/head\s*>/, f + "$\x26"), a = k + a) : a = l.docType + '\x3chtml dir\x3d"' + l.contentsLangDirection + '" lang\x3d"' + (l.contentsLanguage || g.langCode) + '"\x3e\x3chead\x3e\x3ctitle\x3e' + this._.docTitle + "\x3c/title\x3e" + n + f + "\x3c/head\x3e\x3cbody" + (l.bodyId ? ' id\x3d"' + l.bodyId + '"' : "") + (l.bodyClass ? ' class\x3d"' + l.bodyClass + '"' : "") + "\x3e" + a + "\x3c/body\x3e\x3c/html\x3e"; CKEDITOR.env.gecko && (a = a.replace(/<body/, '\x3cbody contenteditable\x3d"true" '), 2E4 > CKEDITOR.env.version &&
                                    (a = a.replace(/<body[^>]*>/, "$\x26\x3c!-- cke-content-start --\x3e"))); l = '\x3cscript id\x3d"cke_actscrpt" type\x3d"text/javascript"' + (CKEDITOR.env.ie ? ' defer\x3d"defer" ' : "") + "\x3evar wasLoaded\x3d0;function onload(){if(!wasLoaded)window.parent.CKEDITOR.tools.callFunction(" + this._.frameLoadedHandler + ",window);wasLoaded\x3d1;}" + (CKEDITOR.env.ie ? "onload();" : 'document.addEventListener("DOMContentLoaded", onload, false );') + "\x3c/script\x3e"; CKEDITOR.env.ie && 9 > CKEDITOR.env.version && (l += '\x3cscript id\x3d"cke_shimscrpt"\x3ewindow.parent.CKEDITOR.tools.enableHtml5Elements(document)\x3c/script\x3e');
                            n && CKEDITOR.env.ie && 10 > CKEDITOR.env.version && (l += '\x3cscript id\x3d"cke_basetagscrpt"\x3evar baseTag \x3d document.querySelector( "base" );baseTag.href \x3d baseTag.href;\x3c/script\x3e'); a = a.replace(/(?=\s*<\/(:?head)>)/, l); this.clearCustomData(); this.clearListeners(); g.fire("contentDomUnload"); var p = this.getDocument(); try { p.write(a) } catch (t) { setTimeout(function () { p.write(a) }, 0) }
                        }
                    }, getData: function (a) {
                        if (a) return this.getHtml(); a = this.editor; var b = a.config, e = b.fullPage, g = e && a.docType, c = e && a.xmlDeclaration,
                            k = this.getDocument(), e = e ? k.getDocumentElement().getOuterHtml() : k.getBody().getHtml(); CKEDITOR.env.gecko && b.enterMode != CKEDITOR.ENTER_BR && (e = e.replace(/<br>(?=\s*(:?$|<\/body>))/, "")); e = a.dataProcessor.toDataFormat(e); c && (e = c + "\n" + e); g && (e = g + "\n" + e); return e
                    }, focus: function () { this._.isLoadingData ? this._.isPendingFocus = !0 : b.baseProto.focus.call(this) }, detach: function () {
                        var a = this.editor, e = a.document, a = a.container.findOne("iframe.cke_wysiwyg_frame"); b.baseProto.detach.call(this); this.clearCustomData(this._.expandoNumber);
                        e.getDocumentElement().clearCustomData(); CKEDITOR.tools.removeFunction(this._.frameLoadedHandler); a && (a.clearCustomData(), (e = a.removeCustomData("onResize")) && e.removeListener(), a.isDetached() || a.remove())
                    }
                }
            })
        })(); CKEDITOR.config.disableObjectResizing = !1; CKEDITOR.config.disableNativeTableHandles = !0; CKEDITOR.config.disableNativeSpellChecker = !0; CKEDITOR.config.plugins = "dialogui,dialog,a11yhelp,about,basicstyles,bidi,blockquote,notification,button,toolbar,clipboard,panelbutton,panel,floatpanel,colorbutton,colordialog,copyformatting,menu,contextmenu,dialogadvtab,div,elementspath,enterkey,entities,popup,filetools,filebrowser,find,fakeobjects,flash,floatingspace,listblock,richcombo,font,format,forms,horizontalrule,htmlwriter,iframe,image,indent,indentblock,indentlist,justify,menubutton,language,link,list,liststyle,magicline,maximize,newpage,pagebreak,pastetools,pastefromgdocs,pastefromlibreoffice,pastefromword,pastetext,preview,print,removeformat,resize,save,scayt,selectall,showblocks,showborders,smiley,sourcearea,specialchar,stylescombo,tab,table,tabletools,tableselection,templates,undo,lineutils,widgetselection,widget,notificationaggregator,uploadwidget,uploadimage,wsc,wysiwygarea";
        CKEDITOR.config.skin = "moono-lisa"; (function () {
            var a = function (a, e) { var b = CKEDITOR.getUrl("plugins/" + e); a = a.split(","); for (var d = 0; d < a.length; d++)CKEDITOR.skin.icons[a[d]] = { path: b, offset: -a[++d], bgsize: a[++d] } }; CKEDITOR.env.hidpi ? a("about,0,,bold,24,,italic,48,,strike,72,,subscript,96,,superscript,120,,underline,144,,bidiltr,168,,bidirtl,192,,blockquote,216,,copy-rtl,240,,copy,264,,cut-rtl,288,,cut,312,,paste-rtl,336,,paste,360,,bgcolor,384,,textcolor,408,,copyformatting,432,,creatediv,456,,find-rtl,480,,find,504,,replace,528,,flash,552,,button,576,,checkbox,600,,form,624,,hiddenfield,648,,imagebutton,672,,radio,696,,select-rtl,720,,select,744,,textarea-rtl,768,,textarea,792,,textfield-rtl,816,,textfield,840,,horizontalrule,864,,iframe,888,,image,912,,indent-rtl,936,,indent,960,,outdent-rtl,984,,outdent,1008,,justifyblock,1032,,justifycenter,1056,,justifyleft,1080,,justifyright,1104,,language,1128,,anchor-rtl,1152,,anchor,1176,,link,1200,,unlink,1224,,bulletedlist-rtl,1248,,bulletedlist,1272,,numberedlist-rtl,1296,,numberedlist,1320,,maximize,1344,,newpage-rtl,1368,,newpage,1392,,pagebreak-rtl,1416,,pagebreak,1440,,pastefromword-rtl,1464,,pastefromword,1488,,pastetext-rtl,1512,,pastetext,1536,,preview-rtl,1560,,preview,1584,,print,1608,,removeformat,1632,,save,1656,,scayt,1680,,selectall,1704,,showblocks-rtl,1728,,showblocks,1752,,smiley,1776,,source-rtl,1800,,source,1824,,specialchar,1848,,table,1872,,templates-rtl,1896,,templates,1920,,redo-rtl,1944,,redo,1968,,undo-rtl,1992,,undo,2016,,simplebox,4080,auto,spellchecker,2064,",
                "icons_hidpi.png") : a("about,0,auto,bold,24,auto,italic,48,auto,strike,72,auto,subscript,96,auto,superscript,120,auto,underline,144,auto,bidiltr,168,auto,bidirtl,192,auto,blockquote,216,auto,copy-rtl,240,auto,copy,264,auto,cut-rtl,288,auto,cut,312,auto,paste-rtl,336,auto,paste,360,auto,bgcolor,384,auto,textcolor,408,auto,copyformatting,432,auto,creatediv,456,auto,find-rtl,480,auto,find,504,auto,replace,528,auto,flash,552,auto,button,576,auto,checkbox,600,auto,form,624,auto,hiddenfield,648,auto,imagebutton,672,auto,radio,696,auto,select-rtl,720,auto,select,744,auto,textarea-rtl,768,auto,textarea,792,auto,textfield-rtl,816,auto,textfield,840,auto,horizontalrule,864,auto,iframe,888,auto,image,912,auto,indent-rtl,936,auto,indent,960,auto,outdent-rtl,984,auto,outdent,1008,auto,justifyblock,1032,auto,justifycenter,1056,auto,justifyleft,1080,auto,justifyright,1104,auto,language,1128,auto,anchor-rtl,1152,auto,anchor,1176,auto,link,1200,auto,unlink,1224,auto,bulletedlist-rtl,1248,auto,bulletedlist,1272,auto,numberedlist-rtl,1296,auto,numberedlist,1320,auto,maximize,1344,auto,newpage-rtl,1368,auto,newpage,1392,auto,pagebreak-rtl,1416,auto,pagebreak,1440,auto,pastefromword-rtl,1464,auto,pastefromword,1488,auto,pastetext-rtl,1512,auto,pastetext,1536,auto,preview-rtl,1560,auto,preview,1584,auto,print,1608,auto,removeformat,1632,auto,save,1656,auto,scayt,1680,auto,selectall,1704,auto,showblocks-rtl,1728,auto,showblocks,1752,auto,smiley,1776,auto,source-rtl,1800,auto,source,1824,auto,specialchar,1848,auto,table,1872,auto,templates-rtl,1896,auto,templates,1920,auto,redo-rtl,1944,auto,redo,1968,auto,undo-rtl,1992,auto,undo,2016,auto,simplebox,2040,auto,spellchecker,2064,auto",
                    "icons.png")
        })()
    }
})();