顾名思义，laravel-blade-lottie 可以让你更方便的在 blade 模板中使用 [lottie animation json files](https://lottiefiles.com/)，也可以使用[iconfont.cn 的 Lottie 库](https://www.iconfont.cn/lotties/index)中的动画。

## 用法
### 安装包

    composer require ys/laravel-blade-lottie

### 发布必要文件

    php artisan lottie:publish

这个操作会把配置文件复制为 `config/lottie.php`，还会把需要用到的前端文件发布到 `public/vendor/lottie`。

### 引入 app.js
在需要用到页面中添加 `<script src="{{ asset('vendor/lottie/app.js') }}" defer></script>`。但是通常来说，把它添加到 `views/layouts/app.blade.php` 中会比较方便。

### 引入 lottie animation files
在 [lottie files](https://lottiefiles.com/) 官方网站上可以免费下载 json 文件。下载文件需要注册一个账号，我在[这里](https://raw.githubusercontent.com/yunshuaipeng/laravel-blade-lottie/main/resources/lottie-files/hello-lottie.json)提供了一个测试用的 json，将其中的内容复制到 `storage/app/public/lottiefiles/hello.json`。

### 使用组件
在 `views/layouts/app.blade.php` 引入 `<x-lottie-hello/>`，打开你的项目地址，就可以看到：

![](https://cdn.jsdelivr.net/gh/pys1992/storage@main/20210331110313.gif)

## 关于 app.js
首先，[lottie-web](https://github.com/airbnb/lottie-web) 是必不可少的，另外我还使用了 [alpinejs](https://github.com/alpinejs/alpine)，用于实现一些 js 的操作。我把他们打包到了 `public/vendor/lottie/app.js` 中，你可以直接使用。

你也可以在自己的 `app.js` 中打包 `lottie-web` 和 `alpinejs`，如果这样做，那么上面提到的的 `<script src="{{ asset('vendor/lottie/app.js') }}" defer></script>` 就没必要再引入了。

## 如何控制动画
这取决与 [lottie-web](https://github.com/airbnb/lottie-web#usage)，它提供了一些属性和方法，用于控制动画。

### loop 属性
在 `config/lottie.php` 中可以定义全局的是否循环播放属性，如果为每个组件单独定义，可以这样做：
```html
<x-lottie-hello loop="true"/>
```

或者简写为：

```html
<x-lottie-hello loop/>
```

### autoplay 属性
在 `config/lottie.php` 中可以定义全局的是否自动播放属性，如果为每个组件单独定义，可以这样做：
```html
<x-lottie-hello autoplay="false"/>
```

或者简写为：

```html
<x-lottie-hello autoplay/>
```

### 调用方法
在 blade 组件中，初始化 alpinejs 的时候，`lottie-web` 实例被绑定给了 `animation`。所以，可以使用 `animation` 来调用 `lottie-web` 提供的方法，从而控制动画。

例如，如果想要单击动画停止播放，可以在 click 事件中，通过调用 `animation.stop()` 来实现。click 是 alpinejs 提供的，在 [alpinejs#use](https://github.com/alpinejs/alpine#use) 可以查看更多用法。
```html
<x-lottie-hello @click="animation.stop()"/>
```

## 自定义 class
自定 class 的会被追加到动画的容器上，参考 [laravel 文档](https://laravel.com/docs/master/blade#default-merged-attributes)。

例如，可以自定义 class：
```html
<x-lottie-hello class="h-16 w-auto z-20"/>
```

## 自定义非 class 属性
自定属性的会被添加到动画容器上，如果已存在相同属性，则会把原来的覆盖，参考 [laravel 文档](https://laravel.com/docs/master/blade#non-class-attribute-merging)。

例如，可以自定义 style：
```html
<x-lottie-hello style="width: 100px"/>
```

## 关于 data_source
支持配置 url 和 content。选择 url ，浏览器会发请求去获取 json 数据，意味着会增加网络开销；而选择 content，则 json 数据会通过后端渲染，附加到 HTML 中发送给前端，如果 json 数据很大，则你的 HTML 页面可能也会变得很大，但是我没有测试。

如果使用 url 的方式，不要忘了在 .env 文件中配置正确的 APP_URL，以及执行 `php artisan storage:link`