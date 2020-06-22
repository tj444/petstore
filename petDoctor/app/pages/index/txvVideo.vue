<template>
	<view>
		<view class="video" v-if="Object.keys(videoobject).length!=0">
			<txv-video :vid="videoobject.vid" playerid="vid"></txv-video>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
			 videoobject:{}
			};
		},
		onLoad(options) {
		 this.videoobject = JSON.parse(options.video)
		 console.log(this.videoobject.vid)
		}
	}
</script>
<style>
	page{
		background-color: #000000;
	}
</style>
<style lang="scss">
 .video{
	padding-top: 300rpx;
 }
</style>
