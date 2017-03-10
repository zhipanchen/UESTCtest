//main.js用于封装所有的js函数API，供外部js文件调用。

//通用（star）*******************************************************

function focusToRed(inputId,color){//获得焦点的inpt元素字体颜色改变。
    $(inputId).focus(function(){
        $(inputId).css('color',color);
    });
}

function logout(){//注销登录
          $.ajax({
                type:"POST",
                url:"php/logout.php?date="+Date.parse(new Date()),
                dataType:"json",
                data:{},
                success:function(data){
                    location.href="login.html";
              }
         });
}

function getLocalTime(nS) {//时间戳转化为时间  
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
} 
//通用（end）********************************************************


//forgetPassword.js封装（star）**************************************

var identifyingCode;
function sendMessage(){//发送验证码邮件，并返回验证码值
    
    $("#loginButton").click(function(){
          $("#emailSending").css("display","none");
          $("#emailGetting").css("display","block");
          $.ajax({
                type:"POST",
                url:"php/forgetPassword_sendEmail.php?date="+Date.parse(new Date()),
                dataType:"json",
                data:{
                    userEmail:$("#useremail").val()
                },
                success:function(data){
                    var result=eval(data);
                    identifyingCode=result.result; 
              }
         });
    });
}


function changPassword(){//修改登录密码
    focusToRed("#identifyingCodeText",'black');//input获得焦点，改变字体颜色
    focusToRed("#newPasswordAgain",'black');//input获得焦点，改变字体颜色

    $("#loginButton1").click(function(){
        if($("#identifyingCodeText").val()==identifyingCode){
            $("#identifyingCodeText").css('color','#50CA00');
            if($("#newPassword").val()==$("#newPasswordAgain").val()){
                $.ajax({
                    type:"POST",
                    url:"php/forgetPassword_changPassword.php?date="+Date.parse(new Date()),
                    dataType:"json",
                    data:{
                       userEmail:$("#useremail").val(),
                       newPassword:$("#newPassword").val()
                    },
                    success:function(data){
                        var information=eval(data);
                        if(information.result=='success'){
                           $("#dialogBox").css("display","block");
                            $("#dialogPoints").css("left",$("#loginButton1").offset().left+$("#loginButton1").width()/2-$("#dialogPoints").width()/2);
                            $("#dialogPoints").animate({top:(($("#dialogBox").offset().top+$("#loginButton1").offset().top)/2+'px')},500);
                            var timer=setInterval(function(){
                            location.href="login.html";
                        },4000);
                        }
                    }
                });
            }else{
                $("#newPasswordAgain").css('color','red');
            };
        };
    });
}
//forgetPassword.js封装（end）***************************************


//login.js封装（star）***********************************************

function passIntoOtherPage(){//用户，密码正确，页面跳转功能
    focusToRed("#username",'black');//input获得焦点，改变字体颜色
    focusToRed("#password",'black');//input获得焦点，改变字体颜色

    $("#loginButton").click(function(){
        $.ajax({
            type:"POST",
            url:"php/login.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                username:$("#username").val(),
                password:$("#password").val(),
            },
            success:function(data){
                var result=eval(data);
                if(result.state=='3') {
                    var input=document.getElementById("username");
                    input.value='';
                    $("#username").attr('placeholder','用户未激活');
                }
                else if(result.state=='2'){
                        location.href="user_studyModules.html";
                }else if(result.state=='1'){
                        location.href="manager_studyModules.html";
                }else if(result.state=='0'){
                    $("#username").val("");
                    $("#password").val("");
                    $("#username").attr('placeholder','用户名或密码错误');
                    
                }        
            }
        });
    });
}

//login.js封装（end）************************************************

//manager_center.js封装（star）**************************************

var userid='';

function getManagerCenterInformation(){//初始化页面数据
    $(".logout").click(function(){
        logout();//注销登录
    });
        $.ajax({
            type:"POST",
            url:"php/center_show.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{},
            success:function(data){
                var result=eval(data);
                if(result.result=="redirection"){
                    location.href="login.html";
                }else{
                    $(".managerName").text(result.user.username);

                    $("#managerOName").text(result.user.usertruename);
                    $("#managerName").text(result.user.username);
                    $("#managerEmail").text(result.user.useremail);
                    $("#phoneNumber").text(result.user.userphone);

                    userid=result.user.userid;
                    $("#userid").val(userid);

                    if(result.user.photo==null){
                        result.user.photo='image/manager_photo.png';
                    }else{
                        $("#managePicture").attr('src',"php/"+result.user.photo);
                    }
                };
            }
        });
}

function updateManagerPicture(){//上传管理员个人照片。
    $("#updateButton").click(function(){
        $('#form1').ajaxSubmit(function(data){
           var result=eval("(" + data + ")");
           var paths=result.path;     
           $("#managePicture").attr("src","php/"+paths+"?"+Date.parse(new Date()));
        });
    });
}

function managerChangPassword(){//修改管理员密码。
    focusToRed("#oldPassword",'black');//input获得焦点，改变字体颜色
    focusToRed("#newPasswordAgain",'black');//input获得焦点，改变字体颜色

    $("#changPasswordButton").click(function(){
        if($("#newPassword").val()==$("#newPasswordAgain").val()){
            
            $.ajax({
                type:"POST",
                url:"php/center_changePassWord.php?date="+Date.parse(new Date()),
                dataType:"json",
                data:{
                    userid:userid,
                    oldpassword:$("#oldPassword").val(),
                    password:$("#newPassword").val()
                },
                success:function(data){
                    var result=eval(data);
                    if(result.result=='false'){
                        $("#oldPassword").val("");
                        $("#oldPassword").attr('placeholder','当前密码输入有误');
                    }else if(result.result=='success'){
                        var button=document.getElementById("changPasswordButton");
                        button.value='修改成功';
                        var timer=setInterval(function(){
                            location.href="manager_center.html";
                        },1000);
                    }
                }
            });
        }else{
            $("#newPasswordAgain").val("");
            $("#newPasswordAgain").attr('placeholder','新设密码和确认密码不符');
        };
    });
}


//manager_center.js封装（end）***************************************

//manager_history.js封装（star）************************************
var moreInformation='';

function getManagerHistoryInformation(){//初始化历史数据
    $(".logout").click(function(){
        logout();//注销登录
    });

        $.ajax({
            type:"POST",
            url:"php/manager_history_manage.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{},
            success:function(data){
                var result=eval(data);
            if(result.result=="redirection"){
                location.href="login.html";
            }else{
                moreInformation=result;
                $(".managerName").text(result.username);

                for(var i=0;i<result.result.length;i++){
                    var html='<tr><td>'+result.result[i].subjectname+'</td><td>'+result.result[i].passsocre+'</td><td>'+
                             result.result[i].totalscore+'</td><td>'+result.result[i].passnumber+'</td><td>'+result.result[i].averagescore+
                             '</td><td><span class="moreInformation" name="'+i+'">...</span></td></tr>';
                    $("#gradeStatistics").append(html);
                }
                getMoreInformation();//点击查看详细过线名单
            }
        }
    });
}

function gradeStatistic(){//点击显示答题情况统计
    $("#testControlControl").click(function(){
        $("#testResult").css("display","none");
        $("#testControl").css("display","block");
        $("#testpassedBook").css("display","none");   
        $("#passMark").text('');

        $.ajax({
            type:"POST",
            url:"php/manager_history_state.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{},
            success:function(data){
                var result=eval(data);
                for(var i=0;i<result.length;i++){
                    var html='<tr><td>'+result[i].subjectName+'</td><td><span class="passingMark" id="'+result[i].subjectid+'">'+result[i].passLine+'%</span></td><td><span>'+result[i].totleScore+'</span></td></tr>';
                    $("#passMark").prepend(html);
                }
                changPassMark();////改变及格分数
            }
        });
    });
}

function gradeManage(){//点击显示成绩管理详情
    $("#testResultControl").click(function(){
        $("#testResult").css("display","block");
        $("#testControl").css("display","none");
        $("#testpassedBook").css("display","none"); 
    });
}

function getMoreInformation(){//点击查看详细过线名单
    $(".moreInformation").click(function(){
        var number=$(this).attr('name');

        $("#testResult").css("display","none");
        $("#testControl").css("display","none");
        $("#testpassedBook").css("display","block");  

        $("#passedPeople").html(""); 
        if(typeof(moreInformation.result[number].data)!="undefined"){
            for(var i=0;i<moreInformation.result[number].data.length;i++){
                var html='<tr><td>'+moreInformation.result[number].subjectname+'</td><td>'+
                    moreInformation.result[number].data[i].usercode+'</td><td>'+moreInformation.result[number].data[i].usertruename+'</td></tr>';
                $("#passedPeople").prepend(html);
            }
        }
    });
}

