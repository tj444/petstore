<template>
    <view>
        <view class="centent">
            <view class="search">
                <input v-model="keyword" type="text" placeholder="常见问题搜索" placeholder-class="placeholder" />
                <image @click="filterList" src="../../static/search.png"></image>
            </view>
        </view>
        <view class="list">
            <view :class="{active:tabIndex===index}" @click="switchTab(index)" v-for="(item, index) in list" :key="index">{{item}}</view>
        </view>
        <view>
            <view v-for="(list, key) in filterdList" :key="key" class="noviceBasis">
                <view class="basis">{{ key }}</view>
                <view class="centent_immune">
                    <view @click="answer(item)" v-for="(item,index) in list" :key="index">{{item.short_title}}</view>
                </view>
            </view>
        </view>
    </view>
</template>

<script>
    export default {
        data() {
            return {
                list: ['猫咪', '狗狗'],
                tabIndex: 0,
                keyword: '',
                search: '',
                rawData: {},
                filterdList: {},
            };
        },
        computed: {
            filterdList() {
                const rawList = this.tabIndex === 0 ? this.rawData.cat : this.rawData.dog;
                if (this.keyword.trim()) {
                    const keyword = this.keyword.trim();
                    const filterdList = {};
                    for (const key in rawList) {
                        filterdList[key] = rawList[key].filter((item) => item.title.indexOf(keyword) > -1 || item.short_title.indexOf(search) > -1)
                    }
                    return filterdList;
                } else {
                    return rawList;
                }
            }
        },
        onLoad() {
            this.petwikiList()
        },
        watch: {
            keyword() {
                if (this.keyword.trim() === '') {
                    this.filterList();
                }
            }
        },
        methods: {
            async petwikiList() {
                let res = await this.$api.petwikiList();
                if (res.data.code == 1) {
                    this.rawData = res.data.data;
                    this.filterList();
                }
            },
            filterList() {
                const rawList = this.tabIndex === 0 ? this.rawData.cat : this.rawData.dog;
                if (this.keyword.trim()) {
                    const keyword = this.keyword.trim();
                    const filterdList = {};
                    for (const key in rawList) {
                        filterdList[key] = rawList[key].filter((item) => item.title.indexOf(keyword) > -1 || item.short_title.indexOf(keyword) > -1)
                    }
                    this.filterdList = filterdList;
                } else {
                    this.filterdList = rawList;
                }
            },
            switchTab(index) {
                this.tabIndex = index;
                this.filterList();
            },
            answer(item) {
                uni.navigateTo({
                    url: './answer?contentId=' + JSON.stringify(item.id)
                })
            }
        }
    }
</script>

<style lang="scss">
    .centent {
        background-color: #F5F5F6;
        height: auto;
        padding-top: 30rpx;
        padding-bottom: 30rpx;
    }

    .search {
        width: 690rpx;
        height: 79rpx;
        background-color: #fff;
        border-radius: 40rpx;
        border: 1rpx solid rgba(187, 187, 187, 1);
        margin: 0 auto;
        display: flex;
        align-items: center;
    }

    .search .placeholder {
        color: #888888;
        font-size: 30rpx;

    }

    .search input {
        color: #888888;
        font-size: 30rpx;
        margin-left: 30rpx;
    }

    .search image {
        width: 30rpx;
        height: 30rpx;
        margin-left: auto;
        margin-right: 30rpx;
    }

    .list {
        display: flex;
        padding-top: 30rpx;
        width: 650rpx;
        margin: 0 auto;
    }

    .list view {
        color: #888888;
        text-align: center;
        width: 325rpx;
        font-size: 30rpx;
        padding-bottom: 20rpx;
    }

    .active {
        color: #7BC6BD !important;
        border-bottom: 2rpx solid #7BC6BD;
    }

    .noviceBasis {
        padding-top: 30rpx;
        padding-left: 30rpx;
    }

    .noviceBasis .basis {
        color: #333333;
        font-size: 30rpx;
        font-weight: bold;
    }

    .centent_immune {
        padding-top: 20rpx;
    }

    .centent_immune view {
        display: inline-block;
        width: 214rpx;
        height: 73rpx;
        text-align: center;
        background-color: #C3F0EB;
        border: 1px solid #C3F0EB;
        margin-right: 20rpx;
        margin-bottom: 20rpx;
        line-height: 80rpx;
        color: #333333;
    }
</style>
