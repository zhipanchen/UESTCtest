
$(function(){

    var ModuleId=getModuleId();//获取当前模块id

    getMessageData(ModuleId);//获取资料数据

    searchMessageData(ModuleId);//查询试题数据

    initTestlModulesManagePage(ModuleId);//初始化页面启用状态

    getTestlModulesManageUsing(ModuleId);//设置模块启用

    getTestlModulesManageUnused(ModuleId);//设置模块禁用

    addTestlModulesManageMessage(ModuleId);//添加资料数据

    closeTestlModulesManageFloatBox(ModuleId);//关闭按钮关闭悬浮框

})

