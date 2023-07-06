![](https://groupprocover.gtimg.cn/20693211651667013)

[![Latest Stable Version](http://poser.pugx.org/xcenweb/doveapi/v)](https://packagist.org/packages/xcenweb/doveapi) [![Total Downloads](http://poser.pugx.org/xcenweb/doveapi/downloads)](https://packagist.org/packages/xcenweb/doveapi) [![Latest Unstable Version](http://poser.pugx.org/xcenweb/doveapi/v/unstable)](https://packagist.org/packages/xcenweb/doveapi) [![License](http://poser.pugx.org/xcenweb/doveapi/license)](https://packagist.org/packages/xcenweb/doveapi)

# 🕊 DoveAPI

- 整顿一下，再次出发！

- 轻量、简洁、不同于MVC


**- 可扩展**

框架支持通过composer自由安装和使用更多的pack，框架的extend目录下的文件可通过include或者namespace等（自动）加载

**- 支持中文编程**

内置自研的中文代码编译器，使您不再对一堆字母发愁，像写博客一样写代码～

**- 完美支持一个API所需的操作**

通过 `$this->xx()` 的 OOP（面向对象程序）方式即可完成接口的 post、get 接收和 json、xml、html、void 等统一式返回。

**- 不同于MVC的架构**

路由即路径，更加简单易懂的结构。


# ⚙️ 安装

通过composer安装框架：
```composer
composer create-project xcenweb/doveapi ./
```

⚠️目前推荐直接安装开发版本

```composer
composer create-project xcenweb/doveapi:dev-main ./
```

更新框架：

```composer
composer update xcenweb/doveapi
```

# ✅ TODO LIST

能不能实现就看我有没有时间啦（迫真）

  - [ ] 完善中文语法设计及编译器
  - [ ] 解决 `$this->xx` 部分类方法编辑器没有提示的问题
  - [ ] 框架组件化探索（基于composer）
  - [ ] 完善的框架文档
  - [ ] `fme`、`i18n` 等组件的开发上线


# 📃 文档

https://xcenweb.github.io/docs/doveapi/


# 💻 QQ部落

https://qun.qq.com/qqweb/qunpro/share?inviteCode=20BHjqDMEmV&businessType=9