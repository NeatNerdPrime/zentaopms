import{r as t,h as s,F as i}from"./p-1f29e0e0.js";const n=class{constructor(s){t(this,s),this.editor=void 0,this.forceUpdateCounter=void 0,this.toggleFullscreen=null,this.showCharCount=!0}render(){const t=this.editor.storage.characterCount.characters();return s(i,null,this.showCharCount?s("span",null,t," character",t>1?"s":"","."):s("div",null),this.toggleFullscreen&&s("button",{id:"fullscreen-button",onClick:this.toggleFullscreen},"Toggle Fullscreen"))}};export{n as zen_editor_footer}