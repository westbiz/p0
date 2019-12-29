<?php

namespace App\Admin\Controllers;

use App\Model\ChinaArea;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ChinaareaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '国内区域';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ChinaArea);

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(3 / 4, function ($filter) {
                $areas = ChinaArea::where('level','2')
                    ->orderBy('id', 'asc')
                    ->pluck('areaName', 'id');
                $filter->expand()->equal('parent_id', '地区|城市')->select($areas);

            });
        });

        $grid->column('id', __('Id'));
        $grid->column('areaCode', __('代码'));
        $grid->column('areaName', __('区域名称'));
        $grid->column('parentarea.areaName', __('父级'))->label('info');
        $grid->column('level', __('等级'));
        $grid->column('cityCode', __('城市编码'));
        $states = [
            'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ];
        $grid->column('active', __('激活'))->switch($states);        
        // $grid->column('center', __('Center'));        
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ChinaArea::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('areaCode', __('代码'));
        $show->field('areaName', __('区域名称'));
        $show->field('active', __('激活'));
        $show->field('level', __('等级'));
        $show->field('cityCode', __('城市编码'));
        // $show->field('center', __('Center'));
        $show->field('parent_id', __('Parent id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ChinaArea);

        $form->text('areaCode', __('代码'));
        $form->text('areaName', __('区域名称'));
        $form->number('parent_id', __('父级'))->default(-1);        
        $form->switch('active', __('激活'));
        $form->switch('level', __('等级'))->default(-1);
        $form->text('cityCode', __('城市代码'));
        // $form->text('center', __('Center'));


        return $form;
    }
}
