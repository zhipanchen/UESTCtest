
$(function(){

    var moduleId=managerStudyModulesGetModuleId();//获取当前模块id

    managerStudyModulesGetMessageData(moduleId);//获取资料数据

    managerStudyModulesPageStar(moduleId);//初始化页面

    managerStudyModulesGetUsing(moduleId);//启用模块

    managerStudyModulesGetUnused(moduleId);//禁用模块

    managerStudyModulesQuery(moduleId);//资料查询功能

    managerStudyModulesAddMessage(moduleId);//添加资料

    managerStudyModulesCloseFloatBox(moduleId);//关闭按钮关闭悬浮框

    //managerStudyModulesPageControl();分页功能在managerStudyModulesPageStar中调用
    
});
