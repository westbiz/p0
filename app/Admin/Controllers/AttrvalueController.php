<?php

namespace App\Admin\Controllers;

use App\Model\Attrvalue;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AttrvalueController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Attrvalue | 属性值';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new Attrvalue);

		$grid->column('id', __('Id'));
		$grid->column('attrvalue', __('值名'));
		$grid->column('attribute.name', __('属性'))->label();
		$grid->column('order', __('排序'));
		$states = [
			'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
		];
		$grid->column('active', __('激活'))->switch($states);
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
		$show = new Show(Attrvalue::findOrFail($id));

		$show->field('id', __('Id'));
		$show->field('attrvalue', __('值名'));
		$show->field('catattr_id', __('属性'));
		$show->field('order', __('排序'));
		$show->field('active', __('激活'));
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
		$form = new Form(new Attrvalue);

		$form->text('attrvalue', __('值名'));
		$form->number('catattr_id', __('属性'));
		$form->text('order', __('排序'));
		$form->switch('active', __('激活'));

		return $form;
	}
}
