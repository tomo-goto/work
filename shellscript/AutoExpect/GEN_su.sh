#!/bin/bash
USR_AFT=${1//\"/}
PWD_AFT=${2//\"/}
WK_DIR=${3//\"/}
Prompt='${Prompt}'

FORMAT=`cat <<END
send "su - ${USR_AFT}\n"
expect {
  *assword: {
    send "${PWD_AFT}\n"
    expect ${Prompt}
    send "mkdir ${WK_DIR}\n"
    expect {
      exists {
        puts [ exec echo proto=error >> login_result ]
        exit 1
      }
      ${Prompt} {
      }
    }
    puts [ exec echo proto=su >> login_result ]
  }
  timeout {
    send "\n"
    expect ${Prompt}
    puts [ exec echo proto=error >> login_result ]
    exit 1
  }
}
END`

echo "$FORMAT"
