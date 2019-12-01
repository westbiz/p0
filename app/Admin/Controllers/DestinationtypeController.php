<?php

namespace App\Admin\Controllers;

use App\Model\Destinationtype;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class DestinationtypeController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Destinationtype | 目的地类型';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new Destinationtype);

		$grid->column('id', __('Id'))->editable();
		$grid->column('name', __('名称'))->editable();
		$grid->column('parenttype.name', __('父类'))->label();
		// $grid->column('order', __('排序'));
		$grid->column('description', __('描述'))->editable();
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
		$show = new Show(Destinationtype::findOrFail($id));

		// $show->field('id', __('Id'));
		$show->field('name', __('名称'));
		// $show->field('parent_id', __('父类'));
		$show->field('order', __('排序'));
		$show->field('description', __('描述'));
		$show->childtypes('子类', function ($childtypes) {
			$childtypes->resource('/admin/destinationtypes');
			$childtypes->name()->editable();
			$childtypes->parent_id();
			// $childtypes->order();
			$childtypes->description()->editable();
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
		$form = new Form(new Destinationtype);

		$p_id = request()->get('parent_id');
		// dd($p_id);
		$form->select('parent_id', '父类')->options(Destinationtype::where('parent_id', 0)->pluck('name', 'id'))->default($p_id);
		// $form->number('parent_id', __('Parent id'));
		$form->text('name', __('名称'))->rules('required|min:2');

		// $next_id = DB::select("SHOW TABLE STATUS LIKE 'tx_destinationtype'");
		// $form->number('order', __('排序'))->value($next_id[0]->Auto_increment)->readonly();
		$form->text('description', __('描述'));

		return $form;
	}
}
