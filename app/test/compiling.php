<h1>DoveApi中文语法编译调试</h1>

//编译测试编  编译测试  编译测试  编译测试编
//   译      编       编          译
//   编      编译测试  编译测试     编
//   编      编            编     编
//   编      编译测试  编试测译     编

<!-- testtesttesttest -->
<!--testtest-->something<!-- testtest -->
<!--[if lt IE 9]>something<![endif]-->

/**
 * use xxx;
 * use dove\xxx;
 * use dove\plugin\xxx;
 */
使用类 xxx;<br>
使用框架类 xxx;<br>
使用插件类 xxx 且重命名为 vvv;<br>

/**
 * 待开发
 * Api::initial([
 *     'header'=>[
 *         'xxx',
 *         'xxxx'=>'abc',
 *     ],
 *     'ini'=>[
 *         'xxx'=>'abc',
 *     ]
 * ]);
 */
初始化接口类 {
    header设置{
        设置xxx;
        设置xxxx的且值为abc;
    }
    ini设置 {
        将xxx的值设为abc;
    }
}
