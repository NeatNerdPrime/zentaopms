import{j as x,d as g,r as l,o as s,m as i,e as o,w as t,p as k,t as w,z as r,n,X as y,Y as B,f as C,ab as S,c as u,ad as f}from"./index.js";import{i as $}from"./icon-f0dc0744.js";const N={key:0,class:"top go-mt-0 go-flex-no-wrap"},T={class:"mt-1"},z=g({__name:"index",props:{title:String,showTop:{type:Boolean,default:!0},showBottom:{type:Boolean,default:!1},flex:{type:Boolean,default:!1},backIcon:{type:Boolean,default:!0},depth:{type:Number,default:1},xScroll:{type:Boolean,default:!1},disabledScroll:{type:Boolean,default:!1}},emits:["back"],setup(e,{emit:m}){const{ChevronBackOutlineIcon:p}=$.ionicons5,h=()=>{m("back")};return(a,I)=>{const _=l("n-text"),v=l("n-ellipsis"),d=l("n-space"),b=l("n-icon"),c=l("n-scrollbar");return s(),i("div",{class:f(["go-content-box",[`bg-depth${e.depth}`,e.flex&&"flex"]])},[e.showTop?(s(),i("div",N,[o(d,{class:"go-flex-no-wrap",size:5},{default:t(()=>[o(v,null,{default:t(()=>[o(_,null,{default:t(()=>[k(w(e.title),1)]),_:1})]),_:1}),r("div",T,[n(a.$slots,"icon",{},void 0,!0)])]),_:3}),o(d,{align:"center",style:{gap:"4px"}},{default:t(()=>[n(a.$slots,"top-right",{},void 0,!0),y(o(b,{size:"20",class:"go-cursor-pointer go-d-block",onClick:h},{default:t(()=>[o(C(p))]),_:1},512),[[B,e.backIcon]])]),_:3})])):S("",!0),r("div",{class:f(["content",{"content-height-show-top-bottom":e.showBottom||e.showTop,"content-height-show-both":e.showBottom&&e.showTop}])},[e.disabledScroll?n(a.$slots,"default",{key:0},void 0,!0):e.xScroll?(s(),u(c,{key:1,"x-scrollable":""},{default:t(()=>[o(c,null,{default:t(()=>[n(a.$slots,"default",{},void 0,!0)]),_:3})]),_:3})):(s(),u(c,{key:2},{default:t(()=>[n(a.$slots,"default",{},void 0,!0)]),_:3}))],2)],2)}}});var j=x(z,[["__scopeId","data-v-68712d9e"]]);export{j as C};
