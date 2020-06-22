# 宠物云医生管理后台

## 安装说明
1. 进入项目目录：
2. 下载前端插件依赖包
  ```
  bower install
  ```
3. 下载PHP依赖包
  ```
  composer install
  ```
4. 一键创建数据库并导入数据
  ```
  php think install -u 数据库用户名 -p 数据库密码
  ```
5. 使用 `create_table.sql` 中的建表语句创建数据表
6. 添加虚拟主机并绑定到项目的public目录
