import { defineComponent as m, openBlock as n, createElementBlock as l, normalizeClass as S, createElementVNode as r, renderSlot as y, createCommentVNode as v, computed as L, unref as c, withModifiers as P, Fragment as x, renderList as V, toDisplayString as M, ref as A, useSlots as F, watch as te, withKeys as G, createBlock as N, withCtx as T, createVNode as C, getCurrentInstance as H, resolveComponent as B, Teleport as re, createTextVNode as E, normalizeStyle as oe, inject as ue, withDirectives as ie, vShow as ce, provide as de, isRef as pe, createSlots as _e } from "vue";
const fe = ["src"], ye = {
  key: 0,
  class: "iconed"
}, ge = /* @__PURE__ */ m({
  __name: "UpAvatar",
  props: {
    url: String,
    size: {
      type: String,
      default: "m",
      validator: (e) => ["xxl", "xl", "l", "m", "s", "xs", "xxs"].indexOf(e) !== -1
    }
  },
  emits: ["click"],
  setup(e) {
    return (o, t) => (n(), l("div", {
      class: S(["up-avatar relative", `up-avatar-${e.size}`]),
      onClick: t[0] || (t[0] = (s) => o.$emit("click", s))
    }, [
      r("img", {
        src: e.url,
        alt: "User avatar",
        class: ""
      }, null, 8, fe),
      o.$slots.default ? (n(), l("div", ye, [
        y(o.$slots, "default")
      ])) : v("", !0)
    ], 2));
  }
}), me = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: ge
}, Symbol.toStringTag, { value: "Module" })), be = /* @__PURE__ */ m({
  __name: "UpBadge",
  props: {
    styl: {
      type: String,
      default: "primary",
      validator: (e) => ["primary", "secondary", "error", "info", "success", "warning"].indexOf(e) >= 0
    }
  },
  setup(e) {
    const o = e, t = L(() => {
      const s = [];
      return s.push("up-badge"), s.push(`up-badge-${o.styl}`), s.join(" ");
    });
    return (s, a) => (n(), l("div", {
      class: S(c(t))
    }, [
      y(s.$slots, "default")
    ], 2));
  }
}), ve = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: be
}, Symbol.toStringTag, { value: "Module" })), Me = ["disabled"], O = /* @__PURE__ */ m({
  __name: "UpButton",
  props: {
    disabled: { type: Boolean, default: !1 },
    append: { type: Boolean, default: !1 },
    prepend: { type: Boolean, default: !1 },
    shape: {
      type: String,
      default: "",
      validator: (e) => ["", "default", "outline", "free"].indexOf(e) >= 0
    },
    styl: {
      type: String,
      default: "primary",
      validator: (e) => ["primary", "secondary", "error", "info", "success", "warning"].indexOf(e) >= 0
    }
  },
  emits: ["click"],
  setup(e, { emit: o }) {
    const t = e, s = L(() => {
      const a = [];
      return a.push("up-btn"), t.append && a.push("up-append"), t.prepend && a.push("up-prepend"), t.shape === "free" ? a.push("free") : t.shape === "outline" && a.push("outlined"), t.disabled && a.push("disabled"), a.push(`btn-${t.styl}`), a.join(" ");
    });
    return (a, u) => (n(), l("button", {
      disabled: t.disabled,
      class: S(c(s)),
      onClick: u[0] || (u[0] = P((i) => a.$emit("click", i), ["prevent"]))
    }, [
      y(a.$slots, "default"),
      y(a.$slots, "menu")
    ], 10, Me));
  }
}), he = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: O
}, Symbol.toStringTag, { value: "Module" })), Le = { class: "up-card" }, je = {
  key: 0,
  class: "card-header"
}, Ce = { class: "card-content" }, Se = {
  key: 1,
  class: "card-footer"
}, Te = /* @__PURE__ */ m({
  __name: "UpCard",
  setup(e) {
    return (o, t) => (n(), l("div", Le, [
      o.$slots.header ? (n(), l("div", je, [
        y(o.$slots, "header")
      ])) : v("", !0),
      r("div", Ce, [
        y(o.$slots, "default")
      ]),
      o.$slots.footer ? (n(), l("div", Se, [
        y(o.$slots, "footer")
      ])) : v("", !0)
    ]));
  }
}), ke = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: Te
}, Symbol.toStringTag, { value: "Module" }));
var W, we = new Uint8Array(16);
function $e() {
  if (!W && (W = typeof crypto < "u" && crypto.getRandomValues && crypto.getRandomValues.bind(crypto) || typeof msCrypto < "u" && typeof msCrypto.getRandomValues == "function" && msCrypto.getRandomValues.bind(msCrypto), !W))
    throw new Error("crypto.getRandomValues() not supported. See https://github.com/uuidjs/uuid#getrandomvalues-not-supported");
  return W(we);
}
const xe = /^(?:[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}|00000000-0000-0000-0000-000000000000)$/i;
function Ne(e) {
  return typeof e == "string" && xe.test(e);
}
var w = [];
for (var Z = 0; Z < 256; ++Z)
  w.push((Z + 256).toString(16).substr(1));
