![](https://groupprocover.gtimg.cn/20693211651667013)

[![Latest Stable Version](http://poser.pugx.org/xcenweb/doveapi/v)](https://packagist.org/packages/xcenweb/doveapi) [![Total Downloads](http://poser.pugx.org/xcenweb/doveapi/downloads)](https://packagist.org/packages/xcenweb/doveapi) [![Latest Unstable Version](http://poser.pugx.org/xcenweb/doveapi/v/unstable)](https://packagist.org/packages/xcenweb/doveapi) [![License](http://poser.pugx.org/xcenweb/doveapi/license)](https://packagist.org/packages/xcenweb/doveapi)


# 🕊 DoveAPI

 [Github](https://github.com/xcenweb/DoveAPI) | [码云(Gitee)](https://gitee.com/xcenweb/DoveAPI)

**▶ 可扩展**

框架支持通过 `composer` 自由安装和使用更多的包，框架 `extend` 目录下的文件可通过 `include` 或者 `namespace` 等（自动）加载

**▶ 支持中文编程**

内置自研的 `中文代码编译器`，使您不再对一堆字母发愁，像写博客一样写代码～

**▶ 完美支持一个API所需的操作**

通过 `dove()->xx()` 即可完成接口的 post、get 接收和返回 json、xml、html、void。

**▶ 不同于MVC的架构**

约定式路由，路径即路由，更加简单易管理的项目结构。


# ⚙️ 安装

通过 composer 创建项目：

```composer
composer create-project xcenweb/doveapi ./
```

⚠️推荐加上 :dev-main

```composer
composer create-project xcenweb/doveapi:dev-main ./
```

更新框架：

```composer
composer update xcenweb/doveapi
```


# ✅ TODO LIST

这些功能都已经着手开发了，欢迎与我一起实现这些令人振奋的功能！

- 框架
  - [x] 约定式路由
  - [x] 独立化 `Debug` config配置
  - [x] 取消 `Log::save()` 方法
  - [x] 独立化 `Log` config配置
  - [x] `AccessControl.php`中所有配置项并入`dove.php`
  - [ ] 框架组件化
  - [ ] 完善中文语法设计及编译器
  - [x] 使用 `dove()->todo` 方式代替 `$this->todo`，并调整 config/api.php 相关配置
  - [ ] 完善的框架文档（2023.8.1 正在实现）


- 组件
  - [ ] `fme` 框架管理器
  - [ ] `i18n`语言国际化
  - [ ] `view` 模板引擎


# 赞助 & 感谢列表

<img src="https://s1.ax1x.com/2023/08/28/pPaUc1P.png" height="230px"/>

感谢以下所有赞助者，
同时感谢所有参与贡献的开发者！

| 赞助者 | 赞助金额 | 备注 |
| :----- | :------- | :--- |
|  |  |  |


# 📃 文档

https://xcenweb.github.io/docs/doveapi/


# 💻 QQ部落

https://qun.qq.com/qqweb/qunpro/share?inviteCode=20BHjqDMEmV&businessType=9