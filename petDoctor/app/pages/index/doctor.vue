<template>
	<view>
		<view class="centent">
			专业医生在线问答，给您的爱宠提供做全面的呵护，再也不会为了爱宠生病而着急上火。
		</view>
		<view class="WeChat">搜索微信号码添加</view>
		<view class="doctor_id">医生微信ID：<text>{{wcchat}}</text></view>
		<view class="copy_wcchat" @click="Copywchat">复制微信号</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
			  wcchat:'maomifanyikefu'
			}
		},
		methods: {
			//复制微信号
			Copywchat(){
			  uni.setClipboardData({
				  data:this.wcchat,
				  success:(res)=>{
				 uni.showToast({
					title:'复制成功',
					duration:1500
				 
				 });
				 //粘贴
				 uni.getClipboardData({
					 success:(res)=>{
				    
				    }
				 })
			    }
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
	.centent{
		width: 690rpx;
		padding-left: 30rpx;
		color: #333333;
		font-size: 28rpx;
		padding-top: 42rpx;
	}
	.WeChat{
	  text-align: center;
	  color: #7BC6BD;
	  font-size: 34rpx;
	  padding-top: 60rpx;
	}
	.doctor_id{
		text-align: center;
		font-size: 34rpx;
		color: #333;
		padding-top: 10rpx;
	}
	.doctor_id text{
		color:#7BC6BD;
	}
	.copy_wcchat{
		width: 280rpx;
		height: 60rpx;
		background-color: #7BC6BD;
		display: flex;
		justify-content:center;
		align-items: center;
		background-color:#7BC6BD;
		border-radius: 35rpx;
		color: #fff;
		font-size: 30rpx;
		margin: 0 auto;
		margin-top: 60rpx;
	}
</style>
