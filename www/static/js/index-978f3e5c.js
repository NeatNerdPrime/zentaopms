var J=(e,t,a)=>new Promise((l,o)=>{var c=_=>{try{f(a.next(_))}catch(I){o(I)}},h=_=>{try{f(a.throw(_))}catch(I){o(I)}},f=_=>_.done?l(_.value):Promise.resolve(_.value).then(c,h);f((a=a.apply(e,t)).next())});import{d as U,v as y,R as te,ca as de,X as _e,o as i,m as v,cb as pe,cc as ve,cd as ae,ce as me,a as ge,cf as he,cg as fe,ch as ye,ci as Ce,j as ne,an as be,y as ke,r as E,e as g,f as s,z as d,w as D,F as P,A as R,t as S,ab as b,D as Oe,E as Se,cj as Ee,c0 as Ie,u as xe,a3 as we,aA as Ae,a1 as L,bR as De,c as F,b_ as Le,ad as Te}from"./index.js";import{C as Ne}from"./index-aae34a6e.js";import{a as Pe,f as Re,b as $e,p as ze}from"./index-547313f7.js";import{u as Fe,E as X,P as T,i as N}from"./chartEditStore-08ee2722.js";import{i as se}from"./icon-e0acebb0.js";import{l as Be,c as Q}from"./index-7b28e12e.js";import{u as oe}from"./chartLayoutStore-2204b84d.js";const Ue={class:"list-img",alt:"\u56FE\u8868\u56FE\u7247"},W=U({__name:"index",props:{chartConfig:{type:Object,required:!0}},setup(e){const t=e,a=y(""),l=()=>J(this,null,function*(){a.value=yield Pe(t.chartConfig)});return te(()=>t.chartConfig.key,()=>l(),{immediate:!0}),(o,c)=>{const h=de("lazy");return _e((i(),v("img",Ue,null,512)),[[h,a.value]])}}});function Ke(e){var t=e==null?0:e.length;return t?e[t-1]:void 0}var Ge=Ke;function Ve(e,t,a){var l=-1,o=e.length;t<0&&(t=-t>o?0:o+t),a=a>o?o:a,a<0&&(a+=o),o=t>a?0:a-t>>>0,t>>>=0;for(var c=Array(o);++l<o;)c[l]=e[l+t];return c}var He=Ve,Me=pe,je=He;function Ye(e,t){return t.length<2?e:Me(e,je(t,0,-1))}var qe=Ye,Je=ae,Xe=Ge,Qe=qe,We=ve;function Ze(e,t){return t=Je(t,e),e=Qe(e,t),e==null||delete e[We(Xe(t))]}var et=Ze,tt=me;function at(e){return tt(e)?void 0:e}var nt=at,st=ge,ot=Ce,ct=et,lt=ae,rt=he,it=nt,ut=fe,dt=ye,_t=1,pt=2,vt=4,mt=ut(function(e,t){var a={};if(e==null)return a;var l=!1;t=st(t,function(c){return c=lt(c,e),l||(l=c.length>1),c}),rt(e,dt(e),a),l&&(a=ot(a,_t|pt|vt,it));for(var o=t.length;o--;)ct(a,t[o]);return a}),gt=mt;const ht=e=>(Oe("data-v-1e61a0d5"),e=e(),Se(),e),ft={class:"go-chart-common"},yt={key:0,class:"charts"},Ct={class:"tree-top"},bt=ht(()=>d("span",null,"\u6240\u6709\u5206\u7EC4",-1)),kt={class:"tree-body"},Ot={class:"chapter chapter-first"},St={class:"text-nowrap label-title"},Et={class:"label-count"},It=["onDragstart"],xt={key:1,class:"chapter chapter-last"},wt={class:"text-nowrap"},At=["onDragstart"],Dt={class:"text-nowrap"},Lt={key:1,class:"no-charts"},Tt={class:"chart-content-list"},Nt=U({__name:"index",props:{selectOptions:{type:Object,default:()=>{}},menu:{type:String,default:()=>{}}},setup(e){var M,j,Y;const t=e,a=Be(()=>be(()=>import("./index-3b0390a1.js"),["static/js/index-3b0390a1.js","static/css/index-edd8c06a.css","static/js/index-677f2e31.js","static/css/index-1fb675e6.css","static/js/index.js","static/css/index-0098e772.css","static/js/icon-e0acebb0.js","static/js/chartEditStore-08ee2722.js","static/js/plugin-38c275d1.js","static/js/chartLayoutStore-2204b84d.js","static/js/index-7b28e12e.js","static/css/index-3cd64027.css","static/js/index-65cae441.js","static/js/index-64f31784.js","static/css/index-19141fc2.css","static/js/index-547313f7.js","static/css/index-187eb1a6.css","static/js/table_scrollboard-e30c6082.js","static/js/SizeSetting.vue_vue_type_style_index_0_scoped_true_lang-95b807ee.js","static/css/SizeSetting.vue_vue_type_style_index_0_scoped_true_lang-030d6af2.css","static/js/useTargetData.hook-565e1d3c.js","static/js/index-aae34a6e.js","static/css/index-a42fa8df.css"])),{ChevronUpOutlineIcon:l,ChevronDownOutlineIcon:o}=se.ionicons5,c=(M=window.dimensions)!=null?M:[],h=y((j=window.dimension)!=null?j:c[0].value),f=(Y=window.treeData)!=null?Y:[],_=f.chart?y(t.menu=="Charts"?f.chart[h.value]:f.pivot[h.value]):y(),I=()=>{_.value=f.chart?t.menu=="Charts"?f.chart[h.value]:f.pivot[h.value]:""},x=y(!1),C=y([]),ce=()=>{x.value=!x.value;for(const r in _.value){C.value[_.value[r].id]=x.value;for(const n in _.value[r].child)C.value[_.value[r].child[n].id]=x.value}},K=r=>{C.value[r]=!C.value[r]};let u=ke({menuOptions:[],selectOptions:{},categorys:{all:[]},categoryNames:{all:"\u6240\u6709"},categorysNum:0,saveSelectOptions:{}});const $=y(),le=r=>{for(const n in r){u.selectOptions=r[n];break}};te(()=>t.selectOptions,r=>{if(u.categorysNum=0,!!r){r.list.forEach(n=>{const w=u.categorys[n.category];u.categorys[n.category]=w&&w.length?[...w,n]:[n],u.categoryNames[n.category]=n.categoryName,u.categorys.all.push(n)});for(const n in u.categorys)u.categorysNum+=1,u.menuOptions.push({key:n,label:u.categoryNames[n]});le(u.categorys),$.value=u.menuOptions[0].key}},{immediate:!0});const re=r=>{u.selectOptions=u.categorys[r]},G=Fe(),V=(r,n)=>{Q(n.chartKey,Re(n)),Q(n.conKey,$e(n)),r.dataTransfer.setData(Ee.DRAG_KEY,Ie(gt(n,["image"]))),G.setEditCanvas(X.IS_CREATE,!0)},H=()=>{G.setEditCanvas(X.IS_CREATE,!1)};return(r,n)=>{const w=E("n-select"),z=E("n-icon"),q=E("n-scrollbar"),ie=E("n-menu");return i(),v("div",ft,[e.menu=="Charts"||e.menu=="Tables"?(i(),v("div",yt,[g(w,{class:"dimension-btn",value:h.value,"onUpdate:value":[n[0]||(n[0]=m=>h.value=m),I],options:s(c)},null,8,["value","options"]),d("div",Ct,[bt,g(z,{size:"16",component:x.value?s(l):s(o),onClick:ce},null,8,["component"])]),d("div",kt,[g(q,null,{default:D(()=>[(i(!0),v(P,null,R(s(_),(m,Jt)=>(i(),v("div",{key:m.id},[d("div",null,[d("div",Ot,[g(z,{size:"16",component:C.value[m.id]?s(l):s(o),onClick:p=>K(m.id)},null,8,["component","onClick"]),d("label",St,S(m.title),1),d("label",Et,S(m.count),1)]),m.child&&C.value[m.id]?(i(!0),v(P,{key:0},R(m.child,p=>(i(),v("div",{class:"tree-child",key:p.id},[p.type!="chapter"?(i(),v("div",{key:0,class:"item-box",draggable:"",onDragstart:O=>V(O,p.chartConfig),onDragend:H},[g(s(W),{class:"list-img",chartConfig:p.chartConfig},null,8,["chartConfig"]),d("span",null,S(p.title),1)],40,It)):b("",!0),p.type=="chapter"?(i(),v("div",xt,[g(z,{size:"16",component:C.value[p.id]?s(l):s(o),onClick:O=>K(p.id)},null,8,["component","onClick"]),d("label",wt,S(p.title),1)])):b("",!0),p.child&&C.value[p.id]?(i(!0),v(P,{key:2},R(p.child,O=>(i(),v("div",{class:"tree-child",key:p.id},[O.type!="chapter"?(i(),v("div",{key:0,class:"item-box",draggable:"",onDragstart:ue=>V(ue,O.chartConfig),onDragend:H},[g(s(W),{class:"list-img",chartConfig:O.chartConfig},null,8,["chartConfig"]),d("span",Dt,S(O.title),1)],40,At)):b("",!0)]))),128)):b("",!0)]))),128)):b("",!0)])]))),128))]),_:1})])])):b("",!0),e.menu!="Charts"&&e.menu!="Tables"?(i(),v("div",Lt,[g(ie,{class:"chart-menu-width",value:$.value,"onUpdate:value":[n[1]||(n[1]=m=>$.value=m),re],options:s(u).menuOptions,"icon-size":16,indent:18},null,8,["value","options"]),d("div",Tt,[g(q,null,{default:D(()=>[g(s(a),{menuOptions:s(u).selectOptions},null,8,["menuOptions"])]),_:1})])])):b("",!0)])}}});var Pt=ne(Nt,[["__scopeId","data-v-1e61a0d5"]]);const Rt=xe(),$t=y(Rt.getAppTheme);oe();const{getCharts:zt}=we(oe()),Ft=Ae({id:"usePackagesStore",state:()=>({packagesList:Object.freeze(ze)}),getters:{getPackagesList(){return this.packagesList}}}),{TableSplitIcon:Bt,RoadmapIcon:Ut,SpellCheckIcon:Kt,GraphicalDataFlowIcon:Gt}=se.carbon,{getPackagesList:Z}=Ft(),k=[],ee={[T.CHARTS]:{icon:L(Ut),label:N.CHARTS},[T.INFORMATIONS]:{icon:L(Kt),label:N.INFORMATIONS},[T.TABLES]:{icon:L(Bt),label:N.TABLES},[T.DECORATES]:{icon:L(Gt),label:N.DECORATES}},Vt=()=>{for(const e in Z)k.push({key:e,icon:ee[e].icon,label:ee[e].label,list:Z[e]})};Vt();k[0].key;const A=y(k[0].key),B=y(k[0]),Ht=e=>{for(const t in k)k[t].key==e&&(B.value=k[t])};const Mt={class:"menu-width-box"},jt={class:"menu-component-box"},Yt=U({__name:"index",setup(e){return De(t=>({"39b2b54d":s($t)})),(t,a)=>{const l=E("n-tab-pane"),o=E("n-tabs");return i(),F(s(Ne),{class:Te(["go-content-charts",{scoped:!s(zt)}]),backIcon:!1},{default:D(()=>[d("aside",null,[d("div",Mt,[g(o,{value:s(A),"onUpdate:value":[a[0]||(a[0]=c=>Le(A)?A.value=c:null),s(Ht)],class:"tabs-box",size:"small",type:"segment"},{default:D(()=>[(i(!0),v(P,null,R(s(k),c=>(i(),F(l,{key:c.key,name:c.key,size:"small","display-directive":"show:lazy"},{tab:D(()=>[d("span",null,S(c.label),1)]),_:2},1032,["name"]))),128))]),_:1},8,["value","onUpdate:value"]),d("div",jt,[s(B)?(i(),F(s(Pt),{selectOptions:s(B),menu:s(A),key:s(A)},null,8,["selectOptions","menu"])):b("",!0)])])])]),_:1},8,["class"])}}});var qt=ne(Yt,[["__scopeId","data-v-0154e46d"]]),sa=Object.freeze(Object.defineProperty({__proto__:null,default:qt},Symbol.toStringTag,{value:"Module"}));export{W as _,sa as i,gt as o};
