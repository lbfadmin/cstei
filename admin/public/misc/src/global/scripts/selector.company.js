/**
 * Created by kevin on 16-12-16.
 */
(function () {
    var Model = {

        cache: {},

        getChildren: function (parentId, callback) {
            var self = this;
            if (typeof this.cache[parentId] !== 'undefined') {
                callback(this.cache[parentId]);
                return;
            }
            $.ajax({
                url: '/common/ajax/area/get-children',
                data: {parent_id: parentId},
                success: function (result) {
                    self.cache[parentId] = result.data.children;
                    callback(result.data.children);
                }
            });
        }
    };
    var Selector = function ($container, options) {
        var self = this;
        this.$container = $container;
        this.$parent_id = this.$container.find('.parent_id');
        // this.$cities = this.$container.find('.cities');
        // this.$districts = this.$container.find('.districts');
        // this.$blocks = this.$container.find('.blocks');
        // this.$communities = this.$container.find('.communities');
        this.selected = {
            parent_id: this.$parent_id.attr('data-selected'),
            // city_id: this.$cities.attr('data-selected'),
            // district_id: this.$districts.attr('data-selected'),
            // block_id: this.$blocks.attr('data-selected'),
            // community_id: this.$communities.attr('data-selected')
        };
        this.options = $.extend({
            selected: this.selected,
            onSelected: null
        }, options);

        // self.$provinces.on('change', function () {
            // self.selectProvince($(this).val());
        // });

        // self.$cities.on('change', function () {
            // self.selectCity($(this).val());
        // });

        // self.$districts.on('change', function () {
            // self.selectDistrict($(this).val());
        // });

        // self.$blocks.on('change', function () {
            // self.selectBlock($(this).val());
        // });

        self.$communities.on('change', function () {
            self.options.onSelected && self.options.onSelected.call(self, self.getSelected());
        });
        Model.getChildren(0, function (data) {
            var html = '<option value=""> -- 请选择 -- </option>';
            $.each(data, function (k, v) {
                var selected = self.selected.province_id == v.id ? 'selected' : '';
                html += '<option value="' + v.id + '" ' + selected + '>' + v.name + '</option>';
            });
            self.$provinces.html(html);
            if (self.selected.province_id && self.selected.province_id != 0) {
                self.$provinces.trigger('change');
                self.selected.province_id = null;
            }
        });
    };
    
    Selector.prototype = {
        
        constructor: Selector,
        
        selectComapany: function (provinceId) {
            var self = this;
            if (provinceId == 0) {
                self.$cities.empty();
                self.$districts.empty();
                self.$blocks.empty();
                self.$communities.empty();
                return;
            }
            Model.getChildren(provinceId, function (data) {
                var html = '<option value=""> -- 请选择 -- </option>';
                $.each(data, function (k, v) {
                    var selected = self.selected.city_id == v.id ? 'selected' : '';
                    html += '<option value="' + v.id + '" ' + selected + '>' + v.name + '</option>';
                });
                self.$cities.html(html);
                self.$districts.empty();
                self.$blocks.empty();
                self.$communities.empty();
                if (self.selected.city_id && self.selected.city_id != 0) {
                    self.$cities.trigger('change');
                    self.selected.city_id = null;
                }
            });
        },
        


        getSelected: function () {
            return {
                province_id: this.$provinces.val(),
                city_id: this.$cities.val(),
                district_id: this.$districts.val(),
                block_id: this.$blocks.val(),
                community_id: this.$communities.val()
            }
        }
    };

    // $.fn.areaSelector = function () {
        // var $this = $(this);
        // $this.each(function () {
            // var $this = $(this);
            // var selector = new Selector($this);
            // $this.data('selector', selector);
        // });
    // };

    window.CompanySelector = Selector;
})();