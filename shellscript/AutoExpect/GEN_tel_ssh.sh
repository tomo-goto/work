#!/bin/bash
IP_AFT=${1//\"/}
USR_AFT=${2//\"/}
PWD_AFT=${3//\"/}
WK_DIR=${4//\"/}
Prompt='${Prompt}'

FORMAT=`cat <<END
set timeout 10
set Prompt "\[#$%>\]"

send "telnet ${IP_AFT}\n"
expect {
  *ogin: {
    send "${USR_AFT}\n"
    expect *assword:
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
    puts [ exec echo proto=telnet >> login_result ]
  }
  timeout {
    send "\x03"
    expect ${Prompt}

    send "ssh -o StrictHostKeyChecking=no ${USR_AFT}@${IP_AFT}\n"
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
        puts [ exec echo proto=ssh >> login_result ]
      }
      timeout {
        send "\x03"
        puts [ exec echo proto=error >> login_result ]
        exit 1
      }
    };#ssh-block end
  }
}
END`

echo "$FORMAT"
