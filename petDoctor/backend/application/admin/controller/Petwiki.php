<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 宠物百科
 *
 * @icon fa fa-circle-o
 */
class Petwiki extends Backend
{
    
    /**
     * Petwiki模型对象
     * @var \app\admin\model\Petwiki
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Petwiki;
        $this->view->assign("typeList", $this->model->getTypeList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams('type');
            $total = $this->model
                    ->with(['category'])
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

            $list = $this->model
                    ->with(['category'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            $resultList = [];
            foreach ($list as $row) {
                $item = array_intersect_key($row->toArray(), array_fill_keys(['id', 'order', 'title', 'short_title', 'type', 'createtime', 'updatetime'], 1));
                $item['category_name'] = $row['category']['name'];
                $resultList[] = $item;
            }
            $result = array("total" => $total, "rows" => $resultList);

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 生成查询所需要的条件,排序方式
     * @param mixed   $searchfields   快速查询的字段
     * @param boolean $relationSearch 是否关联查询
     * @return array
     */
    //protected function buildparams($searchfields = null, $relationSearch = null)
    //{
    //    $result = parent::buildparams();
    //    $type = $this->request->request('type');
    //    if ($type) {
    //        $result[0] = $result[0]->where('type', $type);
    //    }
    //    return $result;
    //}
}
