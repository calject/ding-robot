# dingRobot


**Table of Contents**

* [一、介绍](#一介绍-top)
* [二、安装教程](#二安装教程-top)
* [三、说明](#三说明-top)
    * [3.1 说明](#31-说明)
    * [3.2 推送响应说明](#32-推送响应说明)
* [四、使用](#四使用-top)
    * [4.1 at(@) 说明](#41-at-说明) 
    * [4.2 api各类型消息推送使用说明](#42-api各类型消息推送使用说明) 
        * [1. 推送文本消息](#1-推送文本消息)
        * [2. 推送markdown消息](#2-推送markdown消息)
        * [3. 推送ActionCard类型消息(一)](#3-推送ActionCard类型消息一)
        * [4. 推送ActionCard类型消息(二)](#4-推送ActionCard类型消息二)
        * [5. 推送link类型消息](#5-推送link类型消息)
        * [6. 推送FeedCard类型消息](#6-推送FeedCard类型消息)
* [五、拓展](#expand)
    * [1. `markdown` 类型拓展](#expand-1)
    * [2. 消息拓展](#expand-2)



### v1.1.0 新版自定义机器人`webhook`

* 添加安全验证`加签`实现
* `DingRobot __construct(string $token, string $signToken = null)`

```
# 原创建
$robot = DingRobot::get('access_token');
$robot = new DingRobot('access_token');

# new
$robot = DingRobot::get('access_token', 'signToken | null');
$robot = new DingRobot('access_token', 'signToken | null');

```


### <span id="introduce">一、介绍</span> [top](#dingrobot)

钉钉机器人消息推送 简单封装

### <span id="install">二、安装教程</span> [top](#dingrobot)

`composer require "calject/ding-robot"`

### <span id="explain">三、说明</span> [top](#dingrobot)

#### <span id="explain-3.1">3.1 说明</span>

* [官方开发文档](https://open-doc.dingtalk.com/microapp/serverapi2/qf2nxq)

#### <span id="explain-3.2">3.2 推送响应说明</span>

> `DingRobot` 该类未实现对接口响应的处理，默认`request`方法会返回curl原始的返回数据。

* 推送结果处理:

1. 继承`DingRobot`类，并重新`request`方法, 使用自定义的请求类实现并返回 

2. 新建类并实现`CalJect\DingRobot\Contacts\IPush`接口

3. 在外部判断响应接口。注: 成功将返回`{"errmsg":"ok","errcode":0}`

* 示例

```php
$response = DingRobot::get('access_token')->push(DPushText::make('测试'));
if ($response === false) {
    // success
}else {
    $response = json_decode($response, true);
    if ($response['errcode'] === 0) {
        // success
    }else {
        // error
        $err_msg = $response['errmsg'];
        $err_code = $response['errcode'];
    }
}

```


### <span id="usage">四、使用</span> [top](#dingrobot)

#### <span id="usage-4.1">4.1 at(@) 说明</span>

1. 在`message`实例中若提供有`atAll()`或者`atMobile()`,则表示该类型消息可以@指定或者所有人

* 示例1 @所有人

```php
$message = DPushText::make('这是一条测试消息');
$message->atAll();
DingRobot::get('access_token')->push($message);
```

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_at_all.png)

* 示例2 @指定的人

```php
$message = DPushText::make('这是一条测试消息');
// $message->atMobiles('156********');  // at 单人
// $message->atMobiles('156********', '176********'); //1: at 多人
// $message->atMobiles(['156********', '176********']); //2: at 多人
DingRobot::get('access_token')->push($message);
```

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_at_mobile.png)

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_at_mobile_more.png)

2. `@所有人`文本显示与隐藏, 部分消息需要设置该参数以显示`@所有人`文本

* 例`DPushMD`类型消息推送时设置`atAll()`,会@群内所有人，但是不显示`@所有人`的文本
* 如果需要显示`@所有人`文本，需要额外设置`isShowAtAll(true)`参数

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_md_at_all.png)

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_md_at_mobile.png)

#### <span id="usage-4.2">4.2 api各类型消息推送使用说明</span>

##### <span id="usage-4.2.1">1. 推送文本消息</span>

```php
$message = DPushText::make('这是一条测试消息');
DingRobot::get('access_token')->push($message);
```
* 推送示例

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_text_message.png)

##### <span id="usage-4.2.2">2. 推送`markdown`消息</span>

```php
$message = DPushMD::make('左侧标题');
$message->appendTitle('Title');
$message->appendCite('text: cite');
$message->appendHyperlink('百度', 'http://www.baidu.com');
$message->appendImage('https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=22102217,2573612035&fm=27&gp=0.jpg');
$message->appendItemsOrderly([' o-item1', ' o-item2', ' o-item3']);
$message->appendText(new class('自定义测试文本', 'custom') extends AbsMDText {
    
    /**
     * handle the text
     * @param string $text
     * @param array $args
     * @return string
     */
    public function handle(string $text, ... $args): string
    {
        return 'content: ' . $text . self::NEXT_LINE.
            '传入参数: ' . json_encode($args, JSON_UNESCAPED_UNICODE) . self::NEXT_LINE .
            '处理结果: ' . '* '.$text;
    }
});

DingRobot::get('access_token')->push($message);

```
* 推送示例

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_md_message.png)

##### <span id="usage-4.2.3">3. 推送`ActionCard`类型消息(一)</span>


```php
/* ======== 设置描述文本(markdown或者纯文本) ======== */
$message = DPushActionCardList::make("聊天显示概要");
$message->appendCite("审批申请！");
$message->appendCite("这是一段审批简介1");
$message->appendCite("这是一段审批简介2");
$message->appendCite(MDTextHyperlink::make('详情', 'http://www.baidu.com'));
/* ======== 设置排列方式为横向 ======== */
$message->setBtnOrientation(DPushActionCard::BTN_ORIENTATION_HORIZONTAL);
$message->appendBtn("同意","http://www.baidu.com");
$message->appendBtn("拒绝", "http://www.baidu.com");
DingRobot::get('access_token')->push($message);
```

* 横向排列示例 `$message->setBtnOrientation(DPushActionCard::BTN_ORIENTATION_HORIZONTAL);`

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_btn_list_horizontal.png)

* 竖直排列示例 `$message->setBtnOrientation(DPushActionCard::BTN_ORIENTATION_VERTICAL);`

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_btn_list_vertical.png)

##### <span id="usage-4.2.4">4. 推送`ActionCard`类型消息(二)</span>


```php
$message = DPushActionCardOne::make("聊天显示概要");
$message->appendTitle("标题");
$message->appendCite("概要介绍1");
$message->appendCite("概要介绍2");

$message->setSingleTitle("这是跳转链接标题");
$message->setSingleURL("http://www.baidu.com");
DingRobot::get('access_token')->push($message);
```

* 推送示例

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_action_card.png)

##### <span id="usage-4.2.5">5. 推送`link`类型消息</span>


```php
$messageUrl = 'https://image.baidu.com/search/index?tn=baiduimage&ipn=r&ct=201326592&cl=2&lm=-1&st=-1&fm=result&fr=&sf=1&fmq=1548921909883_R&pv=&ic=&nc=1&z=&hd=&latest=&copyright=&se=1&showtab=0&fb=0&width=&height=&face=0&istype=2&ie=utf-8&hs=2&word=%E7%8B%82%E4%B8%89';
$picUrl = 'https://timgsa.baidu.com/timg?image&quality=80&size=b10000_10000&sec=1548922085&di=4f7f0aa0f29792e6c5d38cc1fe29e994&src=http://b-ssl.duitang.com/uploads/item/201607/29/20160729212858_FyiLZ.jpeg';
$text = '简介，即简明扼要的介绍。是当事人全面而简洁地介绍情况的一种书面表达方式，它是应用写作学研究的一种日常应用文体。';
$message = DPushLink::make("百度一下，你就知道", $text, $messageUrl, $picUrl);
DingRobot::get('access_token')->push($message);
```

* 推送示例

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_link.png)

##### <span id="usage-4.2.6">6. 推送`FeedCard`类型消息</span>


```php
$message = DPushFeedCard::make();
$message->appendLink("大标题", "http://www.baidu.com", "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1548932526783&di=3d8345d0e2657a52310575f6a2ad47ed&imgtype=0&src=http%3A%2F%2Fs7.sinaimg.cn%2Fmw690%2F006886pozy74XL8aocu76%26690");
$message->appendLink("小标题1", "http://www.baidu.com", "http://imgsrc.baidu.com/imgad/pic/item/34fae6cd7b899e51fab3e9c048a7d933c8950d21.jpg");
$message->appendLink("小标题2", "http://www.baidu.com", "http://img15.3lian.com/2015/a1/14/d/23.jpg");
$message->appendLink("小标题3", "http://www.baidu.com", "http://f7.topitme.com/7/91/0f/11321340208bd0f917o.jpg");
DingRobot::get('access_token')->push($message);
```

* 推送示例

![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_feed_card.png)


### <span id="expand">五、拓展</span> [top](#dingrobot)

<span id="expand-1">1. `markdown` 类型拓展</span>

继承`CalJect\DingRobot\Contacts\MarkDown\AbsMDText`抽象类，并实现`handle`函数，返回处理后的文本

<span id="expand-2">2. 消息拓展</span>

    1. 继承`CalJect\DingRobot\Contacts\PushData\AbsPushDataAt` 或 `CalJect\DingRobot\Contacts\PushData\AbsPushData` 抽象类，实现`type()`方法返回消息类型，实现`typeData()`方法返回消息实体数据
    2. 继承已有的数据模型，并重写或拓展方法
    
* 示例 `CalJect\DingRobot\Model\Customs\DPushException` 实现了一个自定义异常消息推送

```php
$exception = new \Exception('这是一条异常消息', 500);
$message = DPushException::make($exception);
DingRobot::get('access_token')->push($message);
```
![Image text](https://raw.githubusercontent.com/calject/resources/master/ding-robot/images/robot_custom_message.png)
