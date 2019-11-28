<?php

namespace App\Admin\Controllers;

use App\Model\Country;
use App\Model\Destination;
use App\Model\Destinationtype;
use App\Model\Worldcity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DestinationController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Destination | 目的地';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new Destination);

		$grid->filter(function ($filter) {
			$filter->disableIdFilter();
			$filter->column(3 / 4, function ($filter) {
				$cities = Worldcity::orderBy('cn_name', 'asc')->pluck('cn_name', 'id');
				$filter->expand()->equal('city_id', '地区|城市')->select($cities);

			});
		});

		$grid->selector(function (Grid\Tools\Selector $selector) {
			$selector->select('areatype', '城市类型', [
				'cities' => '城市区域',
				'regions' => '国家地区',
			]);
		});

		$grid->column('id', __('Id'));
		$grid->column('name', __('Name'))->editable();
		$grid->column('country.cname', __('Country'));
		// $grid->column('city_id', __('City'));
		$grid->column('city.cn_name', __('City'));
		$grid->types()->pluck('name')->label('warning')->style('max-width:150px;line-height:1.5em;word-break:break-all;');
		$grid->column('description', __('Description'))->editable();
		$states = [
			'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
		];
		$grid->column('promotion', __('Promotion'))->switch($states);
		$grid->column('active', __('激活'))->switch($states);
		$grid->column('sort', __('Sort'));
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
		$show = new Show(Destination::findOrFail($id));

		$show->field('id', __('Id'));
		$show->field('name', __('Name'));
		$show->field('country_id', __('Country Id'));
		$show->field('city_id', __('City Id'));
		$show->field('description', __('Description'));
		$show->field('promotion', __('Promotion'));
		$show->field('sort', __('Sort'));
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
		$form = new Form(new Destination);

		$r_id = request()->get('region');
		$c_id = request()->get('city_id');

		$form->select('country_id', __('国家地区'))->options(Country::pluck('cname', 'id'))->default($r_id);
		// $form->select('form', __('form'))->options(Country::pluck('cname', 'id'));
		$form->select('city_id', __('城市'))->options(Worldcity::pluck('cn_name', 'id'))->default($c_id);
		$form->text('name', __('名称'))->rules('required|min:2');
		$form->multipleSelect('types', '类型')->options(Destinationtype::pluck('name', 'id'));

		$form->switch('promotion', __('推荐'));
		$form->number('sort', __('排序'));
		$form->textarea('description', __('描述'))->rows(5);

		return $form;
	}
}
