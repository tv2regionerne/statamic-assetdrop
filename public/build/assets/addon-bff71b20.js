function o(s,e,t,r,n,d,u,_){var a=typeof s=="function"?s.options:s;e&&(a.render=e,a.staticRenderFns=t,a._compiled=!0),r&&(a.functional=!0),d&&(a._scopeId="data-v-"+d);var l;if(u?(l=function(i){i=i||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext,!i&&typeof __VUE_SSR_CONTEXT__<"u"&&(i=__VUE_SSR_CONTEXT__),n&&n.call(this,i),i&&i._registeredComponents&&i._registeredComponents.add(u)},a._ssrRegister=l):n&&(l=_?function(){n.call(this,(a.functional?this.parent:this).$root.$options.shadowRoot)}:n),l)if(a.functional){a._injectStyles=l;var f=a.render;a.render=function(v,c){return l.call(c),f(v,c)}}else{var p=a.beforeCreate;a.beforeCreate=p?[].concat(p,l):[l]}return{exports:s,options:a}}const h={props:["extension","basename","percent","error","running"],computed:{status(){return this.error?"error":this.percent===100?this.running?"pending":"success":this.running?"uploading":"paused"}}};var m=function(){var e=this,t=e._self._c;return t("div",{staticClass:"flex items-center p-2 border-b border-gray-400 bg-gray-100",class:{"text-red-500":e.status=="error","text-green-500":e.status=="success"}},[t("div",{staticClass:"mr-2 shrink-0 flex items-center"},[e.status==="uploading"||e.status==="pending"?t("loading-graphic",{attrs:{inline:!0,text:""}}):e._e(),e.status==="success"?t("svg",{staticClass:"text-green-500 h-4 w-4",attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor"}},[t("path",{attrs:{"fill-rule":"evenodd",d:"M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z","clip-rule":"evenodd"}})]):e._e(),e.status==="error"?t("svg",{staticClass:"text-red-500 h-4 w-4",attrs:{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",fill:"currentColor"}},[t("path",{attrs:{"fill-rule":"evenodd",d:"M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z","clip-rule":"evenodd"}})]):e._e()],1),t("div",{staticClass:"grow whitespace-nowrap overflow-hidden text-ellipsis mr-2"},[e._v(" "+e._s(e.basename)+" ")]),t("div",{staticClass:"w-1/2 shrink-0 mr-2"},[e.running?t("div",{staticClass:"bg-gray-400 h-4 rounded flex"},[t("div",{staticClass:"bg-blue h-full rounded text-white text-center text-3xs px-1 overflow-hidden",style:{width:e.percent+"%"}},[e._v(" "+e._s(Math.round(e.percent)+"%")+" ")])]):e._e(),e.status==="error"?t("div",{staticClass:"text-right"},[e._v(" "+e._s(e.error)+" ")]):e._e()])])},g=[],b=o(h,m,g,!1,null,null,null,null);const C=b.exports,w={props:["uploads"],components:{Upload:C}};var x=function(){var e=this,t=e._self._c;return t("div",{staticClass:"text-xs w-full"},e._l(e.uploads,function(r,n){return t("upload",{key:r.id,attrs:{basename:r.basename,extension:r.extension,percent:r.percent,running:r.running,error:r.errorMessage}})}),1)},y=[],$=o(w,x,y,!1,null,null,null,null);const F=$.exports,S={components:{Uploads:F},props:{blueprint:{type:Object,required:!0},initialValues:{type:Object,required:!0},initialMeta:{type:Object,required:!0}},data(){return{values:this.initialValues,meta:this.initialMeta,errors:{},uploads:[]}},mounted(){this.$refs.uploader.initialize(this.assetsField.config,this.assetsField.meta)},computed:{fields(){return this.blueprint.tabs[0].sections[0].fields.filter(s=>s.handle!=="assets")},assetsField(){return{config:this.blueprint.tabs[0].sections[0].fields.find(s=>s.handle==="assets"),meta:this.meta.assets}},ready(){return this.values.name}},methods:{uploadFile(){this.$refs.uploader.browse()},uploadValues(s,e){const t=new Date().toISOString();return{...e,assetdrop_name:this.values.name,assetdrop_uploaded_at:{date:t.split("T")[0],time:t.split("T")[1].split(".")[0]},assetdrop_uploaded_by:[Statamic.user.id]}},async uploadComplete(s){const e=cp_url("assetdrop");await this.$axios.post(e,{id:s.id})},uploadError(s,e){this.uploads=e,this.$toast.error(s.errorMessage)},uploadsUpdated(s){this.uploads=s}}};var M=function(){var e=this,t=e._self._c;return t("div",{staticClass:"p-0 card"},[t("publish-container",{attrs:{name:"assetdrop",blueprint:e.blueprint,values:e.values,meta:e.meta,errors:e.errors},on:{updated:function(r){e.values=r}},scopedSlots:e._u([{key:"default",fn:function({setFieldValue:r,setFieldMeta:n}){return t("div",{},[t("publish-fields",{attrs:{fields:e.fields},on:{updated:r,"meta-updated":n}})],1)}}])}),t("div",{staticClass:"publish-fields @container"},[t("div",{staticClass:"form-group publish-field w-full"},[t("large_assets-uploader",{ref:"uploader",attrs:{enabled:e.ready,"clear-successful":!1,container:e.assetsField.config.container,path:e.assetsField.config.folder,"values-resolver":e.uploadValues},on:{updated:e.uploadsUpdated,"upload-complete":e.uploadComplete,error:e.uploadError},scopedSlots:e._u([{key:"default",fn:function({dragging:r}){return t("div",{},[t("div",{staticClass:"tv2reg-assetdrop-zone",class:{"tv2reg-assetdrop-ready":e.ready,"tv2reg-assetdrop-dragging":r}},[e.uploads.length?e._e():[r?e._e():t("div",{staticClass:"tv2reg-assetdrop-status"},[t("svg-icon",{staticClass:"opacity-25",attrs:{name:"upload"}}),t("div",{staticClass:"mt-4"},[t("button",{attrs:{type:"button"},on:{click:function(n){return n.preventDefault(),e.uploadFile.apply(null,arguments)}}},[e._v(" "+e._s(e.__("Upload files"))+" ")]),e._v(" "+e._s(e.__("or drag & drop here"))+" ")])],1),r?t("div",{staticClass:"tv2reg-assetdrop-status"},[t("svg-icon",{attrs:{name:"upload"}}),t("div",{staticClass:"mt-4"},[e._v(" "+e._s(e.__("Drop to Upload"))+" ")])],1):e._e()],e.uploads.length?t("uploads",{attrs:{uploads:e.uploads}}):e._e()],2)])}}])})],1)])],1)},R=[],U=o(S,M,R,!1,null,null,null,null);const k=U.exports;Statamic.booting(()=>{Statamic.component("assetdrop",k)});