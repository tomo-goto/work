#!/bin/bash

###########################################################
#-----------------------PREPARATION-----------------------#
###########################################################
FILE="tool.tgz"

###########################################################
#-----------------------SUBROUTINE -----------------------#
###########################################################
function LOGINTEST {
ECONFIG=$1
GEN_TEL_SSH=$2
GEN_SU=$3

HOPS=`grep HOPS ${ECONFIG}|awk -F "=" '{print $2}'`
WK_DIR=`grep WK_DIR ${ECONFIG}|awk -F "=" '{print $2}'`

HEADER=`cat <<END
set timeout 10
set Prompt "\[#$%>\]"
spawn bash
END`

echo "$HEADER"

for i in `seq 1 ${HOPS}`
do
IP_AFT=`grep IP_AFT${i} ${ECONFIG}|awk -F "=" '{print $2}'`
USR_AFT=`grep USR_AFT${i} ${ECONFIG}|awk -F "=" '{print $2}'`
PWD_AFT=`grep PWD_AFT${i} ${ECONFIG}|awk -F "=" '{print $2}'`
SU=`grep SU${i} ${ECONFIG}|awk -F "=" '{print $2}'`

if [ "${SU//\"/}" = "0" ];then
  bash ${GEN_TEL_SSH} ${IP_AFT} ${USR_AFT} ${PWD_AFT} ${WK_DIR}
elif [ "${SU//\"/}" = "1" ];then
  bash ${GEN_SU} ${USR_AFT} ${PWD_AFT} ${WK_DIR}
else
  echo "LOGINTEST error"
fi

done
}

function TRANSFERTEST {
ECONFIG=$1
GEN_FTP_SCP=$2
GEN_MV=$3

HOPS=`grep HOPS ${ECONFIG}|awk -F "=" '{print $2}'`
WK_DIR=`grep WK_DIR ${ECONFIG}|awk -F "=" '{print $2}'`

HEADER=`cat <<END
set timeout 10
set Prompt "\[#$%>\]"
set flg 0
spawn bash
END`

echo "$HEADER"

for i in `seq 1 ${HOPS}`
do
IP_BEF=`grep IP_BEF${i} ${ECONFIG}|awk -F "=" '{print $2}'`
USR_BEF=`grep USR_BEF${i} ${ECONFIG}|awk -F "=" '{print $2}'`
PWD_BEF=`grep PWD_BEF${i} ${ECONFIG}|awk -F "=" '{print $2}'`
IP_AFT=`grep IP_AFT${i} ${ECONFIG}|awk -F "=" '{print $2}'`
USR_AFT=`grep USR_AFT${i} ${ECONFIG}|awk -F "=" '{print $2}'`
PWD_AFT=`grep PWD_AFT${i} ${ECONFIG}|awk -F "=" '{print $2}'`
SU=`grep SU${i} ${ECONFIG}|awk -F "=" '{print $2}'`

					# generate ftp/scp
if [ "${SU//\"/}" = "0" ];then
  LOG_TEL=`grep LOG_TEL${i} ${ECONFIG}|awk -F "=" '{print $2}'`
  LOG_SSH=`grep LOG_SSH${i} ${ECONFIG}|awk -F "=" '{print $2}'`
  if [ "${LOG_TEL//\"/}" = "1" ];then
    bash ${GEN_FTP_SCP} ${IP_BEF} ${USR_BEF} ${PWD_BEF} ${IP_AFT} ${USR_AFT} ${PWD_AFT} ${WK_DIR} ${FILE} telnet
  elif [ "${LOG_SSH//\"/}" = "1" ];then
    bash ${GEN_FTP_SCP} ${IP_BEF} ${USR_BEF} ${PWD_BEF} ${IP_AFT} ${USR_AFT} ${PWD_AFT} ${WK_DIR} ${FILE} ssh
  else
    echo "TRANSFERTEST error"
  fi
					# generate mv
elif [ "${SU//\"/}" = "1" ];then
  bash ${GEN_MV} ${USR_AFT} ${PWD_AFT} ${WK_DIR} ${FILE}
else
  echo "TRANSFERTEST error"
fi

done
}


function AUTOINS {
ECONFIG=$1
GEN_AUTO=$2
INS_SH=$3
VER=$4

HOPS=`grep HOPS ${ECONFIG}|awk -F "=" '{print $2}'`
WK_DIR=`grep WK_DIR ${ECONFIG}|awk -F "=" '{print $2}'`

HEADER=`cat <<END
set timeout 10
set Prompt "\[#$%>\]"
spawn bash
END`

echo "$HEADER"

for i in `seq 1 ${HOPS}`
do
IP_AFT=`grep IP_AFT${i} ${ECONFIG}|awk -F "=" '{print $2}'`
USR_AFT=`grep USR_AFT${i} ${ECONFIG}|awk -F "=" '{print $2}'`
PWD_AFT=`grep PWD_AFT${i} ${ECONFIG}|awk -F "=" '{print $2}'`
SU=`grep SU${i} ${ECONFIG}|awk -F "=" '{print $2}'`

                                        # telnet/ssh
if [ "${SU//\"/}" = "0" ];then
  LOG_TEL=`grep LOG_TEL${i} ${ECONFIG}|awk -F "=" '{print $2}'`
  LOG_SSH=`grep LOG_SSH${i} ${ECONFIG}|awk -F "=" '{print $2}'`
  if [ "${LOG_TEL//\"/}" = "1" ];then
    bash ${GEN_AUTO} ${IP_AFT} ${USR_AFT} ${PWD_AFT} ${WK_DIR} ${FILE} telnet
  elif [ "${LOG_SSH//\"/}" = "1" ];then
    bash ${GEN_AUTO} ${IP_AFT} ${USR_AFT} ${PWD_AFT} ${WK_DIR} ${FILE} ssh
  else
    echo "AUTOINS error"
  fi
                                        # su
elif [ "${SU//\"/}" = "1" ];then
  bash ${GEN_AUTO} ${IP_AFT} ${USR_AFT} ${PWD_AFT} ${WK_DIR} ${FILE} su
else
  echo "AUTOINS error"
fi

done

Prompt='${Prompt}'

FOOTER=`cat <<END
send "cd ~/${WK_DIR}\n"
expect ${Prompt}
send "tar xzfp ${FILE}\n"
expect ${Prompt}
send "bash ${INS_SH} ${VER} ${WK_DIR}\n"
expect ${Prompt}
END`

echo "$FOOTER"
}

###########################################################
#--------------------------MAIN --------------------------#
###########################################################
# $1 = econfig name

while getopts ltaC OPT
do
    case $OPT in
        l ) echo "BEGIN LOGINTEST"
            LOGINTEST  $2 $3 $4 >> logintestscript;;
        t ) echo "BEGIN TRANSFERTEST"
            TRANSFERTEST $2 $3 $4 >> transfertestscript;;
        a ) echo "BEGIN AUTOINS"
            AUTOINS $2 $3 $4 $5 >> autoinsscript;;
        C ) echo "CLEAN UP"
            rm -f logintestscript transfertestscript autoinsscript;;
    esac
done
