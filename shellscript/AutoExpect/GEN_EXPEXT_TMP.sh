#!/bin/bash

###########################################################
#-----------------------PREPARATION-----------------------#
###########################################################
#P_CONFIG=$1		#path config(user made)
#E_CONFIG=$2		#expect config(shell made)

###########################################################
#-----------------------SUBROUTINE -----------------------#
###########################################################
### read config and commit param to text
# USAGE [ $1=KEY(parameter name), $2=PRM(parmeter), $3=text name to mod ]
function MOD_PRM {
KEY=$1
PRM=$2
TXT=$3
MODTMP=.mod_tmp

			# find KEY from text
MATCH=`grep -n "^${KEY}" ${TXT}`
			# get line number of matched KEY
NUM=`echo ${MATCH}| awk -F ":" '{print $1}'`
			# stdout "modded line" to "tmp"
sed "${NUM} s/.*/${KEY}=\"${PRM}\"/" ${TXT} > ${MODTMP}
			# stdout "tmp" to "text" 
cat ${MODTMP} > ${TXT}; rm -f ${MODTMP}
}

### generate config format for EXPECT command
# USAGE [ $1=P_CONFIG(path config), $2=E_CONFIG(expect config), $3=WK_DIR(workind dir for all node) ]
function INIT {
P_CONFIG=$1
E_CONFIG=$2
WK_DIR=$3
TMP=.init_tmp

			# find line start with "ip" "usr" "pwd" from path config
			# and, 
			# stdout to "tmp"
grep -e "^ip=" -e "^usr=" -e "^pwd=" ${P_CONFIG} > ${TMP}
			# get line sum of "tmp"
ALL=`cat ${TMP}|wc -l`
			# count hops("ip", "usr", "pwd" is a set)
HOPS=$(($ALL/3-1))

			# check P_CONFIG(should be multiplied num by 3)
if [ $(($ALL%3)) != 0 ];then
  echo "${P_CONFIG} error"
  exit 1
fi

echo "HOPS=${HOPS}" >> ${E_CONFIG}
echo "WK_DIR=${WK_DIR}" >> ${E_CONFIG}
			# generate config for EXPECT command in certain format
			# loop "HOPS" times
for i in `seq 1 ${HOPS}`
do

FORMAT=`cat <<END
###############
LOG_TEL${i}=0
LOG_SSH${i}=0
IP_BEF${i}=0
USR_BEF${i}=0
PWD_BEF${i}=0
IP_AFT${i}=0
USR_AFT${i}=0
PWD_AFT${i}=0
TFR_PUT${i}=0
TFR_GET${i}=0
TFR_SND${i}=0
TFR_RCV${i}=0
SU${i}=0
END`

  echo -e "${FORMAT}" >> ${E_CONFIG}
done
}

### mod "IP_XXX", "USR_XXX", "PWD_XXX" (and "SUX")
# USAGE [ $1=P_CONFIG(path config), $2=E_CONFIG(expect config) ]
function IP_USR {
P_CONFIG=$1
E_CONFIG=$2
TMP=.ipusr_tmp
HOPS=1 

			# find line start with "ip" "usr" "pwd" from path config
			# and, 
			# stdout to "tmp"
grep -e "^ip=" -e "^usr=" -e "^pwd=" ${P_CONFIG} > ${TMP}
			# get line sum of "tmp"
ALL=`cat ${TMP}|wc -l`
			# 1."IP_BEF" 2."USR_BEF" 3."PWD_BEF" (STR is 1)
			# 4."IP_AFT" 5."USR_AFT" 6."PWD_AFT" (END is 6)
STR=1
END=$(($STR+5))

			# mod parameter (mod 1~6 in one loop)
			# 		(shift 3 at last, until "line sum")
			# ex. 	in case of path like "A -> B -> C" (2 hops)
			#  	A(1,2,3) -> B(4,5,6) -> C
			#  	A	 -> B(1,2,3) -> C(4,5,6)
while [ ${END} -le ${ALL} ]
do
			# mod No.1
  PRM=`sed -n ${STR}p ${TMP}|awk -F "=" '{print $2}'`
  MOD_PRM "IP_BEF${HOPS}" "${PRM}" "${E_CONFIG}"
			# mod No.2
  PRM=`sed -n $(($STR+1))p ${TMP}|awk -F "=" '{print $2}'`
  MOD_PRM "USR_BEF${HOPS}" "${PRM}" "${E_CONFIG}"
			# mod No.3
  PRM=`sed -n $(($STR+2))p ${TMP}|awk -F "=" '{print $2}'`
  MOD_PRM "PWD_BEF${HOPS}" "${PRM}" "${E_CONFIG}"
			# mod No.4
  PRM=`sed -n $(($END-2))p ${TMP}|awk -F "=" '{print $2}'`
  MOD_PRM "IP_AFT${HOPS}" "${PRM}" "${E_CONFIG}"
			# mod No.5
  PRM=`sed -n $(($END-1))p ${TMP}|awk -F "=" '{print $2}'`
  MOD_PRM "USR_AFT${HOPS}" "${PRM}" "${E_CONFIG}"
			# mod No.6
  PRM=`sed -n ${END}p ${TMP}|awk -F "=" '{print $2}'`
  MOD_PRM "PWD_AFT${HOPS}" "${PRM}" "${E_CONFIG}"

			# if same server, then do "su -"/"mv" command
  BEF=`sed -n ${STR}p ${TMP}|awk -F "=" '{print $2}'`
  AFT=`sed -n $(($END-2))p ${TMP}|awk -F "=" '{print $2}'`
  if [ "${BEF}" = "${AFT}" ];then
    MOD_PRM "SU${HOPS}" "1" "${E_CONFIG}"
  fi

  STR=$(($STR+3))
  END=$(($END+3))
  HOPS=$(($HOPS+1))
done

}