function changPassMark(){//改变及格分数

    var subjectId='';

    $(".passingMark").click(function(){
        subjectId=$(this).attr('id');
        $("#dialogBox").css("display","block");
        $("#dialogPoints1").css("display","none");
        $("#dialogPoints").css("display","block");
        $("#dialogPoints").css("left",($("#testControl").offset().left+$("#testControl").width()/2)-$("#dialogPoints").width()/2);
        $("#dialogPoints").animate({top:($("#testResult").height()/2+'px')},500);
    });

    $("#submitCancel").click(function(){
        $("#dialogBox").css("display","none");
    });

    $("#submitSure").click(function(){
        $.ajax({
            type:"POST",
            url:"php/manager_history_change_pass_line.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                subjectid:subjectId,
                subjectPassLine:$("#newPassMark").val()
            },
            success:function(data){
                var result=eval(data);
                if(result.result=='success'){
                    $("#"+subjectId).text($("#newPassMark").val()+'%');
                }
            }
        });
        $("#dialogBox").css("display","none");
    });
}

function changAllMark(){//改变满分分数
    $("#allCode1").click(function(){
        $("#dialogBox").css("display","block");
        $("#dialogPoints").css("display","none");
        $("#dialogPoints1").css("display","block");
        $("#dialogPoints1").css("left",($("#testControl").offset().left+$("#testControl").width()/2)-$("#dialogPoints1").width()/2);
        $("#dialogPoints1").animate({top:($("#testResult").height()/2+'px')},500);
    });

    $("#submitCancel1").click(function(){
        $("#dialogBox").css("display","none");
    });

    $("#submitSure1").click(function(){
        $("#dialogBox").css("display","none");
    });
}

//manager_history.js封装（end）*************************************


//manager_studyModules.js封装（star）********************************

function showModles(){//呈现,删除学习资料模块
    $(".logout").click(function(){
        logout();//注销登录
    });
    $.ajax({
        type:"POST",
        url:"php/manager_studyModules_show.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{},
        success:function(data){
            var result=eval(data);
            if(result.result=="redirection"){
                location.href="login.html";
            }else{
                $(".managerName").text(result.username);

                for(var i=0;i<result.list.data.length;i++){
                    var html='<li><div class="divbox"><span class="close" id="'+result.list.data[i].moduleid+'">x</span><a href="manager_studyModulesManage.html?'+result.list.data[i].moduleid+'"><span class="testBox">'+result.list.data[i].modulename.substr(0, 12)+'</span></a></div></li>';
                    $("#ModulBox").prepend(html);
                };
                removeManagerStudyMoudles();//删除学习资料模块
            };
        }
    });
};

function addMoudles(){//添加，取消添加学习模块

     $("#addingModel").click(function(){//添加学习模块
        $("#dialogBox").css("display","block");
        $("#floatBox").css("left",$("#x1").offset().left-$("#floatBox").width()/2+45);
        $("#floatBox").animate({top:"300px"},500);
     });

     $("#dialogCancel").click(function(){//取消模块命名按钮
        $("#dialogBox").css("display","none");
     });

    $("#dialogSure").click(function(){//确定模块命名按钮
        $.ajax({
            type:"POST",
            url:"php/manager_studyModules_addMoudle.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                moduleName:$("#ModulesName").val()
            },
            success:function(data){
                var result=eval(data);
                if(result.result=="success"){
                    var name=$("#ModulesName").val();
                    var html='<li><div class="divbox"><span class="close" id="'+result.moudleId+'">x</span><a href="manager_studyModulesManage.html?'+result.moudleId+'"><span class="testBox">'+name.substr(0, 12)+'</span></a></div></li>';
                    $("#ModulBox").prepend(html);
                    $("#dialogBox").css("display","none");
                    setTimeout(function() {
                        location.href="manager_studyModules.html";
                    },3000);
                };
            }
        });
    });
}

function removeManagerStudyMoudles(){//删除学习资料模块
    var moduleId;
    $(".close").click(function(){//删除学习资料模块
        $("#dialogBoxdelete").css("display","block");
        $("#floatBoxdelete").css("left",$("#x1").offset().left-$("#floatBoxdelete").width()/2+45);
        $("#floatBoxdelete").animate({top:"300px"},500);
        moduleId=$(this).attr('id');
    });  

    $("#deletesure").click(function(){//确定删除按钮
        $("#dialogBoxdelete").css("display","none");
        $.ajax({
            type:"POST",
            url:"php/manager_studyModules_removeMoudle.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                moduleId:moduleId
            },
            success:function(data){
                var result=eval(data);
                if(result.result=="success"){
                    $("#"+moduleId).parent().parent().remove();
                }
            }
        });
     });

     $("#deletecancel").click(function(){//取消删除按钮
        $("#dialogBoxdelete").css("display","none");
     });
}

//manager_studyModules.js封装（end）*********************************

//manager_studyModulesManage.js封装（star）**************************

var buttonState="add";

function managerStudyModulesGetModuleId(){//获取当前模块id
    var moduleId = location.search.replace("?","");
    if(moduleId==''){
        location.href="login.html";
    }else{
        return moduleId;
    };
}

function managerStudyModulesGetMessageData(moduleIdValue){//获取资料数据
    $(".logout").click(function(){
        logout();//注销登录
    });
    $.ajax({
        type:"POST",
        url:"php/manager_studyModulesManage_dataStart.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{
            moduleId:moduleIdValue,
            modulePage:1
        },
        success:function(data){
            var result=eval(data);
            $(".managerName").text(result.username);
            $(".contentTitle").text("你所在的位置:学习资料管理/"+result.res.moduleName);

            if(result.res.totlePage==0){
                $(".pageBoxGroup").hide();
            }
            $('#totalPage').text(result.res.totlePage);

            if(result.res.totlePage==4){
                $("#five").hide();
            }else if(result.res.totlePage==3){
                $("#five").hide();
                $("#four").hide();
            }else if(result.res.totlePage==2){
                $("#five").hide();
                $("#four").hide();   
                $("#three").hide();       
            }else if(result.res.totlePage==1){
                $("#five").hide();
                $("#four").hide();   
                $("#three").hide();   
                $("#two").hide();  
            };

            for(var i=0;i<result.res.dataData.length;i++){

                var html='<tr><td>'+(i+1)+
                '</td><td>'+result.res.dataData[i].datainfo.substr(0, 20)+'</td><td class="operation"><div class='+
                '"operationdiv"><span class="editQuestion" name="'+result.res.dataData[i].dataid+
                '">修改</span><span class="removeQuestion" name="'+result.res.dataData[i].dataid+'">删除</span></div></td></tr>';

                $("#tableBody").append(html);
            }
            studylModulesManageEditAndRemove();//删除题目
            managerStudyModulesPageControl(moduleIdValue);//分页
        }
    });
};

function managerStudyModulesPageStar(moduleIdValue){//初始化页面启用状态
    $.ajax({
        type:"POST",
        url:"php/manager_studyModulesManage_StateStart.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{
            moduleId:moduleIdValue
        },
        success:function(data){
            var result=eval(data);
            if(result.result==0){
                $("#used").css("background-color","#424242");
            }else if(result.result==1){
                $("#unused").css("background-color","#424242");
            };
        }
    }); 
}

function managerStudyModulesPageControl(moduleIdValue){//分页功能

    $(".pageBox").click(function(){
        var obj=$(this);
        var currctpage =$(this).attr('name');
        var totalpage=$('#totalPage').text();
        var page=$(this).attr('name');
        $.ajax({
            type:"POST",
            url:"php/manager_studyModulesManage_dataStart.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                moduleId:moduleIdValue,
                modulePage:currctpage
            },
            success:function(data){
                var result=eval(data);
                $("#tableBody").text('');
                $("#currentPage").text(page);
                for(var i=0;i<result.res.dataData.length;i++){
                    var html='<tr><td>'+((page-1)*10+i+1)+'</td><td>'+
                              result.res.dataData[i].datainfo.substr(0, 20)+'</td><td class="operation"><div class="operationdiv">'+
                              '<span class="editQuestion">修改</span><span class="removeQuestion">删除</span></div></td></tr>';
                    $("#tableBody").append(html);
                }
                if(totalpage<=5){
                    //nothing
                }else if(totalpage>5){
                    if(currctpage<=3){
                        //nothing
                    }else if(totalpage-currctpage<=3){
                        //nothing
                    }else{
                        $("#one").text(currctpage-2);
                        $("#two").text(currctpage-1);
                        $("#three").text(currctpage);
                        $("#four").text(currctpage+1);
                        $("#five").text(currctpage+2);
                    };
                };
            }
        });
     });
}


function managerStudyModulesGetUsing(moduleIdValue){//设置模块启用
    $("#used").click(function(){
        $.ajax({
            type:"POST",
            url:"php/manager_studyModulesManage_change_state.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                use:'1',
                moduleId:moduleIdValue
            },
            success:function(data){
                var result=eval(data);
                if(result.result=="success"){
                    $("#used").css("background-color","#0054A3");
                    $("#unused").css("background-color","#424242");
                };
            }
        });
    });
}

