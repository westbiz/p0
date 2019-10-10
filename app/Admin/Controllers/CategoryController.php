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
		$grid->column('name', __('Name'));
		$grid->column('parent_id', __('Parent id'));
		$grid->column('order', __('Order'));
		$grid->column('description', __('Description'));
		$grid->column('active', __('Active'));
		$grid->column('created_at', __('Created at'));
		$grid->column('updated_at', __('Updated at'));
		$grid->column('deleted_at', __('Deleted at'));

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
		$show->field('name', __('Name'));
		$show->field('parent_id', __('Parent id'));
		$show->field('order', __('Order'));
		$show->field('description', __('Description'));
		$show->field('active', __('Active'));
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

		$form->text('name', __('Name'));
		$form->number('parent_id', __('Parent id'));
		$form->number('order', __('Order'));
		$form->text('description', __('Description'));
		$form->switch('active', __('Active'));

		return $form;
	}
}
