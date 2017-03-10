
$(function(){


    var subjectid=userTestingGetModuleId();//获取模块id

    UserTestingInitPage(subjectid);//初始化页面信息

    boxMove();//悬浮框移动模块

    timeCount();//考试计时

    

    firstUpdatePaperTip();//未作答提示框控制

    firstUpdatePaper(subjectid);//提交试卷按钮（提示未作答）

    secondUpdatePaperTip(subjectid);//二次确认提示框控制

});













