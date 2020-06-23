<template>
	<view class="content">
		 <!-- 医生在线和百科问答 -->
		 <view class="doctor">
			 <view @click="online"><image src="../../static/Group2.png"></image></view>
			 <view @click="wikipedia"><image src="../../static/Group1.png"></image></view>
		 </view>
		 <!-- 宠物圈 -->
		 <view class="Pet_circle"> 
			  <view class="pet">宠物圈</view>
			  <view class="more" @click="more">
				   <text>更多</text>
				   <image src="../../static/tz.png"></image>
			  </view>
		 </view>
		<view class="autoply_circle">
			<view
			@click="txvVideo(item)"
			 v-for="(item,index) in txvideoList" :key="index"
			 class="bg-top circlewidth"
			 :style="{ 'background-image': 'url(' + imgUrl + item.headimage + ')'}">
				<image src="../../static/autoply.png"></image>
			</view>
		</view> 
	</view>
</template>

<script>
  import {imgUrl} from '@/common/helper.js';
	export default {
		data() {
			return {
		     txvideoList:[],
			 imgUrl:imgUrl,
			 cursor:0
			}
		},
		onLoad() {
          this.txvideo()
		},
		methods: {
		 //视频列表
		 async txvideo(){
			let res = await this.$api.txvideo()
		    if(res.data.code==1){
			 this.txvideoList = res.data.data.list;
			 this.cursor = res.data.data.cursor
			}
		 },
          more(){
			 uni.navigateTo({
			 	url:'./Pet_park?cursor=' + JSON.stringify(this.cursor)
			 })
		  },
		  online(){
			 uni.navigateTo({
			 	url:'./doctor'
			 })
		  },
		  wikipedia(){
			 uni.navigateTo({
			 	url:'./wikipedia'
			 })
		  },
		  txvVideo(item){
			 uni.navigateTo({
			  url:'./txvVideo?video=' + JSON.stringify(item)
			 })
		  }
		}
	}
</script>

<style>
   page{
	   background-color: #F5F5F6;
   }
</style> 

<style lang="scss">
	@import url('../../common/index.css');
</style>