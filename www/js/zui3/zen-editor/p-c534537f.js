import{m as t}from"./p-231078b1.js";import"./p-1f29e0e0.js";
/*!-----------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 * Version: 0.45.0(5e5af013f8d295555a7210df0d5f2cea0bf5dd56)
 * Released under the MIT license
 * https://github.com/microsoft/monaco-editor/blob/main/LICENSE.txt
 *-----------------------------------------------------------------------------*/var n=Object.defineProperty,r=Object.getOwnPropertyDescriptor,e=Object.getOwnPropertyNames,i=Object.prototype.hasOwnProperty,o=(t,o,u,s)=>{if(o&&"object"==typeof o||"function"==typeof o)for(let c of e(o))i.call(t,c)||c===u||n(t,c,{get:()=>o[c],enumerable:!(s=r(o,c))||s.enumerable});return t},u={};o(u,t,"default");var s,c,a,f,h,v,d,l,g,w,m,b,p,j,x,k,I,y,O,E,_,S,T,R,C,D,N,W,L,A,M,F,z,U,H,$,q,P,V,B,G,J,K,Q,X,Y,Z,tt,nt,rt=class{_defaults;_idleCheckInterval;_lastUsedTime;_configChangeListener;_worker;_client;constructor(t){this._defaults=t,this._worker=null,this._client=null,this._idleCheckInterval=window.setInterval((()=>this._checkIfIdle()),3e4),this._lastUsedTime=0,this._configChangeListener=this._defaults.onDidChange((()=>this._stopWorker()))}_stopWorker(){this._worker&&(this._worker.dispose(),this._worker=null),this._client=null}dispose(){clearInterval(this._idleCheckInterval),this._configChangeListener.dispose(),this._stopWorker()}_checkIfIdle(){this._worker&&Date.now()-this._lastUsedTime>12e4&&this._stopWorker()}_getClient(){return this._lastUsedTime=Date.now(),this._client||(this._worker=u.editor.createWebWorker({moduleId:"vs/language/html/htmlWorker",createData:{languageSettings:this._defaults.options,languageId:this._defaults.languageId},label:this._defaults.languageId}),this._client=this._worker.getProxy()),this._client}getLanguageServiceWorker(...t){let n;return this._getClient().then((t=>{n=t})).then((()=>{if(this._worker)return this._worker.withSyncedResources(t)})).then((()=>n))}};(c=s||(s={})).MIN_VALUE=-2147483648,c.MAX_VALUE=2147483647,(f=a||(a={})).MIN_VALUE=0,f.MAX_VALUE=2147483647,(v=h||(h={})).create=function(t,n){return t===Number.MAX_VALUE&&(t=a.MAX_VALUE),n===Number.MAX_VALUE&&(n=a.MAX_VALUE),{line:t,character:n}},v.is=function(t){var n=t;return rn.objectLiteral(n)&&rn.uinteger(n.line)&&rn.uinteger(n.character)},(l=d||(d={})).create=function(t,n,r,e){if(rn.uinteger(t)&&rn.uinteger(n)&&rn.uinteger(r)&&rn.uinteger(e))return{start:h.create(t,n),end:h.create(r,e)};if(h.is(t)&&h.is(n))return{start:t,end:n};throw new Error("Range#create called with invalid arguments["+t+", "+n+", "+r+", "+e+"]")},l.is=function(t){var n=t;return rn.objectLiteral(n)&&h.is(n.start)&&h.is(n.end)},(w=g||(g={})).create=function(t,n){return{uri:t,range:n}},w.is=function(t){var n=t;return rn.defined(n)&&d.is(n.range)&&(rn.string(n.uri)||rn.undefined(n.uri))},(b=m||(m={})).create=function(t,n,r,e){return{targetUri:t,targetRange:n,targetSelectionRange:r,originSelectionRange:e}},b.is=function(t){var n=t;return rn.defined(n)&&d.is(n.targetRange)&&rn.string(n.targetUri)&&(d.is(n.targetSelectionRange)||rn.undefined(n.targetSelectionRange))&&(d.is(n.originSelectionRange)||rn.undefined(n.originSelectionRange))},(j=p||(p={})).create=function(t,n,r,e){return{red:t,green:n,blue:r,alpha:e}},j.is=function(t){var n=t;return rn.numberRange(n.red,0,1)&&rn.numberRange(n.green,0,1)&&rn.numberRange(n.blue,0,1)&&rn.numberRange(n.alpha,0,1)},(k=x||(x={})).create=function(t,n){return{range:t,color:n}},k.is=function(t){var n=t;return d.is(n.range)&&p.is(n.color)},(y=I||(I={})).create=function(t,n,r){return{label:t,textEdit:n,additionalTextEdits:r}},y.is=function(t){var n=t;return rn.string(n.label)&&(rn.undefined(n.textEdit)||U.is(n))&&(rn.undefined(n.additionalTextEdits)||rn.typedArray(n.additionalTextEdits,U.is))},(E=O||(O={})).Comment="comment",E.Imports="imports",E.Region="region",(S=_||(_={})).create=function(t,n,r,e,i){var o={startLine:t,endLine:n};return rn.defined(r)&&(o.startCharacter=r),rn.defined(e)&&(o.endCharacter=e),rn.defined(i)&&(o.kind=i),o},S.is=function(t){var n=t;return rn.uinteger(n.startLine)&&rn.uinteger(n.startLine)&&(rn.undefined(n.startCharacter)||rn.uinteger(n.startCharacter))&&(rn.undefined(n.endCharacter)||rn.uinteger(n.endCharacter))&&(rn.undefined(n.kind)||rn.string(n.kind))},(R=T||(T={})).create=function(t,n){return{location:t,message:n}},R.is=function(t){var n=t;return rn.defined(n)&&g.is(n.location)&&rn.string(n.message)},(D=C||(C={})).Error=1,D.Warning=2,D.Information=3,D.Hint=4,(W=N||(N={})).Unnecessary=1,W.Deprecated=2,(L||(L={})).is=function(t){return null!=t&&rn.string(t.href)},(M=A||(A={})).create=function(t,n,r,e,i,o){var u={range:t,message:n};return rn.defined(r)&&(u.severity=r),rn.defined(e)&&(u.code=e),rn.defined(i)&&(u.source=i),rn.defined(o)&&(u.relatedInformation=o),u},M.is=function(t){var n,r=t;return rn.defined(r)&&d.is(r.range)&&rn.string(r.message)&&(rn.number(r.severity)||rn.undefined(r.severity))&&(rn.integer(r.code)||rn.string(r.code)||rn.undefined(r.code))&&(rn.undefined(r.codeDescription)||rn.string(null===(n=r.codeDescription)||void 0===n?void 0:n.href))&&(rn.string(r.source)||rn.undefined(r.source))&&(rn.undefined(r.relatedInformation)||rn.typedArray(r.relatedInformation,T.is))},(z=F||(F={})).create=function(t,n){for(var r=[],e=2;e<arguments.length;e++)r[e-2]=arguments[e];var i={title:t,command:n};return rn.defined(r)&&r.length>0&&(i.arguments=r),i},z.is=function(t){var n=t;return rn.defined(n)&&rn.string(n.title)&&rn.string(n.command)},(H=U||(U={})).replace=function(t,n){return{range:t,newText:n}},H.insert=function(t,n){return{range:{start:t,end:t},newText:n}},H.del=function(t){return{range:t,newText:""}},H.is=function(t){var n=t;return rn.objectLiteral(n)&&rn.string(n.newText)&&d.is(n.range)},(q=$||($={})).create=function(t,n,r){var e={label:t};return void 0!==n&&(e.needsConfirmation=n),void 0!==r&&(e.description=r),e},q.is=function(t){var n=t;return void 0!==n&&rn.objectLiteral(n)&&rn.string(n.label)&&(rn.boolean(n.needsConfirmation)||void 0===n.needsConfirmation)&&(rn.string(n.description)||void 0===n.description)},(P||(P={})).is=function(t){return"string"==typeof t},(B=V||(V={})).replace=function(t,n,r){return{range:t,newText:n,annotationId:r}},B.insert=function(t,n,r){return{range:{start:t,end:t},newText:n,annotationId:r}},B.del=function(t,n){return{range:t,newText:"",annotationId:n}},B.is=function(t){var n=t;return U.is(n)&&($.is(n.annotationId)||P.is(n.annotationId))},(J=G||(G={})).create=function(t,n){return{textDocument:t,edits:n}},J.is=function(t){var n=t;return rn.defined(n)&&st.is(n.textDocument)&&Array.isArray(n.edits)},(Q=K||(K={})).create=function(t,n,r){var e={kind:"create",uri:t};return void 0===n||void 0===n.overwrite&&void 0===n.ignoreIfExists||(e.options=n),void 0!==r&&(e.annotationId=r),e},Q.is=function(t){var n=t;return n&&"create"===n.kind&&rn.string(n.uri)&&(void 0===n.options||(void 0===n.options.overwrite||rn.boolean(n.options.overwrite))&&(void 0===n.options.ignoreIfExists||rn.boolean(n.options.ignoreIfExists)))&&(void 0===n.annotationId||P.is(n.annotationId))},(Y=X||(X={})).create=function(t,n,r,e){var i={kind:"rename",oldUri:t,newUri:n};return void 0===r||void 0===r.overwrite&&void 0===r.ignoreIfExists||(i.options=r),void 0!==e&&(i.annotationId=e),i},Y.is=function(t){var n=t;return n&&"rename"===n.kind&&rn.string(n.oldUri)&&rn.string(n.newUri)&&(void 0===n.options||(void 0===n.options.overwrite||rn.boolean(n.options.overwrite))&&(void 0===n.options.ignoreIfExists||rn.boolean(n.options.ignoreIfExists)))&&(void 0===n.annotationId||P.is(n.annotationId))},(tt=Z||(Z={})).create=function(t,n,r){var e={kind:"delete",uri:t};return void 0===n||void 0===n.recursive&&void 0===n.ignoreIfNotExists||(e.options=n),void 0!==r&&(e.annotationId=r),e},tt.is=function(t){var n=t;return n&&"delete"===n.kind&&rn.string(n.uri)&&(void 0===n.options||(void 0===n.options.recursive||rn.boolean(n.options.recursive))&&(void 0===n.options.ignoreIfNotExists||rn.boolean(n.options.ignoreIfNotExists)))&&(void 0===n.annotationId||P.is(n.annotationId))},(nt||(nt={})).is=function(t){return t&&(void 0!==t.changes||void 0!==t.documentChanges)&&(void 0===t.documentChanges||t.documentChanges.every((function(t){return rn.string(t.kind)?K.is(t)||X.is(t)||Z.is(t):G.is(t)})))};var et,it,ot,ut,st,ct,at,ft,ht,vt,dt,lt,gt,wt,mt,bt,pt,jt,xt,kt,It,yt,Ot,Et,_t,St,Tt,Rt,Ct,Dt,Nt,Wt,Lt,At,Mt,Ft,zt,Ut,Ht,$t,qt,Pt,Vt,Bt,Gt,Jt,Kt,Qt,Xt,Yt,Zt,tn=function(){function t(t,n){this.edits=t,this.changeAnnotations=n}return t.prototype.insert=function(t,n,r){var e,i;if(void 0===r?e=U.insert(t,n):P.is(r)?(i=r,e=V.insert(t,n,r)):(this.assertChangeAnnotations(this.changeAnnotations),i=this.changeAnnotations.manage(r),e=V.insert(t,n,i)),this.edits.push(e),void 0!==i)return i},t.prototype.replace=function(t,n,r){var e,i;if(void 0===r?e=U.replace(t,n):P.is(r)?(i=r,e=V.replace(t,n,r)):(this.assertChangeAnnotations(this.changeAnnotations),i=this.changeAnnotations.manage(r),e=V.replace(t,n,i)),this.edits.push(e),void 0!==i)return i},t.prototype.delete=function(t,n){var r,e;if(void 0===n?r=U.del(t):P.is(n)?(e=n,r=V.del(t,n)):(this.assertChangeAnnotations(this.changeAnnotations),e=this.changeAnnotations.manage(n),r=V.del(t,e)),this.edits.push(r),void 0!==e)return e},t.prototype.add=function(t){this.edits.push(t)},t.prototype.all=function(){return this.edits},t.prototype.clear=function(){this.edits.splice(0,this.edits.length)},t.prototype.assertChangeAnnotations=function(t){if(void 0===t)throw new Error("Text edit change is not configured to manage change annotations.")},t}(),nn=function(){function t(t){this._annotations=void 0===t?Object.create(null):t,this._counter=0,this._size=0}return t.prototype.all=function(){return this._annotations},Object.defineProperty(t.prototype,"size",{get:function(){return this._size},enumerable:!1,configurable:!0}),t.prototype.manage=function(t,n){var r;if(P.is(t)?r=t:(r=this.nextId(),n=t),void 0!==this._annotations[r])throw new Error("Id "+r+" is already in use.");if(void 0===n)throw new Error("No annotation provided for id "+r);return this._annotations[r]=n,this._size++,r},t.prototype.nextId=function(){return this._counter++,this._counter.toString()},t}();!function(){function t(t){var n=this;this._textEditChanges=Object.create(null),void 0!==t?(this._workspaceEdit=t,t.documentChanges?(this._changeAnnotations=new nn(t.changeAnnotations),t.changeAnnotations=this._changeAnnotations.all(),t.documentChanges.forEach((function(t){if(G.is(t)){var r=new tn(t.edits,n._changeAnnotations);n._textEditChanges[t.textDocument.uri]=r}}))):t.changes&&Object.keys(t.changes).forEach((function(r){var e=new tn(t.changes[r]);n._textEditChanges[r]=e}))):this._workspaceEdit={}}Object.defineProperty(t.prototype,"edit",{get:function(){return this.initDocumentChanges(),void 0!==this._changeAnnotations&&(this._workspaceEdit.changeAnnotations=0===this._changeAnnotations.size?void 0:this._changeAnnotations.all()),this._workspaceEdit},enumerable:!1,configurable:!0}),t.prototype.getTextEditChange=function(t){if(st.is(t)){if(this.initDocumentChanges(),void 0===this._workspaceEdit.documentChanges)throw new Error("Workspace edit is not configured for document changes.");var n={uri:t.uri,version:t.version};return(r=this._textEditChanges[n.uri])||(this._workspaceEdit.documentChanges.push({textDocument:n,edits:e=[]}),r=new tn(e,this._changeAnnotations),this._textEditChanges[n.uri]=r),r}if(this.initChanges(),void 0===this._workspaceEdit.changes)throw new Error("Workspace edit is not configured for normal text edit changes.");var r,e;return(r=this._textEditChanges[t])||(this._workspaceEdit.changes[t]=e=[],r=new tn(e),this._textEditChanges[t]=r),r},t.prototype.initDocumentChanges=function(){void 0===this._workspaceEdit.documentChanges&&void 0===this._workspaceEdit.changes&&(this._changeAnnotations=new nn,this._workspaceEdit.documentChanges=[],this._workspaceEdit.changeAnnotations=this._changeAnnotations.all())},t.prototype.initChanges=function(){void 0===this._workspaceEdit.documentChanges&&void 0===this._workspaceEdit.changes&&(this._workspaceEdit.changes=Object.create(null))},t.prototype.createFile=function(t,n,r){if(this.initDocumentChanges(),void 0===this._workspaceEdit.documentChanges)throw new Error("Workspace edit is not configured for document changes.");var e,i,o;if($.is(n)||P.is(n)?e=n:r=n,void 0===e?i=K.create(t,r):(o=P.is(e)?e:this._changeAnnotations.manage(e),i=K.create(t,r,o)),this._workspaceEdit.documentChanges.push(i),void 0!==o)return o},t.prototype.renameFile=function(t,n,r,e){if(this.initDocumentChanges(),void 0===this._workspaceEdit.documentChanges)throw new Error("Workspace edit is not configured for document changes.");var i,o,u;if($.is(r)||P.is(r)?i=r:e=r,void 0===i?o=X.create(t,n,e):(u=P.is(i)?i:this._changeAnnotations.manage(i),o=X.create(t,n,e,u)),this._workspaceEdit.documentChanges.push(o),void 0!==u)return u},t.prototype.deleteFile=function(t,n,r){if(this.initDocumentChanges(),void 0===this._workspaceEdit.documentChanges)throw new Error("Workspace edit is not configured for document changes.");var e,i,o;if($.is(n)||P.is(n)?e=n:r=n,void 0===e?i=Z.create(t,r):(o=P.is(e)?e:this._changeAnnotations.manage(e),i=Z.create(t,r,o)),this._workspaceEdit.documentChanges.push(i),void 0!==o)return o}}(),(it=et||(et={})).create=function(t){return{uri:t}},it.is=function(t){var n=t;return rn.defined(n)&&rn.string(n.uri)},(ut=ot||(ot={})).create=function(t,n){return{uri:t,version:n}},ut.is=function(t){var n=t;return rn.defined(n)&&rn.string(n.uri)&&rn.integer(n.version)},(ct=st||(st={})).create=function(t,n){return{uri:t,version:n}},ct.is=function(t){var n=t;return rn.defined(n)&&rn.string(n.uri)&&(null===n.version||rn.integer(n.version))},(ft=at||(at={})).create=function(t,n,r,e){return{uri:t,languageId:n,version:r,text:e}},ft.is=function(t){var n=t;return rn.defined(n)&&rn.string(n.uri)&&rn.string(n.languageId)&&rn.integer(n.version)&&rn.string(n.text)},(vt=ht||(ht={})).PlainText="plaintext",vt.Markdown="markdown",function(t){t.is=function(n){return n===t.PlainText||n===t.Markdown}}(ht||(ht={})),(dt||(dt={})).is=function(t){var n=t;return rn.objectLiteral(t)&&ht.is(n.kind)&&rn.string(n.value)},(gt=lt||(lt={})).Text=1,gt.Method=2,gt.Function=3,gt.Constructor=4,gt.Field=5,gt.Variable=6,gt.Class=7,gt.Interface=8,gt.Module=9,gt.Property=10,gt.Unit=11,gt.Value=12,gt.Enum=13,gt.Keyword=14,gt.Snippet=15,gt.Color=16,gt.File=17,gt.Reference=18,gt.Folder=19,gt.EnumMember=20,gt.Constant=21,gt.Struct=22,gt.Event=23,gt.Operator=24,gt.TypeParameter=25,(mt=wt||(wt={})).PlainText=1,mt.Snippet=2,(bt||(bt={})).Deprecated=1,(jt=pt||(pt={})).create=function(t,n,r){return{newText:t,insert:n,replace:r}},jt.is=function(t){var n=t;return n&&rn.string(n.newText)&&d.is(n.insert)&&d.is(n.replace)},(kt=xt||(xt={})).asIs=1,kt.adjustIndentation=2,(It||(It={})).create=function(t){return{label:t}},(yt||(yt={})).create=function(t,n){return{items:t||[],isIncomplete:!!n}},(Et=Ot||(Ot={})).fromPlainText=function(t){return t.replace(/[\\`*_{}[\]()#+\-.!]/g,"\\$&")},Et.is=function(t){var n=t;return rn.string(n)||rn.objectLiteral(n)&&rn.string(n.language)&&rn.string(n.value)},(_t||(_t={})).is=function(t){var n=t;return!!n&&rn.objectLiteral(n)&&(dt.is(n.contents)||Ot.is(n.contents)||rn.typedArray(n.contents,Ot.is))&&(void 0===t.range||d.is(t.range))},(St||(St={})).create=function(t,n){return n?{label:t,documentation:n}:{label:t}},(Tt||(Tt={})).create=function(t,n){for(var r=[],e=2;e<arguments.length;e++)r[e-2]=arguments[e];var i={label:t};return rn.defined(n)&&(i.documentation=n),i.parameters=rn.defined(r)?r:[],i},(Ct=Rt||(Rt={})).Text=1,Ct.Read=2,Ct.Write=3,(Dt||(Dt={})).create=function(t,n){var r={range:t};return rn.number(n)&&(r.kind=n),r},(Wt=Nt||(Nt={})).File=1,Wt.Module=2,Wt.Namespace=3,Wt.Package=4,Wt.Class=5,Wt.Method=6,Wt.Property=7,Wt.Field=8,Wt.Constructor=9,Wt.Enum=10,Wt.Interface=11,Wt.Function=12,Wt.Variable=13,Wt.Constant=14,Wt.String=15,Wt.Number=16,Wt.Boolean=17,Wt.Array=18,Wt.Object=19,Wt.Key=20,Wt.Null=21,Wt.EnumMember=22,Wt.Struct=23,Wt.Event=24,Wt.Operator=25,Wt.TypeParameter=26,(Lt||(Lt={})).Deprecated=1,(At||(At={})).create=function(t,n,r,e,i){var o={name:t,kind:n,location:{uri:e,range:r}};return i&&(o.containerName=i),o},(Ft=Mt||(Mt={})).create=function(t,n,r,e,i,o){var u={name:t,detail:n,kind:r,range:e,selectionRange:i};return void 0!==o&&(u.children=o),u},Ft.is=function(t){var n=t;return n&&rn.string(n.name)&&rn.number(n.kind)&&d.is(n.range)&&d.is(n.selectionRange)&&(void 0===n.detail||rn.string(n.detail))&&(void 0===n.deprecated||rn.boolean(n.deprecated))&&(void 0===n.children||Array.isArray(n.children))&&(void 0===n.tags||Array.isArray(n.tags))},(Ut=zt||(zt={})).Empty="",Ut.QuickFix="quickfix",Ut.Refactor="refactor",Ut.RefactorExtract="refactor.extract",Ut.RefactorInline="refactor.inline",Ut.RefactorRewrite="refactor.rewrite",Ut.Source="source",Ut.SourceOrganizeImports="source.organizeImports",Ut.SourceFixAll="source.fixAll",($t=Ht||(Ht={})).create=function(t,n){var r={diagnostics:t};return null!=n&&(r.only=n),r},$t.is=function(t){var n=t;return rn.defined(n)&&rn.typedArray(n.diagnostics,A.is)&&(void 0===n.only||rn.typedArray(n.only,rn.string))},(Pt=qt||(qt={})).create=function(t,n,r){var e={title:t},i=!0;return"string"==typeof n?(i=!1,e.kind=n):F.is(n)?e.command=n:e.edit=n,i&&void 0!==r&&(e.kind=r),e},Pt.is=function(t){var n=t;return n&&rn.string(n.title)&&(void 0===n.diagnostics||rn.typedArray(n.diagnostics,A.is))&&(void 0===n.kind||rn.string(n.kind))&&(void 0!==n.edit||void 0!==n.command)&&(void 0===n.command||F.is(n.command))&&(void 0===n.isPreferred||rn.boolean(n.isPreferred))&&(void 0===n.edit||nt.is(n.edit))},(Bt=Vt||(Vt={})).create=function(t,n){var r={range:t};return rn.defined(n)&&(r.data=n),r},Bt.is=function(t){var n=t;return rn.defined(n)&&d.is(n.range)&&(rn.undefined(n.command)||F.is(n.command))},(Jt=Gt||(Gt={})).create=function(t,n){return{tabSize:t,insertSpaces:n}},Jt.is=function(t){var n=t;return rn.defined(n)&&rn.uinteger(n.tabSize)&&rn.boolean(n.insertSpaces)},(Qt=Kt||(Kt={})).create=function(t,n,r){return{range:t,target:n,data:r}},Qt.is=function(t){var n=t;return rn.defined(n)&&d.is(n.range)&&(rn.undefined(n.target)||rn.string(n.target))},(Yt=Xt||(Xt={})).create=function(t,n){return{range:t,parent:n}},Yt.is=function(t){var n=t;return void 0!==n&&d.is(n.range)&&(void 0===n.parent||Yt.is(n.parent))},function(t){function n(t,r){if(t.length<=1)return t;var e=t.length/2|0,i=t.slice(0,e),o=t.slice(e);n(i,r),n(o,r);for(var u=0,s=0,c=0;u<i.length&&s<o.length;){var a=r(i[u],o[s]);t[c++]=a<=0?i[u++]:o[s++]}for(;u<i.length;)t[c++]=i[u++];for(;s<o.length;)t[c++]=o[s++];return t}t.create=function(t,n,r,e){return new un(t,n,r,e)},t.is=function(t){var n=t;return!!(rn.defined(n)&&rn.string(n.uri)&&(rn.undefined(n.languageId)||rn.string(n.languageId))&&rn.uinteger(n.lineCount)&&rn.func(n.getText)&&rn.func(n.positionAt)&&rn.func(n.offsetAt))},t.applyEdits=function(t,r){for(var e=t.getText(),i=n(r,(function(t,n){var r=t.range.start.line-n.range.start.line;return 0===r?t.range.start.character-n.range.start.character:r})),o=e.length,u=i.length-1;u>=0;u--){var s=i[u],c=t.offsetAt(s.range.start),a=t.offsetAt(s.range.end);if(!(a<=o))throw new Error("Overlapping edit");e=e.substring(0,c)+s.newText+e.substring(a,e.length),o=c}return e}}(Zt||(Zt={}));var rn,en,on,un=function(){function t(t,n,r,e){this._uri=t,this._languageId=n,this._version=r,this._content=e,this._lineOffsets=void 0}return Object.defineProperty(t.prototype,"uri",{get:function(){return this._uri},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"languageId",{get:function(){return this._languageId},enumerable:!1,configurable:!0}),Object.defineProperty(t.prototype,"version",{get:function(){return this._version},enumerable:!1,configurable:!0}),t.prototype.getText=function(t){if(t){var n=this.offsetAt(t.start),r=this.offsetAt(t.end);return this._content.substring(n,r)}return this._content},t.prototype.update=function(t,n){this._content=t.text,this._version=n,this._lineOffsets=void 0},t.prototype.getLineOffsets=function(){if(void 0===this._lineOffsets){for(var t=[],n=this._content,r=!0,e=0;e<n.length;e++){r&&(t.push(e),r=!1);var i=n.charAt(e);r="\r"===i||"\n"===i,"\r"===i&&e+1<n.length&&"\n"===n.charAt(e+1)&&e++}r&&n.length>0&&t.push(n.length),this._lineOffsets=t}return this._lineOffsets},t.prototype.positionAt=function(t){t=Math.max(Math.min(t,this._content.length),0);var n=this.getLineOffsets(),r=0,e=n.length;if(0===e)return h.create(0,t);for(;r<e;){var i=Math.floor((r+e)/2);n[i]>t?e=i:r=i+1}var o=r-1;return h.create(o,t-n[o])},t.prototype.offsetAt=function(t){var n=this.getLineOffsets();if(t.line>=n.length)return this._content.length;if(t.line<0)return 0;var r=n[t.line];return Math.max(Math.min(r+t.character,t.line+1<n.length?n[t.line+1]:this._content.length),r)},Object.defineProperty(t.prototype,"lineCount",{get:function(){return this.getLineOffsets().length},enumerable:!1,configurable:!0}),t}();en=rn||(rn={}),on=Object.prototype.toString,en.defined=function(t){return void 0!==t},en.undefined=function(t){return void 0===t},en.boolean=function(t){return!0===t||!1===t},en.string=function(t){return"[object String]"===on.call(t)},en.number=function(t){return"[object Number]"===on.call(t)},en.numberRange=function(t,n,r){return"[object Number]"===on.call(t)&&n<=t&&t<=r},en.integer=function(t){return"[object Number]"===on.call(t)&&-2147483648<=t&&t<=2147483647},en.uinteger=function(t){return"[object Number]"===on.call(t)&&0<=t&&t<=2147483647},en.func=function(t){return"[object Function]"===on.call(t)},en.objectLiteral=function(t){return null!==t&&"object"==typeof t},en.typedArray=function(t,n){return Array.isArray(t)&&t.every(n)};var sn=class{constructor(t,n,r){this._languageId=t,this._worker=n;const e=t=>{let n,r=t.getLanguageId();r===this._languageId&&(this._listener[t.uri.toString()]=t.onDidChangeContent((()=>{window.clearTimeout(n),n=window.setTimeout((()=>this._doValidate(t.uri,r)),500)})),this._doValidate(t.uri,r))},i=t=>{u.editor.setModelMarkers(t,this._languageId,[]);let n=t.uri.toString(),r=this._listener[n];r&&(r.dispose(),delete this._listener[n])};this._disposables.push(u.editor.onDidCreateModel(e)),this._disposables.push(u.editor.onWillDisposeModel(i)),this._disposables.push(u.editor.onDidChangeModelLanguage((t=>{i(t.model),e(t.model)}))),this._disposables.push(r((()=>{u.editor.getModels().forEach((t=>{t.getLanguageId()===this._languageId&&(i(t),e(t))}))}))),this._disposables.push({dispose:()=>{u.editor.getModels().forEach(i);for(let t in this._listener)this._listener[t].dispose()}}),u.editor.getModels().forEach(e)}_disposables=[];_listener=Object.create(null);dispose(){this._disposables.forEach((t=>t&&t.dispose())),this._disposables.length=0}_doValidate(t,n){this._worker(t).then((n=>n.doValidation(t.toString()))).then((r=>{const e=r.map((t=>function(t,n){let r="number"==typeof n.code?String(n.code):n.code;return{severity:cn(n.severity),startLineNumber:n.range.start.line+1,startColumn:n.range.start.character+1,endLineNumber:n.range.end.line+1,endColumn:n.range.end.character+1,message:n.message,code:r,source:n.source}}(0,t)));let i=u.editor.getModel(t);i&&i.getLanguageId()===n&&u.editor.setModelMarkers(i,n,e)})).then(void 0,(t=>{console.error(t)}))}};function cn(t){switch(t){case C.Error:return u.MarkerSeverity.Error;case C.Warning:return u.MarkerSeverity.Warning;case C.Information:return u.MarkerSeverity.Info;case C.Hint:return u.MarkerSeverity.Hint;default:return u.MarkerSeverity.Info}}var an=class{constructor(t,n){this._worker=t,this._triggerCharacters=n}get triggerCharacters(){return this._triggerCharacters}provideCompletionItems(t,n,r,e){const i=t.uri;return this._worker(i).then((t=>t.doComplete(i.toString(),fn(n)))).then((r=>{if(!r)return;const e=t.getWordUntilPosition(n),i=new u.Range(n.lineNumber,e.startColumn,n.lineNumber,e.endColumn),o=r.items.map((t=>{const n={label:t.label,insertText:t.insertText||t.label,sortText:t.sortText,filterText:t.filterText,documentation:t.documentation,detail:t.detail,command:(r=t.command,r&&"editor.action.triggerSuggest"===r.command?{id:r.command,title:r.title,arguments:r.arguments}:void 0),range:i,kind:dn(t.kind)};var r,e;return t.textEdit&&(n.range=void 0!==(e=t.textEdit).insert&&void 0!==e.replace?{insert:vn(t.textEdit.insert),replace:vn(t.textEdit.replace)}:vn(t.textEdit.range),n.insertText=t.textEdit.newText),t.additionalTextEdits&&(n.additionalTextEdits=t.additionalTextEdits.map(ln)),t.insertTextFormat===wt.Snippet&&(n.insertTextRules=u.languages.CompletionItemInsertTextRule.InsertAsSnippet),n}));return{isIncomplete:r.isIncomplete,suggestions:o}}))}};function fn(t){if(t)return{character:t.column-1,line:t.lineNumber-1}}function hn(t){if(t)return{start:{line:t.startLineNumber-1,character:t.startColumn-1},end:{line:t.endLineNumber-1,character:t.endColumn-1}}}function vn(t){if(t)return new u.Range(t.start.line+1,t.start.character+1,t.end.line+1,t.end.character+1)}function dn(t){const n=u.languages.CompletionItemKind;switch(t){case lt.Text:return n.Text;case lt.Method:return n.Method;case lt.Function:return n.Function;case lt.Constructor:return n.Constructor;case lt.Field:return n.Field;case lt.Variable:return n.Variable;case lt.Class:return n.Class;case lt.Interface:return n.Interface;case lt.Module:return n.Module;case lt.Property:return n.Property;case lt.Unit:return n.Unit;case lt.Value:return n.Value;case lt.Enum:return n.Enum;case lt.Keyword:return n.Keyword;case lt.Snippet:return n.Snippet;case lt.Color:return n.Color;case lt.File:return n.File;case lt.Reference:return n.Reference}return n.Property}function ln(t){if(t)return{range:vn(t.range),text:t.newText}}var gn=class{constructor(t){this._worker=t}provideHover(t,n,r){let e=t.uri;return this._worker(e).then((t=>t.doHover(e.toString(),fn(n)))).then((t=>{if(t)return{range:vn(t.range),contents:mn(t.contents)}}))}};function wn(t){return"string"==typeof t?{value:t}:(n=t)&&"object"==typeof n&&"string"==typeof n.kind?"plaintext"===t.kind?{value:t.value.replace(/[\\`*_{}[\]()#+\-.!]/g,"\\$&")}:{value:t.value}:{value:"```"+t.language+"\n"+t.value+"\n```\n"};var n}function mn(t){if(t)return Array.isArray(t)?t.map(wn):[wn(t)]}var bn=class{constructor(t){this._worker=t}provideDocumentHighlights(t,n,r){const e=t.uri;return this._worker(e).then((t=>t.findDocumentHighlights(e.toString(),fn(n)))).then((t=>{if(t)return t.map((t=>({range:vn(t.range),kind:pn(t.kind)})))}))}};function pn(t){switch(t){case Rt.Read:return u.languages.DocumentHighlightKind.Read;case Rt.Write:return u.languages.DocumentHighlightKind.Write;case Rt.Text:return u.languages.DocumentHighlightKind.Text}return u.languages.DocumentHighlightKind.Text}var jn=class{constructor(t){this._worker=t}provideDefinition(t,n,r){const e=t.uri;return this._worker(e).then((t=>t.findDefinition(e.toString(),fn(n)))).then((t=>{if(t)return[xn(t)]}))}};function xn(t){return{uri:u.Uri.parse(t.uri),range:vn(t.range)}}var kn=class{constructor(t){this._worker=t}provideReferences(t,n,r,e){const i=t.uri;return this._worker(i).then((t=>t.findReferences(i.toString(),fn(n)))).then((t=>{if(t)return t.map(xn)}))}},In=class{constructor(t){this._worker=t}provideRenameEdits(t,n,r,e){const i=t.uri;return this._worker(i).then((t=>t.doRename(i.toString(),fn(n),r))).then((t=>function(t){if(!t||!t.changes)return;let n=[];for(let r in t.changes){const e=u.Uri.parse(r);for(let i of t.changes[r])n.push({resource:e,versionId:void 0,textEdit:{range:vn(i.range),text:i.newText}})}return{edits:n}}(t)))}},yn=class{constructor(t){this._worker=t}provideDocumentSymbols(t,n){const r=t.uri;return this._worker(r).then((t=>t.findDocumentSymbols(r.toString()))).then((t=>{if(t)return t.map((t=>({name:t.name,detail:"",containerName:t.containerName,kind:On(t.kind),range:vn(t.location.range),selectionRange:vn(t.location.range),tags:[]})))}))}};function On(t){let n=u.languages.SymbolKind;switch(t){case Nt.File:return n.Array;case Nt.Module:return n.Module;case Nt.Namespace:return n.Namespace;case Nt.Package:return n.Package;case Nt.Class:return n.Class;case Nt.Method:return n.Method;case Nt.Property:return n.Property;case Nt.Field:return n.Field;case Nt.Constructor:return n.Constructor;case Nt.Enum:return n.Enum;case Nt.Interface:return n.Interface;case Nt.Function:return n.Function;case Nt.Variable:return n.Variable;case Nt.Constant:return n.Constant;case Nt.String:return n.String;case Nt.Number:return n.Number;case Nt.Boolean:return n.Boolean;case Nt.Array:return n.Array}return n.Function}var En=class{constructor(t){this._worker=t}provideLinks(t,n){const r=t.uri;return this._worker(r).then((t=>t.findDocumentLinks(r.toString()))).then((t=>{if(t)return{links:t.map((t=>({range:vn(t.range),url:t.target})))}}))}},_n=class{constructor(t){this._worker=t}provideDocumentFormattingEdits(t,n,r){const e=t.uri;return this._worker(e).then((t=>t.format(e.toString(),null,Tn(n)).then((t=>{if(t&&0!==t.length)return t.map(ln)}))))}},Sn=class{constructor(t){this._worker=t}canFormatMultipleRanges=!1;provideDocumentRangeFormattingEdits(t,n,r,e){const i=t.uri;return this._worker(i).then((t=>t.format(i.toString(),hn(n),Tn(r)).then((t=>{if(t&&0!==t.length)return t.map(ln)}))))}};function Tn(t){return{tabSize:t.tabSize,insertSpaces:t.insertSpaces}}var Rn=class{constructor(t){this._worker=t}provideDocumentColors(t,n){const r=t.uri;return this._worker(r).then((t=>t.findDocumentColors(r.toString()))).then((t=>{if(t)return t.map((t=>({color:t.color,range:vn(t.range)})))}))}provideColorPresentations(t,n,r){const e=t.uri;return this._worker(e).then((t=>t.getColorPresentations(e.toString(),n.color,hn(n.range)))).then((t=>{if(t)return t.map((t=>{let n={label:t.label};return t.textEdit&&(n.textEdit=ln(t.textEdit)),t.additionalTextEdits&&(n.additionalTextEdits=t.additionalTextEdits.map(ln)),n}))}))}},Cn=class{constructor(t){this._worker=t}provideFoldingRanges(t,n,r){const e=t.uri;return this._worker(e).then((t=>t.getFoldingRanges(e.toString(),n))).then((t=>{if(t)return t.map((t=>{const n={start:t.startLine+1,end:t.endLine+1};return void 0!==t.kind&&(n.kind=function(t){switch(t){case O.Comment:return u.languages.FoldingRangeKind.Comment;case O.Imports:return u.languages.FoldingRangeKind.Imports;case O.Region:return u.languages.FoldingRangeKind.Region}}(t.kind)),n}))}))}},Dn=class{constructor(t){this._worker=t}provideSelectionRanges(t,n,r){const e=t.uri;return this._worker(e).then((t=>t.getSelectionRanges(e.toString(),n.map(fn)))).then((t=>{if(t)return t.map((t=>{const n=[];for(;t;)n.push({range:vn(t.range)}),t=t.parent;return n}))}))}},Nn=class extends an{constructor(t){super(t,[".",":","<",'"',"=","/"])}};function Wn(t){const n=new rt(t),r=(...t)=>n.getLanguageServiceWorker(...t);let e=t.languageId;u.languages.registerCompletionItemProvider(e,new Nn(r)),u.languages.registerHoverProvider(e,new gn(r)),u.languages.registerDocumentHighlightProvider(e,new bn(r)),u.languages.registerLinkProvider(e,new En(r)),u.languages.registerFoldingRangeProvider(e,new Cn(r)),u.languages.registerDocumentSymbolProvider(e,new yn(r)),u.languages.registerSelectionRangeProvider(e,new Dn(r)),u.languages.registerRenameProvider(e,new In(r)),"html"===e&&(u.languages.registerDocumentFormattingEditProvider(e,new _n(r)),u.languages.registerDocumentRangeFormattingEditProvider(e,new Sn(r)))}function Ln(t){const n=[],r=[],e=new rt(t);n.push(e);const i=(...t)=>e.getLanguageServiceWorker(...t);return function(){const{languageId:n,modeConfiguration:e}=t;Mn(r),e.completionItems&&r.push(u.languages.registerCompletionItemProvider(n,new Nn(i))),e.hovers&&r.push(u.languages.registerHoverProvider(n,new gn(i))),e.documentHighlights&&r.push(u.languages.registerDocumentHighlightProvider(n,new bn(i))),e.links&&r.push(u.languages.registerLinkProvider(n,new En(i))),e.documentSymbols&&r.push(u.languages.registerDocumentSymbolProvider(n,new yn(i))),e.rename&&r.push(u.languages.registerRenameProvider(n,new In(i))),e.foldingRanges&&r.push(u.languages.registerFoldingRangeProvider(n,new Cn(i))),e.selectionRanges&&r.push(u.languages.registerSelectionRangeProvider(n,new Dn(i))),e.documentFormattingEdits&&r.push(u.languages.registerDocumentFormattingEditProvider(n,new _n(i))),e.documentRangeFormattingEdits&&r.push(u.languages.registerDocumentRangeFormattingEditProvider(n,new Sn(i)))}(),n.push(An(r)),An(n)}function An(t){return{dispose:()=>Mn(t)}}function Mn(t){for(;t.length;)t.pop().dispose()}export{an as CompletionAdapter,jn as DefinitionAdapter,sn as DiagnosticsAdapter,Rn as DocumentColorAdapter,_n as DocumentFormattingEditProvider,bn as DocumentHighlightAdapter,En as DocumentLinkAdapter,Sn as DocumentRangeFormattingEditProvider,yn as DocumentSymbolAdapter,Cn as FoldingRangeAdapter,gn as HoverAdapter,kn as ReferenceAdapter,In as RenameAdapter,Dn as SelectionRangeAdapter,rt as WorkerManager,fn as fromPosition,hn as fromRange,Ln as setupMode,Wn as setupMode1,vn as toRange,ln as toTextEdit}