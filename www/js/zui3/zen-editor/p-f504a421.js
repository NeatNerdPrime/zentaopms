import{m as e}from"./p-231078b1.js";import"./p-1f29e0e0.js";
/*!-----------------------------------------------------------------------------
 * Copyright (c) Microsoft Corporation. All rights reserved.
 * Version: 0.45.0(5e5af013f8d295555a7210df0d5f2cea0bf5dd56)
 * Released under the MIT license
 * https://github.com/microsoft/monaco-editor/blob/main/LICENSE.txt
 *-----------------------------------------------------------------------------*/var t=Object.defineProperty,n=Object.getOwnPropertyDescriptor,a=Object.getOwnPropertyNames,r=Object.prototype.hasOwnProperty,m=(e,m,l,i)=>{if(m&&"object"==typeof m||"function"==typeof m)for(let o of a(m))r.call(e,o)||o===l||t(e,o,{get:()=>m[o],enumerable:!(i=n(m,o))||i.enumerable});return e},l={};m(l,e,"default");var i=["area","base","br","col","embed","hr","img","input","keygen","link","menuitem","meta","param","source","track","wbr"],o={wordPattern:/(-?\d*\.\d\w*)|([^\`\~\!\@\$\^\&\*\(\)\=\+\[\{\]\}\\\|\;\:\'\"\,\.\<\>\/\s]+)/g,comments:{blockComment:["{{!--","--}}"]},brackets:[["\x3c!--","--\x3e"],["<",">"],["{{","}}"],["{","}"],["(",")"]],autoClosingPairs:[{open:"{",close:"}"},{open:"[",close:"]"},{open:"(",close:")"},{open:'"',close:'"'},{open:"'",close:"'"}],surroundingPairs:[{open:"<",close:">"},{open:'"',close:'"'},{open:"'",close:"'"}],onEnterRules:[{beforeText:new RegExp(`<(?!(?:${i.join("|")}))(\\w[\\w\\d]*)([^/>]*(?!/)>)[^<]*$`,"i"),afterText:/^<\/(\w[\w\d]*)\s*>$/i,action:{indentAction:l.languages.IndentAction.IndentOutdent}},{beforeText:new RegExp(`<(?!(?:${i.join("|")}))(\\w[\\w\\d]*)([^/>]*(?!/)>)[^<]*$`,"i"),action:{indentAction:l.languages.IndentAction.Indent}}]},s={defaultToken:"",tokenPostfix:"",tokenizer:{root:[[/\{\{!--/,"comment.block.start.handlebars","@commentBlock"],[/\{\{!/,"comment.start.handlebars","@comment"],[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.root"}],[/<!DOCTYPE/,"metatag.html","@doctype"],[/<!--/,"comment.html","@commentHtml"],[/(<)(\w+)(\/>)/,["delimiter.html","tag.html","delimiter.html"]],[/(<)(script)/,["delimiter.html",{token:"tag.html",next:"@script"}]],[/(<)(style)/,["delimiter.html",{token:"tag.html",next:"@style"}]],[/(<)([:\w]+)/,["delimiter.html",{token:"tag.html",next:"@otherTag"}]],[/(<\/)(\w+)/,["delimiter.html",{token:"tag.html",next:"@otherTag"}]],[/</,"delimiter.html"],[/\{/,"delimiter.html"],[/[^<{]+/]],doctype:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.comment"}],[/[^>]+/,"metatag.content.html"],[/>/,"metatag.html","@pop"]],comment:[[/\}\}/,"comment.end.handlebars","@pop"],[/./,"comment.content.handlebars"]],commentBlock:[[/--\}\}/,"comment.block.end.handlebars","@pop"],[/./,"comment.content.handlebars"]],commentHtml:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.comment"}],[/-->/,"comment.html","@pop"],[/[^-]+/,"comment.content.html"],[/./,"comment.content.html"]],otherTag:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.otherTag"}],[/\/?>/,"delimiter.html","@pop"],[/"([^"]*)"/,"attribute.value"],[/'([^']*)'/,"attribute.value"],[/[\w\-]+/,"attribute.name"],[/=/,"delimiter"],[/[ \t\r\n]+/]],script:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.script"}],[/type/,"attribute.name","@scriptAfterType"],[/"([^"]*)"/,"attribute.value"],[/'([^']*)'/,"attribute.value"],[/[\w\-]+/,"attribute.name"],[/=/,"delimiter"],[/>/,{token:"delimiter.html",next:"@scriptEmbedded.text/javascript",nextEmbedded:"text/javascript"}],[/[ \t\r\n]+/],[/(<\/)(script\s*)(>)/,["delimiter.html","tag.html",{token:"delimiter.html",next:"@pop"}]]],scriptAfterType:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.scriptAfterType"}],[/=/,"delimiter","@scriptAfterTypeEquals"],[/>/,{token:"delimiter.html",next:"@scriptEmbedded.text/javascript",nextEmbedded:"text/javascript"}],[/[ \t\r\n]+/],[/<\/script\s*>/,{token:"@rematch",next:"@pop"}]],scriptAfterTypeEquals:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.scriptAfterTypeEquals"}],[/"([^"]*)"/,{token:"attribute.value",switchTo:"@scriptWithCustomType.$1"}],[/'([^']*)'/,{token:"attribute.value",switchTo:"@scriptWithCustomType.$1"}],[/>/,{token:"delimiter.html",next:"@scriptEmbedded.text/javascript",nextEmbedded:"text/javascript"}],[/[ \t\r\n]+/],[/<\/script\s*>/,{token:"@rematch",next:"@pop"}]],scriptWithCustomType:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.scriptWithCustomType.$S2"}],[/>/,{token:"delimiter.html",next:"@scriptEmbedded.$S2",nextEmbedded:"$S2"}],[/"([^"]*)"/,"attribute.value"],[/'([^']*)'/,"attribute.value"],[/[\w\-]+/,"attribute.name"],[/=/,"delimiter"],[/[ \t\r\n]+/],[/<\/script\s*>/,{token:"@rematch",next:"@pop"}]],scriptEmbedded:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInEmbeddedState.scriptEmbedded.$S2",nextEmbedded:"@pop"}],[/<\/script/,{token:"@rematch",next:"@pop",nextEmbedded:"@pop"}]],style:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.style"}],[/type/,"attribute.name","@styleAfterType"],[/"([^"]*)"/,"attribute.value"],[/'([^']*)'/,"attribute.value"],[/[\w\-]+/,"attribute.name"],[/=/,"delimiter"],[/>/,{token:"delimiter.html",next:"@styleEmbedded.text/css",nextEmbedded:"text/css"}],[/[ \t\r\n]+/],[/(<\/)(style\s*)(>)/,["delimiter.html","tag.html",{token:"delimiter.html",next:"@pop"}]]],styleAfterType:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.styleAfterType"}],[/=/,"delimiter","@styleAfterTypeEquals"],[/>/,{token:"delimiter.html",next:"@styleEmbedded.text/css",nextEmbedded:"text/css"}],[/[ \t\r\n]+/],[/<\/style\s*>/,{token:"@rematch",next:"@pop"}]],styleAfterTypeEquals:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.styleAfterTypeEquals"}],[/"([^"]*)"/,{token:"attribute.value",switchTo:"@styleWithCustomType.$1"}],[/'([^']*)'/,{token:"attribute.value",switchTo:"@styleWithCustomType.$1"}],[/>/,{token:"delimiter.html",next:"@styleEmbedded.text/css",nextEmbedded:"text/css"}],[/[ \t\r\n]+/],[/<\/style\s*>/,{token:"@rematch",next:"@pop"}]],styleWithCustomType:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInSimpleState.styleWithCustomType.$S2"}],[/>/,{token:"delimiter.html",next:"@styleEmbedded.$S2",nextEmbedded:"$S2"}],[/"([^"]*)"/,"attribute.value"],[/'([^']*)'/,"attribute.value"],[/[\w\-]+/,"attribute.name"],[/=/,"delimiter"],[/[ \t\r\n]+/],[/<\/style\s*>/,{token:"@rematch",next:"@pop"}]],styleEmbedded:[[/\{\{/,{token:"@rematch",switchTo:"@handlebarsInEmbeddedState.styleEmbedded.$S2",nextEmbedded:"@pop"}],[/<\/style/,{token:"@rematch",next:"@pop",nextEmbedded:"@pop"}]],handlebarsInSimpleState:[[/\{\{\{?/,"delimiter.handlebars"],[/\}\}\}?/,{token:"delimiter.handlebars",switchTo:"@$S2.$S3"}],{include:"handlebarsRoot"}],handlebarsInEmbeddedState:[[/\{\{\{?/,"delimiter.handlebars"],[/\}\}\}?/,{token:"delimiter.handlebars",switchTo:"@$S2.$S3",nextEmbedded:"$S3"}],{include:"handlebarsRoot"}],handlebarsRoot:[[/"[^"]*"/,"string.handlebars"],[/[#/][^\s}]+/,"keyword.helper.handlebars"],[/else\b/,"keyword.helper.handlebars"],[/[\s]+/],[/[^}]/,"variable.parameter.handlebars"]]}};export{o as conf,s as language}