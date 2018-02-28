<div id="modal-confirm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5><i class="gi gi-circle_question_mark"></i> 确认</h5>
            </div>
            <div class="modal-body">
                <form action="index.php" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onsubmit="return false;">
                    <div class="form-group">
                        <h4 class="message text-center text-danger">您确定要进行此操作吗？</h4>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="button" class="btn btn-circle btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-circle btn-primary ok">确定</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<div id="modal-message" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5><i class="gi gi-circle_info"></i> 信息</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <h4 class="message text-center text-danger"></h4>
                </div>
                <div class="form-group form-actions">
                    <div class="col-xs-12 text-right">
                        <button type="submit" class="btn btn-sm btn-primary ok">确定</button>
                    </div>
                </div>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>

<div id="modal-tip" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5><i class="gi gi-circle_info"></i> 提示</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <h4 class="message text-center text-info"></h4>
                </div>
            </div>
            <!-- END Modal Body -->
            <div class="modal-footer">
                <div class="form-group form-actions">
                    <div class="col-xs-12 text-right">
                        <button type="submit" class="btn btn-primary ok" data-dismiss="modal">确定</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--[if lt IE 9]>
<script src="/misc/src/global/plugins/respond.min.js"></script>
<script src="/misc/src/global/plugins/excanvas.min.js"></script>
<script src="/misc/src/global/plugins/ie8.fix.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="/misc/src/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/upload.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/layer/layer.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="/misc/src/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="/misc/src/global/scripts/app.min.js" type="text/javascript"></script>
<script src="/misc/src/global/scripts/common.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="/misc/src/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
<script src="/misc/src/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
<script src="/misc/src/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="/misc/src/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
<script>
    $(function() {
        // 菜单高亮
        $('li.nav-item.active').parents('li.nav-item').addClass('active');

        window.$modalAlert = window.$modalTip = window.$alert = window.$tip = $('#modal-tip');
        window.$modalConfirm = window.$confirm = $('#modal-confirm');

        // 确认
        $(document).on("click", ".confirm", function () {
            var $this = $(this);
            $modalConfirm.find(".message").html($this.attr("data-confirm"));
            $modalConfirm.modal();
            $modalConfirm.data("ref", $this);
            return false;
        });
        $(document).on("click", "#modal-confirm .ok", function () {
            var $elem = $modalConfirm.data("ref"),
                href = $elem.attr("href");
            $modalConfirm.modal("hide");
            if (typeof href !== "undefined" && ! /^javascript:/i.test(href)) {
                window.location.href = $elem.attr("href");
            }
        });
    });
</script>