function managerStudyModulesGetUnused(moduleIdValue){//设置模块禁用
    $("#unused").click(function(){
        $.ajax({
            type:"POST",
            url:"php/manager_studyModulesManage_change_state.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                use:'0',
                moduleId:moduleIdValue
            },
            success:function(data){
                var result=eval(data);
                if(result.result=="success"){
                    $("#unused").css("background-color","#0054A3");
                    $("#used").css("background-color","#424242");
                };
            }
        });
    });
}

function managerStudyModulesQuery(moduleIdValue){//资料查询功能
    $("#search").click(function(){
        $.ajax({
            type:"POST",
            url:"php/manager_studyModulesManage_findData.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                word:$("#partOfQuestion").val(),
                moduleid:moduleIdValue
            },
            success:function(data){
                var result=eval(data);
                $("#tableBody").html("");
                for(var i=0;i<result.length;i++){
                var html='<tr><td>'+(i+1)+
                '</td><td>'+result[i].datainfo+'</td><td class="operation"><div class='+
                '"operationdiv"><span class="editQuestion" name="'+result[i].dataid+
                '">修改</span><span class="removeQuestion" name="'+result[i].dataid+'">删除</span></div></td></tr>';
                    $("#tableBody").append(html);
                };
                studylModulesManageEditAndRemove();//删除题目
            }
        });
    });
}

function managerStudyModulesAddMessage(moduleIdValue){//添加资料数据
    $("#addingAnwser").click(function(){//添加资料
        $('#form1').attr('action','php/manager_studyModulesManage_add_data.php');
        $("#dialogBox").css("display","block");
        $("#dialogPoints").css("left",$("#x1").offset().left-$("#dialogPoints").width()/2+30);
        $("#dialogPoints").animate({top:'20px'},500);
    });
}

function managerStudyModulesCloseFloatBox(moduleIdValue){//关闭按钮关闭悬浮框
    $("#closeButton").click(function(){
        $("#dialogBox").css("display","none");
    });

    $("#submitCancel").click(function(){
        $("#dialogBox").css("display","none");           
    });

    $("#submitSure").click(function(){
        if($("#a").is(':checked') || $("#b").is(':checked') || $("#c").is(':checked') || $("#d").is(':checked')){
            $("#moduleid").val(moduleIdValue);
            $('#form1').ajaxSubmit(function(data){
                location.href="manager_studyModulesManage.html?"+moduleIdValue;   
            });
            
        }else{
            $(".tip").css("display","block");
            $(".tip").css("left",$("#x1").offset().left-$(".tip").width()/2+30);
            $(".tip").animate({top:$(window).height()/2},500);
            var timer=setInterval(function(){
                    $(".tip").css("display","none");
                    $(".tip").css("top","0px");
                    clearInterval(timer);
            },2500);
        }
    }); 
}

function studylModulesManageEditAndRemove(){//修改，删除模块

        $(".editQuestion").click(function(){//修改试题按钮
            var id=$(this).attr('name');    
            $("#dataid").val(id);  
            $('#form1').attr('action','php/manager_studyModulesManage_modify_data.php');
            $("#dialogBox").css("display","block");
            $("#dialogPoints").css("left",$("#x1").offset().left-$("#dialogPoints").width()/2+30);
            $("#dialogPoints").animate({top:'20px'},500);
            $.ajax({
                type:"POST",
                url:"php/manager_studyModulesManage_modify_data_find.php?date="+Date.parse(new Date()),
                dataType:"json",
                data:{
                    dataid:id,
                },
                success:function(data){
                    var result=eval(data);

                    $("#questionContent").val(result.datainfo);
                    $("#answerA").val(result.datachoicea);
                    $("#answerB").val(result.datachoiceb);
                    $("#answerC").val(result.datachoicec);
                    $("#answerD").val(result.datachoiced);
                    $("#questionNote").val(result.datanote);

                    if(result.dataanswer=="A"){
                        $("#a").attr("checked",'checked');
                    }else if(result.dataanswer=="B"){
                        $("#b").attr("checked",'checked');
                    }else if(result.dataanswer=="C"){
                        $("#c").attr("checked",'checked');
                    }else if(result.dataanswer=="D"){
                        $("#d").attr("checked",'checked');
                    }
                }
            });
        });

        $(".removeQuestion").click(function(){//删除试题按钮
            var id=$(this).attr('name');
            var obj=$(this);
            $.ajax({
                type:"POST",
                url:"php/manager_studyModulesManage_remove_data.php?date="+Date.parse(new Date()),
                dataType:"json",
                data:{
                    dataid:id,
                },
                success:function(data){
                    var result=eval(data);
                    if(result.result=="success"){
                        obj.parent().parent().parent().remove();                        
                    };
                }
            });
            
        });
}
//manager_studyModulesManage.js封装（end）***************************

//manager_testlModules.js封装（star）********************************

function showManagerTestModles(){//呈现,删除考试模块
    $(".logout").click(function(){
        logout();//注销登录
    });
    $.ajax({
        type:"POST",
        url:"php/manager_testModules_show.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{},
        success:function(data){
            var result=eval(data);
            if(result.result=="redirection'"){
                location.href="login.html";
            }else{
                $(".managerName").text(result.username);
                for(var i=0;i<result.list.data.length;i++){
                    var html='<li><div class="divbox"><span class="close" id="'+result.list.data[i].subjectid+'">x</span><a href="manager_testlModulesManage.html?'+result.list.data[i].subjectid+'"><span class="testBox">'+result.list.data[i].subjectname.substr(0, 12)+'</span></a></div></li>';
                    $("#testModelBox").prepend(html);
                };
                removeMoudles();//删除学习资料模块
            };
        }
    });
}

function addManagerTestMoudles(){//添加，取消添加考试模块

     $("#addingModel").click(function(){//添加学习模块
        $("#dialogBox").css("display","block");
        $("#floatBox").css("left",$("#x1").offset().left-$("#floatBox").width()/2+45);
        $("#floatBox").animate({top:"300px"},500);
     });

     $("#cancel").click(function(){//取消模块命名按钮
        $("#dialogBox").css("display","none");
     });

    $("#sure").click(function(){//确定模块命名按钮
        $.ajax({
            type:"POST",
            url:"php/manager_testModules_addMoudle.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                subjectName:$("#ModulesName").val(),
                subjectpassline:60
            },
            success:function(data){
                var result=eval(data);
                if(result.result=="success"){
                    var name=$("#ModulesName").val();
                    var html='<li><div class="divbox"><span class="close" id="'+result.subjectid+'">x</span><a href="manager_testlModulesManage.html?'+result.subjectid+'"><span class="testBox">'+name.substr(0, 12)+'</span></a></div></li>';
                    $("#testModelBox").prepend(html);
                    $("#dialogBox").css("display","none");
                    location.href="manager_testlModules.html";
                };
            }
        });
    });
}

function removeMoudles(){//删除考试模块
    var moduleId;
    $(".close").click(function(){//删除考试模块
        $("#dialogBoxdelete").css("display","block");
        $("#floatBoxdelete").css("left",$("#x1").offset().left-$("#floatBoxdelete").width()/2+45);
        $("#floatBoxdelete").animate({top:"300px"},500);
        moduleId=$(this).attr('id');
    });  

    $("#deletesure").click(function(){//确定删除按钮
        $("#dialogBoxdelete").css("display","none");
        $.ajax({
            type:"POST",
            url:"php/manager_testModules_removeMoudle.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                subjectId:moduleId
            },
            success:function(data){
                var result=eval(data);
                if(result.result=="success"){
                    $("#"+moduleId).parent().parent().remove();
                }
            }
        });
     });

     $("#deletecancel").click(function(){//取消删除按钮
        $("#dialogBoxdelete").css("display","none");
     });
}
//manager_testlModules.js封装（end）*********************************

//manager_testModulesManage.js封装（star）***************************

function getModuleId(){//获取当前模块id
    var moduleId = location.search.replace("?","");
    return moduleId;
};

function initTestlModulesManagePage(moduleIdValue){//初始化页面启用状态
    $(".logout").click(function(){
        logout();//注销登录
    });
    $.ajax({
        type:"POST",
        url:"php/manager_testModulesManage_StateStart.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{
            subjectId:moduleIdValue,
        },
        success:function(data){
            var result=eval(data);
            if(result.result==0){
                $("#used").css("background-color","#424242");
            }else if(result.result==1){
                $("#unused").css("background-color","#424242");
            };
        }
    });   
}

