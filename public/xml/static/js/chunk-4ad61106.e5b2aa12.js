(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-4ad61106"],{"6ee1":function(t,s,a){"use strict";(function(t){s["a"]={name:"TaskRecord",components:{},props:["taskState"],data(){return{listData:"",isLoad:!1,isFinished:!1,isRefresh:!1,pageNo:1,tabsState:1,tabsIndex:0,taskTabs:[{state:2,text:this.$t("task.tabs[1]")},{state:3,text:this.$t("task.tabs[2]")},{state:4,text:this.$t("task.tabs[3]")},{state:5,text:this.$t("task.tabs[4]")},{state:6,text:this.$t("task.tabs[5]")}],fileList:[]}},computed:{},watch:{},created(){this.listData=this.taskTabs.flatMap(t=>[""]),this.getListData("init")},mounted(){},activated(){},destroyed(){},methods:{onClickCell(s){},onLoad(){this.getListData("load")},changeTabs(t){this.tabsState=this.taskTabs[t].state,this.getListData("init")},getListData(t){this.isLoad=!0,this.isRefresh=!1,"load"==t?this.pageNo+=1:(this.pageNo=1,this.isFinished=!1),this.$Model.GetTaskRecord({status:this.tabsState,page_no:this.pageNo,is_u:2},s=>{this.isLoad=!1,1==s.code?(this.listData[this.tabsIndex]="load"==t?this.listData[this.tabsIndex].concat(s.info):s.info,this.pageNo==s.data_total_page?this.isFinished=!0:this.isFinished=!1):(this.listData[this.tabsIndex]="",this.isFinished=!0)})},onRefresh(){this.getListData("init")},afterRead(t){t.status="uploading",t.message=this.$t("upload[0]"),this.uploadImgs(t)},compressImg(t){this.$Util.CompressImg(t.file.type,t.content,750,s=>{let a=new FormData;a.append("token",localStorage["Token"]),a.append("type",3),a.append("image",s,t.file.name),this.$Model.UploadImg(a,s=>{1==s.code?(t.message=this.$t("upload[2]"),t.status="success",t.url=s.url):(t.status="failed",t.message=this.$t("upload[3]"))})})},uploadImgs(t){if(t.length)t.forEach(t=>{if(!t.file.type.match(/image/))return t.status="failed",void(t.message=this.$t("upload[1]"));this.compressImg(t)});else{if(!t.file.type.match(/image/))return t.status="failed",void(t.message=this.$t("upload[1]"));this.compressImg(t)}},submitTask(t,s){if(this.fileList[s]){const a=this.fileList[s].flatMap(t=>t.url);this.$Model.SubmitTask({order_id:t,examine_demo:a},t=>{1==t.code&&(this.fileList[s]=[],this.getListData("init"))})}else this.$Dialog.Toast(this.$t("task.msg"))},cancelTask(t,s){this.$Model.SubmitTask({order_id:t,status:6},t=>{1==t.code&&(this.fileList[s]=[],this.getListData("init"))})}}}}).call(this,a("1157"))},"7eec":function(t,s,a){"use strict";var e=a("d7ae"),i=a.n(e);i.a},d7ae:function(t,s,a){},e29c:function(t,s,a){"use strict";a.r(s);var e=function(){var t=this,s=t.$createElement,a=t._self._c||s;return a("div",{staticClass:"Site IndexBox",staticStyle:{"padding-top":"48px"}},[a("van-nav-bar",{attrs:{fixed:"",border:!1,title:t.$t("task.default[0]"),"left-arrow":""},on:{"click-left":function(s){return t.$router.go(-1)}}}),a("div",{staticClass:"ScrollBox"},[a("van-tabs",{attrs:{ellipsis:!1,border:!1,color:"#4087f1",background:"#151d31","title-active-color":"#4087f1","title-inactive-color":"#fff","line-width":"60"},on:{change:t.changeTabs},model:{value:t.tabsIndex,callback:function(s){t.tabsIndex=s},expression:"tabsIndex"}},t._l(t.taskTabs,(function(s){return a("van-tab",{key:s.state,attrs:{title:s.text}},[a("van-pull-refresh",{on:{refresh:t.onRefresh},model:{value:t.isRefresh,callback:function(s){t.isRefresh=s},expression:"isRefresh"}},[a("van-list",{class:{Empty:!t.listData[t.tabsIndex].length},attrs:{finished:t.isFinished,"finished-text":t.listData[t.tabsIndex].length?t.$t("vanPull[0]"):t.$t("vanPull[1]")},on:{load:t.onLoad},model:{value:t.isLoad,callback:function(s){t.isLoad=s},expression:"isLoad"}},t._l(t.listData[t.tabsIndex],(function(s,e){return a("van-cell",{key:s.order_id,staticClass:"TaskItem",attrs:{"title-class":"record",border:!1},on:{click:function(a){return t.onClickCell(s.order_id)}},scopedSlots:t._u([{key:"title",fn:function(){return[a("h4",[t._v(t._s(s.group_name)+t._s(t.$t("task.default[1]"))+"："+t._s(s.group_info))]),s.requirement?a("p",{staticStyle:{color:"#fff"}},[t._v("("+t._s(s.requirement)+")")]):t._e(),a("p",[t._v(t._s(t.$t("task.default[2]"))+"："+t._s(s.add_time))]),1!=s.is_fx?a("p",{staticClass:"href"},[a("a",{attrs:{href:s.link_info,target:"_blank"},on:{click:function(t){t.stopPropagation()}}},[t._v(t._s(t.$t("task.default[4]")))]),a("a",{attrs:{href:"javascript:;"},on:{click:function(s){return s.stopPropagation(),t.$Util.CopyText("IosLink"+e,"AppLink"+e)}}},[t._v(t._s(t.$t("task.default[5]")))])]):t._e(),a("span",{staticStyle:{position:"absolute",opacity:"0"},attrs:{id:"IosLink"+e}},[t._v(t._s(s.link_info))]),a("input",{staticStyle:{position:"absolute",opacity:"0"},attrs:{id:"AppLink"+e,type:"text"},domProps:{value:s.link_info}})]},proxy:!0}],null,!0)},[a("div",{staticClass:"icon",attrs:{slot:"icon"},slot:"icon"},[1==s.is_fx?a("a",{attrs:{href:"javascript:;"}},[a("img",{attrs:{src:s.icon}})]):a("a",{attrs:{href:"javascript:;"},on:{click:function(a){return a.stopPropagation(),t.$Util.OpenUrl(s.link_info)}}},[a("img",{attrs:{src:s.icon}})])]),0==t.tabsIndex?a("div",{staticClass:"state"},[a("div",{staticClass:"price"},[t._v(" "+t._s(t.$t("task.default[6]"))+" "),a("p",[t._v(t._s(t.InitData.currency)+t._s(Number(s.reward_price)))])])],1):a("div",{staticClass:"state"},[a("p",[a("img",{attrs:{src:"./static/zxwlpic/state"+s.status+"-"+t.$i18n.locale+".png",height:"50"}})]),1==t.tabsIndex?a("van-button",{staticStyle:{"margin-top":"15px"},attrs:{color:"#aaa",size:"mini",round:""},on:{click:function(a){return a.stopPropagation(),t.cancelTask(s.order_id,e)}}},[t._v(t._s(t.$t("task.default[8]")))]):t._e()],1)])})),1)],1)],1)})),1)],1),a("Footer")],1)},i=[],n=a("6ee1"),o=n["a"],l=(a("7eec"),a("2877")),r=Object(l["a"])(o,e,i,!1,null,"0e6675d9",null);s["default"]=r.exports}}]);