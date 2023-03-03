import{j as X,d as Y,a3 as Z,an as _,v as T,a5 as $,R as ee,r,o as n,c,w as t,e as o,f as u,m as b,A as x,F as D,ab as N,z as R,t as G,L as d}from"./index.js";import{l as i}from"./index-4a2c1888.js";import{i as te}from"./icon-f0dc0744.js";import{C as oe}from"./index-78724c3d.js";import{u as P,C as H}from"./chartLayoutStore-6d7968c4.js";import{u as ae}from"./chartEditStore-0ecb3acc.js";import"./index-8c763e67.js";import"./index-bea68e1b.js";import"./plugin-56c77659.js";var l=(s=>(s.PAGE_SETTING="pageSetting",s.PAGE_SELECT="pageSelect",s.CHART_SETTING="chartSetting",s.CHART_ANIMATION="chartAnimation",s.CHART_DATA="chartData",s.CHART_EVENT="chartEvent",s))(l||{});const ne=Y({__name:"index",setup(s){const{getDetails:E}=Z(P()),{setItem:A}=P(),p=ae(),{ConstructIcon:w,DesktopOutlineIcon:z,LeafIcon:V,SearchIcon:B}=te.ionicons5,O=i(()=>_(()=>import("./index-066e0a3b.js"),["static/js/index-066e0a3b.js","static/css/index-60aedfec.css","static/js/chartEditStore-0ecb3acc.js","static/js/index.js","static/css/index-0098e772.css","static/js/plugin-56c77659.js","static/js/icon-f0dc0744.js","static/js/index-4a2c1888.js","static/css/index-3cd64027.css","static/js/index-8c763e67.js","static/js/index-bea68e1b.js","static/css/index-c496491e.css","static/js/index-79642362.js","static/css/index-02bb4650.css","static/js/table_scrollboard-244f78f2.js","static/js/SizeSetting.vue_vue_type_style_index_0_scoped_true_lang-e8facb4f.js","static/css/SizeSetting.vue_vue_type_style_index_0_scoped_true_lang-ebd7ea3d.css","static/js/useTargetData.hook-003f1f6b.js","static/js/chartLayoutStore-6d7968c4.js","static/js/index-78724c3d.js","static/css/index-d494d603.css","static/js/index-973958dc.js","static/css/index-0134c4e2.css"])),F=i(()=>_(()=>import("./index-53a84c6a.js"),["static/js/index-53a84c6a.js","static/css/index-bbeb5e87.css","static/js/chartEditStore-0ecb3acc.js","static/js/index.js","static/css/index-0098e772.css","static/js/plugin-56c77659.js","static/js/icon-f0dc0744.js"])),M=i(()=>_(()=>import("./index-7cc6ec80.js"),["static/js/index-7cc6ec80.js","static/css/index-fc2b3335.css","static/js/index.js","static/css/index-0098e772.css"])),U=i(()=>_(()=>import("./index-b487da15.js"),["static/js/index-b487da15.js","static/css/index-62f72887.css","static/js/useTargetData.hook-003f1f6b.js","static/js/chartEditStore-0ecb3acc.js","static/js/index.js","static/css/index-0098e772.css","static/js/plugin-56c77659.js","static/js/icon-f0dc0744.js"])),j=i(()=>_(()=>import("./index-352d9161.js"),["static/js/index-352d9161.js","static/css/index-9ce893cd.css","static/js/index.js","static/css/index-0098e772.css","static/js/SizeSetting.vue_vue_type_style_index_0_scoped_true_lang-e8facb4f.js","static/css/SizeSetting.vue_vue_type_style_index_0_scoped_true_lang-ebd7ea3d.css","static/js/useTargetData.hook-003f1f6b.js","static/js/chartEditStore-0ecb3acc.js","static/js/plugin-56c77659.js","static/js/icon-f0dc0744.js"])),m=T(E.value),f=T(l.CHART_SETTING),C=T(l.PAGE_SETTING),y=()=>{m.value=!0,A(H.DETAILS,!0)},I=()=>{m.value=!1,A(H.DETAILS,!1)},g=$(()=>{if(p.getTargetChart.selectId.length!==1)return;const a=p.componentList[p.fetchTargetIndex()];return a!=null&&a.isGroup&&(f.value=l.CHART_SETTING),a});ee(E,v=>{v?y():I()});const q=[{key:l.PAGE_SETTING,title:"\u9875\u9762\u914D\u7F6E",icon:z,render:F},{key:l.PAGE_SELECT,title:"\u5168\u5C40\u7B5B\u9009\u5668",icon:B,render:M}],J=[{key:l.CHART_SETTING,title:"\u57FA\u672C\u4FE1\u606F",icon:w,render:U},{key:l.CHART_ANIMATION,title:"\u52A8\u753B",icon:V,render:j}];return(v,a)=>{const K=r("n-layout-content"),S=r("n-icon"),h=r("n-space"),L=r("n-tab-pane"),k=r("n-tabs"),Q=r("n-layout-sider"),W=r("n-layout");return n(),c(W,{"has-sider":"","sider-placement":"right"},{default:t(()=>[o(K,null,{default:t(()=>[o(u(O))]),_:1}),o(Q,{"collapse-mode":"transform","collapsed-width":0,width:350,collapsed:m.value,"native-scrollbar":!1,"show-trigger":"bar",onCollapse:y,onExpand:I},{default:t(()=>[o(u(oe),{class:"go-content-configurations go-boderbox","show-top":!1,depth:2},{default:t(()=>[u(g)?N("",!0):(n(),c(k,{key:0,value:C.value,"onUpdate:value":a[0]||(a[0]=e=>C.value=e),class:"tabs-box",size:"small",type:"segment"},{default:t(()=>[(n(),b(D,null,x(q,e=>o(L,{key:e.key,name:e.key,size:"small","display-directive":"show:lazy"},{tab:t(()=>[o(h,null,{default:t(()=>[R("span",null,G(e.title),1),o(S,{size:"16",class:"icon-position"},{default:t(()=>[(n(),c(d(e.icon)))]),_:2},1024)]),_:2},1024)]),default:t(()=>[(n(),c(d(e.render)))]),_:2},1032,["name"])),64))]),_:1},8,["value"])),u(g)?(n(),c(k,{key:1,value:f.value,"onUpdate:value":a[1]||(a[1]=e=>f.value=e),class:"tabs-box",size:"small",type:"segment"},{default:t(()=>[(n(),b(D,null,x(J,e=>o(L,{key:e.key,name:e.key,size:"small","display-directive":"show:lazy"},{tab:t(()=>[o(h,null,{default:t(()=>[R("span",null,G(e.title),1),o(S,{size:"16",class:"icon-position"},{default:t(()=>[(n(),c(d(e.icon)))]),_:2},1024)]),_:2},1024)]),default:t(()=>[(n(),c(d(e.render)))]),_:2},1032,["name"])),64))]),_:1},8,["value"])):N("",!0)]),_:1})]),_:1},8,["collapsed"])]),_:1})}}});var me=X(ne,[["__scopeId","data-v-d3257386"]]);export{me as default};
