<?php

namespace App\Admin\Controllers;

use App\Model\Continent;
use App\Model\Country;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CountryController extends AdminController {
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Country | 国家地区';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid(new Country);

		$grid->filter(function ($filter) {
			$filter->disableIdFilter();

			$filter->column(3 / 4, function ($filter) {
				$continents = Continent::where('parent_id', '0')->pluck('cn_name', 'id');
				$filter->expand()->equal('continent_id', '大洲')->select($continents);
				$filter->expand()->where(function ($query) {
					$query->where('cname', 'like', "%{$this->input}%")
						->orWhere('full_cname', 'like', "%{$this->input}%")
						->orWhere('name', 'like', "%{$this->input}%")
						->orWhere('country_code', 'like', "%{$this->input}%");
					// $query->whereHas('country', function ($query){
					//  $query->where('cname', 'like', "%{$this->input}%");
					// });
				}, '关键字');
			});
		});

		$grid->column('id', __('Id'));
		// $grid->column('continent_id', __('洲 id'));
		$grid->column('cname', __('中文名'));
		$grid->column('continent.cn_name', '洲名');
		$grid->continentlocation('地理位置')->pluck('cn_name')->label('danger');
		$grid->column('name', __('英文名称'));
		// $grid->column('lower_name', __('小写'))->limit(10);
		$grid->column('country_code', __('国家地区代码'))->limit(10);
		$grid->column('full_name', __('英文全称'))->limit(10);
		$grid->column('full_cname', __('中文全称'))->limit(10);
		// $grid->column('remark', __('概况'))->limit(30);
		$grid->column('is_island', __('海岛'))->bool();
		$states = [
			'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
			'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
		];
		$grid->column('active', __('激活'))->switch($states);
		$grid->column('promotion', __('推荐'))->switch($states);
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
		$show = new Show(Country::findOrFail($id));

		$show->field('id', __('Id'));
		// $show->field('continent_id', __('洲 id'));
		$show->continent('国家地区', function ($continent) {
			$continent->setResource('/admin/continents');
			$continent->cn_name('大洲');
		});
		$show->field('name', __('英文名称'));
		$show->field('lower_name', __('小写'));
		$show->field('country_code', __('国家地区代码'));
		$show->field('full_name', __('英文全称'));
		$show->field('cname', __('中文名'));
		$show->field('full_cname', __('中文全称'));
		$show->field('remark', __('备注'));
		$show->field('is_island', __('海岛'));
		$show->field('active', __('激活'));
		$show->field('promotion', __('推荐'));
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
		$form = new Form(new Country);

		// $form->number('continent_id', __('洲 id'));
		$form->text('cname', __('中文名'));
		$form->text('name', __('英文名称'));
		$form->text('full_name', __('英文全称'));
		$form->text('country_code', __('国家地区代码'));
		$form->text('full_cname', __('中文全称'));
		$form->text('lower_name', __('英全称小写'));
		$form->select('continent_id', '洲名')->options(Continent::where('parent_id', 0)->pluck('cn_name', 'id'));
		$form->multipleSelect('continentlocation', '地理位置')->options(Continent::where('parent_id', '>', '0')->pluck('cn_name', 'id'));

		$form->textarea('remark', __('概况'));
		$form->switch('is_island', __('海岛'));
		$form->switch('active', __('激活'))->default(1);
		$form->switch('promotion', __('推荐'));

		return $form;
	}
}
