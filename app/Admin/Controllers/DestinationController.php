<?php

namespace App\Admin\Controllers;

use App\Model\Destination;
use App\Model\Country;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DestinationController extends AdminController
{
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
    protected function grid()
    {
        $grid = new Grid(new Destination);

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('country_id', __('Country'));
        $grid->column('city_id',__('City'));
        $grid->column('city.cn_name', __('City'));
        $grid->column('type',__('AreaTpye'))->editable();
        $grid->column('description', __('Description'))->editable();
        $states = [
            'on' => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ];
        $grid->column('promotion', __('Promotion'))->switch($states);
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
    protected function detail($id)
    {
        $show = new Show(Destination::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('country_id', __('Country id'));
        $show->field('city_id', __('City id'));
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
    protected function form()
    {
        $form = new Form(new Destination);

        $form->text('name', __('Name'));
        $form->text('country_id', __('Country id'));
        $form->select('form',__('form'))->options(Country::pluck('cname','id'));
        $form->text('city_id', __('City id'));
        $form->text('type',__('type'));
        $form->keyValue('type');
        $form->text('description', __('Description'));
        $form->switch('promotion', __('Promotion'));
        $form->switch('sort', __('Sort'));

        return $form;
    }
}
