# bili-video-comment-api
bilibili视频评论api（php中转，添加新功能qwq）

## biliapi.php的参数列表
|  参数   | 作用  |  参数填写  |
|  :----:  | :----:  |:----:|
| uid  | 直接获取此用户的最新视频 |此处填写用户uid/mid|
| mode  | 更改排序方式 |1为时间排序，2为热度排序|
| aid  | 输出指定视频的评论(不能与uid混用) |此处填写视频av号(仅数字)|
