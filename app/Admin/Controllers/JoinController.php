<?php

namespace App\Admin\Controllers;

use App\Models\Join;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class JoinController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '预约加盟';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Join());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('sex', __('Sex'))->using([1 => '男', 2 => '女', 0 => '保密'])->dot([
            1 => 'primary',
            2 => 'danger',
            0 => 'success',
        ], 'warning');
        $grid->column('phone', __('Phone'))->copyable();
        $grid->column('email', __('Email'))->copyable();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'))->hide();

        $grid->filter(function ($filter) {
            $filter->like('name', __('Name'));
            $filter->like('phone', __('Phone'));
            $status_text = [
                1 => '男',
                2 => '女',
                0 => '保密'
            ];
            $filter->equal('sex', __('Sex'))->select($status_text);
        });


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
        $show = new Show(Join::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('sex', __('Sex'))->using([1 => '男', 2 => '女', 0 => '保密']);
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
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
        $form = new Form(new Join());

        $form->text('name', __('Name'))->rules('required');
        $form->select('sex', __('Sex'))->options([1 => '男', 2 => '女', 0 => '保密'])->default(0);
        $form->text('phone', __('Phone'))->rules('required');
        $form->email('email', __('Email'));

        return $form;
    }
}
