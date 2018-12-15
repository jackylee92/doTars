#!/bin/sh

cd dotars/tmp

doTarsIP="192.168.163.128"
doTarsType="server"
doTarsServerName="Topic"
doTarsServantName="Server"
doTarsObjName="Obj"

cd ../
mkdir src
mv vendor src

if [ ${doTarsType} == "server" ];then
    cd tmp/src/server
    mv ./* ../../../src/
    cd ../../
    rm -rf tars/client.tars.proto.php
    mv tars/server.tars.proto.php tars/tars.proto.php
    mv tars ../
fi

if [ ${doTarsType} == "client" ];then
    cd tmp/src/client
    mv ./* ../../../src/
    cd ../../
    rm -rf tars/server.tars.proto.php
    mv tars/client.tars.proto.php tars/tars.proto.php
    mv tars ../
fi

cd ../

sed -i "s/\${doTarsIP}/${doTarsIP}/g" `grep '\${doTarsIP}' -rl ./tars/*`
sed -i "s/\${doTarsServerName}/${doTarsServerName}/g" `grep '\${doTarsServerName}' -rl ./tars/*`
sed -i "s/\${doTarsServantName}/${doTarsServantName}/g" `grep '\${doTarsServantName}' -rl ./tars/*`
sed -i "s/\${doTarsObjName}/${doTarsObjName}/g" `grep '\${doTarsObjName}' -rl ./tars/*`

sed -i "s/\${doTarsIP}/${doTarsIP}/g" `grep '\${doTarsIP}' -rl ./src/*`
sed -i "s/\${doTarsServerName}/${doTarsServerName}/g" `grep '\${doTarsServerName}' -rl ./src/*`
sed -i "s/\${doTarsServantName}/${doTarsServantName}/g" `grep '\${doTarsServantName}' -rl ./src/*`
sed -i "s/\${doTarsObjName}/${doTarsObjName}/g" `grep '\${doTarsObjName}' -rl ./src/*`

# -------------client over ----------------

if [ ${doTarsType} == "server" ];then
    tarsFileName=${doTarsServerName}${doTarsServantName}.tars
    echo "正在copy[${tarsFileName}]文件。。。"
    mv ../${tarsFileName} tars/
    cd tars
    php ../src/vendor/phptars/tars2php/src/tars2php.php ./tars.proto.php













fi
