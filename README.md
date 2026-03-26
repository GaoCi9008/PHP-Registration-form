# PHP-register
📁 项目文件说明
1. index.php – 注册表单页面
作用：显示用户注册表单，包含用户名、邮箱、密码、确认密码等输入字段。

特点：

使用 HTML + CSS 构建简单界面。

表单提交到 register.php 处理。

通过 URL 参数显示注册成功或失败信息。

2. register.php – 注册处理逻辑
作用：接收表单提交的数据，进行验证，并将用户信息存入数据库。

核心功能：

检查用户名、邮箱是否已存在。

验证密码长度（≥6位）及两次输入是否一致。

使用 password_hash() 对密码进行哈希加密。

通过 PDO 预处理语句插入新用户。

成功后跳转回 index.php 并携带成功标志，失败则返回错误信息。

安全措施：

使用 PDO 防止 SQL 注入。

密码哈希存储，不保留明文。

输入过滤与验证。

3. config.php – 数据库配置文件
作用：统一管理数据库连接参数和 PDO 初始化。

🖥️ 运行环境与软件
1. 操作系统
Windows 7 / 10 / 11（32位或64位均可）

2. Web 服务器
   
PHP 内置开发服务器（命令行运行 php -S localhost:8000）

3. PHP 版本
PHP 7.0 或更高版本（推荐 PHP 8.4 以获得最佳兼容性）

必须启用的扩展：

pdo_mysql – MySQL 数据库驱动

mysqli（可选，但 PDO 已足够）

4. 数据库
MySQL 5.7 或 MySQL 8.0

数据库名：job_db

表结构：

sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

5. 开发工具
Visual Studio Code

🔧 部署与运行步骤
先下载PHP服务器，随后在文件目录cmd窗口启动PHP服务器。

启动MySQL服务器

在 MySQL 中创建 job_db 数据库及 users 表。

修改 config.php 中的数据库连接参数（主机、用户名、密码、数据库名）。

浏览器访问 http://localhost/register_site/index.php 即可测试注册功能。

📚 总结
这三文件构成了一个基础但完整的用户注册系统，涵盖了前端表单、后端验证、数据库操作等核心环节。通过引入 PDO 预处理和密码哈希，代码具备基础的安全防护能力，适合学习 Web 开发入门或作为小型项目的用户模块。
