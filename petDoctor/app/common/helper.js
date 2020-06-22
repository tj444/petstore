const imgUrl="https://catdoctor.elmerzhang.com";//图片路径前缀
const nickname_object = {}
const now = Date.now || function () {
	return new Date().getTime();
};

const isArray = Array.isArray || function (obj) {
	return obj instanceof Array;
};


//混入整页加载以及技术支持模块；
let MixinSL={
	data() {
		return {
			showloadCen:true,
		}
	},
	onLoad() {
		this.showloadCen=true;
	},
	onReady() {
		setTimeout(()=>{
			this.showloadCen=false;
		},1000)
	},
}

//混入下拉刷新、上拉加载更多功能
let BetterPull = ({ 
	getPage, 
	list = "list", 
	page = "page" 
}) => {
  return {
    data() {
      return { 
				[list]: [],
				[page]: 1 ,
			};
    },
    onPullDownRefresh() {
      this.Refresh();
    },
    onReachBottom() {
      getPage.call(this, this[page], this.__pulldone);
    },
    mounted() {
      this.Refresh();
    },
    methods: {
      Refresh() {
        this[page] = 1;
        getPage.call(this, this[page], this.__pulldone);
      },
      __pulldone(data) {
        var db = data || [];
        if (this[page] == 1) {
          this[list] = db;
        } else {
          this[list] = (this[list] || []).concat(db);
        }
        uni.stopPullDownRefresh();
        this[page]++;
      }
    }
  };
}

// 获取传入的url对应的参数值
let getUrlParam  = function(name,query) {
    var urlArr = query.split("?");
    if(!urlArr[1]) return false;
    var paramstr = urlArr[1];
    var vars = paramstr.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] == name){return pair[1];}
    }
    return(false);
};

   //时间戳转化方法
   let timestampToTime = function(timestamp) {
				var date = new Date(timestamp * 1000);
			  var Y = date.getFullYear() + '年';
			  var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '月';
			  var D = (date.getDate() < 10 ? '0'+date.getDate() : date.getDate()) + '日';
				 var h = (date.getHours() < 10 ? '0'+date.getHours() : date.getHours()) + ':';
				 var m = (date.getMinutes() < 10 ? '0'+date.getMinutes() : date.getMinutes()) ;
				return Y + M + D + h + m;
			};
 var getAllQuestion_objetct = {};
 var arr_lisir_index = Number;
module.exports = {
	imgUrl,
	now,
	isArray,
	MixinSL,
	BetterPull,
  getUrlParam,
	timestampToTime,
	nickname_object,
	getAllQuestion_objetct,
	arr_lisir_index
};