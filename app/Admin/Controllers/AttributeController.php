<?php

namespace App\Admin\Controllers;

use App\Model\Attribute;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AttributeController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Attribute | 属性';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new Attribute);

		$grid->column('id', __('Id'));
		$grid->column('name', __('名称'));
		$grid->column('parent_id', __('父类'));
		$grid->column('en_name', __('英文'));
		$grid->column('isrequired', __('必须'));
		$grid->column('inputtype', __('控件'));
		$grid->column('inputformat', __('格式'));
		// $grid->column('extra', __('扩展'));
		$grid->column('order', __('排序'));
		$states = [
			'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
		];
		$grid->column('active', __('激活'))->switch($states);
		$grid->column('created_at', __('Created at'))->date('Y-m-d');
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
		$show = new Show(Attribute::findOrFail($id));

		$show->field('id', __('Id'));
		$show->field('name', __('名称'));
		$show->field('parent_id', __('父类'));
		$show->field('en_name', __('英文'));
		$show->field('isrequired', __('必须'));
		$show->field('inputtype', __('控件'));
		$show->field('inputformat', __('格式'));
		$show->field('extra', __('扩展'));
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
		$form = new Form(new Attribute);

		$form->text('name', __('名称'));
		$form->number('parent_id', __('父类'));
		$form->text('en_name', __('英文'));
		$form->switch('isrequired', __('必须'));
		$form->text('inputtype', __('控件'));
		$form->text('inputformat', __('格式'));
		$form->text('extra', __('扩展'));
		$form->switch('order', __('排序'));
		$form->switch('active', __('激活'));

		return $form;
	}
}
