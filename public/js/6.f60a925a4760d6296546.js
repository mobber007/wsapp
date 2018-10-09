webpackJsonp([6],{Ef8v:function(t,e,r){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var i=r("Xxa5"),o=r.n(i),n=r("lk2h"),s=r("W08z"),a=r("NYxO"),c=r("mtWM"),l=r.n(c);function u(t){return function(){var e=t.apply(this,arguments);return new Promise(function(t,r){return function i(o,n){try{var s=e[o](n),a=s.value}catch(t){return void r(t)}if(!s.done)return Promise.resolve(a).then(function(t){i("next",t)},function(t){i("throw",t)});t(a)}("next")})}}var d={name:"ProductSingle",components:{Product:n.a,Favorite:s.a},data:function(){return{description_panel:[!0],similars:"",loading_similars:!1,bottomNav:"recent"}},computed:Object(a.mapGetters)({product:"product/product"}),created:function(){this.similars="",this.get_similars()},watch:{"product.id":function(){this.similars="",this.get_similars()}},methods:{redirectTo:function(){var t=u(o.a.mark(function t(e){return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:this.redirecting=!0,console.log("Redirecting"),window.open(e),this.redirecting=!1,console.log("Redirected");case 5:case"end":return t.stop()}},t,this)}));return function(e){return t.apply(this,arguments)}}(),get_similars:function(){var t=u(o.a.mark(function t(){var e;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return this.loading_similars=!0,t.next=3,l.a.get("/api/similars/"+this.product.id);case 3:e=t.sent,this.similars=e.data.similars,this.loading_similars=!1;case 6:case"end":return t.stop()}},t,this)}));return function(){return t.apply(this,arguments)}}()},metaInfo:function(){return{title:this.product.title}}},v=r("XyMi"),p=Object(v.a)(d,function(){var t=this,e=t.$createElement,r=t._self._c||e;return t.product?r("div",[r("v-layout",{attrs:{row:"",wrap:""}},[r("v-flex",{attrs:{xs12:"",sm12:"",md8:"",lg8:"",xl8:"","d-flex":""}},[r("v-card",{attrs:{flat:""}},[r("v-carousel",{staticStyle:{"min-height":"75vh"},attrs:{flat:"","reverse-transition":"fade",transition:"fade","hide-delimiters":"",light:""}},t._l(t.product.images,function(e,i){return r("v-carousel-item",{key:i,attrs:{src:e.url,contain:""}},[r("v-btn",{staticClass:"left",attrs:{fab:"",dark:"",small:"",color:"dark"}},[r("strong",[t._v(t._s(i+1)+"/"+t._s(t.product.images.length))])])],1)}))],1)],1),t._v(" "),r("v-flex",{attrs:{xs12:"",sm12:"",md4:"",lg4:"",xl4:"","d-flex":""}},[r("v-card",{attrs:{"elevation-10":""}},[t.product.discounted?r("v-btn",{staticClass:"left",staticStyle:{"margin-bottom":"-40px"},attrs:{fab:"",dark:"",small:"",color:"error"}},[r("strong",[t._v(t._s(t.product.discounted)+"%")])]):t._e(),t._v(" "),r("a",{staticStyle:{"text-decoration":"none"},on:{click:function(e){t.redirectTo(t.product.event_url)}}},[r("v-img",{attrs:{src:t.product.affiliate_logo,contain:"",height:"140",width:"100%"}})],1),t._v(" "),r("v-card-text",{staticStyle:{"padding-bottom":"60px"}},[r("p",{staticClass:"text-xs-center"},[r("span",{staticStyle:{"font-size":"medium"}},[t._v(t._s(t.product.title))]),t._v(" "),r("v-spacer"),r("span",[t._v(t._s(t.product.price)+" ron ")]),t.product.discounted?r("span",{staticStyle:{"text-decoration":"line-through",color:"red"}},[t._v(t._s(t.product.old_price)+" ron")]):t._e()],1),t._v(" "),r("v-card",{attrs:{"elevation-5":""}},[r("v-card-title",[r("h4",{staticStyle:{margin:"0 auto"}},[t._v("Informatii")])]),t._v(" "),r("v-divider"),t._v(" "),r("v-list",{attrs:{dense:""}},[r("v-list-tile",[r("v-list-tile-content",[t._v("Categorie:")]),t._v(" "),r("v-list-tile-content",{staticClass:"align-end"},[r("strong",[t._v(t._s(t.product.category))])])],1),t._v(" "),r("v-list-tile",[r("v-list-tile-content",[t._v("Subcategorie:")]),t._v(" "),r("v-list-tile-content",{staticClass:"align-end"},[r("strong",[t._v(t._s(t.product.subcategory))])])],1),t._v(" "),r("v-list-tile",[r("v-list-tile-content",[t._v("Brand:")]),t._v(" "),r("v-list-tile-content",{staticClass:"align-end"},[r("strong",[t._v(t._s(t.product.brand))])])],1),t._v(" "),r("v-list-tile",[r("v-list-tile-content",[t._v("Vandut de:")]),t._v(" "),r("v-list-tile-content",{staticClass:"align-end"},[r("strong",[t._v(t._s(t.product.affiliate))])])],1),t._v(" "),r("v-list-tile",[r("v-list-tile-content",[t._v("Accesari:")]),t._v(" "),r("v-list-tile-content",{staticClass:"align-end"},[r("strong",[t._v(t._s(t.product.total_views))])])],1)],1)],1)],1),t._v(" "),r("v-bottom-nav",{attrs:{active:t.bottomNav,value:!0,absolute:"",color:"transparent"},on:{"update:active":function(e){t.bottomNav=e}}},[r("v-btn",{attrs:{color:"indigo",flat:"",value:"recent"},on:{click:function(e){t.$router.go(-1)}}},[r("v-icon",[t._v("keyboard_arrow_left")])],1),t._v(" "),t.$store.state.auth.user?[r("favorite",{staticStyle:{width:"100%"},attrs:{favorited:t.product.favorited,product:t.product,single:!0}})]:r("v-btn",{attrs:{color:"error",flat:"",value:"recent"},on:{click:function(e){t.$store.state.navi.loginSheet=!0}}},[r("v-icon",[t._v("favorite_border")])],1),t._v(" "),r("v-btn",{attrs:{color:"info",flat:"",value:"recent"},on:{click:function(e){t.redirectTo(t.product.event_url)}}},[r("v-icon",[t._v("store")])],1)],2)],1)],1)],1),t._v(" "),r("v-container",{attrs:{"fill-height":"","grid-list-sm":""}},[r("v-layout",{attrs:{row:"",wrap:""}},[t.loading_similars?r("div",{staticClass:"text-xs-center",staticStyle:{margin:"0 auto","margin-top":"1rem","margin-bottom":"1rem"}},[r("v-progress-circular",{attrs:{size:32,color:"indigo",indeterminate:""}})],1):r("v-flex",{staticClass:"my-5",attrs:{xs12:""}},[r("div",{staticClass:"text-xs-center"},[t.similars?r("h2",{staticStyle:{"font-size":"2em"}},[t._v("Produse similare")]):r("h2",{staticStyle:{"font-size":"2em"}},[t._v("Nu exista produse similare")])])]),t._v(" "),t._l(t.similars,function(t,e){return r("v-flex",{key:e,attrs:{xs12:"",sm6:"",md4:"",lg4:"",xl3:""}},[r("product",{attrs:{product:t,index:e}})],1)})],2)],1)],1):t._e()},[],!1,null,null,null);e.default=p.exports},W08z:function(t,e,r){"use strict";var i=r("Xxa5"),o=r.n(i);function n(t){return function(){var e=t.apply(this,arguments);return new Promise(function(t,r){return function i(o,n){try{var s=e[o](n),a=s.value}catch(t){return void r(t)}if(!s.done)return Promise.resolve(a).then(function(t){i("next",t)},function(t){i("throw",t)});t(a)}("next")})}}var s={name:"Favorite",props:{favorited:{type:Boolean,required:!0,default:!1},single:{type:Boolean,required:!1,default:!1},product:{type:Object,required:!0,default:null},index:{type:Number,required:!1,default:0}},data:function(){return{}},created:function(){},methods:{favorite:function(){var t=n(o.a.mark(function t(e){var r;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.$store.dispatch("favorite/setFavorite",e);case 2:return this.product.favorited=!0,t.next=5,this.syncFav(e);case 5:return this.$store.state.favorite.favorites.push(this.product),r={value:!0,message:this.$store.state.favorite.status,type:"indigo",avatar:!1,icon:"favorite",mode:"",timeout:2e3},t.next=9,this.$store.dispatch("navi/setSnackbar",r);case 9:case"end":return t.stop()}},t,this)}));return function(e){return t.apply(this,arguments)}}(),unfavorite:function(){var t=n(o.a.mark(function t(e){var r;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,this.$store.dispatch("favorite/unsetFavorite",e);case 2:return this.product.favorited=!1,t.next=5,this.syncFav(e);case 5:return this.$store.state.favorite.favorites.splice(this.index,1),r={value:!0,message:this.$store.state.favorite.status,type:"indigo",avatar:!1,icon:"favorite_border",mode:"",timeout:2e3},t.next=9,this.$store.dispatch("navi/setSnackbar",r);case 9:case"end":return t.stop()}},t,this)}));return function(e){return t.apply(this,arguments)}}(),syncFav:function(t){if(this.$store.state.product.products.length){var e="";this.$store.state.product.products.filter(function(r,i){r.id==t&&(e=i)}),""!==e&&this.$store.state.product.products.splice(e,1,this.product)}if(this.$store.state.promotion.promotions.length){e="";this.$store.state.promotion.promotions.filter(function(r,i){r.id==t&&(e=i)}),""!==e&&this.$store.state.promotion.promotions.splice(e,1,this.product)}if(this.$store.state.popular.populars.length){e="";this.$store.state.popular.populars.filter(function(r,i){r.id==t&&(e=i)}),""!==e&&this.$store.state.popular.populars.splice(e,1,this.product)}if(this.$store.state.feature.featured.length){e="";this.$store.state.feature.featured.filter(function(r,i){r.id==t&&(e=i)}),""!==e&&this.$store.state.feature.featured.splice(e,1,this.product)}}}},a=r("XyMi"),c=Object(a.a)(s,function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[t.single?[t.favorited?r("v-btn",{attrs:{color:"error",flat:"",value:"recent"},on:{click:function(e){e.preventDefault(),t.unfavorite(t.product.id)}}},[r("v-icon",{attrs:{color:"error"}},[t._v("favorite")])],1):r("v-btn",{attrs:{color:"error",flat:"",value:"recent"},on:{click:function(e){e.preventDefault(),t.favorite(t.product.id)}}},[r("v-icon",{attrs:{color:"error"}},[t._v("favorite_border")])],1)]:[t.favorited?r("v-icon",{attrs:{color:"error"},on:{click:function(e){e.preventDefault(),t.unfavorite(t.product.id)}}},[t._v("favorite")]):r("v-icon",{attrs:{color:"error"},on:{click:function(e){e.preventDefault(),t.favorite(t.product.id)}}},[t._v("favorite_border")])]],2)},[],!1,null,null,null);e.a=c.exports},lk2h:function(t,e,r){"use strict";var i=r("Xxa5"),o=r.n(i);var n={name:"Product",components:{Favorite:r("W08z").a},props:{product:{type:Object,default:null,required:!0},index:{type:Number,default:0,required:!0}},data:function(){return{redirecting:!1}},created:function(){},methods:{redirectTo:function(){var t,e=(t=o.a.mark(function t(e){return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:this.redirecting=!0,console.log("Redirecting"),window.open(e),this.redirecting=!1,console.log("Redirected");case 5:case"end":return t.stop()}},t,this)}),function(){var e=t.apply(this,arguments);return new Promise(function(t,r){return function i(o,n){try{var s=e[o](n),a=s.value}catch(t){return void r(t)}if(!s.done)return Promise.resolve(a).then(function(t){i("next",t)},function(t){i("throw",t)});t(a)}("next")})});return function(t){return e.apply(this,arguments)}}()}},s=r("XyMi"),a=Object(s.a)(n,function(){var t=this,e=t.$createElement,r=t._self._c||e;return t.product?r("v-card",{staticClass:"mx-1 my-1 rounded-radius",attrs:{transition:"scale-transition","elevation-10":"",hover:""}},[r("router-link",{staticStyle:{"text-decoration":"none",color:"black"},attrs:{to:{name:"products.single",params:{id:t.product.slug}}}},[r("v-img",{staticClass:"rounded-radius",attrs:{src:t.product.thumbnail,height:"300px",contain:""}},[r("v-layout",{attrs:{slot:"placeholder","fill-height":"","align-center":"","justify-center":"","ma-0":""},slot:"placeholder"},[r("v-progress-circular",{attrs:{indeterminate:"",color:"grey darken-1"}})],1)],1),t._v(" "),t.product.discounted?r("v-btn",{staticClass:"left",staticStyle:{"margin-top":"-290px"},attrs:{fab:"",dark:"",small:"",color:"error"}},[r("strong",[t._v(t._s(t.product.discounted)+"%")])]):t._e(),t._v(" "),r("v-card-text",{staticClass:"text-xs-center text-truncate",domProps:{textContent:t._s(t.product.title)}}),t._v(" "),r("v-card-text",{staticClass:"text-xs-center"},[r("p",{staticStyle:{"font-size":"medium"}},[r("span",[t._v(t._s(t.product.price)+" ron ")]),t.product.discounted?r("span",{staticStyle:{"text-decoration":"line-through",color:"red"}},[t._v(t._s(t.product.old_price)+" ron")]):t._e()])])],1),t._v(" "),r("v-divider"),t._v(" "),r("v-list-tile",[r("v-btn",{staticStyle:{"margin-left":"-0.75em"},attrs:{icon:""},on:{click:function(e){t.redirectTo(t.product.event_url)}}},[r("v-icon",{attrs:{color:"info"}},[t._v("store")])],1),t._v(" "),r("v-list-tile-content",{staticStyle:{"margin-left":"-0.75em"}},[r("div",{staticStyle:{"font-size":"medium"}},[r("strong",{on:{click:function(e){t.redirectTo(t.product.event_url)}}},[t._v(t._s(t.product.affiliate))])])]),t._v(" "),r("v-spacer"),t._v(" "),t.$store.state.auth.user?r("div",[r("favorite",{attrs:{favorited:t.product.favorited,product:t.product,index:t.index}})],1):r("v-icon",{attrs:{color:"error"},on:{click:function(e){t.$store.state.navi.loginSheet=!0}}},[t._v("favorite_border")]),t._v(" "),r("router-link",{attrs:{to:{name:"products.single",params:{id:t.product.slug}}}},[r("v-icon",{staticClass:"mx-1",staticStyle:{"margin-right":"-0.75em"},attrs:{color:"indigo"},on:{click:function(t){}}},[t._v("remove_red_eye")])],1)],1)],1):t._e()},[],!1,null,null,null);e.a=a.exports}});
//# sourceMappingURL=6.f60a925a4760d6296546.js.map