<?php

namespace App\Admin\Controllers;

use App\Model\WorldCity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WorldCityController extends AdminController
{
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
    protected function grid()
    {
        $grid = new Grid(new WorldCity);

        $grid->column('id', __('Id'));
        $grid->column('country_id', __('Country id'));
        $grid->column('state', __('State'));
        $grid->column('name', __('Name'));
        $grid->column('lower_name', __('Lower name'));
        $grid->column('cn_state', __('Cn state'));
        $grid->column('cn_name', __('Cn name'));
        $grid->column('state_code', __('State code'));
        $grid->column('city_code', __('City code'));
        $grid->column('active', __('Active'));
        $grid->column('is_island', __('Is island'));
        $grid->column('promotion', __('Promotion'));
        $grid->column('capital', __('Capital'));
        $grid->column('is_departure', __('Is departure'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(WorldCity::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('country_id', __('Country id'));
        $show->field('state', __('State'));
        $show->field('name', __('Name'));
        $show->field('lower_name', __('Lower name'));
        $show->field('cn_state', __('Cn state'));
        $show->field('cn_name', __('Cn name'));
        $show->field('state_code', __('State code'));
        $show->field('city_code', __('City code'));
        $show->field('active', __('Active'));
        $show->field('is_island', __('Is island'));
        $show->field('promotion', __('Promotion'));
        $show->field('capital', __('Capital'));
        $show->field('is_departure', __('Is departure'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WorldCity);

        $form->number('country_id', __('Country id'));
        $form->text('state', __('State'));
        $form->text('name', __('Name'));
        $form->text('lower_name', __('Lower name'));
        $form->text('cn_state', __('Cn state'));
        $form->text('cn_name', __('Cn name'));
        $form->text('state_code', __('State code'));
        $form->text('city_code', __('City code'));
        $form->switch('active', __('Active'));
        $form->switch('is_island', __('Is island'));
        $form->switch('promotion', __('Promotion'));
        $form->switch('capital', __('Capital'));
        $form->text('is_departure', __('Is departure'));

        return $form;
    }
}
