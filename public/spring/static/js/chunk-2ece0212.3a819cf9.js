(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2ece0212"],{"8b2e":function(t,e,s){"use strict";var a=s("9ff5"),i=s.n(a);i.a},"9ff5":function(t,e,s){},b267:function(t,e,s){"use strict";s.r(e);var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"PageBox"},[s("div",{staticClass:"ScrollBox"},[s("div",[t.listData.length<=0?s("div",{staticStyle:{"text-align":"center"}},[t._v("暂无记录")]):t._e(),t.listData.length>0?s("div",t._l(t.listData,(function(e,a){return s("van-cell",{key:e.dan,staticClass:"FundItem",attrs:{border:!1},scopedSlots:t._u([{key:"title",fn:function(){return[s("div",[s("span",{staticClass:"money"},[t._v("预计收益:"+t._s(Number(e.money)*e.lilv))]),s("span",[t._v("金额:"+t._s(e.money))])]),s("div",[s("span",{staticStyle:{flex:"none"}},[t._v("购买时间:"+t._s(e.start_time))]),s("span",{staticStyle:{color:"green"}},[t._v(t._s(e.yuebaoid_name)+"状态:("+t._s(e.status_label)+")")])])]},proxy:!0}],null,!0)})})),1):t._e()])])])},i=[],n={name:"newlist",components:{},props:[],data(){return{listData:"",isLoad:!1,isFinished:!1,isRefresh:!1,pageNo:1,tabsState:4,tabsIndex:0,taskTabs:[{state:1,text:""}]}},computed:{},watch:{},created(){this.$parent.navBarTitle="购买记录",this.getListData("init")},mounted(){},activated(){},destroyed(){},methods:{onLoad(){this.getListData("load")},changeTabs(t){},getListData(t){this.isLoad=!0,this.isRefresh=!1,"load"==t?this.pageNo+=1:(this.pageNo=1,this.isFinished=!1),this.$Model.newList({userid:JSON.parse(localStorage.getItem("UserInfo")).userid},t=>{this.isLoad=!1,this.listData=t.info})},onRefresh(){this.getListData("init")}}},o=n,l=(s("8b2e"),s("2877")),r=Object(l["a"])(o,a,i,!1,null,"7bf9f71e",null);e["default"]=r.exports}}]);