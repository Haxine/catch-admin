<?php
namespace catchAdmin\system\controller;

use catcher\base\CatchController;
use catcher\CatchResponse;
use catcher\CatchAdmin;
use catcher\library\InstallCatchModule;
use catcher\library\InstallLocalModule;
use think\response\Json;

class Module extends CatchController
{
    /**
     *  模块列表
     *
     * @return Json
     */
    public function index()
    {
        $modules = [];

        foreach(CatchAdmin::getModulesDirectory() as $d) {
            $modules[] = json_decode(file_get_contents($d . 'module.json'), true);
        }

        $orders = array_column($modules, 'order');

        array_multisort($orders, SORT_DESC, $modules);

        return CatchResponse::success($modules);
    }


    /**
     * 禁用/启用模块
     *
     * @param string $module
     * @return Json
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    public function disOrEnable(string $module)
    {
        $moduleInfo = CatchAdmin::getModuleInfo(CatchAdmin::directory() . $module);

        $install = new InstallLocalModule($module);
        if (!$moduleInfo['enable']) {
            $install->findModuleInPermissions() ? $install->enableModule() : $install->done();
        } else {
            $install->disableModule();
        }

        return CatchResponse::success();
    }

    /**
     * 缓存
     *
     * @time 2020年09月21日
     * @return Json
     */
    public function cache()
    {
        return CatchResponse::success(CatchAdmin::cacheServices());
    }

    /**
     * 清理缓存
     *
     * @time 2020年09月21日
     * @return Json
     */
    public function clear()
    {
        return !file_exists(CatchAdmin::getCacheServicesFile()) ?
            CatchResponse::fail('模块没有缓存') :
            CatchResponse::success(unlink(CatchAdmin::getCacheServicesFile()));
    }
}