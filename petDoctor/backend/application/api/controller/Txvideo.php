<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 腾讯视频接口
 */
class Txvideo extends Api {

    protected $noNeedLogin = ['list'];

    /**
     * Txvideo模型对象
     * @var \app\admin\model\Txvideo
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Txvideo;

    }

    /**
     * 视频列表
     *
     * @ApiTitle    (视频列表)
     * @ApiSummary  (获取视频列表)
     * @ApiMethod   (GET)
     * @ApiRoute    (/api/txvideo/list)
     * @ApiParams   (name="cursor", type="string", required=false, description="用于获取下一页的参数，第一页不需要传。获取下一页时 cursor 的值应为上次请求中返回的 cursor。")
     * @ApiReturnParams   (name="code", type="integer", required=true, sample="1")
     * @ApiReturnParams   (name="msg", type="string", required=true, sample="成功")
     * @ApiReturnParams   (name="data", type="object", sample="{'list':[{'vid':'string','title':'string','headimage':'string'}],'hasmore':'boolean','cursor':'string'}", description="扩展数据返回")
     * @ApiReturnParams   (name="data.list", type="object", sample="{'list':[{'vid':'string','title':'string','headimage':'string'}],'hasmore':'boolean','cursor':'string'}", description="扩展数据返回")
     * @ApiReturn   ({
         'code':'1',
         'msg':'成功',
         'data': {
             'list': [
                'vid': '视频ID',
                'title': '视频标题',
                'headimage': '视频图片'
             ],
             'hasmore': true,
             'cursor': '用于获取下一页的参数'
         }
        })
     */
    public function list() {
        $count = 10;
        $data = ['list' => [], 'hasmore' => false];
        $cursor = $this->request->param('cursor');

        $query = $this->model->order('id', 'desc')->limit($count + 1);
        if ($cursor) {
            $query = $query->where('id', '<', $cursor);
        }
        $list = $query->select();
        $data['hasmore'] = count($list) > $count;
        if ($data['hasmore']) {
            $data['list'] = array_slice($list, 0, $count);
            $data['cursor'] = $data['list'][$count - 1]['id'];
        } else {
            $data['list'] = $list;
        }
        $data['list'] = array_map(function($v) {return array_intersect_key($v->toArray(), array('vid'=>1, 'title'=>1, 'headimage'=>1));}, $data['list']);

        $this->success('成功', $data);
    }
}