function getMessageData(moduleIdValue){//获取试题数据
    $.ajax({
        type:"POST",
        url:"php/manager_testModulesManage_dataStart.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{
            subjectId:moduleIdValue,
            subjectPage:1
        },
        success:function(data){
            var result=eval(data);
            $(".managerName").text(result.username);
            $("#subjectName").text(result.res.subjectName);

            if(result.res.totlePage==0){
                $(".pageBoxGroup").hide();
            }

            $("#totalPage").text(result.res.totlePage);

            if(result.res.totlePage==4){
                $("#five").hide();
            }else if(result.res.totlePage==3){
                $("#five").hide();
                $("#four").hide();
            }else if(result.res.totlePage==2){
                $("#five").hide();
                $("#four").hide();   
                $("#three").hide();       
            }else if(result.res.totlePage==1){
                $("#five").hide();
                $("#four").hide();   
                $("#three").hide();   
                $("#two").hide();  
            }

            for(var i=0;i<result.res.questionData.length;i++){
                var html='<tr><td>'+(i+1)+'</td><td>'+result.res.questionData[i].questioninfo.substr(0, 20)+
                '</td><td>'+result.res.questionData[i].questioncorrectanswer+
                '</td><td class="operation"><div class="operationdiv"><span class="editButton" name="'+
                result.res.questionData[i].questionid+'">'+
                '修改</span><span class="removeButton" name="'+result.res.questionData[i].questionid+
                '">删除</span></div></td></tr>';

                $("#tableBody").append(html);
            }
            TestlModulesManageEditAndRemove();
            managerTestModulesPageControl(moduleIdValue);//分页
        }
    });
}

function searchMessageData(moduleIdValue){//查询试题数据
    $("#searchButton").click(function(){
    $.ajax({
        type:"POST",
        url:"php/manager_testModulesManage_findQuestion.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{
            word:$("#searchInformation").val(),
            subjectid:moduleIdValue,
        },
        success:function(data){
            var result=eval(data);

            $("#tableBody").html('');

            for(var i=0;i<result.length;i++){
                var html='<tr><td>'+(i+1)+'</td><td>'+result[i].questioninfo.substr(0, 20)+
                '</td><td>'+result[i].questioncorrectanswer+
                '</td><td class="operation"><div class="operationdiv"><span class="editButton" name="'+
                result[i].questionid+'">'+
                '修改</span><span class="removeButton" name="'+result[i].questionid+
                '">删除</span></div></td></tr>';

                $("#tableBody").append(html);
            }
            TestlModulesManageEditAndRemove();
        }
    });
    });
}

function managerTestModulesPageControl(moduleIdValue){//分页功能

    $(".pageBox").click(function(){
        var obj=$(this);
        var currctpage =$(this).attr('name');
        var totalpage=$('#totalPage').text();
        var page=$(this).attr('name');
        $.ajax({
            type:"POST",
            url:"php/manager_testModulesManage_dataStart.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                subjectId:moduleIdValue,
                subjectPage:currctpage
            },
            success:function(data){
                var result=eval(data);
                $("#tableBody").text('');
                $("#currentPage").text(page);
                for(var i=0;i<result.res.questionData.length;i++){
                    var html='<tr><td>'+(i+1)+'</td><td>'+result.res.questionData[i].questioninfo+
                        '</td><td>'+result.res.questionData[i].questioncorrectanswer+
                        '</td><td class="operation"><div class="operationdiv"><span class="editButton" name="'+
                        result.res.questionData[i].questionid+'">'+
                        '修改</span><span class="removeButton" name="'+result.res.questionData[i].questionid+
                        '">删除</span></div></td></tr>';
                    $("#tableBody").append(html);
                }
                if(totalpage<=5){
                    //nothing
                }else if(totalpage>5){
                    if(currctpage<=3){
                        //nothing
                    }else if(totalpage-currctpage<=3){
                        //nothing
                    }else{
                        $("#one").text(currctpage-2);
                        $("#two").text(currctpage-1);
                        $("#three").text(currctpage);
                        $("#four").text(currctpage+1);
                        $("#five").text(currctpage+2);
                    };
                };
            }
        });
     });
}

function getTestlModulesManageUsing(moduleIdValue){//设置模块启用
    $("#used").click(function(){
        $.ajax({
            type:"POST",
            url:"php/manager_testModulesManage_change_state.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                use:'1',
                subjectId:moduleIdValue
            },
            success:function(data){
                var result=eval(data);
                if(result.result=="success"){
                    $("#used").css("background-color","#0054A3");
                    $("#unused").css("background-color","#424242");
                };
            }
        });
    });
}

function getTestlModulesManageUnused(moduleIdValue){//设置模块禁用
    $("#unused").click(function(){
        $.ajax({
            type:"POST",
            url:"php/manager_testModulesManage_change_state.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                use:'0',
                subjectId:moduleIdValue
            },
            success:function(data){
                var result=eval(data);
                if(result.result=="success"){
                    $("#unused").css("background-color","#0054A3");
                    $("#used").css("background-color","#424242");
                };
            }
        });
    });
}

function addTestlModulesManageMessage(moduleIdValue){//添加资料数据
    $("#addingQuestion").click(function(){//添加资料
        $("#subjectid").val(moduleIdValue);
        $("#dialogBox").css("display","block");
        $("#dialogPoints").css("left",$("#x1").offset().left-$("#dialogPoints").width()/2+30);
        $("#dialogPoints").animate({top:'5px'},500);
    });
}

function closeTestlModulesManageFloatBox(moduleIdValue){//关闭按钮关闭悬浮框
    $("#closeButton").click(function(){
        $("#dialogBox").css("display","none");
    });

    $("#submitCancel").click(function(){
        $("#dialogBox").css("display","none");
    });

    $("#submitSure").click(function(){
        if($("#a").is(':checked') || $("#b").is(':checked') || $("#c").is(':checked') || $("#d").is(':checked')){
            $('#form1').ajaxSubmit(function(data){
                location.href="manager_testlModulesManage.html?"+moduleIdValue;
            });
            
        }else{
            $(".tip").css("display","block");
            $(".tip").css("left",$("#x1").offset().left-$(".tip").width()/2+30);
            $(".tip").animate({top:$(window).height()/2},500);
            var timer=setInterval(function(){
                    $(".tip").css("display","none");
                    $(".tip").css("top","0px");
                    clearInterval(timer);
            },2500);
        }
    }); 
}

function TestlModulesManageEditAndRemove(){
        $(".editButton").click(function(){//修改试题按钮
            $("#form1").attr("action",'php/manager_testModulesManage_modify_data.php');
            var id=$(this).attr("name");
            $("#questionid").val(id);
            $("#dialogBox").css("display","block");
            $("#dialogPoints").css("left",$("#x1").offset().left-$("#dialogPoints").width()/2+30);
            $("#dialogPoints").animate({top:'70px'},500);

            $.ajax({
                type:"POST",
                url:"php/manager_testModulesManage_modify_data_find.php?date="+Date.parse(new Date()),
                dataType:"json",
                data:{
                    questionid:id,
                },
                success:function(data){
                    var result=eval(data);
                    
                    $("#questionContent").val(result.questioninfo);
                    $("#answerA").val(result.questionchoicea);
                    $("#answerB").val(result.questionchoiceb);
                    $("#answerC").val(result.questionchoicec);
                    $("#answerD").val(result.questionchoiced);
                    $("#questionNote").val(result.questionnote);

                    if(result.questioncorrectanswer=="A"){
                        $("#a").attr("checked",'checked');
                    }else if(result.questioncorrectanswer=="B"){
                        $("#b").attr("checked",'checked');
                    }else if(result.questioncorrectanswer=="C"){
                        $("#c").attr("checked",'checked');
                    }else if(result.questioncorrectanswer=="D"){
                        $("#d").attr("checked",'checked');
                    }
                }
            });
        });

        $(".removeButton").click(function(){//删除试题按钮
            var obj=$(this);
            var id=$(this).attr('name');
            $.ajax({
            type:"POST",
            url:"php/manager_testModulesManage_remove_data.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                questionid:id
            },
            success:function(data){
                var result=eval(data);
                if(result.result=="success"){
                    obj.parent().parent().parent().remove();
                };
            }
        });         
    });
}

//manager_testModulesManage.js封装（end）****************************

//manager_userManage.js封装（star）**********************************

function managerUserManagePageStart(){//初始化页面
    $(".logout").click(function(){
        logout();//注销登录
    });
        
    $.ajax({
        type:"POST",
        url:"php/manager_userManage_start.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{
            page:1
        },
        success:function(data){
            var result=eval(data);
            if(result.result=="redirection"){
                location.href="login.html";
            }else{
            $(".managerName").text(result.username);
            for(var i=0;i<result.list.data.length;i++){
                var rule;
                if(result.list.data[i].usergroupid==1){
                    rule="管理员";
                }else if(result.list.data[i].usergroupid==2){
                    rule="用 户";
                }
                var html='<tr><td><input type="checkbox" class="checkStyle" name="check'+(i+1)+'" name1="'+result.list.data[i].userid+'"/></td><td>'+(i+1)+
                         '</td><td>'+result.list.data[i].usercode+'</td><td>'+result.list.data[i].username+'</td><td>'+
                         result.list.data[i].userphone+'</td><td class="operation"><div class'+
                         '="operationdiv" name="'+result.list.data[i].userid+'"><span class="historyButton" name="'+result.list.data[i].userid+'">历史记录</span><span clas'+
                         's="moreInfoButton" name="'+result.list.data[i].userid+'">详细资料</span><span class="addRules">'+rule+'</span>'+
                         '<span class="deleteButton">删除</span></div></td></tr>';
                 $("#tableBox").append(html);
            }
            managerUserManageClick();//添加点击事件
        }
        }
    });   
}

