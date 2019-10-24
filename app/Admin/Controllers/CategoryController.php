<?php

namespace App\Admin\Controllers;

use App\Model\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Category | 分类';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new Category);

		$grid->column('id', __('Id'));
		$grid->column('name', __('名称'));
		$grid->column('parent_id', __('父 id'));
		$grid->column('order', __('排序'));
		$grid->column('description', __('说明'))->limit(30);
		$states = [
			'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
		];
		$grid->column('active', __('激活'))->switch($states);
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
		$show = new Show(Category::findOrFail($id));

		$show->field('id', __('Id'));
		$show->field('name', __('名称'));
		$show->field('parent_id', __('父 id'));
		$show->field('order', __('排序'));
		$show->field('description', __('说明'));
		$show->field('active', __('激活'));
		$show->field('created_at', __('Created at'));
		$show->field('updated_at', __('Updated at'));
		$show->field('deleted_at', __('Deleted at'));

		return $show;
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form() {
		$form = new Form(new Category);

		$form->text('name', __('名称'));
		$form->number('parent_id', __('父 id'));
		$form->number('order', __('排序'));
		$form->textarea('description', __('说明'))->rows(10);
		$form->switch('active', __('激活'));

		return $form;
	}
}
