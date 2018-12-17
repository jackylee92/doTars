#!/bin/sh

doTarsIP=$0
doTarsType=$1
doTarsServerName=$2
doTarsServantName=$3
doTarsObjName=$4

# 首字母转大写
doTarsServerName=`echo "$doTarsServerName" | awk '{for (i=1;i<=NF;i++)printf toupper(substr($i,0,1))substr($i,2,length($i))" ";printf "\n"}' `
doTarsServerName=`echo "$doTarsServerName" | sed 's/ //g'`
doTarsServantName=`echo "$doTarsServantName" | awk '{for (i=1;i<=NF;i++)printf toupper(substr($i,0,1))substr($i,2,length($i))" ";printf "\n"}' `
doTarsServantName=`echo "$doTarsServantName" | sed 's/ //g'`
doTarsObjName=`echo "$doTarsObjName" | awk '{for (i=1;i<=NF;i++)printf toupper(substr($i,0,1))substr($i,2,length($i))" ";printf "\n"}' `
doTarsObjName=`echo "$doTarsObjName" | sed 's/ //g'`


echo 'doTarsIP: '${doTarsIP}
echo 'doTarsType: '${doTarsType}
echo 'doTarsServerName: '${doTarsServerName}
echo 'doTarsServantName: '${doTarsServantName}
echo 'doTarsObjName: '${doTarsObjName}

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

    cd ../src/servant/${doTarsServerName}/${doTarsServantName}/${doTarsObjName}
    baseImplaceClassFileName=`ls *php`
    if [ ! -n "${baseImplaceClassFileName}" ];then
        echo "[ ERROR ] : tars文件错误，未生成接口文件，请删除项目重试！"
        exit 0
    fi

    baseImplaceClassFileName=`echo $baseImplaceClassFileName | sed 's/.php//g'`

    doTarsServantImplName=`echo $baseImplaceClassFileName | sed 's/$/Impl/g'`

    cd ../../../../..

    sed -i "s/\${doTarsServantImplName}/${doTarsServantImplName}/g" `grep '\${doTarsServantImplName}' -rl ./src/*`












fi
