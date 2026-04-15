(function () {
  'use strict';

  var _WINDOW = {};
  var _DOCUMENT = {};
  try {
    if (typeof window !== 'undefined') _WINDOW = window;
    if (typeof document !== 'undefined') _DOCUMENT = document;
  } catch (e) {} // eslint-disable-line no-empty

  var _ref = _WINDOW.navigator || {},
    _ref$userAgent = _ref.userAgent,
    userAgent = _ref$userAgent === void 0 ? '' : _ref$userAgent;
  var WINDOW = _WINDOW;
  var DOCUMENT = _DOCUMENT;
  var IS_BROWSER = !!WINDOW.document;
  var IS_DOM = !!DOCUMENT.documentElement && !!DOCUMENT.head && typeof DOCUMENT.addEventListener === 'function' && typeof DOCUMENT.createElement === 'function';
  var IS_IE = ~userAgent.indexOf('MSIE') || ~userAgent.indexOf('Trident/');

  function _arrayLikeToArray(r, a) {
    (null == a || a > r.length) && (a = r.length);
    for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e];
    return n;
  }
  function _arrayWithoutHoles(r) {
    if (Array.isArray(r)) return _arrayLikeToArray(r);
  }
  function _defineProperty(e, r, t) {
    return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, {
      value: t,
      enumerable: !0,
      configurable: !0,
      writable: !0
    }) : e[r] = t, e;
  }
  function _iterableToArray(r) {
    if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r);
  }
  function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
  }
  function ownKeys(e, r) {
    var t = Object.keys(e);
    if (Object.getOwnPropertySymbols) {
      var o = Object.getOwnPropertySymbols(e);
      r && (o = o.filter(function (r) {
        return Object.getOwnPropertyDescriptor(e, r).enumerable;
      })), t.push.apply(t, o);
    }
    return t;
  }
  function _objectSpread2(e) {
    for (var r = 1; r < arguments.length; r++) {
      var t = null != arguments[r] ? arguments[r] : {};
      r % 2 ? ownKeys(Object(t), !0).forEach(function (r) {
        _defineProperty(e, r, t[r]);
      }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) {
        Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r));
      });
    }
    return e;
  }
  function _toConsumableArray(r) {
    return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread();
  }
  function _toPrimitive(t, r) {
    if ("object" != typeof t || !t) return t;
    var e = t[Symbol.toPrimitive];
    if (void 0 !== e) {
      var i = e.call(t, r || "default");
      if ("object" != typeof i) return i;
      throw new TypeError("@@toPrimitive must return a primitive value.");
    }
    return ("string" === r ? String : Number)(t);
  }
  function _toPropertyKey(t) {
    var i = _toPrimitive(t, "string");
    return "symbol" == typeof i ? i : i + "";
  }
  function _unsupportedIterableToArray(r, a) {
    if (r) {
      if ("string" == typeof r) return _arrayLikeToArray(r, a);
      var t = {}.toString.call(r).slice(8, -1);
      return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0;
    }
  }

  var _ht;
  var Q = {
      classic: {
        fa: "solid",
        fas: "solid",
        "fa-solid": "solid",
        far: "regular",
        "fa-regular": "regular",
        fal: "light",
        "fa-light": "light",
        fat: "thin",
        "fa-thin": "thin",
        fab: "brands",
        "fa-brands": "brands"
      },
      duotone: {
        fa: "solid",
        fad: "solid",
        "fa-solid": "solid",
        "fa-duotone": "solid",
        fadr: "regular",
        "fa-regular": "regular",
        fadl: "light",
        "fa-light": "light",
        fadt: "thin",
        "fa-thin": "thin"
      },
      sharp: {
        fa: "solid",
        fass: "solid",
        "fa-solid": "solid",
        fasr: "regular",
        "fa-regular": "regular",
        fasl: "light",
        "fa-light": "light",
        fast: "thin",
        "fa-thin": "thin"
      },
      "sharp-duotone": {
        fa: "solid",
        fasds: "solid",
        "fa-solid": "solid",
        fasdr: "regular",
        "fa-regular": "regular",
        fasdl: "light",
        "fa-light": "light",
        fasdt: "thin",
        "fa-thin": "thin"
      },
      slab: {
        "fa-regular": "regular",
        faslr: "regular"
      },
      "slab-press": {
        "fa-regular": "regular",
        faslpr: "regular"
      },
      thumbprint: {
        "fa-light": "light",
        fatl: "light"
      },
      whiteboard: {
        "fa-semibold": "semibold",
        fawsb: "semibold"
      },
      notdog: {
        "fa-solid": "solid",
        fans: "solid"
      },
      "notdog-duo": {
        "fa-solid": "solid",
        fands: "solid"
      },
      etch: {
        "fa-solid": "solid",
        faes: "solid"
      },
      graphite: {
        "fa-thin": "thin",
        fagt: "thin"
      },
      jelly: {
        "fa-regular": "regular",
        fajr: "regular"
      },
      "jelly-fill": {
        "fa-regular": "regular",
        fajfr: "regular"
      },
      "jelly-duo": {
        "fa-regular": "regular",
        fajdr: "regular"
      },
      chisel: {
        "fa-regular": "regular",
        facr: "regular"
      },
      utility: {
        "fa-semibold": "semibold",
        fausb: "semibold"
      },
      "utility-duo": {
        "fa-semibold": "semibold",
        faudsb: "semibold"
      },
      "utility-fill": {
        "fa-semibold": "semibold",
        faufsb: "semibold"
      }
    };
  var i = "classic",
    t = "duotone",
    d = "sharp",
    l = "sharp-duotone",
    f = "chisel",
    h = "etch",
    n = "graphite",
    g = "jelly",
    o = "jelly-duo",
    u = "jelly-fill",
    m = "notdog",
    e = "notdog-duo",
    y = "slab",
    p = "slab-press",
    s = "thumbprint",
    w = "utility",
    a = "utility-duo",
    x = "utility-fill",
    b = "whiteboard",
    c = "Classic",
    I = "Duotone",
    F = "Sharp",
    v = "Sharp Duotone",
    S = "Chisel",
    A = "Etch",
    P = "Graphite",
    j = "Jelly",
    B = "Jelly Duo",
    N = "Jelly Fill",
    k = "Notdog",
    D = "Notdog Duo",
    T = "Slab",
    C = "Slab Press",
    W = "Thumbprint",
    K = "Utility",
    R = "Utility Duo",
    L = "Utility Fill",
    U = "Whiteboard",
    ht = (_ht = {}, _defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_ht, i, c), t, I), d, F), l, v), f, S), h, A), n, P), g, j), o, B), u, N), _defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_ht, m, k), e, D), y, T), p, C), s, W), w, K), a, R), x, L), b, U));
  var yt = {
      classic: {
        900: "fas",
        400: "far",
        normal: "far",
        300: "fal",
        100: "fat"
      },
      duotone: {
        900: "fad",
        400: "fadr",
        300: "fadl",
        100: "fadt"
      },
      sharp: {
        900: "fass",
        400: "fasr",
        300: "fasl",
        100: "fast"
      },
      "sharp-duotone": {
        900: "fasds",
        400: "fasdr",
        300: "fasdl",
        100: "fasdt"
      },
      slab: {
        400: "faslr"
      },
      "slab-press": {
        400: "faslpr"
      },
      whiteboard: {
        600: "fawsb"
      },
      thumbprint: {
        300: "fatl"
      },
      notdog: {
        900: "fans"
      },
      "notdog-duo": {
        900: "fands"
      },
      etch: {
        900: "faes"
      },
      graphite: {
        100: "fagt"
      },
      chisel: {
        400: "facr"
      },
      jelly: {
        400: "fajr"
      },
      "jelly-fill": {
        400: "fajfr"
      },
      "jelly-duo": {
        400: "fajdr"
      },
      utility: {
        600: "fausb"
      },
      "utility-duo": {
        600: "faudsb"
      },
      "utility-fill": {
        600: "faufsb"
      }
    };
  var Mt = {
      chisel: {
        regular: "facr"
      },
      classic: {
        brands: "fab",
        light: "fal",
        regular: "far",
        solid: "fas",
        thin: "fat"
      },
      duotone: {
        light: "fadl",
        regular: "fadr",
        solid: "fad",
        thin: "fadt"
      },
      etch: {
        solid: "faes"
      },
      graphite: {
        thin: "fagt"
      },
      jelly: {
        regular: "fajr"
      },
      "jelly-duo": {
        regular: "fajdr"
      },
      "jelly-fill": {
        regular: "fajfr"
      },
      notdog: {
        solid: "fans"
      },
      "notdog-duo": {
        solid: "fands"
      },
      sharp: {
        light: "fasl",
        regular: "fasr",
        solid: "fass",
        thin: "fast"
      },
      "sharp-duotone": {
        light: "fasdl",
        regular: "fasdr",
        solid: "fasds",
        thin: "fasdt"
      },
      slab: {
        regular: "faslr"
      },
      "slab-press": {
        regular: "faslpr"
      },
      thumbprint: {
        light: "fatl"
      },
      utility: {
        semibold: "fausb"
      },
      "utility-duo": {
        semibold: "faudsb"
      },
      "utility-fill": {
        semibold: "faufsb"
      },
      whiteboard: {
        semibold: "fawsb"
      }
    };
  var Qt = {
      kit: {
        fak: "kit",
        "fa-kit": "kit"
      },
      "kit-duotone": {
        fakd: "kit-duotone",
        "fa-kit-duotone": "kit-duotone"
      }
    },
    Xt = ["kit"];
  var J = "kit",
    r = "kit-duotone",
    E = "Kit",
    _ = "Kit Duotone",
    ll = _defineProperty(_defineProperty({}, J, E), r, _);
  var sl = {
    kit: {
      "fa-kit": "fak"
    },
    "kit-duotone": {
      "fa-kit-duotone": "fakd"
    }
  };
  var nl = {
      kit: {
        fak: "fa-kit"
      },
      "kit-duotone": {
        fakd: "fa-kit-duotone"
      }
    };
  var ml = {
      kit: {
        kit: "fak"
      },
      "kit-duotone": {
        "kit-duotone": "fakd"
      }
    };

  var _wt;
  var t$1 = {
      GROUP: "duotone-group",
      SWAP_OPACITY: "swap-opacity",
      PRIMARY: "primary",
      SECONDARY: "secondary"
    };
  var h$1 = "classic",
    o$1 = "duotone",
    n$1 = "sharp",
    s$1 = "sharp-duotone",
    u$1 = "chisel",
    g$1 = "etch",
    y$1 = "graphite",
    m$1 = "jelly",
    a$1 = "jelly-duo",
    p$1 = "jelly-fill",
    w$1 = "notdog",
    e$1 = "notdog-duo",
    b$1 = "slab",
    c$1 = "slab-press",
    r$1 = "thumbprint",
    x$1 = "utility",
    i$1 = "utility-duo",
    I$1 = "utility-fill",
    F$1 = "whiteboard",
    v$1 = "Classic",
    S$1 = "Duotone",
    A$1 = "Sharp",
    P$1 = "Sharp Duotone",
    j$1 = "Chisel",
    B$1 = "Etch",
    N$1 = "Graphite",
    k$1 = "Jelly",
    D$1 = "Jelly Duo",
    C$1 = "Jelly Fill",
    T$1 = "Notdog",
    L$1 = "Notdog Duo",
    W$1 = "Slab",
    R$1 = "Slab Press",
    K$1 = "Thumbprint",
    U$1 = "Utility",
    J$1 = "Utility Duo",
    E$1 = "Utility Fill",
    _$1 = "Whiteboard",
    wt$1 = (_wt = {}, _defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_wt, h$1, v$1), o$1, S$1), n$1, A$1), s$1, P$1), u$1, j$1), g$1, B$1), y$1, N$1), m$1, k$1), a$1, D$1), p$1, C$1), _defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_defineProperty(_wt, w$1, T$1), e$1, L$1), b$1, W$1), c$1, R$1), r$1, K$1), x$1, U$1), i$1, J$1), I$1, E$1), F$1, _$1));
  var G$1 = "kit",
    d$1 = "kit-duotone",
    M$1 = "Kit",
    O = "Kit Duotone",
    dl$1 = _defineProperty(_defineProperty({}, G$1, M$1), d$1, O);
  var Hl = {
      classic: {
        "fa-brands": "fab",
        "fa-duotone": "fad",
        "fa-light": "fal",
        "fa-regular": "far",
        "fa-solid": "fas",
        "fa-thin": "fat"
      },
      duotone: {
        "fa-regular": "fadr",
        "fa-light": "fadl",
        "fa-thin": "fadt"
      },
      sharp: {
        "fa-solid": "fass",
        "fa-regular": "fasr",
        "fa-light": "fasl",
        "fa-thin": "fast"
      },
      "sharp-duotone": {
        "fa-solid": "fasds",
        "fa-regular": "fasdr",
        "fa-light": "fasdl",
        "fa-thin": "fasdt"
      },
      slab: {
        "fa-regular": "faslr"
      },
      "slab-press": {
        "fa-regular": "faslpr"
      },
      whiteboard: {
        "fa-semibold": "fawsb"
      },
      thumbprint: {
        "fa-light": "fatl"
      },
      notdog: {
        "fa-solid": "fans"
      },
      "notdog-duo": {
        "fa-solid": "fands"
      },
      etch: {
        "fa-solid": "faes"
      },
      graphite: {
        "fa-thin": "fagt"
      },
      jelly: {
        "fa-regular": "fajr"
      },
      "jelly-fill": {
        "fa-regular": "fajfr"
      },
      "jelly-duo": {
        "fa-regular": "fajdr"
      },
      chisel: {
        "fa-regular": "facr"
      },
      utility: {
        "fa-semibold": "fausb"
      },
      "utility-duo": {
        "fa-semibold": "faudsb"
      },
      "utility-fill": {
        "fa-semibold": "faufsb"
      }
    },
    Y$1 = {
      classic: ["fas", "far", "fal", "fat", "fad"],
      duotone: ["fadr", "fadl", "fadt"],
      sharp: ["fass", "fasr", "fasl", "fast"],
      "sharp-duotone": ["fasds", "fasdr", "fasdl", "fasdt"],
      slab: ["faslr"],
      "slab-press": ["faslpr"],
      whiteboard: ["fawsb"],
      thumbprint: ["fatl"],
      notdog: ["fans"],
      "notdog-duo": ["fands"],
      etch: ["faes"],
      graphite: ["fagt"],
      jelly: ["fajr"],
      "jelly-fill": ["fajfr"],
      "jelly-duo": ["fajdr"],
      chisel: ["facr"],
      utility: ["fausb"],
      "utility-duo": ["faudsb"],
      "utility-fill": ["faufsb"]
    },
    Xl = {
      classic: {
        fab: "fa-brands",
        fad: "fa-duotone",
        fal: "fa-light",
        far: "fa-regular",
        fas: "fa-solid",
        fat: "fa-thin"
      },
      duotone: {
        fadr: "fa-regular",
        fadl: "fa-light",
        fadt: "fa-thin"
      },
      sharp: {
        fass: "fa-solid",
        fasr: "fa-regular",
        fasl: "fa-light",
        fast: "fa-thin"
      },
      "sharp-duotone": {
        fasds: "fa-solid",
        fasdr: "fa-regular",
        fasdl: "fa-light",
        fasdt: "fa-thin"
      },
      slab: {
        faslr: "fa-regular"
      },
      "slab-press": {
        faslpr: "fa-regular"
      },
      whiteboard: {
        fawsb: "fa-semibold"
      },
      thumbprint: {
        fatl: "fa-light"
      },
      notdog: {
        fans: "fa-solid"
      },
      "notdog-duo": {
        fands: "fa-solid"
      },
      etch: {
        faes: "fa-solid"
      },
      graphite: {
        fagt: "fa-thin"
      },
      jelly: {
        fajr: "fa-regular"
      },
      "jelly-fill": {
        fajfr: "fa-regular"
      },
      "jelly-duo": {
        fajdr: "fa-regular"
      },
      chisel: {
        facr: "fa-regular"
      },
      utility: {
        fausb: "fa-semibold"
      },
      "utility-duo": {
        faudsb: "fa-semibold"
      },
      "utility-fill": {
        faufsb: "fa-semibold"
      }
    },
    $ = ["solid", "regular", "light", "thin", "duotone", "brands", "semibold"],
    z$1 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    q$1 = z$1.concat([11, 12, 13, 14, 15, 16, 17, 18, 19, 20]),
    H$1 = ["aw", "fw", "pull-left", "pull-right"],
    so = [].concat(_toConsumableArray(Object.keys(Y$1)), $, H$1, ["2xs", "xs", "sm", "lg", "xl", "2xl", "beat", "border", "fade", "beat-fade", "bounce", "flip-both", "flip-horizontal", "flip-vertical", "flip", "inverse", "layers", "layers-bottom-left", "layers-bottom-right", "layers-counter", "layers-text", "layers-top-left", "layers-top-right", "li", "pull-end", "pull-start", "pulse", "rotate-180", "rotate-270", "rotate-90", "rotate-by", "shake", "spin-pulse", "spin-reverse", "spin", "stack-1x", "stack-2x", "stack", "ul", "width-auto", "width-fixed", t$1.GROUP, t$1.SWAP_OPACITY, t$1.PRIMARY, t$1.SECONDARY]).concat(z$1.map(function (l) {
      return "".concat(l, "x");
    })).concat(q$1.map(function (l) {
      return "w-".concat(l);
    }));

  var NAMESPACE_IDENTIFIER = '___FONT_AWESOME___';
  var PRODUCTION = function () {
    try {
      return "production" === 'production';
    } catch (e$$1) {
      return false;
    }
  }();
  function familyProxy(obj) {
    // Defaults to the classic family if family is not available
    return new Proxy(obj, {
      get: function get(target, prop) {
        return prop in target ? target[prop] : target[i];
      }
    });
  }
  var _PREFIX_TO_STYLE = _objectSpread2({}, Q);

  // We changed FACSSClassesToStyleId in the icons repo to be canonical and as such, "classic" family does not have any
  // duotone styles.  But we do still need duotone in _PREFIX_TO_STYLE below, so we are manually adding
  // {'fa-duotone': 'duotone'}
  _PREFIX_TO_STYLE[i] = _objectSpread2(_objectSpread2(_objectSpread2(_objectSpread2({}, {
    'fa-duotone': 'duotone'
  }), Q[i]), Qt['kit']), Qt['kit-duotone']);
  var PREFIX_TO_STYLE = familyProxy(_PREFIX_TO_STYLE);
  var _STYLE_TO_PREFIX = _objectSpread2({}, Mt);

  // We changed FAStyleIdToShortPrefixId in the icons repo to be canonical and as such, "classic" family does not have any
  // duotone styles.  But we do still need duotone in _STYLE_TO_PREFIX below, so we are manually adding {duotone: 'fad'}
  _STYLE_TO_PREFIX[i] = _objectSpread2(_objectSpread2(_objectSpread2(_objectSpread2({}, {
    duotone: 'fad'
  }), _STYLE_TO_PREFIX[i]), ml['kit']), ml['kit-duotone']);
  var STYLE_TO_PREFIX = familyProxy(_STYLE_TO_PREFIX);
  var _PREFIX_TO_LONG_STYLE = _objectSpread2({}, Xl);
  _PREFIX_TO_LONG_STYLE[i] = _objectSpread2(_objectSpread2({}, _PREFIX_TO_LONG_STYLE[i]), nl['kit']);
  var PREFIX_TO_LONG_STYLE = familyProxy(_PREFIX_TO_LONG_STYLE);
  var _LONG_STYLE_TO_PREFIX = _objectSpread2({}, Hl);
  _LONG_STYLE_TO_PREFIX[i] = _objectSpread2(_objectSpread2({}, _LONG_STYLE_TO_PREFIX[i]), sl['kit']);
  var LONG_STYLE_TO_PREFIX = familyProxy(_LONG_STYLE_TO_PREFIX);
  var _FONT_WEIGHT_TO_PREFIX = _objectSpread2({}, yt);
  var FONT_WEIGHT_TO_PREFIX = familyProxy(_FONT_WEIGHT_TO_PREFIX);
  var RESERVED_CLASSES = [].concat(_toConsumableArray(Xt), _toConsumableArray(so));

  function bunker(fn) {
    try {
      for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
        args[_key - 1] = arguments[_key];
      }
      fn.apply(void 0, args);
    } catch (e) {
      if (!PRODUCTION) {
        throw e;
      }
    }
  }

  var w$2 = WINDOW || {};
  if (!w$2[NAMESPACE_IDENTIFIER]) w$2[NAMESPACE_IDENTIFIER] = {};
  if (!w$2[NAMESPACE_IDENTIFIER].styles) w$2[NAMESPACE_IDENTIFIER].styles = {};
  if (!w$2[NAMESPACE_IDENTIFIER].hooks) w$2[NAMESPACE_IDENTIFIER].hooks = {};
  if (!w$2[NAMESPACE_IDENTIFIER].shims) w$2[NAMESPACE_IDENTIFIER].shims = [];
  var namespace = w$2[NAMESPACE_IDENTIFIER];

  function normalizeIcons(icons) {
    return Object.keys(icons).reduce(function (acc, iconName) {
      var icon = icons[iconName];
      var expanded = !!icon.icon;
      if (expanded) {
        acc[icon.iconName] = icon.icon;
      } else {
        acc[iconName] = icon;
      }
      return acc;
    }, {});
  }
  function defineIcons(prefix, icons) {
    var params = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    var _params$skipHooks = params.skipHooks,
      skipHooks = _params$skipHooks === void 0 ? false : _params$skipHooks;
    var normalized = normalizeIcons(icons);
    if (typeof namespace.hooks.addPack === 'function' && !skipHooks) {
      namespace.hooks.addPack(prefix, normalizeIcons(icons));
    } else {
      namespace.styles[prefix] = _objectSpread2(_objectSpread2({}, namespace.styles[prefix] || {}), normalized);
    }

    /**
     * Font Awesome 4 used the prefix of `fa` for all icons. With the introduction
     * of new styles we needed to differentiate between them. Prefix `fa` is now an alias
     * for `fas` so we'll ease the upgrade process for our users by automatically defining
     * this as well.
     */
    if (prefix === 'fas') {
      defineIcons('fa', icons);
    }
  }

  var icons = {
    
    "iit-t1-pos": [423,512,[],"e001","M369.4 25.6L67 25.6C45.9 25.6 28.6 42.9 28.6 64l0 295.6 340.8 0c21.1 0 38.4-17.3 38.4-38.4l0-257.2c0-21.1-17.3-38.4-38.4-38.4zM121.8 92.4c0 7.7-2.6 14.2-7.8 19.4-5.2 5.2-11.6 7.9-19 7.9s-13.6-2.6-18.9-7.9-7.9-11.7-7.9-19.4 2.6-13.9 7.9-19.1 11.6-7.9 18.9-7.9 13.8 2.6 19 7.9c5.2 5.2 7.8 11.6 7.8 19.1zm-1.4 225.7l-50.9 0 0-184.6 50.9 0 0 184.6zM219.1 92.4c0 7.7-2.6 14.2-7.8 19.4s-11.6 7.9-19 7.9-13.7-2.6-18.9-7.9c-5.3-5.2-7.9-11.7-7.9-19.4s2.6-13.9 7.9-19.1 11.6-7.9 18.9-7.9 13.8 2.6 19 7.9 7.8 11.6 7.8 19.1zm-1.4 225.7l-50.9 0 0-184.6 50.9 0 0 184.6zM367.4 165.4l-48.5 0 0 94.6c0 9.6 1.6 16.7 4.8 21.2 3.2 4.5 9.3 6.7 18.5 6.7 4.4 0 8.6-.3 12.6-1s7.8-1.6 11.2-2.6l0 28.9c-5.4 2.3-12.1 3.9-20 5s-15.7 1.6-23.3 1.6c-16.8 0-30.1-5.4-39.9-16.3-9.8-10.9-14.7-26.4-14.7-46.8l0-91.6-21.8 0 0-26.3 23.8-1.3 17-61.4 31.9 0 0 61.1 48.5 0 0 28.2zM29.1 406.5l5.3 0 0 29.1-5.3 0 0-29.1zm13 23c1.7 1.2 3.9 2.1 6.6 2.1 2.4 0 4.8-.9 4.8-3.4 0-5.7-12.6-5-12.6-13.9 0-4.3 3.4-8 9.4-8 3 0 5.5 .7 7.1 1.5l0 4.8c-2.3-1.2-4.6-1.9-6.9-1.9-2 0-4 .8-4 3.1 0 5.3 12.6 4.6 12.6 13.9 0 5.2-4.4 8.3-10.4 8.3-3.4 0-6.6-1-8.8-2.5l2.1-4.1zM70.4 411l-8.5 0 0-4.5 23 0-1.5 4.5-7.8 0 0 24.6-5.3 0 0-24.6zm18.5-4.5l5.3 0 0 29.1-5.3 0 0-29.1zm18 4.5l-8.5 0 0-4.5 23 0-1.5 4.5-7.8 0 0 24.6-5.3 0 0-24.6zm19.5 19.4c-.7-1.5-1.1-3.4-1.1-5.7l0-18.2 5.3 0 0 17.9c0 1.5 .3 2.9 .8 3.9 1 2.1 3 3.3 6 3.3s4.9-1.2 6-3.3c.5-1.1 .8-2.4 .8-4l0-17.8 5.3 0 0 18.2c0 2.3-.3 4.2-1.1 5.7-1.8 3.8-5.6 5.6-11 5.6s-9.2-1.9-11-5.7zM162 411l-8.5 0 0-4.5 23 0-1.5 4.5-7.8 0 0 24.6-5.3 0 0-24.6zM207 421a14.7 14.7 0 1 1 -29.3 .1 14.7 14.7 0 1 1 29.3-.1zm-5.7 .1c0-6.5-3.5-10.5-9-10.5s-9 3.8-9 10.5 3.6 10.4 9 10.4 9-3.8 9-10.4zm21-14.6l5.3 0 0 29.1-5.3 0 0-29.1zm18 4.5l-8.5 0 0-4.5 23 0-1.5 4.5-7.8 0 0 24.6-5.3 0 0-24.6zm23.5-4.7l4.2 0 11.7 29.2-5.7 0-2.8-7.3-10.4 0-2.7 7.3-5.5 0 11.3-29.2zm5.8 17.6l-2-5.8c-.8-2.2-1.2-3.5-1.5-4.5l-.1 0c-.3 1-.7 2.3-1.5 4.6l-2.1 5.7 7.2 0zm14.3-17.5l5.3 0 0 24.6 10.3 0 0 4.5-15.6 0 0-29.1zm20 0l5.3 0 0 29.1-5.3 0 0-29.1zm20.6-.1l4.2 0 11.7 29.2-5.7 0-2.8-7.3-10.4 0-2.7 7.3-5.5 0 11.3-29.2zm5.7 17.6l-2-5.8c-.8-2.2-1.2-3.5-1.5-4.5l-.1 0c-.3 1-.7 2.3-1.5 4.6l-2.1 5.7 7.2 0zm35.5 11.6l-12.6-16.6c-1.3-1.6-2.3-3.1-3.3-4.4l-.1 0c.1 1.1 .1 2.8 .1 4.5l0 16.5-5.3 0 0-29.1 5.2 0 12.2 15.9c1.3 1.7 2.3 3.1 3.2 4.5l.1 0c0-1.5-.1-3.3-.1-4.9l0-15.5 5.3 0 0 29.1-4.8 0zM405.9 421a14.7 14.7 0 1 1 -29.3 .1 14.7 14.7 0 1 1 29.3-.1zm-5.7 .1c0-6.5-3.5-10.5-9-10.5s-9 3.8-9 10.5 3.6 10.4 9 10.4 9-3.8 9-10.4zM29.1 459.4l9.1 0c10.3 0 15.9 5.7 15.9 14.3s-6.3 14.7-16.4 14.7l-8.6 0 0-29.1zm8.7 24.6c7.7 0 10.6-4.7 10.6-10.2 0-6.1-3.6-9.9-10.7-9.9l-3.3 0 0 20.1 3.4 0zm22.3-24.6l5.3 0 0 29.1-5.3 0 0-29.1zm27.5 4.5l-8.5 0 0-4.5 23 0-1.5 4.5-7.8 0 0 24.6-5.3 0 0-24.6zm18.5-4.5l16.1 0-1.5 4.5-9.3 0 0 7.6 9.3 0 0 4.5-9.3 0 0 8 10.8 0 0 4.5-16.1 0 0-29.1zm44.3 27.3c-3.2 1.8-6.3 2.3-9.2 2.3-9.5 0-14.7-6.1-14.7-14.7s6-15.1 15.4-15.1c3.2 0 5.8 .6 7.6 1.4l0 4.9c-2.3-1.2-4.7-1.9-7.5-1.9-6.5 0-9.8 4.8-9.8 10.6 0 6.1 3.7 10.3 9.7 10.3 2.9 0 5.1-.8 7.1-2l1.5 4.2zm26.3 1.9L164.1 472c-1.3-1.6-2.3-3.1-3.3-4.4l-.1 0c.1 1.1 .1 2.8 .1 4.5l0 16.5-5.3 0 0-29.1 5.2 0 12.2 15.9c1.3 1.7 2.3 3.1 3.2 4.5l.1 0c0-1.5-.1-3.3-.1-4.9l0-15.5 5.3 0 0 29.1-4.8 0zm10.9-14.4c0-8.8 6.1-14.9 14.7-14.9s14.7 6.1 14.7 14.9-6.2 14.9-14.7 14.9-14.7-6-14.7-14.9zm23.7 0c0-6.5-3.5-10.5-9-10.5s-9 3.8-9 10.5 3.6 10.4 9 10.4 9-3.8 9-10.4zm11.6-14.7l5.3 0 0 24.6 10.3 0 0 4.5-15.6 0 0-29.1zm18 14.7c0-8.8 6.1-14.9 14.7-14.9s14.7 6.1 14.7 14.9-6.2 14.9-14.7 14.9-14.7-6-14.7-14.9zm23.7 0c0-6.5-3.5-10.5-9-10.5s-9 3.8-9 10.5 3.6 10.4 9 10.4 9-3.8 9-10.4zm36 12.5c-2.6 1.3-6.5 2.3-10.6 2.3-9.5 0-15.2-6.1-15.2-14.5 0-8.8 6.3-15.3 16-15.3 3.4 0 6.2 .7 8.4 1.5l0 4.9c-2.3-1.1-4.9-2-8-2-7 0-10.7 4.3-10.7 10.5s3.7 10.4 9.9 10.4c2 0 3.7-.3 4.8-.9l0-9.2 5.3 0 0 12.2zm7-27.2l5.3 0 0 29.1-5.3 0 0-29.1zm20.6-.1l4.2 0 11.7 29.2-5.7 0-2.8-7.3-10.4 0-2.7 7.3-5.5 0 11.3-29.2zm5.7 17.6l-2-5.8c-.8-2.2-1.2-3.5-1.5-4.5l-.1 0c-.3 1-.7 2.3-1.5 4.6l-2.1 5.7 7.2 0z"],
    "iit-t2-pos": [1326,512,[],"e002","M482.7 26.4l-409.2 0c-28.5 0-51.9 23.4-51.9 51.9l0 399.9 461.1 0c28.5 0 51.9-23.4 51.9-51.9l0-348c0-28.5-23.4-51.9-51.9-51.9zm-335 90.4c0 10.4-3.5 19.2-10.6 26.3-7 7.1-15.6 10.6-25.7 10.6s-18.4-3.5-25.6-10.6-10.7-15.8-10.7-26.3 3.5-18.7 10.7-25.8 15.6-10.6 25.6-10.6 18.6 3.5 25.7 10.6c7.1 7.1 10.6 15.7 10.6 25.8zM145.7 422l-68.8 0 0-249.7 68.8 0 0 249.7zM279.2 116.7c0 10.4-3.5 19.2-10.6 26.3s-15.6 10.6-25.7 10.6-18.5-3.5-25.6-10.6c-7.1-7.1-10.7-15.8-10.7-26.3s3.6-18.7 10.7-25.8 15.6-10.6 25.6-10.6 18.6 3.5 25.7 10.6 10.6 15.7 10.6 25.8zM277.3 422l-68.8 0 0-249.7 68.8 0 0 249.7zM479.9 215.5l-65.6 0 0 128c0 13 2.2 22.6 6.5 28.6 4.3 6.1 12.6 9.1 25 9.1 5.9 0 11.6-.5 17-1.4s10.5-2.1 15.1-3.6l0 39.1c-7.3 3-16.4 5.3-27.1 6.7s-21.2 2.2-31.6 2.2c-22.7 0-40.7-7.3-53.9-22-13.2-14.7-19.8-35.8-19.8-63.3l0-123.9-29.5 0 0-35.6 32.2-1.7 23.1-83.1 43.2 0 0 82.7 65.6 0 0 38.2zM603.4 94.4l15.6 0 0 75-15.6 0 0-75zM639 152c4.8 3.2 10.5 5.6 17.1 5.6 5.8 0 11.6-2 11.6-7.7 0-13.6-32.1-11.8-32.1-34.8 0-11.3 9-21.4 25.1-21.4 8 0 14.7 1.8 19 4l0 14c-6.5-3.2-12.5-4.9-18.5-4.9-4.8 0-9 1.7-9 6.9 0 12.7 32.1 10.9 32.1 34.8 0 13.7-11.9 22.1-27.6 22.1-8.8 0-17.5-2.4-23.6-6.8L639 152zm80-44.4l-21.9 0 0-13.2 61.2 0-4.1 13.2-19.7 0 0 61.8-15.6 0 0-61.8zm48.1-13.2l15.6 0 0 75-15.6 0 0-75zm47.6 13.2l-21.9 0 0-13.2 61.2 0-4.1 13.2-19.7 0 0 61.8-15.6 0 0-61.8zm56.5 48.9c-2.2-4.1-3.3-9.3-3.3-15.5l0-46.6 15.6 0 0 45.7c0 3.9 .8 7.3 2.2 9.9 2.6 4.9 7.6 7.5 14.6 7.5s11.8-2.6 14.5-7.5c1.5-2.6 2.2-6 2.2-10l0-45.6 15.6 0 0 46.6c0 6.2-1.1 11.4-3.3 15.5-4.9 9.6-15.1 14-29 14s-24-4.5-28.9-14zm92.6-48.9l-21.9 0 0-13.2 61.2 0-4.1 13.2-19.7 0 0 61.8-15.6 0 0-61.8zM1085.4 132a38.2 38.2 0 1 1 -76.4 0 38.2 38.2 0 1 1 76.4 0zm-16.6 0c0-16.3-8.6-25.4-21.6-25.4s-21.6 9-21.6 25.4 8.8 25.5 21.6 25.5 21.6-9 21.6-25.5zM603.4 220.9l15.6 0 0 75-15.6 0 0-75zm47.6 13.2l-21.9 0 0-13.2 61.2 0-4.1 13.2-19.7 0 0 61.8-15.6 0 0-61.8zm69.2-13.6l12.6 0 30.6 75.3-16.7 0-7.3-18.3-25.5 0-6.9 18.3-16 0 29.2-75.3zM734.7 265l-4.5-12.6c-1.8-5.5-2.7-8.6-3.4-11.1l-.2 0c-.6 2.6-1.7 5.8-3.7 11.3l-4.6 12.5 16.4 0zm38-44.1l15.6 0 0 61.8 26.2 0 0 13.2-41.8 0 0-75zm52.4 0l15.6 0 0 75-15.6 0 0-75zm54.2-.4l12.6 0 30.6 75.3-16.7 0-7.3-18.3-25.5 0-6.9 18.3-16 0 29.2-75.3zM893.9 265l-4.5-12.6c-1.8-5.5-2.7-8.6-3.4-11.1l-.2 0c-.6 2.6-1.7 5.8-3.7 11.3l-4.6 12.5 16.4 0zm92.6 30.8l-31.4-41.1c-2.7-3.6-5.1-7.1-7.7-10.3l-.2 0c.3 2.7 .3 7.4 .3 11l0 40.4-15.6 0 0-75 15.6 0 30.2 39.5c2.9 3.7 5.4 7.1 7.6 10.3l.2 0c-.2-4-.2-9-.2-12.5l0-37.3 15.6 0 0 75-14.3 0zm111-37.3a38.2 38.2 0 1 1 -76.4 0 38.2 38.2 0 1 1 76.4 0zm-16.6 0c0-16.3-8.6-25.4-21.6-25.4s-21.6 9-21.6 25.4 8.8 25.5 21.6 25.5 21.6-9 21.6-25.5zm55.4-37.6l25.3 0c26.4 0 41.4 14.5 41.4 36.9s-17.2 38.1-42.9 38.1l-23.8 0 0-75zm24.1 61.8c18.5 0 25.9-11.3 25.9-24.5 0-15.1-9-24.1-26.3-24.1l-8.2 0 0 48.6 8.5 0zm57-61.8l15.6 0 0 75-15.6 0 0-75zM617.8 360.6l-21.9 0 0-13.2 61.2 0-4.1 13.2-19.7 0 0 61.8-15.6 0 0-61.8zM666 347.4l43.3 0-4.1 13.2-23.7 0 0 17.3 23.8 0 0 13.1-23.8 0 0 18.2 27.6 0 0 13.2-43.2 0 0-75zm119 69.9c-8.8 4.8-17.2 6.2-24.9 6.2-25.1 0-38.6-15.9-38.6-37.9s15.7-39 40.5-39c8.3 0 15.1 1.5 20 3.6l0 14.3c-6-3.2-12.5-4.9-19.7-4.9-16.4 0-24.2 11.9-24.2 25.7 0 14.8 9.2 25.1 23.9 25.1 7.6 0 13.2-2.3 18.7-5.5l4.3 12.3zm66.9 5l-31.4-41.1c-2.7-3.6-5.1-7.1-7.7-10.3l-.2 0c.3 2.7 .3 7.4 .3 11l0 40.4-15.6 0 0-75 15.6 0 30.2 39.5c2.9 3.7 5.4 7.1 7.6 10.3l.2 0c-.2-4-.2-9-.2-12.5l0-37.3 15.6 0 0 75-14.3 0zm111-37.3a38.2 38.2 0 1 1 -76.4 0 38.2 38.2 0 1 1 76.4 0zm-16.6 0c0-16.3-8.6-25.4-21.6-25.4s-21.6 9-21.6 25.4 8.8 25.5 21.6 25.5 21.6-9 21.6-25.5zm31.2-37.6l15.6 0 0 61.8 26.2 0 0 13.2-41.8 0 0-75zM1103.4 385a38.2 38.2 0 1 1 -76.4 0 38.2 38.2 0 1 1 76.4 0zm-16.6 0c0-16.3-8.6-25.4-21.6-25.4s-21.6 9-21.6 25.4 8.8 25.5 21.6 25.5 21.6-9 21.6-25.5zm96.3 32.3c-7.4 3.7-17.6 6.2-28.1 6.2-25.4 0-39.9-15.8-39.9-37.2 0-22.7 16.5-39.7 42-39.7 8.9 0 16 1.6 22.3 3.6l0 14.5c-6.2-2.9-12.9-5-21-5-17.5 0-26.6 10.6-26.6 25.7s8.8 25.1 24.2 25.1c4.7 0 8.9-.8 11.6-1.9l0-23 15.6 0 0 31.8zm16.9-69.9l15.6 0 0 75-15.6 0 0-75zm54.2-.4l12.6 0 30.6 75.3-16.7 0-7.3-18.3-25.5 0-6.9 18.3-16 0 29.2-75.3zm14.6 44.5l-4.5-12.6c-1.8-5.5-2.7-8.6-3.4-11.1l-.2 0c-.6 2.6-1.7 5.8-3.7 11.3l-4.6 12.5 16.4 0z"]

  };
  var prefixes = [null    ,'fak',
    ,'fa-kit'
];
  bunker(function () {
    for (var _i = 0, _prefixes = prefixes; _i < _prefixes.length; _i++) {
      var prefix = _prefixes[_i];
      if (!prefix) continue;
      defineIcons(prefix, icons);
    }
  });

}());
