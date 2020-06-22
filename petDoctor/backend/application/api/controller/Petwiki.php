<?php

namespace app\api\controller;

use app\common\controller\Api;

/**
 * 宠物百科接口
 */
class Petwiki extends Api {

    protected $noNeedLogin = ['list', 'content', 'test'];

    /**
     * Petwiki模型对象
     * @var \app\admin\model\Petwiki
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Petwiki;
    }

    /**
     * 视频列表
     *
     * @ApiTitle    (百科文章列表)
     * @ApiSummary  (百科文章列表)
     * @ApiMethod   (GET)
     * @ApiRoute    (/api/petwiki/list)
     * @ApiReturnParams   (name="code", type="integer", required=true, sample="1")
     * @ApiReturnParams   (name="msg", type="string", required=true, sample="成功")
     * @ApiReturnParams   (name="data", type="object", sample="{'list':[{'id':'integer','title':'string','short_title':'string'}]}", description="扩展数据返回")
     * @ApiReturn   ({
         'code':'1',
         'msg':'成功',
         'data': {
             'cat': {
                 '新手基础': [{
                     'id': '文章ID',
                     'title': '文章标题',
                     'short_title': '文章短标题',
                 }],
                 '常见问题': [{
                     'id': '文章ID',
                     'title': '文章标题',
                     'short_title': '文章短标题',
                 }]
             },
             'dog': {
                 '新手基础': [{
                     'id': '文章ID',
                     'title': '文章标题',
                     'short_title': '文章短标题',
                 }],
                 '常见问题': [{
                     'id': '文章ID',
                     'title': '文章标题',
                     'short_title': '文章短标题',
                 }]
             }
         }
        })
     */
    public function list() {
        $list = $this->model->with(['category'])
                            ->field('category.name as category_name')
                            ->order(['order' => 'asc', 'id' => 'desc'])
                            ->select();

        $cats = array_filter(array_map(function($v) {if ($v['type'] === 'cat') {return $v;}}, $list));
        $dogs = array_filter(array_map(function($v) {if ($v['type'] === 'dog') {return $v;}}, $list));
        $data['cat']['新手基础'] = array_values(array_filter(array_map(function($v) {if ($v['category_name'] === '新手基础') {return array_intersect_key($v->toArray(), array('id'=>1,'title'=>1,'short_title'=>1));}}, $cats)));
        $data['cat']['常见问题'] = array_values(array_filter(array_map(function($v) {if ($v['category_name'] === '常见问题') {return array_intersect_key($v->toArray(), array('id'=>1,'title'=>1,'short_title'=>1));}}, $cats)));
        $data['dog']['新手基础'] = array_values(array_filter(array_map(function($v) {if ($v['category_name'] === '新手基础') {return array_intersect_key($v->toArray(), array('id'=>1,'title'=>1,'short_title'=>1));}}, $dogs)));
        $data['dog']['常见问题'] = array_values(array_filter(array_map(function($v) {if ($v['category_name'] === '常见问题') {return array_intersect_key($v->toArray(), array('id'=>1,'title'=>1,'short_title'=>1));}}, $dogs)));
        $this->success('成功', $data);
    }

    /**
     * 文章内容
     *
     * @ApiTitle    (百科文章内容)
     * @ApiSummary  (百科文章内容)
     * @ApiMethod   (GET)
     * @ApiRoute    (/api/petwiki/content)
     * @ApiParams   (name="id", type="integer", required=true, description="文章ID")
     * @ApiReturnParams   (name="code", type="integer", required=true, sample="1")
     * @ApiReturnParams   (name="msg", type="string", required=true, sample="成功")
     * @ApiReturnParams   (name="data", type="object", sample="{'title':'string', 'content':'string'}", description="扩展数据返回")
     * @ApiReturn   ({
         'code':'1',
         'msg':'成功',
         'data': {
             'title': '文章标题',
             'content': '文章HTML内容'
         }
        })
     */
    public function content() {
        $id = $this->request->param('id');
        if (!$id) {
            $this->error('失败', 'id 不能为空');
        }
        $data = $this->model->field('title, content')->where('id', $id)->find()->toArray();
        $data['content'] = preg_replace('/(src=")(\/uploads\/.+")/', '$1' . $this->request->domain() . '$2', $data['content']);
        unset($data['type_text']);

        $this->success('成功', $data);
    }
}
