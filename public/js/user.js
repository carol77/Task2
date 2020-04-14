var User = {

    userId: null,

    init: function()
    {
        User.addHandlers();
    },

    addHandlers: function()
    {
        User.addChangeAccountStatusHandler();
    },

    addChangeAccountStatusHandler: function()
    {
        $(document).on("click", "button[class*='enable-user-account'], button[class*='disable-user-account']", function() {
            User.userId = $(this).closest('tr').attr('id');

            if($(this).hasClass('enable-user-account')) {
                var action = "enableAccount";
            } else {
                var action = "disableAccount";
            }

            var url = "/user/" + action + "/" + User.userId;
            $(".loader").show();
            User.sendRequest(action, url);
        });
    },

    sendRequest: function(action, url, data = {})
    {
        $.ajax({
            method: "POST",
            url: url,
            data: data,
            error: function (response) {
                console.log(response);
            },
            success: function (response) {
                User.handleResponse(action, response);
            }
        });
    },

    handleResponse: function (action, response)
    {
        switch (action) {
            case 'enableAccount':
            case 'disableAccount':
                User.handleChangeAccountStatusResponse(action, response);
                break;
        }
    },

    handleChangeAccountStatusResponse: function(action, response)
    {
        $(".loader").hide();
        $(".messages").empty();
        if(response.result === 'success') {
            var tableCell = $("#users table#dt tr#" + User.userId + " td").eq(1);
            if(action === 'enableAccount') {
                tableCell.find("button[class*='enable-user-account']").hide();
                tableCell.find("button[class*='disable-user-account']").show();
                var message = 'Account has been enabled successfully';
            } else {
                tableCell.find("button[class*='enable-user-account']").show();
                tableCell.find("button[class*='disable-user-account']").hide();
                var message = 'Account has been disabled successfully';
            }
            User.displayMessage('success', message);
        } else {
            User.displayMessage('danger', response.message);
        }
        User.hideMessage();
        User.userId = null;
    },

    displayMessage: function(type, message)
    {
        var alert = $("<div />", {class: "alert alert-" + type, text: message});
        $(".messages").append($(alert));
        $(".messages").show();
    },

    hideMessage: function()
    {
        setTimeout(function () {
            $(".messages").hide('slow');
        }, 5000);
    }
};

$(document).ready(function() {
    User.init();
});