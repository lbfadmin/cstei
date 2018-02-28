/**
 * Created by kevin on 17-3-7.
 */
(function () {
    $(function () {
        var $nav = $('.top-nav');
        $('.menu-toggler').on('click', function () {
            if ($nav.is(':hidden')) {
                $nav.stop().slideDown();
            } else {
                $nav.stop().slideUp();
            }
        });
        $(window).on('resize', function () {
            if ($(window).width() > 1200) {
                $nav.show();
            }
        });
        $('[data-role=co-login]').on('click', function () {
            if ($(window).width() <= 1200) {
                window.location.href = '/account/producer/login';
                return;
            }
            layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                shadeClose: true,
                skin: 'box',
                area: [620, 530],
                content: $('#co-login').html(),
                success: function ($layer, index) {
                    $layer.find('.shut').on('click', function () {
                        layer.close(index);
                    });
                    var $form = $layer.find('form');
                    $form.find('[name=role]').on('change', function () {
                        $form.find('[name=username]').val($(this).val());
                    });
                    $form.on('submit', function () {
                        if ($.trim($form.find('[name=username]').val()) === '') {
                            layer.msg('请选择一个角色');
                            return false;
                        }
                    });
                }
            });
        });

        $('[data-role=gov-login]').on('click', function () {
            if ($(window).width() <= 1200) {
                window.location.href = '/account/supervisor/login';
                return;
            }
            layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                shadeClose: true,
                skin: 'box',
                area: [620, 530],
                content: $('#gov-login').html(),
                success: function ($layer, index) {
                    $layer.find('.shut').on('click', function () {
                        layer.close(index);
                    });
                    var $form = $layer.find('form');
                    $form.find('[name=role]').on('change', function () {
                        $form.find('[name=username]').val($(this).val());
                    });
                    $form.on('submit', function () {
                        if ($.trim($form.find('[name=username]').val()) === '') {
                            layer.msg('请选择一个角色');
                            return false;
                        }
                    });
                }
            });
        });

    });
})();