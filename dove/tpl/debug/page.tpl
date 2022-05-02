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
    <style>pre code.hljs{display:block;overflow-x:auto;padding:1em}code.hljs{padding:3px 5px}.hljs{background:#1e1e1e;color:#dcdcdc}.hljs-keyword,.hljs-literal,.hljs-name,.hljs-symbol{color:#569cd6}.hljs-link{color:#569cd6;text-decoration:underline}.hljs-built_in,.hljs-type{color:#4ec9b0}.hljs-class,.hljs-number{color:#b8d7a3}.hljs-meta .hljs-string,.hljs-string{color:#d69d85}.hljs-regexp,.hljs-template-tag{color:#9a5334}.hljs-formula,.hljs-function,.hljs-params,.hljs-subst,.hljs-title{color:#dcdcdc}.hljs-comment,.hljs-quote{color:#57a64a;font-style:italic}.hljs-doctag{color:#608b4e}.hljs-meta,.hljs-meta .hljs-keyword,.hljs-tag{color:#9b9b9b}.hljs-template-variable,.hljs-variable{color:#bd63c5}.hljs-attr,.hljs-attribute{color:#9cdcfe}.hljs-section{color:gold}.hljs-emphasis{font-style:italic}.hljs-strong{font-weight:700}.hljs-bullet,.hljs-selector-attr,.hljs-selector-class,.hljs-selector-id,.hljs-selector-pseudo,.hljs-selector-tag{color:#d7ba7d}.hljs-addition{background-color:#144212;display:inline-block;width:100%}.hljs-deletion{background-color:#600;display:inline-block;width:100%}</style>
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
      {$mistake_file}
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