function Oe(e) {
  var o = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : 0, t = (w[e[o + 0]] + w[e[o + 1]] + w[e[o + 2]] + w[e[o + 3]] + "-" + w[e[o + 4]] + w[e[o + 5]] + "-" + w[e[o + 6]] + w[e[o + 7]] + "-" + w[e[o + 8]] + w[e[o + 9]] + "-" + w[e[o + 10]] + w[e[o + 11]] + w[e[o + 12]] + w[e[o + 13]] + w[e[o + 14]] + w[e[o + 15]]).toLowerCase();
  if (!Ne(t))
    throw TypeError("Stringified UUID is invalid");
  return t;
}
function ze(e, o, t) {
  e = e || {};
  var s = e.random || (e.rng || $e)();
  if (s[6] = s[6] & 15 | 64, s[8] = s[8] & 63 | 128, o) {
    t = t || 0;
    for (var a = 0; a < 16; ++a)
      o[t + a] = s[a];
    return o;
  }
  return Oe(s);
}
const Y = () => {
  const e = L(() => ze()), o = {
    label: {
      type: String,
      default: ""
    },
    disabled: {
      type: Boolean,
      default: !1
    },
    readonly: {
      type: Boolean,
      default: !1
    },
    placeholder: {
      type: String,
      default: ""
    },
    errors: {
      type: Array,
      default: []
    }
  };
  return {
    id: e.value,
    oProps: o
  };
}, Pe = { class: "up-checkbox-wrapper" }, Ue = { class: "up-checkbox" }, Ie = ["id", "checked", "disabled"], De = ["for"], Ee = { class: "up-input-error" }, X = /* @__PURE__ */ m({
  __name: "UpCheckbox",
  props: {
    ...Y().oProps,
    modelValue: Boolean
  },
  emits: ["update:modelValue", "change"],
  setup(e, { emit: o }) {
    const t = (a) => {
      o("update:modelValue", a.target.checked), o("change", a.target.checked);
    }, s = L(() => Y().id);
    return (a, u) => (n(), l("div", Pe, [
      r("div", Ue, [
        r("input", {
          id: c(s),
          type: "checkbox",
          class: "h-5 w-5 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500",
          checked: e.modelValue,
          onChange: t,
          disabled: a.disabled
        }, null, 40, Ie),
        r("label", {
          for: c(s),
          class: "min-w-0 flex-1 text-sm font-medium text-gray-700"
        }, [
          y(a.$slots, "default")
        ], 8, De)
      ]),
      (n(!0), l(x, null, V(a.errors, (i) => (n(), l("div", Ee, M(i), 1))), 256))
    ]));
  }
}), Ve = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: X
}, Symbol.toStringTag, { value: "Module" })), Q = () => ({
  oProps: {
    ...Y().oProps,
    modelValue: String,
    type: {
      type: String,
      default: "text",
      validator: (o) => ["", "text", "number", "email", "password"].findIndex((t) => t === o.toLowerCase())
    },
    clearable: {
      type: Boolean,
      default: !1
    },
    asTextarea: {
      type: Boolean,
      default: !1
    },
    asSelfFormed: {
      type: Boolean,
      default: !1
    }
  },
  id: Y().id
}), Ye = { class: "up-component-group" }, q = /* @__PURE__ */ m({
  __name: "UpComponentGroup",
  setup(e) {
    return (o, t) => (n(), l("div", Ye, [
      y(o.$slots, "default")
    ]));
  }
}), Ae = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: q
}, Symbol.toStringTag, { value: "Module" })), Be = { class: "flex justify-between" }, Fe = ["for"], Qe = { class: "additional-text text-right" }, Re = ["id", "placeholder", "type", "value", "disabled", "readonly", "onKeyup", "onChange", "onInput"], He = ["id", "placeholder", "value", "disabled", "readonly", "onKeyup", "onChange", "onInput", "rows"], Ke = /* @__PURE__ */ r("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 320 512",
  fill: "currentColor"
}, [
  /* @__PURE__ */ r("path", { d: "M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" })
], -1), Je = /* @__PURE__ */ r("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 512 512",
  fill: "currentColor"
}, [
  /* @__PURE__ */ r("path", { d: "M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" })
], -1), We = /* @__PURE__ */ r("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 512 512",
  fill: "currentColor"
}, [
  /* @__PURE__ */ r("path", { d: "M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" })
], -1), Ge = /* @__PURE__ */ r("svg", {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 448 512",
  fill: "currentColor"
}, [
  /* @__PURE__ */ r("path", { d: "M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z" })
], -1), Ze = { class: "up-input-error" }, ee = /* @__PURE__ */ m({
  __name: "UpTextbox",
  props: {
    ...Q().oProps,
    textareaRows: { type: [String, Number], default: 3 }
  },
  emits: ["update:modelValue", "change", "clear", "keyup", "input", "submit", "cancel"],
  setup(e, { emit: o }) {
    const t = e, s = A(t.modelValue), a = A(), u = A(!1), i = (_) => {
      t.asSelfFormed || o("keyup", _);
    }, p = (_) => {
      t.asSelfFormed ? K() : o("keyup", _);
    }, f = (_) => {
      t.asSelfFormed ? I() : o("keyup", _);
    }, b = (_) => {
      o("change", _);
    }, h = (_) => {
      let D = s.value;
      o("update:modelValue", ""), o("clear", D), s.value = "";
    }, g = (_) => {
      s.value = _.target.value, t.asSelfFormed || o("update:modelValue", _.target.value), o("input", _);
    }, d = L(() => {
      const _ = [];
      return _.push("up-textbox__input"), _.push(`up-textbox__input-${t.type}`), t.clearable && _.push("up-textbox__input-clearable"), _.join(" ");
    }), z = L(() => {
      const _ = [];
      return _.push("up-textbox up-textbox__container"), t.disabled && _.push("disabled"), t.asSelfFormed && (_.push("self-formed"), u.value && _.push("self-formed-edit")), _.join(" ");
    }), k = L(() => !!F().append), $ = L(() => !!(t.clearable || t.asSelfFormed || k.value)), U = L(() => !!(t.disabled || t.asSelfFormed && !u.value)), j = () => {
      u.value = !0, setTimeout(() => {
        a.value.focus();
      }, 10);
    }, I = () => {
      o("update:modelValue", s.value), o("submit", s.value), t.asSelfFormed && (u.value = !1);
    }, K = () => {
      s.value = t.modelValue, o("cancel"), t.asSelfFormed && (u.value = !1);
    };
    return te(() => t.modelValue, (_, D) => {
      _ !== D && (s.value = _);
    }), (_, D) => (n(), l("div", {
      class: S(c(z))
    }, [
      r("div", Be, [
        _.label ? (n(), l("label", {
          key: 0,
          for: c(Q)().id,
          class: "up-textbox__label"
        }, M(t.label), 9, Fe)) : v("", !0),
        r("div", Qe, [
          y(_.$slots, "additional-text")
        ])
      ]),
      r("div", {
        class: S(["up-textbox__input_container", { "up-component-group": c($) }])
      }, [
        _.asTextarea ? (n(), l("textarea", {
          key: 1,
          ref_key: "refInput",
          ref: a,
          id: c(Q)().id,
          placeholder: _.placeholder,
          class: S(c(d)),
          value: s.value,
          disabled: c(U),
          readonly: _.readonly,
          onKeyup: [
            P(i, ["prevent"]),
            G(p, ["esc"])
          ],
          onChange: P(b, ["prevent"]),
          onInput: P(g, ["prevent"]),
          rows: e.textareaRows
        }, `
        `, 42, He)) : (n(), l("input", {
          key: 0,
          ref_key: "refInput",
          ref: a,
          id: c(Q)().id,
          placeholder: _.placeholder,
          class: S(c(d)),
          type: _.type,
          value: s.value,
          disabled: c(U),
          readonly: _.readonly,
          onKeyup: [
            P(i, ["prevent"]),
            G(p, ["esc"]),
            G(f, ["enter"])
          ],
          onChange: P(b, ["prevent"]),
          onInput: P(g, ["prevent"])
        }, null, 42, Re)),
        c(k) || _.clearable || _.asSelfFormed ? (n(), N(q, {
          key: 2,
          class: "up-append"
        }, {
          default: T(() => [
            _.clearable ? (n(), N(O, {
              key: 0,
              disabled: c(U),
              onClick: h
            }, {
              default: T(() => [
                Ke
              ]),
              _: 1
            }, 8, ["disabled"])) : v("", !0),
            _.asSelfFormed && !_.readonly ? (n(), l(x, { key: 1 }, [
              u.value ? (n(), l(x, { key: 1 }, [
                C(O, {
                  onClick: D[1] || (D[1] = (J) => I())
                }, {
                  default: T(() => [
                    We
                  ]),
                  _: 1
                }),
                C(O, {
                  onClick: D[2] || (D[2] = (J) => K())
                }, {
                  default: T(() => [
                    Ge
                  ]),
                  _: 1
                })
              ], 64)) : (n(), N(O, {
                key: 0,
                onClick: D[0] || (D[0] = (J) => j()),
                class: "radius-tl-5"
              }, {
                default: T(() => [
                  Je
                ]),
                _: 1
              }))
            ], 64)) : v("", !0),
            c(k) ? y(_.$slots, "append", { key: 2 }) : v("", !0)
          ]),
          _: 3
        })) : v("", !0)
      ], 2),
      _.errors.length > 0 ? (n(!0), l(x, { key: 0 }, V(_.errors, (J) => (n(), l("div", Ze, M(J), 1))), 256)) : v("", !0)
    ], 2));
  }
}), Xe = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: ee
}, Symbol.toStringTag, { value: "Module" })), qe = ["for"], et = ["id"], tt = ["value"], ot = { class: "dropdown-content" }, nt = {
  key: 0,
  class: "search-box"
}, st = { class: "option-list" }, lt = ["data-key", "onClick"], at = /* @__PURE__ */ m({
  __name: "UpDropdown",
  props: {
    ...Y().oProps,
    list: Array,
    keyField: { type: String, default: "id" },
    valueField: { type: String, default: "value" },
    modelValue: [String, Number],
    searchable: { type: Boolean, default: !1 }
  },
  emits: ["onSearch", "update:modelValue", "change"],
  setup(e, { emit: o }) {
    const t = e, s = A("");
    te(() => s.value, (p, f) => {
      p !== f && o("onSearch", p);
    });
    const a = (p) => {
      o("update:modelValue", p[t.keyField]), o("change", p[t.keyField]);
    }, u = L(() => {
      var f;
      const p = (f = t.list) == null ? void 0 : f.find((b) => b[t.keyField] == t.modelValue);
      return p ? p[t.valueField] : t.placeholder || "";
    }), i = L(() => {
      const p = [];
      return p.push("up-dropdown"), t.disabled && p.push("disabled"), p.join(" ");
    });
    return (p, f) => (n(), l("div", {
      class: S(c(i))
    }, [
      p.label ? (n(), l("label", {
        key: 0,
        for: c(Y)().id,
        class: "up-textbox__label"
      }, M(t.label), 9, qe)) : v("", !0),
      r("div", {
        class: "up-dropdown__container",
        id: c(Y)().id
      }, [
        r("button", {
          class: "select",
          value: c(u)
        }, M(c(u)), 9, tt),
        r("div", ot, [
          e.searchable ? (n(), l("div", nt, [
            C(ee, {
              modelValue: s.value,
              "onUpdate:modelValue": f[0] || (f[0] = (b) => s.value = b)
            }, null, 8, ["modelValue"])
          ])) : v("", !0),
          r("ul", st, [
            (n(!0), l(x, null, V(e.list, (b) => (n(), l("li", {
              key: b[e.keyField],
              class: "option-list__item",
              "data-key": b[e.keyField],
              onClick: (h) => a(b)
            }, M(b[e.valueField]), 9, lt))), 128))
          ])
        ])
      ], 8, et)
    ], 2));
  }
}), rt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: at
}, Symbol.toStringTag, { value: "Module" })), ut = { class: "up-footer" }, it = /* @__PURE__ */ m({
  __name: "UpFooter",
  setup(e) {
    return (o, t) => (n(), l("div", ut, [
      y(o.$slots, "default")
    ]));
  }
}), ct = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: it
}, Symbol.toStringTag, { value: "Module" })), dt = /* @__PURE__ */ m({
  __name: "UpCell",
  props: {
    size: {
      type: [String, Number],
      default: "auto",
      validator: (e) => isNaN(e) ? e === "auto" : +e > 0 && +e <= 12
    }
  },
  setup(e) {
    return (o, t) => (n(), l("div", {
      class: S(["up-cell", `up-cell-${e.size}`])
    }, [
      y(o.$slots, "default")
    ], 2));
  }
}), pt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: dt
}, Symbol.toStringTag, { value: "Module" })), _t = /* @__PURE__ */ m({
  __name: "UpRow",
  props: {
    css: { type: String, default: "" }
  },
  setup(e) {
    return (o, t) => (n(), l("div", {
      class: S(["up-row", e.css])
    }, [
      y(o.$slots, "default")
    ], 2));
  }
}), ft = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: _t
}, Symbol.toStringTag, { value: "Module" })), yt = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+Cgkuc3Qwe2ZpbGw6I0U2QzgyQjt9Cjwvc3R5bGU+CjxnPgoJPHBhdGggZD0iTTE0Ny40LDM3MC42Yy0xLjgsMC4yLTMuNywwLjMtNS42LDAuNGMtMC4xLDAtMC4zLDAtMC40LDBjLTEuMywwLjEtMi42LDAuMi0zLjksMC4yYy0wLjQsMC0wLjcsMC0xLDAKCQljLTE1LjQsMC4xLTI4LjktMy4xLTM4LjktMTAuNGMtMy44LTIuNS03LjQtNS4zLTEwLjYtOC43Yy02LjEtNi40LTEwLjgtMTQuNC0xNC4xLTI0LjJjLTMuMy05LjctNC45LTIxLjItNC45LTM0LjVWOTUuOQoJCWMwLTEuNy0wLjYtMy4zLTEuNy00LjdjLTEuMS0xLjQtMy0yLjUtNS42LTMuNGMtMi42LTAuOS02LTEuNS0xMC4zLTIuMWMtNC4zLTAuNS05LjctMC44LTE2LjMtMC44Yy02LjcsMC0xMi4yLDAuMy0xNi41LDAuOAoJCWMtNC4zLDAuNS03LjgsMS4yLTEwLjUsMi4xYy0yLjcsMC45LTQuNSwyLTUuNiwzLjRjLTEsMS40LTEuNiwyLjktMS42LDQuN3YyMDMuNGMwLDIxLjQsMy4xLDQwLDkuMiw1NgoJCWM2LjEsMTUuOSwxNC45LDI5LjMsMjYuNSwzOS45YzExLjUsMTAuNywyNS43LDE4LjcsNDIuNCwyMy45YzE2LjcsNS4zLDM1LjYsNy45LDU2LjYsNy45YzIyLjQsMCw0Mi4yLTIuOSw1OS41LTguOAoJCWMxNy4yLTUuOSwzMS43LTE0LjQsNDMuNC0yNS42YzExLjctMTEuMiwyMC42LTI0LjksMjYuNi00MS4xYzMuNy0xMC4xLDYuMy0yMC45LDcuNy0zMi43Yy03LDQuNi0xMy44LDkuMS0yMC42LDEzLjUKCQlDMjIwLjMsMzUxLjgsMTgwLjgsMzY3LjUsMTQ3LjQsMzcwLjZ6Ii8+Cgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMjY2LjIsODcuOWMtMi42LTAuOS02LTEuNS0xMC4yLTIuMWMtNC4yLTAuNS05LjYtMC44LTE2LjItMC44Yy02LjYsMC0xMiwwLjMtMTYuNCwwLjgKCQljLTQuNCwwLjUtNy45LDEuMi0xMC41LDIuMWMtMi42LDAuOS00LjQsMi01LjQsMy40Yy0xLDEuNC0xLjUsMi45LTEuNSw0Ljd2MjAxLjRjMCwxMS43LTEuNiwyMi4yLTQuOCwzMS40CgkJYy0wLjYsMS43LTEuMywzLjMtMS45LDQuOWMyNC4xLTEzLjEsNDguOS0zNC4xLDczLjktNTkuN1Y5NS45YzAtMS43LTAuNS0zLjMtMS41LTQuN0MyNzAuNiw4OS44LDI2OC44LDg4LjcsMjY2LjIsODcuOXoiLz4KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0zMDIuMiwxNTguOWMtMS4zLTEtMS45LTIuNy0xLjYtNC40YzAuMy0xLjcsMS41LTMuMSwzLjItMy42bDE1My42LTUxLjNjMC4xLDAsMC4zLTAuMSwwLjUtMC4xCgkJYy04LjMtMy44LTE2LjUtNi42LTI0LjctOC4yYy0xMC0yLTE4LjYtMy4zLTI1LjctMy45Yy03LjItMC42LTE0LjctMC45LTIyLjYtMC45SDMwNmMtNi45LDAtMTIuNSwyLTE2LjcsNi4xCgkJYy00LjIsNC4xLTYuMywxMC4xLTYuMywxOC4ydjE1Mi43YzIwLjEtMjEuNCw0MC40LTQ1LjYsNjAuNi03MC44TDMwMi4yLDE1OC45eiIvPgoJPHBhdGggZD0iTTUwNi4zLDE1MS4zYy0zLjgtMTAuOS05LjMtMjAuNS0xNi41LTI4LjdjLTcuMi04LjItMTYtMTQuOS0yNi4yLTIwLjNjLTAuMi0wLjEtMC41LTAuMi0wLjctMC40YzAuMywwLjcsMC41LDEuNSwwLjQsMi4zCgkJbC0xNC45LDE2MS4yYy0wLjIsMS43LTEuMiwzLjItMi44LDMuOWMtMS41LDAuNy0zLjMsMC41LTQuNi0wLjVsLTQyLjQtMzcuNEMzNjYuNiwyNTYsMzI0LDI4NC42LDI4MywzMTEuNnYxMDAuMgoJCWMwLDEuNywwLjUsMy4zLDEuNSw0LjdjMSwxLjQsMi44LDIuNSw1LjQsMy40YzIuNiwwLjksNi4xLDEuNSwxMC41LDIuMWM0LjQsMC41LDkuOSwwLjgsMTYuNCwwLjhjNi43LDAsMTIuMi0wLjMsMTYuNS0wLjgKCQljNC4zLTAuNSw3LjgtMS4yLDEwLjMtMi4xYzIuNi0wLjksNC40LTIsNS42LTMuNGMxLjEtMS40LDEuNy0yLjksMS43LTQuN1YzMDVoMjcuOWMyMi4xLDAsNDEuMi0yLjYsNTcuNS03LjgKCQljMTYuMy01LjIsMzAtMTIuNyw0MS4yLTIyLjZjMTEuMi05LjksMTkuNy0yMi4xLDI1LjYtMzYuNmM1LjktMTQuNSw4LjgtMzEuMSw4LjgtNDkuOUM1MTIsMTc0LjUsNTEwLjEsMTYyLjMsNTA2LjMsMTUxLjN6Ii8+CjwvZz4KPC9zdmc+Cg==", gt = ["src"], mt = /* @__PURE__ */ m({
  __name: "UpLogo",
  props: {
    size: {
      type: String,
      default: "m",
      validator: (e) => ["xl", "l", "m", "s", "xs"].indexOf(e) !== -1
    }
  },
  emits: ["click"],
  setup(e, { emit: o }) {
    return (t, s) => (n(), l("img", {
      class: S(["up-logo", `up-logo-${e.size}`]),
      alt: "Logo",
      src: c(yt),
      onClick: s[0] || (s[0] = (a) => t.$emit("click", a))
    }, null, 10, gt));
  }
}), bt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: mt
}, Symbol.toStringTag, { value: "Module" })), vt = /* @__PURE__ */ m({
  __name: "UpMenu",
  props: {
    direction: {
      type: String,
      default: "ld",
      validator: (e) => ["ld", "rd", "lu", "ru"].indexOf(e) !== -1
    }
  },
  setup(e) {
    return (o, t) => (n(), l("ul", {
      class: S(["up-menu", e.direction])
    }, [
      y(o.$slots, "default")
    ], 2));
  }
}), Mt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: vt
}, Symbol.toStringTag, { value: "Module" })), ht = /* @__PURE__ */ m({
  __name: "UpMenuItem",
  props: {
    to: [String, Object]
  },
  emits: ["click"],
  setup(e, { emit: o }) {
    var p, f;
    const t = e;
    F();
    const s = A(!1), a = !!((p = H()) != null && p.appContext.config.globalProperties.$router);
    let u = (f = H()) == null ? void 0 : f.appContext.config.globalProperties.$router;
    const i = (b) => {
      t.to && a ? u.push(t.to) : o("click", b), b.target.parentElement.parentElement.blur();
    };
    return (b, h) => (n(), l("li", {
      class: S(["up-menu-item", { expanded: s.value }]),
      onClick: i
    }, [
      y(b.$slots, "default")
    ], 2));
  }
}), Lt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: ht
}, Symbol.toStringTag, { value: "Module" })), jt = { class: "up-menu-separator" }, Ct = /* @__PURE__ */ m({
  __name: "UpMenuSeparator",
  setup(e) {
    return (o, t) => (n(), l("hr", jt));
  }
}), St = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: Ct
}, Symbol.toStringTag, { value: "Module" })), Tt = {
  key: 0,
  class: "icon"
}, kt = {
  key: 1,
  class: "icon"
}, wt = {
  key: 2,
  class: "icon"
}, $t = {
  key: 3,
  class: "icon"
}, xt = /* @__PURE__ */ m({
  __name: "UpMessage",
  props: {
    type: {
      type: String,
      default: "",
      validator: (e) => ["normal", "error", "success", "warning", "info", ""].indexOf(e) > -1
    }
  },
  setup(e) {
    return (o, t) => {
      const s = B("fa");
      return n(), l("div", {
        class: S(["up-message", `up-message-${e.type ? e.type : "normal"}`])
      }, [
        e.type === "error" ? (n(), l("span", Tt, [
          C(s, { icon: "circle-xmark" })
        ])) : v("", !0),
        e.type === "success" ? (n(), l("span", kt, [
          C(s, { icon: "circle-check" })
        ])) : v("", !0),
        e.type === "warning" ? (n(), l("span", wt, [
          C(s, { icon: "triangle-exclamation" })
        ])) : v("", !0),
        e.type === "info" ? (n(), l("span", $t, [
          C(s, { icon: "circle-exclamation" })
        ])) : v("", !0),
        r("p", null, [
          y(o.$slots, "default")
        ])
      ], 2);
    };
  }
}), Nt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: xt
}, Symbol.toStringTag, { value: "Module" })), Ot = /* @__PURE__ */ r("div", { class: "up-process-overlay" }, [
  /* @__PURE__ */ r("div", { class: "spinner" })
], -1), ne = /* @__PURE__ */ m({
  __name: "UpProcess",
  props: {
    processing: { type: Boolean, default: !1 }
  },
  setup(e) {
    return (o, t) => (n(), l("div", {
      class: S(["up-process", { processing: e.processing }])
    }, [
      y(o.$slots, "default"),
      Ot
    ], 2));
  }
}), zt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: ne
}, Symbol.toStringTag, { value: "Module" })), Pt = ["onClick"], Ut = { class: "modal-dialog__header" }, It = { class: "title" }, Dt = { class: "modal-dialog__content" }, Et = {
  key: 0,
  class: "modal-dialog__footer"
}, se = /* @__PURE__ */ m({
  __name: "UpModal",
  props: {
    title: String,
    show: { type: Boolean, default: !1 },
    teleport: { type: String, default: "body" },
    processing: { type: Boolean, default: !1 }
  },
  emits: ["close"],
  setup(e, { emit: o }) {
    const t = e, s = F(), a = L(() => !!s.footer), u = () => {
      t.processing || o("close");
    };
    return (i, p) => {
      const f = B("fa");
      return e.show ? (n(), N(re, {
        key: 0,
        to: e.teleport
      }, [
        e.show ? (n(), l("div", {
          key: 0,
          class: "modal-dialog",
          onClick: P(u, ["stop", "prevent"])
        }, [
          C(ne, { processing: e.processing }, {
            default: T(() => [
              r("div", {
                class: "modal-dialog__container",
                onClick: p[0] || (p[0] = P(() => {
                }, ["stop"]))
              }, [
                r("div", Ut, [
                  r("h5", It, M(e.title), 1),
                  C(O, {
                    type: "icon",
                    shape: "free",
                    onClick: u
                  }, {
                    default: T(() => [
                      C(f, { icon: "times" })
                    ]),
                    _: 1
                  })
                ]),
                r("div", Dt, [
                  y(i.$slots, "default")
                ]),
                c(a) ? (n(), l("div", Et, [
                  y(i.$slots, "footer")
                ])) : v("", !0)
              ])
            ]),
            _: 3
          }, 8, ["processing"])
        ], 8, Pt)) : v("", !0)
      ], 8, ["to"])) : v("", !0);
    };
  }
}), Vt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: se
}, Symbol.toStringTag, { value: "Module" })), Yt = { key: 0 }, At = /* @__PURE__ */ E("?"), Bt = { class: "flex flex-end gap-s" }, Ft = {
  __name: "UpDeleteConfirmation",
  props: {
    model: { type: Object },
    modelValue: { type: Boolean, default: !1 },
    title: { type: String, default: "Delete item?" },
    valueField: { type: [String, Array], default: "name" },
    valueJoiner: { type: String, default: " " },
    deleteButtonText: { type: String, default: "Delete" },
    cancelButtonText: { type: String, default: "Cancel" },
    identField: { type: String, default: "id" },
    beforeItemText: { type: String, default: "Delete item" },
    batchText: { type: String, default: "Delete selected items" },
    batch: { type: Boolean, default: !1 },
    processing: { type: Boolean, default: !1 }
  },
  emits: ["confirm", "update:modelValue"],
  setup(e, { emit: o }) {
    const t = e, s = L({
      get() {
        return t.modelValue;
      },
      set(p) {
        o("update:modelValue", p);
      }
    }), a = L(() => {
      if (t.model === null)
        return "";
      if (Array.isArray(t.valueField)) {
        const p = [];
        return t.valueField.map((f) => {
          p.push(t.model[f]);
        }), p.join(t.valueJoiner);
      } else
        return t.model[t.valueField];
    }), u = () => {
      s.value = !1, o("confirm", t.batch ? null : t.model[t.identField]);
    }, i = L(() => t.batch ? t.batchText : t.beforeItemText);
    return (p, f) => (n(), N(se, {
      title: e.title,
      show: c(s),
      onClose: f[1] || (f[1] = (b) => s.value = !1),
      processing: e.processing
    }, {
      footer: T(() => [
        r("div", Bt, [
          C(O, {
            styl: "primary",
            onClick: u
          }, {
            default: T(() => [
              E(M(e.deleteButtonText), 1)
            ]),
            _: 1
          }),
          C(O, {
            outline: !0,
            onClick: f[0] || (f[0] = (b) => s.value = !1)
          }, {
            default: T(() => [
              E(M(e.cancelButtonText), 1)
            ]),
            _: 1
          })
        ])
      ]),
      default: T(() => [
        r("span", null, [
          E(M(c(i)) + " ", 1),
          e.batch ? v("", !0) : (n(), l("strong", Yt, M(c(a)), 1)),
          At
        ])
      ]),
      _: 1
    }, 8, ["title", "show", "processing"]));
  }
}, Qt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: Ft
}, Symbol.toStringTag, { value: "Module" })), Rt = { class: "up-nav-container" }, Ht = {
  key: 0,
  class: "up-nav-container__title"
}, Kt = /* @__PURE__ */ m({
  __name: "UpNavContainer",
  props: {
    title: {
      type: String,
      default: ""
    }
  },
  setup(e) {
    return (o, t) => (n(), l("ul", Rt, [
      e.title !== "" ? (n(), l("li", Ht, M(e.title), 1)) : v("", !0),
      y(o.$slots, "default")
    ]));
  }
}), Jt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: Kt
}, Symbol.toStringTag, { value: "Module" })), Wt = {
  key: 0,
  class: "submenu"
}, Gt = /* @__PURE__ */ m({
  __name: "UpNavItem",
  props: {
    title: String,
    to: String
  },
  emits: ["click"],
  setup(e, { emit: o }) {
    var f, b;
    const t = e, s = F(), a = !!((f = H()) != null && f.appContext.config.globalProperties.$router);
    let u = (b = H()) == null ? void 0 : b.appContext.config.globalProperties.$router;
    const i = A(!1), p = (h) => {
      s.default ? i.value = !i.value : t.to && a ? u.push(t.to) : o("click", h);
    };
    return (h, g) => {
      const d = B("fa");
      return n(), l("li", {
        class: S(["up-nav-item", {
          "up-expandable": !!h.$slots.default,
          expanded: i.value
        }])
      }, [
        r("div", {
          class: "title",
          onClick: p
        }, [
          r("span", null, M(e.title), 1),
          h.$slots.default ? (n(), l(x, { key: 0 }, [
            i.value ? (n(), N(d, {
              key: 0,
              icon: "fa-angle-down"
            })) : (n(), N(d, {
              key: 1,
              icon: "fa-angle-right"
            }))
          ], 64)) : v("", !0)
        ]),
        h.$slots.default ? (n(), l("ul", Wt, [
          y(h.$slots, "default")
        ])) : v("", !0)
      ], 2);
    };
  }
}), Zt = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: Gt
}, Symbol.toStringTag, { value: "Module" })), Xt = { class: "up-vertical-navbar" }, qt = { class: "header" }, eo = { class: "nav-wrapper" }, to = { class: "footer" }, oo = /* @__PURE__ */ m({
  __name: "UpVerticalNavbar",
  setup(e) {
    return (o, t) => (n(), l("div", Xt, [
      r("div", qt, [
        y(o.$slots, "header")
      ]),
      r("div", eo, [
        y(o.$slots, "default")
      ]),
      r("div", to, [
        y(o.$slots, "footer")
      ])
    ]));
  }
}), no = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: oo
}, Symbol.toStringTag, { value: "Module" })), so = { class: "flex justify-between gap-m items-top" }, lo = { class: "p-2" }, ao = /* @__PURE__ */ E("\xD7 "), ro = { class: "timeline w-full" }, uo = /* @__PURE__ */ m({
  __name: "UpNotification",
  props: {
    styl: {
      type: String,
      default: "info",
      validator: (e) => ["primary", "secondary", "error", "info", "success", "warning"].indexOf(e) >= 0
    },
    timeout: {
      type: Number,
      default: 0
    }
  },
  emits: ["close"],
  setup(e, { emit: o }) {
    const t = e, s = () => {
      o("close");
    }, a = L(() => t.timeout !== 0 ? `animation-duration: ${t.timeout}ms;` : "");
    return (u, i) => (n(), l("div", {
      class: S(["up-notification flex flex-column justify-between", `up-notification-${e.styl}`])
    }, [
      r("div", so, [
        r("div", lo, [
          y(u.$slots, "default")
        ]),
        C(O, {
          shape: "free",
          class: "up-notification-close-button",
          onClick: P(s, ["stop", "prevent"])
        }, {
          default: T(() => [
            ao
          ]),
          _: 1
        }, 8, ["onClick"])
      ]),
      r("div", ro, [
        r("div", {
          class: "bar",
          style: oe(c(a))
        }, null, 4)
      ])
    ], 2));
  }
}), io = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: uo
}, Symbol.toStringTag, { value: "Module" })), co = { class: "up-notification-container" }, po = /* @__PURE__ */ m({
  __name: "UpNotificationContainer",
  setup(e) {
    return (o, t) => (n(), l("div", co, [
      y(o.$slots, "default")
    ]));
  }
}), _o = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: po
}, Symbol.toStringTag, { value: "Module" })), fo = { class: "up-page-title flex justify-between" }, yo = { class: "left flex gap-m items-center" }, go = {
  key: 0,
  class: "icon"
}, mo = { class: "title" }, bo = {
  key: 0,
  class: "toolbar flex items-center gap-s"
}, vo = /* @__PURE__ */ m({
  __name: "UpPageTitle",
  props: {
    title: String
  },
  setup(e) {
    const o = F(), t = (s) => !!o[s];
    return (s, a) => (n(), l("div", fo, [
      r("div", yo, [
        t("icon") ? (n(), l("div", go, [
          y(s.$slots, "icon")
        ])) : v("", !0),
        r("h5", mo, M(e.title), 1)
      ]),
      t("toolbar") ? (n(), l("div", bo, [
        y(s.$slots, "toolbar")
      ])) : v("", !0)
    ]));
  }
}), Mo = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: vo
}, Symbol.toStringTag, { value: "Module" })), ho = { class: "up-pagination" }, Lo = {
  key: 0,
  class: "text-sm text-gray-700"
}, jo = { class: "font-medium" }, Co = { class: "font-medium" }, So = { class: "font-medium" }, To = { class: "sr-only" }, ko = { class: "sr-only" }, wo = /* @__PURE__ */ m({
  __name: "UpPagination",
  props: {
    total: { type: [Number, String], default: 1 },
    itemsPerPage: { type: [Number, String], default: 10 },
    currentPage: { type: [Number, String], default: 1 },
    displayedPageCount: { type: [Number, String], default: 5 },
    prevButtonText: { type: String, default: () => "Prev" },
    nextButtonText: { type: String, default: () => "Next" },
    recordFromText: { type: String, default: () => "Showing from" },
    recordToText: { type: String, default: () => "to" },
    recordOfText: { type: String, default: () => "of" },
    recordTotalText: { type: String, default: () => "records" },
    displayRecordsState: { type: Boolean, default: !0 }
  },
  emits: ["pageChange"],
  setup(e, { emit: o }) {
    const t = e, s = L(() => {
      const g = Math.ceil(+t.total / +t.itemsPerPage);
      return g === 0 ? 1 : g;
    }), a = () => +t.currentPage < s.value, u = () => +t.currentPage > 1, i = L(() => t.total > 0 ? (+t.currentPage - 1) * +t.itemsPerPage + 1 : 0), p = L(() => {
      let g = +t.currentPage * +t.itemsPerPage;
      return g <= t.total ? g : t.total;
    }), f = L(() => {
      let g = [1, s.value];
      const d = 1, z = s.value > t.displayedPageCount ? t.displayedPageCount : s.value;
      for (let j = -d; j <= d; j++)
        g.push(+t.currentPage + j);
      let k = d + 1;
      for (; g.length < z && (g.push(+t.currentPage + k), g.push(+t.currentPage - k), k++, g = g.filter((j) => j >= 1 && j <= s.value), g = g.filter((j, I) => g.indexOf(j) === I), !(k > 15)); )
        ;
      g = g.filter((j) => j >= 1 && j <= s.value), g = g.filter((j, I) => g.indexOf(j) === I), g.sort((j, I) => j - I);
      let $ = 0;
      const U = [];
      return g.map((j) => {
        $ + 1 !== j && U.push("..."), U.push(j.toString()), $ = j;
      }), U;
    }), b = (g) => {
      g !== "..." && o("pageChange", g);
    }, h = (g) => {
      let d = t.currentPage + g;
      d = d < 1 ? 1 : d, d = d > s.value ? s.value : d, o("pageChange", d);
    };
    return (g, d) => {
      const z = B("fa");
      return n(), l("div", ho, [
        r("div", null, [
          e.displayRecordsState ? (n(), l("p", Lo, [
            E(M(e.recordFromText) + " ", 1),
            r("span", jo, M(c(i)), 1),
            E(" " + M(e.recordToText) + " ", 1),
            r("span", Co, M(c(p)), 1),
            E(" " + M(e.recordOfText) + " ", 1),
            r("span", So, M(e.total), 1),
            E(" " + M(e.recordTotalText), 1)
          ])) : v("", !0)
        ]),
        r("div", null, [
          C(q, null, {
            default: T(() => [
              C(O, {
                shape: "outline",
                disabled: !u(),
                styl: "primary",
                onClick: d[0] || (d[0] = (k) => h(-1)),
                "aria-label": e.prevButtonText
              }, {
                default: T(() => [
                  r("span", To, M(e.prevButtonText), 1),
                  C(z, { icon: "angle-left" })
                ]),
                _: 1
              }, 8, ["disabled", "aria-label"]),
              (n(!0), l(x, null, V(c(f), (k) => (n(), N(O, {
                shape: +k != +e.currentPage ? "outline" : "",
                styl: "primary",
                disabled: k === "...",
                onClick: ($) => b(k)
              }, {
                default: T(() => [
                  E(M(k), 1)
                ]),
                _: 2
              }, 1032, ["shape", "disabled", "onClick"]))), 256)),
              C(O, {
                shape: "outline",
                disabled: !a(),
                styl: "primary",
                onClick: d[1] || (d[1] = (k) => h(1)),
                "aria-label": e.nextButtonText
              }, {
                default: T(() => [
                  r("span", ko, M(e.nextButtonText), 1),
                  C(z, { icon: "angle-right" })
                ]),
                _: 1
              }, 8, ["disabled", "aria-label"])
            ]),
            _: 1
          })
        ])
      ]);
    };
  }
}), $o = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: wo
}, Symbol.toStringTag, { value: "Module" })), xo = { class: "up-progress" }, No = /* @__PURE__ */ m({
  __name: "UpProgress",
  props: {
    total: {
      type: Number,
      default: 100,
      validator: (e) => e >= 0
    },
    current: {
      type: Number,
      default: 0,
      validator: (e) => e >= 0
    },
    styl: {
      type: String,
      default: "",
      validator: (e) => ["", "primary", "secondary", "error", "info", "success", "warning"].indexOf(e) >= 0
    }
  },
  setup(e) {
    const o = e, t = L(() => {
      let s = o.current / o.total * 100;
      return s > 100 && (s = 100), s.toFixed();
    });
    return (s, a) => (n(), l("div", xo, [
      r("span", {
        class: S(e.styl),
        style: oe(`width: ${c(t)}%;`)
      }, "\xA0" + M(c(t)) + "%", 7)
    ]));
  }
}), Oo = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: No
}, Symbol.toStringTag, { value: "Module" })), zo = /* @__PURE__ */ m({
  __name: "UpSearchhelp",
  props: {
    ...Q().oProps
  },
  emits: ["onSearchhelpClick"],
  setup(e, { emit: o }) {
    const t = e, s = (a) => {
      a.stopPropagation(), a.preventDefault(), o("onSearchhelpClick");
    };
    return (a, u) => {
      const i = B("fa");
      return n(), N(ee, {
        label: t.label,
        placeholder: t.placeholder,
        readonly: !0,
        errors: a.errors,
        modelValue: a.modelValue,
        "onUpdate:modelValue": u[0] || (u[0] = (p) => a.modelValue = p)
      }, {
        append: T(() => [
          C(O, {
            styl: "primary",
            onClick: s
          }, {
            default: T(() => [
              C(i, { icon: ["far", "fa-clone"] })
            ]),
            _: 1
          })
        ]),
        _: 1
      }, 8, ["label", "placeholder", "errors", "modelValue"]);
    };
  }
}), Po = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: zo
}, Symbol.toStringTag, { value: "Module" })), Uo = {
  key: 0,
  class: "label label-left tetx-nowrap"
}, Io = ["id", "disabled", "checked"], Do = ["for"], Eo = /* @__PURE__ */ m({
  __name: "UpSwitch",
  props: {
    ...Y().oProps,
    styl: {
      type: String,
      default: "primary",
      validator: (e) => ["primary", "secondary", "error", "info", "success", "warning"].indexOf(e) >= 0
    },
    altLabel: { type: String, default: "" },
    modelValue: Boolean
  },
  emits: ["update:modelValue", "change"],
  setup(e, { emit: o }) {
    const t = e, s = Y(), a = L(() => {
      const i = [];
      return i.push("up-switch"), i.push(`up-switch-${t.styl}`), t.disabled && i.push("up-switch-disabled"), i.join(" ");
    }), u = (i) => {
      o("update:modelValue", i.target.checked), o("change", i.target.checked);
    };
    return (i, p) => (n(), l("div", {
      class: S(c(a))
    }, [
      e.altLabel !== "" ? (n(), l("span", Uo, M(e.altLabel), 1)) : v("", !0),
      r("input", {
        id: c(s).id,
        type: "checkbox",
        disabled: i.disabled || i.readonly,
        checked: e.modelValue,
        onChange: u
      }, null, 40, Io),
      r("label", {
        class: "label tetx-nowrap",
        for: c(s).id
      }, M(i.label), 9, Do)
    ], 2));
  }
}), Vo = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: Eo
}, Symbol.toStringTag, { value: "Module" })), Yo = { class: "up-tab-content" }, Ao = /* @__PURE__ */ m({
  __name: "UpTab",
  props: {
    title: { type: String, default: "Tab" }
  },
  setup(e) {
    const o = ue("selectedTab");
    return (t, s) => ie((n(), l("div", Yo, [
      y(t.$slots, "default")
    ], 512)), [
      [ce, c(o) === e.title]
    ]);
  }
}), Bo = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: Ao
}, Symbol.toStringTag, { value: "Module" })), Fo = { class: "up-tab-container" }, Qo = { class: "tabs__header up-component-group" }, Ro = ["onClick"], Ho = /* @__PURE__ */ m({
  __name: "UpTabContainer",
  setup(e) {
    const o = A(F().default().map((s) => s.props.title)), t = A(o.value[0]);
    return de("selectedTab", t), (s, a) => (n(), l("div", Fo, [
      r("ul", Qo, [
        (n(!0), l(x, null, V(o.value, (u) => (n(), l("li", {
          key: u,
          class: S({ active: t.value === u }),
          onClick: (i) => t.value = u
        }, M(u), 11, Ro))), 128))
      ]),
      y(s.$slots, "default")
    ]));
  }
}), Ko = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: Ho
}, Symbol.toStringTag, { value: "Module" })), le = () => ({
  getHeaderKey: (t) => typeof t == "string" ? t : t.key,
  getHeaderCss: (t) => t.css ? Array.isArray(t.css) ? t.css.join(" ") : t.css : ""
}), Jo = ["data-ident"], Wo = {
  key: 0,
  class: "up-table-cell up-table-cell-checkbox"
}, ae = /* @__PURE__ */ m({
  __name: "UpTableRow",
  props: {
    header: { type: Array, default: [] },
    data: { type: Object, default: {} },
    checkboxes: { type: Boolean, default: !0 },
    rowIdentField: { type: String, default: "id" }
  },
  emits: ["onDelete", "onDblClick", "onRowClick", "onRowCheck"],
  setup(e, { emit: o }) {
    const t = e, s = (f) => {
      o("onDblClick", f);
    }, a = (f) => {
      o("onRowClick", f);
    }, u = L(() => {
      var f;
      return (f = t.data.css) != null ? f : "";
    }), { getHeaderKey: i } = le(), p = L({
      get() {
        return t.data._checked;
      },
      set(f) {
        o("onRowCheck", t.data, f);
      }
    });
    return (f, b) => (n(), l("tr", {
      onDblclick: b[1] || (b[1] = P((h) => s(e.data), ["prevent", "stop"])),
      onClick: b[2] || (b[2] = P((h) => a(e.data), ["stop"])),
      class: S(c(u)),
      "data-ident": e.data[e.rowIdentField]
    }, [
      e.checkboxes ? (n(), l("td", Wo, [
        C(X, {
          modelValue: c(p),
          "onUpdate:modelValue": b[0] || (b[0] = (h) => pe(p) ? p.value = h : null)
        }, null, 8, ["modelValue"])
      ])) : v("", !0),
      (n(!0), l(x, null, V(e.header, (h, g) => (n(), l(x, null, [
        typeof f.$slots[c(i)(h)] < "u" ? (n(), l("td", {
          class: "up-table-cell",
          key: e.data[c(i)(h)]
        }, [
          y(f.$slots, c(i)(h), {
            field: c(i)(h),
            item: e.data,
            value: e.data[c(i)(h)]
          })
        ])) : (n(), l("td", {
          class: "up-table-cell",
          key: e.data[c(i)(h)]
        }, M(e.data[c(i)(h)]), 1))
      ], 64))), 256))
    ], 42, Jo));
  }
}), Go = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: ae
}, Symbol.toStringTag, { value: "Module" })), Zo = { class: "up-table" }, Xo = {
  key: 0,
  class: "up-table-cell up-table-cell-checkbox"
}, qo = ["data-key-name", "onClick"], en = /* @__PURE__ */ m({
  __name: "UpTable",
  props: {
    header: { type: Array, default: [] },
    data: { type: Array, default: [] },
    checkboxes: { type: Boolean, default: !0 },
    sortedKey: { type: Object, default: { key: "", direction: "asc" } },
    rowIdentField: { type: String, default: "id" }
  },
  emits: ["rowDblClick", "rowClick", "onDelete", "onCheckAll", "onHeaderClick", "rowCheck"],
  setup(e, { emit: o }) {
    const t = e, s = (d) => {
      o("rowDblClick", d);
    }, a = (d) => {
      o("rowClick", d);
    }, u = (d, z) => {
      o("rowCheck", d, z);
    }, i = (d) => {
      o("onDelete", d);
    }, p = (d) => typeof d == "string" ? d : d.title ? d.title : d.key, f = (d) => {
      o("onCheckAll", d);
    }, b = (d) => {
      if (!!d.sortable)
        if (!t.sortedKey.key)
          o("onHeaderClick", { key: d.key, direction: "asc" });
        else {
          let z = "asc";
          t.sortedKey.key === d.key && (z = t.sortedKey.direction === "asc" ? "desc" : "asc"), o("onHeaderClick", { key: d.key, direction: z });
        }
    }, { getHeaderKey: h, getHeaderCss: g } = le();
    return (d, z) => {
      const k = B("fa");
      return n(), l("table", Zo, [
        r("thead", null, [
          r("tr", null, [
            e.checkboxes ? (n(), l("th", Xo, [
              C(X, { "onUpdate:modelValue": f })
            ])) : v("", !0),
            (n(!0), l(x, null, V(e.header, ($) => (n(), l("th", {
              key: c(h)($),
              class: S(["up-table-cell", c(g)($)])
            }, [
              r("div", {
                class: "up-table-cell-header",
                "data-key-name": $.key,
                onClick: (U) => b($)
              }, [
                r("span", null, M(p($)), 1),
                $.sortable ? (n(), l(x, { key: 0 }, [
                  !!e.sortedKey.key && e.sortedKey.key === $.key ? (n(), l(x, { key: 0 }, [
                    e.sortedKey.direction === "asc" ? (n(), N(k, {
                      key: 0,
                      icon: "fa-sort-up"
                    })) : v("", !0),
                    e.sortedKey.direction === "desc" ? (n(), N(k, {
                      key: 1,
                      icon: "fa-sort-down"
                    })) : v("", !0)
                  ], 64)) : (n(), N(k, {
                    key: 1,
                    icon: "fa-sort"
                  }))
                ], 64)) : v("", !0)
              ], 8, qo)
            ], 2))), 128))
          ])
        ]),
        r("tbody", null, [
          (n(!0), l(x, null, V(e.data, ($) => (n(), N(ae, {
            header: e.header,
            data: $,
            checkboxes: e.checkboxes,
            rowIdentField: e.rowIdentField,
            onOnDelete: i,
            onOnDblClick: s,
            onOnRowClick: a,
            onOnRowCheck: u
          }, _e({ _: 2 }, [
            V(Object.keys(d.$slots), (U) => ({
              name: U,
              fn: T(({ field: j, item: I, value: K }) => [
                y(d.$slots, U, {
                  field: j,
                  item: I,
                  value: K
                })
              ])
            }))
          ]), 1032, ["header", "data", "checkboxes", "rowIdentField"]))), 256))
        ])
      ]);
    };
  }
}), tn = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: en
}, Symbol.toStringTag, { value: "Module" })), on = { class: "header" }, nn = { class: "content" }, sn = { class: "footer" }, ln = /* @__PURE__ */ m({
  __name: "UpTile",
  props: {
    doubleRight: {
      type: Boolean,
      default: !1
    },
    doubleBottom: {
      type: Boolean,
      default: !1
    },
    styl: {
      type: String,
      default: "none",
      validator: (e) => ["none", "primary", "secondary", "error", "info", "success", "warning"].indexOf(e) >= 0
    },
    processing: { type: Boolean, default: !1 }
  },
  emits: ["click"],
  setup(e, { emit: o }) {
    const t = e, s = L(() => {
      const u = [];
      return t.doubleRight && u.push("double-right"), t.doubleBottom && u.push("double-bottom"), a.value && u.push("clickable"), u.push(`up-tile-${t.styl}`), u.join(" ");
    }), a = L(() => {
      var u, i;
      return ((i = (u = H()) == null ? void 0 : u.vnode.props) == null ? void 0 : i.onClick) || !1;
    });
    return (u, i) => {
      const p = B("UpProcess");
      return n(), l("div", {
        class: S(["up-tile", c(s)]),
        onClick: i[0] || (i[0] = (f) => u.$emit("click", f))
      }, [
        C(p, {
          processing: e.processing,
          class: "flex flex-column flex-nowrap justify-between h-full"
        }, {
          default: T(() => [
            r("div", on, [
              y(u.$slots, "header")
            ]),
            r("div", nn, [
              y(u.$slots, "default")
            ]),
            r("div", sn, [
              y(u.$slots, "footer")
            ])
          ]),
          _: 3
        }, 8, ["processing"])
      ], 2);
    };
  }
}), an = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: ln
}, Symbol.toStringTag, { value: "Module" })), rn = { class: "up-tile-container" }, un = { key: 0 }, cn = { class: "up-tile-wrapper" }, dn = /* @__PURE__ */ m({
  __name: "UpTileContainer",
  props: {
    title: String
  },
  setup(e) {
    return (o, t) => (n(), l("div", rn, [
      e.title && e.title !== "" ? (n(), l("h4", un, M(e.title), 1)) : v("", !0),
      r("div", cn, [
        y(o.$slots, "default")
      ])
    ]));
  }
}), pn = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: dn
}, Symbol.toStringTag, { value: "Module" })), _n = { class: "up-toolbar" }, fn = { class: "up-left" }, yn = { class: "up-right" }, gn = /* @__PURE__ */ m({
  __name: "UpToolbar",
  setup(e) {
    return (o, t) => (n(), l("div", _n, [
      r("div", fn, [
        y(o.$slots, "left")
      ]),
      r("div", yn, [
        y(o.$slots, "default")
      ])
    ]));
  }
}), mn = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: gn
}, Symbol.toStringTag, { value: "Module" })), bn = /* @__PURE__ */ Object.assign({ "./components/Avatar/UpAvatar.vue": me, "./components/Badge/UpBadge.vue": ve, "./components/Button/UpButton.vue": he, "./components/Card/UpCard.vue": ke, "./components/Checkbox/UpCheckbox.vue": Ve, "./components/Dropdown/UpDropdown.vue": rt, "./components/Footer/UpFooter.vue": ct, "./components/Layout/UpCell.vue": pt, "./components/Layout/UpRow.vue": ft, "./components/Logo/UpLogo.vue": bt, "./components/Menu/UpMenu.vue": Mt, "./components/Menu/UpMenuItem.vue": Lt, "./components/Menu/UpMenuSeparator.vue": St, "./components/Message/UpMessage.vue": Nt, "./components/Modal/UpDeleteConfirmation.vue": Qt, "./components/Modal/UpModal.vue": Vt, "./components/Navigation/UpNavContainer.vue": Jt, "./components/Navigation/UpNavItem.vue": Zt, "./components/Navigation/UpVerticalNavbar.vue": no, "./components/Notification/UpNotification.vue": io, "./components/Notification/UpNotificationContainer.vue": _o, "./components/PageTitle/UpPageTitle.vue": Mo, "./components/Pagination/UpPagination.vue": $o, "./components/Process/UpProcess.vue": zt, "./components/Progress/UpProgress.vue": Oo, "./components/Searchhelp/UpSearchhelp.vue": Po, "./components/Switch/UpSwitch.vue": Vo, "./components/Tab/UpTab.vue": Bo, "./components/Tab/UpTabContainer.vue": Ko, "./components/Table/UpTable.vue": tn, "./components/Table/UpTableRow.vue": Go, "./components/Textbox/UpTextbox.vue": Xe, "./components/Tile/UpTile.vue": an, "./components/Tile/UpTileContainer.vue": pn, "./components/Toolbar/UpToolbar.vue": mn, "./components/UpComponentGroup.vue": Ae }), R = {};
function vn(e) {
  return e.substring(location.pathname.lastIndexOf("/") + 2).split(".vue")[0];
}
Object.entries(bn).forEach(([e, o]) => {
  R[o.name ? o.name : vn(e)] = o.default;
});
const Mn = () => ({
  __name: "UpUI",
  version: "0.11.17"
});
R.version = Mn();
const Ln = {
  install(e) {
    for (const o in R)
      if (R.hasOwnProperty(o)) {
        const t = R[o];
        e.component(t.__name, t);
      }
  }
};
export {
  Ln as default
};
