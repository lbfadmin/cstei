/**
 * Created by kevin on 15-4-24.
 */
;(function (window, undefined) {
    if (typeof App === 'undefined') {
        window.App = {};
    }
    App.queries = {};
    var pairs = location.search.substring(1).split("&");
    for(var i = 0; i < pairs.length; i++) {
        var pos = pairs[i].indexOf('=');
        if (pos == -1) continue;
        var argname = pairs[i].substring(0, pos);
        var value = pairs[i].substring(pos+1);
        value = decodeURIComponent(value);
        App.queries[argname] = value;
    }

    App.getQuery = function (name) {
        return typeof App.queries[name] === 'undefined' ? '' : App.queries[name];
    };

    /**
     * 模板引擎
     */
    this.tpl = function(ID) {
        function Tpl(ID) {
            this.ID = ID;
            this.tpl = $("#" + ID).html();

            return this;
        };

        Tpl.prototype.render = function(data) {
            return data ? tpl.parse(this.tpl, data) : this.tpl;
        };

        if (! tpl.cache[ID]) {
            tpl.cache[ID] = new Tpl(ID);
        }

        return tpl.cache[ID];
    };

    tpl.cache = {};

    tpl.parse = function(str, data) {
        if (! data) return str;
        var parts = str.split("<%");
        for (var i = 0; i < parts.length; i++) {
            parts[i] = parts[i].replace(/(?=%>)[\s\S]+/g, function (m) {
                return m.replace(/\'/g, '\v');
            });
        }
        var fn = new Function("obj",
            "var p = [];" +
            "with (obj) {" +
            "p.push('" +
            parts.join('<%')
                .replace(/[\r\t\n]/g, " ")
                .split("<%").join("\t")
                .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                .replace(/\t=(.*?)%>/g, "',$1,'")
                .split("\t").join("');")
                .split("%>").join("p.push('")
                .split("\r").join("\\'") +
            "');" +
            "}" +
            "return p.join('').replace(/\v/g, '\\'');");
        return fn(data);
    };

    App.alert = function (message, closed) {
        $alert.find('.am-modal-bd').html(message);
        $alert.modal();
        $alert.on('closed.modal.amui', closed);
    };
    App.confirm = function (message, confirm, cancel) {
        $confirm.find('.am-modal-bd').html(message);
        $confirm.modal({
            relatedTarget: this,
            onConfirm: confirm,
            onCancel: cancel
        });
    };

    $.fn.contentLoading = function () {
        $(this).html('<div class="content-loading">加载中……</div>');
    };

})(window);
