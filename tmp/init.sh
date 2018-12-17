#!/bin/sh

doTarsIP=$1
doTarsType=$2
doTarsServerName=$3
doTarsServantName=$4
doTarsObjName=$5
echo "1:"`pwd`

# 首字母转大写
doTarsServerName=`echo "$doTarsServerName" | awk '{for (i=1;i<=NF;i++)printf toupper(substr($i,0,1))substr($i,2,length($i))" ";printf "\n"}' `
doTarsServerName=`echo "$doTarsServerName" | sed 's/ //g'`
echo "2:"`pwd`
doTarsServantName=`echo "$doTarsServantName" | awk '{for (i=1;i<=NF;i++)printf toupper(substr($i,0,1))substr($i,2,length($i))" ";printf "\n"}' `
doTarsServantName=`echo "$doTarsServantName" | sed 's/ //g'`
echo "3:"`pwd`
doTarsObjName=`echo "$doTarsObjName" | awk '{for (i=1;i<=NF;i++)printf toupper(substr($i,0,1))substr($i,2,length($i))" ";printf "\n"}' `
doTarsObjName=`echo "$doTarsObjName" | sed 's/ //g'`
echo "4:"`pwd`


echo 'doTarsIP: '${doTarsIP}
echo 'doTarsType: '${doTarsType}
echo 'doTarsServerName: '${doTarsServerName}
echo 'doTarsServantName: '${doTarsServantName}
echo 'doTarsObjName: '${doTarsObjName}

mkdir src
echo "5:"`pwd`
mv vendor src
echo "6:"`pwd`

if [ ${doTarsType} == "server" ];then
    echo "7:"`pwd`
    cd tmp/src/server
    mv ./* ../../../src/
    cd ../../
    rm -rf tars/client.tars.proto.php
    mv tars/server.tars.proto.php tars/tars.proto.php
    mv tars ../
fi

if [ ${doTarsType} == "client" ];then
    echo "8:"`pwd`
    cd tmp/src/client
    mv ./* ../../../src/
    cd ../../
    rm -rf tars/server.tars.proto.php
    mv tars/client.tars.proto.php tars/tars.proto.php
    mv tars ../
fi

cd ../

echo "9:"`pwd`

sed -i "s/\${doTarsIP}/${doTarsIP}/g" `grep '\${doTarsIP}' -rl ./tars/*`
sed -i "s/\${doTarsServerName}/${doTarsServerName}/g" `grep '\${doTarsServerName}' -rl ./tars/*`
sed -i "s/\${doTarsServantName}/${doTarsServantName}/g" `grep '\${doTarsServantName}' -rl ./tars/*`
sed -i "s/\${doTarsObjName}/${doTarsObjName}/g" `grep '\${doTarsObjName}' -rl ./tars/*`

echo "10:"`pwd`

sed -i "s/\${doTarsIP}/${doTarsIP}/g" `grep '\${doTarsIP}' -rl ./src/*`
sed -i "s/\${doTarsServerName}/${doTarsServerName}/g" `grep '\${doTarsServerName}' -rl ./src/*`
sed -i "s/\${doTarsServantName}/${doTarsServantName}/g" `grep '\${doTarsServantName}' -rl ./src/*`
sed -i "s/\${doTarsObjName}/${doTarsObjName}/g" `grep '\${doTarsObjName}' -rl ./src/*`
echo "11:"`pwd`

# -------------client over ----------------

if [ ${doTarsType} == "server" ];then
    echo "12:"`pwd`
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
    echo "13:"`pwd`

    baseImplaceClassFileName=`echo $baseImplaceClassFileName | sed 's/.php//g'`
    doTarsFunctionBody = `sed -n '/{/,/}/p' SearchServant.php | grep -Ev '(^interface|}$)' | cut -f 1,2 |  sed  "s/\;/\r\n        {\r\n        \}/g"`

    #doTarsServantImplName=`echo $baseImplaceClassFileName | sed 's/$/Impl/g'`

    cd ../../../../..

    sed -i "s/\${doTarsServantImplName}/${baseImplaceClassFileName}/g" `grep '\${doTarsServantImplName}' -rl ./src/*`
    
    sed -i "s/\${doTarsFunctionBody}/${doTarsFunctionBody}/g" `grep '\${doTarsFunctionBody}' -rl ./src/*`












fi
