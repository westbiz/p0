<?php

namespace App\Admin\Controllers;

use App\Model\ChinaArea;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class ChinaareaController extends AdminController {
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
	protected function grid() {
		$grid = new Grid(new ChinaArea);

        // $grid->model()->dishi();

		$grid->filter(function ($filter) {
			$filter->disableIdFilter();
			$filter->column(3 / 4, function ($filter) {
				$filter->expand()->where(function ($query) {
                    
                    $results = ChinaArea::where('areaName', 'like', "%{$this->input}%")->pluck('id');
                    // dd($results);
					$data = $query->with('children')
                        ->where('parent_id', '=', $results);
                        
                    return $data;
				}, '关键字搜索');
			});
		});

		$grid->selector(function (Grid\Tools\Selector $selector) {
			$provinces = ChinaArea::where('parent_id', -1)->pluck('areaName', 'id');
			$selector->select('parent_id', '城市类型', $provinces);
		});

		$grid->column('id', __('Id'));
		$grid->column('areaCode', __('代码'));
		$grid->column('areaName', __('区域名称'));
		$grid->column('parent.areaName', __('父级'))->label('info');
        // $grid->column('children', __('下辖'))->pluck('areaName')->label('default')
        //     ->style('max-width:100px;line-height:1.5em;word-break:break-all;');
        // $grid->column('children', __('下辖'))->display(function($children){
        //     $children = array_map(function($child){
        //         return "<span style='max-width:50px;line-height:1.5em;word-break:break-all;'><a href='/admin/china-areas/{$child['id']}/edit'>{$child['areaName']}</a></span>";
        //     }, $children);
        //     return join('&nbsp;', $children);
        // });
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
	protected function detail($id) {
		$show = new Show(ChinaArea::findOrFail($id));

		$show->field('id', __('Id'));
		$show->field('areaCode', __('代码'));
		$show->field('areaName', __('区域名称'));
		// $show->field('active', __('激活'));
		// $show->field('level', __('等级'));
		// $show->field('cityCode', __('城市编码'));
		// $show->field('center', __('Center'));
		// $show->field('parent_id', __('Parent id'));

        $show->children('下辖',function($child){
            $child->setResource('/admin/china-areas');
            $child->id();
            $child->parent_id();
            $child->areaName();
            $child->cityCode();
            $child->active();
            $child->level();
            $child->cityCode();
            $child->center();
        });
		// $show->field('created_at', __('Created at'));
		// $show->field('updated_at', __('Updated at'));

		return $show;
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form() {
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
