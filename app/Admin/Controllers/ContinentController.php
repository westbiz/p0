<?php

namespace App\Admin\Controllers;

use App\Model\Continent;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ContinentController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Continent | 大洲';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new Continent);

		$grid->column('id', __('Id'));
		$grid->column('parent_id', __('父 id'));
		$grid->column('cn_name', __('名称'));
		$grid->column('en_name', __('英文'));
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
		$show = new Show(Continent::findOrFail($id));

		$show->field('id', __('Id'));
		$show->field('parent_id', __('父 id'));
		$show->field('cn_name', __('名称'));
		$show->field('en_name', __('英文'));
		$show->field('created_at', __('Created at'));
		$show->field('updated_at', __('Updated at'));

		return $show;
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form() {
		$form = new Form(new Continent);

		$form->switch('parent_id', __('父 id'));
		$form->text('cn_name', __('名称'));
		$form->text('en_name', __('英文'));

		return $form;
	}
}
