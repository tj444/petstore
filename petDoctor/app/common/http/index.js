import http from './interface'

//接口签名
http.interceptor.request = (config) => {
	  
}; 
//设置请求结束后拦截器
 http.interceptor.response = (response) => {
	  
};


 
// 生成随机数
function randomNum(minNum,maxNum){
    switch(arguments.length){
        case 1:
            return parseInt(Math.random()*minNum+1,10);
            break;
        case 2:
            return parseInt(Math.random()*(maxNum-minNum+1)+minNum,10);
            break;
        default:
            return 0;
            break;
    }
}

/**
 * 对象转url参数
 * @param {*} data
 * @param {*} isPrefix
 */
function queryParams(data, isPrefix = false) {
    let prefix = isPrefix ? '?' : '';
    let _result = [];
    for (let key in data) {
        let value = data[key];
        // 去掉为空的参数
        if ([undefined, null].includes(value)) {
            continue
        }

        if (value.constructor  === Array) {
            value.forEach(_value => {
                _result.push(key + '[]=' + fixedEncodeURIComponent(_value))
            })
        } else {
            _result.push(key + '=' + fixedEncodeURIComponent(value))
        }
    }

    return _result.length ? prefix + _result.join('&') : ''
}

function fixedEncodeURIComponent (str) {
    return encodeURIComponent(str).replace(/[!'()*]/g, function(c) {
        return '%' + c.charCodeAt(0).toString(16);
    });
}

/**
 * 将json数据进行排序
 * @param {*jason} data
 */
function JsonSort(jsonData) {
    try {
        let tempJsonObj = {};
        let sdic = Object.keys(jsonData).sort();
        sdic.map((item, index)=>{
            tempJsonObj[item] = jsonData[sdic[index]]
        })
        //console.log('将返回的数据进行输出',tempJsonObj);
        return tempJsonObj;
    } catch(e) {
        return jsonData;
    }
} 

//接口列表
export const petwikiList = (data) => {
  return http.request({
      url: 'api/petwiki/list',
      method: 'GET',
      data,
  })
}

export const content = (data) => {
  return http.request({
      url: 'api/petwiki/content',
      method: 'GET',
      data,
  })
}


export const txvideo = (data) => {
  return http.request({
      url: 'api/txvideo/list',
      method: 'GET',
      data,
  })
}


export default {
 petwikiList,
 content,
 txvideo
}