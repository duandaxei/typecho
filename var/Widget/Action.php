<?php

namespace Widget;

use Typecho\Widget;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 执行模块
 *
 * @package Widget
 */
class Action extends Widget
{
    /**
     * 路由映射
     *
     * @access private
     * @var array
     */
    private $map = [
        'ajax'                     => 'Widget_Ajax',
        'login'                    => 'Widget_Login',
        'logout'                   => 'Widget_Logout',
        'register'                 => 'Widget_Register',
        'upgrade'                  => 'Widget_Upgrade',
        'upload'                   => 'Widget_Upload',
        'service'                  => 'Widget_Service',
        'xmlrpc'                   => 'Widget_XmlRpc',
        'comments-edit'            => 'Widget_Comments_Edit',
        'contents-page-edit'       => 'Widget_Contents_Page_Edit',
        'contents-post-edit'       => 'Widget_Contents_Post_Edit',
        'contents-attachment-edit' => 'Widget_Contents_Attachment_Edit',
        'metas-category-edit'      => 'Widget_Metas_Category_Edit',
        'metas-tag-edit'           => 'Widget_Metas_Tag_Edit',
        'options-discussion'       => 'Widget_Options_Discussion',
        'options-general'          => 'Widget_Options_General',
        'options-permalink'        => 'Widget_Options_Permalink',
        'options-reading'          => 'Widget_Options_Reading',
        'plugins-edit'             => 'Widget_Plugins_Edit',
        'themes-edit'              => 'Widget_Themes_Edit',
        'users-edit'               => 'Widget_Users_Edit',
        'users-profile'            => 'Widget_Users_Profile',
        'backup'                   => 'Widget_Backup'
    ];

    /**
     * 入口函数,初始化路由器
     *
     * @throws Widget\Exception
     */
    public function execute()
    {
        /** 验证路由地址 **/
        $action = $this->request->action;

        /** 判断是否为plugin */
        $actionTable = array_merge($this->map, unserialize(Options::alloc()->actionTable));

        if (isset($actionTable[$action])) {
            $widgetName = $actionTable[$action];
        }

        if (isset($widgetName) && class_exists($widgetName)) {
            $widget = self::widget($widgetName);

            if ($widget instanceof ActionInterface) {
                $widget->action();
                return;
            }
        }

        throw new Widget\Exception(_t('请求的地址不存在'), 404);
    }
}