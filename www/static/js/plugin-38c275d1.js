var k=Object.defineProperty,p=Object.defineProperties;var T=Object.getOwnPropertyDescriptors;var R=Object.getOwnPropertySymbols;var F=Object.prototype.hasOwnProperty,I=Object.prototype.propertyIsEnumerable;var v=(e,o,i)=>o in e?k(e,o,{enumerable:!0,configurable:!0,writable:!0,value:i}):e[o]=i,N=(e,o)=>{for(var i in o||(o={}))F.call(o,i)&&v(e,i,o[i]);if(R)for(var i of R(o))I.call(o,i)&&v(e,i,o[i]);return e},E=(e,o)=>p(e,T(o));var C=(e,o,i)=>new Promise((n,u)=>{var c=s=>{try{r(i.next(s))}catch(t){u(t)}},g=s=>{try{r(i.throw(s))}catch(t){u(t)}},r=s=>s.done?n(s.value):Promise.resolve(s.value).then(c,g);r((i=i.apply(e,o)).next())});import{a1 as S,af as D,ag as $}from"./index.js";import{i as x}from"./icon-e0acebb0.js";var a=(e=>(e.DELETE="delete",e.WARNING="warning",e.ERROR="error",e.SUCCESS="success",e))(a||{});const{InformationCircleIcon:A}=x.ionicons5,W=()=>{window.$loading.start()},h=()=>{setTimeout(()=>{window.$loading.finish()})},O=()=>{setTimeout(()=>{window.$loading.error()})},j=e=>{const{type:o,title:i,message:n,positiveText:u,negativeText:c,closeNegativeText:g,isMaskClosable:r,onPositiveCallback:s,onNegativeCallback:t,promise:b,promiseResCallback:w,promiseRejCallback:m}=e,f={[a.DELETE]:{fn:window.$dialog.warning,message:n||"\u662F\u5426\u5220\u9664\u6B64\u6570\u636E?"},[a.WARNING]:{fn:window.$dialog.warning,message:n||"\u662F\u5426\u6267\u884C\u6B64\u64CD\u4F5C?"},[a.ERROR]:{fn:window.$dialog.error,message:n||"\u662F\u5426\u6267\u884C\u6B64\u64CD\u4F5C?"},[a.SUCCESS]:{fn:window.$dialog.success,message:n||"\u662F\u5426\u6267\u884C\u6B64\u64CD\u4F5C?"}},l=f[o||a.WARNING].fn(E(N({},e),{title:i||"\u63D0\u793A",icon:S(A,{size:D}),content:f[o||a.WARNING].message,positiveText:u||"\u786E\u5B9A",negativeText:g?void 0:c||"\u53D6\u6D88",maskClosable:r||$,onPositiveClick:()=>C(void 0,null,function*(){if(b&&s){l.loading=!0;try{const d=yield s();w&&w(d)}catch(d){m&&m(d)}l.loading=!1;return}s&&s(l)}),onNegativeClick:()=>C(void 0,null,function*(){t&&t(l)})}))};export{a as D,W as a,h as b,j as g,O as l};
