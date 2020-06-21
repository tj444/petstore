<script>
	export default {
		onLaunch: function() {
			console.log('App Launch')
		},
		onShow: function() {
			console.log('App Show')
		},
		onHide: function() {
			console.log('App Hide')
		}
	}
</script>

<style>
	/*每个页面公共css */
	@import "./common/uni.css";
	@import "./common/reset.css";
	.mpvue-picker__hd{padding:0!important;}
	.mpvue-picker__action{height: 100%;padding:9px 15px;}
	
</style>
