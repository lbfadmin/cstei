<?=$this->region('common/head')?>
<?=$this->region('common/header')?>
<style>
.anchorBL{display:none;}
</style>
<div class="homecon center-block">
    <div class="homeconitrm">
        <div class="homeconitrmcon">
            <div class="itemheader">
                <p><span>体系简介 </span> / System introduction</p>
                <a href="/content/page/brief?id=37">更多>></a>
                <i></i>
            </div>
            <div class="itemcon itemconex">
                <a href="">
                    <div class="itemconimg txhome">
                        <img src="<?=$this->misc('web/img/img3.jpg')?>" alt="">
                    </div>
                </a>
            </div>
            <div class="lineklist txhomelinek">
                <p>国家海水鱼产业技术体系是农业部、财政部2008年首批启动并在“十三五”期间扩容调整建设的50个现代农业产业技术体系之一，由国家海水鱼产业技术研发中心和综合试验站两个层级构成。研发中心依托单位为中国水产科学研究院黄海水产研究所，首席科学家为关长涛研究员。
                    <a href="/content/page/brief?id=37">【<span>详情</span>】</a>
                </p>
            </div>
        </div>
    </div>
	
    <div class="homeconitrm">
        <div class="homeconitrmcon">
            <div class="itemheader">
                <p><span>新闻动态</span> / News information</p>
                <a href="/content/news/index?parentId=14">更多>></a>
                <i></i>
            </div>
            <div class="itemcon">
                <a href="">
                    <div class="itemconimg">
                        <img src="http://www.ysfri.ac.cn/ueditor/net/upload/image/20170814/6363831786993933523855078.jpg" alt="" width=186 height=146>
                    </div>
                    <div class="itemtext">
                        <a href="/content/news/news-detail?id=142"><p class="itemtexttitle">国家海水鱼产业技术体系建设启动会暨海水鱼产业发展研讨会</p>
                        <p>8月12日，国家海水鱼产业技术体系建设启动会暨海水鱼产业发展研讨会在青岛海洋科学与技术国家实验室召开… </p>
						</a>
                    </div>
                </a>
            </div>
            <div class="lineklist">
                <li class="linekitem">
                    <a href="">
                        <i></i>
                       <a href="/content/news/news-detail?id=143"> <h1>2017年中国渔业统计年鉴概读...</h1>
                        <span>08-16</span></a>
                    </a>
                </li>
                <li class="linekitem">
                    <a href="">
                        <i></i>
                        <h1>东海水产研究所组织举办渔业装备...</h1>
                        <span>08-08</span>
                    </a>
                </li>
                <li class="linekitem">
                    <a href="">
                        <i></i>
                        <h1>东海水产研究所开展绿色风能与海洋生态渔业...</h1>
                        <span>08-08</span>
                    </a>
                </li>
            </div>
        </div>
    </div>

    <div class="homeconitrm">
        <div class="homeconitrmcon">
            <div class="itemheader">
                <p><span>产业文化 </span> / Cultural propaganda</p>
                <a href="/content/news/culture?parentId=15">更多>></a>
                <i></i>
            </div>
            <div class="itemcon">
                <a href="">
                    <div class="itemconimg whhome">
                        <img src="<?=$this->misc('web/img/img2.png')?>" alt="">
                    </div>

                </a>
            </div>
            <div class="lineklist">
                <li class="linekitem">
                    <a href="/content/news/culture-detail?id=76">
                        <i></i>
                        <h1>舌尖上的多宝鱼</h1>
                        <span>08-02</span>
                    </a>
                </li>
                <li class="linekitem">
                    <a href="/content/news/culture-detail?id=78">
                        <i></i>
                        <h1>大连海洋艺术展倡导环保</h1>
                        <span>08-6</span>
                    </a>
                </li>
                <li class="linekitem">
                    <a href="/content/news/culture-detail?id=127">
                        <i></i>
                        <h1>中国多宝鱼戴上“身份证”再闯…</h1>
                        <span>07-10</span>
                    </a>
                </li>
            </div>
        </div>
    </div>



    <div class="homeconitrm">
        <div class="homeconitrmcon">
            <div class="itemheader">
                <p><span>产业动态 </span> / Product tracing</p>
                <a href="/content/news/industry-dynamics?id=84&name=大菱鲆">更多>></a>
                <i></i>
            </div>
            <div class="itemcon ylitemcon">

                    <div class="itemconimg">
                         <div id="chart-companies" class="chart"></div>
                    </div>

            </div>
        </div>
    </div>

            <!-- END PAGE LEVEL SCRIPTS -->
    <div class="homeconitrm homeconitrmsyz">
        <div class="homeconitrmcon">
            <div class="itemheader">
                <p><span>试验站  </span> / Experiment station</p>
                <a href="/content/page/brief?id=37">更多>></a>
                <i></i>
            </div>
            <div class="itemcon ylitemcon">

                    <div class="itemconimg">
                        <div data-area="山东省" id="chart3" class="chart" style="height: 100%;width:100%;"></div>
                     </div>
   
            </div>
        </div>
    </div>

    <div class="homeconitrm homeconitrmsyz">
        <div class="homeconitrmcon">
            <div class="itemheader">
                <p><span>市场经济   </span> /  Market economy</p>
                <a href="">更多>></a>
                <i></i>
            </div>
            <div class="itemcon scitemcon">
                <div class="scitemconheader">
                        <li class="clo1">产品名称</li>
                        <li class="clo2">平均价格</li>
                        <li class="clo3">趋势</li>
                        <li class="clo4">日期</li>
                        <li class="clo5">走势图</li>
                </div>
                <div class="scitemconcon">
