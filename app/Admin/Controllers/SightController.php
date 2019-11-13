<?php

namespace App\Admin\Controllers;

use App\Model\Sight;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SightController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Sight | 景区景点';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new Sight);

		$grid->column('id', __('Id'));
		$grid->column('name', __('Name'));
		// $grid->column('avatar', __('Avatar'));
		$grid->column('rate', __('Rate'));
		$grid->column('grade', __('Grade'));
		$grid->column('extra', __('Extra'));
		$grid->column('city_id', __('City id'));
		$grid->column('parent_id', __('Parent id'));
		$grid->column('summary', __('Summary'));
		$grid->column('content', __('Content'))->limit(50);
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
		$show = new Show(Sight::findOrFail($id));

		$show->field('id', __('Id'));
		$show->field('name', __('Name'));
		$show->field('avatar', __('Avatar'));
		$show->field('rate', __('Rate'));
		$show->field('grade', __('Grade'));
		$show->field('extra', __('Extra'));
		$show->field('city_id', __('City id'));
		$show->field('parent_id', __('Parent id'));
		$show->field('summary', __('Summary'));
		$show->field('content', __('Content'));
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
		$form = new Form(new Sight);

		$form->text('name', __('Name'));
		$form->image('avatar', __('Avatar'));
		$form->text('rate', __('Rate'));
		$form->text('grade', __('Grade'));
		$form->text('extra', __('Extra'));
		$form->number('city_id', __('City id'));
		$form->text('parent_id', __('Parent id'));
		$form->text('summary', __('Summary'));
		$form->text('content', __('Content'));

		return $form;
	}
}