function managerUserManageSearch(){//搜索学生

    $("#searchButton").click(function(){
        $.ajax({
            type:"POST",
            url:"php/manager_userManage_find_user.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                usercode:$("#searchText").val()
            },
            success:function(data){
                var result=eval(data);
                $("#tableBox").text('');
                var rules='';
                for(var i=0;i<result.result.data.length;i++){
                var rule;
                if(result.result.data[i].usergroupid==1){
                    rule="管理员";
                }else if(result.result.data[i].usergroupid==2){
                    rule="用 户";
                }
                var html='<tr><td><input type="checkbox" class="checkStyle" name="check'+(i+1)+'" name1="'+result.result.data[i].userid+'"/></td><td>'+(i+1)+
                         '</td><td>'+result.result.data[i].usercode+'</td><td>'+result.result.data[i].username+'</td><td>'+
                         result.result.data[i].userphone+'</td><td class="operation"><div class'+
                         '="operationdiv" name="'+result.result.data[i].userid+'"><span class="historyButton" name="'+result.result.data[i].userid+'">历史记录</span><span clas'+
                         's="moreInfoButton" name="'+result.result.data[i].userid+'">详细资料</span><span class="addRules">'+rule+'</span>'+
                         '<span class="deleteButton">删除</span></div></td></tr>';
                 $("#tableBox").append(html);
               }
               managerUserManageClick();//添加点击事件
            }
        });
    });
}

function moreRemove(){//批量删除
        $(".operationAction1").click(function(){
            var test=[];
            for(var i=0;i<$(".checkStyle").length;i++){
                if(typeof($("input[name="+'check'+(i)+"]:checked").attr('name1'))=="undefined"){
                    //nothing
                }else{
                    test.push($("input[name="+'check'+(i)+"]:checked").attr('name1'));
                }
             }
            $.ajax({
                type:"POST",
                traditional: true,
                url:"php/manager_userManage_delete_user_mul.php?date="+Date.parse(new Date()),
                dataType:"json",
                data:{
                    userids:JSON.stringify(test)
                },
                success:function(data){
                    var result=eval(data);
                    if(result.result=="success"){
                        location.href="manager_userManage.html";
                    }
                }
          });
    });
}

function managerUserManageClick(){//添加点击事件

    $(".historyButton").click(function(){
        var id=$(this).attr("name");
        if(id==1){
            $(this).css("background",'#1E1E1E');
        }else{
        $.ajax({
            type:"POST",
            url:"php/manager_userManage_find_user_history.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                userid:id
            },
            success:function(data){
                var result=eval(data);
                var html='';
                for(var i=0;i<result.list.data.length;i++){

                     html=html+"<tr><td>"+getLocalTime(result.list.data[i].historytime)+"</td><td>"+
                     result.list.data[i].subjectname+"</td><td>"+result.list.data[i].historyscore+
                     "</td><td>"+result.list.data[i].historywrongnumber+"</td></tr>"
                };
                $("#informationBox").append(html);
                
                $(".box").css("display","block");
                $(".box").css("left",$("#x1").offset().left-$(".box").width()/2+30);
                $(".box").animate({top:$(window).height()/2-$(".box").height()/2},500);
            }
        });
        };
    });
    
    $(".moreInfoButton").click(function(){
        var id=$(this).attr("name");
        $.ajax({
            type:"POST",
            url:"php/manager_userManage_find_user_Id.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                userid:id
            },
            success:function(data){
                var result=eval(data);

                $("#name").text(result.result.username);
                $("#studyNumber").text(result.result.usercode);
                $("#email").text(result.result.useremail);
                $("#phongNumber").text(result.result.userphone);
                $("#personPicture").attr("src","php/"+result.result.photo)

                $(".personInformation").css("display","block");
                $(".personInformation").css("left",$("#x1").offset().left-$(".personInformation").width()/2+30);
                $(".personInformation").animate({top:$(window).height()/2},500);
            }
        });
    });

    $(".getBackButton").click(function(){
        $(".personInformation").css("display","none");
        $(".personInformation").animate({top:0},50);
    });

    $(".getBack").click(function(){
       $(".box").css("display","none");
       $(".box").animate({top:0},50);
    });

    $(".addRules").click(function(){
        
        var userid=$(this).parent().attr('name');
        var obj=$(this);
        var groupid;
        if($(this).text()=="管理员"){
            groupid=2;
        }else if($(this).text()=="用 户"){
            groupid=1;
        };
        
        $.ajax({
            type:"POST",
            url:"php/manager_userManage_change_user_group.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                userid:userid,
                usergroupid:groupid
            },
            success:function(data){
                var result=eval(data);
                if(result.result=='success'){
                    if(obj.text()=="用 户"){
                        obj.text('管理员');
                    }else if(obj.text()=="管理员"){
                        obj.text('用 户');
                    }
                }
            }
        });
    })

    $("#setTime").click(function(){
        $(".timeBox").css("left",$("#x1").offset().left-$(".timeBox").width()/2+30);
        $(".timeBox").animate({top:$(window).height()/2},500);
        $(".timeBox").css('display','block');

        $.ajax({
            type:"POST",
            url:"php/manager_time_get.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{   
            },
            success:function(data){
                var result=eval(data);
                $("#startButton").val(result.start);
                $("#endButton").val(result.end); 
            }
        });

        $("#timeCancel").click(function(){
            $("#startButton").val("");
            $("#endButton").val("");
            $(".timeBox").animate({top:"0px"},500);
            $(".timeBox").css('display','none');
        });

        $("#timeSure").click(function(){
            if($("#startButton").val()=='' || $("#endButton").val()==''){
                $("#startButton").val("");
                $("#startButton").attr("placeholder","起止日期不能为空！");
                var timer=setInterval(function(){
                     $("#startButton").attr("placeholder","例：2014/02/12");
                },2000);
            }else{
                var a={"start":$("#startButton").val(),"end":$("#endButton").val()};

                $.ajax({
                    type:"POST",
                    traditional: true,
                    url:"php/manager_time_set.php?date="+Date.parse(new Date()),
                    dataType:"json",
                    data:{   
                        time:JSON.stringify(a),
                    },
                    success:function(data){
                        var result=eval(data);
                        if(result.result=='success'){
                            $("#startButton").val("");
                            $("#endButton").val("");
                            $(".timeBox").animate({top:"0px"},500);
                            $(".timeBox").css('display','none');
                        }else if(result.result=='reject_start'){
                            $("#startButton").val("");
                            $("#startButton").attr("placeholder","起始日期有误！");
                        }else if(result.result=='reject_end'){
                            $("#endButton").val("");
                            $("#endButton").attr("placeholder","截止日期有误！");
                        }
                    }
                });
            }
        });
    });

    $(".deleteButton").click(function(){

        var userid=$(this).parent().attr('name');
        if(userid!=1){
            var obj=$(this);

            $.ajax({
                type:"POST",
                url:"php/manager_userManage_delete_user.php?date="+Date.parse(new Date()),
                dataType:"json",
                data:{
                    userid:userid
                },
                success:function(data){
                    var result=eval(data);
                    if(result.result=='success'){
                        obj.parent().parent().parent().remove();
                    }
                }
            });
        }else{
            $(this).css("background","#1e1e1e");

        };
    })
}

//manager_userManage.js封装（end）***********************************

//user_center.js封装（star）*****************************************

var userid='';

function getUserCenterInformation(){//初始化页面数据
    $(".logout").click(function(){
        logout();//注销登录
    });
        $.ajax({
            type:"POST",
            url:"php/center_show.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{},
            success:function(data){
                var result=eval(data);
            if(result.result=="redirection"){
                location.href="login.html";
            }else{
                $(".name").text(result.user.username);
                userid=result.user.userid;
                $("#userid").val(userid);
                $("#userName").text(result.user.usertruename);
                $("#userRealName").text(result.user.username);
                $("#userNumber").text(result.user.usercode);
                $("#userEmail").text(result.user.useremail);
                $("#userPhoneNumber").text(result.user.userphone);
                if(result.user.photo==null){
                    result.user.photo='image/photo.png';
                }else{
                    $("#userPicture").attr('src',"php/"+result.user.photo);
                }
            }
            }
        });
}