<?php if (!empty($market_economy->list)):?>

<?php foreach ($market_economy->list as $item):?>
                   <ul>
                        <dd></dd>
                        <li class="clo1"><?=$item->name?></li>
                        <li class="clo2"><?=$item->retail_price?></li>
                        <li class="clo3">
<?php if ($item->trend):?>
上升
<?php else: ?>					
下降
<?php endif ?>
						</li>
                        <li class="clo4"><?=$item->time_created?></li>
                        <li class="clo5"><img src="<?=$this->misc('web/img/zs.png')?>" alt=""></li>
                    </ul>

<?php endforeach;?>


<?php endif ?>
		
                </div>
            </div>
        </div>
    </div>

    <div class="homeconitrm homeconitrmsyz">
        <div class="homeconitrmcon">
            <div class="itemheader">
                <p><span>质量安全 </span> / Quality Safety</p>
                <a href="/content/news/trace?category_id=38">更多>></a>
                <i></i>
            </div>
            <div class="itemcon">
                <a href="">
                    <div class="itemconimg whhome">
                        <img src="<?=$this->misc('web/img/6363556379819250295957094.png')?>" alt="">
                    </div>

                </a>
            </div>
            <div class="lineklist">
                <li class="linekitem">
                    <a href="/content/news/trace?id=62">
                        <i></i>
                        <h1>鲆鲽类产地溯源操作规范</h1>
                        <span>08-02</span>
                    </a>
                </li>
                <li class="linekitem">
                    <a href="/content/news/trace?id=56">
                        <i></i>
                        <h1>吃鱼过敏的人吃其他海鲜也过敏吗</h1>
                        <span>08-06</span>
                    </a>
                </li>
                <li class="linekitem">
                    <a href="/content/news/trace?id=64">
                        <i></i>
                        <h1>水产品质量标准</h1>
                        <span>07-10</span>
                    </a>
                </li>
            </div>
        </div>
    </div>

    <div class="homeconitrm homeconitrmsyz">
        <div class="homeconitrmcon">
            <div class="itemheader">
                <p><span>成果展示 </span> / Achievement display</p>
                <a href="/content/news/achieve?parentId=16">更多>></a>
                <i></i>
            </div>
            <div class="itemcon cgitemconbox">
                <a href="/content/news/achieve-detail?id=80" class="cgitemcon">
                    <div class="itemconimgs">
                        <img src="http://images.marinefish.cn/CR-e9coVRArOg.jpg" alt="" style='width:168px;height:120px;'>
                        <p>网箱养殖</p>
                    </div>
                </a>
                <a href="/content/news/achieve-detail?id=79" class="cgitemcon">
                    <div class="itemconimgs">
                        <img src="http://images.marinefish.cn/CR-kT9MU6l1Dr.jpg" alt="" style='width:168px;height:120px;'>
                        <p>设施装备</p>
                    </div>
                </a>
                <a href="/content/news/achieve-detail?id=75" class="cgitemcon">
                    <div class="itemconimgs">
                        <img src="http://images.marinefish.cn/CR-ScFLOn9NUG.png" alt="" style='width:168px;height:120px;'>
                        <p>大菱鲆种质</p>
                    </div>
                </a>
                <a href="/content/news/achieve-detail?id=66" class="cgitemcon">
                    <div class="itemconimgs">
                        <img src="http://images.marinefish.cn/CR-PxnGQy99wG.png" alt="" style='width:168px;height:120px;'>
                        <p>大菱鲆疫苗技术</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?=$this->region('common/footer')?>
<script src="/misc/src/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/layer/layer.js" type="text/javascript"></script>
<script src="/misc/src/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="/misc/src/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<!-- END CORE PLUGINS -->
<style>
.chart {
    height: 280px;
}
</style>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="/misc/src/global/scripts/app.min.js" type="text/javascript"></script>
<script src="/misc/src/global/scripts/common.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="/misc/src/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
<script src="/misc/src/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
<script src="/misc/src/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="/misc/src/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>

            <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/misc/src/global/plugins/echarts/echarts.min.js" type="text/javascript"></script>
    <script src="/misc/src/web/js/dashboard.js" type="text/javascript"></script>








<script src="<?=$this->misc('vendor/jquery/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?=$this->misc('vendor/bootstrap/3.3.7/js/bootstrap.min.js')?>" type="text/javascript"></script>
<script src="http://api.map.baidu.com/api?v=2.0&ak=sfUt2020b4OwyE1GA7mic3zUgAH5f3Gu"></script>
<script src="<?=$this->misc('vendor/echarts/echarts.min.js')?>"></script>
<script src="<?=$this->misc('vendor/echarts/extension/bmap.min.js')?>"></script>
<script src="<?=$this->misc('vendor/mapv/mapv.min.js')?>"></script>
<script src="<?=$this->misc('app/js/dashboard.js')?>"></script>
<script src="<?=$this->misc('vendor/unslider/2.0/js/unslider-min.js')?>"></script>
<script src="<?=$this->misc('web/js/dashboard.js')?>"></script>
</body>
</html>
