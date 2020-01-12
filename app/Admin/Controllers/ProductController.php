<?php

namespace App\Admin\Controllers;

use App\Model\Category;
use App\Model\ChinaArea;
use App\Model\Product;
use App\Model\Worldcity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

//
class ProductController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Product | 产品';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new Product);

		$grid->column('id', __('Id'));
		$grid->column('name', __('名称'));
		// $grid->column('avatar', __('海报'));
		// $grid->column('pictureuri', __('图片'));
		$grid->column('category_id', __('分类'));
		$grid->column('day', __('天数'));
		$grid->column('night', __('晚数'));
		$grid->column('star', __('星级'));
		// $grid->column('summary', __('概述'));
		$grid->column('route', __('行程'));
		$grid->column('content', __('正文'))->limit(30);
		$grid->column('active', __('上架'));
		$grid->column('attributes', __('属性'));
		$grid->column('编辑')->display(function ($destination) {

			return "<a href='products/".$this->id."/edit?category=" . $this->category_id . "' title='Edit'><i class='fa fa-edit'></i> Edit</a>&nbsp;";
		});
		// $grid->column('created_at', __('Created at'));
		// $grid->column('updated_at', __('Updated at'));
		// $grid->column('deleted_at', __('Deleted at'));

		return $grid;
	}

	/**
	 * Make a show builder.
	 *
	 * @param mixed $id
	 * @return Show
	 */
	protected function detail($id) {
		$show = new Show(Product::findOrFail($id));

		$show->field('id', __('Id'));
		$show->field('name', __('名称'));
		$show->field('avatar', __('海报'));
		$show->field('pictureuri', __('图片'));
		$show->field('category_id', __('分类'));
		$show->field('day', __('天数'));
		$show->field('night', __('晚数'));
		$show->field('star', __('星级'));
		$show->field('summary', __('概述'));
		$show->field('route', __('行程'));
		$show->field('content', __('正文'));
		$show->field('active', __('上架'));
		$show->field('attributes', __('属性'));
		// $show->field('created_at', __('Created at'));
		// $show->field('updated_at', __('Updated at'));
		// $show->field('deleted_at', __('Deleted at'));

		return $show;
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form() {
		$form = new Form(new Product);

		$c_id = request()->get('category');
		// dd($form);
		$form->text('name', __('名称'));
		// 国内
		// $form->multipleSelect('cities', 'city')->options(Worldcity::pluck('cn_name', 'id'))
		// 	->ajax('/api/v1/worldcities/getchinacitiesbykeyword');

		// //select,groups---------------------
		// $groups = Country::select('cname', 'id')->get();
		// $data = [];
		// foreach ($groups as $group) {
		// 	$data[] = [
		// 		'label' => $group->cname,
		// 		'options' => $group->options()->pluck('cn_name', 'id'),
		// 	];
		// }
		// $form->select('cities', 'city')->options()->groups($data);

		// 国家地区
		// 当分类=国内，否则境外
		if ($c_id == 1) {
			$form->multipleSelect('chinacities', '城市')->options(ChinaArea::pluck('areaName','id'))->ajax('/api/v1/chinaareas/getcitiesbyprovince');
		} elseif ($c_id == 3) {
			$form->multipleSelect('chinacities', '城市')->options(ChinaArea::gangaotai()->pluck('areaName','id'));
		} 

		else {
			$form->multipleSelect('cities', '城市')->options(Worldcity::pluck('cn_name', 'id'))
			->ajax('/api/v1/worldcities/getcitieswithdesinationwords');
		}
		

		// $form->image('avatar', __('海报'));
		// $form->text('pictureuri', __('图片'));
		// $form->select('category_id', __('分类'))->options(Category::pluck('name', 'id'))->default($c_id);
		// $form->number('day', __('天数'));
		// $form->number('night', __('晚数'));
		// $form->switch('star', __('星级'));
		// $form->text('summary', __('概述'));
		// $form->text('route', __('行程'));
		// $form->textarea('content', __('正文'));
		// $form->switch('active', __('上架'));
		// $form->text('attributes', __('属性'));

		return $form;
	}
}
