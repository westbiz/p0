<?php

namespace App\Admin\Controllers;

use App\Model\Attribute;
use App\Model\Category;
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
		$grid->column('parentattr.name', __('父类'))->label('primary');
		$grid->categories('归属分类')->pluck('name')->label('warning');
		$grid->column('attrvalues', '属性值')->pluck('attrvalue')->label('info')->style('max-width:200px;line-height:1.5em;word-break:break-all;');
		$grid->column('en_name', __('英文'));
		// $grid->column('isrequired', __('必须'));
		$grid->column('inputtype', __('控件'));
		// $grid->column('inputformat', __('格式'));
		// $grid->column('extra', __('扩展'));
		$grid->column('order', __('排序'));
		$states = [
			'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
		];
		$grid->column('active', __('激活'))->switch($states);
		// $grid->column('created_at', __('Created at'))->date('Y-m-d');
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

		$form->text('name', __('名称'))->rules('required|min:2');
		$form->multipleSelect('categories', '归属分类')->options(Category::where('parent_id', 0)->pluck('name', 'id'));
		$form->number('parent_id', __('父类'));
		$form->text('en_name', __('英文'));
		$form->switch('isrequired', __('必须'));
		$form->text('inputtype', __('控件'));
		$form->text('inputformat', __('格式'));
		$form->table('extra', '扩展项', function ($table) {
			$table->text('key');
			$table->text('value');
			$table->text('desc');
		});
		$form->switch('order', __('排序'));
		$form->switch('active', __('激活'));
		$form->hasMany('attrvalues', '属性值', function (Form\NestedForm $form) {
			$form->text('attrvalue', '值名');
			$form->text('order', '说明');
			$form->radio('status', '状态')->options([1 => '是', 0 => '否'])->default(0);
		});

		return $form;
	}
}
