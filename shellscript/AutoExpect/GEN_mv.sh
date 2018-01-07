#!/bin/bash
USR_AFT=${1//\"/}
PWD_AFT=${2//\"/}
WK_DIR=${3//\"/}
FILE=${4//\"/}
Prompt='${Prompt}'
dir='$dir'

FORMAT=`cat <<END
set dir [exec pwd]
send "su - ${USR_AFT}\n"
expect {
  *assword: {
    send "${PWD_AFT}\n"
    expect ${Prompt}
    send "cd ${WK_DIR}\n"
    expect ${Prompt}
    send "cd $dir\n"
    expect ${Prompt}
    send "cp -pR ${FILE} ~/${WK_DIR};cd ~/${WK_DIR}\n"
    puts [ exec echo trans=mv >> login_result ]
  }
  timeout {
    send "\n"
    expect ${Prompt}
    puts [ exec echo trans=error >> login_result ]
    exit 1
  }
}
END`

echo "$FORMAT"
