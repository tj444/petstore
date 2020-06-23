<template>
	<view class="content">
		 <!-- 宠物园 -->
		<view class="autoply_circle">
			<view v-for="(item,index) in txvideoList" :key="index"
			@click="txvVideo(item)"
			 class="bg-top circlewidth"
			 :style="{ 'background-image': 'url(' + imgUrl + item.headimage + ')'}">
				<image src="../../static/autoply.png"></image>
			</view>
			
		</view>
		<uLiLoadMore v-if="txvideoList.length!=0" :status="more_status"></uLiLoadMore>
	</view>
</template>

<script>
	import {imgUrl} from '@/common/helper.js';
	import uLiLoadMore from "@/components/uLi-load-more/uLi-load-more.vue"
	export default {
		components:{
			uLiLoadMore
		},
		data() {
			return {
		     txvideoList:[],
			 imgUrl:imgUrl,
			 cursor:0,
			 more_status:'more',
			 time:3
			}
		},
		onLoad(options) {
          this.txvideo(JSON.parse(options.cursor))
		},
		methods: {
         async txvideo(cursor){
         	let res = await this.$api.txvideo({
				cursor
			})
            if(res.data.code==1){
			  this.txvideoList = res.data.data.list;
			  this.cursor = res.data.data.cursor
         	}
         },
		 //下拉刷新
		 async cursor_item(){
			let res = await this.$api.txvideo({
				cursor:this.cursor
			}) 
			if(res.data.code==1){
				if(res.data.data.list.length==0){
					this.more_status = 'noMore';
				}else{
				  	this.more_status = 'loading';
					var timer = setInterval(()=>{
						 this.time--
						 if(this.time<=0){
						  this.cursor = res.data.data.cursor;
						   this.txvideoList = this.txvideoList.concat(res.data.data.list);
						   this.more_status = 'more';
						   clearInterval(timer)
						 }
					},1000)
				}
			}
		 },
		 txvVideo(item){
		    uni.navigateTo({
		 	 url:'./txvVideo?video=' + JSON.stringify(item)
		   })
		 }
		},
	  onReachBottom() {
	  	this.cursor_item()
	  },
	  onPullDownRefresh: function() {
		  this.cursor_item()
	  	wx.stopPullDownRefresh()
	  },
	}
</script>

<style>
   page{
	   background-color: #F5F5F6;
   }
</style> 

<style lang="scss">
 @import url('../../common/index.css')
</style>