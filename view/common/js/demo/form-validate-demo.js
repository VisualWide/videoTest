//以下为修改jQuery Validation插件兼容Bootstrap的方法，没有直接写在插件中是为了便于插件升级
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                element.closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    error.appendTo(element.parent().parent().parent());
                } else {
                    error.appendTo(element.parent());
                }
            },
            errorClass: "help-block m-b-none",
            validClass: "help-block m-b-none"


        });

        //以下为官方示例
        $().ready(function () {
            // validate the comment form when it is submitted
            $("#commentForm").validate();
            $("#commentForm1").validate();
            $("#commentForm2").validate();
            // validate signup form on keyup and submit
            var icon = "<i class='fa fa-times-circle'></i> ";
            $("#signupForm").validate({
                rules: {

                    adminName: {
                        required: true,
                        email: true,
                        maxlength: 50
                    },
                    adminPwd: {
                        required: true,
                        minlength: 5
                    },
                    reAdminPwd: {
                        required: true,
                        minlength: 5,
                        equalTo: "#adminPwd"
                    },
                    code: {
                        required: true,
                        minlength: 6,
                        maxlenth: 6
                    }
                },
                messages: {
                    adminName: icon + "请输入您的E-mail",
                    adminPwd: {
                        required: icon + "请输入您的密码",
                        minlength: icon + "密码必须5个字符以上"
                    },
                    reAdminPwd: {
                        required: icon + "请再次输入密码",
                        minlength: icon + "密码必须5个字符以上",
                        equalTo: icon + "两次输入的密码不一致"
                    },
                }
            });

        });
