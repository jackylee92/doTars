#!/bin/bash
set -e
function checkServantName() {
    local ServantName=$1
    if [ ! -n "$ServantName" ];then
        echo 'ServantName错误！'
        return 1
    fi
    if [ ! -d "../tars/${ServantName}" ];then
        echo "${ServantName}文件夹不存在！"
        exit 0
    fi
    if [ ! -f "../tars/${ServantName}/${ServantName}.tars" ];then
        echo "tars/${ServantName}/${ServantName}.tars文件不存在！"
        exit 0
    fi
    if [ ! -f "../tars/${ServantName}/tars.proto.php" ];then
        echo "tars/${ServantName}/tars.proto.php文件不存在！"
        exit 0
    fi
}
while true; do
    read -p "请输入tars中服务文件夹名称[文件夹名称须与.tars文件名称相同,文件下须有tars.proto.php文件，注意.tars中配置]: " ServantName
    checkServantName $ServantName
    [ $? -eq 0 ] && break
done
cd ../tars/
php ../src/vendor/phptars/tars2php/src/tars2php.php ./${ServantName}/tars.proto.php
