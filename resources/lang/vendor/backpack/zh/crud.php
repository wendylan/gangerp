<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dick Crud Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the CRUD interface.
    | You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    // Create form
    'add'                 => '添加新',
    'back_to_all'         => '返回 ',
    'cancel'              => '取消',
    'add_a_new'           => '添加新',

        // Create form - advanced options
        'after_saving'            => '保存之后',
        'go_to_the_table_view'    => '查看队列',
        'let_me_add_another_item' => '给该用户增加其他的项目',
        'edit_the_new_item'       => '编辑新的条目',

    // Edit form
    'edit'                 => '编辑',
    'save'                 => '保存',

    // CRUD table view
    'all'                       => '',
    'in_the_database'           => '在数据库中的所有记录',
    'list'                      => '列表',
    'actions'                   => '操作',
    'preview'                   => 'Preview',
    'delete'                    => '删除',
    'admin'                     => '管理员',
    'details_row'               => 'This is the details row. Modify as you please.',
    'details_row_loading_error' => 'There was an error loading the details. Please retry.',

        // Confirmation messages and bubbles
        'delete_confirm'                              => '你确定要删除该条目吗?',
        'delete_confirmation_title'                   => '条目删除',
        'delete_confirmation_message'                 => '条目已被成功删除',
        'delete_confirmation_not_title'               => '不删除',
        'delete_confirmation_not_message'             => "删除命令执行期间发生了一个意外，该条条目可能并没有成功删除",
        'delete_confirmation_not_deleted_title'       => '不删除',
        'delete_confirmation_not_deleted_message'     => '你的条目符合规则.',

        // DataTables translation
        'emptyTable'     => 'No data available in table',
        'info'           => '当前为 _START_ 到 _END_ 条，共 _TOTAL_ 条',
        'infoEmpty'      => '当前为 0 到 0 条，共 0 条',
        'infoFiltered'   => '(filtered from _MAX_ total entries)',
        'infoPostFix'    => '',
        'thousands'      => ',',
        'lengthMenu'     => '_MENU_ 单页条目数',
        'loadingRecords' => 'Loading...',
        'processing'     => 'Processing...',
        'search'         => '搜索: ',
        'zeroRecords'    => '没有找到匹配的记录',
        'paginate'       => [
            'first'    => '首页',
            'last'     => '尾页',
            'next'     => '下页',
            'previous' => '上页',
        ],
        'aria' => [
            'sortAscending'  => ': activate to sort column ascending',
            'sortDescending' => ': activate to sort column descending',
        ],

    // global crud - errors
    'unauthorized_access' => 'Unauthorized access - you do not have the necessary permissions to see this page.',
    'please_fix' => '请修复下列错误:',

    // global crud - success / error notification bubbles
    'insert_success' => '成功添加',
    'update_success' => '修改成功',

    // CRUD reorder view
    'reorder'                      => 'Reorder',
    'reorder_text'                 => 'Use drag&drop to reorder.',
    'reorder_success_title'        => 'Done',
    'reorder_success_message'      => 'Your order has been saved.',
    'reorder_error_title'          => 'Error',
    'reorder_error_message'        => 'Your order has not been saved.',

    // Fields
    'browse_uploads' => 'Browse uploads',
    'clear' => 'Clear',
    'page_link' => 'Page link',
    'page_link_placeholder' => 'http://example.com/your-desired-page',
    'internal_link' => 'Internal link',
    'internal_link_placeholder' => 'Internal slug. Ex: \'admin/page\' (no quotes) for \':url\'',
    'external_link' => 'External link',

];