function updateUserPicture(){//上传学生个人照片。
    $("#updateButton").click(function(){
        $('#form1').ajaxSubmit(function(data){
           var result=eval("("+data+")");
           var paths=result.path;     
           $("#userPicture").attr("src","php/"+paths+"?"+Date.parse(new Date()));
        });
    });
}

function userChangPassword(){//修改学生密码。
    focusToRed("#oldPassword",'black');//input获得焦点，改变字体颜色
    focusToRed("#newPasswordAgain",'black');//input获得焦点，改变字体颜色

    $("#changPasswordButton").click(function(){
        
            if($("#newPassword").val()==$("#newPasswordAgain").val()){
            $.ajax({
                type:"POST",
                url:"php/center_changePassWord.php?date="+Date.parse(new Date()),
                dataType:"json",
                data:{
                    userid:userid,
                    oldpassword:$("#oldPassword").val(),
                    password:$("#newPassword").val()
                },
                success:function(data){
                    var result=eval(data);
                    if(result.result=='false'){
                        $("#oldPassword").val("");
                        $("#oldPassword").attr("placeholder",'当前密码输入有误');
                    }else if(result.result=='success'){
                        var button=document.getElementById("changPasswordButton");
                        button.value='修改成功';
                    }
                }
            });
        }else{
            $("#newPassword").val("");
            $("#newPassword").attr("placeholder",'确认密码与新设密码不符');
        };
    });
}

//user_center.js封装（end）******************************************

//user_history.js封装（star）****************************************

var allInformation='';
var nowHistoryTime='';

function UserHistoryInitPage(){//初始化页面信息
    $(".logout").click(function(){
        logout();//注销登录
    });
     $.ajax({
        type:"POST",
        url:"php/user_history_start.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{},
        success:function(data){
            var result=eval(data);
            if(result.result=="redirection"){
                location.href="login.html";
            }else{
            allInformation=result;
            $("#name").text(result.username);

            for(var i=0;i<result.list.data.length;i++){
                var time=getLocalTime(result.list.data[i].historytime);
                var html='<li><div class="history" id="'+i+
                         '" name="'+result.list.data[i].historytime+'"><span>'+time+'</span></div></li>'+'<hr class="thinLine"/>';
                $(".titleUl").prepend(html);
            }
            
            var number=result.list.data.length-1;
            nowHistoryTime=result.list.data[number].historytime;
            $("#subject").text(result.list.data[number].subjectname);
            $("#grade").text(result.list.data[number].historyscore);
            $("#time").text(getLocalTime(result.list.data[number].historytime));
            $("#worry").text(result.list.data[number].historywrongnumber);

            UserHistoryChangeRecord();//点击历史记录，获取历史信息
        }
        }
     });
}

    function getLocalTime(nS) {//转化时间戳   
       return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");      
    } 

function UserHistoryChangeRecord(){//点击历史记录，获取历史信息
    $(".history").click(function(){
        var historyId=$(this).attr('id');
        nowHistoryTime=$(this).attr('name')
        $("#subject").text(allInformation.list.data[historyId].subjectname);
        $("#grade").text(allInformation.list.data[historyId].historyscore);
        $("#time").text(getLocalTime(allInformation.list.data[historyId].historytime));
        $("#worry").text(allInformation.list.data[historyId].historywrongnumber);
        $("#testdiv").css("display","none");
        $("#tablediv").css("display","block");
        UserHistoryBack();//返回历史记录
    });
}

function UserHistoryWorryQuestion(){//获取错题信息

    $("#watchTestpaperButton").click(function(){//查看试卷按钮
        $("#testdiv").html("");
        $("#testdiv").css("display","block");
        $("#tablediv").css("display","none");
        $.ajax({
            type:"POST",
            url:"php/user_history_look.php?date="+Date.parse(new Date()),
            dataType:"json",
            data:{
                historytime:nowHistoryTime
            },
            success:function(data){
                var result=eval(data);
                for(var i=0;i<result.length;i++){

                    var q='<img src="'+"php/"+result[i].questiondata.questionpicture+'" class="questionPicture pictureStyle"/>';
                    var a='<img src="'+"php/"+result[i].questiondata.questionpicturea+'" class="Apicture pictureStyle"/>';
                    var b='<img src="'+"php/"+result[i].questiondata.questionpictureb+'" class="Bpicture pictureStyle"/>';
                    var c='<img src="'+"php/"+result[i].questiondata.questionpicturec+'" class="Cpicture pictureStyle"/>';
                    var d='<img src="'+"php/"+result[i].questiondata.questionpictured+'" class="Dpicture pictureStyle"/>';
                    var n='<img src="'+"php/"+result[i].questiondata.questionnotepicture+'" class="analysedPicture pictureStyle"/>';

                    if(result[i].questiondata.questionpicture==null){
                        q='';
                    }
                    if(result[i].questiondata.questionpicturea==null){
                        a='';
                    }
                    if(result[i].questiondata.questionpictureb==null){
                        b='';
                    }
                    if(result[i].questiondata.questionpicturec==null){
                        c='';
                    }
                    if(result[i].questiondata.questionpictured==null){
                        d='';
                    }
                    if(result[i].questiondata.questionnotepicture==null){
                        n='';
                    }

                    var html='<div class="testQuestions">'+
                    '<span class="questions tdResult">'+(i+1)+'.'+result[i].questiondata.questioninfo+'</span>'+
                    q+//'<img src="'+result[i].question.questionpicture+'" class="questionPicture"/>'+
                    '<br /><br />'+
                    '<ul class="questionsChoose">'+
                        '<li><sapn class="questions tdResult">A.'+result[i].questiondata.questionchoicea+'</sapn><li/>'+
                        a+//'<img src="'+result[i].question.questionpicturea+'" class="Apicture"/>'+
                        '<li><sapn class="questions tdResult">B.'+result[i].questiondata.questionchoiceb+'</sapn><li/>'+
                        b+//'<img src="'+result[i].question.questionpictureb+'" class="Bpicture"/>'+
                        '<li><sapn class="questions tdResult">C.'+result[i].questiondata.questionchoicec+'</sapn><li/>'+
                        c+//'<img src="'+result[i].question.questionpicturec+'" class="Cpicture"/>'+
                        '<li><sapn class="questions tdResult">D.'+result[i].questiondata.questionchoiced+'</sapn><li/>'+
                        d+//'<img src="'+result[i].question.questionpictured+'" class="Dpicture"/>'+
                    '</ul>'+
                    '<hr class="noLine"/><br />'+
                    '<span class="answer tdResult">正确答案：</span><span class="answer tdResult">'+result[i].questiondata.questioncorrectanswer+'</span><br />'+
                    '<span class="answer tdResult">试题解析：</span><span class="answer tdResult">'+result[i].questiondata.questionnote+'</span>'+
                    n+//'<img src="'+result[i].question.questionnotepicture+'" class="analysedPicture"/>'+
                    '<br /><br />'+
                    '<hr class="questionline"/><br />'+
                    '</div>';
                    if(i==result.length-1){
                        html=html+'<input type="button" value="返回" class="end" id="endButton"/>';
                    }
                    $("#testdiv").append(html);
                    UserHistoryBack();//返回历史记录
                }     
                if(typeof(result[0])=="undefined"){
                    var html='<input type="button" value="返回" class="end" id="endButton"/>';
                    $("#testdiv").append(html);
                    UserHistoryBack();//返回历史记录
                }
                $("#testdiv").css("display","block");
                $("#tablediv").css("display","none");
            }
        });
    });
}

function UserHistoryBack(){//返回历史记录
    $("#endButton").click(function(){
        $("#testdiv").css("display","none");
        $("#tablediv").css("display","block");
    });
};

//user_history.js封装（end）*****************************************

//user_register.js封装（star）***************************************

function registerTime(){//注册时间
     $.ajax({
        type:"POST",
        url:"php/user_register_time_permmit.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{},
        success:function(data){
            var result=eval(data);
            if(result.result=='success'){
                //nothing
            }else if(result.result=="false"){
                $("#dialogBox").css("display","block");
                $(".success").text("不在注册期:"+result.start+" ~~ "+result.end);
                $("#floatBox").css("left",$("#textBox").offset().left);
                $("#floatBox").animate({top:"300px"},500);
                 var timer=setInterval(function(){
                        $("#dialogBox").css("display","none");
                        location.href='login.html';
                        clearInterval(timer);
                    },5000);
               }
           }
     });
}

