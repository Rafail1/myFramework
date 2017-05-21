var GLOBAL_HELPER = {
    getParent: function (el) {
        return el.closest('.js-parent');
    },
    request: function (params, callback) {
        params.type = params.type || 'post';
        $.ajax({
            url: params.url,
            type: params.type,
            data: params.data
        }).done(function (res) {
            if (callback) {
                callback.call(this, res);
            }
        }).fail(function () {
            this.error("error");
        });
    },
    error: function (message, out) {
        if (out) {
            out.log(message);
        } else {
            console.log(message);
        }
    }
};