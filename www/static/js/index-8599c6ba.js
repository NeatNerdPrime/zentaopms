import{u as m}from"./chartLayoutStore-2204b84d.js";import{d as i,u as _,v as s,a5 as d,R as f,r,o as h,c as g,w as v,z as a,e as C,f as x}from"./index.js";import"./chartEditStore-08ee2722.js";import"./plugin-38c275d1.js";import"./icon-e0acebb0.js";const w=a("span",null," \u62FC\u547D\u52A0\u8F7D\u4E2D... ",-1),L=i({__name:"index",setup(y){const n=m(),c=_(),o=s(!1),t=s(0),u=d(()=>c.getAppTheme);return f(()=>n.getPercentage,e=>{if(e===0){setTimeout(()=>{t.value=e,o.value=!1},500);return}t.value=e,o.value=e>0}),(e,D)=>{const l=r("n-progress"),p=r("n-modal");return h(),g(p,{show:o.value,"close-on-esc":!1,"transform-origin":"center"},{default:v(()=>[a("div",null,[w,C(l,{type:"line",color:x(u),percentage:t.value,style:{width:"300px"}},null,8,["color","percentage"])])]),_:1},8,["show"])}}});export{L as default};
