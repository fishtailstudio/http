
##### 经常在项目里面会用上GET和POST请求方法，使用封装好的方法会方便很多。

## 一、安装

```shell
composer require fishtail/http
```

## 二、使用

###  1. 导入
```php
use Fishtail\Http;
```
###  2. GET请求
```php
$res = Http::get('https://www.baidu.com');
```
###  3. POST请求
```php
$url = 'http://example.com';
$header = [
	'Accept: */*',
	'Content-Type: text/plain;charset=UTF-8'
];
$cookie = 'token=2f2568ae-75f0-4ba9-98d4-8c139dad7f64';
$postData = [
	'page' => 1,
	'pageSize' => 20
];
$res = Http::post($url, $postData, $cookie, $header);
```

## 三、参数解释

###  1. GET方法
| 参数  | 类型  |  描述 |
| :------------ | :------------ | :------------ |
| url | string  |  请求的url |
| cookie |  string | 请求cookie  |
| header | array  | 请求头数据  |
| returnCookie | bool  | 是否返回cookie  |

###  1. POST方法
| 参数  | 类型  |  描述 |
| :------------ | :------------ | :------------ |
| url | string  |  请求的url |
| data |  string\|array | post数据  |
| cookie |  string | 请求cookie  |
| header | array  | 请求头数据  |
| returnCookie | bool  | 是否返回cookie  |
