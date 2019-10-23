<?php

namespace App\Admin\Controllers;

use App\Model\Country;
use App\Model\WorldCity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WorldCityController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'WorldCity | 世界城市';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new WorldCity);

		$grid->filter(function ($filter) {
			$filter->disableIdFilter();
			$filter->column(3 / 4, function ($filter) {
				$continents = Country::orderBy('cname', 'asc')->pluck('cname', 'id');
				$filter->expand()->equal('country_id', '按国家|地区')->select($continents);
				$filter->expand()->where(function ($query) {
					$query->where('cn_name', 'like', "%{$this->input}%")
						->orWhere('cn_state', 'like', "%{$this->input}%")
						->orWhere('name', 'like', "%{$this->input}%")
						->orWhere('lower_name', 'like', "%{$this->input}%")
						->orWhere('state', 'like', "%{$this->input}%")
						->orWhere('city_code', 'like', "%{$this->input}%")
						->orWhere('state_code', 'like', "%{$this->input}%")
					;
					// $query->whereHas('country', function ($query){
					//  $query->where('cname', 'like', "%{$this->input}%");
					// });
				}, '关键字');
			});
		});

		$grid->column('id', __('Id'));
		$grid->column('cn_name', __('中文名'));
		$grid->column('country.cname', __('国家地区'));
		// $grid->column('state', __('州'));
		$grid->column('name', __('名称'));
		// $grid->column('lower_name', __('小写'));
		$grid->column('cn_state', __('中文省/州'));
		$grid->column('state_code', __('州代码'));
		$grid->column('city_code', __('城市代码'));
		$grid->column('is_island', __('海岛'))->bool();
		$grid->column('promotion', __('推荐'))->bool();
		$grid->column('capital', __('首府'))->bool();
		$grid->column('is_departure', __('出发地'))->bool();
		$states = [
		    'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
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
		$show = new Show(WorldCity::findOrFail($id));

		$show->field('id', __('Id'));
		// $show->field('country_id', __('国家地区'));
		$show->country('国家地区', function ($country) {
			$country->setResource('/admin/countries');
			$country->cname('国家地区');
		});
		$show->field('state', __('省/州'));
		$show->field('name', __('名称'));
		$show->field('lower_name', __('小写'));
		$show->field('cn_state', __('中文州/省'));
		$show->field('cn_name', __('中文名'));
		$show->field('state_code', __('州代码'));
		$show->field('city_code', __('城市代码'));
		$show->field('active', __('激活'));
		$show->field('is_island', __('海岛'));
		$show->field('promotion', __('推荐'));
		$show->field('capital', __('首府'));
		$show->field('is_departure', __('出发地'));
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
		$form = new Form(new WorldCity);

		// $form->number('country_id', __('国家'));
		$form->text('cn_name', __('中文名'));
		$form->select('country_id', '国家地区')->options(Country::pluck('cname', 'id'));
		$form->text('state', __('省/州'));
		$form->text('name', __('名称'));
		$form->text('lower_name', __('小写'));
		$form->text('cn_state', __('中文州/省'));
		$form->text('state_code', __('州代码'));
		$form->text('city_code', __('城市代码'));
		$form->switch('active', __('激活'));
		$form->switch('is_island', __('海岛'));
		$form->switch('promotion', __('推荐'));
		$form->switch('capital', __('首府'));
		$form->switch('is_departure', __('出发地'));

		return $form;
	}
}