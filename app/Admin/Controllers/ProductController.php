<?php

namespace App\Admin\Controllers;

use App\Http\Resources\CountryResource;
use App\Model\Country;
use App\Model\Product;
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
		$grid->column('name', __('Name'));
		// $grid->column('avatar', __('Avatar'));
		// $grid->column('pictureuri', __('Pictureuri'));
		$grid->column('category_id', __('Category'));
		$grid->column('day', __('Day'));
		$grid->column('night', __('Night'));
		$grid->column('star', __('Star'));
		// $grid->column('summary', __('Summary'));
		$grid->column('route', __('Route'));
		$grid->column('content', __('Content'))->limit(30);
		$grid->column('active', __('Active'));
		$grid->column('attributes', __('Attributes'));
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
		$show->field('name', __('Name'));
		$show->field('avatar', __('Avatar'));
		$show->field('pictureuri', __('Pictureuri'));
		$show->field('category_id', __('Category id'));
		$show->field('day', __('Day'));
		$show->field('night', __('Night'));
		$show->field('star', __('Star'));
		$show->field('summary', __('Summary'));
		$show->field('route', __('Route'));
		$show->field('content', __('Content'));
		$show->field('active', __('Active'));
		$show->field('attributes', __('Attributes'));
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
		$form = new Form(new Product);

		$c_id = request()->get('category');
		$form->text('name', __('Name'));
		// 国内
		// $form->multipleSelect('cid', 'city')->options(function ($id) {
		// 	$city = Worldcity::find($id);
		// 	if ($city) {
		// 		return [$city->id => $city->cn_name];
		// 	}
		// })->ajax('/api/v1/worldcities/getchinacitiesbykeyword');
		// //国外
		$groups = CountryResource::collection(Country::all());

		// dd($groups);
		$form->select('id', 'city')->options()->groups($groups);
		// $form->select('id', 'city')->options()
		// ->ajax('/api/v1/worldcities/getabroadcitiesbycountry');
		// $form->image('avatar', __('Avatar'));
		// $form->text('pictureuri', __('Pictureuri'));
		// $form->select('category_id', __('Category'))->options(Category::pluck('name', 'id'))->default($c_id);
		// $form->number('day', __('Day'));
		// $form->number('night', __('Night'));
		// $form->switch('star', __('Star'));
		// $form->text('summary', __('Summary'));
		// $form->text('route', __('Route'));
		// $form->textarea('content', __('Content'));
		// $form->switch('active', __('Active'));
		// $form->text('attributes', __('Attributes'));

		return $form;
	}
}