### mod "LOG_XXX"
# USAGE [ $1=P_CONFIG(path config), $2=E_CONFIG(expect config) ]
function CONNECT {
P_CONFIG=$1
E_CONFIG=$2
TMP=.conn_tmp

			# find line start with "proto" from path config
grep "^proto=" ${P_CONFIG} > ${TMP}
			# get hop number from EXPECT config
HOPS=`sed -n 1p ${E_CONFIG}|awk -F "=" '{print $2}'`

			# mod parameter
for i in `seq 1 ${HOPS}`
do
			# read parameter from "tmp"
  PRM=`sed -n ${i}p ${TMP}|awk -F "=" '{print $2}'`

			# if telnet access succeed,		LOG_TEL flag up
			# if ssh access succeed,		LOG_SSH flag up
			# if su command succeed,		do nothing
			# if any access failed,			ERROR
  if [ ${PRM} = "telnet" ];then
    MOD_PRM "LOG_TEL${i}" "1" "${E_CONFIG}"    
  elif [ ${PRM} = "ssh" ];then
    MOD_PRM "LOG_SSH${i}" "1" "${E_CONFIG}"
  elif [ ${PRM} = "su" ];then
    :
  else
    MOD_PRM "LOG_TEL${i}" "error" "${E_CONFIG}"
    MOD_PRM "LOG_SSH${i}" "error" "${E_CONFIG}"
    echo "connection error at ${i}:${PRM}"
    exit 1
  fi
done
}

### mod "TFR_XXX"
# USAGE [ $1=P_CONFIG(path config), $2=E_CONFIG(expect config) ]
function TRANSFER {
P_CONFIG=$1
E_CONFIG=$2
TMP=.trans_tmp

			# find line start with "trans" from path config
grep "^trans=" ${P_CONFIG} > ${TMP}
			# get hop number from EXPECT config
HOPS=`sed -n 1p ${E_CONFIG}|awk -F "=" '{print $2}'`

			# mod parameter
for i in `seq 1 ${HOPS}`
do
			# read parameter from "tmp"
  PRM=`sed -n ${i}p ${TMP}|awk -F "=" '{print $2}'`

                        # if ftp(put) access succeed,		TFR_PUT flag up
                        # if ftp(get) access succeed,		TFR_GET flag up
                        # if scp(send) access succeed,		TFR_SND flag up
                        # if scp(recv) access succeed,		TFR_RCV flag up
                        # if mv command succeed,		do nothing
                        # if blank(once),			do nothing
			# if any access failed,			ERROR
  if [ "${PRM}" = "put" ];then
    MOD_PRM "TFR_PUT${i}" "1" "${E_CONFIG}"
  elif [ "${PRM}" = "get" ];then
    MOD_PRM "TFR_GET${i}" "1" "${E_CONFIG}"
  elif [ "${PRM}" = "send" ];then
    MOD_PRM "TFR_SND${i}" "1" "${E_CONFIG}"
  elif [ "${PRM}" = "recv" ];then
    MOD_PRM "TFR_RCV${i}" "1" "${E_CONFIG}"
  elif [ "${PRM}" = "mv" ];then
    :
  elif [ "${PRM}" = "" ];then
    NEXT=`sed -n $(($i+1))p ${TMP}|awk -F "=" '{print $2}'`
    if [ "${NEXT}" = "get" -o "${NEXT}" = "recv" ];then
      :
    else
      MOD_PRM "TFR_PUT${i}" "blank" "${E_CONFIG}"
      MOD_PRM "TFR_GET${i}" "blank" "${E_CONFIG}"
      MOD_PRM "TFR_SND${i}" "blank" "${E_CONFIG}"
      MOD_PRM "TFR_RCV${i}" "blank" "${E_CONFIG}"
      echo "transfer error(blank) at ${i}:${PRM}"
    fi
  else
    MOD_PRM "TFR_PUT${i}" "error" "${E_CONFIG}"
    MOD_PRM "TFR_GET${i}" "error" "${E_CONFIG}"
    MOD_PRM "TFR_SND${i}" "error" "${E_CONFIG}"
    MOD_PRM "TFR_RCV${i}" "error" "${E_CONFIG}"
    echo "transfer error at ${i}:${PRM}"
    exit 1
  fi
done
}

###########################################################
#--------------------------MAIN --------------------------#
###########################################################

while getopts iuctC OPT
do
    case $OPT in
        i ) echo "BEGIN INIT"
            INIT $2 $3 $4;;
        u ) echo "BEGIN IP_USR_UPDATE"
            IP_USR $2 $3;;
        c ) echo "BEGIN CONNECT_UPDATE"
            CONNECT $2 $3;;
        t ) echo "BEGIN TRANSFER_UPDATE"
            TRANSFER $2 $3;;
        C ) echo "CLEAN UP"
            rm -f login_result trans_result;;
    esac
done