function sendRegisterInformation(){//提交个人注册信息
    //输入：传入一个json,json名args,args是一个数组，其中有username,useremail,userphone,userpassword,usertruename,usercode
    //输出：json格式的数字，1代表username已注册，2代表useremail已注册，3代表真实姓名和学号的组合已注册，5代表注册成功，已经发送了邮件
    //注册
    $("#finishButton").click(function(){
        if($("#surePassword").val().length<6){
            $("#password").val("");
            $("#surePassword").val("");
            $("#password").attr("placeholder",'密码不足6位');
        }else if($("#surePassword").val().length>16){
            $("#password").val("");
            $("#surePassword").val("");
            $("#password").attr("placeholder",'密码超过16位');
        }else if($("#username").val()!=''&& $("#password").val()!='' && $("#surePassword").val()!='' && 
           $("#realName").val()!=''&& $("#studentNumber").val()!='' && $("#email").val()!=''){
               if($("#password").val()==$("#surePassword").val()){
                   $.ajax({
                    type:"POST",
                    url:"php/user_register.php?date="+Date.parse(new Date()),
                    dataType:"json",
                    data:{
                          username:$("#username").val(),
                          useremail:$("#email").val(),
                          userphone:$("#phoneNumber").val(),
                          userpassword:$("#password").val(),
                          usertruename:$("#realName").val(),
                          usercode:$("#studentNumber").val()
                    },
                    success:function(data){
                        var result=eval(data);
                        if(result.result==5){
                            $("#dialogBox").css("display","block");
                            $("#floatBox").css("left",$("#textBox").offset().left);
                            $("#floatBox").animate({top:"300px"},500);
                            var timer=setInterval(function(){
                                $("#dialogBox").css("display","none");
                                location.href='login.html';
                                clearInterval(timer);
                            },3000);
                            }else if(result.result==10){
                                $("#password").val("");
                                $("#password").attr("placeholder",'密码长度有误');
                            }else if(result.result==11){
                                $("#username").val("");
                                $("#username").attr("placeholder",'用户名不为6-16位字母组合');
                            }else if(result.result==12){
                                $("#studentNumber").val("");
                                $("#studentNumber").attr("placeholder",'学号不为10-20位数字组合');
                            }else if(result.result==13){
                                $("#phoneNumber").val("");
                                $("#phoneNumber").attr("placeholder",'手机号不为11位');
                            }else if(result.result==14){
                                $("#email").val("");
                                $("#email").attr("placeholder",'邮件不符合格式');
                            }else if(result.result==15){
                                $("#realName").val("");
                                $("#realName").attr("placeholder",'真实姓名存在字符');
                            }else if(result.result==3){
                                var name=document.getElementById('realName');
                                var number=document.getElementById('studentNumber');
                                name.value='';
                                number.value='';
                                name.placeholder='学号姓名组合重复';
                            }else if(result.result==2){
                                $('#emailText').css('color','red');
                                $('#emailText').text('邮箱重复');
                            }else if(result.result==1){
                                $('#nameText').css('color','red');
                                $('#nameText').text('用户名重复!');    
                            }else if(result.result==404){
                                $("#dialogBox").css("display","block");
                                $(".success").text("不在注册期内");
                                $("#floatBox").css("left",$("#textBox").offset().left);
                                $("#floatBox").animate({top:"300px"},500);
                                var timer=setInterval(function(){
                                    $("#dialogBox").css("display","none");
                                    location.href='login.html';
                                    clearInterval(timer);
                                },3000);
                              }
                           }           
                       });      
               }else{
                   $("#passwordAgin").css('color','red');
                   $("#passwordAgin").text('两次密码不相同，请确定后输入。');
               };   
        }else{
            var buttonText=document.getElementById("finishButton");
            buttonText.value="不能为空";
            var timer=setTimeout(function() {
                buttonText.value="完成注册";
                clearTimeout(timer);
            }, 2000);      
        }
    });
}

//user_register.js封装（end）****************************************

//user_studying.js封装（star）***************************************

function userStudyingGetModuleId(){//获取当前模块id
    var moduleId = location.search.replace("?","");
    return moduleId;
}

function UserStudyingInitPage(moduleId){//初始化页面信息
     $.ajax({
        type:"POST",
        url:"php/user_studying_start.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{
            moduleid:moduleId
        },
        success:function(data){
            var result=eval(data);
            if(result.result=="redirection"){
                location.href="login.html";
            }else{
            $(".managerName").text(result.username);
            $("#modelName").text(result.modulename);
            $("#titleText").text(result.modulename+'资料');
            for(var i=0;i<result.data.data.length;i++){
                var q,a,b,c,d,n;

                q='<img src="'+"php/"+result.data.data[i].datapicture+'" id="questionPicture" class="questionPicture"/>';
                a='<img src="'+"php/"+result.data.data[i].datapicturea+'" id="Apicture" class="questionPicture"/>';
                b='<img src="'+"php/"+result.data.data[i].datapictureb+'" id="Bquestion" class="questionPicture"/>';
                c='<img src="'+"php/"+result.data.data[i].datapicturec+'" id="Cquestion" class="questionPicture"/>';
                d='<img src="'+"php/"+result.data.data[i].datapictured+'" id="Dquestion" class="questionPicture"/>';
                n='<img src="'+"php/"+result.data.data[i].datanotepicture+'" id="analysedPicture" class="questionPicture"/>';

                if(result.data.data[i].datapicture==null){
                    q='';
                }
                if(result.data.data[i].datapicturea==null){
                    a='';
                }
                if(result.data.data[i].datapictureb==null){
                    b='';
                }
                if(result.data.data[i].datapicturec==null){
                    c='';
                }
                if(result.data.data[i].datapictured==null){
                    d='';
                }
                if(result.data.data[i].datanotepicture==null){
                    n='';
                }


                var html='<div class="testQuestions">'+
                    '<span class="questions">'+(i+1)+'.'+result.data.data[i].datainfo+'</span>'+
                    q+
                    '<br /><br /><br />'+
                    '<ul class="questionsChoose">'+
                        '<li><span class="questions">A.'+result.data.data[i].datachoicea+'</span><li/>'+
                        a+
                        '<li><span class="questions">B.'+result.data.data[i].datachoiceb+'</span><li/>'+
                        b+
                        '<li><span class="questions">C.'+result.data.data[i].datachoicec+'</span><li/>'+
                        c+
                        '<li><span class="questions">D.'+result.data.data[i].datachoiced+'</span><li/>'+
                        d+
                    '</ul>'+
                   '<hr class="noLine"/><br />'+
                    '<span class="answer">正确答案：</span><span class="answer">'+result.data.data[i].dataanswer+'</span><br />'+
                    '<span class="answer">试题解析：</span><span class="answer">'+result.data.data[i].datanote+'</span><br />'+
                    n+
                    '<hr class="questionline"/>'+
                '</div>';
                $(".recordBox").append(html);
            }
            }
        }
     });
}

function getback(){//返回模块界面
    $("#endButton").click(function(){
        location.href="user_studyModules.html";
    });
}
//user_studying.js封装（end）****************************************

//user_tesing.js封装（star）*****************************************

var allQuestion={};
var questionString="";
var time=0;

function userTestingGetModuleId(){//获取当前模块id
    var subjectid = location.search.replace("?","");
    return subjectid;
}

function UserTestingInitPage(subjectid){//初始化页面信息
     $.ajax({
        type:"POST",
        url:"php/user_testing_start.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{
            subjectid:subjectid
        },
        success:function(data){
            var result=eval(data);
            if(result.result=="redirection"){
                location.href="login.html";
            }else{     
            $("#name").text(result.username);
            $("#subjectTitle").text(result.subjectname);
            $("#testTitle").text(result.subjectname+'试卷')
            $("#allMark").text(result.totleScore);
            $("#passMark").text(result.passScore);

            var ten=Math.floor(result.questionlist.data.length/10);
            var one=result.questionlist.data.length-(10*ten);

            var a="<tr>";
            for(var i=0;i<ten;i++){
                for(var j=0;j<10;j++){
                    a=a+"<td>"+(i*10+j+1)+"</td>";
                } 
                a=a+"</tr>";
            };        

            var b="<tr>";
            for(var i=0;i<one;i++){
                b=b+'<td>'+(ten*10+i+1)+"</td>";
            };
            for(var i=10-one;i>0;i--){
                b=b+'<td style="color:#9f9f9f;">'+(ten*10+i+1)+"</td>";
            };
            b=b+"</tr>";
             $("#colorBoxs").append(a+b);

            var html='';
            for(var i=0;i<result.questionlist.data.length;i++){

                var q='<img src="'+"php/"+result.questionlist.data[i].questionpicture+'" class="questionPicture"/>';
                var a='<img src="'+"php/"+result.questionlist.data[i].questionpicturea+'" class="Apicture questionPicture"/>';
                var b='<img src="'+"php/"+result.questionlist.data[i].questionpictureb+'" class="Bpicture questionPicture"/>';
                var c='<img src="'+"php/"+result.questionlist.data[i].questionpicturec+'" class="Cpicture questionPicture"/>';
                var d='<img src="'+"php/"+result.questionlist.data[i].questionpictured+'" class="Dpicture questionPicture"/>';

                if(result.questionlist.data[i].questionpicture==null){
                    q='';
                }
                if(result.questionlist.data[i].questionpicturea==null){
                    a='';
                }
                if(result.questionlist.data[i].questionpictureb==null){
                    b='';
                }
                if(result.questionlist.data[i].questionpicturec==null){
                    c='';
                }
                if(result.questionlist.data[i].questionpictured==null){
                    d='';
                }
                html+='<div class="testQuestions">'+
                    '<span class="questions">'+(i+1)+'.'+result.questionlist.data[i].questioninfo+'</span><br /><br /><br />'+
                    q+
                    '<ul class="questionsChoose">'+
                        '<li><input type="radio" value=""  name="'+(i+1)+'" value1="A" name1="'+result.questionlist.data[i].questionid+'"/><sapn class="questions">A.'+result.questionlist.data[i].questionchoicea+'</sapn><li/>'+
                        a+
                        '<li><input type="radio" value=""  name="'+(i+1)+'" value1="B" name1="'+result.questionlist.data[i].questionid+'"/><sapn class="questions">B.'+result.questionlist.data[i].questionchoiceb+'</sapn><li/>'+
                        b+
                        '<li><input type="radio" value=""  name="'+(i+1)+'" value1="C" name1="'+result.questionlist.data[i].questionid+'"/><sapn class="questions">C.'+result.questionlist.data[i].questionchoicec+'</sapn><li/>'+
                        c+
                        '<li><input type="radio" value=""  name="'+(i+1)+'" value1="D" name1="'+result.questionlist.data[i].questionid+'"/><sapn class="questions">D.'+result.questionlist.data[i].questionchoiced+'</sapn><li/>'+
                        d+
                    '</ul><br /><br /><br />'+
                   '<hr class="noLine"/><br /><br /><br />'+
                   '<hr class="questionline"/>'+
                   '</div>';              
            }
            html+='<span class="end">---题目结束---<span>';
            $(".recordBox").append(html);   
            chooseContral();//单选控制
            colorBoxsControl();//悬浮框颜色板，颜色变化
        }
        }
     });
}

