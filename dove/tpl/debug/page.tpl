<!-- doveapi框架友好debug页面 --><!doctype html>
<html lang="zh-cmn-Hans"> 
  <head> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="renderer" content="webkit">
    <meta name="force-rendering" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>哦嚯，出错咯 - DoveAPI</title>
    <link rel="stylesheet" href="{$domain}/static/dove_static/debug/css/mdui.min.css">
    <link rel="stylesheet" href="{$domain}/static/dove_static/debug/css/vs2015.css">
    <style>
      .hljsln {
          position: relative;
          display: block;
          padding-left: 3em !important;
      }
      .hljsln .ln-bg {
          position: absolute;
          z-index: 1;
          top: 0;
          left: 0;
          width: 2.2em;
          height: 100%;
          border-right: 1px solid #555;
          background: rgba(255, 255, 255, 0.18);
      }
      .hljsln .ln-num {
          position: relative;
          display: inline-block;
          height: 1em;
          -webkit-touch-callout: none;
          -webkit-user-select: none;
          -khtml-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
      }
      .hljsln .ln-num::before {
          position: absolute;
          z-index: 2;
          top: 0;
          margin-top: 2.8px;
          right: 0;
          margin-right: 1em;
          color: #777;
          font-style: normal;
          font-weight: normal;
          content: attr(data-num);
      }
    </style>
  </head>
  <body>
    <div class="mdui-container">
      <div class="mdui-card mdui-color-red-400" style="margin-top:10px">
        <div class="mdui-card-content mdui-center">
          这里是框架的<b>错误页面</b>，出现此页面时说明程序运行<u>可能</u>出现问题，请阅读以下回调信息了解错误详情。<br>
          <hr>
          查错技巧：<br>
          1.注意本报错页面的“Error Info”内容和“Call Stack”内容。<br>
          2.如果“Error Info”中的报错让你摸不着头脑，可以在“Call Stack”中由红色的 {clouse}（有些时候可能没有这个）从下往上逐个排查，也许能帮助你找到触发报错的位置。<br>
          3.如果你启用了本框架的中文语法扩展，发生错误时其实是指向编译后（缓存）文件，本页面底端有左右两个（在pc或平板的UA下，手机上为上下）支持代码高亮显示的文本域，你只需参考“Error Info”和“Call Stack”以及对比编译前和编译后文件内容。如此你就能更快的找到报错的原因。祝你好运 :)<br>
          <hr>
          <b>注意：生产环境中请关闭调试模式！</b>
        </div>
      </div>
      <div class="mdui-typo">
        <h3> Error Info <small> 报错内容</small></h3>
        <pre>{$err_info}</pre>
        <div class="mdui-float-right">
            <button onclick="debug_search('du');" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-blue-accent">百度此报错内容</button>
            <button onclick="debug_search('gg');" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-blue-accent">谷歌此报错内容</button>
        </div><br>
      </div>
      <div class="mdui-typo">
        <h3> Call Stack <small> 执行回溯</small></h3>
        <pre>{$call_stack}</pre>
      </div>
      <div class="mdui-row">
        <div class="mdui-col-xs-12 mdui-col-sm-6">
          <div class="mdui-typo">
            <h3> 未编译文件 </h3>
            <small>{$uncompiled_file}</small>
          </div>
          <pre><code>{$uncompiled_file_content}</code></pre>
        </div>
        <div class="mdui-col-xs-12 mdui-col-sm-6">
          <div class="mdui-typo">
            <h3> 编译后文件 </h3>
            <small>{$compiled_file}</small>
          </div>
          <pre><code>{$compiled_file_content}</code></pre>
        </div>
      </div>
      <div class="mdui-typo mdui-text-center">
        <hr>
        <p><b><a class="mdui-text-color-teal" href="http://dove.xcenadmin.top/">DoveAPI V{$version}</a> - 极速上手，快速开发！</b></p>
        运行耗时&nbsp;<font class="mdui-text-color-teal">{$exitTime}s</font>
      </div>
    </div>
  <script src="{$domain}/static/dove_static/debug/js/highlight.min.js"></script>
  <script src="{$domain}/static/dove_static/debug/js/highlightjs-line-numbers.js"></script>
  <script>
      hljs.highlightAll();
      hljsln.initLineNumbersOnLoad();
      function debug_search(keyword){
          var q = "php {$err_info}";
          if(keyword=="du"){
              window.open("http://www.baidu.com/s?wd="+q+"&cl=3");
          }else if(keyword=="gg"){
              window.open("https://www.google.com/search?q="+q);
          }else{
              return false;
          }
      }
  </script>
  </body>
</html>