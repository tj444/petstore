<template>
	<view>
		<view class="centent">
			<view class="search">
			  <input @confirm="confirm($event)" confirm-type="search" type="text" placeholder="常见问题搜索" placeholder-class="placeholder"/>
			  <image src="../../static/search.png"></image>
			</view>
		</view>
		<view class="list">
			 <view :class="{active:listlenght==index}" @click="tabDager(index)" v-for="(item,index) in list" :key="index">{{item}}</view>
		</view>
		<!-- 猫咪 -->
		<view v-if="listlenght==0">
		<view class="noviceBasis">
			<view class="basis">新手基础</view>
			<view class="centent_immune">
			<view @click="answer(item)" v-for="(item,index) in basis" :key="index">{{item.short_title}}</view>
			</view>
		</view>
		<view class="noviceBasis">
			<view class="basis">常见问题</view>
			<view class="centent_immune">
				 <view @click="answer(item)" v-for="(item,index) in problems" :key="index">{{item.short_title}}</view>
			</view>
		</view>
		</view>
	  <!-- 狗狗 -->
	  <view v-if="listlenght==1">
	  <view class="noviceBasis">
	  	<view class="basis">新手基础</view>
	  	<view class="centent_immune">
	  	 <view  @click="answer(item)" v-for="(item,index) in dogBasis" :key="index">{{item.short_title}}</view>
	  	</view>
	  </view>
	  <view class="noviceBasis">
	  	<view class="basis">常见问题</view>
	  	<view class="centent_immune">
	  	 <view @click="answer(item)" v-for="(item,index) in dogProbems" :key="index">{{item.short_title}}</view>
	  	</view>
	  </view>
	  </view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
			  list:['猫咪','狗狗'],
			  listlenght:0,
			  dog:{},
			  problems:[],
			  basis:[],
			  dogProbems:[],
			  dogBasis:[],
			  search:'',
			  concatCat:[] ,//合并后的数组
			  concatDog:[] //合并后的数组
			};
		},
		onLoad(){
	      this.petwikiList()
		},
		methods:{
			async petwikiList(){
			  let res = await this.$api.petwikiList();
			  if(res.data.code==1){
				 this.problems = res.data.data.cat['常见问题'];
				 this.basis = res.data.data.cat['新手基础']
				 this.dogProbems = res.data.data.dog['常见问题']
				 this.dogBasis = res.data.data.dog['新手基础'];
				 this.concatCat = this.concatCat.concat(this.problems, this.basis)
				 this.concatDog = this.concatDog.concat(this.dogProbems,this.dogBasis)
				 
				}
			},
			confirm(e){
			 if(e.detail.value==''){
			    uni.showToast({icon: 'none',title:'输入内容不能为空'});
				return false
			 }else{
				 //猫
				if(this.listlenght==0){
				   this.concatCat.forEach((item)=>{
					 if(item.short_title===e.detail.value || item.title===e.detail.value){
						uni.navigateTo({
						  url:'./answer?contentId=' + JSON.stringify(item.id)
						})
					 }else{
					  uni.showToast({icon: 'none',title:'没有找到相应内容'});
					 }
				   })
	
				}else{
				 this.concatDog.forEach((item)=>{
				  if(item.short_title===e.detail.value || item.title===e.detail.value){
						uni.navigateTo({
					     url:'./answer?contentId=' + JSON.stringify(item.id)
						})
					 }else{
						 uni.showToast({icon: 'none',title:'没有找到相应内容'});
					 }
				})	
				}
			 } 
			}, 
			tabDager(index){
		      this.listlenght = index;
			},
		  answer(item){
			uni.navigateTo({
	      	  url:'./answer?contentId=' + JSON.stringify(item.id)
		    })
		  }
		
		}
		
	}
</script>

<style lang="scss">
  .centent{
	 background-color: #F5F5F6;
	 height: auto;
	 padding-top: 30rpx;
	 padding-bottom: 30rpx;
  }
  .search{
	  width: 690rpx;
	  height: 79rpx;
	  background-color: #fff;
	  border-radius: 40rpx;
	  border:1rpx solid rgba(187,187,187,1);
	  margin: 0 auto;
	  display: flex;
  }
  .search .placeholder{
	  color: #888888;
	  font-size:30rpx;
	  
  }
  .search input{
	 color: #888888;
	 font-size:30rpx;
	 padding-left: 30rpx;
	 margin-top: 25rpx;
  }
  .search image{
	  width: 30rpx;
	  height: 30rpx;
	  margin-left: auto;
	  margin-right: 30rpx;
	  padding-top: 30rpx;
  }
  .list{
	  display: flex;
	  padding-top: 30rpx;
	  width: 650rpx;
	  margin: 0 auto;
  }
  .list view{
	  color: #888888;
	  text-align: center;
	  width: 325rpx;
	  font-size: 30rpx;
	  padding-bottom: 20rpx;
  }
  .active{
	  color: #7BC6BD !important;
	  border-bottom: 2rpx solid #7BC6BD;
  }
  .noviceBasis{
	  padding-top: 30rpx;
	  padding-left: 30rpx;
  }
  .noviceBasis .basis{
	   color: #333333;
	   font-size: 30rpx;
	   font-weight: bold;
  }
  .centent_immune{
	  padding-top: 20rpx;
  }
  .centent_immune view{
	 display: inline-block;
	 width: 214rpx;
	 height: 73rpx;
	 text-align: center;
	 background-color: #7BC6BD;
	 border:1px solid rgba(123,198,189,1);
	 margin-right: 20rpx;
	 margin-bottom: 20rpx;
	 line-height: 80rpx;
	 
  }
</style>