function boxMove(){//悬浮框初始移动
    $("#floatbox").animate({left:($("#content").offset().left-$("#floatbox").offset().left)},1000);
};

function chooseContral(){//单选控制
    $(".radioInput").click(function(){
        var name=$(this).attr('name');
        $("input[name="+name+"]").attr("checked",true);
    });
}

function colorBoxsControl(){//悬浮框颜色板，颜色变化
    $("input").click(function(){

        for(var i=0;i<$(".testQuestions").length;i++){
            if($("input[name="+(i+1)+"]:checked").attr('value1')==null){
                $("#colorBoxs tr").children().eq(i).css('background-color','#959595');
            }else{
                $("#colorBoxs tr").children().eq(i).css('background-color','#165FAB');
            }
 
            var number=$(this).attr('name');
            $("#colorBoxs tr").children().eq(number-1).css('background-color','#262626');
        }
    });
}

function timeCount(){//考试计时
    time=0;
    var timer=null;
    timer=setInterval(function(){
        time++;
        var hour=timeText(Math.floor(time/3600));
        var minute=timeText(Math.floor(time/60));
        var second=timeText(Math.floor(time%60));
        $("#times").text(hour+":"+minute+":"+second);
    },1000);
}

function timeText(number){//保证时间的输出格式为00:00
    if(number<=9){
        return '0'+number;
    }else{
        return number;
    };
};

function firstUpdatePaper(subjectid){//提交试卷按钮（提示未作答）
    $("#submitButton").click(function(){
        allQuestion={};
        questionString="";
        var question=[];
        for(var i=0;i<$(".testQuestions").length;i++){
            if($("input[name="+(i+1)+"]:checked").attr('value1')==null){
                question[i]='E';
                allQuestion["0"]='E';
            }else{
                question[i]=$("input[name="+(i+1)+"]:checked").attr('value1');
                allQuestion[$("input[name="+(i+1)+"]:checked").attr('name1')]=$("input[name="+(i+1)+"]:checked").attr('value1');
            }
        }
        var count=0;
        for(var i=0;i<question.length;i++){
            if(question[i]=='E'){
                questionString+=(i+1)+'、';
                count++;
            }
        }
        
        if(count>=5){
            questionString="5题以上";
            $("#questionNumber").text(questionString);
            $("#dialogBox").css("display","block");
            $("#dialogPoints").css("left",$("#x1").offset().left-$("#dialogPoints").width()/2);
            $("#dialogPoints").animate({top:($("#floatbox").offset().top-400)+'px'},500);
        }else if(count==0){
            $("#dialogBox").css("display","block");
            $("#dialogPoints").css("display","none");
            $("#floatBox1").css("left",$("#x1").offset().left-$("#floatBox1").width()/2);
            $("#floatBox1").animate({top:($("#floatbox").offset().top-400)+'px'},500);
            $("#floatBox1").css("display","block");
        }else{
            $("#questionNumber").text(questionString);
            $("#dialogBox").css("display","block");
            $("#dialogPoints").css("left",$("#x1").offset().left-$("#dialogPoints").width()/2);
            $("#dialogPoints").animate({top:($("#floatbox").offset().top-400)+'px'},500);
        };
    });
}

function firstUpdatePaperTip(){//未作答提示框控制
    $("#submitCancel").click(function(){//未作答提示框取消按钮
        $("#dialogBox").css("display","none");
    });

    $("#submitSure").click(function(){//未作答提示框确定按钮
        $("#floatBox1").css("left",$("#x1").offset().left-$("#floatBox1").width()/2);
        $("#floatBox1").animate({top:($("#floatbox").offset().top-400)+'px'},500);
        $("#floatBox1").css("display","block");
        $("#dialogPoints").css("display","none");
    });
}

function secondUpdatePaperTip(subjectid){//二次确认提示框控制

    $("#sure").click(function(){//提交按钮（已确认未作答）
        $("#floatBox2").css("left",$("#x1").offset().left-$("#floatBox2").width()/2);
        $("#floatBox2").animate({top:($("#floatbox").offset().top-400)+'px'},500);
        $("#floatBox2").css("display","block");
     $.ajax({
        type:"POST",
        traditional: true,
        url:"php/user_testing_submit.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{
            subjectid:subjectid,
            questions:JSON.stringify(allQuestion),
            historyusetime:time 
        },
        success:function(data){
            var result=eval(data);
            $("#success1").text("得分："+result.score);
            $("#success1").css("color","red"); 
            if(result.isPass==1){
                $("#success2").text("考试通过！");
            }else{
                $("#success2").text("考试未通过！");
            }
        }
     });

        $("#floatBox1").css("display","none");
    });

    $("#cancel").click(function(){//取消按钮（已确认未作答）
        $("#dialogBox").css("display","none");
    });
}

//user_tesing.js封装（end）******************************************

//user_studyModules(start)******************************************
function userStudyModulesStartPage(){
    $(".logout").click(function(){
        logout();//注销登录
    });
     $.ajax({
        type:"POST",
        url:"php/user_studyModules_start.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{},
        success:function(data){
            var result=eval(data);
            if(result.result=="redirection"){
                location.href="login.html";
            }else{
            $(".managerName").text(result.username);
            var html='';
            for(var i=0;i<result.result.data.length;i++){
                var adding='<li><span class="testBox"><a href="user_studying.html?'+result.result.data[i].moduleid+'">'+result.result.data[i].modulename+'</a></span></li>';
                html+=adding;
            }
            $("#subjectBox").append(html);  
            }    
        }
    });
}

//user_studyModules(end)********************************************

//user_testModules(start)*******************************************

function userTestModulesStartPage(){//初始化页面
    $(".logout").click(function(){
        logout();//注销登录
    });
     $.ajax({
        type:"POST",
        url:"php/user_testModules_start.php?date="+Date.parse(new Date()),
        dataType:"json",
        data:{},
        success:function(data){
            var result=eval(data);
            if(result.result=="redirection"){
                location.href="login.html";
            }else{
            $(".name").text(result.username);
            var html='';
            for(var i=0;i<result.result.data.length;i++){
                if(result.result.data[i].subjectstate==1){
                    var adding='<li><div class="aStyle"><a class="testBox" id="'+result.result.data[i].subjectid+'">'+result.result.data[i].subjectname+'</a></div></li>';
                    html+=adding;
                }
            }
            $(".modeleBox").append(html);   
            userTestModulesClick();//点击事件   
            }
        }
    });
}

function userTestModulesClick(){//点击事件 

    var nowModleId;   

    $(".testBox").click(function(){//提交按钮
        nowModleId=$(this).attr('id');
        $("#dialogBox").css("display","block");
        $("#floatBox").css("left",$("#x1").offset().left-$("#floatBox").width()/2);
        $("#floatBox").animate({top:"300px"},500);
    });

    $("#cancel").click(function(){//取消按钮
        $("#dialogBox").css("display","none");
    });

    $("#sure").click(function(){//确定按钮
        location.href="user_testing.html?"+nowModleId;
    });
}

//user_testModules(end)*********************************************
