import{d as f,o as d,c as m,u as p,R as h,a as _,b as y,e as g}from"./vendor.54701247.js";const P=function(){const s=document.createElement("link").relList;if(s&&s.supports&&s.supports("modulepreload"))return;for(const e of document.querySelectorAll('link[rel="modulepreload"]'))o(e);new MutationObserver(e=>{for(const t of e)if(t.type==="childList")for(const r of t.addedNodes)r.tagName==="LINK"&&r.rel==="modulepreload"&&o(r)}).observe(document,{childList:!0,subtree:!0});function n(e){const t={};return e.integrity&&(t.integrity=e.integrity),e.referrerpolicy&&(t.referrerPolicy=e.referrerpolicy),e.crossorigin==="use-credentials"?t.credentials="include":e.crossorigin==="anonymous"?t.credentials="omit":t.credentials="same-origin",t}function o(e){if(e.ep)return;e.ep=!0;const t=n(e);fetch(e.href,t)}};P();const L=f({setup(c){return(s,n)=>(d(),m(p(h)))}}),v="modulepreload",i={},E="/dzb-client/",l=function(s,n){return!n||n.length===0?s():Promise.all(n.map(o=>{if(o=`${E}${o}`,o in i)return;i[o]=!0;const e=o.endsWith(".css"),t=e?'[rel="stylesheet"]':"";if(document.querySelector(`link[href="${o}"]${t}`))return;const r=document.createElement("link");if(r.rel=e?"stylesheet":v,e||(r.as="script",r.crossOrigin=""),r.href=o,document.head.appendChild(r),e)return new Promise((a,u)=>{r.addEventListener("load",a),r.addEventListener("error",u)})})).then(()=>s())},R="/dzb-client/",O=R,b=()=>l(()=>import("./HomePage.3f642a08.js"),["assets/HomePage.3f642a08.js","assets/HomePage.e70cd0ca.css","assets/AppTag.dd3d668f.js","assets/AppTag.aef3a35f.css","assets/vendor.54701247.js"]),j=()=>l(()=>import("./ProjectPage.832df859.js"),["assets/ProjectPage.832df859.js","assets/ProjectPage.0dd3a6cd.css","assets/vendor.54701247.js","assets/AppTag.dd3d668f.js","assets/AppTag.aef3a35f.css"]),k=_({scrollBehavior(c,s,n){return n||{top:0}},history:y(O),routes:[{path:"/",component:b,name:"home"},{path:"/project",component:j,name:"project"}]});g(L).use(k).mount("#app");
