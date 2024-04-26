(function ($) {
    $(document).ready(function () {
        //delegation
        $("body").on("click", ".admin-notice-exclusive .notice-dismiss", function () {
            $.post(admin_notice.ajax_url,{
                action: "admin_notice_dismiss",
                nonce: admin_notice.nonce
            },function (response) {
                console.log(response)
            })
        })
    })
})(jQuery)