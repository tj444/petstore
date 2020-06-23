<template>
	<view>
		<view class="centent">
			<view class="search">
			  <input v-model="nameSache" type="text" placeholder="常见问题搜索" placeholder-class="placeholder"/>
			  <image @click="confirm" src="../../static/search.png"></image>
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
			  nameSache:'',
			  problems:[],
			  basis:[],
			  dogProbems:[],
			  dogBasis:[],
			  search:'',
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
				 
				}
			},
			confirm(){
			 if(this.nameSache==''){
			    uni.showToast({icon: 'none',title:'输入内容不能为空'});
				return false
			 }else{
				 //猫
				if(this.listlenght==0){
				   this.basis = this.basis.filter(
				        item => item.short_title == this.nameSache
				     );
	                this.problems = this.problems.filter(
				    item => item.short_title == this.nameSache
				  );
				}else{
				 	this.dogProbems = this.dogProbems.filter(
				 	  item => item.short_title == this.nameSache
				 	);
					this.dogBasis = this.dogBasis.filter(
					  item => item.short_title == this.nameSache
					);
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
		
		},
		watch:{
			//当是空的时候重新请求数据
			nameSache:function(data){
			   if(data==''){
				   this.petwikiList()
			   }
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
	  align-items: center;
  }
  .search .placeholder{
	  color: #888888;
	  font-size:30rpx;
	  
  }
  .search input{
	 color: #888888;
	 font-size:30rpx;
	 margin-left: 30rpx;
  }
  .search image{
	  width: 30rpx;
	  height: 30rpx;
	  margin-left: auto;
	  margin-right: 30rpx;
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
	 background-color:#C3F0EB;
	 border:1px solid #C3F0EB;
	 margin-right: 20rpx;
	 margin-bottom: 20rpx;
	 line-height: 80rpx;
	 color: #333333;
  }
</style>
