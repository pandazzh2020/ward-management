# Hospital-ward-management
__医院病房管理系统__
<br>
PHP 选修课的期末课设
<br>
分为病人端、医生端、病房管理员端
<br>
功能：病房管理、物业报修、病人请假管理、病人需求管理、申请调换病房
一、公共模块:
1.登陆
2.登出
3.修改密码
4.公告
5.病房数据统计

二、管理员操作模块:
1.查看个人信息
2.查看病人需求
3.查看病人离院情况
4.查看病房维修需求并维护
5.搜索病人信息,修改病人信息
6.病房管理
7.调换病房
8.编辑公告

  三、医生操作模块:
1.查看个人信息
2.查看病人需求并响应
3.查看病人离院情况
4.调换病房
5.查看病人信息,修改病人信息

  四、病人操作模块:
1.查看个人信息
2.申请看病需求
3.申请暂时离院
4.申请调换病房

五、前端界面优化工作
1.功能设计简洁直观
2.整体风格统一
3.界面清晰美观

<br><br>
创建 MySql 数据库：
<br>
[create_db.sql](https://github.com/Surbowl/dormitory-management-php/blob/master/create_db.sql)
<br><br>
修改数据库连接：
<br>
dorm/public/_share/[_pdo.php](https://github.com/Surbowl/dormitory-management-php/blob/master/dorm/public/_share/_pdo.php)
