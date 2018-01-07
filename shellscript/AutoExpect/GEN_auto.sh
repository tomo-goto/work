#!/bin/bash
IP_AFT=${1//\"/}
USR_AFT=${2//\"/}
PWD_AFT=${3//\"/}
WK_DIR=${4//\"/}
FILE=${5//\"/}
LOGIN=${6//\"/}
Prompt='${Prompt}'


if [ "$LOGIN" = telnet ];then
FORMAT_1=`cat <<END
send "telnet ${IP_AFT}\n"
expect {
  *ogin: {
    send "${USR_AFT}\n"
    expect *assword:
    send "${PWD_AFT}\n"
    expect ${Prompt}
  }
}
END`

  echo "$FORMAT_1"
elif [ "$LOGIN" = ssh ];then
FORMAT_1=`cat <<END
send "ssh -o StrictHostKeyChecking=no ${USR_AFT}@${IP_AFT}\n" {
expect {
  *assword: {
    send "${PWD_AFT}\n"
    expect ${Prompt}
  }
}
END`

  echo "$FORMAT_1"
elif [ "$LOGIN" = su ];then
FORMAT_1=`cat <<END
send "su - ${USR_AFT}\n"
expect {
  *assword: {
    send "${PWD_AFT}\n"
    expect ${Prompt}
  }
}
END`

  echo "$FORMAT_1"
else
  echo "auto install script error"
fi
