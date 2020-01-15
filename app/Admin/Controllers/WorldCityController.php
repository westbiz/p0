<?php

namespace App\Admin\Controllers;

use App\Model\Country;
use App\Model\Destinationtype;
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
				}, '关键字搜索');
			});
			$continents = Country::orderBy('cname', 'asc')->pluck('cname', 'id');
			$filter->expand()->equal('country_id', '按国家|地区')->select($continents);
		});

		$grid->selector(function (Grid\Tools\Selector $selector) {
			// $selector->select('active', '状态', [
			// 	0 => '未激活',
			// 	1 => '已激活',
			// ]);
			// $selector->select('promotion', '推荐', [
			// 	0 => '未推荐',
			// 	1 => '推荐',
			// ]);
			// $countries = Country::pluck('cname','id');
			// $selector->select('country_id', '国家地区', $countries);
			$selector->select('capital', '城市类型', [
				0 => '城市',
				1 => '首府',
			]);
		});

		$grid->column('id', __('Id'));
		$grid->column('parent_id', __('父ID'));
		$grid->column('cn_name', __('中文名'));
		$grid->column('country.cname', __('国家地区'));
		// $grid->column('state', __('州'));
		$grid->column('name', __('名称'));
		// $grid->column('lower_name', __('小写'));
		$grid->column('cn_state', __('中文省/州'));
		$grid->column('state_code', __('州代码'));
		$grid->column('city_code', __('城市代码'));
		$states = [
			'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
		];
		$grid->column('is_island', __('海岛'))->bool();
		$grid->column('capital', __('首府'))->switch($states);
		$grid->column('is_departure', __('出发地'))->bool();
		$grid->column('promotion', __('推荐'))->switch($states);
		$grid->column('active', __('激活'))->switch($states);

		$grid->destinations()->pluck('name')->label()->style('max-width:200px;line-height:1.5em;word-break:break-all;');

		$grid->column('目的地')->display(function ($destination) {

			return "<a href='destinations/create?country_id=" . $this->country_id . "&city_id=" . $this->id . "' title='添加目的地'><i class='fa fa-plus-square'></i> Add</a>&nbsp;";
		});
		$grid->column('区县')->display(function ($destination) {

			return "<a href='worldcities/create?country_id=" . $this->country_id . "&parent_id=" . $this->id . "' title='添加区县'><i class='fa fa-plus-square-o'></i> Add</a>&nbsp;";
		});

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

		// $show->field('id', __('Id'));
		// $show->field('country_id', __('国家地区'));
		// $show->field('state', __('省/州'));
		// $show->field('name', __('名称'));
		// $show->field('lower_name', __('小写'));
		$show->field('cn_state', __('中文州/省'));
		$show->field('cn_name', __('中文名称'));
		// $show->field('state_code', __('州代码'));
		// $show->field('city_code', __('城市代码'));
		// $show->field('active', __('激活'));
		// $show->field('is_island', __('海岛'));
		// $show->field('promotion', __('推荐'));
		// $show->field('capital', __('首府'));
		// $show->field('is_departure', __('出发地'));
		// $show->field('created_at', __('Created at'));
		// $show->field('updated_at', __('Updated at'));

		$show->destinations('目的地', function ($destinations) {
			$destinations->resource('/admin/destinations');

			$destinations->id();
			$destinations->name()->editable();
			$destinations->country_id();
			// $destinations->city_id', __('City'));
			// $destinations->destinationtype('类型')->name()->label();
			$destinations->types()->pluck('name')->label();
			// $destinations->type_id();
			$destinations->description();
			$states = [
				'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
				'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
			];
			$destinations->promotion()->switch($states);
			$destinations->active();
			$destinations->sort();

		});

		return $show;
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form() {
		$form = new Form(new WorldCity);

		$country_id= request()->get('country_id');
		$parent_id= request()->get('parent_id');
		$form->text('cn_name', __('中文名'));
		if ($parent_id || $coungry_id) {
			$form->select('country_id', __('国家地区'))->options(Country::pluck('cname', 'id'))->default($country_id);
			$form->select('parent_id', __('父级'))->options(Worldcity::pluck('cn_name', 'id'))->default($parent_id);
		} else {
			$form->select('country_id', __('国家地区'))->options(Country::pluck('cname', 'id'));
			$form->select('parent_id', __('父级'))->options(Worldcity::pluck('cn_name', 'id'))->default('0');
		}
		
		
		$form->text('state', __('省/州'));
		$form->text('name', __('EN名称'));
		$form->text('lower_name', __('小写'));
		$form->text('cn_state', __('中文州/省'));
		$form->text('state_code', __('州代码'));
		$form->text('city_code', __('城市代码'));
		$form->switch('active', __('激活'));
		$form->switch('is_island', __('海岛'));
		$form->switch('promotion', __('推荐'));
		$form->switch('capital', __('首府'));
		$form->switch('is_departure', __('出发地'));

		$form->hasMany('destinations', '目的地', function (Form\NestedForm $form) {
			$c_id = request()->route()->parameters('worldcities');
			$form->text('name', __('名称'));
			$form->select('country_id', __('地区'))->options(Country::pluck('cname', 'id'));
			$form->select('type_id', __('类型'))->options(Destinationtype::pluck('name', 'id'));
			$form->text('description', __('描述'));
			// $states = [
			// 	'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			// 	'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
			// ];
			// $form->text('promotion');
			// $form->text('active');
			// $form->text('sort');
		});

		return $form;
	}
}
