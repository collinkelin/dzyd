(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d216bf6"],{c47f:function(t,e,a){"use strict";a.r(e);var s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"MiLiao"},[a("transition",{attrs:{name:t.animateType}},[a("router-view")],1),a("audio",{staticStyle:{display:"none"},attrs:{controls:"",id:"SystemVoice"}},[a("source",{attrs:{src:"./static/miliao/voice/system.mp3",type:"audio/mpeg"}}),a("embed",{attrs:{src:"./static/miliao/voice/system.mp3"}})]),a("audio",{staticStyle:{display:"none"},attrs:{controls:"",id:"MsgVoice"}},[a("source",{attrs:{src:"./static/miliao/voice/msg.mp3",type:"audio/mpeg"}}),a("embed",{attrs:{src:"./static/miliao/voice/msg.mp3"}})])],1)},i=[],c={data(){return{animateType:""}},watch:{$route(t,e){this.$toast.clear(),t.params.isBack||e.params.isBack?(this.animateType="close",delete t.params.isBack,delete e.params.isBack):e.name&&(this.animateType="open")}},created(){},mounted(){},destroyed(){},methods:{}},o=c,r=a("2877"),n=Object(r["a"])(o,s,i,!1,null,null,null);e["default"]=n.exports}}]);