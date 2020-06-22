<template>
	<view>
		<view class="open">{{contentObject.data.title}}</view>
		<view class="timer">{{timestampToTime(contentObject.time)}}</view>
		<view class="centent_width">
		  <rich-text :nodes="contentObject.data.content"></rich-text>
		</view>
	</view>
	</view>
</template>

<script>
   import {imgUrl,timestampToTime} from '@/common/helper.js';
	export default {
		data() {
		return {
		   timestampToTime:timestampToTime,
		   contentObject:{}
		  };
		},
		onLoad(options) {
		  this.content(JSON.parse(options.contentId))
		},
		methods:{
	    async content(id){
		  let res = await this.$api.content({
			  id
		  })
		 if(res.data.code==1){
			this.contentObject = res.data
		 }
	  }
	  }
	}
</script>

<style lang="scss">
 .open{
	color: #333333;
	font-size: 30rpx;
	text-align: center;
	padding-top: 30rpx;
	font-weight: bold;
 }
 .timer{
	 text-align: center;
	 color: #999;
 }
 .centent_width{
	 width: 690rpx;
	 margin: 0 auto;
	 color: #333333;
	 font-size: 24rpx;
	 padding-top: 30rpx;
	 line-height: 50rpx;
 }
 .goodet_images{
	 width: 600rpx;
	 margin: 0 auto;
	 padding-top: 30rpx;
 }
 .goodet_images image{
	 width: 600rpx;
	 height: 430rpx;
 }
</style>