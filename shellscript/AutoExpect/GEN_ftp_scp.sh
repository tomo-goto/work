#!/bin/bash
IP_BEF=${1//\"/}
USR_BEF=${2//\"/}
PWD_BEF=${3//\"/}
IP_AFT=${4//\"/}
USR_AFT=${5//\"/}
PWD_AFT=${6//\"/}
WK_DIR=${7//\"/}
FILE=${8//\"/}
LOGIN=${9//\"/}
Prompt='${Prompt}'
flg='$flg'

					# FORMAT for put/send
FORMAT_1=`cat <<END
send "cd ~/${WK_DIR}\n"
expect ${Prompt}
send "ls\n"
expect ${Prompt}

send "ftp ${IP_AFT}\n"
expect {
  *): {
    send "${USR_AFT}\n"
    expect *assword:
    send "${PWD_AFT}\n"
    expect ftp>
    send "cd ${WK_DIR}\n"
    expect ftp>
    send "put ${FILE}\n"
    expect ftp>
    send "bye\n"
    expect ${Prompt}
    puts [ exec echo trans=put >> trans_result ]
  }
  timeout {
    send "quit\n"
    expect ${Prompt}

    send "scp ${FILE} ${USR_AFT}@${IP_AFT}:~/${WK_DIR}\n"
    expect {
      *assword: {
        send "${PWD_AFT}\n"
        expect ${Prompt}
        puts [ exec echo trans=send >> trans_result ]
      }
      timeout {
        send "\x03"
        expect ${Prompt}
END`

echo "$FORMAT_1"
					# login to exec get/recv
if [ "$LOGIN" = telnet ];then
FORMAT_2=`cat <<END
send "telnet ${IP_AFT}\n"
expect {
  *ogin: {
    send "${USR_AFT}\n"
    expect *assword:
    send "${PWD_AFT}\n"
    expect ${Prompt}
    send "cd ${WK_DIR}\n"
    expect ${Prompt}
    send "ls\n"
    expect ${Prompt}
    set flg 1
  }
}
END`

  echo "$FORMAT_2"
elif [ "$LOGIN" = ssh ];then
FORMAT_2=`cat <<END
send "ssh -o StrictHostKeyChecking=no ${USR_AFT}@${IP_AFT}\n" {
expect {
  *assword: {
    send "${PWD_AFT}\n"
    expect ${Prompt}
    send "cd ${WK_DIR}\n"
    expect ${Prompt}
    send "ls\n"
    expect ${Prompt}
    set flg 1
  }
}
END`

  echo "$FORMAT_2"
else
  echo "transfer test script error"
fi
					# FORMAT for get/recv
FORMAT_3=`cat <<END
        send "cd ~/${WK_DIR}\n"
        expect ${Prompt}
        send "ls\n"
        expect ${Prompt}

        send "ftp ${IP_BEF}\n"
        expect {
          *): {
            send "${USR_BEF}\n"
            expect *assword:
            send "${PWD_BEF}\n"
            expect ftp>
            send "cd ${WK_DIR}\n"
            expect ftp>
            send "get ${FILE}\n"
            expect ftp>
            send "bye\n"
            expect ${Prompt}
            puts [ exec echo trans=get >> trans_result ]
          }
          timeout {
            send "quit\n"
            expect ${Prompt}

            send "scp ${USR_BEF}@${IP_BEF}:~/${WK_DIR}/${FILE} .\n"
            expect {
              *assword: {
                send "${PWD_BEF}\n"
                expect ${Prompt}
                puts [ exec echo trans=recv >> trans_result ]
              }
              timeout {
                puts [ exec echo trans=error >> trans_result ]
                exit 1
              }
            };#recv-block end
          }
        };#get-block end
      }
    };#send-block end
  }
};#put-block end
END`

echo "$FORMAT_3"

if [ "$LOGIN" = telnet ];then
FORMAT_4=`cat <<END
if {$flg == 1} {
  # do nothing
} elseif {$flg == 0} {
  send "telnet ${IP_AFT}\n"
  expect {
    *ogin: {
      send "${USR_AFT}\n"
      expect *assword:
      send "${PWD_AFT}\n"
      expect ${Prompt}
      send "cd ${WK_DIR}\n"
      expect ${Prompt}
      send "ls\n"
      expect ${Prompt}
    }
  }
  set flg 0
}
END`

  echo "$FORMAT_4"
elif [ "$LOGIN" = ssh ];then
FORMAT_4=`cat <<END
if {$flg == 1} {
  # do nothing
} elseif {$flg == 0} {
  send "ssh -o StrictHostKeyChecking=no ${USR_AFT}@${IP_AFT}\n" {
  expect {
    *assword: {
      send "${PWD_AFT}\n"
      expect ${Prompt}
      send "cd ${WK_DIR}\n"
      expect ${Prompt}
      send "ls\n"
      expect ${Prompt}
    }
  }
  set flg 0
}
END`

  echo "$FORMAT_4"
fi
